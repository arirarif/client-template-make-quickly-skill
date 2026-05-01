<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 17 — About: Process
 * 4-column auto-numbered process steps grid.
 */
class Widget_About_Process extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_17_about_process'; }
    public function get_title()      { return '17 — About: Process'; }
    public function get_icon()       { return 'eicon-flow'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'process', 'steps', 'about', 'how', 'pp-uk' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Our Process',
        ] );

        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'From synthesis to your lab.',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_steps', [
            'label' => 'Steps',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'title', [ 'label' => 'Step Title', 'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Step' ] );
        $rep->add_control( 'body',  [ 'label' => 'Step Body',  'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Step description.', 'rows' => 4 ] );

        $this->add_control( 'steps', [
            'label'       => 'Steps',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'title' => 'Sourcing',      'body' => 'We work with a select group of cGMP-compliant synthesis partners. Every batch is accompanied by a manufacturer certificate of analysis before we accept delivery.' ],
                [ 'title' => 'Lab Testing',   'body' => 'Each compound is submitted to an independent UK laboratory for HPLC purity analysis and mass spectrometry identity confirmation. Batches below 98% purity are rejected.' ],
                [ 'title' => 'Packaging',     'body' => 'Approved batches are filled to specification under controlled conditions. Each vial is assigned a lot number, weighed, sealed, and stored at appropriate temperature.' ],
                [ 'title' => 'Dispatch',      'body' => 'Orders ship from our UK facility in temperature-controlled, discreet outer packaging. Tracking numbers are issued automatically. Typical dispatch is 1–2 working days.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-process{background:var(--pp-bg);border-top:1px solid var(--pp-border)}
  .pp-process-head{max-width:640px;margin-bottom:var(--pp-sp-48)}
  .pp-process-head h2{margin-top:var(--pp-sp-16)}
  .pp-process-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;border-top:1px solid var(--pp-border);border-left:1px solid var(--pp-border);counter-reset:step-counter}
  .pp-process-step{padding:var(--pp-sp-32);border-right:1px solid var(--pp-border);border-bottom:1px solid var(--pp-border);counter-increment:step-counter}
  .pp-process-step::before{content:counter(step-counter,decimal-leading-zero);font-family:var(--pp-f-mono);font-size:24px;font-weight:500;color:var(--pp-ink-3);display:block;margin-bottom:var(--pp-sp-24)}
  .pp-process-step h3{font-size:18px;margin-bottom:var(--pp-sp-12)}
  .pp-process-step p{font-size:14px;color:var(--pp-ink-2);line-height:1.7}
  @media(max-width:900px){.pp-process-grid{grid-template-columns:1fr 1fr}}
  @media(max-width:560px){.pp-process-grid{grid-template-columns:1fr}}
</style>
<section class="pp-section pp-process pp-pad">
  <div class="pp-container">
    <div class="pp-process-head pp-reveal">
      <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
      <h2><?php echo esc_html( $s['heading'] ); ?></h2>
    </div>
    <div class="pp-process-grid">
      <?php foreach ( $s['steps'] as $i => $step ) : ?>
      <div class="pp-process-step pp-reveal" style="transition-delay:<?php echo $i * 80; ?>ms">
        <h3><?php echo esc_html( $step['title'] ); ?></h3>
        <p><?php echo esc_html( $step['body'] ); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
