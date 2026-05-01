<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DLW-08 — CTA Banner (Demo Landing)
 * Orange gradient banner with H2, paragraph, white button, fine print.
 */
class Widget_DLW_CTA_Banner extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dlw_08_cta'; }
    public function get_title()      { return 'DLW 08 — CTA Banner'; }
    public function get_icon()       { return 'eicon-call-to-action'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'cta', 'banner', 'call to action', 'bizjump', 'dlw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_text', [
            'label' => 'Banner Text', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'title_text', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Ready to Start Your Business?',
        ] );
        $this->add_control( 'sub_text', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Join over 4 million entrepreneurs who\'ve trusted BizJump to form their business. It only takes 10 minutes.',
        ] );
        $this->add_control( 'btn_text', [
            'label'   => 'Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Start My LLC Now',
        ] );
        $this->add_control( 'btn_url', [
            'label'   => 'Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/start/' ],
        ] );
        $this->add_control( 'note_text', [
            'label'   => 'Fine Print',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'No hidden fees · 100% satisfaction guarantee · Trusted by 4M+ entrepreneurs',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $url = ! empty( $s['btn_url']['url'] ) ? esc_url( $s['btn_url']['url'] ) : '#';
        $tgt = ! empty( $s['btn_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
<style>
.dlw08-banner {
  background: linear-gradient(135deg, #EA580C 0%, #F97316 60%, #FB923C 100%);
  padding: 72px 0; text-align: center;
  position: relative; overflow: hidden;
  font-family: 'Inter', sans-serif;
}
.dlw08-banner::before { content: ''; position: absolute; top: -40%; left: -10%; width: 500px; height: 500px; background: rgba(255,255,255,.06); border-radius: 50%; }
.dlw08-banner::after  { content: ''; position: absolute; bottom: -30%; right: -5%; width: 400px; height: 400px; background: rgba(255,255,255,.05); border-radius: 50%; }
.dlw08-inner { position: relative; z-index: 1; max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.dlw08-h2 { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: clamp(26px,3.5vw,42px); font-weight: 800; color: #fff; line-height: 1.2; letter-spacing: -.02em; margin: 0 0 14px; }
.dlw08-p  { font-size: 17px; color: rgba(255,255,255,.82); max-width: 480px; margin: 0 auto 32px; line-height: 1.65; }
.dlw08-btn {
  display: inline-flex; align-items: center; gap: 8px;
  background: #fff; color: #EA580C;
  font-size: 16px; font-weight: 700;
  padding: 15px 38px; border-radius: 10px;
  border: none; cursor: pointer; text-decoration: none;
  box-shadow: 0 4px 20px rgba(0,0,0,.20);
  transition: all .2s; font-family: 'Inter', sans-serif;
}
.dlw08-btn:hover { background: #FFF7ED; box-shadow: 0 8px 32px rgba(0,0,0,.25); transform: translateY(-2px); color: #EA580C; }
.dlw08-btn svg { transition: transform .2s; }
.dlw08-btn:hover svg { transform: translateX(3px); }
.dlw08-note { margin-top: 16px; font-size: 13px; color: rgba(255,255,255,.65); }

@media (max-width: 600px) {
  .dlw08-banner { padding: 56px 0; }
  .dlw08-p { font-size: 15px; margin-bottom: 24px; }
  .dlw08-btn { padding: 13px 28px; font-size: 15px; }
  .dlw08-note { font-size: 12px; }
}
</style>

<section class="dlw08-banner">
  <div class="dlw08-inner">
    <h2 class="dlw08-h2"><?php echo esc_html( $s['title_text'] ); ?></h2>
    <p class="dlw08-p"><?php echo esc_html( $s['sub_text'] ); ?></p>
    <a href="<?php echo $url; ?>"<?php echo $tgt; ?> class="dlw08-btn">
      <?php echo esc_html( $s['btn_text'] ); ?>
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
    </a>
    <p class="dlw08-note"><?php echo esc_html( $s['note_text'] ); ?></p>
  </div>
</section>
        <?php
    }
}
