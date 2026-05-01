<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main plugin class — singleton.
 * Registers the widget category, enqueues fonts, loads widgets.
 *
 * Widget set:
 *  - DLW (Demo Landing — LLC sales page)        × 9 widgets
 *  - FLW (Formation Landing — doc-aligned)      × 10 widgets (current cleaned design)
 *  - WZD (Formation Wizard — multi-step)        × 1 widget
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
        add_action( 'elementor/frontend/after_enqueue_styles',  [ $this, 'enqueue_fonts' ] );
        add_action( 'elementor/preview/enqueue_styles',         [ $this, 'enqueue_fonts' ] );
        add_action( 'wp_enqueue_scripts',                       [ $this, 'enqueue_fonts' ] );
    }

    public function register_category( $elements_manager ) {
        $elements_manager->add_category( 'bj-lz-widgets', [
            'title' => 'BizJump LZ Widgets',
            'icon'  => 'eicon-folder',
        ] );
    }

    /**
     * Load Inter + Plus Jakarta Sans from Google Fonts (used by all widgets).
     */
    public function enqueue_fonts() {
        wp_enqueue_style(
            'bjlz-google-fonts',
            'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
            [],
            BJLZ_EL_VERSION
        );
    }

    public function register_widgets( $widgets_manager ) {
        $widgets = [
            /* ── Demo Landing (LLC sales page) ─────────────────── */
            'dlw-01-navbar'             => 'Widget_DLW_Navbar',
            'dlw-02-hero'               => 'Widget_DLW_Hero',
            'dlw-03-pricing'            => 'Widget_DLW_Pricing',
            'dlw-04-features'           => 'Widget_DLW_Features',
            'dlw-05-comparison-table'   => 'Widget_DLW_Comparison_Table',
            'dlw-06-testimonials'       => 'Widget_DLW_Testimonials',
            'dlw-07-faq'                => 'Widget_DLW_FAQ',
            'dlw-08-cta-banner'         => 'Widget_DLW_CTA_Banner',
            'dlw-09-footer'             => 'Widget_DLW_Footer',

            /* ── Formation Landing (doc-aligned, current build) ── */
            'flw-01-navbar'              => 'Widget_FLW_Navbar',
            'flw-02-hero-cards'          => 'Widget_FLW_Hero_Cards',
            'flw-03-incorporate'         => 'Widget_FLW_Incorporate',
            'flw-04-legacy'              => 'Widget_FLW_Legacy',
            'flw-05-trust-strip'         => 'Widget_FLW_Trust_Strip',
            'flw-06-secondary-entities'  => 'Widget_FLW_Secondary_Entities',
            'flw-07-faq'                 => 'Widget_FLW_FAQ',
            'flw-08-ai-guide'            => 'Widget_FLW_AI_Guide',
            'flw-09-command-center'      => 'Widget_FLW_Command_Center',
            'flw-10-footer'              => 'Widget_FLW_Footer',

            /* ── Formation Wizard (separate page) ──────────────── */
            'wzd-01-wizard'              => 'Widget_WZD_Wizard',
        ];

        foreach ( $widgets as $file => $class ) {
            $path = BJLZ_EL_PATH . "widgets/class-widget-{$file}.php";
            if ( file_exists( $path ) ) {
                require_once $path;
                $full_class = "\\BJ_LZ_Elementor\\{$class}";
                if ( class_exists( $full_class ) ) {
                    $widgets_manager->register( new $full_class() );
                }
            }
        }
    }
}
