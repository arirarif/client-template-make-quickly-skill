<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Newsletter extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_09_newsletter'; }
    public function get_title()      { return '09 — Newsletter'; }
    public function get_icon()       { return 'eicon-email'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'newsletter', 'email', 'subscribe', 'pp-uk' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'section_content', [
            'label' => 'Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Stay Informed',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'New compounds. Restocks. Lab data.',
        ] );
        $this->add_control( 'body', [
            'label'   => 'Body',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'One short email when something changes. No marketing fluff, no daily blasts.',
            'rows'    => 3,
        ] );
        $this->add_control( 'placeholder', [
            'label'   => 'Input Placeholder',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'your@email.com',
        ] );
        $this->add_control( 'btn_text', [
            'label'   => 'Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Subscribe',
        ] );
        $this->add_control( 'form_action', [
            'label'       => 'Form Action URL',
            'type'        => \Elementor\Controls_Manager::URL,
            'description' => 'e.g. Mailchimp embed action URL. Leave blank to use demo handler.',
            'default'     => [ 'url' => '' ],
        ] );
        $this->add_control( 'note', [
            'label'   => 'Compliance Note',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'No spam · Unsubscribe anytime',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s          = $this->get_settings_for_display();
        $action     = ! empty( $s['form_action']['url'] ) ? esc_url( $s['form_action']['url'] ) : '#';
        $has_action = ! empty( $s['form_action']['url'] );
        ?>
<style>
  .pp-news{background:var(--pp-surface-2);border-top:1px solid var(--pp-border);border-bottom:1px solid var(--pp-border)}
  .pp-news-inner{max-width:720px;margin:0 auto;text-align:center}
  .pp-news-inner h2{margin-bottom:var(--pp-sp-16)}
  .pp-news-inner>p{font-size:16px;color:var(--pp-ink-2);margin-bottom:var(--pp-sp-32)}
  .pp-news-form{display:flex;gap:var(--pp-sp-8);max-width:480px;margin:0 auto}
  .pp-news-input{flex:1;padding:14px 16px;font-family:var(--pp-f-sans);font-size:14px;background:var(--pp-surface);border:1px solid var(--pp-border);border-radius:var(--pp-r);color:var(--pp-ink);outline:none;transition:border-color 150ms var(--pp-ease)}
  .pp-news-input:focus{border-color:var(--pp-ink)}
  .pp-news-input::placeholder{color:var(--pp-ink-4)}
  .pp-news-btn{padding:14px 24px;background:var(--pp-ink);color:var(--pp-bg);font-family:var(--pp-f-sans);font-size:14px;font-weight:500;border:none;border-radius:var(--pp-r);cursor:pointer;white-space:nowrap;transition:opacity 150ms}
  .pp-news-btn:hover{opacity:.88}
  .pp-news-note{font-family:var(--pp-f-mono);font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:var(--pp-ink-3);margin-top:var(--pp-sp-16)}
  @media(max-width:560px){.pp-news-form{flex-direction:column}.pp-news-inner>p{font-size:15px;margin-bottom:var(--pp-sp-24)}}
  @media(max-width:900px){.pp-news-inner h2{font-size:26px}}
</style>
<section class="pp-section pp-news pp-pad" id="newsletter">
  <div class="pp-container">
    <div class="pp-news-inner pp-reveal">
      <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
      <h2><?php echo esc_html( $s['heading'] ); ?></h2>
      <p><?php echo esc_html( $s['body'] ); ?></p>
      <form class="pp-news-form" action="<?php echo $action; ?>" method="POST"<?php if ( ! $has_action ) echo ' onsubmit="return false"'; ?>>
        <?php if ( $has_action ) : ?>
        <?php wp_nonce_field( 'ppuk_newsletter', 'ppuk_news_nonce' ); ?>
        <?php endif; ?>
        <input class="pp-news-input" type="email" name="email" placeholder="<?php echo esc_attr( $s['placeholder'] ); ?>" required autocomplete="email" aria-label="<?php esc_attr_e( 'Email address', 'pp-uk-elementor' ); ?>">
        <button class="pp-news-btn" type="submit"><?php echo esc_html( $s['btn_text'] ); ?></button>
      </form>
      <p class="pp-news-note"><?php echo esc_html( $s['note'] ); ?></p>
    </div>
  </div>
</section>
        <?php
    }
}
