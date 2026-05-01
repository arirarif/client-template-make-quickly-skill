<?php
namespace PP_UK_Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main plugin class — singleton.
 * Registers the widget category, enqueues global assets, loads all widgets.
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
        $elements_manager->add_category( 'pp-uk', [
            'title' => 'Performance Peptide UK',
            'icon'  => 'eicon-folder',
        ] );
    }

    public function enqueue_styles() {
        wp_enqueue_style(
            'ppuk-global',
            PPUK_URL . 'assets/css/global-styles.css',
            [],
            PPUK_VERSION
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            'ppuk-global',
            PPUK_URL . 'assets/js/global-scripts.js',
            [],
            PPUK_VERSION,
            true
        );
    }

    public function register_widgets( $widgets_manager ) {
        $widgets = [
            /* ── Homepage widgets (01–11) ── */
            'compliance-bar'    => 'Widget_Compliance_Bar',
            'hero'              => 'Widget_Hero',
            'how-it-works'      => 'Widget_How_It_Works',
            'categories'        => 'Widget_Categories',
            'featured-products' => 'Widget_Featured_Products',
            'about-peptides'    => 'Widget_About_Peptides',
            'quality-pillars'   => 'Widget_Quality_Pillars',
            'faq'               => 'Widget_FAQ',
            'newsletter'        => 'Widget_Newsletter',
            'footer'            => 'Widget_Footer',
            'age-gate'          => 'Widget_Age_Gate',

            /* ── Inner page widgets (12–23) ── */
            'page-hero'              => 'Widget_Page_Hero',          // 12 — reusable inner-page header
            'cta-band'               => 'Widget_CTA_Band',           // 13 — reusable CTA strip
            'about-mission'          => 'Widget_About_Mission',      // 14 — about: mission 2-col
            'about-stats'            => 'Widget_About_Stats',        // 15 — about: dark stats strip
            'about-values'           => 'Widget_About_Values',       // 16 — about: 2×2 values grid
            'about-process'          => 'Widget_About_Process',      // 17 — about: process steps
            'contact-form'           => 'Widget_Contact_Form',       // 18 — contact: form + sidebar
            'faq-full'               => 'Widget_FAQ_Full',           // 19 — faq: full page with sidebar
            'legal-doc'              => 'Widget_Legal_Doc',          // 20 — legal: terms / privacy
            'shipping-tiers'         => 'Widget_Shipping_Tiers',     // 21 — shipping: tier cards
            'shipping-packaging'     => 'Widget_Shipping_Packaging', // 22 — shipping: packaging features
            'shipping-policies'      => 'Widget_Shipping_Policies',  // 23 — shipping: policy rows
        ];

        foreach ( $widgets as $file => $class ) {
            require_once PPUK_PATH . "widgets/class-widget-{$file}.php";
            $full_class = "\\PP_UK_Elementor\\{$class}";
            $widgets_manager->register( new $full_class() );
        }
    }
}
