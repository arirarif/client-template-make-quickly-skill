# Delivery Note — Niswah Boutique

**Site:** niswahboutique.com · **Theme:** Niswah Boutique (Divi child) **v0.10.17**
**Reference:** niswafashion.com · **Delivered:** 2026-08-30

---

## Delivered

**Global sections** — header (ticker, centred logo, category nav, cart, search) and
footer, built once in Divi's Default Website Template so all five templates inherit
them. Edit in one place, changes everywhere.

**T1 Home** — 7 sections: hero, Shop New Arrivals (3-up, wired to WooCommerce
"Featured" so you pick them by starring a product), category tiles, trust badges,
best sellers, editorial banner, newsletter. Every dimension measured off the
reference's live page, not eyeballed.

**T2 All Products** — centred serif heading, sort control, "44 products" count,
4-column grid, 12 per page.

**T3 Single Product** — two equal columns, sticky image gallery with thumbnail rail,
round colour swatches, square size buttons in real size order (S–XXL, not
alphabetical), description under the buy button, 4 related products.

**T4 Category Archive** — same archive header plus category description; category
thumbnails auto-filled from each category's newest product photo.

**T5 General pages** — global header, footer and typography applied to static pages.

**Beyond the order, at no extra charge:** Collections page at `/collections/`, plus a
full Cart and Checkout — two-column cart as you asked, styled totals panel, and
error notices that read as errors instead of Divi's blue info boxes.

**Catalogue** — 44 products, 457 variations, 11 categories. Prices in QAR, converted
correctly (the source quotes US cents; a raw import would have priced a 17-dollar
scarf at 1,700).

**Product card** used site-wide: 2:3 portrait, second photo crossfades on hover,
ADD TO CART on hover, sale badge. Grid drops 4 → 3 → 2 columns.

**Mobile** — verified at a 400px viewport: home, shop, product and cart all render
with no horizontal overflow.

**Also fixed:** blurry product photos (image sizes raised to 1200×1800, quality 90),
`/product-category/` 404 now redirects to Collections, nav menu built from your live
categories, logo now links to the home page, breadcrumbs restored.

---

## How to update anything

1. Appearance → Add Theme → Upload → **Replace installed with uploaded**
2. Appearance → **Niswah Starter → Import Everything**

Step 2 is essential — Divi stores layouts in the database, so uploading the theme
alone changes nothing on screen. Re-running is always safe.

---

## Needs your action

1. **No payment gateway is enabled.** No customer can complete an order until one is
   set up in WooCommerce → Settings → Payments. This is the only thing blocking sales.
2. **Remove WP Reset.** It wiped the database once already — products, menus and
   templates all lost.
3. **Free up disk space.** Theme uploads failed twice on a full disk. Deleting the
   unused *Molti* and *Divi Ecommerce Pro* themes and the 17 inactive plugins fixes it.
4. **Horizontal logo variant** would let the header sit at the reference's 128px
   instead of 155px. The current stacked logo can't shrink that far and stay readable.
5. Two categories have no image yet — they'll fill in automatically once a product in
   them gets a featured photo.
