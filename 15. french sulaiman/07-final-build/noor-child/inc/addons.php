<?php
/**
 * NOOR — Products sold only as an add-on.
 *
 * Some articles only make sense next to something else (a refill, a matching
 * accessory). The client asked that they cannot be bought on their own.
 *
 * Marked with one checkbox on the product, such an article:
 *   - stays out of the shop, the categories and the search results;
 *   - keeps its own page, so a link still works, but the buy button is
 *     replaced by a note pointing at the products it goes with;
 *   - refuses a direct add to cart;
 *   - can still be ticked inside "Souvent acheté ensemble" (see inc/bundle.php);
 *   - blocks the order if it somehow ends up alone in the cart, rather than
 *     quietly deleting the customer's line.
 *
 * @package Noor_Child
 */

defined( 'ABSPATH' ) || exit;

/** Is this product sold only alongside another one? */
function noor_is_addon_only( $product_id ) {
	return 'yes' === get_post_meta( (int) $product_id, '_noor_addon_only', true );
}

/** Products that offer this one as a complement, for the explanatory note. */
function noor_addon_parents( $addon_id ) {
	$parents = get_transient( 'noor_addon_parents_' . (int) $addon_id );
	if ( is_array( $parents ) ) {
		return $parents;
	}
	$parents = array();
	$query   = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 60,
		'fields'         => 'ids',
		'no_found_rows'  => true,
	) );
	foreach ( $query->posts as $candidate_id ) {
		$candidate = wc_get_product( $candidate_id );
		if ( $candidate && in_array( (int) $addon_id, array_map( 'absint', $candidate->get_upsell_ids() ), true ) ) {
			$parents[] = $candidate_id;
		}
	}
	set_transient( 'noor_addon_parents_' . (int) $addon_id, $parents, 6 * HOUR_IN_SECONDS );
	return $parents;
}

add_action( 'woocommerce_update_product', function () {
	global $wpdb;
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_noor_addon_parents_%' OR option_name LIKE '_transient_timeout_noor_addon_parents_%'" );
} );

/* ---- Admin: the switch ---- */
add_action( 'woocommerce_product_options_general_product_data', function () {
	woocommerce_wp_checkbox( array(
		'id'          => '_noor_addon_only',
		'label'       => 'Vendu uniquement en complément',
		'description' => 'L’article n’apparaît plus dans la boutique et ne peut pas être acheté seul. Il reste proposé dans « Souvent acheté ensemble » des produits qui le listent en vente incitative.',
		'desc_tip'    => true,
	) );
}, 50 );

add_action( 'woocommerce_process_product_meta', function ( $post_id ) {
	update_post_meta( $post_id, '_noor_addon_only', isset( $_POST['_noor_addon_only'] ) ? 'yes' : 'no' );
}, 50 );

/** All add-on-only product ids. */
function noor_addon_only_ids() {
	$ids = get_transient( 'noor_addon_only_ids' );
	if ( is_array( $ids ) ) {
		return $ids;
	}
	$ids = get_posts( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => 100,
		'fields'         => 'ids',
		'meta_key'       => '_noor_addon_only',
		'meta_value'     => 'yes',
	) );
	$ids = array_map( 'absint', (array) $ids );
	set_transient( 'noor_addon_only_ids', $ids, 6 * HOUR_IN_SECONDS );
	return $ids;
}

add_action( 'woocommerce_update_product', function () {
	delete_transient( 'noor_addon_only_ids' );
} );

/* ---- Keep them out of the catalogue and the search ---- */
add_action( 'woocommerce_product_query', function ( $query ) {
	$ids = noor_addon_only_ids();
	if ( ! $ids ) {
		return;
	}
	$excluded = (array) $query->get( 'post__not_in' );
	$query->set( 'post__not_in', array_merge( $excluded, $ids ) );
}, 30 );

add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}
	$ids = noor_addon_only_ids();
	if ( $ids ) {
		$query->set( 'post__not_in', array_merge( (array) $query->get( 'post__not_in' ), $ids ) );
	}
} );

/* Also keep them out of the automatic "Vous aimerez aussi" row. */
add_filter( 'woocommerce_related_products', function ( $related ) {
	$ids = noor_addon_only_ids();
	return $ids ? array_values( array_diff( (array) $related, $ids ) ) : $related;
}, 20 );

/* ---- The product page says how to get it ---- */
add_action( 'wp', function () {
	if ( ! is_singular( 'product' ) || ! noor_is_addon_only( get_the_ID() ) ) {
		return;
	}
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

	add_action( 'woocommerce_single_product_summary', function () {
		$parents = noor_addon_parents( get_the_ID() );
		?>
		<div class="noor-addon-only">
			<strong>Cet article est vendu en complément.</strong>
			<?php if ( $parents ) : ?>
				<p>Ajoutez-le depuis la fiche de l’un de ces produits, dans l’encadré « Souvent acheté ensemble »&nbsp;:</p>
				<ul>
					<?php foreach ( array_slice( $parents, 0, 4 ) as $parent_id ) : ?>
						<li><a href="<?php echo esc_url( get_permalink( $parent_id ) ); ?>"><?php echo esc_html( get_the_title( $parent_id ) ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<p>Il sera proposé automatiquement avec les produits auxquels il est associé.</p>
			<?php endif; ?>
		</div>
		<?php
	}, 30 );
} );

/* ---- Refuse a direct add to cart ---- */
add_filter( 'woocommerce_add_to_cart_validation', function ( $passed, $product_id ) {
	if ( ! $passed || ! noor_is_addon_only( $product_id ) ) {
		return $passed;
	}
	// Allowed when it arrives through the pack box of another product.
	$from_bundle = isset( $_POST['noor_bundle'] )
		&& in_array( (int) $product_id, array_map( 'absint', (array) wp_unslash( $_POST['noor_bundle'] ) ), true );
	if ( $from_bundle ) {
		return $passed;
	}
	wc_add_notice(
		sprintf(
			'« %s » est vendu uniquement en complément d’un autre article. Ajoutez-le depuis la fiche du produit principal.',
			get_the_title( $product_id )
		),
		'error'
	);
	return false;
}, 30, 2 );

/* ---- Last line of defence: it must not travel alone ---- */
add_action( 'woocommerce_check_cart_items', function () {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return;
	}
	foreach ( WC()->cart->get_cart() as $item ) {
		if ( ! noor_is_addon_only( $item['product_id'] ) ) {
			continue;
		}
		$parent_present = ! empty( $item['noor_bundle_parent'] )
			&& function_exists( 'noor_bundle_parent_present' )
			&& noor_bundle_parent_present( $item['noor_bundle_parent'], WC()->cart );

		if ( $parent_present ) {
			continue;
		}
		wc_add_notice(
			sprintf(
				'« %s » ne peut pas être commandé seul. Ajoutez le produit auquel il est associé, ou retirez-le du panier.',
				$item['data']->get_name()
			),
			'error'
		);
	}
} );
