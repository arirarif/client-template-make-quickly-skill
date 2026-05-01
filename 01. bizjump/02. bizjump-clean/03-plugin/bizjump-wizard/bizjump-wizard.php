<?php
/**
 * Plugin Name:     BizJump Wizard
 * Plugin URI:      https://bizjump.com
 * Description:     Multi-step incorporation wizard that integrates with WooCommerce for order creation, payment, and tracking.
 * Version:         1.2.0
 * Author:          BizJump Dev
 * Text Domain:     bizjump-wizard
 * Requires at least: 6.0
 * Requires PHP:    7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'BJW_VERSION',  '1.2.0' );
define( 'BJW_DIR',      plugin_dir_path( __FILE__ ) );
define( 'BJW_URL',      plugin_dir_url( __FILE__ ) );

// ── Load all includes ────────────────────────────────────────────────────────
require_once BJW_DIR . 'includes/data-state-fees.php';
require_once BJW_DIR . 'includes/data-plans.php';
require_once BJW_DIR . 'includes/data-addons.php';
require_once BJW_DIR . 'includes/ajax-handlers.php';
require_once BJW_DIR . 'includes/wc-hooks.php';
require_once BJW_DIR . 'includes/shortcode.php';
require_once BJW_DIR . 'includes/admin-page.php';   // WP Admin docs & product manager

// ── Register shortcode ───────────────────────────────────────────────────────
add_shortcode( 'bizjump_wizard', 'bjw_render_wizard' );

// ── Enqueue assets on pages that contain the shortcode ───────────────────────
add_action( 'wp_enqueue_scripts', 'bjw_enqueue_assets' );

function bjw_enqueue_assets() {
    global $post;

    // Only load on pages that use the shortcode
    if ( ! is_a( $post, 'WP_Post' ) || ! has_shortcode( $post->post_content, 'bizjump_wizard' ) ) {
        return;
    }

    wp_enqueue_style(
        'bjw-google-fonts',
        'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'bjw-wizard',
        BJW_URL . 'assets/wizard.css',
        [ 'bjw-google-fonts' ],
        BJW_VERSION
    );

    wp_enqueue_script(
        'bjw-wizard',
        BJW_URL . 'assets/wizard.js',
        [ 'jquery' ],
        BJW_VERSION,
        true   // load in footer
    );

    // Pass PHP data to JS (state fees, plans, add-ons, AJAX url)
    wp_localize_script( 'bjw-wizard', 'BJW', [
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'nonce'     => wp_create_nonce( 'bjw_nonce' ),
        'stateFees' => bjw_get_state_fees(),
        'plans'     => bjw_get_plans(),
        'addons'    => bjw_get_addons(),
        'currency'  => get_woocommerce_currency_symbol(),
    ] );
}

// ── Activation hook: create hidden WC products ───────────────────────────────
register_activation_hook( __FILE__, 'bjw_activate' );

function bjw_activate() {
    bjw_create_wc_products();
}

/**
 * Create/update all hidden WooCommerce products the wizard needs.
 * Safe to run multiple times — checks if product already exists via meta.
 */
function bjw_create_wc_products() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    $products = array_merge( bjw_get_plans(), bjw_get_addons() );

    foreach ( $products as $item ) {
        // Check if already created
        $existing = get_posts( [
            'post_type'  => 'product',
            'meta_key'   => '_bjw_product_key',
            'meta_value' => $item['key'],
            'numberposts'=> 1,
            'fields'     => 'ids',
        ] );

        if ( ! empty( $existing ) ) {
            continue; // already exists
        }

        $product = new WC_Product_Simple();
        $product->set_name( $item['label'] );
        $product->set_regular_price( $item['price'] );
        $product->set_catalog_visibility( 'hidden' ); // not visible in shop
        $product->set_status( 'publish' );
        $product->set_virtual( true );
        $product->save();

        update_post_meta( $product->get_id(), '_bjw_product_key', $item['key'] );
    }
}

/**
 * Helper: get WC product ID by BJW key.
 * Used in ajax-handlers.php to add the right product to cart.
 */
function bjw_get_product_id( string $key ): int {
    $posts = get_posts( [
        'post_type'  => 'product',
        'meta_key'   => '_bjw_product_key',
        'meta_value' => $key,
        'numberposts'=> 1,
        'fields'     => 'ids',
    ] );

    return ! empty( $posts ) ? (int) $posts[0] : 0;
}
