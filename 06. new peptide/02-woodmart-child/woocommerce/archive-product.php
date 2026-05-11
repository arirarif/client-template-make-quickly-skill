<?php
/**
 * Atomic Blue — WooCommerce Shop Archive
 *
 * Overrides woodmart/woocommerce/archive-product.php.
 * Layout: hero → [ left sidebar (FilterEverything Pro filters) | product grid + sort ] → newsletter (footer).
 *
 * The left sidebar renders the "Atomic Blue · Shop Filters" widget area
 * registered in functions.php. Drop the FilterEverything Pro "Filters"
 * widget into it via Appearance → Widgets to populate Categories /
 * Primary Function / Dosage / Volume / Price.
 *
 * Header / footer continue to come from WoodMart Header & Footer Builder.
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$pp_shop_url = get_permalink( wc_get_page_id( 'shop' ) );
$pp_count    = (int) wp_count_posts( 'product' )->publish;
$pp_has_fe   = function_exists( 'pp_atomic_filtereverything_active' ) && pp_atomic_filtereverything_active();
?>

<main class="atomic-shop-main">

    <!-- HERO — slim version, no "Lab Behind Every Vial" card.
         Client req 11/05/2026: drop the atom card from shop, keep on homepage only. -->
    <section class="wrap hero hero-slim">
        <div>
            <span class="pill">⚛ All Peptides · Stocked in the UK</span>
            <h1><?php echo wp_kses_post( apply_filters( 'pp_atomic_shop_h1', 'The Vault.<br>Every Peptide<br>We Carry.' ) ); ?></h1>
            <p class="lead"><?php echo esc_html( apply_filters( 'pp_atomic_shop_lead', 'Browse the full Performance Peptides catalogue. Stocked in our UK warehouse for fast dispatch — order before 3pm on working days.' ) ); ?></p>
            <div class="actions">
                <a href="#shop" class="btn">Browse the Vault →</a>
                <a href="/reconstitution-guide/" class="btn secondary">Reconstitution Guide</a>
            </div>
        </div>
    </section>

    <!-- SHOP — sidebar + content -->
    <section id="shop" class="wrap section">
        <div class="shop-layout">

            <!-- LEFT: sidebar with FilterEverything Pro widget area -->
            <aside class="shop-sidebar" id="shopSidebar">
                <div class="sidebar-title">
                    <?php esc_html_e( 'Filters', 'woodmart-child' ); ?>
                </div>

                <div class="sidebar-body">
                    <?php
                    if ( is_active_sidebar( 'atomic-blue-shop-filters' ) ) :
                        dynamic_sidebar( 'atomic-blue-shop-filters' );
                    elseif ( $pp_has_fe ) :
                        // FilterEverything is active but no widgets placed yet.
                        ?>
                        <div class="pp-sidebar-empty">
                            <p><strong><?php esc_html_e( 'No filters configured.', 'woodmart-child' ); ?></strong></p>
                            <p>
                                <?php
                                printf(
                                    /* translators: %s = link to widgets screen */
                                    wp_kses_post( __( 'Drop the <em>FilterEverything Pro · Filters</em> widget into the <a href="%s">Atomic Blue · Shop Filters</a> sidebar.', 'woodmart-child' ) ),
                                    esc_url( admin_url( 'widgets.php' ) )
                                );
                                ?>
                            </p>
                        </div>
                        <?php
                    else :
                        // FilterEverything not installed — show a friendly placeholder so the layout still looks finished.
                        ?>
                        <div class="pp-sidebar-empty">
                            <p><strong><?php esc_html_e( 'FilterEverything Pro not active.', 'woodmart-child' ); ?></strong></p>
                            <p><?php esc_html_e( 'Install & activate FilterEverything Pro, then drop its Filters widget into the "Atomic Blue · Shop Filters" sidebar to enable Category / Dosage / Volume / Price filtering.', 'woodmart-child' ); ?></p>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
            </aside>

            <!-- RIGHT: product grid -->
            <div class="shop-content">

                <!-- Toolbar: mobile filter toggle + count + Woo sort -->
                <div class="shop-toolbar">
                    <button type="button" class="filter-toggle" aria-controls="shopSidebar"
                            onclick="document.getElementById('shopSidebar').classList.toggle('is-open');document.documentElement.classList.toggle('pp-sidebar-open');">
                        <?php esc_html_e( '⚙ Filters', 'woodmart-child' ); ?>
                    </button>

                    <?php
                    /**
                     * Posts-found counter — uses FilterEverything's own
                     * shortcode when the plugin is active (so the count
                     * stays in sync with active filters), otherwise falls
                     * back to a static catalogue count.
                     */
                    if ( $pp_has_fe && shortcode_exists( 'fe_posts_found' ) ) {
                        echo '<div class="stock pp-posts-found">' . do_shortcode( '[fe_posts_found]' ) . '</div>';
                    } else {
                        printf(
                            '<div class="stock">%s</div>',
                            esc_html(
                                sprintf(
                                    /* translators: %s = product count */
                                    _n( '%s product', '%s products', $pp_count, 'woodmart-child' ),
                                    number_format_i18n( $pp_count )
                                )
                            )
                        );
                    }
                    ?>

                    <div class="pp-sort-wrap">
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>
                </div>

                <!-- Active-filter chips (renders only if FilterEverything is active and there are selected terms) -->
                <?php if ( $pp_has_fe && shortcode_exists( 'fe_chips' ) ) : ?>
                    <div class="pp-active-chips">
                        <?php echo do_shortcode( '[fe_chips reset="yes"]' ); ?>
                    </div>
                <?php endif; ?>

                <div class="section-head">
                    <div>
                        <p class="eyebrow"><?php echo esc_html( sprintf( __( 'Catalogue · %s Compounds', 'woodmart-child' ), number_format_i18n( $pp_count ) ) ); ?></p>
                        <h2><?php esc_html_e( 'Vault Inventory', 'woodmart-child' ); ?></h2>
                    </div>
                </div>

                <?php if ( woocommerce_product_loop() ) : ?>
                    <div class="featured">
                        <div class="product-grid">
                            <?php while ( have_posts() ) : the_post(); ?>
                                <?php wc_get_template_part( 'content', 'product' ); ?>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <?php
                    /**
                     * Standard WC pagination (after_shop_loop also fires
                     * the noproducts message + pagination).
                     */
                    do_action( 'woocommerce_after_shop_loop' );
                    ?>
                <?php else : ?>
                    <p class="eyebrow"><?php esc_html_e( 'No compounds matched.', 'woodmart-child' ); ?> <a href="<?php echo esc_url( $pp_shop_url ); ?>"><?php esc_html_e( 'Clear filters', 'woodmart-child' ); ?></a>.</p>
                <?php endif; ?>

            </div><!-- /.shop-content -->

        </div><!-- /.shop-layout -->
    </section>

    <!-- Newsletter (prefooter) and FAQ intentionally not rendered here —
         they live in the WoodMart Header & Footer Builder so they stay
         consistent across every page on the site. -->

</main>

<?php
get_footer( 'shop' );
