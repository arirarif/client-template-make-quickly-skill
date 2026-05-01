<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * WZD-01 — Formation Wizard
 * Multi-step formation wizard (Entity → State → Plan → Add-ons → Details → Review → Done).
 * Reads ?entity=llc|ccorp|scorp|nonprofit from the URL to pre-select.
 */
class Widget_WZD_Wizard extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_wzd_01_wizard'; }
    public function get_title()      { return 'WZD 01 — Formation Wizard'; }
    public function get_icon()       { return 'eicon-form-horizontal'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'wizard', 'formation', 'llc', 'multi-step', 'bizjump', 'flw' ]; }

    protected function register_controls() {

        /* Hero (default — overridden by ?entity= JS map) */
        $this->start_controls_section( 'sec_hero', [
            'label' => 'Hero (default)', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'hero_title',    [ 'label' => 'Default Title',    'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Start Your Business Formation' ] );
        $this->add_control( 'hero_subtitle', [ 'label' => 'Default Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Answer a few questions — takes less than 10 minutes' ] );
        $this->add_control( 'change_entity_url', [
            'label' => 'Change-entity link (back to entity selector)', 'type' => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/business-formation/' ],
        ] );
        $this->end_controls_section();

        /* Step labels */
        $this->start_controls_section( 'sec_steps', [
            'label' => 'Step Labels', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'step_1_label', [ 'label' => 'Step 1', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Entity Type' ] );
        $this->add_control( 'step_2_label', [ 'label' => 'Step 2', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Business Info' ] );
        $this->add_control( 'step_3_label', [ 'label' => 'Step 3', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Package' ] );
        $this->add_control( 'step_4_label', [ 'label' => 'Step 4', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Review' ] );
        $this->end_controls_section();

        /* Packages */
        $this->start_controls_section( 'sec_packages', [
            'label' => 'Packages', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'name',  [ 'label' => 'Name',  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Basic' ] );
        $rep->add_control( 'pkg_key', [
            'label' => 'WC Product Key',
            'type'  => \Elementor\Controls_Manager::TEXT,
            'default' => 'plan_basic',
            'description' => 'Must match a key registered in the bizjump-wizard plugin (plan_basic / plan_pro / plan_premium / plan_enterprise).',
        ] );
        $rep->add_control( 'desc',  [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'LLC articles + name search + order tracking' ] );
        $rep->add_control( 'price', [ 'label' => 'Price (number)', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 0 ] );
        $rep->add_control( 'price_note', [ 'label' => 'Price Note', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '+ state fee' ] );
        $rep->add_control( 'badge', [ 'label' => 'Badge Text (optional)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '' ] );
        $rep->add_control( 'badge_style', [
            'label' => 'Badge Style', 'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [ 'popular' => 'Popular (indigo)', 'best' => 'Best (orange)' ],
            'default' => 'popular',
        ] );
        $rep->add_control( 'selected', [ 'label' => 'Pre-selected', 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ] );

        $this->add_control( 'packages', [
            'label' => 'Packages', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $rep->get_controls(),
            'default' => [
                [ 'name' => 'Basic',   'pkg_key' => 'plan_basic',   'desc' => 'LLC articles + name search + order tracking', 'price' => 99,  'price_note' => '+ state fee', 'badge' => '',             'badge_style' => 'popular', 'selected' => '' ],
                [ 'name' => 'Pro',     'pkg_key' => 'plan_pro',     'desc' => 'Everything in Basic + Registered Agent, EIN, Operating Agreement', 'price' => 195, 'price_note' => '+ state fee', 'badge' => 'Most Popular', 'badge_style' => 'popular', 'selected' => 'yes' ],
                [ 'name' => 'Premium', 'pkg_key' => 'plan_premium', 'desc' => 'Everything in Pro + Business bank account, domain, dedicated manager', 'price' => 295, 'price_note' => '+ state fee', 'badge' => 'Best Value',   'badge_style' => 'best',    'selected' => '' ],
            ],
            'title_field' => '{{{ name }}}',
        ] );
        $this->end_controls_section();

        /* CTA / completion */
        $this->start_controls_section( 'sec_cta', [
            'label' => 'CTA & Completion', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'state_filing_fee', [ 'label' => 'Default State Filing Fee (review row)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '$300 (TX)' ] );
        $this->add_control( 'done_title', [ 'label' => 'Done Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Order Confirmed!' ] );
        $this->add_control( 'done_message', [
            'label' => 'Done Message (HTML allowed)', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'We\'ve received your order for <strong>Sunrise Ventures LLC</strong>. Your filing will be processed within 1 business day.',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $change_url = ! empty( $s['change_entity_url']['url'] ) ? esc_url( $s['change_entity_url']['url'] ) : '/business-formation/';
        $packages   = (array) $s['packages'];
        $uid        = 'flw10_' . $this->get_id();

        // Bridge to bizjump-wizard backend: expose ajaxUrl, nonce, and state fees
        // as window.BJW so the FLW-10 JS can POST to bj_create_order and resolve
        // state filing fees. Only emitted when the bizjump-wizard plugin is active.
        $bjw_bridge = null;
        if ( function_exists( 'bjw_get_state_fees' ) ) {
            $bjw_bridge = [
                'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
                'nonce'     => wp_create_nonce( 'bjw_nonce' ),
                'stateFees' => bjw_get_state_fees(),
            ];
        }
        ?>
<?php if ( $bjw_bridge ) : ?>
<script>window.BJW = window.BJW || <?php echo wp_json_encode( $bjw_bridge ); ?>;</script>
<?php endif; ?>
<style>
.flw10-wizard { font-family: 'Inter', 'Plus Jakarta Sans', sans-serif; background: #F8FAFC; color: #475569; }
.flw10-wizard *, .flw10-wizard *::before, .flw10-wizard *::after { box-sizing: border-box; }

/* Navbar */
.flw10-nav { background: #fff; border-bottom: 1px solid #E2E8F0; box-shadow: 0 1px 3px rgba(15,23,42,0.06); }
.flw10-nav-inner { max-width: 960px; margin: 0 auto; padding: 0 24px; height: 64px; display: flex; align-items: center; justify-content: space-between; }
.flw10-logo { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; font-size: 20px; font-weight: 800; color: #0F172A; }
.flw10-logo span { color: #F97316; }
.flw10-nav-actions { display: flex; align-items: center; gap: 16px; }
.flw10-change-link { display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 500; color: #94A3B8; text-decoration: none; transition: color .15s; }
.flw10-change-link:hover { color: #334155; }
.flw10-secure { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #94A3B8; }
.flw10-secure svg { color: #6366F1; }

/* Hero */
.flw10-hero { background: #fff; border-bottom: 1px solid #E2E8F0; padding: 32px 0 28px; text-align: center; }
.flw10-hero h1 { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; font-size: clamp(22px, 3vw, 32px); font-weight: 800; color: #0F172A; margin: 0 0 6px; letter-spacing: -.02em; }
.flw10-hero p { font-size: 15px; color: #94A3B8; margin: 0; }

/* Step progress */
.flw10-progress { background: #fff; border-bottom: 1px solid #E2E8F0; padding: 20px 0; }
.flw10-progress-inner { max-width: 680px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: center; gap: 0; }
.flw10-step { display: flex; flex-direction: column; align-items: center; gap: 6px; position: relative; flex: 1; }
.flw10-step:not(:last-child)::after { content: ''; position: absolute; top: 18px; left: calc(50% + 20px); right: calc(-50% + 20px); height: 2px; background: #E2E8F0; z-index: 0; }
.flw10-step.completed:not(:last-child)::after { background: #6366F1; }
.flw10-circle { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; z-index: 1; transition: all .3s; }
.flw10-step.inactive .flw10-circle { background: #fff; border: 2px solid #CBD5E1; color: #94A3B8; }
.flw10-step.active .flw10-circle { background: #F97316; border: 2px solid #F97316; color: #fff; box-shadow: 0 4px 16px rgba(249,115,22,.35); }
.flw10-step.completed .flw10-circle { background: #6366F1; border: 2px solid #6366F1; color: #fff; }
.flw10-step-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; white-space: nowrap; }
.flw10-step.inactive .flw10-step-label { color: #94A3B8; }
.flw10-step.active .flw10-step-label { color: #F97316; }
.flw10-step.completed .flw10-step-label { color: #6366F1; }

/* Body */
.flw10-body { max-width: 720px; margin: 40px auto; padding: 0 24px 80px; }
.flw10-card { background: #fff; border: 1px solid #E2E8F0; border-radius: 20px; box-shadow: 0 4px 14px rgba(15,23,42,.10); overflow: hidden; }
.flw10-card-header { padding: 36px 40px 0; }
.flw10-tag { display: inline-flex; align-items: center; gap: 6px; background: #FFF7ED; color: #EA580C; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 999px; border: 1px solid #FFEDD5; margin-bottom: 14px; }
.flw10-card-header h2 { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; font-size: clamp(20px, 2.5vw, 26px); font-weight: 800; color: #0F172A; margin: 0 0 8px; letter-spacing: -.02em; }
.flw10-card-header p { font-size: 15px; color: #94A3B8; line-height: 1.6; margin: 0; }
.flw10-card-body { padding: 32px 40px; }
.flw10-card-footer { padding: 24px 40px; border-top: 1px solid #F1F5F9; display: flex; align-items: center; justify-content: space-between; gap: 12px; }

/* Step 1 — entity grid */
.flw10-entity-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
.flw10-entity-card { border: 1.5px solid #E2E8F0; border-radius: 14px; padding: 20px; cursor: pointer; transition: all .2s; position: relative; background: #fff; display: flex; align-items: flex-start; gap: 14px; }
.flw10-entity-card:hover { border-color: #CBD5E1; background: #F8FAFC; }
.flw10-entity-card.selected { border-color: #F97316; background: #FFF7ED; box-shadow: 0 0 0 3px rgba(249,115,22,.10); }
.flw10-entity-icon { width: 44px; height: 44px; border-radius: 10px; background: #F1F5F9; display: flex; align-items: center; justify-content: center; color: #64748B; flex-shrink: 0; transition: all .2s; }
.flw10-entity-card.selected .flw10-entity-icon { background: #FFEDD5; color: #F97316; }
.flw10-entity-info { flex: 1; }
.flw10-entity-name { font-size: 15px; font-weight: 700; color: #1E293B; margin-bottom: 4px; }
.flw10-entity-card.selected .flw10-entity-name { color: #EA580C; }
.flw10-entity-desc { font-size: 13px; color: #94A3B8; line-height: 1.5; }
.flw10-entity-check { position: absolute; top: 12px; right: 12px; width: 20px; height: 20px; border-radius: 50%; background: #F97316; display: flex; align-items: center; justify-content: center; opacity: 0; transform: scale(.5); transition: all .2s; }
.flw10-entity-card.selected .flw10-entity-check { opacity: 1; transform: scale(1); }
.flw10-entity-check svg { color: #fff; }
.flw10-entity-popular { position: absolute; top: -9px; left: 14px; background: #6366F1; color: #fff; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 999px; letter-spacing: .04em; }

/* Forms */
.flw10-fg { margin-bottom: 24px; }
.flw10-fg:last-child { margin-bottom: 0; }
.flw10-label { display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 8px; }
.flw10-input, .flw10-select { width: 100%; padding: 13px 16px; font-size: 15px; font-family: inherit; color: #1E293B; background: #fff; border: 1.5px solid #E2E8F0; border-radius: 10px; outline: none; transition: border-color .2s, box-shadow .2s; }
.flw10-input::placeholder { color: #94A3B8; }
.flw10-input:focus, .flw10-select:focus { border-color: #FB923C; box-shadow: 0 0 0 3px rgba(249,115,22,.12); }
.flw10-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394A3B8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; cursor: pointer; }
.flw10-hint { margin-top: 6px; font-size: 12px; color: #94A3B8; display: flex; align-items: center; gap: 5px; }
.flw10-hint svg { color: #6366F1; }
.flw10-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.flw10-info-note { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; font-size: 13px; color: #64748B; line-height: 1.55; margin-top: 16px; }
.flw10-info-note svg { color: #6366F1; flex-shrink: 0; margin-top: 1px; }

/* Packages */
.flw10-pkg-list { display: flex; flex-direction: column; gap: 14px; }
.flw10-pkg { border: 1.5px solid #E2E8F0; border-radius: 14px; padding: 20px 24px; cursor: pointer; display: flex; align-items: center; gap: 20px; transition: all .2s; background: #fff; position: relative; }
.flw10-pkg:hover { border-color: #CBD5E1; background: #F8FAFC; }
.flw10-pkg.selected { border-color: #F97316; background: #FFF7ED; box-shadow: 0 0 0 3px rgba(249,115,22,.10); }
.flw10-radio { width: 20px; height: 20px; border-radius: 50%; border: 2px solid #CBD5E1; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all .2s; }
.flw10-pkg.selected .flw10-radio { border-color: #F97316; background: #F97316; }
.flw10-radio-dot { width: 8px; height: 8px; background: #fff; border-radius: 50%; opacity: 0; transition: opacity .2s; }
.flw10-pkg.selected .flw10-radio-dot { opacity: 1; }
.flw10-pkg-info { flex: 1; }
.flw10-pkg-name-row { display: flex; align-items: center; gap: 10px; margin-bottom: 4px; }
.flw10-pkg-name { font-size: 16px; font-weight: 700; color: #1E293B; }
.flw10-pkg.selected .flw10-pkg-name { color: #C2410C; }
.flw10-badge { font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 999px; letter-spacing: .04em; }
.flw10-badge.popular { background: #EEF2FF; color: #4F46E5; }
.flw10-badge.best { background: #FFF7ED; color: #EA580C; border: 1px solid #FFEDD5; }
.flw10-pkg-desc { font-size: 13px; color: #94A3B8; }
.flw10-pkg-price { text-align: right; flex-shrink: 0; }
.flw10-pkg-price-main { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: 24px; font-weight: 800; color: #0F172A; line-height: 1; }
.flw10-pkg-price-note { font-size: 11px; color: #94A3B8; margin-top: 2px; }

/* Review */
.flw10-review-list { display: flex; flex-direction: column; gap: 0; border: 1px solid #E2E8F0; border-radius: 12px; overflow: hidden; }
.flw10-review-row { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid #F1F5F9; gap: 12px; }
.flw10-review-row:last-child { border-bottom: none; }
.flw10-review-row:nth-child(even) { background: #F8FAFC; }
.flw10-review-label { font-size: 13px; font-weight: 600; color: #64748B; white-space: nowrap; }
.flw10-review-value { font-size: 14px; font-weight: 600; color: #1E293B; text-align: right; }
.flw10-review-edit { font-size: 12px; color: #6366F1; cursor: pointer; font-weight: 600; white-space: nowrap; transition: color .15s; }
.flw10-review-edit:hover { color: #4F46E5; }
.flw10-total-row { display: flex; align-items: center; justify-content: space-between; padding: 20px; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; margin-top: 16px; }
.flw10-total-label { font-size: 15px; font-weight: 700; color: #1E293B; }
.flw10-total-value { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: 22px; font-weight: 800; color: #F97316; }
.flw10-guarantee { display: flex; align-items: center; gap: 10px; padding: 14px 18px; background: #EEF2FF; border: 1px solid #E0E7FF; border-radius: 10px; margin-top: 16px; font-size: 13px; color: #4F46E5; font-weight: 500; }
.flw10-guarantee svg { color: #6366F1; flex-shrink: 0; }

/* Buttons */
.flw10-btn { display: inline-flex; align-items: center; gap: 8px; background: #F97316; color: #fff; font-family: inherit; font-size: 15px; font-weight: 600; padding: 13px 32px; border-radius: 10px; border: none; cursor: pointer; box-shadow: 0 4px 16px rgba(249,115,22,.35); transition: all .2s ease; white-space: nowrap; }
.flw10-btn:hover { background: #EA580C; box-shadow: 0 6px 22px rgba(249,115,22,.45); transform: translateY(-1px); }
.flw10-btn-back { display: inline-flex; align-items: center; gap: 6px; background: transparent; color: #64748B; font-family: inherit; font-size: 14px; font-weight: 600; padding: 10px 18px; border-radius: 10px; border: 1.5px solid #E2E8F0; cursor: pointer; transition: all .2s; }
.flw10-btn-back:hover { border-color: #CBD5E1; background: #F8FAFC; color: #334155; }

/* Progress bar */
.flw10-pbar-wrap { height: 4px; background: #F1F5F9; border-radius: 99px; margin: 0 40px; overflow: hidden; }
.flw10-pbar-fill { height: 100%; background: #F97316; border-radius: 99px; transition: width .4s ease; }

/* Trust footer */
.flw10-trust { display: flex; align-items: center; justify-content: center; gap: 24px; margin-top: 28px; flex-wrap: wrap; }
.flw10-trust-item { display: flex; align-items: center; gap: 7px; font-size: 13px; color: #94A3B8; }
.flw10-trust-item svg { color: #6366F1; }

/* Panels */
.flw10-panel { display: none; animation: flw10FadeSlide .3s ease; }
.flw10-panel.active { display: block; }
@keyframes flw10FadeSlide { from { opacity: 0; transform: translateX(16px); } to { opacity: 1; transform: translateX(0); } }

/* Done */
.flw10-done { text-align: center; padding: 60px 40px; }
.flw10-done-icon { width: 72px; height: 72px; background: #EEF2FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: #6366F1; }
.flw10-done h2 { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: 26px; font-weight: 800; color: #0F172A; margin-bottom: 12px; }
.flw10-done p { font-size: 15px; color: #64748B; max-width: 400px; margin: 0 auto 32px; line-height: 1.65; }
.flw10-done-badge { display: inline-flex; align-items: center; gap: 8px; background: #FFF7ED; border: 1px solid #FFEDD5; padding: 10px 20px; border-radius: 999px; font-size: 13px; font-weight: 600; color: #EA580C; }
</style>

<div class="flw10-wizard" id="<?php echo esc_attr( $uid ); ?>">

  <!-- Navbar -->
  <nav class="flw10-nav">
    <div class="flw10-nav-inner">
      <div class="flw10-logo">Biz<span>Jump</span></div>
      <div class="flw10-nav-actions">
        <a href="<?php echo $change_url; ?>" class="flw10-change-link">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          Change entity type
        </a>
        <div class="flw10-secure">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
          Secure &amp; encrypted
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <div class="flw10-hero" data-flw10-hero>
    <h1 data-flw10-hero-title><?php echo esc_html( $s['hero_title'] ); ?></h1>
    <p data-flw10-hero-sub><?php echo esc_html( $s['hero_subtitle'] ); ?></p>
  </div>

  <!-- Progress -->
  <div class="flw10-progress" data-flw10-progress>
    <div class="flw10-progress-inner">
      <div class="flw10-step active" data-flw10-prog="1"><div class="flw10-circle">1</div><div class="flw10-step-label"><?php echo esc_html( $s['step_1_label'] ); ?></div></div>
      <div class="flw10-step inactive" data-flw10-prog="2"><div class="flw10-circle">2</div><div class="flw10-step-label"><?php echo esc_html( $s['step_2_label'] ); ?></div></div>
      <div class="flw10-step inactive" data-flw10-prog="3"><div class="flw10-circle">3</div><div class="flw10-step-label"><?php echo esc_html( $s['step_3_label'] ); ?></div></div>
      <div class="flw10-step inactive" data-flw10-prog="4"><div class="flw10-circle">4</div><div class="flw10-step-label"><?php echo esc_html( $s['step_4_label'] ); ?></div></div>
    </div>
  </div>

  <div class="flw10-body">
    <div class="flw10-card">

      <!-- STEP 1 -->
      <div class="flw10-panel active" data-flw10-panel="1">
        <div class="flw10-card-header">
          <div class="flw10-tag">Step 1 of 4</div>
          <h2>What type of business do you want to form?</h2>
          <p>Choose the entity that best fits your business goals. Not sure? LLC is the most popular choice.</p>
        </div>
        <div class="flw10-pbar-wrap" style="margin-top:24px;"><div class="flw10-pbar-fill" style="width:25%"></div></div>
        <div class="flw10-card-body">
          <div class="flw10-entity-grid">
            <div class="flw10-entity-card selected" data-flw10-entity="llc">
              <div class="flw10-entity-popular">Most Popular</div>
              <div class="flw10-entity-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg></div>
              <div class="flw10-entity-info"><div class="flw10-entity-name">LLC</div><div class="flw10-entity-desc">Limited liability protection with flexible management and tax options.</div></div>
              <div class="flw10-entity-check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            </div>
            <div class="flw10-entity-card" data-flw10-entity="c_corp">
              <div class="flw10-entity-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg></div>
              <div class="flw10-entity-info"><div class="flw10-entity-name">C Corporation</div><div class="flw10-entity-desc">Best for startups seeking venture capital or planning to go public.</div></div>
              <div class="flw10-entity-check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            </div>
            <div class="flw10-entity-card" data-flw10-entity="s_corp">
              <div class="flw10-entity-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
              <div class="flw10-entity-info"><div class="flw10-entity-name">S Corporation</div><div class="flw10-entity-desc">Pass-through taxation with corporate liability protection.</div></div>
              <div class="flw10-entity-check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            </div>
            <div class="flw10-entity-card" data-flw10-entity="non_profit">
              <div class="flw10-entity-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><line x1="12" y1="12" x2="12" y2="12"/></svg></div>
              <div class="flw10-entity-info"><div class="flw10-entity-name">Nonprofit</div><div class="flw10-entity-desc">For charitable, educational, or religious organizations seeking 501(c)(3) status.</div></div>
              <div class="flw10-entity-check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            </div>
          </div>
        </div>
        <div class="flw10-card-footer">
          <div></div>
          <button type="button" class="flw10-btn" data-flw10-go="2">Continue<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></button>
        </div>
      </div>

      <!-- STEP 2 -->
      <div class="flw10-panel" data-flw10-panel="2">
        <div class="flw10-card-header">
          <div class="flw10-tag">Step 2 of 4</div>
          <h2>Tell us about your business</h2>
          <p>This information will appear on your official state filing documents.</p>
        </div>
        <div class="flw10-pbar-wrap" style="margin-top:24px;"><div class="flw10-pbar-fill" style="width:50%"></div></div>
        <div class="flw10-card-body">
          <div class="flw10-fg">
            <label class="flw10-label">Business Name</label>
            <input type="text" class="flw10-input" data-flw10-field="business_name" placeholder="e.g. Sunrise Ventures LLC">
            <div class="flw10-hint">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              We'll check availability in your state automatically.
            </div>
          </div>
          <div class="flw10-fg">
            <label class="flw10-label">State of Formation</label>
            <select class="flw10-select" data-flw10-field="state">
              <option value="" disabled selected>Select a state...</option>
              <?php
              $states = [
                  'AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut',
                  'DE'=>'Delaware','DC'=>'District of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois',
                  'IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland',
                  'MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana',
                  'NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York',
                  'NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania',
                  'RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah',
                  'VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming',
              ];
              foreach ( $states as $slug => $name ) {
                  printf( '<option value="%s">%s</option>', esc_attr( $slug ), esc_html( $name ) );
              }
              ?>
            </select>
          </div>
          <div class="flw10-row">
            <div class="flw10-fg" style="margin-bottom:0">
              <label class="flw10-label">First Name</label>
              <input type="text" class="flw10-input" data-flw10-field="first_name" placeholder="John">
            </div>
            <div class="flw10-fg" style="margin-bottom:0">
              <label class="flw10-label">Last Name</label>
              <input type="text" class="flw10-input" data-flw10-field="last_name" placeholder="Smith">
            </div>
          </div>
          <div class="flw10-fg" style="margin-top:24px">
            <label class="flw10-label">Email Address</label>
            <input type="email" class="flw10-input" data-flw10-field="email" placeholder="you@example.com">
          </div>
          <div class="flw10-info-note">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Your information is protected by 256-bit SSL encryption and will never be sold to third parties.
          </div>
        </div>
        <div class="flw10-card-footer">
          <button type="button" class="flw10-btn-back" data-flw10-go="1"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>Back</button>
          <button type="button" class="flw10-btn" data-flw10-go="3">Continue<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></button>
        </div>
      </div>

      <!-- STEP 3 -->
      <div class="flw10-panel" data-flw10-panel="3">
        <div class="flw10-card-header">
          <div class="flw10-tag">Step 3 of 4</div>
          <h2>Choose your formation package</h2>
          <p>All packages include filing and name availability check. State fee is added at checkout.</p>
        </div>
        <div class="flw10-pbar-wrap" style="margin-top:24px;"><div class="flw10-pbar-fill" style="width:75%"></div></div>
        <div class="flw10-card-body">
          <div class="flw10-pkg-list">
            <?php foreach ( $packages as $i => $pkg ) :
                $sel    = ! empty( $pkg['selected'] ) && $pkg['selected'] === 'yes';
                $price  = isset( $pkg['price'] ) ? (int) $pkg['price'] : 0;
                $badge  = ! empty( $pkg['badge'] ) ? trim( $pkg['badge'] ) : '';
                $bstyle = ! empty( $pkg['badge_style'] ) ? $pkg['badge_style'] : 'popular';
                $pkey   = ! empty( $pkg['pkg_key'] ) ? sanitize_key( $pkg['pkg_key'] ) : '';
            ?>
            <div class="flw10-pkg<?php echo $sel ? ' selected' : ''; ?>"
                 data-flw10-pkg-index="<?php echo (int) $i; ?>"
                 data-flw10-pkg-key="<?php echo esc_attr( $pkey ); ?>"
                 data-flw10-pkg-name="<?php echo esc_attr( $pkg['name'] ); ?>"
                 data-flw10-pkg-price="<?php echo (int) $price; ?>">
              <div class="flw10-radio"><div class="flw10-radio-dot"></div></div>
              <div class="flw10-pkg-info">
                <div class="flw10-pkg-name-row">
                  <div class="flw10-pkg-name"><?php echo esc_html( $pkg['name'] ); ?></div>
                  <?php if ( $badge ) : ?>
                    <span class="flw10-badge <?php echo esc_attr( $bstyle ); ?>"><?php echo esc_html( $badge ); ?></span>
                  <?php endif; ?>
                </div>
                <div class="flw10-pkg-desc"><?php echo esc_html( $pkg['desc'] ); ?></div>
              </div>
              <div class="flw10-pkg-price">
                <div class="flw10-pkg-price-main">$<?php echo (int) $price; ?></div>
                <div class="flw10-pkg-price-note"><?php echo esc_html( $pkg['price_note'] ); ?></div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="flw10-card-footer">
          <button type="button" class="flw10-btn-back" data-flw10-go="2"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>Back</button>
          <button type="button" class="flw10-btn" data-flw10-go="4">Review Order<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></button>
        </div>
      </div>

      <!-- STEP 4 -->
      <div class="flw10-panel" data-flw10-panel="4">
        <div class="flw10-card-header">
          <div class="flw10-tag">Step 4 of 4</div>
          <h2>Review your order</h2>
          <p>Everything look right? You can edit any details before completing.</p>
        </div>
        <div class="flw10-pbar-wrap" style="margin-top:24px;"><div class="flw10-pbar-fill" style="width:100%"></div></div>
        <div class="flw10-card-body">
          <div class="flw10-review-list">
            <div class="flw10-review-row">
              <div class="flw10-review-label">Entity Type</div><div style="flex:1"></div>
              <div class="flw10-review-value" data-flw10-review="entity">LLC</div>
              <div class="flw10-review-edit" data-flw10-go="1">Edit</div>
            </div>
            <div class="flw10-review-row">
              <div class="flw10-review-label">Business Name</div><div style="flex:1"></div>
              <div class="flw10-review-value" data-flw10-review="business_name">Sunrise Ventures LLC</div>
              <div class="flw10-review-edit" data-flw10-go="2">Edit</div>
            </div>
            <div class="flw10-review-row">
              <div class="flw10-review-label">State</div><div style="flex:1"></div>
              <div class="flw10-review-value" data-flw10-review="state">Texas</div>
              <div class="flw10-review-edit" data-flw10-go="2">Edit</div>
            </div>
            <div class="flw10-review-row">
              <div class="flw10-review-label">Contact</div><div style="flex:1"></div>
              <div class="flw10-review-value" data-flw10-review="contact">John Smith</div>
              <div class="flw10-review-edit" data-flw10-go="2">Edit</div>
            </div>
            <div class="flw10-review-row">
              <div class="flw10-review-label">Package</div><div style="flex:1"></div>
              <div class="flw10-review-value" data-flw10-review="package">Pro — $149</div>
              <div class="flw10-review-edit" data-flw10-go="3">Edit</div>
            </div>
            <div class="flw10-review-row">
              <div class="flw10-review-label">State Filing Fee</div><div style="flex:1"></div>
              <div class="flw10-review-value" data-flw10-review="state_fee"><?php echo esc_html( $s['state_filing_fee'] ); ?></div>
              <div class="flw10-review-edit" style="opacity:0;pointer-events:none;">Edit</div>
            </div>
          </div>
          <div class="flw10-total-row">
            <div class="flw10-total-label">Total Due Today</div>
            <div class="flw10-total-value" data-flw10-review="total">$449</div>
          </div>
          <div class="flw10-guarantee">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            100% satisfaction guarantee. If we make an error, we'll correct it at no extra charge.
          </div>
        </div>
        <div class="flw10-card-footer">
          <button type="button" class="flw10-btn-back" data-flw10-go="3"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>Back</button>
          <button type="button" class="flw10-btn" data-flw10-complete>Complete Purchase — <span data-flw10-review="total-btn">$449</span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></button>
        </div>
      </div>

      <!-- DONE -->
      <div class="flw10-panel" data-flw10-panel="done">
        <div class="flw10-done">
          <div class="flw10-done-icon"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
          <h2><?php echo esc_html( $s['done_title'] ); ?></h2>
          <p><?php echo wp_kses_post( $s['done_message'] ); ?></p>
          <div class="flw10-done-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Estimated completion: 1–3 business days
          </div>
        </div>
      </div>

    </div>

    <div class="flw10-trust">
      <div class="flw10-trust-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>256-bit SSL encryption</div>
      <div class="flw10-trust-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>100% satisfaction guarantee</div>
      <div class="flw10-trust-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>Expert support 7 days/week</div>
      <div class="flw10-trust-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>4M+ businesses formed</div>
    </div>
  </div>
</div>

<script>
(function(){
  var rootId = <?php echo wp_json_encode( $uid ); ?>;
  var root   = document.getElementById(rootId);
  if (!root || root.dataset.flw10Init === '1') return;
  root.dataset.flw10Init = '1';

  // Keyed by bizjump-wizard's entity slugs (used directly in WC AJAX).
  var entityLabels = {
    llc:        { name: 'LLC',           title: 'Form Your LLC',           subtitle: 'Limited liability, flexible taxes — the most popular structure for small business owners.' },
    c_corp:     { name: 'C Corporation', title: 'Form Your C Corporation', subtitle: 'Issue stock, attract investors, and build a scalable corporate structure.' },
    s_corp:     { name: 'S Corporation', title: 'Form Your S Corporation', subtitle: 'Corporate liability protection with pass-through taxation for small profitable businesses.' },
    non_profit: { name: 'Nonprofit',     title: 'Form Your Nonprofit',     subtitle: 'Pursue your mission with 501(c)(3) tax-exempt status and credibility with donors.' }
  };

  // Map URL entity aliases (FLW-02 buttons + footer) -> bizjump-wizard's slugs.
  var entityAlias = {
    corporation: 'c_corp',
    ccorp:       'c_corp',
    scorp:       's_corp',
    nonprofit:   'non_profit',
    dba:         'llc' // DBA is not a WC product; fall back to LLC at checkout
  };

  var state = {
    step: 1,
    entity: 'llc',
    pkgIndex: -1,
    pkgKey: '',
    pkgName: '',
    pkgPrice: 0,
    stateSlug: '',
    stateName: '',
    stateFilingFee: 0
  };

  // Pick initial entity from URL — accept aliases (corporation, scorp, nonprofit, dba).
  var params = new URLSearchParams(window.location.search);
  var entityParam = (params.get('entity') || 'llc').toLowerCase();
  if (entityAlias[entityParam]) entityParam = entityAlias[entityParam];
  if (!entityLabels[entityParam]) entityParam = 'llc';
  state.entity = entityParam;

  // Pre-select matching entity card
  root.querySelectorAll('[data-flw10-entity]').forEach(function(c){ c.classList.remove('selected'); });
  var match = root.querySelector('[data-flw10-entity="' + entityParam + '"]');
  if (match) match.classList.add('selected');

  // Update hero text from entity label map
  var info = entityLabels[entityParam];
  if (info) {
    var h1 = root.querySelector('[data-flw10-hero-title]');
    var p  = root.querySelector('[data-flw10-hero-sub]');
    if (h1) h1.textContent = info.title;
    if (p)  p.textContent  = info.subtitle;
  }

  // Pick initial package (the one rendered with .selected, or first)
  var initialPkg = root.querySelector('.flw10-pkg.selected') || root.querySelector('.flw10-pkg');
  if (initialPkg) {
    state.pkgIndex = parseInt(initialPkg.getAttribute('data-flw10-pkg-index'), 10) || 0;
    state.pkgKey   = initialPkg.getAttribute('data-flw10-pkg-key') || '';
    state.pkgName  = initialPkg.getAttribute('data-flw10-pkg-name') || '';
    state.pkgPrice = parseInt(initialPkg.getAttribute('data-flw10-pkg-price'), 10) || 0;
  }

  // Lookup state filing fee from BJW.stateFees (provided by bizjump-wizard plugin).
  function lookupStateFee(slug) {
    if (!slug) return { fee: 0, name: '' };
    if (window.BJW && Array.isArray(window.BJW.stateFees)) {
      for (var i = 0; i < window.BJW.stateFees.length; i++) {
        var s = window.BJW.stateFees[i];
        if (String(s.slug).toUpperCase() === String(slug).toUpperCase()) {
          return { fee: parseFloat(s.fee) || 0, name: s.name || slug };
        }
      }
    }
    return { fee: 0, name: slug };
  }

  // Sync state info when the state select changes.
  var stateSelect = root.querySelector('[data-flw10-field="state"]');
  if (stateSelect) {
    stateSelect.addEventListener('change', function(){
      state.stateSlug = stateSelect.value || '';
      var info = lookupStateFee(state.stateSlug);
      state.stateFilingFee = info.fee;
      state.stateName = info.name || (stateSelect.options[stateSelect.selectedIndex] ? stateSelect.options[stateSelect.selectedIndex].text : '');
    });
  }

  function setStep(step) {
    // Hide all panels
    root.querySelectorAll('[data-flw10-panel]').forEach(function(p){ p.classList.remove('active'); });
    // Show panel
    var target = root.querySelector('[data-flw10-panel="' + step + '"]');
    if (target) target.classList.add('active');

    // Show/hide hero + progress for done state
    var hero = root.querySelector('[data-flw10-hero]');
    var prog = root.querySelector('[data-flw10-progress]');
    if (step === 'done') {
      if (hero) hero.style.display = 'none';
      if (prog) prog.style.display = 'none';
    } else {
      if (hero) hero.style.display = '';
      if (prog) prog.style.display = '';
      state.step = step;
      // Update progress dots
      for (var i = 1; i <= 4; i++) {
        var dot = root.querySelector('[data-flw10-prog="' + i + '"]');
        if (!dot) continue;
        dot.classList.remove('active','completed','inactive');
        var circle = dot.querySelector('.flw10-circle');
        if (i < step) {
          dot.classList.add('completed');
          if (circle) circle.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
        } else if (i === step) {
          dot.classList.add('active');
          if (circle) circle.textContent = String(i);
        } else {
          dot.classList.add('inactive');
          if (circle) circle.textContent = String(i);
        }
      }
    }

    if (step === 4) renderReview();

    // Smooth scroll wizard into view (not the very top — keeps wizard hero visible)
    try {
      root.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } catch (e) { window.scrollTo(0, 0); }
  }

  function renderReview() {
    var f = function(name){ var el = root.querySelector('[data-flw10-field="' + name + '"]'); return el ? (el.value || '').trim() : ''; };
    var bn = f('business_name') || 'Sunrise Ventures LLC';
    var fn = f('first_name') || 'John';
    var ln = f('last_name') || 'Smith';
    var contact = (fn + ' ' + ln).trim() || 'John Smith';
    var entLabel = entityLabels[state.entity] ? entityLabels[state.entity].name : state.entity;
    var pkgLabel = state.pkgName + ' — $' + state.pkgPrice;

    // Resolve the selected state (slug → name + fee). If user hasn't picked, leave blank.
    var stateInfo = lookupStateFee(state.stateSlug);
    if (state.stateSlug && stateSelect) {
      stateInfo.name = stateInfo.name || (stateSelect.options[stateSelect.selectedIndex] ? stateSelect.options[stateSelect.selectedIndex].text : '');
    }
    var stateLabel = state.stateSlug ? (stateInfo.name || state.stateSlug) : 'Not selected';
    var feeLabel   = state.stateSlug
        ? '$' + stateInfo.fee.toFixed(2) + ' (' + state.stateSlug + ')'
        : 'Set at checkout';
    var totalNum = state.pkgPrice + (state.stateSlug ? stateInfo.fee : 0);
    var total    = '$' + totalNum.toFixed(2);

    setReview('entity', entLabel);
    setReview('business_name', bn);
    setReview('state', stateLabel);
    setReview('contact', contact);
    setReview('package', pkgLabel);
    setReview('total', total);
    var totalBtn = root.querySelector('[data-flw10-review="total-btn"]');
    if (totalBtn) totalBtn.textContent = total;

    // Update the dynamic state-filing-fee row, if rendered.
    var feeRow = root.querySelector('[data-flw10-review="state_fee"]');
    if (feeRow) feeRow.textContent = feeLabel;
  }
  function setReview(key, val) {
    var el = root.querySelector('[data-flw10-review="' + key + '"]');
    if (el) el.textContent = val;
  }

  // Entity card click
  root.querySelectorAll('[data-flw10-entity]').forEach(function(card){
    card.addEventListener('click', function(){
      root.querySelectorAll('[data-flw10-entity]').forEach(function(c){ c.classList.remove('selected'); });
      card.classList.add('selected');
      state.entity = card.getAttribute('data-flw10-entity');
      var info = entityLabels[state.entity];
      if (info) {
        var h1 = root.querySelector('[data-flw10-hero-title]');
        var p  = root.querySelector('[data-flw10-hero-sub]');
        if (h1) h1.textContent = info.title;
        if (p)  p.textContent  = info.subtitle;
      }
    });
  });

  // Package click
  root.querySelectorAll('.flw10-pkg').forEach(function(pkg){
    pkg.addEventListener('click', function(){
      root.querySelectorAll('.flw10-pkg').forEach(function(c){ c.classList.remove('selected'); });
      pkg.classList.add('selected');
      state.pkgIndex = parseInt(pkg.getAttribute('data-flw10-pkg-index'), 10) || 0;
      state.pkgKey   = pkg.getAttribute('data-flw10-pkg-key') || '';
      state.pkgName  = pkg.getAttribute('data-flw10-pkg-name') || '';
      state.pkgPrice = parseInt(pkg.getAttribute('data-flw10-pkg-price'), 10) || 0;
    });
  });

  // Navigation buttons (Back / Continue / review-edit)
  root.querySelectorAll('[data-flw10-go]').forEach(function(btn){
    btn.addEventListener('click', function(){
      var t = btn.getAttribute('data-flw10-go');
      var step = (t === 'done') ? 'done' : parseInt(t, 10);
      setStep(step);
    });
  });

  // Complete Purchase — submit to bizjump-wizard's AJAX endpoint if available,
  // otherwise show the local "done" panel.
  var completeBtn = root.querySelector('[data-flw10-complete]');
  if (completeBtn) {
    completeBtn.addEventListener('click', function(){
      // If bizjump-wizard plugin isn't active, fall back to fake done.
      if (!window.BJW || !window.BJW.ajaxUrl || !window.BJW.nonce) {
        console.warn('[FLW-10] bizjump-wizard plugin not detected (window.BJW missing). Showing local done panel. Activate the plugin for real WooCommerce checkout.');
        setStep('done');
        return;
      }

      // Validate required fields for the AJAX handler.
      if (!state.pkgKey) {
        alert('Please select a package.');
        return;
      }
      if (!state.stateSlug) {
        alert('Please select a state of formation.');
        setStep(2);
        return;
      }

      var f = function(name){ var el = root.querySelector('[data-flw10-field="' + name + '"]'); return el ? (el.value || '').trim() : ''; };
      var firstName = f('first_name');
      var lastName  = f('last_name');

      // Lock the button while we submit.
      var origText = completeBtn.innerHTML;
      completeBtn.disabled = true;
      completeBtn.innerHTML = 'Preparing your order…';

      var body = new URLSearchParams();
      body.set('action',           'bj_create_order');
      body.set('nonce',            window.BJW.nonce);
      body.set('plan',             state.pkgKey);
      body.set('state',            state.stateSlug);
      body.set('entity',           state.entity);
      body.set('business_name',    f('business_name'));
      body.set('designator',       '');
      body.set('business_address', '');
      body.set('first_name',       firstName);
      body.set('last_name',        lastName);
      body.set('contact_person',   (firstName + ' ' + lastName).trim());
      body.set('contact_email',    f('email'));
      body.set('contact_phone',    '');
      body.set('sms_consent',      '0');

      fetch(window.BJW.ajaxUrl, {
        method:  'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body:    body.toString()
      })
      .then(function(res){ return res.json(); })
      .then(function(json){
        if (json && json.success && json.data && json.data.redirect) {
          window.location.href = json.data.redirect;
        } else {
          var msg = (json && json.data && json.data.message) ? json.data.message : 'Something went wrong. Please try again.';
          alert(msg);
          completeBtn.disabled  = false;
          completeBtn.innerHTML = origText;
        }
      })
      .catch(function(){
        alert('Network error. Please check your connection and try again.');
        completeBtn.disabled  = false;
        completeBtn.innerHTML = origText;
      });
    });
  }
})();
</script>
        <?php
    }
}
