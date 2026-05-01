# BizJump — Pages Guide (WoodMart Implementation)
**Reference the homepage-mockup.html for design. Build each section in Elementor/WoodMart.**

---

## PAGES TO BUILD (8 pages total — keep it minimal)

| # | Page Name | WordPress Page | Notes |
|---|-----------|---------------|-------|
| 1 | Homepage | Front Page | Full design — see mockup |
| 2 | Start Your Business | `/incorporate/` | Entry page → leads into CartFlows |
| 3 | Thank You | `/thank-you/` | After payment — CartFlows thank you step |
| 4 | My Account | `/my-account/` | WooCommerce default — WoodMart auto-styles it |
| 5 | Privacy Policy | `/privacy-policy/` | Plain text page |
| 6 | Terms of Service | `/terms-of-service/` | Plain text page |
| 7 | Refund Policy | `/refund-policy/` | Plain text page |
| 8 | Contact | `/contact/` | WPForms form + address |

**CartFlows wizard steps are NOT separate WordPress pages — CartFlows manages them internally.**

---

## PAGE 1 — HOMEPAGE

Build section by section in WoodMart/Elementor:

### Section 1: Announcement Bar
- WoodMart has a built-in "Top Bar" in Customize → Header → Top Bar
- Text: "🎉 Limited Time: Free Registered Agent for 1 Year — Start Now →"
- Background: #1e3a8a | Text: white | Link: orange

### Section 2: Navigation
- Use WoodMart Header Builder (Appearance → Customize → Header)
- Logo left | Menu center | CTA button right ("Start Your Business")
- Enable sticky header (WoodMart setting: on scroll)
- Menu items: Services | Pricing | How It Works | Contact

### Section 3: Hero
- Use WoodMart's built-in **Slider** element (not Revolution Slider)
- WoodMart → Revolution Slider is optional — use WoodMart's native slider
- Slide content: headline + subheadline + 2 buttons + 4 trust badges
- Background: gradient #0f2156 → #1e3a8a (set in slider settings)
- Text color: white
- **WoodMart Elementor widget:** "Promo Banner" or full-width row with custom background

### Section 4: Stats (4 numbers)
- Elementor: 4-column row
- WoodMart widget: **Counter** (has built-in animated number counter)
- 4 counters: 15,000+ Businesses | 50 States | 4.9★ Rating | $0 Hidden Fees
- Background: white | Border bottom: light gray

### Section 5: How It Works (3 steps)
- Elementor: 3-column row
- Each column: number circle + heading + text
- Background: #f9fafb (light gray)
- Use WoodMart **Icon Box** widget for each step
- Number circle: create with Elementor shape or WoodMart badge widget

### Section 6: Pricing (4 cards)
- Elementor: 4-column row
- WoodMart widget: **Pricing Table** — it has a built-in pricing table with features list
- Highlight middle card (Premium) with WoodMart "featured" toggle
- Each card: name, price, "+ state fee" note, features list, button
- Buttons link to the CartFlows funnel start URL

### Section 7: Why BizJump (2-column)
- Elementor: 2-column row (60% / 40%)
- Left: section label + title + 3 icon boxes (WoodMart Icon Box widget)
- Right: white card with comparison table
  - Use WoodMart **Table** widget or simple Elementor text widget with custom styling

### Section 8: CTA Section
- Elementor: full-width row, dark blue background
- Centered text + 2 buttons
- WoodMart: use "Banner" element or custom row

### Section 9: Footer
- WoodMart Footer Builder (Appearance → Customize → Footer)
- 4 columns: Brand info | Services | Company | Legal
- Add copyright text at bottom
- Background: #111827 (very dark)

---

## PAGE 2 — START YOUR BUSINESS (`/incorporate/`)

This is the entry page before the CartFlows wizard starts.

**What goes on it:**
- Simple hero: "Let's Form Your Business" + short text
- CTA button: "Begin →" (links to CartFlows funnel step 1)
- 3 trust badges below button

**How to build:**
- WoodMart page template: Full Width (no sidebar)
- Elementor: simple 1-column layout
- Background: same dark blue as homepage hero
- Keep it minimal — user just needs to click one button

---

## PAGE 3 — THANK YOU (CartFlows)

CartFlows creates this automatically when you set up the funnel.

**Edit the CartFlows Thank You template to include:**
- "🎉 Your Order is Confirmed!" headline
- Order summary (CartFlows has a built-in order details shortcode)
- Next steps: "Our team will begin processing your formation within 1 business day."
- Link to My Account page

**No extra work needed — just edit the CartFlows thank you step template.**

---

## PAGE 4 — MY ACCOUNT (WooCommerce Default)

WooCommerce creates this page automatically. WoodMart automatically styles it to match the site.

**What it shows by default (no custom code needed):**
- Orders tab — client sees their orders
- Subscriptions tab — shows Registered Agent subscription (WooCommerce Subscriptions adds this)
- Account details tab — name, email, password
- Logout

**That's it. Don't customize this — WooCommerce + WoodMart handles it.**

---

## PAGES 5, 6, 7 — LEGAL PAGES

Three plain WordPress pages. WoodMart styles them automatically.

**How to create:**
- WordPress → Pages → Add New
- Page template: WoodMart default
- Paste in standard legal text (use a generator like termsandconditionstemplate.com)
- Edit to add "BizJump" as the company name and bizjump.com as the website

**Privacy Policy:** Required for Stripe, PayPal, and GDPR
**Terms of Service:** Describes what BizJump provides and liability limits
**Refund Policy:** State your refund terms (e.g., "full refund within 24 hours of purchase if filing hasn't started")

---

## PAGE 8 — CONTACT

**What goes on it:**
- Simple headline: "Get In Touch"
- WPForms contact form (Name, Email, Message, Submit)
- BizJump email address and phone number (get from client)

**How to build:**
- WoodMart full-width page
- Elementor: 2-column (form left, contact info right)
- WPForms: create form in WPForms → paste shortcode into Elementor

---

## CARTFLOWS WIZARD (not a WordPress page — it's a funnel)

CartFlows funnel = 5 internal steps + 1 checkout + 1 thank you

**Create one funnel in CartFlows with these steps:**

| Step # | Step Name | Type | What User Does |
|--------|-----------|------|----------------|
| 1 | Entity Type | Landing | Picks LLC / C-Corp / S-Corp / Non-Profit |
| 2 | Choose State | Landing | Selects US state from dropdown, sees state fee |
| 3 | Choose Plan | Landing | Picks Basic / Pro / Premium / Enterprise |
| 4 | Add-Ons | Landing | Toggles Registered Agent, EIN (optional) |
| 5 | Checkout | Checkout | Business info fields + payment |
| 6 | Thank You | Thank You | Confirmation + next steps |

**CartFlows step design:**
- Use CartFlows with Elementor — each step is an Elementor page
- Keep each step clean: 1 question per step, progress bar at top
- "Continue →" button at bottom of each step
- "← Back" link above
- WoodMart header can be hidden on CartFlows steps (CartFlows setting: remove header/footer)

---

## WOODMART SETTINGS TO CONFIGURE (one-time setup)

Go through these in WoodMart Customize panel:

| Setting | What to do |
|---------|------------|
| Logo | Upload BizJump logo (get from client) |
| Primary Color | Set to #2563eb (blue) |
| Button Color | Set to #f97316 (orange) |
| Font | Set Inter as body font (WoodMart has Google Fonts integration) |
| Header | Sticky on scroll, white background, blur |
| Top Bar | Enable, set announcement text |
| Footer | Build 4-column footer |
| WooCommerce | Enable distraction-free checkout (WoodMart has this toggle) |

---

## WHAT NOT TO BUILD (save yourself time)

| Thing | Why Skip |
|-------|----------|
| Custom client dashboard | WooCommerce My Account is enough |
| Custom order status panel | WooCommerce admin default is fine |
| Custom email templates | WooCommerce default emails are fine for V1 |
| FluentCRM sequences | Default WooCommerce order emails cover the basics |
| ACH payments | Complex, skip for V1 |
| Custom product pages | WoodMart styles WooCommerce product pages automatically |
