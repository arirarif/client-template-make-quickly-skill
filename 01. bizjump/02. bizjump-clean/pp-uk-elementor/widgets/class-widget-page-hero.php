<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 12 — Page Hero
 * Reusable inner-page header: eyebrow line, H1, subtitle.
 * Used at the top of About, Contact, FAQ, Terms, Privacy, Shipping pages.
 */
class Widget_Page_Hero extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_12_page_hero'; }
    public function get_title()      { return '12 — Page Hero'; }
    public function get_icon()       { return 'eicon-heading'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'hero', 'page', 'header', 'title', 'pp-uk' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => 'Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'page_label', [
            'label'   => 'Page Label (eyebrow)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'About',
        ] );

        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Science-led. Independently verified.',
            'rows'    => 2,
        ] );

        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'UK-based researchers building the standard for peptide quality in the domestic market.',
            'rows'    => 3,
        ] );

        $this->add_control( 'has_border_bottom', [
            'label'        => 'Border Bottom',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => 'Yes',
            'label_off'    => 'No',
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s      = $this->get_settings_for_display();
        $border = ( 'yes' === $s['has_border_bottom'] ) ? ' pp-ph-border' : '';
        ?>
<style>
  .pp-ph{padding:var(--pp-sp-64) 0 var(--pp-sp-96)}
  .pp-ph.pp-ph-border{border-bottom:1px solid var(--pp-border)}
  .pp-ph-meta{font-family:var(--pp-f-mono);font-size:12px;letter-spacing:.12em;text-transform:uppercase;color:var(--pp-ink-3);display:flex;align-items:center;gap:var(--pp-sp-12);margin-bottom:var(--pp-sp-24)}
  .pp-ph-meta::before{content:'';width:32px;height:1px;background:var(--pp-ink-3)}
  .pp-ph h1{max-width:760px;margin-bottom:var(--pp-sp-24)}
  .pp-ph-sub{font-size:18px;color:var(--pp-ink-2);max-width:560px}
  @media(max-width:768px){
    .pp-ph{padding:var(--pp-sp-48) 0 var(--pp-sp-64)}
    .pp-ph-sub{font-size:16px}
  }
</style>
<section class="pp-section pp-ph<?php echo esc_attr( $border ); ?>">
  <div class="pp-container">
    <div class="pp-ph-meta"><?php echo esc_html( $s['page_label'] ); ?></div>
    <h1 class="pp-reveal"><?php echo esc_html( $s['heading'] ); ?></h1>
    <?php if ( $s['subtitle'] ) : ?>
    <p class="pp-ph-sub pp-reveal" style="transition-delay:80ms"><?php echo esc_html( $s['subtitle'] ); ?></p>
    <?php endif; ?>
  </div>
</section>
        <?php
    }
}
