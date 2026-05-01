<?php
/**
 * BizJump Wizard — WooCommerce Hooks
 *
 * 1. Cart fee — adds the state filing fee as a line item (not a product)
 * 2. Order meta — saves wizard data to the order on checkout
 * 3. Admin meta box — displays wizard data in WC order admin screen
 * 4. My Account tab — adds "My Formation" tab to WC customer dashboard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── 1. State Filing Fee ───────────────────────────────────────────────────────

add_action( 'woocommerce_cart_calculate_fees', 'bjw_add_state_filing_fee' );

function bjw_add_state_filing_fee( WC_Cart $cart ): void {
    $wizard = WC()->session ? WC()->session->get( 'bjw_wizard_data' ) : null;
    if ( empty( $wizard['state'] ) ) {
        return;
    }

    $fee = bjw_get_state_fee( $wizard['state'] );
    if ( $fee > 0 ) {
        $state_name = '';
        foreach ( bjw_get_state_fees() as $s ) {
            if ( $s['slug'] === strtoupper( $wizard['state'] ) ) {
                $state_name = $s['name'];
                break;
            }
        }
        $cart->add_fee(
            sprintf( __( 'State Filing Fee (%s)', 'bizjump-wizard' ), $state_name ),
            $fee,
            false // not taxable
        );
    }
}

// ── 1b. Pre-fill WC Checkout Fields from Wizard Session ──────────────────────
// When the wizard redirects to /checkout/, populate billing fields with what
// the customer already typed in the wizard so they don't retype it.

add_filter( 'woocommerce_checkout_get_value', 'bjw_prefill_checkout_field', 10, 2 );

function bjw_prefill_checkout_field( $value, string $input ) {
    // If the customer already typed something into the field, don't override it.
    if ( ! empty( $value ) ) {
        return $value;
    }

    $wizard = WC()->session ? WC()->session->get( 'bjw_wizard_data' ) : null;
    if ( empty( $wizard ) || empty( $wizard['business_details'] ) ) {
        return $value;
    }

    $details = $wizard['business_details'];
    $state   = ! empty( $wizard['state'] ) ? strtoupper( $wizard['state'] ) : '';

    switch ( $input ) {
        case 'billing_first_name':
            return $details['first_name'] ?? '';
        case 'billing_last_name':
            return $details['last_name'] ?? '';
        case 'billing_email':
            return $details['contact_email'] ?? '';
        case 'billing_phone':
            return $details['contact_phone'] ?? '';
        case 'billing_company':
            $name = trim( ( $details['business_name'] ?? '' ) . ' ' . ( $details['designator'] ?? '' ) );
            return $name;
        case 'billing_country':
            // All bizjump-wizard states are US.
            return 'US';
        case 'billing_state':
            return $state;
        case 'billing_address_1':
            return $details['business_address'] ?? '';
    }

    return $value;
}

// ── 2. Save Wizard Data to Order ─────────────────────────────────────────────

add_action( 'woocommerce_checkout_create_order', 'bjw_save_wizard_data_to_order', 10, 2 );

function bjw_save_wizard_data_to_order( WC_Order $order, array $data ): void {
    $wizard = WC()->session ? WC()->session->get( 'bjw_wizard_data' ) : null;
    if ( empty( $wizard ) ) {
        return;
    }

    $order->update_meta_data( '_bjw_entity_type',      sanitize_text_field( $wizard['entity_type'] ?? '' ) );
    $order->update_meta_data( '_bjw_state',            sanitize_text_field( $wizard['state'] ?? '' ) );
    $order->update_meta_data( '_bjw_plan',             sanitize_text_field( $wizard['plan'] ?? '' ) );
    $order->update_meta_data( '_bjw_addons',           wp_json_encode( $wizard['addons'] ?? [] ) );

    $details = $wizard['business_details'] ?? [];
    $order->update_meta_data( '_bjw_business_name',    sanitize_text_field( $details['business_name'] ?? '' ) );
    $order->update_meta_data( '_bjw_designator',       sanitize_text_field( $details['designator'] ?? '' ) );
    $order->update_meta_data( '_bjw_business_address', sanitize_textarea_field( $details['business_address'] ?? '' ) );
    $order->update_meta_data( '_bjw_contact_person',   sanitize_text_field( $details['contact_person'] ?? '' ) );
    $order->update_meta_data( '_bjw_contact_email',    sanitize_email( $details['contact_email'] ?? '' ) );
    $order->update_meta_data( '_bjw_contact_phone',    sanitize_text_field( $details['contact_phone'] ?? '' ) );
    $order->update_meta_data( '_bjw_sms_consent',      ! empty( $details['sms_consent'] ) ? 'yes' : 'no' );

    // Clear wizard session after saving
    WC()->session->__unset( 'bjw_wizard_data' );
}

// ── 2b. Add Internal Order Note with All Formation Data ──────────────────────
// Fires AFTER order is saved to DB (so add_order_note works correctly)

add_action( 'woocommerce_checkout_order_created', 'bjw_add_formation_order_note', 10, 1 );

function bjw_add_formation_order_note( WC_Order $order ): void {
    $entity = $order->get_meta( '_bjw_entity_type' );
    if ( empty( $entity ) ) {
        return; // not a BizJump order
    }

    $addons_raw = $order->get_meta( '_bjw_addons' );
    $addons     = $addons_raw ? json_decode( $addons_raw, true ) : [];
    $addon_list = ! empty( $addons )
        ? implode( ', ', array_map( fn( $k ) => ucwords( str_replace( '_', ' ', $k ) ), $addons ) )
        : 'None';

    $entity_label = strtoupper( str_replace( '_', '-', $entity ) );
    $plan_label   = ucfirst( str_replace( 'plan_', '', $order->get_meta( '_bjw_plan' ) ) );
    $state_label  = strtoupper( $order->get_meta( '_bjw_state' ) );

    $note  = "=== BizJump Formation Details ===\n";
    $note .= "Entity Type:      {$entity_label}\n";
    $note .= "State:            {$state_label}\n";
    $note .= "Plan:             {$plan_label}\n";
    $note .= "Add-Ons:          {$addon_list}\n";
    $note .= "Business Name:    " . $order->get_meta( '_bjw_business_name' ) . ' ' . $order->get_meta( '_bjw_designator' ) . "\n";
    $note .= "Business Address: " . $order->get_meta( '_bjw_business_address' ) . "\n";
    $note .= "Contact Person:   " . $order->get_meta( '_bjw_contact_person' ) . "\n";
    $note .= "Contact Email:    " . $order->get_meta( '_bjw_contact_email' ) . "\n";
    $note .= "Contact Phone:    " . $order->get_meta( '_bjw_contact_phone' ) . "\n";
    $note .= "SMS Consent:      " . ( $order->get_meta( '_bjw_sms_consent' ) === 'yes' ? 'Yes' : 'No' );

    // Internal note — not sent to customer, visible only in admin order screen
    $order->add_order_note( $note, 0, false );
}

// ── 3. Admin — Display Wizard Data in Order Screen ───────────────────────────

add_action( 'woocommerce_admin_order_data_after_billing_address', 'bjw_display_wizard_data_in_admin', 10, 1 );

function bjw_display_wizard_data_in_admin( WC_Order $order ): void {
    $entity = $order->get_meta( '_bjw_entity_type' );
    if ( empty( $entity ) ) {
        return; // not a BizJump order
    }

    $addons_raw = $order->get_meta( '_bjw_addons' );
    $addons     = $addons_raw ? json_decode( $addons_raw, true ) : [];
    $addon_list = ! empty( $addons ) ? implode( ', ', array_map( 'esc_html', $addons ) ) : '—';

    $fields = [
        'Entity Type'      => $entity,
        'State'            => $order->get_meta( '_bjw_state' ),
        'Plan'             => $order->get_meta( '_bjw_plan' ),
        'Add-Ons'          => $addon_list,
        'Business Name'    => $order->get_meta( '_bjw_business_name' ),
        'Designator'       => $order->get_meta( '_bjw_designator' ),
        'Business Address' => $order->get_meta( '_bjw_business_address' ),
        'Contact Person'   => $order->get_meta( '_bjw_contact_person' ),
        'Contact Email'    => $order->get_meta( '_bjw_contact_email' ),
        'Contact Phone'    => $order->get_meta( '_bjw_contact_phone' ),
        'SMS Consent'      => $order->get_meta( '_bjw_sms_consent' ) === 'yes' ? 'Yes' : 'No',
    ];

    echo '<div class="bjw-admin-formation" style="margin-top:20px;padding:16px;background:#f0f4ff;border-left:4px solid #1e3a8a;">';
    echo '<h3 style="margin:0 0 12px;color:#1e3a8a;">BizJump Formation Details</h3>';
    echo '<table style="width:100%;border-collapse:collapse;">';

    foreach ( $fields as $label => $value ) {
        $display = esc_html( $value );
        echo '<tr>';
        echo '<td style="padding:6px 12px 6px 0;font-weight:600;width:180px;vertical-align:top;">' . esc_html( $label ) . '</td>';
        echo '<td style="padding:6px 0;">' . $display . '</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '</div>';
}

// ── 4. My Account — "My Formation" Custom Tab ────────────────────────────────

add_filter( 'woocommerce_account_menu_items', 'bjw_add_formation_tab' );

function bjw_add_formation_tab( array $items ): array {
    // Insert after 'orders'
    $new_items = [];
    foreach ( $items as $key => $label ) {
        $new_items[ $key ] = $label;
        if ( 'orders' === $key ) {
            $new_items['my-formation'] = __( 'My Formation', 'bizjump-wizard' );
        }
    }
    return $new_items;
}

// Register the endpoint
add_action( 'init', 'bjw_add_formation_endpoint' );

function bjw_add_formation_endpoint(): void {
    add_rewrite_endpoint( 'my-formation', EP_ROOT | EP_PAGES );
}

// Render tab content
add_action( 'woocommerce_account_my-formation_endpoint', 'bjw_render_formation_tab' );

function bjw_render_formation_tab(): void {
    $user_id = get_current_user_id();
    if ( ! $user_id ) {
        echo '<p>' . esc_html__( 'Please log in to view your formations.', 'bizjump-wizard' ) . '</p>';
        return;
    }

    // Get all orders for this user that have BJW data
    $order_ids = wc_get_orders( [
        'customer_id' => $user_id,
        'return'      => 'ids',
        'limit'       => 20,
        'meta_key'    => '_bjw_business_name',
        'meta_compare'=> 'EXISTS',
    ] );

    if ( empty( $order_ids ) ) {
        echo '<p>' . esc_html__( 'No formation orders found yet. Start your incorporation now!', 'bizjump-wizard' ) . '</p>';
        echo '<p><a href="' . esc_url( home_url( '/incorporate/' ) ) . '" class="button">' . esc_html__( 'Start Formation', 'bizjump-wizard' ) . '</a></p>';
        return;
    }

    echo '<div class="bjw-dashboard">';

    foreach ( $order_ids as $order_id ) {
        $order       = wc_get_order( $order_id );
        $biz_name    = esc_html( $order->get_meta( '_bjw_business_name' ) );
        $entity      = esc_html( strtoupper( str_replace( '_', '-', $order->get_meta( '_bjw_entity_type' ) ) ) );
        $state       = esc_html( $order->get_meta( '_bjw_state' ) );
        $plan        = esc_html( str_replace( 'plan_', '', $order->get_meta( '_bjw_plan' ) ) );
        $order_status = esc_html( wc_get_order_status_name( $order->get_status() ) );
        $order_date  = esc_html( $order->get_date_created()->date_i18n( get_option( 'date_format' ) ) );

        echo '<div style="background:#f8faff;border:1px solid #d1d9f0;border-radius:8px;padding:20px;margin-bottom:20px;">';
        echo '<h3 style="margin:0 0 12px;color:#1e3a8a;">' . $biz_name . ' <span style="font-size:.8em;color:#64748b;">(' . $entity . ')</span></h3>';
        echo '<table style="width:100%;border-collapse:collapse;">';

        $row_data = [
            'Order #'     => '<a href="' . esc_url( $order->get_view_order_url() ) . '">#' . esc_html( $order->get_order_number() ) . '</a>',
            'State'       => $state,
            'Plan'        => ucfirst( $plan ),
            'Status'      => $order_status,
            'Ordered On'  => $order_date,
        ];

        foreach ( $row_data as $lbl => $val ) {
            echo '<tr>';
            echo '<td style="padding:6px 16px 6px 0;font-weight:600;width:130px;">' . esc_html( $lbl ) . '</td>';
            echo '<td style="padding:6px 0;">' . $val . '</td>'; // $val already escaped above
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>';
    }

    echo '</div>';
}
