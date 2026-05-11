<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Hero extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_01_hero'; }
    public function get_title()      { return '01 — Hero'; }
    public function get_icon()       { return 'eicon-banner'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'hero', 'banner', 'atomic', 'peptides' ]; }

    protected function register_controls() {

        /* ── Left column ── */
        $this->start_controls_section( 'sec_left', [
            'label' => 'Left — headline & CTA',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'pill', [
            'label'   => 'Pill text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '⚛ High grade research supplies',
        ] );
        $this->add_control( 'headline', [
            'label'   => 'Headline (H1)',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => 'Cutting Edge science exploration.',
        ] );
        $this->add_control( 'lead', [
            'label'   => 'Lead copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => 'Performance Peptides delivers high-quality research peptides, lab essentials and bundles direct from UK based supplies.',
        ] );
        $this->add_control( 'btn1_text', [
            'label'   => 'Primary button text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Shop peptides ›',
        ] );
        $this->add_control( 'btn1_url', [
            'label'   => 'Primary button link',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/shop' ],
        ] );
        $this->add_control( 'btn2_text', [
            'label'   => 'Secondary button text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Mixing guide',
        ] );
        $this->add_control( 'btn2_url', [
            'label'   => 'Secondary button link',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#' ],
        ] );
        $this->end_controls_section();

        /* ── Right column (hero card) ── */
        $this->start_controls_section( 'sec_card', [
            'label' => 'Right — hero card',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'badge', [
            'label'   => 'Badge text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Hot',
        ] );
        $this->add_control( 'atom_image', [
            'label'   => 'Atom image',
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => '' ],
        ] );
        $this->add_control( 'card_heading', [
            'label'   => 'Card heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Researcher Essentials',
        ] );
        $this->add_control( 'card_copy', [
            'label'   => 'Card copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => 'Peptides, reconstitution supplies and lab tools, all organised for fast checkout.',
        ] );
        $this->end_controls_section();

        /* ── Stats ── */
        $this->start_controls_section( 'sec_stats', [
            'label' => 'Stats (card footer)',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'value', [
            'label'   => 'Value',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '99%+',
        ] );
        $rep->add_control( 'label', [
            'label'   => 'Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Purity',
        ] );
        $rep->add_control( 'colour', [
            'label'   => 'Value colour',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'glow'  => 'Cyan glow (default)',
                'gold'  => 'Gold',
                'paper' => 'Paper',
                'red'   => 'Red',
            ],
            'default' => 'glow',
        ] );
        $this->add_control( 'stats', [
            'label'       => 'Stats',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'value' => '99%+', 'label' => 'Purity',   'colour' => 'glow' ],
                [ 'value' => '3PM',  'label' => 'Dispatch', 'colour' => 'gold' ],
                [ 'value' => 'UK',   'label' => 'Stock',    'colour' => 'paper' ],
            ],
            'title_field' => '{{{ value }}} — {{{ label }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s       = $this->get_settings_for_display();
        $b1_url  = ! empty( $s['btn1_url']['url'] ) ? esc_url( $s['btn1_url']['url'] ) : '#';
        $b1_tgt  = ! empty( $s['btn1_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
        $b2_url  = ! empty( $s['btn2_url']['url'] ) ? esc_url( $s['btn2_url']['url'] ) : '#';
        $b2_tgt  = ! empty( $s['btn2_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
        $atom    = ! empty( $s['atom_image']['url'] ) ? esc_url( $s['atom_image']['url'] ) : '';
        ?>
<style>
  .pp-hero { padding: 34px 20px 72px; }
  .pp-hero .pp-wrap {
    display: grid;
    grid-template-columns: 1.08fr .92fr;
    gap: 52px;
    align-items: center;
  }
  .pp-hero h1 { margin: 28px 0 0; color: var(--pp-paper); }
  .pp-hero .pp-lead {
    max-width: 720px;
    margin: 24px 0 0;
    font: 800 clamp(20px, 2.2vw, 28px) var(--pp-f-body);
    line-height: 1.2;
    color: var(--pp-panel);
  }
  .pp-hero .pp-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-top: 34px;
  }
  .pp-hero-card-wrap { position: relative; }
  .pp-hero-card-wrap::before {
    content: "";
    position: absolute;
    inset: -24px;
    border-radius: 48px;
    background: var(--pp-gold);
    border: var(--pp-border);
    transform: rotate(3deg);
  }
  .pp-hero-card {
    position: relative;
    background: var(--pp-panel);
    color: #000;
    border: var(--pp-border);
    border-radius: 48px;
    padding: 32px;
    box-shadow: var(--pp-shadow-xxl);
    overflow: hidden;
  }
  .pp-hero-card .pp-badge {
    position: absolute;
    top: 18px; right: 18px;
    background: var(--pp-red);
    border: var(--pp-border);
    border-radius: 999px;
    padding: 8px 16px;
    font: 900 14px var(--pp-f-body);
    text-transform: uppercase;
  }
  .pp-hero-card .pp-atom {
    display: block;
    height: 220px;
    max-width: 100%;
    object-fit: contain;
    margin: 0 auto;
  }
  .pp-hero-card h2 {
    margin-top: 12px;
    font-size: 42px;
    text-shadow: none;
    color: #000;
  }
  .pp-hero-card p {
    margin: 8px 0 0;
    font: 800 18px var(--pp-f-body);
    line-height: 1.25;
  }
  .pp-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-top: 24px;
  }
  .pp-stat {
    background: var(--pp-vault);
    color: var(--pp-glow);
    border: var(--pp-border);
    border-radius: 20px;
    padding: 12px;
    text-align: center;
    font: 900 22px var(--pp-f-body);
  }
  .pp-stat.col-gold  { color: var(--pp-gold); }
  .pp-stat.col-paper { color: var(--pp-paper); }
  .pp-stat.col-red   { color: var(--pp-red); }
  .pp-stat span {
    color: var(--pp-paper);
    font-size: 11px;
    text-transform: uppercase;
    display: block;
  }
  @media (max-width: 980px) {
    .pp-hero .pp-wrap { grid-template-columns: 1fr; }
  }
  @media (max-width: 620px) {
    .pp-stats { grid-template-columns: 1fr; }
  }
</style>
<section class="pp-section pp-bg-vault pp-hero">
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
        <?php if ( $atom ) : ?>
          <img class="pp-atom" src="<?php echo $atom; ?>" alt="<?php echo esc_attr( $s['card_heading'] ); ?>">
        <?php endif; ?>
        <h2><?php echo esc_html( $s['card_heading'] ); ?></h2>
        <?php if ( $s['card_copy'] ) : ?>
          <p><?php echo esc_html( $s['card_copy'] ); ?></p>
        <?php endif; ?>
        <?php if ( ! empty( $s['stats'] ) ) : ?>
          <div class="pp-stats">
            <?php foreach ( $s['stats'] as $stat ) :
              $col = ! empty( $stat['colour'] ) ? sanitize_html_class( $stat['colour'] ) : 'glow';
            ?>
              <div class="pp-stat col-<?php echo esc_attr( $col ); ?>">
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
