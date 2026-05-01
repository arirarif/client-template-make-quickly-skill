<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 10 — Testimonials
 * Three-column testimonial cards with star ratings, avatar initials, and verified badge.
 */
class Widget_Testimonials extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_10_testimonials'; }
    public function get_title()      { return '10 — Testimonials'; }
    public function get_icon()       { return 'eicon-testimonial'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'testimonials', 'reviews', 'clients', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        /* ── Header ── */
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'section_label', [
            'label'   => 'Section Label (eyebrow)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Client Reviews',
        ] );

        $this->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Trusted by 3,000+ Entrepreneurs',
        ] );

        $this->end_controls_section();

        /* ── Testimonials ── */
        $this->start_controls_section( 'section_testimonials', [
            'label' => 'Testimonials',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'stars', [
            'label'   => 'Star Rating (1–5)',
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 5,
            'default' => 5,
        ] );

        $rep->add_control( 'quote', [
            'label'   => 'Quote',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'BizJump is amazing!',
            'rows'    => 4,
        ] );

        $rep->add_control( 'author_initials', [
            'label'   => 'Author Initials (2 letters)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'MR',
        ] );

        $rep->add_control( 'author_name', [
            'label'   => 'Author Name',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Marcus R.',
        ] );

        $rep->add_control( 'author_role', [
            'label'   => 'Author Role / Business',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'E-commerce Entrepreneur',
        ] );

        $rep->add_control( 'verified', [
            'label'        => 'Show Verified Badge',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => 'Yes',
            'label_off'    => 'No',
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'testimonials', [
            'label'       => 'Testimonials',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'stars'          => 5,
                    'quote'          => 'BizJump had my LLC formed in under 24 hours. I\'d been putting it off for months because I thought it would be complicated — it was the easiest thing I did all year. Highly recommend.',
                    'author_initials'=> 'MR',
                    'author_name'    => 'Marcus R.',
                    'author_role'    => 'E-commerce Entrepreneur',
                    'verified'       => 'yes',
                ],
                [
                    'stars'          => 5,
                    'quote'          => 'I used a competitor before and they hit me with hidden fees at every step. BizJump showed me the exact total upfront — state fee included — and didn\'t charge a penny more. That\'s rare.',
                    'author_initials'=> 'LT',
                    'author_name'    => 'Latoya T.',
                    'author_role'    => 'Consulting Business Owner',
                    'verified'       => 'yes',
                ],
                [
                    'stars'          => 5,
                    'quote'          => 'The whole process — choosing my entity, picking my state, paying — took maybe 15 minutes. They handled everything else. My articles of incorporation arrived digitally the next morning. Incredible service.',
                    'author_initials'=> 'DS',
                    'author_name'    => 'David S.',
                    'author_role'    => 'Real Estate Investor',
                    'verified'       => 'yes',
                ],
            ],
            'title_field' => '{{{ author_name }}} — {{{ author_role }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.bjw11-wrap {
  font-family: 'Inter', sans-serif;
  max-width: 1120px;
  margin: 0 auto;
  padding: 0 32px;
}
/* Header */
.bjw11-header { text-align: center; margin-bottom: 52px; }
.bjw11-label {
  font-size: 12px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: #2563eb;
  margin-bottom: 10px; display: block;
}
.bjw11-title {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: clamp(28px, 3.5vw, 40px);
  font-weight: 800; color: #111827;
  letter-spacing: -0.8px; line-height: 1.18;
}
/* Grid */
.bjw11-grid {
  display: grid;
  grid-template-columns: repeat(<?php echo min( count( $s['testimonials'] ), 3 ); ?>, 1fr);
  gap: 24px;
}
/* Card */
.bjw11-card {
  background: #fff;
  border: 1.5px solid #e5e7eb;
  border-radius: 20px;
  padding: 32px;
  opacity: 0; transform: translateY(24px);
  transition: opacity .55s ease, transform .55s ease, box-shadow .25s;
}
.bjw11-card.bjw11-visible { opacity: 1; transform: none; }
.bjw11-card:nth-child(2) { transition-delay: .12s; }
.bjw11-card:nth-child(3) { transition-delay: .24s; }
.bjw11-card:hover {
  box-shadow: 0 8px 32px rgba(0,0,0,.1);
  transform: translateY(-4px);
}
/* Stars */
.bjw11-stars { color: #f59e0b; font-size: 16px; margin-bottom: 16px; letter-spacing: 2px; }
/* Quote */
.bjw11-quote {
  font-size: 15px; color: #374151; line-height: 1.7;
  font-style: italic; margin-bottom: 24px;
}
.bjw11-quote::before { content: '\201C'; font-size: 32px; color: #d1d5db; line-height: 0; vertical-align: -8px; margin-right: 2px; }
.bjw11-quote::after  { content: '\201D'; font-size: 32px; color: #d1d5db; line-height: 0; vertical-align: -8px; margin-left: 2px; }
/* Divider */
.bjw11-divider { border: none; border-top: 1px solid #f3f4f6; margin: 0 0 20px; }
/* Author */
.bjw11-author { display: flex; align-items: center; gap: 14px; }
.bjw11-avatar {
  width: 44px; height: 44px; border-radius: 50%;
  background: linear-gradient(135deg, #2563eb, #0f2156);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 16px; font-weight: 700; color: #fff;
  flex-shrink: 0;
}
.bjw11-author-info .bjw11-name {
  font-size: 14px; font-weight: 700; color: #111827;
}
.bjw11-author-info .bjw11-role {
  font-size: 13px; color: #9ca3af;
}
/* Verified badge */
.bjw11-verified {
  margin-left: auto;
  font-size: 11px; font-weight: 600; color: #16a34a;
  background: #f0fdf4; padding: 3px 10px; border-radius: 100px;
  border: 1px solid #bbf7d0; white-space: nowrap;
}
/* Responsive */
@media (max-width: 900px) { .bjw11-grid { grid-template-columns: 1fr; } }
@media (max-width: 600px) { .bjw11-wrap { padding: 0 16px; } }
</style>

<div class="bjw11-wrap">

  <!-- Header -->
  <div class="bjw11-header">
    <span class="bjw11-label"><?php echo esc_html( $s['section_label'] ); ?></span>
    <h2 class="bjw11-title"><?php echo esc_html( $s['title'] ); ?></h2>
  </div>

  <!-- Cards -->
  <div class="bjw11-grid">
    <?php foreach ( $s['testimonials'] as $t ) :
        $stars_count = max( 1, min( 5, intval( $t['stars'] ) ) );
        $stars_str   = str_repeat( '★', $stars_count ) . str_repeat( '☆', 5 - $stars_count );
    ?>
    <div class="bjw11-card">
      <div class="bjw11-stars"><?php echo esc_html( $stars_str ); ?></div>
      <p class="bjw11-quote"><?php echo esc_html( $t['quote'] ); ?></p>
      <hr class="bjw11-divider">
      <div class="bjw11-author">
        <div class="bjw11-avatar"><?php echo esc_html( substr( strtoupper( $t['author_initials'] ), 0, 2 ) ); ?></div>
        <div class="bjw11-author-info">
          <div class="bjw11-name"><?php echo esc_html( $t['author_name'] ); ?></div>
          <div class="bjw11-role"><?php echo esc_html( $t['author_role'] ); ?></div>
        </div>
        <?php if ( 'yes' === $t['verified'] ) : ?>
        <span class="bjw11-verified">✓ Verified</span>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

</div>

<script>
(function(){
  var cards = document.querySelectorAll('.bjw11-card');
  var obs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if(e.isIntersecting){ e.target.classList.add('bjw11-visible'); obs.unobserve(e.target); }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -30px 0px' });
  cards.forEach(function(c){ obs.observe(c); });
})();
</script>
        <?php
    }
}
