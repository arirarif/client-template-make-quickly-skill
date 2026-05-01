<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-04 — Legacy Zone ("Build something greater than yourself")
 * Slate gradient with orange + indigo radial glows, centered headline + body + tagline.
 */
class Widget_FLW_Legacy extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_04_legacy'; }
    public function get_title()      { return 'FLW 04 — Legacy Zone'; }
    public function get_icon()       { return 'eicon-banner'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'legacy', 'cta', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_content', [ 'label' => 'Content', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'headline', [
            'label' => 'Headline', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Build something greater than yourself.',
        ] );
        $this->add_control( 'body', [
            'label' => 'Body (HTML)', 'type' => \Elementor\Controls_Manager::WYSIWYG,
            'default' => '<p>Create a business that lasts beyond you—one that carries your vision, extends your influence, and builds lasting wealth for years to come. This is more than starting a company.</p><p>It\'s about creating a legacy that endures.</p>',
        ] );
        $this->add_control( 'tagline', [ 'label' => 'Tagline', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Welcome to BizJump. Let\'s build what lasts.' ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s  = $this->get_settings_for_display();
        $id = 'bjlz-flw04-' . $this->get_id();
        ?>
        <style>
        #<?php echo esc_attr($id); ?>{font-family:'Inter','Plus Jakarta Sans',sans-serif}
        #<?php echo esc_attr($id); ?> .legacy-zone{background:linear-gradient(135deg,#0F172A 0%,#1E293B 100%);color:#fff;padding:96px 0;text-align:center;position:relative;overflow:hidden}
        #<?php echo esc_attr($id); ?> .legacy-zone::before{content:'';position:absolute;top:-30%;left:-20%;width:560px;height:560px;background:radial-gradient(circle,rgba(249,115,22,.15) 0%,transparent 70%);border-radius:50%}
        #<?php echo esc_attr($id); ?> .legacy-zone::after{content:'';position:absolute;bottom:-30%;right:-15%;width:480px;height:480px;background:radial-gradient(circle,rgba(99,102,241,.12) 0%,transparent 70%);border-radius:50%}
        #<?php echo esc_attr($id); ?> .legacy-inner{position:relative;z-index:1;max-width:740px;margin:0 auto;padding:0 24px}
        #<?php echo esc_attr($id); ?> .legacy-headline{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:clamp(28px,4vw,46px);font-weight:800;line-height:1.15;letter-spacing:-.02em;color:#fff;margin-bottom:24px}
        #<?php echo esc_attr($id); ?> .legacy-body p{font-size:17px;color:rgba(255,255,255,.78);line-height:1.78;margin-bottom:18px}
        #<?php echo esc_attr($id); ?> .legacy-body p:last-child{margin-bottom:0}
        #<?php echo esc_attr($id); ?> .legacy-tag{display:inline-block;font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:18px;font-weight:700;color:#FB923C;margin-top:14px}
        </style>

        <div id="<?php echo esc_attr($id); ?>">
          <section class="legacy-zone">
            <div class="legacy-inner">
              <h2 class="legacy-headline"><?php echo esc_html( $s['headline'] ); ?></h2>
              <div class="legacy-body"><?php echo wp_kses_post( $s['body'] ); ?></div>
              <span class="legacy-tag"><?php echo esc_html( $s['tagline'] ); ?></span>
            </div>
          </section>
        </div>
        <?php
    }
}
