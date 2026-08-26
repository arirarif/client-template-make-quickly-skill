# Niswah Boutique — Divi Child Theme

Custom Divi child theme for **niswahboutique.com**. Brand tokens, global typography, WooCommerce grid rules and the Theme Builder starter templates all ship inside the theme.

Parent theme: **Divi** (site is on 4.27.6). This theme replaces the third-party *Molti – Ecommerce* child theme.

---

## Contents

```
niswah-boutique/
├─ style.css                              Theme header + brand tokens + global CSS
├─ functions.php                          Enqueues, webfonts, Woo support, defaults
├─ README.md                              This file
├─ data/
│  └─ theme-builder.json                  Global Header + Global Footer (generated)
├─ includes/
│  └─ class-nb-starter-import.php         Appearance → Niswah Starter (one-click import)
└─ build/                                 Dev only — excluded from the installable zip
   ├─ theme-builder.build.mjs             Generates data/theme-builder.json
   └─ baseline-export.json                Reference export used to derive Divi's schema
```

`build/` is source tooling, not runtime code. WordPress never executes it, and the
install zip leaves it out. Design targets live in `03-DESIGN-SPEC.md` at the project root.

---

## Install

1. Zip the `niswah-boutique` folder.
2. WP Admin → Appearance → Themes → Add New → Upload Theme → choose the zip → Install.
3. Activate.
4. Appearance → **Niswah Starter** → *Import Header & Footer*.
5. Divi → Theme Builder → confirm the Global Header and Global Footer appear → **Save Changes**.

The importer page reports whether the bundled file was found and whether Divi's Theme Builder API is available before it lets you run anything.

> The importer creates new templates each time it runs. To re-import cleanly, delete the existing Theme Builder templates first.

**Alternative route:** Divi → Theme Builder → Portability (⇅ icon) → Import → upload `data/theme-builder.json`. That uses Divi's own importer and is the fallback if the one-click path misbehaves.

---

## Rebuilding the templates

The header and footer are generated, not hand-edited as JSON:

```bash
node build/theme-builder.build.mjs
```

Edit `build/theme-builder.build.mjs`, re-run, re-import. Keeping them in a build script means the measured spec values stay exact instead of drifting through UI clicks.

---

## Brand tokens

Exposed as CSS custom properties on `:root` in `style.css`, and mirrored in Divi's Global Colors.

| Token | Value | Role |
|---|---|---|
| `--nb-burgundy` | `#6E1423` | Primary — logo wordmark |
| `--nb-gold` | `#C6A15B` | Accent — logo gradient |
| `--nb-terracotta` | `#B24D2E` | Hover / secondary accent |
| `--nb-ivory` | `#FAF3EA` | Editorial background |
| `--nb-espresso` | `#241512` | Text and dark surfaces |

### Type

| Role | Font | Size / weight |
|---|---|---|
| Headings | Marcellus | 36px / 400, line-height 1.3, ls 0.54px |
| Body | Jost | 16px / 300, line-height 1.8, ls 0.6px |
| Arabic | Cairo | applied via `.nb-arabic` or `[lang="ar"]` |

Divi's Customizer exposes only one heading and one body font, so the Arabic face is loaded in `functions.php` and applied with a helper class.

### Layout

| Property | Value |
|---|---|
| Content width | 1600px |
| Gutter | 50px (24px ≤980, 18px ≤480) |
| Product grid | 4 across, 20px column gap, 55px row gap |

---

## Helper classes

| Class | Effect |
|---|---|
| `.nb-arabic` | Switches the element to the Arabic face |
| `.nb-ticker` | Announcement bar typography (13px / 300 / 0.78px, white) |
| `.nb-footer` | Footer link colours — white, gold on hover |

Add these in Divi under any module's **Advanced → CSS ID & Classes**.

---

## Status

Built so far: Global Header, Global Footer, brand tokens, typography, Woo grid rules.

Not built yet: Home page, Shop / Category / Single Product templates, Cart & Checkout styling. See `02-ROADMAP.md`.
