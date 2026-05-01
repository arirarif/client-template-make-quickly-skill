<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Categories extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_04_categories'; }
    public function get_title()      { return '04 — Categories'; }
    public function get_icon()       { return 'eicon-tags'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'categories', 'catalog', 'grid', 'pp-uk' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Browse by Category',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Six research areas. Thirty-two compounds.',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'section_cats', [
            'label' => 'Categories',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'count', [ 'label' => 'Count Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '07 COMPOUNDS' ] );
        $rep->add_control( 'name',  [ 'label' => 'Name',        'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Category' ] );
        $rep->add_control( 'url',   [ 'label' => 'URL',         'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '#' ] ] );
        $this->add_control( 'categories', [
            'label'       => 'Categories',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'count' => '07 COMPOUNDS', 'name' => 'Tissue & Repair',        'url' => [ 'url' => '#' ] ],
                [ 'count' => '06 COMPOUNDS', 'name' => 'GH Peptides',             'url' => [ 'url' => '#' ] ],
                [ 'count' => '05 COMPOUNDS', 'name' => 'Metabolic',               'url' => [ 'url' => '#' ] ],
                [ 'count' => '05 COMPOUNDS', 'name' => 'Longevity',               'url' => [ 'url' => '#' ] ],
                [ 'count' => '04 COMPOUNDS', 'name' => 'Cognitive',               'url' => [ 'url' => '#' ] ],
                [ 'count' => '05 COMPOUNDS', 'name' => 'Immune & Melanocortin',   'url' => [ 'url' => '#' ] ],
            ],
            'title_field' => '{{{ name }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-cats{background:var(--pp-bg)}
  .pp-cat-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:var(--pp-sp-12)}
  .pp-cat{display:flex;flex-direction:column;justify-content:space-between;padding:var(--pp-sp-32);min-height:180px;background:var(--pp-surface);border:1px solid var(--pp-border);border-radius:var(--pp-r);transition:border-color 150ms var(--pp-ease),background 150ms var(--pp-ease),color 150ms var(--pp-ease);cursor:pointer;text-decoration:none;color:inherit}
  .pp-cat:hover{border-color:var(--pp-ink);background:var(--pp-ink);color:var(--pp-bg)}
  .pp-cat-top{display:flex;justify-content:space-between;align-items:flex-start}
  .pp-cat-count{font-family:var(--pp-f-mono);font-size:11px;letter-spacing:.1em;color:var(--pp-ink-3);text-transform:uppercase;transition:color 150ms var(--pp-ease)}
  .pp-cat:hover .pp-cat-count{color:var(--pp-bg)}
  .pp-cat-arr{width:24px;height:24px;display:inline-flex;align-items:center;justify-content:center;color:var(--pp-ink-3);font-size:16px;transition:color 150ms var(--pp-ease),transform 200ms var(--pp-ease)}
  .pp-cat:hover .pp-cat-arr{color:var(--pp-bg);transform:translate(2px,-2px)}
  .pp-cat h3{font-size:22px;font-weight:500;letter-spacing:-.015em;margin-top:var(--pp-sp-48)}
  @media(max-width:900px){.pp-cat-grid{grid-template-columns:repeat(2,1fr)}.pp-cat{padding:var(--pp-sp-24);min-height:150px}.pp-cat h3{font-size:19px;margin-top:var(--pp-sp-32)}}
  @media(max-width:560px){.pp-cat-grid{grid-template-columns:1fr}.pp-cat{min-height:130px;padding:20px}.pp-cat h3{font-size:18px;margin-top:var(--pp-sp-24)}}
  @media(hover:none){.pp-cat:hover{background:var(--pp-surface);color:inherit;border-color:var(--pp-border)}.pp-cat:hover .pp-cat-count,.pp-cat:hover .pp-cat-arr{color:var(--pp-ink-3)}}
</style>
<section class="pp-section pp-cats pp-pad" id="categories">
  <div class="pp-container">
    <div class="pp-section-head pp-reveal">
      <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
      <h2><?php echo esc_html( $s['heading'] ); ?></h2>
    </div>
    <div class="pp-cat-grid">
      <?php foreach ( $s['categories'] as $cat ) :
        $url = ! empty( $cat['url']['url'] ) ? esc_url( $cat['url']['url'] ) : '#';
        $tgt = ! empty( $cat['url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
      ?>
      <a href="<?php echo $url; ?>"<?php echo $tgt; ?> class="pp-cat pp-reveal">
        <div class="pp-cat-top">
          <span class="pp-cat-count"><?php echo esc_html( $cat['count'] ); ?></span>
          <span class="pp-cat-arr" aria-hidden="true">↗</span>
        </div>
        <h3><?php echo esc_html( $cat['name'] ); ?></h3>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
