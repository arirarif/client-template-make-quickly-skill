<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Newsletter extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_05_newsletter'; }
    public function get_title()      { return '05 — Newsletter'; }
    public function get_icon()       { return 'eicon-email-field'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'newsletter', 'signup', 'email', 'peptides' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_text', [
            'label' => 'Text',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Join the research club',
        ] );
        $this->add_control( 'copy', [
            'label'   => 'Copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => 'Get launch offers, restock alerts and useful lab handling guides without the clutter.',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_form', [
            'label' => 'Form',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'placeholder', [
            'label'   => 'Email placeholder',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Email address',
        ] );
        $this->add_control( 'btn_text', [
            'label'   => 'Button text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Sign up',
        ] );
        $this->add_control( 'action_url', [
            'label'       => 'Form action URL (optional)',
            'type'        => \Elementor\Controls_Manager::URL,
            'default'     => [ 'url' => '' ],
            'description' => 'Leave empty to disable submission. Point this at your Mailchimp / Klaviyo / custom endpoint.',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s      = $this->get_settings_for_display();
        $action = ! empty( $s['action_url']['url'] ) ? esc_url( $s['action_url']['url'] ) : '';
        ?>
<style>
  .pp-news-sec { padding: 0 20px 70px; }
  .pp-newsletter {
    background: var(--pp-gold);
    color: #000;
    border: var(--pp-border);
    border-radius: 46px;
    padding: 44px;
    box-shadow: var(--pp-shadow-lg);
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 30px;
    align-items: center;
  }
  .pp-newsletter h2 {
    color: #000;
    text-shadow: none;
  }
  .pp-newsletter p {
    margin: 12px 0 0;
    max-width: 640px;
    font: 800 20px var(--pp-f-body);
  }
  .pp-signup {
    display: flex;
    background: var(--pp-paper);
    border: var(--pp-border);
    border-radius: 18px;
    padding: 8px;
    box-shadow: var(--pp-shadow-md);
  }
  .pp-signup input {
    background: transparent;
    border: 0;
    outline: 0;
    padding: 0 14px;
    font: 800 16px var(--pp-f-body);
    width: 260px;
    color: #000;
  }
  .pp-signup button {
    border: 0;
    border-radius: 12px;
    background: #000;
    color: var(--pp-glow);
    padding: 14px 18px;
    font: 900 13px var(--pp-f-body);
    text-transform: uppercase;
    cursor: pointer;
  }
  @media (max-width: 980px) {
    .pp-newsletter { grid-template-columns: 1fr; }
  }
  @media (max-width: 620px) {
    .pp-signup { width: 100%; }
    .pp-signup input { width: 100%; min-width: 0; }
  }
</style>
<section class="pp-section pp-bg-vault pp-news-sec">
  <div class="pp-wrap">
    <div class="pp-newsletter">
      <div>
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
        <?php if ( $s['copy'] ) : ?><p><?php echo esc_html( $s['copy'] ); ?></p><?php endif; ?>
      </div>
      <form class="pp-signup"<?php echo $action ? ' method="post" action="' . $action . '"' : ' onsubmit="return false"'; ?>>
        <input type="email" name="email" placeholder="<?php echo esc_attr( $s['placeholder'] ); ?>" aria-label="<?php echo esc_attr( $s['placeholder'] ); ?>" required>
        <button type="submit"><?php echo esc_html( $s['btn_text'] ); ?></button>
      </form>
    </div>
  </div>
</section>
        <?php
    }
}
