<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Widget 19 — FAQ Full Page
 * Full-page FAQ layout: sticky sidebar category navigation + grouped accordion Q&As.
 * Each repeater item has a type (heading or qa), a category label for headings,
 * and question/answer for Q&A items.
 */
class Widget_FAQ_Full extends \Elementor\Widget_Base {

    public function get_name()       { return 'ppuk_19_faq_full'; }
    public function get_title()      { return '19 — FAQ: Full Page'; }
    public function get_icon()       { return 'eicon-help-o'; }
    public function get_categories() { return [ 'pp-uk' ]; }
    public function get_keywords()   { return [ 'faq', 'full', 'page', 'categories', 'accordion', 'pp-uk' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_items', [
            'label' => 'FAQ Items',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'faq_items_notice', [
            'type'            => \Elementor\Controls_Manager::RAW_HTML,
            'raw'             => '<p style="font-size:12px;color:#787874">Add items in order. Set <strong>Type = Section Heading</strong> to start a new category group. All subsequent Q&amp;A items belong to that group until the next heading.</p>',
            'content_classes' => 'elementor-descriptor',
        ] );

        $rep = new \Elementor\Repeater();

        $rep->add_control( 'item_type', [
            'label'   => 'Type',
            'type'    => \Elementor\Controls_Manager::SELECT,
            'default' => 'qa',
            'options' => [
                'heading' => 'Section Heading',
                'qa'      => 'Question & Answer',
            ],
        ] );

        $rep->add_control( 'category', [
            'label'     => 'Category Name',
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => 'Products',
            'condition' => [ 'item_type' => 'heading' ],
        ] );

        $rep->add_control( 'question', [
            'label'     => 'Question',
            'type'      => \Elementor\Controls_Manager::TEXT,
            'default'   => 'Your question here?',
            'condition' => [ 'item_type' => 'qa' ],
        ] );

        $rep->add_control( 'answer', [
            'label'     => 'Answer',
            'type'      => \Elementor\Controls_Manager::TEXTAREA,
            'default'   => 'Your answer here.',
            'rows'      => 5,
            'condition' => [ 'item_type' => 'qa' ],
        ] );

        $this->add_control( 'faq_items', [
            'label'       => 'FAQ Items',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'item_type' => 'heading', 'category' => 'Products' ],
                [ 'item_type' => 'qa', 'question' => 'What is the purity of your peptides?', 'answer' => 'All compounds are independently HPLC-tested to confirm purity. Our minimum acceptable threshold is 98%; most batches exceed 99%. Full COA data is published on each product page.' ],
                [ 'item_type' => 'qa', 'question' => 'Are these peptides legal in the UK?', 'answer' => 'Yes. Research peptides are not controlled substances in the UK. They are legal to purchase and possess for legitimate research purposes. They are not licensed medicines and must not be used for human or veterinary consumption.' ],
                [ 'item_type' => 'qa', 'question' => 'How are compounds stored?', 'answer' => 'Lyophilised (freeze-dried) peptides are stored in temperature-controlled conditions from manufacture through to dispatch. All orders include cold-pack inserts to maintain integrity during transit.' ],
                [ 'item_type' => 'heading', 'category' => 'Ordering' ],
                [ 'item_type' => 'qa', 'question' => 'How do I place an order?', 'answer' => 'Add products to your cart, proceed to checkout, and complete payment. You will receive an order confirmation email immediately. Orders are typically dispatched within 1–2 business days.' ],
                [ 'item_type' => 'qa', 'question' => 'Do I need to create an account?', 'answer' => 'No. You can check out as a guest. However, creating an account allows you to track orders, access your order history, and retrieve your COA documents at any time.' ],
                [ 'item_type' => 'heading', 'category' => 'Shipping' ],
                [ 'item_type' => 'qa', 'question' => 'How quickly will my order ship?', 'answer' => 'Orders placed before 1pm on weekdays are typically dispatched the same or next business day from our UK facility. Standard tracked delivery takes 2–3 working days. Express next-day delivery is available at checkout.' ],
                [ 'item_type' => 'qa', 'question' => 'Do you ship internationally?', 'answer' => 'Currently we ship to UK mainland addresses only. We are working on expanding to select EU countries. Sign up to our newsletter to be notified when international shipping launches.' ],
                [ 'item_type' => 'heading', 'category' => 'Payments' ],
                [ 'item_type' => 'qa', 'question' => 'What payment methods do you accept?', 'answer' => 'We accept all major credit and debit cards via our secure payment processor. Cryptocurrency payments (Bitcoin, Ethereum) are also accepted and receive a 5% discount. All transactions are SSL-encrypted.' ],
                [ 'item_type' => 'heading', 'category' => 'Lab Reports' ],
                [ 'item_type' => 'qa', 'question' => 'Where can I find the COA for my product?', 'answer' => 'Every product page includes a downloadable Certificate of Analysis (COA) for the current batch. If you need a COA for a specific lot number from a previous order, contact us with your order reference.' ],
                [ 'item_type' => 'heading', 'category' => 'Legal & Compliance' ],
                [ 'item_type' => 'qa', 'question' => 'Who can purchase from you?', 'answer' => 'Sales are restricted to individuals aged 18 and over who confirm these products are for legitimate research purposes only. By placing an order you confirm this. We reserve the right to refuse orders where we have reason to doubt research intent.' ],
            ],
            'title_field' => '{{ item_type === "heading" ? "📂 " + category : "❓ " + question }}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s         = $this->get_settings_for_display();
        $items     = $s['faq_items'];
        $widget_id = $this->get_id();

        /* Build categories list for sidebar */
        $categories = [];
        foreach ( $items as $item ) {
            if ( 'heading' === $item['item_type'] && ! empty( $item['category'] ) ) {
                $slug = sanitize_title( $item['category'] );
                $categories[] = [ 'slug' => $slug, 'label' => $item['category'] ];
            }
        }
        ?>
<style>
  .pp-faq-full{background:var(--pp-bg)}
  .pp-faq-full-layout{display:grid;grid-template-columns:220px 1fr;gap:var(--pp-sp-64);align-items:start}
  /* Sidebar */
  .pp-faq-cat-nav{position:sticky;top:88px;background:var(--pp-surface);border:1px solid var(--pp-border);border-radius:var(--pp-r-lg);overflow:hidden}
  .pp-faq-cat-nav ul{padding:var(--pp-sp-8) 0}
  .pp-faq-cat-nav a{display:block;padding:var(--pp-sp-12) var(--pp-sp-16);font-size:13px;color:var(--pp-ink-2);transition:background 150ms var(--pp-ease),color 150ms var(--pp-ease)}
  .pp-faq-cat-nav a:hover{background:var(--pp-surface-2);color:var(--pp-ink)}
  .pp-faq-cat-nav a.pp-active{background:var(--pp-surface-2);color:var(--pp-ink);font-weight:500;border-left:3px solid var(--pp-ink)}
  /* Body */
  .pp-faq-group{margin-bottom:var(--pp-sp-64)}
  .pp-faq-group:last-child{margin-bottom:0}
  .pp-faq-group-title{font-family:var(--pp-f-mono);font-size:11px;font-weight:500;letter-spacing:.12em;text-transform:uppercase;color:var(--pp-ink-3);padding-bottom:var(--pp-sp-16);border-bottom:1px solid var(--pp-border);margin-bottom:var(--pp-sp-8)}
  .pp-faq-full-item{border-bottom:1px solid var(--pp-border)}
  .pp-faq-full-q{list-style:none;cursor:pointer;padding:var(--pp-sp-20) 0;display:flex;justify-content:space-between;align-items:center;gap:var(--pp-sp-24);font-size:15px;font-weight:500;color:var(--pp-ink);line-height:1.4;user-select:none}
  .pp-faq-full-q::-webkit-details-marker{display:none}
  .pp-faq-full-q .pp-ico{width:20px;height:20px;position:relative;flex-shrink:0;color:var(--pp-ink-3)}
  .pp-faq-full-q .pp-ico::before{content:'';position:absolute;background:currentColor;top:9px;left:0;right:0;height:2px;transition:opacity 200ms var(--pp-ease)}
  .pp-faq-full-q .pp-ico::after{content:'';position:absolute;background:currentColor;left:9px;top:0;bottom:0;width:2px;transition:transform 200ms var(--pp-ease)}
  .pp-faq-full-item[open] .pp-faq-full-q .pp-ico::after{transform:rotate(90deg)}
  .pp-faq-full-answer{padding-bottom:var(--pp-sp-20);font-size:14px;color:var(--pp-ink-2);line-height:1.7;max-width:680px}
  @media(max-width:900px){
    .pp-faq-full-layout{grid-template-columns:1fr}
    .pp-faq-cat-nav{position:static;display:flex;overflow-x:auto;background:none;border:none;border-radius:0;border-bottom:1px solid var(--pp-border);padding-bottom:var(--pp-sp-16)}
    .pp-faq-cat-nav ul{display:flex;gap:var(--pp-sp-8);padding:0;white-space:nowrap}
    .pp-faq-cat-nav a{padding:8px 14px;border-radius:var(--pp-r);border:1px solid var(--pp-border);font-size:13px;background:var(--pp-surface)}
    .pp-faq-cat-nav a.pp-active{background:var(--pp-ink);color:var(--pp-bg);border-color:var(--pp-ink);border-left-width:1px}
  }
</style>
<section class="pp-section pp-faq-full pp-pad" id="faq-top">
  <div class="pp-container">
    <div class="pp-faq-full-layout">

      <!-- SIDEBAR NAV -->
      <nav class="pp-faq-cat-nav pp-reveal" aria-label="FAQ Categories">
        <ul>
          <?php foreach ( $categories as $cat ) : ?>
          <li><a href="#faq-cat-<?php echo esc_attr( $cat['slug'] ); ?>" data-cat="<?php echo esc_attr( $cat['slug'] ); ?>"><?php echo esc_html( $cat['label'] ); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <!-- FAQ GROUPS -->
      <div class="pp-faq-full-body pp-reveal" style="transition-delay:80ms">
        <?php
        $current_slug = '';
        $group_open   = false;
        foreach ( $items as $item ) :
            if ( 'heading' === $item['item_type'] ) :
                if ( $group_open ) echo '</div>'; // close previous group
                $current_slug = sanitize_title( $item['category'] );
                $group_open   = true;
                ?>
        <div class="pp-faq-group" id="faq-cat-<?php echo esc_attr( $current_slug ); ?>">
          <div class="pp-faq-group-title"><?php echo esc_html( $item['category'] ); ?></div>
                <?php
            elseif ( 'qa' === $item['item_type'] ) :
                ?>
          <details class="pp-faq-full-item">
            <summary class="pp-faq-full-q">
              <span><?php echo esc_html( $item['question'] ); ?></span>
              <span class="pp-ico" aria-hidden="true"></span>
            </summary>
            <p class="pp-faq-full-answer"><?php echo esc_html( $item['answer'] ); ?></p>
          </details>
                <?php
            endif;
        endforeach;
        if ( $group_open ) echo '</div>'; // close last group
        ?>
      </div>
    </div>
  </div>
</section>
<script>
(function(){
  /* Scroll-spy: highlight sidebar link for visible section */
  var navLinks = document.querySelectorAll('.pp-faq-cat-nav a');
  if (!navLinks.length || !('IntersectionObserver' in window)) return;
  var groups = document.querySelectorAll('.pp-faq-group');
  var spyObs = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if (e.isIntersecting) {
        var id = e.target.id;
        navLinks.forEach(function(a){ a.classList.remove('pp-active'); });
        var active = document.querySelector('.pp-faq-cat-nav a[href="#' + id + '"]');
        if (active) active.classList.add('pp-active');
      }
    });
  }, { rootMargin: '-20% 0px -65% 0px' });
  groups.forEach(function(g){ spyObs.observe(g); });
})();
</script>
        <?php
    }
}
