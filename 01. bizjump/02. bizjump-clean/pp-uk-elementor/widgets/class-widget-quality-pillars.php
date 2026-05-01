<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Quality_Pillars extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_07_quality_pillars'; }
    public function get_title()      { return '07 — Quality Pillars'; }
    public function get_icon()       { return 'eicon-shield'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'quality', 'pillars', 'trust', 'pp-uk' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Why Performance Peptide',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => "Three things we don't compromise on.",
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'section_pillars', [
            'label' => 'Pillars',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', [
            'label'   => 'Icon',
            'type'    => \Elementor\Controls_Manager::ICONS,
            'default' => [ 'value' => 'fas fa-check', 'library' => 'fa-solid' ],
        ] );
        $rep->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Pillar Title' ] );
        $rep->add_control( 'body',  [ 'label' => 'Body',  'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Pillar description.', 'rows' => 3 ] );
        $this->add_control( 'pillars', [
            'label'       => 'Pillars',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'title' => 'Independently tested',       'body' => 'Every batch is verified by a third-party UK lab using HPLC and mass spectrometry. Reports are linked on every product page — no logins required.' ],
                [ 'title' => 'UK shipped, discreet',       'body' => 'Orders dispatched same day from our UK depot in plain, sealed packaging. Cold-chain shipping for sensitive compounds. Tracked delivery as standard.' ],
                [ 'title' => 'Sterile, sealed, traceable', 'body' => 'Lyophilised under cleanroom conditions. Vials are tamper-evident. Each batch carries a unique ID you can cross-reference with its lab report.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-quality{background:var(--pp-ink);color:var(--pp-bg)}
  .pp-quality .pp-eyebrow{color:var(--pp-ink-4)}
  .pp-quality h2{color:var(--pp-bg)}
  .pp-quality .pp-section-head p{color:rgba(250,250,248,.65)}
  .pp-pillars{display:grid;grid-template-columns:repeat(3,1fr);gap:var(--pp-sp-16)}
  .pp-pillar{padding:var(--pp-sp-32);background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:var(--pp-r);transition:background 200ms var(--pp-ease)}
  .pp-pillar:hover{background:rgba(255,255,255,.07)}
  .pp-pillar-icon{width:32px;height:32px;color:var(--pp-bg);margin-bottom:var(--pp-sp-24)}
  .pp-pillar-icon i,.pp-pillar-icon svg{font-size:20px;width:100%;height:100%}
  .pp-pillar h3{color:var(--pp-bg);margin-bottom:var(--pp-sp-12)}
  .pp-pillar p{font-size:15px;color:rgba(250,250,248,.65)}
  @media(max-width:768px){.pp-pillars{grid-template-columns:1fr}}
  @media(max-width:900px){.pp-pillar{padding:var(--pp-sp-24)}}
  @media(max-width:560px){.pp-pillar h3{font-size:18px}.pp-pillar p{font-size:14px}}
</style>
<section class="pp-section pp-quality pp-pad" id="quality">
  <div class="pp-container">
    <div class="pp-section-head pp-reveal">
      <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
      <h2><?php echo esc_html( $s['heading'] ); ?></h2>
    </div>
    <div class="pp-pillars">
      <?php foreach ( $s['pillars'] as $p ) : ?>
      <div class="pp-pillar pp-reveal">
        <div class="pp-pillar-icon">
          <?php \Elementor\Icons_Manager::render_icon( $p['icon'], [ 'aria-hidden' => 'true' ] ); ?>
        </div>
        <h3><?php echo esc_html( $p['title'] ); ?></h3>
        <p><?php echo esc_html( $p['body'] ); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
