<?php
/**
 * BizJump Wizard — Activation installer.
 *
 * On activate:
 *   - Auto-create /incorporation/ page with [bizjump_wizard] shortcode.
 *   - Create WC products for each plan tier (bjw-plan-basic / pro / premium).
 *   - Create WC products for each addon (bjw-addon-<id>).
 *   - Flush rewrite rules.
 *
 * Re-running activation is idempotent — existing pages/products are skipped.
 *
 * @package BizJump_Wizard
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BJW_Installer' ) ) :
class BJW_Installer {

    public static function activate(): void {
        self::ensure_page();
        self::ensure_wc_products();
        flush_rewrite_rules();
    }

    private static function ensure_page(): void {
        $existing = get_page_by_path( 'incorporation' );
        if ( $existing ) return;
        wp_insert_post( [
            'post_title'   => 'Incorporation',
            'post_name'    => 'incorporation',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '[bizjump_wizard]',
        ] );
    }

    private static function ensure_wc_products(): void {
        if ( ! class_exists( 'WooCommerce' ) || ! class_exists( 'WC_Product_Simple' ) ) return;

        // Plans
        foreach ( BJW_Plans::all() as $plan ) {
            $sku = BJW_WC_Hooks::SKU_PLAN_PREFIX . $plan['key'];
            if ( wc_get_product_id_by_sku( $sku ) ) continue;
            $product = new WC_Product_Simple();
            $product->set_name( 'BizJump ' . $plan['label'] . ' Plan' );
            $product->set_sku( $sku );
            $product->set_regular_price( (string) $plan['price'] );
            $product->set_price( (string) $plan['price'] );
            $product->set_virtual( true );
            $product->set_catalog_visibility( 'hidden' );
            $product->set_description( $plan['description'] ?? '' );
            $product->save();
        }

        // Addons — only create products for the integer-priced (purchasable) values.
        // Chip-only addons ('included', '99/year', 'free+29mo') are display-only.
        foreach ( BJW_Addons::all() as $addon ) {
            $sku = BJW_WC_Hooks::SKU_ADDON_PREFIX . $addon['id'];
            if ( wc_get_product_id_by_sku( $sku ) ) continue;
            // Pick a representative price — use the Basic-tier value if numeric, else Pro, else Premium.
            $price = null;
            foreach ( [ 'basic', 'pro', 'premium' ] as $tier ) {
                if ( isset( $addon['price'][ $tier ] ) && is_numeric( $addon['price'][ $tier ] ) ) {
                    $price = $addon['price'][ $tier ];
                    break;
                }
            }
            if ( $price === null ) continue; // skip display-only addons
            $product = new WC_Product_Simple();
            $product->set_name( $addon['label'] );
            $product->set_sku( $sku );
            $product->set_regular_price( (string) $price );
            $product->set_price( (string) $price );
            $product->set_virtual( true );
            $product->set_catalog_visibility( 'hidden' );
            $product->set_description( $addon['desc'] ?? '' );
            $product->save();
        }
    }
}
endif;
