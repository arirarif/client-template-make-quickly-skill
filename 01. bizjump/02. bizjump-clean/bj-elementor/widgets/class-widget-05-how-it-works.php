<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 05 — How It Works
 * Three-step process section with numbered circles, dashed connector, and scroll-reveal.
 */
class Widget_How_It_Works extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_05_how'; }
    public function get_title()      { return '05 — How It Works'; }
    public function get_icon()       { return 'eicon-flow'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'how', 'process', 'steps', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        /* ── Header ── */
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'section_label', [
            'label'   => 'Section Label (eyebrow)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Simple Process',
        ] );

        $this->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Form Your Business in 3 Steps',
        ] );

        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'No lawyers, no confusing paperwork. Our guided online wizard walks you through everything in minutes.',
            'rows'    => 2,
        ] );

        $this->end_controls_section();

        /* ── Steps ── */
        $this->start_controls_section( 'section_steps', [
            'label' => 'Steps',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'step_num', [
            'label'   => 'Step Number',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '1',
        ] );

        $rep->add_control( 'step_title', [
            'label'   => 'Step Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Choose Your Entity & State',
        ] );

        $rep->add_control( 'step_desc', [
            'label'   => 'Step Description',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Tell us what type of business you\'re forming and which state you want to incorporate in.',
            'rows'    => 3,
        ] );

        $this->add_control( 'steps', [
            'label'       => 'Steps',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'step_num'   => '1',
                    'step_title' => 'Choose Your Entity &amp; State',
                    'step_desc'  => 'Tell us what type of business you\'re forming and which state you want to incorporate in. Our wizard guides every step.',
                ],
                [
                    'step_num'   => '2',
                    'step_title' => 'Pick a Plan &amp; Add-Ons',
                    'step_desc'  => 'Select the service tier that fits your needs — Basic, Pro, Premium, or Enterprise. Add extras like EIN, Registered Agent, or compliance monitoring.',
                ],
                [
                    'step_num'   => '3',
                    'step_title' => 'We File — You Launch',
                    'step_desc'  => 'We handle all state paperwork and filings on your behalf. You receive your formation documents ready to do business.',
                ],
            ],
            'title_field' => 'Step {{{ step_num }}}: {{{ step_title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.bjw07-wrap {
  font-family: 'Inter', sans-serif;
  max-width: 1120px;
  margin: 0 auto;
  padding: 0 32px;
}
/* Header */
.bjw07-header { text-align: center; margin-bottom: 64px; }
.bjw07-label {
  font-size: 12px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: #2563eb;
  margin-bottom: 10px; display: block;
}
.bjw07-title {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: clamp(28px, 3.5vw, 42px);
  font-weight: 800; color: #111827;
  line-height: 1.18; letter-spacing: -0.8px;
  margin-bottom: 14px;
}
.bjw07-sub {
  font-size: 17px; color: #6b7280;
  max-width: 520px; margin: 0 auto;
  line-height: 1.75;
}
/* Steps container */
.bjw07-steps {
  display: grid;
  grid-template-columns: repeat(<?php echo count( $s['steps'] ); ?>, 1fr);
  gap: 0;
  position: relative;
}
/* Dashed connector line between steps */
.bjw07-connector {
  position: absolute;
  top: 44px;
  left: calc(33.33% / 2 + 24px);
  right: calc(33.33% / 2 + 24px);
  height: 2px;
  background: repeating-linear-gradient(
    90deg,
    #2563eb 0, #2563eb 8px,
    transparent 8px, transparent 16px
  );
}
/* Individual step */
.bjw07-step {
  display: flex; flex-direction: column;
  align-items: center; text-align: center;
  padding: 0 32px 48px;
  opacity: 0; transform: translateY(24px);
  transition: opacity .55s ease, transform .55s ease;
}
.bjw07-step.bjw07-visible { opacity: 1; transform: none; }
.bjw07-step:nth-child(3) { transition-delay: .15s; }
.bjw07-step:nth-child(4) { transition-delay: .3s; }
/* Step number circle */
.bjw07-num {
  width: 88px; height: 88px; border-radius: 50%;
  background: #0f2156; color: #fff;
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 30px; font-weight: 800;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 28px; flex-shrink: 0;
  position: relative; z-index: 1;
  box-shadow: 0 6px 24px rgba(15,33,86,.3);
  transition: transform .3s, box-shadow .3s;
}
.bjw07-step:hover .bjw07-num {
  transform: scale(1.08);
  box-shadow: 0 10px 36px rgba(15,33,86,.4);
}
.bjw07-step h3 {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 19px; font-weight: 700; color: #111827;
  margin-bottom: 12px;
}
.bjw07-step p {
  font-size: 15px; color: #6b7280; line-height: 1.65;
}
/* Responsive */
@media (max-width: 768px) {
  .bjw07-wrap { padding: 0 16px; }
  .bjw07-steps { grid-template-columns: 1fr; gap: 0; }
  .bjw07-connector { display: none; }
  .bjw07-step { padding: 0 16px 40px; }
  .bjw07-num { width: 72px; height: 72px; font-size: 24px; margin-bottom: 20px; }
  .bjw07-sub { font-size: 15px; }
}
</style>

<div class="bjw07-wrap">

  <!-- Header -->
  <div class="bjw07-header">
    <span class="bjw07-label"><?php echo esc_html( $s['section_label'] ); ?></span>
    <h2 class="bjw07-title"><?php echo esc_html( $s['title'] ); ?></h2>
    <p class="bjw07-sub"><?php echo esc_html( $s['subtitle'] ); ?></p>
  </div>

  <!-- Steps -->
  <div class="bjw07-steps">
    <div class="bjw07-connector"></div>

    <?php foreach ( $s['steps'] as $step ) : ?>
    <div class="bjw07-step">
      <div class="bjw07-num"><?php echo esc_html( $step['step_num'] ); ?></div>
      <h3><?php echo wp_kses_post( $step['step_title'] ); ?></h3>
      <p><?php echo esc_html( $step['step_desc'] ); ?></p>
    </div>
    <?php endforeach; ?>

  </div>
</div>

<script>
(function(){
  var steps = document.querySelectorAll('.bjw07-step');
  var obs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if(e.isIntersecting){ e.target.classList.add('bjw07-visible'); obs.unobserve(e.target); }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
  steps.forEach(function(s){ obs.observe(s); });
})();
</script>
        <?php
    }
}
