<?php
/**
 * NOOR — Multi-region system.
 *
 * Regions: re (Réunion) · yt (Mayotte) · fr (France/EU — launches empty).
 * - "Régions" taxonomy on products (which regions may see a product)
 * - Detection: cookie → IP (WooCommerce geolocation) → default fr
 * - /re/ /yt/ /fr/ landing URLs (crawlable, set region, then send to home)
 * - [noor_region_switcher] header shortcode
 * - Catalog filtering per region; rental category hidden outside RE
 * - /fr/ thin catalog → noindex + coming-soon notice
 */

defined( 'ABSPATH' ) || exit;

define( 'NOOR_REGION_COOKIE', 'noor_region' );

function noor_regions() {
	return array(
		're' => array( 'flag' => '🇷🇪', 'label' => 'Réunion',     'desc' => 'Livraison locale + Location' ),
		'yt' => array( 'flag' => '🇾🇹', 'label' => 'Mayotte',     'desc' => 'Catalogue Mayotte' ),
		'fr' => array( 'flag' => '🇫🇷', 'label' => 'France / EU', 'desc' => 'Livraison 3–5 jours' ),
	);
}

/* --------------------------------------------------------------------------
 * Taxonomy — tag products with the regions allowed to see them
 * ------------------------------------------------------------------------ */
add_action( 'init', function () {
	register_taxonomy( 'noor_region', 'product', array(
		'label'             => 'Régions',
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'hierarchical'      => true, // checkbox UI in product editor
		'rewrite'           => false,
	) );

	// Seed the three terms once.
	foreach ( noor_regions() as $slug => $r ) {
		if ( ! term_exists( $slug, 'noor_region' ) ) {
			wp_insert_term( $r['label'], 'noor_region', array( 'slug' => $slug ) );
		}
	}
} );

/* --------------------------------------------------------------------------
 * Landing URLs: /re/ /yt/ /fr/  (crawlable; set cookie then continue)
 * ------------------------------------------------------------------------ */
add_action( 'init', function () {
	add_rewrite_rule( '^(re|yt|fr)/?$', 'index.php?noor_region_land=$matches[1]', 'top' );
} );
add_filter( 'query_vars', function ( $vars ) {
	$vars[] = 'noor_region_land';
	return $vars;
} );

/* --------------------------------------------------------------------------
 * Current region resolution
 * ------------------------------------------------------------------------ */
function noor_current_region() {
	static $region = null;
	if ( null !== $region ) {
		return $region;
	}

	// 1) Explicit switch (?noor_switch=re) — handled in template_redirect too.
	if ( isset( $_GET['noor_switch'] ) && array_key_exists( $_GET['noor_switch'], noor_regions() ) ) {
		return $region = sanitize_key( $_GET['noor_switch'] );
	}
	// 2) Cookie.
	if ( isset( $_COOKIE[ NOOR_REGION_COOKIE ] ) && array_key_exists( $_COOKIE[ NOOR_REGION_COOKIE ], noor_regions() ) ) {
		return $region = sanitize_key( $_COOKIE[ NOOR_REGION_COOKIE ] );
	}
	// 3) IP geolocation via WooCommerce (works on any host, no extra plugin).
	if ( class_exists( 'WC_Geolocation' ) ) {
		$geo     = WC_Geolocation::geolocate_ip();
		$country = isset( $geo['country'] ) ? strtoupper( $geo['country'] ) : '';
		if ( 'RE' === $country ) { return $region = 're'; }
		if ( 'YT' === $country ) { return $region = 'yt'; }
	}
	// 4) Default: international → fr.
	return $region = 'fr';
}

function noor_set_region_cookie( $region ) {
	if ( ! headers_sent() && array_key_exists( $region, noor_regions() ) ) {
		setcookie( NOOR_REGION_COOKIE, $region, time() + YEAR_IN_SECONDS, '/', '', is_ssl(), false );
		$_COOKIE[ NOOR_REGION_COOKIE ] = $region;
	}
}

add_action( 'template_redirect', function () {
	// /re/ /yt/ /fr/ landing → set cookie, go home.
	$land = get_query_var( 'noor_region_land' );
	if ( $land ) {
		noor_set_region_cookie( $land );
		wp_safe_redirect( home_url( '/' ), 302 );
		exit;
	}
	// Manual switch from the header dropdown.
	if ( isset( $_GET['noor_switch'] ) && array_key_exists( $_GET['noor_switch'], noor_regions() ) ) {
		noor_set_region_cookie( sanitize_key( $_GET['noor_switch'] ) );
		wp_safe_redirect( remove_query_arg( 'noor_switch' ), 302 );
		exit;
	}
	// First visit, no cookie yet → persist detected region.
	if ( ! isset( $_COOKIE[ NOOR_REGION_COOKIE ] ) ) {
		noor_set_region_cookie( noor_current_region() );
	}
}, 5 );

/* --------------------------------------------------------------------------
 * Header switcher — [noor_region_switcher]
 * ------------------------------------------------------------------------ */
add_shortcode( 'noor_region_switcher', function () {
	$current = noor_current_region();
	$regions = noor_regions();
	$cur     = $regions[ $current ];

	$html  = '<div class="noor-region-switcher">';
	$html .= '<button type="button" aria-haspopup="true">' . $cur['flag'] . ' <span>' . esc_html( $cur['label'] ) . '</span> ▾</button>';
	$html .= '<div class="noor-region-menu">';
	foreach ( $regions as $slug => $r ) {
		$url    = esc_url( add_query_arg( 'noor_switch', $slug ) );
		$active = $slug === $current ? ' class="active"' : '';
		$html  .= '<a href="' . $url . '"' . $active . '>' . $r['flag'] . ' <span>' . esc_html( $r['label'] ) . '<small>' . esc_html( $r['desc'] ) . '</small></span></a>';
	}
	$html .= '</div></div>';
	return $html;
} );

/* --------------------------------------------------------------------------
 * Catalog filtering — products must carry the current region's term.
 * Products with NO region term are treated as visible everywhere.
 * ------------------------------------------------------------------------ */
add_action( 'woocommerce_product_query', function ( $q ) {
	if ( is_admin() ) {
		return;
	}
	$region    = noor_current_region();
	$tax_query = (array) $q->get( 'tax_query' );

	$tax_query[] = array(
		'relation' => 'OR',
		array( // tagged for this region
			'taxonomy' => 'noor_region',
			'field'    => 'slug',
			'terms'    => array( $region ),
		),
		array( // or not region-tagged at all
			'taxonomy' => 'noor_region',
			'operator' => 'NOT EXISTS',
		),
	);

	// Rental category exists ONLY in Réunion.
	if ( 're' !== $region ) {
		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => array( NOOR_RENTAL_CAT ),
			'operator' => 'NOT IN',
		);
	}
	$q->set( 'tax_query', $tax_query );
} );

// Direct-URL guard: a product not allowed in this region → 404-style redirect home.
add_action( 'template_redirect', function () {
	if ( ! is_singular( 'product' ) ) {
		return;
	}
	$region = noor_current_region();
	$id     = get_queried_object_id();

	$terms = wp_get_post_terms( $id, 'noor_region', array( 'fields' => 'slugs' ) );
	if ( ! is_wp_error( $terms ) && ! empty( $terms ) && ! in_array( $region, $terms, true ) ) {
		wp_safe_redirect( wc_get_page_permalink( 'shop' ), 302 );
		exit;
	}
	if ( 're' !== $region && has_term( NOOR_RENTAL_CAT, 'product_cat', $id ) ) {
		wp_safe_redirect( wc_get_page_permalink( 'shop' ), 302 );
		exit;
	}
}, 6 );

// Hide the rental category tile/menu entry outside RE.
add_filter( 'woocommerce_product_categories_widget_args', 'noor_hide_rental_cat_args' );
add_filter( 'woocommerce_product_subcategories_args', 'noor_hide_rental_cat_args' );
function noor_hide_rental_cat_args( $args ) {
	if ( 're' !== noor_current_region() ) {
		$term = get_term_by( 'slug', NOOR_RENTAL_CAT, 'product_cat' );
		if ( $term ) {
			$args['exclude'] = array_merge( (array) ( $args['exclude'] ?? array() ), array( $term->term_id ) );
		}
	}
	return $args;
}

/* --------------------------------------------------------------------------
 * Rental UI outside Réunion — hidden client-side, on purpose
 *
 * The catalogue filter above already keeps rental PRODUCTS out of every region
 * but Réunion. What it cannot touch is the promotional furniture: the homepage
 * rental banner, the hero button and the "Location" menu entry. Those live on
 * the home page and in the header, which ARE served from the full-page cache —
 * hiding them in PHP would bake one region into the cached copy and re-create
 * the bug where the first visitor decided what everybody else saw.
 *
 * So the elements are always rendered and always marked with `noor-rental-ui`,
 * and a tiny inline script reads the region cookie and puts a class on <html>.
 * The CSS below then hides them. Static markup, static CSS: the cached page is
 * valid for every region, and the decision happens in the visitor's browser.
 *
 * No cookie yet (first hit on a cached page, PHP never ran) → nothing is hidden.
 * ------------------------------------------------------------------------ */

/**
 * True when a URL points at the rental category.
 *
 * @param string $url Absolute or relative URL.
 * @return bool
 */
function noor_is_rental_url( $url ) {
	if ( ! $url ) {
		return false;
	}
	$path = trim( (string) wp_parse_url( $url, PHP_URL_PATH ), '/' );
	if ( '' === $path ) {
		return false;
	}
	$cat = NOOR_RENTAL_CAT;
	return (bool) preg_match( '#(^|/)(product-category|categorie-produit)/' . preg_quote( $cat, '#' ) . '$#', $path )
		|| preg_match( '#(^|/)' . preg_quote( $cat, '#' ) . '$#', $path );
}

/* Tag the "Location" entry in both menus (desktop nav + mobile drawer). */
add_filter( 'nav_menu_css_class', function ( $classes, $item ) {
	if ( ! is_admin() && ! empty( $item->url ) && noor_is_rental_url( $item->url ) ) {
		$classes[] = 'noor-rental-ui';
	}
	return $classes;
}, 10, 2 );

/* Inline on purpose — see the note above. Two separate rules because a browser
 * without `:has()` throws away the WHOLE rule it appears in, and the widget
 * fallback must survive that. */
add_action( 'wp_head', function () {
	if ( is_admin() ) {
		return;
	}
	?>
<script id="noor-region-class">(function(){var m=document.cookie.match(/(?:^|;\s*)noor_region=(re|yt|fr)/);if(!m){return}var d=document.documentElement;d.className+=' noor-region--'+m[1];if('re'!==m[1]){d.className+=' noor-no-rental'}})();</script>
<style id="noor-region-critical">
	.noor-no-rental .noor-rental-ui,
	.noor-no-rental .elementor-widget-noor_rental_banner{display:none !important}
	.noor-no-rental .elementor-section:has(.nfw-rental),
	.noor-no-rental .e-con:has(.nfw-rental),
	.noor-no-rental .elementor-widget-wrap:has(.nfw-rental){display:none !important}
</style>
	<?php
}, 2 );

/* --------------------------------------------------------------------------
 * /fr/ thin catalog → noindex + coming-soon message (Risk R3)
 * ------------------------------------------------------------------------ */
add_action( 'wp_head', function () {
	if ( 'fr' === noor_current_region() && ( is_shop() || is_product_category() ) ) {
		global $wp_query;
		if ( (int) $wp_query->found_posts < 4 ) { // thin → keep out of the index
			echo '<meta name="robots" content="noindex, follow">' . "\n";
		}
	}
}, 1 );

add_action( 'woocommerce_no_products_found', function () {
	if ( 'fr' === noor_current_region() ) {
		echo '<div class="noor-comingsoon"><h2>Bientôt disponible en France 🇫🇷</h2>'
			. '<p>Notre catalogue France/EU arrive très prochainement, in shâ Allah.<br>'
			. 'En attendant, découvrez nos collections livrées depuis La Réunion.</p></div>';
	}
}, 5 );

/* --------------------------------------------------------------------------
 * Page cache must vary by region
 *
 * The catalogue changes per region (rentals are Réunion-only), but a full-page
 * cache stores ONE copy per URL. Without this, whichever region was cached
 * first is served to everybody — which hid the rental products from every
 * logged-out visitor, Réunion included.
 *
 * `litespeed_vary_cookies` adds the cookie to LiteSpeed's cache key, so each
 * region gets its own cached copy. Harmless when LiteSpeed is not installed.
 * ------------------------------------------------------------------------ */
add_filter( 'litespeed_vary_cookies', function ( $cookies ) {
	$cookies[] = NOOR_REGION_COOKIE;
	return $cookies;
} );

/* Catalogue pages must not be served from the shared full-page cache.
 *
 * `litespeed_vary_cookies` above is the tidy solution, but it only works when
 * the server-level vary rule is actually in force — on this host it is not, and
 * the region of the first visitor was being served to everyone (rentals vanished for
 * Réunion customers). Correctness beats a cache hit on a 20-product catalogue,
 * so the region-dependent pages are marked non-cacheable. Everything else
 * (home, static pages, assets) still caches normally.
 *
 * If the host later confirms cookie-vary works, drop this and keep the filter. */
add_action( 'template_redirect', function () {
	$region_dependent = function_exists( 'is_woocommerce' )
		&& ( is_shop() || is_product_category() || is_product_tag() || is_product() );

	if ( $region_dependent || isset( $_GET['noor_switch'] ) ) {
		do_action( 'litespeed_control_set_nocache', 'Noor: region-dependent catalogue' );
	}
}, 4 );
