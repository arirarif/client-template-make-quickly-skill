<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DAL-09 — Command Center (Doc-Aligned Landing)
 * Source: 03. bizjump-doc-aligned/formation-landing.html — .cmd-grid
 * 2-col layout: text + dark CTA on the left, mock dashboard panel on the right
 * (browser dots header + 4 rows with icon, label, meta, status pill).
 * Pill statuses: due/ok/attn (amber/green/red).
 */
class Widget_DAL_Command_Center extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dal_09_command_center'; }
    public function get_title()      { return 'DAL 09 — Command Center'; }
    public function get_icon()       { return 'eicon-dashboard'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'dashboard', 'command', 'mock', 'rows', 'bizjump', 'dal' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_text', [
            'label' => 'Text Column',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Client Dashboard',
        ] );
        $this->add_control( 'headline', [
            'label'   => 'Headline',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Your Business Command Center',
        ] );
        $rep_p = new \Elementor\Repeater();
        $rep_p->add_control( 'text', [
            'label' => 'Paragraph',
            'type'  => \Elementor\Controls_Manager::TEXTAREA,
        ] );
        $this->add_control( 'paragraphs', [
            'label'   => 'Paragraphs',
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $rep_p->get_controls(),
            'default' => [
                [ 'text' => 'All your essentials, updates, and reminders—organized in one place to keep your business running smoothly.' ],
                [ 'text' => 'Stay on top of state requirements and tax obligations with deadlines, filings, and alerts centralized in a single dashboard—ensuring nothing is missed and your business remains fully compliant.' ],
            ],
            'title_field' => '{{{ text.substring(0, 50) }}}…',
        ] );
        $this->add_control( 'btn_text', [
            'label'   => 'Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Open Client Dashboard',
        ] );
        $this->add_control( 'btn_url', [
            'label'   => 'Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#' ],
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_mock', [
            'label' => 'Dashboard Mock',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'mock_title', [
            'label'   => 'Mock Title Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Dashboard · Sunrise Ventures LLC',
        ] );

        $rep_r = new \Elementor\Repeater();
        $rep_r->add_control( 'icon', [
            'label'   => 'Icon Style',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'calendar' => 'Calendar (orange)',
                'shield'   => 'Shield (green)',
                'cube'     => 'Cube/Stack (indigo)',
                'dollar'   => 'Dollar (orange)',
                'clock'    => 'Clock (orange)',
                'check'    => 'Check (green)',
            ],
            'default' => 'calendar',
        ] );
        $rep_r->add_control( 'tone', [
            'label'   => 'Icon Tone',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'o' => 'Orange',
                'i' => 'Indigo',
                'g' => 'Green',
            ],
            'default' => 'o',
        ] );
        $rep_r->add_control( 'label', [
            'label'   => 'Row Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Annual Report Filing',
        ] );
        $rep_r->add_control( 'meta', [
            'label'   => 'Meta (small line)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Due in 14 days · Texas',
        ] );
        $rep_r->add_control( 'pill_text', [
            'label'   => 'Pill Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Action needed',
        ] );
        $rep_r->add_control( 'pill_status', [
            'label'   => 'Pill Status',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'due'  => 'Amber (Action needed)',
                'ok'   => 'Green (Complete)',
                'attn' => 'Red (Reminder)',
            ],
            'default' => 'due',
        ] );

        $this->add_control( 'rows', [
            'label'   => 'Rows',
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $rep_r->get_controls(),
            'default' => [
                [ 'icon' => 'calendar', 'tone' => 'o', 'label' => 'Annual Report Filing',     'meta' => 'Due in 14 days · Texas',     'pill_text' => 'Action needed', 'pill_status' => 'due'  ],
                [ 'icon' => 'cube',     'tone' => 'i', 'label' => 'EIN Confirmed',            'meta' => 'From IRS · Apr 12, 2026',    'pill_text' => 'Complete',      'pill_status' => 'ok'   ],
                [ 'icon' => 'shield',   'tone' => 'g', 'label' => 'Operating Agreement',      'meta' => 'Signed by 2 of 2 members',   'pill_text' => 'Complete',      'pill_status' => 'ok'   ],
                [ 'icon' => 'dollar',   'tone' => 'o', 'label' => 'Quarterly Tax Reminder',   'meta' => 'Q2 estimate · Jun 15',       'pill_text' => 'Reminder',      'pill_status' => 'attn' ],
            ],
            'title_field' => '{{{ label }}}',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_style', [
            'label' => 'Style',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'bg_color', [
            'label'   => 'Section Background',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#F8FAFC',
        ] );
        $this->add_control( 'orange_500', [
            'label'   => 'Orange (eyebrow)',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#F97316',
        ] );
        $this->end_controls_section();
    }

    private function row_icon( $key ) {
        switch ( $key ) {
            case 'shield':   return '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>';
            case 'cube':     return '<path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>';
            case 'dollar':   return '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>';
            case 'clock':    return '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>';
            case 'check':    return '<polyline points="20 6 9 17 4 12"/>';
            case 'calendar':
            default:         return '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>';
        }
    }

    protected function render() {
        $s     = $this->get_settings_for_display();
        $bg    = esc_attr( $s['bg_color']   ?: '#F8FAFC' );
        $o500  = esc_attr( $s['orange_500'] ?: '#F97316' );
        $uid   = 'dal09_' . $this->get_id();
        $b_url = ! empty( $s['btn_url']['url'] ) ? esc_url( $s['btn_url']['url'] ) : '#';
        $b_tgt = ! empty( $s['btn_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
<style>
.<?php echo $uid; ?>.dal09-section {
  background: <?php echo $bg; ?>;
  padding: 80px 0;
  font-family: 'Inter', sans-serif;
}
.<?php echo $uid; ?> .dal09-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.<?php echo $uid; ?> .dal09-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 48px;
  align-items: center;
  max-width: 1080px;
  margin: 0 auto;
}
.<?php echo $uid; ?> .dal09-eyebrow {
  display: inline-block;
  font-size: 11px; font-weight: 700;
  letter-spacing: .1em; text-transform: uppercase;
  color: <?php echo $o500; ?>;
  margin-bottom: 14px;
}
.<?php echo $uid; ?> .dal09-h2 {
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: clamp(26px, 3.4vw, 40px);
  font-weight: 800; line-height: 1.18;
  letter-spacing: -.02em; color: #0F172A;
  margin: 0 0 18px;
}
.<?php echo $uid; ?> .dal09-p {
  font-size: 16px;
  color: #475569;
  line-height: 1.75;
  margin: 0 0 16px;
}
.<?php echo $uid; ?> .dal09-cta {
  display: inline-flex; align-items: center; gap: 8px;
  margin-top: 8px;
  padding: 13px 26px;
  background: #0F172A;
  color: #fff;
  font-size: 15px; font-weight: 700;
  border-radius: 10px;
  border: none; cursor: pointer;
  text-decoration: none;
  transition: all .2s;
}
.<?php echo $uid; ?> .dal09-cta:hover {
  background: #334155;
  color: #fff;
  transform: translateY(-1px);
}

.<?php echo $uid; ?> .dal09-mock {
  background: #fff;
  border: 1px solid #E2E8F0;
  border-radius: 18px;
  padding: 22px;
  box-shadow: 0 16px 36px rgba(15,23,42,0.08);
}
.<?php echo $uid; ?> .dal09-bar {
  display: flex; align-items: center; gap: 6px;
  padding-bottom: 14px;
  border-bottom: 1px solid #F1F5F9;
  margin-bottom: 18px;
}
.<?php echo $uid; ?> .dal09-dot { width: 9px; height: 9px; border-radius: 50%; background: #E2E8F0; }
.<?php echo $uid; ?> .dal09-dot.r { background: #FB7185; }
.<?php echo $uid; ?> .dal09-dot.y { background: #FBBF24; }
.<?php echo $uid; ?> .dal09-dot.g { background: #34D399; }
.<?php echo $uid; ?> .dal09-bar-title {
  margin-left: 8px;
  font-size: 12px; color: #94A3B8; font-weight: 600;
}

.<?php echo $uid; ?> .dal09-row {
  display: flex; align-items: center; justify-content: space-between;
  padding: 14px 16px;
  background: #F8FAFC;
  border: 1px solid #F1F5F9;
  border-radius: 10px;
  margin-bottom: 10px;
}
.<?php echo $uid; ?> .dal09-row:last-child { margin-bottom: 0; }
.<?php echo $uid; ?> .dal09-row-label {
  display: flex; align-items: center; gap: 11px;
  font-size: 14px; font-weight: 600; color: #334155;
}
.<?php echo $uid; ?> .dal09-row-icon {
  width: 34px; height: 34px;
  border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.<?php echo $uid; ?> .dal09-row-icon.o { background: #FFF7ED; color: <?php echo $o500; ?>; }
.<?php echo $uid; ?> .dal09-row-icon.i { background: #EEF2FF; color: #6366F1; }
.<?php echo $uid; ?> .dal09-row-icon.g { background: #ECFDF5; color: #10B981; }
.<?php echo $uid; ?> .dal09-row-meta {
  font-size: 12px; color: #94A3B8; font-weight: 500;
  margin-top: 2px;
}
.<?php echo $uid; ?> .dal09-pill {
  padding: 3px 10px;
  border-radius: 999px;
  font-size: 11px; font-weight: 700;
  white-space: nowrap;
}
.<?php echo $uid; ?> .dal09-pill.due  { background: #FEF3C7; color: #B45309; }
.<?php echo $uid; ?> .dal09-pill.ok   { background: #D1FAE5; color: #047857; }
.<?php echo $uid; ?> .dal09-pill.attn { background: #FEE2E2; color: #B91C1C; }

@media (max-width: 920px) {
  .<?php echo $uid; ?> .dal09-grid { grid-template-columns: 1fr; gap: 36px; }
}
@media (max-width: 600px) {
  .<?php echo $uid; ?>.dal09-section { padding: 56px 0; }
  .<?php echo $uid; ?> .dal09-mock { padding: 18px; }
}
</style>

<section class="<?php echo $uid; ?> dal09-section">
  <div class="dal09-inner">
    <div class="dal09-grid">

      <div class="dal09-text">
        <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
          <span class="dal09-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
        <?php endif; ?>
        <?php if ( ! empty( $s['headline'] ) ) : ?>
          <h2 class="dal09-h2"><?php echo esc_html( $s['headline'] ); ?></h2>
        <?php endif; ?>
        <?php foreach ( (array) $s['paragraphs'] as $p ) :
          if ( empty( $p['text'] ) ) continue; ?>
          <p class="dal09-p"><?php echo esc_html( $p['text'] ); ?></p>
        <?php endforeach; ?>
        <a href="<?php echo $b_url; ?>"<?php echo $b_tgt; ?> class="dal09-cta">
          <?php echo esc_html( $s['btn_text'] ); ?>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>

      <div class="dal09-mock">
        <div class="dal09-bar">
          <div class="dal09-dot r"></div>
          <div class="dal09-dot y"></div>
          <div class="dal09-dot g"></div>
          <span class="dal09-bar-title"><?php echo esc_html( $s['mock_title'] ); ?></span>
        </div>
        <?php foreach ( (array) $s['rows'] as $r ) :
          $tone = in_array( $r['tone'] ?? 'o', [ 'o','i','g' ], true ) ? $r['tone'] : 'o';
          $pill = in_array( $r['pill_status'] ?? 'due', [ 'due','ok','attn' ], true ) ? $r['pill_status'] : 'due';
          $svg  = $this->row_icon( $r['icon'] ?? 'calendar' );
        ?>
        <div class="dal09-row">
          <div class="dal09-row-label">
            <div class="dal09-row-icon <?php echo esc_attr( $tone ); ?>">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $svg; ?></svg>
            </div>
            <div>
              <?php echo esc_html( $r['label'] ); ?>
              <?php if ( ! empty( $r['meta'] ) ) : ?>
                <div class="dal09-row-meta"><?php echo esc_html( $r['meta'] ); ?></div>
              <?php endif; ?>
            </div>
          </div>
          <span class="dal09-pill <?php echo esc_attr( $pill ); ?>"><?php echo esc_html( $r['pill_text'] ); ?></span>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</section>
        <?php
    }
}
