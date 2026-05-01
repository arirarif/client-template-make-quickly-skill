<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DLW-06 — Testimonials (Demo Landing)
 * 3 review cards with stars, quote, initial-avatar + name + role.
 */
class Widget_DLW_Testimonials extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dlw_06_testimonials'; }
    public function get_title()      { return 'DLW 06 — Testimonials'; }
    public function get_icon()       { return 'eicon-testimonial'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'testimonials', 'reviews', 'quotes', 'bizjump', 'dlw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_header', [
            'label' => 'Section Header', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'label_text', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Reviews' ] );
        $this->add_control( 'title_text', [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'What Our Customers Say' ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_items', [
            'label' => 'Reviews', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'stars', [
            'label' => 'Stars (1–5)',
            'type'  => \Elementor\Controls_Manager::NUMBER,
            'min'   => 1, 'max' => 5, 'default' => 5,
        ] );
        $rep->add_control( 'quote', [
            'label' => 'Quote', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'A glowing review from a happy customer goes here.',
        ] );
        $rep->add_control( 'initials', [
            'label' => 'Avatar Initials (2 letters)',
            'type'  => \Elementor\Controls_Manager::TEXT, 'default' => 'JM',
        ] );
        $rep->add_control( 'avatar_color', [
            'label' => 'Avatar Color',
            'type'  => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'indigo' => 'Indigo gradient',
                'orange' => 'Orange gradient',
                'slate'  => 'Slate gradient',
            ],
            'default' => 'indigo',
        ] );
        $rep->add_control( 'name', [
            'label' => 'Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'James M.',
        ] );
        $rep->add_control( 'role', [
            'label' => 'Role', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'E-commerce founder, TX',
        ] );

        $this->add_control( 'items', [
            'label' => 'Items',
            'type'  => \Elementor\Controls_Manager::REPEATER,
            'fields'=> $rep->get_controls(),
            'default' => [
                [ 'stars' => 5, 'quote' => 'BizJump made forming my LLC incredibly straightforward. The entire process took less than 10 minutes and my LLC was approved in 2 days.', 'initials' => 'JM', 'avatar_color' => 'indigo', 'name' => 'James M.', 'role' => 'E-commerce founder, TX' ],
                [ 'stars' => 5, 'quote' => 'I was surprised at how smooth the experience was. Professional service, fast turnaround, and the registered agent feature is a huge time saver.', 'initials' => 'SK', 'avatar_color' => 'orange', 'name' => 'Sarah K.', 'role' => 'Freelance consultant, NY' ],
                [ 'stars' => 5, 'quote' => 'Used BizJump for my second LLC and the experience was even better than the first. Highly recommend the Pro plan — worth every penny.', 'initials' => 'RT', 'avatar_color' => 'slate', 'name' => 'Robert T.', 'role' => 'Real estate investor, FL' ],
            ],
            'title_field' => '{{{ name }}} — {{{ stars }}}★',
        ] );

        $this->end_controls_section();
    }

    private function avatar_bg( $key ) {
        switch ( $key ) {
            case 'orange': return 'linear-gradient(135deg, #F97316, #EA580C)';
            case 'slate':  return 'linear-gradient(135deg, #1E293B, #334155)';
            default:       return 'linear-gradient(135deg, #6366F1, #4F46E5)';
        }
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.dlw06-section { padding: 88px 0; background: #F8FAFC; font-family: 'Inter', sans-serif; }
.dlw06-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.dlw06-header { text-align: center; margin-bottom: 56px; }
.dlw06-label { display: inline-block; font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #F97316; margin-bottom: 12px; }
.dlw06-title { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: clamp(26px,3.5vw,40px); font-weight: 800; color: #0F172A; line-height: 1.2; letter-spacing: -.02em; margin: 0 0 14px; }

.dlw06-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.dlw06-card { background: #fff; border: 1px solid #E2E8F0; border-radius: 14px; padding: 28px; box-shadow: 0 2px 6px rgba(15,23,42,.08); transition: box-shadow .25s, transform .25s; }
.dlw06-card:hover { box-shadow: 0 4px 14px rgba(15,23,42,.10); transform: translateY(-2px); }
.dlw06-stars { display: flex; gap: 3px; margin-bottom: 14px; color: #FB923C; font-size: 16px; letter-spacing: 1px; }
.dlw06-text { font-size: 15px; color: #475569; line-height: 1.65; margin-bottom: 20px; }
.dlw06-author { display: flex; align-items: center; gap: 12px; }
.dlw06-avatar { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 700; color: #fff; flex-shrink: 0; font-family: 'Plus Jakarta Sans','Inter',sans-serif; }
.dlw06-name { font-size: 14px; font-weight: 600; color: #1E293B; }
.dlw06-role { font-size: 12px; color: #94A3B8; margin-top: 2px; }

@media (max-width: 900px) { .dlw06-grid { grid-template-columns: 1fr; gap: 16px; max-width: 520px; margin: 0 auto; } }
@media (max-width: 600px) {
  .dlw06-section { padding: 64px 0; }
  .dlw06-header { margin-bottom: 40px; }
  .dlw06-card { padding: 24px 22px; }
}
</style>

<section class="dlw06-section">
  <div class="dlw06-inner">
    <div class="dlw06-header">
      <span class="dlw06-label"><?php echo esc_html( $s['label_text'] ); ?></span>
      <h2 class="dlw06-title"><?php echo esc_html( $s['title_text'] ); ?></h2>
    </div>
    <div class="dlw06-grid">
      <?php foreach ( (array) $s['items'] as $it ) :
        $stars   = max( 1, min( 5, (int) $it['stars'] ) );
        $bg      = $this->avatar_bg( $it['avatar_color'] );
      ?>
      <div class="dlw06-card">
        <div class="dlw06-stars"><?php echo str_repeat( '★', $stars ); ?></div>
        <p class="dlw06-text"><?php echo esc_html( $it['quote'] ); ?></p>
        <div class="dlw06-author">
          <div class="dlw06-avatar" style="background: <?php echo esc_attr( $bg ); ?>;"><?php echo esc_html( $it['initials'] ); ?></div>
          <div>
            <div class="dlw06-name"><?php echo esc_html( $it['name'] ); ?></div>
            <div class="dlw06-role"><?php echo esc_html( $it['role'] ); ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
