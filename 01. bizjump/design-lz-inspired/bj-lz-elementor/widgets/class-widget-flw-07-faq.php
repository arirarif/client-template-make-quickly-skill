<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-07 — FAQ (Formation Landing)
 * Cream-tinted (#F5F2EE) section with narrow accordion.
 */
class Widget_FLW_FAQ extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_07_faq'; }
    public function get_title()      { return 'FLW 07 — FAQ Accordion'; }
    public function get_icon()       { return 'eicon-help-o'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'faq', 'accordion', 'questions', 'bizjump', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_header', [
            'label' => 'Section Header', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'label_text', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'FAQ' ] );
        $this->add_control( 'title_text', [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Questions About Formation' ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_items', [
            'label' => 'FAQ Items', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'q', [ 'label' => 'Question', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Question?' ] );
        $rep->add_control( 'a', [ 'label' => 'Answer',   'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Answer.' ] );
        $rep->add_control( 'open', [
            'label' => 'Open by default', 'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes', 'default' => '',
        ] );
        $this->add_control( 'items', [
            'label' => 'Items', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $rep->get_controls(),
            'default' => [
                [ 'q' => "What's the difference between an LLC and a Corporation?", 'a' => 'An LLC offers flexible management and pass-through taxation, making it ideal for most small businesses. A Corporation (C or S) has a stricter structure with shareholders and a board of directors — better suited if you plan to raise investor capital or go public.', 'open' => 'yes' ],
                [ 'q' => 'Do I need an attorney to form an LLC or corporation?', 'a' => 'No. BizJump prepares and files all required documents with the state on your behalf. While attorneys can help with complex situations, most straightforward formations are completed entirely through our platform.', 'open' => '' ],
                [ 'q' => 'How long does business formation take?', 'a' => 'State processing times vary — typically 3–7 business days for standard filings. With our Pro or Premium plan, you get priority processing that can be as fast as 24 hours depending on your state.', 'open' => '' ],
                [ 'q' => 'Can I change my entity type later?', 'a' => 'Yes, though it may involve additional filings and fees. Many businesses start as LLCs and later convert to corporations as they grow. BizJump can assist with conversions at any stage.', 'open' => '' ],
            ],
            'title_field' => '{{{ q }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.flw07-section { padding: 72px 0; background: #F5F2EE; font-family: 'Inter', sans-serif; }
.flw07-inner { max-width: 720px; margin: 0 auto; padding: 0 24px; }
.flw07-header { text-align: center; margin-bottom: 48px; }
.flw07-label { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #F97316; margin-bottom: 10px; }
.flw07-title { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: clamp(22px,3vw,34px); font-weight: 800; color: #0F172A; line-height: 1.2; letter-spacing: -.02em; margin: 0 0 12px; }

.flw07-list { display: flex; flex-direction: column; gap: 8px; }
.flw07-item { background: #fff; border: 1px solid #E2E8F0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(15,23,42,.06); }
.flw07-q { display: flex; align-items: center; justify-content: space-between; padding: 18px 22px; cursor: pointer; font-size: 14px; font-weight: 600; color: #1E293B; transition: background .15s; gap: 12px; user-select: none; }
.flw07-q:hover { background: #F8FAFC; }
.flw07-icon { width: 22px; height: 22px; background: #F1F5F9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #94A3B8; flex-shrink: 0; transition: all .2s; }
.flw07-item.flw07-open .flw07-icon { background: #FFF7ED; color: #F97316; transform: rotate(45deg); }
.flw07-item.flw07-open { border-color: #FFEDD5; }
.flw07-a { padding: 0 22px; max-height: 0; overflow: hidden; transition: max-height .3s ease, padding .3s ease; font-size: 14px; color: #64748B; line-height: 1.7; }
.flw07-item.flw07-open .flw07-a { max-height: 360px; padding: 0 22px 18px; }

@media (max-width: 600px) {
  .flw07-section { padding: 56px 0; }
  .flw07-q { padding: 16px 18px; font-size: 13.5px; }
  .flw07-a { font-size: 13.5px; }
  .flw07-item.flw07-open .flw07-a { padding: 0 18px 16px; max-height: 540px; }
}
</style>

<section class="flw07-section">
  <div class="flw07-inner">
    <div class="flw07-header">
      <span class="flw07-label"><?php echo esc_html( $s['label_text'] ); ?></span>
      <h2 class="flw07-title"><?php echo esc_html( $s['title_text'] ); ?></h2>
    </div>
    <div class="flw07-list">
      <?php foreach ( (array) $s['items'] as $it ) :
        $is_open = ! empty( $it['open'] ) && $it['open'] === 'yes';
      ?>
      <div class="flw07-item<?php echo $is_open ? ' flw07-open' : ''; ?>">
        <div class="flw07-q" onclick="(function(el){var i=el.closest('.flw07-item');var o=i.classList.contains('flw07-open');i.parentElement.querySelectorAll('.flw07-item').forEach(function(x){x.classList.remove('flw07-open');});if(!o)i.classList.add('flw07-open');})(this)">
          <?php echo esc_html( $it['q'] ); ?>
          <div class="flw07-icon"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
        </div>
        <div class="flw07-a"><?php echo esc_html( $it['a'] ); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
