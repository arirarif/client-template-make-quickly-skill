# noor-child — Noor Festivities (Hello Elementor child) v3.0.0

> FINAL BUILD. Parent theme = **Hello Elementor** (WoodMart dropped).
> Pattern = NexDisc project: header/footer + product/shop/cart/checkout/account
> pages in child theme; homepage sections = custom Elementor widgets
> (import `../homepage-elementor-template.json`).

Brand source of truth: `BRANDING.md` / `DESIGN-TOKENS.md` (Warm Mocha
`#96421A` · Spiced Coral `#C68053` · Creamy Beige `#EED2AE` · Ivory White
`#EDE5DE` · Ragara headings (Playfair Display stand-in) · Open Sans body).

## Install (staging)
1. Install + activate **Hello Elementor** (parent), **Elementor**, **WooCommerce**.
2. Zip this folder → `noor-child.zip` (folder itself = zip root) → Appearance → Themes → Upload → activate **Noor Festivities Child**.
3. Menus: create « Principal » → assign to **Noor — Navigation principale**; optional « Pied de page » → **Noor — Liens pied de page**.
4. Elementor → Templates → Import → `homepage-elementor-template.json` → set as front page (Settings → Reading).
5. Settings → Permalinks → **Save** (registers /re/ /yt/ /fr/ rewrites).
6. Edit `TODO` constants at top of `functions.php` (WhatsApp number, charity URL…).
7. Create coupon `BIENVENUE10` (WooCommerce → Coupons).
8. Site Identity → favicon = `assets/img/brandmark-mocha.png`.

## Files
| File | Job |
|------|-----|
| `style.css` | Theme identity only (all CSS in assets/css/) |
| `functions.php` | Constants, enqueues, woo supports, menus, modules |
| `header.php` | Announce bar, logo mocha, nav, region switcher, icons, mobile drawer |
| `footer.php` | Espresso footer: ivory logo, columns, newsletter, bottom bar |
| `assets/css/noor.css` | Tokens + base + header/footer + module styles |
| `assets/css/noor-widgets.css` | Elementor widget styles (homepage sections) |
| `assets/css/woocommerce.css` | Shop grid + FULL single product + cart/checkout/account (loads only on Woo pages) |
| `assets/img/` | `logo-mocha.png` (header) · `logo-ivory.png` (footer) · `brandmark-mocha.png` (favicon) |
| `assets/noor.js` | Drawer, region switcher, lead popup, copy-link |
| `inc/region.php` … `inc/marketing.php` | Function modules (region, rental, upsells, charity, account, marketing) |
| `inc/elementor/` | 7 custom widgets — category « Noor Festivities » |

## Elementor widgets (homepage sections)
Bandeau défilant · Hero (badge, titre, 2 CTA, stats) · Grille Collections ·
Bannière Location · Section Vidéo (lazy YouTube/Vimeo) · Témoignages ·
Newsletter. Header/footer = PHP in this theme, NOT widgets.

## Page assembly
- **Accueil**: import the JSON — marquee → hero → collections → produits vedettes (shortcode `[products]`) → location → vidéo → témoignages → newsletter.
- **Boutique / produit / panier / commande / compte**: native WooCommerce, skinned by `woocommerce.css`. Chips row = HTML block class `noor-chips`. Trust row product = class `noor-trust`. Bundle box = class `noor-bundle`.
- **Location**: MWB Bookings product + `inc/rental.php` (caution, RE-only).

## Elementor Global settings (Site Settings)
| Setting | Value |
|---|---|
| Global Colors | Primary `#2E1A0D` (titres) · Secondary `#C68053` · Text `#2E1A0D` · Accent `#96421A` — déjà appliqués sur staging 2026-08-02 |
| Background | `#EDE5DE` |
| Global Fonts | Headings Playfair Display 700/800 · Body Open Sans 400/600 |
| Layout | Content width 1200px |

## Rules
- Never edit Hello Elementor parent files.
- Bump `NOOR_VERSION` (functions.php) + `Version:` (style.css) on ANY change.
- Spiced Coral = decorative only, never body text on light bg (contrast).
- Ragara webfont: upload via Elementor custom fonts ONLY after license confirmed.
- Keep dated zips as versions.
