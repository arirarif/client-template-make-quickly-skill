<?php
/**
 * BizJump Wizard — AJAX Handlers
 *
 * Handles the bj_create_order AJAX action:
 *   1. Validates nonce + inputs
 *   2. Clears the WC cart
 *   3. Adds the correct plan product
 *   4. Adds selected add-on products
 *   5. Stores wizard session data (for wc-hooks.php to pick up at checkout)
 *   6. Returns JSON with { redirect: checkout_url } or { error: message }
 *
 * Hooked in this file; AJAX actions are registered here, not in the main file.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register AJAX action for logged-in and guest users
add_action( 'wp_ajax_bj_create_order',        'bjw_ajax_create_order' );
add_action( 'wp_ajax_nopriv_bj_create_order', 'bjw_ajax_create_order' );

/**
 * Main AJAX handler.
 */
function bjw_ajax_create_order(): void {
    // 1. Verify nonce
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'bjw_nonce' ) ) {
        wp_send_json_error( [ 'message' => 'Security check failed.' ], 403 );
    }

    // 2. Parse + sanitize POST data
    $plan_key    = isset( $_POST['plan'] )   ? sanitize_key( $_POST['plan'] )   : '';
    $state_slug  = isset( $_POST['state'] )  ? sanitize_key( $_POST['state'] )  : '';
    $entity_type = isset( $_POST['entity'] ) ? sanitize_key( $_POST['entity'] ) : '';
    $addon_keys  = [];

    if ( isset( $_POST['addons'] ) && is_array( $_POST['addons'] ) ) {
        foreach ( $_POST['addons'] as $k ) {
            $addon_keys[] = sanitize_key( $k );
        }
    }

    // Business details (Step 5 in legacy 6-step wizard, Step 2 in FLW-10)
    $business_details = [
        'business_name'   => isset( $_POST['business_name'] )   ? sanitize_text_field( wp_unslash( $_POST['business_name'] ) )   : '',
        'designator'      => isset( $_POST['designator'] )       ? sanitize_text_field( wp_unslash( $_POST['designator'] ) )       : '',
        'business_address'=> isset( $_POST['business_address'] ) ? sanitize_textarea_field( wp_unslash( $_POST['business_address'] ) ) : '',
        'first_name'      => isset( $_POST['first_name'] )       ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) )       : '',
        'last_name'       => isset( $_POST['last_name'] )        ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) )        : '',
        'contact_person'  => isset( $_POST['contact_person'] )   ? sanitize_text_field( wp_unslash( $_POST['contact_person'] ) )   : '',
        'contact_email'   => isset( $_POST['contact_email'] )    ? sanitize_email( wp_unslash( $_POST['contact_email'] ) )         : '',
        'contact_phone'   => isset( $_POST['contact_phone'] )    ? sanitize_text_field( wp_unslash( $_POST['contact_phone'] ) )    : '',
        'sms_consent'     => ! empty( $_POST['sms_consent'] ),
    ];

    // If wizard didn't provide split first/last (legacy flow only sends contact_person), derive them.
    if ( '' === $business_details['first_name'] && '' === $business_details['last_name'] && ! empty( $business_details['contact_person'] ) ) {
        $parts = preg_split( '/\s+/', trim( $business_details['contact_person'] ), 2 );
        $business_details['first_name'] = $parts[0] ?? '';
        $business_details['last_name']  = $parts[1] ?? '';
    }

    // 3. Validate required fields
    if ( empty( $plan_key ) || empty( $state_slug ) || empty( $entity_type ) ) {
        wp_send_json_error( [ 'message' => 'Missing required fields.' ], 422 );
    }

    // 4. Resolve WC product IDs
    $plan_product_id = bjw_get_product_id( $plan_key );
    if ( ! $plan_product_id ) {
        wp_send_json_error( [ 'message' => 'Plan product not found. Please contact support.' ], 500 );
    }

    // 5. Make sure WooCommerce cart is available
    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        wp_send_json_error( [ 'message' => 'WooCommerce is not available.' ], 500 );
    }

    WC()->cart->empty_cart();

    // 6. Add plan product to cart
    $cart_item_key = WC()->cart->add_to_cart( $plan_product_id, 1 );
    if ( ! $cart_item_key ) {
        wp_send_json_error( [ 'message' => 'Could not add plan to cart.' ], 500 );
    }

    // 7. Add each selected add-on
    foreach ( $addon_keys as $addon_key ) {
        $addon_product_id = bjw_get_product_id( $addon_key );
        if ( $addon_product_id ) {
            WC()->cart->add_to_cart( $addon_product_id, 1 );
        }
    }

    // 8. Save wizard data to WC session (wc-hooks.php picks this up at checkout)
    WC()->session->set( 'bjw_wizard_data', [
        'entity_type'      => $entity_type,
        'state'            => $state_slug,
        'plan'             => $plan_key,
        'addons'           => $addon_keys,
        'business_details' => $business_details,
    ] );

    // 9. Return checkout URL
    wp_send_json_success( [
        'redirect' => wc_get_checkout_url(),
    ] );
}
