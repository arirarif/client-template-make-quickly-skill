<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 01 — Announcement Bar
 * A slim navy bar at the top of the page with a promotional message and CTA link.
 */
class Widget_Announcement_Bar extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_01_announcement_bar'; }
    public function get_title()      { return '01 — Announcement Bar'; }
    public function get_icon()       { return 'eicon-alert'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'announcement', 'bar', 'promo', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => 'Bar Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'bar_text', [
            'label'   => 'Bar Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Limited Time: Free Registered Agent for 1 Year on Premium &amp; Enterprise plans —',
            'label_block' => true,
        ] );

        $this->add_control( 'bar_link_text', [
            'label'   => 'Link Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Start Now →',
        ] );

        $this->add_control( 'bar_link_url', [
            'label'   => 'Link URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/incorporate/' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s       = $this->get_settings_for_display();
        $lnk_url = ! empty( $s['bar_link_url']['url'] ) ? esc_url( $s['bar_link_url']['url'] ) : '#';
        $lnk_tgt = ! empty( $s['bar_link_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
<style>
.bjw01-bar {
  background: #0f2156;
  color: rgba(255,255,255,.88);
  text-align: center;
  padding: 10px 16px;
  font-family: 'Inter', sans-serif;
  font-size: 13.5px;
  font-weight: 500;
  line-height: 1.5;
}
.bjw01-bar strong {
  color: #fbbf24;
  font-weight: 700;
}
.bjw01-bar a {
  color: #f97316;
  font-weight: 700;
  text-decoration: none;
  margin-left: 6px;
  transition: opacity .2s;
}
.bjw01-bar a:hover { opacity: .8; text-decoration: underline; }

@media (max-width: 480px) {
  .bjw01-bar { font-size: 12px; padding: 8px 12px; }
}
</style>

<div class="bjw01-bar">
  <strong>🎉 <?php echo wp_kses_post( $s['bar_text'] ); ?></strong>
  <a href="<?php echo $lnk_url; ?>"<?php echo $lnk_tgt; ?>><?php echo esc_html( $s['bar_link_text'] ); ?></a>
</div>
        <?php
    }
}
