<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 21 — Shipping: Tiers
 * 3-column delivery option cards + optional free shipping threshold banner.
 */
class Widget_Shipping_Tiers extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_21_shipping_tiers'; }
    public function get_title()      { return '21 — Shipping: Tiers'; }
    public function get_icon()       { return 'eicon-cart-medium'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'shipping', 'delivery', 'tiers', 'pricing', 'pp-uk' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Delivery Options',
        ] );

        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Choose your service.',
        ] );

        $this->end_controls_section();

        /* ── Tiers ── */
        $this->start_controls_section( 'section_tiers', [
            'label' => 'Delivery Tiers',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'badge',       [ 'label' => 'Badge',          'type' => \Elementor\Controls_Manager::TEXT,    'default' => 'Standard' ] );
        $rep->add_control( 'name',        [ 'label' => 'Tier Name',      'type' => \Elementor\Controls_Manager::TEXT,    'default' => 'Standard Tracked' ] );
        $rep->add_control( 'time',        [ 'label' => 'Delivery Time',  'type' => \Elementor\Controls_Manager::TEXT,    'default' => '2–3 business days' ] );
        $rep->add_control( 'price',       [ 'label' => 'Price',          'type' => \Elementor\Controls_Manager::TEXT,    'default' => '£4.95' ] );
        $rep->add_control( 'price_note',  [ 'label' => 'Price Note',     'type' => \Elementor\Controls_Manager::TEXT,    'default' => 'Free on orders over £75' ] );
        $rep->add_control( 'features',    [ 'label' => 'Features (one per line)', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Full parcel tracking\nTemperature-controlled packaging\nPlain unmarked outer packaging\nCOA included", 'rows' => 6 ] );
        $rep->add_control( 'is_featured', [
            'label'        => 'Featured (dark style)',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ] );

        $this->add_control( 'tiers', [
            'label'       => 'Tiers',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'badge'      => 'Standard',
                    'name'       => 'Standard Tracked',
                    'time'       => '2–3 business days',
                    'price'      => '£4.95',
                    'price_note' => 'Free on orders over £75',
                    'features'   => "Full parcel tracking\nTemperature-controlled packaging\nPlain unmarked outer packaging\nCOA included with order",
                    'is_featured'=> '',
                ],
                [
                    'badge'      => 'Most Popular',
                    'name'       => 'Express',
                    'time'       => 'Next business day',
                    'price'      => '£9.95',
                    'price_note' => 'Order before 1pm for same-day dispatch',
                    'features'   => "Priority next business day delivery\nFull parcel tracking + SMS updates\nEnhanced cold-pack packaging\nSignature on delivery\nCOA included with order",
                    'is_featured'=> 'yes',
                ],
                [
                    'badge'      => 'Weekend',
                    'name'       => 'Saturday Delivery',
                    'time'       => 'Saturday, guaranteed',
                    'price'      => '£14.95',
                    'price_note' => 'Order before 1pm Friday',
                    'features'   => "Guaranteed Saturday delivery\nFull parcel tracking + SMS updates\nEnhanced cold-pack packaging\nSignature on delivery\nCOA included with order",
                    'is_featured'=> '',
                ],
            ],
            'title_field' => '{{{ name }}} — {{{ price }}}',
        ] );

        $this->end_controls_section();

        /* ── Free shipping banner ── */
        $this->start_controls_section( 'section_banner', [
            'label' => 'Free Shipping Banner',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'show_banner', [
            'label'        => 'Show Banner',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'banner_text', [
            'label'     => 'Banner Text',
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => 'Free standard shipping on all orders over £75. Automatically applied at checkout — no code required.',
            'condition' => [ 'show_banner' => 'yes' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-ship-tiers{background:var(--pp-bg)}
  .pp-ship-head{max-width:640px;margin-bottom:var(--pp-sp-48)}
  .pp-ship-head h2{margin-top:var(--pp-sp-16)}
  .pp-tiers-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:var(--pp-sp-16)}
  .pp-tier{background:var(--pp-surface);border:1px solid var(--pp-border);border-radius:var(--pp-r-lg);padding:var(--pp-sp-32);display:flex;flex-direction:column;transition:border-color 150ms var(--pp-ease),box-shadow 150ms var(--pp-ease)}
  .pp-tier:hover{border-color:var(--pp-border-2);box-shadow:var(--pp-sh-2)}
  .pp-tier.pp-featured{background:var(--pp-ink);border-color:var(--pp-ink)}
  .pp-tier-badge{font-family:var(--pp-f-mono);font-size:10px;font-weight:500;letter-spacing:.1em;text-transform:uppercase;padding:4px 10px;border-radius:var(--pp-r-sm);background:var(--pp-surface-2);color:var(--pp-ink-3);display:inline-block;margin-bottom:var(--pp-sp-24);align-self:flex-start}
  .pp-featured .pp-tier-badge{background:rgba(255,255,255,.12);color:rgba(250,250,248,.7)}
  .pp-tier h3{font-size:22px;margin-bottom:var(--pp-sp-8)}
  .pp-featured h3{color:var(--pp-bg)}
  .pp-tier-time{font-family:var(--pp-f-mono);font-size:13px;color:var(--pp-ink-3);margin-bottom:var(--pp-sp-24)}
  .pp-featured .pp-tier-time{color:rgba(250,250,248,.5)}
  .pp-tier-price{font-size:32px;font-weight:600;letter-spacing:-0.03em;margin-bottom:4px}
  .pp-featured .pp-tier-price{color:var(--pp-bg)}
  .pp-tier-price-note{font-size:13px;color:var(--pp-ink-3);margin-bottom:var(--pp-sp-32)}
  .pp-featured .pp-tier-price-note{color:rgba(250,250,248,.45)}
  .pp-tier hr{border:none;border-top:1px solid var(--pp-border);margin-bottom:var(--pp-sp-24)}
  .pp-featured hr{border-top-color:rgba(255,255,255,.12)}
  .pp-tier-features{display:flex;flex-direction:column;gap:var(--pp-sp-12);flex:1}
  .pp-tier-feat{display:flex;align-items:center;gap:var(--pp-sp-12);font-size:14px;color:var(--pp-ink-2)}
  .pp-featured .pp-tier-feat{color:rgba(250,250,248,.75)}
  .pp-tier-feat::before{content:'';width:16px;height:16px;flex-shrink:0;background-color:var(--pp-ok);mask-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M5 13l4 4L19 7'/%3E%3C/svg%3E");mask-size:contain;mask-repeat:no-repeat;-webkit-mask-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M5 13l4 4L19 7'/%3E%3C/svg%3E");-webkit-mask-size:contain;-webkit-mask-repeat:no-repeat}
  .pp-featured .pp-tier-feat::before{background-color:rgba(250,250,248,.55)}
  /* Banner */
  .pp-free-ship{background:var(--pp-accent-2);border:1px solid rgba(30,58,95,.12);border-radius:var(--pp-r);padding:var(--pp-sp-20) var(--pp-sp-24);display:flex;align-items:center;gap:var(--pp-sp-16);margin-top:var(--pp-sp-24)}
  .pp-free-ship svg{width:20px;height:20px;color:var(--pp-accent);flex-shrink:0}
  .pp-free-ship p{font-size:14px;color:var(--pp-accent)}
  @media(max-width:900px){.pp-tiers-grid{grid-template-columns:1fr}}
</style>
<section class="pp-section pp-ship-tiers pp-pad">
  <div class="pp-container">
    <div class="pp-ship-head pp-reveal">
      <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
      <h2><?php echo esc_html( $s['heading'] ); ?></h2>
    </div>
    <div class="pp-tiers-grid">
      <?php foreach ( $s['tiers'] as $i => $tier ) :
        $featured   = ( 'yes' === $tier['is_featured'] ) ? ' pp-featured' : '';
        $delay      = $i * 60;
        $feat_lines = array_filter( array_map( 'trim', explode( "\n", $tier['features'] ) ) );
      ?>
      <div class="pp-tier<?php echo esc_attr( $featured ); ?> pp-reveal" style="transition-delay:<?php echo $delay; ?>ms">
        <span class="pp-tier-badge"><?php echo esc_html( $tier['badge'] ); ?></span>
        <h3><?php echo esc_html( $tier['name'] ); ?></h3>
        <div class="pp-tier-time"><?php echo esc_html( $tier['time'] ); ?></div>
        <div class="pp-tier-price"><?php echo esc_html( $tier['price'] ); ?></div>
        <div class="pp-tier-price-note"><?php echo esc_html( $tier['price_note'] ); ?></div>
        <hr>
        <div class="pp-tier-features">
          <?php foreach ( $feat_lines as $feat ) : ?>
          <div class="pp-tier-feat"><?php echo esc_html( $feat ); ?></div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <?php if ( 'yes' === $s['show_banner'] && $s['banner_text'] ) : ?>
    <div class="pp-free-ship pp-reveal">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
      <p><?php echo esc_html( $s['banner_text'] ); ?></p>
    </div>
    <?php endif; ?>
  </div>
</section>
        <?php
    }
}
