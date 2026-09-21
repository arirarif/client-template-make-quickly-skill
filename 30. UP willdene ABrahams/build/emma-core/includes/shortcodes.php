<?php
/**
 * [emma_projects]: project cards from the Portfolio. Works with free Elementor
 * (Shortcode widget), so the homepage does not depend on the Pro Loop Grid.
 *
 *   [emma_projects count="3" layout="featured"]   one large card + two stacked (homepage)
 *   [emma_projects count="12" layout="grid"]      two columns
 *   [emma_projects count="2" layout="grid" service="seo-sem"]   only one Service
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'emma_projects', function ( $atts ) {
	$atts = shortcode_atts( array(
		'count'   => 3,
		'layout'  => 'featured',
		'service' => '',
	), $atts, 'emma_projects' );

	$args = array(
		'post_type'      => 'case_study',
		'post_status'    => 'publish',
		'posts_per_page' => max( 1, (int) $atts['count'] ),
		'orderby'        => array( 'date' => 'DESC', 'ID' => 'DESC' ),
		'no_found_rows'  => true,
	);
	if ( $atts['service'] ) {
		$args['tax_query'] = array( array( 'taxonomy' => 'service', 'field' => 'slug', 'terms' => sanitize_title( $atts['service'] ) ) );
	}
	$projects = get_posts( $args );
	if ( ! $projects ) {
		return '<p class="emma-projects-empty">No projects here yet. Please check back soon.</p>';
	}

	$layout = 'grid' === $atts['layout'] ? 'grid' : 'featured';
	$html   = '<div class="emma-projects emma-projects-' . esc_attr( $layout ) . '">';
	foreach ( $projects as $index => $project ) {
		$url    = get_permalink( $project );
		$terms  = get_the_terms( $project, 'service' );
		$labels = ( $terms && ! is_wp_error( $terms ) ) ? implode( ' · ', wp_list_pluck( $terms, 'name' ) ) : '';
		$sample = get_post_meta( $project->ID, 'emma_sample', true ) ? ' emma-is-sample' : '';
		$image  = get_the_post_thumbnail( $project, 0 === $index && 'featured' === $layout ? 'large' : 'medium_large', array(
			'loading' => 'lazy',
			'alt'     => get_the_title( $project ),
		) );

		$html .= '<article class="emma-project' . $sample . '">';
		$html .= '<a class="emma-project-image" href="' . esc_url( $url ) . '" tabindex="-1" aria-hidden="true">' . $image . '</a>';
		$html .= '<div class="emma-project-meta"><h3 class="emma-project-title"><a href="' . esc_url( $url ) . '">' . esc_html( get_the_title( $project ) ) . '</a></h3>';
		if ( $labels ) {
			$html .= '<span class="emma-project-terms">' . esc_html( $labels ) . '</span>';
		}
		$html .= '</div>';
		if ( has_excerpt( $project ) ) {
			$html .= '<p class="emma-project-excerpt">' . esc_html( get_the_excerpt( $project ) ) . '</p>';
		}
		$html .= '</article>';
	}
	return $html . '</div>';
} );
