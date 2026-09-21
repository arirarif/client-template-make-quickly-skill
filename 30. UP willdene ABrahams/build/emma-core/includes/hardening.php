<?php
/**
 * Small security settings that need no extra plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* XML-RPC is not used by this site and is a common attack target. */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'wp_headers', function ( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
} );

/* Visitors cannot list user names through the REST API or ?author=1. */
add_filter( 'rest_endpoints', function ( $endpoints ) {
	if ( ! is_user_logged_in() ) {
		unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
} );
add_action( 'template_redirect', function () {
	if ( is_author() && ! is_user_logged_in() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
} );

/* This site has no comments. */
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );

/* Do not show the WordPress version. */
remove_action( 'wp_head', 'wp_generator' );
