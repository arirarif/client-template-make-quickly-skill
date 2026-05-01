<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DAL-05 — Trust Strip "Since 1998" (Doc-Aligned Landing)
 * Source: 03. bizjump-doc-aligned/formation-landing.html — .trust-strip
 * Cream band with bold orange-emphasized number and small tag below.
 * Allowed inline tags in body: <strong>, <b>, <em>, <a>.
 */
class Widget_DAL_Trust_Strip extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dal_05_trust_strip'; }
    public function get_title()      { return 'DAL 05 — Trust Strip'; }
    public function get_icon()       { return 'eicon-info-box'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'trust', 'since', 'strip', 'band', 'bizjump', 'dal' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_main', [
            'label' => 'Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'body', [
            'label'       => 'Body Text (HTML allowed: strong, b, em, a)',
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'rows'        => 4,
            'default'     => 'Since 1998, BizJump small business experts have helped more than <strong>3,000+ entrepreneurs</strong> turn ideas into successful businesses.',
        ] );
        $this->add_control( 'tag', [
            'label'   => 'Small Tag Below',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Your journey starts here.',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_style', [
            'label' => 'Style',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'bg_color', [
            'label'   => 'Background',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#FAF6F0',
        ] );
        $this->add_control( 'border_color', [
            'label'   => 'Top/Bottom Border Color',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#EFE7DA',
        ] );
        $this->add_control( 'orange_600', [
            'label'   => 'Orange (number emphasis)',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#EA580C',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $bg   = esc_attr( $s['bg_color']     ?: '#FAF6F0' );
        $br   = esc_attr( $s['border_color'] ?: '#EFE7DA' );
        $o600 = esc_attr( $s['orange_600']   ?: '#EA580C' );
        $uid  = 'dal05_' . $this->get_id();
        ?>
<style>
.<?php echo $uid; ?>.dal05-strip {
  background: <?php echo $bg; ?>;
  padding: 48px 0;
  text-align: center;
  border-top: 1px solid <?php echo $br; ?>;
  border-bottom: 1px solid <?php echo $br; ?>;
  font-family: 'Inter', sans-serif;
}
.<?php echo $uid; ?> .dal05-inner {
  max-width: 760px;
  margin: 0 auto;
  padding: 0 24px;
}
.<?php echo $uid; ?> .dal05-body {
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: clamp(17px, 2.1vw, 22px);
  font-weight: 600;
  color: #1E293B;
  line-height: 1.5;
  margin: 0;
}
.<?php echo $uid; ?> .dal05-body strong {
  color: <?php echo $o600; ?>;
  font-weight: 800;
}
.<?php echo $uid; ?> .dal05-tag {
  display: block;
  margin-top: 10px;
  font-size: 14px;
  color: #64748B;
  font-weight: 500;
}
</style>

<div class="<?php echo $uid; ?> dal05-strip">
  <div class="dal05-inner">
    <p class="dal05-body">
      <?php echo wp_kses_post( $s['body'] ); ?>
      <?php if ( ! empty( $s['tag'] ) ) : ?>
        <span class="dal05-tag"><?php echo esc_html( $s['tag'] ); ?></span>
      <?php endif; ?>
    </p>
  </div>
</div>
        <?php
    }
}
