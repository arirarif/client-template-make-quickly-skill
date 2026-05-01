<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DLW-02 — Hero (Demo Landing)
 * Full-bg image hero with dark gradient overlay, badge, headline + emphasized word,
 * subtitle, primary + secondary CTAs, fine-print, and 4 trust stat pills.
 */
class Widget_DLW_Hero extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dlw_02_hero'; }
    public function get_title()      { return 'DLW 02 — Hero'; }
    public function get_icon()       { return 'eicon-banner'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'hero', 'banner', 'headline', 'bizjump', 'dlw' ]; }

    protected function register_controls() {

        /* ── Background ── */
        $this->start_controls_section( 'sec_bg', [
            'label' => 'Background Image',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'bg_image', [
            'label'   => 'Background Image',
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920&q=85',
            ],
        ] );
        $this->end_controls_section();

        /* ── Hero Text ── */
        $this->start_controls_section( 'sec_text', [
            'label' => 'Hero Text',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'badge_text', [
            'label'   => 'Badge Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '#1 Business Formation Service · 4M+ Businesses Formed',
        ] );
        $this->add_control( 'headline_pre', [
            'label'   => 'Headline (before emphasis)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Start Your LLC',
        ] );
        $this->add_control( 'headline_emphasis', [
            'label'   => 'Headline Emphasis (orange)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Right Way',
        ] );
        $this->add_control( 'headline_mid', [
            'label'   => 'Headline (between)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'the',
        ] );
        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'BizJump handles all the paperwork so you can focus on building your business. Fast, simple, and trusted by entrepreneurs across all 50 states.',
        ] );
        $this->add_control( 'fine_print', [
            'label'   => 'Fine Print (HTML)',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'State fee not included &nbsp;·&nbsp; <b>100% satisfaction guarantee</b> &nbsp;·&nbsp; No hidden fees',
        ] );
        $this->end_controls_section();

        /* ── Buttons ── */
        $this->start_controls_section( 'sec_buttons', [
            'label' => 'CTA Buttons',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'btn1_text', [
            'label'   => 'Primary Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Form My LLC Now',
        ] );
        $this->add_control( 'btn1_url', [
            'label'   => 'Primary Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/start/' ],
        ] );
        $this->add_control( 'btn2_text', [
            'label'   => 'Secondary Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'See How It Works',
        ] );
        $this->add_control( 'btn2_url', [
            'label'   => 'Secondary Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#how' ],
        ] );
        $this->end_controls_section();

        /* ── Stat Pills ── */
        $this->start_controls_section( 'sec_stats', [
            'label' => 'Trust Stat Pills',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', [
            'label'   => 'Icon',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'shield'  => 'Shield',
                'star'    => 'Star',
                'clock'   => 'Clock',
                'lock'    => 'Lock',
                'check'   => 'Check',
                'users'   => 'Users',
            ],
            'default' => 'shield',
        ] );
        $rep->add_control( 'value', [
            'label'   => 'Big Value',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '4M+',
        ] );
        $rep->add_control( 'label', [
            'label'   => 'Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Businesses formed',
        ] );

        $this->add_control( 'stats', [
            'label'   => 'Stat Pills',
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $rep->get_controls(),
            'default' => [
                [ 'icon' => 'shield', 'value' => '4M+',     'label' => 'Businesses formed' ],
                [ 'icon' => 'star',   'value' => '4.7 / 5', 'label' => 'Customer rating' ],
                [ 'icon' => 'clock',  'value' => '24 hrs',  'label' => 'Expedited filing' ],
                [ 'icon' => 'lock',   'value' => '256-bit', 'label' => 'SSL encrypted' ],
            ],
            'title_field' => '{{{ value }}} — {{{ label }}}',
        ] );

        $this->end_controls_section();
    }

    private function pill_icon( $key ) {
        switch ( $key ) {
            case 'star':  return '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>';
            case 'clock': return '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>';
            case 'lock':  return '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>';
            case 'check': return '<polyline points="20 6 9 17 4 12"/>';
            case 'users': return '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>';
            default:      return '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>';
        }
    }

    protected function render() {
        $s     = $this->get_settings_for_display();
        $bg    = ! empty( $s['bg_image']['url'] ) ? esc_url( $s['bg_image']['url'] ) : '';
        $b1u   = ! empty( $s['btn1_url']['url'] ) ? esc_url( $s['btn1_url']['url'] ) : '#';
        $b1t   = ! empty( $s['btn1_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        $b2u   = ! empty( $s['btn2_url']['url'] ) ? esc_url( $s['btn2_url']['url'] ) : '#';
        $b2t   = ! empty( $s['btn2_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
<style>
.dlw02-hero {
  position: relative;
  min-height: 600px;
  display: flex; align-items: center;
  padding: 100px 0 88px;
  overflow: hidden;
  font-family: 'Inter', sans-serif;
  <?php if ( $bg ) : ?>background-image: url('<?php echo $bg; ?>');<?php endif; ?>
  background-size: cover;
  background-position: center 30%;
}
.dlw02-hero::before {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(108deg, rgba(9,14,26,0.90) 0%, rgba(9,14,26,0.78) 42%, rgba(9,14,26,0.38) 75%, rgba(9,14,26,0.15) 100%);
  z-index: 1;
}
.dlw02-hero::after {
  content: ''; position: absolute;
  bottom: 0; left: 0; right: 0; height: 120px;
  background: linear-gradient(to top, rgba(9,14,26,0.35), transparent);
  z-index: 1;
}
.dlw02-inner { position: relative; z-index: 2; max-width: 1160px; margin: 0 auto; padding: 0 24px; width: 100%; }
.dlw02-badge {
  display: inline-flex; align-items: center; gap: 7px;
  background: rgba(249,115,22,0.18); color: #FB923C;
  font-size: 13px; font-weight: 600;
  padding: 6px 16px; border-radius: 999px;
  border: 1px solid rgba(249,115,22,0.32);
  margin-bottom: 24px; backdrop-filter: blur(4px);
}
.dlw02-badge::before {
  content: ''; width: 6px; height: 6px; border-radius: 50%;
  background: #FB923C; box-shadow: 0 0 6px rgba(249,115,22,0.7);
}
.dlw02-h1 {
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  font-size: clamp(36px, 4.5vw, 62px);
  font-weight: 800; line-height: 1.1;
  letter-spacing: -0.025em; color: #fff;
  max-width: 640px; margin: 0 0 20px;
  text-shadow: 0 2px 20px rgba(0,0,0,0.3);
}
.dlw02-h1 em { font-style: normal; color: #FB923C; }
.dlw02-sub {
  font-size: 18px; color: rgba(255,255,255,0.72);
  max-width: 500px; margin: 0 0 38px; line-height: 1.68;
}
.dlw02-cta { display: flex; align-items: center; justify-content: flex-start; gap: 14px; flex-wrap: wrap; }
.dlw02-btn-primary {
  display: inline-flex; align-items: center; gap: 8px;
  background: #F97316; color: #fff;
  font-size: 16px; font-weight: 600;
  padding: 15px 36px; border-radius: 10px;
  border: none; cursor: pointer; text-decoration: none;
  box-shadow: 0 4px 16px rgba(249,115,22,0.35);
  transition: all .2s ease; white-space: nowrap;
  font-family: 'Inter', sans-serif;
}
.dlw02-btn-primary:hover {
  background: #EA580C; color: #fff;
  box-shadow: 0 6px 22px rgba(249,115,22,0.45);
  transform: translateY(-2px);
}
.dlw02-btn-primary svg { transition: transform .2s; }
.dlw02-btn-primary:hover svg { transform: translateX(3px); }
.dlw02-btn-secondary {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,0.10);
  color: rgba(255,255,255,0.90);
  font-size: 16px; font-weight: 600;
  padding: 14px 32px; border-radius: 10px;
  border: 1.5px solid rgba(255,255,255,0.30);
  cursor: pointer; transition: all .2s ease;
  white-space: nowrap; backdrop-filter: blur(4px);
  text-decoration: none; font-family: 'Inter', sans-serif;
}
.dlw02-btn-secondary:hover { background: rgba(255,255,255,0.18); border-color: rgba(255,255,255,0.55); color: #fff; }
.dlw02-note { margin-top: 22px; font-size: 13px; color: rgba(255,255,255,0.38); }
.dlw02-note b { color: rgba(255,255,255,0.60); }
.dlw02-stats { display: flex; align-items: center; gap: 12px; margin-top: 44px; flex-wrap: wrap; }
.dlw02-pill {
  display: flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.14);
  border-radius: 999px; padding: 7px 16px;
  backdrop-filter: blur(8px);
}
.dlw02-pill strong { font-size: 14px; font-weight: 700; color: #fff; }
.dlw02-pill span { font-size: 12px; color: rgba(255,255,255,0.55); }

@media (max-width: 768px) {
  .dlw02-hero { padding: 72px 0 60px; min-height: 520px; }
  .dlw02-h1 { font-size: clamp(30px, 7vw, 44px); }
  .dlw02-sub { font-size: 16px; margin-bottom: 28px; }
  .dlw02-btn-primary, .dlw02-btn-secondary { padding: 13px 26px; font-size: 15px; }
  .dlw02-stats { gap: 8px; margin-top: 32px; }
  .dlw02-pill { padding: 6px 12px; }
  .dlw02-pill strong { font-size: 13px; }
  .dlw02-pill span { font-size: 11px; }
}
@media (max-width: 480px) {
  .dlw02-hero { padding: 60px 0 50px; }
  .dlw02-cta { flex-direction: column; align-items: stretch; gap: 10px; }
  .dlw02-btn-primary, .dlw02-btn-secondary { justify-content: center; width: 100%; }
  .dlw02-note { font-size: 12px; }
}
</style>

<section class="dlw02-hero">
  <div class="dlw02-inner">

    <div class="dlw02-badge"><?php echo esc_html( $s['badge_text'] ); ?></div>

    <h1 class="dlw02-h1">
      <?php echo esc_html( $s['headline_pre'] ); ?><br>
      <?php echo esc_html( $s['headline_mid'] ); ?> <em><?php echo esc_html( $s['headline_emphasis'] ); ?></em>
    </h1>

    <p class="dlw02-sub"><?php echo esc_html( $s['subtitle'] ); ?></p>

    <div class="dlw02-cta">
      <a href="<?php echo $b1u; ?>"<?php echo $b1t; ?> class="dlw02-btn-primary">
        <?php echo esc_html( $s['btn1_text'] ); ?>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
      <a href="<?php echo $b2u; ?>"<?php echo $b2t; ?> class="dlw02-btn-secondary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="10 15 15 12 10 9"/></svg>
        <?php echo esc_html( $s['btn2_text'] ); ?>
      </a>
    </div>

    <p class="dlw02-note"><?php echo wp_kses_post( $s['fine_print'] ); ?></p>

    <div class="dlw02-stats">
      <?php foreach ( (array) $s['stats'] as $stat ) : ?>
      <div class="dlw02-pill">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#F97316"><?php echo $this->pill_icon( $stat['icon'] ); ?></svg>
        <strong><?php echo esc_html( $stat['value'] ); ?></strong>
        <span><?php echo esc_html( $stat['label'] ); ?></span>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
        <?php
    }
}
