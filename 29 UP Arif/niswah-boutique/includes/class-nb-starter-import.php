<?php
/**
 * Niswah Boutique — starter template importer.
 *
 * Installs the Global Header and Global Footer that ship with this theme into
 * Divi's Theme Builder, so a fresh install does not have to rebuild them by hand.
 *
 * Built on Divi's own public Theme Builder constants and helpers:
 *   ET_THEME_BUILDER_TEMPLATE_POST_TYPE
 *   ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE
 *   ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE
 *   et_theme_builder_get_theme_builder_post_id()
 *
 * @package NiswahBoutique
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NB_Starter_Import {

	const MENU_SLUG    = 'nb-starter';
	const NONCE        = 'nb_starter_import';
	const NONCE_HOME   = 'nb_starter_import_home';
	const NONCE_ALL    = 'nb_starter_import_all';
	const DONE_OPT     = 'nb_starter_imported';
	const CREATED_OPT  = 'nb_starter_created_ids';
	const HOME_ID_OPT  = 'nb_starter_home_id';
	const COLLECTIONS_ID_OPT = 'nb_starter_collections_id';
	const MENU_NAME    = 'Niswah Main Menu';

	/**
	 * Placeholder menu id baked into the generated header shortcode.
	 *
	 * The header layout is generated at build time, long before the menu exists
	 * in the database, so the shortcode carries this sentinel and run_import()
	 * swaps in the real id once ensure_main_menu() has created it. Hard-coding a
	 * live id instead is what left the nav falling back to "Sample Page /
	 * Uncategorized" after the database was reset and the old menu vanished.
	 */
	const MENU_PLACEHOLDER = 221;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_page' ) );
		add_action( 'admin_post_nb_starter_import', array( $this, 'handle_import' ) );
		add_action( 'admin_post_nb_starter_import_home', array( $this, 'handle_import_home' ) );
		add_action( 'admin_post_nb_starter_import_all', array( $this, 'handle_import_all' ) );
	}

	public function add_page() {
		add_theme_page(
			__( 'Niswah Starter', 'niswah-boutique' ),
			__( 'Niswah Starter', 'niswah-boutique' ),
			'switch_themes',
			self::MENU_SLUG,
			array( $this, 'render_page' )
		);
	}

	/** Absolute path to the bundled Theme Builder data. */
	private function data_file() {
		return NB_THEME_DIR . '/data/theme-builder.json';
	}

	/** Absolute path to the bundled Home page layout. */
	private function home_file() {
		return NB_THEME_DIR . '/data/home.json';
	}

	/** Absolute path to the bundled Collections page layout. */
	private function collections_file() {
		return NB_THEME_DIR . '/data/collections.json';
	}

	/**
	 * Create or refresh a bundled page from one of the data files.
	 *
	 * Shared by the Home and Collections imports, which differ only in their
	 * data file and whether the page becomes the front page. The id of each
	 * created page is remembered under its own option, so re-running updates
	 * that page instead of stacking up duplicates.
	 *
	 * @param string $file     Absolute path to the page JSON.
	 * @param string $id_key   Option name holding the created page id.
	 * @param string $label    Human label for the result message.
	 * @return array{type:string,message:string}
	 */
	private function import_page_file( $file, $id_key, $label ) {
		if ( ! file_exists( $file ) ) {
			return array(
				'type'    => 'error',
				/* translators: %s: page label */
				'message' => sprintf( __( 'Bundled %s layout is missing.', 'niswah-boutique' ), $label ),
			);
		}

		$data = json_decode( file_get_contents( $file ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions

		if ( ! is_array( $data ) || empty( $data['page']['post_content'] ) ) {
			return array(
				'type'    => 'error',
				/* translators: %s: page label */
				'message' => sprintf( __( 'Bundled %s layout could not be parsed.', 'niswah-boutique' ), $label ),
			);
		}

		$page      = $data['page'];
		$existing  = (int) get_option( $id_key );
		$is_update = $existing && get_post( $existing ) && 'trash' !== get_post_status( $existing );

		$postarr = array(
			'post_title'   => isset( $page['post_title'] ) ? $page['post_title'] : $label,
			'post_name'    => isset( $page['post_name'] ) ? $page['post_name'] : sanitize_title( $label ),
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_content' => $page['post_content'],
		);

		if ( $is_update ) {
			$postarr['ID'] = $existing;
			$page_id       = wp_update_post( $postarr, true );
		} else {
			$page_id = wp_insert_post( $postarr, true );
		}

		if ( is_wp_error( $page_id ) ) {
			return array(
				'type'    => 'error',
				'message' => sprintf(
					/* translators: 1: page label, 2: error message */
					__( 'Could not create the %1$s page: %2$s', 'niswah-boutique' ),
					$label,
					$page_id->get_error_message()
				),
			);
		}

		if ( ! empty( $page['post_meta'] ) && is_array( $page['post_meta'] ) ) {
			foreach ( $page['post_meta'] as $meta ) {
				if ( isset( $meta['key'] ) ) {
					update_post_meta( $page_id, $meta['key'], isset( $meta['value'] ) ? $meta['value'] : '' );
				}
			}
		}
		update_post_meta( $page_id, '_et_pb_use_builder', 'on' );
		update_post_meta( $page_id, '_et_pb_page_layout', 'et_no_sidebar' );
		update_post_meta( $page_id, '_et_pb_side_nav', 'off' );

		update_option( $id_key, $page_id );

		$front_note = '';
		if ( ! empty( $page['set_as_front_page'] ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $page_id );
			$front_note = ' ' . __( 'Set as the site front page.', 'niswah-boutique' );
		}

		return array(
			'type'    => 'success',
			'message' => sprintf(
				/* translators: 1: page label, 2: created or updated, 3: page id, 4: front page note */
				__( '%1$s page %2$s (#%3$d).%4$s', 'niswah-boutique' ),
				$label,
				$is_update ? __( 'updated', 'niswah-boutique' ) : __( 'created', 'niswah-boutique' ),
				$page_id,
				$front_note
			),
		);
	}

	/** Create or refresh the Collections page. */
	private function run_import_collections() {
		return $this->import_page_file( $this->collections_file(), self::COLLECTIONS_ID_OPT, 'Collections' );
	}

	/** True when Divi's Theme Builder API is actually present. */
	private function divi_ready() {
		return defined( 'ET_THEME_BUILDER_TEMPLATE_POST_TYPE' )
			&& defined( 'ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE' )
			&& defined( 'ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE' )
			&& function_exists( 'et_theme_builder_get_theme_builder_post_id' );
	}

	public function render_page() {
		$file        = $this->data_file();
		$has_file    = file_exists( $file );
		$divi_ok     = $this->divi_ready();
		$already     = get_option( self::DONE_OPT );
		$last_result = get_transient( 'nb_starter_result' );

		if ( $last_result ) {
			delete_transient( 'nb_starter_result' );
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Niswah Boutique — Starter Templates', 'niswah-boutique' ); ?></h1>

			<?php if ( $last_result ) : ?>
				<div class="notice notice-<?php echo esc_attr( $last_result['type'] ); ?>">
					<p><?php echo esc_html( $last_result['message'] ); ?></p>
				</div>
			<?php endif; ?>

			<?php
			$home_ready = file_exists( $this->home_file() );
			$all_ready  = $has_file && $divi_ok && $home_ready;
			?>
			<div style="background:#fff;border:1px solid #c3c4c7;border-left:4px solid #2271b1;padding:14px 18px;max-width:760px;margin:18px 0;">
				<h2 style="margin-top:0;"><?php esc_html_e( 'Set up everything', 'niswah-boutique' ); ?></h2>
				<p style="margin-bottom:6px;">
					<?php esc_html_e( 'Installs the Global Header, Global Footer and the Home page in one step, and sets Home as the front page.', 'niswah-boutique' ); ?>
				</p>
				<p class="description" style="margin-top:0;">
					<?php esc_html_e( 'Installing the theme only copies files. Divi keeps layouts in the database, so this step is what actually writes them in.', 'niswah-boutique' ); ?>
				</p>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="nb_starter_import_all" />
					<?php wp_nonce_field( self::NONCE_ALL ); ?>
					<?php
					submit_button(
						__( 'Import Everything', 'niswah-boutique' ),
						'primary large',
						'submit_all',
						false,
						$all_ready ? array() : array( 'disabled' => 'disabled' )
					);
					?>
				</form>
			</div>

			<hr />
			<h2><?php esc_html_e( 'Header &amp; Footer only', 'niswah-boutique' ); ?></h2>
			<p>
				<?php esc_html_e( 'Installs just the Global Header and Global Footer into the Divi Theme Builder.', 'niswah-boutique' ); ?>
			</p>

			<table class="widefat striped" style="max-width:760px;margin-bottom:18px;">
				<tbody>
					<tr>
						<td><strong><?php esc_html_e( 'Bundled template file', 'niswah-boutique' ); ?></strong></td>
						<td>
							<?php echo $has_file
								? '<span style="color:#127a3d;">' . esc_html__( 'Found', 'niswah-boutique' ) . '</span> — <code>data/theme-builder.json</code>'
								: '<span style="color:#b32d2e;">' . esc_html__( 'Missing', 'niswah-boutique' ) . '</span> — <code>data/theme-builder.json</code>'; ?>
						</td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'Divi Theme Builder API', 'niswah-boutique' ); ?></strong></td>
						<td>
							<?php echo $divi_ok
								? '<span style="color:#127a3d;">' . esc_html__( 'Available', 'niswah-boutique' ) . '</span>'
								: '<span style="color:#b32d2e;">' . esc_html__( 'Not available — is Divi the active parent theme?', 'niswah-boutique' ) . '</span>'; ?>
						</td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'Previously imported', 'niswah-boutique' ); ?></strong></td>
						<td>
							<?php echo $already
								? esc_html( sprintf( __( 'Yes — %s', 'niswah-boutique' ), $already ) )
								: esc_html__( 'No', 'niswah-boutique' ); ?>
						</td>
					</tr>
				</tbody>
			</table>

			<p>
				<strong><?php esc_html_e( 'This replaces the Theme Builder templates.', 'niswah-boutique' ); ?></strong>
				<?php esc_html_e( 'Any existing templates and their layouts are deleted first, then the bundled header and footer are installed. Safe to run repeatedly.', 'niswah-boutique' ); ?>
			</p>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="nb_starter_import" />
				<?php wp_nonce_field( self::NONCE ); ?>
				<?php
				submit_button(
					__( 'Import Header & Footer', 'niswah-boutique' ),
					'primary',
					'submit',
					false,
					( $has_file && $divi_ok ) ? array() : array( 'disabled' => 'disabled' )
				);
				?>
			</form>

			<hr />

			<h2><?php esc_html_e( 'Home Page', 'niswah-boutique' ); ?></h2>
			<?php
			$home_file   = $this->home_file();
			$has_home    = file_exists( $home_file );
			$home_id     = (int) get_option( self::HOME_ID_OPT );
			$home_exists = $home_id && get_post( $home_id );
			?>
			<table class="widefat striped" style="max-width:760px;margin-bottom:14px;">
				<tbody>
					<tr>
						<td><strong><?php esc_html_e( 'Bundled home layout', 'niswah-boutique' ); ?></strong></td>
						<td>
							<?php echo $has_home
								? '<span style="color:#127a3d;">' . esc_html__( 'Found', 'niswah-boutique' ) . '</span> — <code>data/home.json</code>'
								: '<span style="color:#b32d2e;">' . esc_html__( 'Missing', 'niswah-boutique' ) . '</span> — <code>data/home.json</code>'; ?>
						</td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'Home page', 'niswah-boutique' ); ?></strong></td>
						<td>
							<?php
							echo $home_exists
								? esc_html( sprintf( __( 'Exists — page #%d', 'niswah-boutique' ), $home_id ) )
								: esc_html__( 'Not created yet', 'niswah-boutique' );
							?>
						</td>
					</tr>
				</tbody>
			</table>

			<p>
				<strong><?php esc_html_e( 'This overwrites the Home page content.', 'niswah-boutique' ); ?></strong>
				<?php esc_html_e( 'Any edits made to the Home page in Divi will be replaced by the bundled layout. Sections needing client photography use a flat brand colour as a placeholder and are labelled SWAP in the Divi layers panel.', 'niswah-boutique' ); ?>
			</p>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="nb_starter_import_home" />
				<?php wp_nonce_field( self::NONCE_HOME ); ?>
				<?php
				submit_button(
					$home_exists
						? __( 'Re-import Home Page', 'niswah-boutique' )
						: __( 'Import Home Page', 'niswah-boutique' ),
					'secondary',
					'submit_home',
					false,
					$has_home ? array() : array( 'disabled' => 'disabled' )
				);
				?>
			</form>

			<hr />
			<p class="description">
				<?php esc_html_e( 'Alternative: Divi → Theme Builder → Portability → Import, using the same file. That route is Divi\'s own importer.', 'niswah-boutique' ); ?>
			</p>
		</div>
		<?php
	}

	public function handle_import() {
		if ( ! current_user_can( 'switch_themes' ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'niswah-boutique' ) );
		}
		check_admin_referer( self::NONCE );

		$result = $this->run_import();

		set_transient( 'nb_starter_result', $result, 60 );
		wp_safe_redirect( admin_url( 'themes.php?page=' . self::MENU_SLUG ) );
		exit;
	}

	/**
	 * Run both imports in one go: Theme Builder templates, then the Home page.
	 *
	 * Deliberately NOT hooked to after_switch_theme. Running automatically on
	 * activation would silently overwrite the client's Home page content every
	 * time the theme was switched or reactivated, which is not a surprise worth
	 * risking on a live site. It stays a button the user presses on purpose.
	 */
	public function handle_import_all() {
		if ( ! current_user_can( 'switch_themes' ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'niswah-boutique' ) );
		}
		check_admin_referer( self::NONCE_ALL );

		// Pages first: the nav menu built inside run_import() links to About Us.
		$pages       = class_exists( 'NB_Pages' ) ? NB_Pages::import() : array( 'type' => 'error', 'message' => 'NB_Pages missing.' );
		$templates   = $this->run_import();
		$home        = $this->run_import_home();
		$collections = $this->run_import_collections();
		$cats        = $this->backfill_category_images();

		$failed = array();
		if ( 'success' !== $pages['type'] ) {
			$failed[] = $pages['message'];
		}
		if ( 'success' !== $templates['type'] ) {
			$failed[] = $templates['message'];
		}
		if ( 'success' !== $home['type'] ) {
			$failed[] = $home['message'];
		}
		if ( 'success' !== $collections['type'] ) {
			$failed[] = $collections['message'];
		}

		if ( empty( $failed ) ) {
			$result = array(
				'type'    => 'success',
				'message' => $pages['message'] . ' ' . $templates['message'] . ' — ' . $home['message'] . ' ' . $collections['message'] . ' ' . sprintf(
					/* translators: 1: thumbnails set, 2: already had one, 3: no product image available */
					__( 'Category images: %1$d set, %2$d already had one, %3$d had no product image yet.', 'niswah-boutique' ),
					$cats['set'],
					$cats['skipped'],
					$cats['empty']
				),
			);
		} else {
			$result = array(
				'type'    => 'error',
				'message' => implode( ' | ', $failed ),
			);
		}

		set_transient( 'nb_starter_result', $result, 60 );
		wp_safe_redirect( admin_url( 'themes.php?page=' . self::MENU_SLUG ) );
		exit;
	}

	public function handle_import_home() {
		if ( ! current_user_can( 'switch_themes' ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'niswah-boutique' ) );
		}
		check_admin_referer( self::NONCE_HOME );

		$result = $this->run_import_home();

		set_transient( 'nb_starter_result', $result, 60 );
		wp_safe_redirect( admin_url( 'themes.php?page=' . self::MENU_SLUG ) );
		exit;
	}

	/**
	 * Create (or refresh) the Home page from the bundled layout and set it as
	 * the site's front page.
	 *
	 * Reuses the page it created last time rather than piling up duplicates.
	 * Content is overwritten on re-run, which is intentional while the layout
	 * is still being iterated on — the warning on the admin page says so.
	 *
	 * @return array{type:string,message:string}
	 */
	private function run_import_home() {
		$file = $this->home_file();

		if ( ! file_exists( $file ) ) {
			return array(
				'type'    => 'error',
				'message' => __( 'Bundled home layout is missing: data/home.json', 'niswah-boutique' ),
			);
		}

		$data = json_decode( file_get_contents( $file ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions

		if ( ! is_array( $data ) || empty( $data['page']['post_content'] ) ) {
			return array(
				'type'    => 'error',
				'message' => __( 'Bundled home layout could not be parsed.', 'niswah-boutique' ),
			);
		}

		$page      = $data['page'];
		$existing  = (int) get_option( self::HOME_ID_OPT );
		$is_update = $existing && get_post( $existing ) && 'trash' !== get_post_status( $existing );

		$postarr = array(
			'post_title'   => isset( $page['post_title'] ) ? $page['post_title'] : 'Home',
			'post_name'    => isset( $page['post_name'] ) ? $page['post_name'] : 'home',
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_content' => $page['post_content'],
		);

		if ( $is_update ) {
			$postarr['ID'] = $existing;
			$page_id       = wp_update_post( $postarr, true );
		} else {
			$page_id = wp_insert_post( $postarr, true );
		}

		if ( is_wp_error( $page_id ) ) {
			return array(
				'type'    => 'error',
				'message' => sprintf(
					/* translators: %s: error message */
					__( 'Could not create the Home page: %s', 'niswah-boutique' ),
					$page_id->get_error_message()
				),
			);
		}

		// Divi only renders the builder output when these are set on the page.
		if ( ! empty( $page['post_meta'] ) && is_array( $page['post_meta'] ) ) {
			foreach ( $page['post_meta'] as $meta ) {
				if ( isset( $meta['key'] ) ) {
					update_post_meta( $page_id, $meta['key'], isset( $meta['value'] ) ? $meta['value'] : '' );
				}
			}
		}
		update_post_meta( $page_id, '_et_pb_use_builder', 'on' );
		update_post_meta( $page_id, '_et_pb_page_layout', 'et_no_sidebar' );
		update_post_meta( $page_id, '_et_pb_side_nav', 'off' );

		update_option( self::HOME_ID_OPT, $page_id );

		$front_note = '';
		if ( ! empty( $page['set_as_front_page'] ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $page_id );
			$front_note = ' ' . __( 'Set as the site front page.', 'niswah-boutique' );
		}

		return array(
			'type'    => 'success',
			'message' => sprintf(
				/* translators: 1: created or updated, 2: page id, 3: front page note */
				__( 'Home page %1$s (#%2$d).%3$s', 'niswah-boutique' ),
				$is_update ? __( 'updated', 'niswah-boutique' ) : __( 'created', 'niswah-boutique' ),
				$page_id,
				$front_note
			),
		);
	}

	/**
	 * Build the main navigation menu from the real catalogue.
	 *
	 * The site has been running on WordPress's page fallback, which is why the
	 * nav read "Cart, Checkout, Sample Page, Uncategorized" — there was no menu
	 * in the database at all after the reset. This creates one containing Home,
	 * Collections, every non-empty product category, and Shop, then assigns it
	 * to Divi's primary location.
	 *
	 * Items are rebuilt on each run so the menu tracks the catalogue: add a
	 * category, re-run the import, and it appears. The menu itself is reused
	 * rather than recreated, so its id stays stable.
	 *
	 * @return array{id:int,items:int}
	 */
	private function ensure_main_menu() {
		$menu = wp_get_nav_menu_object( self::MENU_NAME );

		if ( ! $menu ) {
			$menu_id = wp_create_nav_menu( self::MENU_NAME );
			if ( is_wp_error( $menu_id ) ) {
				return array(
					'id'    => 0,
					'items' => 0,
				);
			}
		} else {
			$menu_id = (int) $menu->term_id;

			// Clear existing items so the menu mirrors the catalogue exactly.
			foreach ( wp_get_nav_menu_items( $menu_id ) as $item ) {
				wp_delete_post( $item->ID, true );
			}
		}

		$position = 0;
		$added    = 0;

		$add_item = function ( $args ) use ( $menu_id, &$position, &$added ) {
			$position++;
			$result = wp_update_nav_menu_item(
				$menu_id,
				0,
				array_merge(
					array(
						'menu-item-position' => $position,
						'menu-item-status'   => 'publish',
					),
					$args
				)
			);
			if ( ! is_wp_error( $result ) ) {
				$added++;
			}
		};

		// Home.
		$home_id = (int) get_option( self::HOME_ID_OPT );
		if ( $home_id && get_post( $home_id ) ) {
			$add_item(
				array(
					'menu-item-title'     => __( 'Home', 'niswah-boutique' ),
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $home_id,
					'menu-item-type'      => 'post_type',
				)
			);
		}

		// Collections.
		$collections_id = (int) get_option( self::COLLECTIONS_ID_OPT );
		if ( $collections_id && get_post( $collections_id ) ) {
			$add_item(
				array(
					'menu-item-title'     => __( 'Collections', 'niswah-boutique' ),
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $collections_id,
					'menu-item-type'      => 'post_type',
				)
			);
		}

		// About Us (client feedback 2026-09-04) — right after Collections.
		$about_id = class_exists( 'NB_Pages' ) ? NB_Pages::id( 'about-us' ) : 0;
		if ( $about_id && get_post( $about_id ) ) {
			$add_item(
				array(
					'menu-item-title'     => __( 'About Us', 'niswah-boutique' ),
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $about_id,
					'menu-item-type'      => 'post_type',
				)
			);
		}

		// Product categories: top-level ones in the client's own order (Sheet2 of
		// their spreadsheet, 2026-09-07), each with its sub-categories as a
		// dropdown. A flat list of every category produced a 35-item nav.
		if ( taxonomy_exists( 'product_cat' ) ) {
			$order = array( 'Premium', 'Hijab', 'Instant Hijab', 'Turbans', 'Essential', 'Prayer Essential', 'Kids',
				'Jewelry & Accessories', 'Sports Wear', 'Modest Wear', 'Gift Sets', 'Sale' );
			$terms = get_terms(
				array(
					'taxonomy'   => 'product_cat',
					'hide_empty' => true,
					'parent'     => 0,
					'orderby'    => 'name',
				)
			);

			if ( ! is_wp_error( $terms ) ) {
				usort(
					$terms,
					function ( $a, $b ) use ( $order ) {
						$ia = array_search( html_entity_decode( $a->name ), $order, true );
						$ib = array_search( html_entity_decode( $b->name ), $order, true );
						$ia = false === $ia ? 99 : $ia;
						$ib = false === $ib ? 99 : $ib;
						return $ia === $ib ? strcmp( $a->name, $b->name ) : $ia - $ib;
					}
				);
				foreach ( $terms as $term ) {
					if ( 'uncategorized' === $term->slug ) {
						continue;
					}
					$position++;
					$parent_item = wp_update_nav_menu_item(
						$menu_id,
						0,
						array(
							'menu-item-position'  => $position,
							'menu-item-status'    => 'publish',
							'menu-item-title'     => html_entity_decode( $term->name ),
							'menu-item-object'    => 'product_cat',
							'menu-item-object-id' => (int) $term->term_id,
							'menu-item-type'      => 'taxonomy',
						)
					);
					if ( is_wp_error( $parent_item ) ) {
						continue;
					}
					$added++;
					$children = get_terms(
						array(
							'taxonomy'   => 'product_cat',
							'hide_empty' => true,
							'parent'     => (int) $term->term_id,
							'orderby'    => 'name',
						)
					);
					if ( is_wp_error( $children ) ) {
						continue;
					}
					foreach ( $children as $child ) {
						$position++;
						$r = wp_update_nav_menu_item(
							$menu_id,
							0,
							array(
								'menu-item-position'  => $position,
								'menu-item-status'    => 'publish',
								'menu-item-parent-id' => (int) $parent_item,
								'menu-item-title'     => html_entity_decode( $child->name ),
								'menu-item-object'    => 'product_cat',
								'menu-item-object-id' => (int) $child->term_id,
								'menu-item-type'      => 'taxonomy',
							)
						);
						if ( ! is_wp_error( $r ) ) {
							$added++;
						}
					}
				}
			}
		}

		// No Shop link, by the client's decision: Collections plus the eleven
		// category links already cover every route into the catalogue, and a
		// generic "Shop" on the end of that list added nothing.

		// Assign to Divi's primary location so the fallback page list stops.
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		if ( ! is_array( $locations ) ) {
			$locations = array();
		}
		foreach ( array( 'primary-menu', 'primary' ) as $slug ) {
			$locations[ $slug ] = $menu_id;
		}
		set_theme_mod( 'nav_menu_locations', $locations );

		return array(
			'id'    => (int) $menu_id,
			'items' => $added,
		);
	}

	/**
	 * Give every product category a thumbnail, taken from one of its products.
	 *
	 * WooCommerce leaves category thumbnails empty unless someone sets each one
	 * by hand, and the collections page is nothing but category thumbnails — so
	 * without this it renders a grid of identical grey placeholders.
	 *
	 * Picks the newest published product in the category that actually has a
	 * featured image. Only fills empty thumbnails, so a category the client has
	 * set deliberately is never overwritten, and re-running is harmless.
	 *
	 * @return array{set:int,skipped:int,empty:int}
	 */
	private function backfill_category_images() {
		$stats = array(
			'set'     => 0,
			'skipped' => 0,
			'empty'   => 0,
		);

		if ( ! taxonomy_exists( 'product_cat' ) ) {
			return $stats;
		}

		$terms = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
			)
		);

		if ( is_wp_error( $terms ) ) {
			return $stats;
		}

		foreach ( $terms as $term ) {
			if ( 'uncategorized' === $term->slug ) {
				continue;
			}

			// Never clobber a thumbnail somebody chose on purpose.
			if ( get_term_meta( $term->term_id, 'thumbnail_id', true ) ) {
				$stats['skipped']++;
				continue;
			}

			$products = get_posts(
				array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => 10,
					'orderby'        => 'date',
					'order'          => 'DESC',
					'fields'         => 'ids',
					'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery
						array(
							'taxonomy' => 'product_cat',
							'field'    => 'term_id',
							'terms'    => $term->term_id,
						),
					),
				)
			);

			$thumb_id = 0;
			foreach ( $products as $product_id ) {
				$candidate = (int) get_post_thumbnail_id( $product_id );
				if ( $candidate ) {
					$thumb_id = $candidate;
					break;
				}
			}

			if ( ! $thumb_id ) {
				$stats['empty']++;
				continue;
			}

			update_term_meta( $term->term_id, 'thumbnail_id', $thumb_id );
			$stats['set']++;
		}

		return $stats;
	}

	/**
	 * Remove every Theme Builder template currently attached to Divi's Theme
	 * Builder container, along with the layout posts each one points at.
	 *
	 * Without this the importer appends, and running it twice leaves several
	 * templates all claiming to be the default — which is how three duplicate
	 * "Default Website Template" cards appeared. Re-importing is the main way
	 * this theme is iterated on, so it has to replace rather than stack.
	 *
	 * @return int Number of templates removed.
	 */
	private function cleanup_previous() {
		$tb_post_id = et_theme_builder_get_theme_builder_post_id( 'publish', false );
		if ( ! $tb_post_id ) {
			return 0;
		}

		$template_ids = get_post_meta( $tb_post_id, '_et_template', false );
		if ( empty( $template_ids ) ) {
			return 0;
		}

		$layout_meta = array( '_et_header_layout_id', '_et_body_layout_id', '_et_footer_layout_id' );
		$removed     = 0;

		foreach ( $template_ids as $template_id ) {
			$template_id = (int) $template_id;
			if ( ! $template_id ) {
				continue;
			}

			// Delete the layout posts this template points at.
			foreach ( $layout_meta as $key ) {
				$layout_id = (int) get_post_meta( $template_id, $key, true );
				if ( $layout_id && get_post( $layout_id ) ) {
					wp_delete_post( $layout_id, true );
				}
			}

			delete_post_meta( $tb_post_id, '_et_template', $template_id );

			if ( get_post( $template_id ) ) {
				wp_delete_post( $template_id, true );
			}

			$removed++;
		}

		delete_option( self::CREATED_OPT );

		return $removed;
	}

	/**
	 * Create the layout posts, wire them into a Theme Builder template, and
	 * attach that template to Divi's Theme Builder container post.
	 *
	 * Replaces any previous import first, so this is safe to run repeatedly.
	 *
	 * @return array{type:string,message:string}
	 */
	private function run_import() {
		if ( ! $this->divi_ready() ) {
			return array(
				'type'    => 'error',
				'message' => __( 'Divi Theme Builder API not found. Make sure Divi is the active parent theme.', 'niswah-boutique' ),
			);
		}

		$file = $this->data_file();
		if ( ! file_exists( $file ) ) {
			return array(
				'type'    => 'error',
				'message' => __( 'Bundled template file is missing: data/theme-builder.json', 'niswah-boutique' ),
			);
		}

		$raw  = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		$data = json_decode( $raw, true );

		if ( ! is_array( $data ) || empty( $data['templates'] ) || empty( $data['layouts'] ) ) {
			return array(
				'type'    => 'error',
				'message' => __( 'Bundled template file could not be parsed.', 'niswah-boutique' ),
			);
		}

		$post_types = array(
			'header' => ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE,
			'body'   => ET_THEME_BUILDER_BODY_LAYOUT_POST_TYPE,
			'footer' => ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE,
		);
		$meta_keys  = array(
			'header' => '_et_header_layout_id',
			'body'   => '_et_body_layout_id',
			'footer' => '_et_footer_layout_id',
		);

		// Replace, do not append.
		$removed = $this->cleanup_previous();

		// Build the nav before the header layout, so the real menu id is known
		// in time to be written into the menu module's shortcode below.
		$menu    = $this->ensure_main_menu();
		$menu_id = (int) $menu['id'];

		$template = $data['templates'][0];
		$created  = array();

		// 1. Create each referenced layout as its own post.
		$layout_ids = array();
		foreach ( array( 'header', 'body', 'footer' ) as $slot ) {
			$ref = isset( $template['layouts'][ $slot ]['id'] ) ? (string) $template['layouts'][ $slot ]['id'] : '0';

			if ( '0' === $ref || empty( $data['layouts'][ $ref ] ) ) {
				$layout_ids[ $slot ] = 0;
				continue;
			}

			$layout    = $data['layouts'][ $ref ];
			$shortcode = isset( $layout['data'][ $ref ] ) ? $layout['data'][ $ref ] : '';

			// Swap the generated placeholder menu id for the real one. The
			// header layout is built long before the menu exists, so it ships
			// with a sentinel; without this the Divi menu module points at a
			// menu that is not there and falls back to listing every page.
			if ( $menu_id && $shortcode ) {
				$shortcode = str_replace(
					'menu_id="' . self::MENU_PLACEHOLDER . '"',
					'menu_id="' . (int) $menu_id . '"',
					$shortcode
				);
			}

			if ( '' === $shortcode ) {
				$layout_ids[ $slot ] = 0;
				continue;
			}

			$new_id = wp_insert_post(
				array(
					'post_title'   => 'Niswah ' . ucfirst( $slot ),
					'post_type'    => $post_types[ $slot ],
					'post_status'  => 'publish',
					'post_content' => $shortcode,
				),
				true
			);

			if ( is_wp_error( $new_id ) ) {
				return array(
					'type'    => 'error',
					'message' => sprintf(
						/* translators: 1: slot name, 2: error message */
						__( 'Could not create the %1$s layout: %2$s', 'niswah-boutique' ),
						$slot,
						$new_id->get_error_message()
					),
				);
			}

			update_post_meta( $new_id, '_et_pb_use_builder', 'on' );
			update_post_meta( $new_id, '_et_pb_built_for_post_type', 'page' );

			$layout_ids[ $slot ] = $new_id;
			$created[]           = $slot;
		}

		if ( empty( $created ) ) {
			return array(
				'type'    => 'error',
				'message' => __( 'Nothing to import — no layouts found in the bundled file.', 'niswah-boutique' ),
			);
		}

		// 2. Create the Theme Builder template that points at those layouts.
		$template_id = wp_insert_post(
			array(
				'post_title'  => isset( $template['title'] ) ? $template['title'] : 'Niswah Template',
				'post_type'   => ET_THEME_BUILDER_TEMPLATE_POST_TYPE,
				'post_status' => 'publish',
			),
			true
		);

		if ( is_wp_error( $template_id ) ) {
			return array(
				'type'    => 'error',
				'message' => sprintf(
					/* translators: %s: error message */
					__( 'Could not create the Theme Builder template: %s', 'niswah-boutique' ),
					$template_id->get_error_message()
				),
			);
		}

		foreach ( $layout_ids as $slot => $id ) {
			update_post_meta( $template_id, $meta_keys[ $slot ], (int) $id );
			update_post_meta( $template_id, '_et_' . $slot . '_layout_enabled', true );
		}

		if ( ! empty( $template['default'] ) ) {
			update_post_meta( $template_id, '_et_default', true );
		}
		update_post_meta( $template_id, '_et_enabled', true );

		// 3. Attach the template to Divi's Theme Builder container post.
		$tb_post_id = et_theme_builder_get_theme_builder_post_id( 'publish', true );

		if ( ! $tb_post_id ) {
			return array(
				'type'    => 'error',
				'message' => __( 'Divi did not return a Theme Builder post to attach the template to.', 'niswah-boutique' ),
			);
		}

		add_post_meta( $tb_post_id, '_et_template', $template_id );

		update_option( self::DONE_OPT, current_time( 'mysql' ) );
		update_option(
			self::CREATED_OPT,
			array(
				'template' => $template_id,
				'layouts'  => array_filter( $layout_ids ),
			)
		);

		return array(
			'type'    => 'success',
			'message' => sprintf(
				/* translators: 1: number removed, 2: comma separated slots, 3: template id, 4: menu id, 5: menu item count */
				__( 'Replaced %1$d previous template(s). Imported: %2$s. Theme Builder template #%3$d created. Menu #%4$d built with %5$d items. Open Divi → Theme Builder and click Save Changes.', 'niswah-boutique' ),
				$removed,
				implode( ', ', $created ),
				$template_id,
				$menu_id,
				(int) $menu['items']
			),
		);
	}
}

new NB_Starter_Import();
