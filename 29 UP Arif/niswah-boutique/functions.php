<?php
/**
 * Niswah Boutique — Divi child theme.
 *
 * @package NiswahBoutique
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'NB_THEME_VERSION', '0.10.2' );
define( 'NB_THEME_DIR', get_stylesheet_directory() );
define( 'NB_THEME_URI', get_stylesheet_directory_uri() );

/**
 * Load the parent (Divi) stylesheet, then ours.
 *
 * Divi registers its stylesheet under the 'divi-style' handle. Depending on
 * that handle keeps our rules after Divi's in the cascade without needing
 * !important everywhere.
 *
 * The child stylesheet is enqueued with filemtime() so an edited file busts the
 * browser cache on its own. That is a safety net, not a substitute for bumping
 * the version: NB_THEME_VERSION and the "Version:" header in style.css must be
 * raised on every release, because WordPress's theme-replace flow and any host
 * or CDN cache (LiteSpeed and friends) key on the declared theme version, which
 * filemtime never touches. Keep the two values identical.
 */
function nb_enqueue_styles() {
	$parent_handle = 'divi-style';
	$child_css     = NB_THEME_DIR . '/style.css';

	wp_enqueue_style(
		$parent_handle,
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( get_template() )->get( 'Version' )
	);

	wp_enqueue_style(
		'niswah-boutique',
		NB_THEME_URI . '/style.css',
		array( $parent_handle ),
		file_exists( $child_css ) ? (string) filemtime( $child_css ) : NB_THEME_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'nb_enqueue_styles', 20 );

/**
 * Brand webfonts.
 *
 * Marcellus  — headings, echoes the condensed serif of the logo wordmark.
 * Jost       — body, geometric sans.
 * Cairo      — Arabic wordmark / any Arabic copy. Divi's Customizer only
 *              exposes one heading and one body font, so the Arabic face is
 *              loaded here and applied via the .nb-arabic helper class.
 *
 * display=swap so text paints immediately rather than blocking on the font.
 */
function nb_enqueue_fonts() {
	wp_enqueue_style(
		'niswah-fonts',
		'https://fonts.googleapis.com/css2'
			. '?family=Marcellus'
			. '&family=Jost:wght@300;400;500'
			. '&family=Cairo:wght@300;400;600'
			. '&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'nb_enqueue_fonts', 5 );

/**
 * Preconnect to the Google Fonts hosts so the font request starts earlier.
 */
function nb_font_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' !== $relation_type ) {
		return $urls;
	}

	$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
	$urls[] = array(
		'href'        => 'https://fonts.gstatic.com',
		'crossorigin' => 'anonymous',
	);

	return $urls;
}
add_filter( 'wp_resource_hints', 'nb_font_resource_hints', 10, 2 );

/**
 * Apply the Arabic face wherever Arabic copy is marked up.
 *
 * Usage in Divi: give the module the CSS class `nb-arabic`, or wrap the
 * Arabic run in <span class="nb-arabic">…</span> inside a Text module.
 */
function nb_arabic_font_css() {
	$css = '.nb-arabic, [lang="ar"] { font-family: "Cairo", "Noto Naskh Arabic", sans-serif; }';
	wp_add_inline_style( 'niswah-boutique', $css );
}
add_action( 'wp_enqueue_scripts', 'nb_arabic_font_css', 21 );

/**
 * Match Divi's content width to the measured design spec (1600px).
 *
 * Divi exposes this through the Customizer too; setting it here means a fresh
 * install of this theme starts at the right width instead of Divi's 1080px
 * default.
 */
function nb_default_content_width() {
	if ( false === get_theme_mod( 'et_pb_content_width', false ) ) {
		set_theme_mod( 'et_pb_content_width', '1600px' );
	}
}
add_action( 'after_switch_theme', 'nb_default_content_width' );

/**
 * WooCommerce: 4 products per row on the shop and category archives,
 * matching the reference grid.
 */
function nb_woo_loop_columns() {
	return 4;
}
add_filter( 'loop_shop_columns', 'nb_woo_loop_columns', 20 );

/**
 * Declare WooCommerce support so Woo stops warning about theme compatibility.
 */
function nb_declare_woo_support() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );

	// Deliberately NOT wc-product-gallery-slider. The reference product page
	// stacks every image vertically down the left column rather than showing one
	// image with thumbnails beneath it. Dropping slider support is what makes
	// WooCommerce render the gallery as a stack; lightbox stays, so clicking an
	// image still opens it full size the way the reference does.
}
add_action( 'after_setup_theme', 'nb_declare_woo_support' );

/**
 * Output the product's second image inside the shop-loop thumbnail.
 *
 * This is the one part of the reference card that CSS alone cannot produce.
 * Their cards contain two <img> elements and crossfade between them on hover;
 * WooCommerce's loop renders only the featured image, so the first gallery
 * image is appended here and style.css handles the fade.
 *
 * Products with no gallery keep a single image and simply do not swap — no
 * broken markup and no PHP notice.
 */
function nb_loop_second_image() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$gallery_ids = $product->get_gallery_image_ids();
	if ( empty( $gallery_ids ) ) {
		return;
	}

	$second = wp_get_attachment_image(
		$gallery_ids[0],
		'woocommerce_thumbnail',
		false,
		array(
			'class'       => 'nb-card__img nb-card__img--hover',
			'alt'         => '',
			'aria-hidden' => 'true',
			'loading'     => 'lazy',
		)
	);

	if ( $second ) {
		echo '<span class="nb-card__hover">' . $second . '</span>'; // phpcs:ignore WordPress.Security.EscapingOutput
	}
}
add_action( 'woocommerce_before_shop_loop_item_title', 'nb_loop_second_image', 11 );

/**
 * Wrap the loop thumbnail so the crossfade and the fixed 2:3 crop have a frame.
 *
 * WooCommerce fires the thumbnail on woocommerce_before_shop_loop_item_title at
 * priority 10, so opening at 9 and closing at 12 encloses both the featured
 * image and the hover image added above.
 */
function nb_card_media_open() {
	echo '<span class="nb-card__media">';
}
add_action( 'woocommerce_before_shop_loop_item_title', 'nb_card_media_open', 9 );

function nb_card_media_close() {
	echo '</span>';
}
add_action( 'woocommerce_before_shop_loop_item_title', 'nb_card_media_close', 12 );

/**
 * Move the add-to-cart button inside the image frame.
 *
 * Measured on the reference: the button is 430px wide inside a 460px card
 * (a 15px inset each side) and its baseline sits 26px BELOW the bottom of the
 * image. Both offsets are relative to the image, not the card, so leaving the
 * button where WooCommerce puts it — after the price, outside the media — makes
 * its position depend on however tall the title and price happen to render.
 * Relocating it into .nb-card__media lets CSS anchor it to the image exactly.
 */
function nb_move_loop_button_into_media() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 11 );
}
add_action( 'wp', 'nb_move_loop_button_into_media' );

/**
 * Loop button wording, matching the reference exactly.
 *
 * The reference renders "CHOOSE OPTIONS" on anything the shopper must configure
 * before buying — variable, grouped and external products all route to the
 * product page rather than adding straight to the cart — and "ADD TO CART" on
 * simple products. WooCommerce's defaults are "Select options" and "Add to
 * cart"; uppercasing is left to CSS so screen readers are not shouted at.
 */
function nb_loop_add_to_cart_text( $text, $product ) {
	if ( ! $product instanceof WC_Product ) {
		return $text;
	}

	if ( ! $product->is_purchasable() || ! $product->is_in_stock() ) {
		return __( 'Read more', 'niswah-boutique' );
	}

	return $product->is_type( array( 'variable', 'grouped', 'external' ) )
		? __( 'Choose options', 'niswah-boutique' )
		: __( 'Add to cart', 'niswah-boutique' );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'nb_loop_add_to_cart_text', 20, 2 );

/**
 * Top-right control on the card.
 *
 * On the reference this slot is a Quick view trigger, not a wishlist — the
 * markup there is a <quick-view> custom element labelled "Quick view". Rather
 * than draw a button that does nothing, this renders whichever of the two
 * installed plugins is actually active and otherwise outputs nothing at all.
 */
function nb_card_top_right() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$markup = '';

	// Wishlist takes the slot when a wishlist plugin is running.
	if ( defined( 'TINVWL_FVERSION' ) || class_exists( 'TInvWL_Public_AddToWishlist' ) ) {
		$markup = do_shortcode( '[ti_wishlists_addtowishlist product_id="' . (int) $product->get_id() . '"]' );
	} elseif ( class_exists( 'YITH_WCQV_Frontend' ) ) {
		$markup = do_shortcode( '[yith_quick_view product_id="' . (int) $product->get_id() . '"]' );
	}

	if ( '' === trim( (string) $markup ) ) {
		return; // No plugin active — draw nothing rather than a dead control.
	}

	echo '<span class="nb-card__action">' . $markup . '</span>'; // phpcs:ignore WordPress.Security.EscapingOutput
}
add_action( 'woocommerce_before_shop_loop_item_title', 'nb_card_top_right', 11 );

/**
 * Render the minor units of a price smaller and raised.
 *
 * The reference sets the decimals as a superscript — "21,900.<sup>00</sup>" —
 * which is a large part of why its prices read as considered rather than
 * utilitarian. Wrapping happens here so CSS can size it.
 *
 * Only the decimal portion is touched; the currency symbol and thousands
 * separators are left exactly as WooCommerce formatted them.
 */
function nb_price_decimals_superscript( $formatted, $price, $decimals, $decimal_separator, $thousand_separator ) {
	if ( $decimals < 1 ) {
		return $formatted;
	}

	// Only ever do this where our stylesheet is present to render it.
	//
	// The first version of this filter ran everywhere, and because it removed
	// the decimal separator, "795.00" became "795" + "00" — which renders as a
	// superscript on the front end but reads as "79500" anywhere the CSS is
	// absent. That is a 100x error to a human eye, and it was visibly wrong in
	// the products list in wp-admin. Order emails and CSV exports would have
	// carried the same corruption to customers, so admin, AJAX, REST and mail
	// contexts are all excluded.
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return $formatted;
	}

	// Keep the separator in the markup rather than dropping it, so the value is
	// still correct when the styling does not apply (copy/paste, reader modes).
	$sep = preg_quote( $decimal_separator, '/' );

	return preg_replace(
		'/' . $sep . '(\d{' . (int) $decimals . '})$/',
		'<span class="nb-price-decimals">' . esc_html( $decimal_separator ) . '$1</span>',
		$formatted
	);
}
add_filter( 'formatted_woocommerce_price', 'nb_price_decimals_superscript', 20, 5 );

/**
 * Shop and product archives run full width — no sidebar.
 *
 * Divi decides this from the body class: it ships et_right_sidebar by default,
 * which is what put a sidebar on the category archives. Swapping the class for
 * et_full_width_page is Divi's own mechanism, so the sidebar is not merely
 * hidden — the content area genuinely takes the full width.
 */
function nb_full_width_woo_archives( $classes ) {
	if ( ! function_exists( 'is_woocommerce' ) ) {
		return $classes;
	}

	if ( is_shop() || is_product_taxonomy() || is_product() ) {
		$classes   = array_diff( $classes, array( 'et_right_sidebar', 'et_left_sidebar' ) );
		$classes[] = 'et_full_width_page';
		$classes[] = 'nb-full-width';
	}

	if ( is_product() ) {
		$classes[] = 'nb-single-product';
	}

	return $classes;
}
add_filter( 'body_class', 'nb_full_width_woo_archives', 20 );

/**
 * Single product page: match the reference's information order.
 *
 * Measured on the reference product page, the right-hand column runs:
 *   title + price -> reviews -> variant pickers -> quantity + add to cart
 *   -> stock notice -> size chart -> description
 *
 * WooCommerce's default order is close but puts the short description above the
 * price and leaves the full description in a tab strip far below the fold. The
 * reference keeps the description in the column with everything else, so it
 * moves here; the remaining tabs (additional info, reviews) stay below as
 * accordions, which is also what the reference does.
 */
function nb_single_product_layout() {
	if ( ! function_exists( 'is_product' ) ) {
		return;
	}

	// Short description sits above the price by default; the reference has no
	// short description in that position at all.
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

	// Product meta (SKU / category list) is noise this high up the column.
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

	// Full description, in the column, under the buy button.
	add_action( 'woocommerce_single_product_summary', 'nb_single_product_description', 45 );
}
add_action( 'wp', 'nb_single_product_layout' );

/**
 * Full product description rendered inside the summary column.
 */
function nb_single_product_description() {
	global $post;

	if ( ! $post || '' === trim( (string) $post->post_content ) ) {
		return;
	}

	echo '<div class="nb-product__description">';
	echo apply_filters( 'the_content', $post->post_content ); // phpcs:ignore WordPress.Security.EscapingOutput
	echo '</div>';
}

/**
 * Stock notice under the buy button, as the reference shows.
 *
 * Only speaks up when stock is genuinely low and actually being tracked —
 * a permanent "in stock" badge on every product is noise, and inventing
 * urgency on products with unmanaged stock would be a lie.
 */
function nb_single_product_stock_notice() {
	global $product;

	if ( ! $product instanceof WC_Product || ! $product->managing_stock() ) {
		return;
	}

	$qty = $product->get_stock_quantity();

	if ( null === $qty || $qty <= 0 || $qty > 5 ) {
		return;
	}

	printf(
		'<p class="nb-product__stock">%s</p>',
		esc_html(
			sprintf(
				/* translators: %d: units remaining */
				_n( 'Hurry — only %d item left in stock', 'Hurry — only %d items left in stock', $qty, 'niswah-boutique' ),
				$qty
			)
		)
	);
}
add_action( 'woocommerce_single_product_summary', 'nb_single_product_stock_notice', 31 );

/**
 * Send the bare product-category base to the Collections page.
 *
 * /product-category/ is only WooCommerce's permalink prefix — no archive is
 * registered there, so it returns a 404. Rather than leave a dead URL that
 * people will inevitably trim to, it lands on the page that actually lists
 * every category. Uses the real permalink base in case the client changes it.
 */
function nb_redirect_product_category_base() {
	if ( is_admin() || ! function_exists( 'is_woocommerce' ) ) {
		return;
	}

	$path = trim( (string) wp_parse_url( add_query_arg( array() ), PHP_URL_PATH ), '/' );

	$permalinks = get_option( 'woocommerce_permalinks' );
	$base       = ! empty( $permalinks['category_base'] ) ? trim( $permalinks['category_base'], '/' ) : 'product-category';

	if ( $path !== $base ) {
		return;
	}

	$collections_id = (int) get_option( 'nb_starter_collections_id' );
	$target         = $collections_id ? get_permalink( $collections_id ) : false;

	if ( ! $target ) {
		$page   = get_page_by_path( 'collections' );
		$target = $page ? get_permalink( $page ) : false;
	}

	if ( $target ) {
		wp_safe_redirect( $target, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'nb_redirect_product_category_base' );

/**
 * Starter templates importer (admin only).
 *
 * Ships the Theme Builder header/footer with the theme so a fresh install can
 * be brought up without rebuilding them by hand.
 */
if ( is_admin() ) {
	$nb_importer = NB_THEME_DIR . '/includes/class-nb-starter-import.php';
	if ( file_exists( $nb_importer ) ) {
		require_once $nb_importer;
	}
}
