<?php
/**
 * Static pages bundled with the theme (About, Contact, Shipping, Returns,
 * Terms, Privacy, FAQ, Size Chart).
 *
 * Why these live in the theme and not in the editor: the client's legal pages
 * were 404s on 2026-09-04 because the WooCommerce-generated drafts were never
 * published and the rest were never created. Bundling the copy means a fresh
 * install — or a WP Reset, which has already happened once on this site — can
 * be brought back with one click of Niswah Starter → Import Everything.
 *
 * Pages are plain HTML (no Divi builder), so the T5 General template wraps them
 * and the client can edit them in the normal editor afterwards. Re-running the
 * import overwrites the body with the bundled copy; that is deliberate for the
 * policy pages, and the client has been told.
 *
 * Manifest: data/pages.json. Copy: data/pages/*.html.
 *
 * @package Niswah_Boutique
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NB_Pages {

	/** Option holding slug => page id for every page this class created/adopted. */
	const IDS_OPT = 'nb_starter_page_ids';

	/** @return string */
	private static function manifest_file() {
		return NB_THEME_DIR . '/data/pages.json';
	}

	/**
	 * Read the manifest.
	 *
	 * @return array|WP_Error
	 */
	public static function manifest() {
		$file = self::manifest_file();
		if ( ! file_exists( $file ) ) {
			return new WP_Error( 'nb_pages_missing', __( 'data/pages.json is missing.', 'niswah-boutique' ) );
		}
		$data = json_decode( (string) file_get_contents( $file ), true );
		if ( ! is_array( $data ) || empty( $data['pages'] ) ) {
			return new WP_Error( 'nb_pages_invalid', __( 'data/pages.json could not be parsed.', 'niswah-boutique' ) );
		}
		return $data;
	}

	/**
	 * Find a page by slug in any status (draft, pending, private, publish).
	 * get_page_by_path() only returns published pages, which is why the
	 * WooCommerce drafts were being missed.
	 *
	 * @param string $slug
	 * @return WP_Post|null
	 */
	private static function find_by_slug( $slug ) {
		$posts = get_posts(
			array(
				'name'           => $slug,
				'post_type'      => 'page',
				'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
				'posts_per_page' => 1,
				'orderby'        => 'ID',
				'order'          => 'ASC',
			)
		);
		return $posts ? $posts[0] : null;
	}

	/**
	 * Create or refresh every page in the manifest.
	 *
	 * @return array { type: success|error, message: string, ids: array }
	 */
	public static function import() {
		$manifest = self::manifest();
		if ( is_wp_error( $manifest ) ) {
			return array(
				'type'    => 'error',
				'message' => $manifest->get_error_message(),
				'ids'     => array(),
			);
		}

		$ids     = get_option( self::IDS_OPT, array() );
		$ids     = is_array( $ids ) ? $ids : array();
		$created = 0;
		$updated = 0;
		$errors  = array();

		foreach ( $manifest['pages'] as $page ) {
			$slug  = isset( $page['slug'] ) ? sanitize_title( $page['slug'] ) : '';
			$title = isset( $page['title'] ) ? $page['title'] : $slug;
			$file  = isset( $page['file'] ) ? NB_THEME_DIR . '/data/pages/' . basename( $page['file'] ) : '';

			if ( ! $slug || ! $file || ! file_exists( $file ) ) {
				$errors[] = sprintf( 'Page "%s": copy file missing.', $title );
				continue;
			}

			$html = (string) file_get_contents( $file );
			// Strip the build-time HTML comments (draft notes) so they never
			// reach the page source.
			$html = trim( (string) preg_replace( '/<!--.*?-->/s', '', $html ) );

			$content = '<div class="nb-page nb-page--' . esc_attr( $slug ) . '">' . "\n" . $html . "\n" . '</div>';

			$existing = self::find_by_slug( $slug );
			$postarr  = array(
				'post_title'   => $title,
				'post_name'    => $slug,
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_content' => $content,
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			);

			if ( $existing ) {
				$postarr['ID'] = $existing->ID;
				$page_id       = wp_update_post( $postarr, true );
				$updated++;
			} else {
				$page_id = wp_insert_post( $postarr, true );
				$created++;
			}

			if ( is_wp_error( $page_id ) ) {
				$errors[] = sprintf( 'Page "%s": %s', $title, $page_id->get_error_message() );
				continue;
			}

			// Plain editor page, full width, under the T5 General template.
			update_post_meta( $page_id, '_et_pb_use_builder', 'off' );
			update_post_meta( $page_id, '_et_pb_page_layout', 'et_full_width_page' );
			update_post_meta( $page_id, '_et_pb_side_nav', 'off' );
			update_post_meta( $page_id, '_et_pb_post_hide_nav', 'default' );

			$ids[ $slug ] = (int) $page_id;

			// Wire into WordPress / WooCommerce settings where the manifest says so.
			if ( ! empty( $page['setting'] ) ) {
				update_option( sanitize_key( $page['setting'] ), (int) $page_id );
			}
		}

		update_option( self::IDS_OPT, $ids );

		// Housekeeping: pages the manifest says should go (Sample Page). Trash,
		// never delete, so it is reversible from the admin.
		$trashed = 0;
		if ( ! empty( $manifest['trash_slugs'] ) && is_array( $manifest['trash_slugs'] ) ) {
			foreach ( $manifest['trash_slugs'] as $slug ) {
				$p = self::find_by_slug( sanitize_title( $slug ) );
				if ( $p && 'trash' !== $p->post_status ) {
					wp_trash_post( $p->ID );
					$trashed++;
				}
			}
		}

		$message = sprintf(
			/* translators: 1: created, 2: updated, 3: trashed */
			__( 'Pages: %1$d created, %2$d updated, %3$d trashed.', 'niswah-boutique' ),
			$created,
			$updated,
			$trashed
		);

		if ( $errors ) {
			return array(
				'type'    => 'error',
				'message' => $message . ' ' . implode( ' | ', $errors ),
				'ids'     => $ids,
			);
		}

		return array(
			'type'    => 'success',
			'message' => $message,
			'ids'     => $ids,
		);
	}

	/**
	 * Page id for a manifest slug, or 0.
	 *
	 * @param string $slug
	 * @return int
	 */
	public static function id( $slug ) {
		$ids = get_option( self::IDS_OPT, array() );
		return isset( $ids[ $slug ] ) ? (int) $ids[ $slug ] : 0;
	}
}
