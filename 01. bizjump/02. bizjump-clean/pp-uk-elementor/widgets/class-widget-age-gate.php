<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Age_Gate extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_11_age_gate'; }
    public function get_title()      { return '11 — Age Gate'; }
    public function get_icon()       { return 'eicon-lock-user'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'age', 'gate', 'verify', '18+', 'pp-uk' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'section_content', [
            'label' => 'Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'badge', [
            'label'   => 'Badge Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Age Verification Required',
        ] );
        $this->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Are you 18 or older?',
        ] );
        $this->add_control( 'body', [
            'label'   => 'Body',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Performance Peptide UK sells research-only compounds strictly to adults aged 18 and above. By entering this site you confirm you meet this requirement and acknowledge that all products are for research purposes only — not for human consumption.',
            'rows'    => 4,
        ] );
        $this->add_control( 'accept_text', [
            'label'   => 'Accept Button',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'I am 18+ — Enter Site',
        ] );
        $this->add_control( 'exit_url', [
            'label'   => 'Exit URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => 'https://www.google.com' ],
        ] );
        $this->add_control( 'exit_text', [
            'label'   => 'Exit Button',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'I am under 18 — Exit',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s       = $this->get_settings_for_display();
        $exit_url = ! empty( $s['exit_url']['url'] ) ? esc_url( $s['exit_url']['url'] ) : 'https://www.google.com';
        ?>
<style>
  .pp-gate-overlay{display:none;position:fixed;inset:0;background:rgba(10,10,10,.92);z-index:99999;align-items:center;justify-content:center;padding:var(--pp-sp-24)}
  .pp-gate-overlay.pp-gate-show{display:flex}
  .pp-gate-card{background:var(--pp-surface);border:1px solid var(--pp-border);border-radius:var(--pp-r-lg);padding:var(--pp-sp-48);max-width:480px;width:100%;text-align:center;box-shadow:0 32px 80px rgba(0,0,0,.4)}
  .pp-gate-badge{font-family:var(--pp-f-mono);font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--pp-warn);background:rgba(138,82,0,.08);border:1px solid rgba(138,82,0,.15);border-radius:var(--pp-r-sm);padding:4px 12px;display:inline-block;margin-bottom:var(--pp-sp-24)}
  .pp-gate-title{font-size:28px;font-weight:600;color:var(--pp-ink);margin-bottom:var(--pp-sp-16);letter-spacing:-.02em}
  .pp-gate-body{font-size:14px;color:var(--pp-ink-2);line-height:1.7;margin-bottom:var(--pp-sp-32)}
  .pp-gate-actions{display:flex;flex-direction:column;gap:var(--pp-sp-12)}
  .pp-gate-accept{padding:16px;background:var(--pp-ink);color:var(--pp-bg);border:none;border-radius:var(--pp-r);font-family:var(--pp-f-sans);font-size:15px;font-weight:500;cursor:pointer;transition:opacity 150ms;letter-spacing:.01em}
  .pp-gate-accept:hover{opacity:.85}
  .pp-gate-exit{font-family:var(--pp-f-sans);font-size:13px;color:var(--pp-ink-3);text-decoration:none;padding:8px;display:block;transition:color 150ms;border-radius:var(--pp-r)}
  .pp-gate-exit:hover{color:var(--pp-ink)}
  @media(max-width:560px){
    .pp-gate-card{padding:var(--pp-sp-32) var(--pp-sp-24)}
    .pp-gate-title{font-size:24px}
    .pp-gate-body{font-size:13px}
    .pp-gate-accept{padding:14px;font-size:14px}
  }
</style>
<div id="ppAgeGate" class="pp-section pp-gate-overlay" role="dialog" aria-modal="true" aria-labelledby="ppGateTitle">
  <div class="pp-gate-card">
    <div class="pp-gate-badge"><?php echo esc_html( $s['badge'] ); ?></div>
    <h2 class="pp-gate-title" id="ppGateTitle"><?php echo esc_html( $s['title'] ); ?></h2>
    <p class="pp-gate-body"><?php echo esc_html( $s['body'] ); ?></p>
    <div class="pp-gate-actions">
      <button id="ppGateAccept" class="pp-gate-accept"><?php echo esc_html( $s['accept_text'] ); ?></button>
      <a href="<?php echo $exit_url; ?>" class="pp-gate-exit"><?php echo esc_html( $s['exit_text'] ); ?></a>
    </div>
  </div>
</div>
        <?php
    }
}
