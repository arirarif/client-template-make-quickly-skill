<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-07 — FAQ
 * Centered eyebrow + title, accordion list. First item open by default.
 */
class Widget_FLW_FAQ extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_07_faq'; }
    public function get_title()      { return 'FLW 07 — FAQ'; }
    public function get_icon()       { return 'eicon-help-o'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'faq', 'accordion', 'flw' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'sec_head', [ 'label' => 'Heading', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'eyebrow', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'FAQ' ] );
        $this->add_control( 'title',   [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Frequently Asked Questions' ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_items', [ 'label' => 'FAQ Items', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'q', [ 'label' => 'Question', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Question?' ] );
        $rep->add_control( 'a', [ 'label' => 'Answer', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Answer.' ] );
        $rep->add_control( 'open', [ 'label' => 'Open by default', 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ] );

        $this->add_control( 'items', [
            'label' => 'Items', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(),
            'default' => [
                [ 'q' => "What's the difference between an LLC and a corporation?", 'a' => 'An LLC is simpler and more flexible, with fewer formal requirements and pass-through taxation by default. A corporation is more structured, requires a board of directors, and is better suited for raising capital and scaling.', 'open' => 'yes' ],
                [ 'q' => "What's the difference between a C corporation and an S corporation?", 'a' => 'A C corporation is taxed separately from its owners (which can lead to double taxation). An S corporation avoids this by passing profits directly to owners for single-level taxation, but it has ownership limits and eligibility rules.', 'open' => '' ],
                [ 'q' => "What's the main difference between a sole proprietorship and an LLC?", 'a' => 'A sole proprietorship is the simplest structure but offers no separation between you and the business. An LLC creates a legal separation, protecting your personal assets from business liabilities.', 'open' => '' ],
                [ 'q' => 'How are different business types taxed?', 'a' => 'Sole proprietorships, partnerships, LLCs (by default), and S corporations typically use pass-through taxation, where profits are taxed once at the owner level. C corporations are taxed at the corporate level, and shareholders may also pay taxes on dividends.', 'open' => '' ],
                [ 'q' => 'Which business types give me personal liability protection?', 'a' => 'LLCs, corporations (C and S), LLPs, and professional corporations generally provide personal liability protection. Sole proprietorships and general partnerships do not.', 'open' => '' ],
            ],
            'title_field' => '{{{ q }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s  = $this->get_settings_for_display();
        $id = 'bjlz-flw07-' . $this->get_id();
        ?>
        <style>
        #<?php echo esc_attr($id); ?>{font-family:'Inter','Plus Jakarta Sans',sans-serif;color:#475569}
        #<?php echo esc_attr($id); ?> .section{padding:80px 0}
        #<?php echo esc_attr($id); ?> .container{max-width:1160px;margin:0 auto;padding:0 24px}
        #<?php echo esc_attr($id); ?> .section-eyebrow{display:inline-block;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#F97316;margin-bottom:12px}
        #<?php echo esc_attr($id); ?> .section-title{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:clamp(26px,3.2vw,38px);font-weight:800;line-height:1.18;letter-spacing:-.02em;color:#0F172A;margin-bottom:18px}
        #<?php echo esc_attr($id); ?> .faq-list{display:flex;flex-direction:column;gap:10px;max-width:760px;margin:0 auto}
        #<?php echo esc_attr($id); ?> .faq-item{background:#fff;border:1px solid #E2E8F0;border-radius:12px;overflow:hidden;box-shadow:0 1px 3px rgba(15,23,42,.06)}
        #<?php echo esc_attr($id); ?> .faq-q{display:flex;align-items:center;justify-content:space-between;padding:20px 24px;cursor:pointer;font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:15px;font-weight:700;color:#0F172A;transition:background .15s;gap:12px;user-select:none}
        #<?php echo esc_attr($id); ?> .faq-q:hover{background:#F8FAFC}
        #<?php echo esc_attr($id); ?> .faq-icon{width:24px;height:24px;background:#F1F5F9;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#64748B;flex-shrink:0;transition:all .25s}
        #<?php echo esc_attr($id); ?> .faq-item.open .faq-icon{background:#F97316;color:#fff;transform:rotate(45deg)}
        #<?php echo esc_attr($id); ?> .faq-item.open{border-color:#FED7AA;box-shadow:0 4px 18px rgba(249,115,22,.10)}
        #<?php echo esc_attr($id); ?> .faq-a{padding:0 24px;max-height:0;overflow:hidden;transition:max-height .35s ease,padding .35s ease;font-size:15px;color:#475569;line-height:1.72}
        #<?php echo esc_attr($id); ?> .faq-item.open .faq-a{max-height:280px;padding:0 24px 22px}
        </style>

        <div id="<?php echo esc_attr($id); ?>">
          <section class="section">
            <div class="container">
              <div style="text-align:center;margin-bottom:40px">
                <span class="section-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
                <h2 class="section-title"><?php echo esc_html( $s['title'] ); ?></h2>
              </div>
              <div class="faq-list">
                <?php foreach ( (array) ( $s['items'] ?? [] ) as $it ) :
                    $open = ( ($it['open'] ?? '') === 'yes' ) ? ' open' : '';
                ?>
                  <div class="faq-item<?php echo esc_attr( $open ); ?>">
                    <div class="faq-q">
                      <?php echo esc_html( $it['q'] ); ?>
                      <div class="faq-icon"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
                    </div>
                    <div class="faq-a"><?php echo esc_html( $it['a'] ); ?></div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </section>
        </div>

        <script>
        (function(){
          var root = document.getElementById('<?php echo esc_js($id); ?>');
          if(!root) return;
          root.querySelectorAll('.faq-q').forEach(function(q){
            q.addEventListener('click', function(){
              var item = q.closest('.faq-item');
              var isOpen = item.classList.contains('open');
              root.querySelectorAll('.faq-item').forEach(function(i){ i.classList.remove('open'); });
              if(!isOpen) item.classList.add('open');
            });
          });
        })();
        </script>
        <?php
    }
}
