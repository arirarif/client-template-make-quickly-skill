<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-01 — Navbar (Formation Landing)
 * Slightly more compact (64px) navbar with Sign In + My Account buttons.
 */
class Widget_FLW_Navbar extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_01_navbar'; }
    public function get_title()      { return 'FLW 01 — Navbar'; }
    public function get_icon()       { return 'eicon-nav-menu'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'navbar', 'header', 'menu', 'bizjump', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_logo', [
            'label' => 'Logo', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'logo_text_1', [ 'label' => 'Logo Part 1', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Biz' ] );
        $this->add_control( 'logo_text_2', [ 'label' => 'Logo Part 2 (orange)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Jump' ] );
        $this->add_control( 'logo_url',    [ 'label' => 'Logo URL',  'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '/' ] ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_links', [
            'label' => 'Nav Links', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Link' ] );
        $rep->add_control( 'url',   [ 'label' => 'URL',   'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '#' ] ] );
        $this->add_control( 'links', [
            'label' => 'Links', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $rep->get_controls(),
            'default' => [
                [ 'label' => 'Overview',    'url' => [ 'url' => '#' ] ],
                [ 'label' => 'LLC',         'url' => [ 'url' => '#' ] ],
                [ 'label' => 'Corporation', 'url' => [ 'url' => '#' ] ],
                [ 'label' => 'Nonprofit',   'url' => [ 'url' => '#' ] ],
                [ 'label' => 'Pricing',     'url' => [ 'url' => '#' ] ],
            ],
            'title_field' => '{{{ label }}}',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_buttons', [
            'label' => 'Action Buttons', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'btn_login_text', [ 'label' => 'Sign In Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Sign In' ] );
        $this->add_control( 'btn_login_url',  [ 'label' => 'Sign In URL',  'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '/login/' ] ] );
        $this->add_control( 'btn_cta_text',   [ 'label' => 'CTA Text',     'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'My Account' ] );
        $this->add_control( 'btn_cta_url',    [ 'label' => 'CTA URL',      'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '/account/' ] ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $logo_url = ! empty( $s['logo_url']['url'] ) ? esc_url( $s['logo_url']['url'] ) : '#';
        $login_url = ! empty( $s['btn_login_url']['url'] ) ? esc_url( $s['btn_login_url']['url'] ) : '#';
        $cta_url   = ! empty( $s['btn_cta_url']['url'] ) ? esc_url( $s['btn_cta_url']['url'] ) : '#';
        $uid = 'flw01_' . $this->get_id();
        ?>
<style>
.flw01-navbar { position: sticky; top: 0; z-index: 100; background: #FFFFFF; border-bottom: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(15,23,42,.06); font-family: 'Inter', sans-serif; }
.flw01-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: space-between; height: 64px; }
.flw01-logo { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: 22px; font-weight: 800; color: #0F172A; display: flex; align-items: center; gap: 8px; text-decoration: none; }
.flw01-logo em { font-style: normal; color: #F97316; }
.flw01-logo-icon { width: 30px; height: 30px; background: #F97316; border-radius: 7px; display: flex; align-items: center; justify-content: center; color: #fff; }
.flw01-links { display: flex; align-items: center; gap: 28px; list-style: none; margin: 0; padding: 0; }
.flw01-links a { font-size: 14px; font-weight: 500; color: #64748B; text-decoration: none; transition: color .15s; }
.flw01-links a:hover { color: #0F172A; }
.flw01-actions { display: flex; align-items: center; gap: 10px; }
.flw01-btn-signin { font-size: 13px; font-weight: 600; color: #475569; padding: 7px 16px; border-radius: 8px; border: 1.5px solid #E2E8F0; background: transparent; cursor: pointer; transition: all .15s; font-family: 'Inter', sans-serif; text-decoration: none; display: inline-block; }
.flw01-btn-signin:hover { background: #F8FAFC; border-color: #CBD5E1; }
.flw01-btn-cta { font-size: 13px; font-weight: 600; color: #fff; padding: 8px 18px; border-radius: 8px; background: #F97316; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(249,115,22,.32); transition: all .2s; font-family: 'Inter', sans-serif; text-decoration: none; display: inline-block; }
.flw01-btn-cta:hover { background: #EA580C; box-shadow: 0 6px 22px rgba(249,115,22,.44); transform: translateY(-1px); color: #fff; }
.flw01-toggle { display: none; background: transparent; border: 1.5px solid #E2E8F0; border-radius: 8px; padding: 7px; cursor: pointer; color: #475569; align-items: center; justify-content: center; }

@media (max-width: 960px) { .flw01-links { gap: 20px; } .flw01-links a { font-size: 13px; } }
@media (max-width: 768px) {
  .flw01-inner { height: 58px; padding: 0 16px; }
  .flw01-toggle { display: flex; }
  .flw01-links { display: none; position: absolute; top: 58px; left: 0; right: 0; flex-direction: column; align-items: stretch; gap: 0; background: #fff; border-top: 1px solid #E2E8F0; box-shadow: 0 8px 28px rgba(15,23,42,.12); padding: 8px 0; }
  .flw01-links.flw01-open { display: flex; }
  .flw01-links li { width: 100%; }
  .flw01-links a { display: block; padding: 13px 20px; border-bottom: 1px solid #F1F5F9; }
  .flw01-actions { gap: 8px; }
  .flw01-btn-signin { padding: 6px 12px; font-size: 12.5px; }
  .flw01-btn-cta { padding: 7px 14px; font-size: 12.5px; }
  .flw01-logo { font-size: 19px; }
  .flw01-logo-icon { width: 28px; height: 28px; }
}
@media (max-width: 480px) { .flw01-btn-signin { display: none; } }
</style>

<nav class="flw01-navbar">
  <div class="flw01-inner">
    <a class="flw01-logo" href="<?php echo $logo_url; ?>">
      <span class="flw01-logo-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
      <?php echo esc_html( $s['logo_text_1'] ); ?><em><?php echo esc_html( $s['logo_text_2'] ); ?></em>
    </a>
    <ul class="flw01-links" id="<?php echo esc_attr( $uid ); ?>">
      <?php foreach ( (array) $s['links'] as $link ) :
        $u = ! empty( $link['url']['url'] ) ? esc_url( $link['url']['url'] ) : '#';
        $t = ! empty( $link['url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
      ?>
      <li><a href="<?php echo $u; ?>"<?php echo $t; ?>><?php echo esc_html( $link['label'] ); ?></a></li>
      <?php endforeach; ?>
    </ul>
    <div class="flw01-actions">
      <a class="flw01-btn-signin" href="<?php echo $login_url; ?>"><?php echo esc_html( $s['btn_login_text'] ); ?></a>
      <a class="flw01-btn-cta" href="<?php echo $cta_url; ?>"><?php echo esc_html( $s['btn_cta_text'] ); ?></a>
      <button class="flw01-toggle" onclick="document.getElementById('<?php echo esc_js( $uid ); ?>').classList.toggle('flw01-open')" aria-label="Menu" type="button">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
    </div>
  </div>
</nav>
        <?php
    }
}
