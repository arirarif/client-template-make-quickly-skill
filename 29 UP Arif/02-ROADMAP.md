# Niswah Boutique — Build Roadmap

Site: niswahboutique.com · Stack: WordPress + WooCommerce + Divi (100% Divi, no custom HTML templates)
Design reference: niswafashion.com (layout/structure patterns only — all content, photos and copy are Niswah's own)
Companion doc: `01-SITE-BUILD-PLAN.md` (what each page contains, section by section)

Build order requested by owner: **Header → Footer → Home Page** first, then everything else.

---

## Status key

- `DONE` — built, saved, verified live
- `PARTIAL` — built but has known open items
- `TODO` — not started
- `BLOCKED` — cannot complete until a dependency clears

---

## Phase 0 — Foundations

| # | Task | Status | Notes |
|---|---|---|---|
| 0.1 | Clean out demo content | DONE | 41 demo pages + 3 demo Projects trashed. Products & Media untouched. |
| 0.2 | Divi Global Colors (5 swatches) | DONE | Burgundy `#6E1423`, Gold `#C6A15B`, Ivory `#FAF3EA`, Espresso `#241512`, Terracotta `#B24D2E` |
| 0.3 | Divi Global Fonts | DONE | Marcellus (headings) + Jost (body). Heading/body colour Espresso, links Burgundy. |
| 0.4 | Upload official logo to Media Library | DONE | Was missing entirely — only Molti demo logos existed. |
| 0.5 | Arabic-compatible font for bilingual wordmark | TODO | Cairo or Noto Naskh Arabic. Divi Customizer only exposes one heading + one body font, so this needs a per-module font or a Divi Theme Options CSS rule. |
| 0.6 | **Replace Molti child theme with own "Niswah Boutique" child theme** | TODO | Decision made. Must audit Molti for WooCommerce hooks/template overrides before swapping. Theme Builder templates live in the DB and survive the swap. |

---

## Phase 1 — Global Header *(priority 1)*

| # | Task | Status | Notes |
|---|---|---|---|
| 1.1 | Announcement/ticker bar | DONE | Burgundy background, white text, delivery + phone + email. |
| 1.2 | Centered logo | DONE | Max width 260px. |
| 1.3 | Primary nav | PARTIAL | 6 placeholder items (`#` links): NEW IN, HIJABS, INSTANT HIJABS, ABAYAS & JILBABS, ACCESSORIES, SALE. Menu "Niswah Main Menu" assigned to Primary location. |
| 1.4 | Reference heights (~180px total) | DONE | Ticker ~45px, logo row ~85px, menu row ~60px. |
| 1.5 | Move search/account/cart icons to far right of **logo row** | TODO | Currently inline with the menu — that is Divi's native behaviour for the "Centered" Menu style. Matching the reference needs the logo row split into columns with the icon group right-aligned. |
| 1.6 | Add **My Account** icon | TODO | Divi's Menu module offers cart + search only; account icon must be added separately. |
| 1.7 | Ticker rotating multiple messages | TODO | Reference cycles several promos. Currently one static line. |
| 1.8 | Mobile: hamburger + slide-in drawer | TODO | Not yet tested at mobile width. |
| 1.9 | Wire cart icon → CartPops drawer | TODO | Click-test on live front end. |
| 1.10 | Wire search icon → FiboSearch | BLOCKED | Cannot be meaningfully tested while 0 products are published. |
| 1.11 | Point nav at real product categories | BLOCKED | No categories exist yet (see 10.1). |

---

## Phase 2 — Global Footer *(priority 2)*

| # | Task | Status | Notes |
|---|---|---|---|
| 2.1 | Promo / rewards strip above footer | TODO | Reference uses a loyalty banner; adapt to a Niswah CTA (WhatsApp / contact / newsletter). |
| 2.2 | Footer column 1 — Support | TODO | Shipping & Delivery, Returns & Refunds, FAQs, Size Chart, Contact Us. |
| 2.3 | Footer column 2 — Shop | TODO | About Us, categories, Gift Card (if offered), Blog. |
| 2.4 | Footer column 3 — Contact | TODO | Email + short helper line. |
| 2.5 | Footer column 4 — Newsletter + social | TODO | Real accounts already known: Facebook, Instagram, TikTok, YouTube (`boutiqueniswah`). |
| 2.6 | Bottom bar — copyright + QAR note | TODO | Single-market store, no currency switcher needed. |
| 2.7 | Mobile stacking check | TODO | Columns must stack cleanly, no overflow. |

---

## Phase 3 — Home Page *(priority 3)*

Front page, built with Divi Builder. Section order mirrors the reference.

| # | Task | Status | Notes |
|---|---|---|---|
| 3.1 | Hero — full-bleed image + eyebrow + serif headline + CTA | TODO | Needs a real Niswah lifestyle/campaign image. |
| 3.2 | Editorial trio — 3 product images + name/price + CTA | BLOCKED | Needs published products. |
| 3.3 | Category tiles — 3 full-bleed tiles with overlay text | BLOCKED | Needs categories + category imagery. |
| 3.4 | Trust badges strip — 3 × icon + stat + subtext | TODO | Needs real copy from client (customer count, business story, guarantee). |
| 3.5 | New arrivals grid — 4-column, dynamic | BLOCKED | Needs published products. |
| 3.6 | Promo / newsletter banner | TODO | |
| 3.7 | Set as WP front page | TODO | Currently the old demo "Shop Homepage" is the front page. |
| 3.8 | Mobile pass | TODO | |

---

## Phase 4 — Shop / All Products archive

| # | Task | Status |
|---|---|---|
| 4.1 | Theme Builder template assigned to Shop page | TODO |
| 4.2 | Title + intro description | TODO |
| 4.3 | Toolbar: Filter button (Themify), Sort dropdown, product count | TODO |
| 4.4 | 4-column product grid, borderless cards, uppercase names | TODO |
| 4.5 | Pagination | TODO |
| 4.6 | Grid-density toggle (2/3/4 col) | TODO — low priority, ship without if needed |

---

## Phase 5 — Category archive

| # | Task | Status |
|---|---|---|
| 5.1 | One reusable Theme Builder template for all product categories | TODO |
| 5.2 | Dynamic category title | TODO |
| 5.3 | Dynamic category description | TODO |
| 5.4 | Grid + toolbar reuse Phase 4 components | TODO |

---

## Phase 6 — Single Product

| # | Task | Status |
|---|---|---|
| 6.1 | 50/50 layout, sticky image column | TODO |
| 6.2 | Title, price, rating, quantity, Add to Cart | TODO |
| 6.3 | Variation swatches (plugin already installed) | TODO |
| 6.4 | Size Chart accordion | TODO |
| 6.5 | Key Features list | TODO |
| 6.6 | Fabric Description & Care block | TODO |
| 6.7 | Care Guide accordion | TODO |
| 6.8 | Related products, 4-column | TODO |
| 6.9 | Sticky bottom mini add-to-cart bar | TODO |

---

## Phase 7 — Cart & Checkout

| # | Task | Status |
|---|---|---|
| 7.1 | Style CartPops slide-out drawer to brand palette | TODO |
| 7.2 | Empty-cart state with CTA | TODO |
| 7.3 | Restyle fallback Cart page | TODO |
| 7.4 | Checkout: single-column, distraction-free, no nav/footer | TODO |
| 7.5 | Sticky order-summary sidebar | TODO |
| 7.6 | Test order end-to-end | BLOCKED — needs a payment gateway configured |

---

## Phase 8 — General page template

| # | Task | Status |
|---|---|---|
| 8.1 | One reusable template for Terms / Privacy / Refunds / About / FAQs | TODO |
| 8.2 | Optional table-of-contents for long legal pages | TODO |
| 8.3 | Apply to the 3 surviving policy pages | TODO |

---

## Phase 9 — QA & launch

| # | Task | Status |
|---|---|---|
| 9.1 | Desktop walkthrough: home → category → shop → product → cart → checkout | TODO |
| 9.2 | Same at mobile width (≤480px) | TODO |
| 9.3 | Console-error check on all 6 page types | TODO |
| 9.4 | Side-by-side fidelity review vs reference, per template | TODO |
| 9.5 | Turn off "Coming Soon" — **only on explicit client approval** | TODO |

---

## Phase 10 — Blockers to clear (owner/client side)

These gate several phases above. Nothing below is a build task — they need a decision or content.

| # | Blocker | Blocks |
|---|---|---|
| 10.1 | **16 products sit in Trash, 0 published.** Real SKUs NB0001–NB0021, real QAR prices. Trashed 2026-07-28, before this project. Owner instruction: leave as-is for now. | 1.10, 1.11, 3.2, 3.5, Phases 4–7 |
| 10.2 | **No product categories** — only "Uncategorized". | 1.11, 3.3, Phase 5 |
| 10.3 | **Client has not placed the order.** Scope currently limited to header + footer + globals. | Everything past Phase 3 |
| 10.4 | Real copy needed: trust-badge stats, About text, footer links. | 2.2–2.4, 3.4 |
| 10.5 | Campaign/lifestyle photography for hero + category tiles. | 3.1, 3.3 |
| 10.6 | Payment gateway not configured. | 7.6 |

---

## Phase 11 — Handover package

Produced at project end. Divi keeps layouts in the database, not in theme files, so a complete package is four artefacts:

| # | Artefact | Contains |
|---|---|---|
| 11.1 | `niswah-child.zip` | Child theme — custom CSS, functions.php |
| 11.2 | `theme-builder.json` | Global header, footer, and all dynamic templates |
| 11.3 | `layouts.json` | Divi Library page layouts |
| 11.4 | `niswah-full.wpress` | Complete site restore (All-in-One WP Migration — already installed) |

Gives the client a rollback point and a redeploy path.

---

## Immediate next actions

1. Verify the last header save persisted (the save was interrupted).
2. Finish Phase 1 open items — 1.5, 1.6, 1.7, 1.8.
3. Build Phase 2 (footer) end to end.
4. Build Phase 3 (home) — non-blocked sections only; leave product/category sections as placeholders until 10.1 and 10.2 clear.
