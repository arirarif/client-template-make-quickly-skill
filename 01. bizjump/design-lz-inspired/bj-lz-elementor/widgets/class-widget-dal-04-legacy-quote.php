<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DAL-04 — Legacy Quote (Doc-Aligned Landing)
 * Source: 03. bizjump-doc-aligned/formation-landing.html — .legacy-zone
 * Dark slate gradient bg with two soft radial accents (orange + indigo),
 * centered headline, body paragraphs, and orange tagline.
 */
class Widget_DAL_Legacy_Quote extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dal_04_legacy_quote'; }
    public function get_title()      { return 'DAL 04 — Legacy Quote'; }
    public function get_icon()       { return 'eicon-testimonial-carousel'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'legacy', 'quote', 'dark', 'gradient', 'bizjump', 'dal' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_main', [
            'label' => 'Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'headline', [
            'label'   => 'Headline',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Build something greater than yourself.',
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'text', [
            'label' => 'Body Paragraph',
            'type'  => \Elementor\Controls_Manager::TEXTAREA,
            'rows'  => 3,
        ] );
        $this->add_control( 'paragraphs', [
            'label'   => 'Body Paragraphs',
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $rep->get_controls(),
            'default' => [
                [ 'text' => 'Create a business that lasts beyond you—one that carries your vision, extends your influence, and builds lasting wealth for years to come. This is more than starting a company.' ],
                [ 'text' => 'It\'s about creating a legacy that endures.' ],
            ],
            'title_field' => '{{{ text.substring(0, 50) }}}…',
        ] );

        $this->add_control( 'tagline', [
            'label'   => 'Orange Tagline',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => "Welcome to BizJump. Let's build what lasts.",
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_style', [
            'label' => 'Style',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'bg_dark_a', [
            'label'   => 'BG Dark Start',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#0F172A',
        ] );
        $this->add_control( 'bg_dark_b', [
            'label'   => 'BG Dark End',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#1E293B',
        ] );
        $this->add_control( 'orange_400', [
            'label'   => 'Orange Tagline Color',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#FB923C',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $a    = esc_attr( $s['bg_dark_a'] ?: '#0F172A' );
        $b    = esc_attr( $s['bg_dark_b'] ?: '#1E293B' );
        $o400 = esc_attr( $s['orange_400'] ?: '#FB923C' );
        $uid  = 'dal04_' . $this->get_id();
        ?>
<style>
.<?php echo $uid; ?>.dal04-zone {
  background: linear-gradient(135deg, <?php echo $a; ?> 0%, <?php echo $b; ?> 100%);
  color: #fff;
  padding: 96px 0;
  text-align: center;
  position: relative;
  overflow: hidden;
  font-family: 'Inter', sans-serif;
}
.<?php echo $uid; ?>.dal04-zone::before {
  content: '';
  position: absolute;
  top: -30%; left: -20%;
  width: 560px; height: 560px;
  background: radial-gradient(circle, rgba(249,115,22,.15) 0%, transparent 70%);
  border-radius: 50%;
}
.<?php echo $uid; ?>.dal04-zone::after {
  content: '';
  position: absolute;
  bottom: -30%; right: -15%;
  width: 480px; height: 480px;
  background: radial-gradient(circle, rgba(99,102,241,.12) 0%, transparent 70%);
  border-radius: 50%;
}
.<?php echo $uid; ?> .dal04-inner {
  position: relative;
  z-index: 1;
  max-width: 740px;
  margin: 0 auto;
  padding: 0 24px;
}
.<?php echo $uid; ?> .dal04-h2 {
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: clamp(28px, 4vw, 46px);
  font-weight: 800;
  line-height: 1.15;
  letter-spacing: -.02em;
  color: #fff;
  margin: 0 0 24px;
}
.<?php echo $uid; ?> .dal04-p {
  font-size: 17px;
  color: rgba(255,255,255,.78);
  line-height: 1.78;
  margin: 0 0 18px;
}
.<?php echo $uid; ?> .dal04-tag {
  display: inline-block;
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: 18px;
  font-weight: 700;
  color: <?php echo $o400; ?>;
  margin-top: 14px;
}
@media (max-width: 600px) {
  .<?php echo $uid; ?>.dal04-zone { padding: 64px 0; }
  .<?php echo $uid; ?> .dal04-p { font-size: 15px; }
}
</style>

<section class="<?php echo $uid; ?> dal04-zone">
  <div class="dal04-inner">
    <?php if ( ! empty( $s['headline'] ) ) : ?>
      <h2 class="dal04-h2"><?php echo esc_html( $s['headline'] ); ?></h2>
    <?php endif; ?>
    <?php foreach ( (array) $s['paragraphs'] as $p ) :
      if ( empty( $p['text'] ) ) continue; ?>
      <p class="dal04-p"><?php echo wp_kses_post( $p['text'] ); ?></p>
    <?php endforeach; ?>
    <?php if ( ! empty( $s['tagline'] ) ) : ?>
      <span class="dal04-tag"><?php echo esc_html( $s['tagline'] ); ?></span>
    <?php endif; ?>
  </div>
</section>
        <?php
    }
}
