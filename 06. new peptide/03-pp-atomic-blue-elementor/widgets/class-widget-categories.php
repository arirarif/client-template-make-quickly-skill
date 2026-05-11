<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Categories extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_03_categories'; }
    public function get_title()      { return '03 — Categories'; }
    public function get_icon()       { return 'eicon-posts-grid'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'categories', 'departments', 'peptides' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_head', [
            'label' => 'Section head',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Shop by department',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Research categories',
        ] );
        $this->add_control( 'btn_text', [
            'label'   => 'Side button text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'View all',
        ] );
        $this->add_control( 'btn_url', [
            'label'   => 'Side button link',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/shop' ],
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_cards', [
            'label' => 'Category cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', [
            'label'   => 'Icon (emoji or short text)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '🧪',
        ] );
        $rep->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Healing Peptides',
        ] );
        $rep->add_control( 'copy', [
            'label'   => 'Copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => 'For the advanced study of tissue healing and anti-aging.',
        ] );
        $rep->add_control( 'link_text', [
            'label'   => 'Link text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'See products ›',
        ] );
        $rep->add_control( 'link_url', [
            'label'   => 'Link URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/shop' ],
        ] );
        $this->add_control( 'cards', [
            'label'       => 'Cards',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'icon' => '🧪', 'title' => 'Healing Peptides', 'copy' => 'For the advanced study of tissue healing and anti-aging.', 'link_text' => 'See products ›' ],
                [ 'icon' => '⚗️', 'title' => 'Metabolic',        'copy' => 'Researching Mitochondrial support and energy.',           'link_text' => 'See products ›' ],
                [ 'icon' => '📦', 'title' => 'Weight Loss',      'copy' => 'Practical research supporting health and weightloss goals.', 'link_text' => 'See products ›' ],
                [ 'icon' => '📘', 'title' => 'Cognitive Centre', 'copy' => 'Compounds specific to Neurological support and improvment.', 'link_text' => 'See products ›' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s       = $this->get_settings_for_display();
        $btn_url = ! empty( $s['btn_url']['url'] ) ? esc_url( $s['btn_url']['url'] ) : '#';
        $btn_tgt = ! empty( $s['btn_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
        ?>
<style>
  .pp-cats { padding: 70px 20px; }
  .pp-cats .pp-cat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
  }
  a.pp-cat-card,
  .pp-cat-card {
    background: var(--pp-panel);
    color: #000 !important;
    border: var(--pp-border);
    border-radius: 32px;
    padding: 26px;
    box-shadow: var(--pp-shadow-lg);
    transition: .15s;
    display: block;
    text-decoration: none;
  }
  a.pp-cat-card:hover,
  a.pp-cat-card:focus,
  a.pp-cat-card:visited,
  a.pp-cat-card:active,
  .pp-cat-card:hover,
  .pp-cat-card:focus,
  .pp-cat-card:visited,
  .pp-cat-card:active { color: #000 !important; text-decoration: none; }
  .pp-cat-card:hover { transform: translateY(-4px); }
  .pp-cat-card .pp-cat-ico { font-size: 42px; line-height: 1; color: #000; }
  .pp-cat-card h3 {
    font-family: var(--pp-f-head);
    font-size: 26px;
    line-height: .95;
    margin: 18px 0 10px;
    text-transform: uppercase;
    color: #000 !important;
  }
  .pp-cat-card p { font: 800 16px var(--pp-f-body); margin: 0; color: #000 !important; }
  .pp-cat-card span {
    font: 800 16px var(--pp-f-body);
    text-transform: uppercase;
    display: inline-block;
    margin-top: 10px;
    color: #000 !important;
  }
  @media (max-width: 980px) { .pp-cats .pp-cat-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 620px) { .pp-cats .pp-cat-grid { grid-template-columns: 1fr; } }
</style>
<section class="pp-section pp-bg-vault pp-cats">
  <div class="pp-wrap">
    <div class="pp-section-head">
      <div>
        <?php if ( $s['eyebrow'] ) : ?><p class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></p><?php endif; ?>
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
      </div>
      <?php if ( $s['btn_text'] ) : ?>
        <a href="<?php echo $btn_url; ?>"<?php echo $btn_tgt; ?> class="pp-btn secondary"><?php echo esc_html( $s['btn_text'] ); ?></a>
      <?php endif; ?>
    </div>
    <div class="pp-cat-grid">
      <?php if ( ! empty( $s['cards'] ) ) : foreach ( $s['cards'] as $card ) :
        $url = ! empty( $card['link_url']['url'] ) ? esc_url( $card['link_url']['url'] ) : '#';
        $tgt = ! empty( $card['link_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
      ?>
        <a class="pp-cat-card" href="<?php echo $url; ?>"<?php echo $tgt; ?>>
          <div class="pp-cat-ico"><?php echo esc_html( $card['icon'] ); ?></div>
          <h3><?php echo esc_html( $card['title'] ); ?></h3>
          <p><?php echo esc_html( $card['copy'] ); ?></p>
          <?php if ( $card['link_text'] ) : ?>
            <span><?php echo esc_html( $card['link_text'] ); ?></span>
          <?php endif; ?>
        </a>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>
        <?php
    }
}
