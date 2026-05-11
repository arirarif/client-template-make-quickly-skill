<?php
/**
 * Atomic Blue — Checkout
 * Overrides woocommerce/checkout/form-checkout.php.
 * Wraps WC's billing / shipping / payment in our 2-col layout. All WC
 * hooks (woocommerce_checkout_billing / shipping / order_review etc.)
 * are preserved so payment gateways and validation keep working.
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}
?>

<main class="atomic-checkout-main">

    <!-- HERO -->
    <section class="wrap" style="padding: 60px 20px 30px;">
        <p class="eyebrow">Stage 2 of 3 · Checkout</p>
        <h1>Final Stretch.<br>Secure Checkout.</h1>
    </section>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

        <section class="wrap section" style="padding-top: 0;">
            <div class="two-col">

                <!-- LEFT: Billing / Shipping -->
                <div>
                    <?php if ( $checkout->get_checkout_fields() ) : ?>
                        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                        <div class="form-card">
                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        </div>

                        <div class="form-card">
                            <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                        </div>

                        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                    <?php endif; ?>
                </div>

                <!-- RIGHT: Order review (sticky on desktop) -->
                <aside class="summary-card" style="position: sticky; top: 20px;">
                    <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

                    <h3 id="order_review_heading"><?php esc_html_e( 'Your Order', 'woocommerce' ); ?></h3>

                    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                    </div>

                    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

                    <p style="margin: 16px 0 0; font: 800 12px Arial,sans-serif; opacity:.7;">🔒 SSL secured · Discreet packaging · 24h dispatch</p>
                </aside>

            </div>
        </section>

    </form>

</main>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
