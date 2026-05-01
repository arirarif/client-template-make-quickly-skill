<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DLW-01 — Navbar (Demo Landing)
 * Sticky white nav with logo, link list, Sign In + Get Started CTAs.
 * Mobile: hamburger toggles dropdown menu.
 */
class Widget_DLW_Navbar extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dlw_01_navbar'; }
    public function get_title()      { return 'DLW 01 — Navbar'; }
    public function get_icon()       { return 'eicon-nav-menu'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'navbar', 'header', 'menu', 'bizjump', 'dlw' ]; }

    protected function register_controls() {

        /* ── Logo ── */
        $this->start_controls_section( 'sec_logo', [
            'label' => 'Logo',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'logo_text_1', [
            'label'   => 'Logo Text Part 1',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Biz',
        ] );
        $this->add_control( 'logo_text_2', [
            'label'   => 'Logo Text Part 2 (orange)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Jump',
        ] );
        $this->add_control( 'logo_url', [
            'label'   => 'Logo Link URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/' ],
        ] );

        $this->end_controls_section();

        /* ── Nav Links ── */
        $this->start_controls_section( 'sec_links', [
            'label' => 'Nav Links',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'label', [
            'label'   => 'Link Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Link',
        ] );
        $rep->add_control( 'url', [
            'label'   => 'Link URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#' ],
        ] );

        $this->add_control( 'links', [
            'label'   => 'Links',
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $rep->get_controls(),
            'default' => [
                [ 'label' => 'Business Formation',  'url' => [ 'url' => '#' ] ],
                [ 'label' => 'LLC vs Corporation',  'url' => [ 'url' => '#' ] ],
                [ 'label' => 'Services',            'url' => [ 'url' => '#' ] ],
                [ 'label' => 'Pricing',             'url' => [ 'url' => '#' ] ],
                [ 'label' => 'Resources',           'url' => [ 'url' => '#' ] ],
            ],
            'title_field' => '{{{ label }}}',
        ] );

        $this->end_controls_section();

        /* ── Buttons ── */
        $this->start_controls_section( 'sec_buttons', [
            'label' => 'Action Buttons',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'btn_login_text', [
            'label'   => 'Sign In Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Sign In',
        ] );
        $this->add_control( 'btn_login_url', [
            'label'   => 'Sign In URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/login/' ],
        ] );

        $this->add_control( 'btn_cta_text', [
            'label'   => 'CTA Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Get Started',
        ] );
        $this->add_control( 'btn_cta_url', [
            'label'   => 'CTA URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/start/' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $logo_url   = ! empty( $s['logo_url']['url'] ) ? esc_url( $s['logo_url']['url'] ) : '#';
        $login_url  = ! empty( $s['btn_login_url']['url'] ) ? esc_url( $s['btn_login_url']['url'] ) : '#';
        $cta_url    = ! empty( $s['btn_cta_url']['url'] ) ? esc_url( $s['btn_cta_url']['url'] ) : '#';
        $widget_id  = 'dlw01_' . $this->get_id();
        ?>
<style>
.dlw01-navbar {
  position: sticky; top: 0; z-index: 100;
  background: #FFFFFF;
  border-bottom: 1px solid #E2E8F0;
  box-shadow: 0 1px 3px rgba(15,23,42,0.06);
  font-family: 'Inter', sans-serif;
}
.dlw01-inner {
  max-width: 1160px; margin: 0 auto; padding: 0 24px;
  display: flex; align-items: center; justify-content: space-between;
  height: 68px;
}
.dlw01-logo {
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  font-size: 22px; font-weight: 800; color: #0F172A;
  display: flex; align-items: center; gap: 8px;
  text-decoration: none;
}
.dlw01-logo span { color: #F97316; }
.dlw01-logo-icon {
  width: 32px; height: 32px;
  background: #F97316; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  color: #fff;
}
.dlw01-links {
  display: flex; align-items: center; gap: 32px;
  list-style: none; margin: 0; padding: 0;
}
.dlw01-links a {
  font-size: 14px; font-weight: 500; color: #475569;
  text-decoration: none; transition: color .15s;
}
.dlw01-links a:hover { color: #0F172A; }
.dlw01-actions { display: flex; align-items: center; gap: 12px; }
.dlw01-btn-login {
  font-size: 14px; font-weight: 600; color: #334155;
  padding: 8px 18px; border-radius: 8px;
  border: 1.5px solid #CBD5E1; background: transparent;
  cursor: pointer; transition: all .15s;
  font-family: 'Inter', sans-serif;
  text-decoration: none;
  display: inline-block;
}
.dlw01-btn-login:hover { background: #F8FAFC; border-color: #94A3B8; }
.dlw01-btn-cta {
  font-size: 14px; font-weight: 600; color: #fff;
  padding: 9px 20px; border-radius: 8px;
  background: #F97316; border: none; cursor: pointer;
  box-shadow: 0 4px 16px rgba(249,115,22,0.35);
  transition: all .2s;
  font-family: 'Inter', sans-serif;
  text-decoration: none;
  display: inline-block;
}
.dlw01-btn-cta:hover {
  background: #EA580C;
  box-shadow: 0 6px 22px rgba(249,115,22,0.45);
  transform: translateY(-1px);
  color: #fff;
}
.dlw01-toggle {
  display: none;
  background: transparent; border: 1.5px solid #E2E8F0;
  border-radius: 8px; padding: 8px;
  cursor: pointer; color: #334155;
  align-items: center; justify-content: center;
}
@media (max-width: 960px) {
  .dlw01-links { gap: 22px; }
  .dlw01-links a { font-size: 13px; }
}
@media (max-width: 768px) {
  .dlw01-inner { height: 60px; padding: 0 16px; }
  .dlw01-toggle { display: flex; }
  .dlw01-links {
    display: none;
    position: absolute; top: 60px; left: 0; right: 0;
    flex-direction: column; align-items: stretch; gap: 0;
    background: #fff; border-top: 1px solid #E2E8F0;
    box-shadow: 0 8px 28px rgba(15,23,42,0.12);
    padding: 8px 0;
  }
  .dlw01-links.dlw01-open { display: flex; }
  .dlw01-links li { width: 100%; }
  .dlw01-links a {
    display: block; padding: 14px 20px;
    border-bottom: 1px solid #F1F5F9;
  }
  .dlw01-actions { gap: 8px; }
  .dlw01-btn-login { padding: 7px 14px; font-size: 13px; }
  .dlw01-btn-cta { padding: 8px 16px; font-size: 13px; }
  .dlw01-logo { font-size: 19px; }
  .dlw01-logo-icon { width: 28px; height: 28px; }
}
@media (max-width: 480px) {
  .dlw01-btn-login { display: none; }
}
</style>

<nav class="dlw01-navbar">
  <div class="dlw01-inner">
    <a class="dlw01-logo" href="<?php echo $logo_url; ?>">
      <span class="dlw01-logo-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      </span>
      <?php echo esc_html( $s['logo_text_1'] ); ?><span><?php echo esc_html( $s['logo_text_2'] ); ?></span>
    </a>

    <ul class="dlw01-links" id="<?php echo esc_attr( $widget_id ); ?>_links">
      <?php foreach ( (array) $s['links'] as $link ) :
          $u = ! empty( $link['url']['url'] ) ? esc_url( $link['url']['url'] ) : '#';
          $t = ! empty( $link['url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
      ?>
      <li><a href="<?php echo $u; ?>"<?php echo $t; ?>><?php echo esc_html( $link['label'] ); ?></a></li>
      <?php endforeach; ?>
    </ul>

    <div class="dlw01-actions">
      <a class="dlw01-btn-login" href="<?php echo $login_url; ?>"><?php echo esc_html( $s['btn_login_text'] ); ?></a>
      <a class="dlw01-btn-cta"   href="<?php echo $cta_url; ?>"><?php echo esc_html( $s['btn_cta_text'] ); ?></a>
      <button class="dlw01-toggle" onclick="document.getElementById('<?php echo esc_js( $widget_id ); ?>_links').classList.toggle('dlw01-open')" aria-label="Menu" type="button">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>
  </div>
</nav>
        <?php
    }
}
