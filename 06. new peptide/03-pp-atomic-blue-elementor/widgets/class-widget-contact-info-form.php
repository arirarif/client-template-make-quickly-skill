<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Contact_Info_Form extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_15_contact_info_form'; }
    public function get_title()      { return '15 — Contact Info & Form'; }
    public function get_icon()       { return 'eicon-form-horizontal'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'contact', 'form', 'info', 'address', 'peptides' ]; }

    protected function register_controls() {

        /* ── Info card ── */
        $this->start_controls_section( 'sec_info', [
            'label' => 'Left — info card',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'info_heading', [
            'label'   => 'Info heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Direct Lines',
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', [
            'label'   => 'Icon (emoji or short text)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '📍',
        ] );
        $rep->add_control( 'label', [
            'label'   => 'Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'UK Warehouse',
        ] );
        $rep->add_control( 'value', [
            'label'   => 'Value',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => 'United Kingdom · Address on request',
        ] );

        $this->add_control( 'rows', [
            'label'       => 'Info rows',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'icon' => '📍', 'label' => 'UK Warehouse',  'value' => 'United Kingdom · Address on request' ],
                [ 'icon' => '📧', 'label' => 'General',       'value' => 'hello@performancepeptidesuk.com' ],
                [ 'icon' => '🛒', 'label' => 'Bulk / Trade',  'value' => 'trade@performancepeptidesuk.com' ],
                [ 'icon' => '📦', 'label' => 'Order Status',  'value' => 'orders@performancepeptidesuk.com' ],
                [ 'icon' => '🕒', 'label' => 'Hours',         'value' => "Mon–Fri · 9 AM – 6 PM GMT\nSame-day dispatch cutoff: 3 PM" ],
            ],
            'title_field' => '{{{ icon }}} {{{ label }}}',
        ] );
        $this->end_controls_section();

        /* ── Form ── */
        $this->start_controls_section( 'sec_form', [
            'label' => 'Right — form',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'form_heading', [
            'label'   => 'Form heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Send a Message',
        ] );
        $this->add_control( 'shortcode', [
            'label'       => 'Form shortcode (CF7 / WPForms / Klaviyo / Fluent Forms)',
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'rows'        => 3,
            'default'     => '',
            'description' => 'Paste your form shortcode here. Leave empty to show the static placeholder form.',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-contact-info-form-section { padding: 0 20px 70px; }
  .pp-contact-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 32px;
    align-items: flex-start;
  }
  .pp-contact-info {
    background: var(--pp-panel);
    color: #000;
    border: var(--pp-border);
    border-radius: 36px;
    padding: 32px;
    box-shadow: var(--pp-shadow-xl);
  }
  .pp-contact-info h3,
  .pp-contact-form h3 {
    font: 900 28px var(--pp-f-body);
    text-transform: uppercase;
    margin: 0 0 18px;
  }
  .pp-info-row {
    display: flex;
    gap: 14px;
    padding: 14px 0;
    border-bottom: 2px dashed rgba(0,0,0,.15);
  }
  .pp-info-row:last-of-type { border-bottom: 0; }
  .pp-info-row .ico { font-size: 28px; line-height: 1; }
  .pp-info-row strong {
    display: block;
    font: 900 14px var(--pp-f-body);
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 2px;
  }
  .pp-info-row .val {
    font: 800 15px var(--pp-f-body);
    white-space: pre-line;
  }
  .pp-contact-form {
    background: var(--pp-paper);
    color: #000;
    border: var(--pp-border);
    border-radius: 36px;
    padding: 32px;
    box-shadow: var(--pp-shadow-xl);
  }
  .pp-contact-form .row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
  }
  .pp-contact-form .field {
    display: block;
    margin-bottom: 16px;
  }
  .pp-contact-form .field label {
    display: block;
    font: 900 12px var(--pp-f-body);
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-bottom: 6px;
  }
  .pp-contact-form .field input,
  .pp-contact-form .field textarea,
  .pp-contact-form .field select {
    width: 100%;
    border: var(--pp-border);
    border-radius: 14px;
    background: #fff;
    padding: 14px 16px;
    font: 800 16px var(--pp-f-body);
    color: #000;
    box-shadow: var(--pp-shadow-sm);
  }
  .pp-contact-form .field textarea { min-height: 140px; resize: vertical; }
  .pp-contact-form .pp-form-note {
    font: 800 12px var(--pp-f-body);
    opacity: .65;
    margin: 6px 0 16px;
  }
  @media (max-width: 980px) {
    .pp-contact-grid,
    .pp-contact-form .row-2 { grid-template-columns: 1fr; }
  }
</style>
<section class="pp-section pp-bg-vault pp-contact-info-form-section">
  <div class="pp-wrap">
    <div class="pp-contact-grid">

      <!-- INFO -->
      <aside class="pp-contact-info">
        <h3><?php echo esc_html( $s['info_heading'] ); ?></h3>
        <?php if ( ! empty( $s['rows'] ) ) : foreach ( $s['rows'] as $r ) : ?>
          <div class="pp-info-row">
            <span class="ico"><?php echo esc_html( $r['icon'] ); ?></span>
            <div>
              <strong><?php echo esc_html( $r['label'] ); ?></strong>
              <span class="val"><?php echo esc_html( $r['value'] ); ?></span>
            </div>
          </div>
        <?php endforeach; endif; ?>
      </aside>

      <!-- FORM -->
      <div class="pp-contact-form">
        <h3><?php echo esc_html( $s['form_heading'] ); ?></h3>
        <?php if ( ! empty( $s['shortcode'] ) ) : ?>
          <?php echo do_shortcode( $s['shortcode'] ); ?>
        <?php else : ?>
          <div class="row-2">
            <div class="field"><label>First Name</label><input type="text"></div>
            <div class="field"><label>Last Name</label><input type="text"></div>
          </div>
          <div class="row-2">
            <div class="field"><label>Email</label><input type="email"></div>
            <div class="field"><label>Subject</label>
              <select>
                <option>General Question</option>
                <option>Order Status</option>
                <option>Bulk / Wholesale</option>
                <option>Research Collaboration</option>
                <option>Press &amp; Media</option>
              </select>
            </div>
          </div>
          <div class="field"><label>Message</label><textarea placeholder="Tell us what you need…"></textarea></div>
          <p class="pp-form-note">⚠ Placeholder form. Paste a CF7 / WPForms shortcode in the widget settings to make it live.</p>
          <button type="button" class="pp-btn" style="width:100%;">Send Message →</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
        <?php
    }
}
