import os
os.chdir(os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'niswah-boutique'))

def patch(path, pairs):
    s = open(path, encoding='utf8').read()
    for old, new in pairs:
        assert s.count(old) == 1, (path, old[:70], s.count(old))
        s = s.replace(old, new)
    open(path, 'w', encoding='utf8').write(s)

patch('functions.php', [
("NB_THEME_VERSION', '0.12.0'", "NB_THEME_VERSION', '0.13.0'"),
("foreach ( array( 'class-nb-pages.php', 'class-nb-payment-methods.php' ) as $nb_inc ) {",
 "foreach ( array( 'class-nb-pages.php', 'class-nb-payment-methods.php', 'class-nb-qatar-checkout.php' ) as $nb_inc ) {"),
])

patch('data/pages.json', [
('"trash_slugs": [ "sample-page" ]', '"trash_slugs": [ "sample-page", "refund_returns" ]'),
])

s = open('style.css', encoding='utf8').read()
assert s.count(' Version:        0.12.0') == 1
s = s.replace(' Version:        0.12.0', ' Version:        0.13.0', 1)
s += r"""

/* =========================================================================
   15. ROUND-2 FIXES (0.13.0)
   ========================================================================= */

/* Divi's Code module and the theme's list reset both put bullets and
   indents back on the badge list; win on specificity, not !important. */
.nb-payment ul.nb-payment__list { list-style: none; margin: 0; padding: 0; }
.nb-payment ul.nb-payment__list li.nb-payment__item { list-style: none; margin: 0; }
.nb-payment .nb-payment__label { line-height: 1; }

/* 14 nav items (About Us added) wrap to two lines under ~1500px at 18px.
   Step the type down before it wraps; the reference nav is 16px anyway. */
@media (min-width: 981px) and (max-width: 1560px) {
  .nb-header .et_pb_menu__menu > nav > ul > li > a {
    font-size: 16px !important;
    letter-spacing: 0.4px !important;
  }
  .nb-header .et_pb_menu__menu > nav > ul > li { padding-right: 18px !important; }
}

/* Tax disclosure line (Qatar: no VAT in force; client asked for it). */
.nb-tax-note {
  font-size: 12px;
  letter-spacing: 0.4px;
  opacity: 0.7;
  margin: -6px 0 18px;
}
.nb-cart .nb-tax-note-row td,
.nb-checkout .nb-tax-note-row td {
  font-size: 12px;
  opacity: 0.7;
  border: 0;
  padding: 6px 0 0;
  text-align: right;
}

/* Qatar checkout fields: Building / Unit share one row like first/last name. */
.nb-checkout .woocommerce form .form-row.nb-field-building,
.nb-checkout .woocommerce form .form-row.nb-field-unit { width: 48%; float: left; }
.nb-checkout .woocommerce form .form-row.nb-field-unit { float: right; }
@media (max-width: 767px) {
  .nb-checkout .woocommerce form .form-row.nb-field-building,
  .nb-checkout .woocommerce form .form-row.nb-field-unit { width: 100%; float: none; }
}
"""
open('style.css', 'w', encoding='utf8').write(s)
print('patched')
