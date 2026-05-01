<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 13 — Easy Way
 * Two-column section: descriptive text on left, visual stats panel on right.
 */
class Widget_Easy_Way extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_13_easy_way'; }
    public function get_title()      { return '13 — Easy Way'; }
    public function get_icon()       { return 'eicon-columns'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'easy', 'incorporate', 'why', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        /* ── Text Column ── */
        $this->start_controls_section( 'section_text', [
            'label' => 'Text Column',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'section_label', [
            'label'   => 'Section Label (eyebrow)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Why BizJump',
        ] );

        $this->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "The easy way to incorporate your business\nin any 50 state",
            'rows'    => 2,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'paragraph', [
            'label'   => 'Paragraph',
            'type'    => \Elementor\Controls_Manager::WYSIWYG,
            'default' => 'Enter paragraph text here.',
        ] );

        $this->add_control( 'paragraphs', [
            'label'       => 'Paragraphs',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'paragraph' => 'Starting at <strong>$99 plus state fees</strong> (paid directly to the state), BizJump makes starting your business fast, simple, and stress-free. No confusing steps. No unnecessary extras — just a clear path to getting up and running.' ],
                [ 'paragraph' => 'You only pay for what you need. <strong>No hidden fees. No surprise add-ons. No upselling.</strong>' ],
                [ 'paragraph' => 'From day one, your dedicated BizJump specialist handles everything — from name search and filings to securing your EIN — so you can focus on building your business.' ],
                [ 'paragraph' => 'And we don\'t stop there. As you grow, we support you with business banking, digital launch tools, access to funding, and tax guidance — all with ongoing priority support.' ],
                [ 'paragraph' => '<strong>Start your business the right way — with a partner that keeps it simple, affordable, and built for your success.</strong>' ],
            ],
            'title_field' => 'Paragraph',
        ] );

        $this->add_control( 'cta_primary_text', [
            'label'   => 'Primary CTA Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Start For Free',
        ] );

        $this->add_control( 'cta_primary_url', [
            'label'   => 'Primary CTA URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/incorporate/' ],
        ] );

        $this->add_control( 'cta_secondary_text', [
            'label'   => 'Secondary CTA Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Talk to a Specialist',
        ] );

        $this->add_control( 'cta_secondary_url', [
            'label'   => 'Secondary CTA URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/contact/' ],
        ] );

        $this->end_controls_section();

        /* ── Stats Panel ── */
        $this->start_controls_section( 'section_stats', [
            'label' => 'Stats Panel',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep2 = new \Elementor\Repeater();

        $rep2->add_control( 'prefix', [
            'label'   => 'Prefix (e.g. $)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '',
        ] );

        $rep2->add_control( 'number', [
            'label'   => 'Number',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '99',
        ] );

        $rep2->add_control( 'suffix', [
            'label'   => 'Suffix (e.g. Day)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '',
        ] );

        $rep2->add_control( 'stat_label', [
            'label'   => 'Stat Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Starting price — one-time, flat-rate',
        ] );

        $this->add_control( 'stats', [
            'label'       => 'Stats',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep2->get_controls(),
            'default'     => [
                [ 'prefix' => '$',  'number' => '99',  'suffix' => '',    'stat_label' => 'Starting price — one-time, flat-rate' ],
                [ 'prefix' => '',   'number' => '50',  'suffix' => '',    'stat_label' => 'States supported across the USA' ],
                [ 'prefix' => '',   'number' => '1',   'suffix' => ' Day','stat_label' => 'Rush filing available on Premium &amp; Enterprise' ],
                [ 'prefix' => '$',  'number' => '0',   'suffix' => '',    'stat_label' => 'Hidden fees — always 100% transparent pricing' ],
            ],
            'title_field' => '{{{ prefix }}}{{{ number }}}{{{ suffix }}} — {{{ stat_label }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s      = $this->get_settings_for_display();
        $cta1_u = ! empty( $s['cta_primary_url']['url'] )   ? esc_url( $s['cta_primary_url']['url'] )   : '#';
        $cta1_t = ! empty( $s['cta_primary_url']['is_external'] )   ? ' target="_blank" rel="noopener noreferrer"' : '';
        $cta2_u = ! empty( $s['cta_secondary_url']['url'] ) ? esc_url( $s['cta_secondary_url']['url'] ) : '#';
        $cta2_t = ! empty( $s['cta_secondary_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
<style>
.bjw13-wrap {
  background: #fff;
  border-top: 1px solid #f3f4f6;
  padding: 80px 32px;
  font-family: 'Inter', sans-serif;
}
.bjw13-inner { max-width: 1120px; margin: 0 auto; }
.bjw13-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 64px;
  align-items: center;
}
.bjw13-label {
  font-size: 12px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: #2563eb;
  margin-bottom: 10px; display: block;
}
.bjw13-title {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: clamp(26px, 3vw, 38px);
  font-weight: 800; color: #111827;
  line-height: 1.2; letter-spacing: -0.6px;
  margin-bottom: 24px;
}
.bjw13-paragraphs p {
  font-size: 15px; color: #374151; line-height: 1.75;
  margin-bottom: 14px;
}
.bjw13-paragraphs p strong { color: #0f2156; }
.bjw13-cta {
  margin-top: 28px;
  display: flex; gap: 14px; flex-wrap: wrap;
}
.bjw13-btn-primary {
  display: inline-flex; align-items: center; gap: 6px;
  background: #f97316; color: #fff;
  padding: 13px 26px; border-radius: 6px;
  font-size: 15px; font-weight: 700; text-decoration: none;
  transition: background .2s, transform .15s;
  box-shadow: 0 3px 10px rgba(249,115,22,.3);
  font-family: 'Inter', sans-serif;
}
.bjw13-btn-primary:hover { background: #ea6c00; transform: translateY(-1px); color: #fff; }
.bjw13-btn-outline {
  display: inline-flex; align-items: center;
  background: transparent; color: #0f2156;
  border: 2px solid #0f2156;
  padding: 13px 26px; border-radius: 6px;
  font-size: 15px; font-weight: 700; text-decoration: none;
  transition: background .2s, color .2s, transform .15s;
  font-family: 'Inter', sans-serif;
}
.bjw13-btn-outline:hover { background: #0f2156; color: #fff; transform: translateY(-1px); }
.bjw13-stats {
  background: #0f2156;
  border-radius: 20px;
  padding: 40px 36px;
  display: flex; flex-direction: column; gap: 0;
}
.bjw13-stat { padding: 24px 0; }
.bjw13-stat-num {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 44px; font-weight: 800;
  color: #fff; line-height: 1;
  letter-spacing: -1px; margin-bottom: 6px;
}
.bjw13-stat-num span { color: #f97316; }
.bjw13-stat-label { font-size: 13px; color: rgba(255,255,255,.65); line-height: 1.5; }
.bjw13-divider {
  height: 1px; background: rgba(255,255,255,.1); margin: 0;
}
@media (max-width: 1024px) {
  .bjw13-grid { grid-template-columns: 1fr; gap: 40px; }
  .bjw13-stats { max-width: 480px; }
}
@media (max-width: 768px) {
  .bjw13-wrap { padding: 56px 16px; }
  .bjw13-stat-num { font-size: 36px; }
}
</style>

<div class="bjw13-wrap">
  <div class="bjw13-inner">
    <div class="bjw13-grid">

      <div class="bjw13-text">
        <span class="bjw13-label"><?php echo esc_html( $s['section_label'] ); ?></span>
        <h2 class="bjw13-title"><?php echo nl2br( wp_kses_post( $s['title'] ) ); ?></h2>
        <div class="bjw13-paragraphs">
          <?php foreach ( $s['paragraphs'] as $item ) : ?>
          <p><?php echo wp_kses_post( $item['paragraph'] ); ?></p>
          <?php endforeach; ?>
        </div>
        <div class="bjw13-cta">
          <a href="<?php echo $cta1_u; ?>"<?php echo $cta1_t; ?> class="bjw13-btn-primary">
            <?php echo esc_html( $s['cta_primary_text'] ); ?> &#8594;
          </a>
          <a href="<?php echo $cta2_u; ?>"<?php echo $cta2_t; ?> class="bjw13-btn-outline">
            <?php echo esc_html( $s['cta_secondary_text'] ); ?>
          </a>
        </div>
      </div>

      <div class="bjw13-visual">
        <div class="bjw13-stats">
          <?php foreach ( $s['stats'] as $i => $stat ) :
              if ( $i > 0 ) echo '<div class="bjw13-divider"></div>';
          ?>
          <div class="bjw13-stat">
            <div class="bjw13-stat-num">
              <?php if ( ! empty( $stat['prefix'] ) ) echo esc_html( $stat['prefix'] ); ?>
              <span><?php echo esc_html( $stat['number'] ); ?></span>
              <?php if ( ! empty( $stat['suffix'] ) ) echo esc_html( $stat['suffix'] ); ?>
            </div>
            <div class="bjw13-stat-label"><?php echo wp_kses_post( $stat['stat_label'] ); ?></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</div>
        <?php
    }
}
