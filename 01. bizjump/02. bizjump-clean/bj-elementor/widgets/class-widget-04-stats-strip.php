<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 04 — Stats Strip
 * Four animated counters displaying key BizJump trust statistics.
 */
class Widget_Stats_Strip extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_04_stats'; }
    public function get_title()      { return '04 — Stats Strip'; }
    public function get_icon()       { return 'eicon-counter'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'stats', 'counter', 'numbers', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_stats', [
            'label' => 'Stats',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'num', [
            'label'   => 'Display Value (e.g. 3,500+)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '3,500+',
            'description' => 'This is the visual display. For animation, set Counter Target below.',
        ] );

        $rep->add_control( 'counter_target', [
            'label'       => 'Counter Target (numeric only, leave blank to skip animation)',
            'type'        => \Elementor\Controls_Manager::NUMBER,
            'default'     => 3500,
            'description' => 'The number the counter counts up to.',
        ] );

        $rep->add_control( 'counter_suffix', [
            'label'   => 'Counter Suffix (e.g. + or %)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '+',
        ] );

        $rep->add_control( 'counter_prefix', [
            'label'   => 'Counter Prefix (e.g. $)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '',
        ] );

        $rep->add_control( 'label', [
            'label'   => 'Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Businesses Formed',
        ] );

        $rep->add_control( 'sub', [
            'label'   => 'Sub-label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Since 1998',
        ] );

        $this->add_control( 'stats', [
            'label'       => 'Stats',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'num'            => '3,000+',
                    'counter_target' => 3000,
                    'counter_suffix' => '+',
                    'counter_prefix' => '',
                    'label'          => 'Businesses Formed',
                    'sub'            => 'Since 1998',
                ],
                [
                    'num'            => '50',
                    'counter_target' => 50,
                    'counter_suffix' => '',
                    'counter_prefix' => '',
                    'label'          => 'States Supported',
                    'sub'            => 'All across the USA',
                ],
                [
                    'num'            => '25+',
                    'counter_target' => 25,
                    'counter_suffix' => '+',
                    'counter_prefix' => '',
                    'label'          => 'Years of Experience',
                    'sub'            => 'Trusted since 1998',
                ],
                [
                    'num'            => '$0',
                    'counter_target' => 0,
                    'counter_suffix' => '',
                    'counter_prefix' => '$',
                    'label'          => 'Hidden Fees',
                    'sub'            => 'Always transparent',
                ],
            ],
            'title_field' => '{{{ num }}} — {{{ label }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.bjw05-stats {
  background: #fff;
  padding: 56px 32px;
  border-bottom: 1px solid #f3f4f6;
  font-family: 'Inter', sans-serif;
}
.bjw05-grid {
  max-width: 1000px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(<?php echo count( $s['stats'] ); ?>, 1fr);
}
.bjw05-item {
  text-align: center;
  padding: 24px 16px;
  border-right: 1px solid #f3f4f6;
}
.bjw05-item:last-child { border-right: none; }
.bjw05-num {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 42px; font-weight: 800;
  color: #0f2156; line-height: 1;
  letter-spacing: -1px;
}
.bjw05-label {
  font-size: 14px; color: #6b7280;
  margin-top: 8px; font-weight: 500;
}
.bjw05-sub {
  font-size: 12px; color: #d1d5db; margin-top: 3px;
}
@media (max-width: 768px) {
  .bjw05-grid { grid-template-columns: repeat(2, 1fr); }
  .bjw05-item { border-right: none; border-bottom: 1px solid #f3f4f6; padding: 20px 12px; }
  .bjw05-item:nth-child(odd) { border-right: 1px solid #f3f4f6; }
  .bjw05-item:nth-child(3), .bjw05-item:nth-child(4) { border-bottom: none; }
  .bjw05-num { font-size: 34px; }
}
@media (max-width: 480px) {
  .bjw05-stats { padding: 40px 16px; }
}
</style>

<div class="bjw05-stats">
  <div class="bjw05-grid">
    <?php foreach ( $s['stats'] as $stat ) :
        $target  = isset( $stat['counter_target'] ) ? intval( $stat['counter_target'] ) : 0;
        $suffix  = isset( $stat['counter_suffix'] ) ? esc_attr( $stat['counter_suffix'] ) : '';
        $prefix  = isset( $stat['counter_prefix'] ) ? esc_attr( $stat['counter_prefix'] ) : '';
        $animate = ( $target > 0 );
    ?>
    <div class="bjw05-item">
      <div class="bjw05-num"<?php if ( $animate ) : ?> data-bjw05-target="<?php echo esc_attr( $target ); ?>" data-bjw05-suffix="<?php echo $suffix; ?>" data-bjw05-prefix="<?php echo $prefix; ?>"<?php endif; ?>><?php echo esc_html( $stat['num'] ); ?></div>
      <div class="bjw05-label"><?php echo esc_html( $stat['label'] ); ?></div>
      <div class="bjw05-sub"><?php echo esc_html( $stat['sub'] ); ?></div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
(function(){
  document.querySelectorAll('[data-bjw05-target]').forEach(function(el){
    var target = parseInt(el.getAttribute('data-bjw05-target'), 10);
    var suf    = el.getAttribute('data-bjw05-suffix') || '';
    var pre    = el.getAttribute('data-bjw05-prefix') || '';
    var started = false;
    var obs = new IntersectionObserver(function(entries){
      if(entries[0].isIntersecting && !started){
        started = true;
        var start = performance.now();
        var dur   = 1600;
        (function tick(now){
          var p    = Math.min((now - start) / dur, 1);
          var ease = 1 - Math.pow(1 - p, 3);
          el.textContent = pre + Math.floor(ease * target).toLocaleString() + suf;
          if(p < 1) requestAnimationFrame(tick);
          else el.textContent = pre + target.toLocaleString() + suf;
        })(start);
        obs.unobserve(el);
      }
    }, {threshold: 0.5});
    obs.observe(el);
  });
})();
</script>
        <?php
    }
}
