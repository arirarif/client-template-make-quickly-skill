<?php
namespace BJ_Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main plugin class — singleton.
 * Registers the widget category, enqueues global assets, loads all 12 widgets.
 */
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
        $elements_manager->add_category( 'bj-widgets', [
            'title' => 'BizJump Widgets',
            'icon'  => 'eicon-folder',
        ] );
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            'bj-global',
            BJW_EL_URL . 'assets/css/global-styles.css',
            [],
            BJW_EL_VERSION
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            'bj-global',
            BJW_EL_URL . 'assets/js/global-scripts.js',
            [],
            BJW_EL_VERSION,
            true
        );
    }

    public function register_widgets( $widgets_manager ) {
        $widgets = [
            /* file-slug (after the number) => class name */
            '01-announcement-bar'     => 'Widget_Announcement_Bar',
            '02-hero'                 => 'Widget_Hero',
            '03-ticker-marquee'       => 'Widget_Ticker_Marquee',
            '04-stats-strip'          => 'Widget_Stats_Strip',
            '05-how-it-works'         => 'Widget_How_It_Works',
            '06-entity-types'         => 'Widget_Entity_Types',
            '07-pricing-cards'        => 'Widget_Pricing_Cards',
            '08-why-bizjump'          => 'Widget_Why_BizJump',
            '09-services-grid'        => 'Widget_Services_Grid',
            '10-testimonials'         => 'Widget_Testimonials',
            '11-cta-banner'           => 'Widget_CTA_Banner',
            '12-footer'               => 'Widget_Footer',
            '13-easy-way'             => 'Widget_Easy_Way',
            '14-legacy'               => 'Widget_Legacy',
            '15-specialized-entities' => 'Widget_Specialized_Entities',
            '16-faq-accordion'        => 'Widget_FAQ_Accordion',
        ];

        foreach ( $widgets as $file => $class ) {
            require_once BJW_EL_PATH . "widgets/class-widget-{$file}.php";
            $full_class = "\\BJ_Elementor\\{$class}";
            $widgets_manager->register( new $full_class() );
        }
    }
}
