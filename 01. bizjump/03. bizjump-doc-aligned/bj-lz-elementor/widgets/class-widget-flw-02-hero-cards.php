<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-02 — Hero + 4 Entity Cards (LegalZoom-style)
 * Cream BG, single big headline "Choose the structure...", 4-card grid, "Need Help?" line.
 */
class Widget_FLW_Hero_Cards extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_02_hero_cards'; }
    public function get_title()      { return 'FLW 02 — Hero + Entity Cards'; }
    public function get_icon()       { return 'eicon-posts-grid'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'hero', 'entity', 'llc', 'corporation', 'cards', 'flw' ]; }

    /* default SVG icons */
    private function default_icons() {
        return [
            'home'  => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
            'corp'  => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/><line x1="2" y1="13" x2="22" y2="13"/></svg>',
            'scorp' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>',
            'np'    => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>',
        ];
    }

    protected function register_controls() {

        $this->start_controls_section( 'sec_head', [ 'label' => 'Headline', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'headline', [
            'label' => 'Headline', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Choose the structure that best fits your goals.',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_cards', [ 'label' => 'Entity Cards', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon_key', [
            'label' => 'Icon', 'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [ 'home' => 'House (LLC)', 'corp' => 'Briefcase (Corp)', 'scorp' => 'Dollar (S-Corp)', 'np' => 'Heart (Nonprofit)' ],
            'default' => 'home',
        ] );
        $rep->add_control( 'name',  [ 'label' => 'Name',     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'LLC' ] );
        $rep->add_control( 'price', [ 'label' => 'Price',    'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Starts at $99 + state filing fees' ] );
        $rep->add_control( 'desc',  [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'The simplest and most flexible business structure.' ] );
        $rep->add_control( 'bullets', [
            'label' => 'Bullet Points (one per line)', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "Personal liability protection\nPass-through taxation\nFlexible management structure\nNo board of directors required",
        ] );
        $rep->add_control( 'btn_text', [ 'label' => 'CTA Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Start my LLC' ] );
        $rep->add_control( 'btn_url',  [ 'label' => 'CTA URL',  'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '/start/?entity=llc' ] ] );

        $this->add_control( 'cards', [
            'label' => 'Cards', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(),
            'default' => [
                [ 'icon_key' => 'home',  'name' => 'LLC',            'price' => 'Starts at $99 + state filing fees', 'desc' => 'The simplest and most flexible business structure. Protect your personal assets without the complexity of a corporation.', 'bullets' => "Personal liability protection\nPass-through taxation\nFlexible management structure\nNo board of directors required", 'btn_text' => 'Start my LLC',         'btn_url' => [ 'url' => '/start/?entity=llc' ] ],
                [ 'icon_key' => 'corp',  'name' => 'Corporation',    'price' => 'Starts at $149 + state filing fees', 'desc' => 'A structured business designed for growth and raising money. Best for companies planning to scale or bring in investors.', 'bullets' => "Strong personal liability protection\nCan raise money by selling shares\nNo limit on number of shareholders\nRequires a board of directors", 'btn_text' => 'Start my C-Corp',      'btn_url' => [ 'url' => '/start/?entity=ccorp' ] ],
                [ 'icon_key' => 'scorp', 'name' => 'S-Corp',         'price' => 'Starts at $149 + state filing fees', 'desc' => 'A tax status that helps avoid double taxation while maintaining a structured business setup. Best for small to mid-sized businesses.', 'bullets' => "Pass-through taxation\nPotential self-employment tax savings\nUp to 100 shareholders\nU.S. citizens / residents only", 'btn_text' => 'Start my S-Corp',      'btn_url' => [ 'url' => '/start/?entity=scorp' ] ],
                [ 'icon_key' => 'np',    'name' => 'Not-for-Profit', 'price' => 'Starts at $99 + state filing fees',  'desc' => 'An organization formed to serve a public or community purpose rather than generate profit for owners.', 'bullets' => "No owners or shareholders\nEligible for tax-exempt status\nCan receive donations and grants\nRequires a board of directors", 'btn_text' => 'Start my Non-profit', 'btn_url' => [ 'url' => '/start/?entity=nonprofit' ] ],
            ],
            'title_field' => '{{{ name }}}',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_help', [ 'label' => 'Help Line', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'help_pre',  [ 'label' => 'Lead Text',  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Need Help?' ] );
        $this->add_control( 'help_link', [ 'label' => 'Link Text',  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Talk to A Representative' ] );
        $this->add_control( 'help_url',  [ 'label' => 'Link URL',   'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '/contact-us/' ] ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s     = $this->get_settings_for_display();
        $id    = 'bjlz-flw02-' . $this->get_id();
        $icons = $this->default_icons();
        ?>
        <style>
        #<?php echo esc_attr($id); ?>{font-family:'Inter','Plus Jakarta Sans',sans-serif;color:#475569}
        #<?php echo esc_attr($id); ?> .hero-zone{background:#F2EDE7;padding:64px 0 72px;text-align:center}
        #<?php echo esc_attr($id); ?> .container{max-width:1160px;margin:0 auto;padding:0 24px}
        #<?php echo esc_attr($id); ?> .hero-headline{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:clamp(26px,4.2vw,46px);font-weight:800;line-height:1.12;letter-spacing:-.025em;color:#0F172A;margin:0 auto 44px;white-space:nowrap}
        #<?php echo esc_attr($id); ?> .entity-card-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;max-width:1040px;margin:0 auto;text-align:left}
        #<?php echo esc_attr($id); ?> .entity-card{background:#fff;border:1px solid rgba(15,23,42,.07);border-radius:18px;padding:22px 20px 20px;box-shadow:0 2px 6px rgba(15,23,42,.08);display:flex;flex-direction:column;max-height:450px;transition:transform .25s,box-shadow .25s,border-color .25s;position:relative;overflow:hidden}
        #<?php echo esc_attr($id); ?> .entity-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:transparent;transition:background .25s}
        #<?php echo esc_attr($id); ?> .entity-card:hover{transform:translateY(-4px);box-shadow:0 8px 28px rgba(15,23,42,.13);border-color:#FED7AA}
        #<?php echo esc_attr($id); ?> .entity-card:hover::before{background:#F97316}
        #<?php echo esc_attr($id); ?> .ec-icon{width:44px;height:44px;border-radius:11px;background:#FFF7ED;color:#EA580C;display:flex;align-items:center;justify-content:center;margin-bottom:12px}
        #<?php echo esc_attr($id); ?> .ec-name{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:19px;font-weight:800;color:#0F172A;letter-spacing:-.01em;margin:0 0 3px;line-height:1.2}
        #<?php echo esc_attr($id); ?> .ec-price{font-size:11.5px;font-weight:600;color:#EA580C;margin:0 0 10px;letter-spacing:.01em}
        #<?php echo esc_attr($id); ?> .ec-desc{font-size:13px;color:#475569;line-height:1.5;margin:0 0 12px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
        #<?php echo esc_attr($id); ?> .ec-bullets{list-style:none;display:flex;flex-direction:column;gap:6px;margin:0 0 16px;padding:0;flex:1}
        #<?php echo esc_attr($id); ?> .ec-bullets li{display:flex;align-items:flex-start;gap:8px;font-size:12.5px;color:#334155;line-height:1.45}
        #<?php echo esc_attr($id); ?> .ec-bullets li::before{content:'';flex-shrink:0;width:15px;height:15px;border-radius:50%;background:#FFF7ED;background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23EA580C' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'><polyline points='20 6 9 17 4 12'/></svg>");background-repeat:no-repeat;background-position:center;background-size:9px;margin-top:2px}
        #<?php echo esc_attr($id); ?> .ec-cta{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:11px 16px;background:#F97316;color:#fff;font-size:13.5px;font-weight:700;border-radius:10px;border:none;text-decoration:none;box-shadow:0 4px 14px rgba(249,115,22,.32);transition:all .2s;letter-spacing:.01em;margin-top:auto;text-align:center}
        #<?php echo esc_attr($id); ?> .ec-cta:hover{background:#EA580C;box-shadow:0 6px 22px rgba(249,115,22,.44);transform:translateY(-1px)}
        #<?php echo esc_attr($id); ?> .help-line{display:flex;align-items:center;justify-content:center;gap:8px;margin-top:36px;font-size:14px;color:#475569}
        #<?php echo esc_attr($id); ?> .help-line a{color:#EA580C;font-weight:600;text-decoration:underline;text-underline-offset:3px}
        #<?php echo esc_attr($id); ?> .help-line svg{color:#F97316;flex-shrink:0}
        @media (max-width:1024px){ #<?php echo esc_attr($id); ?> .entity-card-grid{grid-template-columns:repeat(2,1fr);max-width:720px} }
        @media (max-width:760px){ #<?php echo esc_attr($id); ?> .hero-headline{white-space:normal} }
        @media (max-width:560px){ #<?php echo esc_attr($id); ?> .entity-card-grid{grid-template-columns:1fr;max-width:420px} }
        </style>

        <div id="<?php echo esc_attr($id); ?>">
          <section class="hero-zone">
            <div class="container">
              <h1 class="hero-headline"><?php echo wp_kses_post( $s['headline'] ); ?></h1>
              <div class="entity-card-grid">
                <?php foreach ( (array) ( $s['cards'] ?? [] ) as $c ) :
                    $key   = $c['icon_key'] ?? 'home';
                    $svg   = $icons[ $key ] ?? $icons['home'];
                    $bul   = array_filter( array_map( 'trim', preg_split( "/\r\n|\r|\n/", (string) ( $c['bullets'] ?? '' ) ) ) );
                ?>
                  <article class="entity-card">
                    <div class="ec-icon"><?php echo $svg; // SVG markup, hard-coded ?></div>
                    <h3 class="ec-name"><?php echo esc_html( $c['name'] ); ?></h3>
                    <p class="ec-price"><?php echo esc_html( $c['price'] ); ?></p>
                    <p class="ec-desc"><?php echo esc_html( $c['desc'] ); ?></p>
                    <ul class="ec-bullets">
                      <?php foreach ( $bul as $b ) : ?><li><?php echo esc_html( $b ); ?></li><?php endforeach; ?>
                    </ul>
                    <a href="<?php echo esc_url( $c['btn_url']['url'] ?? '#' ); ?>" class="ec-cta">
                      <?php echo esc_html( $c['btn_text'] ); ?>
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                  </article>
                <?php endforeach; ?>
              </div>
              <p class="help-line">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                <?php echo esc_html( $s['help_pre'] ); ?> <a href="<?php echo esc_url( $s['help_url']['url'] ?? '#' ); ?>"><?php echo esc_html( $s['help_link'] ); ?></a>
              </p>
            </div>
          </section>
        </div>
        <?php
    }
}
