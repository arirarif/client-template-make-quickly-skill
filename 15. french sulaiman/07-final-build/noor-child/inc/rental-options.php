<?php
/**
 * NOOR — Options de location (client POINT 3, expliqué le 14/08/2026).
 *
 * The client's words:
 *
 *   "Sur la fiche d'une arche, une fois que le client a choisi ses dates, on lui
 *    propose des options — drapés, fleurs, etc. Il coche ce qu'il veut, SANS
 *    avoir à resaisir les dates. Arche 25 € + drapés 5 € + fleurs 5 € = 35 €."
 *
 * So: tick boxes under the date pickers on a rental, and every ticked option
 * joins the cart already carrying the parent's booking dates.
 *
 * WHY THIS IS NOT inc/bundle.php:
 * bundle.php refuses rentals on purpose (noor_bundle_addon_is_eligible), and its
 * whole point is a *discount* that only exists while the parent is in the cart.
 * The client's example has no discount — 25 + 5 + 5 = 35 — and needs something
 * bundle.php has no concept of: dates inherited from the parent line. Bending
 * the bundle to do both would have made two different offers share one code
 * path. This module is separate and bundle.php is untouched.
 *
 * WHAT IS CURATED WHERE:
 * the options offered under a rental are its **Linked Products → Upsells**, the
 * same list bundle.php uses for ordinary products, so the shop owner still
 * curates in one place and learns one habit.
 *
 * THE PRICING QUESTION THE CLIENT HAS NOT ANSWERED YET:
 * we asked whether an option's price covers the whole rental or is per day. He
 * has not replied, and that must not hold up the build — so it is a per-option
 * setting, `_noor_option_pricing`, defaulting to `flat` (whole rental), which is
 * what his own 25 + 5 + 5 = 35 example implies. If he answers "par jour", it is
 * a dropdown on each option product, not a code change.
 *
 * MONEY IS NEVER TAKEN FROM THE BROWSER. The form posts ticked ids and nothing
 * else; every amount is recomputed here from product meta and the stored dates.
 *
 * @package Noor_Child
 */

defined( 'ABSPATH' ) || exit;

/** Pricing mode for an option: 'flat' (whole rental) or 'per_day'. */
function noor_option_pricing_mode( $product_id ) {
	$mode = get_post_meta( (int) $product_id, '_noor_option_pricing', true );
	return ( 'per_day' === $mode ) ? 'per_day' : 'flat';
}

/**
 * Can this product be offered as an option under a rental?
 *
 * A rental cannot be an option of another rental: it would need its own dates,
 * its own deposit and its own availability calendar.
 */
function noor_option_is_eligible( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return false;
	}
	if ( noor_is_rental_product( $product->get_id() ) ) {
		return false;
	}
	return $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock();
}

/** The options offered under a rental, from its Upsells. */
function noor_rental_options( $product ) {
	if ( ! $product instanceof WC_Product || ! noor_is_rental_product( $product->get_id() ) ) {
		return array();
	}
	$options = array();
	foreach ( $product->get_upsell_ids() as $id ) {
		$candidate = wc_get_product( $id );
		if ( noor_option_is_eligible( $candidate ) ) {
			$options[] = $candidate;
		}
	}
	return apply_filters( 'noor_rental_options', $options, $product );
}

/**
 * Length of a booking in days, counted the way the arch counts it.
 *
 * CAREFUL: noor_days_between() includes BOTH ends, because it feeds the
 * availability calendar, where the last day is genuinely occupied. The price
 * does not work that way — the tested behaviour is 1→5 sept = 4 jours = 25 €
 * and 10→15 sept = 5 jours = 50 €, i.e. the end date is not billed. Using the
 * calendar count here would bill every option one day too many.
 */
function noor_option_units( $from_key, $to_key ) {
	$days = count( noor_days_between( $from_key, $to_key ) ) - 1;
	return (int) max( 1, $days );
}

/**
 * What one option costs for a booking of $units days.
 *
 * flat    — the price as entered, once, whatever the length of the rental.
 * per_day — the price multiplied by the number of days actually booked. Note
 *           this is NOT the arch's 4-day forfait: "par jour" means per day, and
 *           billing an option in 4-day blocks would surprise the customer.
 */
function noor_option_total( $option_id, $units ) {
	$product = wc_get_product( $option_id );
	if ( ! $product ) {
		return 0.0;
	}
	$price = (float) $product->get_price();
	if ( 'per_day' !== noor_option_pricing_mode( $option_id ) ) {
		return $price;
	}
	$units = (int) max( 1, ceil( (float) $units ) );
	return $price * $units;
}

/* ==========================================================================
 * COMBO PRICING  (client's own accessory sheet, 08/09/2026)
 *
 * ACCESSOIRES pour Arches_.docx prices every arch the same way:
 *
 *     2 Drapés de 6m = 20 €
 *     Lot de 4 fleurs = 15 €
 *     si c'est les 2 = 25 €
 *
 * So taking BOTH costs 25 €, not 35 €. Without this, the module would charge
 * 20 + 15 and overcharge every customer who takes exactly the combination he
 * is actively promoting — the single most expensive bug in this feature.
 *
 * Stored on the PARENT rental, because the pair and the price are a property
 * of that arch's offer, not of either accessory on its own. Format:
 *
 *     _noor_option_combo = "SKU-A|SKU-B|25.00"
 *
 * Applied in the same absolute-price pass as everything else, so it stays
 * idempotent and needs no did_action() guard.
 * ========================================================================== */

/**
 * The combo rule for a rental, or false.
 *
 * @return array{a:string,b:string,price:float}|false
 */
function noor_option_combo( $parent_id ) {
	$raw = trim( (string) get_post_meta( (int) $parent_id, '_noor_option_combo', true ) );
	if ( '' === $raw ) {
		return false;
	}
	$parts = array_map( 'trim', explode( '|', $raw ) );
	if ( count( $parts ) < 3 || '' === $parts[0] || '' === $parts[1] || ! is_numeric( $parts[2] ) ) {
		return false;
	}
	return array(
		'a'     => $parts[0],
		'b'     => $parts[1],
		'price' => (float) $parts[2],
	);
}

/**
 * Cart keys of the two combo lines under one parent booking, when BOTH are present.
 *
 * Matching is by parent cart-item key, not by product, so two separate bookings
 * of the same arch each get their own combo — and a customer who ticked only
 * one accessory is never given the pair price.
 *
 * @return array<string> exactly two keys, or empty.
 */
function noor_option_combo_lines( $cart, $parent_key ) {
	$parent = $cart->get_cart_item( $parent_key );
	if ( ! $parent ) {
		return array();
	}
	$combo = noor_option_combo( $parent['product_id'] );
	if ( ! $combo ) {
		return array();
	}

	$found = array();
	foreach ( $cart->get_cart() as $key => $item ) {
		if ( empty( $item['noor_option_parent'] ) || $item['noor_option_parent'] !== $parent_key ) {
			continue;
		}
		$product = wc_get_product( $item['product_id'] );
		if ( ! $product ) {
			continue;
		}
		$sku = $product->get_sku();
		if ( $sku === $combo['a'] || $sku === $combo['b'] ) {
			$found[ $sku ] = $key;
		}
	}

	// Both halves, or nothing. A single accessory keeps its own price.
	if ( isset( $found[ $combo['a'] ], $found[ $combo['b'] ] ) ) {
		return array( $found[ $combo['a'] ], $found[ $combo['b'] ] );
	}
	return array();
}

/* ==========================================================================
 * ADMIN — the per-option setting
 * ========================================================================== */
add_action( 'woocommerce_product_options_general_product_data', function () {
	woocommerce_wp_select( array(
		'id'          => '_noor_option_pricing',
		'label'       => 'Tarif en option de location',
		'options'     => array(
			'flat'    => 'Pour toute la location (par défaut)',
			'per_day' => 'Par jour',
		),
		'description' => 'Utilisé quand ce produit est proposé en option sous une location (drapés, fleurs…). « Par jour » multiplie le prix par le nombre de jours réservés.',
		'desc_tip'    => true,
	) );
} );

/* Combo rule — on the rental itself, since the pair price belongs to its offer. */
add_action( 'woocommerce_product_options_general_product_data', function () {
	woocommerce_wp_text_input( array(
		'id'          => '_noor_option_combo',
		'label'       => 'Offre « les 2 options »',
		'placeholder' => 'SKU-DRAPES|SKU-FLEURS|25',
		'description' => 'Prix forfaitaire quand le client coche LES DEUX options indiquées. Format : SKU de la première | SKU de la seconde | prix. Exemple : 2 drapés 20 € + 4 fleurs 15 € mais 25 € les deux. Laisser vide pour facturer chaque option séparément.',
		'desc_tip'    => true,
	) );
} );

add_action( 'woocommerce_process_product_meta', function ( $post_id ) {
	$value = isset( $_POST['_noor_option_pricing'] ) ? sanitize_key( wp_unslash( $_POST['_noor_option_pricing'] ) ) : 'flat';
	update_post_meta( $post_id, '_noor_option_pricing', ( 'per_day' === $value ) ? 'per_day' : 'flat' );

	$combo = isset( $_POST['_noor_option_combo'] ) ? wc_clean( wp_unslash( $_POST['_noor_option_combo'] ) ) : '';
	update_post_meta( $post_id, '_noor_option_combo', $combo );
} );

/* ==========================================================================
 * FRONT — the tick boxes, under the dates
 * ========================================================================== */
add_action( 'woocommerce_before_add_to_cart_button', function () {
	global $product;
	if ( ! $product || ! noor_is_rental_product( $product->get_id() ) ) {
		return;
	}
	$options = noor_rental_options( $product );
	if ( ! $options ) {
		return;
	}
	?>
	<div class="noor-options">
		<h3 class="noor-options__title">Complétez votre location</h3>
		<p class="noor-options__hint">Cochez ce que vous souhaitez ajouter. <strong>Les dates sont reprises automatiquement</strong>, vous n’avez rien à ressaisir.</p>
		<ul class="noor-options__list">
			<?php foreach ( $options as $option ) : ?>
				<?php
				$mode  = noor_option_pricing_mode( $option->get_id() );
				$price = (float) $option->get_price();
				?>
				<li class="noor-options__item">
					<label>
						<input type="checkbox" name="noor_options[]" value="<?php echo esc_attr( $option->get_id() ); ?>">
						<?php if ( $option->get_image_id() ) : ?>
							<?php echo wp_kses_post( $option->get_image( 'woocommerce_gallery_thumbnail' ) ); ?>
						<?php endif; ?>
						<span class="noor-options__name"><?php echo esc_html( $option->get_name() ); ?></span>
						<span class="noor-options__price">
							+ <?php echo wp_kses_post( wc_price( $price ) ); ?><?php echo ( 'per_day' === $mode ) ? ' <em>/ jour</em>' : ''; ?>
						</span>
					</label>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
}, 40 ); // after the plugin's date block, before the deposit notice at 50

/* ==========================================================================
 * CART — attach the ticked options to the rental that was just added
 *
 * Runs on woocommerce_add_to_cart, i.e. AFTER the parent line exists, so the
 * parent's stored booking values can be read rather than re-parsed from POST.
 * A static guard stops the nested add_to_cart() calls re-entering this hook.
 * ========================================================================== */
add_action( 'woocommerce_add_to_cart', function ( $cart_item_key, $product_id ) {
	static $busy = false;

	if ( $busy || empty( $_POST['noor_options'] ) || ! noor_is_rental_product( $product_id ) ) {
		return;
	}
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return;
	}

	$cart   = WC()->cart;
	$parent = $cart->get_cart_item( $cart_item_key );
	if ( ! $parent ) {
		return;
	}

	// Dates as the booking plugin stored them on the parent line.
	$values = isset( $parent['mwb_mbfw_booking_values'] ) ? (array) $parent['mwb_mbfw_booking_values'] : array();
	$from   = '';
	$to     = '';
	foreach ( array( 'date_time_from', 'single_cal_date_time_from' ) as $field ) {
		if ( '' === $from && ! empty( $values[ $field ] ) ) {
			$from = (string) $values[ $field ];
		}
	}
	foreach ( array( 'date_time_to', 'single_cal_date_time_to' ) as $field ) {
		if ( '' === $to && ! empty( $values[ $field ] ) ) {
			$to = (string) $values[ $field ];
		}
	}

	$from_key = noor_date_key( $from );
	$to_key   = noor_date_key( $to );
	if ( '' === $from_key || '' === $to_key ) {
		return; // no usable dates: add nothing rather than guess
	}

	$units = noor_option_units( $from_key, $to_key );

	$allowed = array();
	$parent_product = wc_get_product( $product_id );
	foreach ( noor_rental_options( $parent_product ) as $option ) {
		$allowed[] = (int) $option->get_id();
	}

	$ticked = array_map( 'absint', (array) wp_unslash( $_POST['noor_options'] ) );

	$busy = true;
	foreach ( array_unique( $ticked ) as $option_id ) {
		// Only what this rental actually offers — never an arbitrary posted id.
		if ( ! in_array( $option_id, $allowed, true ) ) {
			continue;
		}
		$cart->add_to_cart(
			$option_id,
			1,
			0,
			array(),
			array(
				'noor_option_parent'    => $cart_item_key,
				'noor_option_parent_id' => (int) $product_id,
				'noor_option_from'      => $from,
				'noor_option_to'        => $to,
				'noor_option_units'     => $units,
			)
		);
	}
	$busy = false;
}, 20, 2 );

/* ---- Keep each option a distinct line per parent booking ---- */
add_filter( 'woocommerce_add_cart_item_data', function ( $data ) {
	if ( ! empty( $data['noor_option_parent'] ) ) {
		// Two bookings of the same arch with the same option must not merge.
		$data['noor_option_uniq'] = $data['noor_option_parent'] . '|' . $data['noor_option_from'] . '|' . $data['noor_option_to'];
	}
	return $data;
}, 20 );

/* ==========================================================================
 * PRICE — recomputed here, never trusted from the browser
 * ========================================================================== */
add_action( 'woocommerce_before_calculate_totals', function ( $cart ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}
	/* No did_action() >= 2 guard here on purpose. That guard belongs to code
	 * that adjusts a price *relatively* and would otherwise compound. This sets
	 * an absolute amount recomputed from meta, so running on every calculation
	 * is idempotent — and skipping later calculations, as that guard does, is
	 * what actually leaves stale prices in the cart. */
	// 1. every option at its own price
	foreach ( $cart->get_cart() as $item ) {
		if ( empty( $item['noor_option_parent'] ) || empty( $item['data'] ) ) {
			continue;
		}
		$units = isset( $item['noor_option_units'] ) ? (int) $item['noor_option_units'] : 1;
		$item['data']->set_price( noor_option_total( $item['product_id'], $units ) );
	}

	// 2. then re-price the pairs. The combo total is put entirely on the first
	//    line and the second is zeroed, so the cart sums to exactly the price
	//    he advertises. Both lines are flagged so the display can explain it —
	//    a silent 0,00 € line looks like a bug to a customer.
	$parents = array();
	foreach ( $cart->get_cart() as $item ) {
		if ( ! empty( $item['noor_option_parent'] ) ) {
			$parents[ $item['noor_option_parent'] ] = true;
		}
	}
	foreach ( array_keys( $parents ) as $parent_key ) {
		$pair = noor_option_combo_lines( $cart, $parent_key );
		if ( ! $pair ) {
			continue;
		}
		$parent = $cart->get_cart_item( $parent_key );
		$combo  = noor_option_combo( $parent['product_id'] );

		$first  = $cart->get_cart_item( $pair[0] );
		$second = $cart->get_cart_item( $pair[1] );
		if ( ! $first || ! $second ) {
			continue;
		}
		$full = (float) $first['data']->get_price() + (float) $second['data']->get_price();

		$first['data']->set_price( $combo['price'] );
		$second['data']->set_price( 0 );

		$cart->cart_contents[ $pair[0] ]['noor_combo_role']  = 'lead';
		$cart->cart_contents[ $pair[0] ]['noor_combo_full']  = $full;
		$cart->cart_contents[ $pair[0] ]['noor_combo_price'] = $combo['price'];
		$cart->cart_contents[ $pair[1] ]['noor_combo_role']  = 'included';
	}
}, 20 );

/* ==========================================================================
 * DISPLAY — cart, checkout, order and e-mails
 * ========================================================================== */
add_filter( 'woocommerce_get_item_data', function ( $item_data, $cart_item ) {
	if ( empty( $cart_item['noor_option_parent_id'] ) ) {
		return $item_data;
	}

	$item_data[] = array(
		'key'   => 'Option de',
		'value' => get_the_title( (int) $cart_item['noor_option_parent_id'] ),
	);

	// Same wording and the same French formatting as the parent rental line.
	$from = noor_format_booking_date( (string) $cart_item['noor_option_from'] );
	$to   = noor_format_booking_date( (string) $cart_item['noor_option_to'] );
	if ( '' !== $from && '' !== $to ) {
		$item_data[] = array(
			'key'   => 'Période de location',
			'value' => sprintf( 'du %s au %s', $from, $to ),
		);
	}

	// The combo, said out loud. A customer who sees 0,00 € with no explanation
	// assumes the site is broken, not that they saved 10 €.
	if ( ! empty( $cart_item['noor_combo_role'] ) ) {
		if ( 'lead' === $cart_item['noor_combo_role'] ) {
			$item_data[] = array(
				'key'   => 'Offre 2 options',
				'value' => sprintf(
					'%s au lieu de %s — vous économisez %s',
					wp_strip_all_tags( wc_price( (float) $cart_item['noor_combo_price'] ) ),
					wp_strip_all_tags( wc_price( (float) $cart_item['noor_combo_full'] ) ),
					wp_strip_all_tags( wc_price( max( 0, (float) $cart_item['noor_combo_full'] - (float) $cart_item['noor_combo_price'] ) ) )
				),
			);
		} else {
			$item_data[] = array(
				'key'   => 'Offre 2 options',
				'value' => 'Compris dans le forfait 2 options ci-dessus',
			);
		}
	}

	if ( 'per_day' === noor_option_pricing_mode( $cart_item['product_id'] ) ) {
		$units = isset( $cart_item['noor_option_units'] ) ? (int) $cart_item['noor_option_units'] : 1;
		$item_data[] = array(
			'key'   => 'Tarif',
			'value' => sprintf( '%d jour%s', $units, $units > 1 ? 's' : '' ),
		);
	}

	return $item_data;
}, 10, 2 );

/* ---- Carry it onto the order line, so it survives into e-mails ---- */
add_action( 'woocommerce_checkout_create_order_line_item', function ( $item, $cart_item_key, $values ) {
	if ( empty( $values['noor_option_parent_id'] ) ) {
		return;
	}
	$item->add_meta_data( 'Option de', get_the_title( (int) $values['noor_option_parent_id'] ), true );

	$from = noor_format_booking_date( (string) $values['noor_option_from'] );
	$to   = noor_format_booking_date( (string) $values['noor_option_to'] );
	if ( '' !== $from && '' !== $to ) {
		$item->add_meta_data( 'Période de location', sprintf( 'du %s au %s', $from, $to ), true );
	}
}, 10, 3 );

/* ==========================================================================
 * INTEGRITY — an option must never outlive its rental
 *
 * The deposit is deliberately NOT touched: noor_cart_deposit_total() sums lines
 * carrying noor_deposit_ack, which only the rental itself has. So ticking three
 * options does not add three deposits — that falls out of the existing design
 * rather than needing a special case here.
 * ========================================================================== */
add_action( 'woocommerce_cart_item_removed', function ( $removed_key, $cart ) {
	foreach ( $cart->get_cart() as $key => $item ) {
		if ( ! empty( $item['noor_option_parent'] ) && $item['noor_option_parent'] === $removed_key ) {
			$cart->remove_cart_item( $key );
		}
	}
}, 10, 2 );

add_action( 'woocommerce_check_cart_items', function () {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return;
	}
	$cart = WC()->cart;
	foreach ( $cart->get_cart() as $item ) {
		if ( empty( $item['noor_option_parent'] ) ) {
			continue;
		}
		if ( ! $cart->get_cart_item( $item['noor_option_parent'] ) ) {
			wc_add_notice(
				sprintf(
					'« %s » était une option de votre location. La location ayant été retirée, l’option a été retirée aussi.',
					$item['data']->get_name()
				),
				'notice'
			);
			$cart->remove_cart_item( $item['key'] );
		}
	}
} );
