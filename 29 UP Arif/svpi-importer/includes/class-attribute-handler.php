<?php
/**
 * SVPI Attribute Handler
 *
 * Creates WooCommerce global attributes and their terms.
 * Sets WoodMart color swatch meta on color-type attribute terms.
 *
 * WoodMart swatch term meta keys:
 *   'color'                   → hex code  (e.g. "#FFFFFF")
 *   'type'                    → 'color'
 *   'product_attribute_color' → hex code  (internal WoodMart key, for compatibility)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SVPI_Attribute_Handler {

	/** @var array Taxonomy existence cache to avoid repeated DB lookups */
	private array $attribute_id_cache = [];

	/**
	 * Ensure a global WC attribute exists and all its terms are created.
	 *
	 * @param array $attr_data {
	 *   name:    string       Attribute label, e.g. "Color"
	 *   type:    string       'color' | 'text' | 'image'
	 *   options: array        For color: [{ value, color_code }]
	 *                         For text:  [{ value }]
	 * }
	 * @return array {
	 *   attribute_id: int
	 *   taxonomy:     string   e.g. 'pa_color'
	 *   term_ids:     array    option_value => term_id
	 * }
	 * @throws Exception on unrecoverable failure.
	 */
	public function ensure_attribute( array $attr_data ): array {
		$name    = trim( $attr_data['name'] );
		$type    = $attr_data['type'] ?? 'text';   // 'color' | 'text' | 'image'
		$options = $attr_data['options'] ?? [];

		// ── Derive slug + taxonomy ────────────────────────────────────────
		// Explicit ASCII slug from JSON wins — needed for non-Latin attribute
		// names (e.g. Chinese), which percent-encode into broken taxonomy slugs.
		$slug = ! empty( $attr_data['slug'] )
			? wc_sanitize_taxonomy_name( $attr_data['slug'] )
			: wc_sanitize_taxonomy_name( $name );
		if ( strlen( $slug ) > 28 ) {
			$slug = substr( $slug, 0, 28 );
		}
		$taxonomy = 'pa_' . $slug;

		// ── Create global attribute if it doesn't exist ───────────────────
		$attribute_id = $this->get_or_create_global_attribute( $name, $slug );

		// ── Register taxonomy in this PHP request ─────────────────────────
		// WC registers attribute taxonomies at init, but freshly created ones
		// need manual registration so term functions work in the same request.
		if ( ! taxonomy_exists( $taxonomy ) ) {
			register_taxonomy( $taxonomy, 'product', [
				'hierarchical' => false,
				'show_ui'      => false,
				'query_var'    => true,
				'rewrite'      => false,
			] );
		}

		// ── Create / fetch terms ──────────────────────────────────────────
		$term_ids = [];
		foreach ( $options as $option ) {
			$value      = trim( $option['value'] ?? '' );
			$color_code = isset( $option['color_code'] ) ? trim( $option['color_code'] ) : null;

			if ( $value === '' ) {
				continue;
			}

			$term = get_term_by( 'name', $value, $taxonomy );

			if ( ! $term ) {
				$result = wp_insert_term( $value, $taxonomy );
				if ( is_wp_error( $result ) ) {
					continue;
				}
				$term_id = (int) $result['term_id'];
			} else {
				$term_id = (int) $term->term_id;
			}

			$term_ids[ $value ] = $term_id;

			// ── WoodMart color swatch meta ────────────────────────────────
			if ( $type === 'color' && $color_code ) {
				$hex = $this->normalise_hex( $color_code );
				// Key 1 & 2 — as specified in SVPI docs
				update_term_meta( $term_id, 'color', $hex );
				update_term_meta( $term_id, 'type',  'color' );
				// Key 3 — WoodMart internal key (compatibility)
				update_term_meta( $term_id, 'product_attribute_color', $hex );
			}
		}

		return [
			'attribute_id' => $attribute_id,
			'taxonomy'     => $taxonomy,
			'term_ids'     => $term_ids,  // 'Arctic White' => 42
		];
	}

	// ── Private helpers ───────────────────────────────────────────────────────

	/**
	 * Get or create a WooCommerce global attribute definition.
	 * WC stores these in the woocommerce_attribute_taxonomies option / table.
	 *
	 * @param string $label Human-readable name, e.g. "Color"
	 * @param string $slug  Sanitized slug without pa_, e.g. "color"
	 * @return int  Attribute ID
	 * @throws Exception
	 */
	private function get_or_create_global_attribute( string $label, string $slug ): int {
		if ( isset( $this->attribute_id_cache[ $slug ] ) ) {
			return $this->attribute_id_cache[ $slug ];
		}

		// wc_attribute_taxonomy_id_by_name expects the slug without 'pa_'
		$attribute_id = wc_attribute_taxonomy_id_by_name( $slug );

		if ( ! $attribute_id ) {
			$attribute_id = wc_create_attribute( [
				'name'         => $label,
				'slug'         => $slug,
				'type'         => 'select',    // WC type — WoodMart overrides display via swatch meta
				'order_by'     => 'menu_order',
				'has_archives' => false,
			] );

			if ( is_wp_error( $attribute_id ) ) {
				throw new Exception( "Failed to create attribute '{$label}': " . $attribute_id->get_error_message() );
			}

			// Flush WC attribute caches after creation
			delete_transient( 'wc_attribute_taxonomies' );
			if ( class_exists( 'WC_Cache_Helper' ) ) {
				WC_Cache_Helper::invalidate_cache_group( 'woocommerce-attributes' );
			}
		}

		$this->attribute_id_cache[ $slug ] = (int) $attribute_id;
		return (int) $attribute_id;
	}

	/**
	 * Ensure a filter-only attribute and its terms exist.
	 *
	 * Convenience wrapper around ensure_attribute() for non-variation attributes.
	 * Accepts a plain string array instead of [{value, color_code}] objects.
	 * Always creates a text-type attribute (no swatch meta).
	 *
	 * @param string   $name   Attribute label, e.g. "Geschlecht"
	 * @param string[] $values Plain term values, e.g. ["Herren"]
	 * @return array { attribute_id, taxonomy, term_ids }
	 * @throws Exception
	 */
	public function ensure_filter_attribute( string $name, array $values ): array {
		$options = array_values(
			array_map(
				fn( string $v ) => [ 'value' => $v ],
				array_filter( $values, fn( $v ) => trim( $v ) !== '' )
			)
		);

		return $this->ensure_attribute( [
			'name'    => $name,
			'type'    => 'text',
			'options' => $options,
		] );
	}

	/**
	 * Ensure hex code has a # prefix and is uppercase.
	 *
	 * @param string $hex Raw value, e.g. "ffffff" or "#FFFFFF"
	 * @return string     Normalised, e.g. "#FFFFFF"
	 */
	private function normalise_hex( string $hex ): string {
		$hex = ltrim( $hex, '#' );
		return '#' . strtoupper( $hex );
	}
}
