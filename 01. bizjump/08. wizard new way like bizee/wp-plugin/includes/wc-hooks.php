<?php
/**
 * BizJump Wizard — WooCommerce cart integration.
 *
 * The wizard pushes the user's selections into the WC cart, then redirects to
 * checkout. Each plan tier + each addon must exist as a WC product (created by
 * BJW_Installer on activation). State filing fee + expedited fee are added as
 * cart-level fees (since they're not products).
 *
 * @package BizJump_Wizard
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BJW_WC_Hooks' ) ) :
class BJW_WC_Hooks {

    /** SKU convention: bjw-plan-basic / bjw-plan-pro / bjw-plan-premium */
    const SKU_PLAN_PREFIX  = 'bjw-plan-';
    /** SKU convention for addons: bjw-addon-<addon-id>  (e.g. bjw-addon-ein) */
    const SKU_ADDON_PREFIX = 'bjw-addon-';

    public static function register(): void {
        add_action( 'woocommerce_cart_calculate_fees', [ __CLASS__, 'add_state_fees' ] );
        add_filter( 'woocommerce_get_item_data',       [ __CLASS__, 'show_addon_meta_in_cart' ], 10, 2 );
        add_action( 'woocommerce_checkout_create_order_line_item', [ __CLASS__, 'persist_addon_meta_on_order' ], 10, 4 );
    }

    /** Build cart from a validated wizard state array. */
    public static function build_cart_from_wizard( array $state ): void {
        if ( ! function_exists( 'WC' ) || ! WC()->cart ) return;
        WC()->cart->empty_cart();

        // 1) Plan
        $plan_id = $state['plan']['id'] ?? '';
        if ( $plan_id ) {
            $sku        = self::SKU_PLAN_PREFIX . $plan_id;
            $product_id = wc_get_product_id_by_sku( $sku );
            if ( $product_id ) {
                WC()->cart->add_to_cart( $product_id, 1 );
            }
        }

        // 2) Addons
        foreach ( (array) ( $state['inlineAddons'] ?? [] ) as $addon_id => $_ ) {
            $sku        = self::SKU_ADDON_PREFIX . sanitize_key( $addon_id );
            $product_id = wc_get_product_id_by_sku( $sku );
            if ( $product_id ) {
                WC()->cart->add_to_cart( $product_id, 1 );
            }
        }

        // 3) Stash wizard state on the WC session so checkout-prefill can read it,
        //    and so add_state_fees() can compute fees from authoritative tables.
        WC()->session->set( 'bjw_state', $state );
    }

    /** Add state filing fee + expedited surcharge as cart fees (not products). */
    public static function add_state_fees( $cart ): void {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
        $state = WC()->session ? WC()->session->get( 'bjw_state' ) : null;
        if ( ! is_array( $state ) ) return;

        $entity     = $state['entity']    ?? '';
        $state_name = $state['stateName'] ?? '';
        $fee        = BJW_State_Fees::get_fee( $state_name, $entity );

        if ( $fee > 0 ) {
            $cart->add_fee( sprintf( '%s State Filing Fee', $state_name ), $fee, false );
        }

        if ( ! empty( $state['filingTime']['type'] ) && $state['filingTime']['type'] === 'rush' ) {
            $exp = BJW_State_Fees::get_expedited( $state_name );
            if ( $exp > 0 ) $cart->add_fee( 'Expedited Filing', $exp, false );
        }
    }

    /** Show the addon's source addon-id under each line in the cart for clarity. */
    public static function show_addon_meta_in_cart( $item_data, $cart_item ) {
        $product = $cart_item['data'] ?? null;
        if ( $product && str_starts_with( (string) $product->get_sku(), self::SKU_ADDON_PREFIX ) ) {
            $item_data[] = [
                'key'     => __( 'Type', 'bizjump-wizard' ),
                'value'   => __( 'Wizard Add-on', 'bizjump-wizard' ),
                'display' => '',
            ];
        }
        return $item_data;
    }

    /** Save wizard state as order meta when the order is created. */
    public static function persist_addon_meta_on_order( $item, $cart_item_key, $values, $order ): void {
        // Add the full wizard snapshot once per order (on the first line item).
        static $written_for_order = [];
        $order_id = $order ? $order->get_id() : 0;
        if ( $order_id && empty( $written_for_order[ $order_id ] ) ) {
            $state = WC()->session ? WC()->session->get( 'bjw_state' ) : null;
            if ( is_array( $state ) ) {
                $order->update_meta_data( '_bjw_wizard_state', wp_json_encode( $state ) );
                $order->save();
            }
            $written_for_order[ $order_id ] = true;
        }
    }
}
endif;
