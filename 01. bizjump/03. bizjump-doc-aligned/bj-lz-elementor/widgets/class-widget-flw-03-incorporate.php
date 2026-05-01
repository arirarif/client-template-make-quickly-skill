<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-03 — The Easy Way to Incorporate
 * White section with orange pill price tag, big headline, and 5 paragraphs of body.
 */
class Widget_FLW_Incorporate extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_03_incorporate'; }
    public function get_title()      { return 'FLW 03 — Easy Way to Incorporate'; }
    public function get_icon()       { return 'eicon-text-area'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'incorporate', 'pricing', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_content', [ 'label' => 'Content', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'pricetag', [ 'label' => 'Price Pill', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Starting at $99 + state fees' ] );
        $this->add_control( 'title', [
            'label' => 'Section Title', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'The easy way to incorporate your business in any 50 state',
        ] );
        $this->add_control( 'body', [
            'label' => 'Body (HTML allowed; one <p>…</p> per paragraph)', 'type' => \Elementor\Controls_Manager::WYSIWYG,
            'default' => '<p>Starting at <strong>$99 plus state fees</strong> (paid directly to the state), BizJump makes starting your business fast, simple, and stress-free. No confusing steps. No unnecessary extras—just a clear path to getting up and running.</p>'
                       . '<p>You only pay for what you need. <strong>No hidden fees. No surprise add-ons. No upselling.</strong></p>'
                       . '<p>From day one, your dedicated BizJump specialist handles everything—from name search and filings to securing your EIN—so you can focus on building your business.</p>'
                       . '<p>And we don\'t stop there. As you grow, we support you with <strong>business banking, digital launch tools, access to funding, and tax guidance</strong>—all with ongoing priority support.</p>'
                       . '<p>Start your business the right way—with a partner that keeps it simple, affordable, and built for your success.</p>',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s  = $this->get_settings_for_display();
        $id = 'bjlz-flw03-' . $this->get_id();
        ?>
        <style>
        #<?php echo esc_attr($id); ?>{font-family:'Inter','Plus Jakarta Sans',sans-serif;color:#475569}
        #<?php echo esc_attr($id); ?> .section{padding:80px 0}
        #<?php echo esc_attr($id); ?> .container{max-width:1160px;margin:0 auto;padding:0 24px}
        #<?php echo esc_attr($id); ?> .incorp-wrap{max-width:780px;margin:0 auto;text-align:center}
        #<?php echo esc_attr($id); ?> .incorp-pricetag{display:inline-block;background:#FFF7ED;color:#C2410C;padding:6px 16px;border-radius:999px;font-size:13px;font-weight:700;letter-spacing:.02em;border:1px solid #FFEDD5;margin-bottom:18px}
        #<?php echo esc_attr($id); ?> .section-title{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:clamp(26px,3.4vw,40px);font-weight:800;line-height:1.18;letter-spacing:-.02em;color:#0F172A;margin-bottom:18px}
        #<?php echo esc_attr($id); ?> .incorp-body p{font-size:16px;color:#475569;line-height:1.78;margin-bottom:18px}
        #<?php echo esc_attr($id); ?> .incorp-body p:last-child{margin-bottom:0}
        #<?php echo esc_attr($id); ?> .incorp-body p strong{color:#0F172A;font-weight:700}
        </style>

        <div id="<?php echo esc_attr($id); ?>">
          <section class="section">
            <div class="container">
              <div class="incorp-wrap">
                <span class="incorp-pricetag"><?php echo esc_html( $s['pricetag'] ); ?></span>
                <h2 class="section-title"><?php echo wp_kses_post( $s['title'] ); ?></h2>
                <div class="incorp-body"><?php echo wp_kses_post( $s['body'] ); ?></div>
              </div>
            </div>
          </section>
        </div>
        <?php
    }
}
