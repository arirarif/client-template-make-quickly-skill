<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_FAQ extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_08_faq'; }
    public function get_title()      { return '08 — FAQ'; }
    public function get_icon()       { return 'eicon-help-o'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'faq', 'questions', 'accordion', 'pp-uk' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'FAQ',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Frequently asked questions.',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'section_items', [
            'label' => 'Questions',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'question', [ 'label' => 'Question', 'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Your question?' ] );
        $rep->add_control( 'answer',   [ 'label' => 'Answer',   'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Your answer.', 'rows' => 4 ] );
        $this->add_control( 'items', [
            'label'       => 'Questions',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'question' => 'Are these peptides legal in the UK?',                           'answer' => 'Yes. Research peptides are not controlled substances in the UK. They are legal to purchase and possess for legitimate research purposes. They are not licensed medicines and must not be used for human or veterinary consumption.' ],
                [ 'question' => 'How do I pay? Can I use crypto?',                              'answer' => 'We accept credit and debit cards via our secure processor, as well as Bitcoin and Ethereum. Crypto payments receive a 5% discount. All payment pages are SSL-encrypted.' ],
                [ 'question' => 'How quickly will my order ship?',                              'answer' => 'Orders placed before 1pm on weekdays are dispatched same day from our UK depot. Standard tracked delivery takes 1–2 working days. Next-day delivery is available at checkout.' ],
                [ 'question' => 'Where do I find dosing or reconstitution info?',               'answer' => 'Each product page links to our companion knowledge base, which covers reconstitution protocols, storage guidelines, and reference data. We do not provide dosing advice — all information is provided for research reference only.' ],
                [ 'question' => 'Do you have an affiliate program?',                            'answer' => 'Yes. We run a commission-based affiliate programme for researchers, content creators, and review sites. Apply via the Affiliates page — approved partners receive a unique referral link and dashboard.' ],
            ],
            'title_field' => '{{{ question }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-faq{background:var(--pp-bg)}
  .pp-faq-grid{display:grid;grid-template-columns:1fr 2fr;gap:var(--pp-sp-96);align-items:start}
  .pp-faq-left .pp-eyebrow{margin-bottom:var(--pp-sp-16)}
  .pp-faq-left h2{max-width:280px}
  .pp-faq-list{display:flex;flex-direction:column}
  .pp-faq-item{border-bottom:1px solid var(--pp-border)}
  .pp-faq-q{list-style:none;cursor:pointer;padding:var(--pp-sp-24) 0;display:flex;justify-content:space-between;align-items:center;gap:var(--pp-sp-24);font-size:16px;font-weight:500;color:var(--pp-ink);line-height:1.4;user-select:none}
  .pp-faq-q::-webkit-details-marker{display:none}
  .pp-faq-q:focus-visible{outline:2px solid var(--pp-accent);outline-offset:2px;border-radius:2px}
  .pp-faq-q .pp-ico{width:20px;height:20px;position:relative;flex-shrink:0;color:var(--pp-ink-3)}
  .pp-faq-q .pp-ico::before{content:'';position:absolute;background:currentColor;top:9px;left:0;right:0;height:2px;transition:opacity 200ms var(--pp-ease)}
  .pp-faq-q .pp-ico::after{content:'';position:absolute;background:currentColor;left:9px;top:0;bottom:0;width:2px;transition:transform 200ms var(--pp-ease)}
  .pp-faq-item[open] .pp-faq-q .pp-ico::after{transform:rotate(90deg)}
  .pp-faq-answer{padding-bottom:var(--pp-sp-24);font-size:15px;color:var(--pp-ink-2);line-height:1.7;max-width:640px}
  @media(max-width:1024px){.pp-faq-grid{gap:var(--pp-sp-64)}}
  @media(max-width:900px){
    .pp-faq-grid{grid-template-columns:1fr;gap:var(--pp-sp-32)}
    .pp-faq-left h2{max-width:100%}
    .pp-faq-q{font-size:15px;padding:var(--pp-sp-20) 0}
    .pp-faq-answer{font-size:14px;padding-bottom:var(--pp-sp-20)}
  }
  @media(max-width:560px){
    .pp-faq-q{font-size:14px;padding:var(--pp-sp-16) 0;gap:var(--pp-sp-16)}
  }
</style>
<section class="pp-section pp-faq pp-pad" id="faq">
  <div class="pp-container">
    <div class="pp-faq-grid">
      <div class="pp-faq-left pp-reveal">
        <span class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
      </div>
      <div class="pp-faq-list pp-reveal">
        <?php foreach ( $s['items'] as $item ) : ?>
        <details class="pp-faq-item">
          <summary class="pp-faq-q">
            <span><?php echo esc_html( $item['question'] ); ?></span>
            <span class="pp-ico" aria-hidden="true"></span>
          </summary>
          <p class="pp-faq-answer"><?php echo esc_html( $item['answer'] ); ?></p>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
        <?php
    }
}
