<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_News_Carousel extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_06_news_carousel'; }
    public function get_title()      { return '06 — News Carousel'; }
    public function get_icon()       { return 'eicon-post-list'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'news', 'press', 'articles', 'carousel', 'peptides' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_head', [
            'label' => 'Section head',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Industry signal',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Latest research peptide news',
        ] );
        $this->add_control( 'pill', [
            'label'   => 'Side pill',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Articles & videos',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_cards', [
            'label' => 'News cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'date', [
            'label'   => 'Date pill',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '2 May 2026',
        ] );
        $rep->add_control( 'type', [
            'label'   => 'Type label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Research news',
        ] );
        $rep->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => 'Enzyme discovery could improve peptide-drug stability',
        ] );
        $rep->add_control( 'copy', [
            'label'   => 'Copy',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => 'A new enzyme, PapB, is reported to macrocyclize peptide drugs, a change that may improve stability and durability in future peptide therapeutics.',
        ] );
        $rep->add_control( 'link_text', [
            'label'   => 'Link text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Open link →',
        ] );
        $rep->add_control( 'link_url', [
            'label'   => 'Link URL',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#', 'is_external' => 'on' ],
        ] );

        $this->add_control( 'cards', [
            'label'       => 'Cards',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [ 'date' => '2 May 2026',  'type' => 'Research news',     'title' => 'Enzyme discovery could improve peptide-drug stability', 'copy' => 'A new enzyme, PapB, is reported to macrocyclize peptide drugs, a change that may improve stability and durability in future peptide therapeutics.', 'link_text' => 'Open link →', 'link_url' => [ 'url' => 'https://nypost.com/2026/05/02/us-news/scientists-discover-enzyme-that-could-supercharge-ozempic-like-weight-loss-drugs/', 'is_external' => 'on' ] ],
                [ 'date' => '1 May 2026',  'type' => 'Industry watch',    'title' => 'Peptides and consumer access under fresh scrutiny',     'copy' => 'Recent coverage looks at the growing peptide market, regulatory attention and consumer safety questions around unproven wellness use.',          'link_text' => 'Open link →', 'link_url' => [ 'url' => 'https://www.sciencenews.org/article/peptides-unproven-health-fda-access',                                          'is_external' => 'on' ] ],
                [ 'date' => '23 Apr 2026', 'type' => 'Research feature',  'title' => 'The peptide design challenge',                          'copy' => 'Science reports on international peptide-drug design efforts using AI-guided research and testing across hundreds of researchers.',                'link_text' => 'Open link →', 'link_url' => [ 'url' => 'https://www.science.org/content/article/peptide-design-challenge',                                                'is_external' => 'on' ] ],
                [ 'date' => '2025',        'type' => 'YouTube video',     'title' => 'Biggest peptide developments of 2025',                  'copy' => 'Video slot for a research-focused peptide industry update, styled to sit alongside article cards in the site carousel.',                            'link_text' => 'Open link →', 'link_url' => [ 'url' => 'https://www.youtube.com/watch?v=ch8UieRPeGE',                                                                       'is_external' => 'on' ] ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
<style>
  .pp-news { padding: 0 20px 70px; }
  .pp-news .pp-section-head h2 { color: var(--pp-paper); }
  .pp-news-carousel {
    display: grid;
    grid-template-columns: repeat(4, minmax(260px, 1fr));
    gap: 20px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    padding-bottom: 12px;
  }
  .pp-news-card {
    min-width: 260px;
    scroll-snap-align: start;
    background: var(--pp-paper);
    color: #000;
    border: var(--pp-border);
    border-radius: 30px;
    padding: 20px;
    box-shadow: var(--pp-shadow-lg);
    display: flex;
    flex-direction: column;
    min-height: 285px;
  }
  .pp-news-card .pp-news-date {
    align-self: flex-start;
    background: var(--pp-gold);
    color: #000;
    border: 3px solid #000;
    border-radius: 999px;
    padding: 6px 12px;
    font: 900 12px var(--pp-f-body);
    text-transform: uppercase;
    box-shadow: 3px 3px 0 #000;
  }
  .pp-news-card .pp-news-type {
    margin-top: 14px;
    font: 900 11px var(--pp-f-body);
    text-transform: uppercase;
    letter-spacing: .08em;
    opacity: .72;
  }
  .pp-news-card h3 {
    font-family: var(--pp-f-head);
    margin: 10px 0 8px;
    font-size: 26px;
    line-height: .92;
    text-transform: uppercase;
    color: #000;
    text-shadow: none;
  }
  .pp-news-card p {
    margin: 0 0 18px;
    font: 800 14px var(--pp-f-body);
    line-height: 1.3;
    opacity: .86;
  }
  .pp-news-card a {
    margin-top: auto;
    display: inline-flex;
    width: max-content;
    background: var(--pp-glow);
    color: #000;
    border: var(--pp-border);
    border-radius: 13px;
    padding: 9px 13px;
    font: 900 13px var(--pp-f-body);
    text-transform: uppercase;
    box-shadow: 4px 4px 0 #000;
  }
  @media (max-width: 980px) {
    .pp-news-carousel { grid-template-columns: repeat(4, minmax(280px, 1fr)); }
  }
</style>
<section class="pp-section pp-bg-vault pp-news">
  <div class="pp-wrap">
    <div class="pp-section-head">
      <div>
        <?php if ( $s['eyebrow'] ) : ?><p class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></p><?php endif; ?>
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
      </div>
      <?php if ( $s['pill'] ) : ?>
        <div class="pp-stock"><?php echo esc_html( $s['pill'] ); ?></div>
      <?php endif; ?>
    </div>
    <div class="pp-news-carousel" aria-label="Latest research peptide industry news carousel">
      <?php if ( ! empty( $s['cards'] ) ) : foreach ( $s['cards'] as $card ) :
        $url = ! empty( $card['link_url']['url'] ) ? esc_url( $card['link_url']['url'] ) : '#';
        $tgt = ! empty( $card['link_url']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
      ?>
      <article class="pp-news-card">
        <div class="pp-news-date"><?php echo esc_html( $card['date'] ); ?></div>
        <div class="pp-news-type"><?php echo esc_html( $card['type'] ); ?></div>
        <h3><?php echo esc_html( $card['title'] ); ?></h3>
        <p><?php echo esc_html( $card['copy'] ); ?></p>
        <a href="<?php echo $url; ?>"<?php echo $tgt; ?>><?php echo esc_html( $card['link_text'] ); ?></a>
      </article>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>
        <?php
    }
}
