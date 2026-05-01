<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DLW-05 — Comparison Table (Demo Landing)
 * 4-col plan comparison. Stacks into per-plan cards on mobile (≤700px).
 * Each row stores 3 values (Basic/Pro/Premium): "y" = check, anything else = dash.
 */
class Widget_DLW_Comparison_Table extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dlw_05_comparison'; }
    public function get_title()      { return 'DLW 05 — Comparison Table'; }
    public function get_icon()       { return 'eicon-table'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'comparison', 'table', 'pricing', 'plans', 'bizjump', 'dlw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_header', [
            'label' => 'Section Header', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'label_text', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Compare' ] );
        $this->add_control( 'title_text', [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Plan Comparison' ] );
        $this->end_controls_section();

        /* ── Column Headers ── */
        $this->start_controls_section( 'sec_columns', [
            'label' => 'Column Headers', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'col_feature', [ 'label' => 'Feature Column Title',  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Feature' ] );
        $this->add_control( 'col_1', [ 'label' => 'Plan 1 Title',                'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Basic' ] );
        $this->add_control( 'col_2', [ 'label' => 'Plan 2 Title (featured)',     'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Pro' ] );
        $this->add_control( 'col_3', [ 'label' => 'Plan 3 Title',                'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Premium' ] );
        $this->end_controls_section();

        /* ── Rows ── */
        $this->start_controls_section( 'sec_rows', [
            'label' => 'Rows', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'feature', [ 'label' => 'Feature Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Feature' ] );
        $rep->add_control( 'p1', [
            'label' => 'Plan 1', 'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes', 'default' => '',
            'label_on' => 'Yes', 'label_off' => 'No',
        ] );
        $rep->add_control( 'p2', [
            'label' => 'Plan 2', 'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes', 'default' => 'yes',
            'label_on' => 'Yes', 'label_off' => 'No',
        ] );
        $rep->add_control( 'p3', [
            'label' => 'Plan 3', 'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes', 'default' => 'yes',
            'label_on' => 'Yes', 'label_off' => 'No',
        ] );

        $this->add_control( 'rows', [
            'label' => 'Rows',
            'type'  => \Elementor\Controls_Manager::REPEATER,
            'fields'=> $rep->get_controls(),
            'default' => [
                [ 'feature' => 'LLC Articles of Organization', 'p1' => 'yes', 'p2' => 'yes', 'p3' => 'yes' ],
                [ 'feature' => 'Name Availability Search',     'p1' => 'yes', 'p2' => 'yes', 'p3' => 'yes' ],
                [ 'feature' => 'Registered Agent (1 Year)',    'p1' => '',    'p2' => 'yes', 'p3' => 'yes' ],
                [ 'feature' => 'Operating Agreement',          'p1' => '',    'p2' => 'yes', 'p3' => 'yes' ],
                [ 'feature' => 'EIN / Tax ID Filing',          'p1' => '',    'p2' => 'yes', 'p3' => 'yes' ],
                [ 'feature' => 'Business Bank Account',        'p1' => '',    'p2' => '',    'p3' => 'yes' ],
                [ 'feature' => 'Domain + Business Email',      'p1' => '',    'p2' => '',    'p3' => 'yes' ],
            ],
            'title_field' => '{{{ feature }}}',
        ] );

        $this->end_controls_section();
    }

    private function cell( $is_yes ) {
        if ( $is_yes ) {
            return '<div class="dlw05-check"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>';
        }
        return '<div class="dlw05-dash"></div>';
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.dlw05-section { padding: 88px 0; background: #FFFFFF; font-family: 'Inter', sans-serif; }
.dlw05-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.dlw05-header { text-align: center; margin-bottom: 56px; }
.dlw05-label { display: inline-block; font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #F97316; margin-bottom: 12px; }
.dlw05-title { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: clamp(26px,3.5vw,40px); font-weight: 800; color: #0F172A; line-height: 1.2; letter-spacing: -.02em; margin: 0 0 14px; }
.dlw05-wrap { background: #fff; border: 1px solid #E2E8F0; border-radius: 16px; box-shadow: 0 4px 14px rgba(15,23,42,.10); overflow: hidden; }
.dlw05-head { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; background: #F8FAFC; border-bottom: 1px solid #E2E8F0; padding: 0 24px; }
.dlw05-th { padding: 18px 12px; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #94A3B8; }
.dlw05-th.dlw05-featured { color: #F97316; position: relative; }
.dlw05-th.dlw05-featured::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #F97316; border-radius: 3px 3px 0 0; }
.dlw05-row { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; padding: 0 24px; border-bottom: 1px solid #F1F5F9; align-items: center; }
.dlw05-row:last-child { border-bottom: none; }
.dlw05-row:hover { background: #F8FAFC; }
.dlw05-td { padding: 15px 12px; font-size: 14px; color: #475569; }
.dlw05-label-td { font-weight: 500; color: #334155; }
.dlw05-center { text-align: center; }
.dlw05-check { width: 20px; height: 20px; background: #EEF2FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: #6366F1; }
.dlw05-dash { width: 20px; height: 2px; background: #E2E8F0; margin: 0 auto; border-radius: 2px; }
.dlw05-mh { display: none; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #94A3B8; }

@media (max-width: 900px) {
  .dlw05-section { padding: 64px 0; }
  .dlw05-th, .dlw05-td { font-size: 12px; padding: 14px 8px; }
  .dlw05-head, .dlw05-row { padding: 0 14px; }
}
@media (max-width: 700px) {
  .dlw05-wrap { background: transparent; border: none; box-shadow: none; }
  .dlw05-head { display: none; }
  .dlw05-row {
    display: grid; grid-template-columns: 1fr; gap: 0;
    padding: 0; margin-bottom: 14px;
    background: #fff; border: 1px solid #E2E8F0;
    border-radius: 12px; overflow: hidden;
    box-shadow: 0 1px 3px rgba(15,23,42,.06);
  }
  .dlw05-row .dlw05-td { display: flex; align-items: center; justify-content: space-between; padding: 12px 18px; border-bottom: 1px solid #F1F5F9; text-align: left; }
  .dlw05-row .dlw05-td:last-child { border-bottom: none; }
  .dlw05-row .dlw05-label-td { background: #F8FAFC; font-weight: 700; color: #0F172A; font-size: 14px; padding: 14px 18px; }
  .dlw05-mh { display: inline-block; }
  .dlw05-check, .dlw05-dash { margin: 0; }
}
</style>

<section class="dlw05-section">
  <div class="dlw05-inner">
    <div class="dlw05-header">
      <span class="dlw05-label"><?php echo esc_html( $s['label_text'] ); ?></span>
      <h2 class="dlw05-title"><?php echo esc_html( $s['title_text'] ); ?></h2>
    </div>

    <div class="dlw05-wrap">
      <div class="dlw05-head">
        <div class="dlw05-th"><?php echo esc_html( $s['col_feature'] ); ?></div>
        <div class="dlw05-th"><?php echo esc_html( $s['col_1'] ); ?></div>
        <div class="dlw05-th dlw05-featured"><?php echo esc_html( $s['col_2'] ); ?></div>
        <div class="dlw05-th"><?php echo esc_html( $s['col_3'] ); ?></div>
      </div>
      <?php foreach ( (array) $s['rows'] as $r ) : ?>
        <div class="dlw05-row">
          <div class="dlw05-td dlw05-label-td"><?php echo esc_html( $r['feature'] ); ?></div>
          <div class="dlw05-td dlw05-center"><span class="dlw05-mh"><?php echo esc_html( $s['col_1'] ); ?></span><?php echo $this->cell( ! empty( $r['p1'] ) && $r['p1'] === 'yes' ); ?></div>
          <div class="dlw05-td dlw05-center"><span class="dlw05-mh"><?php echo esc_html( $s['col_2'] ); ?></span><?php echo $this->cell( ! empty( $r['p2'] ) && $r['p2'] === 'yes' ); ?></div>
          <div class="dlw05-td dlw05-center"><span class="dlw05-mh"><?php echo esc_html( $s['col_3'] ); ?></span><?php echo $this->cell( ! empty( $r['p3'] ) && $r['p3'] === 'yes' ); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
