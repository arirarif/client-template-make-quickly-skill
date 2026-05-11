<?php
namespace PP_Atomic_Blue;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Plugin {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'elementor/elements/categories_registered', [ $this, 'register_category' ] );
        add_action( 'elementor/widgets/register',               [ $this, 'register_widgets' ] );
        add_action( 'elementor/frontend/after_enqueue_styles',  [ $this, 'enqueue_styles' ] );
        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'elementor/preview/enqueue_styles',         [ $this, 'enqueue_styles' ] );
        add_action( 'elementor/preview/enqueue_scripts',        [ $this, 'enqueue_scripts' ] );
    }

    public function register_category( $elements_manager ) {
        $elements_manager->add_category( 'pp_atomic_blue', [
            'title' => 'Performance Peptides',
            'icon'  => 'eicon-flask',
        ] );
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            'pp-global',
            PP_URL . 'assets/css/global-styles.css',
            [],
            PP_VERSION
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            'pp-global',
            PP_URL . 'assets/js/global-scripts.js',
            [],
            PP_VERSION,
            true
        );
    }

    public function register_widgets( $widgets_manager ) {
        $widgets = [
            // Home
            'hero'              => 'Widget_Hero',
            'trust-strip'       => 'Widget_Trust_Strip',
            'categories'        => 'Widget_Categories',
            'featured-products' => 'Widget_Featured_Products',
            'newsletter'        => 'Widget_Newsletter',
            'news-carousel'     => 'Widget_News_Carousel',
            'footer'            => 'Widget_Footer',
            // About
            'about-hero'        => 'Widget_About_Hero',
            'story-grid'        => 'Widget_Story_Grid',
            'stat-strip'        => 'Widget_Stat_Strip',
            'values-grid'       => 'Widget_Values_Grid',
            'lab-tour'          => 'Widget_Lab_Tour',
            'team-grid'         => 'Widget_Team_Grid',
            // Contact
            'contact-hero'      => 'Widget_Contact_Hero',
            'contact-info-form' => 'Widget_Contact_Info_Form',
            'contact-map'       => 'Widget_Contact_Map',
        ];

        foreach ( $widgets as $file => $class ) {
            require_once PP_PATH . "widgets/class-widget-{$file}.php";
            $full_class = "\\PP_Atomic_Blue\\{$class}";
            $widgets_manager->register( new $full_class() );
        }
    }
}
