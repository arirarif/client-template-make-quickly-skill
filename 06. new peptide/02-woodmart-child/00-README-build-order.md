# 02-woodmart-child — Build & Tracking Guide

Atomic Blue WooCommerce shop override. Sits on top of WoodMart parent theme via WooCommerce template overrides. No parent theme files are modified.

---

## Project folder map (parent dir: `06. new peptide/`)

| # | Folder | Role | Edit? |
|---|---|---|---|
| 01 | `01-woodmart/` | Parent theme — reference only | Never |
| 02 | `02-woodmart-child/` | **This theme** — Atomic Blue shop override | Yes |
| 03 | `03-pp-atomic-blue-elementor/` | Homepage Elementor widgets plugin | Yes |
| 04 | `04-pp-webpage-icon-pack/` | Icon SVG assets | Add icons here |
| 05 | `05-product-images/` | Product photo source files | Upload to Media Library |
| 06 | `06-frostyjon-attachments/` | Client-supplied attachments | Reference only |

> Number prefixes are **dev-side only**. When you zip this theme to upload to WordPress, rename the folder back to `woodmart-child/` first so the WP theme slug stays clean. Same goes for `03-pp-atomic-blue-elementor` → `pp-atomic-blue-elementor` before zipping.

---

## File map inside this theme

```
02-woodmart-child/
├── 00-README-build-order.md          ← you are here
├── style.css                         ← REQUIRED filename — theme header + Atomic Blue color tokens
├── functions.php                     ← REQUIRED filename — enqueues + body class
├── woocommerce/                      ← REQUIRED path — WooCommerce auto-detects overrides here
│   ├── archive-product.php           ← shop page layout (hero, filters, grid, newsletter, FAQ)
│   └── content-product.php           ← single product card (.product)
└── assets/
    └── css/
        └── atomic-blue-shop.css      ← all shop styling, scoped under body.atomic-blue-shop
```

The `style.css`, `functions.php`, and `woocommerce/*.php` filenames are **fixed by WordPress and WooCommerce** — renaming them breaks the override. Everything inside `assets/` is freely renameable (referenced from `functions.php`).

---

## Common edits — where to look

| What you want to change | Open this file |
|---|---|
| Hero pill / H1 / lead / button labels | `woocommerce/archive-product.php` (top of `<section class="hero">`) |
| Hero card stats (99% / 3rd / 24h) | `woocommerce/archive-product.php` (`.stats` block) |
| Newsletter copy | `woocommerce/archive-product.php` (`.newsletter` block) |
| FAQ items | `woocommerce/archive-product.php` (`.faq-grid` block) |
| Product card markup (formula / category atom / Add button) | `woocommerce/content-product.php` |
| Colors (gold / glow / vault / paper) | `style.css` (`:root` block) |
| Typography, spacing, hover, responsive | `assets/css/atomic-blue-shop.css` |
| When the chip filters / search loads | `functions.php` (`is_shop()` / `is_product_taxonomy()` checks) |

The H1 and lead also have filters wired (`pp_atomic_shop_h1`, `pp_atomic_shop_lead`) — you can override them from a tiny mu-plugin without touching the template.

---

## Install steps

1. Rename this folder back to `woodmart-child` (drop the `02-` prefix).
2. Zip the folder.
3. WP Admin → Appearance → Themes → Add New → Upload Theme → activate.
4. Make sure WoodMart parent theme is installed (not active — child is active, parent supplies the framework).
5. Visit `/shop/` — Atomic Blue layout should render with your live products.
6. WoodMart Header & Footer Builder still owns the topbar/nav/footer, so design those there to match the mockup.

---

## What is live vs static

**Live (pulls from WooCommerce automatically):**
- Product grid, prices, images, SKU, "Add to Cart" → real WooCommerce data
- Search box → `?s=` product search
- Category chips → real `product_cat` terms, active state follows current archive
- Sale / Featured / Sold Out badge on each card → automatic
- Pagination → standard WooCommerce pagination

**Static (edit in `archive-product.php`):**
- Hero copy + buttons
- Hero card stats
- Newsletter copy
- FAQ items

If you later want any of the static blocks to be editable from the WP admin without touching PHP, the cleanest option is ACF fields on a "Shop Settings" options page, or WordPress Customizer fields — happy to wire either.
