<?php
/**
 * BizJump Wizard — Shortcode + asset enqueue.
 *
 * Shortcode: [bizjump_wizard view="..." wizard_url="/incorporation/"]
 *   view="wizard"  (default) → renders ONLY the 14-step wizard. URL params
 *                              ?entity=...&state=... preselect those values.
 *   view="hero"             → renders ONLY the homepage hero. "Start My
 *                              Business" redirects to wizard_url with entity
 *                              + state in the query string.
 *   view="auto"             → renders both sections; JS toggles between them
 *                              on the same URL (legacy behaviour).
 *
 * @package BizJump_Wizard
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BJW_Shortcode' ) ) :
class BJW_Shortcode {

    public static function render( $atts ): string {
        $atts = shortcode_atts( [
            'view'       => 'wizard',
            'wizard_url' => '/incorporation/',
            'step'       => '1',
        ], $atts, 'bizjump_wizard' );

        // Allowed views
        if ( ! in_array( $atts['view'], [ 'wizard', 'hero', 'auto' ], true ) ) {
            $atts['view'] = 'wizard';
        }

        ob_start();
        include BJW_DIR . 'templates/wizard.php';
        return ob_get_clean();
    }

    public static function enqueue_assets(): void {
        // Only enqueue when the shortcode is present on the post.
        global $post;
        if ( ! $post || ! has_shortcode( $post->post_content, 'bizjump_wizard' ) ) return;

        wp_enqueue_style( 'bjw-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap', [], null );
        wp_enqueue_style( 'bjw-wizard', BJW_URL . 'assets/wizard.css', [ 'bjw-google-fonts' ], BJW_VERSION );
        wp_enqueue_script( 'bjw-wizard', BJW_URL . 'assets/wizard.js', [], BJW_VERSION, true );

        // Pull the wizard_url from the shortcode atts in the current post.
        // Default to /incorporation/ (the page the installer auto-creates).
        $wizard_url = self::extract_wizard_url( $post->post_content );

        wp_localize_script( 'bjw-wizard', 'BJW_DATA', [
            'ajax_url'    => admin_url( 'admin-ajax.php' ),
            'nonce'       => wp_create_nonce( 'bjw_submit' ),
            'wizard_url'  => $wizard_url,
            'states'      => BJW_State_Fees::all_fees(),
            'plans'       => BJW_Plans::all(),
            'addons'      => BJW_Addons::all(),
            'sections'    => BJW_Addons::sections(),
            'designators' => BJW_Designators::all(),
        ] );
    }

    /** Pull the wizard_url attribute out of the shortcode tag if specified. */
    private static function extract_wizard_url( string $content ): string {
        $default = home_url( '/incorporation/' );
        if ( preg_match( '/\[bizjump_wizard[^\]]*wizard_url=["\']([^"\']+)["\']/', $content, $m ) ) {
            $u = $m[1];
            // Allow absolute URLs or site-relative paths
            if ( strpos( $u, '://' ) === false ) $u = home_url( $u );
            return $u;
        }
        return $default;
    }
}
endif;
