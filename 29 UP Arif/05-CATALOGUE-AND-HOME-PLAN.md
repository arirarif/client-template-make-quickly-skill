# Catalogue Structure + Home Page Plan

Written 2026-08-26, after the site database reset. Product data below is taken from the real Niswah catalogue that was on the site before the reset — real SKUs (NB00xx) and real QAR prices.

Companion docs: `03-DESIGN-SPEC.md` (measured layout targets), `04-WORK-PLAN.md` (schedule).

---

# PART A — Product categories

## A1. Category structure

Five categories. These map exactly to the header nav already built, so the menu wires up with no rework.

| # | Category | Slug | Covers |
|---|---|---|---|
| 1 | Hijabs | `hijabs` | Wrap/shawl style — chiffon, modal, jersey, pashmina |
| 2 | Instant Hijabs | `instant-hijabs` | Pre-sewn, slip-on styles |
| 3 | Abayas & Jilbabs | `abayas-jilbabs` | Full-length outerwear |
| 4 | Accessories | `accessories` | Pins, caps, sleeves, underscarves |
| 5 | Prayer Essentials | `prayer-essentials` | Prayer mats and related |

### The two nav items that are NOT categories

**NEW IN** and **SALE** should stay dynamic, not become categories:

- **NEW IN** → Shop page sorted by date, or a Divi module querying most recent products. Stays current with zero maintenance.
- **SALE** → WooCommerce's on-sale query. Any product with a sale price appears automatically.

If they were real categories you'd have to move products in and out by hand forever. Worth avoiding.

---

## A2. The 10 products to upload

Chosen so every category has at least one product and the templates can all be tested properly.

| # | Product | SKU | QAR | Category | Type |
|---|---|---|---|---|---|
| 1 | Plain Chiffon Hijab | NB0019 | 20 | Hijabs | **Variable** — colour |
| 2 | Modal Hijab | NB0007 | 35 | Hijabs | Variable — colour |
| 3 | Bamboo Jersey Hijab | NB0002 | 60 | Hijabs | Simple |
| 4 | Korean Chiffon Embroidered Hijab | NB0009 | 65 | Hijabs | Simple |
| 5 | Instant Moscrepe Hijab | NB0004 | 45 | Instant Hijabs | Simple |
| 6 | Magnetic Ninja Chiffon Hijab | NB0018 | 80 | Instant Hijabs | Simple |
| 7 | One Piece Jilbab | NB0011 | 150 | Abayas & Jilbabs | Variable — size |
| 8 | Hijab Cap | NB0013 | 15 | Accessories | Simple |
| 9 | Magnetic Hijab Pins | NB0016 | 20 | Accessories | Simple |
| 10 | Prayer Matt – White | NB0021 | 35 | Prayer Essentials | Simple |

### Why the mix matters

**At least one variable product is essential.** The Single Product template has to show colour/size swatches — Variation Swatches for WooCommerce is installed for exactly this. With only simple products the swatch area can't be built or verified.

Plain Chiffon Hijab (NB0019) is the natural choice: the pre-reset media held 30+ colourways for it (Olive Green, Bottle Green, Pista Green, Maroon, Brown, Oak, Caramel, Sand, Slate Grey, Sky Blue, Peach, Navy, Black, Dark Grey, Light Grey, White, Peachy Nude, Rust, Rosewood, Soft Pink and more).

**Suggested minimum for launch:** 6–8 colours on NB0019 rather than all 30. Enough to prove the swatch row without a long upload session. The rest can be added later without touching the template.

---

## A3. What each product needs

| Field | Why |
|---|---|
| Name + SKU | SKU shows on the product page |
| Regular price (QAR) | Required |
| Sale price — on 1–2 products | So the SALE nav item and sale badges have something to show |
| Category | One of the five above |
| Featured image | Product card + product page |
| Gallery images (2–4) | Product page slider |
| Short description | Appears under the price |
| Long description | Main product tab |
| Attributes — Colour / Size | Required for the variable products, drives swatches |
| Stock status | Grid can show "Out of stock" |

**Product photo aspect ratio: keep every image the same.** The reference site uses a consistent portrait crop. Mixed ratios make the 4-column grid look ragged. Portrait 3:4 or 4:5 is the safe choice.

---

## A4. Check before uploading — the images may still be there

The Media Library shows 0 items, but the logo still renders on the front end. That strongly suggests the **files still exist in `wp-content/uploads/`** and only the database records were lost.

If so, a media re-import plugin can rebuild the library from the files on disk — recovering all 672 photos without re-uploading a single one. Worth 10 minutes to check before doing it manually.

---

## A5. Also needs restoring after the reset

The reset removed more than products:

| Item | Status |
|---|---|
| WooCommerce | Deactivated — nothing works without it |
| Variation Swatches | Gone — needed for the colour swatches |
| FiboSearch | Gone — powers the header search icon |
| CartPops | Gone — powers the cart drawer |
| Themify Product Filter | Gone — powers the shop Filter button |
| MC Wishlist, YITH Quick View | Gone — optional |
| "Niswah Main Menu" | Gone — nav currently falls back to "Sample Page / Uncategorized" |

WooCommerce and Variation Swatches are the two that block template work.

---

# PART B — Home page plan

Section order follows the reference site's hierarchy. Built with Divi modules, dynamic where possible so the client can manage content without editing layout.

## B1. Section order — measured from the reference

Read off niswafashion.com's live DOM on 2026-08-26 (section heights and contents measured, not eyeballed). This is the hierarchy the client asked us to follow.

Read on 2026-08-26 from the reference page's own Shopify section wrappers
(`<section id="shopify-section-template--…__<type>">`), which carry both the
section type and the merchant's arrangement order. Saved at
`reference-home/home.html`, parsed to `reference-home/outline.json`.

| # | Shopify section | What it is | Data source |
|---|---|---|---|
| — | `announcement-bar` | Ticker, 40px | Global Header (built) |
| — | `header` | Header, 128px | Global Header (built) |
| 1 | `slideshow` | Hero, 2 full-bleed images | Static image + text |
| 2 | `featured_collection` | "Shop New Arrivals" grid + SHOP NOW | **Dynamic** — Woo, by date |
| 3 | `gallery` | 3 category tiles | Category images + links |
| 4 | `1642571684…` | Trust badges, 3 items | Static icons + copy |
| 5 | `c97ebf4d-…` | "BEST SELLERS" grid + View all | **Dynamic** — Woo, by popularity |
| 6 | `image_banner` | Editorial banner, 1 image | Static |
| 7 | `1699019302…` | Trailing section, renders empty | — |
| — | `footer` | Footer, ~531px | Global Footer (built) |

> **Second correction — and the first correction was also wrong.**
>
> Draft 1 (from memory): hero → category tiles → new arrivals → trust badges → editorial.
> Draft 2 (claimed "measured"): put the **editorial banner second**. That was still wrong;
> it came from eyeballing rendered boxes rather than reading the section wrappers.
>
> The table above is read from the page's own section ids, which is authoritative.
> The editorial `image_banner` is **sixth, near the end** — not second. There is **no
> newsletter section**: section 7 renders empty. Build to this table, not to either draft.

> **Note on their live page:** the `image_banner` section is currently **broken on the
> reference site** — it outputs `Liquid error (sections/image-banner line 77): invalid
> url input` instead of an image. So there is no editorial design to copy. Ours is a
> reasonable reconstruction, not a match.

## Exact copy lifted from the reference

**Category tiles** (section 3) — these map onto categories our catalogue actually has:

| Tile | Subtitle | Their link |
|---|---|---|
| Abayas | Elegance Redefined | `/collections/abaya` |
| Dresses | For Every Body, Every Occasion | `/collections/dresses` |
| Hijabs | Infinite Colors, Endless Styles | `/collections/hijabs-scarves` |

**Trust badges** (section 4):

| Headline | Subtext |
|---|---|
| 40,000+ Happy Customers | Your Trusted Fashion Source |
| Women Operated | For women, by women |
| Giving Back | Supporting Emergency Relief projects with every purchase |

The badge figures and claims are **theirs, not the client's** — placeholders to be
replaced with Niswah's own numbers before launch.

---

## B2. Section detail

### 1 — Hero
- Full-bleed lifestyle photo, no side gutters
- Small uppercase eyebrow line, letterspaced
- Large Marcellus headline
- One button, burgundy, uppercase, square corners
- **Mobile:** headline drops to ~28px, image keeps a minimum height so text stays legible
- **Needs from client:** one campaign photo (landscape, min 2000px wide) + headline + button text

### 2 — Editorial banner
- Two images with text, ~598px tall on the reference
- Serif heading, short paragraph, text link or button
- No prices here — this is brand storytelling, not product
- **Needs from client:** one or two lifestyle images + short brand paragraph

### 3 — New arrivals grid
- Divi **Woo Products** module — 4 across, 8 products, ordered by date
- Card: image, uppercase name, price. No borders, no shadows
- Column gap 20px, row gap 55px (measured)
- Centred "VIEW ALL" button below
- **Mobile:** 2 across
- Fully automatic — new products appear here on their own

### 4 — Shop by category
- Three full-bleed tiles side by side, image with dark overlay
- Small eyebrow + large serif category name on each
- Links to Hijabs, Instant Hijabs, Abayas & Jilbabs
- **Mobile:** stacks to one column
- **Needs from client:** three category images

### 5 — Trust badges
- Three columns: icon, short stat headline, one line of subtext
- Short band (~214px measured) — keep it tight, not a tall section
- Ivory `#FAF3EA` background to separate it from the white sections
- **Mobile:** stacks
- **Needs from client:** three claims (e.g. customer count, delivery promise, quality/returns)

### 6 — Best sellers
- Same Woo Products module as section 3, ordered by popularity
- 4 cards across on the reference
- Deliberately reuses section 3's styling so both stay consistent

### 7 — Newsletter strip
- Full-width band, espresso `#241512` background, white text
- Heading + one line + email field + button
- **Mobile:** field and button stack full width

---

## B3. Reusability — the client's "global sections" requirement

The client asked to manage things centrally. Applied here as:

| Element | Approach |
|---|---|
| Product grid styling | Build once, duplicate for Best Sellers — one visual language |
| Trust badges | **Divi Global Module** — edit once, updates everywhere it's used |
| Newsletter strip | **Divi Global Module** — will be reused on other pages |
| Buttons | Divi Button preset so every CTA matches |
| Colours / fonts | Already Global Colors + Global Fonts |

Every section and row gets a clear name in Divi's layers panel, so the client can find "Hero", "New Arrivals" etc. rather than "Section 3".

---

## B4. Blocked until products exist

Sections 3 and 6 are dynamic product grids. They can be **built** now but will render empty until products are uploaded. Sections 1, 2, 4, 5, 7 can be completed immediately.

---

## B5. What I need from you to finish the home page

1. Hero image + headline + button text
2. Three category images
3. Three trust-badge claims
4. One editorial image + short brand paragraph
5. The 10 products uploaded with categories

Placeholders go in for anything not supplied, clearly marked so nothing ships looking unfinished.
