<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 23 — Shipping: Policies
 * Mono-label / body policy rows — dispatch times, tracking, lost parcels, damaged goods.
 */
class Widget_Shipping_Policies extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_23_shipping_policies'; }
    public function get_title()      { return '23 — Shipping: Policies'; }
    public function get_icon()       { return 'eicon-text-align-left'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'shipping', 'policies', 'rules', 'pp-uk' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Policies',
        ] );

        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Shipping policies.',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_policies', [
            'label' => 'Policy Rows',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'label', [ 'label' => 'Label (mono)',  'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Dispatch times' ] );
        $rep->add_control( 'title', [ 'label' => 'Row Title',     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Policy heading' ] );
        $rep->add_control( 'body',  [ 'label' => 'Row Body',      'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Policy description.', 'rows' => 5 ] );

        $this->add_control( 'policies', [
            'label'       => 'Policies',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'label' => 'Dispatch times',
                    'title' => 'Orders dispatched within 1–2 business days',
                    'body'  => 'All orders are processed and dispatched Monday to Friday. Orders placed after 1pm or on weekends/bank holidays are processed the next business day. Express orders placed before 1pm are given dispatch priority.',
                ],
                [
                    'label' => 'Tracking',
                    'title' => 'Full tracking on every order',
                    'body'  => 'A tracking number is emailed to you as soon as your order is dispatched. Express and Saturday delivery orders also receive SMS notifications at key milestones. If you have not received a tracking email within 2 business days of ordering, check your spam folder and contact us.',
                ],
                [
                    'label' => 'Lost parcels',
                    'title' => 'We cover lost parcels',
                    'body'  => 'If your tracking shows no movement for more than 48 hours, or your parcel has not arrived within 5 business days of dispatch, contact us with your order number. We will investigate with the carrier and reship or issue a full refund if the parcel is confirmed lost.',
                ],
                [
                    'label' => 'Damaged goods',
                    'title' => 'Damaged on arrival',
                    'body'  => 'If any product arrives visibly damaged, photograph the packaging and the affected item before opening and contact us within 48 hours of delivery. Do not use a damaged product. We will issue a replacement or full refund promptly upon verification.',
                ],
            ],
            'title_field' => '{{{ label }}} — {{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-ship-pol{background:var(--pp-bg)}
  .pp-ship-pol-head{max-width:640px;margin-bottom:var(--pp-sp-48)}
  .pp-ship-pol-head h2{margin-top:var(--pp-sp-16)}
  .pp-pol-list{border-top:1px solid var(--pp-border)}
  .pp-pol-row{display:grid;grid-template-columns:280px 1fr;gap:var(--pp-sp-48);padding:var(--pp-sp-32) 0;border-bottom:1px solid var(--pp-border);align-items:start}
  .pp-pol-label{font-family:var(--pp-f-mono);font-size:12px;font-weight:500;letter-spacing:.1em;text-transform:uppercase;color:var(--pp-ink-3);padding-top:4px}
  .pp-pol-body h4{font-size:16px;font-weight:500;margin-bottom:var(--pp-sp-8)}
  .pp-pol-body p{font-size:15px;color:var(--pp-ink-2);line-height:1.7}
  @media(max-width:768px){.pp-pol-row{grid-template-columns:1fr;gap:var(--pp-sp-12)}}
</style>
<section class="pp-section pp-ship-pol pp-pad">
  <div class="pp-container">
    <div class="pp-ship-pol-head pp-reveal">
      <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
      <h2><?php echo esc_html( $s['heading'] ); ?></h2>
    </div>
    <div class="pp-pol-list">
      <?php foreach ( $s['policies'] as $i => $pol ) : ?>
      <div class="pp-pol-row pp-reveal" style="transition-delay:<?php echo $i * 60; ?>ms">
        <div class="pp-pol-label"><?php echo esc_html( $pol['label'] ); ?></div>
        <div class="pp-pol-body">
          <h4><?php echo esc_html( $pol['title'] ); ?></h4>
          <p><?php echo esc_html( $pol['body'] ); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
