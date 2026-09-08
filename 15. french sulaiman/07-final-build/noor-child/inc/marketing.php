<?php
/**
 * NOOR — Marketing: WhatsApp float, lead-capture popup, product share buttons.
 */

defined( 'ABSPATH' ) || exit;

/* --------------------------------------------------------------------------
 * WhatsApp floating button (site-wide)
 * ------------------------------------------------------------------------ */
add_action( 'wp_footer', function () {
	$url = 'https://wa.me/' . rawurlencode( NOOR_WHATSAPP_NUMBER ) . '?text=' . rawurlencode( NOOR_WHATSAPP_MESSAGE );
	?>
	<a class="noor-whatsapp" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
		<svg viewBox="0 0 32 32"><path d="M16 3C9.4 3 4 8.4 4 15c0 2.6.8 5 2.2 7L4 29l7.2-2.1c1.9 1 4 1.6 6.3 1.6h.5c6.6 0 12-5.4 12-12S22.6 3 16 3zm5.9 17.1c-.3.8-1.5 1.5-2.4 1.7-.6.1-1.4.2-4.2-.9-3.5-1.5-5.8-5-6-5.3-.2-.2-1.4-1.9-1.4-3.6s.9-2.6 1.2-2.9c.3-.3.7-.4 1-.4h.7c.2 0 .5-.1.8.6.3.8 1 2.6 1.1 2.8.1.2.2.4 0 .7-.1.2-.2.4-.4.6l-.6.7c-.2.2-.4.4-.2.8.2.4 1 1.7 2.2 2.7 1.5 1.3 2.8 1.7 3.2 1.9.4.2.6.2.9-.1.2-.3 1-1.2 1.3-1.6.3-.4.5-.3.9-.2.4.1 2.4 1.1 2.8 1.3.4.2.7.3.8.5.1.1.1.9-.2 1.7z"/></svg>
	</a>
	<?php
} );

/* --------------------------------------------------------------------------
 * Lead-capture popup (name + email → discount code). Cookie-throttled.
 * The JS (assets/noor.js) handles show/dismiss/cookie; submit is AJAX.
 * ------------------------------------------------------------------------ */
add_action( 'wp_footer', function () {
	?>
	<div class="noor-popup-overlay" id="noor-popup" aria-hidden="true">
		<div class="noor-popup" role="dialog" aria-label="Offre de bienvenue">
			<button type="button" class="noor-popup-close" aria-label="Fermer">×</button>
			<h3>Un cadeau de bienvenue 🎁</h3>
			<p>Recevez <strong>-10%</strong> sur votre première commande.</p>
			<form id="noor-popup-form">
				<input type="text"  name="noor_name"  placeholder="Prénom" required>
				<input type="email" name="noor_email" placeholder="Adresse e-mail" required>
				<button type="submit">Recevoir mon code</button>
			</form>
			<p class="noor-popup-done" style="display:none;color:#16A34A;">
				✅ Votre code : <strong><?php echo esc_html( NOOR_POPUP_DISCOUNT_CODE ); ?></strong>
			</p>
		</div>
	</div>
	<?php
} );

/* AJAX: store the lead (also mail it to admin; Brevo sync comes in Phase 4). */
add_action( 'wp_ajax_noor_lead', 'noor_lead_capture' );
add_action( 'wp_ajax_nopriv_noor_lead', 'noor_lead_capture' );
function noor_lead_capture() {
	$name  = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		wp_send_json_error( 'email' );
	}
	// Store as a simple option-based list (Phase 4 replaces with Brevo API).
	$leads   = get_option( 'noor_leads', array() );
	$leads[] = array( 'name' => $name, 'email' => $email, 'date' => current_time( 'mysql' ), 'region' => noor_current_region() );
	update_option( 'noor_leads', $leads, false );
	wp_mail( get_option( 'admin_email' ), 'Nouveau lead Noor : ' . $email, "Nom: $name\nEmail: $email" );
	wp_send_json_success();
}

/* --------------------------------------------------------------------------
 * Share buttons on product page — FB, WhatsApp, Snapchat, Instagram, TikTok.
 * TikTok/Instagram have no desktop share URL → copy-link buttons (honest UX).
 * ------------------------------------------------------------------------ */
add_action( 'woocommerce_single_product_summary', function () {
	$url   = rawurlencode( get_permalink() );
	$title = rawurlencode( get_the_title() );
	?>
	<div class="noor-share">
		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank" rel="noopener">📘 Facebook</a>
		<a href="https://wa.me/?text=<?php echo $title . '%20' . $url; ?>" target="_blank" rel="noopener">💬 WhatsApp</a>
		<a href="https://www.snapchat.com/scan?attachmentUrl=<?php echo $url; ?>" target="_blank" rel="noopener">👻 Snapchat</a>
		<button type="button" class="noor-copylink" data-share="instagram">📷 Instagram</button>
		<button type="button" class="noor-copylink" data-share="tiktok">🎵 TikTok</button>
	</div>
	<?php
}, 45 );
