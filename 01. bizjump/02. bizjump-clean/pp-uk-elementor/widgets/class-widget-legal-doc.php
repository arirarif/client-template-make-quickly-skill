<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 20 — Legal Document
 * Reusable legal page layout: sticky auto-numbered TOC sidebar + scrollable section body.
 * Used for both Terms & Conditions and Privacy Policy pages.
 */
class Widget_Legal_Doc extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_20_legal_doc'; }
    public function get_title()      { return '20 — Legal Document'; }
    public function get_icon()       { return 'eicon-document-file'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'legal', 'terms', 'privacy', 'policy', 'doc', 'toc', 'pp-uk' ]; }

    protected function register_controls() {

        /* ── Meta bar ── */
        $this->start_controls_section( 'section_meta', [
            'label' => 'Document Meta',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'last_updated', [
            'label'   => 'Last Updated',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'April 2026',
        ] );

        $this->add_control( 'governing_law', [
            'label'   => 'Governing Law',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'England & Wales',
        ] );

        $this->add_control( 'applies_to', [
            'label'   => 'Applies To',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'All UK orders',
        ] );

        $this->add_control( 'legal_notice', [
            'label'   => 'Top Legal Notice (HTML)',
            'type'    => \Elementor\Controls_Manager::WYSIWYG,
            'default' => '<p><strong>Important:</strong> Please read these terms carefully before placing an order. By purchasing from Performance Peptide UK you agree to be bound by these terms. These products are supplied for research purposes only and must not be used for human or veterinary consumption.</p>',
        ] );

        $this->end_controls_section();

        /* ── Sections ── */
        $this->start_controls_section( 'section_content', [
            'label' => 'Document Sections',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'sec_title', [
            'label'   => 'Section Title',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Section Title',
        ] );

        $rep->add_control( 'sec_body', [
            'label'   => 'Section Body (HTML)',
            'type'    => \Elementor\Controls_Manager::WYSIWYG,
            'default' => '<p>Section content goes here.</p>',
        ] );

        $this->add_control( 'sections', [
            'label'       => 'Sections',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'sec_title' => 'Definitions',
                    'sec_body'  => '<p>"Company", "we", "us", "our" refers to Performance Peptide UK. "Products" means any research compounds supplied by the Company. "Buyer", "you", "your" means the individual or organisation placing an order. "COA" means Certificate of Analysis issued by an independent laboratory.</p>',
                ],
                [
                    'sec_title' => 'Eligibility',
                    'sec_body'  => '<p>You must be aged 18 or over to purchase from us. By placing an order you confirm that you are 18 or over and that the products are for legitimate research purposes. We reserve the right to request proof of age or research intent at any time.</p>',
                ],
                [
                    'sec_title' => 'Research Use Only',
                    'sec_body'  => '<p>All products sold by Performance Peptide UK are supplied exclusively for in-vitro research and laboratory use. They are not medicines, food supplements, or veterinary products. They must not be administered to humans or animals. The Company accepts no liability for misuse of these products.</p>',
                ],
                [
                    'sec_title' => 'Orders & Contract',
                    'sec_body'  => '<p>An order constitutes an offer to purchase. A contract is formed when we dispatch your order. We reserve the right to cancel any order at our discretion, including where we suspect the products will not be used for legitimate research, and to issue a full refund in such cases.</p>',
                ],
                [
                    'sec_title' => 'Pricing & Payment',
                    'sec_body'  => '<p>All prices are in GBP and include UK VAT where applicable. Prices are subject to change without notice. Payment must be received in full before dispatch. We accept credit/debit cards and cryptocurrency.</p>',
                ],
                [
                    'sec_title' => 'Delivery',
                    'sec_body'  => '<p>Delivery times are estimates only and not guaranteed. Risk in the products passes to you on delivery. Title passes on receipt of cleared payment. We are not liable for delays caused by the carrier or circumstances outside our control.</p>',
                ],
                [
                    'sec_title' => 'Returns & Refunds',
                    'sec_body'  => '<p>You have 14 days from receipt to notify us of any defect or discrepancy. Products must be returned in original condition, sealed, and accompanied by the original packing slip. Refunds are issued within 14 days of receiving the returned goods. We do not accept returns of correctly supplied, unsealed products due to the nature of research chemicals.</p>',
                ],
                [
                    'sec_title' => 'Limitation of Liability',
                    'sec_body'  => '<p>Our total liability to you in respect of any claim arising out of or in connection with a purchase shall not exceed the price paid for the relevant products. We are not liable for any indirect, consequential, or economic loss. Nothing in these terms limits our liability for death or personal injury caused by our negligence, or for fraud.</p>',
                ],
                [
                    'sec_title' => 'Governing Law',
                    'sec_body'  => '<p>These terms are governed by the laws of England and Wales. Any disputes shall be subject to the exclusive jurisdiction of the courts of England and Wales.</p>',
                ],
                [
                    'sec_title' => 'Contact',
                    'sec_body'  => '<p>Performance Peptide UK<br>Email: <a href="mailto:legal@performancepeptideuk.com">legal@performancepeptideuk.com</a><br>Registered in England and Wales.</p>',
                ],
            ],
            'title_field' => '{{{ sec_title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s         = $this->get_settings_for_display();
        $sections  = $s['sections'];
        $widget_id = $this->get_id();
        ?>
<style>
  .pp-legal{background:var(--pp-bg)}
  .pp-legal-meta{display:flex;align-items:center;gap:var(--pp-sp-24);flex-wrap:wrap;margin-bottom:var(--pp-sp-32)}
  .pp-legal-meta-item{font-family:var(--pp-f-mono);font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--pp-ink-3)}
  .pp-legal-meta-item strong{color:var(--pp-ink-2);font-weight:500}
  .pp-legal-meta-item::before{content:'·';margin-right:var(--pp-sp-12)}
  .pp-legal-meta-item:first-child::before{display:none}
  .pp-legal-notice{background:var(--pp-accent-2);border:1px solid rgba(30,58,95,.12);border-radius:var(--pp-r);padding:var(--pp-sp-20);margin-bottom:var(--pp-sp-48)}
  .pp-legal-notice p{font-size:14px;color:var(--pp-accent);line-height:1.6}
  .pp-legal-layout{display:grid;grid-template-columns:240px 1fr;gap:var(--pp-sp-64);align-items:start}
  /* TOC */
  .pp-legal-toc{position:sticky;top:88px;background:var(--pp-surface);border:1px solid var(--pp-border);border-radius:var(--pp-r-lg);overflow:hidden;counter-reset:toc-counter}
  .pp-legal-toc ul{padding:var(--pp-sp-8) 0}
  .pp-legal-toc li{counter-increment:toc-counter}
  .pp-legal-toc a{display:flex;align-items:baseline;gap:var(--pp-sp-12);padding:var(--pp-sp-10) var(--pp-sp-16);font-size:13px;color:var(--pp-ink-2);line-height:1.4;transition:background 150ms var(--pp-ease),color 150ms var(--pp-ease)}
  .pp-legal-toc a::before{content:counter(toc-counter,decimal-leading-zero) '.';font-family:var(--pp-f-mono);font-size:10px;color:var(--pp-ink-3);flex-shrink:0}
  .pp-legal-toc a:hover{background:var(--pp-surface-2);color:var(--pp-ink)}
  .pp-legal-toc a.pp-active{background:var(--pp-surface-2);color:var(--pp-ink);font-weight:500;border-left:3px solid var(--pp-ink)}
  /* Body */
  .pp-legal-body{display:flex;flex-direction:column;gap:var(--pp-sp-48)}
  .pp-legal-section{}
  .pp-legal-section h3{font-size:18px;font-weight:600;margin-bottom:var(--pp-sp-16);padding-bottom:var(--pp-sp-12);border-bottom:1px solid var(--pp-border)}
  .pp-legal-section p{font-size:15px;color:var(--pp-ink-2);line-height:1.75;margin-bottom:var(--pp-sp-12)}
  .pp-legal-section p:last-child{margin-bottom:0}
  .pp-legal-section a{color:var(--pp-accent);text-decoration:underline}
  .pp-legal-section ul{list-style:disc;padding-left:var(--pp-sp-24);margin-top:var(--pp-sp-12);display:flex;flex-direction:column;gap:var(--pp-sp-8)}
  .pp-legal-section ul li{font-size:15px;color:var(--pp-ink-2);line-height:1.6}
  @media(max-width:900px){
    .pp-legal-layout{grid-template-columns:1fr}
    .pp-legal-toc{position:static;display:flex;overflow-x:auto;background:none;border:none;border-radius:0;border-bottom:1px solid var(--pp-border);padding-bottom:var(--pp-sp-16)}
    .pp-legal-toc ul{display:flex;gap:var(--pp-sp-8);padding:0;white-space:nowrap;counter-reset:none}
    .pp-legal-toc li{counter-increment:none}
    .pp-legal-toc a{padding:8px 14px;border-radius:var(--pp-r);border:1px solid var(--pp-border);background:var(--pp-surface)}
    .pp-legal-toc a::before{display:none}
    .pp-legal-toc a.pp-active{background:var(--pp-ink);color:var(--pp-bg);border-color:var(--pp-ink);border-left-width:1px}
  }
</style>
<section class="pp-section pp-legal pp-pad">
  <div class="pp-container">

    <div class="pp-legal-meta pp-reveal">
      <?php if ( $s['last_updated'] ) : ?>
      <div class="pp-legal-meta-item"><strong>Updated:</strong> <?php echo esc_html( $s['last_updated'] ); ?></div>
      <?php endif; ?>
      <?php if ( $s['governing_law'] ) : ?>
      <div class="pp-legal-meta-item"><strong>Governing Law:</strong> <?php echo esc_html( $s['governing_law'] ); ?></div>
      <?php endif; ?>
      <?php if ( $s['applies_to'] ) : ?>
      <div class="pp-legal-meta-item"><strong>Applies To:</strong> <?php echo esc_html( $s['applies_to'] ); ?></div>
      <?php endif; ?>
    </div>

    <?php if ( $s['legal_notice'] ) : ?>
    <div class="pp-legal-notice pp-reveal">
      <?php echo wp_kses_post( $s['legal_notice'] ); ?>
    </div>
    <?php endif; ?>

    <div class="pp-legal-layout">

      <!-- TOC SIDEBAR -->
      <nav class="pp-legal-toc pp-reveal" aria-label="Document Contents">
        <ul>
          <?php foreach ( $sections as $i => $sec ) : ?>
          <li><a href="#<?php echo esc_attr( 'pp-legal-sec-' . $widget_id . '-' . $i ); ?>"><?php echo esc_html( $sec['sec_title'] ); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <!-- BODY -->
      <div class="pp-legal-body pp-reveal" style="transition-delay:80ms">
        <?php foreach ( $sections as $i => $sec ) : ?>
        <div class="pp-legal-section" id="<?php echo esc_attr( 'pp-legal-sec-' . $widget_id . '-' . $i ); ?>">
          <h3><?php echo esc_html( $sec['sec_title'] ); ?></h3>
          <?php echo wp_kses_post( $sec['sec_body'] ); ?>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</section>
<script>
(function(){
  var tocLinks = document.querySelectorAll('.pp-legal-toc a');
  if (!tocLinks.length || !('IntersectionObserver' in window)) return;
  var secs = document.querySelectorAll('.pp-legal-section');
  var tocObs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if (e.isIntersecting) {
        tocLinks.forEach(function(a){ a.classList.remove('pp-active'); });
        var active = document.querySelector('.pp-legal-toc a[href="#' + e.target.id + '"]');
        if (active) active.classList.add('pp-active');
      }
    });
  }, { rootMargin: '-15% 0px -75% 0px' });
  secs.forEach(function(s){ tocObs.observe(s); });
})();
</script>
        <?php
    }
}
