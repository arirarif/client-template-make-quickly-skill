<?php
/**
 * NOOR — My Account: "Locations actives" (Active Rentals) endpoint.
 *
 * Adds a My Account tab listing the customer's current/upcoming bookings.
 * Reads WooCommerce Bookings data when the plugin is active; shows a clean
 * empty state otherwise. Full visual override of account screens comes later
 * via woocommerce/myaccount/ templates.
 */

defined( 'ABSPATH' ) || exit;

define( 'NOOR_RENTALS_ENDPOINT', 'locations' );

/* Register the endpoint. After activation: Settings → Permalinks → Save. */
add_action( 'init', function () {
	add_rewrite_endpoint( NOOR_RENTALS_ENDPOINT, EP_ROOT | EP_PAGES );
} );

/* Menu item — after Orders. */
add_filter( 'woocommerce_account_menu_items', function ( $items ) {
	$new = array();
	foreach ( $items as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'orders' === $key ) {
			$new[ NOOR_RENTALS_ENDPOINT ] = '📅 Locations actives';
		}
	}
	return $new;
} );

/* Endpoint content. */
add_action( 'woocommerce_account_' . NOOR_RENTALS_ENDPOINT . '_endpoint', function () {
	echo '<h3 style="font-family:\'Playfair Display\',serif;">Mes locations</h3>';

	if ( ! class_exists( 'WC_Booking_Data_Store' ) ) {
		echo '<p>Le système de location sera bientôt disponible.</p>';
		return;
	}

	$booking_ids = WC_Booking_Data_Store::get_booking_ids_by( array(
		'customer_id' => get_current_user_id(),
		'status'      => array( 'confirmed', 'paid', 'pending-confirmation' ),
		'limit'       => 20,
		'order_by'    => 'start_date',
		'order'       => 'ASC',
	) );

	if ( empty( $booking_ids ) ) {
		echo '<p>Aucune location en cours. <a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">Découvrir notre matériel de location →</a></p>';
		return;
	}

	echo '<table class="shop_table"><thead><tr><th>Matériel</th><th>Du</th><th>Au</th><th>Statut</th></tr></thead><tbody>';
	foreach ( $booking_ids as $bid ) {
		$booking = get_wc_booking( $bid );
		if ( ! $booking ) {
			continue;
		}
		$product = $booking->get_product();
		echo '<tr>';
		echo '<td>' . ( $product ? '<a href="' . esc_url( get_permalink( $product->get_id() ) ) . '">' . esc_html( $product->get_name() ) . '</a>' : '—' ) . '</td>';
		echo '<td>' . esc_html( date_i18n( 'd M Y', $booking->get_start() ) ) . '</td>';
		echo '<td>' . esc_html( date_i18n( 'd M Y', $booking->get_end() ) ) . '</td>';
		echo '<td>' . esc_html( wc_bookings_get_status_label( $booking->get_status() ) ) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
} );

/* Dashboard greeting with rental awareness. */
add_action( 'woocommerce_account_dashboard', function () {
	if ( 're' === noor_current_region() ) {
		echo '<p style="background:#FAF6F1;border:1px solid #DCC7AC;border-radius:10px;padding:12px 16px;font-size:13.5px;">'
			. '📅 Retrouvez vos réservations de matériel dans <a href="' . esc_url( wc_get_account_endpoint_url( NOOR_RENTALS_ENDPOINT ) ) . '"><strong>Locations actives</strong></a>.</p>';
	}
}, 5 );
