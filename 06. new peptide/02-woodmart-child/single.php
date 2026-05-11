<?php
/**
 * Atomic Blue — Single Post
 * Hero with post meta + full-width cover + 2-col article + sticky
 * sidebar (TOC / author / related). All standard WP loop hooks
 * preserved (the_content, comments_template, etc.).
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) : the_post();
    $cat_list  = get_the_category();
    $cat_name  = $cat_list ? $cat_list[0]->name : __( 'Article', 'woodmart-child' );
    $cat_link  = $cat_list ? get_category_link( $cat_list[0] ) : '#';
    $author_id = get_the_author_meta( 'ID' );
    $reading   = max( 1, ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 220 ) );
?>

<main class="atomic-single-main">

    <!-- HERO -->
    <section class="wrap post-hero">
        <p class="eyebrow">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/' ) ); ?>"><?php esc_html_e( 'Blog', 'woodmart-child' ); ?></a> /
            <a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_name ); ?></a>
        </p>

        <h1><?php the_title(); ?></h1>

        <?php if ( has_excerpt() ) : ?>
            <p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
        <?php endif; ?>

        <div class="meta" style="margin-top: 24px;">
            <span class="chip"><?php echo esc_html( get_the_date() ); ?></span>
            <span class="chip"><?php echo esc_html( $reading ); ?> min read</span>
            <span class="chip active"><?php echo esc_html( $cat_name ); ?></span>
            <span class="chip">By <?php echo esc_html( get_the_author() ); ?></span>
        </div>
    </section>

    <!-- COVER -->
    <?php if ( has_post_thumbnail() ) : ?>
        <section class="wrap">
            <div class="post-cover">
                <?php the_post_thumbnail( 'large', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
            </div>
        </section>
    <?php else : ?>
        <section class="wrap">
            <div class="post-cover">🔬</div>
        </section>
    <?php endif; ?>

    <!-- BODY -->
    <section class="wrap" style="padding-bottom: 80px;">
        <div class="post-layout">

            <article class="post-body" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'woodmart-child' ),
                    'after'  => '</div>',
                ) );

                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
                ?>
            </article>

            <aside class="sidebar-post">
                <?php
                // Auto-generated TOC from h2/h3 headings in the post body.
                // Returns '' when there are fewer than 2 headings (don't show
                // a TOC for short posts).
                $toc_html = pp_atomic_get_toc( get_the_content() );
                if ( $toc_html ) : ?>
                    <div class="toc">
                        <h4><?php esc_html_e( 'In This Article', 'woodmart-child' ); ?></h4>
                        <?php echo $toc_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                <?php endif; ?>

                <?php
                $author_bio    = get_the_author_meta( 'description', $author_id );
                $author_url    = get_author_posts_url( $author_id );
                $author_avatar = get_avatar( $author_id, 88 );
                ?>
                <div class="author-card">
                    <a href="<?php echo esc_url( $author_url ); ?>" class="face"><?php echo $author_avatar; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
                    <h4><?php echo esc_html( get_the_author() ); ?></h4>
                    <?php if ( $author_bio ) : ?>
                        <p><?php echo esc_html( $author_bio ); ?></p>
                    <?php else : ?>
                        <p style="opacity:.6;">Performance Peptides contributor.</p>
                    <?php endif; ?>
                </div>

                <!-- RELATED POSTS -->
                <?php
                $related = new WP_Query( array(
                    'post_type'      => 'post',
                    'posts_per_page' => 4,
                    'post__not_in'   => array( get_the_ID() ),
                    'category__in'   => wp_list_pluck( get_the_category(), 'term_id' ),
                    'orderby'        => 'rand',
                ) );
                if ( $related->have_posts() ) : ?>
                    <div class="related-posts">
                        <h4>Related Reads</h4>
                        <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </aside>

        </div>
    </section>

    <!-- KEEP READING -->
    <?php
    $keep_reading = new WP_Query( array(
        'post_type'      => 'post',
        'posts_per_page' => 4,
        'post__not_in'   => array( get_the_ID() ),
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );
    if ( $keep_reading->have_posts() ) : ?>
        <section class="wrap section">
            <div class="section-head">
                <div><p class="eyebrow">Keep Reading</p><h2>More From The Bench.</h2></div>
            </div>
            <div class="featured">
                <div class="product-grid">
                    <?php while ( $keep_reading->have_posts() ) : $keep_reading->the_post();
                        $kc_list = get_the_category();
                        $kc_name = $kc_list ? $kc_list[0]->name : __( 'Article', 'woodmart-child' );
                    ?>
                        <article class="news-card">
                            <span class="news-date"><?php echo esc_html( get_the_date( 'M j' ) ); ?></span>
                            <p class="news-type"><?php echo esc_html( $kc_name ); ?></p>
                            <h3><?php the_title(); ?></h3>
                            <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p>
                            <a href="<?php the_permalink(); ?>" class="read-more">Read →</a>
                        </article>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>

</main>

<?php endwhile; get_footer();
