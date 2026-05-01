<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_About_Peptides extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_06_about_peptides'; }
    public function get_title()      { return '06 — About Peptides'; }
    public function get_icon()       { return 'eicon-info-circle'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'about', 'peptides', 'science', 'pp-uk' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'section_left', [
            'label' => 'Left Column',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'What Are Peptides?',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Short chains of amino acids — the building blocks of biology.',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'section_right', [
            'label' => 'Right Column',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'para_1', [
            'label'   => 'Paragraph 1',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Peptides are short chains of amino acids — the same building blocks that form proteins — but small enough to pass biological barriers that larger proteins cannot. In research settings they are used as signalling molecules that trigger highly targeted biological responses.',
            'rows'    => 4,
        ] );
        $this->add_control( 'para_2', [
            'label'   => 'Paragraph 2',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Unlike synthetic drugs, many peptides are identical or closely analogous to sequences produced naturally by the body. This structural familiarity means they are generally well-tolerated in preclinical models and show a high degree of tissue or receptor specificity.',
            'rows'    => 4,
        ] );
        $this->add_control( 'para_3', [
            'label'   => 'Paragraph 3',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Research into peptide therapeutics is accelerating: the global peptide market is forecast to exceed $70 billion by 2030, driven by approvals in metabolic disease, oncology and wound healing. Performance Peptide UK supplies the compounds that underpin this research at laboratory grade.',
            'rows'    => 4,
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'section_specs', [
            'label' => 'Spec List',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'key',   [ 'label' => 'Key',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Parameter' ] );
        $rep->add_control( 'value', [ 'label' => 'Value', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Specification' ] );
        $this->add_control( 'specs', [
            'label'       => 'Specs',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'key' => 'Form',          'value' => 'Lyophilised powder in sealed glass vial' ],
                [ 'key' => 'Storage',      'value' => '-20°C until reconstitution; 4°C once reconstituted' ],
                [ 'key' => 'Reconstitution', 'value' => 'Bacteriostatic water; see product guide' ],
                [ 'key' => 'Shelf Life',   'value' => '≥ 24 months lyophilised; 30 days reconstituted' ],
                [ 'key' => 'Use',          'value' => 'Research purposes only' ],
            ],
            'title_field' => '{{{ key }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-about{background:var(--pp-bg)}
  .pp-about-grid{display:grid;grid-template-columns:1fr 1.2fr;gap:var(--pp-sp-96);align-items:start}
  .pp-about-left .pp-eyebrow{margin-bottom:var(--pp-sp-16)}
  .pp-about-left h2{margin-bottom:0}
  .pp-about-body p{font-size:16px;line-height:1.75;color:var(--pp-ink-2);margin-bottom:var(--pp-sp-24)}
  .pp-about-body p:last-of-type{margin-bottom:0}
  .pp-about-list{list-style:none;padding:0;margin-top:var(--pp-sp-32);border-top:1px solid var(--pp-border)}
  .pp-about-list li{display:grid;grid-template-columns:auto 1fr;gap:var(--pp-sp-16);padding:var(--pp-sp-16) 0;border-bottom:1px solid var(--pp-border)}
  .pp-about-list .pp-k{font-family:var(--pp-f-mono);font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:var(--pp-ink-3);min-width:120px;padding-top:3px}
  .pp-about-list .pp-v{font-size:15px;color:var(--pp-ink-2)}
  @media(max-width:1024px){.pp-about-grid{gap:var(--pp-sp-64)}}
  @media(max-width:900px){
    .pp-about-grid{grid-template-columns:1fr;gap:var(--pp-sp-40)}
    .pp-about-body p{font-size:15px}
    .pp-about-list .pp-k{min-width:100px;font-size:10px}
    .pp-about-list .pp-v{font-size:14px}
  }
  @media(max-width:560px){
    .pp-about-list li{grid-template-columns:1fr;gap:var(--pp-sp-4)}
    .pp-about-list .pp-k{min-width:unset}
  }
</style>
<section class="pp-section pp-about pp-pad" id="about">
  <div class="pp-container">
    <div class="pp-about-grid">
      <div class="pp-about-left pp-reveal">
        <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
      </div>
      <div class="pp-about-body pp-reveal">
        <?php if ( ! empty( $s['para_1'] ) ) : ?>
        <p><?php echo esc_html( $s['para_1'] ); ?></p>
        <?php endif; ?>
        <?php if ( ! empty( $s['para_2'] ) ) : ?>
        <p><?php echo esc_html( $s['para_2'] ); ?></p>
        <?php endif; ?>
        <?php if ( ! empty( $s['para_3'] ) ) : ?>
        <p><?php echo esc_html( $s['para_3'] ); ?></p>
        <?php endif; ?>
        <?php if ( ! empty( $s['specs'] ) ) : ?>
        <ul class="pp-about-list">
          <?php foreach ( $s['specs'] as $spec ) : ?>
          <li>
            <span class="pp-k"><?php echo esc_html( $spec['key'] ); ?></span>
            <span class="pp-v"><?php echo esc_html( $spec['value'] ); ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
        <?php
    }
}
