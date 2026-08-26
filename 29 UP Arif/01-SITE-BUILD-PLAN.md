# Niswah Boutique — Divi Build Plan
Reference site: niswafashion.com (Shopify) → Target: niswahboutique.com (WordPress / WooCommerce / Divi + Molti child theme)
Everything below is built 100% in Divi (Theme Builder for global/dynamic templates, Divi Builder for standalone pages). No custom HTML/PHP templates.

Status: PLANNING — not yet started. Awaiting client confirmation before build begins.

---

## 0. Design System Foundations

Set up once, globally, before any template — every section below inherits from this.

- **0.1 Divi Global Colors**
  - Primary — Deep Burgundy `#6E1423` (from "NISWAH" wordmark)
  - Accent — Antique Gold `#C6A15B` (from hair-gradient crown)
  - Secondary accent — Terracotta `#B24D2E` (mid-gradient, for hover/CTA states)
  - Background / Neutral — Warm Ivory `#FAF3EA` (matches reference site's editorial whitespace)
  - Text / Dark — Espresso `#241512` (warm near-black, not pure black)
- **0.2 Divi Global Fonts**
  - Headings: Marcellus or Cormorant Garamond (echoes the bold condensed serif of the "NISWAH" logo wordmark, matches reference site's serif logo/headline treatment)
  - Body: Jost or Poppins Light (matches reference site's airy minimal sans body copy)
  - Arabic-compatible face: Cairo or Noto Naskh Arabic (logo carries Arabic wordmark; Qatar market)
- **0.3 Spacing & grid rules**
  - Full-bleed edge-to-edge imagery on hero/category sections (reference site uses no side gutters on hero banners)
  - 4-column product grid on desktop archives, collapsing to 2-column on mobile
  - Generous vertical section padding (reference site's editorial breathing room) — target ~100–120px section padding desktop, ~48–64px mobile
- **0.4 Existing plugin stack to reuse (already installed, do not replace)**
  - CartPops → powers the slide-out cart drawer (matches reference site's cart-drawer pattern exactly)
  - FiboSearch → powers the header search icon/overlay
  - Variation Swatches for WooCommerce → color/size swatches on product cards + single product
  - Themify WooCommerce Product Filter → powers the "FILTER" panel on archive pages
  - YITH WooCommerce Quick View → optional, not present on reference site; keep available, don't force into design
  - MC Wishlist → optional extra beyond reference site (reference header has no wishlist icon); confirm with client whether to add a wishlist icon or leave header matching reference exactly
  - Sticky Menu (or Anything!) on Scroll → powers the sticky bottom mini add-to-cart bar on single product (reference site pattern)

---

## 1. Global Header (Divi Theme Builder — Global Header)

Reference pattern (niswafashion.com):
- 1.1 Top announcement bar — rotating/cycling promo messages, dark background, full width
- 1.2 Logo row — centered serif wordmark ("NISWA FASHION"), search / account / cart icons right-aligned
- 1.3 Primary nav row — horizontal, centered, all-caps letter-spaced links (NEW / MODAL HIJABS / APPAREL / HIJABS / KIDS / JEWELRY & ACCESSORIES / SALE)
- 1.4 Mobile: collapses to hamburger icon + centered logo + cart icon; nav becomes a slide-in drawer

Our build:
- Announcement bar → Divi Bar/Text module, burgundy `#6E1423` background, ivory text, cycling via Divi's built-in slider or a lightweight rotating-text module; content: phone/delivery info already on site (free delivery threshold, contact) instead of generic promo copy
- Logo row → centered Niswah Boutique logo (gold/burgundy hair mark + wordmark), search icon (wired to FiboSearch), account icon (My Account page), cart icon (wired to CartPops drawer)
- Primary nav → Divi Menu module, all-caps letter-spaced, gold hover-underline, top-level categories pulled from real WooCommerce product categories once catalog is organized
- Mobile hamburger → Divi's built-in mobile menu toggle inside the Header module, styled as a full-height slide-in drawer (matches reference site's mobile pattern), logo stays centered, cart icon stays visible

---

## 2. Global Footer (Divi Theme Builder — Global Footer)

Reference pattern:
- 2.1 Pink/neutral "Rewards" banner strip directly above footer — logo lockup + short pitch + "JOIN NOW" / "LOG IN" buttons
- 2.2 Black footer, 4 columns: Support links (Shipping, Returns, FAQs, Size Chart, Contact) / More links (About, Shop-by-price, Gift Card, Blog) / Contact Us (email + copy) / Newsletter signup + social icons
- 2.3 Bottom bar — copyright + region/currency selector

Our build:
- Rewards-style banner → swap for a Niswah-relevant strip (loyalty program if any, or WhatsApp/phone contact CTA) in ivory + gold accent, matching the layout not necessarily the exact copy
- Footer columns → burgundy-on-espresso or espresso-on-ivory (test both for contrast, likely espresso `#241512` background to mirror reference's black), same 4-column structure: Support / Shop / Contact Us / Newsletter+Social (Facebook, Instagram, TikTok, YouTube — already have real handles)
- Bottom bar → copyright + Qatar/QAR currency note (no multi-currency selector needed, single-market store)

---

## 3. Home Page (Divi Builder — standalone page, set as WP front page)

Reference section order — rebuild each 1:1:

- 3.1 Hero — full-bleed lifestyle photo, small eyebrow line + large serif headline + black "SHOP NOW" button bottom-left/center
- 3.2 Editorial "shop the look" — 3-column fading-hover product images, product name + price caption under each, centered "SHOP NOW" button below the row
- 3.3 Category trio — 3 full-bleed tiles (e.g. Abayas / Hijabs / Modal collection for Niswah) with overlay eyebrow text + large serif category name
- 3.4 Trust badges strip — 3 columns, icon + stat headline + subtext (adapt copy: happy customers count, women-operated / local Qatar business, giving-back or quality-guarantee angle)
- 3.5 New-arrivals product grid — 4-column, uppercase product name + price, black "VIEW ALL" button
- 3.6 Promo/newsletter banner — soft background, short pitch + CTA button(s)
- 3.7 Footer (global, from section 2)

Divi implementation notes: each section = one Divi Section/Row with Image, Text, Button, and WooCommerce "Shop" modules (dynamic product grid pulling live products) for 3.2/3.5 once real catalog is populated.

---

## 4. Shop / All Products Archive (Divi Theme Builder — Custom Body assigned to WooCommerce Shop page)

Reference pattern:
- 4.1 Page title (serif) + short descriptive paragraph
- 4.2 Toolbar row — "FILTER" pill button (opens filter panel), "SORT BY" dropdown, grid-density toggle (2/3/4 columns), live product count
- 4.3 4-column product grid — edge-to-edge product image, uppercase name + price below, no card borders/shadows, no badges unless on-sale
- 4.4 Pagination (or infinite scroll — reference doesn't show, default to standard pagination)

Our build: Divi WooCommerce "Shop" module inside the Theme Builder Shop template; Filter button wired to Themify Product Filter panel; Sort dropdown = WooCommerce default sort; grid-density toggle is a nice-to-have (lower priority, can ship without it in v1); product count from live query.

---

## 5. Category Archive (Divi Theme Builder — Custom Body assigned to Product Category taxonomy)

Same layout as section 4, but:
- 5.1 Page title = category name, dynamic
- 5.2 Description = category description field (editable per category in WP)
- 5.3 Product grid scoped to the current category automatically (Divi WooCommerce module's "include current category" dynamic setting)

One template, reused across every category — no per-category manual page building needed.

---

## 6. Single Product Page (Divi Theme Builder — Custom Body assigned to Product Page)

Reference pattern:
- 6.1 50/50 split layout — left column: large product image with prev/next arrows, sticky while right column scrolls; right column: uppercase serif product title, price, star rating, quantity stepper + black "ADD TO CART" button
- 6.2 "SIZE CHART" accordion (collapsed by default)
- 6.3 Description paragraphs
- 6.4 "Key Features" bullet list
- 6.5 "Fabric Description & Care" spec block (size/contour/care instructions)
- 6.6 "Niswa Care Guide" accordion
- 6.7 Marquee/ticker strip (stock/value messaging) between product info and related products
- 6.8 "You'll also love" related products — 4-column grid
- 6.9 Sticky bottom mini add-to-cart bar on scroll (thumbnail + name + price + Add to Cart), mobile-first conversion pattern

Our build: Divi's dynamic WooCommerce modules (Product Images, Product Title, Product Price, Product Add to Cart w/ Variation Swatches integration, Product Description, Product Additional Info) assembled in this exact order; accordions via Divi Accordion module bound to custom product meta (size chart, care guide) or ACF fields if needed; sticky bottom bar via Sticky Menu (or Anything!) plugin targeting a custom Divi row; related products via Divi's "Related Products" WooCommerce module, 4-column.

---

## 7. Cart (Divi-styled, powered by CartPops)

Reference pattern: right-side slide-out drawer (not a separate page) — header "CART" + close, empty state with message + "NEW ARRIVALS"-style CTA, populated state shows line items + subtotal + checkout button.

Our build: CartPops is already installed specifically for this — configure its drawer design (colors, fonts, button styles) to match our Global Color/Font tokens (burgundy button, ivory background, espresso text) instead of building a custom cart page as the primary cart UX. The existing WooCommerce Cart page stays as a fallback/direct-link page, restyled with Divi's WooCommerce Cart module in the same palette for non-JS/direct-URL visits.

---

## 8. Checkout (Divi Builder page + Divi WooCommerce Checkout module)

Not deeply shown on reference site (no screenshots captured — standard Shopify checkout is off-theme), so this is designed to our own clean standard rather than a literal clone:
- 8.1 Single-column, distraction-free layout (no header nav / footer to reduce drop-off), logo only
- 8.2 Order summary sidebar (sticky on desktop) using the same card styling as the rest of the site
- 8.3 Divi's WooCommerce Checkout module restyled with Global Colors/Fonts — burgundy primary button, ivory background, espresso text/labels

---

## 9. General Page Template (Divi Theme Builder — Custom Body for static pages)

For Terms & Conditions, Privacy Policy, Refund & Returns Policy, About, FAQs, etc.
- 9.1 Simple centered content column, serif page title, body text in Jost/Poppins
- 9.2 Optional sidebar table-of-contents for longer legal pages (Terms, Privacy, Refund Policy)
- One reusable template assigned via Divi Theme Builder rules, not rebuilt per page.

---

## 10. Build Sequence

1. **Design system** (section 0) — Global Colors + Fonts set up in Divi first; everything below depends on this.
2. **Global Header + Footer** (sections 1–2) — built and assigned in Theme Builder so every subsequent page previews correctly.
3. **Home Page** (section 3) — most visible, client-facing proof of direction.
4. **Shop + Category templates** (sections 4–5) — share one Divi WooCommerce module setup, build together.
5. **Single Product template** (section 6) — depends on real product data/variations being in place.
6. **Cart + Checkout** (sections 7–8) — configure CartPops + restyle Woo modules.
7. **General page template** (section 9) — quick, low-risk, can slot in anytime after section 0.
8. **QA pass** — every template checked on desktop + mobile against the reference site side-by-side; WooCommerce flows (add to cart → cart drawer → checkout → order confirmation) tested end-to-end with a real test product.

---

## 11. Open Questions for Client (confirm before/soon after build starts)

- 11.1 Keep header icon set exactly as reference (search/account/cart only), or add the wishlist icon since MC Wishlist is already installed?
- 11.2 Real copy for trust-badges strip (customer count, business story) and footer "More" links (About Us content, gift cards?) — currently placeholder concepts above.
- 11.3 Confirm final product category names/structure so the primary nav and category templates are built against real taxonomy, not guesses.
