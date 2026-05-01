# 🛠️ BizJump — WooCommerce Implementation Guide
### Step-by-Step: How to Build This on WordPress + WooCommerce

---

## PHASE 1: Environment Setup

### 1.1 Hosting & WordPress
- Use **WP Engine**, **Kinsta**, or **SiteGround** (client specified)
- Install WordPress (latest version)
- Install and activate **WooCommerce**
- Install **SSL certificate** (usually free via Let's Encrypt on managed hosts)

### 1.2 Required Plugins (Install These First)
| Plugin | Purpose | Cost |
|--------|---------|------|
| WooCommerce | Core e-commerce engine | Free |
| CartFlows | Multi-step wizard/funnel | ~$99/yr |
| WooCommerce Product Add-ons | Dynamic add-ons + pricing | ~$79/yr |
| WooCommerce Subscriptions | Recurring billing | ~$279/yr |
| Checkout Field Editor (ThemeHigh) | Custom checkout fields | Free/Pro |
| FluentCRM | CRM + email automation | Free/Pro |
| WooCommerce Stripe Gateway | Stripe + ACH payments | Free |
| WooCommerce PayPal Payments | PayPal | Free |
| WP Legal Pages | Privacy Policy/Terms | Free/Pro |
| Google reCAPTCHA for WP | Spam/bot protection | Free |

---

## PHASE 2: Create the Service Products

### 2.1 Create 4 Service Tier Products
In WooCommerce → Products → Add New, create 4 **Simple Products**:

**Product 1: Basic Incorporation**
- Set base price
- Description: What's included at Basic tier
- Category: "Incorporation"

**Product 2: Pro Incorporation**
- Set price higher than Basic
- Include everything in Basic + more features

**Product 3: Premium Incorporation**
- Higher price
- Full-featured

**Product 4: Enterprise Incorporation**
- Highest price
- White-glove service

> **Tip:** You can alternatively use a single **Variable Product** with 4 variations (Basic/Pro/Premium/Enterprise) — this is cleaner and easier to manage.

### 2.2 Add the Add-On Services (WooCommerce Product Add-ons)
On each product, use the Product Add-ons plugin to add optional selections:

**Entity Type (required dropdown):**
- LLC
- C-Corp
- S-Corp
- Non-Profit
- Other (triggers custom quote form)
- Set each to add $0 base (state fees handled separately)

**State Selection (required dropdown):**
- List all 50 states
- Assign a price modifier per state (the filing fee for that state)
- Example: Delaware LLC = +$90 state fee, Wyoming LLC = +$102, etc.
- Use the "price modifier" feature in Product Add-ons to add state fees automatically

**Optional Add-On Services (checkboxes):**
- ☐ Registered Agent Service — +$X/year (subscription)
- ☐ EIN / Tax ID Filing — +$X one-time
- ☐ Operating Agreement — +$X one-time
- ☐ Business Bank Account Setup — +$X
- ☐ Website Hosting — +$X/month (subscription)
- ☐ Compliance Monitoring — +$X/year (subscription)
- ☐ Certificate of Good Standing — +$X

Each checkbox dynamically adds to the cart total. ✅ This is built into WooCommerce Product Add-ons.

---

## PHASE 3: Build the Wizard Flow with CartFlows

### 3.1 Install & Setup CartFlows
CartFlows creates a "flow" (funnel) — a series of pages the user goes through instead of the standard WooCommerce shop/cart/checkout pages.

### 3.2 Create the BizJump Flow
Go to CartFlows → Flows → Add New

**Step 1 Page: "What type of business are you forming?"**
- Entity type selection (LLC, C-Corp, S-Corp, Non-Profit)
- Design as a visual card selector (use Elementor or block editor)
- This selection pre-selects the WooCommerce product variation

**Step 2 Page: "Select Your State"**
- 50-state dropdown
- Show the state filing fee dynamically when selected
- This triggers the price modifier in Product Add-ons

**Step 3 Page: "Choose Your Package"**
- Show the 4 tiers (Basic/Pro/Premium/Enterprise) side by side
- Comparison table layout
- Clicking a tier adds that product to cart

**Step 4 Page: "Customize Your Order"**
- Show add-on checkboxes (registered agent, EIN, hosting, etc.)
- Running price total updates as user checks boxes
- CartFlows + Product Add-ons handles this

**Step 5 Page: "Your Business Details" (Custom Checkout Fields)**
- Company Name field
- "What if company name is unavailable?" — second choice field
- Business Purpose
- Business Address fields
- File upload (optional documents)

**Step 6 Page: "Contact Person Details"**
- First Name, Last Name
- Email
- Phone (with country code +1)
- "Same as business address?" toggle
- SMS consent checkbox

**Step 7 Page: "Review & Pay"**
- Order summary (entity type, state, package, add-ons, total)
- Payment options: Stripe / PayPal / ACH
- Estimated processing time shown based on tier selected
- Legal disclaimers

> CartFlows handles the navigation between steps, progress bar, and "next" buttons automatically.

---

## PHASE 4: Subscription Products Setup

### 4.1 For Recurring Services (Registered Agent, Hosting, Compliance)
These add-ons need to be linked to WooCommerce Subscription products:

Option A: Create **standalone subscription products** (e.g., "Registered Agent — Annual") and add them to the cart when the checkbox is selected. This requires a small custom function or a plugin like "WooCommerce Composite Products."

Option B: Use **WooCommerce Subscriptions + Product Add-ons** together — mark specific add-ons as subscription items. This is more complex to set up but seamless for the user.

**Recommended approach:** Create separate subscription products and use CartFlows order bumps to offer them at checkout. Simpler and more reliable.

---

## PHASE 5: Custom Checkout Fields

### 5.1 Using Checkout Field Editor (ThemeHigh)
Go to WooCommerce → Checkout Fields (after plugin install)

Add these custom fields to the checkout:
- `company_name` — Text field, required
- `company_name_alternative` — Text field, optional
- `business_purpose` — Textarea, required
- `contact_first_name` — Text, required
- `contact_last_name` — Text, required
- `contact_email` — Email, required
- `contact_phone` — Phone, required
- `sms_consent` — Checkbox
- `document_upload` — File upload field (may need WooCommerce Upload Files plugin)

These fields are saved with the order and visible in the WooCommerce order admin.

---

## PHASE 6: Payment Gateways

### 6.1 Stripe (Credit/Debit Cards)
- Install **WooCommerce Stripe Payment Gateway** (free, official plugin)
- Connect your Stripe account via API keys
- Enable card payments

### 6.2 ACH (Bank Transfer via Stripe)
- In Stripe plugin settings, enable **ACH Direct Debit** (US bank transfers)
- Requires users to verify their bank account

### 6.3 PayPal
- Install **WooCommerce PayPal Payments** (free, official plugin)
- Connect your PayPal Business account

---

## PHASE 7: Client Dashboard

### 7.1 WooCommerce My Account Page (default)
WooCommerce already has a "My Account" page with:
- Orders list
- Account details
- Subscriptions (if WooCommerce Subscriptions is active)

### 7.2 Customize the Dashboard
To add BizJump-specific features (document uploads, progress tracking, deliverable downloads):

**Option A (Easier):** Use a plugin like **WooCommerce Customer Area** or **YITH WooCommerce Customer History** to extend My Account

**Option B (Custom):** Add custom tabs to My Account using WooCommerce hooks:
```php
// Add custom tab to My Account
add_filter('woocommerce_account_menu_items', function($items) {
    $items['formation-status'] = 'Formation Status';
    $items['my-documents'] = 'My Documents';
    return $items;
});
```

**For document uploads/downloads:** Use **WooCommerce Upload Files** plugin — lets both admin and customer upload files per order.

---

## PHASE 8: Admin Order Management

WooCommerce's built-in order management covers most of this:
- View all orders with formation details (custom fields appear in order view)
- Update order status (custom statuses for formation workflow)

### 8.1 Custom Order Statuses
Add custom statuses for the formation workflow:
- `wc-pending-review` — Order received, under review
- `wc-in-formation` — Actively being filed with Secretary of State
- `wc-filed` — Filed, waiting for state approval
- `wc-completed` — Formation complete, documents delivered

Use plugin **WooCommerce Custom Order Statuses** or add via code.

---

## PHASE 9: CRM & Post-Purchase Automation

### 9.1 FluentCRM Setup
- Install FluentCRM (free base plugin)
- Connect to WooCommerce (built-in integration)
- When a purchase is made → automatically create/update a contact in FluentCRM
- Tag contacts by: entity type, state, plan tier, add-ons purchased

### 9.2 Email Automations (FluentCRM)
Create automated email sequences:
1. **Immediately after purchase:** "Order Received — We're Getting Started"
2. **When status → In Formation:** "Great news! We've begun filing your paperwork"
3. **When status → Filed:** "Your formation has been filed with the state"
4. **When status → Completed:** "Your business is officially formed! Here are your documents"
5. **Subscription renewal reminders:** 30 days / 7 days / 1 day before renewal

---

## PHASE 10: Legal Pages & Security

### 10.1 Generate Legal Pages
- Install **WP Legal Pages** plugin
- Generate: Privacy Policy, Terms of Service, Refund Policy
- Customize with BizJump's specific policies

### 10.2 reCAPTCHA
- Install **Google reCAPTCHA for WP**
- Apply to checkout and contact forms

### 10.3 SSL
- Confirm SSL is active (most managed hosts provide this)
- Force HTTPS in WordPress settings and .htaccess

---

## PHASE 11: Testing Checklist

Before going live, test all of these:

- [ ] Complete wizard flow from start to finish
- [ ] Entity type selection changes pricing
- [ ] State selection adds correct filing fee
- [ ] Add-ons update cart total in real-time
- [ ] Subscription items appear separately with recurring price shown
- [ ] All custom checkout fields save to order
- [ ] Stripe payment works (use test mode)
- [ ] PayPal payment works
- [ ] ACH payment works
- [ ] Confirmation email sent after purchase
- [ ] FluentCRM contact created after purchase
- [ ] Customer can log in to My Account and see their order
- [ ] Admin can see all custom field data in order view
- [ ] Document upload works (if enabled)
- [ ] Custom order statuses update correctly
- [ ] CRM automation emails trigger at correct status changes
- [ ] Mobile responsiveness (wizard works on phone/tablet)
- [ ] reCAPTCHA active on checkout
- [ ] SSL active, no mixed content warnings

---

## 📋 Realistic Timeline Estimate

| Phase | Work Estimate |
|-------|--------------|
| Environment setup + plugins | 2–4 hrs |
| Product creation (4 tiers + add-ons) | 4–8 hrs |
| CartFlows wizard setup + design | 8–16 hrs |
| Subscription products | 2–4 hrs |
| Custom checkout fields | 2–4 hrs |
| Payment gateways (3x) | 2–4 hrs |
| Client dashboard customization | 4–8 hrs |
| Admin order management | 2–4 hrs |
| CRM + email automations | 4–8 hrs |
| Legal pages + security | 1–2 hrs |
| Testing + fixes | 4–8 hrs |
| **TOTAL** | **35–70 hrs** |

---

## 💡 Pro Tips

1. **Start with CartFlows Pro** — the free version is limited. Get Pro to unlock multi-step flows and order bumps.
2. **Build the state fee list in a spreadsheet first** — all 50 states × entity types with their fees. You'll need this to configure Product Add-ons correctly.
3. **Use CartFlows + Elementor** for the best design control on wizard step pages.
4. **Test subscriptions in WooCommerce Subscriptions sandbox mode** before going live — subscription bugs are painful to fix after real customers sign up.
5. **The "Other" entity type** (for custom quotes) should redirect to a Gravity Forms or WPForms page, not go through checkout.
6. **WooCommerce Subscriptions is expensive** (~$279/yr) — make sure client is aware and has budget for it.
