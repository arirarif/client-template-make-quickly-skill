<?php
/**
 * Plugin Name: BizJump — LZ-Inspired Elementor Widgets
 * Description: Custom Elementor widgets for the BizJump pages — demo-landing (LLC sales), formation-landing (doc-aligned entity selector), and formation wizard. Adds 20 widgets organized under the "BizJump LZ Widgets" category.
 * Version: 2.0.0
 * Author: BizJump
 * Author URI: https://bizjump.com
 * Text Domain: bj-lz-elementor
 * Requires Plugins: elementor
 * Elementor tested up to: 3.25
 * License: GPL v2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'BJLZ_EL_VERSION', '2.0.0' );
define( 'BJLZ_EL_PATH',    plugin_dir_path( __FILE__ ) );
define( 'BJLZ_EL_URL',     plugin_dir_url( __FILE__ ) );

function bj_lz_elementor_check() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'bj_lz_elementor_missing_notice' );
        return;
    }
    require_once BJLZ_EL_PATH . 'includes/class-bj-lz-elementor.php';
    \BJ_LZ_Elementor\Plugin::instance();
}
add_action( 'plugins_loaded', 'bj_lz_elementor_check' );

function bj_lz_elementor_missing_notice() {
    printf(
        '<div class="notice notice-error"><p><strong>BizJump LZ Elementor Widgets</strong> requires <strong>Elementor</strong> to be installed and activated.</p></div>'
    );
}
