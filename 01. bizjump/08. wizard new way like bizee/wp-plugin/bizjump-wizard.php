<?php
/**
 * Plugin Name:     BizJump Wizard
 * Plugin URI:      https://bizjump.com
 * Description:     Bizee-style incorporation wizard with per-entity state fees, 3 plan tiers, entity-gated add-ons, contact-step prefill, and WooCommerce checkout. V4 — built from scratch matching the 08/index.html prototype.
 * Version:         4.2.2
 * Author:          BizJump Dev
 * Text Domain:     bizjump-wizard
 * Requires at least: 6.0
 * Requires PHP:    7.4
 *
 * @package BizJump_Wizard
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'BJW_VERSION', '4.2.2' );
define( 'BJW_DIR',     plugin_dir_path( __FILE__ ) );
define( 'BJW_URL',     plugin_dir_url( __FILE__ ) );
define( 'BJW_FILE',    __FILE__ );

// Data layer (no deps; load first)
require_once BJW_DIR . 'includes/data-state-fees.php';
require_once BJW_DIR . 'includes/data-plans.php';
require_once BJW_DIR . 'includes/data-addons.php';
require_once BJW_DIR . 'includes/data-designators.php';

// Behaviour layer
require_once BJW_DIR . 'includes/shortcode.php';
require_once BJW_DIR . 'includes/ajax-handlers.php';
require_once BJW_DIR . 'includes/wc-hooks.php';
require_once BJW_DIR . 'includes/checkout-prefill.php';
require_once BJW_DIR . 'includes/class-installer.php';
require_once BJW_DIR . 'includes/class-admin.php';

// Wire up on plugins_loaded
add_action( 'plugins_loaded', function () {
    add_shortcode( 'bizjump_wizard', [ 'BJW_Shortcode', 'render' ] );
    add_action( 'wp_enqueue_scripts', [ 'BJW_Shortcode', 'enqueue_assets' ] );

    BJW_Ajax_Handlers::register();
    BJW_Admin::register();

    if ( class_exists( 'WooCommerce' ) ) {
        BJW_WC_Hooks::register();
        BJW_Checkout_Prefill::register();
    }
} );

register_activation_hook( __FILE__, [ 'BJW_Installer', 'activate' ] );
register_deactivation_hook( __FILE__, function () {
    flush_rewrite_rules();
} );
