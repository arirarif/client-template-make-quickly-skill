<?php
/**
 * Noor Festivities — Elementor integration (lives in the child theme).
 *
 * Registers the "Noor Festivities" widget category and all custom widgets
 * from inc/elementor/widgets/. Header and footer are NOT widgets — they are
 * rendered by the child theme (header.php / footer.php).
 */

defined( 'ABSPATH' ) || exit;

final class Noor_Elementor {

	const MINIMUM_ELEMENTOR_VERSION = '3.5.0';

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		/* NOTE: plugins_loaded has already fired by the time theme code runs —
		   hooking it here would never execute. after_setup_theme is the first
		   hook available to a theme; Elementor is loaded before it. */
		add_action( 'after_setup_theme', array( $this, 'init' ) );
	}

	public function init() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'notice_missing_elementor' ) );
			return;
		}
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'notice_elementor_version' ) );
			return;
		}

		add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );

		// Widget styles in the editor + preview (front-end enqueue lives in functions.php).
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_widget_styles' ) );
		add_action( 'elementor/preview/enqueue_styles', array( $this, 'enqueue_widget_styles' ) );
	}

	public function notice_missing_elementor() {
		printf(
			'<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
			esc_html__( 'Le thème Noor Festivities inclut des widgets Elementor — installez et activez Elementor pour les utiliser.', 'noor' )
		);
	}

	public function notice_elementor_version() {
		printf(
			'<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
			esc_html__( 'Les widgets Noor Festivities nécessitent Elementor 3.5+. Veuillez mettre à jour Elementor.', 'noor' )
		);
	}

	public function register_category( $elements_manager ) {
		$elements_manager->add_category(
			'noor-festivities',
			array(
				'title' => __( 'Noor Festivities', 'noor' ),
				'icon'  => 'fa fa-moon',
			)
		);
	}

	public function register_widgets( $widgets_manager ) {
		$widgets = array(
			'class-noor-marquee.php'       => 'Noor_Widget_Marquee',
			'class-noor-hero.php'          => 'Noor_Widget_Hero',
			'class-noor-categories.php'    => 'Noor_Widget_Categories',
			'class-noor-rental-banner.php' => 'Noor_Widget_Rental_Banner',
			'class-noor-video.php'         => 'Noor_Widget_Video',
			'class-noor-testimonials.php'  => 'Noor_Widget_Testimonials',
			'class-noor-newsletter.php'    => 'Noor_Widget_Newsletter',
		);
		foreach ( $widgets as $file => $class ) {
			$path = get_stylesheet_directory() . '/inc/elementor/widgets/' . $file;
			if ( file_exists( $path ) ) {
				require_once $path;
				if ( class_exists( $class ) ) {
					$widgets_manager->register( new $class() );
				}
			}
		}
	}

	public function enqueue_widget_styles() {
		wp_enqueue_style(
			'noor-widgets',
			get_stylesheet_directory_uri() . '/assets/css/noor-widgets.css',
			array(),
			NOOR_VERSION
		);
	}
}

Noor_Elementor::instance();
