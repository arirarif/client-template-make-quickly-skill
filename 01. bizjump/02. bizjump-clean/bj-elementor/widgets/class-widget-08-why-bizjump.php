<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 08 — Why BizJump
 * Two-column section: feature list (left) + competitor comparison table (right).
 */
class Widget_Why_BizJump extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_08_why'; }
    public function get_title()      { return '08 — Why BizJump'; }
    public function get_icon()       { return 'eicon-check-circle-o'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'why', 'benefits', 'comparison', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        /* ── Header ── */
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'section_label', [
            'label'   => 'Section Label (eyebrow)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Why Choose BizJump',
        ] );

        $this->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "More Than Just Filing —\nYour Business Partner",
            'rows'    => 2,
        ] );

        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => '',
            'rows'    => 2,
        ] );

        $this->end_controls_section();

        /* ── Features ── */
        $this->start_controls_section( 'section_features', [
            'label' => 'Feature List (left column)',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'icon', [
            'label'   => 'Icon (emoji)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '⚡',
        ] );

        $rep->add_control( 'feat_title', [
            'label'   => 'Feature Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Fastest Turnaround',
        ] );

        $rep->add_control( 'feat_desc', [
            'label'   => 'Feature Description',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Rush same-day filing available.',
            'rows'    => 3,
        ] );

        $this->add_control( 'features', [
            'label'       => 'Features',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'icon'       => '⚡',
                    'feat_title' => 'Fastest Turnaround',
                    'feat_desc'  => 'Rush same-day filing available. Most formations completed in 1–5 business days, faster than any competitor.',
                ],
                [
                    'icon'       => '💰',
                    'feat_title' => 'Guaranteed Flat Pricing',
                    'feat_desc'  => 'No hidden fees, no surprise invoices. You pay what you see — the state fee is shown upfront before checkout.',
                ],
                [
                    'icon'       => '🛡️',
                    'feat_title' => '25+ Years of Experience',
                    'feat_desc'  => 'Since 1998 we\'ve helped over 3,000 entrepreneurs launch their business. We know every state\'s requirements inside out.',
                ],
                [
                    'icon'       => '📞',
                    'feat_title' => 'Real Human Support',
                    'feat_desc'  => 'Dedicated account managers, not bots. Reach us by phone, email, or live chat — 6 days a week.',
                ],
                [
                    'icon'       => '🔄',
                    'feat_title' => '100% Satisfaction Guarantee',
                    'feat_desc'  => 'If we make an error on your filing, we fix it at no charge. Period. Your peace of mind is our responsibility.',
                ],
            ],
            'title_field' => '{{{ icon }}} {{{ feat_title }}}',
        ] );

        $this->end_controls_section();

        /* ── Comparison Table ── */
        $this->start_controls_section( 'section_table', [
            'label' => 'Comparison Table (right column)',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'table_note', [
            'label'       => 'Note',
            'type'        => \Elementor\Controls_Manager::RAW_HTML,
            'raw'         => '<p style="color:#888;font-size:12px;">The comparison table is hardcoded for accuracy. Edit the widget PHP file to change table rows.</p>',
            'content_classes' => 'elementor-descriptor',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $title_lines = nl2br( esc_html( $s['title'] ) );
        ?>
<style>
.bjw09-wrap {
  font-family: 'Inter', sans-serif;
  max-width: 1120px;
  margin: 0 auto;
  padding: 0 32px;
}
/* Header */
.bjw09-header { text-align: center; margin-bottom: 52px; }
.bjw09-label {
  font-size: 12px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: #2563eb;
  margin-bottom: 10px; display: block;
}
.bjw09-title {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: clamp(28px, 3.5vw, 40px);
  font-weight: 800; color: #111827;
  letter-spacing: -0.8px; line-height: 1.18;
}
/* 2-column layout */
.bjw09-cols {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 48px;
  align-items: start;
}
/* ── LEFT: Feature List ── */
.bjw09-features { display: flex; flex-direction: column; gap: 28px; }
.bjw09-feat {
  display: flex; gap: 18px; align-items: flex-start;
  opacity: 0; transform: translateX(-20px);
  transition: opacity .5s ease, transform .5s ease;
}
.bjw09-feat.bjw09-visible { opacity: 1; transform: none; }
.bjw09-feat:nth-child(2) { transition-delay: .1s; }
.bjw09-feat:nth-child(3) { transition-delay: .2s; }
.bjw09-feat:nth-child(4) { transition-delay: .3s; }
.bjw09-feat:nth-child(5) { transition-delay: .4s; }
.bjw09-icon-box {
  width: 48px; height: 48px; border-radius: 12px;
  background: #eff6ff; display: flex; align-items: center;
  justify-content: center; font-size: 22px; flex-shrink: 0;
}
.bjw09-feat-text h4 {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 4px;
}
.bjw09-feat-text p { font-size: 14px; color: #6b7280; line-height: 1.6; margin: 0; }
/* ── RIGHT: Comparison Table ── */
.bjw09-compare-wrap {
  overflow-x: auto;
  opacity: 0; transform: translateX(20px);
  transition: opacity .5s ease .2s, transform .5s ease .2s;
}
.bjw09-compare-wrap.bjw09-visible { opacity: 1; transform: none; }
.bjw09-table {
  width: 100%; min-width: 380px;
  border-collapse: collapse;
  border-radius: 16px; overflow: hidden;
  border: 1.5px solid #e5e7eb;
  box-shadow: 0 2px 16px rgba(0,0,0,.06);
}
.bjw09-table thead tr {
  background: #0f2156; color: #fff;
}
.bjw09-table th {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 13px; font-weight: 700; letter-spacing: .3px;
  padding: 14px 20px; text-align: left;
}
.bjw09-table th:first-child { width: 50%; }
.bjw09-table th:not(:first-child) { text-align: center; }
.bjw09-table td {
  padding: 13px 20px; font-size: 13.5px;
  color: #374151; border-bottom: 1px solid #f3f4f6;
}
.bjw09-table td:not(:first-child) { text-align: center; font-size: 16px; }
.bjw09-table tbody tr:nth-child(even) { background: #f9fafb; }
.bjw09-table tbody tr:last-child td { border-bottom: none; }
.bjw09-ok  { color: #16a34a; font-weight: 800; }
.bjw09-no  { color: #d1d5db; }
.bjw09-col-biz { font-weight: 700; color: #2563eb !important; }
/* Responsive */
@media (max-width: 900px) {
  .bjw09-cols { grid-template-columns: 1fr; gap: 40px; }
  .bjw09-feat { opacity: 1; transform: none; }
  .bjw09-compare-wrap { opacity: 1; transform: none; }
}
@media (max-width: 600px) {
  .bjw09-wrap { padding: 0 16px; }
}
</style>

<div class="bjw09-wrap">

  <!-- Header -->
  <div class="bjw09-header">
    <span class="bjw09-label"><?php echo esc_html( $s['section_label'] ); ?></span>
    <h2 class="bjw09-title"><?php echo $title_lines; ?></h2>
    <?php if ( ! empty( $s['subtitle'] ) ) : ?>
    <p style="font-size:17px;color:#6b7280;margin-top:14px;line-height:1.75;"><?php echo esc_html( $s['subtitle'] ); ?></p>
    <?php endif; ?>
  </div>

  <div class="bjw09-cols">

    <!-- LEFT: Feature List -->
    <div class="bjw09-features">
      <?php foreach ( $s['features'] as $feat ) : ?>
      <div class="bjw09-feat">
        <div class="bjw09-icon-box"><?php echo esc_html( $feat['icon'] ); ?></div>
        <div class="bjw09-feat-text">
          <h4><?php echo esc_html( $feat['feat_title'] ); ?></h4>
          <p><?php echo esc_html( $feat['feat_desc'] ); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- RIGHT: Comparison Table -->
    <div class="bjw09-compare-wrap">
      <table class="bjw09-table">
        <thead>
          <tr>
            <th>Feature</th>
            <th class="bjw09-col-biz">BizJump</th>
            <th>Attorney</th>
            <th>DIY</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Flat-rate pricing</td>
            <td class="bjw09-col-biz"><span class="bjw09-ok">✓</span></td>
            <td><span class="bjw09-no">✗</span></td>
            <td><span class="bjw09-ok">✓</span></td>
          </tr>
          <tr>
            <td>Expert guidance</td>
            <td class="bjw09-col-biz"><span class="bjw09-ok">✓</span></td>
            <td><span class="bjw09-ok">✓</span></td>
            <td><span class="bjw09-no">✗</span></td>
          </tr>
          <tr>
            <td>Fast filing (1–5 days)</td>
            <td class="bjw09-col-biz"><span class="bjw09-ok">✓</span></td>
            <td><span class="bjw09-no">✗</span></td>
            <td><span class="bjw09-no">✗</span></td>
          </tr>
          <tr>
            <td>Registered Agent included</td>
            <td class="bjw09-col-biz"><span class="bjw09-ok">✓</span></td>
            <td><span class="bjw09-no">✗</span></td>
            <td><span class="bjw09-no">✗</span></td>
          </tr>
          <tr>
            <td>EIN / Tax ID filing</td>
            <td class="bjw09-col-biz"><span class="bjw09-ok">✓</span></td>
            <td>+ extra fee</td>
            <td><span class="bjw09-no">✗</span></td>
          </tr>
          <tr>
            <td>Ongoing compliance support</td>
            <td class="bjw09-col-biz"><span class="bjw09-ok">✓</span></td>
            <td>+ retainer</td>
            <td><span class="bjw09-no">✗</span></td>
          </tr>
          <tr>
            <td>Satisfaction guarantee</td>
            <td class="bjw09-col-biz"><span class="bjw09-ok">✓</span></td>
            <td><span class="bjw09-no">✗</span></td>
            <td><span class="bjw09-no">✗</span></td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</div>

<script>
(function(){
  var items = document.querySelectorAll('.bjw09-feat, .bjw09-compare-wrap');
  var obs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if(e.isIntersecting){ e.target.classList.add('bjw09-visible'); obs.unobserve(e.target); }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  items.forEach(function(i){ obs.observe(i); });
})();
</script>
        <?php
    }
}
