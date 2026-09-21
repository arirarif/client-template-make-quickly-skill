<?php
/**
 * Title: Portfolio list with service filter
 * Slug: emma/portfolio-list
 * Categories: emma
 * Inserter: no
 */
?>
<!-- wp:group {"tagName":"section","className":"emma-archive"} -->
<section class="wp-block-group emma-archive"><!-- wp:group {"className":"emma-wrap"} -->
<div class="wp-block-group emma-wrap"><!-- wp:shortcode -->
[emma_service_filter]
<!-- /wp:shortcode -->

<!-- wp:query {"queryId":12,"query":{"perPage":12,"pages":0,"offset":0,"postType":"case_study","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"className":"emma-cases emma-cases-grid"} -->
<div class="wp-block-query emma-cases emma-cases-grid"><!-- wp:post-template -->
<!-- wp:post-featured-image {"isLink":true} /-->

<!-- wp:group {"className":"emma-case-meta"} -->
<div class="wp-block-group emma-case-meta"><!-- wp:post-title {"level":3,"isLink":true} /-->

<!-- wp:post-terms {"term":"service"} /--></div>
<!-- /wp:group -->

<!-- wp:post-excerpt /-->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"emma-no-results"} -->
<p class="emma-no-results">No projects here yet. Please check back soon.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->

<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
