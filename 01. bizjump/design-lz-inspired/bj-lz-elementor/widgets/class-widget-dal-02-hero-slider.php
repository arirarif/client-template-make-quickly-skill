<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DAL-02 — Hero Slider (Doc-Aligned Landing)
 * Multi-slide version of DAL-01 using Swiper.js. Each slide carries its own
 * background image, badge, headline + gradient word, subtitle, CTAs, fine print.
 * Global controls: autoplay, loop, transition speed, fade/slide effect, dots, arrows.
 * The heroFadeIn d1–d4 stagger is preserved per slide on each transition.
 */
class Widget_DAL_Hero_Slider extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dal_02_hero_slider'; }
    public function get_title()      { return 'DAL 02 — Hero Slider'; }
    public function get_icon()       { return 'eicon-slider-push'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'hero', 'slider', 'carousel', 'swiper', 'banner', 'bizjump', 'dal' ]; }

    public function get_script_depends() { return [ 'bjlz-swiper' ]; }
    public function get_style_depends()  { return [ 'bjlz-swiper' ]; }

    protected function register_controls() {

        /* ── Slides ── */
        $this->start_controls_section( 'sec_slides', [
            'label' => 'Slides',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'bg_image', [
            'label'   => 'Background Image',
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1920&q=85',
            ],
        ] );
        $rep->add_control( 'show_badge', [
            'label'        => 'Show Badge',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );
        $rep->add_control( 'badge_text', [
            'label'   => 'Badge Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '#1 Business Formation Service · 4M+ Businesses Formed',
            'condition' => [ 'show_badge' => 'yes' ],
        ] );
        $rep->add_control( 'show_badge_star', [
            'label'        => 'Show Star Icon in Badge',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
            'condition'    => [ 'show_badge' => 'yes' ],
        ] );
        $rep->add_control( 'headline_pre', [
            'label'   => 'Headline Line 1',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Start Your LLC',
        ] );
        $rep->add_control( 'headline_mid', [
            'label'   => 'Headline Line 2 (plain)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'the',
        ] );
        $rep->add_control( 'headline_emphasis', [
            'label'   => 'Headline Line 2 (gradient word)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Right Way',
        ] );
        $rep->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'BizJump handles all the paperwork so you can focus on building your business. Fast, simple, and trusted by entrepreneurs across all 50 states.',
        ] );
        $rep->add_control( 'btn1_text', [
            'label'   => 'Primary Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Form My LLC Now',
        ] );
        $rep->add_control( 'btn1_url', [
            'label'   => 'Primary Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/start/' ],
        ] );
        $rep->add_control( 'show_btn2', [
            'label'        => 'Show Secondary Button',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );
        $rep->add_control( 'btn2_text', [
            'label'   => 'Secondary Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'See How It Works',
            'condition' => [ 'show_btn2' => 'yes' ],
        ] );
        $rep->add_control( 'btn2_url', [
            'label'    => 'Secondary Button URL',
            'type'     => \Elementor\Controls_Manager::URL,
            'default'  => [ 'url' => '#how' ],
            'condition' => [ 'show_btn2' => 'yes' ],
        ] );
        $rep->add_control( 'fine_print', [
            'label'   => 'Fine Print (HTML allowed)',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'State fee not included &nbsp;·&nbsp; <b>100% satisfaction guarantee</b> &nbsp;·&nbsp; No hidden fees',
        ] );

        $this->add_control( 'slides', [
            'label'   => 'Slides',
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $rep->get_controls(),
            'default' => [
                [
                    'bg_image'           => [ 'url' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1920&q=85' ],
                    'show_badge'         => 'yes',
                    'badge_text'         => '#1 Business Formation Service · 4M+ Businesses Formed',
                    'show_badge_star'    => 'yes',
                    'headline_pre'       => 'Start Your LLC',
                    'headline_mid'       => 'the',
                    'headline_emphasis'  => 'Right Way',
                    'subtitle'           => 'BizJump handles all the paperwork so you can focus on building your business. Fast, simple, and trusted by entrepreneurs across all 50 states.',
                    'btn1_text'          => 'Form My LLC Now',
                    'btn1_url'           => [ 'url' => '/start/?entity=llc' ],
                    'show_btn2'          => 'yes',
                    'btn2_text'          => 'See How It Works',
                    'btn2_url'           => [ 'url' => '#how' ],
                    'fine_print'         => 'State fee not included &nbsp;·&nbsp; <b>100% satisfaction guarantee</b> &nbsp;·&nbsp; No hidden fees',
                ],
                [
                    'bg_image'           => [ 'url' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1920&q=85' ],
                    'show_badge'         => 'yes',
                    'badge_text'         => 'Trusted by 4M+ Founders',
                    'show_badge_star'    => 'yes',
                    'headline_pre'       => 'Form a Corporation',
                    'headline_mid'       => 'built to',
                    'headline_emphasis'  => 'Scale',
                    'subtitle'           => 'C-Corps and S-Corps designed for growth, investors, and serious operators. Filed in any of the 50 states.',
                    'btn1_text'          => 'Start My Corp',
                    'btn1_url'           => [ 'url' => '/start/?entity=ccorp' ],
                    'show_btn2'          => 'yes',
                    'btn2_text'          => 'Compare Entities',
                    'btn2_url'           => [ 'url' => '#compare' ],
                    'fine_print'         => 'State fees apply &nbsp;·&nbsp; <b>Lifetime support</b> &nbsp;·&nbsp; Filed in 24 hrs',
                ],
                [
                    'bg_image'           => [ 'url' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1920&q=85' ],
                    'show_badge'         => 'yes',
                    'badge_text'         => 'Mission-Driven? We Got You',
                    'show_badge_star'    => 'yes',
                    'headline_pre'       => 'Launch a Nonprofit',
                    'headline_mid'       => 'with real',
                    'headline_emphasis'  => 'Impact',
                    'subtitle'           => 'Form your 501(c)(3) and start accepting tax-deductible donations. We handle the paperwork, you focus on the mission.',
                    'btn1_text'          => 'Start My Nonprofit',
                    'btn1_url'           => [ 'url' => '/start/?entity=nonprofit' ],
                    'show_btn2'          => 'yes',
                    'btn2_text'          => 'See How It Works',
                    'btn2_url'           => [ 'url' => '#how' ],
                    'fine_print'         => 'IRS-ready filings &nbsp;·&nbsp; <b>Free EIN</b> &nbsp;·&nbsp; All 50 states',
                ],
            ],
            'title_field' => '{{{ headline_pre }}} — {{{ headline_emphasis }}}',
        ] );

        $this->end_controls_section();

        /* ── Slider Behavior ── */
        $this->start_controls_section( 'sec_behavior', [
            'label' => 'Slider Behavior',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'autoplay', [
            'label'        => 'Autoplay',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );
        $this->add_control( 'autoplay_delay', [
            'label'   => 'Autoplay Delay (ms)',
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 6000,
            'min'     => 2000, 'max' => 20000, 'step' => 500,
            'condition' => [ 'autoplay' => 'yes' ],
        ] );
        $this->add_control( 'pause_on_hover', [
            'label'        => 'Pause on Hover',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
            'condition'    => [ 'autoplay' => 'yes' ],
        ] );
        $this->add_control( 'loop', [
            'label'        => 'Loop',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );
        $this->add_control( 'effect', [
            'label'   => 'Transition Effect',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'fade',
            'options' => [
                'slide' => 'Slide',
                'fade'  => 'Fade',
            ],
        ] );
        $this->add_control( 'speed', [
            'label'   => 'Transition Speed (ms)',
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 800,
            'min'     => 200, 'max' => 3000, 'step' => 100,
        ] );
        $this->add_control( 'show_dots', [
            'label'        => 'Show Pagination Dots',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );
        $this->add_control( 'show_arrows', [
            'label'        => 'Show Nav Arrows',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );
        $this->end_controls_section();

        /* ── Layout / Background ── */
        $this->start_controls_section( 'sec_layout', [
            'label' => 'Layout',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'min_height', [
            'label'   => 'Minimum Height (px)',
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 700,
            'min'     => 400, 'max' => 1200,
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
        $this->add_control( 'overlay_color', [
            'label'   => 'Overlay Base Color (RGB)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '15,23,42',
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
        $this->end_controls_section();
    }

    protected function render() {
        $s        = $this->get_settings_for_display();
        $min_h    = (int) ( $s['min_height'] ?? 700 );
        $o_top    = floatval( $s['overlay_top'] ?? 0.55 );
        $o_mid    = floatval( $s['overlay_mid'] ?? 0.45 );
        $o_bot    = floatval( $s['overlay_bot'] ?? 0.70 );
        $o_rgb    = preg_replace( '/[^0-9,]/', '', $s['overlay_color'] ?? '15,23,42' );
        $c_o400   = esc_attr( $s['orange_400'] ?: '#FB923C' );
        $c_o500   = esc_attr( $s['orange_500'] ?: '#F97316' );
        $c_o600   = esc_attr( $s['orange_600'] ?: '#EA580C' );

        $autoplay   = ( 'yes' === ( $s['autoplay'] ?? 'yes' ) );
        $delay      = (int) ( $s['autoplay_delay'] ?? 6000 );
        $pause_hov  = ( 'yes' === ( $s['pause_on_hover'] ?? 'yes' ) );
        $loop       = ( 'yes' === ( $s['loop'] ?? 'yes' ) );
        $effect     = in_array( $s['effect'] ?? 'fade', [ 'slide', 'fade' ], true ) ? $s['effect'] : 'fade';
        $speed      = (int) ( $s['speed'] ?? 800 );
        $show_dots  = ( 'yes' === ( $s['show_dots'] ?? 'yes' ) );
        $show_arrow = ( 'yes' === ( $s['show_arrows'] ?? 'yes' ) );

        $uid    = 'dal02_' . $this->get_id();
        $slides = (array) ( $s['slides'] ?? [] );

        $config = [
            'effect'     => $effect,
            'speed'      => $speed,
            'loop'       => $loop && count( $slides ) > 1,
            'autoplay'   => $autoplay ? [
                'delay'                => $delay,
                'disableOnInteraction' => false,
                'pauseOnMouseEnter'    => $pause_hov,
            ] : false,
            'pagination' => $show_dots  ? [ 'el' => ".{$uid}-pagination", 'clickable' => true ] : false,
            'navigation' => $show_arrow ? [ 'nextEl' => ".{$uid}-next", 'prevEl' => ".{$uid}-prev" ] : false,
            'fadeEffect' => [ 'crossFade' => true ],
        ];
        $config_json = wp_json_encode( $config );
        ?>
<style>
@keyframes <?php echo $uid; ?>_fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
.<?php echo $uid; ?>.dal02-slider {
  position: relative;
  width: 100%;
  min-height: <?php echo $min_h; ?>px;
  overflow: hidden;
  isolation: isolate;
  font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
}
.<?php echo $uid; ?> .swiper { width: 100%; min-height: <?php echo $min_h; ?>px; }
.<?php echo $uid; ?> .swiper-slide {
  position: relative;
  display: flex; align-items: center; justify-content: center;
  min-height: <?php echo $min_h; ?>px;
  color: #fff;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
.<?php echo $uid; ?> .swiper-slide::before {
  content: ''; position: absolute; inset: 0; z-index: 0;
  background: linear-gradient(180deg,
    rgba(<?php echo $o_rgb; ?>,<?php echo $o_top; ?>) 0%,
    rgba(<?php echo $o_rgb; ?>,<?php echo $o_mid; ?>) 50%,
    rgba(<?php echo $o_rgb; ?>,<?php echo $o_bot; ?>) 100%);
}
.<?php echo $uid; ?> .dal02-content {
  position: relative; z-index: 1;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  text-align: center;
  max-width: 880px; width: 100%;
  padding: 96px 24px 96px;
}

/* Stagger plays each time a slide becomes active */
.<?php echo $uid; ?> .swiper-slide-active .dal02-fade { animation: <?php echo $uid; ?>_fadeIn .7s ease-out both; }
.<?php echo $uid; ?> .swiper-slide-active .dal02-fade.d1 { animation-delay: .15s; }
.<?php echo $uid; ?> .swiper-slide-active .dal02-fade.d2 { animation-delay: .30s; }
.<?php echo $uid; ?> .swiper-slide-active .dal02-fade.d3 { animation-delay: .45s; }
.<?php echo $uid; ?> .swiper-slide-active .dal02-fade.d4 { animation-delay: .60s; }

.<?php echo $uid; ?> .dal02-badge {
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
.<?php echo $uid; ?> .dal02-badge:hover { background: rgba(255,255,255,0.16); }
.<?php echo $uid; ?> .dal02-badge svg { color: <?php echo $c_o400; ?>; fill: <?php echo $c_o400; ?>; }

.<?php echo $uid; ?> .dal02-h1 {
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  font-size: clamp(40px, 6.4vw, 80px);
  font-weight: 700; line-height: 1.05;
  letter-spacing: -0.035em;
  color: #fff; margin: 0;
  text-shadow: 0 2px 24px rgba(0,0,0,0.40);
}
.<?php echo $uid; ?> .dal02-h1 .dal02-grad {
  background: linear-gradient(135deg, #fff 0%, #fff 35%, <?php echo $c_o400; ?> 100%);
  -webkit-background-clip: text; background-clip: text;
  color: transparent; -webkit-text-fill-color: transparent;
}

.<?php echo $uid; ?> .dal02-sub {
  font-size: clamp(16px, 1.4vw, 20px);
  font-weight: 400;
  color: rgba(255,255,255,0.92);
  max-width: 640px;
  margin: 24px auto 0;
  line-height: 1.7;
  text-shadow: 0 1px 12px rgba(0,0,0,0.35);
}

.<?php echo $uid; ?> .dal02-cta { display: flex; gap: 14px; flex-wrap: wrap; justify-content: center; margin-top: 40px; }
.<?php echo $uid; ?> .dal02-btn-primary {
  display: inline-flex; align-items: center; gap: 8px;
  background: <?php echo $c_o500; ?>; color: #fff;
  font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 600;
  padding: 16px 32px; border-radius: 999px; border: none;
  cursor: pointer; text-decoration: none;
  box-shadow: 0 4px 16px rgba(249,115,22,0.35);
  transition: all .2s ease; white-space: nowrap;
}
.<?php echo $uid; ?> .dal02-btn-primary:hover {
  background: <?php echo $c_o600; ?>; color: #fff;
  box-shadow: 0 6px 22px rgba(249,115,22,0.45);
  transform: translateY(-2px);
}
.<?php echo $uid; ?> .dal02-btn-primary svg { transition: transform .2s; }
.<?php echo $uid; ?> .dal02-btn-primary:hover svg { transform: translateX(3px); }

.<?php echo $uid; ?> .dal02-btn-secondary {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,0.12); color: #fff;
  font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 600;
  padding: 16px 32px; border-radius: 999px;
  border: 1px solid rgba(255,255,255,0.28);
  cursor: pointer; text-decoration: none;
  transition: all .2s ease; white-space: nowrap;
  backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
}
.<?php echo $uid; ?> .dal02-btn-secondary:hover {
  background: rgba(255,255,255,0.20);
  border-color: rgba(255,255,255,0.45);
  color: #fff; transform: translateY(-2px);
}

.<?php echo $uid; ?> .dal02-note {
  font-size: 13px;
  color: rgba(255,255,255,0.78);
  margin: 32px 0 0;
}
.<?php echo $uid; ?> .dal02-note b { color: #fff; font-weight: 600; }

/* Pagination + arrows */
.<?php echo $uid; ?> .swiper-pagination {
  position: absolute; bottom: 28px; left: 0; right: 0;
  display: flex; justify-content: center; gap: 8px;
  z-index: 5;
}
.<?php echo $uid; ?> .swiper-pagination-bullet {
  width: 10px; height: 10px; border-radius: 999px;
  background: rgba(255,255,255,0.4);
  opacity: 1;
  transition: background .2s, width .25s;
}
.<?php echo $uid; ?> .swiper-pagination-bullet-active {
  background: <?php echo $c_o500; ?>;
  width: 32px;
}
.<?php echo $uid; ?> .swiper-button-prev,
.<?php echo $uid; ?> .swiper-button-next {
  position: absolute; top: 50%; transform: translateY(-50%);
  width: 48px; height: 48px;
  background: rgba(255,255,255,0.12);
  border: 1px solid rgba(255,255,255,0.28);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: #fff; cursor: pointer;
  backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
  z-index: 5;
  transition: all .2s;
}
.<?php echo $uid; ?> .swiper-button-prev { left: 24px; }
.<?php echo $uid; ?> .swiper-button-next { right: 24px; }
.<?php echo $uid; ?> .swiper-button-prev:hover,
.<?php echo $uid; ?> .swiper-button-next:hover {
  background: rgba(255,255,255,0.22);
  border-color: rgba(255,255,255,0.5);
}
.<?php echo $uid; ?> .swiper-button-prev::after,
.<?php echo $uid; ?> .swiper-button-next::after { content: none; } /* override Swiper default */

@media (max-width: 768px) {
  .<?php echo $uid; ?>.dal02-slider { min-height: 100vh; }
  .<?php echo $uid; ?> .swiper,
  .<?php echo $uid; ?> .swiper-slide { min-height: 100vh; }
  .<?php echo $uid; ?> .dal02-content { padding: 80px 20px 80px; }
  .<?php echo $uid; ?> .dal02-h1 { font-size: clamp(34px, 9vw, 56px); }
  .<?php echo $uid; ?> .dal02-sub { font-size: 16px; }
  .<?php echo $uid; ?> .dal02-btn-primary,
  .<?php echo $uid; ?> .dal02-btn-secondary { padding: 14px 24px; font-size: 14px; }
  .<?php echo $uid; ?> .swiper-button-prev,
  .<?php echo $uid; ?> .swiper-button-next { width: 40px; height: 40px; }
  .<?php echo $uid; ?> .swiper-button-prev { left: 12px; }
  .<?php echo $uid; ?> .swiper-button-next { right: 12px; }
}
</style>

<section class="<?php echo $uid; ?> dal02-slider">
  <div class="swiper">
    <div class="swiper-wrapper">
      <?php foreach ( $slides as $idx => $sl ) :
        $bg  = ! empty( $sl['bg_image']['url'] ) ? esc_url( $sl['bg_image']['url'] ) : '';
        $b1u = ! empty( $sl['btn1_url']['url'] ) ? esc_url( $sl['btn1_url']['url'] ) : '#';
        $b1t = ! empty( $sl['btn1_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        $b2u = ! empty( $sl['btn2_url']['url'] ) ? esc_url( $sl['btn2_url']['url'] ) : '#';
        $b2t = ! empty( $sl['btn2_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
      ?>
      <div class="swiper-slide" style="<?php if ( $bg ) echo "background-image:url('{$bg}');"; ?>">
        <div class="dal02-content">

          <?php if ( 'yes' === ( $sl['show_badge'] ?? 'yes' ) && ! empty( $sl['badge_text'] ) ) : ?>
          <div class="dal02-fade d1">
            <div class="dal02-badge">
              <?php echo esc_html( $sl['badge_text'] ); ?>
              <?php if ( 'yes' === ( $sl['show_badge_star'] ?? 'yes' ) ) : ?>
              <svg width="14" height="14" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>

          <h1 class="dal02-h1 dal02-fade d2">
            <?php echo esc_html( $sl['headline_pre'] ); ?><br>
            <?php echo esc_html( $sl['headline_mid'] ); ?> <span class="dal02-grad"><?php echo esc_html( $sl['headline_emphasis'] ); ?></span>
          </h1>

          <?php if ( ! empty( $sl['subtitle'] ) ) : ?>
          <p class="dal02-sub dal02-fade d3"><?php echo esc_html( $sl['subtitle'] ); ?></p>
          <?php endif; ?>

          <div class="dal02-cta dal02-fade d4">
            <a href="<?php echo $b1u; ?>"<?php echo $b1t; ?> class="dal02-btn-primary">
              <?php echo esc_html( $sl['btn1_text'] ); ?>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
            <?php if ( 'yes' === ( $sl['show_btn2'] ?? 'yes' ) ) : ?>
            <a href="<?php echo $b2u; ?>"<?php echo $b2t; ?> class="dal02-btn-secondary">
              <svg width="14" height="14" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
              <?php echo esc_html( $sl['btn2_text'] ); ?>
            </a>
            <?php endif; ?>
          </div>

          <?php if ( ! empty( $sl['fine_print'] ) ) : ?>
          <p class="dal02-note dal02-fade d4"><?php echo wp_kses_post( $sl['fine_print'] ); ?></p>
          <?php endif; ?>

        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <?php if ( $show_dots ) : ?>
    <div class="swiper-pagination <?php echo $uid; ?>-pagination"></div>
    <?php endif; ?>

    <?php if ( $show_arrow ) : ?>
    <button class="swiper-button-prev <?php echo $uid; ?>-prev" aria-label="Previous slide">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
    </button>
    <button class="swiper-button-next <?php echo $uid; ?>-next" aria-label="Next slide">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </button>
    <?php endif; ?>
  </div>
</section>

<script>
(function(){
  var rootSel = '.<?php echo $uid; ?> .swiper';
  var cfg = <?php echo $config_json; ?>;
  function init(){
    if (typeof Swiper === 'undefined') { return setTimeout(init, 100); }
    var el = document.querySelector(rootSel);
    if (!el || el.dataset.bjlzInit === '1') return;
    el.dataset.bjlzInit = '1';
    new Swiper(el, cfg);
  }
  if (document.readyState !== 'loading') { init(); }
  else { document.addEventListener('DOMContentLoaded', init); }
})();
</script>
        <?php
    }
}
