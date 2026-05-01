<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 13 — CTA Band
 * Reusable call-to-action band with heading, body, and two buttons.
 * Used at the bottom of About, Shipping, and FAQ pages before the newsletter.
 */
class Widget_CTA_Band extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_13_cta_band'; }
    public function get_title()      { return '13 — CTA Band'; }
    public function get_icon()       { return 'eicon-call-to-action'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'cta', 'call to action', 'band', 'buttons', 'pp-uk' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => 'Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Ready to start your research?',
        ] );

        $this->add_control( 'body', [
            'label'   => 'Body',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Browse our full catalogue of independently verified compounds.',
        ] );

        $this->add_control( 'btn1_text', [
            'label'   => 'Primary Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Browse Products',
        ] );

        $this->add_control( 'btn1_url', [
            'label'   => 'Primary Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/shop/' ],
        ] );

        $this->add_control( 'btn2_text', [
            'label'   => 'Secondary Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '',
        ] );

        $this->add_control( 'btn2_url', [
            'label'   => 'Secondary Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $u1  = ! empty( $s['btn1_url']['url'] ) ? esc_url( $s['btn1_url']['url'] ) : '#';
        $t1  = ! empty( $s['btn1_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
        $u2  = ! empty( $s['btn2_url']['url'] ) ? esc_url( $s['btn2_url']['url'] ) : '';
        $t2  = ! empty( $s['btn2_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
        ?>
<style>
  .pp-cta{background:var(--pp-surface);border-top:1px solid var(--pp-border)}
  .pp-cta-inner{display:flex;align-items:center;justify-content:space-between;gap:var(--pp-sp-32);flex-wrap:wrap}
  .pp-cta-text h2{font-size:clamp(22px,3vw,32px)}
  .pp-cta-text p{color:var(--pp-ink-2);margin-top:var(--pp-sp-8)}
  .pp-cta-actions{display:flex;gap:var(--pp-sp-12);flex-shrink:0;flex-wrap:wrap}
  @media(max-width:768px){.pp-cta-inner{flex-direction:column;align-items:flex-start}}
</style>
<section class="pp-section pp-cta pp-pad">
  <div class="pp-container">
    <div class="pp-cta-inner pp-reveal">
      <div class="pp-cta-text">
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
        <?php if ( $s['body'] ) : ?>
        <p><?php echo esc_html( $s['body'] ); ?></p>
        <?php endif; ?>
      </div>
      <div class="pp-cta-actions">
        <?php if ( $s['btn1_text'] ) : ?>
        <a href="<?php echo $u1; ?>"<?php echo $t1; ?> class="pp-btn pp-btn-primary"><?php echo esc_html( $s['btn1_text'] ); ?></a>
        <?php endif; ?>
        <?php if ( $s['btn2_text'] && $u2 ) : ?>
        <a href="<?php echo $u2; ?>"<?php echo $t2; ?> class="pp-btn pp-btn-secondary"><?php echo esc_html( $s['btn2_text'] ); ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
        <?php
    }
}
