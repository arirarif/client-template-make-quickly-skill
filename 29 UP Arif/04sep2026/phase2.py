import os, sys
os.chdir(os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'niswah-boutique'))

def patch(path, pairs):
    s = open(path, encoding='utf8').read()
    for old, new in pairs:
        assert s.count(old) == 1, (path, old[:70], s.count(old))
        s = s.replace(old, new)
    open(path, 'w', encoding='utf8').write(s)

# ---------- functions.php ----------
patch('functions.php', [
("NB_THEME_VERSION', '0.11.1'", "NB_THEME_VERSION', '0.12.0'"),
("""if ( is_admin() ) {
	$nb_importer = NB_THEME_DIR . '/includes/class-nb-starter-import.php';
	if ( file_exists( $nb_importer ) ) {
		require_once $nb_importer;
	}
}""", """if ( is_admin() ) {
	$nb_importer = NB_THEME_DIR . '/includes/class-nb-starter-import.php';
	if ( file_exists( $nb_importer ) ) {
		require_once $nb_importer;
	}
}

/**
 * Round 2 (client feedback 2026-09-04).
 *
 * Bundled static pages (About, Contact, policies) and the "We accept"
 * payment badges. Pages are imported by Niswah Starter; badges render on the
 * front end, so both load everywhere.
 */
foreach ( array( 'class-nb-pages.php', 'class-nb-payment-methods.php' ) as $nb_inc ) {
	$nb_inc = NB_THEME_DIR . '/includes/' . $nb_inc;
	if ( file_exists( $nb_inc ) ) {
		require_once $nb_inc;
	}
}"""),
])

# ---------- importer ----------
patch('includes/class-nb-starter-import.php', [
("""		check_admin_referer( self::NONCE_ALL );

		$templates   = $this->run_import();
		$home        = $this->run_import_home();
		$collections = $this->run_import_collections();
		$cats        = $this->backfill_category_images();

		$failed = array();
		if ( 'success' !== $templates['type'] ) {""", """		check_admin_referer( self::NONCE_ALL );

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
		if ( 'success' !== $templates['type'] ) {"""),
("""				'message' => $templates['message'] . ' — ' . $home['message'] . ' ' . $collections['message'] . ' ' . sprintf(""",
 """				'message' => $pages['message'] . ' ' . $templates['message'] . ' — ' . $home['message'] . ' ' . $collections['message'] . ' ' . sprintf("""),
("""		// Every product category that actually has stock in it. Uncategorized is""",
"""		// About Us (client feedback 2026-09-04) — right after Collections.
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

		// Every product category that actually has stock in it. Uncategorized is"""),
])

# ---------- generator ----------
g = open('build/theme-builder.build.mjs', encoding='utf8').read()
a = g.index('const footerMain = row(')
b = g.index('// ---------------------------------------------------------------------------\n// HOME PAGE')
new_footer = open(os.path.join(os.path.dirname(os.path.abspath(__file__)), 'footer.mjs.txt'), encoding='utf8').read()
g = g[:a] + new_footer + g[b:]
open('build/theme-builder.build.mjs', 'w', encoding='utf8').write(g)

# ---------- style.css ----------
s = open('style.css', encoding='utf8').read()
assert s.count(' Version:        0.11.1') == 1
s = s.replace(' Version:        0.11.1', ' Version:        0.12.0', 1)
s += open(os.path.join(os.path.dirname(os.path.abspath(__file__)), 'phase2.css.txt'), encoding='utf8').read()
open('style.css', 'w', encoding='utf8').write(s)
print('patched')
