<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Compliance_Bar extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_01_compliance_bar'; }
    public function get_title()      { return '01 — Compliance Bar'; }
    public function get_icon()       { return 'eicon-alert'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'compliance', 'bar', 'notice', 'pp-uk' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'section_content', [
            'label' => 'Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'pill_1', [
            'label'   => 'Pill 1',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '18+ ONLY',
        ] );
        $this->add_control( 'pill_2', [
            'label'   => 'Pill 2',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'For Research Purposes Only',
        ] );
        $this->add_control( 'pill_3', [
            'label'   => 'Pill 3',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Not For Human Consumption',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-compliance{background:var(--pp-ink);color:var(--pp-bg);font-family:var(--pp-f-mono);font-size:12px;letter-spacing:.08em;text-transform:uppercase;padding:10px var(--pp-sp-16);text-align:center;line-height:1.5}
  .pp-compliance span{color:var(--pp-ink-4);margin:0 var(--pp-sp-12)}
  .pp-compliance strong{font-weight:500;color:var(--pp-bg)}
  @media(max-width:900px){.pp-compliance{font-size:10px;letter-spacing:.06em;padding:8px var(--pp-sp-16)}.pp-compliance span{margin:0 var(--pp-sp-8)}}
  @media(max-width:560px){.pp-compliance{font-size:9px;padding:6px var(--pp-sp-12)}.pp-compliance span{margin:0 6px}}
  @media(max-width:400px){.pp-compliance .pp-cb-last{display:none}}
</style>
<div class="pp-section pp-compliance" role="note">
  <strong><?php echo esc_html( $s['pill_1'] ); ?></strong>
  <span aria-hidden="true">·</span>
  <strong><?php echo esc_html( $s['pill_2'] ); ?></strong>
  <span class="pp-cb-last" aria-hidden="true">·</span>
  <strong class="pp-cb-last"><?php echo esc_html( $s['pill_3'] ); ?></strong>
</div>
        <?php
    }
}
