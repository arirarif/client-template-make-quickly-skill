<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-06 — Stats Band (Formation Landing)
 * Dark slate-900 strip with 4 stats divided by vertical lines.
 */
class Widget_FLW_Stats_Band extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_06_stats'; }
    public function get_title()      { return 'FLW 06 — Stats Band'; }
    public function get_icon()       { return 'eicon-counter'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'stats', 'numbers', 'band', 'bizjump', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_items', [
            'label' => 'Stats', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'num',   [ 'label' => 'Number', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '4M+' ] );
        $rep->add_control( 'label', [ 'label' => 'Label',  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Businesses formed' ] );

        $this->add_control( 'items', [
            'label' => 'Stats', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $rep->get_controls(),
            'default' => [
                [ 'num' => '4M+',  'label' => 'Businesses formed' ],
                [ 'num' => '4.7★', 'label' => 'Average customer rating' ],
                [ 'num' => '50',   'label' => 'States served' ],
                [ 'num' => '24hr', 'label' => 'Expedited filing available' ],
            ],
            'title_field' => '{{{ num }}} — {{{ label }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $count = max( 1, count( (array) $s['items'] ) );
        ?>
<style>
.flw06-band { background: #0F172A; padding: 44px 0; font-family: 'Inter', sans-serif; }
.flw06-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.flw06-grid { display: grid; grid-template-columns: repeat(<?php echo (int) $count; ?>, 1fr); gap: 0; }
.flw06-item { text-align: center; padding: 0 20px; border-right: 1px solid rgba(255,255,255,.08); }
.flw06-item:last-child { border-right: none; }
.flw06-num { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: clamp(26px,3vw,38px); font-weight: 800; color: #F97316; line-height: 1; margin-bottom: 6px; }
.flw06-label { font-size: 13px; color: rgba(255,255,255,.5); font-weight: 500; }

@media (max-width: 700px) {
  .flw06-grid { grid-template-columns: repeat(2, 1fr); gap: 24px 0; }
  .flw06-item { border-right: none; padding: 12px 16px; }
  .flw06-item:nth-child(odd) { border-right: 1px solid rgba(255,255,255,.08); }
}
@media (max-width: 420px) {
  .flw06-grid { grid-template-columns: 1fr; }
  .flw06-item { border-right: none !important; border-bottom: 1px solid rgba(255,255,255,.08); padding: 14px 0; }
  .flw06-item:last-child { border-bottom: none; }
}
</style>

<div class="flw06-band">
  <div class="flw06-inner">
    <div class="flw06-grid">
      <?php foreach ( (array) $s['items'] as $it ) : ?>
        <div class="flw06-item">
          <div class="flw06-num"><?php echo esc_html( $it['num'] ); ?></div>
          <div class="flw06-label"><?php echo esc_html( $it['label'] ); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
        <?php
    }
}
