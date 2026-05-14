<?php
/**
 * BizJump Wizard — Prefill WooCommerce checkout billing fields from wizard state.
 *
 * On the WC checkout page, the billing fields are populated automatically from
 * what the user typed into Step 4 (Contact) of the wizard.
 *
 * @package BizJump_Wizard
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BJW_Checkout_Prefill' ) ) :
class BJW_Checkout_Prefill {

    public static function register(): void {
        add_filter( 'woocommerce_checkout_get_value',  [ __CLASS__, 'prefill_field' ], 10, 2 );
    }

    public static function prefill_field( $value, $input ) {
        if ( ! empty( $value ) ) return $value; // user already changed it
        $state = function_exists( 'WC' ) && WC()->session ? WC()->session->get( 'bjw_state' ) : null;
        if ( ! is_array( $state ) ) return $value;
        $c = $state['contact'] ?? [];

        $map = [
            'billing_first_name' => $c['firstName'] ?? '',
            'billing_last_name'  => $c['lastName']  ?? '',
            'billing_email'      => $c['email']     ?? '',
            'billing_phone'      => $c['phone']     ?? '',
            'billing_address_1'  => $c['street1']   ?? '',
            'billing_address_2'  => $c['street2']   ?? '',
            'billing_city'       => $c['city']      ?? '',
            'billing_state'      => $c['state']     ?? '',
            'billing_postcode'   => $c['zip']       ?? '',
            'billing_country'    => $c['country']   ?? 'US',
        ];
        return $map[ $input ] ?? $value;
    }
}
endif;
