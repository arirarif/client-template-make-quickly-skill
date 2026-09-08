<?php
/**
 * Collections / categories grid widget — image cards with overlay.
 *
 * @package Noor_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Noor_Widget_Categories extends \Elementor\Widget_Base {

	public function get_name() {
		return 'noor_categories';
	}

	public function get_title() {
		return __( 'Noor — Grille Collections', 'noor' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return array( 'noor-festivities' );
	}

	public function get_keywords() {
		return array( 'noor', 'categories', 'collections', 'grid' );
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
				'default' => __( '- Explorer -', 'noor' ),
			)
		);
		$this->add_control(
			'title',
			array(
				'label'   => __( 'Titre', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Nos Collections', 'noor' ),
			)
		);
		$this->add_control(
			'subtitle',
			array(
				'label'   => __( 'Sous-titre', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Des lanternes Eid aux cérémonies de mariage — tout pour illuminer vos célébrations.', 'noor' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_items',
			array(
				'label' => __( 'Collections', 'noor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'image',
			array(
				'label'   => __( 'Image', 'noor' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array( 'url' => \Elementor\Utils::get_placeholder_image_src() ),
			)
		);
		$repeater->add_control(
			'label',
			array(
				'label'   => __( 'Nom', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Déco Eid', 'noor' ),
			)
		);
		$repeater->add_control(
			'desc',
			array(
				'label'   => __( 'Description courte', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Lanternes, guirlandes', 'noor' ),
			)
		);
		$repeater->add_control(
			'link',
			array(
				'label'   => __( 'Lien', 'noor' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'default' => array( 'url' => '#' ),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => __( 'Collections', 'noor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => array(
					array( 'label' => __( 'Déco Eid', 'noor' ), 'desc' => __( 'Lanternes, guirlandes', 'noor' ), 'image' => array( 'url' => get_stylesheet_directory_uri() . '/assets/img/cat-eid.jpg' ), 'link' => array( 'url' => noor_category_url( 'eid-decor' ) ) ),
					array( 'label' => __( 'Arches de Ballons', 'noor' ), 'desc' => __( 'Sur mesure', 'noor' ), 'image' => array( 'url' => get_stylesheet_directory_uri() . '/assets/img/cat-ballons.jpg' ), 'link' => array( 'url' => noor_category_url( 'arches-de-ballons' ) ) ),
					array( 'label' => __( 'Mariage Nikkah', 'noor' ), 'desc' => __( 'Kits cérémonie', 'noor' ), 'image' => array( 'url' => get_stylesheet_directory_uri() . '/assets/img/cat-nikkah.jpg' ), 'link' => array( 'url' => noor_category_url( 'nikkah' ) ) ),
					array( 'label' => __( 'Naissance Aqiqah', 'noor' ), 'desc' => __( 'Célébrations naissance', 'noor' ), 'image' => array( 'url' => get_stylesheet_directory_uri() . '/assets/img/cat-aqiqah.jpg' ), 'link' => array( 'url' => noor_category_url( 'aqiqah' ) ) ),
					array( 'label' => __( 'Hajj & Umrah', 'noor' ), 'desc' => __( 'Bougies, souvenirs', 'noor' ), 'image' => array( 'url' => get_stylesheet_directory_uri() . '/assets/img/cat-hajj.jpg' ), 'link' => array( 'url' => noor_category_url( 'hajj-umrah' ) ) ),
					array( 'label' => __( 'Éclairage Festif', 'noor' ), 'desc' => __( 'Guirlandes, lanternes', 'noor' ), 'image' => array( 'url' => get_stylesheet_directory_uri() . '/assets/img/cat-lumieres.jpg' ), 'link' => array( 'url' => noor_category_url( 'luminaires' ) ) ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => __( 'Style', 'noor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'card_height',
			array(
				'label'      => __( 'Hauteur des cartes', 'noor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 120, 'max' => 420 ) ),
				'default'    => array( 'unit' => 'px', 'size' => 220 ),
				'selectors'  => array( '{{WRAPPER}} .nfw-cat' => 'height: {{SIZE}}{{UNIT}};' ),
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
				<?php if ( ! empty( $settings['subtitle'] ) ) : ?><p class="nfw-sechead__sub"><?php echo esc_html( $settings['subtitle'] ); ?></p><?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="nfw-cats">
			<?php foreach ( $settings['items'] as $item ) :
				$url = ! empty( $item['link']['url'] ) ? $item['link']['url'] : '#';
				/* A card pointing at the rental category disappears outside
				 * Réunion — client-side, see inc/region.php. */
				$card_class = ( function_exists( 'noor_is_rental_url' ) && noor_is_rental_url( $url ) ) ? ' noor-rental-ui' : '';
				?>
				<a class="nfw-cat<?php echo esc_attr( $card_class ); ?>" href="<?php echo esc_url( $url ); ?>">
					<?php if ( ! empty( $item['image']['url'] ) ) : ?>
						<img class="nfw-cat__img" src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( $item['label'] ); ?>" loading="lazy" />
					<?php endif; ?>
					<span class="nfw-cat__overlay"></span>
					<span class="nfw-cat__body">
						<span class="nfw-cat__label"><?php echo esc_html( $item['label'] ); ?></span>
						<span class="nfw-cat__desc"><?php echo esc_html( $item['desc'] ); ?></span>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
