<?php
/**
 * Product image ratio by category.
 *
 * Client ask (2026-09-04): "Hijabs & Accessories: 1:1. Jilbab, Coord Sets,
 * Dresses, etc.: 1:2." Until now every card and gallery frame was 2:3.
 *
 * Mechanism: a class on each product card (li.product) and on <body> for the
 * single product and category pages — nb-ratio-square or nb-ratio-tall — and
 * CSS aspect-ratio rules keyed off it (style.css §16). No image is re-cropped
 * per ratio: thumbnails are now generated UNcropped (functions.php image
 * sizes) and object-fit: cover fills whichever frame the card has, so one set
 * of files serves both ratios.
 *
 * @package Niswah_Boutique
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NB_Image_Ratios {

	/** Category slugs whose products show square (1:1). Everything else is 1:2. */
	const SQUARE_CATS = array( 'hijabs', 'hijab-caps', 'jewellery', 'accessories' );

	public static function init() {
		add_filter( 'woocommerce_post_class', array( __CLASS__, 'product_class' ), 20, 2 );
		add_filter( 'body_class', array( __CLASS__, 'body_class' ), 30 );
	}

	/**
	 * @param int|WC_Product $product
	 * @return string square|tall
	 */
	public static function ratio_for_product( $product ) {
		$id = $product instanceof WC_Product ? $product->get_id() : (int) $product;
		if ( ! $id ) {
			return 'tall';
		}
		// Variations carry no categories; look at the parent.
		$parent = wp_get_post_parent_id( $id );
		if ( $parent ) {
			$id = $parent;
		}
		$slugs = apply_filters( 'nb_square_ratio_categories', self::SQUARE_CATS );
		return has_term( $slugs, 'product_cat', $id ) ? 'square' : 'tall';
	}

	/**
	 * @param string|WP_Term $term
	 * @return string square|tall
	 */
	public static function ratio_for_category( $term ) {
		$slug  = $term instanceof WP_Term ? $term->slug : (string) $term;
		$slugs = apply_filters( 'nb_square_ratio_categories', self::SQUARE_CATS );
		return in_array( $slug, $slugs, true ) ? 'square' : 'tall';
	}

	public static function product_class( $classes, $product ) {
		if ( $product instanceof WC_Product ) {
			$classes[] = 'nb-ratio-' . self::ratio_for_product( $product );
		}
		return $classes;
	}

	public static function body_class( $classes ) {
		if ( function_exists( 'is_product' ) && is_product() ) {
			$classes[] = 'nb-ratio-' . self::ratio_for_product( get_queried_object_id() );
		} elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
			$classes[] = 'nb-archive-ratio-' . self::ratio_for_category( get_queried_object() );
		}
		return $classes;
	}
}

NB_Image_Ratios::init();
