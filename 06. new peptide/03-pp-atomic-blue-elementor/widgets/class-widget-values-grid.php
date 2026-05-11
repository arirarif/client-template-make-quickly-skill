<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Values_Grid extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_11_values_grid'; }
    public function get_title()      { return '11 — Values Grid'; }
    public function get_icon()       { return 'eicon-info-box'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'values', 'about', 'grid', 'icons', 'peptides' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_head', [
            'label' => 'Section head',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'What We Stand For',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Three Non-Negotiables.',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_cards', [
            'label' => 'Value cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', [
            'label'   => 'Icon (emoji or short text)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '🇬🇧',
        ] );
        $rep->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'UK Stock',
        ] );
        $rep->add_control( 'copy', [
            'label'   => 'Copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 4,
            'default' => 'Every product on the site is held in our UK warehouse.',
        ] );

        $this->add_control( 'cards', [
            'label'       => 'Cards',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'icon'  => '🇬🇧',
                    'title' => 'UK Stock',
                    'copy'  => 'Every product on the site is physically held in our UK warehouse. What you see is what we can ship — no drop-shipping, no overseas waits.',
                ],
                [
                    'icon'  => '🚚',
                    'title' => 'Same-Day Dispatch',
                    'copy'  => 'Order before 3pm on a working day and it ships the same day. Tracked &amp; discreet — usually next-day delivery within the UK.',
                ],
                [
                    'icon'  => '💬',
                    'title' => 'Real Support',
                    'copy'  => 'Questions about reconstitution, storage or product info? Drop us a message and a real person on our team will reply within one working day.',
                ],
            ],
            'title_field' => '{{{ icon }}} {{{ title }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $cols = max( 1, count( $s['cards'] ) );
        ?>
<style>
  .pp-values { padding: 70px 20px; }
  .pp-values .pp-section-head h2 { color: var(--pp-paper); }
  .pp-values-grid {
    display: grid;
    gap: 22px;
  }
  .pp-value-card {
    background: var(--pp-panel);
    color: #000;
    border: var(--pp-border);
    border-radius: 30px;
    padding: 26px;
    box-shadow: var(--pp-shadow-lg);
  }
  .pp-value-card .ico {
    font-size: 48px;
    margin-bottom: 12px;
    display: block;
    line-height: 1;
  }
  .pp-value-card h3 {
    font: 900 22px var(--pp-f-body);
    text-transform: uppercase;
    margin: 0 0 8px;
  }
  .pp-value-card p {
    font: 800 14px var(--pp-f-body);
    line-height: 1.4;
    margin: 0;
  }
  @media (max-width: 980px) {
    .pp-values-grid { grid-template-columns: repeat(2, 1fr) !important; }
  }
  @media (max-width: 620px) {
    .pp-values-grid { grid-template-columns: 1fr !important; }
  }
</style>
<section class="pp-section pp-bg-vault pp-values">
  <div class="pp-wrap">
    <div class="pp-section-head">
      <div>
        <?php if ( $s['eyebrow'] ) : ?>
          <p class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></p>
        <?php endif; ?>
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
      </div>
    </div>
    <?php if ( ! empty( $s['cards'] ) ) : ?>
      <div class="pp-values-grid" style="grid-template-columns: repeat(<?php echo (int) $cols; ?>, 1fr);">
        <?php foreach ( $s['cards'] as $c ) : ?>
          <article class="pp-value-card">
            <span class="ico"><?php echo esc_html( $c['icon'] ); ?></span>
            <h3><?php echo esc_html( $c['title'] ); ?></h3>
            <p><?php echo esc_html( $c['copy'] ); ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
        <?php
    }
}
