<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DAL-10 — Entity Cards (Doc-Aligned Landing)
 * Source: 03. bizjump-doc-aligned/formation-landing.html — .hero-zone .entity-card-grid
 * Cream-bg centered headline + 4 entity cards (icon, name, price, desc, bullets, CTA).
 * "Need Help?" line below.
 *
 * Wizard integration:
 *   Each card's CTA URL is built as {wizard_url}?{param}={entity_slug}.
 *   The bizjump-wizard plugin reads ?entity=llc|ccorp|scorp|nonprofit on its page
 *   to pre-select the corresponding step. Set the "Wizard Page URL" once at the
 *   widget level — every card uses it automatically.
 */
class Widget_DAL_Entity_Cards extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dal_10_entity_cards'; }
    public function get_title()      { return 'DAL 10 — Entity Cards (→ Wizard)'; }
    public function get_icon()       { return 'eicon-price-list'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'entities', 'cards', 'llc', 'corporation', 'wizard', 'bizjump', 'dal' ]; }

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

        /* ── Wizard Integration ── */
        $this->start_controls_section( 'sec_wizard', [
            'label' => 'Wizard Integration',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'wizard_info', [
            'type' => \Elementor\Controls_Manager::RAW_HTML,
            'raw'  => '<strong>How this works:</strong><br>The bizjump-wizard plugin reads <code>?entity=…</code> from the URL to pre-select. Set the page where you placed the <code>[bizjump_wizard]</code> shortcode here, and the cards will route to it automatically.',
            'content_classes' => 'elementor-control-field-description',
        ] );
        $this->add_control( 'wizard_url', [
            'label'       => 'Wizard Page URL',
            'type'        => \Elementor\Controls_Manager::URL,
            'description' => 'The page that hosts the [bizjump_wizard] shortcode. Default: /start/',
            'default'     => [ 'url' => '/start/' ],
            'show_external' => false,
        ] );
        $this->add_control( 'wizard_param', [
            'label'   => 'Query Parameter Name',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'entity',
            'description' => 'Default: entity. Built URL: /start/?entity=llc',
        ] );
        $this->add_control( 'override_per_card', [
            'label'        => 'Allow Per-Card URL Override',
            'description'  => 'Turn ON to use a custom full URL on individual cards (e.g. external links).',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'default'      => '',
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
                'custom'    => 'Custom SVG',
            ],
            'default' => 'home',
        ] );
        $rep->add_control( 'icon_custom', [
            'label'       => 'Custom SVG markup',
            'type'        => \Elementor\Controls_Manager::TEXTAREA,
            'description' => 'Inner SVG paths only — no <svg> wrapper.',
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
            'rows'        => 6,
            'default'     => "Personal liability protection\nPass-through taxation\nFlexible management structure\nNo board of directors required",
        ] );
        $rep->add_control( 'btn_text', [
            'label'   => 'Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Start my LLC',
        ] );
        $rep->add_control( 'entity_slug', [
            'label'       => 'Entity Slug (passed to wizard)',
            'type'        => \Elementor\Controls_Manager::SELECT,
            'options'     => [
                'llc'        => 'llc (LLC)',
                'c_corp'     => 'c_corp (C Corporation)',
                's_corp'     => 's_corp (S Corporation)',
                'non_profit' => 'non_profit (Nonprofit)',
            ],
            'default'     => 'llc',
            'description' => 'Must match the wizard\'s data-entity values exactly.',
        ] );
        $rep->add_control( 'btn_url_override', [
            'label'     => 'Custom URL (overrides wizard URL)',
            'type'      => \Elementor\Controls_Manager::URL,
            'description' => 'Only used when "Allow Per-Card URL Override" is ON in Wizard Integration tab.',
        ] );

        $this->add_control( 'entities', [
            'label'   => 'Cards',
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $rep->get_controls(),
            'default' => [
                [
                    'icon'        => 'home',
                    'name'        => 'LLC',
                    'price'       => 'Starts at $99 + state filing fees',
                    'desc'        => 'The simplest and most flexible business structure. Protect your personal assets without the complexity of a corporation.',
                    'bullets'     => "Personal liability protection\nPass-through taxation\nFlexible management structure\nNo board of directors required",
                    'btn_text'    => 'Start my LLC',
                    'entity_slug' => 'llc',
                ],
                [
                    'icon'        => 'building',
                    'name'        => 'Corporation',
                    'price'       => 'Starts at $149 + state filing fees',
                    'desc'        => 'A structured business designed for growth and raising money. Best for companies planning to scale or bring in investors.',
                    'bullets'     => "Strong personal liability protection\nCan raise money by selling shares\nNo limit on number of shareholders\nRequires a board of directors",
                    'btn_text'    => 'Start my C-Corp',
                    'entity_slug' => 'c_corp',
                ],
                [
                    'icon'        => 'dollar',
                    'name'        => 'S-Corp',
                    'price'       => 'Starts at $149 + state filing fees',
                    'desc'        => 'A tax status that helps avoid double taxation while maintaining a structured business setup. Best for small to mid-sized businesses.',
                    'bullets'     => "Pass-through taxation\nPotential self-employment tax savings\nUp to 100 shareholders\nU.S. citizens / residents only",
                    'btn_text'    => 'Start my S-Corp',
                    'entity_slug' => 's_corp',
                ],
                [
                    'icon'        => 'heart',
                    'name'        => 'Not-for-Profit',
                    'price'       => 'Starts at $99 + state filing fees',
                    'desc'        => 'An organization formed to serve a public or community purpose rather than generate profit for owners.',
                    'bullets'     => "No owners or shareholders\nEligible for tax-exempt status\nCan receive donations and grants\nRequires a board of directors",
                    'btn_text'    => 'Start my Non-profit',
                    'entity_slug' => 'non_profit',
                ],
            ],
            'title_field' => '{{{ name }}} → {{{ entity_slug }}}',
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
            'default' => [ 'url' => '/contact/' ],
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
            case 'custom':    return $custom;
            default:          return '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>';
        }
    }

    /**
     * Build the final href for a card.
     * - If "Allow Per-Card URL Override" is ON and the card has a custom URL → use it.
     * - Otherwise compose {wizard_url}?{param}={entity_slug}.
     */
    private function card_url( $card, $wizard_url, $param, $allow_override ) {
        if ( $allow_override && ! empty( $card['btn_url_override']['url'] ) ) {
            return [
                'url'      => esc_url( $card['btn_url_override']['url'] ),
                'external' => ! empty( $card['btn_url_override']['is_external'] ),
            ];
        }
        $base = $wizard_url ?: '/start/';
        $slug = preg_replace( '/[^a-zA-Z0-9_\-]/', '', $card['entity_slug'] ?? '' );
        $sep  = ( strpos( $base, '?' ) === false ) ? '?' : '&';
        $url  = $slug !== '' ? $base . $sep . rawurlencode( $param ) . '=' . rawurlencode( $slug ) : $base;
        return [ 'url' => esc_url( $url ), 'external' => false ];
    }

    protected function render() {
        $s        = $this->get_settings_for_display();
        $hu       = ! empty( $s['help_link_url']['url'] ) ? esc_url( $s['help_link_url']['url'] ) : '#';
        $bg       = esc_attr( $s['bg_color']   ?: '#FAF6F0' );
        $o500     = esc_attr( $s['orange_500'] ?: '#F97316' );
        $o600     = esc_attr( $s['orange_600'] ?: '#EA580C' );
        $nowrap   = ( 'yes' === ( $s['headline_nowrap'] ?? 'yes' ) );
        $allow_ov = ( 'yes' === ( $s['override_per_card'] ?? '' ) );
        $wiz_url  = $s['wizard_url']['url'] ?? '/start/';
        $param    = preg_replace( '/[^a-zA-Z0-9_]/', '', $s['wizard_param'] ?: 'entity' );
        $uid      = 'dal10_' . $this->get_id();
        ?>
<style>
.<?php echo $uid; ?>.dal10-zone {
  background: <?php echo $bg; ?>;
  padding: 64px 0 72px;
  text-align: center;
  font-family: 'Inter', sans-serif;
}
.<?php echo $uid; ?> .dal10-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }

.<?php echo $uid; ?> .dal10-h1 {
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: clamp(26px, 4.2vw, 46px);
  font-weight: 800; line-height: 1.12;
  letter-spacing: -.025em; color: #0F172A;
  margin: 0 auto 44px;
  <?php if ( $nowrap ) : ?>white-space: nowrap;<?php endif; ?>
}

.<?php echo $uid; ?> .dal10-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  max-width: 1040px;
  margin: 0 auto;
  text-align: left;
}
.<?php echo $uid; ?> .dal10-card {
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
.<?php echo $uid; ?> .dal10-card::before {
  content: ''; position: absolute;
  top: 0; left: 0; right: 0; height: 3px;
  background: transparent; transition: background .25s;
}
.<?php echo $uid; ?> .dal10-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 16px 36px rgba(15,23,42,0.12);
  border-color: #FED7AA;
}
.<?php echo $uid; ?> .dal10-card:hover::before { background: <?php echo $o500; ?>; }

.<?php echo $uid; ?> .dal10-icon {
  width: 44px; height: 44px;
  border-radius: 11px;
  background: #FFF7ED;
  color: <?php echo $o600; ?>;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 12px;
}
.<?php echo $uid; ?> .dal10-name {
  font-family: 'Plus Jakarta Sans','Inter',sans-serif;
  font-size: 19px; font-weight: 800;
  color: #0F172A; letter-spacing: -.01em;
  margin: 0 0 3px; line-height: 1.2;
}
.<?php echo $uid; ?> .dal10-price {
  font-size: 11.5px; font-weight: 600;
  color: <?php echo $o600; ?>;
  margin: 0 0 10px; letter-spacing: .01em;
}
.<?php echo $uid; ?> .dal10-desc {
  font-size: 13px; color: #475569;
  line-height: 1.5; margin: 0 0 12px;
  display: -webkit-box; -webkit-line-clamp: 3;
  -webkit-box-orient: vertical; overflow: hidden;
}
.<?php echo $uid; ?> .dal10-bullets {
  list-style: none; padding: 0; margin: 0 0 16px;
  display: flex; flex-direction: column; gap: 6px; flex: 1;
}
.<?php echo $uid; ?> .dal10-bullets li {
  display: flex; align-items: flex-start; gap: 8px;
  font-size: 12.5px; color: #334155; line-height: 1.45;
}
.<?php echo $uid; ?> .dal10-bullets li::before {
  content: ''; flex-shrink: 0;
  width: 15px; height: 15px; border-radius: 50%;
  background: #FFF7ED;
  background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23EA580C' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'><polyline points='20 6 9 17 4 12'/></svg>");
  background-repeat: no-repeat;
  background-position: center;
  background-size: 9px;
  margin-top: 2px;
}
.<?php echo $uid; ?> .dal10-cta {
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
.<?php echo $uid; ?> .dal10-cta:hover {
  background: <?php echo $o600; ?>; color: #fff;
  box-shadow: 0 6px 22px rgba(249,115,22,0.42);
  transform: translateY(-1px);
}

.<?php echo $uid; ?> .dal10-help {
  display: flex; align-items: center; justify-content: center;
  gap: 8px; margin: 36px 0 0;
  font-size: 14px; color: #475569;
  flex-wrap: wrap;
}
.<?php echo $uid; ?> .dal10-help a {
  color: <?php echo $o600; ?>;
  font-weight: 600; text-decoration: underline;
  text-underline-offset: 3px;
  transition: color .15s;
}
.<?php echo $uid; ?> .dal10-help a:hover { color: #C2410C; }
.<?php echo $uid; ?> .dal10-help svg { color: <?php echo $o500; ?>; flex-shrink: 0; }

@media (max-width: 1024px) {
  .<?php echo $uid; ?> .dal10-grid { grid-template-columns: repeat(2, 1fr); max-width: 720px; }
}
@media (max-width: 760px) {
  .<?php echo $uid; ?> .dal10-h1 { white-space: normal; }
}
@media (max-width: 560px) {
  .<?php echo $uid; ?>.dal10-zone { padding: 48px 0 56px; }
  .<?php echo $uid; ?> .dal10-grid { grid-template-columns: 1fr; max-width: 420px; }
  .<?php echo $uid; ?> .dal10-h1 { margin-bottom: 28px; }
}
</style>

<section class="<?php echo $uid; ?> dal10-zone" id="entities">
  <div class="dal10-inner">

    <h1 class="dal10-h1"><?php echo esc_html( $s['headline'] ); ?></h1>

    <div class="dal10-grid">
      <?php foreach ( (array) $s['entities'] as $e ) :
        $url_data = $this->card_url( $e, $wiz_url, $param, $allow_ov );
        $url      = $url_data['url'];
        $tgt      = $url_data['external'] ? ' target="_blank" rel="noopener noreferrer"' : '';
        $bullets  = preg_split( '/\r\n|\r|\n/', (string) ( $e['bullets'] ?? '' ) );
        $svg_inner = $this->entity_icon( $e['icon'] ?? 'home', $e['icon_custom'] ?? '' );
      ?>
      <article class="dal10-card">
        <div class="dal10-icon">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $svg_inner; ?></svg>
        </div>
        <h3 class="dal10-name"><?php echo esc_html( $e['name'] ); ?></h3>
        <p class="dal10-price"><?php echo esc_html( $e['price'] ); ?></p>
        <p class="dal10-desc"><?php echo esc_html( $e['desc'] ); ?></p>
        <?php if ( ! empty( array_filter( $bullets ) ) ) : ?>
        <ul class="dal10-bullets">
          <?php foreach ( $bullets as $b ) :
            $b = trim( $b );
            if ( $b === '' ) continue; ?>
            <li><?php echo esc_html( $b ); ?></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <a href="<?php echo $url; ?>"<?php echo $tgt; ?> class="dal10-cta">
          <?php echo esc_html( $e['btn_text'] ); ?>
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </article>
      <?php endforeach; ?>
    </div>

    <?php if ( 'yes' === ( $s['show_help'] ?? 'yes' ) ) : ?>
    <p class="dal10-help">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
      <?php echo esc_html( $s['help_text'] ); ?> <a href="<?php echo $hu; ?>"><?php echo esc_html( $s['help_link_text'] ); ?></a>
    </p>
    <?php endif; ?>

  </div>
</section>
        <?php
    }
}
