<?php
/**
 * Emma child theme: fonts and layout CSS only.
 *
 * Content types and the setup tool live in the emma-core plugin, so the
 * site's data survives a theme change.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function () {
	$deps = wp_style_is( 'elementor-frontend', 'registered' ) ? array( 'elementor-frontend' ) : array();
	wp_enqueue_style(
		'emma-theme',
		get_stylesheet_directory_uri() . '/assets/css/theme.css',
		$deps,
		wp_get_theme()->get( 'Version' )
	);
}, 20 );

/* Same CSS inside the Elementor editor preview and the editor panel font list. */
add_action( 'elementor/preview/enqueue_styles', function () {
	wp_enqueue_style(
		'emma-theme',
		get_stylesheet_directory_uri() . '/assets/css/theme.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
} );

/* The headline font sits above the fold on every page. */
add_action( 'wp_head', function () {
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( get_stylesheet_directory_uri() . '/assets/fonts/gloock-400.woff2' )
	);
}, 1 );

/* The brand fonts are self-hosted: list them in Elementor without a Google Fonts request. */
add_filter( 'elementor/fonts/additional_fonts', function ( $fonts ) {
	$fonts['Gloock']         = 'system';
	$fonts['Hanken Grotesk'] = 'system';
	return $fonts;
} );
