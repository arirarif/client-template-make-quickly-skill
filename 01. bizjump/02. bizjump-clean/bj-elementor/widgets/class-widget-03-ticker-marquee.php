<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 03 — Ticker Marquee
 * Infinite horizontal scrolling ticker strip in BizJump blue.
 */
class Widget_Ticker_Marquee extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_03_ticker'; }
    public function get_title()      { return '03 — Ticker Marquee'; }
    public function get_icon()       { return 'eicon-slider-push'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'ticker', 'marquee', 'scroll', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_ticker', [
            'label' => 'Ticker Items',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'item_text', [
            'label'   => 'Item Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'LLC Formation',
        ] );

        $this->add_control( 'ticker_items', [
            'label'       => 'Ticker Items',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'item_text' => 'LLC Formation' ],
                [ 'item_text' => 'Corporation' ],
                [ 'item_text' => 'S-Corp Filing' ],
                [ 'item_text' => 'Non-Profit' ],
                [ 'item_text' => 'EIN / Tax ID' ],
                [ 'item_text' => 'Registered Agent' ],
                [ 'item_text' => 'Operating Agreement' ],
                [ 'item_text' => 'All 50 States' ],
                [ 'item_text' => 'Flat-Rate Pricing' ],
                [ 'item_text' => 'Business Financing' ],
                [ 'item_text' => 'Digital Marketing' ],
                [ 'item_text' => 'Accounting &amp; Tax' ],
            ],
            'title_field' => '{{{ item_text }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.bjw04-ticker {
  background: #2563eb;
  padding: 14px 0;
  overflow: hidden;
  border-top: 1px solid rgba(255,255,255,.08);
  border-bottom: 1px solid rgba(255,255,255,.08);
  font-family: 'Inter', sans-serif;
}
.bjw04-track {
  display: flex;
  width: max-content;
  animation: bjw04scroll 28s linear infinite;
  white-space: nowrap;
}
.bjw04-track:hover { animation-play-state: paused; }
.bjw04-item {
  display: inline-flex; align-items: center;
  padding: 0 32px;
  font-size: 13px; font-weight: 700;
  color: rgba(255,255,255,.9);
  text-transform: uppercase; letter-spacing: 1.5px;
  flex-shrink: 0;
}
.bjw04-item::after {
  content: '✦';
  margin-left: 32px;
  color: #f97316;
  font-size: 10px;
}
@keyframes bjw04scroll {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
</style>

<div class="bjw04-ticker" aria-hidden="true">
  <div class="bjw04-track">
    <?php
    /* Render set 1 */
    foreach ( $s['ticker_items'] as $item ) {
        echo '<span class="bjw04-item">' . esc_html( $item['item_text'] ) . '</span>';
    }
    /* Render set 2 (duplicate for seamless loop) */
    foreach ( $s['ticker_items'] as $item ) {
        echo '<span class="bjw04-item">' . esc_html( $item['item_text'] ) . '</span>';
    }
    ?>
  </div>
</div>
        <?php
    }
}
