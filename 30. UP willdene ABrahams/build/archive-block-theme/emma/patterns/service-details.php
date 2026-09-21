<?php
/**
 * Title: Service details (all 6 services with matching work)
 * Slug: emma/service-details
 * Categories: emma
 * Description: One section per service. Each section lists the latest case studies that carry the same Service tag.
 */

if ( ! taxonomy_exists( 'service' ) ) {
	return;
}

$emma_copy = array(
	'web-development'        => array(
		'Websites that load fast, look right on every screen and are easy for you to update. Built on WordPress, without page-builder bloat.',
		array( 'Design made for your brand, not a template', 'Responsive build for phone, tablet and desktop', 'Speed, security and search basics included', 'A short guide so you can edit it yourself' ),
	),
	'seo-sem'                => array(
		'Be found when people search for what you sell. We fix the technical basics, improve your pages and run paid search where it pays off.',
		array( 'Technical and on-page SEO audit', 'Keyword and content plan', 'Google Ads setup and management', 'Monthly report in plain words' ),
	),
	'social-media-marketing' => array(
		'A steady, recognisable presence on the channels your customers use, with content planned ahead instead of posted in a hurry.',
		array( 'Channel and content plan', 'Post design and copy', 'Paid social campaigns', 'Community replies and reporting' ),
	),
	'ai-solutions'           => array(
		'Practical AI that saves your team time: assistants that answer common questions and workflows that take over repetitive tasks.',
		array( 'Review of where AI can help you', 'Assistants trained on your own content', 'Automated workflows between your tools', 'Training for your team' ),
	),
	'email-automation'       => array(
		'Emails that send themselves at the right moment: a welcome series, reminders and newsletters your customers want to open.',
		array( 'Setup of your email platform', 'Welcome and follow-up flows', 'Newsletter templates in your brand', 'List segments and reporting' ),
	),
	'analytics'              => array(
		'Know what works. We set up clean tracking and turn the numbers into a dashboard and a report you can read in five minutes.',
		array( 'Analytics and conversion tracking setup', 'Dashboard with the numbers that matter', 'Monthly report with next steps', 'Privacy-friendly configuration' ),
	),
);

$emma_terms = get_terms( array(
	'taxonomy'   => 'service',
	'hide_empty' => false,
	'orderby'    => 'term_id',
	'order'      => 'ASC',
) );

if ( is_wp_error( $emma_terms ) ) {
	return;
}

foreach ( $emma_terms as $emma_i => $emma_term ) :
	$emma_text  = isset( $emma_copy[ $emma_term->slug ] ) ? $emma_copy[ $emma_term->slug ][0] : $emma_term->description;
	$emma_items = isset( $emma_copy[ $emma_term->slug ] ) ? $emma_copy[ $emma_term->slug ][1] : array( 'First item included', 'Second item included', 'Third item included' );
	?>
<!-- wp:group {"tagName":"section","className":"emma-service-detail"} -->
<section id="<?php echo esc_attr( $emma_term->slug ); ?>" class="wp-block-group emma-service-detail"><!-- wp:group {"className":"emma-wrap"} -->
<div class="wp-block-group emma-wrap"><!-- wp:group {"className":"emma-split"} -->
<div class="wp-block-group emma-split"><!-- wp:group {"className":"emma-split-text"} -->
<div class="wp-block-group emma-split-text"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php echo esc_html( $emma_term->name ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html( $emma_text ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><?php foreach ( $emma_items as $emma_item ) : ?><!-- wp:list-item -->
<li><?php echo esc_html( $emma_item ); ?></li>
<!-- /wp:list-item --><?php endforeach; ?></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-sun"} -->
<div class="wp-block-button is-style-sun"><a class="wp-block-button__link wp-element-button" href="/contact/">Ask about <?php echo esc_html( $emma_term->name ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"emma-related"} -->
<div class="wp-block-group emma-related"><!-- wp:paragraph {"className":"is-style-label"} -->
<p class="is-style-label">Related work</p>
<!-- /wp:paragraph -->

<!-- wp:query {"queryId":<?php echo (int) ( 20 + $emma_i ); ?>,"query":{"perPage":2,"pages":0,"offset":0,"postType":"case_study","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"service":[<?php echo (int) $emma_term->term_id; ?>]}},"className":"emma-cases emma-cases-small"} -->
<div class="wp-block-query emma-cases emma-cases-small"><!-- wp:post-template -->
<!-- wp:post-featured-image {"isLink":true} /-->

<!-- wp:group {"className":"emma-case-meta"} -->
<div class="wp-block-group emma-case-meta"><!-- wp:post-title {"level":3,"isLink":true} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p>Case studies for this service are coming soon.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

	<?php
endforeach;
