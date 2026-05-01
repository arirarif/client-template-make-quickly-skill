# BizJump — LZ-Inspired Elementor Widgets

Custom Elementor widgets for the LegalZoom-inspired BizJump pages —
**demo-landing** (LLC sales) and **formation-landing** (entity selector).

After activation, all 19 widgets appear in the Elementor panel under the
**"BizJump LZ Widgets"** category.

## Install

1. Make sure **Elementor** is installed and activated.
2. Zip the `bj-lz-elementor` folder.
3. WP Admin → **Plugins → Add New → Upload Plugin** → choose the zip → install.
4. Activate **BizJump — LZ-Inspired Elementor Widgets**.
5. Edit any page with Elementor → search the panel for `DLW` or `FLW`.

## Folder layout

```
bj-lz-elementor/
├─ bj-lz-elementor.php              # plugin bootstrap
├─ includes/
│  └─ class-bj-lz-elementor.php     # singleton, category + widget registration
├─ widgets/
│  ├─ class-widget-dlw-01-navbar.php
│  ├─ class-widget-dlw-02-hero.php
│  ├─ class-widget-dlw-03-pricing.php
│  ├─ class-widget-dlw-04-features.php
│  ├─ class-widget-dlw-05-comparison-table.php
│  ├─ class-widget-dlw-06-testimonials.php
│  ├─ class-widget-dlw-07-faq.php
│  ├─ class-widget-dlw-08-cta-banner.php
│  ├─ class-widget-dlw-09-footer.php
│  ├─ class-widget-flw-01-navbar.php
│  ├─ class-widget-flw-02-hero-entity-grid.php
│  ├─ class-widget-flw-03-how-it-works.php
│  ├─ class-widget-flw-04-comparison-table.php
│  ├─ class-widget-flw-05-why-bizjump.php
│  ├─ class-widget-flw-06-stats-band.php
│  ├─ class-widget-flw-07-faq.php
│  ├─ class-widget-flw-08-cta-banner.php
│  ├─ class-widget-flw-09-footer.php
│  └─ class-widget-flw-10-wizard.php
└─ assets/
   ├─ css/
   └─ js/
```

## Widget index

### Demo Landing — `DLW`
*(LLC sales page — `demo-landing.html`)*

| #  | Widget                       | What it is                                                                  |
|----|------------------------------|-----------------------------------------------------------------------------|
| 01 | DLW 01 — Navbar              | Sticky white nav, logo + 5 links + Sign In/CTA, hamburger on mobile         |
| 02 | DLW 02 — Hero                | Full-bg image, dark overlay, badge, headline w/ emphasis, 2 CTAs, stat pills |
| 03 | DLW 03 — Pricing Cards       | 3 cards (Basic / Pro / Premium), Pro is featured (orange ring + lift)       |
| 04 | DLW 04 — Features Grid       | 6 icon-cards on slate-50 bg, alternating orange/indigo icons                |
| 05 | DLW 05 — Comparison Table    | 4-col plan table, **stacks into per-plan cards on mobile**                  |
| 06 | DLW 06 — Testimonials        | 3 review cards with stars, quote, initial-avatar                            |
| 07 | DLW 07 — FAQ Accordion       | Collapsible FAQ with single-open toggle (no jQuery)                         |
| 08 | DLW 08 — CTA Banner          | Orange gradient with decorative orbs + white CTA button                     |
| 09 | DLW 09 — Footer              | 4-col dark footer (brand + 3 link cols + legal row)                         |

### Formation Landing — `FLW`
*(Entity selector page — `formation-landing.html`)*

| #  | Widget                          | What it is                                                                     |
|----|---------------------------------|--------------------------------------------------------------------------------|
| 01 | FLW 01 — Navbar                 | Compact (64px) sticky nav, Sign In + My Account                                |
| 02 | FLW 02 — Hero + Entity Grid     | Cream bg, breadcrumb, headline, 4 entity cards w/ price + CTA, helper bar      |
| 03 | FLW 03 — How It Works           | 3-step circle flow with connecting line; step 1 highlighted orange             |
| 04 | FLW 04 — Entity Comparison      | 5-col table, supports check/dash/pill cells, **stacks on mobile**              |
| 05 | FLW 05 — Why BizJump            | 6 icon-cards, alternating orange/indigo                                        |
| 06 | FLW 06 — Stats Band             | Dark slate-900 strip with 4 stats + vertical dividers                          |
| 07 | FLW 07 — FAQ Accordion          | Same accordion pattern, cream-tinted bg                                        |
| 08 | FLW 08 — CTA Banner             | Deeper orange gradient (700→500→400) variant                                   |
| 09 | FLW 09 — Footer                 | Dark 4-col footer, formation-page link defaults                                |
| 10 | FLW 10 — Formation Wizard       | 4-step wizard (Entity → Info → Package → Review → Done), reads `?entity=` URL  |

### Wiring FLW-02 → FLW-10 (formation flow)

The entity-card buttons in **FLW-02** default to `/start/?entity=llc` (and
`corporation` / `nonprofit` / `dba`). For those clicks to actually land on a
working wizard:

1. WP Admin → **Pages → Add New**, title it whatever you like.
2. Set the permalink to `/start/` (or change the FLW-02 button URLs to your page slug).
3. Edit with Elementor → drop **FLW 10 — Formation Wizard** into a single full-width column.
4. Publish. The wizard reads the `entity` query string and pre-selects the matching card / hero.

URL alias: `?entity=corporation` / `?entity=ccorp` (FLW-02 / FLW-09 footer) and
`?entity=scorp`, `?entity=nonprofit`, `?entity=dba` are all accepted — they map to
the wizard's internal slugs (`c_corp`, `s_corp`, `non_profit`; DBA falls back to
LLC since no DBA WC product exists).

### WooCommerce checkout (requires the `bizjump-wizard` plugin)

FLW-10 does not implement WooCommerce on its own. To turn the in-wizard
"Complete Purchase" button into a real WC checkout, install and activate the
sister plugin **BizJump Wizard** (`bizjump-wizard`) — it provides:

- Hidden WC products (`plan_basic`, `plan_pro`, `plan_premium`, …) created on activation
- AJAX endpoint `bj_create_order` that adds the chosen plan to the cart, attaches the
  state filing fee as a WC fee, saves wizard data to the order, and returns the
  checkout URL
- Order admin meta box and "My Formation" tab in WC My Account

When both plugins are active and the user clicks "Complete Purchase":

1. FLW-10 reads `window.BJW.ajaxUrl` and `window.BJW.nonce` (localized by
   `bizjump-wizard`)
2. POSTs `plan` (the package's "WC Product Key" — defaults: `plan_basic` / `plan_pro` /
   `plan_premium`), `state` (2-letter slug), `entity` (`llc` / `c_corp` / `s_corp` /
   `non_profit`), and the collected business name / contact name / email
3. Browser redirects to the WC checkout URL returned by the handler
4. After payment, the order shows the formation details to the customer in
   `My Account → My Formation`

If `bizjump-wizard` is **not** active, FLW-10 logs a console warning and shows the
local "Order Confirmed!" panel instead — useful for previewing the wizard
without WooCommerce.

The package "WC Product Key" is editable per package row in Elementor, so you
can add additional plans (e.g. `plan_enterprise`) by also adding them to
`bizjump-wizard/includes/data-plans.php`.

## Section-setup tips per widget

For widgets that go **edge-to-edge** (Navbar, Hero, CTA Banner, Footer, Stats Band):

- Add a new Section → **Layout → Content Width: Full Width**
- **Stretch Section: YES**
- **Padding: 0** on all sides
- Drop the widget in a single Column

For all other widgets the HTML handles its own padding — you can use a
default Boxed section with **Padding: 0** and let the widget breathe.

## Editable controls

Every widget exposes editable controls in the Elementor sidebar:

- **Text fields** — headlines, eyebrows, button labels, descriptions
- **URL fields** — every link/button (with "open in new tab" toggle)
- **Repeaters** — pricing cards, comparison rows, FAQ items, footer link columns,
  entity cards, testimonials, stats, breadcrumbs
- **Switchers** — featured/highlight toggles, "open by default" for FAQ items
- **Selects** — icon pickers, color variants (orange / indigo), avatar gradients
- **Media** — hero background image (DLW-02)

All HTML is escaped via `esc_html()` / `esc_url()` / `wp_kses_post()`. Headlines
that need `<br>` use textarea + `wp_kses_post()`.

## Fonts

The plugin auto-enqueues **Inter** + **Plus Jakarta Sans** from Google Fonts on
the front-end and in the Elementor preview. If your theme already loads them,
the duplicate request is harmless (the CDN response is cached).

To switch off: edit `enqueue_fonts()` in `includes/class-bj-lz-elementor.php`.

## Mobile responsiveness

Every widget includes media queries at:
- **≤960px** — small tablet adjustments
- **≤768px** — tablet breakpoint
- **≤700px** — comparison tables flip to per-plan cards
- **≤600px / ≤520px / ≤480px / ≤420px** — phone breakpoints

Both navbars switch to a hamburger toggle on ≤768px.

## CSS class prefixes (no collisions)

Each widget uses its own prefix so styles never bleed:

- `dlw01-`, `dlw02-`, … `dlw09-` — Demo Landing widgets
- `flw01-`, `flw02-`, … `flw09-` — Formation Landing widgets
- `flw10-` — Formation Wizard

## Coexistence with the existing `bj-elementor` plugin

This plugin uses different namespace (`BJ_LZ_Elementor`), category slug
(`bj-lz-widgets`), constants (`BJLZ_EL_*`), CSS prefixes (`dlw/flw`), and
class names (`Widget_DLW_*` / `Widget_FLW_*`) — so it can be activated
**alongside** `bj-elementor` without any conflicts.
