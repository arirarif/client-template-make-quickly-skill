<?php
/**
 * Plugin Name: Simple Variable Product Importer (SVPI)
 * Description: Import variable products with color swatches from JSON into WooCommerce. WoodMart-compatible.
 * Version:     1.0.0
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * Author:      hub-tex
 * Text Domain: svpi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SVPI_DIR',     plugin_dir_path( __FILE__ ) );
define( 'SVPI_URL',     plugin_dir_url( __FILE__ ) );
define( 'SVPI_VERSION', '1.0.0' );

// ─── Autoload includes ────────────────────────────────────────────────────────
require_once SVPI_DIR . 'includes/class-json-parser.php';
require_once SVPI_DIR . 'includes/class-attribute-handler.php';
require_once SVPI_DIR . 'includes/class-image-handler.php';
require_once SVPI_DIR . 'includes/class-product-creator.php';
require_once SVPI_DIR . 'includes/class-variation-creator.php';
// ─── Register product_brand taxonomy ───────────────────────────────────────────────
add_action( 'init', function () {
	if ( ! taxonomy_exists( 'product_brand' ) ) {
		register_taxonomy( 'product_brand', 'product', [
			'labels' => [
				'name'              => 'Marken',
				'singular_name'     => 'Marke',
				'search_items'      => 'Marken suchen',
				'all_items'         => 'Alle Marken',
				'edit_item'         => 'Marke bearbeiten',
				'update_item'       => 'Marke aktualisieren',
				'add_new_item'      => 'Neue Marke hinzufügen',
				'new_item_name'     => 'Neue Marke',
				'menu_name'         => 'Marken',
			],
			'hierarchical'      => false,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => [ 'slug' => 'marke', 'with_front' => false ],
		] );
	}
} );
// ─── Admin menu ───────────────────────────────────────────────────────────────
add_action( 'admin_menu', function () {
	add_submenu_page(
		'woocommerce',
		'Import Products (SVPI)',
		'Import Products',
		'manage_woocommerce',
		'svpi-importer',
		'svpi_render_admin_page'
	);
} );

// ─── Enqueue admin styles + script ──────────────────────────────────────────────
add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( $hook !== 'woocommerce_page_svpi-importer' ) {
		return;
	}
	wp_enqueue_style( 'svpi-admin', SVPI_URL . 'assets/admin.css', [], SVPI_VERSION );
	wp_enqueue_script( 'svpi-admin', SVPI_URL . 'assets/js/admin.js', [], SVPI_VERSION, true );
	wp_localize_script( 'svpi-admin', 'svpiAdmin', [
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'svpi_import' ),
	] );
} );

// ─── Admin page ───────────────────────────────────────────────────────────────
function svpi_render_admin_page() {
	$results = null;
	$error   = null;

	// ── Delete All action ───────────────────────────────────────────────────────
	$delete_result = null;
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' && ( $_POST['svpi_action'] ?? '' ) === 'delete_all' ) {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'svpi_delete_all' ) ) {
			$error = 'Security check failed.';
		} else {
			$delete_result = svpi_delete_all_products();
		}
	}

	// ── Cache Clean action ────────────────────────────────────────────────────────
	$cache_result = null;
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' && ( $_POST['svpi_action'] ?? '' ) === 'clean_cache' ) {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'svpi_clean_cache' ) ) {
			$error = 'Security check failed.';
		} else {
			$cache_result = svpi_clean_cache();
		}
	}

	if ( $_SERVER['REQUEST_METHOD'] === 'POST' && ! empty( $_FILES['svpi_json'] ) ) {
		// CSRF check
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'svpi_import' ) ) {
			$error = 'Security check failed.';
		} else {
			$file = $_FILES['svpi_json'];

			if ( $file['error'] !== UPLOAD_ERR_OK ) {
				$error = 'File upload error code: ' . (int) $file['error'];
			} elseif ( strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) ) !== 'json' ) {
				$error = 'Please upload a .json file.';
			} else {
				$skip_existing   = ! empty( $_POST['skip_existing'] );
				$download_images = ! empty( $_POST['download_images'] );

				$parser = new SVPI_JSON_Parser();
				$data   = $parser->parse( $file['tmp_name'] );

				if ( is_wp_error( $data ) ) {
					$error = $data->get_error_message();
				} else {
					$importer = new SVPI_Product_Creator( $skip_existing, $download_images );
					$results  = $importer->import_all( $data['products'] );
				}
			}
		}
	}

	$nonce = wp_create_nonce( 'svpi_import' );
	?>
	<div class="wrap svpi-wrap">
		<h1>Simple Variable Product Importer</h1>
		<p class="svpi-subtitle">Upload your <code>products.json</code> to create WooCommerce variable products with WoodMart color swatches.</p>

		<?php if ( $error ) : ?>
			<div class="svpi-notice svpi-notice--error"><?php echo esc_html( $error ); ?></div>
		<?php endif; ?>

		<div class="svpi-card">
			<form id="svpi-import-form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( $nonce ); ?>">

				<div class="svpi-field">
					<label for="svpi_json"><strong>JSON File</strong></label>
					<input type="file" name="svpi_json" id="svpi_json" accept=".json" required>
					<span class="svpi-hint">File format: <code>{ "products": [ ... ] }</code></span>
				</div>

				<div class="svpi-field">
					<strong>Options</strong>
					<label class="svpi-checkbox">
						<input type="checkbox" name="skip_existing" value="1" checked>
						Skip if already exists — <em>uncheck to UPDATE existing products instead</em>
					</label>
					<label class="svpi-checkbox">
						<input type="checkbox" name="download_images" value="1" checked>
						Download and upload images to Media Library
					</label>
				</div>

				<button type="submit" id="svpi-submit-btn" class="button button-primary svpi-btn">Run Import</button>
			</form>
		</div>

		<!-- ── Progress ───────────────────────────────────────────────────────── -->
		<div class="svpi-card" id="svpi-progress-wrap" style="display:none">
			<div class="svpi-progress-header">
				<span id="svpi-progress-label">Starting…</span>
				<span id="svpi-progress-pct">0%</span>
			</div>
			<div class="svpi-progress-track" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
				<div id="svpi-progress-bar"></div>
			</div>
			<details class="svpi-log" open>
				<summary id="svpi-log-summary">Import Log</summary>
				<div id="svpi-progress-log" class="svpi-log__body"></div>
			</details>
		</div>

		<!-- ── Results (populated by JS) ──────────────────────────────────────── -->
		<div class="svpi-card svpi-results" id="svpi-results-wrap" style="display:none"></div>

		<!-- ── Swatch note (shown by JS) ──────────────────────────────────────────── -->
		<div class="svpi-notice svpi-notice--info" id="svpi-swatch-note" style="display:none">
			<strong>Note:</strong> For WoodMart color swatches, go to
			<strong>WooCommerce → Attributes → Color → Edit</strong>
			and set <strong>Swatch type → Color</strong>. This is a one-time step.
		</div>

		<!-- ── Tools card ──────────────────────────────────────────────────────── -->
		<div class="svpi-card svpi-tools">
			<h2 style="margin-top:0;font-size:16px;margin-bottom:16px;">Tools</h2>
			<div class="svpi-tools-row">

				<div class="svpi-tool-item">
				<form method="post" onsubmit="return confirm('DELETE ALL products, variations, attributes, categories, brands and SVPI-uploaded images?\n\nThis cannot be undone.')">
					<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( wp_create_nonce( 'svpi_delete_all' ) ); ?>">
					<input type="hidden" name="svpi_action" value="delete_all">
					<button type="submit" class="button svpi-btn-danger">
						&#x1F5D1; Delete All Products &amp; Data
					</button>
				</form>
				<span class="svpi-hint">Removes all products, variations, pa_* attributes, categories, brands, tags and SVPI-uploaded images.</span>
				</div>

				<div class="svpi-tool-item">
					<form method="post">
						<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( wp_create_nonce( 'svpi_clean_cache' ) ); ?>">
						<input type="hidden" name="svpi_action" value="clean_cache">
						<button type="submit" class="button svpi-btn-secondary">
							&#x1F9F9; Clean Cache &amp; Recount
						</button>
					</form>
					<span class="svpi-hint">Clears WooCommerce transients, attribute cache, object cache and recounts category terms.</span>
				</div>

			</div>

			<?php if ( $delete_result ) : ?>
				<div class="svpi-notice svpi-notice--success" style="margin-top:16px;margin-bottom:0;">
					<strong>Deleted:</strong>
					<?php echo (int) $delete_result['products']; ?> products,
					<?php echo (int) $delete_result['variations']; ?> variations,
					<?php echo (int) $delete_result['attributes']; ?> attribute types,
					<?php echo (int) $delete_result['terms']; ?> attribute terms,
					<?php echo (int) $delete_result['categories']; ?> categories,
					<?php echo (int) ($delete_result['brands'] ?? 0); ?> brands,
					<?php echo (int) $delete_result['images']; ?> images.
				</div>
			<?php endif; ?>

			<?php if ( $cache_result ) : ?>
				<div class="svpi-notice svpi-notice--success" style="margin-top:16px;margin-bottom:0;">
					<?php foreach ( $cache_result as $line ) : ?>
						<div>&#x2705; <?php echo esc_html( $line ); ?></div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

	</div>
	<?php
}

// ─── Delete All Products helper ───────────────────────────────────────────────
function svpi_delete_all_products(): array {
	@set_time_limit( 0 );

	$deleted = [
		'products'   => 0,
		'variations' => 0,
		'attributes' => 0,
		'terms'      => 0,
		'categories' => 0,
		'brands'     => 0,
		'images'     => 0,
	];

	// 1. Delete all product + variation posts
	$ids = get_posts( [
		'post_type'      => [ 'product', 'product_variation' ],
		'posts_per_page' => -1,
		'post_status'    => 'any',
		'fields'         => 'ids',
	] );
	foreach ( $ids as $id ) {
		$type = get_post_type( $id );
		wp_delete_post( (int) $id, true );
		if ( $type === 'product_variation' ) {
			++$deleted['variations'];
		} else {
			++$deleted['products'];
		}
	}

	// 2. Delete SVPI-uploaded media attachments (_svpi_source_url meta)
	global $wpdb;
	$img_ids = $wpdb->get_col(
		$wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = %s", '_svpi_source_url' )
	);
	foreach ( $img_ids as $img_id ) {
		wp_delete_attachment( (int) $img_id, true );
		++$deleted['images'];
	}

	// 3. Delete all product_cat terms (WP won't allow deleting the built-in "Uncategorized" — safe)
	$cats = get_terms( [ 'taxonomy' => 'product_cat', 'hide_empty' => false, 'fields' => 'ids' ] );
	if ( ! is_wp_error( $cats ) ) {
		foreach ( $cats as $tid ) {
			wp_delete_term( (int) $tid, 'product_cat' );
			++$deleted['categories'];
		}
	}

	// 4. Delete all product_tag terms
	$tags = get_terms( [ 'taxonomy' => 'product_tag', 'hide_empty' => false, 'fields' => 'ids' ] );
	if ( ! is_wp_error( $tags ) ) {
		foreach ( $tags as $tid ) {
			wp_delete_term( (int) $tid, 'product_tag' );
		}
	}

	// 4b. Delete all product_brand terms
	if ( taxonomy_exists( 'product_brand' ) ) {
		$brands = get_terms( [ 'taxonomy' => 'product_brand', 'hide_empty' => false, 'fields' => 'ids' ] );
		if ( ! is_wp_error( $brands ) ) {
			foreach ( $brands as $tid ) {
				wp_delete_term( (int) $tid, 'product_brand' );
				++$deleted['brands'];
			}
		}
	}

	// 5. Delete all pa_* attribute taxonomies + their terms
	$attributes = wc_get_attribute_taxonomies();
	foreach ( $attributes as $attr ) {
		$taxonomy = wc_attribute_taxonomy_name( $attr->attribute_name );
		$terms    = get_terms( [ 'taxonomy' => $taxonomy, 'hide_empty' => false, 'fields' => 'ids' ] );
		if ( ! is_wp_error( $terms ) ) {
			foreach ( $terms as $tid ) {
				wp_delete_term( (int) $tid, $taxonomy );
				++$deleted['terms'];
			}
		}
		wc_delete_attribute( (int) $attr->attribute_id );
		++$deleted['attributes'];
	}

	delete_transient( 'wc_attribute_taxonomies' );
	if ( class_exists( 'WC_Cache_Helper' ) ) {
		WC_Cache_Helper::invalidate_cache_group( 'woocommerce-attributes' );
	}

	return $deleted;
}

// ─── Cache Clean helper ───────────────────────────────────────────────────────
function svpi_clean_cache(): array {
	$cleaned = [];

	// 1. Delete all WC transients from options table
	global $wpdb;
	$count = (int) $wpdb->query(
		"DELETE FROM {$wpdb->options}
		 WHERE option_name LIKE '\_transient\_wc\_%'
		    OR option_name LIKE '\_transient\_timeout\_wc\_%'"
	);
	$cleaned[] = "Deleted {$count} WooCommerce transients";

	// 2. Clear attribute taxonomies transient
	delete_transient( 'wc_attribute_taxonomies' );
	$cleaned[] = 'Cleared attribute taxonomies transient';

	// 3. Invalidate WC cache groups
	if ( class_exists( 'WC_Cache_Helper' ) ) {
		WC_Cache_Helper::invalidate_cache_group( 'woocommerce-attributes' );
		WC_Cache_Helper::invalidate_cache_group( 'products' );
		$cleaned[] = 'Invalidated WC cache groups (attributes, products)';
	}

	// 4. Flush WordPress object cache
	wp_cache_flush();
	$cleaned[] = 'Flushed WordPress object cache';

	// 5. Recount product category terms
	if ( function_exists( 'wc_recount_all_terms' ) ) {
		wc_recount_all_terms();
		$cleaned[] = 'Recounted product category terms';
	}

	return $cleaned;
}

// ─── Temp import storage (file-based) ───────────────────────────────────────────
// Large imports (1MB+) can't be stored in transients when a persistent object
// cache (Redis/Memcached) is active — items over the cache limit are silently
// dropped, which surfaced as "Import session expired" on product 1. We instead
// stash the parsed products in a JSON file under uploads/svpi-tmp/.
function svpi_tmp_dir(): string {
	$up  = wp_upload_dir();
	$dir = trailingslashit( $up['basedir'] ) . 'svpi-tmp';
	if ( ! is_dir( $dir ) ) {
		wp_mkdir_p( $dir );
		// Keep the folder private.
		@file_put_contents( trailingslashit( $dir ) . 'index.html', '' );
	}
	return $dir;
}
function svpi_tmp_file( string $key ): string {
	$key = sanitize_key( $key );
	return trailingslashit( svpi_tmp_dir() ) . $key . '.json';
}

// ─── AJAX: Init import (parse file, store products in a temp file) ───────────────
add_action( 'wp_ajax_svpi_init_import', 'svpi_ajax_init_import' );

function svpi_ajax_init_import(): void {
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		wp_send_json_error( 'Unauthorised.' );
	}
	check_ajax_referer( 'svpi_import', '_wpnonce' );

	if ( empty( $_FILES['svpi_json'] ) || (int) $_FILES['svpi_json']['error'] !== UPLOAD_ERR_OK ) {
		wp_send_json_error( 'File upload error.' );
	}

	$file = $_FILES['svpi_json'];
	if ( strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) ) !== 'json' ) {
		wp_send_json_error( 'Please upload a .json file.' );
	}

	$parser = new SVPI_JSON_Parser();
	$data   = $parser->parse( $file['tmp_name'] );

	if ( is_wp_error( $data ) ) {
		wp_send_json_error( $data->get_error_message() );
	}

	// Lowercase key so it survives sanitize_key() unchanged on the batch side.
	$import_key = 'svpi_' . strtolower( wp_generate_password( 16, false ) );
	$path       = svpi_tmp_file( $import_key );

	$written = file_put_contents( $path, wp_json_encode( $data['products'] ) );
	if ( $written === false ) {
		wp_send_json_error( 'Could not write the temp import file. Check that wp-content/uploads is writable.' );
	}

	wp_send_json_success( [
		'import_key' => $import_key,
		'total'      => count( $data['products'] ),
		'nonce'      => wp_create_nonce( 'svpi_import_batch' ),
	] );
}

// ─── AJAX: Import one product (called in a loop from JS) ────────────────────────
add_action( 'wp_ajax_svpi_import_batch', 'svpi_ajax_import_batch' );

function svpi_ajax_import_batch(): void {
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		wp_send_json_error( 'Unauthorised.' );
	}
	check_ajax_referer( 'svpi_import_batch', '_wpnonce' );

	$import_key      = sanitize_key( $_POST['import_key'] ?? '' );
	$index           = (int) ( $_POST['index'] ?? 0 );
	$skip_existing   = ! empty( $_POST['skip_existing'] );
	$download_images = ! empty( $_POST['download_images'] );

	if ( empty( $import_key ) ) {
		wp_send_json_error( 'Missing import key.' );
	}

	$path = svpi_tmp_file( $import_key );
	if ( ! is_readable( $path ) ) {
		wp_send_json_error( 'Import session expired. Please re-upload the file.' );
	}
	$products = json_decode( (string) file_get_contents( $path ), true );
	if ( ! is_array( $products ) ) {
		wp_send_json_error( 'Import session expired. Please re-upload the file.' );
	}

	if ( ! isset( $products[ $index ] ) ) {
		@unlink( $path );
		wp_send_json_success( [ 'done' => true ] );
		return;
	}

	@set_time_limit( 120 );
	$creator = new SVPI_Product_Creator( $skip_existing, $download_images );
	$result  = $creator->import_single( $products[ $index ] );

	wp_send_json_success( [
		'done'  => false,
		'index' => $index,
		'stats' => $result['stats'],
		'log'   => $result['log'],
	] );
}
