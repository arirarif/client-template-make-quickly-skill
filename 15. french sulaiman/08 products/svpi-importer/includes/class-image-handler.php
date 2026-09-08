<?php
/**
 * SVPI Image Handler
 *
 * Downloads remote images and uploads them to the WordPress Media Library.
 * Caches by URL so the same image is not downloaded twice per import run.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SVPI_Image_Handler {

	/** @var array URL => attachment_id  (per-request cache) */
	private array $cache = [];

	/**
	 * Upload an image into the Media Library.
	 * Returns the existing attachment ID if the image was already imported.
	 *
	 * Accepts two forms:
	 *   - "https://example.com/box.png"  → downloaded from the remote host
	 *   - "demo-images/nxd-u2404-dvd.png" → read from inside this plugin folder
	 *     (ships with the plugin, so the import needs no internet access and
	 *      no third-party image service — DSGVO-friendly).
	 *
	 * @param string $url     Remote image URL or plugin-relative file path.
	 * @param int    $post_id Optional: parent post ID for attachment relationships.
	 * @return int  Attachment ID, or 0 on failure.
	 */
	public function upload_from_url( string $url, int $post_id = 0 ): int {
		if ( empty( $url ) ) {
			return 0;
		}

		// ── In-memory cache ───────────────────────────────────────────────
		if ( isset( $this->cache[ $url ] ) ) {
			return $this->cache[ $url ];
		}

		// ── DB cache — already uploaded in a previous import ──────────────
		global $wpdb;
		$existing_id = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT post_id FROM {$wpdb->postmeta}
				 WHERE meta_key = '_svpi_source_url' AND meta_value = %s
				 LIMIT 1",
				$url
			)
		);

		if ( $existing_id ) {
			$this->cache[ $url ] = $existing_id;
			return $existing_id;
		}

		// ── Reuse a matching file already in the Media Library ────────────
		// Covers artwork uploaded by hand: same basename → same image, so we
		// attach the existing attachment instead of creating a duplicate.
		$reused = $this->find_by_filename( basename( (string) wp_parse_url( $url, PHP_URL_PATH ) ) );
		if ( $reused ) {
			update_post_meta( $reused, '_svpi_source_url', $url );
			$this->cache[ $url ] = $reused;
			return $reused;
		}

		// ── Copy / download to temp file ──────────────────────────────────
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		if ( preg_match( '#^https?://#i', $url ) ) {
			$tmp      = download_url( $url, 120 );
			$filename = basename( (string) wp_parse_url( $url, PHP_URL_PATH ) );
		} else {
			$local = $this->resolve_bundled_file( $url );
			if ( ! $local ) {
				return 0;
			}
			$filename = basename( $local );
			$tmp      = wp_tempnam( $filename );
			if ( ! $tmp || ! copy( $local, $tmp ) ) {
				if ( $tmp ) {
					@unlink( $tmp );
				}
				return 0;
			}
		}

		if ( is_wp_error( $tmp ) ) {
			return 0;
		}

		// ── Determine filename ────────────────────────────────────────────
		if ( empty( $filename ) || empty( pathinfo( $filename, PATHINFO_EXTENSION ) ) ) {
			// Try to detect extension from MIME type
			$mime = mime_content_type( $tmp );
			$ext  = $this->mime_to_ext( $mime );
			$filename = 'product-image-' . uniqid() . ($ext ? '.' . $ext : '.jpg');
		}

		$file_array = [
			'name'     => $filename,
			'tmp_name' => $tmp,
			'error'    => 0,
			'size'     => filesize( $tmp ),
		];

		// ── Sideload into Media Library ───────────────────────────────────
		$attachment_id = media_handle_sideload( $file_array, $post_id );
		@unlink( $tmp ); // clean up temp file in all cases

		if ( is_wp_error( $attachment_id ) ) {
			return 0;
		}

		// ── Store source URL so future imports can find this attachment ────
		update_post_meta( $attachment_id, '_svpi_source_url', $url );

		$this->cache[ $url ] = (int) $attachment_id;
		return (int) $attachment_id;
	}

	// ── Private helpers ───────────────────────────────────────────────────────

	/**
	 * Find an attachment already in the Media Library by its file name.
	 *
	 * WordPress stores the upload-relative path in `_wp_attached_file`
	 * (e.g. "2026/07/nxd-win11pro-box.jpg"), so we match on the trailing
	 * segment. Also tolerates WP's "-1", "-2" … de-duplication suffixes.
	 *
	 * @param string $filename e.g. "nxd-win11pro-box.jpg"
	 * @return int Attachment ID, or 0 when nothing matches.
	 */
	private function find_by_filename( string $filename ): int {
		$filename = trim( $filename );
		if ( $filename === '' ) {
			return 0;
		}

		global $wpdb;

		// Exact file name first.
		$id = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT post_id FROM {$wpdb->postmeta}
				 WHERE meta_key = '_wp_attached_file'
				   AND ( meta_value = %s OR meta_value LIKE %s )
				 ORDER BY post_id ASC LIMIT 1",
				$filename,
				'%/' . $wpdb->esc_like( $filename )
			)
		);

		if ( $id ) {
			return $id;
		}

		// Then a WP-renamed copy: name-1.jpg, name-2.jpg …
		$ext  = pathinfo( $filename, PATHINFO_EXTENSION );
		$base = pathinfo( $filename, PATHINFO_FILENAME );
		if ( $base === '' || $ext === '' ) {
			return 0;
		}

		return (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT post_id FROM {$wpdb->postmeta}
				 WHERE meta_key = '_wp_attached_file'
				   AND meta_value LIKE %s
				 ORDER BY post_id ASC LIMIT 1",
				'%/' . $wpdb->esc_like( $base ) . '-%.' . $wpdb->esc_like( $ext )
			)
		);
	}

	/**
	 * Resolve a plugin-relative image path (e.g. "demo-images/nxd-u2404-dvd.png")
	 * to an absolute path inside this plugin folder.
	 *
	 * Absolute paths and traversal outside the plugin are rejected, so a crafted
	 * JSON file cannot pull arbitrary files off the server into the media library.
	 *
	 * @param string $relative Plugin-relative path.
	 * @return string Absolute readable path, or '' when it cannot be resolved.
	 */
	private function resolve_bundled_file( string $relative ): string {
		$relative = ltrim( str_replace( '\\', '/', trim( $relative ) ), '/' );

		if ( $relative === '' || strpos( $relative, '..' ) !== false ) {
			return '';
		}

		$base = realpath( SVPI_DIR );
		$path = realpath( SVPI_DIR . $relative );

		if ( ! $base || ! $path || strpos( $path, $base ) !== 0 ) {
			return '';
		}

		return is_readable( $path ) && ! is_dir( $path ) ? $path : '';
	}

	private function mime_to_ext( string $mime ): string {
		$map = [
			'image/jpeg' => 'jpg',
			'image/png'  => 'png',
			'image/gif'  => 'gif',
			'image/webp' => 'webp',
			'image/avif' => 'avif',
		];
		return $map[ $mime ] ?? 'jpg';
	}
}
