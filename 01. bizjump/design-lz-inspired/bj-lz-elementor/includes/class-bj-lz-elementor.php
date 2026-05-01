<?php
namespace BJ_LZ_Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main plugin class — singleton.
 * Registers the widget category, enqueues fonts, loads all 19 widgets.
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
        add_action( 'wp_enqueue_scripts',                       [ $this, 'register_swiper' ] );
        add_action( 'elementor/preview/enqueue_scripts',        [ $this, 'register_swiper' ] );
        add_action( 'elementor/editor/before_enqueue_scripts',  [ $this, 'register_swiper' ] );
    }

    /**
     * Register (not enqueue) Swiper.js + CSS so widgets can declare them as deps.
     * Pinned to Swiper 11 from jsDelivr.
     */
    public function register_swiper() {
        wp_register_style(
            'bjlz-swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            [],
            '11.0.0'
        );
        wp_register_script(
            'bjlz-swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            [],
            '11.0.0',
            true
        );
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

            /* ── Formation Landing (entity selector page) ─────── */
            'flw-01-navbar'             => 'Widget_FLW_Navbar',
            'flw-02-hero-entity-grid'   => 'Widget_FLW_Hero_Entity_Grid',
            'flw-03-how-it-works'       => 'Widget_FLW_How_It_Works',
            'flw-04-comparison-table'   => 'Widget_FLW_Comparison_Table',
            'flw-05-why-bizjump'        => 'Widget_FLW_Why_BizJump',
            'flw-06-stats-band'         => 'Widget_FLW_Stats_Band',
            'flw-07-faq'                => 'Widget_FLW_FAQ',
            'flw-08-cta-banner'         => 'Widget_FLW_CTA_Banner',
            'flw-09-footer'             => 'Widget_FLW_Footer',

            /* ── Formation Wizard (multi-step start) ──────────── */
            'flw-10-wizard'             => 'Widget_FLW_Wizard',

            /* ── Doc-Aligned Landing (03. bizjump-doc-aligned) ── */
            'dal-01-hero'               => 'Widget_DAL_Hero',
            'dal-02-hero-slider'        => 'Widget_DAL_Hero_Slider',
            'dal-03-easy-way'           => 'Widget_DAL_Easy_Way',
            'dal-04-legacy-quote'       => 'Widget_DAL_Legacy_Quote',
            'dal-05-trust-strip'        => 'Widget_DAL_Trust_Strip',
            'dal-06-secondary-entities' => 'Widget_DAL_Secondary_Entities',
            'dal-07-faq'                => 'Widget_DAL_FAQ',
            'dal-08-ai-guide'           => 'Widget_DAL_AI_Guide',
            'dal-09-command-center'     => 'Widget_DAL_Command_Center',
            'dal-10-entity-cards'       => 'Widget_DAL_Entity_Cards',
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
