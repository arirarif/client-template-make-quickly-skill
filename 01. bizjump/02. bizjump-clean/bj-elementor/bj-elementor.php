<?php
/**
 * Plugin Name: BizJump — Elementor Widgets
 * Description: Custom Elementor widgets for the BizJump incorporation service website. Adds Announcement Bar, Hero, Ticker Marquee, Stats Strip, How It Works, Entity Types, Pricing Cards, Why BizJump, Services Grid, Testimonials, CTA Banner, and Footer sections.
 * Version: 1.0.0
 * Author: BizJump
 * Author URI: https://bizjump.com
 * Text Domain: bj-elementor
 * Requires Plugins: elementor
 * Elementor tested up to: 3.25
 * License: GPL v2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'BJW_EL_VERSION', '1.0.0' );
define( 'BJW_EL_PATH',    plugin_dir_path( __FILE__ ) );
define( 'BJW_EL_URL',     plugin_dir_url( __FILE__ ) );

/**
 * Check Elementor is active, then bootstrap.
 */
function bj_elementor_check() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'bj_elementor_missing_notice' );
        return;
    }
    require_once BJW_EL_PATH . 'includes/class-bj-elementor.php';
    \BJ_Elementor\Plugin::instance();
}
add_action( 'plugins_loaded', 'bj_elementor_check' );

/**
 * Admin notice when Elementor is not active.
 */
function bj_elementor_missing_notice() {
    printf(
        '<div class="notice notice-error"><p><strong>BizJump Elementor Widgets</strong> requires <strong>Elementor</strong> to be installed and activated.</p></div>'
    );
}
