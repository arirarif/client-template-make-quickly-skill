<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Stat_Strip extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_10_stat_strip'; }
    public function get_title()      { return '10 — Stat Strip'; }
    public function get_icon()       { return 'eicon-counter'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'stats', 'strip', 'counter', 'numbers', 'peptides' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_stats', [
            'label' => 'Stats',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'num', [
            'label'   => 'Number',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'UK',
        ] );
        $rep->add_control( 'lbl', [
            'label'   => 'Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Held In Stock',
        ] );

        $this->add_control( 'stats', [
            'label'       => 'Stats (3–5 recommended)',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'num' => 'UK',   'lbl' => 'Held In Stock' ],
                [ 'num' => '52',   'lbl' => 'Compounds in Vault' ],
                [ 'num' => '3PM',  'lbl' => 'Same-Day Cutoff' ],
                [ 'num' => '24h',  'lbl' => 'Average Dispatch' ],
            ],
            'title_field' => '{{{ num }}} — {{{ lbl }}}',
        ] );

        $this->add_control( 'background', [
            'label'   => 'Background',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'gold',
            'options' => [
                'gold'  => 'Gold (default)',
                'glow'  => 'Cyan glow',
                'paper' => 'Paper',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $bg   = ! empty( $s['background'] ) ? sanitize_html_class( $s['background'] ) : 'gold';
        $cols = max( 1, count( $s['stats'] ) );
        ?>
<style>
  .pp-stat-strip-section { padding: 0 20px 70px; }
  .pp-stat-strip {
    border: var(--pp-border);
    border-radius: 36px;
    padding: 36px;
    box-shadow: var(--pp-shadow-xl);
    color: #000;
    display: grid;
    gap: 20px;
  }
  .pp-stat-strip.bg-gold  { background: var(--pp-gold); }
  .pp-stat-strip.bg-glow  { background: var(--pp-glow); }
  .pp-stat-strip.bg-paper { background: var(--pp-paper); }
  .pp-stat-strip .pp-num  {
    font: 900 56px var(--pp-f-body);
    line-height: 1;
  }
  .pp-stat-strip .pp-lbl  {
    font: 900 13px var(--pp-f-body);
    text-transform: uppercase;
    margin-top: 6px;
  }
  @media (max-width: 980px) {
    .pp-stat-strip { grid-template-columns: repeat(2, 1fr) !important; }
  }
  @media (max-width: 620px) {
    .pp-stat-strip { grid-template-columns: 1fr !important; }
  }
</style>
<section class="pp-section pp-bg-vault pp-stat-strip-section">
  <div class="pp-wrap">
    <div
      class="pp-stat-strip bg-<?php echo esc_attr( $bg ); ?>"
      style="grid-template-columns: repeat(<?php echo (int) $cols; ?>, 1fr);"
    >
      <?php foreach ( $s['stats'] as $stat ) : ?>
        <div>
          <div class="pp-num"><?php echo esc_html( $stat['num'] ); ?></div>
          <div class="pp-lbl"><?php echo esc_html( $stat['lbl'] ); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
