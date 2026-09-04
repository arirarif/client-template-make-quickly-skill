<?php
/**
 * Qatar "blue plate" address format at checkout, plus the tax disclosure line.
 *
 * Client ask (2026-09-04): checkout address fields should follow the Qatar
 * address format — Zone, Street, Building No., Unit/Flat No. — and be easy to
 * fill. State/County and Postcode are meaningless in Qatar and were shown as
 * required.
 *
 * How it maps onto WooCommerce's fixed address keys, so that every place that
 * prints an address (order emails, admin, My Account, packing slips) keeps
 * working without a template override:
 *
 *   address_1  -> Zone            (relabelled via the QA country locale)
 *   address_2  -> Street          (relabelled, made required)
 *   building_no, unit_no          (new fields, saved as _billing_/_shipping_ meta)
 *   city       -> Area / City
 *   state, postcode               (hidden, not required)
 *
 * The QA address *format* is rewritten so the stored values print as
 * "Zone 25, Street 850 / Building 12, Unit 4 / Doha / Qatar".
 *
 * @package Niswah_Boutique
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class NB_Qatar_Checkout {

	public static function init() {
		add_filter( 'woocommerce_get_country_locale', array( __CLASS__, 'locale' ) );
		add_filter( 'woocommerce_billing_fields', array( __CLASS__, 'billing_fields' ), 20 );
		add_filter( 'woocommerce_shipping_fields', array( __CLASS__, 'shipping_fields' ), 20 );
		add_action( 'woocommerce_after_checkout_validation', array( __CLASS__, 'validate' ), 10, 2 );
		add_filter( 'woocommerce_checkout_fields', array( __CLASS__, 'checkout_fields' ), 99 );
		add_action( 'admin_init', array( __CLASS__, 'phone_setting' ) );

		add_filter( 'woocommerce_admin_billing_fields', array( __CLASS__, 'admin_fields' ), 20 );
		add_filter( 'woocommerce_admin_shipping_fields', array( __CLASS__, 'admin_fields' ), 20 );

		add_filter( 'woocommerce_order_formatted_billing_address', array( __CLASS__, 'formatted_address' ), 10, 2 );
		add_filter( 'woocommerce_order_formatted_shipping_address', array( __CLASS__, 'formatted_address_shipping' ), 10, 2 );
		add_filter( 'woocommerce_localisation_address_formats', array( __CLASS__, 'address_formats' ) );
		add_filter( 'woocommerce_formatted_address_replacements', array( __CLASS__, 'replacements' ), 10, 2 );

		// Tax disclosure (Qatar has no VAT in force; client asked for a clear line).
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'tax_note_product' ), 11 );
		add_action( 'woocommerce_cart_totals_after_order_total', array( __CLASS__, 'tax_note_row' ) );
		add_action( 'woocommerce_review_order_after_order_total', array( __CLASS__, 'tax_note_row' ) );
	}

	/** The tax line, used in three places. */
	public static function tax_note_text() {
		return __( 'Prices in QAR, inclusive of applicable taxes.', 'niswah-boutique' );
	}

	/**
	 * Relabel and reorder the core address fields for Qatar.
	 *
	 * @param array $locale
	 * @return array
	 */
	public static function locale( $locale ) {
		$locale['QA'] = array(
			'address_1' => array(
				'label'       => __( 'Zone', 'niswah-boutique' ),
				'placeholder' => __( 'e.g. 25', 'niswah-boutique' ),
				'required'    => true,
				'priority'    => 50,
			),
			'address_2' => array(
				'label'       => __( 'Street No. / Name', 'niswah-boutique' ),
				// WooCommerce ships address_2 with label_class screen-reader-text;
				// without clearing it the "Street" label would be invisible.
				'label_class' => array(),
				'placeholder' => __( 'e.g. 850 or Al Waab Street', 'niswah-boutique' ),
				'required'    => true,
				'hidden'      => false,
				'priority'    => 55,
			),
			'city'      => array(
				'label'       => __( 'Area / City', 'niswah-boutique' ),
				'placeholder' => __( 'e.g. Doha, Al Wakrah, Al Rayyan', 'niswah-boutique' ),
				'required'    => true,
				'priority'    => 70,
			),
			'state'     => array(
				'required' => false,
				'hidden'   => true,
			),
			'postcode'  => array(
				'required' => false,
				'hidden'   => true,
			),
			// wc-address-i18n applies locale entries by field id on the client,
			// so these also cover the custom fields and the phone after a
			// country change.
			'phone'       => array( 'required' => true ),
			'building_no' => array( 'required' => true ),
		);
		return $locale;
	}

	/**
	 * Last word on the checkout form: WooCommerce rebuilds billing_phone from
	 * its "phone field" setting after the address-field filters have run, so
	 * the required flag has to be set here too.
	 */
	public static function checkout_fields( $fields ) {
		if ( isset( $fields['billing']['billing_phone'] ) ) {
			$fields['billing']['billing_phone']['required'] = true;
		}
		foreach ( array( 'billing', 'shipping' ) as $type ) {
			if ( isset( $fields[ $type ][ $type . '_building_no' ] ) ) {
				$fields[ $type ][ $type . '_building_no' ]['required'] = true;
			}
		}
		return $fields;
	}

	/** WooCommerce → Settings phone field must say "required" or it wins. */
	public static function phone_setting() {
		if ( 'required' !== get_option( 'woocommerce_checkout_phone_field' ) ) {
			update_option( 'woocommerce_checkout_phone_field', 'required' );
		}
	}

	/**
	 * The two extra fields, keyed for a given prefix.
	 *
	 * Not marked required here: WooCommerce would then demand them for every
	 * country. validate() enforces Building No. when the country is Qatar.
	 *
	 * @param string $prefix billing|shipping
	 * @return array
	 */
	private static function extra_fields( $prefix ) {
		return array(
			$prefix . '_building_no' => array(
				'label'       => __( 'Building No.', 'niswah-boutique' ),
				'placeholder' => __( 'e.g. 12', 'niswah-boutique' ),
				'required'    => true,
				'class'       => array( 'form-row-first', 'nb-field-building' ),
				'priority'    => 60,
				'autocomplete'=> 'off',
			),
			$prefix . '_unit_no'     => array(
				'label'       => __( 'Unit / Flat No.', 'niswah-boutique' ),
				'placeholder' => __( 'optional', 'niswah-boutique' ),
				'required'    => false,
				'class'       => array( 'form-row-last', 'nb-field-unit' ),
				'priority'    => 65,
				'autocomplete'=> 'off',
			),
		);
	}

	public static function billing_fields( $fields ) {
		$fields = array_merge( $fields, self::extra_fields( 'billing' ) );

		// A courier needs a phone number; COD doubly so. Was optional.
		if ( isset( $fields['billing_phone'] ) ) {
			$fields['billing_phone']['required'] = true;
			$fields['billing_phone']['placeholder'] = __( 'e.g. +974 3388 2265', 'niswah-boutique' );
		}
		return $fields;
	}

	public static function shipping_fields( $fields ) {
		return array_merge( $fields, self::extra_fields( 'shipping' ) );
	}

	/**
	 * Building No. is required when the address is in Qatar.
	 *
	 * @param array    $data   Posted checkout data.
	 * @param WP_Error $errors
	 */
	public static function validate( $data, $errors ) {
		$ship_to_different = ! empty( $data['ship_to_different_address'] );

		if ( isset( $data['billing_country'] ) && 'QA' === $data['billing_country'] && empty( $data['billing_building_no'] ) ) {
			$errors->add( 'billing_building_no_required', __( 'Please enter your Building No. (billing address).', 'niswah-boutique' ) );
		}
		if ( $ship_to_different && isset( $data['shipping_country'] ) && 'QA' === $data['shipping_country'] && empty( $data['shipping_building_no'] ) ) {
			$errors->add( 'shipping_building_no_required', __( 'Please enter your Building No. (delivery address).', 'niswah-boutique' ) );
		}
	}

	/**
	 * Show the two fields in the order edit screen. Keys here map to
	 * _billing_{key} / _shipping_{key} meta, which is what WooCommerce saved.
	 */
	public static function admin_fields( $fields ) {
		$fields['building_no'] = array(
			'label' => __( 'Building No.', 'niswah-boutique' ),
			'show'  => true,
		);
		$fields['unit_no']     = array(
			'label' => __( 'Unit / Flat No.', 'niswah-boutique' ),
			'show'  => true,
		);
		return $fields;
	}

	public static function formatted_address( $address, $order ) {
		return self::add_to_address( $address, $order, 'billing' );
	}

	public static function formatted_address_shipping( $address, $order ) {
		return self::add_to_address( $address, $order, 'shipping' );
	}

	private static function add_to_address( $address, $order, $type ) {
		if ( ! is_array( $address ) || ! $order instanceof WC_Order ) {
			return $address;
		}
		$address['building_no'] = (string) $order->get_meta( '_' . $type . '_building_no' );
		$address['unit_no']     = (string) $order->get_meta( '_' . $type . '_unit_no' );
		return $address;
	}

	/**
	 * Qatar address layout. {address_1} holds the Zone, {address_2} the Street.
	 */
	public static function address_formats( $formats ) {
		$formats['QA'] = "{name}\n{company}\nZone {address_1}, Street {address_2}\n{nb_building}\n{city}\n{country}";
		return $formats;
	}

	/**
	 * Fill our placeholders. "Building 12, Unit 4" or "Building 12"; blank if
	 * neither was captured (older orders).
	 */
	public static function replacements( $replacements, $args ) {
		$building = isset( $args['building_no'] ) ? trim( (string) $args['building_no'] ) : '';
		$unit     = isset( $args['unit_no'] ) ? trim( (string) $args['unit_no'] ) : '';

		$line = '';
		if ( '' !== $building ) {
			$line = sprintf( __( 'Building %s', 'niswah-boutique' ), $building );
			if ( '' !== $unit ) {
				$line .= ', ' . sprintf( __( 'Unit %s', 'niswah-boutique' ), $unit );
			}
		}
		$replacements['{nb_building}'] = $line;
		return $replacements;
	}

	/* ---- tax disclosure -------------------------------------------------- */

	public static function tax_note_product() {
		echo '<p class="nb-tax-note">' . esc_html( self::tax_note_text() ) . '</p>';
	}

	public static function tax_note_row() {
		echo '<tr class="nb-tax-note-row"><td colspan="2" class="nb-tax-note">' . esc_html( self::tax_note_text() ) . '</td></tr>';
	}
}

NB_Qatar_Checkout::init();
