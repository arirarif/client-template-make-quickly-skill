<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 11 — CTA Banner
 * Full-width dark navy gradient section with orange headline, subtitle, and dual CTA buttons.
 */
class Widget_CTA_Banner extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_11_cta'; }
    public function get_title()      { return '11 — CTA Banner'; }
    public function get_icon()       { return 'eicon-call-to-action'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'cta', 'banner', 'call to action', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => 'CTA Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'section_label', [
            'label'   => 'Eyebrow Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Ready to Launch?',
        ] );

        $this->add_control( 'headline', [
            'label'   => 'Headline',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "Your Business Starts\nin Minutes, Not Weeks",
            'rows'    => 2,
        ] );

        $this->add_control( 'headline_highlight', [
            'label'       => 'Word to highlight in orange',
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => 'Minutes',
            'description' => 'Exactly as it appears in the headline above (case-sensitive).',
        ] );

        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "Join 3,000+ entrepreneurs who chose the smarter way to incorporate.\nFlat-rate pricing. All 50 states. No surprises.",
            'rows'    => 3,
        ] );

        $this->add_control( 'btn1_text', [
            'label'   => 'Primary Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Start Your LLC For Free →',
        ] );

        $this->add_control( 'btn1_url', [
            'label'   => 'Primary Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/incorporate/' ],
        ] );

        $this->add_control( 'btn2_text', [
            'label'   => 'Outline Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Compare Plans',
        ] );

        $this->add_control( 'btn2_url', [
            'label'   => 'Outline Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#pricing' ],
        ] );

        $this->end_controls_section();

        /* ── Trust micro-row ── */
        $this->start_controls_section( 'section_trust', [
            'label' => 'Trust Items',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'trust_text', [
            'label'   => 'Trust Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'No hidden fees',
        ] );

        $this->add_control( 'trust_items', [
            'label'       => 'Trust Items',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'trust_text' => 'No hidden fees' ],
                [ 'trust_text' => '100% money-back guarantee' ],
                [ 'trust_text' => 'SSL secured' ],
            ],
            'title_field' => '{{{ trust_text }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $b1u  = ! empty( $s['btn1_url']['url'] ) ? esc_url( $s['btn1_url']['url'] ) : '#';
        $b1t  = ! empty( $s['btn1_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        $b2u  = ! empty( $s['btn2_url']['url'] ) ? esc_url( $s['btn2_url']['url'] ) : '#';
        $b2t  = ! empty( $s['btn2_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';

        /* Build headline with optional highlighted word */
        $headline_raw  = esc_html( $s['headline'] );
        $highlight     = ! empty( $s['headline_highlight'] ) ? esc_html( $s['headline_highlight'] ) : '';
        if ( $highlight ) {
            $headline_html = str_replace(
                $highlight,
                '<span>' . $highlight . '</span>',
                nl2br( $headline_raw )
            );
        } else {
            $headline_html = nl2br( $headline_raw );
        }
        ?>
<style>
.bjw12-cta {
  background: linear-gradient(130deg, #0a0e1a 0%, #0f2156 45%, #1e3a8a 100%);
  padding: 88px 32px;
  text-align: center;
  position: relative;
  overflow: hidden;
  font-family: 'Inter', sans-serif;
}
/* Glow orbs */
.bjw12-orb {
  position: absolute; border-radius: 50%;
  filter: blur(90px); pointer-events: none;
}
.bjw12-orb-1 {
  width: 420px; height: 420px;
  background: rgba(37,99,235,.25);
  top: -100px; left: -60px;
}
.bjw12-orb-2 {
  width: 320px; height: 320px;
  background: rgba(249,115,22,.12);
  bottom: -80px; right: -40px;
}
/* Inner */
.bjw12-inner {
  position: relative; z-index: 1;
  max-width: 680px; margin: 0 auto;
}
.bjw12-label {
  font-size: 12px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: #93c5fd;
  margin-bottom: 16px; display: block;
}
.bjw12-title {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: clamp(30px, 4.5vw, 52px);
  font-weight: 800; color: #fff;
  letter-spacing: -1.2px; line-height: 1.12;
  margin-bottom: 20px;
}
.bjw12-title span { color: #f97316; }
.bjw12-sub {
  font-size: 18px; color: rgba(255,255,255,.7);
  line-height: 1.7; margin-bottom: 44px;
}
/* Buttons */
.bjw12-btns {
  display: flex; gap: 16px;
  justify-content: center; flex-wrap: wrap;
  margin-bottom: 36px;
}
.bjw12-btn-primary {
  background: #f97316; color: #fff;
  padding: 18px 48px; border-radius: 10px;
  font-size: 17px; font-weight: 700;
  text-decoration: none; display: inline-block;
  transition: background .2s, transform .15s, box-shadow .2s;
  box-shadow: 0 4px 24px rgba(249,115,22,.45);
  font-family: 'Inter', sans-serif;
}
.bjw12-btn-primary:hover {
  background: #ea6c00;
  transform: translateY(-2px);
  box-shadow: 0 8px 36px rgba(249,115,22,.55);
  color: #fff;
}
.bjw12-btn-outline {
  background: transparent;
  border: 2px solid rgba(255,255,255,.4);
  color: #fff; padding: 16px 40px;
  border-radius: 10px; font-size: 17px; font-weight: 600;
  text-decoration: none; display: inline-block;
  transition: background .2s, border-color .2s;
  font-family: 'Inter', sans-serif;
}
.bjw12-btn-outline:hover {
  border-color: #fff; background: rgba(255,255,255,.08); color: #fff;
}
/* Trust micro-row */
.bjw12-trust {
  display: flex; gap: 24px;
  justify-content: center; flex-wrap: wrap;
}
.bjw12-trust-item {
  font-size: 13px; color: rgba(255,255,255,.6);
  display: flex; align-items: center; gap: 6px;
}
.bjw12-trust-item span { color: #4ade80; font-weight: 700; }
/* Responsive */
@media (max-width: 640px) {
  .bjw12-cta { padding: 64px 16px; }
  .bjw12-btns { flex-direction: column; align-items: center; gap: 12px; }
  .bjw12-btn-primary, .bjw12-btn-outline {
    width: 100%; max-width: 300px; text-align: center; font-size: 16px;
  }
  .bjw12-trust { gap: 12px; }
  .bjw12-sub { font-size: 16px; }
}
</style>

<div class="bjw12-cta">
  <div class="bjw12-orb bjw12-orb-1"></div>
  <div class="bjw12-orb bjw12-orb-2"></div>
  <div class="bjw12-inner">

    <span class="bjw12-label"><?php echo esc_html( $s['section_label'] ); ?></span>

    <h2 class="bjw12-title"><?php echo $headline_html; ?></h2>

    <p class="bjw12-sub"><?php echo nl2br( esc_html( $s['subtitle'] ) ); ?></p>

    <div class="bjw12-btns">
      <a href="<?php echo $b1u; ?>"<?php echo $b1t; ?> class="bjw12-btn-primary"><?php echo esc_html( $s['btn1_text'] ); ?></a>
      <a href="<?php echo $b2u; ?>"<?php echo $b2t; ?> class="bjw12-btn-outline"><?php echo esc_html( $s['btn2_text'] ); ?></a>
    </div>

    <div class="bjw12-trust">
      <?php foreach ( $s['trust_items'] as $item ) : ?>
      <div class="bjw12-trust-item"><span>✓</span> <?php echo esc_html( $item['trust_text'] ); ?></div>
      <?php endforeach; ?>
    </div>

  </div>
</div>
        <?php
    }
}
