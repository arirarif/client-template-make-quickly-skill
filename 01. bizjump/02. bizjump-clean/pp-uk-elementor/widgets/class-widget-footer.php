<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Footer extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_10_footer'; }
    public function get_title()      { return '10 — Footer'; }
    public function get_icon()       { return 'eicon-footer'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'footer', 'links', 'legal', 'pp-uk' ]; }

    protected function register_controls() {
        /* Brand */
        $this->start_controls_section( 'section_brand', [
            'label' => 'Brand',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'brand_name', [
            'label'   => 'Brand Name',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Performance Peptide UK',
        ] );
        $this->add_control( 'brand_desc', [
            'label'   => 'Brand Description',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Research-grade peptides supplied from the United Kingdom. Independently tested. For research purposes only.',
            'rows'    => 3,
        ] );
        $this->add_control( 'compliance_note', [
            'label'   => 'Footer Legal Note',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'For Research Purposes Only · Not For Human Consumption',
            'rows'    => 2,
        ] );
        $this->end_controls_section();

        /* Shop links */
        $this->start_controls_section( 'section_shop', [
            'label' => 'Shop Links',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'shop_col_heading', [
            'label'   => 'Column Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Shop',
        ] );
        $rep_shop = new \Elementor\Repeater();
        $rep_shop->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Link' ] );
        $rep_shop->add_control( 'url',   [ 'label' => 'URL',   'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '#' ] ] );
        $this->add_control( 'shop_links', [
            'label'       => 'Links',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep_shop->get_controls(),
            'default'     => [
                [ 'label' => 'All Products',        'url' => [ 'url' => '/shop/' ] ],
                [ 'label' => 'Repair & Recovery',   'url' => [ 'url' => '/shop/repair-recovery/' ] ],
                [ 'label' => 'Cognitive',           'url' => [ 'url' => '/shop/cognitive/' ] ],
                [ 'label' => 'Growth & Metabolic',  'url' => [ 'url' => '/shop/growth-metabolic/' ] ],
                [ 'label' => 'Cardioprotective',    'url' => [ 'url' => '/shop/cardioprotective/' ] ],
            ],
            'title_field' => '{{{ label }}}',
        ] );
        $this->end_controls_section();

        /* Company links */
        $this->start_controls_section( 'section_company', [
            'label' => 'Company Links',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'company_col_heading', [
            'label'   => 'Column Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Company',
        ] );
        $rep_co = new \Elementor\Repeater();
        $rep_co->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Link' ] );
        $rep_co->add_control( 'url',   [ 'label' => 'URL',   'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '#' ] ] );
        $this->add_control( 'company_links', [
            'label'       => 'Links',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep_co->get_controls(),
            'default'     => [
                [ 'label' => 'About',         'url' => [ 'url' => '/about/' ] ],
                [ 'label' => 'Quality Assurance', 'url' => [ 'url' => '/quality/' ] ],
                [ 'label' => 'Blog',          'url' => [ 'url' => '/blog/' ] ],
                [ 'label' => 'Contact',       'url' => [ 'url' => '/contact/' ] ],
            ],
            'title_field' => '{{{ label }}}',
        ] );
        $this->end_controls_section();

        /* Legal links */
        $this->start_controls_section( 'section_legal', [
            'label' => 'Legal Links',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'legal_col_heading', [
            'label'   => 'Column Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Legal',
        ] );
        $rep_lg = new \Elementor\Repeater();
        $rep_lg->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Link' ] );
        $rep_lg->add_control( 'url',   [ 'label' => 'URL',   'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '#' ] ] );
        $this->add_control( 'legal_links', [
            'label'       => 'Links',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep_lg->get_controls(),
            'default'     => [
                [ 'label' => 'Terms & Conditions',  'url' => [ 'url' => '/terms/' ] ],
                [ 'label' => 'Privacy Policy',      'url' => [ 'url' => '/privacy/' ] ],
                [ 'label' => 'Cookie Policy',       'url' => [ 'url' => '/cookies/' ] ],
                [ 'label' => 'Research Disclaimer', 'url' => [ 'url' => '/disclaimer/' ] ],
            ],
            'title_field' => '{{{ label }}}',
        ] );
        $this->end_controls_section();

        /* Bottom bar */
        $this->start_controls_section( 'section_bottom', [
            'label' => 'Bottom Bar',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'copyright', [
            'label'   => 'Copyright',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '© 2026 Performance Peptide UK Ltd · Registered in England',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $cols = [
            [ 'heading' => $s['shop_col_heading'],    'links' => $s['shop_links'] ],
            [ 'heading' => $s['company_col_heading'], 'links' => $s['company_links'] ],
            [ 'heading' => $s['legal_col_heading'],   'links' => $s['legal_links'] ],
        ];
        ?>
<style>
  .pp-footer{background:var(--pp-bg);border-top:1px solid var(--pp-border)}
  .pp-footer-top{display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:var(--pp-sp-48);padding-bottom:var(--pp-sp-48)}
  .pp-footer-brand-name{display:flex;align-items:center;gap:var(--pp-sp-8);margin-bottom:var(--pp-sp-16)}
  .pp-footer-brand-mark{width:24px;height:24px;border-radius:50%;background:var(--pp-ink);position:relative;flex-shrink:0}
  .pp-footer-brand-mark::after{content:'';position:absolute;inset:6px;border-radius:50%;background:var(--pp-bg)}
  .pp-footer-brand-mark::before{content:'';position:absolute;inset:10px;border-radius:50%;background:var(--pp-ink)}
  .pp-footer-brand-label{font-weight:600;font-size:15px;letter-spacing:-.01em;color:var(--pp-ink)}
  .pp-footer-brand-desc{font-size:14px;color:var(--pp-ink-3);max-width:320px;line-height:1.6;margin:0}
  .pp-footer-col h4{font-family:var(--pp-f-mono);font-size:11px;font-weight:500;letter-spacing:.12em;text-transform:uppercase;color:var(--pp-ink-3);margin-bottom:var(--pp-sp-16)}
  .pp-footer-col ul{display:flex;flex-direction:column}
  .pp-footer-col li{padding:4px 0}
  .pp-footer-col li a{font-size:14px;color:var(--pp-ink-2);text-decoration:none;transition:color 150ms var(--pp-ease)}
  .pp-footer-col li a:hover{color:var(--pp-ink)}
  .pp-footer-bottom{padding-top:var(--pp-sp-24);border-top:1px solid var(--pp-border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:var(--pp-sp-16);font-size:12px;color:var(--pp-ink-3)}
  .pp-footer-legal{font-family:var(--pp-f-mono);letter-spacing:.05em;text-transform:uppercase;font-size:11px}
  @media(max-width:900px){.pp-footer-top{grid-template-columns:1fr 1fr;gap:var(--pp-sp-32);padding-bottom:var(--pp-sp-32)}}
  @media(max-width:768px){.pp-footer-bottom{flex-direction:column;align-items:flex-start;gap:var(--pp-sp-8)}}
  @media(max-width:480px){.pp-footer-top{grid-template-columns:1fr}}
  @media(max-width:560px){.pp-footer-col li a{font-size:13px}.pp-footer-bottom{font-size:11px}.pp-footer-legal{font-size:10px}}
</style>
<footer class="pp-section pp-footer" style="padding-top:var(--pp-sp-64);padding-bottom:var(--pp-sp-32)" role="contentinfo">
  <div class="pp-container">
    <div class="pp-footer-top">
      <div class="pp-footer-brand">
        <div class="pp-footer-brand-name">
          <span class="pp-footer-brand-mark" aria-hidden="true"></span>
          <span class="pp-footer-brand-label"><?php echo esc_html( $s['brand_name'] ); ?></span>
        </div>
        <p class="pp-footer-brand-desc"><?php echo esc_html( $s['brand_desc'] ); ?></p>
      </div>
      <?php foreach ( $cols as $col ) : ?>
      <div class="pp-footer-col">
        <h4><?php echo esc_html( $col['heading'] ); ?></h4>
        <ul>
          <?php foreach ( $col['links'] as $link ) :
            $url = ! empty( $link['url']['url'] ) ? esc_url( $link['url']['url'] ) : '#';
            $tgt = ! empty( $link['url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
          ?>
          <li><a href="<?php echo $url; ?>"<?php echo $tgt; ?>><?php echo esc_html( $link['label'] ); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="pp-footer-bottom">
      <div><?php echo esc_html( $s['copyright'] ); ?></div>
      <div class="pp-footer-legal"><?php echo esc_html( $s['compliance_note'] ); ?></div>
    </div>
  </div>
</footer>
        <?php
    }
}
