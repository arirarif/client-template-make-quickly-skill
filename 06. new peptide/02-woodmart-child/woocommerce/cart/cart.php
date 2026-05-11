<?php
/**
 * Atomic Blue — Cart
 * Overrides woocommerce/cart/cart.php.
 * Wraps WC's standard cart form + collaterals in our hero + 2-col layout.
 * All WC hooks preserved so AJAX update / coupon / fees keep working.
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

// Empty cart? Render WC's empty template inside our hero shell.
if ( WC()->cart->is_empty() ) {
    ?>
    <main class="atomic-cart-main">
        <section class="wrap" style="padding: 80px 20px 60px;">
            <p class="eyebrow">Cart</p>
            <h1>Your Vault Is Empty.</h1>
            <p class="lead">Nothing loaded yet. Browse the catalogue and start filling the bench.</p>
            <div class="actions">
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn">Browse the Vault →</a>
            </div>
        </section>
        <section class="wrap section">
            <?php do_action( 'woocommerce_cart_is_empty' ); ?>
        </section>
    </main>
    <?php
    get_footer( 'shop' );
    return;
}

do_action( 'woocommerce_before_cart' );

$cart_count = WC()->cart->get_cart_contents_count();
?>

<main class="atomic-cart-main">

    <!-- HERO -->
    <section class="wrap" style="padding: 60px 20px 30px;">
        <p class="eyebrow">Stage 1 of 3 · Cart</p>
        <h1>Your Vault.<br><?php echo esc_html( $cart_count ); ?> <?php echo $cart_count === 1 ? 'Compound' : 'Compounds'; ?> Loaded.</h1>
    </section>

    <section class="wrap section" style="padding-top: 0;">
        <div class="two-col">

            <!-- LEFT: Cart form -->
            <div>
                <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                    <?php do_action( 'woocommerce_before_cart_table' ); ?>

                    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="product-remove">&nbsp;</th>
                                <th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name"><?php esc_html_e( 'Compound', 'woocommerce' ); ?></th>
                                <th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
                                <th class="product-quantity"><?php esc_html_e( 'Qty', 'woocommerce' ); ?></th>
                                <th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                            <?php
                            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                                $product_link = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

                                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                    ?>
                                    <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                                        <td class="product-remove">
                                            <?php
                                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                'woocommerce_cart_item_remove_link',
                                                sprintf(
                                                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                    esc_attr__( 'Remove this item', 'woocommerce' ),
                                                    esc_attr( $product_id ),
                                                    esc_attr( $_product->get_sku() )
                                                ),
                                                $cart_item_key
                                            );
                                            ?>
                                        </td>

                                        <td class="product-thumbnail">
                                            <?php
                                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                            if ( ! $product_link ) {
                                                echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            } else {
                                                printf( '<a href="%s">%s</a>', esc_url( $product_link ), $thumbnail ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            }
                                            ?>
                                        </td>

                                        <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                                            <?php
                                            if ( ! $product_link ) {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                            } else {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" style="font:900 16px Arial,sans-serif; text-transform:uppercase;">%s</a>', esc_url( $product_link ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                            }

                                            do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                            // Meta data.
                                            echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

                                            // SKU display.
                                            if ( $_product->get_sku() ) {
                                                echo '<div style="font:800 12px Arial,sans-serif; opacity:.6; margin-top:4px;">SKU: ' . esc_html( $_product->get_sku() ) . '</div>';
                                            }
                                            ?>
                                        </td>

                                        <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                                            <?php
                                            echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            ?>
                                        </td>

                                        <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                                            <?php
                                            if ( $_product->is_sold_individually() ) {
                                                $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                            } else {
                                                $product_quantity = woocommerce_quantity_input(
                                                    array(
                                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                                        'input_value'  => $cart_item['quantity'],
                                                        'max_value'    => $_product->get_max_purchase_quantity(),
                                                        'min_value'    => '0',
                                                        'product_name' => $_product->get_name(),
                                                    ),
                                                    $_product,
                                                    false
                                                );
                                            }
                                            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            ?>
                                        </td>

                                        <td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
                                            <strong><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                            <?php do_action( 'woocommerce_cart_contents' ); ?>

                            <tr>
                                <td colspan="6" class="actions">
                                    <?php if ( wc_coupons_enabled() ) : ?>
                                        <div class="coupon">
                                            <label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
                                            <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code · e.g. VAULT20', 'woocommerce' ); ?>" />
                                            <button type="submit" class="btn secondary" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply', 'woocommerce' ); ?></button>
                                            <?php do_action( 'woocommerce_cart_coupon' ); ?>
                                        </div>
                                    <?php endif; ?>

                                    <button type="submit" class="btn secondary" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>" style="margin-top:14px;"><?php esc_html_e( 'Update Cart', 'woocommerce' ); ?></button>
                                    <?php do_action( 'woocommerce_cart_actions' ); ?>
                                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                                </td>
                            </tr>

                            <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                        </tbody>
                    </table>

                    <?php do_action( 'woocommerce_after_cart_table' ); ?>
                </form>
            </div>

            <!-- RIGHT: Order summary -->
            <aside class="summary-card cart-collaterals">
                <h3>Order Summary</h3>
                <?php
                /**
                 * Render cart-totals.php directly so the panel matches our design.
                 * `woocommerce_cart_collaterals` would also fire cross-sells inside
                 * the panel, which we render below the layout instead.
                 */
                wc_get_template( 'cart/cart-totals.php' );
                ?>

                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn secondary" style="display:block; width:100%; text-align:center; margin-top: 14px;">
                    ← <?php esc_html_e( 'Continue Shopping', 'woodmart-child' ); ?>
                </a>

                <p style="margin: 18px 0 0; font: 800 12px Arial,sans-serif; opacity:.7;">⚛ Same-day dispatch on orders before 3 PM. Tracked, discreet packaging.</p>
            </aside>

        </div>

        <?php
        // Cross-sells below the layout.
        if ( function_exists( 'woocommerce_cross_sell_display' ) ) {
            woocommerce_cross_sell_display();
        }
        ?>
    </section>
</main>

<?php
do_action( 'woocommerce_after_cart' );
get_footer( 'shop' );
