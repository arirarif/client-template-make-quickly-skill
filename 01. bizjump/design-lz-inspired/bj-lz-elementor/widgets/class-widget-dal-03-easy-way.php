<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DAL-03 — Easy Way to Incorporate (Doc-Aligned Landing)
 * Source: 03. bizjump-doc-aligned/formation-landing.html — .incorp-wrap
 * Centered text block: orange pricetag pill + section title + paragraphs
 * with strong-tag emphasis. Allowed inline tags in paragraphs: <strong>, <b>, <em>, <a>.
 */
class Widget_DAL_Easy_Way extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dal_03_easy_way'; }
    public function get_title()      { return 'DAL 03 — Easy Way to Incorporate'; }
    public function get_icon()       { return 'eicon-text-area'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'incorporate', 'text', 'paragraph', 'price', 'bizjump', 'dal' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_main', [
            'label' => 'Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'show_pricetag', [
            'label'        => 'Show Pricetag Pill',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );
        $this->add_control( 'pricetag', [
            'label'   => 'Pricetag Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Starting at $99 + state fees',
            'condition' => [ 'show_pricetag' => 'yes' ],
        ] );
        $this->add_control( 'headline', [
            'label'   => 'Headline',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'The easy way to incorporate your business in any 50 state',
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'text', [
            'label' => 'Paragraph (HTML allowed: strong, b, em, a)',
            'type'  => \Elementor\Controls_Manager::TEXTAREA,
            'rows'  => 4,
        ] );
        $this->add_control( 'paragraphs', [
            'label'   => 'Paragraphs',
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $rep->get_controls(),
            'default' => [
                [ 'text' => 'Starting at <strong>$99 plus state fees</strong> (paid directly to the state), BizJump makes starting your business fast, simple, and stress-free. No confusing steps. No unnecessary extras—just a clear path to getting up and running.' ],
                [ 'text' => 'You only pay for what you need. <strong>No hidden fees. No surprise add-ons. No upselling.</strong>' ],
                [ 'text' => 'From day one, your dedicated BizJump specialist handles everything—from name search and filings to securing your EIN—so you can focus on building your business.' ],
                [ 'text' => 'And we don\'t stop there. As you grow, we support you with <strong>business banking, digital launch tools, access to funding, and tax guidance</strong>—all with ongoing priority support.' ],
                [ 'text' => 'Start your business the right way—with a partner that keeps it simple, affordable, and built for your success.' ],
            ],
            'title_field' => '{{{ text.substring(0, 60) }}}…',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_style', [
            'label' => 'Style',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'bg_color', [
            'label'   => 'Section Background',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
        ] );
        $this->add_control( 'orange_500', [
            'label'   => 'Orange 500',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#F97316',
        ] );
        $this->add_control( 'orange_700', [
            'label'   => 'Orange 700 (pricetag text)',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#C2410C',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $bg   = esc_attr( $s['bg_color']   ?: '#ffffff' );
        $o500 = esc_attr( $s['orange_500'] ?: '#F97316' );
        $o700 = esc_attr( $s['orange_700'] ?: '#C2410C' );
        $uid  = 'dal03_' . $this->get_id();
        ?>
<style>
.<?php echo $uid; ?>.dal03-section {
  background: <?php echo $bg; ?>;
  padding: 80px 0;
  font-family: 'Inter', sans-serif;
}
.<?php echo $uid; ?> .dal03-inner {
  max-width: 780px;
  margin: 0 auto;
  padding: 0 24px;
  text-align: center;
}
.<?php echo $uid; ?> .dal03-pricetag {
  display: inline-block;
  background: #FFF7ED;
  color: <?php echo $o700; ?>;
  padding: 6px 16px;
  border-radius: 999px;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: .02em;
  border: 1px solid #FFEDD5;
  margin-bottom: 18px;
}
.<?php echo $uid; ?> .dal03-eyebrow {
  display: inline-block;
  font-size: 11px; font-weight: 700;
  letter-spacing: .1em; text-transform: uppercase;
  color: <?php echo $o500; ?>; margin-bottom: 12px;
}
.<?php echo $uid; ?> .dal03-h2 {
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: clamp(26px, 3.4vw, 40px);
  font-weight: 800; line-height: 1.18;
  letter-spacing: -.02em;
  color: #0F172A;
  margin: 0 0 18px;
}
.<?php echo $uid; ?> .dal03-p {
  font-size: 16px;
  color: #475569;
  line-height: 1.78;
  margin: 0 0 18px;
}
.<?php echo $uid; ?> .dal03-p:last-child { margin-bottom: 0; }
.<?php echo $uid; ?> .dal03-p strong { color: #0F172A; font-weight: 700; }
.<?php echo $uid; ?> .dal03-p a { color: <?php echo $o500; ?>; }

@media (max-width: 600px) {
  .<?php echo $uid; ?>.dal03-section { padding: 56px 0; }
  .<?php echo $uid; ?> .dal03-p { font-size: 15px; }
}
</style>

<section class="<?php echo $uid; ?> dal03-section">
  <div class="dal03-inner">
    <?php if ( 'yes' === ( $s['show_pricetag'] ?? 'yes' ) && ! empty( $s['pricetag'] ) ) : ?>
      <span class="dal03-pricetag"><?php echo esc_html( $s['pricetag'] ); ?></span>
    <?php endif; ?>
    <?php if ( ! empty( $s['headline'] ) ) : ?>
      <h2 class="dal03-h2"><?php echo esc_html( $s['headline'] ); ?></h2>
    <?php endif; ?>
    <?php foreach ( (array) $s['paragraphs'] as $p ) :
      if ( empty( $p['text'] ) ) continue; ?>
      <p class="dal03-p"><?php echo wp_kses_post( $p['text'] ); ?></p>
    <?php endforeach; ?>
  </div>
</section>
        <?php
    }
}
