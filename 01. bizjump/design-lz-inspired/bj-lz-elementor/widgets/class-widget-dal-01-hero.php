<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DAL-01 — Hero (Doc-Aligned Landing, centered glass)
 * Source: 03. bizjump-doc-aligned/demo-landing.html — .hero section.
 * Full-bleed background image, dark gradient overlay, glass badge,
 * gradient-word headline, subtitle, pill CTAs, fine-print note.
 * Includes the original heroFadeIn staggered animation (d1–d4).
 */
class Widget_DAL_Hero extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dal_01_hero'; }
    public function get_title()      { return 'DAL 01 — Hero (Centered Glass)'; }
    public function get_icon()       { return 'eicon-banner'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'hero', 'banner', 'centered', 'gradient', 'bizjump', 'dal', 'doc-aligned' ]; }

    protected function register_controls() {

        /* ── Background ── */
        $this->start_controls_section( 'sec_bg', [
            'label' => 'Background',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'bg_image', [
            'label'   => 'Background Image',
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1920&q=85',
            ],
        ] );
        $this->add_control( 'min_height', [
            'label'   => 'Minimum Height (px)',
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 700,
            'min'     => 400,
            'max'     => 1200,
        ] );
        $this->add_control( 'overlay_top', [
            'label'   => 'Overlay Top Opacity (0-1)',
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 0.55,
            'min'     => 0, 'max' => 1, 'step' => 0.05,
        ] );
        $this->add_control( 'overlay_mid', [
            'label'   => 'Overlay Middle Opacity (0-1)',
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 0.45,
            'min'     => 0, 'max' => 1, 'step' => 0.05,
        ] );
        $this->add_control( 'overlay_bot', [
            'label'   => 'Overlay Bottom Opacity (0-1)',
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 0.70,
            'min'     => 0, 'max' => 1, 'step' => 0.05,
        ] );
        $this->end_controls_section();

        /* ── Badge ── */
        $this->start_controls_section( 'sec_badge', [
            'label' => 'Badge',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'show_badge', [
            'label'        => 'Show Badge',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'label_on'     => 'Show',
            'label_off'    => 'Hide',
            'return_value' => 'yes',
        ] );
        $this->add_control( 'badge_text', [
            'label'   => 'Badge Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '#1 Business Formation Service · 4M+ Businesses Formed',
            'condition' => [ 'show_badge' => 'yes' ],
        ] );
        $this->add_control( 'show_badge_star', [
            'label'        => 'Show Star Icon in Badge',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
            'condition'    => [ 'show_badge' => 'yes' ],
        ] );
        $this->end_controls_section();

        /* ── Headline ── */
        $this->start_controls_section( 'sec_text', [
            'label' => 'Headline & Copy',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'headline_pre', [
            'label'   => 'Headline Line 1',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Start Your LLC',
        ] );
        $this->add_control( 'headline_mid', [
            'label'   => 'Headline Line 2 (plain)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'the',
        ] );
        $this->add_control( 'headline_emphasis', [
            'label'   => 'Headline Line 2 (gradient word)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Right Way',
        ] );
        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'BizJump handles all the paperwork so you can focus on building your business. Fast, simple, and trusted by entrepreneurs across all 50 states.',
        ] );
        $this->add_control( 'fine_print', [
            'label'       => 'Fine Print (HTML allowed)',
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => 'State fee not included &nbsp;·&nbsp; <b>100% satisfaction guarantee</b> &nbsp;·&nbsp; No hidden fees',
            'description' => 'Allows <b>, <br>, <a> tags.',
        ] );
        $this->end_controls_section();

        /* ── CTAs ── */
        $this->start_controls_section( 'sec_buttons', [
            'label' => 'CTA Buttons',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'btn1_text', [
            'label'   => 'Primary Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Form My LLC Now',
        ] );
        $this->add_control( 'btn1_url', [
            'label'   => 'Primary Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/start/' ],
        ] );
        $this->add_control( 'show_btn2', [
            'label'        => 'Show Secondary Button',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );
        $this->add_control( 'btn2_text', [
            'label'   => 'Secondary Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'See How It Works',
            'condition' => [ 'show_btn2' => 'yes' ],
        ] );
        $this->add_control( 'btn2_url', [
            'label'    => 'Secondary Button URL',
            'type'     => \Elementor\Controls_Manager::URL,
            'default'  => [ 'url' => '#how' ],
            'condition' => [ 'show_btn2' => 'yes' ],
        ] );
        $this->end_controls_section();

        /* ── Style: Colors ── */
        $this->start_controls_section( 'sec_colors', [
            'label' => 'Colors',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'orange_400', [
            'label'   => 'Orange 400 (badge icon, gradient end)',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#FB923C',
        ] );
        $this->add_control( 'orange_500', [
            'label'   => 'Orange 500 (primary button)',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#F97316',
        ] );
        $this->add_control( 'orange_600', [
            'label'   => 'Orange 600 (button hover)',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#EA580C',
        ] );
        $this->add_control( 'overlay_color', [
            'label'   => 'Overlay Base Color (RGB)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '15,23,42',
            'description' => 'Comma-separated R,G,B values used in the gradient overlay.',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $bg  = ! empty( $s['bg_image']['url'] ) ? esc_url( $s['bg_image']['url'] ) : '';
        $b1u = ! empty( $s['btn1_url']['url'] ) ? esc_url( $s['btn1_url']['url'] ) : '#';
        $b1t = ! empty( $s['btn1_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        $b2u = ! empty( $s['btn2_url']['url'] ) ? esc_url( $s['btn2_url']['url'] ) : '#';
        $b2t = ! empty( $s['btn2_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';

        $min_h    = (int) ( $s['min_height'] ?? 700 );
        $o_top    = floatval( $s['overlay_top'] ?? 0.55 );
        $o_mid    = floatval( $s['overlay_mid'] ?? 0.45 );
        $o_bot    = floatval( $s['overlay_bot'] ?? 0.70 );
        $o_rgb    = preg_replace( '/[^0-9,]/', '', $s['overlay_color'] ?? '15,23,42' );
        $c_o400   = esc_attr( $s['orange_400'] ?: '#FB923C' );
        $c_o500   = esc_attr( $s['orange_500'] ?: '#F97316' );
        $c_o600   = esc_attr( $s['orange_600'] ?: '#EA580C' );
        $uid      = 'dal01_' . $this->get_id();
        ?>
<style>
@keyframes <?php echo $uid; ?>_fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
.<?php echo $uid; ?>.dal01-hero {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  min-height: <?php echo $min_h; ?>px;
  overflow: hidden;
  isolation: isolate;
  color: #fff;
  font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
}
.<?php echo $uid; ?> .dal01-hero-bg {
  position: absolute; inset: 0; z-index: -1;
  <?php if ( $bg ) : ?>background-image: url('<?php echo $bg; ?>');<?php endif; ?>
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
.<?php echo $uid; ?> .dal01-hero-overlay {
  position: absolute; inset: 0; z-index: 0;
  background: linear-gradient(180deg,
    rgba(<?php echo $o_rgb; ?>,<?php echo $o_top; ?>) 0%,
    rgba(<?php echo $o_rgb; ?>,<?php echo $o_mid; ?>) 50%,
    rgba(<?php echo $o_rgb; ?>,<?php echo $o_bot; ?>) 100%);
}
.<?php echo $uid; ?> .dal01-hero-content {
  position: relative; z-index: 1;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  text-align: center;
  max-width: 880px; width: 100%;
  padding: 96px 24px 64px;
}
.<?php echo $uid; ?> .dal01-fade { animation: <?php echo $uid; ?>_fadeIn .7s ease-out both; }
.<?php echo $uid; ?> .dal01-fade.d1 { animation-delay: .25s; }
.<?php echo $uid; ?> .dal01-fade.d2 { animation-delay: .45s; }
.<?php echo $uid; ?> .dal01-fade.d3 { animation-delay: .65s; }
.<?php echo $uid; ?> .dal01-fade.d4 { animation-delay: .85s; }

.<?php echo $uid; ?> .dal01-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,0.10);
  border: 1px solid rgba(255,255,255,0.22);
  color: #fff;
  font-size: 11px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .08em;
  padding: 7px 16px; border-radius: 999px;
  backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
  margin-bottom: 28px;
  transition: background .2s;
}
.<?php echo $uid; ?> .dal01-badge:hover { background: rgba(255,255,255,0.16); }
.<?php echo $uid; ?> .dal01-badge svg { color: <?php echo $c_o400; ?>; fill: <?php echo $c_o400; ?>; }

.<?php echo $uid; ?> .dal01-h1 {
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  font-size: clamp(40px, 6.4vw, 80px);
  font-weight: 700; line-height: 1.05;
  letter-spacing: -0.035em;
  color: #fff; margin: 0;
  text-shadow: 0 2px 24px rgba(0,0,0,0.40);
}
.<?php echo $uid; ?> .dal01-h1 .dal01-grad {
  background: linear-gradient(135deg, #fff 0%, #fff 35%, <?php echo $c_o400; ?> 100%);
  -webkit-background-clip: text; background-clip: text;
  color: transparent; -webkit-text-fill-color: transparent;
}

.<?php echo $uid; ?> .dal01-sub {
  font-size: clamp(16px, 1.4vw, 20px);
  font-weight: 400;
  color: rgba(255,255,255,0.92);
  max-width: 640px;
  margin: 24px auto 0;
  line-height: 1.7;
  text-shadow: 0 1px 12px rgba(0,0,0,0.35);
}

.<?php echo $uid; ?> .dal01-cta { display: flex; gap: 14px; flex-wrap: wrap; justify-content: center; margin-top: 40px; }
.<?php echo $uid; ?> .dal01-btn-primary {
  display: inline-flex; align-items: center; gap: 8px;
  background: <?php echo $c_o500; ?>; color: #fff;
  font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 600;
  padding: 16px 32px; border-radius: 999px; border: none;
  cursor: pointer; text-decoration: none;
  box-shadow: 0 4px 16px rgba(249,115,22,0.35);
  transition: all .2s ease; white-space: nowrap;
}
.<?php echo $uid; ?> .dal01-btn-primary:hover {
  background: <?php echo $c_o600; ?>; color: #fff;
  box-shadow: 0 6px 22px rgba(249,115,22,0.45);
  transform: translateY(-2px);
}
.<?php echo $uid; ?> .dal01-btn-primary:active { transform: translateY(0); }
.<?php echo $uid; ?> .dal01-btn-primary svg { transition: transform .2s; }
.<?php echo $uid; ?> .dal01-btn-primary:hover svg { transform: translateX(3px); }

.<?php echo $uid; ?> .dal01-btn-secondary {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,0.12); color: #fff;
  font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 600;
  padding: 16px 32px; border-radius: 999px;
  border: 1px solid rgba(255,255,255,0.28);
  cursor: pointer; text-decoration: none;
  transition: all .2s ease; white-space: nowrap;
  backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
}
.<?php echo $uid; ?> .dal01-btn-secondary:hover {
  background: rgba(255,255,255,0.20);
  border-color: rgba(255,255,255,0.45);
  color: #fff; transform: translateY(-2px);
}
.<?php echo $uid; ?> .dal01-btn-secondary svg { fill: currentColor; }

.<?php echo $uid; ?> .dal01-note {
  font-size: 13px;
  color: rgba(255,255,255,0.78);
  margin: 32px 0 0;
}
.<?php echo $uid; ?> .dal01-note b { color: #fff; font-weight: 600; }

@media (max-width: 768px) {
  .<?php echo $uid; ?>.dal01-hero { min-height: 100vh; }
  .<?php echo $uid; ?> .dal01-hero-content { padding: 80px 20px 56px; }
  .<?php echo $uid; ?> .dal01-h1 { font-size: clamp(34px, 9vw, 56px); }
  .<?php echo $uid; ?> .dal01-sub { font-size: 16px; }
  .<?php echo $uid; ?> .dal01-btn-primary,
  .<?php echo $uid; ?> .dal01-btn-secondary { padding: 14px 24px; font-size: 14px; }
}
</style>

<section class="<?php echo $uid; ?> dal01-hero">
  <div class="dal01-hero-bg" aria-hidden="true"></div>
  <div class="dal01-hero-overlay" aria-hidden="true"></div>

  <div class="dal01-hero-content">

    <?php if ( 'yes' === ( $s['show_badge'] ?? 'yes' ) && ! empty( $s['badge_text'] ) ) : ?>
    <div class="dal01-fade d1">
      <div class="dal01-badge">
        <?php echo esc_html( $s['badge_text'] ); ?>
        <?php if ( 'yes' === ( $s['show_badge_star'] ?? 'yes' ) ) : ?>
        <svg width="14" height="14" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

    <h1 class="dal01-h1 dal01-fade d2">
      <?php echo esc_html( $s['headline_pre'] ); ?><br>
      <?php echo esc_html( $s['headline_mid'] ); ?> <span class="dal01-grad"><?php echo esc_html( $s['headline_emphasis'] ); ?></span>
    </h1>

    <?php if ( ! empty( $s['subtitle'] ) ) : ?>
    <p class="dal01-sub dal01-fade d3"><?php echo esc_html( $s['subtitle'] ); ?></p>
    <?php endif; ?>

    <div class="dal01-cta dal01-fade d4">
      <a href="<?php echo $b1u; ?>"<?php echo $b1t; ?> class="dal01-btn-primary">
        <?php echo esc_html( $s['btn1_text'] ); ?>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
      <?php if ( 'yes' === ( $s['show_btn2'] ?? 'yes' ) ) : ?>
      <a href="<?php echo $b2u; ?>"<?php echo $b2t; ?> class="dal01-btn-secondary">
        <svg width="14" height="14" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
        <?php echo esc_html( $s['btn2_text'] ); ?>
      </a>
      <?php endif; ?>
    </div>

    <?php if ( ! empty( $s['fine_print'] ) ) : ?>
    <p class="dal01-note dal01-fade d4"><?php echo wp_kses_post( $s['fine_print'] ); ?></p>
    <?php endif; ?>

  </div>
</section>
        <?php
    }
}
