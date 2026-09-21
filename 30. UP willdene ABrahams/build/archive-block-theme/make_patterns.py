"""Writes the static block patterns of the Emma theme into build/emma/patterns.

Run from the project folder:  python build/tools/make_patterns.py
(The Services page pattern is hand-written PHP: patterns/service-details.php.)

Each helper returns the exact markup the block editor itself saves, so the
client never sees "this block contains unexpected content".
"""
import os

ROOT = os.path.join(os.path.dirname(__file__), '..', 'emma', 'patterns')
os.makedirs(ROOT, exist_ok=True)


# ---- block helpers ---------------------------------------------------------
def _cls(c):
    return ' {"className":"%s"}' % c if c else ''


def P(text, cls=None):
    return '<!-- wp:paragraph%s -->\n<p%s>%s</p>\n<!-- /wp:paragraph -->' % (
        _cls(cls), ' class="%s"' % cls if cls else '', text)


def H(level, text, cls=None):
    attrs = {}
    if level != 2:
        attrs['level'] = level
    if cls:
        attrs['className'] = cls
    a = ''
    if attrs:
        a = ' {' + ','.join('"%s":%s' % (k, v if isinstance(v, int) else '"%s"' % v) for k, v in attrs.items()) + '}'
    return '<!-- wp:heading%s -->\n<h%d class="wp-block-heading%s">%s</h%d>\n<!-- /wp:heading -->' % (
        a, level, ' ' + cls if cls else '', text, level)


def G(inner, cls, tag='div', anchor=None):
    attrs = []
    if tag != 'div':
        attrs.append('"tagName":"%s"' % tag)
    attrs.append('"className":"%s"' % cls)
    body = '\n\n'.join(inner) if isinstance(inner, (list, tuple)) else inner
    return '<!-- wp:group {%s} -->\n<%s%s class="wp-block-group %s">%s</%s>\n<!-- /wp:group -->' % (
        ','.join(attrs), tag, ' id="%s"' % anchor if anchor else '', cls, body, tag)


def IMG(file, alt, cls, caption=None):
    src = "<?php echo esc_url( get_theme_file_uri( 'assets/img/%s' ) ); ?>" % file
    cap = '<figcaption class="wp-element-caption">%s</figcaption>' % caption if caption else ''
    return ('<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"%s"} -->\n'
            '<figure class="wp-block-image size-full %s"><img src="%s" alt="%s"/>%s</figure>\n<!-- /wp:image -->') % (
        cls, cls, src, alt, cap)


def BTN(text, url, style=None):
    return ('<!-- wp:button%s -->\n<div class="wp-block-button%s"><a class="wp-block-button__link wp-element-button" href="%s">%s</a></div>\n'
            '<!-- /wp:button -->') % (_cls(style), ' ' + style if style else '', url, text)


def BUTTONS(*btns):
    return '<!-- wp:buttons -->\n<div class="wp-block-buttons">%s</div>\n<!-- /wp:buttons -->' % '\n\n'.join(btns)


def LINK(text, url):
    return P('<a href="%s">%s</a>' % (url, text), 'is-style-text-link')


def LIST(items):
    lis = '\n\n'.join('<!-- wp:list-item -->\n<li>%s</li>\n<!-- /wp:list-item -->' % i for i in items)
    return '<!-- wp:list -->\n<ul class="wp-block-list">%s</ul>\n<!-- /wp:list -->' % lis


def DETAILS(q, a):
    return '<!-- wp:details -->\n<details class="wp-block-details"><summary>%s</summary>%s</details>\n<!-- /wp:details -->' % (q, P(a))


def COLUMNS(cols, cls):
    inner = '\n\n'.join(
        '<!-- wp:column {"className":"%s"} -->\n<div class="wp-block-column %s">%s</div>\n<!-- /wp:column -->' % (c, c, '\n\n'.join(body))
        for c, body in cols)
    return '<!-- wp:columns {"className":"%s"} -->\n<div class="wp-block-columns %s">%s</div>\n<!-- /wp:columns -->' % (cls, cls, inner)


def WRAP(*inner):
    return G(list(inner), 'emma-wrap')


def HEAD(title, link_text=None, link_url=None):
    inner = [H(2, title)]
    if link_text:
        inner.append(LINK(link_text, link_url))
    return G(inner, 'emma-section-head')


def pattern(slug, title, body, inserter=True, extra=''):
    head = '<?php\n/**\n * Title: %s\n * Slug: emma/%s\n * Categories: emma\n%s%s */\n?>\n' % (
        title, slug, '' if inserter else ' * Inserter: no\n', extra)
    with open(os.path.join(ROOT, slug + '.php'), 'w', encoding='utf8', newline='\n') as f:
        f.write(head + body.strip('\n') + '\n')
    print(slug)


SUN = IMG('sunflower-real.png', '', 'emma-bloom')


def page_hero(label, title, lead):
    return G(WRAP(P(label, 'is-style-label'), H(1, title), P(lead, 'emma-lead')), 'emma-page-hero', 'section')


# ---- home ------------------------------------------------------------------
pattern('hero', 'Hero with sunflower', G([
    SUN,
    WRAP(
        P('Emma Digital Agency', 'is-style-label'),
        H(1, 'Make your ideas bloom.'),
        P('Websites, search, social and automation for growing businesses. Clear plans, honest reporting and results you can see.', 'emma-lead'),
        BUTTONS(BTN('Start a project', '/contact/', 'is-style-sun'), BTN('See our work', '/portfolio/', 'is-style-textlink')),
    )], 'emma-hero', 'section'))

pattern('intro', 'Intro statement with two photos', G(WRAP(
    G([P('Who we are', 'is-style-label'),
       P('Emma looks after the digital side of your business, <em>from the website to the numbers behind it,</em> and explains every step in plain words.', 'emma-statement')],
      'emma-intro-head'),
    G([IMG('hero-team.jpg', 'The team working together around a laptop', 'emma-photo emma-ratio-16-10', 'One team for your website, search, social and data.'),
       IMG('intro-sketch.jpg', 'Sketching website layouts on paper', 'emma-photo emma-ratio-4-5', 'Every project starts on paper.')],
      'emma-intro-photos'),
), 'emma-intro', 'section'))

SERVICES = [
    ('web-development', 'Web Development', 'Fast, well-built websites that you can update yourself.', 'Design · Build · Care plans'),
    ('seo-sem', 'SEO &amp; SEM', 'Get found on Google, in the search results and through paid ads.', 'Technical SEO · Content · Google Ads'),
    ('social-media-marketing', 'Social Media Marketing', 'A steady, on-brand presence where your customers already spend their time.', 'Planning · Content · Paid social'),
    ('ai-solutions', 'AI Solutions', 'Practical AI tools that take repetitive work off your team.', 'Assistants · Workflows · Training'),
    ('email-automation', 'Email Automation', 'The right email at the right moment, sent without manual work.', 'Welcome flows · Newsletters · Segments'),
    ('analytics', 'Analytics', 'Clear numbers on what works, in reports that are easy to read.', 'Tracking setup · Dashboards · Monthly reports'),
]
rows = [G([H(3, '<a href="/services/#%s">%s</a>' % (slug, name)),
           G([P(text), P(tags, 'emma-tags')], 'emma-service-text')], 'emma-service')
        for slug, name, text, tags in SERVICES]
pattern('services-list', 'Services list (6 services)', G(WRAP(
    HEAD('What we do', 'All services', '/services/'),
    G(rows, 'emma-service-list'),
), 'emma-services', 'section'))

pattern('band', 'Full-width photo band', G([
    IMG('band-sunflowers.jpg', 'A sunflower field at sunset', 'emma-band-photo'),
    WRAP(P('Make your ideas bloom', 'is-style-label')),
], 'emma-band'))

QUERY = ('<!-- wp:query {"queryId":%d,"query":{"perPage":%d,"pages":0,"offset":0,"postType":"case_study","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":%s%s},"className":"emma-cases %s"} -->\n'
         '<div class="wp-block-query emma-cases %s"><!-- wp:post-template -->\n'
         '<!-- wp:post-featured-image {"isLink":true} /-->\n\n'
         '<!-- wp:group {"className":"emma-case-meta"} -->\n<div class="wp-block-group emma-case-meta"><!-- wp:post-title {"level":3,"isLink":true} /-->\n\n'
         '<!-- wp:post-terms {"term":"service"} /--></div>\n<!-- /wp:group -->\n\n'
         '<!-- wp:post-excerpt /-->\n<!-- /wp:post-template -->%s</div>\n<!-- /wp:query -->')

pattern('featured-work', 'Selected work (latest 3 projects)', G(WRAP(
    HEAD('Selected work', 'All projects', '/portfolio/'),
    QUERY % (11, 3, 'false', '', 'emma-cases-featured', 'emma-cases-featured', ''),
    G([LINK('See all projects', '/portfolio/')], 'emma-work-foot'),
), 'emma-work', 'section'))

STEPS = [('Talk', 'A short call about your business, your goals and what is not working today.'),
         ('Plan', 'A written plan with the scope, the timeline and a fixed price. No surprises later.'),
         ('Build', 'We do the work and keep you updated at every step, then launch it together.'),
         ('Measure', 'A clear report on the results, and ideas for what to improve next.')]
pattern('process', 'How we work (4 steps)', G(WRAP(
    HEAD('How we work'),
    G([G([H(3, t), P(d)], 'emma-step') for t, d in STEPS], 'emma-steps'),
), 'emma-process', 'section'))

pattern('cta', 'Call to action with sunflower', G([
    SUN,
    WRAP(
        P('Start a project', 'is-style-label'),
        H(2, 'Tell us what you are working on.'),
        P('A few lines about your business are enough. We will come back to you with ideas and a clear next step.', 'emma-lead'),
        BUTTONS(BTN('Get in touch', '/contact/')),
    )], 'emma-cta', 'section'))

# ---- portfolio list (used by the archive templates) -------------------------
NO_RESULTS = ('\n\n<!-- wp:query-no-results -->\n' + P('No projects here yet. Please check back soon.', 'emma-no-results') + '\n<!-- /wp:query-no-results -->'
              '\n\n<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->\n<!-- wp:query-pagination-previous /-->\n\n'
              '<!-- wp:query-pagination-numbers /-->\n\n<!-- wp:query-pagination-next /-->\n<!-- /wp:query-pagination -->')
pattern('portfolio-list', 'Portfolio list with service filter', G(WRAP(
    '<!-- wp:shortcode -->\n[emma_service_filter]\n<!-- /wp:shortcode -->',
    QUERY % (12, 12, 'true', '', 'emma-cases-grid', 'emma-cases-grid', NO_RESULTS),
), 'emma-archive', 'section'), inserter=False)

# ---- about -----------------------------------------------------------------
pattern('page-hero-about', 'Page intro: About', page_hero(
    'About', 'A small agency that treats your business like its own.',
    'Emma brings design, development and marketing together, so you talk to one team and always know what is happening.'))

pattern('story', 'Text with photo', G(WRAP(G([
    G([P('Our story', 'is-style-label'),
       H(2, 'Digital work should be clear, not complicated.'),
       P('Many business owners pay for websites and marketing they do not fully understand. Emma was started to change that: good work, explained in plain words, with results you can check yourself.'),
       P('We plan every project with you, agree a fixed price before we start, and report honestly on what worked and what did not.')],
      'emma-split-text'),
    IMG('hero-team.jpg', 'The team working together around a laptop', 'emma-photo emma-ratio-4-3'),
], 'emma-split')), 'emma-story', 'section'))

VALUES = [('Clear', 'Plain words, written plans and fixed prices. You always know what you are paying for.'),
          ('Careful', 'We build things properly, test them on real devices and look after them once they are live.'),
          ('Honest', 'We report the real numbers, including the ones that are not good yet, and say what we would do next.')]
pattern('values', 'Three values', G(WRAP(
    HEAD('What you can expect'),
    G([G([H(3, t), P(d)], 'emma-card') for t, d in VALUES], 'emma-cards'),
), 'emma-values', 'section'))

pattern('partners', 'Text with photo (photo left)', G(WRAP(G([
    IMG('intro-sketch.jpg', 'Sketching website layouts on paper', 'emma-photo emma-ratio-4-3'),
    G([P('How we are organised', 'is-style-label'),
       H(2, 'One contact, a network of specialists.'),
       P('You work with one person at Emma from the first call to the final report. Behind that contact is a network of trusted specialists: developers, SEO and ads experts, designers and analysts.'),
       P('Each project gets the people it needs and nothing more. That keeps quality high and prices fair.'),
       BUTTONS(BTN('See our work', '/portfolio/'))],
      'emma-split-text'),
], 'emma-split')), 'emma-story', 'section'))

TEAM = [('Team member name', 'Founder and main contact'), ('Team member name', 'Web development'),
        ('Team member name', 'SEO and paid search'), ('Team member name', 'Design and content')]
pattern('team', 'Team (4 people, text only)', G(WRAP(
    HEAD('The people behind Emma'),
    G([G([H(3, n), P(r)], 'emma-card emma-member') for n, r in TEAM], 'emma-cards'),
), 'emma-team', 'section'))

# ---- services --------------------------------------------------------------
pattern('page-hero-services', 'Page intro: Services', page_hero(
    'Services', 'Everything your business needs online, from one team.',
    'Six services that work well on their own and better together. Every project starts with a free first call and a written plan.'))

PLANS = [
    ('Starter', '$000', 'one-time, from', ['First item included in this package', 'Second item included', 'Third item included'], False),
    ('Growth', '$000', 'per month, from', ['Everything in Starter', 'First extra item', 'Second extra item', 'Third extra item'], True),
    ('Complete', '$000', 'per month, from', ['Everything in Growth', 'First extra item', 'Second extra item', 'Third extra item'], False),
]
cols = [('emma-price-card' + (' is-featured' if feat else ''),
         [H(3, name), P(price, 'emma-price'), P(note, 'emma-price-note'), LIST(items),
          BUTTONS(BTN('Choose ' + name, '/contact/', 'is-style-sun' if feat else None))])
        for name, price, note, items, feat in PLANS]
pattern('pricing', 'Pricing table (3 packages)', G(WRAP(
    HEAD('Packages and pricing'),
    COLUMNS(cols, 'emma-pricing'),
), 'emma-pricing-section', 'section'))

FAQ = [('How does a project start?', 'With a short call. After that you receive a written plan with the scope, the timeline and a fixed price. Work starts when you approve it.'),
       ('Can I update my website myself?', 'Yes. We build on WordPress and show you how to change text, images and prices. You also receive a short written guide.'),
       ('Do you work with businesses outside our country?', 'Yes. We work remotely with clients in different countries and time zones.'),
       ('What happens after launch?', 'You can look after the site yourself, or choose a care plan where we handle updates, backups and small changes.')]
pattern('faq', 'Questions and answers', G(WRAP(
    HEAD('Questions and answers'),
    G([DETAILS(q, a) for q, a in FAQ], 'emma-faq-list'),
), 'emma-faq', 'section'))

# ---- contact ---------------------------------------------------------------
pattern('page-hero-contact', 'Page intro: Contact', page_hero(
    'Contact', 'Tell us what you are working on.',
    'Fill in the form and we will reply within one working day. No sales pressure, just a clear next step.'))

pattern('contact-split', 'Contact details with enquiry form', G(WRAP(G([
    G([P('Email', 'is-style-label'), P('<a href="mailto:hello@emmadigitalagency.com">hello@emmadigitalagency.com</a>'),
       P('Working hours', 'is-style-label'), P('Monday to Friday, 9:00 to 17:00'),
       P('Where we work', 'is-style-label'), P('Remotely, with clients in every time zone.')],
      'emma-contact-details'),
    '<!-- wp:shortcode -->\n[emma_contact_form]\n<!-- /wp:shortcode -->',
], 'emma-split')), 'emma-contact', 'section'))

# ---- extra section for the client ------------------------------------------
pattern('testimonial', 'Client quote', G(WRAP(G([
    P('Replace this text with a real quote from a client.', 'emma-quote-text'),
    P('Client name', 'emma-quote-name'),
    P('Role, company', 'emma-quote-role'),
], 'emma-quote')), 'emma-story', 'section'))

# ---- footer ----------------------------------------------------------------
def FOOTLIST(title, links):
    return G([H(2, title), LIST(['<a href="%s">%s</a>' % (u, t) for t, u in links])], 'emma-footer-col')

pattern('footer', 'Footer', G(WRAP(
    G([G([IMG('logo-yellow.png', 'Emma Digital Agency', 'emma-footer-logo'),
          P('Make your ideas bloom. Websites, search, social, AI, email and analytics.', 'emma-footer-note')], 'emma-footer-col'),
       FOOTLIST('Pages', [('Services', '/services/'), ('Work', '/portfolio/'), ('About', '/about/'), ('Contact', '/contact/')]),
       FOOTLIST('Services', [(n, '/services/#' + s) for s, n, _, _ in SERVICES[:4]]),
       FOOTLIST('Contact', [('hello@emmadigitalagency.com', 'mailto:hello@emmadigitalagency.com'), ('Send an enquiry', '/contact/')])],
      'emma-footer-grid'),
    G([P('© <?php echo esc_html( gmdate( \'Y\' ) ); ?> Emma Digital Agency'), P('<a href="/privacy-policy/">Privacy policy</a>')], 'emma-legal'),
), 'emma-footer'), inserter=False)
