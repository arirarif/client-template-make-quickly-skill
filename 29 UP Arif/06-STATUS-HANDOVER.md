# Status & Handover — Niswah Boutique

Written 2026-08-27. Live theme version **0.9.1**.

Read this first, then `05-CATALOGUE-AND-HOME-PLAN.md` for measured design values and
`.unlazy/divi-build/PLAN.md` for the full event log.

---

## 1. How to change anything on this site

Layouts are **generated**, not clicked together in the builder. Never edit the Home,
Collections, header or footer inside Divi — the next import overwrites it. Edit the
generator instead.

```
1  edit  niswah-boutique/build/theme-builder.build.mjs      (layouts)
         niswah-boutique/style.css                          (styling)
         niswah-boutique/functions.php                      (Woo behaviour)
         niswah-boutique/includes/class-nb-starter-import.php (import + menu)

2  bump  Version: in style.css AND NB_THEME_VERSION in functions.php  (must match)

3  node niswah-boutique/build/theme-builder.build.mjs
   powershell -ExecutionPolicy Bypass -File niswah-boutique/build/pack.ps1

4  WP Admin → Appearance → Add Theme → Upload → Replace installed with uploaded

5  WP Admin → Appearance → Niswah Starter → Import Everything
```

**Step 5 is the one people forget.** Divi stores Theme Builder layouts in the
DATABASE. Uploading theme files changes nothing on screen until the importer runs.
Symptom: new CSS is live but the page looks identical.

`pack.ps1` refuses to build if the two version numbers disagree, and writes
forward-slash zip entries — `Compress-Archive` writes backslashes, which WordPress
rejects with "no valid themes were found".

### What "Import Everything" does

- Replaces the Theme Builder template (header + footer)
- Rebuilds the Home page (#21) and Collections page (#783)
- **Rebuilds the nav menu** from live product categories, and writes the real menu id
  into the header layout's Divi menu module
- **Backfills category thumbnails** from each category's newest product photo — only
  fills empty ones, never overwrites a deliberate choice

It is idempotent. Re-running is always safe.

---

## 2. What is done

### Home page — matched to measured reference values

Every dimension was read off niswafashion.com's live DOM. Order comes from the
reference's own Shopify `<section id="shopify-section-…">` wrappers.

| # | Section | State |
|---|---|---|
| — | Ticker | 40px, exact |
| — | Header | 155px (target 128 — see Known Gaps) |
| 1 | Hero | done |
| 2 | Shop New Arrivals — 3-up full-bleed | exact: 460×747 card, 460×690 image (2:3), gaps 20/55, x = 50/530/1010 |
| 3 | Category tiles | exact: 3 × 506×820, no tint, text bottom-left 30px in / 10px up |
| 4 | Trust badges | exact: 32×32 line icons, 18px serif heading, 16px subtext @75% |
| 5 | Best Sellers | rendering |
| 6 | Editorial banner | copy vertically centred against the photo |
| 7 | Newsletter | burgundy `#6E1423` |

**Product card** (used everywhere): 2:3 portrait, second gallery image crossfades in on
hover, black `CHOOSE OPTIONS` / `ADD TO CART` button 430×40 inset 15px sitting 26px
below the image, square burgundy sale badge, grid 4→3→2 columns.

### Collections page — `/collections/`

Matched to the reference's `/collections/`: centred 36px serif H1, 3-col grid, 20px
gaps, **square 1:1 cards**, image fills the card, title overlaid bottom-left
(30px in, 21px up, 16px sans).

Uses WooCommerce's `[product_categories]`, so a category added later appears on its own.

One deliberate departure: the reference uses dark text straight on pale promo artwork.
Ours are real photographs of every tone, so the title is white over a soft bottom scrim.

### Catalogue

44 products · 457 variations · 11 categories · generated from the reference's public
product feed and validated clean (0 errors, 0 duplicate SKUs).

Abayas & Jilbabs 7 · Dresses 6 · Hijabs 6 · Cardigans & Outerwear 5 ·
Skirts & Bottoms 5 · Kids 4 · Tops 4 · Matching Sets 2 · Hijab Caps 2 ·
Jewellery 2 · Accessories 1

Prices converted from the reference's USD **minor units** at the riyal's 3.64 peg —
their `1700.00` is USD 17.00, not 1,700.

### Other fixed this session

- Shop and category archives run **full width** (were `et_right_sidebar`)
- `/product-category/` was a **404** (it is only WooCommerce's permalink prefix) —
  now 301-redirects to `/collections/`
- **Nav menu** built from live categories: Home, Collections, 11 categories. No Shop
  link, by client decision. Replaces the "Sample Page / Uncategorized" page fallback
- **Mobile header** fixed — see below

---

## 3. Known gaps

| Item | Why it is not done |
|---|---|
| **Templates T2–T5** | All Products, Single Product, Category Archive, General — **not started**. This is the bulk of the client's five-template order. |
| Header 155px vs 128px | Blocked on a design asset, not code. Their logo is a flat wordmark at 8.2:1; ours is a stacked lockup at 1161×516 = 2.25:1. Forcing our logo to their ~44px height shrinks it to 99px wide and the wordmark stops being readable. Needs a **horizontal logo variant** (emblem left, wordmark right). |
| Mobile header visual check | The CSS fix is live and all 12 rules verified to match real elements, but the browser would not resize on the final attempt, so it was never seen rendered. **Check on a real phone.** |
| Quick-view control on cards | Coded, renders nothing — it needs TI Wishlist or YITH Quick View **activated**. Both installed, both inactive. |
| 2 categories without images | No product in them has a featured image yet. |

---

## 4. Risks — act on these

**Disk space is the live constraint.** A theme upload failed twice with
`Failed to write file to disk.`, and the Theme File Editor also silently failed to
save. Two independent write paths failing means the server could not write at all.
It will recur on the next upload. Free space by removing:

- `Molti - Ecommerce` and `Divi Ecommerce Pro` — both installed, both unused
- 17 inactive plugins

**WP Reset is still installed.** It wiped this database once already — products,
menus and Theme Builder templates all lost. Remove it.

**The `DIVI/` folder holds nulled premium plugins.** `divi-ecommerce-pro/functions.php`
forces its licence to "valid" in code, and ran three `update_option()` DB writes on
every page load. Advised against them; the client agreed to stay on our own theme.
Do not install them.

**Product import is not one-click.** It stalls on long image runs and must be re-run
until the count matches. Safe and resumable — "skip if exists" prevents duplicates.

---

## 5. Bugs found and fixed — worth not repeating

1. **WooCommerce's clearfix `::before`/`::after` on `ul.products` become GRID ITEMS**
   in a CSS grid. `::before` silently ate the first cell and shunted every card one
   place along, leaving an empty top-left slot.
2. **Divi wraps the loop image in `span.et_shop_image`**, which computes to **zero
   height** and absolutely positions the `<img>` inside it. That broke the 2:3 frame
   until the wrapper was stretched to fill it.
3. **A base rule out-specified its own hover rule.**
   `.woocommerce ul.products li.product > .button` is (0,4,2);
   `li.product:hover > .button` is (0,3,1). `opacity: 0` always won, so the hover
   button never appeared even though the hover was firing correctly.
4. **The price-decimals superscript filter stripped the decimal separator**, so
   `795.00` became `795` + `00`. It rendered as a superscript on the front end but
   read as **79500** anywhere the CSS was absent — wp-admin, and it would have gone
   out in **order confirmation emails** as a 100× error. Now front-end only.
5. **Animating `background-size` from `cover` to `106% auto`** on a 507×820 tile makes
   the photo *shrink*, because 106% of the width is far less than `cover` needs for
   the height. Never animate background-size on a tall element.
6. **Divi's own responsive rules for the menu module are not reliably present** on this
   site. At 400px the desktop nav computed to `display:block`, the closed mobile menu
   to `display:block`, and the search panel rendered despite Divi's own `--disabled`
   class — a 655px header showing the nav twice as a plain bulleted list. The mobile
   state is now enforced in our stylesheet rather than inherited.
7. **SKUs truncated to 28 chars collided** — `…two-piece-set-blush` and `…-black` both
   cut to the same string, and WooCommerce silently skips a duplicate SKU.

### Two testing traps

- **CSS `:hover` cannot be triggered by `dispatchEvent`.** Scripted mouse events always
  report the un-hovered state. Use the browser tool's real `hover` action. This cost
  two long detours chasing a position that was already correct.
- **Do not trust a single `document.styleSheets` probe.** One reported "0 rules" for a
  stylesheet that actually had 67, which made a working stylesheet look dead.

---

## 6. Local files that matter

```
29 UP Arif/
  niswah-boutique/            the theme (generator in build/)
  svpi-importer/              products.json + generator + validator
    build/build-products.mjs      catalogue generator
    build/validate-products.mjs   RUN THIS before every import
    build/reference-feed.json     cached reference feed (gitignored)
  reference-home/             cached reference home page + parsed outline.json
  images/                     326 recovered media originals, ~309 MB (gitignored)
  03-DESIGN-SPEC.md           measured tokens
  05-CATALOGUE-AND-HOME-PLAN.md  measured section order + exact reference copy
  .unlazy/divi-build/PLAN.md  full append-only event log
```
