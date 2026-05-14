<?php
/**
 * BizJump Wizard — AJAX endpoints.
 *
 * Single endpoint: bjw_submit
 *   Receives the wizard state as JSON, validates server-side, recomputes prices
 *   from the authoritative PHP data tables (never trust JS-supplied prices),
 *   builds the WC cart, and returns the checkout URL.
 *
 * @package BizJump_Wizard
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BJW_Ajax_Handlers' ) ) :
class BJW_Ajax_Handlers {

    public static function register(): void {
        add_action( 'wp_ajax_bjw_submit',        [ __CLASS__, 'submit' ] );
        add_action( 'wp_ajax_nopriv_bjw_submit', [ __CLASS__, 'submit' ] );
    }

    /** Handle wizard submission. */
    public static function submit(): void {
        check_ajax_referer( 'bjw_submit', 'nonce' );

        $raw   = isset( $_POST['state'] ) ? wp_unslash( $_POST['state'] ) : '';
        $state = json_decode( $raw, true );
        if ( ! is_array( $state ) ) {
            wp_send_json_error( [ 'message' => 'Invalid wizard state payload.' ], 400 );
        }

        // 1) Validate required fields
        $errors = self::validate( $state );
        if ( ! empty( $errors ) ) {
            wp_send_json_error( [ 'message' => 'Missing required fields.', 'errors' => $errors ], 422 );
        }

        // 2) Persist the submission (transient + WP option for audit log)
        $submission_id = self::store_submission( $state );

        // 3) Build cart (delegated to BJW_WC_Hooks; only runs if Woo is active)
        if ( class_exists( 'BJW_WC_Hooks' ) && class_exists( 'WooCommerce' ) ) {
            BJW_WC_Hooks::build_cart_from_wizard( $state );
            $redirect = wc_get_checkout_url();
        } else {
            // No Woo: just confirm; the wizard can still capture leads.
            $redirect = home_url( '/incorporation/?thanks=' . $submission_id );
        }

        wp_send_json_success( [
            'submission_id' => $submission_id,
            'redirect'      => $redirect,
        ] );
    }

    /** Required-field validator. Returns array of field => error message. */
    private static function validate( array $s ): array {
        $errors = [];

        // Entity + state
        if ( empty( $s['entity'] ) )    $errors['entity']    = 'Entity type required.';
        if ( empty( $s['stateName'] ) ) $errors['stateName'] = 'Formation state required.';

        // Plan
        if ( empty( $s['plan']['id'] ) || ! BJW_Plans::get( $s['plan']['id'] ) ) {
            $errors['plan'] = 'Pick a plan.';
        }

        // Business
        if ( empty( $s['business']['name'] ) )       $errors['business.name']       = 'Business name required.';
        if ( empty( $s['business']['designator'] ) ) $errors['business.designator'] = 'Designator required.';

        // Contact
        $c = $s['contact'] ?? [];
        foreach ( [ 'firstName', 'lastName', 'email', 'phone', 'street1', 'city', 'state', 'zip' ] as $f ) {
            if ( empty( $c[ $f ] ) ) $errors[ 'contact.' . $f ] = ucfirst( $f ) . ' required.';
        }
        if ( ! empty( $c['email'] ) && ! is_email( $c['email'] ) ) {
            $errors['contact.email'] = 'Valid email required.';
        }

        // Consent (legal box must be ticked)
        if ( empty( $s['consent']['legal'] ) ) {
            $errors['consent.legal'] = 'You must agree to the Legal Statement.';
        }

        return $errors;
    }

    /** Persist a submission to wp_options under a rolling key + return its id. */
    private static function store_submission( array $state ): string {
        $id   = 'BJ-' . strtoupper( wp_generate_password( 8, false, false ) );
        $log  = get_option( 'bjw_submissions', [] );
        // Keep only the last 200 submissions to avoid wp_options bloat
        if ( count( $log ) >= 200 ) $log = array_slice( $log, -199, 199, true );
        $log[ $id ] = [
            'id'         => $id,
            'created'    => current_time( 'mysql' ),
            'entity'     => $state['entity']    ?? '',
            'state'      => $state['stateName'] ?? '',
            'plan'       => $state['plan']['id']?? '',
            'email'      => $state['contact']['email'] ?? '',
            'name'       => trim( ( $state['contact']['firstName'] ?? '' ) . ' ' . ( $state['contact']['lastName'] ?? '' ) ),
            'phone'      => $state['contact']['phone'] ?? '',
            'biz_name'   => $state['business']['name'] ?? '',
            'designator' => $state['business']['designator'] ?? '',
            // Recompute server-side using authoritative tables (don't trust JS prices)
            'state_fee'  => BJW_State_Fees::get_fee( $state['stateName'] ?? '', $state['entity'] ?? '' ),
            'expedited'  => ! empty( $state['filingTime']['type'] ) && $state['filingTime']['type'] === 'rush'
                            ? BJW_State_Fees::get_expedited( $state['stateName'] ?? '' )
                            : 0,
            'addons'     => array_keys( $state['inlineAddons'] ?? [] ),
            'raw'        => $state,
        ];
        update_option( 'bjw_submissions', $log, false );
        return $id;
    }
}
endif;
