<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 22 — Shipping: Packaging
 * 2-column grid: packaging features (icon rows) left, image right.
 */
class Widget_Shipping_Packaging extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_22_shipping_packaging'; }
    public function get_title()      { return '22 — Shipping: Packaging'; }
    public function get_icon()       { return 'eicon-archive-2'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'shipping', 'packaging', 'features', 'pp-uk' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_text', [
            'label' => 'Text',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Packaging',
        ] );

        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Integrity at every step.',
        ] );

        $this->add_control( 'intro', [
            'label'   => 'Intro Paragraph',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'All compounds are packaged to maintain molecular integrity from our facility to your laboratory. Discretion, safety, and scientific precision — built into every dispatch.',
            'rows'    => 3,
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_features', [
            'label' => 'Features',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'feat_title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Feature title' ] );
        $rep->add_control( 'feat_body',  [ 'label' => 'Body',  'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Feature description.', 'rows' => 4 ] );

        $this->add_control( 'features', [
            'label'       => 'Features',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'feat_title' => 'Plain outer packaging',              'feat_body' => 'No company name, branding, or product description visible on the exterior. Fully discreet delivery to your address.' ],
                [ 'feat_title' => 'Temperature-controlled cold packs',  'feat_body' => '48-hour rated cold packs included with all orders to maintain compound stability during transit.' ],
                [ 'feat_title' => 'Individual amber vial sealing',      'feat_body' => 'Every compound is sealed in pharmaceutical-grade amber glass vials within protective foam inserts. Vials are tamper-evident sealed.' ],
                [ 'feat_title' => 'COA included in every order',        'feat_body' => 'Printed batch COA and packing slip included. Each item cross-referenced to its batch number and laboratory report.' ],
            ],
            'title_field' => '{{{ feat_title }}}',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_image', [
            'label' => 'Image',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'image', [
            'label'   => 'Packaging Image',
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => '' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $img = ! empty( $s['image']['url'] ) ? esc_url( $s['image']['url'] ) : '';
        ?>
<style>
  .pp-pkg{background:var(--pp-surface)}
  .pp-pkg-grid{display:grid;grid-template-columns:1fr 1fr;gap:var(--pp-sp-64);align-items:start}
  .pp-pkg-text .pp-eyebrow{margin-bottom:var(--pp-sp-16)}
  .pp-pkg-text h2{margin-bottom:var(--pp-sp-16)}
  .pp-pkg-text>p{font-size:16px;color:var(--pp-ink-2);line-height:1.7;margin-bottom:var(--pp-sp-32)}
  .pp-pkg-feats{display:flex;flex-direction:column;gap:var(--pp-sp-16)}
  .pp-pkg-feat{display:grid;grid-template-columns:40px 1fr;gap:var(--pp-sp-16);align-items:start}
  .pp-pkg-icon{width:40px;height:40px;border:1px solid var(--pp-border);border-radius:var(--pp-r);background:var(--pp-surface);display:flex;align-items:center;justify-content:center;flex-shrink:0}
  .pp-pkg-icon svg{width:18px;height:18px;color:var(--pp-ink-3)}
  .pp-pkg-feat h4{font-size:15px;font-weight:500;margin-bottom:4px}
  .pp-pkg-feat p{font-size:14px;color:var(--pp-ink-2);line-height:1.6}
  .pp-pkg-img{background:var(--pp-surface-2);border:1px solid var(--pp-border);border-radius:var(--pp-r);aspect-ratio:4/3;overflow:hidden;display:flex;align-items:center;justify-content:center}
  .pp-pkg-img img{width:100%;height:100%;object-fit:cover;display:block}
  .pp-pkg-img svg{width:64px;height:64px;color:var(--pp-border-2)}
  @media(max-width:900px){.pp-pkg-grid{grid-template-columns:1fr;gap:var(--pp-sp-48)}.pp-pkg-img{order:-1}}
</style>
<section class="pp-section pp-pkg pp-pad">
  <div class="pp-container">
    <div class="pp-pkg-grid">
      <div class="pp-pkg-text pp-reveal">
        <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
        <?php if ( $s['intro'] ) : ?>
        <p><?php echo esc_html( $s['intro'] ); ?></p>
        <?php endif; ?>
        <div class="pp-pkg-feats">
          <?php foreach ( $s['features'] as $feat ) : ?>
          <div class="pp-pkg-feat">
            <div class="pp-pkg-icon">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
            </div>
            <div>
              <h4><?php echo esc_html( $feat['feat_title'] ); ?></h4>
              <p><?php echo esc_html( $feat['feat_body'] ); ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="pp-pkg-img pp-reveal" style="transition-delay:120ms">
        <?php if ( $img ) : ?>
        <img src="<?php echo $img; ?>" alt="<?php esc_attr_e( 'Packaging detail', 'pp-uk-elementor' ); ?>" loading="lazy">
        <?php else : ?>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="0.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
        <?php
    }
}
