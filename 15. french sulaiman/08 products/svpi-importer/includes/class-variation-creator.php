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
	 *   virtual:       bool    (no shipping — digital goods)
	 *   downloadable:  bool    (customer gets download links after purchase)
	 *   downloads:     array   [ { name: string, file: string } ] or [ "https://…" ]
	 *   download_limit:  int   (default -1 = unlimited)
	 *   download_expiry: int   (default -1 = never)
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

		// ── Digital goods (Download variation) ────────────────────────────
		// "Medium: Download" must be virtual (no shipping) + downloadable
		// (WooCommerce serves the files from My Account → Downloads).
		$is_virtual      = ! empty( $var_data['virtual'] );
		$is_downloadable = ! empty( $var_data['downloadable'] );

		$variation->set_virtual( $is_virtual );
		$variation->set_downloadable( $is_downloadable );

		if ( $is_downloadable ) {
			$downloads = [];

			foreach ( $var_data['downloads'] ?? [] as $entry ) {
				// Accept both "https://…" and { "name": "…", "file": "https://…" }.
				$file = is_array( $entry ) ? trim( (string) ( $entry['file'] ?? '' ) ) : trim( (string) $entry );
				if ( $file === '' ) {
					continue;
				}

				$label = is_array( $entry ) ? trim( (string) ( $entry['name'] ?? '' ) ) : '';
				if ( $label === '' ) {
					$label = basename( (string) wp_parse_url( $file, PHP_URL_PATH ) );
				}

				// Remote files must live in an approved download directory (WC 6.8+),
				// otherwise WooCommerce silently disables the download on save.
				$this->approve_download_dir( $file );

				$download = new WC_Product_Download();
				$download->set_id( md5( $file ) );
				$download->set_name( $label );
				$download->set_file( $file );
				$downloads[] = $download;
			}

			if ( $downloads ) {
				try {
					$variation->set_downloads( $downloads );
				} catch ( \Exception $e ) {
					// A rejected file must not abort the rest of the import —
					// the variation is still created, just without its file.
					$variation->set_downloads( [] );
				}
			}

			$variation->set_download_limit(
				isset( $var_data['download_limit'] ) ? (int) $var_data['download_limit'] : -1
			);
			$variation->set_download_expiry(
				isset( $var_data['download_expiry'] ) ? (int) $var_data['download_expiry'] : -1
			);
		}

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

	/**
	 * Register a remote download URL with WooCommerce's Approved Download
	 * Directories (WC 6.8+). Without this, WooCommerce accepts the file but
	 * disables the download link, so the customer buys nothing usable.
	 *
	 * Everything is guarded: on older WooCommerce versions, or if the internal
	 * API ever moves, the import continues untouched.
	 *
	 * @param string $url Download file URL.
	 * @return void
	 */
	private function approve_download_dir( string $url ): void {
		$class = '\Automattic\WooCommerce\Internal\ProductDownloads\ApprovedDirectories\Register';

		if ( ! function_exists( 'wc_get_container' ) || ! class_exists( $class ) ) {
			return;
		}

		try {
			$register = wc_get_container()->get( $class );

			if ( method_exists( $register, 'is_valid_path' ) && $register->is_valid_path( $url ) ) {
				return; // Already covered by an approved directory.
			}

			if ( ! method_exists( $register, 'add_approved_directory' ) ) {
				return;
			}

			// Approve the directory the file sits in, not the file itself.
			$parts = wp_parse_url( $url );
			if ( empty( $parts['scheme'] ) || empty( $parts['host'] ) ) {
				return;
			}
			$dir = $parts['scheme'] . '://' . $parts['host'];
			if ( ! empty( $parts['path'] ) ) {
				$dir .= rtrim( dirname( $parts['path'] ), '/\\' ) . '/';
			}

			$rule_id = $register->add_approved_directory( $dir );

			if ( $rule_id && method_exists( $register, 'enable_by_id' ) ) {
				$register->enable_by_id( (int) $rule_id );
			}
		} catch ( \Throwable $e ) {
			// Approved Directories is optional — never break the import over it.
			return;
		}
	}
}
