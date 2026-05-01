# 05 — Wizard Flow Spec (Final)

The complete spec for the step-by-step wizard on the Incorporation landing page.

---

## Overview

```
[Step 1] Entity Type
   ↓
[Step 2] State Selection (live state fee shown)
   ↓
[Step 3] Plan Selection (4 tiers, comparison table)
   ↓
[Step 4] Add-Ons (conditional based on entity + plan)
   ↓
[Step 5] Business Details (name + designator + address + contact person)
   ↓
[Step 6] Review & Checkout (push to WooCommerce checkout)
```

---

## Sticky Right Sidebar — Order Summary (visible from Step 2 onward)

```
┌─────────────────────────┐
│  Your Order             │
├─────────────────────────┤
│  Entity:    LLC         │
│  State:     Texas       │
│  Plan:      Pro         │
├─────────────────────────┤
│  BizJump Service  $195  │
│  Texas Filing Fee $300  │
│  EIN Filing       $30   │
│  Registered Agent $99/y │
├─────────────────────────┤
│  Total Today:    $624   │
│  Recurring:    $99/year │
└─────────────────────────┘
```

---

## Step-by-Step Detail

### Step 1 — Select Entity Type

**Layout:** 4 large clickable cards in a row (mobile: stacked)

| Card | What it says |
|---|---|
| **LLC** | "Most popular for small businesses. Personal liability protection with tax flexibility." |
| **C-Corp** | "Issue shares, raise capital, go public. Best for high-growth startups." |
| **S-Corp** | "Pass-through taxation with corporate structure. U.S. citizens/residents only." |
| **Non-Profit** | "501(c)(3) eligible. Tax-exempt structure for public benefit organizations." |

**+ "Other" link below cards** → opens a contact form for custom quote.

**On click:** Highlight selected card with blue border + checkmark, then auto-advance to Step 2.

---

### Step 2 — Select State

**Layout:** Big dropdown / searchable select with all 50 states + DC.

**Below the dropdown:** Dynamic fee box

```
┌──────────────────────────────────────┐
│  Texas state filing fee:  $300.00    │
│  (Added to your service fee)         │
└──────────────────────────────────────┘
```

**Note below:** "State filing fees are paid directly to the state and are non-refundable once submitted."

---

### Step 3 — Select Plan

**Layout:** Comparison TABLE (Bizee-style — far better than cards for 4 plans).

Columns: Basic | Pro | Premium ⭐ | Enterprise
Rows: Price, Processing Time, Features (with ✓ / —)

Each column header has a "Select" button.
Premium column has a "MOST POPULAR" ribbon.

**Mobile:** Collapse to stacked cards.

---

### Step 4 — Add-Ons

**Layout:** List of conditional add-ons with toggles.

Each add-on row:
```
┌──────────────────────────────────────────────────┐
│  ☐  Operating Agreement              + $35       │
│     Legal document defining ownership...         │
└──────────────────────────────────────────────────┘
```

- Show only the add-ons that match `showIf()` for current entity + plan
- Auto-select EIN if Pro/Premium/Enterprise (let user uncheck if they want)
- Group recurring (subscriptions) visually separate from one-time

**Add a "Skip add-ons" link below** for users who want to proceed without anything extra.

---

### Step 5 — Business Details

**Two sections in this step:**

#### 5A — Business Information

| Field | Type | Notes |
|---|---|---|
| Business Name | Text | Real-time preview below |
| Designator | Dropdown | Options change by entity (LLC/LIMITED LIABILITY COMPANY for LLC; INC/CORP/CORPORATION/INCORPORATED for C-Corp/S-Corp/Non-Profit) |
| Live preview | (display only) | "Your official company name will display as: **BIZJUMP INC**" |
| Business Purpose | Textarea | What does your business do? |
| Business Address | Address fields | Street, City, State, ZIP |

**Helper text below name field:**
> "What if my company name is unavailable? We will contact you with guidance in choosing other options."

#### 5B — Contact Person

> "Please provide the name of the person responsible for this order whom we may contact if additional information is needed."

| Field | Type |
|---|---|
| First Name | Text |
| Last Name | Text |
| Email | Email |
| Contact Address | Same as Business Address? (checkbox) — if unchecked, show address fields |
| Mobile Phone | Phone (US +1 prefix) |
| SMS Consent | Checkbox: "I consent to receiving SMS text messages and phone calls from BIZJUMP" |
| Document Upload | Optional — multiple files |

**Footer note:**
> "At this stage, we only require contact information for the person responsible for setting up the corporation. Depending on the selected service level, we may later request contact information for owners/shareholders, directors, and officers."

---

### Step 6 — Review & Checkout

**Layout:** Full summary of everything chosen + final CTA.

**Sections:**
1. Your Selections (read-only summary, with "Edit" links per section)
2. Pricing Breakdown:
   ```
   BizJump Pro Service           $195.00
   Texas State Filing Fee        $300.00
   EIN Filing                     $30.00
   Operating Agreement            $35.00
   ─────────────────────────────────────
   Total Due Today              $560.00

   Recurring (billed separately):
   Registered Agent              $99/year
   ```
3. Estimated Processing Time: "Your business will be filed within **5 business days** + Secretary of State processing time (1–14 days)."
4. **"Proceed to Secure Checkout →"** button (orange CTA)

**On click:** Push selected products + add-ons to WooCommerce cart via AJAX → redirect to `/checkout/`

---

## Progress Bar (Top of Wizard)

```
●━━━●━━━●━━━○━━━○━━━○
1   2   3   4   5   6
✓   ✓   active
```

- Completed steps: solid blue with checkmark
- Active step: highlighted
- Future steps: grey

Allow clicking back to any completed step to edit.

---

## Mobile Behavior

- All steps full-width
- Sticky order summary becomes a collapsible drawer at bottom
- Plan comparison table → stacked cards
- Progress bar → simple "Step 3 of 6" text + bar

---

## Validation Rules

| Step | Rule |
|---|---|
| 1 | Must select an entity |
| 2 | Must select a state |
| 3 | Must select a plan |
| 4 | No required selections (skip allowed) |
| 5 | Required: Business Name, Designator, Purpose, Address, First Name, Last Name, Email, Phone, SMS Consent |
| 6 | (display only — payment validation in WooCommerce checkout) |

---

## State to Persist Across Steps

```js
{
  entity: 'LLC',           // string
  state: 'Texas',          // string
  stateFee: 300.00,        // number
  plan: 'Pro',             // string
  planPrice: 195,          // number
  addons: ['ein','op_agreement','reg_agent'],  // array of IDs
  business: {
    name: 'BizJump',
    designator: 'INC',
    purpose: '...',
    address: { street, city, state, zip }
  },
  contact: {
    firstName, lastName, email, phone,
    sameAsBusinessAddress: true,
    smsConsent: true
  },
  documents: []  // file uploads
}
```
