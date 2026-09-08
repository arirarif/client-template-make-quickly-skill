<?php
/**
 * Noor Festivities Child — Hello Elementor child theme.
 *
 * Header/footer are PHP (header.php / footer.php in this theme). Homepage and
 * landing pages stay normal Elementor pages using the custom widgets in
 * inc/elementor/. WooCommerce pages are skinned by assets/css/woocommerce.css.
 *
 * Structure:
 *   header.php / footer.php — site shell (announce bar, nav, espresso footer)
 *   inc/region.php    — multi-region system (/re/ /yt/ /fr/)
 *   inc/rental.php    — rental tweaks (RE-only, cash deposit)
 *   inc/upsells.php   — free-ship bar, cart add-ons, recently viewed
 *   inc/charity.php   — direct-to-charity widget
 *   inc/account.php   — My Account: Active Rentals
 *   inc/customizer.php — logos + announcement bar options (Apparence → Personnaliser)
 *   inc/marketing.php — WhatsApp float, lead popup, share buttons
 *   inc/elementor/    — custom Elementor widgets (homepage sections)
 *
 * @package noor
 */

defined( 'ABSPATH' ) || exit;

/* ==========================================================================
 * SETTINGS — edit these, nothing else, for day-to-day config
 * ========================================================================== */
define( 'NOOR_VERSION',              '3.21.0' ); // Bump on ANY file change (cache-busting).

// WhatsApp float
define( 'NOOR_WHATSAPP_NUMBER',      '262692000000' );                          // TODO real number (no +, country code first)
define( 'NOOR_WHATSAPP_MESSAGE',     'Salam ! Je visite noorfestivities.com et j’ai une question.' );

// Free-shipping progress bar (per region, in €)
define( 'NOOR_FREESHIP_RE',          50 );
define( 'NOOR_FREESHIP_YT',          80 );
define( 'NOOR_FREESHIP_FR',          70 );

// Lead popup
define( 'NOOR_POPUP_DELAY_MS',       9000 );      // show after 9s
define( 'NOOR_POPUP_COOKIE_DAYS',    14 );        // don't re-show for 14 days
define( 'NOOR_POPUP_DISCOUNT_CODE',  'BIENVENUE10' ); // must exist in WooCommerce → Coupons

// Charity (mode 'link' until the association's Stripe info arrives — see inc/charity.php)
define( 'NOOR_CHARITY_NAME',         'Association partenaire' );               // TODO real name
define( 'NOOR_CHARITY_URL',          'https://example.org/don' );              // TODO real donation URL
define( 'NOOR_CHARITY_MODE',         'link' );    // 'link' | 'stripe' (future)

// Default cash deposit for rentals, in EUR (override per product in the product data)
define( 'NOOR_DEPOSIT_DEFAULT',      50 );  // client 16/08/2026: 50 €, was 150

// Show a "only N left" notice once the stock drops BELOW this number
define( 'NOOR_LOW_STOCK',            5 );

// Percentage off an add-on bought inside a "Souvent acheté ensemble" pack
// (override per product with the "Remise pack (%)" field in the product data)
define( 'NOOR_BUNDLE_DISCOUNT',      15 );

// Rental category slug (products in this category are treated as rentals)
define( 'NOOR_RENTAL_CAT',           'location' );

/* ==========================================================================
 * SETUP
 * ========================================================================== */
/* Hello Elementor prints the page title above content — the design never shows it. */
add_filter( 'hello_elementor_page_title', '__return_false' );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'noor-main'   => __( 'Noor — Navigation principale', 'noor' ),
			'noor-footer' => __( 'Noor — Liens pied de page', 'noor' ),
		)
	);
} );

/* NOTE: WordPress replaces emoji with images served from s.w.org, and those do
 * load correctly here. Do NOT disable that: Windows cannot draw regional flag
 * emoji from its own fonts, so the region switcher would fall back to showing
 * the bare letters "RE" / "FR" instead of the flags. */

/**
 * True on any WooCommerce-driven front-end page.
 *
 * @return bool
 */
function noor_is_woo_page() {
	if ( ! function_exists( 'is_woocommerce' ) ) {
		return false;
	}
	return is_woocommerce() || is_cart() || is_checkout() || is_account_page() || is_wc_endpoint_url();
}

/* ==========================================================================
 * STYLES & SCRIPTS
 * ========================================================================== */
add_action( 'wp_enqueue_scripts', function () {
	$uri = get_stylesheet_directory_uri();

	// Brand fonts — Playfair Display stands in for Ragara until the webfont
	// license is confirmed; Open Sans is the official body font.
	wp_enqueue_style(
		'noor-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=Open+Sans:wght@300;400;600;700&display=swap',
		array(), null
	);

	// Tokens + base + header/footer + module styles.
	wp_enqueue_style( 'noor-child', $uri . '/assets/css/noor.css', array( 'noor-fonts' ), NOOR_VERSION );

	// Custom Elementor widget styles (also loaded in the Elementor editor via inc/elementor).
	wp_enqueue_style( 'noor-widgets', $uri . '/assets/css/noor-widgets.css', array( 'noor-child' ), NOOR_VERSION );

	// Shop layouts — loaded everywhere: the homepage "Produits Vedettes" grid
	// uses the [products] shortcode, which needs the same product-card styles.
	wp_enqueue_style( 'noor-woocommerce', $uri . '/assets/css/woocommerce.css', array( 'noor-child' ), NOOR_VERSION );

	// Light skin (client POINT 0). Must load LAST — it overrides tokens and
	// surfaces from all three sheets above. Scoped to html.noor-light, so
	// shipping it to everyone costs nothing until the class is present.
	wp_enqueue_style( 'noor-light', $uri . '/assets/css/noor-light.css', array( 'noor-woocommerce' ), NOOR_VERSION );

	wp_enqueue_script( 'noor-js', $uri . '/assets/noor.js', array(), NOOR_VERSION, true );
	wp_localize_script( 'noor-js', 'NOOR_CFG', array(
		'popupDelay'      => NOOR_POPUP_DELAY_MS,
		'popupCookieDays' => NOOR_POPUP_COOKIE_DAYS,
		'ajaxUrl'         => admin_url( 'admin-ajax.php' ),
	) );
}, 20 );

/* ==========================================================================
 * LIGHT SKIN  (client POINT 0, 03/09/2026)
 *
 * Adds html.noor-light, which is what assets/css/noor-light.css hangs off.
 *
 * WHY THE TOGGLE IS ADMIN-ONLY, and must stay that way:
 * this site is behind LiteSpeed full-page cache. In early August we hid the
 * rental blocks server-side per region; the France copy of the homepage got
 * cached and then served to Réunion visitors, and the rentals disappeared
 * for everyone. A server-rendered light/dark switch is the SAME BUG — the
 * first variant a crawler warms is the variant every anonymous visitor gets.
 *
 * So the response varies only for logged-in administrators, who bypass the
 * page cache anyway. Anonymous traffic always receives exactly one variant,
 * chosen by NOOR_LIGHT_DEFAULT. When the client approves the light skin,
 * flip that constant to true and the whole site moves together — still one
 * variant, still cache-safe. The query parameter stays as the preview and
 * revert switch.
 * ========================================================================== */
define( 'NOOR_LIGHT_DEFAULT', true ); // client POINT 0 — light is now the site

function noor_light_skin_active() {
	$active = NOOR_LIGHT_DEFAULT;

	// Administrators only — see the cache note above.
	if ( current_user_can( 'manage_options' ) && isset( $_GET['noor_theme'] ) ) {
		$active = ( 'light' === sanitize_key( wp_unslash( $_GET['noor_theme'] ) ) );
	}

	return (bool) $active;
}

add_filter( 'language_attributes', function ( $output ) {
	if ( ! noor_light_skin_active() ) {
		return $output;
	}

	// language_attributes() emits attributes only, no class= of its own,
	// so appending one is safe here.
	return $output . ' class="noor-light"';
} );

/* ==========================================================================
 * MODULES
 * ========================================================================== */
foreach ( array( 'customizer', 'region', 'shop', 'wishlist', 'bundle', 'addons', 'rental', 'rental-options', 'upsells', 'charity', 'account', 'marketing' ) as $noor_module ) {
	$noor_file = get_stylesheet_directory() . '/inc/' . $noor_module . '.php';
	if ( file_exists( $noor_file ) ) {
		require_once $noor_file;
	}
}

/* Elementor widgets (self-guarding: shows an admin notice if Elementor is inactive). */
require_once get_stylesheet_directory() . '/inc/elementor/class-noor-elementor.php';
