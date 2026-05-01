<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DLW-04 — Features Grid (Demo Landing)
 * 6 feature cards on a slate-50 section. Icon color alternates orange/indigo.
 */
class Widget_DLW_Features extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dlw_04_features'; }
    public function get_title()      { return 'DLW 04 — Features Grid'; }
    public function get_icon()       { return 'eicon-icon-box'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'features', 'icons', 'why', 'benefits', 'bizjump', 'dlw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_header', [
            'label' => 'Section Header', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'label_text', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Why BizJump' ] );
        $this->add_control( 'title_text', [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Everything You Need to Launch' ] );
        $this->add_control( 'sub_text',   [ 'label' => 'Subtitle','type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'We take care of the legal paperwork, so you can focus on what matters — building your business.' ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_items', [
            'label' => 'Feature Items', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'icon', [
            'label' => 'Icon',
            'type'  => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'file'      => 'File / Document',
                'shield'    => 'Shield',
                'clock'     => 'Clock',
                'tax'       => 'Tax / Dollar',
                'agreement' => 'Agreement',
                'support'   => 'Support / Chat',
                'lock'      => 'Lock',
                'check'     => 'Check',
            ],
            'default' => 'file',
        ] );
        $rep->add_control( 'color', [
            'label' => 'Icon Color',
            'type'  => \Elementor\Controls_Manager::SELECT,
            'options' => [ 'orange' => 'Orange', 'indigo' => 'Indigo' ],
            'default' => 'orange',
        ] );
        $rep->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Feature Title' ] );
        $rep->add_control( 'desc',  [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Description goes here.' ] );

        $this->add_control( 'items', [
            'label' => 'Items',
            'type'  => \Elementor\Controls_Manager::REPEATER,
            'fields'=> $rep->get_controls(),
            'default' => [
                [ 'icon' => 'file',      'color' => 'orange', 'title' => 'Fast, Simple Filing', 'desc' => 'Answer a few questions and we\'ll prepare and file your LLC documents with the state — typically in one business day.' ],
                [ 'icon' => 'shield',    'color' => 'indigo', 'title' => 'Registered Agent Service', 'desc' => 'Every LLC needs a registered agent. We\'ll serve as yours, ensuring you never miss an important legal document.' ],
                [ 'icon' => 'clock',     'color' => 'orange', 'title' => 'Fast Turnaround', 'desc' => 'Standard processing in 3–5 days. Pro customers get priority handling — expedited to as fast as 24 hours.' ],
                [ 'icon' => 'tax',       'color' => 'indigo', 'title' => 'EIN / Tax ID Filing', 'desc' => 'Get your federal Employer Identification Number — required to open a business bank account and hire employees.' ],
                [ 'icon' => 'agreement', 'color' => 'orange', 'title' => 'Operating Agreement', 'desc' => 'A custom operating agreement to protect your personal assets and define how your LLC is managed.' ],
                [ 'icon' => 'support',   'color' => 'indigo', 'title' => 'Expert Support', 'desc' => 'Real humans available 7 days a week. Have a question? Our formation specialists are here to help.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    private function feat_icon( $key ) {
        switch ( $key ) {
            case 'shield':    return '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>';
            case 'clock':     return '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>';
            case 'tax':       return '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>';
            case 'agreement': return '<rect x="3" y="3" width="18" height="18" rx="2"/><line x1="9" y1="9" x2="15" y2="9"/><line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="15" x2="12" y2="15"/>';
            case 'support':   return '<path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>';
            case 'lock':      return '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>';
            case 'check':     return '<polyline points="20 6 9 17 4 12"/>';
            default:          return '<path d="M13 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V9z"/><polyline points="13 2 13 9 20 9"/>';
        }
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
.dlw04-section { padding: 88px 0; background: #F8FAFC; font-family: 'Inter', sans-serif; }
.dlw04-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.dlw04-header { text-align: center; margin-bottom: 56px; }
.dlw04-label { display: inline-block; font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #F97316; margin-bottom: 12px; }
.dlw04-title { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: clamp(26px,3.5vw,40px); font-weight: 800; color: #0F172A; line-height: 1.2; letter-spacing: -.02em; margin: 0 0 14px; }
.dlw04-sub { font-size: 17px; color: #64748B; max-width: 520px; margin: 0 auto; line-height: 1.65; }

.dlw04-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
.dlw04-card { background: #fff; border: 1px solid #E2E8F0; border-radius: 14px; padding: 32px 28px; box-shadow: 0 2px 6px rgba(15,23,42,.08); transition: box-shadow .25s, transform .25s; }
.dlw04-card:hover { box-shadow: 0 4px 14px rgba(15,23,42,.10); transform: translateY(-2px); }
.dlw04-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; }
.dlw04-icon.dlw04-orange { background: #FFF7ED; color: #F97316; }
.dlw04-icon.dlw04-indigo { background: #EEF2FF; color: #6366F1; }
.dlw04-feat-title { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: 17px; font-weight: 700; color: #1E293B; margin-bottom: 10px; }
.dlw04-desc { font-size: 14px; color: #64748B; line-height: 1.65; }

@media (max-width: 900px) { .dlw04-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; } }
@media (max-width: 600px) {
  .dlw04-section { padding: 64px 0; }
  .dlw04-header { margin-bottom: 40px; }
  .dlw04-grid { grid-template-columns: 1fr; gap: 16px; }
  .dlw04-card { padding: 26px 22px; }
}
</style>

<section class="dlw04-section">
  <div class="dlw04-inner">
    <div class="dlw04-header">
      <span class="dlw04-label"><?php echo esc_html( $s['label_text'] ); ?></span>
      <h2 class="dlw04-title"><?php echo esc_html( $s['title_text'] ); ?></h2>
      <p class="dlw04-sub"><?php echo esc_html( $s['sub_text'] ); ?></p>
    </div>
    <div class="dlw04-grid">
      <?php foreach ( (array) $s['items'] as $it ) : ?>
        <div class="dlw04-card">
          <div class="dlw04-icon dlw04-<?php echo esc_attr( $it['color'] ); ?>">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $this->feat_icon( $it['icon'] ); ?></svg>
          </div>
          <div class="dlw04-feat-title"><?php echo esc_html( $it['title'] ); ?></div>
          <p class="dlw04-desc"><?php echo esc_html( $it['desc'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
