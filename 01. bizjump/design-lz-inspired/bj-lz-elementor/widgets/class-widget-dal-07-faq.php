<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DAL-07 — FAQ Accordion (Doc-Aligned Landing)
 * Source: 03. bizjump-doc-aligned/formation-landing.html — #faq
 * Eyebrow + section title above a stack of expandable Q/A items.
 * Open item: rotated + icon → x, orange-tinted border, soft orange shadow.
 * JS scoped to this widget instance.
 */
class Widget_DAL_FAQ extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dal_07_faq'; }
    public function get_title()      { return 'DAL 07 — FAQ Accordion'; }
    public function get_icon()       { return 'eicon-help-o'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'faq', 'accordion', 'questions', 'bizjump', 'dal' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_head', [
            'label' => 'Headline',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'FAQ',
        ] );
        $this->add_control( 'headline', [
            'label'   => 'Headline',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Frequently Asked Questions',
        ] );
        $this->add_control( 'first_open', [
            'label'        => 'First Item Open by Default',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );
        $this->add_control( 'one_at_a_time', [
            'label'        => 'Only One Item Open at a Time',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => '',
            'return_value' => 'yes',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_items', [
            'label' => 'Items',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'q', [
            'label' => 'Question',
            'type'  => \Elementor\Controls_Manager::TEXT,
        ] );
        $rep->add_control( 'a', [
            'label' => 'Answer (HTML allowed)',
            'type'  => \Elementor\Controls_Manager::TEXTAREA,
            'rows'  => 4,
        ] );
        $this->add_control( 'items', [
            'label'   => 'Items',
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $rep->get_controls(),
            'default' => [
                [
                    'q' => "What's the difference between an LLC and a corporation?",
                    'a' => 'An LLC is simpler and more flexible, with fewer formal requirements and pass-through taxation by default. A corporation is more structured, requires a board of directors, and is better suited for raising capital and scaling.',
                ],
                [
                    'q' => "What's the difference between a C corporation and an S corporation?",
                    'a' => 'A C corporation is taxed separately from its owners (which can lead to double taxation). An S corporation avoids this by passing profits directly to owners for single-level taxation, but it has ownership limits and eligibility rules.',
                ],
                [
                    'q' => "What's the main difference between a sole proprietorship and an LLC?",
                    'a' => 'A sole proprietorship is the simplest structure but offers no separation between you and the business. An LLC creates a legal separation, protecting your personal assets from business liabilities.',
                ],
                [
                    'q' => 'How are different business types taxed?',
                    'a' => 'Sole proprietorships, partnerships, LLCs (by default), and S corporations typically use pass-through taxation, where profits are taxed once at the owner level. C corporations are taxed at the corporate level, and shareholders may also pay taxes on dividends.',
                ],
                [
                    'q' => 'Which business types give me personal liability protection?',
                    'a' => 'LLCs, corporations (C and S), LLPs, and professional corporations generally provide personal liability protection. Sole proprietorships and general partnerships do not.',
                ],
            ],
            'title_field' => '{{{ q }}}',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_style', [
            'label' => 'Style',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'bg_color', [
            'label'   => 'Section Background',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
        ] );
        $this->add_control( 'orange_500', [
            'label'   => 'Orange Accent (open icon)',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#F97316',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s        = $this->get_settings_for_display();
        $bg       = esc_attr( $s['bg_color']   ?: '#ffffff' );
        $o500     = esc_attr( $s['orange_500'] ?: '#F97316' );
        $uid      = 'dal07_' . $this->get_id();
        $items    = (array) ( $s['items'] ?? [] );
        $first    = ( 'yes' === ( $s['first_open']    ?? 'yes' ) );
        $only_one = ( 'yes' === ( $s['one_at_a_time'] ?? '' ) );
        ?>
<style>
.<?php echo $uid; ?>.dal07-section {
  background: <?php echo $bg; ?>;
  padding: 80px 0;
  font-family: 'Inter', sans-serif;
}
.<?php echo $uid; ?> .dal07-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.<?php echo $uid; ?> .dal07-head { text-align: center; margin-bottom: 40px; }
.<?php echo $uid; ?> .dal07-eyebrow {
  display: inline-block;
  font-size: 11px; font-weight: 700;
  letter-spacing: .1em; text-transform: uppercase;
  color: <?php echo $o500; ?>; margin-bottom: 12px;
}
.<?php echo $uid; ?> .dal07-h2 {
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: clamp(26px, 3.4vw, 40px);
  font-weight: 800; line-height: 1.18;
  letter-spacing: -.02em; color: #0F172A; margin: 0;
}
.<?php echo $uid; ?> .dal07-list {
  display: flex; flex-direction: column; gap: 10px;
  max-width: 760px; margin: 0 auto;
}
.<?php echo $uid; ?> .dal07-item {
  background: #fff;
  border: 1px solid #E2E8F0;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 1px 2px rgba(15,23,42,.04);
  transition: border-color .2s, box-shadow .2s;
}
.<?php echo $uid; ?> .dal07-q {
  display: flex; align-items: center; justify-content: space-between;
  padding: 20px 24px;
  cursor: pointer;
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: 15px; font-weight: 700;
  color: #0F172A;
  transition: background .15s;
  gap: 12px;
  user-select: none;
}
.<?php echo $uid; ?> .dal07-q:hover { background: #F8FAFC; }
.<?php echo $uid; ?> .dal07-icon {
  width: 24px; height: 24px;
  background: #F1F5F9;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: #64748B;
  flex-shrink: 0;
  transition: all .25s;
}
.<?php echo $uid; ?> .dal07-item.is-open .dal07-icon {
  background: <?php echo $o500; ?>;
  color: #fff;
  transform: rotate(45deg);
}
.<?php echo $uid; ?> .dal07-item.is-open {
  border-color: #FED7AA;
  box-shadow: 0 4px 18px rgba(249,115,22,.10);
}
.<?php echo $uid; ?> .dal07-a {
  padding: 0 24px;
  max-height: 0;
  overflow: hidden;
  transition: max-height .35s ease, padding .35s ease;
  font-size: 15px; color: #475569; line-height: 1.72;
}
.<?php echo $uid; ?> .dal07-item.is-open .dal07-a {
  max-height: 400px;
  padding: 0 24px 22px;
}

@media (max-width: 600px) {
  .<?php echo $uid; ?>.dal07-section { padding: 56px 0; }
}
</style>

<section class="<?php echo $uid; ?> dal07-section">
  <div class="dal07-inner">

    <div class="dal07-head">
      <?php if ( ! empty( $s['eyebrow'] ) ) : ?><span class="dal07-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span><?php endif; ?>
      <?php if ( ! empty( $s['headline'] ) ) : ?><h2 class="dal07-h2"><?php echo esc_html( $s['headline'] ); ?></h2><?php endif; ?>
    </div>

    <div class="dal07-list">
      <?php foreach ( $items as $i => $it ) :
        $open = ( $first && $i === 0 ) ? ' is-open' : ''; ?>
      <div class="dal07-item<?php echo $open; ?>">
        <div class="dal07-q">
          <?php echo esc_html( $it['q'] ); ?>
          <div class="dal07-icon">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="5" x2="12" y2="19"/>
              <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
          </div>
        </div>
        <div class="dal07-a"><?php echo wp_kses_post( $it['a'] ); ?></div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<script>
(function(){
  var root = document.querySelector('.<?php echo $uid; ?>');
  if (!root || root.dataset.bjlzInit === '1') return;
  root.dataset.bjlzInit = '1';
  var only = <?php echo $only_one ? 'true' : 'false'; ?>;
  var items = root.querySelectorAll('.dal07-item');
  items.forEach(function(it){
    var q = it.querySelector('.dal07-q');
    if (!q) return;
    q.addEventListener('click', function(){
      var open = it.classList.contains('is-open');
      if (only) { items.forEach(function(o){ o.classList.remove('is-open'); }); }
      it.classList.toggle('is-open', !open);
    });
  });
})();
</script>
        <?php
    }
}
