<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 06 — Entity Types
 * 4-column grid with full bullet descriptions and "Start my [entity]" CTA buttons.
 */
class Widget_Entity_Types extends \Elementor\Widget_Base {

    public function get_name()       { return 'bj_06_entities'; }
    public function get_title()      { return '06 — Entity Types'; }
    public function get_icon()       { return 'eicon-posts-grid'; }
    public function get_categories() { return [ 'bj-widgets' ]; }
    public function get_keywords()   { return [ 'entity', 'llc', 'corporation', 'types', 'bj', 'bizjump' ]; }

    protected function register_controls() {

        /* ── Header ── */
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'section_label', [
            'label'   => 'Section Label (eyebrow)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Choose Your Entity',
        ] );

        $this->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "What Type of Business\nAre You Forming?",
            'rows'    => 2,
        ] );

        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Not sure which is right for you? Each structure has unique tax and liability benefits.',
            'rows'    => 2,
        ] );

        $this->end_controls_section();

        /* ── Entities ── */
        $this->start_controls_section( 'section_entities', [
            'label' => 'Entity Cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'icon', [
            'label'   => 'Icon (emoji)',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '🏢',
        ] );

        $rep->add_control( 'name', [
            'label'   => 'Entity Name',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'LLC',
        ] );

        $rep->add_control( 'tag_text', [
            'label'   => 'Badge Tag Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Most Popular',
        ] );

        $rep->add_control( 'full_desc', [
            'label'   => 'Full Description',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Limited Liability Company (LLC) — the simplest and most flexible business structure.',
            'rows'    => 3,
        ] );

        $rep->add_control( 'bullets', [
            'label'       => 'Bullet Points (one per line)',
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'default'     => "Personal liability protection\nPass-through taxation\nFlexible management structure",
            'rows'        => 5,
            'description' => 'Enter one bullet per line.',
        ] );

        $rep->add_control( 'cta_text', [
            'label'   => 'CTA Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Start my LLC',
        ] );

        $rep->add_control( 'link_url', [
            'label'   => 'CTA Link URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/incorporate/?entity=llc' ],
        ] );

        $this->add_control( 'entities', [
            'label'       => 'Entities',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'icon'      => '🏢',
                    'name'      => 'LLC',
                    'tag_text'  => 'Most Popular',
                    'full_desc' => 'Limited Liability Company (LLC) — the simplest and most flexible business structure. Protect your personal assets without the complexity of a corporation.',
                    'bullets'   => "Personal liability protection\nPass-through taxation (profits taxed once at the individual level)\nFlexible management structure\nNo board of directors or formal corporate requirements",
                    'cta_text'  => 'Start my LLC',
                    'link_url'  => [ 'url' => '/incorporate/?entity=llc' ],
                ],
                [
                    'icon'      => '📈',
                    'name'      => 'C-Corporation',
                    'tag_text'  => 'Investor-Ready',
                    'full_desc' => 'C Corporation (C Corp) — a structured business designed for growth and raising money. Best for companies planning to scale or bring in investors.',
                    'bullets'   => "Strong personal liability protection\nCompany pays its own taxes (separate from owners)\nCan raise money by selling shares\nNo limit on number of shareholders\nRequires a board of directors and formal structure",
                    'cta_text'  => 'Start my C-Corp',
                    'link_url'  => [ 'url' => '/incorporate/?entity=ccorp' ],
                ],
                [
                    'icon'      => '💼',
                    'name'      => 'S-Corporation',
                    'tag_text'  => 'Tax Efficient',
                    'full_desc' => 'S Corporation (S Corp) — a tax status that helps avoid double taxation while maintaining a structured business setup. Best for small to mid-sized businesses.',
                    'bullets'   => "Personal liability protection\nPass-through taxation (profits taxed once)\nPotential self-employment tax savings\nMaximum of 100 shareholders\nShareholders must be U.S. citizens or residents\nCan convert to a C Corporation as the business grows",
                    'cta_text'  => 'Start my S-Corp',
                    'link_url'  => [ 'url' => '/incorporate/?entity=scorp' ],
                ],
                [
                    'icon'      => '❤️',
                    'name'      => 'Non-Profit',
                    'tag_text'  => 'Tax Exempt',
                    'full_desc' => 'Nonprofit Corporation — an organization formed to serve a public or community purpose rather than generate profit for owners.',
                    'bullets'   => "No owners or shareholders\nProfits are reinvested into the organization's mission\nEligible for tax-exempt status (if approved)\nCan receive donations and grants\nRequires a board of directors and formal governance structure",
                    'cta_text'  => 'Start my Non-Profit',
                    'link_url'  => [ 'url' => '/incorporate/?entity=nonprofit' ],
                ],
            ],
            'title_field' => '{{{ icon }}} {{{ name }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.bjw06-wrap {
  font-family: 'Inter', sans-serif;
  max-width: 1120px; margin: 0 auto; padding: 0 32px;
}
.bjw06-header { text-align: center; margin-bottom: 52px; }
.bjw06-label {
  font-size: 12px; font-weight: 700; letter-spacing: 2px;
  text-transform: uppercase; color: #2563eb;
  margin-bottom: 10px; display: block;
}
.bjw06-title {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: clamp(28px, 3.5vw, 42px);
  font-weight: 800; color: #111827;
  line-height: 1.18; letter-spacing: -0.8px; margin-bottom: 14px;
}
.bjw06-sub { font-size: 17px; color: #6b7280; max-width: 500px; margin: 0 auto; line-height: 1.75; }
.bjw06-grid {
  display: grid;
  grid-template-columns: repeat(<?php echo count( $s['entities'] ); ?>, 1fr);
  gap: 20px;
}
.bjw06-card {
  background: #fff; border: 1px solid #e5e7eb;
  border-radius: 16px; padding: 28px 22px;
  text-align: left; position: relative; overflow: hidden;
  transition: box-shadow .25s, transform .25s, border-color .25s;
  opacity: 0; transform: translateY(24px);
}
.bjw06-card.bjw06-visible { opacity: 1; transform: none; }
.bjw06-card { transition: opacity .5s ease, transform .5s ease, box-shadow .25s, border-color .25s; }
.bjw06-card:nth-child(2) { transition-delay: .1s; }
.bjw06-card:nth-child(3) { transition-delay: .2s; }
.bjw06-card:nth-child(4) { transition-delay: .3s; }
.bjw06-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: #2563eb; transform: scaleX(0); transition: transform .3s;
}
.bjw06-card:hover::before { transform: scaleX(1); }
.bjw06-card:hover { box-shadow: 0 6px 32px rgba(0,0,0,.12); transform: translateY(-5px); border-color: #2563eb; }
.bjw06-card-top { text-align: center; margin-bottom: 16px; }
.bjw06-icon {
  width: 60px; height: 60px; border-radius: 14px; margin: 0 auto 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 26px; background: #eff6ff;
}
.bjw06-card h3 {
  font-family: 'Space Grotesk', 'Inter', sans-serif;
  font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 6px;
}
.bjw06-tag {
  display: inline-block; background: #eff6ff; color: #2563eb;
  font-size: 11px; font-weight: 700; padding: 4px 12px;
  border-radius: 100px; letter-spacing: .5px;
}
.bjw06-full-desc { font-size: 13px; color: #6b7280; line-height: 1.6; margin-bottom: 14px; }
.bjw06-bullets { list-style: none; margin: 0 0 20px; padding: 0; }
.bjw06-bullets li {
  display: flex; align-items: flex-start; gap: 7px;
  font-size: 13px; color: #374151; padding: 3px 0; line-height: 1.5;
}
.bjw06-bullets li::before {
  content: '&#10004;'; color: #16a34a; font-size: 11px; flex-shrink: 0; margin-top: 2px;
}
.bjw06-cta {
  display: block; width: 100%; padding: 12px 16px;
  background: #f97316; color: #fff; border: none; border-radius: 6px;
  font-size: 14px; font-weight: 700; font-family: 'Inter', sans-serif;
  text-align: center; text-decoration: none; cursor: pointer;
  transition: background .2s, transform .15s;
  box-shadow: 0 3px 10px rgba(249,115,22,.3);
}
.bjw06-cta:hover { background: #ea6c00; transform: translateY(-1px); color: #fff; }
@media (max-width: 1024px) { .bjw06-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) { .bjw06-wrap { padding: 0 16px; } .bjw06-sub { font-size: 15px; } }
@media (max-width: 480px) { .bjw06-grid { grid-template-columns: 1fr; } }
</style>

<div class="bjw06-wrap">

  <div class="bjw06-header">
    <span class="bjw06-label"><?php echo esc_html( $s['section_label'] ); ?></span>
    <h2 class="bjw06-title"><?php echo nl2br( wp_kses_post( $s['title'] ) ); ?></h2>
    <p class="bjw06-sub"><?php echo esc_html( $s['subtitle'] ); ?></p>
  </div>

  <div class="bjw06-grid">
    <?php foreach ( $s['entities'] as $entity ) :
        $link_url  = ! empty( $entity['link_url']['url'] ) ? esc_url( $entity['link_url']['url'] ) : '#';
        $link_tgt  = ! empty( $entity['link_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        $raw_bullets = isset( $entity['bullets'] ) ? $entity['bullets'] : '';
        $bullets_arr = array_filter( array_map( 'trim', explode( "\n", $raw_bullets ) ) );
    ?>
    <div class="bjw06-card">
      <div class="bjw06-card-top">
        <div class="bjw06-icon"><?php echo esc_html( $entity['icon'] ); ?></div>
        <h3><?php echo esc_html( $entity['name'] ); ?></h3>
        <span class="bjw06-tag"><?php echo esc_html( $entity['tag_text'] ); ?></span>
      </div>
      <p class="bjw06-full-desc"><?php echo esc_html( $entity['full_desc'] ); ?></p>
      <ul class="bjw06-bullets">
        <?php foreach ( $bullets_arr as $bullet ) : ?>
        <li><?php echo esc_html( $bullet ); ?></li>
        <?php endforeach; ?>
      </ul>
      <a href="<?php echo $link_url; ?>"<?php echo $link_tgt; ?> class="bjw06-cta"><?php echo esc_html( $entity['cta_text'] ); ?></a>
    </div>
    <?php endforeach; ?>
  </div>

</div>

<script>
(function(){
  var cards = document.querySelectorAll('.bjw06-card');
  var obs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if(e.isIntersecting){ e.target.classList.add('bjw06-visible'); obs.unobserve(e.target); }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
  cards.forEach(function(c){ obs.observe(c); });
})();
</script>
        <?php
    }
}
