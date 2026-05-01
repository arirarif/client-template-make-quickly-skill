# 01 — Client's Full Requirements Document

**Source:** `🚀 BizJump Incorporation req 4-9-26.docx` (sent by client Apr 9, 2026)

This is the complete text of what client sent. Anything in this doc = official requirement.

---

## 🚀 BizJump Incorporation Website Upgrade

**Project Objective:** Revamp current checkout process for an incorporation business
URL: https://www.bizjump.com/service/incorporation/

### Project Description

The BizJump Incorporation Platform is a guided, WooCommerce-based business formation system designed to allow entrepreneurs to form a business online through a structured, step-by-step wizard. The platform mirrors the user experience of leading incorporation providers while maintaining transparent flat-rate pricing and customizable service options.

The system replaces traditional consultation-based incorporation services with a productized workflow where users select their entity type, state of formation, and optional services, then complete checkout. After purchase, the platform captures all required business formation details and routes the order for processing.

**Similar to:**
- https://www.legalzoom.com/business/business-formation/
- https://www.zenbusiness.com/
- https://bizee.com/

### Platform Features

- **Guided Wizard Interface** — step-by-step onboarding flow that simplifies incorporation
- **Productized Service Packages** — 4 tiers: Basic, Pro, Premium, Enterprise
- **Add-On Service Selection** — users can select optional services that dynamically update pricing
- **Dynamic Pricing Logic** — based on entity type, state fees, selected services, subscription options
- **Subscription Services** — recurring billing for Registered Agent, website hosting, compliance monitoring
- **WooCommerce Checkout** — secure payment via Stripe, PayPal, ACH
- **Client Dashboard** — view order status, upload documents, track progress, download deliverables
- **Admin Order Management** — view formation details, track services purchased, update status, manage subscriptions

### Technology Stack

- Platform: WordPress
- E-commerce Engine: WooCommerce
- Wizard Builder: CartFlows
- Product Configuration: WooCommerce Product Add-ons
- Subscriptions: WooCommerce Subscriptions
- Checkout Customization: Checkout Field Editor
- CRM Integration: FluentCRM or Jetpack CRM
- Hosting: WP Engine / Kinsta / SiteGround

---

## Detailed Workflow

### Tools & Plugins Overview (Suggested)

| Purpose | Plugin | Function |
|---|---|---|
| E-commerce Core | WooCommerce | Listings, checkout, orders |
| Service Tiers & Add-ons | WooCommerce Product Add-ons or Advanced Product Fields | Conditional logic for entity types, EIN, etc. |
| Subscriptions (Enterprise) | WooCommerce Subscriptions | $29/month recurring |
| Document Uploads | Checkout Files Upload | Articles, ID, EIN authorization |
| CRM & Email | Jetpack CRM or FluentCRM | Drip campaigns, onboarding |
| Client Dashboard | Custom My Account Page or WP Adminify | Track progress, manage docs |
| Legal Pages | WP Legal Pages | Privacy, TOS, refund policy |
| Hosting | Kinsta / SiteGround / WP Engine | Optimized for WooCommerce |

---

## Checkout Workflow — 5 Steps

### 🔹 Step 1: Select Entity Type

Dropdown / cards:
- LLC
- C-Corp
- S-Corp
- Non-Profit
- Other → redirect to short form for custom quote

> **Reference:** https://bizee.com/ — "Let's start with your new business — Dream Big. We'll Handle the Small but Critical Stuff."

### 🔹 Step 2: Select State

- Dropdown of all 50 U.S. states
- Dynamically show state-specific filing fees

### 🔹 Step 3: Select Services (Plan Selection)

**4 Plans:**

| Plan | Price | Includes |
|---|---|---|
| **Basic** | **$99 + state fees** (one-time) | Corporate Filing Only (7–10 days). Ideal for DIY entrepreneurs. |
| **Pro** | **$195 + state fees** (one-time) | All Basic + EIN, Operating Agreement (5 days). Ideal for entrepreneurs who want initial filings handled including EIN. |
| **Premium** | **$295 + state fees** (one-time) | All Pro + Rush Filing, Compliance docs templates, manage 1st year ongoing compliance (1 day). |
| **Enterprise** | **$295 + state fees** + **$29/month** | All Premium + free website, domain, premium support, accounting setup, ongoing hosting/maintenance. |

> Processing times exclude Secretary of State processing time (1–14 business days).

**Special Offer Note:** Many competitors advertise $0 + state fees plans, then charge $200–$350/year hidden fees. BizJump uses transparent pay-only-for-what-you-need pricing.

**Disclaimer:** "BizJump is not a law firm and does not provide legal advice."

### 🔹 Step 3.1: Customize Your Order (Add-Ons)

See `04-addons-full-list.md` for the complete list with conditional logic.

### 🔹 Step 4: Enter Business Details

Use Checkout Field Editor to collect:
- **Business Name**
- **Designator selection:**
  - For C-Corp / S-Corp / Non-Profit: INC, CORPORATION, INCORPORATED, CORP
  - For LLC: LLC, LIMITED LIABILITY COMPANY
- Show preview: "Your official company name will display as: BIZJUMP INC"
- Note: "What if company name is unavailable? We will contact you with guidance."
- **Business Purpose**
- **Business Address**

### 🔹 Step 4.1: Contact Person Details

> "Please provide the name of the person responsible for this order whom we may contact if additional information is needed."

- First Name
- Last Name
- Email
- Contact Address (checkbox: "Same as Business Address?")
- Mobile Phone (United States +1)
- Checkbox: "I consent to receiving SMS text messages and phone calls from BIZJUMP"
- Optional document uploads

> Note: "At this stage, we only require contact information for the person responsible for setting up the corporation. Depending on the selected service level, we may later request contact information for owners/shareholders, directors, and officers."

### 🔹 Step 5: Review & Payment

- Display summary with all selections + pricing
- Payment Methods: Stripe, PayPal, ACH (via Stripe plugin)
- Show estimated processing time based on plan

---

## Post-Purchase Automation

| Action | Implementation |
|---|---|
| Admin notified of full order | WooCommerce backend + file uploads |
| Client receives confirmation & timeline | WooCommerce email templates |
| Client dashboard access | Customize "My Account" section |
| Document upload/download | Customer dashboard plugin |
| Subscription management | WooCommerce Subscriptions plugin |
| CRM-based follow-up | FluentCRM / Jetpack CRM |

---

## Legal & Compliance Setup

✅ Privacy Policy
✅ Terms of Service
✅ Refund Policy
✅ SSL Certificate
✅ Google reCAPTCHA protection

---

## Optional Enhancements

- Order Progress Tracker (custom plugin)
- Testimonials Slider (Strong Testimonials or Elementor)
- Dynamic Pricing Table (Pricing Table by Supsystic or TablePress)
