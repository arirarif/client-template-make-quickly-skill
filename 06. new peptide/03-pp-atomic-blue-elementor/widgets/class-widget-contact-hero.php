<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Contact_Hero extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_14_contact_hero'; }
    public function get_title()      { return '14 — Contact Hero'; }
    public function get_icon()       { return 'eicon-mail'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'contact', 'hero', 'reply', 'peptides' ]; }

    protected function register_controls() {

        /* ── Left ── */
        $this->start_controls_section( 'sec_left', [
            'label' => 'Left — headline',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'pill', [
            'label'   => 'Pill text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '📬 We Read Every Message',
        ] );
        $this->add_control( 'headline', [
            'label'   => 'Headline (H1)',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => "Talk To\nThe Vault.",
        ] );
        $this->add_control( 'lead', [
            'label'   => 'Lead copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => 'Questions on stock, dispatch, reconstitution, bulk pricing, or anything else? Drop us a line — a real person from our UK team will reply within one working day.',
        ] );
        $this->end_controls_section();

        /* ── Right card ── */
        $this->start_controls_section( 'sec_card', [
            'label' => 'Right — reply card',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'badge', [
            'label'   => 'Badge text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '24h Reply',
        ] );
        $this->add_control( 'card_heading', [
            'label'   => 'Card heading',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => "Real Humans.\nReal Answers.",
        ] );
        $this->add_control( 'card_copy', [
            'label'   => 'Card copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => 'No tickets, no chatbots, no copy-paste replies. You message us, an actual person on our team writes back.',
        ] );
        $this->end_controls_section();

        /* ── Mini stats ── */
        $this->start_controls_section( 'sec_stats', [
            'label' => 'Mini stats (card footer)',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'value', [
            'label'   => 'Value',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '99%',
        ] );
        $rep->add_control( 'label', [
            'label'   => 'Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Reply Rate',
        ] );

        $this->add_control( 'stats', [
            'label'       => 'Stats',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'value' => 'UK',  'label' => 'Based Team' ],
                [ 'value' => '24h', 'label' => 'Avg. Reply' ],
                [ 'value' => '9–6', 'label' => 'Mon–Fri' ],
            ],
            'title_field' => '{{{ value }}} — {{{ label }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-contact-hero { padding: 34px 20px 58px; }
  .pp-contact-hero .pp-wrap {
    display: grid;
    grid-template-columns: 1.08fr .92fr;
    gap: 52px;
    align-items: center;
  }
  .pp-contact-hero h1 {
    margin: 28px 0 0;
    color: var(--pp-paper);
    white-space: pre-line;
  }
  .pp-contact-hero .pp-lead {
    max-width: 720px;
    margin: 24px 0 0;
    font: 800 clamp(20px, 2.2vw, 28px) var(--pp-f-body);
    line-height: 1.2;
    color: var(--pp-panel);
  }
  .pp-contact-hero .pp-hero-card-wrap { position: relative; }
  .pp-contact-hero .pp-hero-card-wrap::before {
    content: "";
    position: absolute;
    inset: -24px;
    border-radius: 48px;
    background: var(--pp-gold);
    border: var(--pp-border);
    transform: rotate(3deg);
  }
  .pp-contact-hero .pp-hero-card {
    position: relative;
    background: var(--pp-panel);
    color: #000;
    border: var(--pp-border);
    border-radius: 48px;
    padding: 32px;
    box-shadow: var(--pp-shadow-xxl);
    overflow: hidden;
  }
  .pp-contact-hero .pp-hero-card .pp-badge {
    position: absolute;
    top: 18px; right: 18px;
    background: var(--pp-red);
    border: var(--pp-border);
    border-radius: 999px;
    padding: 8px 16px;
    font: 900 14px var(--pp-f-body);
    text-transform: uppercase;
  }
  .pp-contact-hero .pp-hero-card h2 {
    margin: 0;
    font-size: 42px;
    text-shadow: none;
    color: #000;
    white-space: pre-line;
  }
  .pp-contact-hero .pp-hero-card p {
    margin: 8px 0 0;
    font: 800 18px var(--pp-f-body);
    line-height: 1.25;
  }
  .pp-contact-hero .pp-mini-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-top: 24px;
  }
  .pp-contact-hero .pp-mini-stat {
    background: var(--pp-vault);
    color: var(--pp-glow);
    border: var(--pp-border);
    border-radius: 20px;
    padding: 12px;
    text-align: center;
    font: 900 22px var(--pp-f-body);
  }
  .pp-contact-hero .pp-mini-stat span {
    color: var(--pp-paper);
    font-size: 11px;
    text-transform: uppercase;
    display: block;
    margin-top: 2px;
  }
  @media (max-width: 980px) {
    .pp-contact-hero .pp-wrap { grid-template-columns: 1fr; }
  }
  @media (max-width: 620px) {
    .pp-contact-hero .pp-mini-stats { grid-template-columns: 1fr; }
  }
</style>
<section class="pp-section pp-bg-vault pp-contact-hero">
  <div class="pp-wrap">
    <div>
      <?php if ( $s['pill'] ) : ?>
        <div class="pp-pill"><?php echo esc_html( $s['pill'] ); ?></div>
      <?php endif; ?>
      <h1><?php echo esc_html( $s['headline'] ); ?></h1>
      <?php if ( $s['lead'] ) : ?>
        <p class="pp-lead"><?php echo esc_html( $s['lead'] ); ?></p>
      <?php endif; ?>
    </div>
    <div class="pp-hero-card-wrap">
      <div class="pp-hero-card">
        <?php if ( $s['badge'] ) : ?>
          <div class="pp-badge"><?php echo esc_html( $s['badge'] ); ?></div>
        <?php endif; ?>
        <h2><?php echo esc_html( $s['card_heading'] ); ?></h2>
        <?php if ( $s['card_copy'] ) : ?>
          <p><?php echo esc_html( $s['card_copy'] ); ?></p>
        <?php endif; ?>
        <?php if ( ! empty( $s['stats'] ) ) : ?>
          <div class="pp-mini-stats">
            <?php foreach ( $s['stats'] as $stat ) : ?>
              <div class="pp-mini-stat">
                <?php echo esc_html( $stat['value'] ); ?>
                <span><?php echo esc_html( $stat['label'] ); ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
        <?php
    }
}
