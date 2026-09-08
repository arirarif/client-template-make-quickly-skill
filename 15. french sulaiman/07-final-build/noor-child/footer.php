<?php
/**
 * Noor Festivities footer — per 06-mockups: espresso background, ivory logo +
 * tagline, Boutique / Informations columns, newsletter, bottom line.
 * Closes #noor-content opened in header.php.
 *
 * @package noor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$noor_logo_ivory = function_exists( 'noor_footer_logo_url' )
	? noor_footer_logo_url()
	: get_stylesheet_directory_uri() . '/assets/img/logo-ivory.png';
$noor_shop       = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/boutique/' );
?>
</div><!-- #noor-content -->

<footer class="noor-footer">
	<div class="noor-wrap noor-footer-in">
		<div class="noor-foot-brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo esc_url( $noor_logo_ivory ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			</a>
			<p><?php echo esc_html( get_theme_mod(
				'noor_footer_tagline',
				__( 'Décorations et matériel de célébration premium pour toutes vos fêtes — Eid, Nikkah, Aqiqah, Hajj & Umrah.', 'noor' )
			) ); ?></p>
		</div>

		<div class="noor-foot-col">
			<h4><?php esc_html_e( 'Boutique', 'noor' ); ?></h4>
			<ul>
				<li><a href="<?php echo esc_url( $noor_shop ); ?>"><?php esc_html_e( 'Toutes les collections', 'noor' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/location/' ) ); ?>"><?php esc_html_e( 'Location (Réunion)', 'noor' ); ?></a></li>
				<li><a href="<?php echo esc_url( add_query_arg( 'orderby', 'date', $noor_shop ) ); ?>"><?php esc_html_e( 'Nouveautés', 'noor' ); ?></a></li>
				<li><a href="<?php echo esc_url( add_query_arg( 'on_sale', '1', $noor_shop ) ); ?>"><?php esc_html_e( 'Promotions', 'noor' ); ?></a></li>
			</ul>
		</div>

		<div class="noor-foot-col">
			<h4><?php esc_html_e( 'Informations', 'noor' ); ?></h4>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'noor-footer',
					'container'      => false,
					'menu_class'     => 'noor-foot-menu',
					'fallback_cb'    => function () {
						echo '<ul class="noor-foot-menu">';
						echo '<li><a href="' . esc_url( home_url( '/livraison/' ) ) . '">' . esc_html__( 'Livraison', 'noor' ) . '</a></li>';
						echo '<li><a href="' . esc_url( home_url( '/retours/' ) ) . '">' . esc_html__( 'Retours', 'noor' ) . '</a></li>';
						echo '<li><a href="' . esc_url( home_url( '/cgv/' ) ) . '">' . esc_html__( 'CGV', 'noor' ) . '</a></li>';
						echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">' . esc_html__( 'Contact', 'noor' ) . '</a></li>';
						echo '</ul>';
					},
					'depth'          => 1,
				)
			);
			?>
		</div>

		<div class="noor-foot-col noor-foot-news">
			<h4><?php esc_html_e( 'Newsletter', 'noor' ); ?></h4>
			<form class="noor-foot-form" action="#" method="post">
				<input type="email" name="noor_newsletter_email" placeholder="<?php esc_attr_e( 'E-mail', 'noor' ); ?>" required>
				<button type="submit" class="noor-foot-submit"><?php esc_html_e( 'S’inscrire', 'noor' ); ?></button>
			</form>
		</div>
	</div>

	<div class="noor-foot-bottom">
		© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?> · La Réunion 🇷🇪 · <?php esc_html_e( 'Paiement sécurisé', 'noor' ); ?> 💳
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
