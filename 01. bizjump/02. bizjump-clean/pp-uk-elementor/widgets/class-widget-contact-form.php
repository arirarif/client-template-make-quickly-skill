<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 18 — Contact Form
 * 2-column layout: enquiry form left, sidebar right.
 * The form shell can be replaced with a Contact Form 7 shortcode via the control.
 */
class Widget_Contact_Form extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_18_contact_form'; }
    public function get_title()      { return '18 — Contact Form'; }
    public function get_icon()       { return 'eicon-form-horizontal'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'contact', 'form', 'enquiry', 'pp-uk' ]; }

    protected function register_controls() {

        /* ── Form ── */
        $this->start_controls_section( 'section_form', [
            'label' => 'Form',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'cf7_shortcode', [
            'label'       => 'Contact Form 7 Shortcode',
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'description' => 'Paste your CF7 shortcode here, e.g. [contact-form-7 id="123"]. Leave blank to use the built-in demo form.',
            'default'     => '',
            'rows'        => 2,
        ] );

        $this->add_control( 'form_heading', [
            'label'   => 'Form Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Send an enquiry',
        ] );

        $this->add_control( 'btn_label', [
            'label'   => 'Submit Button Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Send Message',
        ] );

        $this->end_controls_section();

        /* ── Sidebar ── */
        $this->start_controls_section( 'section_sidebar', [
            'label' => 'Sidebar',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'response_heading', [
            'label'   => 'Response Times Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Response Times',
        ] );

        $rep_rt = new \Elementor\Repeater();
        $rep_rt->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'General enquiries' ] );
        $rep_rt->add_control( 'value', [ 'label' => 'Value', 'type' => \Elementor\Controls_Manager::TEXT,     'default' => '< 1 business day' ] );

        $this->add_control( 'response_times', [
            'label'       => 'Response Time Rows',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep_rt->get_controls(),
            'default'     => [
                [ 'label' => 'General enquiries',    'value' => '< 1 business day' ],
                [ 'label' => 'Order queries',         'value' => '< 4 hours (Mon–Fri)' ],
                [ 'label' => 'Lab report requests',  'value' => '1–2 business days' ],
                [ 'label' => 'Bulk / trade orders',  'value' => '2–3 business days' ],
            ],
            'title_field' => '{{{ label }}}',
        ] );

        $this->add_control( 'direct_email', [
            'label'   => 'Direct Email',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'hello@performancepeptideuk.com',
        ] );

        $this->add_control( 'notice_text', [
            'label'   => 'Notice Text',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'We do not provide dosing advice, medical guidance, or personalised research recommendations. All enquiries must relate to legitimate research purposes.',
            'rows'    => 4,
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s          = $this->get_settings_for_display();
        $has_cf7    = ! empty( trim( $s['cf7_shortcode'] ) );
        $widget_id  = $this->get_id();
        ?>
<style>
  .pp-contact{background:var(--pp-bg)}
  .pp-contact-grid{display:grid;grid-template-columns:1fr 380px;gap:var(--pp-sp-64);align-items:start}
  .pp-contact-form-wrap{background:var(--pp-surface);border:1px solid var(--pp-border);border-radius:var(--pp-r-lg);padding:var(--pp-sp-32)}
  .pp-contact-form-wrap h3{margin-bottom:var(--pp-sp-24)}
  .pp-cf-field{display:flex;flex-direction:column;gap:var(--pp-sp-8);margin-bottom:var(--pp-sp-20)}
  .pp-cf-field label{font-size:14px;font-weight:500;color:var(--pp-ink)}
  .pp-cf-field label span{color:var(--pp-err)}
  .pp-cf-input,.pp-cf-select,.pp-cf-textarea{width:100%;padding:12px 14px;font-family:var(--pp-f-sans);font-size:14px;background:var(--pp-bg);border:1px solid var(--pp-border);border-radius:var(--pp-r);color:var(--pp-ink);outline:none;transition:border-color 150ms var(--pp-ease)}
  .pp-cf-input:focus,.pp-cf-select:focus,.pp-cf-textarea:focus{border-color:var(--pp-ink)}
  .pp-cf-textarea{min-height:120px;resize:vertical}
  .pp-cf-select{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23787874' stroke-width='1.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;background-size:16px;padding-right:36px;cursor:pointer}
  .pp-cf-checkbox-row{display:flex;align-items:flex-start;gap:var(--pp-sp-12);padding:var(--pp-sp-16);background:var(--pp-surface-2);border:1px solid var(--pp-border);border-radius:var(--pp-r);margin-bottom:var(--pp-sp-24)}
  .pp-cf-checkbox-row input[type=checkbox]{margin-top:2px;width:16px;height:16px;flex-shrink:0;accent-color:var(--pp-ink)}
  .pp-cf-checkbox-row label{font-size:13px;color:var(--pp-ink-2);line-height:1.5}
  .pp-cf-success{display:none;text-align:center;padding:var(--pp-sp-32) 0}
  .pp-cf-success svg{width:40px;height:40px;color:var(--pp-ok);margin:0 auto var(--pp-sp-16)}
  .pp-cf-success h4{font-size:18px;margin-bottom:var(--pp-sp-8)}
  .pp-cf-success p{font-size:14px;color:var(--pp-ink-2)}
  /* Sidebar */
  .pp-contact-sidebar{display:flex;flex-direction:column;gap:var(--pp-sp-16)}
  .pp-contact-card{background:var(--pp-surface);border:1px solid var(--pp-border);border-radius:var(--pp-r-lg);padding:var(--pp-sp-24)}
  .pp-contact-card h4{font-size:15px;font-weight:500;margin-bottom:var(--pp-sp-16)}
  .pp-info-row{display:grid;grid-template-columns:1fr auto;gap:var(--pp-sp-12);padding:var(--pp-sp-12) 0;border-bottom:1px solid var(--pp-border);align-items:center}
  .pp-info-row:last-child{border-bottom:none}
  .pp-info-label{font-size:13px;color:var(--pp-ink-2)}
  .pp-info-value{font-family:var(--pp-f-mono);font-size:12px;letter-spacing:.06em;color:var(--pp-ink);text-align:right}
  .pp-contact-notice{background:var(--pp-accent-2);border:1px solid rgba(30,58,95,.1);border-radius:var(--pp-r);padding:var(--pp-sp-16)}
  .pp-contact-notice p{font-size:13px;color:var(--pp-accent);line-height:1.6}
  @media(max-width:900px){.pp-contact-grid{grid-template-columns:1fr}.pp-contact-sidebar{order:-1}}
  .pp-cf-name-row{display:grid;grid-template-columns:1fr 1fr;gap:var(--pp-sp-16)}
  @media(max-width:560px){.pp-cf-name-row{grid-template-columns:1fr}}
</style>
<section class="pp-section pp-contact pp-pad">
  <div class="pp-container">
    <div class="pp-contact-grid">

      <!-- FORM -->
      <div class="pp-contact-form-wrap pp-reveal">
        <?php if ( $has_cf7 ) : ?>
          <h3><?php echo esc_html( $s['form_heading'] ); ?></h3>
          <?php echo do_shortcode( wp_kses_post( $s['cf7_shortcode'] ) ); ?>
        <?php else : ?>
          <h3><?php echo esc_html( $s['form_heading'] ); ?></h3>
          <div id="ppCfSuccess-<?php echo esc_attr( $widget_id ); ?>" class="pp-cf-success" aria-live="polite">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <h4>Message sent</h4>
            <p>We'll be in touch within one business day.</p>
          </div>
          <form id="ppCf-<?php echo esc_attr( $widget_id ); ?>" novalidate>
            <?php wp_nonce_field( 'ppuk_contact', 'ppuk_contact_nonce' ); ?>
            <div class="pp-cf-name-row">
              <div class="pp-cf-field">
                <label for="ppName-<?php echo esc_attr( $widget_id ); ?>">Name <span aria-hidden="true">*</span></label>
                <input class="pp-cf-input" id="ppName-<?php echo esc_attr( $widget_id ); ?>" type="text" name="name" autocomplete="name" required>
              </div>
              <div class="pp-cf-field">
                <label for="ppEmail-<?php echo esc_attr( $widget_id ); ?>">Email <span aria-hidden="true">*</span></label>
                <input class="pp-cf-input" id="ppEmail-<?php echo esc_attr( $widget_id ); ?>" type="email" name="email" autocomplete="email" required>
              </div>
            </div>
            <div class="pp-cf-field">
              <label for="ppSubject-<?php echo esc_attr( $widget_id ); ?>">Enquiry Type <span aria-hidden="true">*</span></label>
              <select class="pp-cf-select" id="ppSubject-<?php echo esc_attr( $widget_id ); ?>" name="subject" required>
                <option value="" disabled selected>Select a topic…</option>
                <option value="order">Order or delivery query</option>
                <option value="product">Product or stock enquiry</option>
                <option value="labs">Lab reports / COA request</option>
                <option value="bulk">Bulk or trade pricing</option>
                <option value="returns">Returns or refund</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="pp-cf-field">
              <label for="ppMsg-<?php echo esc_attr( $widget_id ); ?>">Message <span aria-hidden="true">*</span></label>
              <textarea class="pp-cf-textarea" id="ppMsg-<?php echo esc_attr( $widget_id ); ?>" name="message" required></textarea>
            </div>
            <div class="pp-cf-checkbox-row">
              <input type="checkbox" id="ppResearch-<?php echo esc_attr( $widget_id ); ?>" name="research_confirm" required>
              <label for="ppResearch-<?php echo esc_attr( $widget_id ); ?>">I confirm this enquiry is for legitimate research purposes and I am aged 18 or over.</label>
            </div>
            <button type="submit" class="pp-btn pp-btn-primary pp-btn-blk"><?php echo esc_html( $s['btn_label'] ); ?></button>
          </form>
          <script>
          (function(){
            var form = document.getElementById('ppCf-<?php echo esc_js( $widget_id ); ?>');
            var success = document.getElementById('ppCfSuccess-<?php echo esc_js( $widget_id ); ?>');
            if (!form) return;
            form.addEventListener('submit', function(e){
              e.preventDefault();
              form.style.display = 'none';
              success.style.display = 'block';
            });
          })();
          </script>
        <?php endif; ?>
      </div>

      <!-- SIDEBAR -->
      <div class="pp-contact-sidebar pp-reveal" style="transition-delay:120ms">
        <div class="pp-contact-card">
          <h4><?php echo esc_html( $s['response_heading'] ); ?></h4>
          <?php foreach ( $s['response_times'] as $rt ) : ?>
          <div class="pp-info-row">
            <span class="pp-info-label"><?php echo esc_html( $rt['label'] ); ?></span>
            <span class="pp-info-value"><?php echo esc_html( $rt['value'] ); ?></span>
          </div>
          <?php endforeach; ?>
        </div>
        <?php if ( $s['direct_email'] ) : ?>
        <div class="pp-contact-card">
          <h4>Direct Contact</h4>
          <a href="mailto:<?php echo sanitize_email( $s['direct_email'] ); ?>" style="font-family:var(--pp-f-mono);font-size:13px;color:var(--pp-ink)"><?php echo esc_html( $s['direct_email'] ); ?></a>
        </div>
        <?php endif; ?>
        <?php if ( $s['notice_text'] ) : ?>
        <div class="pp-contact-notice">
          <p><?php echo esc_html( $s['notice_text'] ); ?></p>
        </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>
        <?php
    }
}
