# BizJump — Clean Project Folder

**Client:** BizJump | **Paid:** $700 (Apr 17 2026) | **Deadline:** Apr 29 2026

---

## Folder Structure

```
01-pages/                   ← HTML mockups (open in browser to preview)
  homepage.html             ← Homepage design (v2, final)
  incorporation-landing.html← Incorporation entry/landing page
  wizard-prototype.html     ← Full 6-step wizard UI prototype
  contact.html
  privacy-policy.html
  refund-policy.html
  terms-of-service.html

02-elementor/               ← Elementor widget HTML references (01–13)
  01-announcement-bar.html
  02-nav-header.html
  03-hero.html
  04-ticker-marquee.html
  05-stats-strip.html
  06-entity-types.html
  07-how-it-works.html
  08-pricing-cards.html
  09-why-bizjump.html
  10-services-grid.html
  11-testimonials.html
  12-cta-banner.html
  13-footer-guide.md

03-plugin/                  ← WordPress plugin (upload this to WP)
  bizjump-wizard/           ← Plugin source code
    assets/wizard.css       ← Complete wizard styling (973 lines)
    assets/wizard.js        ← State machine + live pricing (495 lines)
    includes/               ← PHP: data, AJAX, shortcode, WC hooks
    bizjump-wizard.php      ← Main plugin file
  bizjump-wizard.zip        ← Ready to upload to WordPress

04-scope/                   ← Definitive project scope documents
  00-FINAL-SCOPE.md         ← START HERE — 2 pages only
  01-client-doc-full.md
  02-state-filing-fees.md
  03-pricing-and-plans.md   ← Basic $99 / Pro $195 / Premium $295 / Enterprise $295+$29/mo
  04-addons-full-list.md
  05-wizard-flow.md         ← 6-step wizard flow
  06-competitor-analysis.md
  07-build-checklist.md
  BUILD-PLAN.md             ← 12-day delivery plan
  PAGES-GUIDE.md            ← Elementor/WoodMart page building guide

05-research/                ← Background research & client comms
  brand.md
  client-messages.md
  deal-notes.md
  project-brief.md
  tech-stack.md
  wizard-flow.md
  project-brief-full.md
  woocommerce-guide.md

06-resources/               ← Raw client files
  bli.xlsx                  ← State filing fees spreadsheet
  🚀 BizJump Incorporation req 4-9-26.docx ← Original client requirements doc
```

---

## Scope (2 pages only)

1. **Homepage** — redesign from scratch using Elementor
2. **Incorporation landing page** — wizard form page

**Page builder:** Elementor (NOT WPBakery)
**Theme:** WoodMart

---

## Key Design Tokens

| Token | Value |
|-------|-------|
| Primary blue | `#1e3a8a` / `#2563eb` |
| Orange CTA | `#f97316` |
| Font | Inter (Google Fonts) |
| Border radius | 8px cards, 12px large cards |

---

## Wizard Shortcode

Place `[bizjump_wizard]` on any WordPress page to render the full 6-step incorporation wizard.

---

## Pending from Client

- WordPress / hosting credentials
- Logo + hero image assets
- Stripe / PayPal API keys
