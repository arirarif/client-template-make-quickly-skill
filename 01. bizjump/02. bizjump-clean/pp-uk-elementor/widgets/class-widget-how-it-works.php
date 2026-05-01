<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_How_It_Works extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_03_how_it_works'; }
    public function get_title()      { return '03 — How It Works'; }
    public function get_icon()       { return 'eicon-flow'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'how', 'steps', 'process', 'pp-uk' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Getting Started',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Three simple steps.',
        ] );
        $this->add_control( 'body', [
            'label'   => 'Intro Text',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'From browsing the catalog to receiving your research compounds — the entire process is straightforward, transparent, and built for the research community.',
            'rows'    => 3,
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'section_steps', [
            'label' => 'Steps',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Step' ] );
        $rep->add_control( 'body',  [ 'label' => 'Body',  'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Description.', 'rows' => 3 ] );
        $this->add_control( 'steps', [
            'label'       => 'Steps',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'title' => 'Browse the catalog',        'body' => 'Find peptides by category — tissue repair, GH axis, metabolic, longevity, and more. Each listing shows purity, batch test reports, and current stock status.' ],
                [ 'title' => 'Verify & checkout',         'body' => 'Confirm 18+ research use, choose your payment method (card via Wallid, Stripe, or BTC/ETH), and place your order. All transactions are encrypted end-to-end.' ],
                [ 'title' => 'Reconstitute & research',   'body' => 'Receive your sealed vials with bacteriostatic water options. Visit our companion knowledge base for reconstitution guides, storage protocols, and reference data.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-how{background:var(--pp-surface);border-top:1px solid var(--pp-border);border-bottom:1px solid var(--pp-border)}
  .pp-how-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:var(--pp-sp-16);counter-reset:step}
  .pp-step{padding:var(--pp-sp-32);background:var(--pp-bg);border:1px solid var(--pp-border);border-radius:var(--pp-r);counter-increment:step;position:relative;transition:border-color 150ms var(--pp-ease),box-shadow 150ms var(--pp-ease)}
  .pp-step:hover{border-color:var(--pp-border-2);box-shadow:var(--pp-sh-1)}
  .pp-step::before{content:'0' counter(step);font-family:var(--pp-f-mono);font-size:12px;letter-spacing:.1em;color:var(--pp-accent);display:block;margin-bottom:var(--pp-sp-24)}
  .pp-step h3{margin-bottom:var(--pp-sp-12)}
  .pp-step p{font-size:15px;color:var(--pp-ink-2)}
  @media(max-width:768px){.pp-how-grid{grid-template-columns:1fr}}
  @media(max-width:900px){.pp-step{padding:var(--pp-sp-24)}.pp-step::before{margin-bottom:var(--pp-sp-16)}}
  @media(max-width:560px){.pp-step h3{font-size:18px}.pp-step p{font-size:14px}}
</style>
<section class="pp-section pp-how pp-pad" id="how">
  <div class="pp-container">
    <div class="pp-section-head pp-reveal">
      <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
      <h2><?php echo esc_html( $s['heading'] ); ?></h2>
      <?php if ( ! empty( $s['body'] ) ) : ?>
      <p><?php echo esc_html( $s['body'] ); ?></p>
      <?php endif; ?>
    </div>
    <div class="pp-how-grid">
      <?php foreach ( $s['steps'] as $step ) : ?>
      <div class="pp-step pp-reveal">
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
