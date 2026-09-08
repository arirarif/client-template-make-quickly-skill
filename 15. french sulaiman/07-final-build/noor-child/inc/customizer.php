<?php
/**
 * Noor Festivities — Customizer options.
 *
 * Lets the site owner change the logos and the announcement bar from
 * Apparence → Personnaliser, without touching any file. Every setting falls
 * back to the brand asset bundled in the theme, so the site always looks
 * right even on a fresh install.
 *
 * @package noor
 */

defined( 'ABSPATH' ) || exit;

/* --------------------------------------------------------------------------
 * Header logo = the native WordPress "custom logo" (Site Identity panel)
 * ------------------------------------------------------------------------ */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'custom-logo', array(
		'height'      => 120,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
	) );
} );

/**
 * Header logo URL: Customizer logo if one was chosen, else the bundled mocha logo.
 *
 * @return string
 */
function noor_header_logo_url() {
	$id = (int) get_theme_mod( 'custom_logo' );
	if ( $id ) {
		$src = wp_get_attachment_image_src( $id, 'full' );
		if ( ! empty( $src[0] ) ) {
			return $src[0];
		}
	}
	return get_stylesheet_directory_uri() . '/assets/img/logo-mocha.png';
}

/**
 * Footer logo URL: its own Customizer setting, else the bundled ivory logo.
 * (The footer sits on espresso, so it needs the light version — that is why it
 * is a separate control rather than reusing the header logo.)
 *
 * @return string
 */
function noor_footer_logo_url() {
	$url = trim( (string) get_theme_mod( 'noor_footer_logo', '' ) );
	if ( $url ) {
		return $url;
	}

	// Under the light skin the footer is Creamy Beige, not espresso, so the
	// ivory logo would be almost invisible on it — use the mocha one instead.
	// An explicit Customizer choice above still wins in both skins.
	if ( function_exists( 'noor_light_skin_active' ) && noor_light_skin_active() ) {
		return get_stylesheet_directory_uri() . '/assets/img/logo-mocha.png';
	}

	return get_stylesheet_directory_uri() . '/assets/img/logo-ivory.png';
}

/* --------------------------------------------------------------------------
 * Customizer section: Noor Festivities
 * ------------------------------------------------------------------------ */
add_action( 'customize_register', function ( $wp_customize ) {

	$wp_customize->add_section( 'noor_options', array(
		'title'       => __( 'Noor Festivities', 'noor' ),
		'priority'    => 30,
		'description' => __( 'Logo du pied de page et barre d’annonce. Le logo de l’en-tête se règle dans « Identité du site ».', 'noor' ),
	) );

	/* ---- Footer logo ---- */
	$wp_customize->add_setting( 'noor_footer_logo', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'noor_footer_logo', array(
		'label'       => __( 'Logo du pied de page', 'noor' ),
		'description' => __( 'Version claire (ivoire) — le pied de page est foncé. Vide = logo ivoire fourni avec le thème.', 'noor' ),
		'section'     => 'noor_options',
	) ) );

	/* ---- Announcement bar ---- */
	$wp_customize->add_setting( 'noor_announce_show', array(
		'default'           => true,
		'sanitize_callback' => function ( $v ) {
			return (bool) $v;
		},
	) );
	$wp_customize->add_control( 'noor_announce_show', array(
		'label'   => __( 'Afficher la barre d’annonce', 'noor' ),
		'section' => 'noor_options',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'noor_announce_text', array(
		'default'           => '✨ <b>Livraison offerte</b> dès 50€ à La Réunion',
		'sanitize_callback' => function ( $v ) {
			return wp_kses( $v, array( 'b' => array(), 'strong' => array(), 'em' => array(), 'a' => array( 'href' => array() ) ) );
		},
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'noor_announce_text', array(
		'label'       => __( 'Texte de la barre d’annonce', 'noor' ),
		'description' => __( 'Balises autorisées : &lt;b&gt; &lt;em&gt; &lt;a&gt;.', 'noor' ),
		'section'     => 'noor_options',
		'type'        => 'text',
	) );

	/* ---- Footer tagline ---- */
	$wp_customize->add_setting( 'noor_footer_tagline', array(
		'default'           => __( 'Décorations et matériel de célébration premium pour toutes vos fêtes — Eid, Nikkah, Aqiqah, Hajj & Umrah.', 'noor' ),
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'noor_footer_tagline', array(
		'label'   => __( 'Texte sous le logo du pied de page', 'noor' ),
		'section' => 'noor_options',
		'type'    => 'textarea',
	) );
} );
