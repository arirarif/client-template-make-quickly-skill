# Design Spec — measured from niswafashion.com

Measured live via computed styles on 2026-08-25, desktop viewport. These are **layout/typography metrics** used as a build target. Content, photography and copy are Niswah's own — nothing from the reference site is reused.

Reference uses Shopify (Dawn-based). Its stylesheet cannot be dropped into Divi — different DOM and class names. These numbers are the transferable part; we rebuild them with Divi module settings.

---

## 1. Measured values (reference site)

### Header

| Element | Value |
|---|---|
| Ticker bar height | **40px** |
| Ticker background | `rgb(26, 27, 24)` → `#1A1B18` |
| Ticker text | `#FFFFFF`, 13px, weight 300, letter-spacing 0.78px, line-height 16.25px |
| Logo + nav block height | **88px** |
| **Header total** | **128px** |
| Logo type | Trirong serif, 36px, weight 400, letter-spacing 0.54px, uppercase |
| Nav items | Outfit sans, 18px, weight 300, letter-spacing 0.6px, colour `rgb(26,27,24)` |

### Typography

| Role | Value |
|---|---|
| Body | Outfit sans, 16px, weight **300**, letter-spacing 0.6px, line-height 28.8px (**1.8**) |
| H2 | Trirong serif, 36px, weight 400, letter-spacing 0.54px, line-height 46.8px (**1.3**) |
| Product price | Outfit, 14px, weight 400, letter-spacing **1px** |

### Layout

| Property | Value |
|---|---|
| Container max-width | **1600px** |
| Container horizontal padding | **50px** |
| Product grid column gap | **20px** |
| Product grid row gap | **55px** |

### Footer

| Property | Value |
|---|---|
| Background | `rgb(26, 27, 24)` → `#1A1B18` |
| Links | `#FFFFFF`, 16px, weight 300, letter-spacing 0.6px |

---

## 2. Translation to Niswah Boutique

Same structure and metrics, Niswah's own brand identity.

| Token | Reference | **Niswah build value** | Why |
|---|---|---|---|
| Serif / headings | Trirong | **Marcellus** | Already set as Divi Global Font. Same editorial serif register. |
| Sans / body | Outfit | **Jost** *(or switch to Outfit)* | Jost already set. Outfit is on Google Fonts and available in Divi — switching would match the reference more exactly. **Open decision.** |
| Dark surface (ticker + footer) | `#1A1B18` | **`#241512` Espresso** | Our warm near-black, pulled from the logo. Same function, on-brand. |
| Accent | — | **`#6E1423` Burgundy** | From logo wordmark. |
| Secondary accent | — | **`#C6A15B` Gold** | From logo gradient. |
| Page background | white | **`#FAF3EA` Ivory** / white | Ivory for editorial bands. |

### Numbers to copy exactly

- Ticker height **40px**
- Header total **128px** (ticker 40 + logo/nav 88)
- Body weight **300**, line-height **1.8**, letter-spacing **0.6px**
- H2 36px / line-height **1.3** / letter-spacing 0.54px
- Nav 18px weight 300 letter-spacing 0.6px
- Price 14px weight 400 letter-spacing **1px**
- Container **1600px** max-width, **50px** side padding
- Grid gaps **20px column / 55px row**

> Note: earlier estimate of ~180px header was wrong. Measured value is **128px**. Build to 128px.

---

## 3. Divi mapping

| Spec | Where it goes in Divi |
|---|---|
| Body font/size/weight/line-height/letter-spacing | Customizer → General Settings → Typography |
| Container 1600px | Customizer → General Settings → Layout Settings → Website Content Width |
| Ticker 40px | Header Section → Spacing (padding), Text module font 13px |
| Header 128px | Header Section 2 → Spacing |
| Nav 18px / 300 / 0.6px | Menu module → Design → Menu Text |
| H2 36px / 1.3 | Customizer → Typography (Header sizes) + per-module overrides |
| Grid gaps | Woo Products module → Design → Spacing |
| Footer dark surface | Footer Section → Background → Espresso global colour |

---

## 4. What is NOT copied

- Product photography — Niswah has 672 of its own images already uploaded
- Marketing copy, headlines, promo text
- Logo, brand marks, brand name
- Their CSS/JS/theme files (Shopify-specific; would not function in Divi anyway)
