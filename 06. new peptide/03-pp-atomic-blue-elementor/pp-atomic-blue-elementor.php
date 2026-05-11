<?php
/**
 * Plugin Name: Performance Peptides — Atomic Blue Elementor Widgets
 * Description: Custom Elementor widgets implementing the "Atomic Blue" homepage design for the Performance Peptides WooCommerce store. Hero, Trust Strip, Categories, Featured Products (live Woo), Newsletter, News Carousel, Footer.
 * Version: 1.0.0
 * Author: Performance Peptides
 * Text Domain: pp-atomic-blue
 * Requires Plugins: elementor, woocommerce
 * Elementor tested up to: 3.25
 * License: GPL v2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'PP_VERSION', '1.0.0' );
define( 'PP_PATH', plugin_dir_path( __FILE__ ) );
define( 'PP_URL', plugin_dir_url( __FILE__ ) );

function pp_atomic_blue_check() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'pp_atomic_blue_missing_notice' );
        return;
    }
    require_once PP_PATH . 'includes/class-pp-atomic-blue.php';
    \PP_Atomic_Blue\Plugin::instance();
}
add_action( 'plugins_loaded', 'pp_atomic_blue_check' );

function pp_atomic_blue_missing_notice() {
    printf(
        '<div class="notice notice-error"><p><strong>Performance Peptides — Atomic Blue Widgets</strong> requires <strong>Elementor</strong> to be installed and activated.</p></div>'
    );
}
