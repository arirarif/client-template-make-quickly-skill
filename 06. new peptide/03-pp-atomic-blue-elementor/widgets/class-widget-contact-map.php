<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Contact_Map extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_16_contact_map'; }
    public function get_title()      { return '16 — Contact Map'; }
    public function get_icon()       { return 'eicon-google-maps'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'map', 'contact', 'location', 'pin', 'peptides' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_map', [
            'label' => 'Map',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'mode', [
            'label'   => 'Mode',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'placeholder',
            'options' => [
                'placeholder' => 'Stylised placeholder (default)',
                'embed'       => 'Live Google Maps embed',
            ],
        ] );

        $this->add_control( 'embed_url', [
            'label'       => 'Google Maps embed URL',
            'type'        => \Elementor\Controls_Manager::URL,
            'default'     => [ 'url' => '' ],
            'description' => 'Use the "Embed a map" iframe src URL from Google Maps. Required only when Mode = Live embed.',
            'condition'   => [ 'mode' => 'embed' ],
        ] );

        $this->add_control( 'pin_emoji', [
            'label'     => 'Pin emoji',
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => '📍',
            'condition' => [ 'mode' => 'placeholder' ],
        ] );

        $this->add_control( 'label', [
            'label'   => 'Label pill text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'United Kingdom',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $mode = ! empty( $s['mode'] ) ? $s['mode'] : 'placeholder';
        $url  = ! empty( $s['embed_url']['url'] ) ? esc_url( $s['embed_url']['url'] ) : '';
        ?>
<style>
  .pp-map-section { padding: 0 20px 70px; }
  .pp-map {
    height: 320px;
    background: var(--pp-deep);
    border: var(--pp-border);
    border-radius: 36px;
    box-shadow: var(--pp-shadow-xl);
    display: grid;
    place-items: center;
    position: relative;
    overflow: hidden;
  }
  .pp-map .pin {
    font-size: 80px;
    filter: drop-shadow(4px 4px 0 #000);
  }
  .pp-map .pin-label {
    position: absolute;
    bottom: 24px;
    left: 24px;
    background: var(--pp-glow);
    color: #000;
    border: var(--pp-border);
    border-radius: 999px;
    padding: 10px 18px;
    font: 900 13px var(--pp-f-body);
    text-transform: uppercase;
    box-shadow: var(--pp-shadow-sm);
  }
  .pp-map iframe {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
  }
</style>
<section class="pp-section pp-bg-vault pp-map-section">
  <div class="pp-wrap">
    <div class="pp-map">
      <?php if ( 'embed' === $mode && $url ) : ?>
        <iframe src="<?php echo $url; ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      <?php else : ?>
        <span class="pin"><?php echo esc_html( $s['pin_emoji'] ); ?></span>
      <?php endif; ?>
      <?php if ( $s['label'] ) : ?>
        <span class="pin-label"><?php echo esc_html( $s['label'] ); ?></span>
      <?php endif; ?>
    </div>
  </div>
</section>
        <?php
    }
}
