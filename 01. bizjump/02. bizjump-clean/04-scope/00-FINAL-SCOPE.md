# 🎯 BizJump — FINAL Confirmed Scope

> **READ THIS FIRST.** This folder is the single source of truth.
> Everything in here = what client actually wants.
> Anything outside this scope = upsell / out of project.

---

## ✅ What Client Actually Wants (His Exact Words)

> "I am comfortable with the existing website... just want to redo the home page and landing page for incorporation"

**Translation:** Client already has a working WordPress site at https://www.bizjump.com/. He doesn't want a full rebuild. He just wants:

1. **Homepage** — redesigned
2. **Incorporation landing page** (`/service/incorporation/`) — redesigned, with the new step-by-step wizard

That's it. Two pages.

---

## ❌ What's NOT in Scope

- Contact page (already on his site)
- About page (already on his site)
- Privacy / Terms / Refund pages (already on his site)
- Blog
- Other service pages
- Full theme rebuild

→ The HTML pages we already created (`contact.html`, `privacy-policy.html`, `terms-of-service.html`, `refund-policy.html`) are **not part of the deliverable**. We can keep them as bonuses or use them as references — but client didn't ask for them.

---

## 📦 The 2 Deliverables

### Deliverable 1 — New Homepage
- Hero section (with slider — client requested late, message #13)
- Who is BizJump / what we do
- 4 plan overview (with prices)
- How it works (3 steps)
- Why choose BizJump
- Trust / stats section
- Footer CTA

### Deliverable 2 — New Incorporation Landing Page
This is where the **wizard** lives:
- Page header explaining the service
- The full 5-step wizard (entity → state → plan → add-ons → business details → checkout)
- All dynamic pricing logic
- Final "Proceed to Checkout" pushes order to existing WooCommerce checkout

---

## 🛠️ Implementation Approach

| Page | How We Build It |
|---|---|
| Homepage | Elementor page in WoodMart (or custom HTML/CSS in a page template) |
| Incorporation landing | Elementor page + `[bizjump_wizard]` shortcode from custom plugin |

**Custom plugin** = `bizjump-wizard` — handles all wizard logic, state fees, dynamic pricing, WooCommerce cart integration.

---

## 📁 Files in This Folder

| File | What It Is |
|---|---|
| `00-FINAL-SCOPE.md` | This file — read first |
| `01-client-doc-full.md` | Full text of `🚀 BizJump Incorporation req 4-9-26.docx` |
| `02-state-filing-fees.md` | All 50 state fees from `State_Filing_Fees.xlsx` |
| `03-pricing-and-plans.md` | Final pricing for 4 plans (correct, from doc) |
| `04-addons-full-list.md` | All 14 add-ons with conditional logic rules |
| `05-wizard-flow.md` | Final step-by-step wizard spec |
| `06-competitor-analysis.md` | Notes from LegalZoom, ZenBusiness, Bizee |
| `07-build-checklist.md` | Day-by-day build plan for the 2 pages |

---

## 💰 Money / Timeline

- **Price:** $700 (paid)
- **Deadline:** Apr 29, 2026 (12 days from Apr 17)
- **Client WhatsApp:** +1 212-781-5806
- **Hosting:** Client has it ready (need credentials)

---

## 🎯 Bottom Line

We're NOT building a 9-page website. We're building **2 pages** + **1 plugin**. That's the entire scope.
