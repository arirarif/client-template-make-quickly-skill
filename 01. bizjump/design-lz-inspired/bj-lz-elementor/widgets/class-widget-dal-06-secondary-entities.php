<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DAL-06 — Secondary Entities Tabs (Doc-Aligned Landing)
 * Source: 03. bizjump-doc-aligned/formation-landing.html — "We form almost any type"
 * Indigo-accented tabs (DBA / Professional Corp / B-Corp / LLP) with panels
 * containing headline + bullet list. Includes "custom quote" footer line.
 * Tab switching is vanilla JS, scoped to this widget instance.
 */
class Widget_DAL_Secondary_Entities extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dal_06_secondary_entities'; }
    public function get_title()      { return 'DAL 06 — Secondary Entities Tabs'; }
    public function get_icon()       { return 'eicon-tabs'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'tabs', 'entities', 'dba', 'bcorp', 'llp', 'bizjump', 'dal' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_head', [
            'label' => 'Headline',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'More Options',
        ] );
        $this->add_control( 'headline', [
            'label'   => 'Headline',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'We form almost any type of business',
        ] );
        $this->add_control( 'intro', [
            'label'   => 'Intro Paragraph',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'While not as common as the options above, these specialized business structures are necessary in certain situations—and yes, we can form them too.',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_tabs', [
            'label' => 'Tabs',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'tab_label', [
            'label'   => 'Tab Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'DBA',
        ] );
        $rep->add_control( 'panel_html', [
            'label'   => 'Panel Headline (HTML allowed: strong, b, em, a)',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => '<strong>Doing Business As (DBA)</strong> — a simple way to operate your business under a different name without forming a separate legal entity.',
        ] );
        $rep->add_control( 'bullets', [
            'label'       => 'Bullets (one per line)',
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'rows'        => 6,
            'default'     => "No separate legal entity\nQuick and low-cost registration\nAllows you to brand your business with a professional name\nCan be used with sole proprietorships, LLCs, or corporations",
        ] );

        $this->add_control( 'tabs', [
            'label'   => 'Tabs',
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $rep->get_controls(),
            'default' => [
                [
                    'tab_label'  => 'DBA',
                    'panel_html' => '<strong>Doing Business As (DBA)</strong> — a simple way to operate your business under a different name without forming a separate legal entity.',
                    'bullets'    => "No separate legal entity (operates under your existing business or personal name)\nQuick and low-cost registration\nAllows you to brand your business with a professional name\nCan be used with sole proprietorships, LLCs, or corporations",
                ],
                [
                    'tab_label'  => 'Professional Corporations',
                    'panel_html' => '<strong>Professional Corporation (PC)</strong> — a business structure for licensed professionals that require state licensing, offering liability protection while meeting regulatory requirements.',
                    'bullets'    => "Personal liability protection for business debts\nDesigned for licensed professionals (e.g., doctors, lawyers, accountants)\nOwners must hold valid state licenses in their profession\nStructured with a board of directors and formal corporate requirements",
                ],
                [
                    'tab_label'  => 'B-Corporation',
                    'panel_html' => '<strong>B Corporation (Benefit Corporation)</strong> — combines the advantages of a traditional corporation with a mission-driven focus similar to a nonprofit.',
                    'bullets'    => "Full benefits of a regular corporation (liability protection, ability to raise capital)\nFocus on social and environmental impact\nLegal protection to consider stakeholders, not just shareholders\nRequires transparency and impact reporting",
                ],
                [
                    'tab_label'  => 'LLP',
                    'panel_html' => '<strong>Limited Liability Partnership (LLP)</strong> — a business structure where partners share management while protecting themselves from certain liabilities.',
                    'bullets'    => "Personal liability protection for each partner\nFlexible management—partners can run the business directly\nPass-through taxation (profits taxed once)\nCommon for licensed professionals (e.g., lawyers, accountants)",
                ],
            ],
            'title_field' => '{{{ tab_label }}}',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_quote', [
            'label' => 'Custom Quote Line',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'show_quote', [
            'label'        => 'Show Custom Quote Line',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );
        $this->add_control( 'quote_text', [
            'label'   => 'Quote Line Text',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Contact us directly for a custom quote to set up either a B-Corp, DBA, Professional Corporation, or LLP.',
            'condition' => [ 'show_quote' => 'yes' ],
        ] );
        $this->add_control( 'quote_link_text', [
            'label'   => 'Link Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Get a custom quote →',
            'condition' => [ 'show_quote' => 'yes' ],
        ] );
        $this->add_control( 'quote_link_url', [
            'label'   => 'Link URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#' ],
            'condition' => [ 'show_quote' => 'yes' ],
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_style', [
            'label' => 'Style',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'bg_color', [
            'label'   => 'Section Background',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#F8FAFC',
        ] );
        $this->add_control( 'accent_color', [
            'label'   => 'Active Tab + Strong Accent',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#4F46E5',
        ] );
        $this->add_control( 'orange_500', [
            'label'   => 'Orange (eyebrow + bullet check)',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#F97316',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s        = $this->get_settings_for_display();
        $bg       = esc_attr( $s['bg_color']     ?: '#F8FAFC' );
        $accent   = esc_attr( $s['accent_color'] ?: '#4F46E5' );
        $o500     = esc_attr( $s['orange_500']   ?: '#F97316' );
        $uid      = 'dal06_' . $this->get_id();
        $tabs     = (array) ( $s['tabs'] ?? [] );
        $hu       = ! empty( $s['quote_link_url']['url'] ) ? esc_url( $s['quote_link_url']['url'] ) : '#';
        ?>
<style>
.<?php echo $uid; ?>.dal06-section {
  background: <?php echo $bg; ?>;
  padding: 80px 0;
  font-family: 'Inter', sans-serif;
}
.<?php echo $uid; ?> .dal06-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.<?php echo $uid; ?> .dal06-head { text-align: center; margin-bottom: 14px; }
.<?php echo $uid; ?> .dal06-eyebrow {
  display: inline-block;
  font-size: 11px; font-weight: 700;
  letter-spacing: .1em; text-transform: uppercase;
  color: <?php echo $o500; ?>; margin-bottom: 12px;
}
.<?php echo $uid; ?> .dal06-h2 {
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: clamp(26px, 3.4vw, 40px);
  font-weight: 800; line-height: 1.18;
  letter-spacing: -.02em; color: #0F172A; margin: 0 0 18px;
}
.<?php echo $uid; ?> .dal06-intro {
  max-width: 680px;
  margin: 0 auto 36px;
  text-align: center;
  font-size: 16px;
  color: #64748B;
  line-height: 1.7;
}
.<?php echo $uid; ?> .dal06-tabs {
  display: flex; gap: 6px;
  background: #fff; padding: 6px;
  border-radius: 14px;
  box-shadow: 0 1px 3px rgba(15,23,42,.06);
  max-width: 680px;
  margin: 0 auto;
  border: 1px solid rgba(15,23,42,.06);
}
.<?php echo $uid; ?> .dal06-tab {
  flex: 1; padding: 13px 14px;
  border: none; background: transparent;
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: 14px; font-weight: 700;
  color: #64748B; border-radius: 10px;
  cursor: pointer; transition: all .2s;
}
.<?php echo $uid; ?> .dal06-tab:hover { color: #1E293B; background: #F1F5F9; }
.<?php echo $uid; ?> .dal06-tab.is-active {
  background: <?php echo $accent; ?>;
  color: #fff;
}
.<?php echo $uid; ?> .dal06-panel-wrap {
  margin: 22px auto 0;
  background: #fff;
  border: 1px solid rgba(15,23,42,.07);
  border-radius: 18px;
  padding: 32px 36px;
  box-shadow: 0 1px 3px rgba(15,23,42,.06);
  max-width: 840px;
}
.<?php echo $uid; ?> .dal06-panel { display: none; }
.<?php echo $uid; ?> .dal06-panel.is-active { display: block; animation: <?php echo $uid; ?>_fadeIn .25s ease-out; }
@keyframes <?php echo $uid; ?>_fadeIn { from{opacity:0;transform:translateY(4px)} to{opacity:1;transform:none} }
.<?php echo $uid; ?> .dal06-headline {
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: clamp(18px, 1.9vw, 22px);
  font-weight: 700;
  color: #0F172A;
  line-height: 1.4;
  margin: 0 0 18px;
}
.<?php echo $uid; ?> .dal06-headline strong { color: <?php echo $accent; ?>; }
.<?php echo $uid; ?> .dal06-bullets {
  list-style: none; padding: 0; margin: 0;
  display: flex; flex-direction: column; gap: 11px;
}
.<?php echo $uid; ?> .dal06-bullets li {
  display: flex; align-items: flex-start; gap: 11px;
  font-size: 15px; color: #334155; line-height: 1.55;
}
.<?php echo $uid; ?> .dal06-bullets li::before {
  content: ''; flex-shrink: 0;
  width: 20px; height: 20px; border-radius: 50%;
  background: #EEF2FF;
  background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23F97316' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'><polyline points='20 6 9 17 4 12'/></svg>");
  background-repeat: no-repeat;
  background-position: center;
  background-size: 11px;
  margin-top: 2px;
}
.<?php echo $uid; ?> .dal06-quote {
  margin: 32px auto 0;
  text-align: center;
  background: #F8FAFC;
  border: 1px solid #E2E8F0;
  border-radius: 12px;
  padding: 20px 24px;
  max-width: 760px;
}
.<?php echo $uid; ?> .dal06-quote p { margin: 0; font-size: 15px; color: #334155; }
.<?php echo $uid; ?> .dal06-quote a {
  color: #EA580C;
  font-weight: 700;
  text-decoration: underline;
  text-underline-offset: 3px;
}

@media (max-width: 920px) {
  .<?php echo $uid; ?> .dal06-tabs { flex-wrap: wrap; }
  .<?php echo $uid; ?> .dal06-tab { flex: 1 1 calc(50% - 6px); }
}
@media (max-width: 560px) {
  .<?php echo $uid; ?> .dal06-panel-wrap { padding: 24px 22px; }
}
</style>

<section class="<?php echo $uid; ?> dal06-section">
  <div class="dal06-inner">

    <div class="dal06-head">
      <?php if ( ! empty( $s['eyebrow'] ) ) : ?><span class="dal06-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span><?php endif; ?>
      <?php if ( ! empty( $s['headline'] ) ) : ?><h2 class="dal06-h2"><?php echo esc_html( $s['headline'] ); ?></h2><?php endif; ?>
    </div>
    <?php if ( ! empty( $s['intro'] ) ) : ?>
      <p class="dal06-intro"><?php echo esc_html( $s['intro'] ); ?></p>
    <?php endif; ?>

    <div class="dal06-tabs" role="tablist">
      <?php foreach ( $tabs as $i => $t ) : ?>
        <button class="dal06-tab<?php echo $i === 0 ? ' is-active' : ''; ?>" data-tab="<?php echo $i; ?>" role="tab" aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"><?php echo esc_html( $t['tab_label'] ); ?></button>
      <?php endforeach; ?>
    </div>

    <div class="dal06-panel-wrap">
      <?php foreach ( $tabs as $i => $t ) :
        $bullets = preg_split( '/\r\n|\r|\n/', (string) ( $t['bullets'] ?? '' ) ); ?>
        <div class="dal06-panel<?php echo $i === 0 ? ' is-active' : ''; ?>" data-panel="<?php echo $i; ?>">
          <p class="dal06-headline"><?php echo wp_kses_post( $t['panel_html'] ); ?></p>
          <ul class="dal06-bullets">
            <?php foreach ( $bullets as $b ) :
              $b = trim( $b );
              if ( $b === '' ) continue; ?>
              <li><?php echo esc_html( $b ); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if ( 'yes' === ( $s['show_quote'] ?? 'yes' ) ) : ?>
    <div class="dal06-quote">
      <p>
        <?php echo esc_html( $s['quote_text'] ); ?>
        <a href="<?php echo $hu; ?>"><?php echo esc_html( $s['quote_link_text'] ); ?></a>
      </p>
    </div>
    <?php endif; ?>

  </div>
</section>

<script>
(function(){
  var root = document.querySelector('.<?php echo $uid; ?>');
  if (!root || root.dataset.bjlzInit === '1') return;
  root.dataset.bjlzInit = '1';
  var tabs = root.querySelectorAll('.dal06-tab');
  var panels = root.querySelectorAll('.dal06-panel');
  tabs.forEach(function(btn){
    btn.addEventListener('click', function(){
      var key = btn.dataset.tab;
      tabs.forEach(function(b){
        var on = (b === btn);
        b.classList.toggle('is-active', on);
        b.setAttribute('aria-selected', on ? 'true' : 'false');
      });
      panels.forEach(function(p){
        p.classList.toggle('is-active', p.dataset.panel === key);
      });
    });
  });
})();
</script>
        <?php
    }
}
