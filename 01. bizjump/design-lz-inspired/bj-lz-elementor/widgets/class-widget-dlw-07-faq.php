<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DLW-07 — FAQ Accordion (Demo Landing)
 * Click toggle accordion. Single-open mode (closes others on click).
 */
class Widget_DLW_FAQ extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_dlw_07_faq'; }
    public function get_title()      { return 'DLW 07 — FAQ Accordion'; }
    public function get_icon()       { return 'eicon-help-o'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'faq', 'accordion', 'questions', 'bizjump', 'dlw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_header', [
            'label' => 'Section Header', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'label_text', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'FAQ' ] );
        $this->add_control( 'title_text', [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Common Questions' ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_items', [
            'label' => 'FAQ Items', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();
        $rep->add_control( 'q', [ 'label' => 'Question', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Question?' ] );
        $rep->add_control( 'a', [ 'label' => 'Answer',   'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Answer goes here.' ] );
        $rep->add_control( 'open', [
            'label' => 'Open by default',
            'type'  => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes', 'default' => '',
        ] );

        $this->add_control( 'items', [
            'label' => 'Items',
            'type'  => \Elementor\Controls_Manager::REPEATER,
            'fields'=> $rep->get_controls(),
            'default' => [
                [ 'q' => 'What is an LLC and why do I need one?', 'a' => 'An LLC (Limited Liability Company) protects your personal assets from business debts and lawsuits, while giving you the tax flexibility of a sole proprietorship. It\'s one of the most popular business structures for small business owners.', 'open' => 'yes' ],
                [ 'q' => 'How long does it take to form an LLC?', 'a' => 'Standard filing takes 3–5 business days. With our Pro and Premium plans, you get priority processing which can be as fast as 24 hours depending on your state.', 'open' => '' ],
                [ 'q' => 'What is a registered agent and do I need one?', 'a' => 'Every LLC is legally required to have a registered agent — someone designated to receive official state and legal documents on behalf of your business. BizJump can serve as your registered agent so you never miss an important notice.', 'open' => '' ],
                [ 'q' => 'Can I form an LLC in any state?', 'a' => 'Yes! BizJump files LLCs in all 50 U.S. states. State filing fees vary — you\'ll see your state\'s exact fee before completing your order.', 'open' => '' ],
            ],
            'title_field' => '{{{ q }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s   = $this->get_settings_for_display();
        $uid = 'dlw07_' . $this->get_id();
        ?>
<style>
.dlw07-section { padding: 88px 0; background: #FFFFFF; font-family: 'Inter', sans-serif; }
.dlw07-inner { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
.dlw07-header { text-align: center; margin-bottom: 48px; }
.dlw07-label { display: inline-block; font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #F97316; margin-bottom: 12px; }
.dlw07-title { font-family: 'Plus Jakarta Sans','Inter',sans-serif; font-size: clamp(26px,3.5vw,40px); font-weight: 800; color: #0F172A; line-height: 1.2; letter-spacing: -.02em; margin: 0 0 14px; }

.dlw07-list { max-width: 720px; margin: 0 auto; display: flex; flex-direction: column; gap: 8px; }
.dlw07-item { background: #fff; border: 1px solid #E2E8F0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(15,23,42,.06); }
.dlw07-q { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px; cursor: pointer; font-size: 15px; font-weight: 600; color: #1E293B; transition: background .15s; gap: 12px; user-select: none; }
.dlw07-q:hover { background: #F8FAFC; }
.dlw07-icon { width: 24px; height: 24px; background: #F1F5F9; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #64748B; transition: all .2s; }
.dlw07-item.dlw07-open .dlw07-icon { background: #FFF7ED; color: #F97316; transform: rotate(45deg); }
.dlw07-item.dlw07-open { border-color: #FFEDD5; }
.dlw07-a { padding: 0 24px; max-height: 0; overflow: hidden; transition: max-height .3s ease, padding .3s ease; font-size: 14px; color: #64748B; line-height: 1.7; }
.dlw07-item.dlw07-open .dlw07-a { max-height: 420px; padding: 0 24px 20px; }

@media (max-width: 600px) {
  .dlw07-section { padding: 64px 0; }
  .dlw07-header { margin-bottom: 36px; }
  .dlw07-q { padding: 16px 18px; font-size: 14px; }
  .dlw07-a { font-size: 13.5px; }
  .dlw07-item.dlw07-open .dlw07-a { padding: 0 18px 16px; max-height: 600px; }
}
</style>

<section class="dlw07-section">
  <div class="dlw07-inner">
    <div class="dlw07-header">
      <span class="dlw07-label"><?php echo esc_html( $s['label_text'] ); ?></span>
      <h2 class="dlw07-title"><?php echo esc_html( $s['title_text'] ); ?></h2>
    </div>
    <div class="dlw07-list" id="<?php echo esc_attr( $uid ); ?>">
      <?php foreach ( (array) $s['items'] as $it ) :
        $is_open = ! empty( $it['open'] ) && $it['open'] === 'yes';
      ?>
      <div class="dlw07-item<?php echo $is_open ? ' dlw07-open' : ''; ?>">
        <div class="dlw07-q" onclick="(function(el){var i=el.closest('.dlw07-item');var o=i.classList.contains('dlw07-open');i.parentElement.querySelectorAll('.dlw07-item').forEach(function(x){x.classList.remove('dlw07-open');});if(!o)i.classList.add('dlw07-open');})(this)">
          <?php echo esc_html( $it['q'] ); ?>
          <div class="dlw07-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
        </div>
        <div class="dlw07-a"><?php echo esc_html( $it['a'] ); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
        <?php
    }
}
