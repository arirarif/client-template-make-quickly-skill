<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 07 — Pricing Cards
 * 4-column pricing grid: Basic, Pro, Premium (featured), Enterprise.
 * Each card has a features list, CTA button style (outline/solid/orange).
 */
class Widget_Pricing_Cards extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_07_pricing'; }
    public function get_title()      { return '07 — Pricing Cards'; }
    public function get_icon()       { return 'eicon-price-table'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'pricing', 'plans', 'cards', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        /* ── Header ── */
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'section_label', [
            'label'   => 'Section Label (eyebrow)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Transparent Pricing',
        ] );

        $this->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Simple Flat-Rate Plans',
        ] );

        $this->add_control( 'note', [
            'label'   => 'Note (below title)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '+ state filing fee (varies by state) · No hidden charges. Ever.',
        ] );

        $this->end_controls_section();

        /* ── Plans ── */
        $this->start_controls_section( 'section_plans', [
            'label' => 'Pricing Plans',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'name', [
            'label'   => 'Plan Name',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Basic',
        ] );

        $rep->add_control( 'price', [
            'label'   => 'Price (number only)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '99',
        ] );

        $rep->add_control( 'period', [
            'label'   => 'Period text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'one-time · + state fee',
        ] );

        $rep->add_control( 'sub_price', [
            'label'   => 'Sub-price text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '7–10 business day processing',
        ] );

        $rep->add_control( 'is_featured', [
            'label'        => 'Featured Card',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => 'Yes',
            'label_off'    => 'No',
            'return_value' => 'yes',
            'default'      => '',
        ] );

        $rep->add_control( 'badge_text', [
            'label'       => 'Badge Text (if featured)',
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => '⭐ Most Popular',
            'condition'   => [ 'is_featured' => 'yes' ],
        ] );

        $rep->add_control( 'features', [
            'label'       => 'Features (one per line)',
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => "Articles of Incorporation filing\nName availability check\nLifetime customer support\nDigital document delivery",
            'rows'        => 6,
            'description' => 'Enter one feature per line.',
        ] );

        $rep->add_control( 'cta_text', [
            'label'   => 'Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Get Started',
        ] );

        $rep->add_control( 'cta_url', [
            'label'   => 'Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/incorporate/' ],
        ] );

        $rep->add_control( 'cta_style', [
            'label'   => 'Button Style',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'outline',
            'options' => [
                'outline' => 'Outline (light)',
                'solid'   => 'Solid Blue',
                'orange'  => 'Orange (CTA)',
            ],
        ] );

        $rep->add_control( 'time_note', [
            'label'   => 'Turnaround Note',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '⏱ 7–10 business days',
        ] );

        $this->add_control( 'plans', [
            'label'       => 'Plans',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'name'       => 'Basic',
                    'price'      => '99',
                    'period'     => 'one-time · + state fee',
                    'sub_price'  => '7–10 business day processing',
                    'is_featured'=> '',
                    'badge_text' => '',
                    'features'   => "Articles of Incorporation filing\nName availability check\nLifetime customer support\nDigital document delivery",
                    'cta_text'   => 'Get Started',
                    'cta_url'    => [ 'url' => '/incorporate/?plan=plan_basic' ],
                    'cta_style'  => 'outline',
                    'time_note'  => '⏱ 7–10 business days',
                ],
                [
                    'name'       => 'Pro',
                    'price'      => '195',
                    'period'     => 'one-time · + state fee',
                    'sub_price'  => '5 business day processing',
                    'is_featured'=> '',
                    'badge_text' => '',
                    'features'   => "Everything in Basic\nEIN / Tax ID number\nOperating Agreement\nRegistered Agent (1 year)\nPriority processing (5 days)",
                    'cta_text'   => 'Get Started',
                    'cta_url'    => [ 'url' => '/incorporate/?plan=plan_pro' ],
                    'cta_style'  => 'solid',
                    'time_note'  => '⏱ 5 business days',
                ],
                [
                    'name'       => 'Premium',
                    'price'      => '295',
                    'period'     => 'one-time · + state fee',
                    'sub_price'  => 'Rush 1-day processing',
                    'is_featured'=> 'yes',
                    'badge_text' => '⭐ Most Popular',
                    'features'   => "Everything in Pro\nRush 1-day filing\nBusiness bank account setup\nCompliance calendar alerts\nDedicated account manager\nExpedited state filing",
                    'cta_text'   => 'Get Started →',
                    'cta_url'    => [ 'url' => '/incorporate/?plan=plan_premium' ],
                    'cta_style'  => 'orange',
                    'time_note'  => '⚡ Rush: 1 business day',
                ],
                [
                    'name'       => 'Enterprise',
                    'price'      => '295',
                    'period'     => 'one-time · + state fee',
                    'sub_price'  => '+ $29/month ongoing services · Rush 1-day',
                    'is_featured'=> '',
                    'badge_text' => '',
                    'features'   => "Everything in Premium\nMonthly compliance monitoring\nAnnual report reminders\nOngoing registered agent\nPriority phone support\nMulti-state filing support",
                    'cta_text'   => 'Get Started',
                    'cta_url'    => [ 'url' => '/incorporate/?plan=plan_enterprise' ],
                    'cta_style'  => 'solid',
                    'time_note'  => '⚡ Rush: 1 business day',
                ],
            ],
            'title_field' => '{{{ name }}} — ${{{ price }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.bjw08-wrap {
  font-family: 'Inter', sans-serif;
  max-width: 1160px;
  margin: 0 auto;
  padding: 0 24px;
}
/* Header */
.bjw08-header { text-align: center; margin-bottom: 52px; }
.bjw08-label {
  font-size: 12px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: #2563eb;
  margin-bottom: 10px; display: block;
}
.bjw08-title {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: clamp(28px, 3.5vw, 42px);
  font-weight: 800; color: #111827;
  letter-spacing: -0.8px; line-height: 1.18;
  margin-bottom: 12px;
}
.bjw08-note { font-size: 15px; color: #6b7280; }
.bjw08-note strong { color: #111827; }
/* Grid */
.bjw08-grid {
  display: grid;
  grid-template-columns: repeat(<?php echo count( $s['plans'] ); ?>, 1fr);
  gap: 20px;
  align-items: start;
}
/* Card base */
.bjw08-card {
  background: #fff;
  border: 1.5px solid #e5e7eb;
  border-radius: 20px;
  padding: 32px 24px 28px;
  position: relative;
}
.bjw08-card:hover {
  box-shadow: 0 8px 40px rgba(0,0,0,.1);
  transform: translateY(-4px);
}
/* FEATURED card */
.bjw08-card.bjw08-featured {
  border-color: #2563eb;
  box-shadow: 0 8px 32px rgba(37,99,235,.18);
  transform: scale(1.03);
  z-index: 2;
}
.bjw08-card.bjw08-featured:hover {
  transform: scale(1.03) translateY(-4px);
  box-shadow: 0 14px 48px rgba(37,99,235,.24);
}
/* Popular badge */
.bjw08-badge {
  position: absolute; top: -13px; left: 50%; transform: translateX(-50%);
  background: #2563eb; color: #fff;
  font-size: 11px; font-weight: 700; letter-spacing: .5px;
  padding: 5px 16px; border-radius: 100px;
  white-space: nowrap;
}
/* Plan name */
.bjw08-plan-name {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 17px; font-weight: 700; color: #111827;
  margin-bottom: 4px;
}
/* Price area */
.bjw08-price-row {
  margin-bottom: 4px; display: flex; align-items: baseline; gap: 4px;
}
.bjw08-dollar { font-size: 20px; font-weight: 700; color: #0f2156; margin-top: 12px; }
.bjw08-amount {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 46px; font-weight: 800; color: #0f2156; line-height: 1;
}
.bjw08-period { font-size: 13px; color: #6b7280; margin-top: 4px; }
.bjw08-sub-price { font-size: 12px; color: #6b7280; margin-bottom: 20px; }
/* Features list */
.bjw08-features {
  list-style: none; margin: 0 0 28px; padding: 0;
  display: flex; flex-direction: column; gap: 10px;
}
.bjw08-features li {
  display: flex; align-items: flex-start; gap: 10px;
  font-size: 14px; color: #374151;
}
.bjw08-features li::before {
  content: '✓';
  background: #eff6ff; color: #2563eb;
  width: 20px; height: 20px; border-radius: 50%;
  flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; font-weight: 800;
  margin-top: 1px;
}
/* Divider */
.bjw08-div { border: none; border-top: 1px solid #f3f4f6; margin: 0 0 20px; }
/* CTA Button */
.bjw08-cta {
  display: block; width: 100%;
  padding: 14px; border-radius: 10px;
  text-align: center; font-size: 15px; font-weight: 700;
  text-decoration: none; cursor: pointer;
  transition: background .2s, transform .15s, box-shadow .2s;
  font-family: 'Inter', sans-serif;
}
.bjw08-cta-outline {
  background: #f9fafb; color: #0f2156;
  border: 2px solid #e5e7eb;
}
.bjw08-cta-outline:hover {
  background: #eff6ff; border-color: #2563eb; color: #2563eb;
}
.bjw08-cta-solid {
  background: #2563eb; color: #fff;
  border: 2px solid #2563eb;
  box-shadow: 0 4px 16px rgba(37,99,235,.3);
}
.bjw08-cta-solid:hover {
  background: #1d4ed8;
  box-shadow: 0 6px 24px rgba(37,99,235,.4);
  transform: translateY(-1px);
  color: #fff;
}
.bjw08-cta-orange {
  background: #f97316; color: #fff;
  border: 2px solid #f97316;
  box-shadow: 0 4px 16px rgba(249,115,22,.3);
}
.bjw08-cta-orange:hover {
  background: #ea6c00; border-color: #ea6c00;
  box-shadow: 0 6px 24px rgba(249,115,22,.4);
  transform: translateY(-1px);
  color: #fff;
}
/* Turnaround note */
.bjw08-time {
  text-align: center; margin-top: 12px;
  font-size: 12px; color: #9ca3af;
}
/* Scroll reveal */
.bjw08-card { opacity: 0; transform: translateY(24px); }
.bjw08-card.bjw08-visible { opacity: 1; }
.bjw08-card {
  transition: opacity .55s ease, transform .55s ease, box-shadow .25s;
}
.bjw08-card.bjw08-featured { transform: scale(1.03) translateY(24px); }
.bjw08-card.bjw08-featured.bjw08-visible { transform: scale(1.03) translateY(0); }
.bjw08-card:nth-child(2) { transition-delay: .08s; }
.bjw08-card:nth-child(3) { transition-delay: .16s; }
.bjw08-card:nth-child(4) { transition-delay: .24s; }
/* Responsive */
@media (max-width: 1024px) {
  .bjw08-grid { grid-template-columns: repeat(2, 1fr); }
  .bjw08-card.bjw08-featured { transform: scale(1) translateY(24px); }
  .bjw08-card.bjw08-featured.bjw08-visible { transform: scale(1) translateY(0); }
  .bjw08-card.bjw08-featured:hover { transform: translateY(-4px); }
}
@media (max-width: 640px) {
  .bjw08-grid { grid-template-columns: 1fr; }
  .bjw08-wrap { padding: 0 16px; }
}
</style>

<div class="bjw08-wrap" id="pricing">

  <!-- Header -->
  <div class="bjw08-header">
    <span class="bjw08-label"><?php echo esc_html( $s['section_label'] ); ?></span>
    <h2 class="bjw08-title"><?php echo esc_html( $s['title'] ); ?></h2>
    <p class="bjw08-note"><?php echo esc_html( $s['note'] ); ?></p>
  </div>

  <!-- Cards -->
  <div class="bjw08-grid">
    <?php foreach ( $s['plans'] as $plan ) :
        $featured   = ( 'yes' === $plan['is_featured'] );
        $cta_url    = ! empty( $plan['cta_url']['url'] ) ? esc_url( $plan['cta_url']['url'] ) : '#';
        $cta_tgt    = ! empty( $plan['cta_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        $cta_class  = 'bjw08-cta bjw08-cta-' . esc_attr( $plan['cta_style'] );

        /* Parse features textarea into lines */
        $features_raw  = isset( $plan['features'] ) ? $plan['features'] : '';
        $features_list = array_filter( array_map( 'trim', explode( "\n", $features_raw ) ) );
    ?>
    <div class="bjw08-card<?php echo $featured ? ' bjw08-featured' : ''; ?>">
      <?php if ( $featured && ! empty( $plan['badge_text'] ) ) : ?>
      <div class="bjw08-badge"><?php echo esc_html( $plan['badge_text'] ); ?></div>
      <?php endif; ?>
      <div class="bjw08-plan-name"><?php echo esc_html( $plan['name'] ); ?></div>
      <div class="bjw08-price-row">
        <span class="bjw08-dollar">$</span>
        <span class="bjw08-amount"><?php echo esc_html( $plan['price'] ); ?></span>
      </div>
      <div class="bjw08-period"><?php echo esc_html( $plan['period'] ); ?></div>
      <div class="bjw08-sub-price"><?php echo esc_html( $plan['sub_price'] ); ?></div>
      <hr class="bjw08-div">
      <ul class="bjw08-features">
        <?php foreach ( $features_list as $feat ) : ?>
        <li><?php echo esc_html( $feat ); ?></li>
        <?php endforeach; ?>
      </ul>
      <a href="<?php echo $cta_url; ?>"<?php echo $cta_tgt; ?> class="<?php echo $cta_class; ?>"><?php echo esc_html( $plan['cta_text'] ); ?></a>
      <?php if ( ! empty( $plan['time_note'] ) ) : ?>
      <div class="bjw08-time"><?php echo esc_html( $plan['time_note'] ); ?></div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>

</div>

<script>
(function(){
  var cards = document.querySelectorAll('.bjw08-card');
  var obs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if(e.isIntersecting){ e.target.classList.add('bjw08-visible'); obs.unobserve(e.target); }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });
  cards.forEach(function(c){ obs.observe(c); });
})();
</script>
        <?php
    }
}
