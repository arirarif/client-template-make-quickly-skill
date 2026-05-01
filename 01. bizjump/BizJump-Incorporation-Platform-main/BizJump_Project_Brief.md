# 🚀 BizJump Incorporation Website Upgrade — Project Brief

**Client Website:** https://www.bizjump.com/service/incorporation/
**Project Type:** WooCommerce-based Business Formation Platform
**Date Reviewed:** April 9, 2026

---

## 🎯 What the Client Wants (Plain English)

The client runs **BizJump**, an online business incorporation service. Right now their checkout is basic. They want to **completely revamp it** to work like the big players:

- **LegalZoom** (https://www.legalzoom.com/business/business-formation/)
- **ZenBusiness** (https://www.zenbusiness.com/)
- **Bizee** (https://bizee.com/)

The goal is a **guided, step-by-step wizard** where a user visits the site, picks what kind of business they want to form, selects a service package, adds optional extras, fills in their business info, and pays — all in one smooth flow.

---

## 🧩 Main Functionality the Client Needs

### 1. Guided Wizard Interface
A multi-step form/flow that walks users through the entire incorporation process. Not a single page — a step-by-step experience that feels professional and simple.

### 2. Four Service Tiers (Products)
The client wants 4 WooCommerce packages:
| Tier | Description |
|------|-------------|
| **Basic** | Entry-level formation |
| **Pro** | Mid-tier with more features |
| **Premium** | Higher-end services included |
| **Enterprise** | Full-service, top-tier |

Each tier has different included services, processing times, and prices.

### 3. Dynamic Pricing Logic
Prices must **automatically update** based on:
- Which **entity type** the user picks (LLC, C-Corp, S-Corp, Non-Profit)
- Which **US state** they're forming in (each state has different filing fees)
- What **add-on services** they select
- Whether they choose **subscription-based** services

### 4. Add-On Services (Optional Extras)
Users can add extra services on top of their base package. Each add-on dynamically updates the cart total. Examples of likely add-ons:
- Registered Agent (recurring annual subscription)
- Website Hosting (recurring)
- Compliance Monitoring (recurring)
- EIN Filing, Operating Agreement, etc.

### 5. Subscription / Recurring Billing
Some services are billed annually/monthly (not one-time):
- Registered Agent service
- Website hosting
- Compliance monitoring

These need **WooCommerce Subscriptions** to handle recurring payments.

### 6. WooCommerce Checkout with Multiple Payment Methods
- **Stripe** (credit/debit cards)
- **PayPal**
- **ACH** (bank transfer via Stripe)

### 7. Business Details Collection (Custom Checkout Fields)
After selecting services, users fill in:
- Company Name (with fallback if name is unavailable)
- Business Purpose
- Business Address
- Contact Person (First Name, Last Name, Email, Phone)
- Option to upload documents
- SMS/phone consent checkbox

### 8. Client Dashboard
After purchase, each customer gets a dashboard where they can:
- View order status
- Upload documents
- Track progress of their formation
- Download deliverables (e.g., formation documents)

### 9. Admin Order Management Panel
The BizJump team needs an admin view to:
- See all formation details per order
- Track which services were purchased
- Update order status
- Manage subscriptions

### 10. Post-Purchase Automation
After a user checks out:
- Automated confirmation email
- CRM record created (FluentCRM or Jetpack CRM)
- Order routed to admin for processing
- Subscription billing initiated (if applicable)

### 11. Legal & Compliance Pages
- Privacy Policy
- Terms of Service
- Refund Policy
- SSL Certificate
- Google reCAPTCHA

---

## 🛠️ Technology Stack the Client Specified

| Component | Tool/Plugin |
|-----------|-------------|
| Platform | WordPress |
| E-commerce Engine | WooCommerce |
| Wizard/Funnel Builder | CartFlows |
| Product Add-ons | WooCommerce Product Add-ons |
| Subscriptions | WooCommerce Subscriptions |
| Checkout Fields | Checkout Field Editor (WooCommerce) |
| CRM | FluentCRM or Jetpack CRM |
| Hosting | WP Engine / Kinsta / SiteGround |

---

## ✅ Are You Capable of This? (Honest Assessment)

**Short answer: YES — but only if you know WooCommerce well.**

Here's a breakdown of what each piece requires and how complex it is:

| Feature | Complexity | Your Skill Needed |
|---------|------------|-------------------|
| WooCommerce setup + products | Low–Medium | Basic WooCommerce |
| 4 service tiers as products | Low | Basic WooCommerce |
| CartFlows wizard/funnel | Medium | CartFlows plugin |
| Product Add-ons (dynamic pricing) | Medium–High | WooCommerce Add-ons plugin |
| State fee logic (conditional pricing) | High | Custom logic / ACF / plugin config |
| Subscriptions (recurring billing) | Medium | WooCommerce Subscriptions plugin |
| Custom checkout fields | Medium | Checkout Field Editor plugin |
| Stripe + PayPal + ACH | Medium | Payment gateway setup |
| Client dashboard | Medium–High | WooCommerce My Account customization |
| Admin order management | Medium | WooCommerce Orders + custom fields |
| FluentCRM integration | Medium | FluentCRM + WooCommerce automation |
| Post-purchase email automation | Medium | FluentCRM or WooCommerce emails |

**What makes this challenging:**
- The **dynamic state-based pricing** (50 states × entity types) requires careful setup — either via conditional logic in Product Add-ons or a custom-coded fee calculator
- The **client dashboard** will likely need customization of WooCommerce's My Account page
- **CartFlows** needs to be configured correctly to create the wizard experience

**What makes this achievable:**
- All the tools the client specified are real, well-supported plugins — no need to build from scratch
- WooCommerce + CartFlows is a proven combo for this type of flow
- If you've done WooCommerce before, the majority of this is plugin configuration, not custom coding

---

## 📝 Key Questions to Ask the Client

Before quoting or starting, clarify:

1. Do they have an existing WordPress/WooCommerce site or is it from scratch?
2. Do they already have the 4 service tiers defined with exact pricing?
3. Do they have a list of all 50 state filing fees ready?
4. Do they already own WooCommerce Subscriptions and other premium plugins?
5. What does their current checkout look like — what specifically is broken?
6. Do they need the client dashboard built, or do they just need WooCommerce's default My Account page?
7. What CRM do they prefer — FluentCRM or Jetpack CRM?
8. Do they need the site designed from scratch or just the checkout/wizard functionality?
9. Who handles the actual incorporation orders on their end?
10. Do they have a budget range in mind?

---

## 💰 Project Scope Summary

This is a **medium-to-large WooCommerce project**. It is NOT a simple store setup. Think of it as building a **SaaS-like onboarding flow on top of WooCommerce**. Realistic scope breakdown:

- **Small/Simple version** (basic wizard + 4 products + checkout fields + Stripe): ~20–35 hrs
- **Full version** (all features including subscriptions, CRM, dashboard, state pricing logic): ~60–100+ hrs

---

## 🔑 Bottom Line for Client

You are **fully capable** of delivering this on WooCommerce. The platform they've described is 80% plugin configuration and 20% customization. You don't need to build a custom app — everything they want exists as proven WooCommerce plugins. The hardest part is the dynamic state/entity pricing logic, but even that can be handled with WooCommerce Product Add-ons' conditional logic feature or a lightweight custom function.
