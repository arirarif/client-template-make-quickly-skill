<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-10 — Footer (Formation Landing)
 * Slate-900 BG with brand block + 3 link columns + copyright/legal row.
 */
class Widget_FLW_Footer extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_10_footer'; }
    public function get_title()      { return 'FLW 10 — Footer'; }
    public function get_icon()       { return 'eicon-footer'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'footer', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_brand', [ 'label' => 'Brand', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'logo_part_1', [ 'label' => 'Logo Part 1', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Biz' ] );
        $this->add_control( 'logo_part_2', [ 'label' => 'Logo Part 2 (orange)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Jump' ] );
        $this->add_control( 'tagline', [
            'label' => 'Tagline', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'America\'s trusted business formation service. We make starting a business fast, simple, and affordable.',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_cols', [ 'label' => 'Link Columns', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'heading', [ 'label' => 'Heading', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Services' ] );
        $rep->add_control( 'links', [
            'label' => 'Links (one per line: Label|URL)', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "Form an LLC|#\nForm a Corporation|#\nRegistered Agent|#\nEIN Filing|#",
        ] );
        $this->add_control( 'cols', [
            'label' => 'Columns', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(),
            'default' => [
                [ 'heading' => 'Services',  'links' => "Form an LLC|#\nForm a Corporation|#\nRegistered Agent|#\nEIN Filing|#" ],
                [ 'heading' => 'Resources', 'links' => "Business Name Search|#\nState Requirements|#\nBusiness Guide|/blog/\nFAQ|#" ],
                [ 'heading' => 'Company',   'links' => "About Us|/about-us/\nCustomer Reviews|#\nContact|/contact-us/\nAffiliate Program|#" ],
            ],
            'title_field' => '{{{ heading }}}',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_legal', [ 'label' => 'Legal Row', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'copyright', [ 'label' => 'Copyright', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '© 2026 BizJump Inc. All rights reserved.' ] );
        $this->add_control( 'legal_links', [
            'label' => 'Legal Links (one per line: Label|URL)', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "Privacy Policy|#\nTerms of Service|#\nCookie Policy|#",
        ] );
        $this->end_controls_section();
    }

    private function parse_link_lines( $raw ) {
        $out = [];
        $lines = preg_split( "/\r\n|\r|\n/", (string) $raw );
        foreach ( $lines as $ln ) {
            $ln = trim( $ln );
            if ( $ln === '' ) { continue; }
            $parts = array_map( 'trim', explode( '|', $ln, 2 ) );
            $out[] = [ 'label' => $parts[0] ?? '', 'url' => $parts[1] ?? '#' ];
        }
        return $out;
    }

    protected function render() {
        $s  = $this->get_settings_for_display();
        $id = 'bjlz-flw10-' . $this->get_id();
        ?>
        <style>
        #<?php echo esc_attr($id); ?>{font-family:'Inter','Plus Jakarta Sans',sans-serif}
        #<?php echo esc_attr($id); ?> .footer{background:#0F172A;padding:60px 0 28px}
        #<?php echo esc_attr($id); ?> .container{max-width:1160px;margin:0 auto;padding:0 24px}
        #<?php echo esc_attr($id); ?> .footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:36px;margin-bottom:40px}
        #<?php echo esc_attr($id); ?> .footer-logo{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:20px;font-weight:800;color:#fff;margin-bottom:12px}
        #<?php echo esc_attr($id); ?> .footer-logo em{font-style:normal;color:#F97316}
        #<?php echo esc_attr($id); ?> .footer-brand p{font-size:13px;color:#64748B;line-height:1.65;max-width:240px;margin:0}
        #<?php echo esc_attr($id); ?> .fcol h4{font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748B;margin-bottom:14px}
        #<?php echo esc_attr($id); ?> .fcol ul{list-style:none;display:flex;flex-direction:column;gap:9px;padding:0;margin:0}
        #<?php echo esc_attr($id); ?> .fcol a{font-size:13px;color:#64748B;text-decoration:none;transition:color .15s}
        #<?php echo esc_attr($id); ?> .fcol a:hover{color:#E2E8F0}
        #<?php echo esc_attr($id); ?> .footer-bottom{border-top:1px solid #1E293B;padding-top:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
        #<?php echo esc_attr($id); ?> .footer-copy{font-size:12px;color:#475569}
        #<?php echo esc_attr($id); ?> .footer-legal{display:flex;gap:16px}
        #<?php echo esc_attr($id); ?> .footer-legal a{font-size:12px;color:#475569;text-decoration:none;transition:color .15s}
        #<?php echo esc_attr($id); ?> .footer-legal a:hover{color:#CBD5E1}
        @media (max-width:920px){ #<?php echo esc_attr($id); ?> .footer-grid{grid-template-columns:1fr 1fr} }
        @media (max-width:560px){ #<?php echo esc_attr($id); ?> .footer-grid{grid-template-columns:1fr} }
        </style>

        <div id="<?php echo esc_attr($id); ?>">
          <footer class="footer">
            <div class="container">
              <div class="footer-grid">
                <div class="footer-brand">
                  <div class="footer-logo"><?php echo esc_html( $s['logo_part_1'] ); ?><em><?php echo esc_html( $s['logo_part_2'] ); ?></em></div>
                  <p><?php echo esc_html( $s['tagline'] ); ?></p>
                </div>
                <?php foreach ( (array) ( $s['cols'] ?? [] ) as $col ) :
                    $links = $this->parse_link_lines( $col['links'] ?? '' );
                ?>
                  <div class="fcol">
                    <h4><?php echo esc_html( $col['heading'] ); ?></h4>
                    <ul>
                      <?php foreach ( $links as $lk ) : ?>
                        <li><a href="<?php echo esc_url( $lk['url'] ); ?>"><?php echo esc_html( $lk['label'] ); ?></a></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="footer-bottom">
                <span class="footer-copy"><?php echo esc_html( $s['copyright'] ); ?></span>
                <div class="footer-legal">
                  <?php foreach ( $this->parse_link_lines( $s['legal_links'] ) as $lk ) : ?>
                    <a href="<?php echo esc_url( $lk['url'] ); ?>"><?php echo esc_html( $lk['label'] ); ?></a>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </footer>
        </div>
        <?php
    }
}
