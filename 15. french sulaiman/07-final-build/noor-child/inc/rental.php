<?php
/**
 * NOOR — Rental tweaks (Réunion only).
 *
 * The booking engine itself = WooCommerce Bookings (per-item stock, calendar).
 * This module adds what the plugin doesn't do:
 * - cash-deposit acknowledgement checkbox at checkout (no gateway)
 * - deposit note saved on the order (admin sees it)
 * - rental cross-sells nudge in cart
 * Region-hiding of rentals is in inc/region.php.
 */

defined( 'ABSPATH' ) || exit;

/** Does the cart contain a rental (product in the rental category)? */
function noor_cart_has_rental() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return false;
	}
	foreach ( WC()->cart->get_cart() as $item ) {
		if ( has_term( NOOR_RENTAL_CAT, 'product_cat', $item['product_id'] ) ) {
			return true;
		}
	}
	return false;
}

/* --------------------------------------------------------------------------
 * Cash deposit — acknowledged on the PRODUCT page, before adding to the cart
 *
 * The client asked for this to behave like a terms checkbox: the customer must
 * tick it before the reservation can go into the cart, not discover it later at
 * checkout. The tick is stored on the cart line, shown in the cart, and copied
 * onto the order. Checkout only reminds — it no longer asks a second time.
 * ------------------------------------------------------------------------ */

/** Is this product a rental? Rental category, or a booking-type product. */
function noor_is_rental_product( $product_id ) {
	if ( has_term( NOOR_RENTAL_CAT, 'product_cat', $product_id ) ) {
		return true;
	}
	$product = wc_get_product( $product_id );
	return $product && $product->is_type( 'mwb_booking' );
}

/** Deposit for a product: per-product field, else the site default. */
function noor_deposit_amount( $product_id ) {
	$amount = get_post_meta( $product_id, '_noor_deposit_amount', true );
	if ( '' === $amount || null === $amount ) {
		$amount = defined( 'NOOR_DEPOSIT_DEFAULT' ) ? NOOR_DEPOSIT_DEFAULT : 0;
	}
	return (float) $amount;
}

/** Sentence shown next to the checkbox. */
function noor_deposit_text( $product_id ) {
	$amount = noor_deposit_amount( $product_id );
	$sum    = $amount > 0 ? ' de ' . wp_strip_all_tags( wc_price( $amount ) ) : '';
	return sprintf(
		'<strong>Caution en espèces%s :</strong> elle est demandée à la remise du matériel et restituée intégralement au retour, en bon état. Aucun paiement en ligne pour la caution.',
		$sum
	);
}

/* ---- Admin: deposit amount per rental product ---- */
add_action( 'woocommerce_product_options_general_product_data', function () {
	woocommerce_wp_text_input( array(
		'id'                => '_noor_deposit_amount',
		'label'             => 'Caution (€)',
		'description'       => 'Caution en espèces demandée à la remise. Vide = valeur par défaut du site.',
		'desc_tip'          => true,
		'type'              => 'number',
		'custom_attributes' => array( 'step' => '1', 'min' => '0' ),
	) );
} );

add_action( 'woocommerce_process_product_meta', function ( $post_id ) {
	$value = isset( $_POST['_noor_deposit_amount'] ) ? wc_clean( wp_unslash( $_POST['_noor_deposit_amount'] ) ) : '';
	update_post_meta( $post_id, '_noor_deposit_amount', $value );
} );

/* ---- Product page: required acknowledgement above the booking button ---- */
add_action( 'woocommerce_before_add_to_cart_button', function () {
	global $product;
	if ( ! $product || ! noor_is_rental_product( $product->get_id() ) ) {
		return;
	}
	?>
	<div class="noor-deposit-notice noor-deposit-notice--product">
		<label>
			<?php /* Deliberately NOT `required`: the browser's own constraint check
			   aborts the submission before any script runs, which swallowed the
			   "choisissez vos dates" message the client asked for. noor.js shows
			   both messages itself; the server guard below is the real refusal. */ ?>
			<input type="checkbox" name="noor_deposit_ack" value="1">
			<span><?php echo wp_kses_post( noor_deposit_text( $product->get_id() ) ); ?>
			<em>Je comprends et j’accepte.</em></span>
		</label>
	</div>
	<?php
}, 50 ); // late, so it sits directly above the booking button (after the plugin date and price block)

/* ---- Server-side guard: no dates, no reservation ----
 *
 * The booking plugin does not enforce its own date fields: it reads them with
 * array_key_exists, so an empty field still "exists" and strtotime('') returns
 * false — the reservation went into the cart with a meaningless date instead of
 * being refused. Runs at priority 5, before the deposit check, so a customer who
 * filled in nothing gets the date message first rather than two red notices. */
add_filter( 'woocommerce_add_to_cart_validation', function ( $passed, $product_id ) {
	if ( ! $passed || ! noor_is_rental_product( $product_id ) ) {
		return $passed;
	}
	$from = isset( $_POST['mwb_mbfw_booking_from_time'] ) ? wc_clean( wp_unslash( $_POST['mwb_mbfw_booking_from_time'] ) ) : '';
	$to   = isset( $_POST['mwb_mbfw_booking_to_time'] ) ? wc_clean( wp_unslash( $_POST['mwb_mbfw_booking_to_time'] ) ) : '';

	if ( '' === noor_date_key( $from ) || '' === noor_date_key( $to ) ) {
		wc_add_notice( 'Veuillez sélectionner vos dates de location (du … au …) avant de réserver.', 'error' );
		return false;
	}
	return $passed;
}, 5, 2 );

/* ---- Server-side guard: no tick, no reservation ---- */
add_filter( 'woocommerce_add_to_cart_validation', function ( $passed, $product_id ) {
	if ( ! $passed || ! noor_is_rental_product( $product_id ) ) {
		return $passed;
	}
	if ( empty( $_POST['noor_deposit_ack'] ) ) {
		wc_add_notice( 'Merci d’accepter la condition de caution avant de réserver ce matériel.', 'error' );
		return false;
	}
	return $passed;
}, 10, 2 );

/* ---- Remember the acknowledgement on the cart line ---- */
add_filter( 'woocommerce_add_cart_item_data', function ( $data, $product_id ) {
	if ( noor_is_rental_product( $product_id ) && ! empty( $_POST['noor_deposit_ack'] ) ) {
		$data['noor_deposit_ack']    = 'yes';
		$data['noor_deposit_amount'] = noor_deposit_amount( $product_id );
	}
	return $data;
}, 10, 2 );

/* ---- Show it on the cart / checkout line ---- */
add_filter( 'woocommerce_get_item_data', function ( $item_data, $cart_item ) {
	if ( ! empty( $cart_item['noor_deposit_ack'] ) ) {
		$amount      = isset( $cart_item['noor_deposit_amount'] ) ? (float) $cart_item['noor_deposit_amount'] : 0;
		$item_data[] = array(
			'key'   => 'Caution acceptée',
			'value' => $amount > 0
				? wp_strip_all_tags( wc_price( $amount ) ) . ' en espèces à la remise'
				: 'en espèces à la remise',
		);
	}
	return $item_data;
}, 10, 2 );

/** Total deposit currently in the cart. */
function noor_cart_deposit_total() {
	$total = 0;
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return $total;
	}
	foreach ( WC()->cart->get_cart() as $item ) {
		if ( ! empty( $item['noor_deposit_amount'] ) ) {
			$total += (float) $item['noor_deposit_amount'] * (int) $item['quantity'];
		}
	}
	return $total;
}

/* ---- Checkout: remind, do not ask again ---- */
add_action( 'woocommerce_review_order_before_submit', function () {
	if ( ! noor_cart_has_rental() ) {
		return;
	}
	$total = noor_cart_deposit_total();
	?>
	<div class="noor-deposit-notice noor-deposit-notice--recap">
		<strong>🔐 Rappel caution<?php echo $total > 0 ? ' — ' . wp_kses_post( wc_price( $total ) ) : ''; ?> :</strong>
		à régler <em>en espèces</em> à la remise du matériel, restituée au retour en bon état.
		Vous avez accepté cette condition en réservant. Aucun montant n’est prélevé en ligne.
	</div>
	<?php
} );

/* ---- Copy onto the order ---- */
add_action( 'woocommerce_checkout_create_order', function ( $order ) {
	if ( ! noor_cart_has_rental() ) {
		return;
	}
	$total = noor_cart_deposit_total();
	$order->update_meta_data( '_noor_deposit_ack', 'yes' );
	$order->update_meta_data( '_noor_deposit_total', $total );
	$order->add_order_note( sprintf(
		'Caution acceptée par le client : %s en espèces à la remise du matériel.',
		wp_strip_all_tags( wc_price( $total ) )
	) );
} );

// Show it in admin order screen.
add_action( 'woocommerce_admin_order_data_after_billing_address', function ( $order ) {
	if ( 'yes' === $order->get_meta( '_noor_deposit_ack' ) ) {
		$total = (float) $order->get_meta( '_noor_deposit_total' );
		echo '<p><strong>🔐 Caution location :</strong> acceptée par le client'
			. ( $total > 0 ? ' — ' . wp_strip_all_tags( wc_price( $total ) ) . ' en espèces à la remise' : '' )
			. '</p>';
	}
} );

/* --------------------------------------------------------------------------
 * Block pricing — a rental is billed per started block of N days
 *
 * The client sells the arch as a package — 25 € for 4 days as of 16/08/2026
 * (it was 35 € when this was built) — not as a daily rate. The amount and the
 * block length are product meta, so a price change never touches this file. The
 * rule for periods longer than one block is still to be confirmed. The booking
 * plugin only knows a per-day rate, so we replace the total it computes: every
 * started block of N days costs one block price (1 to 4 days = 1 block,
 * 5 to 8 days = 2 blocks, and so on).
 *
 * Two filters are needed because the plugin works the total out twice:
 *   wps_mbfw_set_unit_cost_price_day  -> the live total box on the product page
 *   mwb_mbfw_vary_product_unit_price  -> the price that lands in the cart
 * Leaving the block price empty on a product keeps the old per-day behaviour.
 * ------------------------------------------------------------------------ */

/** Block setup for a product, or false when it stays billed per day. */
function noor_block_config( $product_id ) {
	$price = get_post_meta( $product_id, '_noor_block_price', true );
	if ( '' === $price || null === $price ) {
		return false;
	}
	$days = (int) get_post_meta( $product_id, '_noor_block_days', true );
	return array(
		'days'  => $days > 0 ? $days : 4,
		'price' => (float) $price,
	);
}

/** Number of blocks a booking of $units days uses — any started block counts. */
function noor_block_count( $units, $block_days ) {
	$units = (int) ceil( (float) $units );
	if ( $units < 1 ) {
		$units = 1;
	}
	$block_days = (int) $block_days > 0 ? (int) $block_days : 4;
	return (int) max( 1, ceil( $units / $block_days ) );
}

/** Total for $units days, or false when this product is not block-priced. */
function noor_block_total( $product_id, $units ) {
	$config = noor_block_config( $product_id );
	if ( ! $config ) {
		return false;
	}
	return noor_block_count( $units, $config['days'] ) * $config['price'];
}

/** Remembers what was charged per cart line, filled while prices are computed. */
function noor_block_memo( $key = null, $value = null ) {
	static $memo = array();
	if ( null === $key ) {
		return $memo;
	}
	if ( null !== $value ) {
		$memo[ $key ] = $value;
	}
	return isset( $memo[ $key ] ) ? $memo[ $key ] : null;
}

/** Tariff sentence shown under the calendar. */
function noor_block_text( $product_id ) {
	$config = noor_block_config( $product_id );
	if ( ! $config ) {
		return '';
	}
	return sprintf(
		'<strong>Tarif forfaitaire : %1$s pour %2$d jours.</strong> Toute période entamée de %2$d jours est facturée au même tarif — de %3$d à %4$d jours : %5$s.',
		wp_strip_all_tags( wc_price( $config['price'] ) ),
		$config['days'],
		$config['days'] + 1,
		$config['days'] * 2,
		wp_strip_all_tags( wc_price( $config['price'] * 2 ) )
	);
}

/* ---- Admin: block price and block length, per rental product ---- */
add_action( 'woocommerce_product_options_general_product_data', function () {
	woocommerce_wp_text_input( array(
		'id'                => '_noor_block_price',
		'label'             => 'Forfait — prix (€)',
		'description'       => 'Prix d’un forfait. Laisser vide pour facturer au jour comme avant.',
		'desc_tip'          => true,
		'type'              => 'number',
		'custom_attributes' => array( 'step' => '0.01', 'min' => '0' ),
	) );
	woocommerce_wp_text_input( array(
		'id'                => '_noor_block_days',
		'label'             => 'Forfait — nombre de jours',
		'description'       => 'Durée couverte par un forfait. Vide = 4 jours.',
		'desc_tip'          => true,
		'type'              => 'number',
		'custom_attributes' => array( 'step' => '1', 'min' => '1' ),
	) );
}, 20 );

add_action( 'woocommerce_process_product_meta', function ( $post_id ) {
	foreach ( array( '_noor_block_price', '_noor_block_days' ) as $meta_key ) {
		$value = isset( $_POST[ $meta_key ] ) ? wc_clean( wp_unslash( $_POST[ $meta_key ] ) ) : '';
		update_post_meta( $post_id, $meta_key, $value );
	}
}, 20 );

/* ---- Live total box on the product page ----
 * Returning a float makes the plugin treat our number as the whole cost
 * instead of multiplying its per-day rate by the number of days. */
add_filter( 'wps_mbfw_set_unit_cost_price_day', function ( $price, $product_id, $date_from, $date_to, $units ) {
	$total = noor_block_total( $product_id, $units );
	return false === $total ? $price : $total;
}, 10, 5 );

/* ---- The price that actually lands in the cart ---- */
add_filter( 'mwb_mbfw_vary_product_unit_price', function ( $unit_price, $cart_data, $cart_object, $cart_item, $booking_dates, $units ) {
	$product_id = isset( $cart_item['product_id'] ) ? (int) $cart_item['product_id'] : 0;
	$total      = noor_block_total( $product_id, $units );
	if ( false === $total ) {
		return $unit_price;
	}
	$config = noor_block_config( $product_id );
	if ( ! empty( $cart_item['key'] ) ) {
		noor_block_memo( $cart_item['key'], array(
			'blocks' => noor_block_count( $units, $config['days'] ),
			'days'   => (int) $config['days'],
			'price'  => (float) $config['price'],
		) );
	}
	return $total;
}, 10, 6 );

/* ---- Shop and product page price: "35,00 € / 4 jours" ---- */
add_filter( 'woocommerce_get_price_html', function ( $html, $product ) {
	$config = noor_block_config( $product->get_id() );
	if ( ! $config ) {
		return $html;
	}
	return wc_price( $config['price'] )
		. ' <span class="noor-price-unit">/ ' . (int) $config['days'] . ' jours</span>';
}, 10, 2 );

/* ---- Tariff explanation under the calendar, above the deposit tick ---- */
add_action( 'woocommerce_before_add_to_cart_button', function () {
	global $product;
	if ( ! $product ) {
		return;
	}
	$text = noor_block_text( $product->get_id() );
	if ( '' === $text ) {
		return;
	}
	echo '<div class="noor-block-notice">' . wp_kses_post( $text ) . '</div>';
}, 40 );

/* ---- Cart line: spell the forfait out ---- */
add_filter( 'woocommerce_get_item_data', function ( $item_data, $cart_item ) {
	$memo = ! empty( $cart_item['key'] ) ? noor_block_memo( $cart_item['key'] ) : null;
	if ( ! $memo ) {
		return $item_data;
	}
	$item_data[] = array(
		'key'   => 'Forfait',
		'value' => sprintf(
			'%d × %d jours (%s le forfait)',
			$memo['blocks'],
			$memo['days'],
			wp_strip_all_tags( wc_price( $memo['price'] ) )
		),
	);
	return $item_data;
}, 20, 2 );

/* ---- Cart line: booking dates in French ----
 * The booking plugin formats its dates with gmdate(), which never translates
 * month names, so a French shop still reads "September 1, 2026". We reformat
 * the two rows it printed, matching them by VALUE against the stored booking
 * values rather than by label, so a change of wording cannot break this.
 *
 * The stored meta is deliberately left alone: noor_rental_unavailable_days()
 * parses those same strings, and rewriting them would move the calendar.
 * ------------------------------------------------------------------------ */
add_filter( 'woocommerce_get_item_data', function ( $item_data, $cart_item ) {
	if ( empty( $cart_item['mwb_mbfw_booking_values'] ) || ! is_array( $item_data ) ) {
		return $item_data;
	}
	$values = (array) $cart_item['mwb_mbfw_booking_values'];
	$stored = array();
	foreach ( array( 'date_time_from', 'date_time_to', 'single_cal_date_time_from', 'single_cal_date_time_to' ) as $field ) {
		if ( ! empty( $values[ $field ] ) ) {
			$stored[] = trim( (string) $values[ $field ] );
		}
	}
	if ( ! $stored ) {
		return $item_data;
	}
	// A row carries its text in "display" or in "value" depending on who added
	// it, and WooCommerce reads whichever is set — so rewrite both when present.
	foreach ( $item_data as $index => $row ) {
		foreach ( array( 'display', 'value' ) as $field ) {
			if ( ! isset( $row[ $field ] ) ) {
				continue;
			}
			$current = trim( wp_strip_all_tags( (string) $row[ $field ] ) );
			if ( '' === $current || ! in_array( $current, $stored, true ) ) {
				continue;
			}
			$pretty = noor_format_booking_date( $current );
			if ( '' !== $pretty ) {
				$item_data[ $index ][ $field ] = $pretty;
			}
		}
	}
	return $item_data;
}, 30, 2 );

/** "September 1, 2026" becomes "1 septembre 2026". Empty when it is not a date. */
function noor_format_booking_date( $value ) {
	$key = noor_date_key( $value );
	if ( '' === $key ) {
		return '';
	}
	// Midday keeps the day from slipping either side of a timezone boundary.
	$stamp = strtotime( $key . ' 12:00:00' );
	return $stamp ? date_i18n( 'j F Y', $stamp ) : '';
}

/* ---- Order, e-mails and My account: the same dates, also in French ----
 * The plugin echoes its stored date strings straight out, with no filter to
 * intercept, so the only way to translate them is to take the renderer over.
 * Noor uses none of its other fields (no people count, no services, no slots),
 * so ours prints the period and the cancelled state and nothing else.
 * ------------------------------------------------------------------------ */
add_action( 'wp_loaded', function () {
	global $wp_filter;
	$hook = 'woocommerce_order_item_meta_end';
	if ( empty( $wp_filter[ $hook ] ) ) {
		return;
	}
	// Collect first, remove after: remove_action rewrites the array we walk.
	$doomed = array();
	foreach ( $wp_filter[ $hook ]->callbacks as $priority => $callbacks ) {
		foreach ( $callbacks as $registered ) {
			$callback = $registered['function'];
			if ( is_array( $callback ) && isset( $callback[1] )
				&& 'mbfw_show_booking_details_on_my_account_page_user' === $callback[1] ) {
				$doomed[] = array( $callback, $priority );
			}
		}
	}
	foreach ( $doomed as $entry ) {
		remove_action( $hook, $entry[0], $entry[1] );
	}
}, 20 );

add_action( 'woocommerce_order_item_meta_end', 'noor_render_booking_period', 10, 4 );

/** Print the rental period under the order line, in French. */
function noor_render_booking_period( $item_id, $item, $order = null, $plain_text = false ) {
	if ( ! is_object( $item ) || ! method_exists( $item, 'get_product' ) ) {
		return;
	}
	$product = $item->get_product();
	if ( ! $product || 'mwb_booking' !== $product->get_type() ) {
		return;
	}

	if ( 'yes' === wc_get_order_item_meta( $item_id, '_item_cancelled', true ) ) {
		$reason = wc_get_order_item_meta( $item_id, '_cancel_reason', true );
		$line   = 'Réservation annulée' . ( $reason ? ' — ' . $reason : '' );
		echo $plain_text
			? "\n" . esc_html( $line ) . "\n"
			: '<p class="noor-booking-cancelled">' . esc_html( $line ) . '</p>';
		return;
	}

	$from = noor_format_booking_date( $item->get_meta( '_mwb_bfwp_date_time_from', true ) );
	$to   = noor_format_booking_date( $item->get_meta( '_mwb_bfwp_date_time_to', true ) );
	if ( '' === $from ) {
		$from = noor_format_booking_date( $item->get_meta( '_wps_single_cal_date_time_from', true ) );
		$to   = noor_format_booking_date( $item->get_meta( '_wps_single_cal_date_time_to', true ) );
	}
	if ( '' === $from ) {
		return;
	}

	$period = ( '' !== $to && $to !== $from )
		? sprintf( 'du %s au %s', $from, $to )
		: sprintf( 'le %s', $from );

	echo $plain_text
		? "\n" . esc_html( 'Période de location : ' . $period ) . "\n"
		: '<p class="noor-booking-dates"><strong>Période de location :</strong> ' . esc_html( $period ) . '</p>';
}

/* --------------------------------------------------------------------------
 * Availability — grey out the days that are already taken
 *
 * The free booking plugin only works out booked-up days for its "single
 * calendar" mode; for the two-field calendar we use, that list is a paid
 * feature and always arrives empty. So we work it out ourselves: read the
 * booking dates stored on past order lines, count how many units each day is
 * out, and treat a day as unavailable once the whole stock is committed. The
 * shop owner can also close days by hand per product.
 *
 * The result feeds three things: the calendar (days disabled and struck
 * through), a legend under it, and a server-side guard so a booking cannot be
 * forced through by editing the page.
 * ------------------------------------------------------------------------ */

/** Normalise any stored booking date to a plain Y-m-d key. */
function noor_date_key( $value ) {
	$value = trim( (string) $value );
	if ( '' === $value ) {
		return '';
	}
	$parts = explode( ' ', $value );
	if ( preg_match( '~^(\d{1,2})[-/](\d{1,2})[-/](\d{4})$~', $parts[0], $found ) ) {
		return sprintf( '%04d-%02d-%02d', $found[3], $found[2], $found[1] );
	}
	$timestamp = strtotime( $value );
	return $timestamp ? gmdate( 'Y-m-d', $timestamp ) : '';
}

/** Every day from one Y-m-d key to another, both ends included. */
function noor_days_between( $from_key, $to_key ) {
	if ( '' === $from_key ) {
		return array();
	}
	if ( '' === $to_key || $to_key < $from_key ) {
		$to_key = $from_key;
	}
	$days   = array();
	$zone   = new DateTimeZone( 'UTC' );
	$cursor = new DateTime( $from_key . ' 00:00:00', $zone );
	$end    = new DateTime( $to_key . ' 00:00:00', $zone );
	$step   = new DateInterval( 'P1D' );
	$guard  = 0;
	while ( $cursor <= $end && $guard < 400 ) {
		$days[] = $cursor->format( 'Y-m-d' );
		$cursor->add( $step );
		$guard++;
	}
	return $days;
}

/** How many units of this rental exist.
 *
 * Deliberately NOT the WooCommerce stock: a rental comes back, but WooCommerce
 * decrements stock on every order, so stock would shrink with each booking and
 * the calendar would slowly close itself. The owner states the fleet size once.
 */
function noor_rental_capacity( $product_id ) {
	$units = (int) get_post_meta( $product_id, '_noor_rental_units', true );
	if ( $units > 0 ) {
		return $units;
	}
	$product = wc_get_product( $product_id );
	$stock   = $product ? (int) $product->get_stock_quantity() : 0;
	return $stock > 0 ? $stock : 1;
}

/** Days closed by hand in the product settings. */
function noor_manual_blocked_days( $product_id ) {
	$raw  = (string) get_post_meta( $product_id, '_noor_blocked_dates', true );
	$days = array();
	foreach ( preg_split( '~[\r\n;,]+~', $raw ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts = preg_split( '~\s+(?:au|à|to|->)\s+~ui', $line );
		$from  = noor_date_key( $parts[0] );
		$to    = isset( $parts[1] ) ? noor_date_key( $parts[1] ) : $from;
		$days  = array_merge( $days, noor_days_between( $from, $to ) );
	}
	return $days;
}

/** Days this rental cannot be booked on, as Y-m-d keys. */
function noor_rental_unavailable_days( $product_id ) {
	$product_id  = (int) $product_id;
	$cache_key   = 'noor_rental_unavail_' . $product_id;
	$cached      = get_transient( $cache_key );
	// ?noor_refresh=1 recomputes on the spot — handy when a booking was changed
	// straight in the database, or while checking a closure was picked up.
	if ( is_array( $cached ) && ! isset( $_GET['noor_refresh'] ) ) {
		return $cached;
	}

	global $wpdb;
	$rows = $wpdb->get_results( $wpdb->prepare(
		"SELECT oi.order_id,
			MAX( CASE WHEN oim.meta_key = '_mwb_bfwp_date_time_from' THEN oim.meta_value END ) AS date_from,
			MAX( CASE WHEN oim.meta_key = '_mwb_bfwp_date_time_to'   THEN oim.meta_value END ) AS date_to,
			MAX( CASE WHEN oim.meta_key = '_qty'                     THEN oim.meta_value END ) AS qty,
			MAX( CASE WHEN oim.meta_key = '_product_id'              THEN oim.meta_value END ) AS product_id
		FROM {$wpdb->prefix}woocommerce_order_items AS oi
		INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS oim
			ON oim.order_item_id = oi.order_item_id
		WHERE oi.order_item_type = 'line_item'
		GROUP BY oi.order_item_id
		HAVING product_id = %d",
		$product_id
	) );

	// A cancelled or refunded booking frees its dates again.
	$holds    = apply_filters( 'noor_rental_holding_statuses', array( 'pending', 'on-hold', 'processing', 'completed' ) );
	$capacity = noor_rental_capacity( $product_id );
	$counts   = array();

	foreach ( (array) $rows as $row ) {
		$order = wc_get_order( $row->order_id );
		if ( ! $order || ! in_array( $order->get_status(), $holds, true ) ) {
			continue;
		}
		$quantity = max( 1, (int) $row->qty );
		foreach ( noor_days_between( noor_date_key( $row->date_from ), noor_date_key( $row->date_to ) ) as $day ) {
			$counts[ $day ] = ( isset( $counts[ $day ] ) ? $counts[ $day ] : 0 ) + $quantity;
		}
	}

	$unavailable = array();
	foreach ( $counts as $day => $taken ) {
		if ( $taken >= $capacity ) {
			$unavailable[] = $day;
		}
	}
	$unavailable = array_merge( $unavailable, noor_manual_blocked_days( $product_id ) );
	$unavailable = array_values( array_unique( $unavailable ) );
	sort( $unavailable );

	set_transient( $cache_key, $unavailable, 6 * HOUR_IN_SECONDS );
	return $unavailable;
}

/** Forget the cached availability — a booking or a setting just changed. */
function noor_flush_rental_availability( $product_id = 0 ) {
	if ( $product_id ) {
		delete_transient( 'noor_rental_unavail_' . (int) $product_id );
		return;
	}
	$ids = get_posts( array(
		'post_type'   => 'product',
		'post_status' => 'any',
		'numberposts' => 200,
		'fields'      => 'ids',
		'tax_query'   => array( array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => NOOR_RENTAL_CAT,
		) ),
	) );
	foreach ( $ids as $id ) {
		delete_transient( 'noor_rental_unavail_' . (int) $id );
	}
}
add_action( 'woocommerce_new_order', 'noor_flush_rental_availability' );
add_action( 'woocommerce_checkout_order_processed', 'noor_flush_rental_availability' );
add_action( 'woocommerce_order_status_changed', 'noor_flush_rental_availability' );
add_action( 'woocommerce_update_product', 'noor_flush_rental_availability' );

/* ---- Admin: close days by hand ---- */
add_action( 'woocommerce_product_options_general_product_data', function () {
	woocommerce_wp_text_input( array(
		'id'                => '_noor_rental_units',
		'label'             => 'Unités disponibles',
		'description'       => 'Combien d’exemplaires vous possédez. Une journée devient indisponible quand tous sont réservés. Vide = valeur du stock.',
		'desc_tip'          => true,
		'type'              => 'number',
		'custom_attributes' => array( 'step' => '1', 'min' => '1' ),
	) );
	woocommerce_wp_textarea_input( array(
		'id'          => '_noor_blocked_dates',
		'label'       => 'Jours indisponibles',
		'description' => 'Un par ligne, au format jj/mm/aaaa. Pour une période : 24/12/2026 au 02/01/2027. Les jours déjà réservés sont bloqués automatiquement.',
		'desc_tip'    => true,
		'rows'        => 4,
	) );
}, 30 );

add_action( 'woocommerce_process_product_meta', function ( $post_id ) {
	$value = isset( $_POST['_noor_blocked_dates'] ) ? sanitize_textarea_field( wp_unslash( $_POST['_noor_blocked_dates'] ) ) : '';
	update_post_meta( $post_id, '_noor_blocked_dates', $value );
	$units = isset( $_POST['_noor_rental_units'] ) ? wc_clean( wp_unslash( $_POST['_noor_rental_units'] ) ) : '';
	update_post_meta( $post_id, '_noor_rental_units', $units );
	noor_flush_rental_availability( $post_id );
}, 30 );

/* ---- Hand the list to the calendar script ---- */
add_action( 'wp_enqueue_scripts', function () {
	if ( ! is_singular( 'product' ) ) {
		return;
	}
	$product_id = get_the_ID();
	if ( ! noor_is_rental_product( $product_id ) ) {
		return;
	}
	wp_localize_script( 'noor-js', 'NOOR_RENTAL', array(
		'unavailable' => noor_rental_unavailable_days( $product_id ),
		'closed'      => noor_manual_blocked_days( $product_id ),
		'capacity'    => noor_rental_capacity( $product_id ),
	) );
}, 30 );

/* ---- Legend under the calendar ---- */
add_action( 'woocommerce_before_add_to_cart_button', function () {
	global $product;
	if ( ! $product || ! noor_is_rental_product( $product->get_id() ) ) {
		return;
	}
	?>
	<div class="noor-cal-legend">
		<span><i class="noor-swatch noor-swatch--free"></i>Disponible</span>
		<span><i class="noor-swatch noor-swatch--busy"></i>Déjà réservé</span>
		<span><i class="noor-swatch noor-swatch--pick"></i>Votre sélection</span>
	</div>
	<?php /* Shown by assets/noor.js when someone tries to reserve with no dates.
	   The real refusal happens server-side; this only says so before the click
	   costs a page reload. */ ?>
	<p class="noor-date-required" hidden>Veuillez sélectionner vos dates de location.</p>
	<?php
}, 30 );

/* ---- Guard: refuse a booking that lands on a taken day ---- */
add_filter( 'woocommerce_add_to_cart_validation', function ( $passed, $product_id ) {
	if ( ! $passed || ! noor_is_rental_product( $product_id ) ) {
		return $passed;
	}
	$from = isset( $_POST['mwb_mbfw_booking_from_time'] ) ? wc_clean( wp_unslash( $_POST['mwb_mbfw_booking_from_time'] ) ) : '';
	$to   = isset( $_POST['mwb_mbfw_booking_to_time'] ) ? wc_clean( wp_unslash( $_POST['mwb_mbfw_booking_to_time'] ) ) : '';
	if ( '' === $from ) {
		return $passed;
	}
	$clash = array_intersect(
		noor_days_between( noor_date_key( $from ), noor_date_key( $to ) ),
		noor_rental_unavailable_days( $product_id )
	);
	if ( empty( $clash ) ) {
		return $passed;
	}
	$readable = array();
	foreach ( $clash as $day ) {
		$readable[] = gmdate( 'd/m/Y', strtotime( $day ) );
	}
	wc_add_notice(
		sprintf(
			'Ces dates ne sont plus disponibles : %s. Merci de choisir une autre période.',
			implode( ', ', $readable )
		),
		'error'
	);
	return false;
}, 20, 2 );

/* --------------------------------------------------------------------------
 * Rental cross-sells nudge in cart
 * (real linked products are set per-product in "Linked Products" — this just
 *  surfaces them prominently when a rental is in the cart)
 * ------------------------------------------------------------------------ */
add_action( 'woocommerce_cart_collaterals', function () {
	if ( ! noor_cart_has_rental() ) {
		return;
	}
	echo '<p class="noor-rental-nudge" style="font-size:13px;color:#7C6350;">🎈 <em>Complétez votre location :</em> pensez aux nappes, ballons et accessoires ci-dessous.</p>';
}, 5 );

/* --------------------------------------------------------------------------
 * WPS Bookings — French strings
 * The free plugin ships no fr_FR translation, so the rental form shows
 * English labels on an otherwise French site. Map the handful we display.
 * ------------------------------------------------------------------------ */
add_filter( 'gettext', function ( $translated, $original, $domain ) {
	if ( 0 !== strpos( (string) $domain, 'mwb-bookings' ) && 0 !== strpos( (string) $domain, 'wps-' ) ) {
		return $translated;
	}
	// The cost row is relabelled for block-priced rentals: they are not sold by
	// the day, so "Tarif journalier ( 35,00 € /jour )" would be misleading. The
	// row is only ever rendered by the totals AJAX call, which carries the id.
	$booking_product = isset( $_POST['mwb_mbfw_booking_product_id'] ) ? (int) $_POST['mwb_mbfw_booking_product_id'] : 0;
	$is_block_priced = $booking_product && noor_block_config( $booking_product );

	$map = array(
		'From'                => 'Du',
		'To'                  => 'Au',
		'Book Now'            => 'Réserver',
		'Booking'             => 'Réservation',
		'Bookings'            => 'Réservations',
		'Total'               => 'Total',
		'Total Price'         => 'Prix total',
		'Booking Details'     => 'Détails de la réservation',
		'Select Date'         => 'Choisir une date',
		'Choose date'         => 'jj/mm/aaaa', // short: the field is narrow and the plugin capitalises it
		'Choose Date'         => 'Choisir une date',
		'Check In'            => 'Retrait',
		'Check Out'           => 'Retour',
		'Quantity'            => 'Quantité',
		'Day'                 => 'jour',
		'Days'                => 'jours',
		'My Bookings'         => 'Mes réservations',
		// NOTE: the plugin compares its cost labels as literal English when
		// deciding whether to hide a row (`if ( 'General Cost' == $title )`).
		// Translating a label therefore disables that row's "hide" checkbox.
		// 'Base Cost' is deliberately NOT translated: we hide that row with the
		// plugin's own option instead (it is always 0 € for our rentals).
		'General Cost'        => $is_block_priced ? 'Forfait de location' : 'Tarif journalier',
		'/day'                => $is_block_priced ? '' : '/jour',
	);
	return $map[ $original ] ?? $translated;
}, 20, 3 );

/* The plugin auto-assigns a "booking" product category on save — noise in the
 * breadcrumb next to the real "Location" category. Strip it on the fly. */
add_filter( 'get_the_terms', function ( $terms, $post_id, $taxonomy ) {
	if ( 'product_cat' !== $taxonomy || is_wp_error( $terms ) || ! is_array( $terms ) ) {
		return $terms;
	}
	return array_filter( $terms, function ( $t ) {
		return 'booking' !== $t->slug;
	} );
}, 10, 3 );
