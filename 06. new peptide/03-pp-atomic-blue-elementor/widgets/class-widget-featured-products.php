<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Featured Products — live WooCommerce products in Atomic Blue card markup.
 *
 * Per-product Atomic-Blue overrides via post meta (sensible Woo-derived fallbacks otherwise):
 *   _pp_formula       — small uppercase line above the title
 *   _pp_category_line — coloured-dot label (e.g. "Systemic / Brain")
 *   _pp_atom_color    — atom dot CSS colour (e.g. "#7c5cff")
 *   _pp_tag           — red corner badge text (e.g. "20 in stock", "Sale")
 */
class Widget_Featured_Products extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_04_featured_products'; }
    public function get_title()      { return '04 — Featured Products (Woo)'; }
    public function get_icon()       { return 'eicon-products'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'products', 'woocommerce', 'featured', 'peptides' ]; }

    /* ──────────────────────────────────────────────────────────────────────────
     * Controls
     * ────────────────────────────────────────────────────────────────────────── */
    protected function register_controls() {

        /* ── Section head ── */
        $this->start_controls_section( 'sec_head', [
            'label' => 'Section head',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Featured products',
        ] );
        $this->add_control( 'pill', [
            'label'   => 'Side pill text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'In stock now',
        ] );
        $this->end_controls_section();

        /* ── Source ── */
        $this->start_controls_section( 'sec_source', [
            'label' => 'Product source',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'source', [
            'label'   => 'Show',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'featured',
            'options' => [
                'featured'     => 'Featured products',
                'recent'       => 'Most recent',
                'best_sellers' => 'Best sellers',
                'sale'         => 'On sale',
                'category'     => 'By category',
                'tag'          => 'By tag',
                'ids'          => 'Specific product IDs',
                'all'          => 'All products',
            ],
        ] );

        $this->add_control( 'limit', [
            'label'      => 'Number of products',
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ '' ],
            'range'      => [
                '' => [ 'min' => 1, 'max' => 24, 'step' => 1 ],
            ],
            'default'    => [ 'unit' => '', 'size' => 12 ],
        ] );

        $this->add_control( 'categories', [
            'label'       => 'Category slugs',
            'description' => 'Comma-separated slugs (e.g. <code>healing, metabolic</code>).',
            'type'        => \Elementor\Controls_Manager::TEXT,
            'condition'   => [ 'source' => 'category' ],
            'default'     => '',
        ] );

        $this->add_control( 'tags', [
            'label'       => 'Tag slugs',
            'description' => 'Comma-separated slugs.',
            'type'        => \Elementor\Controls_Manager::TEXT,
            'condition'   => [ 'source' => 'tag' ],
            'default'     => '',
        ] );

        $this->add_control( 'ids', [
            'label'       => 'Product IDs',
            'description' => 'Comma-separated WooCommerce product IDs. Order respects what you list.',
            'type'        => \Elementor\Controls_Manager::TEXT,
            'condition'   => [ 'source' => 'ids' ],
            'default'     => '',
        ] );

        $this->add_control( 'orderby', [
            'label'     => 'Order by',
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'date',
            'options'   => [
                'date'       => 'Date',
                'rand'       => 'Random',
                'price'      => 'Price',
                'title'      => 'Title',
                'menu_order' => 'Menu order',
                'popularity' => 'Popularity (sales)',
            ],
            'condition' => [ 'source!' => [ 'ids', 'best_sellers' ] ],
        ] );

        $this->add_control( 'order', [
            'label'     => 'Sort direction',
            'type'      => \Elementor\Controls_Manager::SELECT,
            'default'   => 'DESC',
            'options'   => [
                'DESC' => 'Descending',
                'ASC'  => 'Ascending',
            ],
            'condition' => [ 'source!' => [ 'ids', 'best_sellers' ] ],
        ] );

        $this->end_controls_section();

        /* ── Filters ── */
        $this->start_controls_section( 'sec_filters', [
            'label' => 'Filters',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'hide_out_of_stock', [
            'label'        => 'Hide out-of-stock',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => 'Yes',
            'label_off'    => 'No',
            'default'      => '',
            'return_value' => 'yes',
        ] );
        $this->add_control( 'hide_free', [
            'label'        => 'Hide free products',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => 'Yes',
            'label_off'    => 'No',
            'default'      => '',
            'return_value' => 'yes',
        ] );
        $this->add_control( 'show_hidden', [
            'label'        => 'Include hidden products',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => 'Yes',
            'label_off'    => 'No',
            'default'      => '',
            'return_value' => 'yes',
        ] );
        $this->end_controls_section();

        /* ── Layout (Style tab) ── */
        $this->start_controls_section( 'sec_layout', [
            'label' => 'Layout',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'columns', [
            'label'           => 'Columns',
            'type'            => \Elementor\Controls_Manager::SELECT,
            'default'         => '4',
            'tablet_default'  => '2',
            'mobile_default'  => '1',
            'options'         => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
            'selectors'       => [
                '{{WRAPPER}} .pp-prod-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
            ],
        ] );

        $this->add_responsive_control( 'gap', [
            'label'      => 'Gap between cards',
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [
                'px' => [ 'min' => 8, 'max' => 60, 'step' => 1 ],
            ],
            'default'    => [ 'unit' => 'px', 'size' => 20 ],
            'selectors'  => [
                '{{WRAPPER}} .pp-prod-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'image_height', [
            'label'      => 'Image height',
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [
                'px' => [ 'min' => 140, 'max' => 360, 'step' => 1 ],
            ],
            'default'        => [ 'unit' => 'px', 'size' => 260 ],
            'tablet_default' => [ 'unit' => 'px', 'size' => 240 ],
            'mobile_default' => [ 'unit' => 'px', 'size' => 300 ],
            'selectors'      => [
                '{{WRAPPER}} .pp-prod-photo'     => 'height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .pp-prod-photo img' => 'max-height: calc({{SIZE}}{{UNIT}} - 10px);',
            ],
        ] );

        $this->end_controls_section();
    }

    /* ──────────────────────────────────────────────────────────────────────────
     * Query builder
     * ────────────────────────────────────────────────────────────────────────── */
    private function build_query_args( $s ) {
        $limit = isset( $s['limit']['size'] ) ? (int) $s['limit']['size'] : 12;
        if ( $limit < 1 ) { $limit = 12; }

        $args = [
            'post_type'           => 'product',
            'posts_per_page'      => $limit,
            'post_status'         => 'publish',
            'no_found_rows'       => true,
            'ignore_sticky_posts' => true,
        ];

        // Source.
        switch ( $s['source'] ) {
            case 'featured':
                $args['tax_query'][] = [
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                ];
                break;

            case 'sale':
                $sale_ids = function_exists( 'wc_get_product_ids_on_sale' ) ? wc_get_product_ids_on_sale() : [];
                $args['post__in'] = ! empty( $sale_ids ) ? $sale_ids : [ 0 ];
                if ( ! empty( $sale_ids ) ) { $args['orderby'] = 'post__in'; }
                break;

            case 'best_sellers':
                $args['meta_key'] = 'total_sales';
                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'DESC';
                break;

            case 'category':
                if ( ! empty( $s['categories'] ) ) {
                    $args['tax_query'][] = [
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => array_filter( array_map( 'trim', explode( ',', $s['categories'] ) ) ),
                    ];
                }
                break;

            case 'tag':
                if ( ! empty( $s['tags'] ) ) {
                    $args['tax_query'][] = [
                        'taxonomy' => 'product_tag',
                        'field'    => 'slug',
                        'terms'    => array_filter( array_map( 'trim', explode( ',', $s['tags'] ) ) ),
                    ];
                }
                break;

            case 'ids':
                $ids = array_filter( array_map( 'absint', array_map( 'trim', explode( ',', $s['ids'] ) ) ) );
                $args['post__in'] = ! empty( $ids ) ? $ids : [ 0 ];
                if ( ! empty( $ids ) ) { $args['orderby'] = 'post__in'; }
                break;

            case 'recent':
            case 'all':
            default:
                // Fall through to orderby/order below.
                break;
        }

        // Order (skip if already forced by source).
        if ( ! in_array( $s['source'], [ 'ids', 'best_sellers', 'sale' ], true ) ) {
            $orderby = ! empty( $s['orderby'] ) ? $s['orderby'] : 'date';
            $order   = ! empty( $s['order'] )   ? $s['order']   : 'DESC';
            switch ( $orderby ) {
                case 'price':
                    $args['meta_key'] = '_price';
                    $args['orderby']  = 'meta_value_num';
                    break;
                case 'popularity':
                    $args['meta_key'] = 'total_sales';
                    $args['orderby']  = 'meta_value_num';
                    break;
                case 'menu_order':
                    $args['orderby'] = 'menu_order title';
                    break;
                default:
                    $args['orderby'] = $orderby; // date, rand, title
            }
            $args['order'] = $order;
        }

        // Catalog visibility.
        if ( 'yes' !== ( $s['show_hidden'] ?? '' ) ) {
            $args['tax_query'][] = [
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => [ 'exclude-from-catalog' ],
                'operator' => 'NOT IN',
            ];
        }

        // Hide out of stock.
        if ( 'yes' === ( $s['hide_out_of_stock'] ?? '' ) ) {
            $args['tax_query'][] = [
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => [ 'outofstock' ],
                'operator' => 'NOT IN',
            ];
        }

        // Hide free.
        if ( 'yes' === ( $s['hide_free'] ?? '' ) ) {
            $args['meta_query'][] = [
                'key'     => '_price',
                'value'   => 0,
                'compare' => '>',
                'type'    => 'NUMERIC',
            ];
        }

        if ( ! empty( $args['tax_query'] ) && count( $args['tax_query'] ) > 1 ) {
            $args['tax_query']['relation'] = 'AND';
        }

        return $args;
    }

    /* ──────────────────────────────────────────────────────────────────────────
     * Resolve per-card extra fields (post-meta with Woo fallbacks)
     * ────────────────────────────────────────────────────────────────────────── */
    private function resolve_card_meta( $product ) {
        $pid = $product->get_id();

        $formula = (string) get_post_meta( $pid, '_pp_formula', true );
        if ( '' === $formula ) {
            $bits = [];
            $sku  = $product->get_sku();
            if ( $sku ) { $bits[] = $sku; }
            $bits[] = 'Research use only';
            $formula = implode( ' · ', $bits );
        }

        $cat_line = (string) get_post_meta( $pid, '_pp_category_line', true );
        if ( '' === $cat_line ) {
            $terms = wc_get_product_terms( $pid, 'product_cat', [ 'fields' => 'names' ] );
            if ( ! empty( $terms ) ) { $cat_line = $terms[0]; }
        }

        $atom_color = (string) get_post_meta( $pid, '_pp_atom_color', true );
        if ( '' === $atom_color ) {
            $palette = [ '#7c5cff', '#46f0ff', '#ffd166', '#ff4d6d', '#7ad36b', '#ffa45c', '#a78bfa', '#34d399' ];
            $slug    = '';
            $terms   = wc_get_product_terms( $pid, 'product_cat', [ 'fields' => 'slugs' ] );
            if ( ! empty( $terms ) ) { $slug = $terms[0]; }
            $atom_color = $palette[ abs( crc32( $slug . $pid ) ) % count( $palette ) ];
        }

        $tag = (string) get_post_meta( $pid, '_pp_tag', true );
        if ( '' === $tag ) {
            if ( $product->is_on_sale() ) {
                $tag = 'Sale';
            } elseif ( $product->managing_stock() ) {
                $qty = (int) $product->get_stock_quantity();
                if ( $qty > 0 ) { $tag = $qty . ' in stock'; }
            } elseif ( ! $product->is_in_stock() ) {
                $tag = 'Sold out';
            }
        }

        return [
            'formula'       => $formula,
            'category_line' => $cat_line,
            'atom_color'    => $atom_color,
            'tag'           => $tag,
        ];
    }

    /* ──────────────────────────────────────────────────────────────────────────
     * Render
     * ────────────────────────────────────────────────────────────────────────── */
    protected function render() {
        if ( ! function_exists( 'wc_get_product' ) ) {
            echo '<section class="pp-section pp-bg-vault" style="padding:40px 20px;"><div class="pp-wrap" style="color:var(--pp-paper);font:800 16px Arial">WooCommerce is not active. Activate WooCommerce to display this widget.</div></section>';
            return;
        }

        $s = $this->get_settings_for_display();
        $q = new \WP_Query( $this->build_query_args( $s ) );
        ?>
<style>
  .pp-feat { padding: 0 20px 70px; }
  .pp-featured {
    background: var(--pp-deep);
    border: var(--pp-border);
    border-radius: 42px;
    padding: 30px;
    box-shadow: var(--pp-shadow-xl);
  }
  .pp-feat .pp-feat-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    gap: 16px;
  }
  .pp-feat-head h2 { color: var(--pp-paper); }
  .pp-prod-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 20px;
    align-items: stretch;
  }
  .pp-product {
    background: var(--pp-paper);
    color: #000;
    border: var(--pp-border);
    border-radius: 30px;
    padding: 18px;
    box-shadow: var(--pp-shadow-lg);
    display: flex;
    flex-direction: column;
  }
  .pp-product .pp-prod-photo {
    height: 260px;
    background: linear-gradient(135deg, rgba(255,255,255,.92), var(--pp-panel));
    border: var(--pp-border);
    border-radius: 26px;
    display: grid;
    place-items: center;
    position: relative;
    overflow: hidden;
  }
  .pp-product .pp-prod-photo img {
    max-height: 250px;
    max-width: 96%;
    object-fit: contain;
  }
  .pp-product .pp-tag {
    position: absolute;
    top: 10px; left: 10px;
    background: var(--pp-red);
    border: 3px solid #000;
    border-radius: 999px;
    padding: 5px 10px;
    font: 900 11px var(--pp-f-body);
    text-transform: uppercase;
    color: #000;
  }
  .pp-product .pp-formula {
    margin: 16px 0 0;
    font: 900 11px var(--pp-f-body);
    opacity: .72;
    text-transform: uppercase;
  }
  .pp-product h3 {
    font-family: var(--pp-f-head);
    font-size: 26px;
    line-height: .95;
    margin: 18px 0 10px;
    text-transform: uppercase;
    color: #000;
    text-shadow: none;
    min-height: 52px;
  }
  .pp-product h3 a { color: inherit; text-decoration: none; }
  .pp-product .pp-cat-line {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 10px 0 8px;
    font: 900 11px var(--pp-f-body);
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--pp-ink);
  }
  .pp-product .pp-cat-atom {
    width: 18px; height: 18px;
    border: 3px solid #000;
    border-radius: 999px;
    display: inline-grid;
    place-items: center;
    background: var(--pp-cat, #7c5cff);
    box-shadow: 2px 2px 0 #000;
    color: #000;
    font-size: 12px;
    line-height: 1;
  }
  .pp-product .pp-prod-desc {
    margin: 0;
    min-height: 92px;
    font: 800 13px var(--pp-f-body);
    line-height: 1.28;
    opacity: .88;
  }
  .pp-product .pp-buy {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 18px;
    gap: 12px;
  }
  .pp-product .pp-price {
    font: 900 24px var(--pp-f-body);
  }
  .pp-product .pp-price ins { text-decoration: none; }
  .pp-product .pp-price del { opacity: .55; font-size: 16px; margin-right: 6px; }
  .pp-product .pp-add {
    background: var(--pp-glow);
    border: var(--pp-border);
    border-radius: 13px;
    padding: 9px 15px;
    font: 900 13px var(--pp-f-body);
    text-transform: uppercase;
    color: #000;
    cursor: pointer;
    text-decoration: none;
    transition: .15s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }
  .pp-product .pp-add:hover { transform: translate(2px,2px); box-shadow: 2px 2px 0 #000; }
  .pp-product .pp-add.added::after { content: " ✓"; }
  .pp-product .pp-add.loading { opacity: .6; pointer-events: none; }
  .pp-feat-empty {
    color: var(--pp-paper);
    font: 800 16px var(--pp-f-body);
    grid-column: 1 / -1;
    text-align: center;
    padding: 30px 0;
  }
  @media (max-width: 620px) {
    .pp-feat .pp-feat-head { flex-direction: column; align-items: flex-start; }
  }
</style>
<section class="pp-section pp-bg-vault pp-feat">
  <div class="pp-wrap">
    <div class="pp-featured">
      <div class="pp-feat-head">
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
        <?php if ( $s['pill'] ) : ?>
          <div class="pp-stock"><?php echo esc_html( $s['pill'] ); ?></div>
        <?php endif; ?>
      </div>
      <div class="pp-prod-grid">
        <?php
        if ( $q->have_posts() ) :
          while ( $q->have_posts() ) : $q->the_post();
            $product = wc_get_product( get_the_ID() );
            if ( ! $product ) { continue; }

            $meta      = $this->resolve_card_meta( $product );
            $img_id    = $product->get_image_id();
            $img_url   = $img_id ? wp_get_attachment_image_url( $img_id, 'medium_large' ) : wc_placeholder_img_src( 'medium_large' );
            $permalink = get_permalink();
            $price_h   = $product->get_price_html();
            $add_url   = $product->add_to_cart_url();
            $add_text  = $product->add_to_cart_text();

            $add_classes = [ 'pp-add', 'product_type_' . $product->get_type() ];
            if ( $product->is_purchasable() && $product->is_in_stock() && $product->supports( 'ajax_add_to_cart' ) ) {
                $add_classes[] = 'ajax_add_to_cart';
            }

            $desc = $product->get_short_description();
            if ( ! $desc ) {
                $desc = wp_trim_words( wp_strip_all_tags( $product->get_description() ), 28, '…' );
            }
        ?>
        <div class="pp-product">
          <a class="pp-prod-photo" href="<?php echo esc_url( $permalink ); ?>" aria-label="<?php echo esc_attr( $product->get_name() ); ?>">
            <?php if ( $img_url ) : ?>
              <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" loading="lazy">
            <?php endif; ?>
            <?php if ( $meta['tag'] ) : ?>
              <span class="pp-tag"><?php echo esc_html( $meta['tag'] ); ?></span>
            <?php endif; ?>
          </a>
          <?php if ( $meta['formula'] ) : ?>
            <p class="pp-formula"><?php echo esc_html( $meta['formula'] ); ?></p>
          <?php endif; ?>
          <h3><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
          <?php if ( $meta['category_line'] ) : ?>
            <p class="pp-cat-line">
              <span class="pp-cat-atom" style="--pp-cat:<?php echo esc_attr( $meta['atom_color'] ); ?>">⚛</span>
              <span><?php echo esc_html( $meta['category_line'] ); ?></span>
            </p>
          <?php endif; ?>
          <?php if ( $desc ) : ?>
            <p class="pp-prod-desc"><?php echo wp_kses_post( $desc ); ?></p>
          <?php endif; ?>
          <div class="pp-buy">
            <span class="pp-price"><?php echo wp_kses_post( $price_h ); ?></span>
            <a href="<?php echo esc_url( $add_url ); ?>"
               data-quantity="1"
               data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
               data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
               class="<?php echo esc_attr( implode( ' ', $add_classes ) ); ?>"
               aria-label="<?php echo esc_attr( $add_text ); ?>"
               rel="nofollow"><?php echo esc_html__( 'Add', 'pp-atomic-blue' ); ?></a>
          </div>
        </div>
        <?php endwhile; wp_reset_postdata();
        else : ?>
          <p class="pp-feat-empty">No products found for the current filters.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
        <?php
    }
}
