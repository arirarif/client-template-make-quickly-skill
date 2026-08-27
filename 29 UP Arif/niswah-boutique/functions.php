<?php
/**
 * Niswah Boutique — Divi child theme.
 *
 * @package NiswahBoutique
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'NB_THEME_VERSION', '0.10.13' );
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

	// Slider IS wanted. An earlier version dropped it, on a misreading of the
	// reference: its media column contains six elements, which looked like a
	// vertical stack until their coordinates were checked — the first two sit at
	// the identical position (710x1064), i.e. one slide visible at a time, with
	// a 710x83 thumbnail rail directly beneath. Main image plus thumbnails.
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'nb_declare_woo_support' );

/**
 * Image sizes — the fix for soft product photography.
 *
 * Measured on the live site 2026-08-28, at devicePixelRatio 1.125:
 *
 *   single product gallery   file 600x900   into a 710px box (needs 799px)  -> 0.75x
 *   collections tiles        file 300x450   into a 487px box (needs 547px)  -> 0.55x
 *
 * Both were being UPSCALED by the browser, which is the entire cause of the
 * blur. The source uploads are fine (1707x2560 originals are present), so
 * nothing needs re-uploading — WooCommerce was simply registering crops far
 * smaller than the layout renders them at.
 *
 * These filters are the definitive ones: wc_get_image_size() applies them last,
 * so they win over both the Customizer options and add_theme_support(). Sizes
 * are 2:3 to match the card and gallery aspect ratio, and large enough to stay
 * sharp on a 2x display:
 *
 *   thumbnail  800px  covers the 365px shop card and the 487px collections tile
 *   single    1200px  covers the 710px gallery
 *
 * NOTE: registering a size does not create the files. Existing uploads keep
 * only their old crops until the thumbnails are regenerated —
 * WooCommerce -> Status -> Tools -> "Regenerate shop thumbnails".
 */
function nb_image_size_thumbnail( $size ) {
	return array( 'width' => 800, 'height' => 1200, 'crop' => 1 );
}
add_filter( 'woocommerce_get_image_size_thumbnail', 'nb_image_size_thumbnail', 20 );

function nb_image_size_single( $size ) {
	return array( 'width' => 1200, 'height' => 1800, 'crop' => 1 );
}
add_filter( 'woocommerce_get_image_size_single', 'nb_image_size_single', 20 );

/**
 * Gallery rail thumbnails render at 84px; 200px keeps them sharp at 2x.
 */
function nb_image_size_gallery_thumbnail( $size ) {
	return array( 'width' => 200, 'height' => 200, 'crop' => 1 );
}
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'nb_image_size_gallery_thumbnail', 20 );

/**
 * WordPress re-encodes every resized JPEG at quality 82 by default. On flat
 * fabric and skin tones that shows as blotching well before it shows as
 * softness, so this raises it for both the legacy and the modern filter.
 */
function nb_jpeg_quality() {
	return 90;
}
add_filter( 'jpeg_quality', 'nb_jpeg_quality', 20 );

function nb_editor_quality( $quality, $mime = '' ) {
	return ( 'image/jpeg' === $mime || '' === $mime ) ? 90 : $quality;
}
add_filter( 'wp_editor_set_quality', 'nb_editor_quality', 20, 2 );

/**
 * Related products: always four, always a full row.
 *
 * The grid is already four columns wide — measured 365px x 4 on the live page —
 * so nothing is wrong with the CSS. WooCommerce was returning only three
 * products because relatedness is limited to shared categories and tags, and
 * this product's category simply does not hold four other visible items. A
 * three-card row leaves a visible hole in a four-column grid.
 *
 * The top-up runs AFTER WooCommerce's own lookup, so genuine related products
 * are always preferred and the filler only covers the shortfall.
 */
function nb_related_products_args( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'nb_related_products_args', 20 );

function nb_fill_related_products( $related_ids, $product_id, $args ) {
	$limit       = 4;
	$related_ids = array_values( array_unique( array_filter( array_map( 'absint', (array) $related_ids ) ) ) );
	$related_ids = array_slice( $related_ids, 0, $limit );

	$shortfall = $limit - count( $related_ids );
	if ( $shortfall < 1 || ! function_exists( 'wc_get_products' ) ) {
		return $related_ids;
	}

	$filler = wc_get_products(
		array(
			'status'     => 'publish',
			'visibility' => 'catalog',
			'limit'      => $shortfall,
			'exclude'    => array_merge( array( absint( $product_id ) ), $related_ids ),
			'orderby'    => 'rand',
			'return'     => 'ids',
		)
	);

	if ( is_wp_error( $filler ) || ! is_array( $filler ) ) {
		return $related_ids;
	}

	return array_slice( array_merge( $related_ids, array_map( 'absint', $filler ) ), 0, $limit );
}
add_filter( 'woocommerce_related_products', 'nb_fill_related_products', 20, 3 );

/**
 * Breadcrumbs belong on the single product page only.
 *
 * WooCommerce prints them from woocommerce_before_main_content at priority 20
 * on every shop, category and product page. Dropping the action on everything
 * that is not a product leaves the single product trail intact.
 */
function nb_breadcrumbs_on_product_only() {
	if ( ! function_exists( 'is_product' ) || ! is_product() ) {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	}
}
add_action( 'template_redirect', 'nb_breadcrumbs_on_product_only' );

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
 * Every WooCommerce page runs full width — no sidebar.
 *
 * Divi decides this from the body class: it ships et_right_sidebar by default,
 * which is what put a sidebar on the category archives. Swapping the class for
 * et_full_width_page is Divi's own mechanism, so the sidebar is not merely
 * hidden — the content area genuinely takes the full width.
 *
 * Cart and Checkout are included deliberately. A sidebar there squeezed the cart
 * table to 795px, which cannot hold the reference's five-column line-item layout,
 * and a sidebar next to a checkout form is a conversion problem regardless of
 * width. is_cart()/is_checkout() are not covered by is_woocommerce(), which is
 * why they need naming separately.
 */
function nb_full_width_woo_archives( $classes ) {
	if ( ! function_exists( 'is_woocommerce' ) ) {
		return $classes;
	}

	$is_cart     = function_exists( 'is_cart' ) && is_cart();
	$is_checkout = function_exists( 'is_checkout' ) && is_checkout();

	if ( is_shop() || is_product_taxonomy() || is_product() || $is_cart || $is_checkout ) {
		$classes   = array_diff( $classes, array( 'et_right_sidebar', 'et_left_sidebar' ) );
		$classes[] = 'et_full_width_page';
		$classes[] = 'nb-full-width';
	}

	if ( is_product() ) {
		$classes[] = 'nb-single-product';
	}

	if ( $is_cart ) {
		$classes[] = 'nb-cart';
	}

	if ( $is_checkout ) {
		$classes[] = 'nb-checkout';
	}

	return $classes;
}
add_filter( 'body_class', 'nb_full_width_woo_archives', 20 );

/**
 * Put the Cart and Checkout pages back on the classic WooCommerce shortcodes.
 *
 * WooCommerce now creates both pages containing the block versions
 * (wp:woocommerce/cart and wp:woocommerce/checkout), and that is what this site
 * shipped with. Two reasons that had to change:
 *
 *  1. The block cart renders a fixed narrow-content + right-rail layout with its
 *     own wc-block-* class names. The reference cart is a full-bleed five-column
 *     table with the totals sitting below it on the right. The block markup
 *     cannot be made into that shape; the classic .shop_table can, column for
 *     column.
 *  2. Every other WooCommerce customisation in this theme — the price
 *     superscript, size ordering, the loop card, the single-product layout — is
 *     written against classic template markup and hooks. The blocks bypass all
 *     of it, so the cart and checkout were drifting away from the rest of the
 *     site's styling with no way to pull them back.
 *
 * The swap runs once, guarded by an option, and stashes the previous content in
 * post meta first so it is reversible — delete the option and restore the meta.
 * It is not hooked to theme activation for the same reason the starter import
 * is not: silently rewriting page content on a live site should happen exactly
 * once, on purpose, not on every theme switch.
 */
function nb_classic_cart_checkout() {
	if ( get_option( 'nb_classic_cart_checkout_done' ) ) {
		return;
	}

	if ( ! function_exists( 'wc_get_page_id' ) ) {
		return;
	}

	$targets = array(
		'cart'     => '[woocommerce_cart]',
		'checkout' => '[woocommerce_checkout]',
	);

	foreach ( $targets as $page => $shortcode ) {
		$id = wc_get_page_id( $page );

		if ( $id <= 0 || ! get_post( $id ) ) {
			continue;
		}

		$current = (string) get_post_field( 'post_content', $id );

		// Only touch a page that is actually still on the block. If the client
		// has already customised it, leave their work alone.
		if ( false === strpos( $current, 'wp:woocommerce/' . $page ) ) {
			continue;
		}

		update_post_meta( $id, '_nb_content_before_classic', $current );

		wp_update_post(
			array(
				'ID'           => $id,
				'post_content' => $shortcode,
			)
		);
	}

	update_option( 'nb_classic_cart_checkout_done', NB_THEME_VERSION );
}
add_action( 'admin_init', 'nb_classic_cart_checkout' );

/**
 * Twelve products per archive page, not nine.
 *
 * The grid is four columns wide, so nine leaves a two-item orphan row at the
 * bottom of every page. Twelve fills three complete rows. The reference loads
 * 80 at a time behind a "show more" button; that needs AJAX paging, which is
 * out of scope here — see the pagination note in the stylesheet.
 */
function nb_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'nb_products_per_page', 20 );

/**
 * Reference wording and order for the archive toolbar.
 *
 * WooCommerce renders the result count at priority 20 and the sort dropdown at
 * 30, giving "Showing 1–9 of 44 results" first. The reference does the reverse:
 * a sort bar, and beneath it a plain "448 products". So the stock count is
 * unhooked and re-added after the dropdown, with the count reduced to the
 * catalogue total.
 *
 * Re-registered rather than filtered because the string lives in
 * loop/result-count.php with no filter of its own, and swapping it through
 * gettext would mean matching four different plural forms.
 */
function nb_reorder_archive_toolbar() {
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	add_action( 'woocommerce_before_shop_loop', 'nb_result_count', 31 );
}
add_action( 'woocommerce_before_shop_loop', 'nb_reorder_archive_toolbar', 5 );

function nb_result_count() {
	global $wp_query;

	$total = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;

	if ( $total < 1 ) {
		return;
	}

	printf(
		'<p class="woocommerce-result-count nb-result-count">%s</p>',
		esc_html(
			sprintf(
				/* translators: %d: number of products in this archive */
				_n( '%d product', '%d products', $total, 'niswah-boutique' ),
				$total
			)
		)
	);
}

/**
 * Drop the cart cross-sells block.
 *
 * The reference cart ends at the totals and the checkout button. Cross-sells
 * would add a product grid below that, pushing the checkout button up the page
 * and away from the thing it is meant to be next to.
 */
function nb_remove_cart_cross_sells() {
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
}
add_action( 'woocommerce_before_cart', 'nb_remove_cart_cross_sells' );

/**
 * Reference wording on the cart page.
 *
 * WooCommerce says "Proceed to checkout"; the reference says "Check out now".
 * Both strings live inside templates as plain esc_html__() calls with no filter
 * of their own, so gettext is the hook that reaches them. Scoped to the cart
 * page and to exact matches only, so it cannot bleed into wp-admin or into an
 * unrelated string that happens to contain the same words.
 */
function nb_cart_strings( $translated, $original, $domain ) {
	if ( 'woocommerce' !== $domain || is_admin() ) {
		return $translated;
	}

	// gettext fires from the moment plugins start loading, long before the main
	// query has run. Calling is_cart() that early makes WordPress emit its
	// "conditional query tags do not work before the query is run" notice on
	// every page load, so wait until template_redirect has fired.
	if ( ! did_action( 'template_redirect' ) ) {
		return $translated;
	}

	if ( ! function_exists( 'is_cart' ) || ! is_cart() ) {
		return $translated;
	}

	// "Cart totals" becomes "Order Summary", not "Subtotal": the table directly
	// beneath the heading already has its own Subtotal row, so borrowing the
	// reference's wording here printed "Subtotal" twice, one line apart.
	$map = array(
		'Proceed to checkout' => __( 'Check out now', 'niswah-boutique' ),
		'Cart totals'         => __( 'Order Summary', 'niswah-boutique' ),
	);

	return isset( $map[ $original ] ) ? $map[ $original ] : $translated;
}
add_filter( 'gettext', 'nb_cart_strings', 20, 3 );

/**
 * Order size options smallest to largest.
 *
 * WooCommerce lists attribute terms alphabetically, which puts clothing sizes in
 * the nonsensical order L, M, S, XL, XS, XXL. This sorts them against a real
 * size sequence instead. Anything not in the sequence — numeric lengths like
 * 52 / 56, or a size we have not anticipated — falls through to a natural sort,
 * so numbers still read 52, 56 rather than 52, 56 by string.
 *
 * Applied by filter rather than by hand-ordering terms in wp-admin, so it keeps
 * working when the client adds a size later.
 */
function nb_sort_size_options( $args ) {
	$attribute = isset( $args['attribute'] ) ? strtolower( (string) $args['attribute'] ) : '';

	if ( false === strpos( $attribute, 'size' ) || empty( $args['options'] ) ) {
		return $args;
	}

	$sequence = array( 'xxxs', 'xxs', 'xs', 's', 'm', 'l', 'xl', 'xxl', '2xl', '3xl', '4xl', '5xl', '6xl' );

	usort(
		$args['options'],
		static function ( $a, $b ) use ( $sequence ) {
			$ia = array_search( strtolower( (string) $a ), $sequence, true );
			$ib = array_search( strtolower( (string) $b ), $sequence, true );

			if ( false === $ia && false === $ib ) {
				return strnatcasecmp( (string) $a, (string) $b );
			}
			if ( false === $ia ) {
				return 1;
			}
			if ( false === $ib ) {
				return -1;
			}

			return $ia <=> $ib;
		}
	);

	return $args;
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'nb_sort_size_options', 20 );

/**
 * Same ordering, applied where the swatch plugin actually reads its terms.
 *
 * The dropdown filter above only covers WooCommerce's own <select>. Variation
 * Swatches builds its own markup from wc_get_product_terms(), so without this
 * the swatch row stayed alphabetical (L, M, S, XL, XS, XXL) even though the
 * select was sorted correctly.
 *
 * @param WP_Term[]|string[] $terms    Terms or names, depending on the caller's args.
 * @param int                $id       Product id.
 * @param string             $taxonomy Attribute taxonomy.
 * @return array
 */
function nb_sort_size_terms( $terms, $id, $taxonomy ) {
	if ( false === strpos( strtolower( (string) $taxonomy ), 'size' ) || empty( $terms ) ) {
		return $terms;
	}

	$sequence = array( 'xxxs', 'xxs', 'xs', 's', 'm', 'l', 'xl', 'xxl', '2xl', '3xl', '4xl', '5xl', '6xl' );

	// The array may hold WP_Term objects or plain strings depending on the
	// caller's `fields` argument, so read whichever is present.
	$key = static function ( $item ) {
		if ( is_object( $item ) ) {
			return strtolower( isset( $item->slug ) ? $item->slug : ( $item->name ?? '' ) );
		}
		return strtolower( (string) $item );
	};

	usort(
		$terms,
		static function ( $a, $b ) use ( $sequence, $key ) {
			$ia = array_search( $key( $a ), $sequence, true );
			$ib = array_search( $key( $b ), $sequence, true );

			if ( false === $ia && false === $ib ) {
				return strnatcasecmp( $key( $a ), $key( $b ) );
			}
			if ( false === $ia ) {
				return 1;
			}
			if ( false === $ib ) {
				return -1;
			}

			return $ia <=> $ib;
		}
	);

	return $terms;
}
add_filter( 'woocommerce_get_product_terms', 'nb_sort_size_terms', 20, 3 );

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
