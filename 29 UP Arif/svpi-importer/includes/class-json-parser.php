<?php
/**
 * SVPI JSON Parser
 *
 * Reads and validates the products.json file.
 * Supports wrapped format: { "products": [...] }
 * and legacy flat format:  [ {...}, {...} ]
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SVPI_JSON_Parser {

	/**
	 * Parse a products.json file from a path.
	 *
	 * @param string $file_path Absolute path to the uploaded JSON file.
	 * @return array|WP_Error  ['products' => [...]] on success, WP_Error on failure.
	 */
	public function parse( string $file_path ) {
		if ( ! is_readable( $file_path ) ) {
			return new WP_Error( 'parse_error', 'Cannot read the uploaded file.' );
		}

		$contents = file_get_contents( $file_path );
		if ( $contents === false || $contents === '' ) {
			return new WP_Error( 'parse_error', 'The uploaded file is empty.' );
		}

		$data = json_decode( $contents, true );
		if ( json_last_error() !== JSON_ERROR_NONE ) {
			return new WP_Error( 'parse_error', 'Invalid JSON: ' . json_last_error_msg() );
		}

		// ── Normalise to flat products array ─────────────────────────────
		if ( isset( $data['products'] ) && is_array( $data['products'] ) ) {
			// Wrapped format from new scraper: { "source": "...", "products": [...] }
			$products = $data['products'];
		} elseif ( is_array( $data ) && ! empty( $data ) && isset( $data[0] ) ) {
			// Legacy flat array format
			$products = $data;
		} else {
			return new WP_Error( 'parse_error', 'No products found in the JSON file. Expected {"products":[...]} or [...].' );
		}

		if ( empty( $products ) ) {
			return new WP_Error( 'parse_error', 'The products array is empty.' );
		}

		// ── Basic validation ──────────────────────────────────────────────
		foreach ( $products as $i => $product ) {
			if ( empty( $product['name'] ) ) {
				return new WP_Error( 'parse_error', "Product at index {$i} is missing 'name'." );
			}
		}

		return [ 'products' => $products ];
	}
}
