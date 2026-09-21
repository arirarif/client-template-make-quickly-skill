<?php
/**
 * Footer used while Elementor Pro's Theme Builder is not active: prints the
 * Emma "Footer" Elementor template (Templates > Footer). If that is missing,
 * Hello's own footer is used.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'emma_core_render_template' ) || ! emma_core_render_template( 'footer' ) ) {
	require get_template_directory() . '/template-parts/dynamic-footer.php';
}
