<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 15 — About: Stats Strip
 * Dark ink background strip with 4 numerical stats displayed side by side.
 */
class Widget_About_Stats extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_15_about_stats'; }
    public function get_title()      { return '15 — About: Stats'; }
    public function get_icon()       { return 'eicon-counter'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'stats', 'numbers', 'about', 'strip', 'pp-uk' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_stats', [
            'label' => 'Stats',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'num',   [ 'label' => 'Number / Value', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '99.2%' ] );
        $rep->add_control( 'label', [ 'label' => 'Label',          'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Average Purity' ] );
        $rep->add_control( 'note',  [ 'label' => 'Note (small)',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'HPLC verified, all batches' ] );

        $this->add_control( 'stats', [
            'label'       => 'Stats',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'num' => '99.2%', 'label' => 'Average Purity',    'note' => 'HPLC verified, all batches' ],
                [ 'num' => '32',    'label' => 'Compounds',          'note' => 'In stock right now' ],
                [ 'num' => '100%',  'label' => '3rd-party Tested',   'note' => 'Independent labs only' ],
                [ 'num' => '1–2',   'label' => 'Day Dispatch',       'note' => 'From our UK facility' ],
            ],
            'title_field' => '{{{ num }}} — {{{ label }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-stats{background:var(--pp-ink)}
  .pp-stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0}
  .pp-stat{padding:var(--pp-sp-48) var(--pp-sp-32);border-right:1px solid rgba(255,255,255,.08)}
  .pp-stat:last-child{border-right:none}
  .pp-stat-num{font-size:clamp(32px,4vw,48px);font-weight:600;letter-spacing:-0.04em;color:var(--pp-bg);line-height:1;margin-bottom:var(--pp-sp-12)}
  .pp-stat-label{font-size:16px;font-weight:500;color:rgba(250,250,248,.8);margin-bottom:var(--pp-sp-8)}
  .pp-stat-note{font-family:var(--pp-f-mono);font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:rgba(250,250,248,.4);line-height:1.4}
  @media(max-width:900px){.pp-stats-grid{grid-template-columns:repeat(2,1fr)}.pp-stat{border-bottom:1px solid rgba(255,255,255,.08)}.pp-stat:nth-child(2){border-right:none}.pp-stat:nth-last-child(-n+2){border-bottom:none}.pp-stat{padding:var(--pp-sp-32) var(--pp-sp-24)}}
  @media(max-width:560px){.pp-stats-grid{grid-template-columns:1fr}.pp-stat{border-right:none;border-bottom:1px solid rgba(255,255,255,.08)}.pp-stat:last-child{border-bottom:none}}
</style>
<section class="pp-section pp-stats">
  <div class="pp-container" style="padding:0;max-width:none">
    <div class="pp-stats-grid">
      <?php foreach ( $s['stats'] as $i => $stat ) : ?>
      <div class="pp-stat pp-reveal" style="transition-delay:<?php echo $i * 80; ?>ms">
        <div class="pp-stat-num"><?php echo esc_html( $stat['num'] ); ?></div>
        <div class="pp-stat-label"><?php echo esc_html( $stat['label'] ); ?></div>
        <?php if ( $stat['note'] ) : ?>
        <div class="pp-stat-note"><?php echo esc_html( $stat['note'] ); ?></div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
