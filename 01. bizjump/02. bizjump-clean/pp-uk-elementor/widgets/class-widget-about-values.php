<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 16 — About: Values
 * 2×2 grid of numbered value cards with title and body text.
 */
class Widget_About_Values extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_16_about_values'; }
    public function get_title()      { return '16 — About: Values'; }
    public function get_icon()       { return 'eicon-bullet-list'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'values', 'about', 'grid', 'cards', 'pp-uk' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'What We Stand For',
        ] );

        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Four principles. No compromises.',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_values', [
            'label' => 'Values',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Transparency' ] );
        $rep->add_control( 'body',  [ 'label' => 'Body',  'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Every COA published. Every batch traceable. No hidden data.',  'rows' => 4 ] );

        $this->add_control( 'values', [
            'label'       => 'Values',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'title' => 'Transparency',  'body' => 'Every COA published before a product goes live. Every batch traceable by lot number. No hidden data, no buried results.' ],
                [ 'title' => 'Independence',  'body' => 'We do not own or operate our testing labs. Third-party HPLC and mass spectrometry analysis — because you deserve an unbiased result.' ],
                [ 'title' => 'Precision',     'body' => 'Each vial is weighed and filled to ±2% tolerance. Temperature-controlled storage and cold-pack dispatch protect compound integrity from our freezer to your lab.' ],
                [ 'title' => 'Responsibility','body' => 'We sell to verified researchers only. Age gate, research declaration, and ongoing compliance with UK regulations are non-negotiable.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-values{background:var(--pp-surface)}
  .pp-values-head{max-width:640px;margin-bottom:var(--pp-sp-48)}
  .pp-values-head h2{margin-top:var(--pp-sp-16)}
  .pp-values-grid{display:grid;grid-template-columns:1fr 1fr;gap:var(--pp-sp-16)}
  .pp-value-card{background:var(--pp-surface-2);border:1px solid var(--pp-border);border-radius:var(--pp-r-lg);padding:var(--pp-sp-32);position:relative;counter-increment:value-counter}
  .pp-value-card::before{content:counter(value-counter,decimal-leading-zero);font-family:var(--pp-f-mono);font-size:12px;letter-spacing:.1em;color:var(--pp-ink-3);display:block;margin-bottom:var(--pp-sp-24)}
  .pp-values-grid{counter-reset:value-counter}
  .pp-value-card h3{font-size:20px;margin-bottom:var(--pp-sp-12)}
  .pp-value-card p{font-size:15px;color:var(--pp-ink-2);line-height:1.7}
  @media(max-width:768px){.pp-values-grid{grid-template-columns:1fr}}
</style>
<section class="pp-section pp-values pp-pad">
  <div class="pp-container">
    <div class="pp-values-head pp-reveal">
      <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
      <h2><?php echo esc_html( $s['heading'] ); ?></h2>
    </div>
    <div class="pp-values-grid">
      <?php foreach ( $s['values'] as $i => $val ) : ?>
      <div class="pp-value-card pp-reveal" style="transition-delay:<?php echo $i * 60; ?>ms">
        <h3><?php echo esc_html( $val['title'] ); ?></h3>
        <p><?php echo esc_html( $val['body'] ); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
