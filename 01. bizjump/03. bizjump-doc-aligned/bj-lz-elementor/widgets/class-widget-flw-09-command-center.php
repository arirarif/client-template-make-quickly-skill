<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-09 — Business Command Center / Client Dashboard
 * Slate-50 BG, 2-col: text + dashboard mockup with status rows.
 */
class Widget_FLW_Command_Center extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_09_command_center'; }
    public function get_title()      { return 'FLW 09 — Command Center'; }
    public function get_icon()       { return 'eicon-dashboard'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'dashboard', 'command-center', 'flw' ]; }

    private function row_icons() {
        return [
            'cal'   => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
            'doc'   => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>',
            'shield'=> '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            'cash'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>',
        ];
    }

    protected function register_controls() {
        $this->start_controls_section( 'sec_text', [ 'label' => 'Text', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'eyebrow', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Client Dashboard' ] );
        $this->add_control( 'title',   [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Your Business Command Center' ] );
        $this->add_control( 'body', [
            'label' => 'Body (HTML)', 'type' => \Elementor\Controls_Manager::WYSIWYG,
            'default' => '<p>All your essentials, updates, and reminders—organized in one place to keep your business running smoothly.</p><p>Stay on top of state requirements and tax obligations with deadlines, filings, and alerts centralized in a single dashboard—ensuring nothing is missed and your business remains fully compliant.</p>',
        ] );
        $this->add_control( 'btn_text', [ 'label' => 'CTA Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Open Client Dashboard' ] );
        $this->add_control( 'btn_url',  [ 'label' => 'CTA URL',  'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '/my-account/' ] ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_mock', [ 'label' => 'Dashboard Mockup', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'mock_title', [ 'label' => 'Mock Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Dashboard · Sunrise Ventures LLC' ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon_key', [ 'label' => 'Icon', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => [ 'cal' => 'Calendar', 'doc' => 'Document', 'shield' => 'Shield', 'cash' => 'Currency' ], 'default' => 'cal' ] );
        $rep->add_control( 'icon_color', [ 'label' => 'Icon Color', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => [ 'o' => 'Orange', 'i' => 'Indigo', 'g' => 'Green' ], 'default' => 'o' ] );
        $rep->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Annual Report Filing' ] );
        $rep->add_control( 'meta',  [ 'label' => 'Meta',  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Due in 14 days · Texas' ] );
        $rep->add_control( 'pill_text', [ 'label' => 'Pill Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Action needed' ] );
        $rep->add_control( 'pill_type', [ 'label' => 'Pill Type', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => [ 'due' => 'Due (yellow)', 'ok' => 'Complete (green)', 'attn' => 'Reminder (red)' ], 'default' => 'due' ] );

        $this->add_control( 'rows', [
            'label' => 'Rows', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(),
            'default' => [
                [ 'icon_key' => 'cal',    'icon_color' => 'o', 'title' => 'Annual Report Filing',  'meta' => 'Due in 14 days · Texas',     'pill_text' => 'Action needed', 'pill_type' => 'due' ],
                [ 'icon_key' => 'doc',    'icon_color' => 'i', 'title' => 'EIN Confirmed',         'meta' => 'From IRS · Apr 12, 2026',    'pill_text' => 'Complete',      'pill_type' => 'ok' ],
                [ 'icon_key' => 'shield', 'icon_color' => 'g', 'title' => 'Operating Agreement',   'meta' => 'Signed by 2 of 2 members',   'pill_text' => 'Complete',      'pill_type' => 'ok' ],
                [ 'icon_key' => 'cash',   'icon_color' => 'o', 'title' => 'Quarterly Tax Reminder','meta' => 'Q2 estimate · Jun 15',       'pill_text' => 'Reminder',      'pill_type' => 'attn' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s     = $this->get_settings_for_display();
        $id    = 'bjlz-flw09-' . $this->get_id();
        $icons = $this->row_icons();
        ?>
        <style>
        #<?php echo esc_attr($id); ?>{font-family:'Inter','Plus Jakarta Sans',sans-serif;color:#475569}
        #<?php echo esc_attr($id); ?> .section{padding:80px 0;background:#F8FAFC}
        #<?php echo esc_attr($id); ?> .container{max-width:1160px;margin:0 auto;padding:0 24px}
        #<?php echo esc_attr($id); ?> .cmd-grid{display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center;max-width:1080px;margin:0 auto}
        #<?php echo esc_attr($id); ?> .section-eyebrow{display:inline-block;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#F97316;margin-bottom:14px}
        #<?php echo esc_attr($id); ?> .section-title{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:clamp(26px,3.2vw,38px);font-weight:800;line-height:1.18;letter-spacing:-.02em;color:#0F172A;margin-bottom:18px}
        #<?php echo esc_attr($id); ?> .cmd-text p{font-size:16px;color:#475569;line-height:1.75;margin-bottom:16px}
        #<?php echo esc_attr($id); ?> .cmd-cta{display:inline-flex;align-items:center;gap:8px;margin-top:8px;padding:13px 26px;background:#0F172A;color:#fff;font-size:15px;font-weight:700;border-radius:10px;text-decoration:none;transition:all .2s}
        #<?php echo esc_attr($id); ?> .cmd-cta:hover{background:#334155;transform:translateY(-1px)}
        #<?php echo esc_attr($id); ?> .cmd-mock{background:#fff;border:1px solid #E2E8F0;border-radius:18px;padding:22px;box-shadow:0 8px 28px rgba(15,23,42,.13)}
        #<?php echo esc_attr($id); ?> .cmd-mock-bar{display:flex;align-items:center;gap:6px;padding-bottom:14px;border-bottom:1px solid #F1F5F9;margin-bottom:18px}
        #<?php echo esc_attr($id); ?> .cmd-dot{width:9px;height:9px;border-radius:50%;background:#E2E8F0}
        #<?php echo esc_attr($id); ?> .cmd-dot.r{background:#FB7185}
        #<?php echo esc_attr($id); ?> .cmd-dot.y{background:#FBBF24}
        #<?php echo esc_attr($id); ?> .cmd-dot.g{background:#34D399}
        #<?php echo esc_attr($id); ?> .cmd-mock-title{margin-left:8px;font-size:12px;color:#94A3B8;font-weight:600}
        #<?php echo esc_attr($id); ?> .cmd-row{display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:#F8FAFC;border:1px solid #F1F5F9;border-radius:10px;margin-bottom:10px}
        #<?php echo esc_attr($id); ?> .cmd-row:last-child{margin-bottom:0}
        #<?php echo esc_attr($id); ?> .cmd-row-label{display:flex;align-items:center;gap:11px;font-size:14px;font-weight:600;color:#334155}
        #<?php echo esc_attr($id); ?> .cmd-row-icon{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        #<?php echo esc_attr($id); ?> .cmd-row-icon.o{background:#FFF7ED;color:#F97316}
        #<?php echo esc_attr($id); ?> .cmd-row-icon.i{background:#EEF2FF;color:#6366F1}
        #<?php echo esc_attr($id); ?> .cmd-row-icon.g{background:#ECFDF5;color:#10B981}
        #<?php echo esc_attr($id); ?> .cmd-row-meta{font-size:12px;color:#94A3B8;font-weight:500}
        #<?php echo esc_attr($id); ?> .cmd-pill{padding:3px 10px;border-radius:999px;font-size:11px;font-weight:700}
        #<?php echo esc_attr($id); ?> .cmd-pill.due{background:#FEF3C7;color:#B45309}
        #<?php echo esc_attr($id); ?> .cmd-pill.ok{background:#D1FAE5;color:#047857}
        #<?php echo esc_attr($id); ?> .cmd-pill.attn{background:#FEE2E2;color:#B91C1C}
        @media (max-width:920px){ #<?php echo esc_attr($id); ?> .cmd-grid{grid-template-columns:1fr;gap:36px} }
        </style>

        <div id="<?php echo esc_attr($id); ?>">
          <section class="section">
            <div class="container">
              <div class="cmd-grid">
                <div class="cmd-text">
                  <span class="section-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
                  <h2 class="section-title"><?php echo esc_html( $s['title'] ); ?></h2>
                  <?php echo wp_kses_post( $s['body'] ); ?>
                  <a class="cmd-cta" href="<?php echo esc_url( $s['btn_url']['url'] ?? '#' ); ?>">
                    <?php echo esc_html( $s['btn_text'] ); ?>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                  </a>
                </div>
                <div class="cmd-mock">
                  <div class="cmd-mock-bar">
                    <div class="cmd-dot r"></div><div class="cmd-dot y"></div><div class="cmd-dot g"></div>
                    <span class="cmd-mock-title"><?php echo esc_html( $s['mock_title'] ); ?></span>
                  </div>
                  <?php foreach ( (array) ( $s['rows'] ?? [] ) as $r ) :
                      $svg = $icons[ $r['icon_key'] ?? 'cal' ] ?? $icons['cal'];
                      $color = $r['icon_color'] ?? 'o';
                      $pt = $r['pill_type'] ?? 'due';
                  ?>
                    <div class="cmd-row">
                      <div class="cmd-row-label">
                        <div class="cmd-row-icon <?php echo esc_attr( $color ); ?>"><?php echo $svg; ?></div>
                        <div><?php echo esc_html( $r['title'] ); ?>
                          <div class="cmd-row-meta"><?php echo esc_html( $r['meta'] ); ?></div>
                        </div>
                      </div>
                      <span class="cmd-pill <?php echo esc_attr( $pt ); ?>"><?php echo esc_html( $r['pill_text'] ); ?></span>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </section>
        </div>
        <?php
    }
}
