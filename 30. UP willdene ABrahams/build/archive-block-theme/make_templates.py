"""Writes the block templates and template parts of the Emma theme.

Run from the project folder:  python build/tools/make_templates.py
The repeated pieces (bound fields, facts, results) are generated so the block
markup stays identical everywhere, which keeps the editor from flagging blocks
as invalid.
"""
import os

ROOT = os.path.join(os.path.dirname(__file__), '..', 'emma')


def w(path, text):
    full = os.path.join(ROOT, path)
    os.makedirs(os.path.dirname(full), exist_ok=True)
    with open(full, 'w', encoding='utf8', newline='\n') as f:
        f.write(text.strip('\n') + '\n')
    print(path)


HEAD = '<!-- wp:template-part {"slug":"header","tagName":"header"} /-->\n'
FOOT = '<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->\n'

w('parts/header.html', '''
<!-- wp:group {"className":"emma-header"} -->
<div class="wp-block-group emma-header"><!-- wp:group {"className":"emma-wrap"} -->
<div class="wp-block-group emma-wrap"><!-- wp:site-logo {"width":170,"shouldSyncIcon":false} /-->

<!-- wp:group {"className":"emma-header-nav"} -->
<div class="wp-block-group emma-header-nav"><!-- wp:navigation {"overlayMenu":"mobile","layout":{"type":"flex","justifyContent":"right"}} -->
<!-- wp:navigation-link {"label":"Services","url":"/services/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Work","url":"/portfolio/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"About","url":"/about/","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Contact","url":"/contact/","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/contact/">Start a project</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
''')

w('parts/footer.html', '<!-- wp:pattern {"slug":"emma/footer"} /-->')

SECTIONS = HEAD + '''
<!-- wp:group {"tagName":"main"} -->
<main class="wp-block-group"><!-- wp:post-content {"className":"emma-sections"} /--></main>
<!-- /wp:group -->

''' + FOOT
w('templates/front-page.html', SECTIONS)
w('templates/page-sections.html', SECTIONS)

PLAIN = HEAD + '''
<!-- wp:group {"tagName":"main","className":"emma-plain","layout":{"type":"constrained"}} -->
<main class="wp-block-group emma-plain"><!-- wp:post-title {"level":1} /-->

<!-- wp:post-content {"layout":{"type":"constrained"}} /--></main>
<!-- /wp:group -->

''' + FOOT
w('templates/page.html', PLAIN)
w('templates/single.html', PLAIN)

w('templates/index.html', HEAD + '''
<!-- wp:group {"tagName":"main","className":"emma-plain","layout":{"type":"constrained"}} -->
<main class="wp-block-group emma-plain"><!-- wp:query-title {"type":"archive","showPrefix":false,"level":1} /-->

<!-- wp:query {"queryId":0,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true}} -->
<div class="wp-block-query"><!-- wp:post-template -->
<!-- wp:post-title {"level":2,"isLink":true} /-->

<!-- wp:post-excerpt /-->
<!-- /wp:post-template -->

<!-- wp:query-pagination -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></main>
<!-- /wp:group -->

''' + FOOT)

w('templates/404.html', HEAD + '''
<!-- wp:group {"tagName":"main"} -->
<main class="wp-block-group"><!-- wp:group {"className":"emma-page-hero"} -->
<div class="wp-block-group emma-page-hero"><!-- wp:group {"className":"emma-wrap"} -->
<div class="wp-block-group emma-wrap"><!-- wp:paragraph {"className":"is-style-label"} -->
<p class="is-style-label">Page not found</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">This page has moved or never existed.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"emma-lead"} -->
<p class="emma-lead">Go back to the homepage, or have a look at our work.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-sun"} -->
<div class="wp-block-button is-style-sun"><a class="wp-block-button__link wp-element-button" href="/">Back to the homepage</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->

''' + FOOT)


def archive(title_block):
    return HEAD + '''
<!-- wp:group {"tagName":"main"} -->
<main class="wp-block-group"><!-- wp:group {"className":"emma-page-hero"} -->
<div class="wp-block-group emma-page-hero"><!-- wp:group {"className":"emma-wrap"} -->
<div class="wp-block-group emma-wrap"><!-- wp:paragraph {"className":"is-style-label"} -->
<p class="is-style-label">Our work</p>
<!-- /wp:paragraph -->

''' + title_block + '''

<!-- wp:paragraph {"className":"emma-lead"} -->
<p class="emma-lead">A selection of projects. Choose a service to see the work that matches it.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"emma/portfolio-list"} /--></main>
<!-- /wp:group -->

''' + FOOT


w('templates/archive-case_study.html', archive(
    '<!-- wp:heading {"level":1} -->\n<h1 class="wp-block-heading">Work that made a difference.</h1>\n<!-- /wp:heading -->'))
w('templates/taxonomy-service.html', archive(
    '<!-- wp:query-title {"type":"archive","showPrefix":false,"level":1} /-->'))


def bound(key, cls):
    return ('<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"%s"}}}},"className":"%s"} -->\n'
            '<p class="%s"></p>\n<!-- /wp:paragraph -->') % (key, cls, cls)


def fact(label, key):
    return '''<!-- wp:group {"className":"emma-fact"} -->
<div class="wp-block-group emma-fact"><!-- wp:paragraph {"className":"is-style-label"} -->
<p class="is-style-label">%s</p>
<!-- /wp:paragraph -->

%s</div>
<!-- /wp:group -->''' % (label, bound(key, 'emma-fact-value'))


def result(n):
    return '''<!-- wp:group {"className":"emma-result"} -->
<div class="wp-block-group emma-result">%s

%s</div>
<!-- /wp:group -->''' % (bound('emma_result_%d_number' % n, 'emma-result-number'),
                        bound('emma_result_%d_label' % n, 'emma-result-label'))


w('templates/single-case_study.html', HEAD + '''
<!-- wp:group {"tagName":"main","className":"emma-case"} -->
<main class="wp-block-group emma-case"><!-- wp:group {"className":"emma-case-hero"} -->
<div class="wp-block-group emma-case-hero"><!-- wp:group {"className":"emma-wrap"} -->
<div class="wp-block-group emma-wrap"><!-- wp:post-terms {"term":"service"} /-->

<!-- wp:post-title {"level":1} /-->

<!-- wp:post-excerpt /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"emma-wrap"} -->
<div class="wp-block-group emma-wrap"><!-- wp:post-featured-image {"className":"emma-case-cover"} /-->

<!-- wp:group {"className":"emma-facts"} -->
<div class="wp-block-group emma-facts">''' + fact('Client', 'emma_client') + '\n\n' + fact('Industry', 'emma_industry') + '\n\n' + fact('Year', 'emma_year') + '''

<!-- wp:group {"className":"emma-fact emma-fact-link"} -->
<div class="wp-block-group emma-fact emma-fact-link"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"metadata":{"bindings":{"url":{"source":"core/post-meta","args":{"key":"emma_live_url"}}}},"className":"is-style-sun"} -->
<div class="wp-block-button is-style-sun"><a class="wp-block-button__link wp-element-button">Visit the website</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"emma-results"} -->
<div class="wp-block-group emma-results">''' + result(1) + '\n\n' + result(2) + '\n\n' + result(3) + '''</div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"emma-case-body"} -->
<div class="wp-block-group emma-case-body"><!-- wp:group {"className":"emma-wrap"} -->
<div class="wp-block-group emma-wrap"><!-- wp:post-content {"layout":{"type":"constrained"}} /-->

<!-- wp:group {"className":"emma-quote"} -->
<div class="wp-block-group emma-quote">''' + bound('emma_quote', 'emma-quote-text') + '\n\n' + bound('emma_quote_name', 'emma-quote-name') + '\n\n' + bound('emma_quote_role', 'emma-quote-role') + '''</div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"emma/cta"} /--></main>
<!-- /wp:group -->

''' + FOOT)
