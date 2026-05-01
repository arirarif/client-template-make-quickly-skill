<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DAL-08 — AI Business Guide (Doc-Aligned Landing)
 * Source: 03. bizjump-doc-aligned/formation-landing.html — .ai-zone
 * Dark gradient bg with glow accent, glass orb icon, headline, subtitle,
 * and a fake AI input pill with placeholder + "Ask" send button.
 * Optional: submit URL to convert the visual mock into a real GET form.
 */
class Widget_DAL_AI_Guide extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dal_08_ai_guide'; }
    public function get_title()      { return 'DAL 08 — AI Business Guide'; }
    public function get_icon()       { return 'eicon-ai'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'ai', 'guide', 'chat', 'input', 'bizjump', 'dal' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_main', [
            'label' => 'Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'headline', [
            'label'   => 'Headline',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Your personal AI Business Guide',
        ] );
        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Get instant answers to your business questions.',
        ] );
        $this->add_control( 'placeholder', [
            'label'   => 'Input Placeholder',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Ask anything about starting your business…',
        ] );
        $this->add_control( 'btn_text', [
            'label'   => 'Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Ask',
        ] );
        $this->add_control( 'submit_url', [
            'label'       => 'Submit URL (optional)',
            'type'        => \Elementor\Controls_Manager::URL,
            'description' => 'If set, input becomes a real GET form posting to this URL with ?q=…',
        ] );
        $this->add_control( 'submit_param', [
            'label'   => 'Query Parameter Name',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'q',
            'description' => 'Used as the ?param=value name when Submit URL is set.',
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
        $this->add_control( 'orange_500', [
            'label'   => 'Orange (button)',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#F97316',
        ] );
        $this->add_control( 'orange_600', [
            'label'   => 'Orange Hover',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#EA580C',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $a    = esc_attr( $s['bg_dark_a']  ?: '#0F172A' );
        $b    = esc_attr( $s['bg_dark_b']  ?: '#1E293B' );
        $o500 = esc_attr( $s['orange_500'] ?: '#F97316' );
        $o600 = esc_attr( $s['orange_600'] ?: '#EA580C' );
        $uid  = 'dal08_' . $this->get_id();
        $url  = ! empty( $s['submit_url']['url'] ) ? esc_url( $s['submit_url']['url'] ) : '';
        $param = preg_replace( '/[^a-zA-Z0-9_]/', '', $s['submit_param'] ?: 'q' );
        $is_form = $url !== '';
        ?>
<style>
.<?php echo $uid; ?>.dal08-zone {
  background: linear-gradient(135deg, <?php echo $a; ?> 0%, <?php echo $b; ?> 100%);
  color: #fff;
  padding: 80px 0;
  text-align: center;
  position: relative;
  overflow: hidden;
  font-family: 'Inter', sans-serif;
}
.<?php echo $uid; ?>.dal08-zone::before {
  content: ''; position: absolute; inset: 0;
  background: radial-gradient(ellipse at top right, rgba(249,115,22,.18) 0%, transparent 60%);
}
.<?php echo $uid; ?> .dal08-inner {
  position: relative; z-index: 1;
  max-width: 680px;
  margin: 0 auto;
  padding: 0 24px;
}
.<?php echo $uid; ?> .dal08-orb {
  width: 80px; height: 80px;
  border-radius: 50%;
  background: rgba(255,255,255,.16);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 24px;
  color: #fff;
  border: 1px solid rgba(255,255,255,.25);
}
.<?php echo $uid; ?> .dal08-h2 {
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: clamp(28px, 3.6vw, 42px);
  font-weight: 800;
  color: #fff;
  letter-spacing: -.02em;
  margin: 0 0 14px;
  line-height: 1.18;
}
.<?php echo $uid; ?> .dal08-sub {
  font-size: 17px;
  color: rgba(255,255,255,.85);
  line-height: 1.6;
  margin: 0 0 30px;
}
.<?php echo $uid; ?> .dal08-input {
  display: flex; align-items: center; gap: 10px;
  background: rgba(255,255,255,.95);
  padding: 8px 8px 8px 22px;
  border-radius: 14px;
  max-width: 520px;
  margin: 0 auto;
  box-shadow: 0 12px 40px rgba(0,0,0,.18);
}
.<?php echo $uid; ?> .dal08-input input {
  flex: 1; border: none; background: transparent;
  outline: none; font-size: 15px; color: #334155;
  padding: 10px 0;
  font-family: 'Inter', sans-serif;
}
.<?php echo $uid; ?> .dal08-input input::placeholder { color: #94A3B8; }
.<?php echo $uid; ?> .dal08-send {
  padding: 11px 22px;
  background: <?php echo $o500; ?>;
  color: #fff;
  font-size: 14px; font-weight: 700;
  border-radius: 10px;
  border: none; cursor: pointer;
  transition: all .2s;
  display: inline-flex; align-items: center; gap: 6px;
  box-shadow: 0 4px 14px rgba(249,115,22,0.28);
  text-decoration: none;
}
.<?php echo $uid; ?> .dal08-send:hover {
  background: <?php echo $o600; ?>;
  color: #fff;
  transform: translateY(-1px);
}
</style>

<section class="<?php echo $uid; ?> dal08-zone">
  <div class="dal08-inner">
    <div class="dal08-orb">
      <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a3 3 0 00-3 3v1H7a3 3 0 00-3 3v9a3 3 0 003 3h10a3 3 0 003-3V9a3 3 0 00-3-3h-2V5a3 3 0 00-3-3z"/><circle cx="9" cy="13" r="1"/><circle cx="15" cy="13" r="1"/><path d="M9 17h6"/></svg>
    </div>
    <?php if ( ! empty( $s['headline'] ) ) : ?>
      <h2 class="dal08-h2"><?php echo esc_html( $s['headline'] ); ?></h2>
    <?php endif; ?>
    <?php if ( ! empty( $s['subtitle'] ) ) : ?>
      <p class="dal08-sub"><?php echo esc_html( $s['subtitle'] ); ?></p>
    <?php endif; ?>

    <?php if ( $is_form ) : ?>
    <form class="dal08-input" action="<?php echo $url; ?>" method="get">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#94A3B8"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
      <input type="text" name="<?php echo esc_attr( $param ); ?>" placeholder="<?php echo esc_attr( $s['placeholder'] ); ?>">
      <button type="submit" class="dal08-send">
        <?php echo esc_html( $s['btn_text'] ); ?>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </button>
    </form>
    <?php else : ?>
    <div class="dal08-input" aria-hidden="true">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#94A3B8"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
      <input type="text" placeholder="<?php echo esc_attr( $s['placeholder'] ); ?>" disabled>
      <button class="dal08-send" type="button">
        <?php echo esc_html( $s['btn_text'] ); ?>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </button>
    </div>
    <?php endif; ?>

  </div>
</section>
        <?php
    }
}
