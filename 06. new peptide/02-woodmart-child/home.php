<?php
/**
 * Atomic Blue — Blog Archive (home.php)
 * Renders on the WP "Posts page" (Settings → Reading → Posts page).
 * 3-col grid of blog posts with hero + filter chips + pagination.
 */

defined( 'ABSPATH' ) || exit;

get_header();

$post_categories = get_categories( array(
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
    'number'     => 8,
) );
$active_cat = is_category() ? get_queried_object_id() : 0;
?>

<main class="atomic-blog-main">

    <!-- HERO -->
    <section class="wrap hero">
        <div>
            <span class="pill">📡 The Lab Notes</span>
            <h1><?php echo wp_kses_post( apply_filters( 'pp_atomic_blog_h1', 'Vault Updates.<br>Protocol Drops.' ) ); ?></h1>
            <p class="lead"><?php echo esc_html( apply_filters( 'pp_atomic_blog_lead', "Reconstitution guides, deep-dive compound profiles, lab notes, and the occasional research roundup. Written by chemists, for researchers." ) ); ?></p>
        </div>
        <div class="hero-card-wrap">
            <div class="hero-card">
                <span class="badge">Weekly</span>
                <h2 style="margin-top: 0;">Skim or Deep-Dive.</h2>
                <p>Quick takes for busy days, long-form lab notes when you've got the time. Pick your poison.</p>
                <div class="stats">
                    <div class="stat"><?php echo esc_html( wp_count_posts()->publish ); ?><span>Articles</span></div>
                    <div class="stat"><?php echo esc_html( count( get_categories( array( 'hide_empty' => true ) ) ) ); ?><span>Categories</span></div>
                    <div class="stat">7k+<span>Subscribers</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- FILTER CHIPS -->
    <?php if ( $post_categories ) : ?>
    <section class="blog-filters">
        <div class="wrap">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/' ) ); ?>"
               class="chip<?php echo ! $active_cat ? ' active' : ''; ?>">All</a>
            <?php foreach ( $post_categories as $cat ) : ?>
                <a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"
                   class="chip<?php echo $active_cat === (int) $cat->term_id ? ' active' : ''; ?>">
                    <?php echo esc_html( $cat->name ); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- GRID -->
    <section class="wrap section">
        <div class="section-head">
            <div>
                <p class="eyebrow">Latest · <?php echo esc_html( wp_count_posts()->publish ); ?> Articles</p>
                <h2>Fresh From The Bench</h2>
            </div>
            <span class="stock">Updated Weekly</span>
        </div>

        <?php if ( have_posts() ) : ?>
            <div class="blog-grid">
                <?php while ( have_posts() ) : the_post();
                    $cat_list = get_the_category();
                    $cat_name = $cat_list ? $cat_list[0]->name : __( 'Article', 'woodmart-child' );
                ?>
                    <a href="<?php the_permalink(); ?>" class="blog-card">
                        <div class="blog-thumb">
                            <span class="news-date"><?php echo esc_html( get_the_date( 'M j' ) ); ?></span>
                            <?php if ( has_post_thumbnail() ) :
                                the_post_thumbnail( 'medium_large', array( 'alt' => esc_attr( get_the_title() ) ) );
                            else : ?>
                                <span style="font-size: 80px;">🧪</span>
                            <?php endif; ?>
                        </div>
                        <div class="blog-card-body">
                            <p class="news-type"><?php echo esc_html( $cat_name ); ?></p>
                            <h3><?php the_title(); ?></h3>
                            <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
                            <span class="read-more">Read →</span>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>

            <!-- PAGINATION -->
            <nav class="pagination">
                <?php
                echo paginate_links( array(
                    'mid_size'  => 1,
                    'prev_text' => '←',
                    'next_text' => '→',
                ) );
                ?>
            </nav>

        <?php else : ?>
            <div class="card" style="padding: 40px; text-align: center;">
                <h3 style="font: 900 24px Arial, sans-serif; text-transform: uppercase; color: var(--pp-ink);">Nothing Posted Yet.</h3>
                <p style="font: 800 16px Arial, sans-serif; color: var(--pp-ink); opacity: .7;">Check back soon — we ship lab notes weekly.</p>
            </div>
        <?php endif; ?>
    </section>

</main>

<?php get_footer();
