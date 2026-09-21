<?php
/**
 * Portfolio: the "case_study" post type, the "service" taxonomy and the
 * "Project details" form.
 *
 * URLs: /portfolio/project-name/ for one project, /service/seo-sem/ for one
 * service. The /portfolio/ overview itself is a normal Elementor page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** The fields of the "Project details" form: meta key => array( label, type, help ). */
function emma_core_project_fields() {
	return array(
		'emma_client'          => array( 'Client name', 'text', '' ),
		'emma_industry'        => array( 'Industry', 'text', 'For example: Hospitality, Retail, Health.' ),
		'emma_year'            => array( 'Year', 'text', '' ),
		'emma_live_url'        => array( 'Live website link', 'url', 'Starts with https://' ),
		'emma_result_1_number' => array( 'Result 1: number', 'text', 'For example: +42% or 3x. Leave empty to hide.' ),
		'emma_result_1_label'  => array( 'Result 1: what it measures', 'text', 'For example: more enquiries in 3 months.' ),
		'emma_result_2_number' => array( 'Result 2: number', 'text', '' ),
		'emma_result_2_label'  => array( 'Result 2: what it measures', 'text', '' ),
		'emma_result_3_number' => array( 'Result 3: number', 'text', '' ),
		'emma_result_3_label'  => array( 'Result 3: what it measures', 'text', '' ),
		'emma_quote'           => array( 'Client quote', 'textarea', 'Only use real quotes. Leave empty to hide.' ),
		'emma_quote_name'      => array( 'Quote: name', 'text', '' ),
		'emma_quote_role'      => array( 'Quote: role and company', 'text', '' ),
	);
}

function emma_core_register_content_types() {
	register_post_type( 'case_study', array(
		'labels'       => array(
			'name'          => 'Portfolio',
			'singular_name' => 'Project',
			'add_new'       => 'Add project',
			'add_new_item'  => 'Add new project',
			'edit_item'     => 'Edit project',
			'all_items'     => 'All projects',
			'view_item'     => 'View project',
			'search_items'  => 'Search projects',
			'not_found'     => 'No projects found',
		),
		'public'       => true,
		'has_archive'  => false,
		'menu_icon'    => 'dashicons-portfolio',
		'menu_position' => 20,
		'show_in_rest' => true,
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions' ),
		'rewrite'      => array( 'slug' => 'portfolio', 'with_front' => false ),
		'template'     => array(
			array( 'core/heading', array( 'content' => 'The challenge' ) ),
			array( 'core/paragraph', array( 'placeholder' => 'What was the problem, and why did it matter to the client?' ) ),
			array( 'core/heading', array( 'content' => 'What we did' ) ),
			array( 'core/paragraph', array( 'placeholder' => 'The work, step by step, in plain words.' ) ),
			array( 'core/heading', array( 'content' => 'The result' ) ),
			array( 'core/paragraph', array( 'placeholder' => 'What changed for the client. Add screenshots with the Gallery block.' ) ),
		),
	) );

	register_taxonomy( 'service', array( 'case_study' ), array(
		'labels'            => array(
			'name'          => 'Services',
			'singular_name' => 'Service',
			'all_items'     => 'All services',
			'edit_item'     => 'Edit service',
			'add_new_item'  => 'Add new service',
			'menu_name'     => 'Services',
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'service', 'with_front' => false ),
	) );

	foreach ( emma_core_project_fields() as $key => $field ) {
		register_post_meta( 'case_study', $key, array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'url' === $field[1] ? 'esc_url_raw' : ( 'textarea' === $field[1] ? 'sanitize_textarea_field' : 'sanitize_text_field' ),
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		) );
	}
	register_post_meta( 'case_study', 'emma_sample', array(
		'type'              => 'boolean',
		'single'            => true,
		'show_in_rest'      => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
	) );
}
add_action( 'init', 'emma_core_register_content_types' );

/* ---- the "Project details" form ------------------------------------------ */

add_action( 'add_meta_boxes_case_study', function () {
	add_meta_box( 'emma-project-details', 'Project details', 'emma_core_render_project_box', 'case_study', 'normal', 'high' );
} );

function emma_core_render_project_box( $post ) {
	wp_nonce_field( 'emma_project_details', 'emma_project_nonce' );
	echo '<p>Fill in what you have. Empty fields are simply not shown on the page.</p>';
	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( emma_core_project_fields() as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );
		printf( '<tr><th scope="row"><label for="%1$s">%2$s</label></th><td>', esc_attr( $key ), esc_html( $field[0] ) );
		if ( 'textarea' === $field[1] ) {
			printf( '<textarea id="%1$s" name="%1$s" rows="3" class="large-text">%2$s</textarea>', esc_attr( $key ), esc_textarea( $value ) );
		} else {
			printf( '<input type="%3$s" id="%1$s" name="%1$s" value="%2$s" class="regular-text">', esc_attr( $key ), esc_attr( $value ), esc_attr( $field[1] ) );
		}
		if ( $field[2] ) {
			printf( '<p class="description">%s</p>', esc_html( $field[2] ) );
		}
		echo '</td></tr>';
	}
	printf(
		'<tr><th scope="row">Sample project</th><td><label><input type="checkbox" name="emma_sample" value="1" %s> This is an example, not real client work (shows a "Sample project" label)</label></td></tr>',
		checked( (bool) get_post_meta( $post->ID, 'emma_sample', true ), true, false )
	);
	echo '</tbody></table>';
}

add_action( 'save_post_case_study', function ( $post_id ) {
	if ( ! isset( $_POST['emma_project_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['emma_project_nonce'] ), 'emma_project_details' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( emma_core_project_fields() as $key => $field ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitised by the registered meta callback.
		if ( '' === trim( $raw ) ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $raw );
		}
	}
	if ( empty( $_POST['emma_sample'] ) ) {
		delete_post_meta( $post_id, 'emma_sample' );
	} else {
		update_post_meta( $post_id, 'emma_sample', 1 );
	}
} );

/* ---- "Sample project" label ---------------------------------------------- */

add_filter( 'post_class', function ( $classes, $extra, $post_id ) {
	if ( 'case_study' === get_post_type( $post_id ) && get_post_meta( $post_id, 'emma_sample', true ) ) {
		$classes[] = 'emma-is-sample';
	}
	return $classes;
}, 10, 3 );

add_filter( 'body_class', function ( $classes ) {
	if ( is_singular( 'case_study' ) && get_post_meta( get_queried_object_id(), 'emma_sample', true ) ) {
		$classes[] = 'emma-is-sample';
	}
	return $classes;
} );

/*
 * Empty project fields are not shown.
 * In the Elementor "Single project" template, an element with the CSS class
 * emma-if-FIELD (for example emma-if-emma_quote) is skipped when that field
 * of the current project is empty.
 */
function emma_core_should_render( $render, $element ) {
	$settings = $element->get_settings();
	$classes  = ( isset( $settings['css_classes'] ) ? $settings['css_classes'] : '' ) . ' ' . ( isset( $settings['_css_classes'] ) ? $settings['_css_classes'] : '' );
	if ( false === strpos( $classes, 'emma-if-' ) || ! is_singular( 'case_study' ) ) {
		return $render;
	}
	if ( preg_match_all( '/emma-if-([a-z0-9_]+)/', $classes, $found ) ) {
		foreach ( $found[1] as $key ) {
			if ( '' === trim( (string) get_post_meta( get_queried_object_id(), $key, true ) ) ) {
				return false;
			}
		}
	}
	return $render;
}
add_filter( 'elementor/frontend/container/should_render', 'emma_core_should_render', 10, 2 );
add_filter( 'elementor/frontend/widget/should_render', 'emma_core_should_render', 10, 2 );
