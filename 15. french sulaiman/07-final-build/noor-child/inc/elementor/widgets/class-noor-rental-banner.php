<?php
/**
 * Rental CTA banner widget — coral gradient banner, Réunion exclusive.
 *
 * @package Noor_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Noor_Widget_Rental_Banner extends \Elementor\Widget_Base {

	public function get_name() {
		return 'noor_rental_banner';
	}

	public function get_title() {
		return __( 'Noor — Bannière Location', 'noor' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return array( 'noor-festivities' );
	}

	public function get_keywords() {
		return array( 'noor', 'rental', 'location', 'banner', 'cta' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Contenu', 'noor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'bg_image',
			array(
				'label'   => __( 'Image de fond', 'noor' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array( 'url' => get_stylesheet_directory_uri() . '/assets/img/rental.jpg' ),
			)
		);
		$this->add_control(
			'chip',
			array(
				'label'   => __( 'Badge', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( '📍 Exclusivité Réunion', 'noor' ),
			)
		);
		$this->add_control(
			'title',
			array(
				'label'       => __( 'Titre', 'noor' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => __( 'Location de matériel<br><em>maintenant disponible</em>', 'noor' ),
				'description' => __( '<em>…</em> = ligne claire italique. <br> = retour à la ligne.', 'noor' ),
			)
		);
		$this->add_control(
			'text',
			array(
				'label'   => __( 'Texte', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				/* Client 16/08/2026: no sound system is rented — arches only. */
				'default' => __( 'Arches de ballons à louer pour votre événement, à récupérer à Saint-Denis.', 'noor' ),
			)
		);
		$this->add_control(
			'btn_text',
			array(
				'label'   => __( 'Bouton — texte', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Voir le matériel', 'noor' ),
			)
		);
		$this->add_control(
			'btn_link',
			array(
				'label'   => __( 'Bouton — lien', 'noor' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'default' => array( 'url' => noor_category_url( 'location' ) ),
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
		$this->add_control(
			'overlay_color',
			array(
				'label'     => __( 'Couleur du voile', 'noor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#C68053',
				'selectors' => array(
					'{{WRAPPER}} .nfw-rental__overlay' => 'background: linear-gradient(90deg, {{VALUE}}F0 0%, {{VALUE}}9E 60%, {{VALUE}}66 100%);',
				),
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$allowed  = array(
			'em' => array(),
			'br' => array(),
		);
		$url = ! empty( $settings['btn_link']['url'] ) ? $settings['btn_link']['url'] : '#';
		?>
		<?php /* noor-rental-ui: hidden outside Réunion by the region CSS (inc/region.php). */ ?>
		<div class="nfw-rental noor-rental-ui">
			<?php if ( ! empty( $settings['bg_image']['url'] ) ) : ?>
				<img class="nfw-rental__img" src="<?php echo esc_url( $settings['bg_image']['url'] ); ?>" alt="" loading="lazy" />
			<?php endif; ?>
			<div class="nfw-rental__overlay"></div>
			<div class="nfw-rental__inner">
				<div>
					<?php if ( ! empty( $settings['chip'] ) ) : ?><span class="nfw-rental__chip"><?php echo esc_html( $settings['chip'] ); ?></span><?php endif; ?>
					<h2 class="nfw-rental__title"><?php echo wp_kses( $settings['title'], $allowed ); ?></h2>
					<?php if ( ! empty( $settings['text'] ) ) : ?><p class="nfw-rental__text"><?php echo esc_html( $settings['text'] ); ?></p><?php endif; ?>
				</div>
				<?php if ( ! empty( $settings['btn_text'] ) ) : ?>
					<a class="nfw-rental__btn" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $settings['btn_text'] ); ?> →</a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
