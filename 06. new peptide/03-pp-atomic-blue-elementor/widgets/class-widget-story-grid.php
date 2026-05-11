<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Story_Grid extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_09_story_grid'; }
    public function get_title()      { return '09 — Story Grid'; }
    public function get_icon()       { return 'eicon-post-list'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'story', 'grid', 'about', 'cards', 'peptides' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_head', [
            'label' => 'Section head',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Our Story',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => "Built By Researchers.\nFor Researchers.",
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_cards', [
            'label' => 'Story cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'The Beginning',
        ] );
        $rep->add_control( 'copy', [
            'label'   => 'Copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 5,
            'default' => 'We started Performance Peptides because, as researchers ourselves, we couldn\'t find a supplier we\'d trust to put on our own benches.',
        ] );

        $this->add_control( 'cards', [
            'label'       => 'Cards',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'title' => 'The Beginning',
                    'copy'  => 'We started Performance Peptides because, as researchers ourselves, we wanted a UK supplier that was simple to order from and quick to deliver. No clunky checkouts, no waiting weeks for stock, no jargon.',
                ],
                [
                    'title' => 'The Mission',
                    'copy'  => 'Build the easiest UK research peptide store to use. Plain-English product pages, stock you can actually order today, same-day dispatch on working days. No nonsense, no shipping delays, no surprises at checkout.',
                ],
            ],
            'title_field' => '{{{ title }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-story { padding: 70px 20px; }
  .pp-story .pp-section-head h2 { color: var(--pp-paper); white-space: pre-line; }
  .pp-story-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
    align-items: stretch;
  }
  .pp-story-card {
    background: var(--pp-paper);
    color: #000;
    border: var(--pp-border);
    border-radius: 30px;
    padding: 30px;
    box-shadow: var(--pp-shadow-lg);
  }
  .pp-story-card h3 {
    font: 900 28px var(--pp-f-body);
    text-transform: uppercase;
    margin: 0 0 12px;
  }
  .pp-story-card p {
    font: 800 16px var(--pp-f-body);
    line-height: 1.4;
    margin: 0;
  }
  @media (max-width: 980px) {
    .pp-story-grid { grid-template-columns: 1fr; }
  }
</style>
<section class="pp-section pp-bg-vault pp-story">
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
      <div class="pp-story-grid">
        <?php foreach ( $s['cards'] as $c ) : ?>
          <article class="pp-story-card">
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
