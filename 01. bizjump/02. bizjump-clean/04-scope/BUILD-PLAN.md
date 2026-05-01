# BizJump — WordPress Build Plan
**Budget: $700 | Deadline: 12 days | Theme: WoodMart**

---

## SCOPE RULE (read this first)
> Build the minimum that saves the client's business.
> Ship it. Get paid. Expand only if client pays more.

### ✅ IN SCOPE (deliver this)
- Homepage with hero slider
- Incorporation landing page
- CartFlows wizard (5 steps)
- 4 service tier products
- Dynamic state fee pricing (custom JS — the only unique code)
- Add-on services with price updates
- Registered Agent as subscription
- Stripe + PayPal checkout
- Basic My Account page
- Privacy Policy, Terms of Service, Refund Policy pages
- Contact page

### ❌ OUT OF SCOPE (do NOT build, tell client "phase 2")
- ACH bank transfer (complex, skip V1)
- Full custom client dashboard (use default WooCommerce My Account)
- Admin order management panel (WooCommerce default is enough)
- FluentCRM full automation (just WooCommerce default order emails)
- EIN Filing, Operating Agreement add-ons (add later)
- Compliance Monitoring subscription (add later)

---

## PAGES LIST (10 pages total)

| # | Page | How Built | Notes |
|---|------|-----------|-------|
| 1 | **Homepage** | WoodMart page builder | Hero slider, benefits, how it works, pricing preview, CTA |
| 2 | **Incorporation Landing** | WoodMart page builder | The main "Start Your Business" entry page → leads to wizard |
| 3 | **Wizard Step 1** | CartFlows step | Choose Entity Type (LLC / C-Corp / S-Corp / Non-Profit) |
| 4 | **Wizard Step 2** | CartFlows step | Choose State (dropdown, state fee auto-loads) |
| 5 | **Wizard Step 3** | CartFlows step | Choose Service Tier (Basic / Pro / Premium / Enterprise) |
| 6 | **Wizard Step 4** | CartFlows step | Select Add-Ons (Registered Agent, EIN, etc.) |
| 7 | **Checkout** | CartFlows checkout | WooCommerce checkout + custom business info fields |
| 8 | **Thank You** | CartFlows thank you | Order summary + next steps |
| 9 | **My Account** | WooCommerce default (WoodMart styled) | Order history, subscription management |
| 10 | **Legal Pages** | WordPress pages | Privacy Policy, Terms of Service, Refund Policy |
| 11 | **Contact** | WPForms + WoodMart | Simple contact form |

**Total: 11 pages (CartFlows steps count as their own pages internally)**

---

## PLUGIN LIST (install these, no custom code needed for most)

### FREE (install from WordPress repo)
| Plugin | Does What |
|--------|-----------|
| WooCommerce | Core e-commerce engine |
| Stripe for WooCommerce | Credit/debit card payments |
| WooCommerce PayPal Payments | PayPal checkout |
| Classic Editor (optional) | If page builder conflicts |

### PREMIUM (you provide at no cost to client)
| Plugin | Does What | Custom code needed? |
|--------|-----------|---------------------|
| **WoodMart Theme** | Full site design, sliders, layout builder | No |
| **CartFlows Pro** | Multi-step wizard/funnel | No — just configure |
| **WooCommerce Product Add-ons** | Add-on services with price updates | No — just configure |
| **WooCommerce Subscriptions** | Registered Agent recurring billing | No — just configure |
| **WooCommerce Checkout Field Editor** | Business info fields at checkout | No — just configure |
| **WPForms Pro** | Contact form + business details backup | No |

### TOTAL: 6 premium plugins — that's it. Nothing else needed.

---

## THE ONE CUSTOM THING (state-based pricing)

This is the only thing you code from scratch. Everything else is plugin config.

**What it does:**
When user selects entity type + state in the wizard, the price updates live to show the correct state filing fee.

**How to build it (simple approach):**
1. Create a PHP file: `wp-content/plugins/bizjump-state-pricing/bizjump-state-pricing.php`
2. Load all 50 state fees from the Excel sheet into a PHP array (copy-paste the data)
3. Expose the data as a JS object via `wp_localize_script()`
4. On the CartFlows wizard step, a small JS snippet reads the selected state + entity → updates the displayed price in real time
5. On checkout, a WooCommerce fee hook adds the state fee to the order total

**Estimated time: 4–6 hours max**

---

## WoodMart Theme Setup Notes

WoodMart handles:
- Header + mega menu (configure, don't code)
- Hero section with built-in slider (use this — no Revolution Slider needed)
- Footer builder
- Page layout via Elementor or WoodMart's own builder
- Mobile responsive out of the box
- WooCommerce product pages styled automatically

**Tell client:** WoodMart has a built-in slider that's faster than Revolution Slider. Use it.

---

## BUILD ORDER (follow exactly, day by day)

### PHASE 1 — Foundation (Days 1–2)
- [ ] Get hosting credentials from client
- [ ] Install WordPress on client's hosting
- [ ] Install WooCommerce
- [ ] Install + activate WoodMart theme
- [ ] Install all 6 premium plugins
- [ ] Basic site settings: title, timezone, permalinks, SSL verify
- [ ] Create placeholder pages for all 11 pages

**Deliverable:** Site is live, theme active, all plugins installed

---

### PHASE 2 — Products & Pricing (Days 3–4)
- [ ] Create 4 service tier products in WooCommerce
  - Basic, Pro, Premium, Enterprise
  - Set base prices (confirm prices with client)
- [ ] Configure WooCommerce Product Add-ons for each tier
  - Registered Agent (+$XX/yr) — subscription type
  - EIN Filing (+$XX one-time)
- [ ] Set up WooCommerce Subscriptions for Registered Agent
- [ ] Build the state pricing plugin (custom code — the only one)
  - PHP file with state fee data array
  - JS to update price on wizard step

**Deliverable:** Products exist, add-ons work, state fees calculate correctly

---

### PHASE 3 — CartFlows Wizard (Days 5–6)
- [ ] Create CartFlows funnel
- [ ] Step 1: Entity type selection (LLC, C-Corp, S-Corp, Non-Profit)
- [ ] Step 2: State selection (50 states dropdown + fee display)
- [ ] Step 3: Service tier selection (link to WooCommerce products)
- [ ] Step 4: Add-on selection (link to Product Add-ons)
- [ ] Step 5: Checkout (WooCommerce checkout + custom business fields)
- [ ] Thank you page
- [ ] Test full wizard flow end to end

**Deliverable:** Full wizard works, user can go from step 1 to paid order

---

### PHASE 4 — Checkout & Payments (Day 7)
- [ ] Configure Stripe for WooCommerce (get keys from client)
- [ ] Configure PayPal Payments (get keys from client)
- [ ] Add custom checkout fields via Checkout Field Editor:
  - Company Name (preferred + fallback)
  - Business Purpose
  - Business Address
  - SMS consent checkbox
- [ ] Test a real order with Stripe test mode
- [ ] Test a real order with PayPal sandbox

**Deliverable:** Payments work, checkout collects all business info

---

### PHASE 5 — Homepage & Pages (Days 8–9)
- [ ] Build homepage with WoodMart page builder:
  - Hero section with WoodMart slider (3 slides)
  - How it works (3 steps)
  - Service tier pricing table
  - Trust signals (SSL badge, money-back, client logos)
  - CTA section → links to wizard
- [ ] Incorporation landing page (simpler — just hero + CTA to wizard)
- [ ] My Account page (use WooCommerce default, WoodMart styles it)
- [ ] Privacy Policy, Terms of Service, Refund Policy (copy standard templates, edit for BizJump)
- [ ] Contact page with WPForms form

**Deliverable:** Site looks good, all pages exist

---

### PHASE 6 — QA & Delivery (Days 10–11)
- [ ] Test wizard flow on mobile (375px)
- [ ] Test wizard flow on desktop
- [ ] Place test order end to end (entity → state → tier → checkout → thank you)
- [ ] Verify order appears in WooCommerce admin with all business details
- [ ] Verify order confirmation email sends
- [ ] Verify subscription billing set up correctly
- [ ] Fix any broken links or layout issues
- [ ] Speed check (WoodMart has built-in optimization)

**Day 12 — Buffer / Delivery**
- [ ] Final client walkthrough (Loom video)
- [ ] Hand over admin credentials
- [ ] Submit Fiverr delivery

---

## QUESTIONS TO ASK CLIENT BEFORE STARTING

1. **Hosting credentials** — WordPress admin access or cPanel/FTP (URGENT — needed day 1)
2. **Service tier prices** — How much is Basic / Pro / Premium / Enterprise?
3. **Add-on prices** — How much is Registered Agent per year? EIN?
4. **Stripe/PayPal keys** — They need to create accounts and share API keys
5. **Hero slider images** — Do they have brand images or use stock?
6. **Logo** — Need the BizJump logo file

---

## TIME ESTIMATE (12 days)

| Phase | Days | Hours |
|-------|------|-------|
| Foundation (install + setup) | 1–2 | 4h |
| Products + state pricing | 3–4 | 8h |
| CartFlows wizard | 5–6 | 8h |
| Payments + checkout fields | 7 | 4h |
| Homepage + pages | 8–9 | 8h |
| QA + delivery | 10–12 | 4h |
| **Total** | **12 days** | **~36h** |

**At $700 that's ~$19/hr — keep scope tight.**

---

## WHAT TO TELL CLIENT IF THEY ASK FOR MORE

> "That feature is part of Phase 2. I've built the foundation to support it — adding it later will be fast and easy. Let me know once you're ready to expand and I'll quote it separately."

Phase 2 items (future upsell):
- ACH payments
- Full client dashboard with document upload
- FluentCRM email automation sequences
- Compliance Monitoring subscription
- Admin order management panel with custom statuses
- EIN Filing + Operating Agreement add-ons
