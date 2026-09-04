import os
os.chdir(os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'niswah-boutique'))

def patch(path, pairs):
    s = open(path, encoding='utf8').read()
    for old, new in pairs:
        assert s.count(old) == 1, (path, old[:70], s.count(old))
        s = s.replace(old, new)
    open(path, 'w', encoding='utf8').write(s)

patch('functions.php', [
("NB_THEME_VERSION', '0.14.1'", "NB_THEME_VERSION', '0.15.0'"),
("'class-nb-qatar-checkout.php', 'class-nb-image-ratios.php' ) as $nb_inc ) {",
 "'class-nb-qatar-checkout.php', 'class-nb-image-ratios.php', 'class-nb-language.php' ) as $nb_inc ) {"),
])

# Ticker: append the switcher shortcode. Divi Text modules run do_shortcode on
# their content, and [nb_lang] prints nothing while TranslatePress is inactive.
patch('build/theme-builder.build.mjs', [
("        'FREE DELIVERY ON ORDERS OVER QAR 250 &nbsp;·&nbsp; +974 33882265 &nbsp;·&nbsp; INFO@NISWAHBOUTIQUE.COM'",
 "        // [nb_lang] = EN | AR switcher (includes/class-nb-language.php); CSS pins it\n"
 "        // to the ticker's right edge on desktop, inline after the text on phones.\n"
 "        'FREE DELIVERY ON ORDERS OVER QAR 250 &nbsp;·&nbsp; +974 33882265 &nbsp;·&nbsp; INFO@NISWAHBOUTIQUE.COM[nb_lang]'"),
])

s = open('style.css', encoding='utf8').read()
assert s.count(' Version:        0.14.1') == 1
s = s.replace(' Version:        0.14.1', ' Version:        0.15.0', 1)

# Nav breakpoints: measured 2026-09-04 — 14 items need ~1290px at 14px,
# ~1460px at 16px, ~1620px at 18px.
old_nav = """@media (min-width: 1301px) and (max-width: 1560px) {
  .nb-header .et_pb_menu__menu > nav > ul > li > a {
    font-size: 16px !important;
    letter-spacing: 0.4px !important;
  }
  .nb-header .et_pb_menu__menu > nav > ul > li { padding-right: 18px !important; }
}
@media (min-width: 981px) and (max-width: 1300px) {"""
new_nav = """@media (min-width: 1481px) and (max-width: 1640px) {
  .nb-header .et_pb_menu__menu > nav > ul > li > a {
    font-size: 16px !important;
    letter-spacing: 0.4px !important;
  }
  .nb-header .et_pb_menu__menu > nav > ul > li { padding-right: 18px !important; }
}
@media (min-width: 981px) and (max-width: 1480px) {"""
assert s.count(old_nav) == 1
s = s.replace(old_nav, new_nav)

s += open(os.path.join(os.path.dirname(os.path.abspath(__file__)), 'phase5.css.txt'), encoding='utf8').read()
open('style.css', 'w', encoding='utf8').write(s)
print('patched')
