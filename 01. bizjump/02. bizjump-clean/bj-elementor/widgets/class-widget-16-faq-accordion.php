<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 16 — FAQ Accordion
 * Expandable Q&A list with animated toggle.
 */
class Widget_FAQ_Accordion extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_16_faq'; }
    public function get_title()      { return '16 — FAQ Accordion'; }
    public function get_icon()       { return 'eicon-accordion'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'faq', 'accordion', 'questions', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        /* ── Header ── */
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'section_label', [
            'label'   => 'Section Label (eyebrow)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Common Questions',
        ] );

        $this->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Frequently Asked Questions',
        ] );

        $this->end_controls_section();

        /* ── FAQ Items ── */
        $this->start_controls_section( 'section_faqs', [
            'label' => 'FAQ Items',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'question', [
            'label'   => 'Question',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'What is the difference between an LLC and a corporation?',
        ] );

        $rep->add_control( 'answer', [
            'label'   => 'Answer',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Enter the answer here.',
            'rows'    => 4,
        ] );

        $this->add_control( 'faqs', [
            'label'       => 'FAQ Items',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'question' => "What\xe2\x80\x99s the difference between an LLC and a corporation?",
                    'answer'   => 'An LLC is simpler and more flexible, with fewer formal requirements and pass-through taxation by default. A corporation is more structured, requires a board of directors, and is better suited for raising capital and scaling.',
                ],
                [
                    'question' => "What\xe2\x80\x99s the difference between a C corporation and an S corporation?",
                    'answer'   => 'A C corporation is taxed separately from its owners (which can lead to double taxation). An S corporation avoids this by passing profits directly to owners for single-level taxation, but it has ownership limits and eligibility rules.',
                ],
                [
                    'question' => "What\xe2\x80\x99s the main difference between a sole proprietorship and an LLC?",
                    'answer'   => 'A sole proprietorship is the simplest structure but offers no separation between you and the business. An LLC creates a legal separation, protecting your personal assets from business liabilities.',
                ],
                [
                    'question' => 'How are different business types taxed?',
                    'answer'   => 'Sole proprietorships, partnerships, LLCs (by default), and S corporations typically use pass-through taxation, where profits are taxed once at the owner level. C corporations are taxed at the corporate level, and shareholders may also pay taxes on dividends.',
                ],
                [
                    'question' => 'Which business types give me personal liability protection?',
                    'answer'   => 'LLCs, corporations (C and S), LLPs, and professional corporations generally provide personal liability protection. Sole proprietorships and general partnerships do not.',
                ],
            ],
            'title_field' => '{{{ question }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s  = $this->get_settings_for_display();
        $id = 'bjw16-' . $this->get_id();
        ?>
<style>
.bjw16-wrap {
  background: #fff;
  padding: 80px 32px;
  font-family: 'Inter', sans-serif;
}
.bjw16-inner { max-width: 1120px; margin: 0 auto; }
.bjw16-header { text-align: center; margin-bottom: 52px; }
.bjw16-label {
  font-size: 12px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: #2563eb;
  margin-bottom: 10px; display: block;
}
.bjw16-title {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: clamp(26px, 3.2vw, 40px);
  font-weight: 800; color: #111827;
  line-height: 1.2; letter-spacing: -0.6px;
}
.bjw16-list { max-width: 800px; margin: 0 auto; }
.bjw16-item { border-bottom: 1px solid #e5e7eb; }
.bjw16-q {
  width: 100%; background: none; border: none;
  display: flex; align-items: center; justify-content: space-between;
  gap: 16px;
  padding: 22px 0; cursor: pointer;
  font-size: 16px; font-weight: 600; color: #111827;
  text-align: left; line-height: 1.5;
  font-family: 'Inter', sans-serif;
  transition: color .2s;
}
.bjw16-q:hover { color: #2563eb; }
.bjw16-icon {
  width: 28px; height: 28px; border-radius: 50%;
  background: #f3f4f6; border: 1px solid #e5e7eb;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px; font-weight: 400; color: #6b7280;
  flex-shrink: 0;
  transition: transform .3s, background .2s, color .2s;
}
.bjw16-item.bjw16-open .bjw16-icon {
  transform: rotate(45deg);
  background: #2563eb; color: #fff; border-color: #2563eb;
}
.bjw16-a {
  display: none;
  font-size: 15px; color: #4b5563;
  line-height: 1.8; padding: 0 0 22px;
  padding-right: 48px;
}
.bjw16-item.bjw16-open .bjw16-a { display: block; }
@media (max-width: 768px) {
  .bjw16-wrap { padding: 56px 16px; }
  .bjw16-q { font-size: 15px; padding: 18px 0; }
  .bjw16-a { font-size: 14px; padding-right: 0; }
}
</style>

<div class="bjw16-wrap" id="<?php echo esc_attr( $id ); ?>">
  <div class="bjw16-inner">

    <div class="bjw16-header">
      <span class="bjw16-label"><?php echo esc_html( $s['section_label'] ); ?></span>
      <h2 class="bjw16-title"><?php echo esc_html( $s['title'] ); ?></h2>
    </div>

    <div class="bjw16-list">
      <?php foreach ( $s['faqs'] as $faq ) : ?>
      <div class="bjw16-item">
        <button class="bjw16-q">
          <?php echo esc_html( $faq['question'] ); ?>
          <span class="bjw16-icon">+</span>
        </button>
        <div class="bjw16-a"><?php echo esc_html( $faq['answer'] ); ?></div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</div>

<script>
(function(){
  var wrap = document.getElementById('<?php echo esc_js( $id ); ?>');
  if(!wrap) return;
  wrap.querySelectorAll('.bjw16-q').forEach(function(btn){
    btn.addEventListener('click', function(){
      var item = btn.closest('.bjw16-item');
      var isOpen = item.classList.contains('bjw16-open');
      wrap.querySelectorAll('.bjw16-item.bjw16-open').forEach(function(el){ el.classList.remove('bjw16-open'); });
      if(!isOpen) item.classList.add('bjw16-open');
    });
  });
})();
</script>
        <?php
    }
}
