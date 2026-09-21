<?php
/**
 * Shows an Emma Elementor template (for example the Footer) from the theme,
 * so it also works while Elementor Pro's Theme Builder is not active.
 * With Pro active, Theme Builder takes over and this is not used.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @param string $key Template key set by the setup tool: header, footer ...
 * @return bool True when the template was printed.
 */
function emma_core_render_template( $key ) {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return false;
	}
	$found = get_posts( array(
		'post_type'   => 'elementor_library',
		'post_status' => 'publish',
		'meta_key'    => '_emma_key',
		'meta_value'  => $key,
		'numberposts' => 1,
		'fields'      => 'ids',
	) );
	if ( ! $found ) {
		return false;
	}
	$html = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( (int) $found[0] );
	if ( ! $html ) {
		return false;
	}
	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own rendered markup.
	return true;
}
