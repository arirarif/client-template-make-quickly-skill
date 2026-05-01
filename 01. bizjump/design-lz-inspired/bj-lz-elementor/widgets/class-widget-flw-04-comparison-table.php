<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-04 — Entity Comparison Table (Formation Landing)
 * 5-column table comparing Feature vs LLC / C Corp / S Corp / Nonprofit.
 * Cell types: 'check' / 'dash' / 'pill' (e.g. "Best fit").
 * Mobile (≤700px): stacks into per-entity cards.
 */
class Widget_FLW_Comparison_Table extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_04_comparison'; }
    public function get_title()      { return 'FLW 04 — Entity Comparison'; }
    public function get_icon()       { return 'eicon-table'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'comparison', 'table', 'llc', 'corp', 'bizjump', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_header', [
            'label' => 'Section Header', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'label_text', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Compare' ] );
        $this->add_control( 'title_text', [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Which Structure Fits You Best?' ] );
        $this->add_control( 'sub_text',   [ 'label' => 'Subtitle','type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'A quick side-by-side to help you decide before you start.' ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_columns', [
            'label' => 'Column Headers', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'col_feature', [ 'label' => 'Feature Col', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Feature' ] );
        $this->add_control( 'col_1', [ 'label' => 'Col 1 (highlighted)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'LLC' ] );
        $this->add_control( 'col_2', [ 'label' => 'Col 2', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'C Corp' ] );
        $this->add_control( 'col_3', [ 'label' => 'Col 3', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'S Corp' ] );
        $this->add_control( 'col_4', [ 'label' => 'Col 4', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Nonprofit' ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_rows', [
            'label' => 'Rows', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'feature', [ 'label' => 'Feature', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Feature name' ] );
        $cell_options = [ 'check' => '✓ Check', 'dash' => '— Dash', 'pill' => 'Pill (text)' ];
        foreach ( [ 'c1', 'c2', 'c3', 'c4' ] as $idx => $key ) {
            $rep->add_control( "{$key}_type", [
                'label' => "Col " . ( $idx + 1 ) . " Type",
                'type'  => \Elementor\Controls_Manager::SELECT,
                'options' => $cell_options,
                'default' => 'dash',
            ] );
            $rep->add_control( "{$key}_text", [
                'label' => "Col " . ( $idx + 1 ) . " Pill Text",
                'type'  => \Elementor\Controls_Manager::TEXT,
                'default' => 'Best fit',
                'condition' => [ "{$key}_type" => 'pill' ],
            ] );
        }

        $this->add_control( 'rows', [
            'label' => 'Rows', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $rep->get_controls(),
            'default' => [
                [ 'feature' => 'Personal liability protection',  'c1_type' => 'check', 'c2_type' => 'check', 'c3_type' => 'check', 'c4_type' => 'check' ],
                [ 'feature' => 'Pass-through taxation',          'c1_type' => 'check', 'c2_type' => 'dash',  'c3_type' => 'check', 'c4_type' => 'dash' ],
                [ 'feature' => 'Raise venture capital / issue stock', 'c1_type' => 'dash', 'c2_type' => 'check', 'c3_type' => 'dash', 'c4_type' => 'dash' ],
                [ 'feature' => 'Tax-exempt status (501c3)',      'c1_type' => 'dash',  'c2_type' => 'dash',  'c3_type' => 'dash', 'c4_type' => 'check' ],
                [ 'feature' => 'Best for most small businesses', 'c1_type' => 'pill', 'c1_text' => 'Best fit', 'c2_type' => 'dash',  'c3_type' => 'dash', 'c4_type' => 'dash' ],
                [ 'feature' => 'No board of directors required', 'c1_type' => 'check', 'c2_type' => 'dash',  'c3_type' => 'dash', 'c4_type' => 'dash' ],
            ],
            'title_field' => '{{{ feature }}}',
        ] );
        $this->end_controls_section();
    }

    private function render_cell( $type, $text = '' ) {
        switch ( $type ) {
            case 'check':
                return '<div class="flw04-check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>';
            case 'pill':
                return '<div class="flw04-pill">' . esc_html( $text ) . '</div>';
            default:
                return '<div class="flw04-dash"></div>';
        }
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.flw04-section { padding: 72px 0; background: #F5F2EE; font-family: 'Inter', sans-serif; }
.flw04-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.flw04-header { text-align: center; margin-bottom: 48px; }
.flw04-label { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #F97316; margin-bottom: 10px; }
.flw04-title { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: clamp(22px,3vw,34px); font-weight: 800; color: #0F172A; line-height: 1.2; letter-spacing: -.02em; margin: 0 0 12px; }
.flw04-sub { font-size: 16px; color: #94A3B8; max-width: 460px; margin: 0 auto; line-height: 1.65; }

.flw04-wrap { background: #fff; border: 1px solid #E2E8F0; border-radius: 16px; box-shadow: 0 4px 14px rgba(15,23,42,.10); overflow: hidden; }
.flw04-head { display: grid; grid-template-columns: 1.6fr 1fr 1fr 1fr 1fr; background: #F8FAFC; border-bottom: 1px solid #E2E8F0; padding: 0 20px; }
.flw04-th { padding: 14px 10px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #94A3B8; }
.flw04-th.flw04-hl { color: #F97316; }
.flw04-row { display: grid; grid-template-columns: 1.6fr 1fr 1fr 1fr 1fr; padding: 0 20px; border-bottom: 1px solid #F1F5F9; align-items: center; }
.flw04-row:nth-child(even) { background: #F8FAFC; }
.flw04-row:last-child { border-bottom: none; }
.flw04-row:hover { background: #FFF7ED; }
.flw04-td { padding: 13px 10px; font-size: 13px; color: #475569; }
.flw04-label-td { font-weight: 600; color: #334155; }
.flw04-center { text-align: center; }
.flw04-check { width: 18px; height: 18px; border-radius: 50%; background: #EEF2FF; color: #6366F1; display: flex; align-items: center; justify-content: center; margin: 0 auto; }
.flw04-dash { width: 18px; height: 2px; background: #E2E8F0; margin: 0 auto; border-radius: 2px; }
.flw04-pill { display: inline-flex; align-items: center; justify-content: center; background: #FFF7ED; color: #EA580C; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 999px; border: 1px solid #FFEDD5; white-space: nowrap; }
.flw04-mh { display: none; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #94A3B8; }

@media (max-width: 900px) {
  .flw04-th, .flw04-td { font-size: 11.5px; padding: 12px 6px; }
  .flw04-head, .flw04-row { padding: 0 10px; }
}
@media (max-width: 700px) {
  .flw04-wrap { background: transparent; border: none; box-shadow: none; }
  .flw04-head { display: none; }
  .flw04-row { display: grid; grid-template-columns: 1fr; gap: 0; padding: 0; margin-bottom: 14px; background: #fff; border: 1px solid #E2E8F0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(15,23,42,.06); }
  .flw04-row:nth-child(even) { background: #fff; }
  .flw04-row .flw04-td { display: flex; align-items: center; justify-content: space-between; padding: 12px 18px; border-bottom: 1px solid #F1F5F9; }
  .flw04-row .flw04-td:last-child { border-bottom: none; }
  .flw04-row .flw04-label-td { background: #F8FAFC; font-weight: 700; color: #0F172A; font-size: 14px; padding: 14px 18px; }
  .flw04-mh { display: inline-block; }
  .flw04-check, .flw04-dash, .flw04-pill { margin: 0; }
}
</style>

<section class="flw04-section">
  <div class="flw04-inner">
    <div class="flw04-header">
      <span class="flw04-label"><?php echo esc_html( $s['label_text'] ); ?></span>
      <h2 class="flw04-title"><?php echo esc_html( $s['title_text'] ); ?></h2>
      <p class="flw04-sub"><?php echo esc_html( $s['sub_text'] ); ?></p>
    </div>

    <div class="flw04-wrap">
      <div class="flw04-head">
        <div class="flw04-th"><?php echo esc_html( $s['col_feature'] ); ?></div>
        <div class="flw04-th flw04-hl"><?php echo esc_html( $s['col_1'] ); ?></div>
        <div class="flw04-th"><?php echo esc_html( $s['col_2'] ); ?></div>
        <div class="flw04-th"><?php echo esc_html( $s['col_3'] ); ?></div>
        <div class="flw04-th"><?php echo esc_html( $s['col_4'] ); ?></div>
      </div>

      <?php foreach ( (array) $s['rows'] as $r ) : ?>
      <div class="flw04-row">
        <div class="flw04-td flw04-label-td"><?php echo esc_html( $r['feature'] ); ?></div>
        <div class="flw04-td flw04-center"><span class="flw04-mh"><?php echo esc_html( $s['col_1'] ); ?></span><?php echo $this->render_cell( $r['c1_type'], $r['c1_text'] ?? '' ); ?></div>
        <div class="flw04-td flw04-center"><span class="flw04-mh"><?php echo esc_html( $s['col_2'] ); ?></span><?php echo $this->render_cell( $r['c2_type'], $r['c2_text'] ?? '' ); ?></div>
        <div class="flw04-td flw04-center"><span class="flw04-mh"><?php echo esc_html( $s['col_3'] ); ?></span><?php echo $this->render_cell( $r['c3_type'], $r['c3_text'] ?? '' ); ?></div>
        <div class="flw04-td flw04-center"><span class="flw04-mh"><?php echo esc_html( $s['col_4'] ); ?></span><?php echo $this->render_cell( $r['c4_type'], $r['c4_text'] ?? '' ); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
