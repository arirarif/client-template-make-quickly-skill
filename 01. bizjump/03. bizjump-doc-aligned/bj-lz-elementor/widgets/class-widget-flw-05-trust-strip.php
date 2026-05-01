<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-05 — Trust Strip ("Since 1998... 3,000+ entrepreneurs")
 * Cream strip with single-line callout + sub tagline.
 */
class Widget_FLW_Trust_Strip extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_05_trust_strip'; }
    public function get_title()      { return 'FLW 05 — Trust Strip'; }
    public function get_icon()       { return 'eicon-info-circle'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'trust', 'since', 'flw' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'sec_content', [ 'label' => 'Content', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'main_text', [
            'label' => 'Main Text (HTML allowed — use <strong> for highlight)',
            'type'  => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Since 1998, BizJump small business experts have helped more than <strong>3,000+ entrepreneurs</strong> turn ideas into successful businesses.',
        ] );
        $this->add_control( 'sub_tag', [
            'label' => 'Sub Tagline', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Your journey starts here.',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s  = $this->get_settings_for_display();
        $id = 'bjlz-flw05-' . $this->get_id();
        ?>
        <style>
        #<?php echo esc_attr($id); ?>{font-family:'Inter','Plus Jakarta Sans',sans-serif}
        #<?php echo esc_attr($id); ?> .trust-strip{background:#F2EDE7;padding:48px 0;text-align:center;border-top:1px solid #EAE3DB;border-bottom:1px solid #EAE3DB}
        #<?php echo esc_attr($id); ?> .container{max-width:1160px;margin:0 auto;padding:0 24px}
        #<?php echo esc_attr($id); ?> .trust-strip p{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:clamp(17px,2.1vw,22px);font-weight:600;color:#1E293B;line-height:1.5;max-width:760px;margin:0 auto}
        #<?php echo esc_attr($id); ?> .trust-strip p strong{color:#EA580C;font-weight:800}
        #<?php echo esc_attr($id); ?> .trust-tag{display:block;margin-top:10px;font-size:14px;color:#64748B;font-weight:500}
        </style>

        <div id="<?php echo esc_attr($id); ?>">
          <div class="trust-strip">
            <div class="container">
              <p><?php echo wp_kses_post( $s['main_text'] ); ?><span class="trust-tag"><?php echo esc_html( $s['sub_tag'] ); ?></span></p>
            </div>
          </div>
        </div>
        <?php
    }
}
