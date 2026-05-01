<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * FLW-06 — Secondary Entities ("We form almost any type of business")
 * Slate-50 BG, eyebrow + title + intro, 4 tabs (DBA / Professional Corp / B-Corp / LLP)
 * with bullet-list panels and a "Contact us for custom quote" line below.
 */
class Widget_FLW_Secondary_Entities extends \Elementor\Widget_Base {

    public function get_name()       { return 'bjlz_flw_06_secondary_entities'; }
    public function get_title()      { return 'FLW 06 — Secondary Entities'; }
    public function get_icon()       { return 'eicon-tabs'; }
    public function get_categories() { return [ 'bj-lz-widgets' ]; }
    public function get_keywords()   { return [ 'entity', 'tabs', 'dba', 'b-corp', 'llp', 'flw' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_head', [ 'label' => 'Heading', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'eyebrow', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'More Options' ] );
        $this->add_control( 'title',   [ 'label' => 'Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'We form almost any type of business' ] );
        $this->add_control( 'intro',   [
            'label' => 'Intro', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'While not as common as the options above, these specialized business structures are necessary in certain situations—and yes, we can form them too.',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_tabs', [ 'label' => 'Tabs', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'tab_label', [ 'label' => 'Tab Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'DBA' ] );
        $rep->add_control( 'panel_lead', [
            'label' => 'Panel Lead Sentence (HTML — wrap entity name in <strong>)', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => '<strong>Doing Business As (DBA)</strong> — a simple way to operate your business under a different name without forming a separate legal entity.',
        ] );
        $rep->add_control( 'bullets', [
            'label' => 'Bullets (one per line)', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => "No separate legal entity\nQuick and low-cost registration\nProfessional brand name\nWorks with sole proprietorships, LLCs, or corporations",
        ] );

        $this->add_control( 'tabs_list', [
            'label' => 'Tabs', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $rep->get_controls(),
            'default' => [
                [ 'tab_label' => 'DBA',                       'panel_lead' => '<strong>Doing Business As (DBA)</strong> — a simple way to operate your business under a different name without forming a separate legal entity.', 'bullets' => "No separate legal entity (operates under your existing business or personal name)\nQuick and low-cost registration\nAllows you to brand your business with a professional name\nCan be used with sole proprietorships, LLCs, or corporations" ],
                [ 'tab_label' => 'Professional Corporations', 'panel_lead' => '<strong>Professional Corporation (PC)</strong> — a business structure for licensed professionals that require state licensing, offering liability protection while meeting regulatory requirements.', 'bullets' => "Personal liability protection for business debts\nDesigned for licensed professionals (e.g., doctors, lawyers, accountants)\nOwners must hold valid state licenses in their profession\nStructured with a board of directors and formal corporate requirements" ],
                [ 'tab_label' => 'B-Corporation',             'panel_lead' => '<strong>B Corporation (Benefit Corporation)</strong> — combines the advantages of a traditional corporation with a mission-driven focus similar to a nonprofit.', 'bullets' => "Full benefits of a regular corporation (liability protection, ability to raise capital)\nFocus on social and environmental impact\nLegal protection to consider stakeholders, not just shareholders\nRequires transparency and impact reporting" ],
                [ 'tab_label' => 'LLP',                       'panel_lead' => '<strong>Limited Liability Partnership (LLP)</strong> — a business structure where partners share management while protecting themselves from certain liabilities.', 'bullets' => "Personal liability protection for each partner\nFlexible management—partners can run the business directly\nPass-through taxation (profits taxed once)\nCommon for licensed professionals (e.g., lawyers, accountants)" ],
            ],
            'title_field' => '{{{ tab_label }}}',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_quote', [ 'label' => 'Custom Quote Line', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT ] );
        $this->add_control( 'quote_lead', [
            'label' => 'Lead Text', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Contact us directly for a custom quote to set up either a B-Corp, DBA, Professional Corporation, or LLP.',
        ] );
        $this->add_control( 'quote_link_text', [ 'label' => 'Link Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Get a custom quote →' ] );
        $this->add_control( 'quote_link_url',  [ 'label' => 'Link URL',  'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '/contact-us/' ] ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s  = $this->get_settings_for_display();
        $id = 'bjlz-flw06-' . $this->get_id();
        $tabs = (array) ( $s['tabs_list'] ?? [] );
        ?>
        <style>
        #<?php echo esc_attr($id); ?>{font-family:'Inter','Plus Jakarta Sans',sans-serif;color:#475569}
        #<?php echo esc_attr($id); ?> .section{padding:80px 0;background:#F8FAFC}
        #<?php echo esc_attr($id); ?> .container{max-width:1160px;margin:0 auto;padding:0 24px}
        #<?php echo esc_attr($id); ?> .section-eyebrow{display:inline-block;font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#F97316;margin-bottom:12px}
        #<?php echo esc_attr($id); ?> .section-title{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:clamp(26px,3.2vw,38px);font-weight:800;line-height:1.18;letter-spacing:-.02em;color:#0F172A;margin-bottom:18px}
        #<?php echo esc_attr($id); ?> .sec-intro{max-width:680px;margin:0 auto 36px;text-align:center;font-size:16px;color:#64748B;line-height:1.7}
        #<?php echo esc_attr($id); ?> .sec-tabs{display:flex;gap:6px;background:#fff;padding:6px;border-radius:14px;box-shadow:0 2px 6px rgba(15,23,42,.08);max-width:680px;margin:0 auto;border:1px solid rgba(15,23,42,.06)}
        #<?php echo esc_attr($id); ?> .sec-tab{flex:1;padding:13px 14px;border:none;background:transparent;font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:14px;font-weight:700;color:#64748B;border-radius:10px;cursor:pointer;transition:all .2s}
        #<?php echo esc_attr($id); ?> .sec-tab:hover{color:#1E293B;background:#F8FAFC}
        #<?php echo esc_attr($id); ?> .sec-tab.is-active{background:#F97316;color:#fff}
        #<?php echo esc_attr($id); ?> .sec-panel-wrap{margin-top:22px;background:#fff;border:1px solid rgba(15,23,42,.07);border-radius:18px;padding:32px 36px;box-shadow:0 2px 6px rgba(15,23,42,.08);max-width:840px;margin-left:auto;margin-right:auto}
        #<?php echo esc_attr($id); ?> .sec-panel{display:none}
        #<?php echo esc_attr($id); ?> .sec-panel.is-active{display:block;animation:bjlzFade .25s ease-out}
        @keyframes bjlzFade{from{opacity:0;transform:translateY(4px)}to{opacity:1;transform:none}}
        #<?php echo esc_attr($id); ?> .sec-headline{font-family:'Plus Jakarta Sans','Inter',sans-serif;font-size:clamp(18px,1.9vw,22px);font-weight:700;color:#0F172A;line-height:1.4;margin-bottom:18px}
        #<?php echo esc_attr($id); ?> .sec-headline strong{color:#F97316}
        #<?php echo esc_attr($id); ?> .sec-bullets{list-style:none;display:flex;flex-direction:column;gap:11px;margin:0;padding:0}
        #<?php echo esc_attr($id); ?> .sec-bullets li{display:flex;align-items:flex-start;gap:11px;font-size:15px;color:#334155;line-height:1.55}
        #<?php echo esc_attr($id); ?> .sec-bullets li::before{content:'';flex-shrink:0;width:20px;height:20px;border-radius:50%;background:#FFF7ED;background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23F97316' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'><polyline points='20 6 9 17 4 12'/></svg>");background-repeat:no-repeat;background-position:center;background-size:11px;margin-top:2px}
        #<?php echo esc_attr($id); ?> .sec-quote{margin-top:32px;text-align:center;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;padding:20px 24px;max-width:760px;margin-left:auto;margin-right:auto}
        #<?php echo esc_attr($id); ?> .sec-quote p{font-size:15px;color:#334155;margin:0}
        #<?php echo esc_attr($id); ?> .sec-quote a{color:#EA580C;font-weight:700;text-decoration:underline;text-underline-offset:3px}
        @media (max-width:920px){
          #<?php echo esc_attr($id); ?> .sec-tabs{flex-wrap:wrap}
          #<?php echo esc_attr($id); ?> .sec-tab{flex:1 1 calc(50% - 6px)}
        }
        @media (max-width:560px){ #<?php echo esc_attr($id); ?> .sec-panel-wrap{padding:24px 22px} }
        </style>

        <div id="<?php echo esc_attr($id); ?>">
          <section class="section">
            <div class="container">
              <div style="text-align:center;margin-bottom:14px">
                <span class="section-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
                <h2 class="section-title"><?php echo esc_html( $s['title'] ); ?></h2>
              </div>
              <p class="sec-intro"><?php echo esc_html( $s['intro'] ); ?></p>

              <div class="sec-tabs">
                <?php foreach ( $tabs as $i => $t ) : ?>
                  <button class="sec-tab<?php echo $i === 0 ? ' is-active' : ''; ?>" data-sec="<?php echo esc_attr( 'p' . $i ); ?>"><?php echo esc_html( $t['tab_label'] ); ?></button>
                <?php endforeach; ?>
              </div>

              <div class="sec-panel-wrap">
                <?php foreach ( $tabs as $i => $t ) :
                    $bul = array_filter( array_map( 'trim', preg_split( "/\r\n|\r|\n/", (string) ( $t['bullets'] ?? '' ) ) ) );
                ?>
                  <div class="sec-panel<?php echo $i === 0 ? ' is-active' : ''; ?>" data-secp="<?php echo esc_attr( 'p' . $i ); ?>">
                    <p class="sec-headline"><?php echo wp_kses_post( $t['panel_lead'] ); ?></p>
                    <ul class="sec-bullets">
                      <?php foreach ( $bul as $b ) : ?><li><?php echo esc_html( $b ); ?></li><?php endforeach; ?>
                    </ul>
                  </div>
                <?php endforeach; ?>
              </div>

              <div class="sec-quote">
                <p><?php echo esc_html( $s['quote_lead'] ); ?> <a href="<?php echo esc_url( $s['quote_link_url']['url'] ?? '#' ); ?>"><?php echo esc_html( $s['quote_link_text'] ); ?></a></p>
              </div>
            </div>
          </section>
        </div>

        <script>
        (function(){
          var root = document.getElementById('<?php echo esc_js($id); ?>');
          if(!root) return;
          root.querySelectorAll('.sec-tab').forEach(function(btn){
            btn.addEventListener('click', function(){
              var key = btn.dataset.sec;
              root.querySelectorAll('.sec-tab').forEach(function(b){ b.classList.toggle('is-active', b===btn); });
              root.querySelectorAll('.sec-panel').forEach(function(p){ p.classList.toggle('is-active', p.dataset.secp===key); });
            });
          });
        })();
        </script>
        <?php
    }
}
