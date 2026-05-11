<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Footer extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_07_footer'; }
    public function get_title()      { return '07 — Footer'; }
    public function get_icon()       { return 'eicon-footer'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'footer', 'compliance', 'peptides' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_content', [
            'label' => 'Footer content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'logo', [
            'label'   => 'Logo image',
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => '' ],
        ] );
        $this->add_control( 'logo_alt', [
            'label'   => 'Logo alt text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Performance Peptides logo',
        ] );
        $this->add_control( 'copy', [
            'label'   => 'Compliance copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => 'Performance Peptides products are supplied strictly for laboratory research use only. Not for human or veterinary use.',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $logo = ! empty( $s['logo']['url'] ) ? esc_url( $s['logo']['url'] ) : '';
        ?>
<style>
  .pp-footer {
    background: #000;
    color: var(--pp-panel);
    border-top: var(--pp-border);
    border-top-color: var(--pp-panel);
    padding: 42px 0;
  }
  .pp-footer .pp-wrap {
    display: flex;
    justify-content: space-between;
    gap: 30px;
    align-items: flex-start;
  }
  .pp-footer img {
    height: 58px;
    max-width: 320px;
    object-fit: contain;
  }
  .pp-footer p {
    max-width: 600px;
    margin: 0;
    font: 800 15px var(--pp-f-body);
    line-height: 1.45;
  }
  @media (max-width: 620px) {
    .pp-footer .pp-wrap { flex-direction: column; align-items: flex-start; }
  }
</style>
<footer class="pp-section pp-footer">
  <div class="pp-wrap">
    <?php if ( $logo ) : ?>
      <img src="<?php echo $logo; ?>" alt="<?php echo esc_attr( $s['logo_alt'] ); ?>">
    <?php endif; ?>
    <?php if ( $s['copy'] ) : ?>
      <p><?php echo esc_html( $s['copy'] ); ?></p>
    <?php endif; ?>
  </div>
</footer>
        <?php
    }
}
