<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-02 — Hero + Entity Card Grid (Formation Landing)
 * Source: 03. bizjump-doc-aligned/formation-landing.html
 * Cream-bg centered hero with a single big headline and a 4-card entity grid
 * (icon + name + price + description + bullets + CTA). "Need Help?" line below.
 * Updated v1.4.0: replaces the previous tabs+single-panel design with the new
 * LegalZoom-style card grid (no JS, all 4 entities visible at once).
 */
class Widget_FLW_Hero_Entity_Grid extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_02_hero_entities'; }
    public function get_title()      { return 'FLW 02 — Hero + Entity Grid'; }
    public function get_icon()       { return 'eicon-posts-grid'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'hero', 'entity', 'llc', 'corporation', 'cards', 'bizjump', 'flw' ]; }

    protected function register_controls() {

        /* ── Headline ── */
        $this->start_controls_section( 'sec_head', [
            'label' => 'Headline',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'headline', [
            'label'   => 'Headline',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Choose the structure that best fits your goals.',
        ] );
        $this->add_control( 'headline_nowrap', [
            'label'        => 'Force Single Line on Desktop',
            'description'  => 'Headline stays on one line ≥760px, wraps naturally below.',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );
        $this->end_controls_section();

        /* ── Entity Cards ── */
        $this->start_controls_section( 'sec_entities', [
            'label' => 'Entity Cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', [
            'label'   => 'Icon',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'home'      => 'Home (LLC)',
                'building'  => 'Building (Corporation)',
                'dollar'    => 'Dollar Sign (S-Corp)',
                'heart'     => 'Heart (Non-profit)',
                'briefcase' => 'Briefcase',
                'users'     => 'Users',
                'custom'    => 'Custom SVG (use field below)',
            ],
            'default' => 'home',
        ] );
        $rep->add_control( 'icon_custom', [
            'label'       => 'Custom SVG markup',
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'description' => 'Inner SVG paths only — no <svg> wrapper. Used when Icon = Custom.',
            'condition'   => [ 'icon' => 'custom' ],
        ] );
        $rep->add_control( 'name', [
            'label'   => 'Entity Name',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'LLC',
        ] );
        $rep->add_control( 'price', [
            'label'   => 'Price Line',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Starts at $99 + state filing fees',
        ] );
        $rep->add_control( 'desc', [
            'label'   => 'Description',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'The simplest and most flexible business structure. Protect your personal assets without the complexity of a corporation.',
        ] );
        $rep->add_control( 'bullets', [
            'label'       => 'Bullets (one per line)',
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'description' => 'Plain text, one bullet per line.',
            'default'     => "Personal liability protection\nPass-through taxation\nFlexible management structure\nNo board of directors required",
            'rows'        => 6,
        ] );
        $rep->add_control( 'btn_text', [
            'label'   => 'Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Start my LLC',
        ] );
        $rep->add_control( 'btn_url', [
            'label'   => 'Button URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/start/?entity=llc' ],
        ] );

        $this->add_control( 'entities', [
            'label'   => 'Cards',
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $rep->get_controls(),
            'default' => [
                [
                    'icon'     => 'home',
                    'name'     => 'LLC',
                    'price'    => 'Starts at $99 + state filing fees',
                    'desc'     => 'The simplest and most flexible business structure. Protect your personal assets without the complexity of a corporation.',
                    'bullets'  => "Personal liability protection\nPass-through taxation\nFlexible management structure\nNo board of directors required",
                    'btn_text' => 'Start my LLC',
                    'btn_url'  => [ 'url' => '/start/?entity=llc' ],
                ],
                [
                    'icon'     => 'building',
                    'name'     => 'Corporation',
                    'price'    => 'Starts at $149 + state filing fees',
                    'desc'     => 'A structured business designed for growth and raising money. Best for companies planning to scale or bring in investors.',
                    'bullets'  => "Strong personal liability protection\nCan raise money by selling shares\nNo limit on number of shareholders\nRequires a board of directors",
                    'btn_text' => 'Start my C-Corp',
                    'btn_url'  => [ 'url' => '/start/?entity=ccorp' ],
                ],
                [
                    'icon'     => 'dollar',
                    'name'     => 'S-Corp',
                    'price'    => 'Starts at $149 + state filing fees',
                    'desc'     => 'A tax status that helps avoid double taxation while maintaining a structured business setup. Best for small to mid-sized businesses.',
                    'bullets'  => "Pass-through taxation\nPotential self-employment tax savings\nUp to 100 shareholders\nU.S. citizens / residents only",
                    'btn_text' => 'Start my S-Corp',
                    'btn_url'  => [ 'url' => '/start/?entity=scorp' ],
                ],
                [
                    'icon'     => 'heart',
                    'name'     => 'Not-for-Profit',
                    'price'    => 'Starts at $99 + state filing fees',
                    'desc'     => 'An organization formed to serve a public or community purpose rather than generate profit for owners.',
                    'bullets'  => "No owners or shareholders\nEligible for tax-exempt status\nCan receive donations and grants\nRequires a board of directors",
                    'btn_text' => 'Start my Non-profit',
                    'btn_url'  => [ 'url' => '/start/?entity=nonprofit' ],
                ],
            ],
            'title_field' => '{{{ name }}}',
        ] );
        $this->end_controls_section();

        /* ── Help Line ── */
        $this->start_controls_section( 'sec_help', [
            'label' => 'Help Line',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'show_help', [
            'label'        => 'Show Help Line',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );
        $this->add_control( 'help_text', [
            'label'   => 'Help Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Need Help?',
            'condition' => [ 'show_help' => 'yes' ],
        ] );
        $this->add_control( 'help_link_text', [
            'label'   => 'Link Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Talk to A Representative',
            'condition' => [ 'show_help' => 'yes' ],
        ] );
        $this->add_control( 'help_link_url', [
            'label'   => 'Link URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#' ],
            'condition' => [ 'show_help' => 'yes' ],
        ] );
        $this->end_controls_section();

        /* ── Style ── */
        $this->start_controls_section( 'sec_style', [
            'label' => 'Colors',
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'bg_color', [
            'label'   => 'Section Background',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#FAF6F0',
        ] );
        $this->add_control( 'orange_500', [
            'label'   => 'Orange 500 (CTA, accent)',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#F97316',
        ] );
        $this->add_control( 'orange_600', [
            'label'   => 'Orange 600 (hover, price text)',
            'type'    => \Elementor\Controls_Manager::COLOR,
            'default' => '#EA580C',
        ] );
        $this->end_controls_section();
    }

    private function entity_icon( $key, $custom = '' ) {
        switch ( $key ) {
            case 'home':      return '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>';
            case 'building':  return '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/><line x1="2" y1="13" x2="22" y2="13"/>';
            case 'dollar':    return '<path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>';
            case 'heart':     return '<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>';
            case 'briefcase': return '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/>';
            case 'users':     return '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>';
            case 'custom':    return $custom; // passed through (allowed inside SVG)
            default:          return '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>';
        }
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $hu   = ! empty( $s['help_link_url']['url'] ) ? esc_url( $s['help_link_url']['url'] ) : '#';
        $bg   = esc_attr( $s['bg_color']   ?: '#FAF6F0' );
        $o500 = esc_attr( $s['orange_500'] ?: '#F97316' );
        $o600 = esc_attr( $s['orange_600'] ?: '#EA580C' );
        $nowrap = ( 'yes' === ( $s['headline_nowrap'] ?? 'yes' ) );
        ?>
<style>
.flw02-zone {
  background: <?php echo $bg; ?>;
  padding: 64px 0 72px;
  text-align: center;
  font-family: 'Inter', sans-serif;
}
.flw02-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }

.flw02-h1 {
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: clamp(26px, 4.2vw, 46px);
  font-weight: 800; line-height: 1.12;
  letter-spacing: -.025em; color: #0F172A;
  margin: 0 auto 44px;
  <?php if ( $nowrap ) : ?>white-space: nowrap;<?php endif; ?>
}

.flw02-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  max-width: 1040px;
  margin: 0 auto;
  text-align: left;
}
.flw02-card {
  background: #fff;
  border: 1px solid rgba(15,23,42,.07);
  border-radius: 18px;
  padding: 22px 20px 20px;
  box-shadow: 0 1px 3px rgba(15,23,42,0.06);
  display: flex; flex-direction: column;
  max-height: 450px;
  transition: transform .25s, box-shadow .25s, border-color .25s;
  position: relative; overflow: hidden;
}
.flw02-card::before {
  content: ''; position: absolute;
  top: 0; left: 0; right: 0; height: 3px;
  background: transparent; transition: background .25s;
}
.flw02-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 16px 36px rgba(15,23,42,0.12);
  border-color: #FED7AA;
}
.flw02-card:hover::before { background: <?php echo $o500; ?>; }

.flw02-icon {
  width: 44px; height: 44px;
  border-radius: 11px;
  background: #FFF7ED;
  color: <?php echo $o600; ?>;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 12px;
}
.flw02-name {
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: 19px; font-weight: 800;
  color: #0F172A; letter-spacing: -.01em;
  margin: 0 0 3px; line-height: 1.2;
}
.flw02-price {
  font-size: 11.5px; font-weight: 600;
  color: <?php echo $o600; ?>;
  margin: 0 0 10px; letter-spacing: .01em;
}
.flw02-desc {
  font-size: 13px; color: #475569;
  line-height: 1.5; margin: 0 0 12px;
  display: -webkit-box; -webkit-line-clamp: 3;
  -webkit-box-orient: vertical; overflow: hidden;
}
.flw02-bullets {
  list-style: none; padding: 0; margin: 0 0 16px;
  display: flex; flex-direction: column; gap: 6px; flex: 1;
}
.flw02-bullets li {
  display: flex; align-items: flex-start; gap: 8px;
  font-size: 12.5px; color: #334155; line-height: 1.45;
}
.flw02-bullets li::before {
  content: ''; flex-shrink: 0;
  width: 15px; height: 15px; border-radius: 50%;
  background: #FFF7ED;
  background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23EA580C' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'><polyline points='20 6 9 17 4 12'/></svg>");
  background-repeat: no-repeat;
  background-position: center;
  background-size: 9px;
  margin-top: 2px;
}
.flw02-cta {
  display: inline-flex; align-items: center; justify-content: center;
  gap: 6px; padding: 11px 16px;
  background: <?php echo $o500; ?>; color: #fff;
  font-family: 'Inter', sans-serif;
  font-size: 13.5px; font-weight: 700;
  border-radius: 10px; border: none;
  cursor: pointer; text-decoration: none;
  box-shadow: 0 4px 14px rgba(249,115,22,0.28);
  transition: all .2s;
  letter-spacing: .01em;
  margin-top: auto; text-align: center;
}
.flw02-cta:hover {
  background: <?php echo $o600; ?>; color: #fff;
  box-shadow: 0 6px 22px rgba(249,115,22,0.42);
  transform: translateY(-1px);
}

.flw02-help {
  display: flex; align-items: center; justify-content: center;
  gap: 8px; margin: 36px 0 0;
  font-size: 14px; color: #475569;
  flex-wrap: wrap;
}
.flw02-help a {
  color: <?php echo $o600; ?>;
  font-weight: 600; text-decoration: underline;
  text-underline-offset: 3px;
  transition: color .15s;
}
.flw02-help a:hover { color: #C2410C; }
.flw02-help svg { color: <?php echo $o500; ?>; flex-shrink: 0; }

@media (max-width: 1024px) {
  .flw02-grid { grid-template-columns: repeat(2, 1fr); max-width: 720px; }
}
@media (max-width: 760px) {
  .flw02-h1 { white-space: normal; }
}
@media (max-width: 560px) {
  .flw02-zone { padding: 48px 0 56px; }
  .flw02-grid { grid-template-columns: 1fr; max-width: 420px; }
  .flw02-h1 { margin-bottom: 28px; }
}
</style>

<section class="flw02-zone" id="entities">
  <div class="flw02-inner">

    <h1 class="flw02-h1"><?php echo esc_html( $s['headline'] ); ?></h1>

    <div class="flw02-grid">
      <?php foreach ( (array) $s['entities'] as $e ) :
        $url     = ! empty( $e['btn_url']['url'] ) ? esc_url( $e['btn_url']['url'] ) : '#';
        $tgt     = ! empty( $e['btn_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
        $bullets = preg_split( '/\r\n|\r|\n/', (string) ( $e['bullets'] ?? '' ) );
        $svg_inner = $this->entity_icon( $e['icon'] ?? 'home', $e['icon_custom'] ?? '' );
      ?>
      <article class="flw02-card">
        <div class="flw02-icon">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $svg_inner; ?></svg>
        </div>
        <h3 class="flw02-name"><?php echo esc_html( $e['name'] ); ?></h3>
        <p class="flw02-price"><?php echo esc_html( $e['price'] ); ?></p>
        <p class="flw02-desc"><?php echo esc_html( $e['desc'] ); ?></p>
        <?php if ( ! empty( array_filter( $bullets ) ) ) : ?>
        <ul class="flw02-bullets">
          <?php foreach ( $bullets as $b ) :
            $b = trim( $b );
            if ( $b === '' ) continue; ?>
            <li><?php echo esc_html( $b ); ?></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <a href="<?php echo $url; ?>"<?php echo $tgt; ?> class="flw02-cta">
          <?php echo esc_html( $e['btn_text'] ); ?>
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </article>
      <?php endforeach; ?>
    </div>

    <?php if ( 'yes' === ( $s['show_help'] ?? 'yes' ) ) : ?>
    <p class="flw02-help">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
      <?php echo esc_html( $s['help_text'] ); ?> <a href="<?php echo $hu; ?>"><?php echo esc_html( $s['help_link_text'] ); ?></a>
    </p>
    <?php endif; ?>

  </div>
</section>
        <?php
    }
}
