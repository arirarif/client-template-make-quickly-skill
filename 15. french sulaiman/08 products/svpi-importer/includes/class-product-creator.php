<?php
/**
 * SVPI Product Creator
 *
 * Orchestrates the full import for each product:
 *   1. Create / get global attributes + terms (with WoodMart swatch meta)
 *   2. Download gallery images
 *   3. Create WC_Product_Variable
 *   4. Create all variations via SVPI_Variation_Creator
 *   5. Sync variable product min/max prices
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SVPI_Product_Creator {

	private bool                   $skip_existing;
	private bool                   $download_images;
	private SVPI_Attribute_Handler $attr_handler;
	private SVPI_Image_Handler     $image_handler;
	private SVPI_Variation_Creator $var_creator;

	private array $log   = [];
	private array $stats = [
		'created'    => 0,
		'updated'    => 0,
		'skipped'    => 0,
		'errors'     => 0,
		'variations' => 0,
		'images'     => 0,
	];

	public function __construct( bool $skip_existing = true, bool $download_images = true ) {
		$this->skip_existing   = $skip_existing;
		$this->download_images = $download_images;
		$this->attr_handler    = new SVPI_Attribute_Handler();
		$this->image_handler   = new SVPI_Image_Handler();
		$this->var_creator     = new SVPI_Variation_Creator();
	}

	/**
	 * Import all products from the parsed JSON.
	 *
	 * @param array $products Array of product data arrays.
	 * @return array { stats: array, log: array }
	 */
	public function import_all( array $products ): array {
		// Give the import plenty of time — image downloads can be slow
		@set_time_limit( 0 );

		foreach ( $products as $product_data ) {
			$this->import_product( $product_data );
		}

		// Every product now exists, so the parked SKUs can be resolved.
		foreach ( self::resolve_pending_upsells() as $line ) {
			$this->log[] = $line;
		}

		return [
			'stats' => $this->stats,
			'log'   => $this->log,
		];
	}

	/**
	 * Second pass: turn parked upsell SKUs into product ids.
	 *
	 * Runs only once the whole batch exists, because an arch references
	 * accessories that may be imported after it. Static so the AJAX batch
	 * endpoint — which builds a fresh creator per product — can call it at
	 * the end of the run.
	 *
	 * A SKU that never appears is reported rather than silently dropped: a
	 * missing accessory means the option box on that rental is short an
	 * entry, which is invisible until a customer looks for it.
	 *
	 * @return array log lines
	 */
	public static function resolve_pending_upsells(): array {
		$log = [];

		$pending = get_posts( [
			'post_type'      => 'product',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'meta_key'       => '_svpi_pending_upsells',
			'no_found_rows'  => true,
		] );

		foreach ( $pending as $product_id ) {
			$raw  = get_post_meta( $product_id, '_svpi_pending_upsells', true );
			$skus = json_decode( (string) $raw, true );
			delete_post_meta( $product_id, '_svpi_pending_upsells' );

			if ( ! is_array( $skus ) || ! $skus ) {
				continue;
			}

			$ids     = [];
			$missing = [];
			foreach ( $skus as $sku ) {
				$id = wc_get_product_id_by_sku( $sku );
				if ( $id ) {
					$ids[] = (int) $id;
				} else {
					$missing[] = $sku;
				}
			}

			$product = wc_get_product( $product_id );
			if ( $product && $ids ) {
				$product->set_upsell_ids( $ids );
				$product->save();
			}

			$log[] = [
				'type'    => 'upsells',
				'message' => sprintf(
					'Upsells for #%d: %d linked%s',
					$product_id,
					count( $ids ),
					$missing ? ' — SKU NOT FOUND: ' . implode( ', ', $missing ) : ''
				),
			];
		}

		return $log;
	}

	/**
	 * Import a single product. Used by the AJAX progress-bar endpoint.
	 *
	 * @param array $product_data
	 * @return array { stats: array, log: array }
	 */
	public function import_single( array $product_data ): array {
		$this->import_product( $product_data );

		return [
			'stats' => $this->stats,
			'log'   => $this->log,
		];
	}

	// ── Private ───────────────────────────────────────────────────────────────

	private function import_product( array $data ): void {
		$name = $data['name'] ?? '(no name)';
		$sku  = trim( $data['sku'] ?? '' );

		// ── Product type ────────────────────────────────────────────────────────────
		// Explicit "type" wins; otherwise: has variations => variable, else simple.
		$type        = strtolower( trim( (string) ( $data['type'] ?? '' ) ) );
		$has_variations = ! empty( $data['variations'] );
		$is_variable = ( $type === 'variable' ) || ( $type === '' && $has_variations );

		// ── Skip / Update check ────────────────────────────────────────────────────
		$existing_id = $sku ? (int) wc_get_product_id_by_sku( $sku ) : 0;
		$update_mode = false;

		if ( $existing_id ) {
			if ( $this->skip_existing ) {
				$this->stats['skipped']++;
				$this->log[] = [ 'type' => 'skip', 'message' => "Skipped (exists): {$name} (SKU: {$sku})" ];
				return;
			}
			$update_mode = true;
		}

		try {
			// ── 1. Ensure variation attributes + terms (variable only) ──────────
			$attribute_map = [];  // attr_name => { attribute_id, taxonomy, term_ids }
			if ( $is_variable ) {
				foreach ( $data['attributes'] ?? [] as $attr ) {
					$result = $this->attr_handler->ensure_attribute( $attr );
					$attribute_map[ $attr['name'] ] = $result;
					$this->log[] = [
						'type'    => 'attr',
						'message' => "Attribute: {$attr['name']} ({$result['taxonomy']}) — " . count( $result['term_ids'] ) . ' terms',
					];
				}
			}

			// ── 1b. Ensure filter attributes + terms ────────────────────────────
			// filter_attributes drive sidebar facets (FacetWP / WC Layered Nav).
			// They are NOT variation attributes — set_variation = false.
			$filter_attribute_map = [];  // attr_name => { attribute_id, taxonomy, term_ids }
			foreach ( $data['filter_attributes'] ?? [] as $fattr ) {
				$fname  = trim( $fattr['name']   ?? '' );
				$fvals  = $fattr['values'] ?? [];
				if ( $fname === '' || empty( $fvals ) ) {
					continue;
				}
				$result = $this->attr_handler->ensure_filter_attribute( $fname, $fvals );
				$filter_attribute_map[ $fname ] = $result;
			}

			// ── 2. Download gallery images ────────────────────────────────
			$gallery_attachment_ids = [];
			if ( $this->download_images ) {
				foreach ( $data['gallery_images'] ?? [] as $url ) {
					$attachment_id = $this->image_handler->upload_from_url( $url );
					if ( $attachment_id ) {
						$gallery_attachment_ids[] = $attachment_id;
						$this->stats['images']++;
					} else {
						// Never fail silently — a missing bundled file or a dead URL
						// used to look exactly like "images just didn't import".
						$this->log[] = [
							'type'    => 'error',
							'message' => "Image FAILED for {$name}: {$url}"
								. ( preg_match( '#^https?://#i', $url )
									? ' (download failed)'
									: ' (not found in the plugin folder — is the plugin zip up to date?)' ),
						];
					}
				}
			} elseif ( ! empty( $data['gallery_images'] ) ) {
				$this->log[] = [
					'type'    => 'skip',
					'message' => "Images skipped for {$name} — the \"Download and upload images\" option is off.",
				];
			}

			// ── 3. Create / load product (variable or simple) ─────────────────────
			if ( $update_mode ) {
				$product = wc_get_product( $existing_id );
				if ( $is_variable && ! $product instanceof WC_Product_Variable ) {
					throw new \Exception( "Existing product ID {$existing_id} is not a variable product." );
				}
			} else {
				$product = $is_variable ? new WC_Product_Variable() : new WC_Product_Simple();
			}
			$product->set_name( $name );
			$product->set_status( 'publish' );
			$product->set_catalog_visibility( 'visible' );
			$product->set_description( $this->build_description_html( $data ) );
			$product->set_short_description( $data['short_description'] ?? '' );
			$product->set_stock_status( 'instock' );

			if ( $sku ) {
				$product->set_sku( $sku );
			}

			// ── Simple product: price + stock quantity ────────────────────────────
			if ( ! $is_variable ) {
				if ( isset( $data['regular_price'] ) && $data['regular_price'] !== '' ) {
					$product->set_regular_price( (string) $data['regular_price'] );
				}
				if ( ! empty( $data['sale_price'] ) ) {
					$product->set_sale_price( (string) $data['sale_price'] );
				}
				$stock_qty = $data['stock_quantity'] ?? null;
				if ( $stock_qty !== null && $stock_qty !== '' ) {
					$product->set_manage_stock( true );
					$product->set_stock_quantity( (int) $stock_qty );
					$product->set_stock_status( (int) $stock_qty > 0 ? 'instock' : 'outofstock' );
				}
			}

			// Categories — supports both legacy flat strings and new hierarchical objects.
			//
			// Legacy:       ["T-Shirts", "Herren"]            → flat, no parent
			// Hierarchical: [{"name":"Bekleidung"}, {"name":"T-Shirts","parent":"Bekleidung"}, {"name":"Herren","parent":"T-Shirts"}]
			if ( ! empty( $data['categories'] ) ) {
				$cat_ids = [];
				// Build a name → term_id lookup so child entries can reference their parent
				$cat_name_to_id = [];

				foreach ( $data['categories'] as $cat_entry ) {
					// Normalise: string → {"name": string}, object stays as-is
					if ( is_string( $cat_entry ) ) {
						$cat_entry = [ 'name' => $cat_entry ];
					}

					$cat_name   = trim( $cat_entry['name'] ?? '' );
					$parent_name = trim( $cat_entry['parent'] ?? '' );
					$parent_id   = 0;

					// Resolve parent term ID (from a previous iteration or existing WC category)
					if ( $parent_name ) {
						if ( isset( $cat_name_to_id[ $parent_name ] ) ) {
							$parent_id = $cat_name_to_id[ $parent_name ];
						} else {
							$parent_term = get_term_by( 'name', $parent_name, 'product_cat' );
							if ( $parent_term ) {
								$parent_id = (int) $parent_term->term_id;
							}
						}
					}

					$cat_id = $this->get_or_create_category( $cat_name, $parent_id );
					if ( $cat_id ) {
						$cat_ids[] = $cat_id;
						$cat_name_to_id[ $cat_name ] = $cat_id;
					}
				}
				if ( $cat_ids ) {
					$product->set_category_ids( $cat_ids );
				}
			}

			// Build WC_Product_Attribute objects
			// Variation attributes drive the variation selector (Color swatch + Size dropdown).
			$wc_attributes = [];
			if ( $is_variable ) {
				foreach ( $data['attributes'] ?? [] as $attr ) {
					$map = $attribute_map[ $attr['name'] ];

					$wc_attr = new WC_Product_Attribute();
					$wc_attr->set_id( $map['attribute_id'] );
					$wc_attr->set_name( $map['taxonomy'] );
					$wc_attr->set_options( array_values( $map['term_ids'] ) );
					$wc_attr->set_visible( true );
					$wc_attr->set_variation( true );
					$wc_attributes[] = $wc_attr;
				}
			}

			// Filter attributes — visible in product page specs, NOT on variation dropdowns.
			// Drive FacetWP / WC Layered Nav sidebars.
			foreach ( $filter_attribute_map as $fname => $map ) {
				$wc_attr = new WC_Product_Attribute();
				$wc_attr->set_id( $map['attribute_id'] );
				$wc_attr->set_name( $map['taxonomy'] );
				$wc_attr->set_options( array_values( $map['term_ids'] ) );
				$wc_attr->set_visible( true );
				$wc_attr->set_variation( false );
				$wc_attributes[] = $wc_attr;
			}
			$product->set_attributes( $wc_attributes );

			// ── Save parent product ───────────────────────────────────────
			$product_id = $product->save();
			if ( ! $product_id ) {
				throw new \Exception( 'WC_Product_Variable::save() returned 0.' );
			}

			// Tags (must be set after save to have a post ID)
			if ( ! empty( $data['tags'] ) && is_array( $data['tags'] ) ) {
				wp_set_object_terms( $product_id, $data['tags'], 'product_tag' );
			}

			/*
			 * ── Custom meta ───────────────────────────────────────────────
			 * Needed by the Noor child theme, which stores its rental rules
			 * in post meta: _noor_block_price / _noor_block_days (the
			 * 25 € / 4 jours forfait), _noor_deposit_amount (the 50 € cash
			 * deposit), _noor_option_pricing (flat | per_day) and
			 * _noor_option_combo (the "les 2 = 25 €" pair price).
			 *
			 * Without this every rental had to be re-configured by hand
			 * after each import.
			 */
			if ( ! empty( $data['meta'] ) && is_array( $data['meta'] ) ) {
				foreach ( $data['meta'] as $meta_key => $meta_value ) {
					$meta_key = sanitize_key( (string) $meta_key );
					if ( '' === $meta_key ) {
						continue;
					}
					update_post_meta( $product_id, $meta_key, is_scalar( $meta_value ) ? wc_clean( (string) $meta_value ) : $meta_value );
				}
				$this->log[] = [
					'type'    => 'meta',
					'message' => 'Meta: ' . implode( ', ', array_keys( $data['meta'] ) ),
				];
			}

			/*
			 * ── Upsells, deferred ─────────────────────────────────────────
			 * Upsells are what the theme reads to decide which accessories
			 * appear under which rental. They CANNOT be resolved here: an
			 * arch references accessories that may be created later in the
			 * same run, so their SKUs do not exist yet.
			 *
			 * The SKUs are parked in a temporary meta key and resolved by
			 * resolve_pending_upsells() once every product exists.
			 */
			if ( ! empty( $data['upsell_skus'] ) && is_array( $data['upsell_skus'] ) ) {
				$skus = array_values( array_filter( array_map( 'trim', array_map( 'strval', $data['upsell_skus'] ) ) ) );
				if ( $skus ) {
					update_post_meta( $product_id, '_svpi_pending_upsells', wp_json_encode( $skus ) );
				}
			}

			// Brand (→ product_brand taxonomy)
			$brand = trim( $data['brand'] ?? '' );
			if ( $brand ) {
				wp_set_object_terms( $product_id, $brand, 'product_brand' );
				$this->log[] = [
					'type'    => 'brand',
					'message' => "Brand: {$brand}",
				];
			}

			// ── Assign gallery images ─────────────────────────────────────
			if ( ! empty( $gallery_attachment_ids ) ) {
				set_post_thumbnail( $product_id, $gallery_attachment_ids[0] );
				if ( count( $gallery_attachment_ids ) > 1 ) {
					update_post_meta(
						$product_id,
						'_product_image_gallery',
						implode( ',', array_slice( $gallery_attachment_ids, 1 ) )
					);
				}
			}

			// ── 4. Create variations (variable products only) ──────────────
			$var_count = 0;
			if ( $is_variable ) {
				// In update mode, delete old variations first to avoid duplicates.
				if ( $update_mode ) {
					foreach ( $product->get_children() as $old_var_id ) {
						wp_delete_post( (int) $old_var_id, true );
					}
				}
				$var_count = $this->var_creator->create_all(
					$product_id,
					$data['variations'] ?? [],
					$attribute_map,
					$this->image_handler,
					$this->download_images
				);
				$this->stats['variations'] += $var_count;

				// ── 5. Sync variable product prices ───────────────────────────
				// This sets the min/max price displayed in shop archives.
				WC_Product_Variable::sync( $product_id );
			}

			if ( $update_mode ) {
				$this->stats['updated']++;
				$this->log[] = [
					'type'    => 'update',
					'message' => "Updated: {$name} (ID: {$product_id}) — {$var_count} variations",
				];
			} else {
				$this->stats['created']++;
				$this->log[] = [
					'type'    => 'product',
					'message' => "Created: {$name} (ID: {$product_id}) — {$var_count} variations",
				];
			}

		} catch ( \Exception $e ) {
			$this->stats['errors']++;
			$this->log[] = [
				'type'    => 'error',
				'message' => "Error on '{$name}': " . $e->getMessage(),
			];
		}
	}

	/**
	 * Get or create a product category term, optionally under a parent.
	 *
	 * When parent_id is provided, the lookup checks for a term with the
	 * exact name AND parent — so "Herren" under "T-Shirts" won't collide
	 * with "Herren" under "Poloshirts".
	 *
	 * @param string $name      Category name.
	 * @param int    $parent_id Parent term ID (0 = top-level).
	 * @return int|null Term ID or null on failure.
	 */
	private function get_or_create_category( string $name, int $parent_id = 0 ): ?int {
		if ( empty( $name ) ) {
			return null;
		}

		// Look for existing term with the same name AND parent
		$existing = get_terms( [
			'taxonomy'   => 'product_cat',
			'name'       => $name,
			'parent'     => $parent_id,
			'hide_empty' => false,
			'number'     => 1,
		] );
		if ( ! is_wp_error( $existing ) && ! empty( $existing ) ) {
			return (int) $existing[0]->term_id;
		}

		// Fallback: match by name only (any parent) to avoid duplicates
		$term = get_term_by( 'name', $name, 'product_cat' );
		if ( $term && (int) $term->parent === $parent_id ) {
			return (int) $term->term_id;
		}

		// Create new term under the specified parent
		$result = wp_insert_term( $name, 'product_cat', [ 'parent' => $parent_id ] );
		return is_wp_error( $result ) ? null : (int) $result['term_id'];
	}

	/**
	 * Build the full product description HTML.
	 *
	 * Order:
	 *   1. Intro text          (artikeldetails.intro)
	 *   2. Feature bullets     (artikeldetails.bullets)
	 *   3. Specs table         (artikeldetails.specs)
	 *   4. Raw fallback        (description, only when artikeldetails is empty)
	 *   5. PDF download button (pdf_url)
	 *   6. Textildruck section (textildruck.methods + positions + generic steps)
	 *
	 * @param array $data Product data array from JSON.
	 * @return string Safe HTML string.
	 */
	private function build_description_html( array $data ): string {
		// Pre-rendered HTML description wins over everything else.
		// Used by imports whose source already provides rich HTML (e.g. Squarespace).
		$raw_html = trim( $data['description_html'] ?? '' );
		if ( $raw_html ) {
			return wp_kses_post( $raw_html );
		}

		$html = '';
		$ad   = $data['artikeldetails'] ?? [];

		// ── 1. Intro paragraph ────────────────────────────────────────────
		$intro = trim( $ad['intro'] ?? '' );
		if ( $intro ) {
			$html .= '<p>' . esc_html( $intro ) . '</p>';
		}

		// ── 2. Feature bullet list ────────────────────────────────────────
		$bullets = $ad['bullets'] ?? [];
		if ( ! empty( $bullets ) ) {
			$html .= '<ul class="svpi-features">';
			foreach ( $bullets as $bullet ) {
				$html .= '<li>' . esc_html( trim( $bullet ) ) . '</li>';
			}
			$html .= '</ul>';
		}

		// ── 3. Specs table ────────────────────────────────────────────────
		$specs = $ad['specs'] ?? [];
		if ( ! empty( $specs ) ) {
			$html .= '<table class="svpi-specs"><tbody>';
			foreach ( $specs as $key => $val ) {
				$html .= '<tr><th>' . esc_html( $key ) . '</th><td>' . esc_html( $val ) . '</td></tr>';
			}
			$html .= '</tbody></table>';
		}

		// ── 4. Fallback: raw description if artikeldetails was empty ───────
		if ( empty( $intro ) && empty( $bullets ) && empty( $specs ) ) {
			$raw = trim( $data['description'] ?? '' );
			if ( $raw ) {
				$html .= wpautop( esc_html( $raw ) );
			}
		}

		// ── 5. PDF download button ────────────────────────────────────────
		$pdf_url = trim( $data['pdf_url'] ?? '' );
		if ( $pdf_url ) {
			$html .= '<p class="svpi-pdf-download">'
				. '<a href="' . esc_url( $pdf_url ) . '" target="_blank" rel="noopener" class="button svpi-pdf-btn">'
				. '&#128196; ' . esc_html__( 'Datenblatt herunterladen (PDF)', 'svpi-importer' )
				. '</a></p>';
		}

		// ── 6. Textildruck section ────────────────────────────────────────
		$td      = $data['textildruck'] ?? [];
		$methods = $td['methods']   ?? [];
		$positions = $td['positions'] ?? [];

		if ( ! empty( $methods ) || ! empty( $positions ) ) {
			$html .= '<hr class="svpi-divider">';
			$html .= '<h3 class="svpi-section-title">'
				. esc_html__( 'Textildruck auf diesem Artikel', 'svpi-importer' )
				. '</h3>';

			// Generic intro (same for all products)
			$html .= '<p>'
				. esc_html__( 'Dieser Artikel kann mit Ihrem Logo/Motiv bedruckt oder bestickt werden. Folgen Sie diesen einfachen Schritten, um ein schnelles und unverbindliches, kostenfreies Angebot zu erhalten.', 'svpi-importer' )
				. '</p>';

			// "Angebot erhalten" steps block (generic — identical on every product)
			$html .= '<div class="svpi-print-steps">';
			$html .= '<h4>' . esc_html__( 'Angebot erhalten', 'svpi-importer' ) . '</h4>';
			$html .= '<p>' . esc_html__( 'So stellen Sie eine kostenlose und unverbindliche Textildruckanfrage:', 'svpi-importer' ) . '</p>';
			$html .= '<ol>';
			$steps = [
				'Legen Sie die gewünschten Artikel in den Warenkorb.',
				'Klicken Sie auf das Warenkorb-Symbol und anschließend auf Textildruck konfigurieren.',
				'Sie werden in 4 Schritten durch den Konfigurator geleitet.',
				'Weisen Sie das Motiv den Artikeln im Warenkorb zu (das Motiv kann direkt auf alle im Warenkorb befindlichen Artikel oder auf einzelne Produkte angewendet werden).',
				'Klicken Sie auf den Button „Jetzt konkrete Druckanfrage stellen".',
			];
			foreach ( $steps as $step ) {
				$html .= '<li>' . esc_html( $step ) . '</li>';
			}
			$html .= '</ol>';
			$html .= '<p>'
				. esc_html__( 'Wir prüfen Ihre Anfrage, melden uns bei Rückfragen oder kommen mit einem ', 'svpi-importer' )
				. '<strong>' . esc_html__( 'kostenlosen, unverbindlichen Angebot', 'svpi-importer' ) . '</strong>'
				. esc_html__( ' auf Sie zu.', 'svpi-importer' )
				. '</p>';
			$html .= '</div>';

			// Product-specific: print methods
			if ( ! empty( $methods ) ) {
				$html .= '<p><strong>' . esc_html__( 'Die möglichen Veredelungsarten', 'svpi-importer' ) . '</strong></p>';
				$html .= '<ul class="svpi-print-tags">';
				foreach ( $methods as $method ) {
					$html .= '<li>' . esc_html( trim( $method ) ) . '</li>';
				}
				$html .= '</ul>';
			}

			// Product-specific: print positions
			if ( ! empty( $positions ) ) {
				$html .= '<p><strong>' . esc_html__( 'Die möglichen Druckpositionen', 'svpi-importer' ) . '</strong></p>';
				$html .= '<ul class="svpi-print-tags">';
				foreach ( $positions as $position ) {
					$html .= '<li>' . esc_html( trim( $position ) ) . '</li>';
				}
				$html .= '</ul>';
			}
		}

		return $html;
	}
}
