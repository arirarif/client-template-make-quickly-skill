<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Trust_Strip extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_02_trust_strip'; }
    public function get_title()      { return '02 — Trust Strip'; }
    public function get_icon()       { return 'eicon-info-box'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'trust', 'usp', 'badges', 'peptides' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_cards', [
            'label' => 'Trust cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', [
            'label'   => 'Icon (emoji or short text)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '🚚',
        ] );
        $rep->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Fast UK dispatch',
        ] );
        $rep->add_control( 'copy', [
            'label'   => 'Copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => 'Order before 3pm on working days.',
        ] );

        $this->add_control( 'cards', [
            'label'       => 'Cards',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'icon' => '🚚', 'title' => 'Fast UK dispatch',    'copy' => 'Order before 3pm on working days.' ],
                [ 'icon' => '✅', 'title' => 'Research use only',   'copy' => 'Clear compliance messaging across the store.' ],
                [ 'icon' => '⭐', 'title' => 'Quality focused',     'copy' => 'Purity, storage and clear product definitions.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-trust {
    background: var(--pp-paper);
    color: #000;
    border-top: var(--pp-border);
    border-bottom: var(--pp-border);
    box-shadow: 0 -8px 0 rgba(0,0,0,.35), 0 8px 0 rgba(0,0,0,.35);
    padding: 32px 0;
  }
  .pp-trust .pp-trust-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }
  .pp-trust-card {
    background: var(--pp-panel);
    border: var(--pp-border);
    border-radius: 28px;
    padding: 22px;
    box-shadow: var(--pp-shadow-lg);
    display: flex;
    gap: 16px;
    font-family: var(--pp-f-body);
    align-items: flex-start;
  }
  .pp-trust-card .pp-trust-ico {
    font-size: 28px;
    line-height: 1;
  }
  .pp-trust-card b {
    display: block;
    font-size: 20px;
    text-transform: uppercase;
  }
  .pp-trust-card p {
    margin: .35rem 0 0;
    font-weight: 800;
  }
  @media (max-width: 980px) { .pp-trust .pp-trust-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 620px) { .pp-trust .pp-trust-grid { grid-template-columns: 1fr; } }
</style>
<section class="pp-section pp-trust">
  <div class="pp-wrap pp-trust-grid">
    <?php if ( ! empty( $s['cards'] ) ) : foreach ( $s['cards'] as $card ) : ?>
      <div class="pp-trust-card">
        <div class="pp-trust-ico"><?php echo esc_html( $card['icon'] ); ?></div>
        <div>
          <b><?php echo esc_html( $card['title'] ); ?></b>
          <p><?php echo esc_html( $card['copy'] ); ?></p>
        </div>
      </div>
    <?php endforeach; endif; ?>
  </div>
</section>
        <?php
    }
}
