<?php
/**
 * Testimonials grid widget — review cards with stars, avatar, location.
 *
 * @package Noor_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Noor_Widget_Testimonials extends \Elementor\Widget_Base {

	public function get_name() {
		return 'noor_testimonials';
	}

	public function get_title() {
		return __( 'Noor — Témoignages', 'noor' );
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return array( 'noor-festivities' );
	}

	public function get_keywords() {
		return array( 'noor', 'testimonials', 'reviews', 'avis' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_heading',
			array(
				'label' => __( 'En-tête de section', 'noor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'kicker',
			array(
				'label'   => __( 'Kicker', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( '- Avis Clients -', 'noor' ),
			)
		);
		$this->add_control(
			'title',
			array(
				'label'   => __( 'Titre', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Ils ont célébré avec nous', 'noor' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_items',
			array(
				'label' => __( 'Témoignages', 'noor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'text',
			array(
				'label'   => __( 'Témoignage', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'La décoration Eid était absolument magnifique. Livraison rapide et emballage soigné !', 'noor' ),
			)
		);
		$repeater->add_control(
			'name',
			array(
				'label'   => __( 'Nom', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Aicha M.', 'noor' ),
			)
		);
		$repeater->add_control(
			'loc',
			array(
				'label'   => __( 'Localisation', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Saint-Denis, Réunion', 'noor' ),
			)
		);
		$repeater->add_control(
			'rating',
			array(
				'label'   => __( 'Note (1-5)', 'noor' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 1,
				'max'     => 5,
			)
		);
		$repeater->add_control(
			'avatar',
			array(
				'label'   => __( 'Photo', 'noor' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => __( 'Témoignages', 'noor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'default'     => array(
					array(
						'name'   => __( 'Aicha M.', 'noor' ),
						'loc'    => __( 'Saint-Denis, Réunion', 'noor' ),
						'text'   => __( 'La décoration Eid était absolument magnifique. Livraison rapide et emballage soigné !', 'noor' ),
						'avatar' => array( 'url' => get_stylesheet_directory_uri() . '/assets/img/avatar-1.jpg' ),
					),
					array(
						'name'   => __( 'Fatima B.', 'noor' ),
						'loc'    => __( 'Saint-Pierre, Réunion', 'noor' ),
						'text'   => __( 'L’arche de ballons pour notre Nikkah était exactement comme sur la photo — sublime.', 'noor' ),
						'avatar' => array( 'url' => get_stylesheet_directory_uri() . '/assets/img/avatar-2.jpg' ),
					),
					array(
						'name'   => __( 'Youssef R.', 'noor' ),
						'loc'    => __( 'Paris 18ème, France', 'noor' ),
						'text'   => __( 'Commandé depuis Paris, reçu en 4 jours. Qualité premium, emballage luxueux.', 'noor' ),
						'avatar' => array( 'url' => get_stylesheet_directory_uri() . '/assets/img/avatar-3.jpg' ),
					),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<?php if ( ! empty( $settings['title'] ) || ! empty( $settings['kicker'] ) ) : ?>
			<div class="nfw-sechead">
				<?php if ( ! empty( $settings['kicker'] ) ) : ?><div class="nfw-sechead__kicker"><?php echo esc_html( $settings['kicker'] ); ?></div><?php endif; ?>
				<?php if ( ! empty( $settings['title'] ) ) : ?><h2 class="nfw-sechead__title"><?php echo esc_html( $settings['title'] ); ?></h2><?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="nfw-tests">
			<?php foreach ( $settings['items'] as $item ) :
				$rating = max( 1, min( 5, absint( $item['rating'] ) ) );
				?>
				<div class="nfw-test">
					<div class="nfw-test__stars" aria-label="<?php echo esc_attr( $rating ); ?>/5"><?php echo esc_html( str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ) ); ?></div>
					<p class="nfw-test__text">&laquo;&nbsp;<?php echo esc_html( $item['text'] ); ?>&nbsp;&raquo;</p>
					<div class="nfw-test__who">
						<?php if ( ! empty( $item['avatar']['url'] ) ) : ?>
							<img class="nfw-test__avatar" src="<?php echo esc_url( $item['avatar']['url'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" loading="lazy" />
						<?php endif; ?>
						<div>
							<div class="nfw-test__name"><?php echo esc_html( $item['name'] ); ?></div>
							<div class="nfw-test__loc">📍 <?php echo esc_html( $item['loc'] ); ?></div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
