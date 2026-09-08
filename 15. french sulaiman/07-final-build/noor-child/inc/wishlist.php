<?php
/**
 * NOOR — Wishlist wording.
 *
 * The wishlist itself is YITH WooCommerce Wishlist (installed as a plugin at
 * the client's request) and it already ships a French translation. That
 * translation says "liste d'envies" / "liste de souhaits", while the rest of
 * the site says "favoris" — including the page and the heart in the header.
 * These few strings line the plugin up with the site vocabulary.
 *
 * Styling for the plugin markup lives in assets/css/woocommerce.css.
 *
 * @package Noor_Child
 */

defined( 'ABSPATH' ) || exit;

/* The heading printed above the table is the wishlist record's own name, which
 * comes from the database rather than from a translated string, so gettext
 * cannot reach it. */
foreach ( array( 'yith_wcwl_wishlist_title', 'yith_wcwl_wishlist_page_title' ) as $noor_wishlist_title_filter ) {
	add_filter( $noor_wishlist_title_filter, function () {
		return 'Mes favoris';
	}, 20 );
}

add_filter( 'gettext', function ( $translated, $original, $domain ) {
	if ( 'yith-woocommerce-wishlist' !== $domain ) {
		return $translated;
	}
	$map = array(
		'Add to wishlist'                          => 'Ajouter aux favoris',
		'Add to Wishlist'                          => 'Ajouter aux favoris',
		'Browse wishlist'                          => 'Voir mes favoris',
		'Wishlist'                                 => 'Mes favoris',
		'My wishlist'                              => 'Mes favoris',
		'My Wishlist'                              => 'Mes favoris',
		'My wishlist on %s'                        => 'Mes favoris sur %s',
		'Remove this product'                      => 'Retirer ce produit',
		'Remove'                                   => 'Retirer',
		'Product added to wishlist'                => 'Produit ajouté à vos favoris',
		'Product already in wishlist'              => 'Ce produit est déjà dans vos favoris',
		'The product is already in your wishlist!' => 'Ce produit est déjà dans vos favoris.',
		'Product added to your wishlist!'          => 'Produit ajouté à vos favoris.',
		'Product removed from wishlist'            => 'Produit retiré de vos favoris',
		'No products were added to the wishlist'   => 'Vous n’avez pas encore de favoris.',
		'Share on:'                                => 'Partager :',
		'Product name'                             => 'Produit',
		'Unit price'                               => 'Prix',
		'Stock status'                             => 'Disponibilité',
	);
	return isset( $map[ $original ] ) ? $map[ $original ] : $translated;
}, 20, 3 );

/* The button wording does not come from a translated string at all: the plugin
 * stores it in options and hands it to its JavaScript, which draws the button.
 * Setting the options is precise — an earlier attempt that rewrote the French
 * text produced nonsense like "Selectionnez une favoris". */
$noor_wishlist_labels = array(
	'yith_wcwl_add_to_wishlist_text'      => 'Ajouter aux favoris',
	'yith_wcwl_product_added_text'        => 'Ajouté à vos favoris !',
	'yith_wcwl_browse_wishlist_text'      => 'Voir mes favoris',
	'yith_wcwl_already_in_wishlist_text'  => 'Déjà dans vos favoris',
	'yith_wcwl_product_already_in_wishlist_text' => 'Déjà dans vos favoris',
	'yith_wcwl_remove_from_wishlist_text' => 'Retirer des favoris',
);
foreach ( $noor_wishlist_labels as $noor_wishlist_option => $noor_wishlist_value ) {
	$noor_wishlist_setter = function () use ( $noor_wishlist_value ) {
		return $noor_wishlist_value;
	};
	add_filter( 'option_' . $noor_wishlist_option, $noor_wishlist_setter, 20 );
	add_filter( 'default_option_' . $noor_wishlist_option, $noor_wishlist_setter, 20 );
}
