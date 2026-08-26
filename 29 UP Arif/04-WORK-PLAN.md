# Work Plan — Niswah Boutique Divi Templates

**Order confirmed:** 2026-08-26 · **Client timeline:** 3–4 days
**Site:** niswahboutique.com (WordPress + WooCommerce + Divi 4.27.6)
**Reference for layout & visual hierarchy:** niswafashion.com
**Measured design targets:** `03-DESIGN-SPEC.md`

---

## 1. Scope as ordered

Five Divi Theme Builder templates:

| # | Template | Divi assignment |
|---|---|---|
| T1 | Home Page | Front page (Divi Builder page, not a TB body) |
| T2 | All Products | TB body → WooCommerce Shop page |
| T3 | Single Product Page | TB body → Product Page |
| T4 | Category / Product Archive | TB body → All Product Category Pages |
| T5 | General Template (other pages) | TB body → static pages |

**Explicit client requirements carried into every template:**
- Global sections/modules wherever repeated — client wants to manage centrally
- Clean, well-organised Divi structure — client edits content themselves afterwards
- Follow reference site's layout and visual hierarchy closely
- Template/design work on the existing site — not a rebuild

---

## 2. Already done (head start, not billed as new work)

| Item | State |
|---|---|
| Demo cleanup — 41 demo pages, 3 demo projects | Done |
| Divi Global Colors (5 brand swatches) | Done |
| Divi Global Fonts (Marcellus + Jost, Cairo for Arabic) | Done |
| Design spec measured off reference site | Done |
| Custom child theme `niswah-boutique` (installed + active) | Done |
| One-click starter importer (`Appearance → Niswah Starter`) | Done, working |
| **Global Header** — ticker, centered logo, nav, cart, search | Rendering live |
| **Global Footer** — 4 columns + bottom bar | Built, **not rendering — see 3.1** |

Header and footer are not among the five ordered templates, but every template needs them.
They are built and are the "global sections" the brief asks for.

---

## 3. Must fix before template work (Day 0 — same day)

| # | Defect | Impact |
|---|---|---|
| 3.1 | **Footer not rendering.** Divi's stock "Designed by Elegant Themes" bar still shows. | Blocks all 5 templates looking finished |
| 3.2 | **Three duplicate "Default Website Template" cards** in Theme Builder — importer ran more than once. Divi expects one default. Likely the cause of 3.1. | Conflicting template resolution |
| 3.3 | **Layouts imported as "Custom", not "Global."** Importer sets `_et_default` / `_et_enabled` but not Divi's is-global meta. | Directly contradicts the client's "global sections preferred" requirement |
| 3.4 | Header nav still points at `#` placeholders | Needs real categories (see 4.2) |
| 3.5 | Header icons inline with menu, not far-right on logo row; no account icon | Reference-fidelity gap |

---

## 4. Blockers — need client input to hit 3–4 days

These gate three of the five templates. Flagging early because they are on the critical path.

| # | Blocker | Blocks | Needed |
|---|---|---|---|
| 4.1 | **All 16 products are in Trash — 0 published.** Real SKUs NB0001–NB0021, real QAR prices. Trashed 2026-07-28, before this project. | T2, T3, T4 | Restore them, or confirm a fresh import is coming |
| 4.2 | **No product categories exist** — only "Uncategorized". | T4 (entirely), T1 category tiles, header nav | Category list + which products belong where |
| 4.3 | **Hero + category tile imagery** | T1 | Campaign/lifestyle photos. 672 product images already on site, but no hero-grade shots seen |
| 4.4 | **Copy** — trust-badge stats, About text, footer link targets, policy pages | T1, T5 | Client text |
| 4.5 | Payment gateway not configured | Order-flow testing only, not template work | Optional for this scope |

> Without 4.1 and 4.2, T2/T3/T4 can be **built** but not **verified** — they would render empty.
> Fastest unblock: restore the 16 products and create 4–6 categories. ~1 hour of work.

---

## 5. Day plan

### Day 1 — Foundations locked
- Fix 3.1–3.3 (footer rendering, duplicate templates, global flags)
- Finish header to spec: icons far-right on logo row, account icon, nav typography
- Convert header/footer to true Global layouts
- Unblock 4.1 / 4.2 with client, or agree placeholder strategy
- **T5 — General Template** (simplest, unblocked): centered content column, serif title, optional TOC for legal pages

### Day 2 — Product surfaces
- **T2 — All Products**: title + description, Filter / Sort / count toolbar, 4-col grid (20px col gap, 55px row gap), pagination
- **T4 — Category Archive**: same components as T2, dynamic title + description, auto-scoped products
- Build T2 and T4 from one shared set of global modules so a change to the grid updates both

### Day 3 — Single product + home
- **T3 — Single Product**: 50/50 sticky image layout, title/price/rating/qty/add-to-cart, variation swatches, size-chart + care accordions, key features, related products, sticky mobile add-to-cart bar
- **T1 — Home Page**: hero, editorial trio, category tiles, trust badges, new-arrivals grid, promo banner

### Day 4 — QA, polish, handover
- Desktop + mobile pass on all 5 templates
- Side-by-side fidelity check against reference
- Console-error check
- Confirm client can edit content — walk the Divi structure
- Handover package (section 7)

---

## 6. Definition of done — per template

A template is finished only when all of these hold:

1. Renders correctly at desktop **and** ≤480px
2. Pulls **live** WooCommerce data — no hardcoded content
3. Repeated elements are **Global** modules, not copies
4. Section/row/module names are readable in Divi's layers panel — client can find things
5. No leftover Lorem ipsum or demo content
6. Reviewed side-by-side against the corresponding reference-site page
7. No console errors

---

## 7. Handover package

Divi stores layouts in the database, not theme files, so a complete handover is four artefacts:

| Artefact | Contains |
|---|---|
| `niswah-boutique.zip` | Child theme — CSS, functions, bundled templates, one-click importer |
| `data/theme-builder.json` | All Theme Builder templates (ships inside the theme) |
| `layouts.json` | Divi Library layouts |
| `niswah-full.wpress` | Full site restore (All-in-One WP Migration, already installed) |

Plus a short written guide on editing each template.

---

## 8. Risk register

| Risk | Likelihood | Mitigation |
|---|---|---|
| Products/categories not restored in time | High | Build against 2–3 temporary test products so templates are verifiable; swap to real data later |
| No hero-grade photography supplied | Medium | Build hero with a product image placeholder, flag for swap |
| Reference fidelity disputes | Medium | `03-DESIGN-SPEC.md` records measured values — fidelity judged against numbers, not opinion |
| 3–4 days is tight for 5 templates + fixes | Medium | T5 and globals are near-done; T2/T4 share components; sequence puts blocked work last |

---

## 9. Immediate next actions

1. Delete the two duplicate Theme Builder templates, keep one.
2. Re-verify footer renders on the front end.
3. Fix the importer's global-layout flag and re-import cleanly.
4. Ask client to restore products + define categories (4.1, 4.2).
