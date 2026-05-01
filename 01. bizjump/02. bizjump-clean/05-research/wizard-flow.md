# BizJump — Wizard Flow (Step-by-Step)

## The Full User Journey

```
[Land on Homepage]
       ↓
[Step 1 — Choose Entity Type]
  • LLC
  • C-Corporation
  • S-Corporation
  • Non-Profit Organization
       ↓
[Step 2 — Choose State of Formation]
  • Dropdown of all 50 US states
  • State fee automatically loaded from State_Filing_Fees.xlsx
  • Price shown updates live
       ↓
[Step 3 — Choose Service Tier]
  • Basic    — entry-level, base price
  • Pro      — mid-tier, more services
  • Premium  — higher-end, faster
  • Enterprise — full-service, priority
  • Pricing updates based on entity + state
       ↓
[Step 4 — Add-On Services]
  • Registered Agent (annual subscription)  +$XX/yr
  • Website Hosting (monthly/annual)        +$XX/mo
  • Compliance Monitoring (annual)          +$XX/yr
  • EIN Filing (one-time)                   +$XX
  • Operating Agreement (one-time)          +$XX
  • Each toggle = live cart total update
       ↓
[Step 5 — Business Details Form]
  • Company Name (preferred + fallback)
  • Business Purpose / Description
  • Business Address
  • Contact: First Name, Last Name, Email, Phone
  • Document Upload (optional)
  • SMS/Phone consent checkbox
       ↓
[Step 6 — Review & Checkout]
  • Order summary (entity, state, tier, add-ons)
  • State filing fee shown separately
  • Total price (one-time + recurring breakdown)
  • Payment options: Stripe / PayPal / ACH
       ↓
[Order Confirmed]
  • Confirmation email sent
  • FluentCRM record created
  • Order appears in BizJump admin
  • Subscriptions activated (if applicable)
       ↓
[Client Dashboard Access]
  • Order status tracker
  • Document upload portal
  • Download deliverables
  • Subscription management
```

---

## Dynamic Pricing Logic (How It Works)

```
Final Price = Base Tier Price
            + State Filing Fee (from State_Filing_Fees.xlsx)
            + Sum of selected Add-On prices
            + (if subscription: recurring charges shown separately)
```

### Entity Type affects:
- Base price may vary per tier
- Some states have different fees per entity type

### State Fee Source:
- File: `State_Filing_Fees.xlsx` (provided by client Apr 9)
- 50 states × multiple entity types
- Must be loaded into WooCommerce as conditional pricing rules
- Implementation: custom plugin or Product Add-ons conditional logic

---

## CartFlows Setup Plan

| Step | CartFlows Element | Notes |
|------|-------------------|-------|
| Landing page | Funnel landing page | Homepage with hero slider |
| Wizard steps | CartFlows steps (multi-step) | Steps 1–5 above |
| Checkout | CartFlows checkout page | WooCommerce integrated |
| Thank you | CartFlows thank you page | Order summary + next steps |

---

## Key UX Rules (match competitor sites)
- Progress bar visible at all times (Step X of 6)
- User can go BACK to previous steps
- Entity type + state selection must feel instant (no page reload)
- Price update must be live (AJAX or JS-based, not form submit)
- Mobile-first — all steps must work on phone
- Trust signals on every step (security badges, "As seen on..." etc.)
