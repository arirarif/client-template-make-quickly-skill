# BizJump — Full Project Requirements

## What the Client Wants (Plain English)
Revamp the current basic incorporation checkout into a full guided wizard platform — like LegalZoom, ZenBusiness, and Bizee. Users visit the site, pick their business type, choose a service tier, add optional extras, fill in business details, and pay — all in one smooth step-by-step flow.

---

## Feature 1 — Multi-Step Guided Wizard
- NOT a single page — a step-by-step wizard experience
- Powered by CartFlows
- Steps: Entity Type → State → Service Tier → Add-Ons → Business Details → Checkout
- Must feel professional and simple (like the competitor sites)

---

## Feature 2 — Four Service Tiers (WooCommerce Products)
| Tier       | Description                          |
|------------|--------------------------------------|
| Basic      | Entry-level formation                |
| Pro        | Mid-tier with more features          |
| Premium    | Higher-end services included         |
| Enterprise | Full-service, top-tier, priority     |

Each tier has:
- Different included services
- Different processing times
- Different prices

---

## Feature 3 — Dynamic Pricing Logic
Prices must AUTO-UPDATE based on:
- Entity type selected (LLC, C-Corp, S-Corp, Non-Profit)
- US State selected (each state has different filing fees — see State_Filing_Fees.xlsx)
- Add-on services selected
- Subscription vs one-time choice

This is the HARDEST part — requires custom logic / dedicated plugin / conditional pricing in WooCommerce Product Add-ons.

---

## Feature 4 — Add-On Services (Optional Extras)
Each add-on dynamically updates the cart total:
- Registered Agent (annual subscription)
- Website Hosting (recurring)
- Compliance Monitoring (recurring)
- EIN Filing (one-time)
- Operating Agreement (one-time)
- Others TBD

---

## Feature 5 — Recurring Subscriptions
Some services billed annually or monthly:
- Registered Agent service
- Website hosting
- Compliance monitoring
- Powered by: WooCommerce Subscriptions

---

## Feature 6 — WooCommerce Checkout
3 payment methods required:
- Stripe (credit/debit cards)
- PayPal
- ACH bank transfer (via Stripe ACH or Authorize.net)

---

## Feature 7 — Business Info Collection (Custom Checkout Fields)
After selecting services, user fills in:
- Company Name (with fallback name option)
- Business Purpose
- Business Address
- Contact Person: First Name, Last Name, Email, Phone
- Document upload option
- SMS/phone consent checkbox
- Powered by: WooCommerce Checkout Field Editor

---

## Feature 8 — Client Dashboard
After purchase, each customer sees:
- Order status
- Document upload portal
- Formation progress tracker
- Download deliverables (e.g., formation docs)
- Powered by: WooCommerce My Account (customized)

---

## Feature 9 — Admin Order Management Panel
BizJump team needs:
- All formation details per order
- Which services were purchased
- Order status updates
- Subscription management
- Powered by: WooCommerce Orders + custom fields + Admin Columns Pro

---

## Feature 10 — Post-Purchase Automation
After checkout:
- Automated confirmation email sent
- CRM record created (FluentCRM or Jetpack CRM)
- Order routed to BizJump admin for processing
- Subscription billing initiated (if applicable)

---

## Feature 11 — Legal & Compliance Pages
- Privacy Policy page
- Terms of Service page
- Refund Policy page
- SSL Certificate active
- Google reCAPTCHA on checkout

---

## Feature 12 — Hero Section Slider (Late Addition — Apr 17)
- Client requested hero section uses a slider
- Client mentioned Revolution Slider (they've used it for years)
- Suggested lighter alternative instead of Revolution Slider
- DECISION NEEDED: Which slider to use — confirm with client

---

## Data Files from Client
- `State_Filing_Fees.xlsx` — filing fees for all 50 US states (received Apr 9)
- `BizJump Incorporation req 4-9-26.docx` — full requirements document (received Apr 9)

---

## Prototypes Built & Shown to Client
- https://arirarif.github.io/bizjump-tempalte/ (initial mockup)
- https://arirarif.github.io/BizJump-Incorporation-Platform/ (full platform prototype)
- https://arirarif.github.io/BizJump-Incorporation-Platform/BizJump_Visual_Prototype.html (visual prototype direct link)
- Client said: "ok on the right track" and "ok cool" — approved direction

---

## Open Questions / TODOs
- [ ] Which slider for hero section? (Revolution Slider vs lighter alternative)
- [ ] Get WordPress/hosting login credentials from client
- [ ] Review State_Filing_Fees.xlsx to plan dynamic pricing logic
- [ ] Review BizJump_req docx for any extra details
- [ ] Confirm exact pricing for each of the 4 service tiers
- [ ] Confirm which exact add-ons to include
