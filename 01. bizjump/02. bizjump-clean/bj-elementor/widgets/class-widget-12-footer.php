<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 12 — Footer
 * Dark navy 4-column footer: Brand+Contact, Incorporation links, Company links,
 * Newsletter+Trust. Full-width legal bar at bottom.
 */
class Widget_Footer extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_12_footer'; }
    public function get_title()      { return '12 — Footer'; }
    public function get_icon()       { return 'eicon-footer'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'footer', 'links', 'contact', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        /* ── Column 1: Brand ── */
        $this->start_controls_section( 'section_brand', [
            'label' => 'Column 1 — Brand & Contact',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'brand_name', [
            'label'   => 'Brand Name',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'BizJump',
        ] );

        $this->add_control( 'brand_tagline', [
            'label'   => 'Brand Tagline',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Business Formation Experts',
        ] );

        $this->add_control( 'company_desc', [
            'label'   => 'Company Description',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Helping entrepreneurs launch and grow their businesses since 1998. Trusted by 3,000+ companies across all 50 states.',
            'rows'    => 3,
        ] );

        $this->add_control( 'phone', [
            'label'   => 'Phone Number',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '+1 (212) 781-5806',
        ] );

        $this->add_control( 'phone_href', [
            'label'   => 'Phone href (tel:)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'tel:+12127815806',
        ] );

        $this->add_control( 'email', [
            'label'   => 'Email Address',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'info@bizjump.com',
        ] );

        $this->add_control( 'address', [
            'label'   => 'Address / Location',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'United States — All 50 States',
        ] );

        /* Social links */
        $this->add_control( 'social_facebook', [
            'label'   => 'Facebook URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => 'https://facebook.com/bizjump' ],
        ] );

        $this->add_control( 'social_twitter', [
            'label'   => 'Twitter / X URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => 'https://twitter.com/bizjump' ],
        ] );

        $this->add_control( 'social_linkedin', [
            'label'   => 'LinkedIn URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => 'https://linkedin.com/company/bizjump' ],
        ] );

        $this->add_control( 'social_instagram', [
            'label'   => 'Instagram URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => 'https://instagram.com/bizjump' ],
        ] );

        $this->end_controls_section();

        /* ── Column 2 ── */
        $this->start_controls_section( 'section_col2', [
            'label' => 'Column 2 — Incorporation Links',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'col2_title', [
            'label'   => 'Column Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Incorporation',
        ] );

        $rep2 = new \Elementor\Repeater();
        $rep2->add_control( 'link_text', [ 'label' => 'Link Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'LLC Formation' ] );
        $rep2->add_control( 'link_url',  [ 'label' => 'Link URL',  'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '/incorporate/?entity=llc' ] ] );

        $this->add_control( 'col2_links', [
            'label'       => 'Links',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep2->get_controls(),
            'default'     => [
                [ 'link_text' => 'LLC Formation',    'link_url' => [ 'url' => '/incorporate/?entity=llc' ] ],
                [ 'link_text' => 'Corporation',      'link_url' => [ 'url' => '/incorporate/?entity=corporation' ] ],
                [ 'link_text' => 'S-Corporation',    'link_url' => [ 'url' => '/incorporate/?entity=scorp' ] ],
                [ 'link_text' => 'Non-Profit',       'link_url' => [ 'url' => '/incorporate/?entity=nonprofit' ] ],
                [ 'link_text' => 'Registered Agent', 'link_url' => [ 'url' => '/incorporate/?addon=registered-agent' ] ],
                [ 'link_text' => 'EIN / Tax ID',     'link_url' => [ 'url' => '/incorporate/?addon=ein' ] ],
            ],
            'title_field' => '{{{ link_text }}}',
        ] );

        $this->end_controls_section();

        /* ── Column 3 ── */
        $this->start_controls_section( 'section_col3', [
            'label' => 'Column 3 — Company Links',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'col3_title', [
            'label'   => 'Column Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Company',
        ] );

        $rep3 = new \Elementor\Repeater();
        $rep3->add_control( 'link_text', [ 'label' => 'Link Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'About Us' ] );
        $rep3->add_control( 'link_url',  [ 'label' => 'Link URL',  'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '/about/' ] ] );

        $this->add_control( 'col3_links', [
            'label'       => 'Links',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep3->get_controls(),
            'default'     => [
                [ 'link_text' => 'About Us',         'link_url' => [ 'url' => '/about/' ] ],
                [ 'link_text' => 'Contact',          'link_url' => [ 'url' => '/contact/' ] ],
                [ 'link_text' => 'Pricing',          'link_url' => [ 'url' => '/#pricing' ] ],
                [ 'link_text' => 'Privacy Policy',   'link_url' => [ 'url' => '/privacy-policy/' ] ],
                [ 'link_text' => 'Terms of Service', 'link_url' => [ 'url' => '/terms-of-service/' ] ],
                [ 'link_text' => 'Refund Policy',    'link_url' => [ 'url' => '/refund-policy/' ] ],
            ],
            'title_field' => '{{{ link_text }}}',
        ] );

        $this->end_controls_section();

        /* ── Column 4 ── */
        $this->start_controls_section( 'section_col4', [
            'label' => 'Column 4 — Newsletter',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'col4_title', [
            'label'   => 'Column Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Stay Updated',
        ] );

        $this->add_control( 'newsletter_desc', [
            'label'   => 'Newsletter Description',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Business tips, state law updates, and exclusive offers.',
            'rows'    => 2,
        ] );

        $this->add_control( 'newsletter_form_action', [
            'label'       => 'Form Action URL (Mailchimp / FluentCRM)',
            'type'        => \Elementor\Controls_Manager::URL,
            'default'     => [ 'url' => '#' ],
            'description' => 'Replace with your email list form action URL.',
        ] );

        $this->end_controls_section();

        /* ── Legal Bar ── */
        $this->start_controls_section( 'section_legal', [
            'label' => 'Legal Bar',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'copyright_text', [
            'label'   => 'Copyright Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '© ' . date( 'Y' ) . ' BizJump LLC. All rights reserved.',
        ] );

        $this->add_control( 'disclaimer_text', [
            'label'   => 'Legal Disclaimer',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'BizJump is not a law firm and does not provide legal advice.',
            'rows'    => 2,
        ] );

        $rep_legal = new \Elementor\Repeater();
        $rep_legal->add_control( 'link_text', [ 'label' => 'Link Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Privacy Policy' ] );
        $rep_legal->add_control( 'link_url',  [ 'label' => 'Link URL',  'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '/privacy-policy/' ] ] );

        $this->add_control( 'legal_links', [
            'label'       => 'Legal Links',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep_legal->get_controls(),
            'default'     => [
                [ 'link_text' => 'Privacy Policy',   'link_url' => [ 'url' => '/privacy-policy/' ] ],
                [ 'link_text' => 'Terms of Service', 'link_url' => [ 'url' => '/terms-of-service/' ] ],
                [ 'link_text' => 'Refund Policy',    'link_url' => [ 'url' => '/refund-policy/' ] ],
            ],
            'title_field' => '{{{ link_text }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        /* Social URLs */
        $social = [
            'facebook'  => [ 'label' => 'f',  'url' => ! empty( $s['social_facebook']['url'] )  ? esc_url( $s['social_facebook']['url'] )  : '' ],
            'twitter'   => [ 'label' => '𝕏',  'url' => ! empty( $s['social_twitter']['url'] )   ? esc_url( $s['social_twitter']['url'] )   : '' ],
            'linkedin'  => [ 'label' => 'in', 'url' => ! empty( $s['social_linkedin']['url'] )  ? esc_url( $s['social_linkedin']['url'] )  : '' ],
            'instagram' => [ 'label' => '◎',  'url' => ! empty( $s['social_instagram']['url'] ) ? esc_url( $s['social_instagram']['url'] ) : '' ],
        ];

        $form_action = ! empty( $s['newsletter_form_action']['url'] ) ? esc_url( $s['newsletter_form_action']['url'] ) : '#';
        ?>
<style>
.bjw12f-footer {
  background: #0a0e1a;
  font-family: 'Inter', sans-serif;
  color: rgba(255,255,255,.65);
}
/* ── Main footer grid ── */
.bjw12f-main {
  max-width: 1200px;
  margin: 0 auto;
  padding: 64px 32px 48px;
  display: grid;
  grid-template-columns: 1.3fr 1fr 1fr 1.2fr;
  gap: 48px;
}
/* ── Brand column ── */
.bjw12f-brand-name {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 22px; font-weight: 800; color: #fff;
  margin-bottom: 4px; letter-spacing: -0.5px;
}
.bjw12f-brand-name span { color: #f97316; }
.bjw12f-tagline {
  font-size: 11px; letter-spacing: 2px;
  text-transform: uppercase; color: rgba(255,255,255,.4);
  margin-bottom: 16px;
}
.bjw12f-desc {
  font-size: 14px; color: rgba(255,255,255,.6);
  line-height: 1.7; margin-bottom: 20px; max-width: 260px;
}
/* Social icons */
.bjw12f-social {
  display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 24px;
}
.bjw12f-social a {
  width: 36px; height: 36px; border-radius: 8px;
  background: rgba(255,255,255,.08);
  display: flex; align-items: center; justify-content: center;
  color: rgba(255,255,255,.7); text-decoration: none;
  font-size: 15px; font-family: 'Space Grotesk', sans-serif; font-weight: 700;
  transition: background .2s, color .2s;
  flex-shrink: 0;
}
.bjw12f-social a:hover { background: #f97316; color: #fff; }
/* Contact */
.bjw12f-contact { display: flex; flex-direction: column; gap: 10px; }
.bjw12f-contact a,
.bjw12f-contact div {
  display: flex; align-items: flex-start; gap: 10px;
  color: rgba(255,255,255,.65); text-decoration: none;
  font-size: 14px; line-height: 1.5;
  transition: color .2s;
}
.bjw12f-contact a:hover { color: #fff; }
.bjw12f-contact-icon { color: #f97316; font-size: 16px; flex-shrink: 0; margin-top: 1px; }
/* ── Link columns ── */
.bjw12f-col-title {
  font-size: 13px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: #fff;
  margin-bottom: 18px;
}
.bjw12f-col-links {
  list-style: none; margin: 0; padding: 0;
  display: flex; flex-direction: column; gap: 10px;
}
.bjw12f-col-links li a {
  font-size: 14px; color: rgba(255,255,255,.65);
  text-decoration: none; transition: color .2s;
}
.bjw12f-col-links li a:hover { color: #fff; }
/* ── Newsletter column ── */
.bjw12f-nl-desc {
  font-size: 14px; color: rgba(255,255,255,.6);
  margin-bottom: 16px; line-height: 1.5;
}
.bjw12f-nl-form {
  display: flex; flex-direction: column; gap: 8px;
  margin-bottom: 24px;
}
.bjw12f-nl-input {
  width: 100%; padding: 12px 16px;
  border-radius: 8px;
  border: 1.5px solid rgba(255,255,255,.15);
  background: rgba(255,255,255,.07);
  color: #fff; font-size: 14px;
  font-family: 'Inter', sans-serif;
  outline: none; box-sizing: border-box;
  transition: border-color .2s;
}
.bjw12f-nl-input:focus { border-color: #2563eb; }
.bjw12f-nl-input::placeholder { color: rgba(255,255,255,.35); }
.bjw12f-nl-btn {
  padding: 12px;
  background: #f97316; color: #fff;
  border: none; border-radius: 8px;
  font-size: 14px; font-weight: 700;
  cursor: pointer; font-family: 'Inter', sans-serif;
  transition: background .2s;
}
.bjw12f-nl-btn:hover { background: #ea6c00; }
/* Trust mini-badges */
.bjw12f-trust { display: flex; flex-direction: column; gap: 8px; }
.bjw12f-trust-item {
  display: flex; align-items: center; gap: 8px;
  font-size: 13px; color: rgba(255,255,255,.55);
}
.bjw12f-trust-icon { color: #4ade80; font-weight: 700; }
/* ── Legal bar ── */
.bjw12f-legal {
  background: #060912;
  border-top: 1px solid rgba(255,255,255,.07);
  padding: 20px 32px;
}
.bjw12f-legal-inner {
  max-width: 1200px; margin: 0 auto;
  display: flex; align-items: center;
  justify-content: space-between; flex-wrap: wrap; gap: 12px;
}
.bjw12f-copyright {
  font-size: 13px; color: rgba(255,255,255,.4);
}
.bjw12f-legal-links {
  display: flex; gap: 20px; flex-wrap: wrap;
}
.bjw12f-legal-links a {
  font-size: 13px; color: rgba(255,255,255,.45);
  text-decoration: none; transition: color .2s;
}
.bjw12f-legal-links a:hover { color: #fff; }
/* ── Responsive ── */
@media (max-width: 1024px) {
  .bjw12f-main { grid-template-columns: 1fr 1fr; gap: 40px; }
}
@media (max-width: 600px) {
  .bjw12f-main { grid-template-columns: 1fr; padding: 40px 16px 32px; }
  .bjw12f-legal { padding: 16px; }
  .bjw12f-legal-inner { flex-direction: column; align-items: flex-start; gap: 10px; }
}
</style>

<footer class="bjw12f-footer">
  <div class="bjw12f-main">

    <!-- Col 1: Brand + Social + Contact -->
    <div>
      <div class="bjw12f-brand-name">
        <?php
        $brand = esc_html( $s['brand_name'] );
        /* Highlight "Jump" part in orange if brand ends with "Jump" */
        if ( strtolower( substr( $brand, -4 ) ) === 'jump' ) {
            $prefix = substr( $brand, 0, -4 );
            $suffix = substr( $brand, -4 );
            echo esc_html( $prefix ) . '<span>' . esc_html( $suffix ) . '</span>';
        } else {
            echo $brand;
        }
        ?>
      </div>
      <div class="bjw12f-tagline"><?php echo esc_html( $s['brand_tagline'] ); ?></div>
      <p class="bjw12f-desc"><?php echo esc_html( $s['company_desc'] ); ?></p>

      <!-- Social icons -->
      <div class="bjw12f-social">
        <?php foreach ( $social as $key => $item ) :
            if ( empty( $item['url'] ) ) continue;
        ?>
        <a href="<?php echo $item['url']; ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $key ); ?>">
          <?php echo esc_html( $item['label'] ); ?>
        </a>
        <?php endforeach; ?>
      </div>

      <!-- Contact -->
      <div class="bjw12f-contact">
        <?php if ( ! empty( $s['phone'] ) ) : ?>
        <a href="<?php echo esc_attr( $s['phone_href'] ); ?>">
          <span class="bjw12f-contact-icon">📞</span>
          <?php echo esc_html( $s['phone'] ); ?>
        </a>
        <?php endif; ?>
        <?php if ( ! empty( $s['email'] ) ) : ?>
        <a href="mailto:<?php echo esc_attr( antispambot( $s['email'] ) ); ?>">
          <span class="bjw12f-contact-icon">✉</span>
          <?php echo esc_html( antispambot( $s['email'] ) ); ?>
        </a>
        <?php endif; ?>
        <?php if ( ! empty( $s['address'] ) ) : ?>
        <div>
          <span class="bjw12f-contact-icon">📍</span>
          <?php echo esc_html( $s['address'] ); ?>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Col 2: Incorporation Links -->
    <div>
      <div class="bjw12f-col-title"><?php echo esc_html( $s['col2_title'] ); ?></div>
      <ul class="bjw12f-col-links">
        <?php foreach ( $s['col2_links'] as $link ) :
            $lnk = ! empty( $link['link_url']['url'] ) ? esc_url( $link['link_url']['url'] ) : '#';
            $tgt = ! empty( $link['link_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
        <li><a href="<?php echo $lnk; ?>"<?php echo $tgt; ?>><?php echo esc_html( $link['link_text'] ); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Col 3: Company Links -->
    <div>
      <div class="bjw12f-col-title"><?php echo esc_html( $s['col3_title'] ); ?></div>
      <ul class="bjw12f-col-links">
        <?php foreach ( $s['col3_links'] as $link ) :
            $lnk = ! empty( $link['link_url']['url'] ) ? esc_url( $link['link_url']['url'] ) : '#';
            $tgt = ! empty( $link['link_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
        <li><a href="<?php echo $lnk; ?>"<?php echo $tgt; ?>><?php echo esc_html( $link['link_text'] ); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Col 4: Newsletter + Trust -->
    <div>
      <div class="bjw12f-col-title"><?php echo esc_html( $s['col4_title'] ); ?></div>
      <p class="bjw12f-nl-desc"><?php echo esc_html( $s['newsletter_desc'] ); ?></p>
      <form class="bjw12f-nl-form" action="<?php echo $form_action; ?>" method="post">
        <input
          type="email"
          name="email"
          placeholder="Your email address"
          class="bjw12f-nl-input"
          required
          aria-label="Email address for newsletter"
        >
        <button type="submit" class="bjw12f-nl-btn">Subscribe</button>
      </form>

      <!-- Trust badges -->
      <div class="bjw12f-trust">
        <div class="bjw12f-trust-item">
          <span class="bjw12f-trust-icon">✓</span> SSL Secured Checkout
        </div>
        <div class="bjw12f-trust-item">
          <span class="bjw12f-trust-icon">✓</span> 100% Money-Back Guarantee
        </div>
        <div class="bjw12f-trust-item">
          <span class="bjw12f-trust-icon">✓</span> No Hidden Fees, Ever
        </div>
      </div>
    </div>

  </div>

  <!-- Legal Bar -->
  <div class="bjw12f-legal">
    <div class="bjw12f-legal-inner">
      <div class="bjw12f-copyright">
        <?php echo esc_html( $s['copyright_text'] ); ?>
        <?php if ( ! empty( $s['disclaimer_text'] ) ) : ?>
        <?php echo ' ' . esc_html( $s['disclaimer_text'] ); ?>
        <?php endif; ?>
      </div>
      <?php if ( ! empty( $s['legal_links'] ) ) : ?>
      <div class="bjw12f-legal-links">
        <?php foreach ( $s['legal_links'] as $link ) :
            $lnk = ! empty( $link['link_url']['url'] ) ? esc_url( $link['link_url']['url'] ) : '#';
        ?>
        <a href="<?php echo $lnk; ?>"><?php echo esc_html( $link['link_text'] ); ?></a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>

</footer>
        <?php
    }
}
