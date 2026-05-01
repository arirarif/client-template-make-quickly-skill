<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DLW-09 — Footer (Demo Landing)
 * 4-col dark footer with brand block + 3 link columns + copyright/legal row.
 */
class Widget_DLW_Footer extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dlw_09_footer'; }
    public function get_title()      { return 'DLW 09 — Footer'; }
    public function get_icon()       { return 'eicon-footer'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'footer', 'links', 'bizjump', 'dlw' ]; }

    protected function register_controls() {

        /* ── Brand ── */
        $this->start_controls_section( 'sec_brand', [
            'label' => 'Brand', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'logo_text_1', [ 'label' => 'Logo Text Part 1', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Biz' ] );
        $this->add_control( 'logo_text_2', [ 'label' => 'Logo Text Part 2 (orange)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Jump' ] );
        $this->add_control( 'tagline', [
            'label' => 'Tagline', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'America\'s trusted business formation service. We make starting a business fast, simple, and affordable.',
        ] );
        $this->end_controls_section();

        /* ── Columns ── */
        for ( $col = 1; $col <= 3; $col++ ) {
            $this->start_controls_section( "sec_col_{$col}", [
                'label' => "Column {$col}", 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ] );
            $defaults = [
                1 => [ 'heading' => 'Services',  'links' => [
                    [ 'label' => 'Form an LLC',         'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'Form a Corporation', 'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'Registered Agent',   'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'EIN Filing',         'url' => [ 'url' => '#' ] ],
                ] ],
                2 => [ 'heading' => 'Resources', 'links' => [
                    [ 'label' => 'Business Name Search', 'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'State Requirements',   'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'Business Guide',       'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'FAQ',                  'url' => [ 'url' => '#' ] ],
                ] ],
                3 => [ 'heading' => 'Company',   'links' => [
                    [ 'label' => 'About Us',          'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'Customer Reviews',  'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'Contact',           'url' => [ 'url' => '#' ] ],
                    [ 'label' => 'Affiliate Program', 'url' => [ 'url' => '#' ] ],
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

        /* ── Bottom ── */
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
                [ 'label' => 'Cookie Policy',    'url' => [ 'url' => '#' ] ],
            ],
            'title_field' => '{{{ label }}}',
        ] );
        $this->end_controls_section();
    }

    private function render_col( $heading, $links ) {
        ?>
        <div class="dlw09-col">
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
.dlw09-footer { background: #0F172A; padding: 64px 0 32px; font-family: 'Inter', sans-serif; }
.dlw09-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.dlw09-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 48px; }
.dlw09-brand .dlw09-logo { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: 20px; font-weight: 800; color: #fff; display: flex; align-items: center; gap: 8px; margin-bottom: 14px; }
.dlw09-brand .dlw09-logo span { color: #F97316; }
.dlw09-brand p { font-size: 14px; color: #94A3B8; line-height: 1.65; max-width: 260px; }
.dlw09-col h4 { font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #94A3B8; margin: 0 0 16px; }
.dlw09-col ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; }
.dlw09-col a { font-size: 14px; color: #64748B; text-decoration: none; transition: color .15s; }
.dlw09-col a:hover { color: #E2E8F0; }
.dlw09-bottom { border-top: 1px solid #1E293B; padding-top: 28px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
.dlw09-copy { font-size: 13px; color: #64748B; }
.dlw09-legal { display: flex; gap: 20px; }
.dlw09-legal a { font-size: 13px; color: #64748B; text-decoration: none; transition: color .15s; }
.dlw09-legal a:hover { color: #CBD5E1; }

@media (max-width: 900px) {
  .dlw09-grid { grid-template-columns: 1fr 1fr; gap: 32px 24px; }
  .dlw09-brand { grid-column: 1 / -1; }
}
@media (max-width: 520px) {
  .dlw09-footer { padding: 48px 0 28px; }
  .dlw09-grid { grid-template-columns: 1fr; gap: 28px; margin-bottom: 32px; }
  .dlw09-bottom { flex-direction: column; align-items: flex-start; gap: 12px; }
  .dlw09-legal { flex-wrap: wrap; gap: 14px; }
}
</style>

<footer class="dlw09-footer">
  <div class="dlw09-inner">

    <div class="dlw09-grid">
      <div class="dlw09-brand">
        <div class="dlw09-logo"><?php echo esc_html( $s['logo_text_1'] ); ?><span><?php echo esc_html( $s['logo_text_2'] ); ?></span></div>
        <p><?php echo esc_html( $s['tagline'] ); ?></p>
      </div>
      <?php $this->render_col( $s['col1_heading'], $s['col1_links'] ); ?>
      <?php $this->render_col( $s['col2_heading'], $s['col2_links'] ); ?>
      <?php $this->render_col( $s['col3_heading'], $s['col3_links'] ); ?>
    </div>

    <div class="dlw09-bottom">
      <span class="dlw09-copy"><?php echo esc_html( $s['copyright'] ); ?></span>
      <div class="dlw09-legal">
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
