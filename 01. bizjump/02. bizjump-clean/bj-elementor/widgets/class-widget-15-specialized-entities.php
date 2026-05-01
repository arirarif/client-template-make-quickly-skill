<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 15 — Specialized Entities
 * 4-column grid of DBA / PC / B-Corp / LLP cards, plus a custom quote callout.
 */
class Widget_Specialized_Entities extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_15_specialized'; }
    public function get_title()      { return '15 — Specialized Entities'; }
    public function get_icon()       { return 'eicon-posts-grid'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'dba', 'pc', 'llp', 'bcorp', 'specialized', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        /* ── Header ── */
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'section_label', [
            'label'   => 'Section Label (eyebrow)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Specialized Structures',
        ] );

        $this->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'We form almost any type of business',
        ] );

        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "While not as common as the options above, these specialized business structures are necessary in certain situations \xe2\x80\x94 and yes, we can form them too.",
            'rows'    => 3,
        ] );

        $this->end_controls_section();

        /* ── Entity Cards ── */
        $this->start_controls_section( 'section_cards', [
            'label' => 'Entity Cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'card_title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'DBA',
        ] );

        $rep->add_control( 'card_desc', [
            'label'   => 'Description',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Enter description.',
            'rows'    => 3,
        ] );

        $rep->add_control( 'bullets', [
            'label'       => 'Bullet Points (one per line)',
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => "Bullet one\nBullet two\nBullet three",
            'rows'        => 5,
            'description' => 'Enter one bullet per line.',
        ] );

        $this->add_control( 'cards', [
            'label'       => 'Cards',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'card_title' => 'DBA',
                    'card_desc'  => "Doing Business As (DBA) \xe2\x80\x94 a simple way to operate your business under a different name without forming a separate legal entity.",
                    'bullets'    => "No separate legal entity (operates under your existing business or personal name)\nQuick and low-cost registration\nAllows you to brand your business with a professional name\nCan be used with sole proprietorships, LLCs, or corporations",
                ],
                [
                    'card_title' => 'Professional Corporations',
                    'card_desc'  => "Professional Corporation (PC) \xe2\x80\x94 a business structure for licensed professionals that require state licensing, offering liability protection while meeting regulatory requirements.",
                    'bullets'    => "Personal liability protection for business debts\nDesigned for licensed professionals (e.g., doctors, lawyers, accountants)\nOwners must hold valid state licenses in their profession\nStructured with a board of directors and formal corporate requirements",
                ],
                [
                    'card_title' => 'B-Corporation',
                    'card_desc'  => "B Corporation (Benefit Corporation) \xe2\x80\x94 combines the advantages of a traditional corporation with a mission-driven focus similar to a nonprofit.",
                    'bullets'    => "Full benefits of a regular corporation (liability protection, ability to raise capital)\nFocus on social and environmental impact\nLegal protection to consider stakeholders, not just shareholders\nRequires transparency and impact reporting",
                ],
                [
                    'card_title' => 'LLP',
                    'card_desc'  => "Limited Liability Partnership (LLP) \xe2\x80\x94 a business structure where partners share management while protecting themselves from certain liabilities.",
                    'bullets'    => "Personal liability protection for each partner\nFlexible management \xe2\x80\x94 partners can run the business directly\nPass-through taxation (profits taxed once)\nCommon for licensed professionals (e.g., lawyers, accountants)",
                ],
            ],
            'title_field' => '{{{ card_title }}}',
        ] );

        $this->end_controls_section();

        /* ── Callout ── */
        $this->start_controls_section( 'section_callout', [
            'label' => 'Quote Callout',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'callout_text', [
            'label'   => 'Callout Text',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Contact us directly for a custom quote to set up either a B-Corp, DBA, Professional Corporation, or LLP.',
            'rows'    => 2,
        ] );

        $this->add_control( 'callout_btn_text', [
            'label'   => 'Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Request a Custom Quote',
        ] );

        $this->add_control( 'callout_btn_url', [
            'label'   => 'Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/contact/' ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s       = $this->get_settings_for_display();
        $btn_u   = ! empty( $s['callout_btn_url']['url'] ) ? esc_url( $s['callout_btn_url']['url'] ) : '#';
        $btn_t   = ! empty( $s['callout_btn_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
<style>
.bjw15-wrap {
  background: #f9fafb;
  padding: 80px 32px;
  font-family: 'Inter', sans-serif;
}
.bjw15-inner { max-width: 1120px; margin: 0 auto; }
.bjw15-header { text-align: center; margin-bottom: 48px; }
.bjw15-label {
  font-size: 12px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: #2563eb;
  margin-bottom: 10px; display: block;
}
.bjw15-title {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: clamp(26px, 3.2vw, 40px);
  font-weight: 800; color: #111827;
  line-height: 1.2; letter-spacing: -0.6px;
  margin-bottom: 14px;
}
.bjw15-sub { font-size: 16px; color: #6b7280; max-width: 680px; margin: 0 auto; line-height: 1.75; }
.bjw15-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-bottom: 32px;
}
.bjw15-card {
  background: #fff; border: 1px solid #e5e7eb;
  border-radius: 14px; padding: 28px 22px;
  transition: box-shadow .25s, transform .25s, border-color .25s;
  opacity: 0; transform: translateY(20px);
}
.bjw15-card.bjw15-visible { opacity: 1; transform: none; }
.bjw15-card { transition: opacity .5s ease, transform .5s ease, box-shadow .25s, border-color .25s; }
.bjw15-card:nth-child(2) { transition-delay: .1s; }
.bjw15-card:nth-child(3) { transition-delay: .2s; }
.bjw15-card:nth-child(4) { transition-delay: .3s; }
.bjw15-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,.10); transform: translateY(-4px); border-color: #2563eb; }
.bjw15-card h3 {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 17px; font-weight: 700; color: #111827;
  margin-bottom: 10px;
}
.bjw15-desc { font-size: 13px; color: #6b7280; line-height: 1.65; margin-bottom: 16px; }
.bjw15-bullets { list-style: none; margin: 0; padding: 0; }
.bjw15-bullets li {
  display: flex; align-items: flex-start; gap: 7px;
  font-size: 13px; color: #374151; padding: 3px 0; line-height: 1.5;
}
.bjw15-bullets li::before {
  content: '&#10004;'; color: #16a34a; font-size: 11px; flex-shrink: 0; margin-top: 2px;
}
.bjw15-callout {
  background: #0f2156; border-radius: 14px;
  padding: 32px 36px;
  display: flex; align-items: center; justify-content: space-between;
  gap: 24px; flex-wrap: wrap;
}
.bjw15-callout p {
  font-size: 16px; color: rgba(255,255,255,.9);
  line-height: 1.65; margin: 0; max-width: 620px;
}
.bjw15-callout-btn {
  display: inline-flex; align-items: center; gap: 6px;
  background: #f97316; color: #fff; white-space: nowrap;
  padding: 13px 26px; border-radius: 6px;
  font-size: 15px; font-weight: 700; text-decoration: none;
  transition: background .2s, transform .15s;
  box-shadow: 0 3px 10px rgba(249,115,22,.35);
  font-family: 'Inter', sans-serif; flex-shrink: 0;
}
.bjw15-callout-btn:hover { background: #ea6c00; transform: translateY(-1px); color: #fff; }
@media (max-width: 1024px) { .bjw15-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
  .bjw15-wrap { padding: 56px 16px; }
  .bjw15-callout { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 480px) { .bjw15-grid { grid-template-columns: 1fr; } }
</style>

<div class="bjw15-wrap">
  <div class="bjw15-inner">

    <div class="bjw15-header">
      <span class="bjw15-label"><?php echo esc_html( $s['section_label'] ); ?></span>
      <h2 class="bjw15-title"><?php echo esc_html( $s['title'] ); ?></h2>
      <p class="bjw15-sub"><?php echo esc_html( $s['subtitle'] ); ?></p>
    </div>

    <div class="bjw15-grid">
      <?php foreach ( $s['cards'] as $card ) :
          $raw_bullets  = isset( $card['bullets'] ) ? $card['bullets'] : '';
          $bullets_arr  = array_filter( array_map( 'trim', explode( "\n", $raw_bullets ) ) );
      ?>
      <div class="bjw15-card">
        <h3><?php echo esc_html( $card['card_title'] ); ?></h3>
        <p class="bjw15-desc"><?php echo esc_html( $card['card_desc'] ); ?></p>
        <ul class="bjw15-bullets">
          <?php foreach ( $bullets_arr as $bullet ) : ?>
          <li><?php echo esc_html( $bullet ); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="bjw15-callout">
      <p><?php echo esc_html( $s['callout_text'] ); ?></p>
      <a href="<?php echo $btn_u; ?>"<?php echo $btn_t; ?> class="bjw15-callout-btn">
        <?php echo esc_html( $s['callout_btn_text'] ); ?> &#8594;
      </a>
    </div>

  </div>
</div>

<script>
(function(){
  var cards = document.querySelectorAll('.bjw15-card');
  var obs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if(e.isIntersecting){ e.target.classList.add('bjw15-visible'); obs.unobserve(e.target); }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
  cards.forEach(function(c){ obs.observe(c); });
})();
</script>
        <?php
    }
}
