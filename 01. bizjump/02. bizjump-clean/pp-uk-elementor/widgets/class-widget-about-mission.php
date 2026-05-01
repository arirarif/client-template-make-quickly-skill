<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 14 — About: Mission
 * 2-column grid: text (eyebrow + heading + body) left, image with badge overlay right.
 */
class Widget_About_Mission extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_14_about_mission'; }
    public function get_title()      { return '14 — About: Mission'; }
    public function get_icon()       { return 'eicon-target'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'about', 'mission', 'pp-uk' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_text', [
            'label' => 'Text',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Our Mission',
        ] );

        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Raising the standard for research-grade compounds in the UK.',
            'rows'    => 2,
        ] );

        $this->add_control( 'body', [
            'label'   => 'Body (HTML allowed)',
            'type'    => \Elementor\Controls_Manager::WYSIWYG,
            'default' => '<p>Performance Peptide UK was founded because researchers deserved better. We were tired of ambiguous sourcing, inconsistent purity, and suppliers who buried their lab data behind paywalls.</p><p style="margin-top:16px">Every compound we stock is independently HPLC-tested before dispatch. Every batch report is published on the product page. No exceptions.</p>',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_image', [
            'label' => 'Image & Badge',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'image', [
            'label'   => 'Image',
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=800&q=80&auto=format&fit=crop' ],
        ] );

        $this->add_control( 'badge_stat', [
            'label'   => 'Badge Stat',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '99.2%',
        ] );

        $this->add_control( 'badge_label', [
            'label'   => 'Badge Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Average purity across all batches',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $img = ! empty( $s['image']['url'] ) ? esc_url( $s['image']['url'] ) : '';
        ?>
<style>
  .pp-mission{background:var(--pp-bg)}
  .pp-mission-grid{display:grid;grid-template-columns:1fr 1fr;gap:var(--pp-sp-64);align-items:center}
  .pp-mission-text .pp-eyebrow{margin-bottom:var(--pp-sp-16)}
  .pp-mission-text h2{margin-bottom:var(--pp-sp-24)}
  .pp-mission-text p{font-size:16px;color:var(--pp-ink-2);line-height:1.7}
  .pp-mission-text p+p{margin-top:var(--pp-sp-16)}
  .pp-mission-img-wrap{position:relative}
  .pp-mission-img{width:100%;aspect-ratio:4/5;object-fit:cover;border-radius:var(--pp-r-lg);display:block}
  .pp-mission-badge{position:absolute;bottom:var(--pp-sp-24);left:var(--pp-sp-24);background:var(--pp-surface);border:1px solid var(--pp-border);border-radius:var(--pp-r);padding:var(--pp-sp-16) var(--pp-sp-20);box-shadow:var(--pp-sh-3);max-width:200px}
  .pp-mission-badge-stat{font-size:28px;font-weight:600;color:var(--pp-ink);letter-spacing:-0.03em;line-height:1}
  .pp-mission-badge-label{font-family:var(--pp-f-mono);font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:var(--pp-ink-3);margin-top:var(--pp-sp-8);line-height:1.4}
  .pp-mission-img-placeholder{width:100%;aspect-ratio:4/5;background:var(--pp-surface-2);border:1px solid var(--pp-border);border-radius:var(--pp-r-lg);display:flex;align-items:center;justify-content:center}
  .pp-mission-img-placeholder svg{width:64px;height:64px;color:var(--pp-border-2)}
  @media(max-width:900px){.pp-mission-grid{grid-template-columns:1fr;gap:var(--pp-sp-48)}.pp-mission-img-wrap{order:-1}}
</style>
<section class="pp-section pp-mission pp-pad">
  <div class="pp-container">
    <div class="pp-mission-grid">
      <div class="pp-mission-text pp-reveal">
        <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
        <div><?php echo wp_kses_post( $s['body'] ); ?></div>
      </div>
      <div class="pp-mission-img-wrap pp-reveal" style="transition-delay:120ms">
        <?php if ( $img ) : ?>
        <img class="pp-mission-img" src="<?php echo $img; ?>" alt="<?php esc_attr_e( 'Lab research', 'pp-uk-elementor' ); ?>" loading="lazy">
        <?php else : ?>
        <div class="pp-mission-img-placeholder">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="0.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 3h18M3 21h18"/></svg>
        </div>
        <?php endif; ?>
        <?php if ( $s['badge_stat'] ) : ?>
        <div class="pp-mission-badge">
          <div class="pp-mission-badge-stat"><?php echo esc_html( $s['badge_stat'] ); ?></div>
          <div class="pp-mission-badge-label"><?php echo esc_html( $s['badge_label'] ); ?></div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
        <?php
    }
}
