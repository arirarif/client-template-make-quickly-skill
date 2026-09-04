<?php
/**
 * "We accept" payment-method badges.
 *
 * Client ask (2026-09-04): "Display all available payment methods clearly on
 * the website." The list is read from the gateways WooCommerce actually has
 * enabled, so it is never a promise the checkout cannot keep: nothing shows
 * until a gateway is switched on, and a new gateway appears the moment it is.
 *
 * Rendered in three places:
 *   - footer bottom bar, via the [nb_payment_methods] shortcode in the
 *     generated footer layout
 *   - single product, under the add-to-cart form
 *   - checkout, above the payment options
 *
 * @package Niswah_Boutique
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NB_Payment_Methods {

	public static function init() {
		add_shortcode( 'nb_payment_methods', array( __CLASS__, 'shortcode' ) );
		add_action( 'woocommerce_after_add_to_cart_form', array( __CLASS__, 'render_product' ), 20 );
		add_action( 'woocommerce_review_order_before_payment', array( __CLASS__, 'render_checkout' ), 5 );
	}

	/**
	 * Enabled gateways as [ id => label ].
	 *
	 * Labels are short, customer-facing names rather than the gateway's own
	 * (often long) title. Unknown gateways fall back to their WooCommerce title.
	 *
	 * @return array
	 */
	public static function methods() {
		if ( ! function_exists( 'WC' ) || ! WC()->payment_gateways() ) {
			return array();
		}

		$labels = array(
			'cod'    => __( 'Cash on Delivery', 'niswah-boutique' ),
			'bacs'   => __( 'Bank Transfer', 'niswah-boutique' ),
			'cheque' => __( 'Cheque', 'niswah-boutique' ),
		);

		$out = array();
		foreach ( WC()->payment_gateways()->payment_gateways() as $gateway ) {
			if ( 'yes' !== $gateway->enabled ) {
				continue;
			}
			$id = $gateway->id;
			$out[ $id ] = isset( $labels[ $id ] ) ? $labels[ $id ] : wp_strip_all_tags( $gateway->get_title() );

			// Card gateways: say the card brands, which is what the customer looks for.
			if ( preg_match( '/stripe|card|qpay|sadad|skipcash|dibsy|tap|myfatoorah|paytabs|telr|checkout/i', $id ) ) {
				$out[ $id . '_visa' ]       = 'Visa';
				$out[ $id . '_mastercard' ] = 'Mastercard';
			}
		}

		/**
		 * Filter the badge list. Lets a future gateway add Apple Pay / Google Pay
		 * without touching the theme.
		 *
		 * @param array $out id => label
		 */
		return apply_filters( 'nb_payment_methods', $out );
	}

	/**
	 * @param string $context footer|product|checkout
	 * @return string
	 */
	public static function html( $context = 'footer' ) {
		$methods = self::methods();
		if ( ! $methods ) {
			return '';
		}

		$out  = '<div class="nb-payment nb-payment--' . esc_attr( $context ) . '">';
		$out .= '<span class="nb-payment__label">' . esc_html__( 'We accept', 'niswah-boutique' ) . '</span>';
		$out .= '<ul class="nb-payment__list">';
		foreach ( $methods as $id => $label ) {
			$out .= '<li class="nb-payment__item nb-payment__item--' . esc_attr( sanitize_html_class( $id ) ) . '">' . esc_html( $label ) . '</li>';
		}
		$out .= '</ul></div>';

		return $out;
	}

	public static function shortcode( $atts ) {
		$atts = shortcode_atts( array( 'context' => 'footer' ), $atts, 'nb_payment_methods' );
		return self::html( $atts['context'] );
	}

	public static function render_product() {
		echo self::html( 'product' ); // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts.
	}

	public static function render_checkout() {
		echo self::html( 'checkout' ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
}

NB_Payment_Methods::init();
