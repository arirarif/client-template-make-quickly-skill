<?php
/**
 * Atomic Blue — Single Product
 * Overrides woocommerce/single-product.php.
 * Renders the WC product gallery + add-to-cart form + tabs + related
 * inside our 2-col PDP design. All WC hooks intact so variations,
 * reviews, AJAX add-to-cart, and gallery zoom keep working.
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

while ( have_posts() ) :
    the_post();
    global $product;

    if ( ! $product instanceof WC_Product ) {
        continue;
    }

    $sku        = $product->get_sku();
    $cat_terms  = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
    $cat_label  = $cat_terms ? $cat_terms[0] : __( 'Peptide', 'woodmart-child' );
    $shop_url   = get_permalink( wc_get_page_id( 'shop' ) );
    ?>

    <main class="atomic-pdp-main">

        <section class="wrap pdp">

            <!-- BREADCRUMBS -->
            <p class="eyebrow" style="margin-bottom: 24px;">
                <a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop', 'woodmart-child' ); ?></a> /
                <?php if ( $cat_terms ) : ?>
                    <span><?php echo esc_html( $cat_label ); ?></span> /
                <?php endif; ?>
                <span style="color: var(--pp-paper);"><?php the_title(); ?></span>
            </p>

            <div class="two-col" style="grid-template-columns: 1fr 1fr;">

                <!-- LEFT: Gallery -->
                <div class="gallery">
                    <?php
                    /**
                     * Hook: woocommerce_before_single_product_summary
                     *
                     * @hooked woocommerce_show_product_sale_flash - 10
                     * @hooked woocommerce_show_product_images - 20
                     */
                    do_action( 'woocommerce_before_single_product_summary' );
                    ?>
                </div>

                <!-- RIGHT: Info -->
                <div class="pdp-info summary entry-summary">
                    <p class="formula">
                        <?php echo esc_html( $sku ?: 'PEPTIDE' ); ?>
                        <?php if ( $cat_terms ) : ?>
                            · <?php echo esc_html( strtoupper( $cat_label ) ); ?>
                        <?php endif; ?>
                    </p>

                    <?php
                    /**
                     * Hook: woocommerce_single_product_summary
                     *
                     * @hooked woocommerce_template_single_title - 5
                     * @hooked woocommerce_template_single_rating - 10
                     * @hooked woocommerce_template_single_price - 10
                     * @hooked woocommerce_template_single_excerpt - 20
                     * @hooked woocommerce_template_single_add_to_cart - 30
                     * @hooked woocommerce_template_single_meta - 40
                     * @hooked woocommerce_template_single_sharing - 50
                     */
                    do_action( 'woocommerce_single_product_summary' );
                    ?>

                    <?php if ( $sku ) : ?>
                        <p style="font: 800 12px Arial,sans-serif; opacity:.6; margin: 8px 0 0;">
                            SKU <?php echo esc_html( $sku ); ?>
                            <?php if ( $product->get_stock_status() === 'instock' ) : ?> · <span style="color: var(--pp-glow);">In Stock</span><?php endif; ?>
                        </p>
                    <?php endif; ?>
                </div>

            </div>

            <!-- TABS -->
            <?php
            /**
             * Hook: woocommerce_after_single_product_summary
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_upsell_display - 15
             * @hooked woocommerce_output_related_products - 20
             */
            do_action( 'woocommerce_after_single_product_summary' );
            ?>

        </section>

    </main>

    <?php
endwhile;

get_footer( 'shop' );
