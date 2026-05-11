<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Lab_Tour extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_12_lab_tour'; }
    public function get_title()      { return '12 — Lab Tour'; }
    public function get_icon()       { return 'eicon-image-rollover'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'lab', 'tour', 'about', 'image', 'peptides' ]; }

    protected function register_controls() {

        /* ── Left ── */
        $this->start_controls_section( 'sec_left', [
            'label' => 'Left — image',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'image', [
            'label'       => 'Image (optional)',
            'type'        => \Elementor\Controls_Manager::MEDIA,
            'default'     => [ 'url' => '' ],
            'description' => 'Leave empty to fall back to the emoji placeholder.',
        ] );
        $this->add_control( 'emoji', [
            'label'       => 'Emoji fallback',
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => '📦',
            'description' => 'Used only when no image is set.',
        ] );
        $this->end_controls_section();

        /* ── Right ── */
        $this->start_controls_section( 'sec_right', [
            'label' => 'Right — copy',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'The Warehouse',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'UK Based. Climate-controlled. Ready To Ship.',
        ] );
        $this->add_control( 'copy', [
            'label'   => 'Copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 4,
            'default' => 'Our UK fulfilment site is climate-controlled and stocked daily. Orders are picked, packed and dispatched the same day on working days — so you don\'t sit waiting on customs or international shipping.',
        ] );
        $this->add_control( 'btn_text', [
            'label'   => 'Button text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Get In Touch →',
        ] );
        $this->add_control( 'btn_url', [
            'label'   => 'Button link',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/contact' ],
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $url  = ! empty( $s['btn_url']['url'] ) ? esc_url( $s['btn_url']['url'] ) : '#';
        $tgt  = ! empty( $s['btn_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
        $img  = ! empty( $s['image']['url'] ) ? esc_url( $s['image']['url'] ) : '';
        ?>
<style>
  .pp-lab-tour-section { padding: 0 20px 70px; }
  .pp-lab-tour {
    background: var(--pp-deep);
    border: var(--pp-border);
    border-radius: 42px;
    padding: 40px;
    box-shadow: var(--pp-shadow-xl);
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
    align-items: center;
    color: var(--pp-paper);
  }
  .pp-lab-tour .pp-lab-img {
    height: 320px;
    background: linear-gradient(135deg, var(--pp-glow), var(--pp-panel));
    border: var(--pp-border);
    border-radius: 32px;
    display: grid;
    place-items: center;
    font-size: 140px;
    overflow: hidden;
  }
  .pp-lab-tour .pp-lab-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }
  .pp-lab-tour h2 { color: var(--pp-paper); }
  .pp-lab-tour .pp-eyebrow { color: var(--pp-gold) !important; }
  .pp-lab-tour .pp-lab-copy {
    font: 800 16px var(--pp-f-body);
    line-height: 1.45;
    margin: 16px 0;
    color: var(--pp-paper);
  }
  @media (max-width: 980px) {
    .pp-lab-tour { grid-template-columns: 1fr; }
    .pp-lab-tour .pp-lab-img { height: 240px; font-size: 96px; }
  }
</style>
<section class="pp-section pp-bg-vault pp-lab-tour-section">
  <div class="pp-wrap">
    <div class="pp-lab-tour">
      <div class="pp-lab-img">
        <?php if ( $img ) : ?>
          <img src="<?php echo $img; ?>" alt="<?php echo esc_attr( $s['heading'] ); ?>">
        <?php else : ?>
          <span><?php echo esc_html( $s['emoji'] ); ?></span>
        <?php endif; ?>
      </div>
      <div>
        <?php if ( $s['eyebrow'] ) : ?>
          <p class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></p>
        <?php endif; ?>
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
        <?php if ( $s['copy'] ) : ?>
          <p class="pp-lab-copy"><?php echo esc_html( $s['copy'] ); ?></p>
        <?php endif; ?>
        <?php if ( $s['btn_text'] ) : ?>
          <a href="<?php echo $url; ?>"<?php echo $tgt; ?> class="pp-btn"><?php echo esc_html( $s['btn_text'] ); ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
        <?php
    }
}
