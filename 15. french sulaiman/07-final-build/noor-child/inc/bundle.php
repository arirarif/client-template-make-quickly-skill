<?php
/**
 * NOOR — "Souvent acheté ensemble" bundle.
 *
 * The client asked for a bundle offer whose price recalculates on its own. The
 * offer is conditional in the real sense: the reduced price only exists while
 * the main product is in the cart. Remove the main product and the add-ons go
 * back to their normal price on the spot, so the discount can never be farmed
 * by adding one cheap item and deleting the rest.
 *
 * The candidates are the complementary products already chosen in Linked
 * Products (see inc/shop.php), so the shop owner curates one list, not two.
 *
 * The price shown in the box is never trusted: the browser only posts which
 * boxes were ticked, and every amount is recomputed in PHP.
 *
 * @package Noor_Child
 */

defined( 'ABSPATH' ) || exit;

/** Percentage taken off an add-on when it travels with its parent. */
function noor_bundle_discount( $product_id ) {
	$own = get_post_meta( $product_id, '_noor_bundle_discount', true );
	$pct = '' !== $own ? (float) $own : ( defined( 'NOOR_BUNDLE_DISCOUNT' ) ? (float) NOOR_BUNDLE_DISCOUNT : 0 );
	return max( 0, min( 90, $pct ) );
}

/** Can this product be offered as a bundle add-on? */
function noor_bundle_addon_is_eligible( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return false;
	}
	// Rentals carry dates and a deposit; they cannot ride along silently.
	if ( function_exists( 'noor_is_rental_product' ) && noor_is_rental_product( $product->get_id() ) ) {
		return false;
	}
	// A variable product would need its options chosen, which the box cannot ask.
	return $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock();
}

/** The add-ons offered under a product, at most three. */
function noor_bundle_addons( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return array();
	}
	if ( function_exists( 'noor_is_rental_product' ) && noor_is_rental_product( $product->get_id() ) ) {
		return array();
	}
	$addons = array();
	foreach ( $product->get_upsell_ids() as $id ) {
		$candidate = wc_get_product( $id );
		if ( noor_bundle_addon_is_eligible( $candidate ) ) {
			$addons[] = $candidate;
		}
		if ( count( $addons ) >= 3 ) {
			break;
		}
	}
	return apply_filters( 'noor_bundle_addons', $addons, $product );
}

/** What an add-on costs inside the bundle. */
function noor_bundle_addon_price( $addon, $parent_id ) {
	$full     = (float) $addon->get_price();
	$discount = noor_bundle_discount( $parent_id );
	return round( $full * ( 1 - $discount / 100 ), wc_get_price_decimals() );
}

/* ---- Admin: the discount for this product's pack ---- */
add_action( 'woocommerce_product_options_general_product_data', function () {
	woocommerce_wp_text_input( array(
		'id'                => '_noor_bundle_discount',
		'label'             => 'Remise pack (%)',
		'description'       => 'Remise appliquée aux articles ajoutés depuis « Souvent acheté ensemble ». Vide = valeur par défaut du site.',
		'desc_tip'          => true,
		'type'              => 'number',
		'custom_attributes' => array( 'step' => '1', 'min' => '0', 'max' => '90' ),
	) );
}, 40 );

add_action( 'woocommerce_process_product_meta', function ( $post_id ) {
	$value = isset( $_POST['_noor_bundle_discount'] ) ? wc_clean( wp_unslash( $_POST['_noor_bundle_discount'] ) ) : '';
	update_post_meta( $post_id, '_noor_bundle_discount', $value );
}, 40 );

/* --------------------------------------------------------------------------
 * The box on the product page
 * ------------------------------------------------------------------------ */
add_action( 'woocommerce_before_add_to_cart_button', function () {
	global $product;
	if ( ! $product ) {
		return;
	}
	$addons = noor_bundle_addons( $product );
	if ( ! $addons ) {
		return;
	}
	$discount   = noor_bundle_discount( $product->get_id() );
	$base_price = (float) $product->get_price();
	?>
	<div class="noor-bundle" data-noor-bundle data-base="<?php echo esc_attr( $base_price ); ?>">
		<h3>Souvent acheté ensemble<?php echo $discount > 0 ? ' — ' . esc_html( sprintf( '%s%% sur les articles ajoutés', wc_format_localized_decimal( $discount ) ) ) : ''; ?></h3>

		<div class="noor-bundle-item noor-bundle-item--self">
			<input type="checkbox" checked disabled aria-label="<?php esc_attr_e( 'Ce produit', 'noor' ); ?>">
			<?php echo wp_kses_post( $product->get_image( 'woocommerce_gallery_thumbnail' ) ); ?>
			<span class="noor-bundle-info">
				<b><?php echo esc_html( $product->get_name() ); ?></b>
				<small>Ce produit</small>
			</span>
			<span class="noor-bundle-price" data-self-price><?php echo wp_kses_post( wc_price( $base_price ) ); ?></span>
		</div>

		<?php foreach ( $addons as $addon ) :
			$full   = (float) $addon->get_price();
			$bundle = noor_bundle_addon_price( $addon, $product->get_id() );
			?>
			<label class="noor-bundle-item">
				<input type="checkbox" name="noor_bundle[]" value="<?php echo esc_attr( $addon->get_id() ); ?>"
					data-price="<?php echo esc_attr( $bundle ); ?>" checked>
				<?php echo wp_kses_post( $addon->get_image( 'woocommerce_gallery_thumbnail' ) ); ?>
				<span class="noor-bundle-info">
					<b><?php echo esc_html( $addon->get_name() ); ?></b>
					<?php if ( $bundle < $full ) : ?>
						<small>Au lieu de <?php echo wp_kses_post( wc_price( $full ) ); ?> —
							<b><?php echo wp_kses_post( wc_price( $bundle ) ); ?> dans le pack</b></small>
					<?php endif; ?>
				</span>
				<span class="noor-bundle-price">
					<?php if ( $bundle < $full ) : ?><s><?php echo wp_kses_post( wc_price( $full ) ); ?></s><?php endif; ?>
					<?php echo wp_kses_post( wc_price( $bundle ) ); ?>
				</span>
			</label>
		<?php endforeach; ?>

		<div class="noor-bundle-total">
			<span>Total du pack</span>
			<span class="noor-bundle-total-value" data-bundle-total><?php echo wp_kses_post( wc_price( $base_price ) ); ?></span>
		</div>
	</div>
	<?php
}, 20 );

/* --------------------------------------------------------------------------
 * Adding the chosen add-ons alongside the parent
 * ------------------------------------------------------------------------ */
add_action( 'woocommerce_add_to_cart', function ( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
	// Only react to the customer's own add, never to the ones we make below.
	static $busy = false;
	if ( $busy || ! empty( $cart_item_data['noor_bundle_parent'] ) ) {
		return;
	}
	if ( empty( $_POST['noor_bundle'] ) ) {
		return;
	}

	$parent = wc_get_product( $product_id );
	if ( ! $parent ) {
		return;
	}
	$allowed = array();
	foreach ( noor_bundle_addons( $parent ) as $addon ) {
		$allowed[] = $addon->get_id();
	}
	$wanted = array_map( 'absint', (array) wp_unslash( $_POST['noor_bundle'] ) );

	$busy = true;
	foreach ( $wanted as $addon_id ) {
		// Ignore anything that was not on offer for this product.
		if ( ! in_array( $addon_id, $allowed, true ) ) {
			continue;
		}
		WC()->cart->add_to_cart( $addon_id, 1, 0, array(), array(
			'noor_bundle_parent' => (int) $product_id,
		) );
	}
	$busy = false;
}, 10, 6 );

/** A bundled line stays its own line rather than merging with a plain one.
 *
 * WooCommerce passes FIVE arguments here — id, product id, variation id,
 * variation, cart item data. Declaring a sixth throws an ArgumentCountError
 * and every add-to-cart on the site returns a 500.
 */
add_filter( 'woocommerce_cart_id', function ( $id, $product_id, $variation_id, $variation, $cart_item_data ) {
	if ( ! empty( $cart_item_data['noor_bundle_parent'] ) ) {
		$id = md5( $id . 'noor-bundle-' . $cart_item_data['noor_bundle_parent'] );
	}
	return $id;
}, 10, 5 );

/* --------------------------------------------------------------------------
 * The condition: the discount lives only while the parent is in the cart
 * ------------------------------------------------------------------------ */

/** Is the parent of this bundled line still in the cart? */
function noor_bundle_parent_present( $parent_id, $cart ) {
	foreach ( $cart->get_cart() as $item ) {
		if ( empty( $item['noor_bundle_parent'] ) && (int) $item['product_id'] === (int) $parent_id ) {
			return true;
		}
	}
	return false;
}

add_action( 'woocommerce_before_calculate_totals', function ( $cart ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}
	foreach ( $cart->get_cart() as $item ) {
		if ( empty( $item['noor_bundle_parent'] ) ) {
			continue;
		}
		if ( ! noor_bundle_parent_present( $item['noor_bundle_parent'], $cart ) ) {
			continue; // Parent gone: the line keeps its normal price.
		}
		$price = noor_bundle_addon_price( $item['data'], $item['noor_bundle_parent'] );
		$item['data']->set_price( $price );
	}
}, 30 );

/** Say why the line is cheaper, or why it stopped being cheaper. */
add_filter( 'woocommerce_get_item_data', function ( $item_data, $cart_item ) {
	if ( empty( $cart_item['noor_bundle_parent'] ) || ! function_exists( 'WC' ) || ! WC()->cart ) {
		return $item_data;
	}
	$parent = wc_get_product( $cart_item['noor_bundle_parent'] );
	$name   = $parent ? $parent->get_name() : '';

	if ( noor_bundle_parent_present( $cart_item['noor_bundle_parent'], WC()->cart ) ) {
		$discount    = noor_bundle_discount( $cart_item['noor_bundle_parent'] );
		$item_data[] = array(
			'key'   => 'Offre pack',
			'value' => $discount > 0
				? sprintf( '−%s%% avec « %s »', wc_format_localized_decimal( $discount ), $name )
				: sprintf( 'Ajouté avec « %s »', $name ),
		);
	} else {
		$item_data[] = array(
			'key'   => 'Offre pack',
			'value' => sprintf( 'Prix normal — « %s » n’est plus dans le panier', $name ),
		);
	}
	return $item_data;
}, 30, 2 );
