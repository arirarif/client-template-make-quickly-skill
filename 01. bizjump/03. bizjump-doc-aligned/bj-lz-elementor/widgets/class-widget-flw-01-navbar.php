<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-01 — Navbar (Formation Landing, doc-aligned)
 * Sticky white nav: BizJump logo with house icon + nav links + Sign In + My Account CTA.
 */
class Widget_FLW_Navbar extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_01_navbar'; }
    public function get_title()      { return 'FLW 01 — Navbar'; }
    public function get_icon()       { return 'eicon-nav-menu'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'navbar', 'header', 'menu', 'bizjump', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_brand', [
            'label' => 'Brand', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'logo_part_1', [ 'label' => 'Logo Part 1', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Biz' ] );
        $this->add_control( 'logo_part_2', [ 'label' => 'Logo Part 2 (orange)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Jump' ] );
        $this->add_control( 'logo_url',    [ 'label' => 'Logo URL', 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '/' ] ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_links', [
            'label' => 'Nav Links', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Link' ] );
        $rep->add_control( 'url',   [ 'label' => 'URL',   'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '#' ] ] );
        $rep->add_control( 'active',[ 'label' => 'Active', 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ] );
        $this->add_control( 'links', [
            'label' => 'Links', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $rep->get_controls(),
            'default' => [
                [ 'label' => 'Form a Business', 'url' => [ 'url' => '/form-a-business/' ], 'active' => 'yes' ],
                [ 'label' => 'About',           'url' => [ 'url' => '/about-us/' ],       'active' => '' ],
                [ 'label' => 'Blog',            'url' => [ 'url' => '/blog/' ],           'active' => '' ],
                [ 'label' => 'Contact',         'url' => [ 'url' => '/contact-us/' ],     'active' => '' ],
                [ 'label' => 'Shop',            'url' => [ 'url' => '/shop/' ],           'active' => '' ],
            ],
            'title_field' => '{{{ label }}}',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_actions', [
            'label' => 'Action Buttons', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'signin_text', [ 'label' => 'Sign In Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Sign In' ] );
        $this->add_control( 'signin_url',  [ 'label' => 'Sign In URL',  'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '/my-account/' ] ] );
        $this->add_control( 'cta_text',    [ 'label' => 'CTA Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'My Account' ] );
        $this->add_control( 'cta_url',     [ 'label' => 'CTA URL',  'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '/my-account/' ] ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s  = $this->get_settings_for_display();
        $id = 'bjlz-flw01-' . $this->get_id();
        ?>
        <style>
        #<?php echo esc_attr($id); ?>{font-family:'Inter','Plus Jakarta Sans',sans-serif}
        #<?php echo esc_attr($id); ?> .navbar{position:sticky;top:0;z-index:100;background:#fff;border-bottom:1px solid #E2E8F0;box-shadow:0 1px 3px rgba(15,23,42,.06)}
        #<?php echo esc_attr($id); ?> .navbar-inner{max-width:1160px;margin:0 auto;padding:0 24px;display:flex;align-items:center;justify-content:space-between;height:64px}
        #<?php echo esc_attr($id); ?> .nav-logo{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:22px;font-weight:800;color:#0F172A;display:flex;align-items:center;gap:8px;text-decoration:none}
        #<?php echo esc_attr($id); ?> .nav-logo-icon{width:30px;height:30px;background:#F97316;border-radius:7px;display:flex;align-items:center;justify-content:center;color:#fff}
        #<?php echo esc_attr($id); ?> .nav-logo em{font-style:normal;color:#F97316}
        #<?php echo esc_attr($id); ?> .nav-links{display:flex;align-items:center;gap:28px;list-style:none;margin:0;padding:0}
        #<?php echo esc_attr($id); ?> .nav-links a{font-size:14px;font-weight:500;color:#64748B;text-decoration:none;transition:color .15s}
        #<?php echo esc_attr($id); ?> .nav-links a:hover,#<?php echo esc_attr($id); ?> .nav-links a.is-active{color:#0F172A}
        #<?php echo esc_attr($id); ?> .nav-actions{display:flex;align-items:center;gap:10px}
        #<?php echo esc_attr($id); ?> .btn-signin{font-size:13px;font-weight:600;color:#475569;padding:7px 16px;border-radius:8px;border:1.5px solid #E2E8F0;background:transparent;text-decoration:none;transition:all .15s;font-family:inherit;cursor:pointer}
        #<?php echo esc_attr($id); ?> .btn-signin:hover{background:#F8FAFC;border-color:#CBD5E1}
        #<?php echo esc_attr($id); ?> .btn-nav-primary{font-size:13px;font-weight:600;color:#fff;padding:8px 18px;border-radius:8px;background:#F97316;border:none;text-decoration:none;box-shadow:0 4px 14px rgba(249,115,22,.32);transition:all .2s;font-family:inherit;cursor:pointer}
        #<?php echo esc_attr($id); ?> .btn-nav-primary:hover{background:#EA580C;box-shadow:0 6px 22px rgba(249,115,22,.44);transform:translateY(-1px)}
        @media (max-width:920px){ #<?php echo esc_attr($id); ?> .nav-links{display:none} }
        </style>

        <div id="<?php echo esc_attr($id); ?>">
          <nav class="navbar">
            <div class="navbar-inner">
              <a class="nav-logo" href="<?php echo esc_url( $s['logo_url']['url'] ?? '/' ); ?>">
                <div class="nav-logo-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
                <?php echo esc_html( $s['logo_part_1'] ); ?><em><?php echo esc_html( $s['logo_part_2'] ); ?></em>
              </a>
              <ul class="nav-links">
                <?php foreach ( (array) ( $s['links'] ?? [] ) as $lk ) : $is = ( ($lk['active'] ?? '') === 'yes' ) ? ' is-active' : ''; ?>
                  <li><a class="<?php echo esc_attr( trim( $is ) ); ?>" href="<?php echo esc_url( $lk['url']['url'] ?? '#' ); ?>"><?php echo esc_html( $lk['label'] ); ?></a></li>
                <?php endforeach; ?>
              </ul>
              <div class="nav-actions">
                <a class="btn-signin" href="<?php echo esc_url( $s['signin_url']['url'] ?? '/my-account/' ); ?>"><?php echo esc_html( $s['signin_text'] ); ?></a>
                <a class="btn-nav-primary" href="<?php echo esc_url( $s['cta_url']['url'] ?? '/my-account/' ); ?>"><?php echo esc_html( $s['cta_text'] ); ?></a>
              </div>
            </div>
          </nav>
        </div>
        <?php
    }
}
