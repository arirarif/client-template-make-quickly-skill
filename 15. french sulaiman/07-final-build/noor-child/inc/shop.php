<?php
/**
 * NOOR — Shop archive: category sidebar and filters.
 *
 * The client asked for the categories to sit in a column on the left of the
 * shop, with filters, the way the mockup shows it. Hello Elementor ships no
 * shop sidebar, so the layout is opened around the product loop and the panel
 * is rendered here rather than through widgets — that keeps the markup and the
 * wording under our control.
 *
 * Price and rating filtering ride on WooCommerce native query vars
 * (min_price / max_price / rating_filter). Category, stock and sale filtering
 * are ours, applied in noor_shop_filter_query().
 *
 * @package Noor_Child
 */

defined( 'ABSPATH' ) || exit;

/** Shop, category or tag archive — the pages that get the sidebar. */
function noor_is_shop_archive() {
	return function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() );
}

/** Categories offered in the panel, minus plumbing and out-of-region ones. */
function noor_filter_categories() {
	$terms = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
	) );
	if ( is_wp_error( $terms ) ) {
		return array();
	}
	$hidden = array( 'booking', 'uncategorized', 'non-classe', 'non-classe-2' );
	// Rentals only exist on Reunion, so the category would lead nowhere else.
	if ( function_exists( 'noor_current_region' ) && 're' !== noor_current_region() ) {
		$hidden[] = defined( 'NOOR_RENTAL_CAT' ) ? NOOR_RENTAL_CAT : 'location';
	}
	$out = array();
	foreach ( $terms as $term ) {
		if ( ! in_array( $term->slug, $hidden, true ) ) {
			$out[] = $term;
		}
	}
	return $out;
}

/**
 * Front-end URL of a product category, by slug.
 *
 * Used by the homepage widgets so their default links land on a real listing
 * instead of a placeholder. Falls back to the conventional permalink when the
 * term does not exist yet, which keeps the editor usable on a fresh install.
 */
function noor_category_url( $slug ) {
	$term = get_term_by( 'slug', $slug, 'product_cat' );
	if ( $term && ! is_wp_error( $term ) ) {
		$link = get_term_link( $term );
		if ( ! is_wp_error( $link ) ) {
			return $link;
		}
	}
	return home_url( '/product-category/' . $slug . '/' );
}

/** Category slugs currently ticked. */
function noor_selected_categories() {
	$selected = isset( $_GET['noor_cat'] ) ? (array) wp_unslash( $_GET['noor_cat'] ) : array();
	$selected = array_map( 'sanitize_title', $selected );
	// Browsing a category archive counts as that category being selected.
	if ( ! $selected && is_product_category() ) {
		$term = get_queried_object();
		if ( $term && isset( $term->slug ) ) {
			$selected[] = $term->slug;
		}
	}
	return array_filter( $selected );
}

/** Highest product price in the shop, for the price field placeholder. */
function noor_shop_max_price() {
	$cached = get_transient( 'noor_shop_max_price' );
	if ( false !== $cached ) {
		return (float) $cached;
	}
	global $wpdb;
	$max = (float) $wpdb->get_var( "SELECT MAX(max_price) FROM {$wpdb->wc_product_meta_lookup}" );
	$max = $max > 0 ? ceil( $max ) : 500;
	set_transient( 'noor_shop_max_price', $max, DAY_IN_SECONDS );
	return $max;
}

/** True when any filter is active — drives the "clear" link. */
function noor_shop_has_filters() {
	foreach ( array( 'noor_cat', 'min_price', 'max_price', 'noor_stock', 'noor_sale', 'rating_filter' ) as $key ) {
		if ( isset( $_GET[ $key ] ) && '' !== $_GET[ $key ] ) {
			return true;
		}
	}
	return false;
}

/* --------------------------------------------------------------------------
 * Applying the filters to the product query
 * ------------------------------------------------------------------------ */
add_action( 'woocommerce_product_query', function ( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! noor_is_shop_archive() ) {
		return;
	}

	// Categories — merged into whatever region.php already put in place.
	$categories = isset( $_GET['noor_cat'] ) ? array_filter( array_map( 'sanitize_title', (array) wp_unslash( $_GET['noor_cat'] ) ) ) : array();
	if ( $categories ) {
		$tax_query   = (array) $query->get( 'tax_query' );
		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $categories,
			'operator' => 'IN',
		);
		$query->set( 'tax_query', $tax_query );
	}

	// In stock only.
	if ( ! empty( $_GET['noor_stock'] ) ) {
		$meta_query   = (array) $query->get( 'meta_query' );
		$meta_query[] = array(
			'key'   => '_stock_status',
			'value' => 'instock',
		);
		$query->set( 'meta_query', $meta_query );
	}

	// On sale only.
	if ( ! empty( $_GET['noor_sale'] ) ) {
		$on_sale = wc_get_product_ids_on_sale();
		$query->set( 'post__in', array_merge( array( 0 ), $on_sale ) );
	}
}, 20 );

/* --------------------------------------------------------------------------
 * The category chips above the grid
 * ------------------------------------------------------------------------ */
add_action( 'woocommerce_archive_description', function () {
	if ( ! noor_is_shop_archive() ) {
		return;
	}
	$categories = noor_filter_categories();
	if ( ! $categories ) {
		return;
	}
	$current = noor_selected_categories();
	$shop    = get_permalink( wc_get_page_id( 'shop' ) );
	?>
	<nav class="noor-chip-row" aria-label="Catégories">
		<a class="noor-chip<?php echo empty( $current ) ? ' is-active' : ''; ?>" href="<?php echo esc_url( $shop ); ?>">Tout</a>
		<?php foreach ( $categories as $term ) : ?>
			<a class="noor-chip<?php echo in_array( $term->slug, $current, true ) ? ' is-active' : ''; ?>"
			   href="<?php echo esc_url( get_term_link( $term ) ); ?>">
				<?php echo esc_html( $term->name ); ?>
			</a>
		<?php endforeach; ?>
	</nav>
	<?php
}, 20 );

/* --------------------------------------------------------------------------
 * Product cards: reveal the second photo on hover
 *
 * WooCommerce prints the thumbnail as a bare <img> inside the same link as the
 * title, so there is nothing to position a second image against. We swap that
 * output for the same image wrapped in a media box, with the first gallery
 * photo stacked on top of it and faded in on hover. Products without a gallery
 * simply keep one image.
 * ------------------------------------------------------------------------ */
add_action( 'init', function () {
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'noor_loop_product_media', 10 );
} );

function noor_loop_product_media() {
	global $product;
	if ( ! $product ) {
		return;
	}
	$primary = $product->get_image( 'woocommerce_thumbnail' );
	$gallery = $product->get_gallery_image_ids();
	$second  = '';
	if ( ! empty( $gallery[0] ) ) {
		$second = wp_get_attachment_image(
			$gallery[0],
			'woocommerce_thumbnail',
			false,
			array(
				'class'   => 'noor-card-media__alt',
				'alt'     => '',
				'aria-hidden' => 'true',
				'loading' => 'lazy',
			)
		);
	}
	echo '<span class="noor-card-media' . ( $second ? ' has-alt' : '' ) . '">'
		. wp_kses_post( $primary )
		. wp_kses_post( $second )
		. '</span>';
}

/* --------------------------------------------------------------------------
 * Low stock: say how few are left
 *
 * Only for products that actually track stock. Rentals are excluded on
 * purpose: their availability is a calendar question, handled in rental.php,
 * and WooCommerce decrements their stock on every booking, which would make
 * this notice lie.
 * ------------------------------------------------------------------------ */

/** Remaining units when the product is running low, otherwise 0. */
function noor_low_stock_count( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return 0;
	}
	if ( function_exists( 'noor_is_rental_product' ) && noor_is_rental_product( $product->get_id() ) ) {
		return 0;
	}
	if ( ! $product->managing_stock() || ! $product->is_in_stock() ) {
		return 0;
	}
	$quantity  = (int) $product->get_stock_quantity();
	$threshold = (int) apply_filters(
		'noor_low_stock_threshold',
		defined( 'NOOR_LOW_STOCK' ) ? NOOR_LOW_STOCK : 5,
		$product
	);
	return ( $quantity > 0 && $quantity < $threshold ) ? $quantity : 0;
}

/** Wording, singular and plural. */
function noor_low_stock_text( $left ) {
	return 1 === (int) $left
		? 'Dernier exemplaire disponible'
		: sprintf( 'Plus que %d exemplaires disponibles', (int) $left );
}

/* ---- Product page: under the price ---- */
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	$left = noor_low_stock_count( $product );
	if ( ! $left ) {
		return;
	}
	echo '<p class="noor-stock-low noor-stock-low--single">⚡ '
		. esc_html( noor_low_stock_text( $left ) )
		. '</p>';
}, 15 );

/* WooCommerce prints its own "3 en stock" line just below. Two sentences
 * saying the same thing reads as a mistake, so ours replaces it. */
add_filter( 'woocommerce_get_stock_html', function ( $html, $product ) {
	return noor_low_stock_count( $product ) ? '' : $html;
}, 10, 2 );

/* ---- Catalogue card: between the title and the price ---- */
add_action( 'woocommerce_after_shop_loop_item_title', function () {
	global $product;
	$left = noor_low_stock_count( $product );
	if ( ! $left ) {
		return;
	}
	echo '<span class="noor-stock-low noor-stock-low--loop">'
		. esc_html( noor_low_stock_text( $left ) )
		. '</span>';
}, 8 );

/* --------------------------------------------------------------------------
 * Reassurance row on the product page
 *
 * The four promises the client makes, shown where the customer hesitates:
 * right under the add-to-cart button. Drawn as inline SVG rather than emoji so
 * they take the brand colour and do not depend on an external image.
 *
 * The delivery line follows the chosen region, which is safe here because
 * product pages are excluded from the page cache (see inc/region.php).
 * ------------------------------------------------------------------------ */

/** The four promises, as icon + label. */
function noor_product_benefits() {
	$threshold = function_exists( 'noor_freeship_threshold' ) ? noor_freeship_threshold() : 0;
	$delivery  = $threshold > 0
		? sprintf( 'Livraison offerte dès %s', wp_strip_all_tags( wc_price( $threshold ) ) )
		: 'Livraison soignée et suivie';

	$benefits = array(
		array(
			'label' => $delivery,
			'icon'  => '<path d="M1 3h13v10H1z"/><path d="M14 6h4l3 3v4h-7z"/><circle cx="6" cy="18" r="2"/><circle cx="17.5" cy="18" r="2"/>',
		),
		array(
			'label' => 'Paiement 100 % sécurisé',
			'icon'  => '<rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/>',
		),
		array(
			'label' => 'Retours sous 14 jours',
			'icon'  => '<path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 4v5h5"/>',
		),
		array(
			'label' => 'Conseils sur WhatsApp 7j/7',
			'icon'  => '<path d="M21 11.5a8.4 8.4 0 0 1-12.3 7.5L3 21l2-5.7A8.4 8.4 0 1 1 21 11.5z"/>',
		),
	);

	return apply_filters( 'noor_product_benefits', $benefits );
}

add_action( 'woocommerce_single_product_summary', function () {
	$benefits = noor_product_benefits();
	if ( ! $benefits ) {
		return;
	}
	echo '<ul class="noor-benefits">';
	foreach ( $benefits as $benefit ) {
		printf(
			'<li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%s</svg><span>%s</span></li>',
			$benefit['icon'], // Trusted: defined above, not user input.
			esc_html( $benefit['label'] )
		);
	}
	echo '</ul>';
}, 36 );

/* --------------------------------------------------------------------------
 * Related and complementary products
 *
 * WooCommerce ships two blocks under a product: "upsells", which are the ones
 * the shop owner picks by hand in Linked Products, and "related", which
 * WooCommerce fills automatically from the same category. The first is the
 * "goes well with this" row the client asked for, so it is given the stronger
 * wording and shown first; the second stays as a gentle fallback.
 * ------------------------------------------------------------------------ */
add_filter( 'woocommerce_product_upsells_products_heading', function () {
	return 'Complétez votre décoration';
} );

add_filter( 'woocommerce_product_related_products_heading', function () {
	return 'Vous aimerez aussi';
} );

/* Four across, on one row, matching the shop grid. */
add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
} );

add_filter( 'woocommerce_upsell_display_args', function ( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
} );

/* Rentals are a different kind of purchase: suggesting them under a decoration
 * (or the other way round) is noise, and outside Reunion they are hidden
 * anyway. Keep both blocks inside their own world. */
add_filter( 'woocommerce_related_products', function ( $related, $product_id ) {
	$source_is_rental = function_exists( 'noor_is_rental_product' ) && noor_is_rental_product( $product_id );
	$filtered         = array();
	foreach ( (array) $related as $id ) {
		$is_rental = function_exists( 'noor_is_rental_product' ) && noor_is_rental_product( $id );
		if ( $is_rental === $source_is_rental ) {
			$filtered[] = $id;
		}
	}
	return $filtered ? $filtered : $related;
}, 10, 2 );

/* --------------------------------------------------------------------------
 * Rentals are Reunion-only: say so instead of showing an empty category
 *
 * The homepage and the menu link to the rental category for everyone. Hiding
 * those links per region would make the header region-dependent, which would
 * force the home page out of the page cache and bring back exactly the bug
 * fixed in region.php. Explaining it on arrival is cheaper and clearer.
 * ------------------------------------------------------------------------ */
add_action( 'woocommerce_archive_description', function () {
	$rental_cat = defined( 'NOOR_RENTAL_CAT' ) ? NOOR_RENTAL_CAT : 'location';
	if ( ! is_product_category( $rental_cat ) ) {
		return;
	}
	if ( ! function_exists( 'noor_current_region' ) || 're' === noor_current_region() ) {
		return;
	}
	?>
	<div class="noor-region-notice">
		<strong>Location de matériel — La Réunion uniquement.</strong>
		Le matériel se retire et se rend sur place, il n’est donc pas expédié hors de l’île.
		<a href="<?php echo esc_url( add_query_arg( 'noor_switch', 're', get_permalink( wc_get_page_id( 'shop' ) ) ) ); ?>">Passer sur le catalogue Réunion</a>
		ou <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>">voir la boutique</a>.
	</div>
	<?php
}, 30 );

/* --------------------------------------------------------------------------
 * Layout: sidebar on the left, loop on the right
 *
 * Opened around the loop rather than around the whole page so the archive
 * title stays full width. It has to open on the empty-results branch too,
 * otherwise a filter returning nothing would hide the very panel needed to
 * undo it.
 * ------------------------------------------------------------------------ */
function noor_shop_layout_open() {
	static $done = false;
	if ( $done || ! noor_is_shop_archive() ) {
		return;
	}
	$done = true;
	echo '<div class="noor-shop-layout">';
	noor_shop_sidebar();
	echo '<div class="noor-shop-main">';
	// Remember that the wrappers are open, so the closer knows to run.
	$GLOBALS['noor_shop_layout_open'] = true;
}
add_action( 'woocommerce_before_shop_loop', 'noor_shop_layout_open', 5 );
add_action( 'woocommerce_no_products_found', 'noor_shop_layout_open', 5 );

add_action( 'woocommerce_after_main_content', function () {
	if ( empty( $GLOBALS['noor_shop_layout_open'] ) ) {
		return;
	}
	echo '</div></div>';
	$GLOBALS['noor_shop_layout_open'] = false;
}, 5 );

/* --------------------------------------------------------------------------
 * The panel itself
 * ------------------------------------------------------------------------ */
function noor_shop_sidebar() {
	$categories = noor_filter_categories();
	$selected   = noor_selected_categories();
	$max_price  = noor_shop_max_price();
	$min_value  = isset( $_GET['min_price'] ) ? (float) wp_unslash( $_GET['min_price'] ) : '';
	$max_value  = isset( $_GET['max_price'] ) ? (float) wp_unslash( $_GET['max_price'] ) : '';
	$rating     = isset( $_GET['rating_filter'] ) ? (int) wp_unslash( $_GET['rating_filter'] ) : 0;
	$action     = is_product_category() || is_product_tag()
		? get_term_link( get_queried_object() )
		: get_permalink( wc_get_page_id( 'shop' ) );
	if ( is_wp_error( $action ) ) {
		$action = home_url( '/' );
	}
	?>
	<button type="button" class="noor-filter-toggle" aria-expanded="false">
		Filtrer les produits
	</button>

	<aside class="noor-filters" id="noor-filters">
		<form method="get" action="<?php echo esc_url( $action ); ?>">
			<?php if ( isset( $_GET['orderby'] ) ) : ?>
				<input type="hidden" name="orderby" value="<?php echo esc_attr( sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) ); ?>">
			<?php endif; ?>

			<?php if ( $categories && ! is_product_category() ) : ?>
				<h4>Catégories</h4>
				<?php foreach ( $categories as $term ) : ?>
					<label>
						<input type="checkbox" name="noor_cat[]" value="<?php echo esc_attr( $term->slug ); ?>"
							<?php checked( in_array( $term->slug, $selected, true ) ); ?>>
						<span><?php echo esc_html( $term->name ); ?></span>
						<span class="noor-facet-count"><?php echo esc_html( $term->count ); ?></span>
					</label>
				<?php endforeach; ?>
			<?php elseif ( $categories ) : ?>
				<h4>Catégories</h4>
				<?php foreach ( $categories as $term ) : ?>
					<a class="noor-filters-link<?php echo in_array( $term->slug, $selected, true ) ? ' is-active' : ''; ?>"
					   href="<?php echo esc_url( get_term_link( $term ) ); ?>">
						<span><?php echo esc_html( $term->name ); ?></span>
						<span class="noor-facet-count"><?php echo esc_html( $term->count ); ?></span>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>

			<h4>Prix</h4>
			<div class="noor-pricerange">
				<input type="number" name="min_price" min="0" step="1" inputmode="numeric"
					placeholder="0" value="<?php echo '' === $min_value ? '' : esc_attr( $min_value ); ?>">
				<span>—</span>
				<input type="number" name="max_price" min="0" step="1" inputmode="numeric"
					placeholder="<?php echo esc_attr( $max_price ); ?>" value="<?php echo '' === $max_value ? '' : esc_attr( $max_value ); ?>">
				<span>€</span>
			</div>

			<h4>Disponibilité</h4>
			<label>
				<input type="checkbox" name="noor_stock" value="1" <?php checked( ! empty( $_GET['noor_stock'] ) ); ?>>
				<span>En stock</span>
			</label>
			<label>
				<input type="checkbox" name="noor_sale" value="1" <?php checked( ! empty( $_GET['noor_sale'] ) ); ?>>
				<span>En promotion</span>
			</label>

			<h4>Note</h4>
			<label>
				<input type="checkbox" name="rating_filter" value="4" <?php checked( 4 === $rating ); ?>>
				<span>4 étoiles et plus</span>
			</label>

			<button type="submit" class="noor-btn noor-filters-apply">Appliquer</button>
			<?php if ( noor_shop_has_filters() ) : ?>
				<a class="noor-filters-clear" href="<?php echo esc_url( $action ); ?>">Effacer les filtres</a>
			<?php endif; ?>
		</form>
	</aside>
	<?php
}
