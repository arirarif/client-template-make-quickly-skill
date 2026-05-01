<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-05 — Why BizJump (Formation Landing)
 * 6 icon-cards on white bg. Tighter padding than DLW-04 features.
 */
class Widget_FLW_Why_BizJump extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_05_why'; }
    public function get_title()      { return 'FLW 05 — Why BizJump'; }
    public function get_icon()       { return 'eicon-favorite'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'why', 'features', 'benefits', 'icons', 'bizjump', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_header', [
            'label' => 'Section Header', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'label_text', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Why Us' ] );
        $this->add_control( 'title_text', [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The BizJump Difference' ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_items', [
            'label' => 'Items', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', [
            'label' => 'Icon',
            'type'  => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'clock'    => 'Clock',
                'shield'   => 'Shield',
                'support'  => 'Support / Chat',
                'docs'     => 'Documents',
                'lock'     => 'Lock',
                'tax'      => 'Tax / Dollar',
            ],
            'default' => 'clock',
        ] );
        $rep->add_control( 'color', [
            'label' => 'Icon Color',
            'type'  => \Elementor\Controls_Manager::SELECT,
            'options' => [ 'orange' => 'Orange', 'indigo' => 'Indigo' ],
            'default' => 'orange',
        ] );
        $rep->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Title' ] );
        $rep->add_control( 'desc',  [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Description goes here.' ] );

        $this->add_control( 'items', [
            'label' => 'Items', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $rep->get_controls(),
            'default' => [
                [ 'icon' => 'clock',   'color' => 'orange', 'title' => 'Fast Processing', 'desc' => 'Standard orders are filed within 1 business day. Expedited customers get same-day submission.' ],
                [ 'icon' => 'shield',  'color' => 'indigo', 'title' => '100% Accuracy Guarantee', 'desc' => 'If we make a mistake on your filing, we\'ll fix it at no additional charge — guaranteed.' ],
                [ 'icon' => 'support', 'color' => 'orange', 'title' => 'Real People, Real Help', 'desc' => 'Speak with a formation specialist 7 days a week. No bots — just knowledgeable humans ready to help.' ],
                [ 'icon' => 'docs',    'color' => 'indigo', 'title' => 'Complete Document Package', 'desc' => 'Operating agreements, EIN, registered agent, and more — everything your business needs in one place.' ],
                [ 'icon' => 'lock',    'color' => 'orange', 'title' => 'Secure & Private', 'desc' => 'Your data is protected with 256-bit encryption. We never sell your information to third parties.' ],
                [ 'icon' => 'tax',     'color' => 'indigo', 'title' => 'No Hidden Fees', 'desc' => 'You see exactly what you pay before checkout. The only added cost is your state\'s filing fee — shown upfront.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );
        $this->end_controls_section();
    }

    private function ic( $key ) {
        switch ( $key ) {
            case 'shield':  return '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>';
            case 'support': return '<path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>';
            case 'docs':    return '<rect x="3" y="3" width="18" height="18" rx="2"/><line x1="9" y1="9" x2="15" y2="9"/><line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="15" x2="12" y2="15"/>';
            case 'lock':    return '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>';
            case 'tax':     return '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>';
            default:        return '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>';
        }
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.flw05-section { padding: 72px 0; background: #FFFFFF; font-family: 'Inter', sans-serif; }
.flw05-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.flw05-header { text-align: center; margin-bottom: 48px; }
.flw05-label { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #F97316; margin-bottom: 10px; }
.flw05-title { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: clamp(22px,3vw,34px); font-weight: 800; color: #0F172A; line-height: 1.2; letter-spacing: -.02em; margin: 0 0 12px; }

.flw05-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.flw05-card { background: #fff; border: 1px solid #E2E8F0; border-radius: 14px; padding: 26px; box-shadow: 0 1px 3px rgba(15,23,42,.06); transition: box-shadow .2s, transform .2s; }
.flw05-card:hover { box-shadow: 0 4px 14px rgba(15,23,42,.10); transform: translateY(-2px); }
.flw05-icon { width: 46px; height: 46px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
.flw05-icon.flw05-orange { background: #FFF7ED; color: #F97316; }
.flw05-icon.flw05-indigo { background: #EEF2FF; color: #6366F1; }
.flw05-feat-title { font-size: 15px; font-weight: 700; color: #1E293B; margin-bottom: 7px; }
.flw05-desc { font-size: 13px; color: #94A3B8; line-height: 1.65; }

@media (max-width: 900px) { .flw05-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; } }
@media (max-width: 600px) {
  .flw05-section { padding: 56px 0; }
  .flw05-grid { grid-template-columns: 1fr; }
  .flw05-card { padding: 22px; }
}
</style>

<section class="flw05-section">
  <div class="flw05-inner">
    <div class="flw05-header">
      <span class="flw05-label"><?php echo esc_html( $s['label_text'] ); ?></span>
      <h2 class="flw05-title"><?php echo esc_html( $s['title_text'] ); ?></h2>
    </div>
    <div class="flw05-grid">
      <?php foreach ( (array) $s['items'] as $it ) : ?>
        <div class="flw05-card">
          <div class="flw05-icon flw05-<?php echo esc_attr( $it['color'] ); ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $this->ic( $it['icon'] ); ?></svg>
          </div>
          <div class="flw05-feat-title"><?php echo esc_html( $it['title'] ); ?></div>
          <p class="flw05-desc"><?php echo esc_html( $it['desc'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
