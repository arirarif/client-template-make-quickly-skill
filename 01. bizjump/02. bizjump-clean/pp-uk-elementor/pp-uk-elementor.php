<?php
/**
 * Plugin Name: Performance Peptide UK — Elementor Widgets
 * Description: Custom Elementor widgets for the Performance Peptide UK WooCommerce site. Adds Compliance Bar, Hero, How It Works, Categories, Featured Products, About Peptides, Quality Pillars, FAQ, Newsletter, Footer, and Age Gate sections.
 * Version: 1.0.0
 * Author: Performance Peptide UK
 * Author URI: https://performancepeptideuk.com
 * Text Domain: pp-uk-elementor
 * Requires Plugins: elementor
 * Elementor tested up to: 3.25
 * License: GPL v2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'PPUK_VERSION', '1.0.0' );
define( 'PPUK_PATH', plugin_dir_path( __FILE__ ) );
define( 'PPUK_URL', plugin_dir_url( __FILE__ ) );

/**
 * Check Elementor is active, then bootstrap.
 */
function ppuk_elementor_check() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'ppuk_elementor_missing_notice' );
        return;
    }
    require_once PPUK_PATH . 'includes/class-pp-uk-elementor.php';
    \PP_UK_Elementor\Plugin::instance();
}
add_action( 'plugins_loaded', 'ppuk_elementor_check' );

/**
 * Admin notice when Elementor is not active.
 */
function ppuk_elementor_missing_notice() {
    printf(
        '<div class="notice notice-error"><p><strong>Performance Peptide UK Elementor Widgets</strong> requires <strong>Elementor</strong> to be installed and activated.</p></div>'
    );
}
