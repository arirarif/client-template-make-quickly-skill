<?php
/**
 * NOOR — CRO: free-shipping progress bar, cart-exclusive add-ons,
 * recently viewed strip.
 */

defined( 'ABSPATH' ) || exit;

/** Region-aware free-shipping threshold (€). */
function noor_freeship_threshold() {
	switch ( noor_current_region() ) {
		case 're': return (float) NOOR_FREESHIP_RE;
		case 'yt': return (float) NOOR_FREESHIP_YT;
		default:   return (float) NOOR_FREESHIP_FR;
	}
}

/* --------------------------------------------------------------------------
 * Free-shipping progress bar — [noor_freeship_bar]
 * Auto-inserted on: cart page + single product page (above Add to Cart).
 * ------------------------------------------------------------------------ */
function noor_freeship_bar_html() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return '';
	}
	$threshold = noor_freeship_threshold();
	if ( $threshold <= 0 ) {
		return '';
	}
	$total    = (float) WC()->cart->get_displayed_subtotal();
	$pct      = min( 100, round( $total / $threshold * 100 ) );
	$missing  = max( 0, $threshold - $total );
	$unlocked = $missing <= 0;

	$msg = $unlocked
		? '🎉 <b>Livraison gratuite débloquée !</b>'
		: 'Plus que <b>' . wc_price( $missing ) . '</b> pour la <b>livraison gratuite</b>';

	return '<div class="noor-freeship' . ( $unlocked ? ' unlocked' : '' ) . '">'
		. '<div class="noor-freeship-msg">' . $msg . '</div>'
		. '<div class="noor-freeship-track"><div class="noor-freeship-fill" style="width:' . $pct . '%"></div></div>'
		. '</div>';
}
add_shortcode( 'noor_freeship_bar', 'noor_freeship_bar_html' );

add_action( 'woocommerce_before_cart', function () { echo noor_freeship_bar_html(); }, 5 );
add_action( 'woocommerce_before_add_to_cart_form', function () { echo noor_freeship_bar_html(); }, 5 );

/* --------------------------------------------------------------------------
 * Cart-exclusive add-ons — offers that appear ONLY under a condition.
 * v1 rule: when a rental is in the cart, offer the products listed below.
 * Manage: put the product IDs of the add-on offers here.
 * ------------------------------------------------------------------------ */
function noor_cart_addon_ids() {
	// TODO: real product IDs after products are imported (e.g. tablecloth, balloons).
	return array(); // e.g. array( 123, 456 );
}

add_action( 'woocommerce_cart_collaterals', function () {
	if ( ! noor_cart_has_rental() ) {
		return;
	}
	$ids = array_filter( array_map( 'absint', noor_cart_addon_ids() ) );
	if ( empty( $ids ) ) {
		return;
	}
	// Don't offer what's already in the cart.
	foreach ( WC()->cart->get_cart() as $item ) {
		$ids = array_diff( $ids, array( $item['product_id'] ) );
	}
	if ( empty( $ids ) ) {
		return;
	}
	echo '<div class="noor-cart-addons"><h3 style="font-family:\'Playfair Display\',serif;">Offres exclusives location 🎈</h3>';
	echo do_shortcode( '[products ids="' . implode( ',', $ids ) . '" columns="3" limit="3"]' );
	echo '</div>';
}, 8 );

/* --------------------------------------------------------------------------
 * Recently viewed strip on the cart page.
 * Uses WooCommerce's own woocommerce_recently_viewed cookie.
 * ------------------------------------------------------------------------ */
add_action( 'woocommerce_after_cart', function () {
	if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) {
		return;
	}
	$ids = array_filter( array_map( 'absint', explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ) );
	$ids = array_slice( array_reverse( $ids ), 0, 4 );
	if ( empty( $ids ) ) {
		return;
	}
	echo '<div class="noor-recently-viewed"><h3 style="font-family:\'Playfair Display\',serif;">Vus récemment</h3>';
	echo do_shortcode( '[products ids="' . implode( ',', $ids ) . '" columns="4" limit="4"]' );
	echo '</div>';
} );

// Make sure Woo actually tracks recently-viewed (it only does when the widget is active).
add_action( 'template_redirect', function () {
	if ( is_singular( 'product' ) ) {
		global $post;
		$viewed = empty( $_COOKIE['woocommerce_recently_viewed'] )
			? array()
			: array_filter( array_map( 'absint', explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ) );
		$viewed   = array_diff( $viewed, array( $post->ID ) );
		$viewed[] = $post->ID;
		$viewed   = array_slice( $viewed, -15 );
		wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed ) );
	}
}, 20 );
