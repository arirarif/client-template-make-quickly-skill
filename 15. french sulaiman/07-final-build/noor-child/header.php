<?php
/**
 * Noor Festivities header — per 06-mockups:
 * espresso announce bar · ivory header with primary logo (mocha) · main nav ·
 * region switcher · account/cart icons. Mobile: burger + slide-in drawer.
 *
 * @package noor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$noor_logo    = function_exists( 'noor_header_logo_url' )
	? noor_header_logo_url()
	: get_stylesheet_directory_uri() . '/assets/img/logo-mocha.png';
$noor_shop    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/boutique/' );
$noor_account = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/mon-compte/' );
$noor_cart    = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/panier/' );
$noor_count   = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
/* Favourites live in YITH Wishlist. The icon only appears when that plugin is
 * active, so the header never points at a page that does not exist. No count
 * is shown next to it on purpose: the header is inside the page cache, and a
 * cached number would be wrong for the next visitor. */
$noor_wishlist = function_exists( 'yith_wcwl_object_id' ) || defined( 'YITH_WCWL' )
	? get_permalink( (int) get_option( 'yith_wcwl_wishlist_page_id' ) )
	: '';
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<?php /* Drawer state rules inline on purpose: CSS optimizers (UCSS/CCSS)
	   strip state classes like `.open` that never appear in the crawled DOM. */ ?>
	<style id="noor-critical">
		.noor-drawer{position:fixed;inset:0;z-index:1000;pointer-events:none}
		.noor-drawer.open{pointer-events:auto}
		.noor-drawer-backdrop{position:absolute;inset:0;z-index:1;background:rgba(46,26,13,.55);opacity:0;transition:opacity .3s}
		.noor-drawer.open .noor-drawer-backdrop{opacity:1}
		.noor-drawer-panel{position:absolute;z-index:2;top:0;bottom:0;left:0;width:min(320px,86vw);background:#FAF6F1;transform:translateX(-100%);transition:transform .3s;overflow-y:auto;display:flex;flex-direction:column}
		.noor-drawer.open .noor-drawer-panel{transform:none}
		.noor-region-switcher.open .noor-region-menu{display:block}
	</style>
</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#noor-content"><?php esc_html_e( 'Aller au contenu', 'noor' ); ?></a>

<?php
$noor_announce_show = get_theme_mod( 'noor_announce_show', true );
$noor_announce_text = get_theme_mod( 'noor_announce_text', '✨ <b>' . __( 'Livraison offerte', 'noor' ) . '</b> ' . __( 'dès 50€ à La Réunion', 'noor' ) );
if ( $noor_announce_show && trim( $noor_announce_text ) ) : ?>
<div class="noor-announce">
	<?php echo wp_kses( $noor_announce_text, array( 'b' => array(), 'strong' => array(), 'em' => array(), 'a' => array( 'href' => array() ) ) ); ?>
</div>
<?php endif; ?>

<header class="noor-header">
	<div class="noor-wrap noor-header-in">
		<button class="noor-burger" aria-label="<?php esc_attr_e( 'Ouvrir le menu', 'noor' ); ?>" aria-expanded="false" aria-controls="noor-drawer">
			<span></span><span></span><span></span>
		</button>

		<a class="noor-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img src="<?php echo esc_url( $noor_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
		</a>

		<nav class="noor-nav" aria-label="<?php esc_attr_e( 'Navigation principale', 'noor' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'noor-main',
					'container'      => false,
					'menu_class'     => 'noor-menu',
					'fallback_cb'    => false,
					'depth'          => 2,
				)
			);
			?>
		</nav>

		<div class="noor-actions">
			<?php echo do_shortcode( '[noor_region_switcher]' ); ?>
			<?php if ( $noor_wishlist ) : ?>
				<a class="noor-hicon noor-hicon--wish" href="<?php echo esc_url( $noor_wishlist ); ?>" aria-label="<?php esc_attr_e( 'Mes favoris', 'noor' ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1L12 21.2l7.7-7.8 1.1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
				</a>
			<?php endif; ?>
			<a class="noor-hicon" href="<?php echo esc_url( $noor_account ); ?>" aria-label="<?php esc_attr_e( 'Mon compte', 'noor' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
			</a>
			<a class="noor-hicon" href="<?php echo esc_url( $noor_cart ); ?>" aria-label="<?php esc_attr_e( 'Panier', 'noor' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
				<?php if ( $noor_count ) : ?><span class="noor-count"><?php echo esc_html( $noor_count ); ?></span><?php endif; ?>
			</a>
		</div>
	</div>
</header>

<div id="noor-drawer" class="noor-drawer" aria-hidden="true">
	<div class="noor-drawer-backdrop"></div>
	<div class="noor-drawer-panel">
		<div class="noor-drawer-head">
			<img src="<?php echo esc_url( $noor_logo ); ?>" alt="" class="noor-drawer-logo">
			<button class="noor-drawer-close" aria-label="<?php esc_attr_e( 'Fermer le menu', 'noor' ); ?>">✕</button>
		</div>
		<nav class="noor-drawer-nav" aria-label="<?php esc_attr_e( 'Menu mobile', 'noor' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'noor-main',
					'container'      => false,
					'menu_class'     => 'noor-drawer-menu',
					'fallback_cb'    => false,
					'depth'          => 2,
				)
			);
			?>
		</nav>
		<div class="noor-drawer-foot">
			<a class="noor-btn-drawer" href="<?php echo esc_url( $noor_shop ); ?>"><?php esc_html_e( 'Découvrir la boutique', 'noor' ); ?></a>
		</div>
	</div>
</div>

<div id="noor-content">
