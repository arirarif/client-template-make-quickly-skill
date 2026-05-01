<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Hero extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_02_hero'; }
    public function get_title()      { return '02 — Hero'; }
    public function get_icon()       { return 'eicon-banner'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'hero', 'banner', 'pp-uk' ]; }

    protected function register_controls() {

        /* ── Hero text ── */
        $this->start_controls_section( 'section_text', [
            'label' => 'Hero Text',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'UK · Research Grade · Est. 2026',
        ] );
        $this->add_control( 'headline', [
            'label'   => 'Headline',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Research-grade peptides. Independently verified.',
            'rows'    => 2,
        ] );
        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => '32 compounds. HPLC-tested by third-party labs. Shipped from the UK in discreet, sterile packaging. Built for researchers who care about purity.',
            'rows'    => 3,
        ] );
        $this->end_controls_section();

        /* ── CTA ── */
        $this->start_controls_section( 'section_cta', [
            'label' => 'CTA Buttons',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'btn1_text', [
            'label'   => 'Primary Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Browse Products',
        ] );
        $this->add_control( 'btn1_url', [
            'label'   => 'Primary Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#products' ],
        ] );
        $this->add_control( 'btn2_text', [
            'label'   => 'Ghost Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'How it works →',
        ] );
        $this->add_control( 'btn2_url', [
            'label'   => 'Ghost Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#how' ],
        ] );
        $this->end_controls_section();

        /* ── Trust stats ── */
        $this->start_controls_section( 'section_stats', [
            'label' => 'Trust Stats',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'num',   [ 'label' => 'Number / Value', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '99.2%' ] );
        $rep->add_control( 'label', [ 'label' => 'Label',          'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Avg. Purity' ] );
        $this->add_control( 'stats', [
            'label'       => 'Stats',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'num' => '99.2%', 'label' => 'Avg. Purity' ],
                [ 'num' => '32',    'label' => 'Compounds' ],
                [ 'num' => '3rd',   'label' => 'Party Tested' ],
                [ 'num' => 'UK',    'label' => 'Shipped' ],
            ],
            'title_field' => '{{{ num }}} — {{{ label }}}',
        ] );
        $this->end_controls_section();

        /* ── Product card visual ── */
        $this->start_controls_section( 'section_card', [
            'label' => 'Featured Product Card',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'card_stock', [
            'label'   => 'Stock Status',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'in',
            'options' => [ 'in' => 'In Stock', 'low' => 'Low Stock', 'out' => 'Out of Stock' ],
        ] );
        $this->add_control( 'card_image', [
            'label'   => 'Vial Image',
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => 'https://images.unsplash.com/photo-1631549916768-4119b2e5f926?w=600&q=80&auto=format&fit=crop' ],
        ] );
        $this->add_control( 'card_name', [
            'label'   => 'Product Name',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'BPC-157 · 5mg',
        ] );
        $this->add_control( 'card_sub', [
            'label'   => 'Product Sub',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Tissue & Repair · Lyophilised',
        ] );
        $this->add_control( 'card_purity', [
            'label'   => 'Purity',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '99.2% HPLC',
        ] );
        $this->add_control( 'card_price', [
            'label'   => 'Price',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '£34.99',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s      = $this->get_settings_for_display();
        $b1_url = ! empty( $s['btn1_url']['url'] ) ? esc_url( $s['btn1_url']['url'] ) : '#';
        $b1_tgt = ! empty( $s['btn1_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
        $b2_url = ! empty( $s['btn2_url']['url'] ) ? esc_url( $s['btn2_url']['url'] ) : '#';
        $b2_tgt = ! empty( $s['btn2_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
        $img    = ! empty( $s['card_image']['url'] ) ? esc_url( $s['card_image']['url'] ) : '';

        $stock_labels = [ 'in' => 'In Stock', 'low' => 'Low Stock', 'out' => 'Out of Stock' ];
        $stock_label  = $stock_labels[ $s['card_stock'] ] ?? 'In Stock';
        ?>
<style>
  .pp-hero{background:var(--pp-bg)}
  .pp-hero-grid{display:grid;grid-template-columns:1.1fr 1fr;gap:var(--pp-sp-96);align-items:center}
  .pp-hero-meta{font-family:var(--pp-f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--pp-ink-3);display:flex;align-items:center;gap:var(--pp-sp-12);margin-bottom:var(--pp-sp-24)}
  .pp-hero-meta::before{content:'';width:32px;height:1px;background:var(--pp-ink-3)}
  .pp-hero h1{margin-bottom:var(--pp-sp-24)}
  .pp-hero-sub{font-size:18px;color:var(--pp-ink-2);max-width:480px;margin-bottom:var(--pp-sp-32)}
  .pp-hero-cta{display:flex;gap:var(--pp-sp-12);align-items:center;flex-wrap:wrap;margin-bottom:var(--pp-sp-48)}
  .pp-hero-trust{display:flex;gap:var(--pp-sp-32);padding-top:var(--pp-sp-32);border-top:1px solid var(--pp-border);flex-wrap:wrap}
  .pp-hero-trust>div{display:flex;flex-direction:column;gap:var(--pp-sp-4)}
  .pp-hero-trust .pp-num{font-size:24px;font-weight:600;color:var(--pp-ink);letter-spacing:-0.02em}
  .pp-hero-trust .pp-lbl{font-family:var(--pp-f-mono);font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--pp-ink-3)}
  .pp-hero-visual{position:relative;aspect-ratio:4/5;background:var(--pp-surface);border:1px solid var(--pp-border);border-radius:var(--pp-r-lg);padding:var(--pp-sp-32);display:flex;flex-direction:column;justify-content:space-between;box-shadow:var(--pp-sh-2)}
  .pp-hv-tag{position:absolute;top:var(--pp-sp-16);right:var(--pp-sp-16);font-family:var(--pp-f-mono);font-size:11px;letter-spacing:.08em;padding:4px 10px;border-radius:var(--pp-r-sm);text-transform:uppercase}
  .pp-hv-tag.in{color:var(--pp-ok);background:rgba(26,107,58,.08)}
  .pp-hv-tag.low{color:var(--pp-warn);background:rgba(138,82,0,.08)}
  .pp-hv-tag.out{color:var(--pp-err);background:rgba(139,26,26,.08)}
  .pp-hv-vial{flex:1;display:flex;align-items:center;justify-content:center}
  .pp-hv-vial img{max-height:320px;width:auto;filter:grayscale(.1)}
  .pp-hv-meta{border-top:1px solid var(--pp-border);padding-top:var(--pp-sp-16);display:grid;grid-template-columns:1fr 1fr;gap:var(--pp-sp-16);margin:0}
  .pp-hv-meta dt{font-family:var(--pp-f-mono);font-size:10px;letter-spacing:.1em;text-transform:uppercase;color:var(--pp-ink-3);margin-bottom:2px}
  .pp-hv-meta dd{font-size:14px;font-weight:500;color:var(--pp-ink);margin:0}
  .pp-hv-name{font-size:18px;font-weight:600;margin-bottom:2px;color:var(--pp-ink)}
  .pp-hv-sub{font-family:var(--pp-f-mono);font-size:11px;color:var(--pp-ink-3);letter-spacing:.08em;text-transform:uppercase;margin-bottom:var(--pp-sp-16)}
  @media(max-width:1024px){.pp-hero-grid{gap:var(--pp-sp-48)}}
  @media(max-width:900px){
    .pp-hero-grid{grid-template-columns:1fr;gap:var(--pp-sp-48)}
    .pp-hero-meta{font-size:11px;margin-bottom:var(--pp-sp-16)}
    .pp-hero-meta::before{width:20px}
    .pp-hero-sub{font-size:16px;margin-bottom:var(--pp-sp-24)}
    .pp-hero-cta{margin-bottom:var(--pp-sp-32);gap:var(--pp-sp-8)}
    .pp-hero-trust{gap:var(--pp-sp-24);padding-top:var(--pp-sp-24)}
    .pp-hero-trust .pp-num{font-size:20px}
    .pp-hero-visual{max-width:380px;margin:0 auto;padding:var(--pp-sp-24);aspect-ratio:4/4.5}
    .pp-hv-vial img{max-height:240px}
  }
  @media(max-width:768px){.pp-hero-trust{display:grid;grid-template-columns:repeat(2,1fr);gap:var(--pp-sp-16)}}
  @media(max-width:560px){
    .pp-hero-sub{font-size:15px}
    .pp-hero-cta{flex-direction:column;align-items:stretch}
    .pp-hero-cta .pp-btn{width:100%}
    .pp-hero-cta .pp-btn-ghost{padding:8px 0}
    .pp-hero-visual{max-width:100%;padding:var(--pp-sp-16);aspect-ratio:auto}
    .pp-hv-tag{top:var(--pp-sp-12);right:var(--pp-sp-12);font-size:10px}
    .pp-hv-vial{padding:var(--pp-sp-24) 0}
    .pp-hv-vial img{max-height:180px}
    .pp-hv-name{font-size:16px}
  }
</style>
<section class="pp-section pp-hero pp-pad-lg">
  <div class="pp-container">
    <div class="pp-hero-grid">
      <div class="pp-hero-text pp-reveal">
        <div class="pp-hero-meta"><?php echo esc_html( $s['eyebrow'] ); ?></div>
        <h1><?php echo esc_html( $s['headline'] ); ?></h1>
        <p class="pp-hero-sub"><?php echo esc_html( $s['subtitle'] ); ?></p>
        <div class="pp-hero-cta">
          <a href="<?php echo $b1_url; ?>"<?php echo $b1_tgt; ?> class="pp-btn pp-btn-primary"><?php echo esc_html( $s['btn1_text'] ); ?></a>
          <a href="<?php echo $b2_url; ?>"<?php echo $b2_tgt; ?> class="pp-btn pp-btn-ghost"><?php echo esc_html( $s['btn2_text'] ); ?></a>
        </div>
        <div class="pp-hero-trust">
          <?php foreach ( $s['stats'] as $stat ) : ?>
          <div>
            <span class="pp-num"><?php echo esc_html( $stat['num'] ); ?></span>
            <span class="pp-lbl"><?php echo esc_html( $stat['label'] ); ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="pp-hero-visual pp-reveal" aria-label="Featured product">
        <span class="pp-hv-tag <?php echo esc_attr( $s['card_stock'] ); ?>">● <?php echo esc_html( $stock_label ); ?></span>
        <div class="pp-hv-vial">
          <?php if ( $img ) : ?>
          <img src="<?php echo $img; ?>" alt="<?php echo esc_attr( $s['card_name'] ); ?>" onerror="this.style.display='none'">
          <?php endif; ?>
        </div>
        <div>
          <div class="pp-hv-name"><?php echo esc_html( $s['card_name'] ); ?></div>
          <div class="pp-hv-sub"><?php echo esc_html( $s['card_sub'] ); ?></div>
          <dl class="pp-hv-meta">
            <div><dt>Purity</dt><dd><?php echo esc_html( $s['card_purity'] ); ?></dd></div>
            <div><dt>Price</dt><dd><?php echo esc_html( $s['card_price'] ); ?></dd></div>
          </dl>
        </div>
      </div>
    </div>
  </div>
</section>
        <?php
    }
}
