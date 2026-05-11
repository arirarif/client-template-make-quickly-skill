<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Widget_Team_Grid extends \Elementor\Widget_Base {

    public function get_name()       { return 'pp_13_team_grid'; }
    public function get_title()      { return '13 — Team Grid'; }
    public function get_icon()       { return 'eicon-person'; }
    public function get_categories() { return [ 'pp_atomic_blue' ]; }
    public function get_keywords()   { return [ 'team', 'about', 'people', 'staff', 'peptides' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'sec_head', [
            'label' => 'Section head',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'eyebrow', [
            'label'   => 'Eyebrow',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'The Bench',
        ] );
        $this->add_control( 'heading', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'The Humans Behind The Vault.',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'sec_cards', [
            'label' => 'Team members',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $rep = new \Elementor\Repeater();
        $rep->add_control( 'photo', [
            'label'       => 'Photo (optional)',
            'type'        => \Elementor\Controls_Manager::MEDIA,
            'default'     => [ 'url' => '' ],
            'description' => 'Leave empty to use the emoji face.',
        ] );
        $rep->add_control( 'face', [
            'label'   => 'Emoji face fallback',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => '📦',
        ] );
        $rep->add_control( 'name', [
            'label'   => 'Name',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Fulfilment',
        ] );
        $rep->add_control( 'role', [
            'label'   => 'Role',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'UK Warehouse Team',
        ] );
        $rep->add_control( 'bio', [
            'label'   => 'Bio',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => 'Picks, packs and ships every order from our UK warehouse. Same-day dispatch on working days when you order before 3pm.',
        ] );

        $this->add_control( 'cards', [
            'label'       => 'Team members',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                [
                    'face' => '📦', 'name' => 'Fulfilment',
                    'role' => 'UK Warehouse Team',
                    'bio'  => 'Picks, packs and ships every order from our UK warehouse. Same-day dispatch on working days when you order before 3pm.',
                ],
                [
                    'face' => '💬', 'name' => 'Support',
                    'role' => 'Customer Care',
                    'bio'  => 'Real people answering real questions on reconstitution, storage and product info. We reply within one working day.',
                ],
                [
                    'face' => '🛒', 'name' => 'Operations',
                    'role' => 'Stock & Logistics',
                    'bio'  => 'Keeps the UK stock list accurate and the catalogue current. If it\'s on the site, it\'s in the warehouse — not on a boat.',
                ],
            ],
            'title_field' => '{{{ name }}}',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $cols = max( 1, count( $s['cards'] ) );
        ?>
<style>
  .pp-team { padding: 70px 20px; }
  .pp-team .pp-section-head h2 { color: var(--pp-paper); }
  .pp-team-grid {
    display: grid;
    gap: 22px;
  }
  .pp-team-card {
    background: var(--pp-paper);
    color: #000;
    border: var(--pp-border);
    border-radius: 30px;
    padding: 22px;
    box-shadow: var(--pp-shadow-lg);
    text-align: center;
  }
  .pp-team-card .face {
    width: 110px;
    height: 110px;
    margin: 0 auto 14px;
    border: var(--pp-border);
    border-radius: 999px;
    background: linear-gradient(135deg, var(--pp-glow), var(--pp-gold));
    display: grid;
    place-items: center;
    font-size: 50px;
    box-shadow: var(--pp-shadow-md);
    overflow: hidden;
  }
  .pp-team-card .face img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    border-radius: 999px;
  }
  .pp-team-card h3 {
    font: 900 22px var(--pp-f-body);
    text-transform: uppercase;
    margin: 0 0 4px;
  }
  .pp-team-card .role {
    font: 900 12px var(--pp-f-body);
    text-transform: uppercase;
    opacity: .7;
    margin: 0 0 10px;
    letter-spacing: .06em;
  }
  .pp-team-card p {
    font: 800 14px var(--pp-f-body);
    margin: 0;
    line-height: 1.4;
  }
  @media (max-width: 980px) {
    .pp-team-grid { grid-template-columns: repeat(2, 1fr) !important; }
  }
  @media (max-width: 620px) {
    .pp-team-grid { grid-template-columns: 1fr !important; }
  }
</style>
<section class="pp-section pp-bg-vault pp-team">
  <div class="pp-wrap">
    <div class="pp-section-head">
      <div>
        <?php if ( $s['eyebrow'] ) : ?>
          <p class="pp-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></p>
        <?php endif; ?>
        <h2><?php echo esc_html( $s['heading'] ); ?></h2>
      </div>
    </div>
    <?php if ( ! empty( $s['cards'] ) ) : ?>
      <div class="pp-team-grid" style="grid-template-columns: repeat(<?php echo (int) $cols; ?>, 1fr);">
        <?php foreach ( $s['cards'] as $c ) :
          $photo = ! empty( $c['photo']['url'] ) ? esc_url( $c['photo']['url'] ) : '';
        ?>
          <article class="pp-team-card">
            <div class="face">
              <?php if ( $photo ) : ?>
                <img src="<?php echo $photo; ?>" alt="<?php echo esc_attr( $c['name'] ); ?>">
              <?php else : ?>
                <span><?php echo esc_html( $c['face'] ); ?></span>
              <?php endif; ?>
            </div>
            <h3><?php echo esc_html( $c['name'] ); ?></h3>
            <p class="role"><?php echo esc_html( $c['role'] ); ?></p>
            <p><?php echo esc_html( $c['bio'] ); ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
        <?php
    }
}
