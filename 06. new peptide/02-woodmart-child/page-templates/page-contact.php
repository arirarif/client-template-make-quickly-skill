<?php
/**
 * Template Name: Atomic Blue · Contact
 *
 * Custom page template for the "Contact" page. Assign from the WP
 * page editor: Page Attributes → Template → "Atomic Blue · Contact".
 * The contact form is a static markup placeholder — drop in a
 * shortcode (CF7 / WPForms / Klaviyo) inside the .contact-form box
 * to make it functional.
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) : the_post(); ?>

    <main class="atomic-contact-main">

        <section class="wrap hero">
            <div>
                <span class="pill">📬 We Read Every Message</span>
                <h1><?php echo wp_kses_post( apply_filters( 'pp_atomic_contact_h1', 'Talk To<br>The Vault.' ) ); ?></h1>
                <p class="lead"><?php echo esc_html( apply_filters( 'pp_atomic_contact_lead', "Questions on stock, dispatch, reconstitution, bulk pricing, or anything else? Drop us a line — a real person from our UK team will reply within one working day." ) ); ?></p>
            </div>
            <div class="hero-card-wrap">
                <div class="hero-card">
                    <span class="badge">24h Reply</span>
                    <h2 style="margin-top: 0;">Real Humans.<br>Real Answers.</h2>
                    <p>No tickets, no chatbots, no copy-paste replies. You message us, an actual person on our UK team writes back.</p>
                    <div class="stats">
                        <div class="stat">UK<span>Based Team</span></div>
                        <div class="stat">24h<span>Avg. Reply</span></div>
                        <div class="stat">9–6<span>Mon–Fri</span></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="wrap section" style="padding-top: 0;">
            <div class="contact-grid">

                <!-- INFO CARD -->
                <aside class="contact-info">
                    <h3>Direct Lines</h3>
                    <div class="info-row"><span class="ico">📍</span><div><strong>UK Warehouse</strong><span><?php echo esc_html( apply_filters( 'pp_atomic_contact_address', 'United Kingdom · Address on request' ) ); ?></span></div></div>
                    <div class="info-row"><span class="ico">📧</span><div><strong>General</strong><span><?php echo esc_html( apply_filters( 'pp_atomic_contact_email_general', 'hello@performancepeptidesuk.com' ) ); ?></span></div></div>
                    <div class="info-row"><span class="ico">🛒</span><div><strong>Bulk / Trade</strong><span><?php echo esc_html( apply_filters( 'pp_atomic_contact_email_science', 'trade@performancepeptidesuk.com' ) ); ?></span></div></div>
                    <div class="info-row"><span class="ico">📦</span><div><strong>Order Status</strong><span><?php echo esc_html( apply_filters( 'pp_atomic_contact_email_orders', 'orders@performancepeptidesuk.com' ) ); ?></span></div></div>
                    <div class="info-row"><span class="ico">🕒</span><div><strong>Hours</strong><span><?php echo wp_kses_post( apply_filters( 'pp_atomic_contact_hours', 'Mon–Fri · 9 AM – 6 PM GMT<br>Same-day dispatch cutoff: 3 PM' ) ); ?></span></div></div>
                </aside>

                <!-- FORM -->
                <div class="contact-form">
                    <h3>Send a Message</h3>
                    <?php
                    $page_content = trim( get_the_content() );
                    if ( $page_content ) {
                        // If admin pasted a CF7 / WPForms / Klaviyo shortcode in the page content, render that.
                        the_content();
                    } else {
                        // Static placeholder form — replace with a real shortcode in the page editor.
                        ?>
                        <div class="row-2">
                            <div class="field"><label>First Name</label><input type="text" required></div>
                            <div class="field"><label>Last Name</label><input type="text" required></div>
                        </div>
                        <div class="row-2">
                            <div class="field"><label>Email</label><input type="email" required></div>
                            <div class="field"><label>Subject</label>
                                <select>
                                    <option>General Question</option>
                                    <option>Order Status</option>
                                    <option>Bulk / Wholesale</option>
                                    <option>Research Collaboration</option>
                                    <option>Press &amp; Media</option>
                                </select>
                            </div>
                        </div>
                        <div class="field"><label>Message</label><textarea placeholder="Tell us what you need…"></textarea></div>
                        <p style="font: 800 12px Arial,sans-serif; opacity:.65; margin: 6px 0 16px;">⚠ Replace this with a CF7 / WPForms shortcode by editing the Contact page in the WP editor.</p>
                        <button type="button" class="btn" style="width: 100%;">Send Message →</button>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <!-- MAP -->
            <div class="map">
                <span class="pin">📍</span>
                <span class="pin-label"><?php echo esc_html( apply_filters( 'pp_atomic_contact_map_label', 'United Kingdom' ) ); ?></span>
            </div>
        </section>

    </main>

<?php endwhile; get_footer();
