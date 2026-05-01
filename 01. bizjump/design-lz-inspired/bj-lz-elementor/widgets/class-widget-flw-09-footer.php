<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-09 — Footer (Formation Landing)
 * Same shape as DLW-09 but with formation-page link defaults.
 */
class Widget_FLW_Footer extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_09_footer'; }
    public function get_title()      { return 'FLW 09 — Footer'; }
    public function get_icon()       { return 'eicon-footer'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'footer', 'links', 'bizjump', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_brand', [
            'label' => 'Brand', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'logo_text_1', [ 'label' => 'Logo Part 1', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Biz' ] );
        $this->add_control( 'logo_text_2', [ 'label' => 'Logo Part 2 (orange)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Jump' ] );
        $this->add_control( 'tagline', [
            'label' => 'Tagline', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'America\'s trusted business formation service. Fast, simple, and affordable — for entrepreneurs who mean business.',
        ] );
        $this->end_controls_section();

        for ( $col = 1; $col <= 3; $col++ ) {
            $this->start_controls_section( "sec_col_{$col}", [
                'label' => "Column {$col}", 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ] );
            $defaults = [
                1 => [ 'heading' => 'Form a Business', 'links' => [
                    [ 'label' => 'Form an LLC',    'url' => [ 'url' => '/start/?entity=llc' ] ],
                    [ 'label' => 'C Corporation', 'url' => [ 'url' => '/start/?entity=ccorp' ] ],
                    [ 'label' => 'S Corporation', 'url' => [ 'url' => '/start/?entity=scorp' ] ],
                    [ 'label' => 'Nonprofit',     'url' => [ 'url' => '/start/?entity=nonprofit' ] ],
                ] ],
                2 => [ 'heading' => 'Resources', 'links' => [
                    [ 'label' => 'LLC vs Corporation',  'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'State Requirements',  'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'Business Name Search','url' => [ 'url' => '#' ] ],
                    [ 'label' => 'FAQ',                  'url' => [ 'url' => '#' ] ],
                ] ],
                3 => [ 'heading' => 'Company', 'links' => [
                    [ 'label' => 'About BizJump',   'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'Customer Reviews','url' => [ 'url' => '#' ] ],
                    [ 'label' => 'Contact Us',      'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'Affiliate Program','url' => [ 'url' => '#' ] ],
                ] ],
            ];
            $this->add_control( "col{$col}_heading", [
                'label' => 'Heading', 'type' => \Elementor\Controls_Manager::TEXT,
                'default' => $defaults[ $col ]['heading'],
            ] );
            $rep = new \Elementor\Repeater();
            $rep->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Link' ] );
            $rep->add_control( 'url',   [ 'label' => 'URL',   'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '#' ] ] );
            $this->add_control( "col{$col}_links", [
                'label' => 'Links', 'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $rep->get_controls(),
                'default' => $defaults[ $col ]['links'],
                'title_field' => '{{{ label }}}',
            ] );
            $this->end_controls_section();
        }

        $this->start_controls_section( 'sec_bottom', [
            'label' => 'Bottom Row', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'copyright', [
            'label' => 'Copyright', 'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '© 2026 BizJump Inc. All rights reserved.',
        ] );
        $rep2 = new \Elementor\Repeater();
        $rep2->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Privacy Policy' ] );
        $rep2->add_control( 'url',   [ 'label' => 'URL',   'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '#' ] ] );
        $this->add_control( 'legal_links', [
            'label' => 'Legal Links', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $rep2->get_controls(),
            'default' => [
                [ 'label' => 'Privacy Policy',   'url' => [ 'url' => '#' ] ],
                [ 'label' => 'Terms of Service', 'url' => [ 'url' => '#' ] ],
                [ 'label' => 'Disclaimer',       'url' => [ 'url' => '#' ] ],
            ],
            'title_field' => '{{{ label }}}',
        ] );
        $this->end_controls_section();
    }

    private function render_col( $heading, $links ) {
        ?>
        <div class="flw09-col">
          <h4><?php echo esc_html( $heading ); ?></h4>
          <ul>
            <?php foreach ( (array) $links as $l ) :
              $u = ! empty( $l['url']['url'] ) ? esc_url( $l['url']['url'] ) : '#';
              $t = ! empty( $l['url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
            ?>
            <li><a href="<?php echo $u; ?>"<?php echo $t; ?>><?php echo esc_html( $l['label'] ); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.flw09-footer { background: #0F172A; padding: 56px 0 28px; font-family: 'Inter', sans-serif; }
.flw09-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.flw09-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 36px; margin-bottom: 40px; }
.flw09-brand .flw09-logo { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 12px; display: inline-block; }
.flw09-brand .flw09-logo em { font-style: normal; color: #F97316; }
.flw09-brand p { font-size: 13px; color: #64748B; line-height: 1.65; max-width: 240px; }
.flw09-col h4 { font-size: 11px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #64748B; margin: 0 0 14px; }
.flw09-col ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 9px; }
.flw09-col a { font-size: 13px; color: #64748B; text-decoration: none; transition: color .15s; }
.flw09-col a:hover { color: #E2E8F0; }
.flw09-bottom { border-top: 1px solid #1E293B; padding-top: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
.flw09-copy { font-size: 12px; color: #475569; }
.flw09-legal { display: flex; gap: 16px; }
.flw09-legal a { font-size: 12px; color: #475569; text-decoration: none; transition: color .15s; }
.flw09-legal a:hover { color: #CBD5E1; }

@media (max-width: 900px) {
  .flw09-grid { grid-template-columns: 1fr 1fr; gap: 28px 20px; }
  .flw09-brand { grid-column: 1 / -1; }
}
@media (max-width: 520px) {
  .flw09-footer { padding: 44px 0 24px; }
  .flw09-grid { grid-template-columns: 1fr; gap: 24px; margin-bottom: 28px; }
  .flw09-bottom { flex-direction: column; align-items: flex-start; gap: 10px; }
  .flw09-legal { flex-wrap: wrap; gap: 12px; }
}
</style>

<footer class="flw09-footer">
  <div class="flw09-inner">

    <div class="flw09-grid">
      <div class="flw09-brand">
        <div class="flw09-logo"><?php echo esc_html( $s['logo_text_1'] ); ?><em><?php echo esc_html( $s['logo_text_2'] ); ?></em></div>
        <p><?php echo esc_html( $s['tagline'] ); ?></p>
      </div>
      <?php $this->render_col( $s['col1_heading'], $s['col1_links'] ); ?>
      <?php $this->render_col( $s['col2_heading'], $s['col2_links'] ); ?>
      <?php $this->render_col( $s['col3_heading'], $s['col3_links'] ); ?>
    </div>

    <div class="flw09-bottom">
      <span class="flw09-copy"><?php echo esc_html( $s['copyright'] ); ?></span>
      <div class="flw09-legal">
        <?php foreach ( (array) $s['legal_links'] as $l ) :
          $u = ! empty( $l['url']['url'] ) ? esc_url( $l['url']['url'] ) : '#';
          $t = ! empty( $l['url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
        <a href="<?php echo $u; ?>"<?php echo $t; ?>><?php echo esc_html( $l['label'] ); ?></a>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</footer>
        <?php
    }
}
