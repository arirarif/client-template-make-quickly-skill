<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-08 — AI Business Guide
 * Slate gradient with orange glow, AI orb icon, headline + sub + input mock + CTA.
 */
class Widget_FLW_AI_Guide extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_08_ai_guide'; }
    public function get_title()      { return 'FLW 08 — AI Business Guide'; }
    public function get_icon()       { return 'eicon-ai'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'ai', 'guide', 'flw' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'sec_content', [ 'label' => 'Content', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'headline', [ 'label' => 'Headline', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Your personal AI Business Guide' ] );
        $this->add_control( 'sub',      [ 'label' => 'Sub',      'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Get instant answers to your business questions.' ] );
        $this->add_control( 'placeholder', [ 'label' => 'Input Placeholder', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Ask anything about starting your business…' ] );
        $this->add_control( 'btn_text', [ 'label' => 'Button Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Ask' ] );
        $this->add_control( 'btn_url',  [ 'label' => 'Button URL',  'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '#' ] ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s  = $this->get_settings_for_display();
        $id = 'bjlz-flw08-' . $this->get_id();
        ?>
        <style>
        #<?php echo esc_attr($id); ?>{font-family:'Inter','Plus Jakarta Sans',sans-serif}
        #<?php echo esc_attr($id); ?> .ai-zone{background:linear-gradient(135deg,#0F172A 0%,#1E293B 100%);color:#fff;padding:80px 0;text-align:center;position:relative;overflow:hidden}
        #<?php echo esc_attr($id); ?> .ai-zone::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at top right,rgba(249,115,22,.18) 0%,transparent 60%)}
        #<?php echo esc_attr($id); ?> .ai-inner{position:relative;z-index:1;max-width:680px;margin:0 auto;padding:0 24px}
        #<?php echo esc_attr($id); ?> .ai-orb{width:80px;height:80px;border-radius:50%;background:rgba(255,255,255,.16);backdrop-filter:blur(12px);display:flex;align-items:center;justify-content:center;margin:0 auto 24px;color:#fff;border:1px solid rgba(255,255,255,.25)}
        #<?php echo esc_attr($id); ?> .ai-headline{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:clamp(28px,3.6vw,42px);font-weight:800;color:#fff;letter-spacing:-.02em;margin-bottom:14px;line-height:1.18}
        #<?php echo esc_attr($id); ?> .ai-sub{font-size:17px;color:rgba(255,255,255,.85);line-height:1.6;margin-bottom:30px}
        #<?php echo esc_attr($id); ?> .ai-input-mock{display:flex;align-items:center;gap:10px;background:rgba(255,255,255,.95);padding:8px 8px 8px 22px;border-radius:14px;max-width:520px;margin:0 auto;box-shadow:0 12px 40px rgba(0,0,0,.18)}
        #<?php echo esc_attr($id); ?> .ai-input-mock input{flex:1;border:none;background:transparent;outline:none;font-size:15px;color:#334155;padding:10px 0;font-family:inherit}
        #<?php echo esc_attr($id); ?> .ai-input-mock input::placeholder{color:#94A3B8}
        #<?php echo esc_attr($id); ?> .ai-send{padding:11px 22px;background:#F97316;color:#fff;font-size:14px;font-weight:700;border-radius:10px;border:none;text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 4px 14px rgba(249,115,22,.32);transition:all .2s}
        #<?php echo esc_attr($id); ?> .ai-send:hover{background:#EA580C;transform:translateY(-1px)}
        </style>

        <div id="<?php echo esc_attr($id); ?>">
          <section class="ai-zone">
            <div class="ai-inner">
              <div class="ai-orb">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a3 3 0 00-3 3v1H7a3 3 0 00-3 3v9a3 3 0 003 3h10a3 3 0 003-3V9a3 3 0 00-3-3h-2V5a3 3 0 00-3-3z"/><circle cx="9" cy="13" r="1"/><circle cx="15" cy="13" r="1"/><path d="M9 17h6"/></svg>
              </div>
              <h2 class="ai-headline"><?php echo esc_html( $s['headline'] ); ?></h2>
              <p class="ai-sub"><?php echo esc_html( $s['sub'] ); ?></p>
              <div class="ai-input-mock">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#94A3B8"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                <input type="text" placeholder="<?php echo esc_attr( $s['placeholder'] ); ?>">
                <a class="ai-send" href="<?php echo esc_url( $s['btn_url']['url'] ?? '#' ); ?>">
                  <?php echo esc_html( $s['btn_text'] ); ?>
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
              </div>
            </div>
          </section>
        </div>
        <?php
    }
}
