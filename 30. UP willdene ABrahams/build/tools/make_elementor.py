"""Writes the Elementor pages and templates of the Emma site as JSON.

Run from the project folder:  python build/tools/make_elementor.py
Output: build/emma-core/templates/*.json + manifest.json, imported by
Tools > Emma setup (emma-core/includes/setup.php).

Only normal Elementor / Elementor Pro widgets are used. Layout details come
from CSS classes in the child theme (emma-child/assets/css/theme.css).

Tokens replaced by the importer:
  {{img:FILE:url}} / "{{img:FILE:id}}"   media library copy of emma-core/assets/img/FILE
  "{{term:SLUG}}"                        term id of a Service
  "{{tpl:KEY}}"                          post id of an imported template
  {{menu}}                               slug of the main menu
  {{email}}                              the site admin email
"""
import hashlib
import json
import os

OUT = os.path.join(os.path.dirname(__file__), '..', 'emma-core', 'templates')
os.makedirs(OUT, exist_ok=True)

_n = [0]


def _id():
    _n[0] += 1
    return hashlib.md5(('emma-%d' % _n[0]).encode()).hexdigest()[:7]


# ---- element helpers --------------------------------------------------------
def con(children, cls='', width='full', tag=None, **settings):
    s = {'content_width': width, 'css_classes': cls}
    if tag:
        s['html_tag'] = tag
    s.update(settings)
    return {'id': _id(), 'elType': 'container', 'isInner': False, 'settings': s, 'elements': list(children)}


def section(children, cls, tag='section', **settings):
    """A full-width band whose content is boxed to the site width."""
    return con(children, cls='emma-section ' + cls, width='boxed', tag=tag, **settings)


def widget(kind, settings, cls=''):
    s = dict(settings)
    if cls:
        s['_css_classes'] = cls
    return {'id': _id(), 'elType': 'widget', 'widgetType': kind, 'settings': s, 'elements': []}


def heading(text, tag='h2', cls='', link=None):
    s = {'title': text, 'header_size': tag}
    if link:
        s['link'] = {'url': link, 'is_external': '', 'nofollow': ''}
    return widget('heading', s, cls)


def text(html, cls=''):
    if not html.lstrip().startswith('<'):
        html = '<p>%s</p>' % html
    return widget('text-editor', {'editor': html}, cls)


def label(t):
    return text(t, 'emma-label')


def image(file, alt, cls='', caption=None):
    s = {'image': {'url': '{{img:%s:url}}' % file, 'id': '{{img:%s:id}}' % file, 'alt': alt, 'source': 'library'},
         'image_size': 'full'}
    if caption:
        s['caption_source'] = 'custom'
        s['caption'] = caption
    return widget('image', s, cls)


def button(t, url, cls=''):
    return widget('button', {'text': t, 'link': {'url': url, 'is_external': '', 'nofollow': ''}}, cls)


def ul(items):
    return '<ul>' + ''.join('<li>%s</li>' % i for i in items) + '</ul>'


def dyn(name, settings=None):
    s = json.dumps(settings or {}, separators=(',', ':'))
    from urllib.parse import quote
    return '[elementor-tag id="%s" name="%s" settings="%s"]' % (_id(), name, quote(s))


def field(key):
    """Dynamic tag: a Project details field of the current project."""
    return dyn('post-custom-field', {'key': key, 'custom_key': key})


def section_head(title, link_text=None, link_url=None):
    kids = [heading(title, 'h2')]
    if link_text:
        kids.append(button(link_text, link_url, 'emma-textlink'))
    return con(kids, 'emma-section-head')


SUN = lambda: image('sunflower-real.png', '', 'emma-bloom')  # noqa: E731


def page_hero(lab, title, lead):
    return section([label(lab), heading(title, 'h1'), text(lead, 'emma-lead')], 'emma-page-hero')


def cta():
    return section([
        SUN(),
        label('Start a project'),
        heading('Tell us what you are working on.', 'h2'),
        text('A few lines about your business are enough. We will come back to you with ideas and a clear next step.', 'emma-lead'),
        button('Get in touch', '/contact/'),
    ], 'emma-cta')


def loop_grid(cls, per_page, columns, extra=None):
    s = {'template_id': '{{tpl:loop-case}}', 'post_query_post_type': 'case_study', 'posts_per_page': per_page,
         'columns': columns, 'columns_tablet': min(columns, 2), 'columns_mobile': 1,
         'post_query_orderby': 'post_date', 'post_query_order': 'desc',
         'nothing_found_message_text': 'No projects here yet. Please check back soon.', 'enable_nothing_found_message': 'yes'}
    if extra:
        s.update(extra)
    return widget('loop-grid', s, 'emma-cases ' + cls)


MANIFEST = []


def save(key, title, kind, elements, **meta):
    with open(os.path.join(OUT, key + '.json'), 'w', encoding='utf8', newline='\n') as f:
        json.dump(elements, f, ensure_ascii=False, indent=1)
    MANIFEST.append(dict(key=key, title=title, kind=kind, **meta))
    print(key)


SERVICES = [
    ('web-development', 'Web Development', 'Fast, well-built websites that you can update yourself.', 'Design · Build · Care plans',
     'Websites that load fast, look right on every screen and are easy for you to update. Built on WordPress, with a design made for your brand.',
     ['Design made for your brand, not a template', 'Responsive build for phone, tablet and desktop', 'Speed, security and search basics included', 'A short guide so you can edit it yourself']),
    ('seo-sem', 'SEO &amp; SEM', 'Get found on Google, in the search results and through paid ads.', 'Technical SEO · Content · Google Ads',
     'Be found when people search for what you sell. We fix the technical basics, improve your pages and run paid search where it pays off.',
     ['Technical and on-page SEO audit', 'Keyword and content plan', 'Google Ads setup and management', 'Monthly report in plain words']),
    ('social-media-marketing', 'Social Media Marketing', 'A steady, on-brand presence where your customers already spend their time.', 'Planning · Content · Paid social',
     'A steady, recognisable presence on the channels your customers use, with content planned ahead instead of posted in a hurry.',
     ['Channel and content plan', 'Post design and copy', 'Paid social campaigns', 'Community replies and reporting']),
    ('ai-solutions', 'AI Solutions', 'Practical AI tools that take repetitive work off your team.', 'Assistants · Workflows · Training',
     'Practical AI that saves your team time: assistants that answer common questions and workflows that take over repetitive tasks.',
     ['Review of where AI can help you', 'Assistants trained on your own content', 'Automated workflows between your tools', 'Training for your team']),
    ('email-automation', 'Email Automation', 'The right email at the right moment, sent without manual work.', 'Welcome flows · Newsletters · Segments',
     'Emails that send themselves at the right moment: a welcome series, reminders and newsletters your customers want to open.',
     ['Setup of your email platform', 'Welcome and follow-up flows', 'Newsletter templates in your brand', 'List segments and reporting']),
    ('analytics', 'Analytics', 'Clear numbers on what works, in reports that are easy to read.', 'Tracking setup · Dashboards · Monthly reports',
     'Know what works. We set up clean tracking and turn the numbers into a dashboard and a report you can read in five minutes.',
     ['Analytics and conversion tracking setup', 'Dashboard with the numbers that matter', 'Monthly report with next steps', 'Privacy-friendly configuration']),
]

# ---- loop item: one project card ---------------------------------------------
save('loop-case', 'Project card', 'loop-item', [con([
    widget('theme-post-featured-image', {'image_size': 'large', 'link_to': 'custom',
                                         '__dynamic__': {'link': dyn('post-url')}}, 'emma-case-image'),
    con([
        widget('theme-post-title', {'header_size': 'h3', '__dynamic__': {'title': dyn('post-title'), 'link': dyn('post-url')}}, 'emma-case-title'),
        widget('post-info', {'view': 'inline', 'icon_list': [
            {'_id': _id(), 'type': 'terms', 'taxonomy': 'service', 'show_icon': 'none', 'terms_link': '', 'link': ''}]}, 'emma-case-terms'),
    ], 'emma-case-meta'),
    widget('theme-post-excerpt', {'__dynamic__': {'excerpt': dyn('post-excerpt')}}, 'emma-case-excerpt'),
], 'emma-case-card')])

# ---- header / footer ---------------------------------------------------------
save('header', 'Header', 'header', [section([
    widget('theme-site-logo', {'image_size': 'full', 'link_to': 'custom',
                               '__dynamic__': {'image': dyn('site-logo'), 'link': dyn('site-url')}}, 'emma-logo'),
    con([
        widget('nav-menu', {'menu': '{{menu}}', 'layout': 'horizontal', 'align_items': 'end', 'pointer': 'none',
                            'dropdown': 'mobile', 'full_width': 'stretch', 'toggle': 'burger', 'submenu_icon': {'value': '', 'library': ''}}, 'emma-nav'),
        button('Start a project', '/contact/', 'emma-header-cta'),
    ], 'emma-header-nav'),
], 'emma-header', tag='header')], conditions=['include/general'])


def foot_col(title, links):
    return con([heading(title, 'h2'), text(ul('<a href="%s">%s</a>' % (u, t) for t, u in links))], 'emma-footer-col')


save('footer', 'Footer', 'footer', [section([
    con([
        con([image('logo-yellow.png', 'Emma Digital Agency', 'emma-footer-logo'),
             text('Make your ideas bloom. Websites, search, social, AI, email and analytics.', 'emma-footer-note')], 'emma-footer-col'),
        foot_col('Pages', [('Services', '/services/'), ('Work', '/portfolio/'), ('About', '/about/'), ('Contact', '/contact/')]),
        foot_col('Services', [(s[1], '/services/#' + s[0]) for s in SERVICES[:4]]),
        foot_col('Contact', [('{{email}}', 'mailto:{{email}}'), ('Send an enquiry', '/contact/')]),
    ], 'emma-footer-grid'),
    con([text('© 2026 Emma Digital Agency'), text('<p><a href="/privacy-policy/">Privacy policy</a></p>')], 'emma-legal'),
], 'emma-footer', tag='footer')], conditions=['include/general'])

# ---- pricing: saved once, shown wherever the Template widget is placed ------------
PLANS = [('Starter', '$000', 'one-time, from', ['First item included in this package', 'Second item included', 'Third item included'], False),
         ('Growth', '$000', 'per month, from', ['Everything in Starter', 'First extra item', 'Second extra item', 'Third extra item'], True),
         ('Complete', '$000', 'per month, from', ['Everything in Growth', 'First extra item', 'Second extra item', 'Third extra item'], False)]
save('pricing', 'Pricing table', 'section', [section([
    section_head('Packages and pricing'),
    con([con([heading(n, 'h3'), text(p, 'emma-price'), text(note, 'emma-price-note'), text(ul(items), 'emma-price-list'),
              button('Choose ' + n, '/contact/', 'emma-sun' if feat else '')],
             'emma-price-card' + (' is-featured' if feat else '')) for n, p, note, items, feat in PLANS], 'emma-pricing'),
], 'emma-pricing-section')])

# ---- home --------------------------------------------------------------------
STEPS = [('Talk', 'A short call about your business, your goals and what is not working today.'),
         ('Plan', 'A written plan with the scope, the timeline and a fixed price. No surprises later.'),
         ('Build', 'We do the work and keep you updated at every step, then launch it together.'),
         ('Measure', 'A clear report on the results, and ideas for what to improve next.')]

save('home', 'Home', 'page', [
    section([
        SUN(),
        label('Emma Digital Agency'),
        heading('Make your ideas bloom.', 'h1'),
        text('Websites, search, social and automation for growing businesses. Clear plans, honest reporting and results you can see.', 'emma-lead'),
        con([button('Start a project', '/contact/', 'emma-sun'), button('See our work', '/portfolio/', 'emma-textlink')], 'emma-actions'),
    ], 'emma-hero'),
    section([
        con([label('Who we are'),
             text('Emma looks after the digital side of your business, <em>from the website to the numbers behind it,</em> and explains every step in plain words.', 'emma-statement')],
            'emma-intro-head'),
        con([image('hero-team.jpg', 'The team working together around a laptop', 'emma-photo emma-ratio-16-10', 'One team for your website, search, social and data.'),
             image('intro-sketch.jpg', 'Sketching website layouts on paper', 'emma-photo emma-ratio-4-5', 'Every project starts on paper.')],
            'emma-intro-photos'),
    ], 'emma-intro'),
    section([
        section_head('What we do', 'All services', '/services/'),
        con([con([heading(name, 'h3', link='/services/#' + slug),
                  con([text(short), text(tags, 'emma-tags')], 'emma-service-text')], 'emma-service')
             for slug, name, short, tags, _, _ in SERVICES], 'emma-service-list'),
    ], 'emma-services'),
    con([image('band-sunflowers.jpg', 'A sunflower field at sunset', 'emma-band-photo'), label('Make your ideas bloom')], 'emma-band'),
    section([
        section_head('Selected work', 'All projects', '/portfolio/'),
        widget('shortcode', {'shortcode': '[emma_projects count="3" layout="featured"]'}, 'emma-projects-widget'),
        con([button('See all projects', '/portfolio/', 'emma-textlink')], 'emma-work-foot'),
    ], 'emma-work'),
    section([
        section_head('How we work'),
        con([con([heading(t, 'h3'), text(d)], 'emma-step') for t, d in STEPS], 'emma-steps'),
    ], 'emma-process'),
    cta(),
], slug='home', front=True)

# ---- about -------------------------------------------------------------------
VALUES = [('Clear', 'Plain words, written plans and fixed prices. You always know what you are paying for.'),
          ('Careful', 'We build things properly, test them on real devices and look after them once they are live.'),
          ('Honest', 'We report the real numbers, including the ones that are not good yet, and say what we would do next.')]
TEAM = [('Team member name', 'Founder and main contact'), ('Team member name', 'Web development'),
        ('Team member name', 'SEO and paid search'), ('Team member name', 'Design and content')]

save('about', 'About', 'page', [
    page_hero('About', 'A small agency that treats your business like its own.',
              'Emma brings design, development and marketing together, so you talk to one team and always know what is happening.'),
    section([con([
        con([label('Our story'), heading('Digital work should be clear, not complicated.', 'h2'),
             text('<p>Many business owners pay for websites and marketing they do not fully understand. Emma was started to change that: good work, explained in plain words, with results you can check yourself.</p>'
                  '<p>We plan every project with you, agree a fixed price before we start, and report honestly on what worked and what did not.</p>')],
            'emma-split-text'),
        image('hero-team.jpg', 'The team working together around a laptop', 'emma-photo emma-ratio-4-3'),
    ], 'emma-split')], 'emma-story'),
    section([section_head('What you can expect'),
             con([con([heading(t, 'h3'), text(d)], 'emma-card') for t, d in VALUES], 'emma-cards')], 'emma-values'),
    section([con([
        image('intro-sketch.jpg', 'Sketching website layouts on paper', 'emma-photo emma-ratio-4-3'),
        con([label('How we are organised'), heading('One contact, a network of specialists.', 'h2'),
             text('<p>You work with one person at Emma from the first call to the final report. Behind that contact is a network of trusted specialists: developers, SEO and ads experts, designers and analysts.</p>'
                  '<p>Each project gets the people it needs and nothing more. That keeps quality high and prices fair.</p>'),
             button('See our work', '/portfolio/')], 'emma-split-text'),
    ], 'emma-split')], 'emma-story'),
    section([section_head('The people behind Emma'),
             con([con([heading(n, 'h3'), text(r)], 'emma-card emma-member') for n, r in TEAM], 'emma-cards emma-cards-4')], 'emma-team'),
    cta(),
], slug='about')

# ---- services ----------------------------------------------------------------
FAQ = [('How does a project start?', 'With a short call. After that you receive a written plan with the scope, the timeline and a fixed price. Work starts when you approve it.'),
       ('Can I update my website myself?', 'Yes. We build on WordPress and show you how to change text, images and prices. You also receive a short written guide.'),
       ('Do you work with businesses in other countries?', 'Yes. We work remotely with clients in different countries and time zones.'),
       ('What happens after launch?', 'You can look after the site yourself, or choose a care plan where we handle updates, backups and small changes.')]

service_sections = [
    section([con([
        con([heading(name, 'h2'), text(long), text(ul(items), 'emma-checklist'),
             button('Ask about ' + name, '/contact/', 'emma-sun')], 'emma-split-text'),
        con([label('Related work'),
             loop_grid('emma-cases-small', 2, 2, {'post_query_include': ['terms'], 'post_query_include_term_ids': ['{{term:%s}}' % slug],
                                                 'nothing_found_message_text': 'Case studies for this service are coming soon.'})],
            'emma-related'),
    ], 'emma-split')], 'emma-service-detail', _element_id=slug)
    for slug, name, _, _, long, items in SERVICES]

save('services', 'Services', 'page', [
    page_hero('Services', 'Everything your business needs online, from one team.',
              'Six services that work well on their own and better together. Every project starts with a free first call and a written plan.'),
    *service_sections,
    widget('template', {'template_id': '{{tpl:pricing}}'}, 'emma-pricing-embed'),
    section([section_head('Questions and answers'),
             widget('accordion', {'tabs': [{'_id': _id(), 'tab_title': q, 'tab_content': '<p>%s</p>' % a} for q, a in FAQ],
                                  'title_html_tag': 'h3', 'faq_schema': 'yes',
                                  'selected_icon': {'value': 'fas fa-plus', 'library': 'fa-solid'},
                                  'selected_active_icon': {'value': 'fas fa-minus', 'library': 'fa-solid'}}, 'emma-faq-list')], 'emma-faq'),
    cta(),
], slug='services')

# ---- portfolio ---------------------------------------------------------------
grid = loop_grid('emma-cases-grid', 12, 2, {'pagination_type': 'load_more_on_click', 'load_more_button_text': 'Show more projects'})
save('portfolio', 'Portfolio', 'page', [
    page_hero('Our work', 'Work that made a difference.', 'A selection of projects. Choose a service to see the work that matches it.'),
    section([
        widget('taxonomy-filter', {'selected_element': grid['id'], 'taxonomy': 'service', 'show_first_item': 'yes',
                                   'first_item_title': 'All work', 'horizontal_scroll': 'enable'}, 'emma-filter'),
        grid,
    ], 'emma-archive'),
    cta(),
], slug='portfolio')

save('archive-service', 'Service archive', 'archive', [
    section([label('Our work'),
             widget('theme-archive-title', {'header_size': 'h1', '__dynamic__': {'title': dyn('archive-title', {'include_context': ''})}}),
             text('Projects for this service. <a href="/portfolio/">See all work</a>.', 'emma-lead')], 'emma-page-hero'),
    section([loop_grid('emma-cases-grid', 12, 2, {'post_query_post_type': 'current_query'})], 'emma-archive'),
    cta(),
], conditions=['include/archive/service'])

# ---- single project ----------------------------------------------------------
def fact(lab, key):
    return con([label(lab), widget('text-editor', {'editor': '', '__dynamic__': {'editor': field(key)}}, 'emma-fact-value')],
               'emma-fact emma-if-' + key)


def result(n):
    return con([widget('heading', {'title': '', 'header_size': 'p', '__dynamic__': {'title': field('emma_result_%d_number' % n)}}, 'emma-result-number'),
                widget('text-editor', {'editor': '', '__dynamic__': {'editor': field('emma_result_%d_label' % n)}}, 'emma-result-label')],
               'emma-result emma-if-emma_result_%d_number' % n)


save('single-case', 'Single project', 'single-post', [
    section([
        widget('post-info', {'view': 'inline', 'icon_list': [{'_id': _id(), 'type': 'terms', 'taxonomy': 'service', 'show_icon': 'none'}]}, 'emma-case-terms'),
        widget('theme-post-title', {'header_size': 'h1', '__dynamic__': {'title': dyn('post-title')}}),
        widget('theme-post-excerpt', {'__dynamic__': {'excerpt': dyn('post-excerpt')}}, 'emma-lead'),
    ], 'emma-case-hero'),
    section([
        widget('theme-post-featured-image', {'image_size': 'full', '__dynamic__': {'image': dyn('post-featured-image')}}, 'emma-case-cover'),
        con([fact('Client', 'emma_client'), fact('Industry', 'emma_industry'), fact('Year', 'emma_year'),
             con([widget('button', {'text': 'Visit the website', 'link': {'url': '', 'is_external': 'on', 'nofollow': ''},
                                    '__dynamic__': {'link': field('emma_live_url')}}, 'emma-sun')], 'emma-fact emma-fact-link emma-if-emma_live_url')],
            'emma-facts'),
        con([result(1), result(2), result(3)], 'emma-results emma-if-emma_result_1_number'),
    ], 'emma-case-top'),
    section([
        widget('theme-post-content', {}, 'emma-case-content'),
        con([widget('text-editor', {'editor': '', '__dynamic__': {'editor': field('emma_quote')}}, 'emma-quote-text'),
             widget('text-editor', {'editor': '', '__dynamic__': {'editor': field('emma_quote_name')}}, 'emma-quote-name'),
             widget('text-editor', {'editor': '', '__dynamic__': {'editor': field('emma_quote_role')}}, 'emma-quote-role')], 'emma-quote emma-if-emma_quote'),
    ], 'emma-case-body'),
    cta(),
], conditions=['include/singular/case_study'])

# ---- contact -----------------------------------------------------------------
def ff(cid, kind, lab, width='100', required=True, **extra):
    d = {'_id': _id(), 'custom_id': cid, 'field_type': kind, 'field_label': lab, 'placeholder': '', 'width': width,
         'required': 'true' if required else ''}
    d.update(extra)
    return d


FORM = widget('form', {
    'form_name': 'Enquiry',
    'form_fields': [
        ff('name', 'text', 'Your name', '50'),
        ff('email', 'email', 'Email', '50'),
        ff('company', 'text', 'Company', '50', required=False),
        ff('service', 'select', 'What can we help with?', '50', required=False,
           field_options='\n'.join(['Not sure yet'] + [s[1].replace('&amp;', '&') for s in SERVICES])),
        ff('message', 'textarea', 'Tell us about your project', rows=6),
        ff('website_url', 'honeypot', '', required=False),
    ],
    'show_labels': 'true', 'mark_required': '', 'button_text': 'Send enquiry', 'button_width': '100',
    'submit_actions': ['save-to-database', 'email'],
    'email_to': '{{email}}', 'email_subject': 'New enquiry from the Emma website',
    'email_content': '[all-fields]', 'email_from': 'hello@emmadigitalagency.com', 'email_from_name': 'Emma website',
    'email_reply_to': 'email', 'form_metadata': ['date', 'time', 'page_url'],
    'success_message': 'Thank you. Your enquiry has been sent, and we will reply within one working day.',
    'error_message': 'Your enquiry could not be sent. Please try again, or email us directly.',
    'required_field_message': 'Please fill in this field.', 'invalid_message': 'Please check this field.',
    'custom_messages': 'yes',
}, 'emma-form')

save('contact', 'Contact', 'page', [
    page_hero('Contact', 'Tell us what you are working on.',
              'Fill in the form and we will reply within one working day. No sales pressure, just a clear next step.'),
    section([con([
        con([label('Email'), text('<p><a href="mailto:{{email}}">{{email}}</a></p>'),
             label('Working hours'), text('Monday to Friday, 9:00 to 17:00'),
             label('Where we work'), text('Remotely, with clients in every time zone.')], 'emma-contact-details'),
        FORM,
    ], 'emma-split emma-split-form')], 'emma-contact'),
], slug='contact')

# ---- 404 ---------------------------------------------------------------------
save('not-found', 'Page not found', 'error-404', [
    section([label('Page not found'), heading('This page has moved or never existed.', 'h1'),
             text('Go back to the homepage, or have a look at our work.', 'emma-lead'),
             con([button('Back to the homepage', '/', 'emma-sun'), button('See our work', '/portfolio/', 'emma-textlink')], 'emma-actions')],
            'emma-page-hero'),
], conditions=['include/singular/not_found404'])

with open(os.path.join(OUT, 'manifest.json'), 'w', encoding='utf8', newline='\n') as f:
    json.dump(MANIFEST, f, indent=1)
print('manifest: %d documents' % len(MANIFEST))
