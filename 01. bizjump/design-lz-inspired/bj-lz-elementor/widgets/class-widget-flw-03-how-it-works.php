<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-03 — How It Works (Formation Landing)
 * 3-step horizontal flow with connecting line. Step 1 is highlighted (orange filled),
 * steps 2 and 3 are outlined.
 */
class Widget_FLW_How_It_Works extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_03_how_it_works'; }
    public function get_title()      { return 'FLW 03 — How It Works'; }
    public function get_icon()       { return 'eicon-number-field'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'process', 'steps', 'how it works', 'bizjump', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_header', [
            'label' => 'Section Header', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'label_text', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Process' ] );
        $this->add_control( 'title_text', [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Formation in 3 Simple Steps' ] );
        $this->add_control( 'sub_text',   [ 'label' => 'Subtitle','type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'From start to official approval — we guide you every step of the way.' ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_steps', [
            'label' => 'Steps', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'num',   [ 'label' => 'Step Number', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '1' ] );
        $rep->add_control( 'title', [ 'label' => 'Title',       'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Step Title' ] );
        $rep->add_control( 'desc',  [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Description goes here.' ] );
        $rep->add_control( 'highlight', [
            'label' => 'Highlighted (orange filled)', 'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes', 'default' => '',
        ] );
        $this->add_control( 'steps', [
            'label' => 'Steps', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $rep->get_controls(),
            'default' => [
                [ 'num' => '1', 'title' => 'Choose & Customize', 'desc' => 'Pick your entity, enter your business name, state, and details — takes about 10 minutes.', 'highlight' => 'yes' ],
                [ 'num' => '2', 'title' => 'We File for You',    'desc' => 'BizJump prepares and submits your formation documents directly to the state.', 'highlight' => '' ],
                [ 'num' => '3', 'title' => "You're Official",    'desc' => 'Receive your approved documents and start operating as a legally formed business.', 'highlight' => '' ],
            ],
            'title_field' => '{{{ num }}} — {{{ title }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.flw03-section { padding: 72px 0; background: #FFFFFF; font-family: 'Inter', sans-serif; }
.flw03-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.flw03-header { text-align: center; margin-bottom: 48px; }
.flw03-label { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #F97316; margin-bottom: 10px; }
.flw03-title { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: clamp(22px,3vw,34px); font-weight: 800; color: #0F172A; line-height: 1.2; letter-spacing: -.02em; margin: 0 0 12px; }
.flw03-sub { font-size: 16px; color: #94A3B8; max-width: 460px; margin: 0 auto; line-height: 1.65; }

.flw03-steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0; position: relative; max-width: 640px; margin: 0 auto; }
.flw03-steps::before { content: ''; position: absolute; top: 28px; left: calc(16.66% + 28px); right: calc(16.66% + 28px); height: 2px; background: #E2E8F0; z-index: 0; }
.flw03-step { text-align: center; padding: 0 20px; position: relative; z-index: 1; }
.flw03-circle { width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: 20px; font-weight: 800; border: 2px solid #CBD5E1; background: #fff; color: #94A3B8; transition: all .3s; }
.flw03-circle.flw03-hl { background: #F97316; border-color: #F97316; color: #fff; box-shadow: 0 4px 14px rgba(249,115,22,.32); }
.flw03-step-title { font-size: 16px; font-weight: 700; color: #1E293B; margin-bottom: 6px; }
.flw03-step-desc  { font-size: 14px; color: #94A3B8; line-height: 1.6; }

@media (max-width: 768px) {
  .flw03-section { padding: 56px 0; }
  .flw03-steps { grid-template-columns: 1fr; max-width: 360px; gap: 32px; }
  .flw03-steps::before { display: none; }
  .flw03-step { padding: 0; }
}
</style>

<section class="flw03-section">
  <div class="flw03-inner">
    <div class="flw03-header">
      <span class="flw03-label"><?php echo esc_html( $s['label_text'] ); ?></span>
      <h2 class="flw03-title"><?php echo esc_html( $s['title_text'] ); ?></h2>
      <p class="flw03-sub"><?php echo esc_html( $s['sub_text'] ); ?></p>
    </div>

    <div class="flw03-steps">
      <?php foreach ( (array) $s['steps'] as $st ) :
        $hl = ! empty( $st['highlight'] ) && $st['highlight'] === 'yes';
      ?>
      <div class="flw03-step">
        <div class="flw03-circle<?php echo $hl ? ' flw03-hl' : ''; ?>"><?php echo esc_html( $st['num'] ); ?></div>
        <div class="flw03-step-title"><?php echo esc_html( $st['title'] ); ?></div>
        <p class="flw03-step-desc"><?php echo esc_html( $st['desc'] ); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
