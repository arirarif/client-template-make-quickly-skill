<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-08 — CTA Banner (Formation Landing)
 * Deeper orange gradient (700→500→400). Smaller white button. Slightly tighter layout than DLW-08.
 */
class Widget_FLW_CTA_Banner extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_08_cta'; }
    public function get_title()      { return 'FLW 08 — CTA Banner'; }
    public function get_icon()       { return 'eicon-call-to-action'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'cta', 'banner', 'bizjump', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_text', [
            'label' => 'Banner', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'title_text', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Ready to Make It Official?' ] );
        $this->add_control( 'sub_text',   [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Choose your entity above and get your business formed today. Less than 10 minutes to start.' ] );
        $this->add_control( 'btn_text',   [ 'label' => 'Button Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Choose My Entity' ] );
        $this->add_control( 'btn_url',    [ 'label' => 'Button URL',  'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '#entities' ] ] );
        $this->add_control( 'note_text',  [ 'label' => 'Fine Print',  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'No hidden fees · 100% satisfaction guarantee · Trusted by 4M+ entrepreneurs' ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['btn_url']['url'] ) ? esc_url( $s['btn_url']['url'] ) : '#';
        $tgt = ! empty( $s['btn_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
<style>
.flw08-banner { background: linear-gradient(135deg, #C2410C 0%, #F97316 55%, #FB923C 100%); padding: 64px 0; text-align: center; position: relative; overflow: hidden; font-family: 'Inter', sans-serif; }
.flw08-banner::before { content: ''; position: absolute; top: -40%; left: -10%; width: 480px; height: 480px; background: rgba(255,255,255,.05); border-radius: 50%; }
.flw08-banner::after  { content: ''; position: absolute; bottom: -30%; right: -5%; width: 380px; height: 380px; background: rgba(255,255,255,.04); border-radius: 50%; }
.flw08-inner { position: relative; z-index: 1; max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.flw08-h2 { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: clamp(22px,3vw,38px); font-weight: 800; color: #fff; line-height: 1.2; letter-spacing: -.02em; margin: 0 0 12px; }
.flw08-p { font-size: 16px; color: rgba(255,255,255,.8); max-width: 440px; margin: 0 auto 28px; line-height: 1.6; }
.flw08-btn { display: inline-flex; align-items: center; gap: 8px; background: #fff; color: #EA580C; font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 700; padding: 14px 36px; border-radius: 10px; border: none; cursor: pointer; box-shadow: 0 4px 20px rgba(0,0,0,.18); transition: all .2s; text-decoration: none; }
.flw08-btn:hover { background: #FFF7ED; box-shadow: 0 8px 32px rgba(0,0,0,.22); transform: translateY(-2px); color: #EA580C; }
.flw08-btn svg { transition: transform .2s; }
.flw08-btn:hover svg { transform: translateX(3px); }
.flw08-note { margin-top: 14px; font-size: 12px; color: rgba(255,255,255,.55); }

@media (max-width: 600px) {
  .flw08-banner { padding: 52px 0; }
  .flw08-p { font-size: 14.5px; }
  .flw08-btn { padding: 12px 26px; font-size: 14.5px; }
  .flw08-note { font-size: 11.5px; }
}
</style>

<section class="flw08-banner">
  <div class="flw08-inner">
    <h2 class="flw08-h2"><?php echo esc_html( $s['title_text'] ); ?></h2>
    <p class="flw08-p"><?php echo esc_html( $s['sub_text'] ); ?></p>
    <a href="<?php echo $url; ?>"<?php echo $tgt; ?> class="flw08-btn">
      <?php echo esc_html( $s['btn_text'] ); ?>
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
    </a>
    <p class="flw08-note"><?php echo esc_html( $s['note_text'] ); ?></p>
  </div>
</section>
        <?php
    }
}
