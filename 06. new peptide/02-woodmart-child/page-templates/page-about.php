<?php
/**
 * Template Name: Atomic Blue · About
 *
 * Custom page template for the "About" page. Assign this from the WP
 * page editor: Page Attributes → Template → "Atomic Blue · About".
 * Page-editor content (the_content) is rendered inside the Story
 * block — leave the page content empty to use the default copy below.
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
    the_post();
    $page_content = trim( get_the_content() );
    ?>

    <main class="atomic-about-main">

        <!-- HERO -->
        <section class="wrap hero">
            <div>
                <span class="pill">⚛ Stocked in the UK · Dispatched Fast</span>
                <h1><?php echo wp_kses_post( apply_filters( 'pp_atomic_about_h1', 'The Vault.<br>UK Stocked.<br>Quickly Shipped.' ) ); ?></h1>
                <p class="lead"><?php echo esc_html( apply_filters( 'pp_atomic_about_lead', 'Performance Peptides is a UK-stocked research peptide supplier built for researchers who value fast turnaround. Every order ships from our UK warehouse — order before 3pm on working days and it goes out the same day.' ) ); ?></p>
                <div class="actions">
                    <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn">Browse the Vault →</a>
                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn secondary">Get In Touch</a>
                </div>
            </div>
            <div class="hero-card-wrap">
                <div class="hero-card">
                    <span class="badge">Our Pledge</span>
                    <svg class="atom" viewBox="0 0 220 220" aria-hidden="true">
                        <ellipse cx="110" cy="110" rx="92" ry="32" fill="none" stroke="#000" stroke-width="6"/>
                        <ellipse cx="110" cy="110" rx="92" ry="32" fill="none" stroke="#000" stroke-width="6" transform="rotate(60 110 110)"/>
                        <ellipse cx="110" cy="110" rx="92" ry="32" fill="none" stroke="#000" stroke-width="6" transform="rotate(-60 110 110)"/>
                        <circle cx="110" cy="110" r="16" fill="#46f0ff" stroke="#000" stroke-width="6"/>
                    </svg>
                    <h2>UK Stock. Fast Dispatch.</h2>
                    <p>Every product is held in our UK warehouse. Order before 3pm on a working day and it ships the same day.</p>
                </div>
            </div>
        </section>

        <!-- STORY -->
        <section class="wrap section">
            <div class="section-head"><div><p class="eyebrow">Our Story</p><h2>Built By Chemists.<br>Not Marketers.</h2></div></div>

            <?php if ( $page_content ) : ?>
                <article class="card" style="padding: 30px;">
                    <?php the_content(); ?>
                </article>
            <?php else : ?>
                <div class="story-grid">
                    <article class="card">
                        <h3>The Beginning</h3>
                        <p>We started Performance Peptides because, as researchers ourselves, we wanted a UK supplier that was simple to order from and quick to deliver. No clunky checkouts, no waiting weeks for stock to land, no jargon.</p>
                    </article>
                    <article class="card">
                        <h3>The Mission</h3>
                        <p>Build the easiest UK research peptide store to use. Plain-English product pages. Stock you can actually order today. Same-day dispatch on working days. No nonsense, no shipping delays, no surprises at checkout.</p>
                    </article>
                </div>
            <?php endif; ?>
        </section>

        <!-- STATS STRIP -->
        <section class="wrap section" style="padding-top: 0;">
            <div class="stat-strip">
                <div><div class="num">UK</div><div class="lbl">Held In Stock</div></div>
                <div><div class="num"><?php echo esc_html( wp_count_posts( 'product' )->publish ); ?></div><div class="lbl">Compounds in Vault</div></div>
                <div><div class="num">3PM</div><div class="lbl">Same-Day Cutoff</div></div>
                <div><div class="num">24h</div><div class="lbl">Average Dispatch</div></div>
            </div>
        </section>

        <!-- VALUES -->
        <section class="wrap section">
            <div class="section-head"><div><p class="eyebrow">What We Stand For</p><h2>Three Non-Negotiables.</h2></div></div>
            <div class="values">
                <article class="value-card">
                    <span class="ico">🇬🇧</span>
                    <h3>UK Stock</h3>
                    <p>Every product on the site is physically held in our UK warehouse. What you see is what we can ship — no drop-shipping, no overseas waits.</p>
                </article>
                <article class="value-card">
                    <span class="ico">🚚</span>
                    <h3>Same-Day Dispatch</h3>
                    <p>Order before 3pm on a working day and it ships the same day. Tracked &amp; discreet. UK Royal Mail / courier — usually next-day delivery.</p>
                </article>
                <article class="value-card">
                    <span class="ico">💬</span>
                    <h3>Real Support</h3>
                    <p>Questions about reconstitution, storage or product info? Drop us a message and a real person on our team will reply within one working day.</p>
                </article>
            </div>
        </section>

        <!-- WAREHOUSE -->
        <section class="wrap section" style="padding-top: 0;">
            <div class="lab-tour">
                <div class="lab-img">📦</div>
                <div>
                    <p class="eyebrow" style="color: var(--pp-gold);">The Warehouse</p>
                    <h2>UK Based. Climate-controlled. Ready To Ship.</h2>
                    <p style="font:800 16px Arial,sans-serif; line-height:1.45; margin: 16px 0; color: var(--pp-paper);">Our UK fulfilment site is climate-controlled and stocked daily. Orders are picked, packed and dispatched the same day on working days — so you don't sit waiting on customs or international shipping.</p>
                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn">Get In Touch →</a>
                </div>
            </div>
        </section>

        <!-- TEAM -->
        <section class="wrap section">
            <div class="section-head"><div><p class="eyebrow">The Team</p><h2>The Humans Behind The Vault.</h2></div></div>
            <div class="team-grid">
                <article class="team-card">
                    <div class="face">📦</div>
                    <h3>Fulfilment</h3>
                    <p class="role">UK Warehouse Team</p>
                    <p>Picks, packs and ships every order from our UK warehouse. Same-day dispatch on working days when you order before 3pm.</p>
                </article>
                <article class="team-card">
                    <div class="face">💬</div>
                    <h3>Support</h3>
                    <p class="role">Customer Care</p>
                    <p>Real people answering real questions on reconstitution, storage and product info. We reply within one working day.</p>
                </article>
                <article class="team-card">
                    <div class="face">🛒</div>
                    <h3>Operations</h3>
                    <p class="role">Stock &amp; Logistics</p>
                    <p>Keeps the UK stock list accurate and the catalogue current. If it's on the site, it's in the warehouse — not on a boat.</p>
                </article>
            </div>
        </section>

    </main>

    <?php
endwhile;

get_footer();
