<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 02 — Hero
 * Full-width hero with headline, entity quick-select buttons, help link, and trust badges.
 */
class Widget_Hero extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_02_hero'; }
    public function get_title()      { return '02 — Hero'; }
    public function get_icon()       { return 'eicon-banner'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'hero', 'banner', 'headline', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        /* ── Hero Text ── */
        $this->start_controls_section( 'section_text', [
            'label' => 'Hero Text',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'badge_text', [
            'label'   => 'Badge Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Trusted by 15,000+ Entrepreneurs · Since 1998',
        ] );

        $this->add_control( 'headline_line1', [
            'label'   => 'Headline Line 1',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Jump-start your business',
        ] );

        $this->add_control( 'headline_line2', [
            'label'   => 'Headline Line 2',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'in minutes',
        ] );

        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Choose the structure that best fits your goals.',
        ] );

        $this->end_controls_section();

        /* ── Entity Quick Buttons ── */
        $this->start_controls_section( 'section_entities', [
            'label' => 'Entity Quick-Select Buttons',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', [
            'label'   => 'Icon (emoji)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '🏢',
        ] );
        $rep->add_control( 'label', [
            'label'   => 'Button Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Start my LLC',
        ] );
        $rep->add_control( 'url', [
            'label'   => 'URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/incorporate/?entity=llc' ],
        ] );

        $this->add_control( 'entity_btns', [
            'label'       => 'Entity Buttons',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'icon' => '🏢', 'label' => 'Start my LLC',       'url' => [ 'url' => '/incorporate/?entity=llc' ] ],
                [ 'icon' => '📈', 'label' => 'Start my C-Corp',    'url' => [ 'url' => '/incorporate/?entity=ccorp' ] ],
                [ 'icon' => '💼', 'label' => 'Start my S-Corp',    'url' => [ 'url' => '/incorporate/?entity=scorp' ] ],
                [ 'icon' => '❤️', 'label' => 'Start my Non-Profit','url' => [ 'url' => '/incorporate/?entity=nonprofit' ] ],
            ],
            'title_field' => '{{{ icon }}} {{{ label }}}',
        ] );

        $this->end_controls_section();

        /* ── Help Link ── */
        $this->start_controls_section( 'section_help', [
            'label' => 'Help Link',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'help_text', [
            'label'   => 'Help Link Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Need Help? / Talk to A Representative',
        ] );

        $this->add_control( 'help_url', [
            'label'   => 'Help Link URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/contact/' ],
        ] );

        $this->end_controls_section();

        /* ── Trust Badges ── */
        $this->start_controls_section( 'section_trust', [
            'label' => 'Trust Badges',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep2 = new \Elementor\Repeater();
        $rep2->add_control( 'trust_text', [
            'label'   => 'Badge Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'No Hidden Fees',
        ] );

        $this->add_control( 'trust_badges', [
            'label'       => 'Trust Badges',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep2->get_controls(),
            'default'     => [
                [ 'trust_text' => 'No Hidden Fees' ],
                [ 'trust_text' => 'SSL Secured Checkout' ],
                [ 'trust_text' => '100% Money-Back Guarantee' ],
                [ 'trust_text' => 'All 50 States' ],
            ],
            'title_field' => '{{{ trust_text }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s      = $this->get_settings_for_display();
        $help_u = ! empty( $s['help_url']['url'] ) ? esc_url( $s['help_url']['url'] ) : '#';
        $help_t = ! empty( $s['help_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
<style>
.bjw02-hero {
  background: linear-gradient(155deg, #0f2156 0%, #1e3a8a 55%, #1d4ed8 100%);
  color: #fff;
  padding: 96px 32px 80px;
  text-align: center;
  position: relative;
  overflow: hidden;
  font-family: 'Inter', sans-serif;
}
.bjw02-hero::before {
  content: '';
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
  background-size: 48px 48px;
  pointer-events: none;
}
.bjw02-orb {
  position: absolute; border-radius: 50%;
  filter: blur(80px); pointer-events: none;
}
.bjw02-orb-1 { width: 400px; height: 400px; background: rgba(37,99,235,.35); top: -120px; left: -80px; }
.bjw02-orb-2 { width: 300px; height: 300px; background: rgba(249,115,22,.15); bottom: -60px; right: -40px; }
.bjw02-inner { position: relative; z-index: 1; max-width: 820px; margin: 0 auto; }
.bjw02-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18);
  color: rgba(255,255,255,.9); font-size: 13px; font-weight: 600;
  padding: 7px 18px; border-radius: 100px; margin-bottom: 28px; letter-spacing: .3px;
}
.bjw02-dot {
  width: 7px; height: 7px; border-radius: 50%;
  background: #4ade80; box-shadow: 0 0 6px #4ade80;
  animation: bjw02blink 1.8s ease-in-out infinite;
}
@keyframes bjw02blink { 0%,100%{opacity:1} 50%{opacity:.3} }
.bjw02-h1 {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: clamp(34px, 5.5vw, 62px);
  font-weight: 800; line-height: 1.1;
  letter-spacing: -1.5px; margin-bottom: 18px; color: #fff;
}
.bjw02-h1 span { display: block; }
.bjw02-sub {
  font-size: 18px; color: rgba(255,255,255,.78);
  margin: 0 auto 32px; line-height: 1.75;
}
/* Entity quick-select buttons */
.bjw02-entity-btns {
  display: flex; gap: 12px;
  justify-content: center; flex-wrap: wrap;
  margin-bottom: 18px;
}
.bjw02-entity-btn {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,.1); border: 1.5px solid rgba(255,255,255,.28);
  color: #fff; padding: 13px 24px; border-radius: 8px;
  font-size: 15px; font-weight: 600; text-decoration: none;
  transition: background .2s, border-color .2s, transform .15s;
  font-family: 'Inter', sans-serif;
}
.bjw02-entity-btn:hover {
  background: #f97316; border-color: #f97316;
  color: #fff; transform: translateY(-2px);
}
.bjw02-entity-icon { font-size: 18px; }
.bjw02-help {
  font-size: 14px; color: rgba(255,255,255,.55); margin-bottom: 44px;
}
.bjw02-help a {
  color: rgba(255,255,255,.8); font-weight: 600;
  text-decoration: underline; text-underline-offset: 3px;
  transition: color .2s;
}
.bjw02-help a:hover { color: #fff; }
/* Trust badges */
.bjw02-trust { display: flex; gap: 28px; justify-content: center; flex-wrap: wrap; }
.bjw02-trust-item {
  display: flex; align-items: center; gap: 8px;
  font-size: 13.5px; color: rgba(255,255,255,.72); font-weight: 500;
}
.bjw02-check {
  width: 18px; height: 18px; border-radius: 50%;
  background: rgba(74,222,128,.15); border: 1px solid #4ade80;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; font-size: 10px; color: #4ade80;
}
@media (max-width: 768px) {
  .bjw02-hero { padding: 64px 16px 52px; }
  .bjw02-h1 { font-size: clamp(30px, 8vw, 42px); letter-spacing: -.5px; }
  .bjw02-sub { font-size: 16px; }
  .bjw02-entity-btns { gap: 8px; }
  .bjw02-entity-btn { font-size: 14px; padding: 11px 16px; }
  .bjw02-trust { gap: 12px; }
  .bjw02-orb-1 { width: 200px; height: 200px; top: -60px; left: -60px; }
  .bjw02-orb-2 { width: 150px; height: 150px; }
}
@media (max-width: 480px) {
  .bjw02-trust { flex-direction: column; align-items: center; }
  .bjw02-badge { font-size: 12px; padding: 6px 14px; }
}
</style>

<div class="bjw02-hero">
  <div class="bjw02-orb bjw02-orb-1"></div>
  <div class="bjw02-orb bjw02-orb-2"></div>
  <div class="bjw02-inner">

    <div class="bjw02-badge">
      <span class="bjw02-dot"></span>
      <?php echo esc_html( $s['badge_text'] ); ?>
    </div>

    <h1 class="bjw02-h1">
      <span><?php echo esc_html( $s['headline_line1'] ); ?></span>
      <span><?php echo esc_html( $s['headline_line2'] ); ?></span>
    </h1>

    <p class="bjw02-sub"><?php echo esc_html( $s['subtitle'] ); ?></p>

    <div class="bjw02-entity-btns">
      <?php foreach ( $s['entity_btns'] as $btn ) :
          $u = ! empty( $btn['url']['url'] ) ? esc_url( $btn['url']['url'] ) : '#';
          $t = ! empty( $btn['url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
      ?>
      <a href="<?php echo $u; ?>"<?php echo $t; ?> class="bjw02-entity-btn">
        <span class="bjw02-entity-icon"><?php echo esc_html( $btn['icon'] ); ?></span>
        <?php echo esc_html( $btn['label'] ); ?>
      </a>
      <?php endforeach; ?>
    </div>

    <p class="bjw02-help">
      <a href="<?php echo $help_u; ?>"<?php echo $help_t; ?>><?php echo esc_html( $s['help_text'] ); ?></a>
    </p>

    <div class="bjw02-trust">
      <?php foreach ( $s['trust_badges'] as $badge ) : ?>
      <div class="bjw02-trust-item">
        <div class="bjw02-check">&#10003;</div>
        <?php echo esc_html( $badge['trust_text'] ); ?>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</div>
        <?php
    }
}
