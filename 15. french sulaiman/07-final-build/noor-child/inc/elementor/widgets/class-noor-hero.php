<?php
/**
 * Hero widget — full-screen hero with background image, badge, title, two CTAs.
 *
 * @package Noor_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Noor_Widget_Hero extends \Elementor\Widget_Base {

	public function get_name() {
		return 'noor_hero';
	}

	public function get_title() {
		return __( 'Noor — Hero', 'noor' );
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_categories() {
		return array( 'noor-festivities' );
	}

	public function get_keywords() {
		return array( 'noor', 'hero', 'banner', 'header' );
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
				'default' => array( 'url' => get_stylesheet_directory_uri() . '/assets/img/hero.jpg' ),
			)
		);

		$this->add_control(
			'badge_text',
			array(
				'label'   => __( 'Badge', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Illuminez chaque célébration', 'noor' ), // client 16/08/2026: official tagline (BRANDING.md §1)
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => __( 'Titre', 'noor' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => __( 'Illuminez <em>Chaque</em><br>Célébration', 'noor' ),
				'description' => __( '<em>…</em> = mot doré en italique. <br> = retour à la ligne.', 'noor' ),
			)
		);

		$this->add_control(
			'subtitle',
			array(
				'label'   => __( 'Sous-titre', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'La première destination de La Réunion pour les mariages Nikkah, l’Eid, l’Aqiqah et tous vos événements.', 'noor' ),
			)
		);

		$this->add_control(
			'cta1_text',
			array(
				'label'   => __( 'Bouton 1 — texte', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Découvrir la collection Eid', 'noor' ),
			)
		);
		$this->add_control(
			'cta1_link',
			array(
				'label'   => __( 'Bouton 1 — lien', 'noor' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'default' => array( 'url' => noor_category_url( 'eid-decor' ) ),
			)
		);
		$this->add_control(
			'cta2_text',
			array(
				'label'       => __( 'Bouton 2 — texte (vide = masqué)', 'noor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => __( '📅 Réserver du matériel', 'noor' ),
			)
		);
		$this->add_control(
			'cta2_link',
			array(
				'label'   => __( 'Bouton 2 — lien', 'noor' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'default' => array( 'url' => noor_category_url( 'location' ) ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_stats',
			array(
				'label' => __( 'Statistiques (bandeau sous les boutons)', 'noor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$stats = new \Elementor\Repeater();
		$stats->add_control(
			'value',
			array(
				'label'   => __( 'Valeur', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '1200+',
			)
		);
		$stats->add_control(
			'label',
			array(
				'label'   => __( 'Libellé', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'commandes livrées', 'noor' ),
			)
		);

		$this->add_control(
			'stats_items',
			array(
				'label'       => __( 'Statistiques (vide = masqué)', 'noor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $stats->get_controls(),
				'title_field' => '{{{ value }}} {{{ label }}}',
				'default'     => array(
					array( 'value' => '1200+', 'label' => __( 'commandes livrées', 'noor' ) ),
					array( 'value' => '4.9★', 'label' => __( 'note moyenne', 'noor' ) ),
					array( 'value' => '6+', 'label' => __( 'années d’expérience', 'noor' ) ),
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
			'min_height',
			array(
				'label'      => __( 'Hauteur minimum', 'noor' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'vh', 'px' ),
				'range'      => array(
					'vh' => array( 'min' => 30, 'max' => 100 ),
					'px' => array( 'min' => 300, 'max' => 1200 ),
				),
				'default'    => array( 'unit' => 'vh', 'size' => 88 ),
				'selectors'  => array( '{{WRAPPER}} .nfw-hero' => 'min-height: {{SIZE}}{{UNIT}};' ),
			)
		);

		$this->add_control(
			'accent_color',
			array(
				'label'     => __( 'Couleur mot accentué', 'noor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#EED2AE', // Creamy Beige (brand Accent 1).
				'selectors' => array( '{{WRAPPER}} .nfw-hero__title em' => 'color: {{VALUE}};' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$allowed = array(
			'em' => array(),
			'br' => array(),
		);

		$cta1_url = ! empty( $settings['cta1_link']['url'] ) ? $settings['cta1_link']['url'] : '#';
		$cta2_url = ! empty( $settings['cta2_link']['url'] ) ? $settings['cta2_link']['url'] : '#';

		/* A button pointing at the rental category is hidden outside Réunion —
		 * client-side, so the cached home page stays valid everywhere
		 * (see inc/region.php). */
		$cta1_class = ( function_exists( 'noor_is_rental_url' ) && noor_is_rental_url( $cta1_url ) ) ? ' noor-rental-ui' : '';
		$cta2_class = ( function_exists( 'noor_is_rental_url' ) && noor_is_rental_url( $cta2_url ) ) ? ' noor-rental-ui' : '';
		?>
		<section class="nfw-hero">
			<?php if ( ! empty( $settings['bg_image']['url'] ) ) : ?>
				<img class="nfw-hero__img" src="<?php echo esc_url( $settings['bg_image']['url'] ); ?>" alt="" loading="eager" />
			<?php endif; ?>
			<div class="nfw-hero__overlay"></div>
			<div class="nfw-hero__inner">
				<?php if ( ! empty( $settings['badge_text'] ) ) : ?>
					<div class="nfw-hero__badge">☾ <?php echo esc_html( $settings['badge_text'] ); ?></div>
				<?php endif; ?>
				<h1 class="nfw-hero__title"><?php echo wp_kses( $settings['title'], $allowed ); ?></h1>
				<?php if ( ! empty( $settings['subtitle'] ) ) : ?>
					<p class="nfw-hero__subtitle"><?php echo esc_html( $settings['subtitle'] ); ?></p>
				<?php endif; ?>
				<div class="nfw-hero__ctas">
					<?php if ( ! empty( $settings['cta1_text'] ) ) : ?>
						<a class="nfw-btn nfw-btn--primary<?php echo esc_attr( $cta1_class ); ?>" href="<?php echo esc_url( $cta1_url ); ?>"><?php echo esc_html( $settings['cta1_text'] ); ?> →</a>
					<?php endif; ?>
					<?php if ( ! empty( $settings['cta2_text'] ) ) : ?>
						<a class="nfw-btn nfw-btn--ghost<?php echo esc_attr( $cta2_class ); ?>" href="<?php echo esc_url( $cta2_url ); ?>"><?php echo esc_html( $settings['cta2_text'] ); ?></a>
					<?php endif; ?>
				</div>
				<?php if ( ! empty( $settings['stats_items'] ) ) : ?>
					<div class="nfw-hero__stats">
						<?php foreach ( $settings['stats_items'] as $stat ) : ?>
							<div class="nfw-hero__stat">
								<b><?php echo esc_html( $stat['value'] ); ?></b>
								<span><?php echo esc_html( $stat['label'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
