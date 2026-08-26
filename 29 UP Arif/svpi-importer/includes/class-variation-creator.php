<?php
/**
 * SVPI Variation Creator
 *
 * Creates WC_Product_Variation children under a variable product.
 * Links each variation to its specific color image via _thumbnail_id.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SVPI_Variation_Creator {

	/**
	 * Create all variations for a variable product.
	 *
	 * @param int                  $parent_id     WC variable product ID.
	 * @param array                $variations    Variation data from JSON.
	 * @param array                $attribute_map name => {taxonomy, term_ids}
	 * @param SVPI_Image_Handler   $image_handler
	 * @param bool                 $download_images
	 * @return int  Number of variations successfully created.
	 */
	public function create_all(
		int $parent_id,
		array $variations,
		array $attribute_map,
		SVPI_Image_Handler $image_handler,
		bool $download_images
	): int {
		$count = 0;
		foreach ( $variations as $var_data ) {
			$id = $this->create_variation( $parent_id, $var_data, $attribute_map, $image_handler, $download_images );
			if ( $id ) {
				$count++;
			}
		}
		return $count;
	}

	// ── Private ───────────────────────────────────────────────────────────────

	/**
	 * Create a single variation.
	 *
	 * @param int                $parent_id
	 * @param array              $var_data    {
	 *   sku:           string
	 *   regular_price: string
	 *   sale_price:    string  (optional)
	 *   stock_quantity: int|null
	 *   in_stock:      bool    (used when stock_quantity is null)
	 *   attributes:    array   { "Color": "Arctic White" }
	 *   image_url:     string  (variation-specific image)
	 * }
	 * @param array              $attribute_map
	 * @param SVPI_Image_Handler $image_handler
	 * @param bool               $download_images
	 * @return int  Variation ID or 0 on failure.
	 */
	private function create_variation(
		int $parent_id,
		array $var_data,
		array $attribute_map,
		SVPI_Image_Handler $image_handler,
		bool $download_images
	): int {
		$variation = new WC_Product_Variation();
		$variation->set_parent_id( $parent_id );
		$variation->set_status( 'publish' );

		// ── SKU ───────────────────────────────────────────────────────────
		$sku = trim( $var_data['sku'] ?? '' );
		if ( $sku && ! wc_get_product_id_by_sku( $sku ) ) {
			$variation->set_sku( $sku );
		}

		// ── Pricing ───────────────────────────────────────────────────────
		$variation->set_regular_price( (string) ( $var_data['regular_price'] ?? '' ) );
		if ( ! empty( $var_data['sale_price'] ) ) {
			$variation->set_sale_price( (string) $var_data['sale_price'] );
		}

		// ── Stock ─────────────────────────────────────────────────────────
		$stock_qty = $var_data['stock_quantity'] ?? null;
		if ( $stock_qty !== null ) {
			$variation->set_manage_stock( true );
			$variation->set_stock_quantity( (int) $stock_qty );
			$variation->set_stock_status( $stock_qty > 0 ? 'instock' : 'outofstock' );
		} else {
			$variation->set_manage_stock( false );
			$variation->set_stock_status( ( $var_data['in_stock'] ?? true ) ? 'instock' : 'outofstock' );
		}

		// ── Attributes ────────────────────────────────────────────────────
		// WooCommerce expects: [ 'pa_color' => 'arctic-white' ]
		// (taxonomy slug => term slug)
		$attrs = [];
		foreach ( $var_data['attributes'] ?? [] as $attr_name => $attr_value ) {
			if ( ! isset( $attribute_map[ $attr_name ] ) ) {
				continue;
			}

			$map      = $attribute_map[ $attr_name ];
			$taxonomy = $map['taxonomy'];
			$term_id  = $map['term_ids'][ $attr_value ] ?? 0;

			if ( ! $term_id ) {
				continue;
			}

			$term = get_term( $term_id, $taxonomy );
			if ( $term && ! is_wp_error( $term ) ) {
				$attrs[ $taxonomy ] = $term->slug;
			}
		}
		$variation->set_attributes( $attrs );

		// ── Save ──────────────────────────────────────────────────────────
		$variation_id = $variation->save();
		if ( ! $variation_id ) {
			return 0;
		}

		// ── Variation image ───────────────────────────────────────────────
		// Each color variation gets its own thumbnail so clicking the swatch
		// swaps the main product image in WoodMart.
		if ( $download_images && ! empty( $var_data['image_url'] ) ) {
			$attachment_id = $image_handler->upload_from_url( $var_data['image_url'], $parent_id );
			if ( $attachment_id ) {
				update_post_meta( $variation_id, '_thumbnail_id', $attachment_id );
			}
		}

		return $variation_id;
	}
}
