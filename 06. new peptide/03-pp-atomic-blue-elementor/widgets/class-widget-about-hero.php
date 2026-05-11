<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_About_Hero extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_08_about_hero'; }
    public function get_title()      { return '08 — About Hero'; }
    public function get_icon()       { return 'eicon-info-circle'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'about', 'hero', 'pledge', 'atom', 'peptides' ]; }

    protected function register_controls() {

        /* ── Left ── */
        $this->start_controls_section( 'sec_left', [
            'label' => 'Left — headline & CTA',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'pill', [
            'label'   => 'Pill text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '⚛ Stocked in the UK · Dispatched Fast',
        ] );
        $this->add_control( 'headline', [
            'label'       => 'Headline (H1)',
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'rows'        => 2,
            'default'     => "The Vault.\nUK Stocked.",
            'description' => 'Use a line break for the second line.',
        ] );
        $this->add_control( 'lead', [
            'label'   => 'Lead copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => 'Performance Peptides is a UK-stocked research peptide supplier built for researchers who value fast turnaround. Order before 3pm on a working day and we ship the same day.',
        ] );
        $this->add_control( 'btn1_text', [
            'label'   => 'Primary button text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Browse the Vault →',
        ] );
        $this->add_control( 'btn1_url', [
            'label'   => 'Primary button link',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/shop' ],
        ] );
        $this->add_control( 'btn2_text', [
            'label'   => 'Secondary button text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Get In Touch',
        ] );
        $this->add_control( 'btn2_url', [
            'label'   => 'Secondary button link',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/contact' ],
        ] );
        $this->end_controls_section();

        /* ── Right card ── */
        $this->start_controls_section( 'sec_card', [
            'label' => 'Right — pledge card',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'badge', [
            'label'   => 'Badge text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Our Pledge',
        ] );
        $this->add_control( 'card_image', [
            'label'       => 'Card image (optional)',
            'type'        => \Elementor\Controls_Manager::MEDIA,
            'default'     => [ 'url' => '' ],
            'description' => 'Leave empty to use the built-in animated atom SVG.',
        ] );
        $this->add_control( 'card_heading', [
            'label'   => 'Card heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'UK Stock. Fast Dispatch.',
        ] );
        $this->add_control( 'card_copy', [
            'label'   => 'Card copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => 'Every product on the site is physically held in our UK warehouse. Order before 3pm on a working day and it ships the same day.',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s      = $this->get_settings_for_display();
        $b1_url = ! empty( $s['btn1_url']['url'] ) ? esc_url( $s['btn1_url']['url'] ) : '#';
        $b1_tgt = ! empty( $s['btn1_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
        $b2_url = ! empty( $s['btn2_url']['url'] ) ? esc_url( $s['btn2_url']['url'] ) : '#';
        $b2_tgt = ! empty( $s['btn2_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
        $img    = ! empty( $s['card_image']['url'] ) ? esc_url( $s['card_image']['url'] ) : '';
        ?>
<style>
  .pp-about-hero { padding: 34px 20px 58px; }
  .pp-about-hero .pp-wrap {
    display: grid;
    grid-template-columns: 1.08fr .92fr;
    gap: 52px;
    align-items: center;
  }
  .pp-about-hero h1 {
    margin: 28px 0 0;
    color: var(--pp-paper);
    white-space: pre-line;
  }
  .pp-about-hero .pp-lead {
    max-width: 720px;
    margin: 24px 0 0;
    font: 800 clamp(20px, 2.2vw, 28px) var(--pp-f-body);
    line-height: 1.2;
    color: var(--pp-panel);
  }
  .pp-about-hero .pp-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-top: 34px;
  }
  .pp-about-hero .pp-hero-card-wrap { position: relative; }
  .pp-about-hero .pp-hero-card-wrap::before {
    content: "";
    position: absolute;
    inset: -24px;
    border-radius: 48px;
    background: var(--pp-gold);
    border: var(--pp-border);
    transform: rotate(3deg);
  }
  .pp-about-hero .pp-hero-card {
    position: relative;
    background: var(--pp-panel);
    color: #000;
    border: var(--pp-border);
    border-radius: 48px;
    padding: 32px;
    box-shadow: var(--pp-shadow-xxl);
    overflow: hidden;
    text-align: center;
  }
  .pp-about-hero .pp-hero-card .pp-badge {
    position: absolute;
    top: 18px; right: 18px;
    background: var(--pp-red);
    border: var(--pp-border);
    border-radius: 999px;
    padding: 8px 16px;
    font: 900 14px var(--pp-f-body);
    text-transform: uppercase;
  }
  .pp-about-hero .pp-atom-svg,
  .pp-about-hero .pp-atom-img {
    display: block;
    height: 220px;
    max-width: 100%;
    object-fit: contain;
    margin: 0 auto;
  }
  .pp-about-hero .pp-hero-card h2 {
    margin-top: 12px;
    font-size: 42px;
    text-shadow: none;
    color: #000;
  }
  .pp-about-hero .pp-hero-card p {
    margin: 8px 0 0;
    font: 800 18px var(--pp-f-body);
    line-height: 1.25;
  }
  @media (max-width: 980px) {
    .pp-about-hero .pp-wrap { grid-template-columns: 1fr; }
  }
</style>
<section class="pp-section pp-bg-vault pp-about-hero">
  <div class="pp-wrap">
    <div>
      <?php if ( $s['pill'] ) : ?>
        <div class="pp-pill"><?php echo esc_html( $s['pill'] ); ?></div>
      <?php endif; ?>
      <h1><?php echo esc_html( $s['headline'] ); ?></h1>
      <?php if ( $s['lead'] ) : ?>
        <p class="pp-lead"><?php echo esc_html( $s['lead'] ); ?></p>
      <?php endif; ?>
      <div class="pp-actions">
        <?php if ( $s['btn1_text'] ) : ?>
          <a href="<?php echo $b1_url; ?>"<?php echo $b1_tgt; ?> class="pp-btn"><?php echo esc_html( $s['btn1_text'] ); ?></a>
        <?php endif; ?>
        <?php if ( $s['btn2_text'] ) : ?>
          <a href="<?php echo $b2_url; ?>"<?php echo $b2_tgt; ?> class="pp-btn secondary"><?php echo esc_html( $s['btn2_text'] ); ?></a>
        <?php endif; ?>
      </div>
    </div>
    <div class="pp-hero-card-wrap">
      <div class="pp-hero-card">
        <?php if ( $s['badge'] ) : ?>
          <div class="pp-badge"><?php echo esc_html( $s['badge'] ); ?></div>
        <?php endif; ?>
        <?php if ( $img ) : ?>
          <img class="pp-atom-img" src="<?php echo $img; ?>" alt="<?php echo esc_attr( $s['card_heading'] ); ?>">
        <?php else : ?>
          <svg class="pp-atom-svg" viewBox="0 0 220 220" aria-hidden="true">
            <ellipse cx="110" cy="110" rx="92" ry="32" fill="none" stroke="#000" stroke-width="6"/>
            <ellipse cx="110" cy="110" rx="92" ry="32" fill="none" stroke="#000" stroke-width="6" transform="rotate(60 110 110)"/>
            <ellipse cx="110" cy="110" rx="92" ry="32" fill="none" stroke="#000" stroke-width="6" transform="rotate(-60 110 110)"/>
            <circle cx="110" cy="110" r="16" fill="#46f0ff" stroke="#000" stroke-width="6"/>
          </svg>
        <?php endif; ?>
        <h2><?php echo esc_html( $s['card_heading'] ); ?></h2>
        <?php if ( $s['card_copy'] ) : ?>
          <p><?php echo esc_html( $s['card_copy'] ); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
        <?php
    }
}
