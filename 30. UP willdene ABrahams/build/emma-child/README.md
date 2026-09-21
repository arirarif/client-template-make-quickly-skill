# Emma — notes for the next developer

Standard setup, nothing locked in:

- **Hello Elementor** (parent theme) + **Emma** (this child theme) + **Elementor / Elementor Pro**.
- Plugin **Emma Core** holds the data layer, so it survives a theme change.

## What lives where

| Thing | Where |
|---|---|
| Brand colours, fonts, button style, site width (1128 px) | Elementor → Site Settings (saved in the active Kit) |
| Pages (Home, About, Services, Portfolio, Contact) | Normal Elementor pages, template "Elementor Full Width" |
| Header, Footer, Single project, Service archive, 404, Project card (loop item), Pricing table | Templates → Theme Builder / Saved Templates |
| Fonts (Gloock, Hanken Grotesk), self-hosted `.woff2` | `assets/fonts/`, declared at the top of `assets/css/theme.css`. Google Fonts loading is switched off in Elementor |
| Layout CSS | `assets/css/theme.css`, numbered sections, one block per page section |
| Portfolio post type `case_study`, taxonomy `service`, "Project details" fields | `emma-core/includes/content-types.php` |
| Hide-when-empty rule for project fields | CSS class `emma-if-FIELDKEY` on an element in the Single project template (same file) |
| Security tweaks (XML-RPC off, no user listing, comments off) | `emma-core/includes/hardening.php` |

## How the CSS is attached

Every section and some widgets carry a class in **Advanced → CSS Classes**, for example `emma-hero`,
`emma-steps`, `emma-sun` (yellow button), `emma-textlink` (underlined link), `emma-label` (small caps label).
Remove the class and the element falls back to plain Elementor styling.

Selectors are kept at low specificity on purpose, so anything set in the Elementor panel wins.
Two Elementor rules to know when you add CSS:

- Widget wrappers get `margin-block-end: 0` and `max-width: 100%` from Elementor with 3–4 class selectors.
  Use `margin-top` for spacing, and put a `max-width` on the inner element (`.my-class > *`).
- `.e-con::before` is Elementor's overlay layer and is positioned absolutely. If you use it for content,
  set `position: static` (see `.emma-step::before`).

## Rebuilding the starter content

`build/tools/make_elementor.py` writes the Elementor JSON in `emma-core/templates/`; **Tools → Emma setup**
imports it. Only needed for a fresh install. After launch, `includes/setup.php` and `templates/` can be deleted.

Bump `Version:` in `style.css` on every CSS change (cache busting), then purge LiteSpeed Cache.
