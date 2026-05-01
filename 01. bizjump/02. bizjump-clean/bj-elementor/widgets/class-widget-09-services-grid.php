<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 09 — Services Grid
 * 3-column grid of BizJump service cards with icons and scroll-reveal.
 */
class Widget_Services_Grid extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_09_services'; }
    public function get_title()      { return '09 — Services Grid'; }
    public function get_icon()       { return 'eicon-apps'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'services', 'grid', 'cards', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        /* ── Header ── */
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'section_label', [
            'label'   => 'Section Label (eyebrow)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Our Services',
        ] );

        $this->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Everything Your Business Needs',
        ] );

        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'From formation to growth — BizJump supports your business at every stage.',
            'rows'    => 2,
        ] );

        $this->end_controls_section();

        /* ── Services ── */
        $this->start_controls_section( 'section_services', [
            'label' => 'Services',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'icon', [
            'label'   => 'Icon (emoji)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '🏛️',
        ] );

        $rep->add_control( 'name', [
            'label'   => 'Service Name',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Business Incorporation',
        ] );

        $rep->add_control( 'desc', [
            'label'   => 'Description',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'LLC, Corporation, S-Corp, or Non-Profit — we file the paperwork in all 50 states.',
            'rows'    => 3,
        ] );

        $rep->add_control( 'link_url', [
            'label'   => 'Card Link URL (optional)',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '' ],
        ] );

        $this->add_control( 'services', [
            'label'       => 'Services',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'icon'     => '🏛️',
                    'name'     => 'Business Incorporation',
                    'desc'     => 'LLC, Corporation, S-Corp, or Non-Profit — we file the paperwork in all 50 states with guaranteed accuracy.',
                    'link_url' => [ 'url' => '/incorporate/' ],
                ],
                [
                    'icon'     => '💳',
                    'name'     => 'Business Financing',
                    'desc'     => 'Access business credit lines, SBA loan guidance, and funding partnerships to fuel your growth from day one.',
                    'link_url' => [ 'url' => '/services/financing/' ],
                ],
                [
                    'icon'     => '📣',
                    'name'     => 'Digital Marketing',
                    'desc'     => 'SEO, social media management, Google Ads, and brand strategy — get found by your ideal customers online.',
                    'link_url' => [ 'url' => '/services/marketing/' ],
                ],
                [
                    'icon'     => '📋',
                    'name'     => 'Business Planning',
                    'desc'     => 'Professional business plan writing for investors, SBA loans, or internal strategy. Crafted by experienced advisors.',
                    'link_url' => [ 'url' => '/services/business-planning/' ],
                ],
                [
                    'icon'     => '🧾',
                    'name'     => 'Accounting & Tax',
                    'desc'     => 'Bookkeeping, tax preparation, quarterly filings, and payroll — keep your financials clean and compliant year-round.',
                    'link_url' => [ 'url' => '/services/accounting/' ],
                ],
                [
                    'icon'     => '💎',
                    'name'     => 'Credit Repair',
                    'desc'     => 'Build or repair your business credit score. We work with bureaus to dispute inaccuracies and establish credit lines.',
                    'link_url' => [ 'url' => '/services/credit-repair/' ],
                ],
            ],
            'title_field' => '{{{ icon }}} {{{ name }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $count = count( $s['services'] );
        $cols  = $count <= 3 ? $count : 3;
        ?>
<style>
.bjw10-wrap {
  font-family: 'Inter', sans-serif;
  max-width: 1120px;
  margin: 0 auto;
  padding: 0 32px;
}
/* Header */
.bjw10-header { text-align: center; margin-bottom: 52px; }
.bjw10-label {
  font-size: 12px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: #2563eb;
  margin-bottom: 10px; display: block;
}
.bjw10-title {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: clamp(28px, 3.5vw, 40px);
  font-weight: 800; color: #111827;
  letter-spacing: -0.8px; line-height: 1.18; margin-bottom: 12px;
}
.bjw10-sub {
  font-size: 17px; color: #6b7280;
  max-width: 500px; margin: 0 auto; line-height: 1.75;
}
/* Grid */
.bjw10-grid {
  display: grid;
  grid-template-columns: repeat(<?php echo $cols; ?>, 1fr);
  gap: 20px;
}
/* Card */
.bjw10-card {
  background: #fff;
  border: 1.5px solid rgba(37,99,235,.1);
  border-radius: 16px;
  padding: 32px 24px;
  text-decoration: none;
  color: inherit;
  display: block;
  opacity: 0; transform: translateY(20px);
  transition: opacity .5s ease, transform .5s ease, box-shadow .25s, border-color .25s;
}
.bjw10-card.bjw10-visible { opacity: 1; transform: none; }
.bjw10-card:nth-child(2) { transition-delay: .07s; }
.bjw10-card:nth-child(3) { transition-delay: .14s; }
.bjw10-card:nth-child(4) { transition-delay: .21s; }
.bjw10-card:nth-child(5) { transition-delay: .28s; }
.bjw10-card:nth-child(6) { transition-delay: .35s; }
.bjw10-card:hover {
  box-shadow: 0 6px 32px rgba(37,99,235,.12);
  transform: translateY(-5px);
  border-color: rgba(37,99,235,.3);
}
/* Icon */
.bjw10-icon {
  width: 56px; height: 56px; border-radius: 14px;
  background: #eff6ff;
  display: flex; align-items: center; justify-content: center;
  font-size: 26px; margin-bottom: 18px;
}
.bjw10-card:nth-child(2) .bjw10-icon { background: #fef3c7; }
.bjw10-card:nth-child(3) .bjw10-icon { background: #f0fdf4; }
.bjw10-card:nth-child(4) .bjw10-icon { background: #fdf4ff; }
.bjw10-card:nth-child(5) .bjw10-icon { background: #fff7ed; }
.bjw10-card:nth-child(6) .bjw10-icon { background: #f0fdf4; }
.bjw10-card h3 {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 17px; font-weight: 700; color: #111827; margin-bottom: 10px;
}
.bjw10-card p {
  font-size: 14px; color: #6b7280; line-height: 1.65; margin: 0;
}
/* Responsive */
@media (max-width: 1024px) { .bjw10-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px) {
  .bjw10-grid { grid-template-columns: 1fr; }
  .bjw10-wrap { padding: 0 16px; }
  .bjw10-sub { font-size: 15px; }
}
</style>

<div class="bjw10-wrap">

  <!-- Header -->
  <div class="bjw10-header">
    <span class="bjw10-label"><?php echo esc_html( $s['section_label'] ); ?></span>
    <h2 class="bjw10-title"><?php echo esc_html( $s['title'] ); ?></h2>
    <p class="bjw10-sub"><?php echo esc_html( $s['subtitle'] ); ?></p>
  </div>

  <!-- Grid -->
  <div class="bjw10-grid">
    <?php foreach ( $s['services'] as $service ) :
        $lnk_url = ! empty( $service['link_url']['url'] ) ? esc_url( $service['link_url']['url'] ) : '#';
        $lnk_tgt = ! empty( $service['link_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
    ?>
    <a href="<?php echo $lnk_url; ?>"<?php echo $lnk_tgt; ?> class="bjw10-card">
      <div class="bjw10-icon"><?php echo esc_html( $service['icon'] ); ?></div>
      <h3><?php echo esc_html( $service['name'] ); ?></h3>
      <p><?php echo esc_html( $service['desc'] ); ?></p>
    </a>
    <?php endforeach; ?>
  </div>

</div>

<script>
(function(){
  var cards = document.querySelectorAll('.bjw10-card');
  var obs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if(e.isIntersecting){ e.target.classList.add('bjw10-visible'); obs.unobserve(e.target); }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -30px 0px' });
  cards.forEach(function(c){ obs.observe(c); });
})();
</script>
        <?php
    }
}
