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
	 * Upload an image from a URL to the Media Library.
	 * Returns the existing attachment ID if the image was already imported.
	 *
	 * @param string $url     Remote image URL.
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

		// ── Already in this site's Media Library? ─────────────────────────
		// The client catalogue (2026-09-07) is uploaded to the Media Library
		// first and products.json points at those URLs. Re-downloading them
		// would double every file; reuse the attachment instead.
		$site_host = wp_parse_url( home_url(), PHP_URL_HOST );
		$url_host  = wp_parse_url( $url, PHP_URL_HOST );
		if ( $site_host && $url_host === $site_host ) {
			$local_id = (int) attachment_url_to_postid( $url );
			if ( $local_id ) {
				update_post_meta( $local_id, '_svpi_source_url', $url );
				$this->cache[ $url ] = $local_id;
				return $local_id;
			}
		}

		// ── Download to temp file ─────────────────────────────────────────
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$tmp = download_url( $url, 120 );
		if ( is_wp_error( $tmp ) ) {
			return 0;
		}

		// ── Determine filename ────────────────────────────────────────────
		$filename = basename( wp_parse_url( $url, PHP_URL_PATH ) );
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
