<?php
/**
 * Newsletter signup widget — "Stay in the loop" block.
 * Form posts to a configurable action URL (Mailchimp/Brevo embed endpoint),
 * or renders a shortcode (e.g. Brevo form plugin) when provided.
 *
 * @package Noor_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Noor_Widget_Newsletter extends \Elementor\Widget_Base {

	public function get_name() {
		return 'noor_newsletter';
	}

	public function get_title() {
		return __( 'Noor — Newsletter', 'noor' );
	}

	public function get_icon() {
		return 'eicon-email-field';
	}

	public function get_categories() {
		return array( 'noor-festivities' );
	}

	public function get_keywords() {
		return array( 'noor', 'newsletter', 'email', 'subscribe' );
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
			'icon_emoji',
			array(
				'label'   => __( 'Icône (emoji)', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '✨',
			)
		);
		$this->add_control(
			'title',
			array(
				'label'   => __( 'Titre', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Restez informé·e', 'noor' ),
			)
		);
		$this->add_control(
			'subtitle',
			array(
				'label'   => __( 'Sous-titre', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Nouvelles collections, offres exclusives & inspiration festive.', 'noor' ),
			)
		);
		$this->add_control(
			'placeholder',
			array(
				'label'   => __( 'Placeholder email', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'votre@email.com', 'noor' ),
			)
		);
		$this->add_control(
			'btn_text',
			array(
				'label'   => __( 'Bouton', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'S’abonner', 'noor' ),
			)
		);
		$this->add_control(
			'note',
			array(
				'label'   => __( 'Note RGPD', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Désinscription à tout moment. Vos données restent privées.', 'noor' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_integration',
			array(
				'label' => __( 'Intégration (Mailchimp / Brevo)', 'noor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'form_action',
			array(
				'label'       => __( 'URL d’action du formulaire', 'noor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'description' => __( 'URL "form action" Mailchimp/Brevo. Vide = formulaire décoratif (démo).', 'noor' ),
			)
		);
		$this->add_control(
			'shortcode',
			array(
				'label'       => __( 'OU shortcode formulaire', 'noor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'description' => __( 'Ex : shortcode du plugin Brevo/MC4WP. Prioritaire sur l’URL si rempli.', 'noor' ),
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="nfw-news">
			<?php if ( ! empty( $settings['icon_emoji'] ) ) : ?><div class="nfw-news__icon"><?php echo esc_html( $settings['icon_emoji'] ); ?></div><?php endif; ?>
			<h2 class="nfw-news__title"><?php echo esc_html( $settings['title'] ); ?></h2>
			<?php if ( ! empty( $settings['subtitle'] ) ) : ?><p class="nfw-news__sub"><?php echo esc_html( $settings['subtitle'] ); ?></p><?php endif; ?>

			<?php if ( ! empty( $settings['shortcode'] ) ) : ?>
				<div class="nfw-news__shortcode"><?php echo do_shortcode( sanitize_text_field( $settings['shortcode'] ) ); ?></div>
			<?php else : ?>
				<form class="nfw-news__form" method="post" action="<?php echo esc_url( $settings['form_action'] ); ?>" target="_blank" rel="noopener">
					<input class="nfw-news__input" type="email" name="EMAIL" placeholder="<?php echo esc_attr( $settings['placeholder'] ); ?>" required />
					<button class="nfw-news__btn" type="submit"><?php echo esc_html( $settings['btn_text'] ); ?></button>
				</form>
			<?php endif; ?>

			<?php if ( ! empty( $settings['note'] ) ) : ?><div class="nfw-news__note">🔒 <?php echo esc_html( $settings['note'] ); ?></div><?php endif; ?>
		</div>
		<?php
	}
}
