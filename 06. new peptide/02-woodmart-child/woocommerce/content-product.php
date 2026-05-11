<?php
/**
 * Atomic Blue — Product card (loop item)
 * Overrides woodmart/woocommerce/content-product.php.
 * Renders the .product card markup matching the Atomic Blue mockup.
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product instanceof WC_Product || ! $product->is_visible() ) {
    return;
}

// Choose a single contextual tag for the photo corner.
$tag = '';
if ( ! $product->is_in_stock() ) {
    $tag = __( 'Sold Out', 'woodmart-child' );
} elseif ( $product->is_on_sale() ) {
    $tag = __( 'Sale', 'woodmart-child' );
} elseif ( $product->is_featured() ) {
    $tag = __( 'Featured', 'woodmart-child' );
}

// Primary category label for the .category-line row.
$cat_terms = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
$cat_label = $cat_terms ? $cat_terms[0] : __( 'Peptide', 'woodmart-child' );

$sku  = $product->get_sku();
$desc = wp_trim_words(
    wp_strip_all_tags(
        $product->get_short_description() ?: $product->get_description()
    ),
    18
);
?>
<div class="product" data-id="<?php echo esc_attr( $product->get_id() ); ?>">
    <a href="<?php the_permalink(); ?>" class="product-photo" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
        <?php if ( $tag ) : ?>
            <span class="tag"><?php echo esc_html( $tag ); ?></span>
        <?php endif; ?>
        <?php echo $product->get_image( 'woocommerce_thumbnail' ); ?>
    </a>

    <p class="formula"><?php echo esc_html( $sku ?: 'PEPTIDE' ); ?></p>

    <p class="category-line">
        <span class="cat-atom" aria-hidden="true">⚛</span>
        <?php echo esc_html( $cat_label ); ?>
    </p>

    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

    <p class="product-desc"><?php echo esc_html( $desc ); ?></p>

    <div class="buy">
        <span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
        <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
           class="add add_to_cart_button<?php echo $product->is_type( 'simple' ) ? ' ajax_add_to_cart' : ''; ?>"
           data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
           data-product_sku="<?php echo esc_attr( $sku ); ?>"
           rel="nofollow">
            <?php echo esc_html( $product->add_to_cart_text() ?: __( 'Add', 'woodmart-child' ) ); ?>
        </a>
    </div>
</div>
