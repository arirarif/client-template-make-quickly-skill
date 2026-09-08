<?php
/**
 * NOOR — Charity widget (checkout).
 *
 * HARD REQUIREMENT (tax): donation money must NEVER pass through Noor's
 * account. So v1 = 'link' mode: a prominent widget that sends the donor
 * DIRECTLY to the association's own donation page.
 * 'stripe' mode (Stripe Connect direct-to-charity) can be added once the
 * association's payment details arrive from Sulayman.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'woocommerce_review_order_before_submit', function () {
	if ( 'link' !== NOOR_CHARITY_MODE ) {
		return; // stripe mode: to be implemented when charity infra is known
	}
	?>
	<div class="noor-charity">
		<h4>💝 Faire un don — <?php echo esc_html( NOOR_CHARITY_NAME ); ?></h4>
		<p style="margin:0;color:#7C6350;font-size:12.5px;">
			Votre don est versé <strong>directement à l'association</strong> — il ne transite jamais par Noor Festivities.
		</p>
		<a class="noor-charity-btn" href="<?php echo esc_url( NOOR_CHARITY_URL ); ?>" target="_blank" rel="noopener">
			Faire un don sur le site de l'association ↗
		</a>
	</div>
	<?php
}, 8 );
