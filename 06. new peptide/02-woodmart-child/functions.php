<?php
/**
 * WoodMart Child — Atomic Blue
 *
 * Loads the Atomic Blue design system on every page that uses one of
 * our custom templates (shop, cart, checkout, single product, about,
 * contact, blog archive, single post). Forces full-width / no-sidebar
 * on those pages so our hero & grids have the room they need.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Detect whether the current request is one of our Atomic Blue pages.
 * Single source of truth — used by enqueue, body class, and layout filters.
 */
function pp_is_atomic_page() {
    if ( function_exists( 'is_woocommerce' ) ) {
        if ( is_shop() || is_product_taxonomy() || is_cart() || is_checkout() || is_product() ) {
            return true;
        }
    }

    $tpl = is_singular() ? get_page_template_slug() : '';
    if ( in_array( $tpl, array( 'page-templates/page-about.php', 'page-templates/page-contact.php' ), true ) ) {
        return true;
    }

    if ( is_home() || is_singular( 'post' ) ) {
        return true;
    }

    return false;
}

/**
 * Enqueue parent + child + Atomic Blue CSS.
 */
add_action( 'wp_enqueue_scripts', 'pp_atomic_enqueue', 20 );
function pp_atomic_enqueue() {
    wp_enqueue_style(
        'woodmart-parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme( get_template() )->get( 'Version' )
    );

    wp_enqueue_style(
        'woodmart-child-style',
        get_stylesheet_uri(),
        array( 'woodmart-parent-style' ),
        wp_get_theme()->get( 'Version' )
    );

    if ( pp_is_atomic_page() ) {
        wp_enqueue_style(
            'pp-atomic-blue',
            get_stylesheet_directory_uri() . '/assets/css/atomic-blue.css',
            array( 'woodmart-child-style' ),
            wp_get_theme()->get( 'Version' )
        );
    }
}

/**
 * Body classes — `atomic-blue` is the universal scope used by all the
 * CSS, plus a page-specific class so individual templates can fine-tune.
 */
add_filter( 'body_class', 'pp_atomic_body_class' );
function pp_atomic_body_class( $classes ) {
    if ( ! pp_is_atomic_page() ) {
        return $classes;
    }

    $classes[] = 'atomic-blue';

    if ( function_exists( 'is_woocommerce' ) ) {
        if ( is_shop() || is_product_taxonomy() ) { $classes[] = 'atomic-blue-shop'; }
        if ( is_cart() )                          { $classes[] = 'atomic-blue-cart'; }
        if ( is_checkout() )                      { $classes[] = 'atomic-blue-checkout'; }
        if ( is_product() )                       { $classes[] = 'atomic-blue-product'; }
    }

    if ( is_page_template( 'page-templates/page-about.php' ) )   { $classes[] = 'atomic-blue-about'; }
    if ( is_page_template( 'page-templates/page-contact.php' ) ) { $classes[] = 'atomic-blue-contact'; }
    if ( is_home() )                                             { $classes[] = 'atomic-blue-blog'; }
    if ( is_singular( 'post' ) )                                 { $classes[] = 'atomic-blue-single'; }

    return $classes;
}

/**
 * Force full-width layout on all Atomic Blue pages — no sidebar, no
 * 9/12 column squeeze. These three filters together break us out of
 * WoodMart's default sidebar-shop layout.
 */
add_filter( 'woodmart_get_page_layout', 'pp_atomic_force_full_width', 99 );
function pp_atomic_force_full_width( $layout ) {
    return pp_is_atomic_page() ? 'full-width' : $layout;
}

add_filter( 'woodmart_main_content_classes', 'pp_atomic_main_content_classes', 99 );
function pp_atomic_main_content_classes( $classes ) {
    if ( ! pp_is_atomic_page() ) {
        return $classes;
    }
    $classes = array_filter( (array) $classes, function ( $c ) {
        return ! preg_match( '/^col-(md|lg|xl)-(7|8|9|10)$/', $c );
    } );
    $classes[] = 'col-12';
    return $classes;
}

add_filter( 'woodmart_disable_sidebar', 'pp_atomic_disable_sidebar' );
function pp_atomic_disable_sidebar( $disable ) {
    return pp_is_atomic_page() ? true : $disable;
}

/**
 * Make our custom page templates appear in the WP page editor's
 * Template dropdown. Without this, page-about.php / page-contact.php
 * are invisible to admins.
 */
add_filter( 'theme_page_templates', 'pp_atomic_register_page_templates' );
function pp_atomic_register_page_templates( $templates ) {
    $templates['page-templates/page-about.php']   = 'Atomic Blue · About';
    $templates['page-templates/page-contact.php'] = 'Atomic Blue · Contact';
    return $templates;
}

/* =====================================================================
   Shop sidebar — registers the "Atomic Blue · Shop Filters" widget area
   that the shop archive renders on the left. Drop the FilterEverything
   Pro "Filters" widget into it via Appearance → Widgets to power the
   sidebar's category / attribute filters with live WooCommerce data.
   ===================================================================== */
add_action( 'widgets_init', 'pp_atomic_register_sidebars' );
function pp_atomic_register_sidebars() {
    register_sidebar( array(
        'name'          => __( 'Atomic Blue · Shop Filters', 'woodmart-child' ),
        'id'            => 'atomic-blue-shop-filters',
        'description'   => __( 'Renders inside the shop archive sidebar. Drop a FilterEverything Pro "Filters" widget here to power Categories / Primary Function / Dosage / Volume / Price filtering.', 'woodmart-child' ),
        'before_widget' => '<div id="%1$s" class="pp-sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="pp-sidebar-widget-title">',
        'after_title'   => '</h3>',
    ) );
}

/**
 * Helper — true when FilterEverything Pro is active. Used by the shop
 * archive to decide between "render widget area" and "show admin hint".
 */
function pp_atomic_filtereverything_active() {
    return class_exists( '\\FilterEverything\\Filter\\Plugin' )
        || function_exists( 'flrt_show_selected_terms' );
}

/* =====================================================================
   Single Product (PDP) — inject the three Atomic Blue extras the mockup
   shows but WC's standard summary doesn't render: trust-chip row,
   "Buy Now" button next to Add to Cart, and the Specs info-block.
   ===================================================================== */

// Trust chips between H1 and price.
add_action( 'woocommerce_single_product_summary', 'pp_atomic_pdp_meta_chips', 7 );
function pp_atomic_pdp_meta_chips() {
    ?>
    <div class="meta atomic-meta-chips" style="display:flex; flex-wrap:wrap; gap:8px; margin: 14px 0;">
        <span class="chip active">99% Purity</span>
        <span class="chip">3rd Party COA</span>
        <span class="chip">Same-Day Dispatch</span>
    </div>
    <?php
}

// "Buy Now" button — adds product to cart and redirects straight to checkout.
add_action( 'woocommerce_after_add_to_cart_button', 'pp_atomic_pdp_buy_now' );
function pp_atomic_pdp_buy_now() {
    global $product;
    if ( ! $product || ! $product->is_purchasable() || ! $product->is_in_stock() ) {
        return;
    }
    if ( $product->is_type( 'variable' ) || $product->is_type( 'grouped' ) ) {
        return;
    }
    $url = add_query_arg( 'add-to-cart', $product->get_id(), wc_get_checkout_url() );
    printf(
        '<a href="%s" class="btn gold pp-buy-now" rel="nofollow">%s</a>',
        esc_url( $url ),
        esc_html__( 'Buy Now', 'woodmart-child' )
    );
}

// Specs info-block — pulls the product's non-taxonomy attributes if set,
// falls back to a sensible peptide-research default if the product has none.
add_action( 'woocommerce_single_product_summary', 'pp_atomic_pdp_specs', 35 );
function pp_atomic_pdp_specs() {
    global $product;
    if ( ! $product instanceof WC_Product ) {
        return;
    }

    $rows = array();
    foreach ( $product->get_attributes() as $attribute ) {
        if ( $attribute->get_visible() && ! $attribute->is_taxonomy() ) {
            $values = $attribute->get_options();
            if ( ! empty( $values ) ) {
                $rows[ wc_attribute_label( $attribute->get_name() ) ] = is_array( $values ) ? implode( ', ', $values ) : $values;
            }
        }
    }

    // Fallback specs when the product has no custom attributes set.
    if ( empty( $rows ) ) {
        $rows = array(
            __( 'Purity',       'woodmart-child' ) => __( '≥99% HPLC',         'woodmart-child' ),
            __( 'Form',         'woodmart-child' ) => __( 'Lyophilised powder', 'woodmart-child' ),
            __( 'Storage',      'woodmart-child' ) => __( '-20 °C',            'woodmart-child' ),
            __( 'Reconstitute', 'woodmart-child' ) => __( 'Bac. water',        'woodmart-child' ),
        );
    }
    ?>
    <div class="info-block">
        <h3><?php esc_html_e( 'Specs', 'woodmart-child' ); ?></h3>
        <dl>
            <?php foreach ( $rows as $label => $value ) : ?>
                <dt><?php echo esc_html( $label ); ?></dt>
                <dd><?php echo esc_html( $value ); ?></dd>
            <?php endforeach; ?>
        </dl>
    </div>
    <?php
}

/* =====================================================================
   Single Post — auto-generate TOC from h2/h3 headings in the post body.
   Adds matching IDs via the_content filter so the TOC links scroll
   to the right heading.
   ===================================================================== */

add_filter( 'the_content', 'pp_atomic_add_heading_ids', 9 );
function pp_atomic_add_heading_ids( $content ) {
    if ( ! is_singular( 'post' ) || ! in_the_loop() ) {
        return $content;
    }
    $i = 0;
    return preg_replace_callback(
        '/<(h[23])((?:\s[^>]*)?)>(.+?)<\/\1>/is',
        function ( $m ) use ( &$i ) {
            $i++;
            $tag    = $m[1];
            $attrs  = $m[2];
            $inner  = $m[3];
            if ( strpos( $attrs, ' id=' ) !== false ) {
                return $m[0];
            }
            return sprintf( '<%s id="pp-h-%d"%s>%s</%s>', $tag, $i, $attrs, $inner, $tag );
        },
        $content
    );
}

function pp_atomic_get_toc( $content ) {
    if ( empty( $content ) ) {
        return '';
    }
    $i     = 0;
    $items = array();
    preg_replace_callback(
        '/<(h[23])((?:\s[^>]*)?)>(.+?)<\/\1>/is',
        function ( $m ) use ( &$i, &$items ) {
            $i++;
            $items[] = array(
                'level' => $m[1],
                'id'    => 'pp-h-' . $i,
                'title' => wp_strip_all_tags( $m[3] ),
            );
            return $m[0];
        },
        $content
    );

    if ( count( $items ) < 2 ) {
        return ''; // No point showing a TOC for one or zero headings.
    }

    $out = '';
    foreach ( $items as $item ) {
        $indent = 'h3' === $item['level'] ? ' style="padding-left:14px; opacity:.85;"' : '';
        $out   .= sprintf( '<a href="#%s"%s>%s</a>', esc_attr( $item['id'] ), $indent, esc_html( $item['title'] ) );
    }
    return $out;
}
