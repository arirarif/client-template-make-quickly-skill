<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 14 — Legacy
 * Dark navy full-width section with background image overlay, heading with highlighted em word, and paragraphs.
 */
class Widget_Legacy extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_14_legacy'; }
    public function get_title()      { return '14 — Legacy'; }
    public function get_icon()       { return 'eicon-parallax'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'legacy', 'hero', 'dark', 'vision', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => 'Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'bg_image', [
            'label'   => 'Background Image',
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=1600&auto=format&fit=crop&q=80' ],
            'description' => 'Dark photo used as overlay background. Image from Unsplash.',
        ] );

        $this->add_control( 'heading_line1', [
            'label'   => 'Heading Line 1',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Build something',
        ] );

        $this->add_control( 'heading_line2', [
            'label'   => 'Heading Line 2 (highlighted in gold)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'greater than yourself.',
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'paragraph', [
            'label'   => 'Paragraph',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Enter paragraph text here.',
            'rows'    => 3,
        ] );

        $this->add_control( 'paragraphs', [
            'label'       => 'Body Paragraphs',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'paragraph' => "Create a business that lasts beyond you \xe2\x80\x94 one that carries your vision, extends your influence, and builds lasting wealth for years to come. This is more than starting a company." ],
                [ 'paragraph' => "It\xe2\x80\x99s about creating a legacy that endures." ],
                [ 'paragraph' => "Welcome to BizJump. Let\xe2\x80\x99s build what lasts." ],
            ],
            'title_field' => 'Paragraph',
        ] );

        $this->add_control( 'since_text', [
            'label'   => '"Since" Callout Text',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "Since 1998, BizJump small business experts have helped more than 3,000+ entrepreneurs turn ideas into successful businesses.\nYour journey starts here.",
            'rows'    => 3,
        ] );

        $this->add_control( 'since_highlight', [
            'label'       => '"Since" highlight phrase (appears in orange)',
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => 'Since 1998,',
            'description' => 'This exact phrase will be wrapped in orange bold styling.',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s      = $this->get_settings_for_display();
        $bg_url = ! empty( $s['bg_image']['url'] ) ? esc_url( $s['bg_image']['url'] ) : '';
        $hl     = ! empty( $s['since_highlight'] ) ? $s['since_highlight'] : '';
        ?>
<style>
.bjw14-legacy {
  position: relative;
  overflow: hidden;
  font-family: 'Inter', sans-serif;
}
.bjw14-bg {
  position: absolute; inset: 0;
  background-size: cover; background-position: center;
  background-attachment: fixed;
}
.bjw14-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(10,20,60,.92) 0%, rgba(15,33,86,.85) 100%);
}
.bjw14-inner {
  position: relative; z-index: 1;
  max-width: 1120px; margin: 0 auto;
  padding: 96px 32px;
}
.bjw14-content { max-width: 700px; }
.bjw14-content h2 {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: clamp(36px, 5vw, 58px);
  font-weight: 800; color: #fff;
  line-height: 1.12; letter-spacing: -1px;
  margin-bottom: 24px;
}
.bjw14-content h2 em {
  font-style: normal;
  color: #fbbf24;
}
.bjw14-content p {
  font-size: 17px; color: rgba(255,255,255,.8);
  line-height: 1.8; margin-bottom: 16px;
}
.bjw14-since {
  margin-top: 32px;
  background: rgba(255,255,255,.06);
  border-left: 3px solid #f97316;
  border-radius: 0 8px 8px 0;
  padding: 18px 20px;
  font-size: 15px; color: rgba(255,255,255,.75);
  line-height: 1.7;
}
.bjw14-since strong { color: #f97316; font-style: normal; }
@media (max-width: 768px) {
  .bjw14-inner { padding: 64px 16px; }
  .bjw14-bg { background-attachment: scroll; }
}
</style>

<div class="bjw14-legacy">
  <?php if ( $bg_url ) : ?>
  <div class="bjw14-bg" style="background-image:url('<?php echo $bg_url; ?>')"></div>
  <?php endif; ?>
  <div class="bjw14-overlay"></div>
  <div class="bjw14-inner">
    <div class="bjw14-content">
      <h2>
        <?php echo esc_html( $s['heading_line1'] ); ?><br>
        <em><?php echo esc_html( $s['heading_line2'] ); ?></em>
      </h2>
      <?php foreach ( $s['paragraphs'] as $item ) : ?>
      <p><?php echo esc_html( $item['paragraph'] ); ?></p>
      <?php endforeach; ?>
      <?php if ( ! empty( $s['since_text'] ) ) :
          $since_raw = esc_html( $s['since_text'] );
          if ( $hl ) {
              $hl_safe = esc_html( $hl );
              $since_raw = str_replace( $hl_safe, '<strong>' . $hl_safe . '</strong>', $since_raw );
          }
      ?>
      <div class="bjw14-since"><?php echo nl2br( $since_raw ); ?></div>
      <?php endif; ?>
    </div>
  </div>
</div>
        <?php
    }
}
