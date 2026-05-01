# 07 — Build Checklist (2 Pages Only)

> Reduced scope: just **Homepage** + **Incorporation Landing Page** (with wizard).

---

## Phase 1 — Setup (Day 1)

- [ ] Get hosting/WordPress login from client (WhatsApp: +1 212-781-5806)
- [ ] Verify WordPress, WooCommerce, WoodMart already installed (client has existing site)
- [ ] Install required plugins:
  - [ ] WooCommerce Subscriptions (premium)
  - [ ] WooCommerce Checkout Field Editor
  - [ ] WPForms Pro (or use built-in)
- [ ] Create staging environment (don't break live site)

---

## Phase 2 — Build Homepage (Day 2–4)

### 2A — Build with Elementor in WoodMart

Use `homepage-mockup.html` (already built) as the design reference.

**Sections to build:**
- [ ] Announcement bar (dark blue + orange link)
- [ ] Sticky nav (logo + 4 links + orange CTA)
- [ ] **Hero with slider** (client requested) — use WoodMart's built-in slider, NOT Revolution Slider
  - Slide 1: "Form Your Business in Minutes" + entity cards + "Start Now"
  - Slide 2: "Transparent Pricing — No Hidden Fees" (BizJump differentiator)
  - Slide 3: Trust badges + "Trusted by X+ entrepreneurs"
- [ ] Stats section (4 counters)
- [ ] How it works (3 steps)
- [ ] Pricing overview (4 plan cards, link to wizard)
- [ ] Why BizJump (vs competitors comparison)
- [ ] CTA section ("Ready to start?")
- [ ] Footer (4 columns)

### 2B — Set as Homepage

- [ ] Settings → Reading → Homepage = new page

---

## Phase 3 — Build Custom Plugin (Day 5–9) ⭐ HARDEST PART

### 3A — Plugin Structure

```
wp-content/plugins/bizjump-wizard/
├── bizjump-wizard.php         (main plugin file)
├── includes/
│   ├── shortcode.php           (renders [bizjump_wizard])
│   ├── ajax-handlers.php       (cart push handlers)
│   ├── state-fees.php          (PHP array of 51 state fees)
│   ├── plans.php               (4 plans config)
│   └── addons.php              (14 add-ons + conditional logic)
├── assets/
│   ├── wizard.css              (full wizard styling)
│   └── wizard.js               (step navigation + state management)
└── readme.txt
```

### 3B — Build the wizard

Use `incorporate.html` as reference but **fix everything per the new spec** in `05-wizard-flow.md`:
- [ ] Correct prices ($99 / $195 / $295 / $295+$29mo)
- [ ] Plan comparison TABLE (not cards)
- [ ] All 14 add-ons with conditional show/hide
- [ ] Step 5: Business Details (name + designator + address + contact person + SMS consent)
- [ ] Sticky right sidebar order summary
- [ ] Step 6: Review with itemized breakdown

### 3C — WooCommerce integration

- [ ] Create 4 hidden WooCommerce products (one per plan) — admin only, not public
- [ ] Create simple add-on products for each of the 14 add-ons
- [ ] Use `WC()->cart->add_to_cart()` via AJAX on "Proceed to Checkout"
- [ ] Add custom fee for state filing fee via `woocommerce_cart_calculate_fees` hook
- [ ] Save business details + contact info as order meta via `woocommerce_checkout_create_order`

---

## Phase 4 — Build Incorporation Landing Page (Day 10)

- [ ] Create page at `/service/incorporation/` (replace existing)
- [ ] Top section: Hero ("Start Your Business in 4 Easy Steps")
- [ ] Insert `[bizjump_wizard]` shortcode
- [ ] Add trust strip below wizard (testimonials, badges)
- [ ] Add FAQ section at bottom

---

## Phase 5 — Polish & QA (Day 11)

- [ ] Test wizard end-to-end for all 4 entity types
- [ ] Verify add-on conditional logic for each entity
- [ ] Test 5 different states for fee calculation
- [ ] Verify Stripe + PayPal payment flow
- [ ] Mobile responsive check (375px, 768px, 1024px)
- [ ] Page speed test (target: <3s load)
- [ ] Reduced motion / accessibility check

---

## Phase 6 — Handover (Day 12)

- [ ] Take backup of working version
- [ ] Push to live (replace existing homepage + incorporation page)
- [ ] Send client:
  - [ ] Login credentials
  - [ ] Short Loom video walkthrough of wizard backend
  - [ ] How to edit prices (settings page in plugin)
  - [ ] How to view orders in WooCommerce
- [ ] Request 5-star Fiverr review

---

## Time Budget (~36 hours)

| Phase | Hours |
|---|---|
| Setup | 2h |
| Homepage build | 8h |
| Plugin build (wizard) | 18h |
| Landing page | 3h |
| QA / polish | 3h |
| Handover | 2h |
| **Total** | **~36h** |

At $700 = ~$19/hr — tight but doable since most homepage work is already designed.

---

## Out of Scope — Upsell Opportunities

If client asks for any of these AFTER paid scope is delivered, charge separately:

- Client dashboard customization (My Account redesign)
- Document upload portal beyond default WooCommerce
- Admin dashboard customizations
- FluentCRM setup
- Email automation flows
- Additional pages (about, blog, etc.)
- Logo design
- Content writing
- SEO optimization
- Marketing automation

**Suggested upsell message:**
> "That's a great enhancement! It's outside our current scope, but I can quote it as a separate project. Would you like me to send pricing?"
