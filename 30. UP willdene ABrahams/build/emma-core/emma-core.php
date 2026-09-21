<?php
/**
 * Plugin Name: Emma Core
 * Description: Site functionality for Emma Digital Agency: the Portfolio (case studies) with Service tags and a simple project form, small security settings, and a one-time setup tool that creates the Elementor pages and templates.
 * Version: 0.1.0
 * Author: Md Ariful Islam
 * Requires at least: 6.6
 * Requires PHP: 8.0
 * License: GPL-2.0-or-later
 * Text Domain: emma-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EMMA_CORE_VERSION', '0.1.0' );
define( 'EMMA_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'EMMA_CORE_URL', plugin_dir_url( __FILE__ ) );

require_once EMMA_CORE_DIR . 'includes/content-types.php';
require_once EMMA_CORE_DIR . 'includes/hardening.php';

/* The setup tool is only needed while building. Delete includes/setup.php and /templates after launch. */
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) || defined( 'EMMA_CORE_RUN_SETUP' ) ) {
	if ( file_exists( EMMA_CORE_DIR . 'includes/setup.php' ) ) {
		require_once EMMA_CORE_DIR . 'includes/setup.php';
	}
}

register_activation_hook( __FILE__, function () {
	emma_core_register_content_types();
	flush_rewrite_rules();
} );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
