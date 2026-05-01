<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DLW-03 — Pricing Cards (Demo Landing)
 * 3 pricing cards. Mark a card as "Featured" to apply the orange ring.
 */
class Widget_DLW_Pricing extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dlw_03_pricing'; }
    public function get_title()      { return 'DLW 03 — Pricing Cards'; }
    public function get_icon()       { return 'eicon-price-table'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'pricing', 'plans', 'cards', 'bizjump', 'dlw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'label_text', [
            'label' => 'Eyebrow Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Pricing',
        ] );
        $this->add_control( 'title_text', [
            'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Choose Your Formation Package',
        ] );
        $this->add_control( 'sub_text', [
            'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'All plans include LLC formation, registered agent for 30 days, and operating agreement template.',
        ] );
        $this->end_controls_section();

        /* ── Cards ── */
        $this->start_controls_section( 'sec_cards', [
            'label' => 'Pricing Cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'name', [
            'label' => 'Plan Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Basic',
        ] );
        $rep->add_control( 'price_currency', [
            'label' => 'Currency Symbol', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '$',
        ] );
        $rep->add_control( 'price_amount', [
            'label' => 'Price Amount', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '0',
        ] );
        $rep->add_control( 'price_note', [
            'label' => 'Price Note', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '+ state filing fee',
        ] );
        $rep->add_control( 'features', [
            'label' => 'Features (one per line)',
            'type'  => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "State articles of organization\nName availability search\nOnline order status tracking\nEmail support",
        ] );
        $rep->add_control( 'btn_text', [
            'label' => 'Button Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Get Started Free',
        ] );
        $rep->add_control( 'btn_url', [
            'label' => 'Button URL', 'type' => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/start/' ],
        ] );
        $rep->add_control( 'is_featured', [
            'label'        => 'Featured (orange ring)',
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ] );
        $rep->add_control( 'badge_text', [
            'label' => 'Featured Badge Text', 'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Most Popular',
            'condition' => [ 'is_featured' => 'yes' ],
        ] );

        $this->add_control( 'cards', [
            'label'   => 'Cards',
            'type'    => \Elementor\Controls_Manager::REPEATER,
            'fields'  => $rep->get_controls(),
            'default' => [
                [
                    'name' => 'Basic', 'price_amount' => '0', 'price_currency' => '$',
                    'price_note' => '+ state filing fee',
                    'features'   => "State articles of organization\nName availability search\nOnline order status tracking\nEmail support",
                    'btn_text'   => 'Get Started Free',
                    'btn_url'    => [ 'url' => '/start/?plan=basic' ],
                    'is_featured'=> '',
                ],
                [
                    'name' => 'Pro', 'price_amount' => '149', 'price_currency' => '$',
                    'price_note' => '+ state filing fee',
                    'features'   => "Everything in Basic\nRegistered agent — 1 year included\nOperating agreement\nEIN / Tax ID filing\nPriority processing",
                    'btn_text'   => 'Get Started',
                    'btn_url'    => [ 'url' => '/start/?plan=pro' ],
                    'is_featured'=> 'yes',
                    'badge_text' => 'Most Popular',
                ],
                [
                    'name' => 'Premium', 'price_amount' => '299', 'price_currency' => '$',
                    'price_note' => '+ state filing fee',
                    'features'   => "Everything in Pro\nBusiness bank account setup\nBusiness credit card\nDomain + business email\nDedicated account manager",
                    'btn_text'   => 'Get Started',
                    'btn_url'    => [ 'url' => '/start/?plan=premium' ],
                    'is_featured'=> '',
                ],
            ],
            'title_field' => '{{{ name }}} — {{{ price_currency }}}{{{ price_amount }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.dlw03-section { padding: 88px 0; background: #FFFFFF; font-family: 'Inter', sans-serif; }
.dlw03-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.dlw03-header { text-align: center; margin-bottom: 56px; }
.dlw03-label { display: inline-block; font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #F97316; margin-bottom: 12px; }
.dlw03-title { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: clamp(26px,3.5vw,40px); font-weight: 800; color: #0F172A; line-height: 1.2; letter-spacing: -.02em; margin: 0 0 14px; }
.dlw03-sub { font-size: 17px; color: #64748B; max-width: 520px; margin: 0 auto; line-height: 1.65; }

.dlw03-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; align-items: start; }
.dlw03-card { background: #fff; border: 1px solid #E2E8F0; border-radius: 16px; padding: 36px 32px; box-shadow: 0 4px 14px rgba(15,23,42,.10); position: relative; transition: box-shadow .25s, transform .25s; }
.dlw03-card:hover { box-shadow: 0 8px 28px rgba(15,23,42,.12); transform: translateY(-3px); }
.dlw03-card.dlw03-featured { border: 2px solid #F97316; box-shadow: 0 8px 32px rgba(249,115,22,.14); transform: translateY(-6px); }
.dlw03-card.dlw03-featured:hover { box-shadow: 0 16px 48px rgba(249,115,22,.20); transform: translateY(-8px); }
.dlw03-badge { position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: #F97316; color: #fff; font-size: 12px; font-weight: 700; padding: 4px 16px; border-radius: 999px; white-space: nowrap; box-shadow: 0 4px 16px rgba(249,115,22,.35); }
.dlw03-name { font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #94A3B8; margin-bottom: 8px; }
.dlw03-price { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: 42px; font-weight: 800; color: #0F172A; line-height: 1; margin-bottom: 4px; }
.dlw03-price sup { font-size: 22px; vertical-align: super; font-weight: 700; }
.dlw03-note { font-size: 13px; color: #94A3B8; margin-bottom: 24px; }
.dlw03-divider { height: 1px; background: #E2E8F0; margin: 24px 0; }
.dlw03-features { list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 12px; }
.dlw03-features li { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; color: #475569; line-height: 1.5; }
.dlw03-check { width: 18px; height: 18px; background: #EEF2FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px; color: #6366F1; }
.dlw03-btn { width: 100%; padding: 13px; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; border: none; transition: all .2s; font-family: 'Inter', sans-serif; display: block; text-align: center; text-decoration: none; box-sizing: border-box; }
.dlw03-btn-outline { background: #fff; color: #334155; border: 1.5px solid #CBD5E1; }
.dlw03-btn-outline:hover { background: #F8FAFC; border-color: #94A3B8; color: #334155; }
.dlw03-btn-orange { background: #F97316; color: #fff; box-shadow: 0 4px 16px rgba(249,115,22,.35); }
.dlw03-btn-orange:hover { background: #EA580C; box-shadow: 0 6px 22px rgba(249,115,22,.45); transform: translateY(-1px); color: #fff; }

@media (max-width: 900px) {
  .dlw03-grid { grid-template-columns: 1fr; gap: 32px; max-width: 460px; margin: 0 auto; }
  .dlw03-card.dlw03-featured { transform: none; }
  .dlw03-card.dlw03-featured:hover { transform: translateY(-3px); }
}
@media (max-width: 600px) {
  .dlw03-section { padding: 64px 0; }
  .dlw03-header { margin-bottom: 40px; }
  .dlw03-card { padding: 28px 22px; }
  .dlw03-price { font-size: 36px; }
}
</style>

<section class="dlw03-section">
  <div class="dlw03-inner">
    <div class="dlw03-header">
      <span class="dlw03-label"><?php echo esc_html( $s['label_text'] ); ?></span>
      <h2 class="dlw03-title"><?php echo esc_html( $s['title_text'] ); ?></h2>
      <p class="dlw03-sub"><?php echo esc_html( $s['sub_text'] ); ?></p>
    </div>
    <div class="dlw03-grid">
      <?php foreach ( (array) $s['cards'] as $c ) :
          $featured = ! empty( $c['is_featured'] ) && $c['is_featured'] === 'yes';
          $btn_url = ! empty( $c['btn_url']['url'] ) ? esc_url( $c['btn_url']['url'] ) : '#';
          $btn_t   = ! empty( $c['btn_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
          $features = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $c['features'] ) ) );
      ?>
      <div class="dlw03-card<?php echo $featured ? ' dlw03-featured' : ''; ?>">
        <?php if ( $featured && ! empty( $c['badge_text'] ) ) : ?>
          <div class="dlw03-badge"><?php echo esc_html( $c['badge_text'] ); ?></div>
        <?php endif; ?>
        <div class="dlw03-name"><?php echo esc_html( $c['name'] ); ?></div>
        <div class="dlw03-price"><sup><?php echo esc_html( $c['price_currency'] ); ?></sup><?php echo esc_html( $c['price_amount'] ); ?></div>
        <div class="dlw03-note"><?php echo esc_html( $c['price_note'] ); ?></div>
        <div class="dlw03-divider"></div>
        <ul class="dlw03-features">
          <?php foreach ( $features as $feat ) : ?>
            <li>
              <span class="dlw03-check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
              <?php echo esc_html( $feat ); ?>
            </li>
          <?php endforeach; ?>
        </ul>
        <a href="<?php echo $btn_url; ?>"<?php echo $btn_t; ?> class="dlw03-btn <?php echo $featured ? 'dlw03-btn-orange' : 'dlw03-btn-outline'; ?>"><?php echo esc_html( $c['btn_text'] ); ?></a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
