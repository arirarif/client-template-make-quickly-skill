<?php
/**
 * Tools > Emma setup: builds the site from the JSON files in /templates.
 *
 * Safe to run more than once: everything it creates is remembered by a key,
 * and existing items are skipped unless "Replace" is ticked.
 * After launch this file and the /templates folder can be deleted.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', function () {
	add_management_page( 'Emma setup', 'Emma setup', 'manage_options', 'emma-setup', 'emma_core_setup_page' );
} );

function emma_core_setup_page() {
	echo '<div class="wrap"><h1>Emma setup</h1>';
	if ( isset( $_POST['emma_setup_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['emma_setup_nonce'] ), 'emma_setup' ) && current_user_can( 'manage_options' ) ) {
		$log = emma_core_run_setup( ! empty( $_POST['emma_replace'] ) );
		echo '<div class="notice notice-success"><p><strong>Done.</strong></p></div><ol>';
		foreach ( $log as $line ) {
			echo '<li>' . esc_html( $line ) . '</li>';
		}
		echo '</ol>';
	}
	$ready = did_action( 'elementor/loaded' );
	echo '<p>Creates the brand colours and fonts in Elementor, the header, footer and portfolio templates, the 5 pages, the 6 Services and 3 sample projects.</p>';
	echo '<p>Elementor: ' . ( $ready ? '<strong>active</strong>' : '<strong style="color:#b32d2e">not active. Activate Elementor and Elementor Pro first.</strong>' );
	echo ' &nbsp; Elementor Pro: ' . ( defined( 'ELEMENTOR_PRO_VERSION' ) ? '<strong>active</strong>' : '<strong style="color:#b32d2e">not active (header, footer, portfolio grids and the form need it)</strong>' ) . '</p>';
	echo '<form method="post">';
	wp_nonce_field( 'emma_setup', 'emma_setup_nonce' );
	echo '<p><label><input type="checkbox" name="emma_replace" value="1"> Replace pages and templates that already exist (your edits to them will be lost)</label></p>';
	submit_button( 'Run setup', 'primary', 'submit', false, $ready ? array() : array( 'disabled' => 'disabled' ) );
	echo '</form></div>';
}

/** @return string[] log lines */
function emma_core_run_setup( $replace = false ) {
	$log = array();
	if ( ! did_action( 'elementor/loaded' ) ) {
		return array( 'Elementor is not active. Nothing was changed.' );
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$images = emma_core_setup_images( $log );
	$terms  = emma_core_setup_terms( $log );
	$menu   = emma_core_setup_menu( $log );
	emma_core_setup_kit( $log );

	$manifest = json_decode( file_get_contents( EMMA_CORE_DIR . 'templates/manifest.json' ), true );
	$tpl_ids  = array();
	foreach ( $manifest as $doc ) {
		$tpl_ids[ $doc['key'] ] = emma_core_setup_document( $doc, $images, $terms, $tpl_ids, $menu, $replace, $log );
	}

	emma_core_setup_projects( $images, $terms, $log );
	emma_core_setup_options( $images, $tpl_ids, $log );

	flush_rewrite_rules();
	if ( class_exists( '\ElementorPro\Modules\ThemeBuilder\Module' ) ) {
		\ElementorPro\Modules\ThemeBuilder\Module::instance()->get_conditions_manager()->get_cache()->regenerate();
		$log[] = 'Theme Builder display conditions refreshed.';
	}
	\Elementor\Plugin::$instance->files_manager->clear_cache();
	$log[] = 'Elementor CSS cache cleared.';
	return $log;
}

function emma_core_find_by_key( $key, $post_types ) {
	$found = get_posts( array(
		'post_type'   => $post_types,
		'post_status' => 'any',
		'meta_key'    => '_emma_key',
		'meta_value'  => $key,
		'numberposts' => 1,
		'fields'      => 'ids',
	) );
	return $found ? (int) $found[0] : 0;
}

function emma_core_setup_images( &$log ) {
	$out = array();
	foreach ( glob( EMMA_CORE_DIR . 'assets/img/*.{jpg,png}', GLOB_BRACE ) as $path ) {
		$file = basename( $path );
		$id   = emma_core_find_by_key( 'img:' . $file, 'attachment' );
		if ( ! $id ) {
			$tmp = wp_tempnam( $file );
			copy( $path, $tmp );
			$id = media_handle_sideload( array( 'name' => $file, 'tmp_name' => $tmp ), 0 );
			if ( is_wp_error( $id ) ) {
				$log[] = 'Image failed: ' . $file . ' (' . $id->get_error_message() . ')';
				continue;
			}
			update_post_meta( $id, '_emma_key', 'img:' . $file );
			$log[] = 'Image added to the media library: ' . $file;
		}
		$out[ $file ] = array( 'id' => (int) $id, 'url' => wp_get_attachment_url( $id ) );
	}
	return $out;
}

function emma_core_setup_terms( &$log ) {
	$services = array(
		'web-development'        => 'Web Development',
		'seo-sem'                => 'SEO & SEM',
		'social-media-marketing' => 'Social Media Marketing',
		'ai-solutions'           => 'AI Solutions',
		'email-automation'       => 'Email Automation',
		'analytics'              => 'Analytics',
	);
	$out = array();
	foreach ( $services as $slug => $name ) {
		$term = get_term_by( 'slug', $slug, 'service' );
		if ( ! $term ) {
			$made = wp_insert_term( $name, 'service', array( 'slug' => $slug ) );
			$term = is_wp_error( $made ) ? null : get_term( $made['term_id'], 'service' );
			$log[] = 'Service created: ' . $name;
		}
		if ( $term ) {
			$out[ $slug ] = (int) $term->term_id;
		}
	}
	return $out;
}

function emma_core_setup_menu( &$log ) {
	$menu = wp_get_nav_menu_object( 'Main menu' );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( 'Main menu' );
		foreach ( array( 'Services' => '/services/', 'Work' => '/portfolio/', 'About' => '/about/', 'Contact' => '/contact/' ) as $title => $url ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'  => $title,
				'menu-item-url'    => home_url( $url ),
				'menu-item-status' => 'publish',
				'menu-item-type'   => 'custom',
			) );
		}
		$menu  = wp_get_nav_menu_object( $menu_id );
		$log[] = 'Main menu created.';
	}
	$locations           = get_theme_mod( 'nav_menu_locations', array() );
	$locations['menu-1'] = $menu->term_id;
	set_theme_mod( 'nav_menu_locations', $locations );
	return $menu->slug;
}

/** Brand colours, fonts, widths and buttons in Elementor > Site Settings. */
function emma_core_setup_kit( &$log ) {
	$kit_id = (int) get_option( 'elementor_active_kit' );
	if ( ! $kit_id || ! get_post( $kit_id ) ) {
		$kit_id = (int) \Elementor\Plugin::$instance->kits_manager->create_default();
		update_option( 'elementor_active_kit', $kit_id );
	}
	$settings = get_post_meta( $kit_id, '_elementor_page_settings', true );
	$settings = is_array( $settings ) ? $settings : array();

	$display = array( 'typography_typography' => 'custom', 'typography_font_family' => 'Gloock', 'typography_font_weight' => '400' );
	$body    = array( 'typography_typography' => 'custom', 'typography_font_family' => 'Hanken Grotesk', 'typography_font_weight' => '400' );
	$size    = function ( $value ) {
		return array( 'unit' => 'custom', 'size' => $value, 'sizes' => array() );
	};
	$zero    = array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true );

	$brand = array(
		'system_colors'     => array(
			array( '_id' => 'primary', 'title' => 'Ink Black (headings)', 'color' => '#12100E' ),
			array( '_id' => 'secondary', 'title' => 'Botanical Olive', 'color' => '#54654A' ),
			array( '_id' => 'text', 'title' => 'Charcoal Slate (text)', 'color' => '#5A544C' ),
			array( '_id' => 'accent', 'title' => 'Sunflower Gold', 'color' => '#F2B02F' ),
		),
		'custom_colors'     => array(
			array( '_id' => 'emmabg1', 'title' => 'Cream Linen (background)', 'color' => '#FAF7F2' ),
			array( '_id' => 'emmabg2', 'title' => 'Sunbeam Cream', 'color' => '#FDF5E6' ),
			array( '_id' => 'emmalin', 'title' => 'Warm Stone (lines)', 'color' => '#E8E3DA' ),
			array( '_id' => 'emmaamb', 'title' => 'Warm Amber (hover)', 'color' => '#D9822B' ),
		),
		'system_typography' => array(
			array( '_id' => 'primary', 'title' => 'Headlines' ) + $display,
			array( '_id' => 'secondary', 'title' => 'Sub-headlines' ) + $display,
			array( '_id' => 'text', 'title' => 'Text' ) + $body,
			array( '_id' => 'accent', 'title' => 'Buttons and labels' ) + array( 'typography_font_weight' => '500' ) + $body,
		),
		'default_generic_fonts'          => 'sans-serif',
		'container_width'                => array( 'unit' => 'px', 'size' => 1128, 'sizes' => array() ),
		'container_padding'              => $zero,
		'space_between_widgets'          => array( 'unit' => 'px', 'size' => 0, 'column' => '0', 'row' => '0', 'sizes' => array() ),
		'body_background_background'     => 'classic',
		'body_background_color'          => '#FAF7F2',
		'body_color'                     => '#5A544C',
		'body_typography_typography'     => 'custom',
		'body_typography_font_family'    => 'Hanken Grotesk',
		'body_typography_font_weight'    => '400',
		'body_typography_font_size'      => array( 'unit' => 'rem', 'size' => 1.0625, 'sizes' => array() ),
		'body_typography_line_height'    => array( 'unit' => 'em', 'size' => 1.65, 'sizes' => array() ),
		'link_normal_color'              => '#12100E',
		'link_hover_color'               => '#D9822B',
		'button_typography_typography'   => 'custom',
		'button_typography_font_family'  => 'Hanken Grotesk',
		'button_typography_font_weight'  => '500',
		'button_typography_font_size'    => array( 'unit' => 'rem', 'size' => 0.95, 'sizes' => array() ),
		'button_typography_line_height'  => array( 'unit' => 'em', 'size' => 1, 'sizes' => array() ),
		'button_text_color'              => '#FAF7F2',
		'button_background_color'        => '#12100E',
		'button_hover_text_color'        => '#FAF7F2',
		'button_hover_background_color'  => '#2E2A25',
		'button_border_radius'           => array( 'unit' => 'px', 'top' => '999', 'right' => '999', 'bottom' => '999', 'left' => '999', 'isLinked' => true ),
		'button_padding'                 => array( 'unit' => 'em', 'top' => '1.05', 'right' => '1.6', 'bottom' => '1.05', 'left' => '1.6', 'isLinked' => false ),
	);
	foreach ( array( 'h1' => 'clamp(3rem, 7.4vw, 6.6rem)', 'h2' => 'clamp(2.2rem, 4.6vw, 3.8rem)', 'h3' => 'clamp(1.6rem, 2.8vw, 2.4rem)' ) as $tag => $clamp ) {
		$brand[ $tag . '_color' ]                  = '#12100E';
		$brand[ $tag . '_typography_typography' ]  = 'custom';
		$brand[ $tag . '_typography_font_family' ] = 'Gloock';
		$brand[ $tag . '_typography_font_weight' ] = '400';
		$brand[ $tag . '_typography_font_size' ]   = $size( $clamp );
		$brand[ $tag . '_typography_line_height' ] = array( 'unit' => 'em', 'size' => 'h1' === $tag ? 0.98 : 1.05, 'sizes' => array() );
	}

	update_post_meta( $kit_id, '_elementor_page_settings', array_merge( $settings, $brand ) );
	$log[] = 'Brand colours, fonts, site width and button style saved in Elementor > Site Settings.';
}

function emma_core_setup_document( $doc, $images, $terms, $tpl_ids, $menu, $replace, &$log ) {
	$is_page   = 'page' === $doc['kind'];
	$post_type = $is_page ? 'page' : 'elementor_library';
	$id        = emma_core_find_by_key( $doc['key'], $post_type );

	if ( $id && ! $replace ) {
		$log[] = 'Kept as it is: ' . $doc['title'];
		return $id;
	}

	$json = file_get_contents( EMMA_CORE_DIR . 'templates/' . $doc['key'] . '.json' );
	foreach ( $images as $file => $image ) {
		$json = str_replace( '"{{img:' . $file . ':id}}"', (string) $image['id'], $json );
		$json = str_replace( '{{img:' . $file . ':url}}', $image['url'], $json );
	}
	foreach ( $terms as $slug => $term_id ) {
		$json = str_replace( '"{{term:' . $slug . '}}"', '"' . $term_id . '"', $json );
	}
	foreach ( $tpl_ids as $key => $tpl_id ) {
		$json = str_replace( '"{{tpl:' . $key . '}}"', (string) (int) $tpl_id, $json );
	}
	$json = str_replace( array( '{{menu}}', '{{email}}' ), array( $menu, get_option( 'admin_email' ) ), $json );
	$data = json_decode( $json, true );
	if ( ! is_array( $data ) ) {
		$log[] = 'Skipped (template file could not be read): ' . $doc['title'];
		return $id;
	}

	$args = array(
		'post_type'   => $post_type,
		'post_title'  => $doc['title'],
		'post_status' => 'publish',
		'post_name'   => $is_page ? $doc['slug'] : 'emma-' . $doc['key'],
	);
	if ( $id ) {
		$args['ID'] = $id;
		wp_update_post( $args );
	} else {
		$id = wp_insert_post( $args );
	}
	if ( ! $id || is_wp_error( $id ) ) {
		$log[] = 'Could not create: ' . $doc['title'];
		return 0;
	}

	update_post_meta( $id, '_emma_key', $doc['key'] );
	update_post_meta( $id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $id, '_elementor_version', defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.0.0' );
	update_post_meta( $id, '_elementor_template_type', $is_page ? 'wp-page' : $doc['kind'] );
	update_post_meta( $id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
	delete_post_meta( $id, '_elementor_css' );

	if ( $is_page ) {
		update_post_meta( $id, '_wp_page_template', 'elementor_header_footer' );
	} else {
		wp_set_object_terms( $id, $doc['kind'], 'elementor_library_type' );
		if ( ! empty( $doc['conditions'] ) ) {
			update_post_meta( $id, '_elementor_conditions', $doc['conditions'] );
		}
	}
	$log[] = ( $is_page ? 'Page' : 'Template' ) . ' created: ' . $doc['title'];
	return (int) $id;
}

/** Three example projects, clearly marked as samples. */
function emma_core_setup_projects( $images, $terms, &$log ) {
	$projects = array(
		'sample-florist' => array( 'Florist', 'email-automation', 'work-florist.jpg', 'Seasonal emails and reminders that bring customers back.', 'Retail' ),
		'sample-yoga'    => array( 'Yoga studio', 'seo-sem', 'work-yoga.jpg', 'Local search and ads to fill the morning classes.', 'Health and wellbeing' ),
		'sample-cafe'    => array( 'Neighbourhood café', 'web-development', 'work-cafe.jpg', 'A new website with the menu, opening hours and online orders in one place.', 'Hospitality' ),
	);
	$block = function ( $heading, $text ) {
		return "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">{$heading}</h2>\n<!-- /wp:heading -->\n\n<!-- wp:paragraph -->\n<p>{$text}</p>\n<!-- /wp:paragraph -->\n\n";
	};
	foreach ( $projects as $key => $p ) {
		if ( emma_core_find_by_key( $key, 'case_study' ) ) {
			continue;
		}
		$id = wp_insert_post( array(
			'post_type'    => 'case_study',
			'post_status'  => 'publish',
			'post_title'   => $p[0],
			'post_excerpt' => $p[3],
			'post_content' => $block( 'The challenge', 'This is a sample project. Replace this text with the problem the client had, and why it mattered to the business.' )
				. $block( 'What we did', 'Describe the work step by step, in plain words. Add screenshots with the Gallery block.' )
				. $block( 'The result', 'Describe what changed for the client. Put the key numbers in the Project details form below the editor.' ),
		) );
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		update_post_meta( $id, '_emma_key', $key );
		update_post_meta( $id, 'emma_sample', 1 );
		update_post_meta( $id, 'emma_client', 'Sample client' );
		update_post_meta( $id, 'emma_industry', $p[4] );
		update_post_meta( $id, 'emma_year', gmdate( 'Y' ) );
		if ( isset( $terms[ $p[1] ] ) ) {
			wp_set_object_terms( $id, array( $terms[ $p[1] ] ), 'service' );
		}
		if ( isset( $images[ $p[2] ] ) ) {
			set_post_thumbnail( $id, $images[ $p[2] ]['id'] );
		}
		$log[] = 'Sample project created: ' . $p[0];
	}
}

function emma_core_setup_options( $images, $tpl_ids, &$log ) {
	if ( ! empty( $tpl_ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $tpl_ids['home'] );
		$log[] = 'Home set as the front page.';
	}
	if ( isset( $images['logo-color.png'] ) && ! get_theme_mod( 'custom_logo' ) ) {
		set_theme_mod( 'custom_logo', $images['logo-color.png']['id'] );
		$log[] = 'Site logo set.';
	}
	/* The client's favicon (2026-09-26). Replaces the first icon, but never one chosen by hand. */
	$icon = (int) get_option( 'site_icon' );
	$old  = isset( $images['sunflower.png'] ) ? $images['sunflower.png']['id'] : -1;
	if ( isset( $images['emma-favicon.png'] ) && ( ! $icon || $icon === $old ) ) {
		update_option( 'site_icon', $images['emma-favicon.png']['id'] );
		$log[] = 'Site icon set.';
	}
	if ( 'emmadigitalagency.com' === get_option( 'blogname' ) || '' === get_option( 'blogname' ) ) {
		update_option( 'blogname', 'Emma Digital Agency' );
		update_option( 'blogdescription', 'Make your ideas bloom' );
	}
	update_option( 'default_comment_status', 'closed' );
	update_option( 'default_ping_status', 'closed' );

	/* Elementor: self-hosted fonts only, and allow editing projects. */
	update_option( 'elementor_google_font', '0' );
	$cpt = (array) get_option( 'elementor_cpt_support', array( 'page', 'post' ) );
	update_option( 'elementor_cpt_support', array_values( array_unique( array_merge( $cpt, array( 'page' ) ) ) ) );
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );
	$log[] = 'Elementor set to use the self-hosted fonts (no Google Fonts requests).';
}
