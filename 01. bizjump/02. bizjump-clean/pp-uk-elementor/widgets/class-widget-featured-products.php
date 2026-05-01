<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Featured Products widget — design preview only.
 * NOTE: For live WooCommerce data use the WoodMart "WD Products" widget instead.
 * This widget is for page design / client approval / fallback display.
 */
class Widget_Featured_Products extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_05_featured_products'; }
    public function get_title()      { return '05 — Featured Products'; }
    public function get_icon()       { return 'eicon-products'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'products', 'shop', 'woocommerce', 'pp-uk' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Featured',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Most-ordered this month.',
        ] );
        $this->add_control( 'view_all_url', [
            'label'   => 'View All URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/shop/' ],
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'section_products', [
            'label' => 'Products',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'notice', [
            'label'       => 'ℹ️ Note',
            'type'        => \Elementor\Controls_Manager::RAW_HTML,
            'raw'         => '<div style="font-size:12px;color:#888;line-height:1.5;padding:8px 0;">For live WooCommerce data, use the <strong>WD Products</strong> widget (WoodMart). This widget is a static design preview only.</div>',
            'separator'   => 'none',
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'name',     [ 'label' => 'Name',     'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Peptide' ] );
        $rep->add_control( 'category', [ 'label' => 'Category', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Category · Lyophilised' ] );
        $rep->add_control( 'purity',   [ 'label' => 'Purity',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => '99.1% HPLC' ] );
        $rep->add_control( 'price',    [ 'label' => 'Price',    'type' => \Elementor\Controls_Manager::TEXT, 'default' => '£29.99' ] );
        $rep->add_control( 'url',      [ 'label' => 'URL',      'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '#' ] ] );
        $rep->add_control( 'stock',    [
            'label'   => 'Stock',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'in',
            'options' => [ 'in' => 'In Stock', 'low' => 'Low Stock', 'out' => 'Out of Stock' ],
        ] );
        $rep->add_control( 'image',    [ 'label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => [ 'url' => '' ] ] );
        $this->add_control( 'products', [
            'label'       => 'Products',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'name' => 'BPC-157 · 5mg',              'category' => 'Tissue & Repair · Lyophilised',  'purity' => '99.2% HPLC', 'price' => '£34.99', 'stock' => 'in',  'url' => [ 'url' => '#' ] ],
                [ 'name' => 'TB-500 · 5mg',               'category' => 'Tissue & Repair · Lyophilised',  'purity' => '99.0% HPLC', 'price' => '£39.99', 'stock' => 'in',  'url' => [ 'url' => '#' ] ],
                [ 'name' => 'CJC-1295 No-DAC · 5mg',      'category' => 'GH Peptides · Lyophilised',      'purity' => '98.7% HPLC', 'price' => '£44.99', 'stock' => 'low', 'url' => [ 'url' => '#' ] ],
                [ 'name' => 'Ipamorelin · 5mg',           'category' => 'GH Peptides · Lyophilised',      'purity' => '99.1% HPLC', 'price' => '£29.99', 'stock' => 'in',  'url' => [ 'url' => '#' ] ],
                [ 'name' => 'GHK-Cu · 50mg',              'category' => 'Longevity · Lyophilised',        'purity' => '99.4% HPLC', 'price' => '£24.99', 'stock' => 'in',  'url' => [ 'url' => '#' ] ],
                [ 'name' => 'Semaglutide · 5mg',          'category' => 'Metabolic · Lyophilised',        'purity' => '98.9% HPLC', 'price' => '£59.99', 'stock' => 'low', 'url' => [ 'url' => '#' ] ],
                [ 'name' => 'Selank · 10mg',              'category' => 'Cognitive · Lyophilised',        'purity' => '99.0% HPLC', 'price' => '£36.99', 'stock' => 'in',  'url' => [ 'url' => '#' ] ],
                [ 'name' => 'Bacteriostatic Water · 30ml','category' => 'Research Supply',               'purity' => 'USP Grade',   'price' => '£9.99',  'stock' => 'in',  'url' => [ 'url' => '#' ] ],
            ],
            'title_field' => '{{{ name }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $va_url = ! empty( $s['view_all_url']['url'] ) ? esc_url( $s['view_all_url']['url'] ) : '/shop/';
        $stock_labels = [ 'in' => 'In Stock', 'low' => 'Low Stock', 'out' => 'Out of Stock' ];
        ?>
<style>
  .pp-prods{background:var(--pp-surface);border-top:1px solid var(--pp-border);border-bottom:1px solid var(--pp-border)}
  .pp-prods-head{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:var(--pp-sp-48);flex-wrap:wrap;gap:var(--pp-sp-16)}
  .pp-prods-head .pp-eyebrow{margin-bottom:var(--pp-sp-8)}
  .pp-prods-head h2{margin:0}
  .pp-prod-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:var(--pp-sp-16)}
  .pp-prod{background:var(--pp-bg);border:1px solid var(--pp-border);border-radius:var(--pp-r);overflow:hidden;display:flex;flex-direction:column;transition:box-shadow 200ms var(--pp-ease),transform 200ms var(--pp-ease)}
  .pp-prod:hover{box-shadow:var(--pp-sh-2);transform:translateY(-2px)}
  .pp-prod-img{background:var(--pp-surface-2);aspect-ratio:1/1;overflow:hidden;position:relative;display:flex;align-items:center;justify-content:center}
  .pp-prod-img img{width:100%;height:100%;object-fit:contain;transition:transform 300ms var(--pp-ease)}
  .pp-prod:hover .pp-prod-img img{transform:scale(1.04)}
  .pp-prod-placeholder{font-family:var(--pp-f-mono);font-size:11px;color:var(--pp-ink-4);letter-spacing:.08em;text-transform:uppercase}
  .pp-prod-stock{font-family:var(--pp-f-mono);font-size:10px;letter-spacing:.08em;text-transform:uppercase;padding:3px 8px;position:absolute;top:12px;left:12px;border-radius:var(--pp-r-sm)}
  .pp-prod-stock.in{color:var(--pp-ok);background:rgba(26,107,58,.1)}
  .pp-prod-stock.low{color:var(--pp-warn);background:rgba(138,82,0,.1)}
  .pp-prod-stock.out{color:var(--pp-err);background:rgba(139,26,26,.1)}
  .pp-prod-body{padding:var(--pp-sp-16);flex:1;display:flex;flex-direction:column}
  .pp-prod-cat{font-family:var(--pp-f-mono);font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--pp-ink-3);margin-bottom:var(--pp-sp-8)}
  .pp-prod-name{font-size:15px;font-weight:600;color:var(--pp-ink);margin-bottom:var(--pp-sp-12);letter-spacing:-.01em;flex:1}
  .pp-prod-meta{display:flex;justify-content:space-between;align-items:center;padding-top:var(--pp-sp-12);border-top:1px solid var(--pp-border);margin-bottom:var(--pp-sp-12)}
  .pp-prod-purity{font-family:var(--pp-f-mono);font-size:11px;color:var(--pp-ink-3)}
  .pp-prod-price{font-size:17px;font-weight:600;color:var(--pp-ink);letter-spacing:-.02em}
  .pp-prod-cart{width:100%;padding:10px 16px;background:var(--pp-surface);border:1px solid var(--pp-border);border-radius:var(--pp-r-sm);font-family:var(--pp-f-sans);font-size:13px;font-weight:500;color:var(--pp-ink);cursor:pointer;transition:background 150ms,border-color 150ms;text-align:center}
  .pp-prod-cart:hover{background:var(--pp-ink);color:var(--pp-bg);border-color:var(--pp-ink)}
  @media(max-width:1024px){.pp-prod-grid{grid-template-columns:repeat(2,1fr);gap:var(--pp-sp-12)}}
  @media(max-width:900px){.pp-prods-head{margin-bottom:var(--pp-sp-32)}.pp-prod-name{font-size:14px}.pp-prod-price{font-size:15px}}
  @media(max-width:560px){.pp-prod-grid{grid-template-columns:repeat(2,1fr);gap:var(--pp-sp-8)}.pp-prod-body{padding:var(--pp-sp-12)}.pp-prod-cat{font-size:10px}.pp-prod-name{font-size:13px}}
  @media(max-width:400px){.pp-prod-grid{grid-template-columns:1fr}}
</style>
<section class="pp-section pp-prods pp-pad" id="products">
  <div class="pp-container">
    <div class="pp-prods-head pp-reveal">
      <div>
        <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
      </div>
      <a href="<?php echo $va_url; ?>" class="pp-btn pp-btn-secondary pp-btn-sm">View all</a>
    </div>
    <div class="pp-prod-grid">
      <?php foreach ( $s['products'] as $p ) :
        $p_img = ! empty( $p['image']['url'] ) ? esc_url( $p['image']['url'] ) : '';
        $stock_label = $stock_labels[ $p['stock'] ] ?? 'In Stock';
      ?>
      <div class="pp-prod pp-reveal">
        <div class="pp-prod-img">
          <span class="pp-prod-stock <?php echo esc_attr( $p['stock'] ); ?>">● <?php echo esc_html( $stock_label ); ?></span>
          <?php if ( $p_img ) : ?>
          <img src="<?php echo $p_img; ?>" alt="<?php echo esc_attr( $p['name'] ); ?>" loading="lazy" onerror="this.parentElement.innerHTML+='<span class=\'pp-prod-placeholder\'>Product Image</span>'">
          <?php else : ?>
          <span class="pp-prod-placeholder">Product Image</span>
          <?php endif; ?>
        </div>
        <div class="pp-prod-body">
          <div class="pp-prod-cat"><?php echo esc_html( $p['category'] ); ?></div>
          <div class="pp-prod-name"><?php echo esc_html( $p['name'] ); ?></div>
          <div class="pp-prod-meta">
            <span class="pp-prod-purity"><?php echo esc_html( $p['purity'] ); ?></span>
            <span class="pp-prod-price"><?php echo esc_html( $p['price'] ); ?></span>
          </div>
          <button class="pp-prod-cart" type="button"><?php esc_html_e( 'Add to Cart', 'pp-uk-elementor' ); ?></button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
