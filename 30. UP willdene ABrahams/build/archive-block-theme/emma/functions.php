<?php
/**
 * Emma theme: design only.
 *
 * Content types, the enquiry form and the setup tool live in the emma-core
 * plugin, so the site's data survives a theme change.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', function () {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/theme.css' );
	remove_theme_support( 'core-block-patterns' );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'emma-theme',
		get_theme_file_uri( 'assets/css/theme.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);
} );

/* The headline font sits above the fold on every page. */
add_action( 'wp_head', function () {
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( get_theme_file_uri( 'assets/fonts/gloock-400.woff2' ) )
	);
}, 1 );

add_action( 'init', function () {
	register_block_pattern_category( 'emma', array( 'label' => __( 'Emma sections', 'emma' ) ) );

	register_block_style( 'core/button', array(
		'name'  => 'sun',
		'label' => __( 'Sunflower', 'emma' ),
	) );
	register_block_style( 'core/button', array(
		'name'  => 'textlink',
		'label' => __( 'Underlined link', 'emma' ),
	) );
	register_block_style( 'core/paragraph', array(
		'name'  => 'label',
		'label' => __( 'Small label', 'emma' ),
	) );
	register_block_style( 'core/paragraph', array(
		'name'  => 'text-link',
		'label' => __( 'Underlined link', 'emma' ),
	) );
} );
