import os
os.chdir(os.path.join(os.path.dirname(os.path.abspath(__file__)), '..', 'niswah-boutique'))

def patch(path, pairs):
    s = open(path, encoding='utf8').read()
    for old, new in pairs:
        assert s.count(old) == 1, (path, old[:70], s.count(old))
        s = s.replace(old, new)
    open(path, 'w', encoding='utf8').write(s)

patch('functions.php', [
("NB_THEME_VERSION', '0.13.1'", "NB_THEME_VERSION', '0.14.0'"),
("'class-nb-payment-methods.php', 'class-nb-qatar-checkout.php' ) as $nb_inc ) {",
 "'class-nb-payment-methods.php', 'class-nb-qatar-checkout.php', 'class-nb-image-ratios.php' ) as $nb_inc ) {"),
("""function nb_image_size_thumbnail( $size ) {
	return array( 'width' => 800, 'height' => 1200, 'crop' => 1 );
}""", """/*
 * Round 2 (2026-09-04): cards are no longer one ratio — hijabs/accessories
 * are 1:1, garments 1:2 (includes/class-nb-image-ratios.php). A hard 2:3
 * crop would lose content in both frames, so thumbnails are now generated
 * UNcropped inside an 800x1600 box and object-fit: cover does the framing.
 * Regenerate: WooCommerce -> Status -> Tools -> Regenerate shop thumbnails.
 */
function nb_image_size_thumbnail( $size ) {
	return array( 'width' => 800, 'height' => 1600, 'crop' => 0 );
}"""),
("""function nb_image_size_single( $size ) {
	return array( 'width' => 1200, 'height' => 1800, 'crop' => 1 );
}""", """function nb_image_size_single( $size ) {
	return array( 'width' => 1200, 'height' => 2400, 'crop' => 0 );
}"""),
])

s = open('style.css', encoding='utf8').read()
assert s.count(' Version:        0.13.1') == 1
s = s.replace(' Version:        0.13.1', ' Version:        0.14.0', 1)
s += r"""

/* =========================================================================
   16. IMAGE RATIO BY CATEGORY (round 2, 2026-09-04)
   Hijabs & Accessories 1:1 · garments 1:2. Classes come from
   includes/class-nb-image-ratios.php. The default 2:3 frame stays for any
   product the classes do not reach.
   ========================================================================= */

ul.products li.product.nb-ratio-square .nb-card__media { aspect-ratio: 1 / 1; }
ul.products li.product.nb-ratio-tall   .nb-card__media { aspect-ratio: 1 / 2; }

/* Mixed grids (home, shop): a square hijab next to a 1:2 dress leaves uneven
   card bottoms. Pin every card to the top of its row so the titles at least
   start from a straight line under their own image. */
ul.products { align-items: start; }

/* Single product gallery: square products get a square frame. Garments keep
   2:3 here on purpose — a 1:2 frame at the gallery's 710px width would be
   1420px tall, taller than most screens, and the gallery is sticky. */
body.nb-ratio-square .nb-single-product .woocommerce-product-gallery__image,
body.nb-single-product.nb-ratio-square .woocommerce-product-gallery__image { aspect-ratio: 1 / 1; }
"""
open('style.css', 'w', encoding='utf8').write(s)
print('patched')
