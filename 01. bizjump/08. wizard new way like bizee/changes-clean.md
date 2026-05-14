# Client Changes — Step 1 Package Page (clean spec)

Source: `changes.md` (raw paste from client doc) + screenshot `Screenshot_287.png`.
Decoded into structured spec on 2026-05-15.

---

## 1. Page header

| Field | Value |
|---|---|
| Brand | `bizjump` |
| Tagline | `Led by Real Small Business Experts Since 1998` |
| Page H1 | `Select your Formation Package` |
| Page H2 | `(One time formation fee)` |
| Page H3 | `You can also choose additional services as needed` |

Context strip below header (from hero):
- Entity Type: `<value>` (e.g. LLC)
- State: `<value>` (e.g. New York)

⚠️ **Open Q3 from spec/11**: 1998 vs 2020. Current homepage hero says 2020 — client doc says 1998. **Decision needed before publishing.**

---

## 2. Pricing tiers (no Enterprise)

| Tier | Price | Filing speed |
|---|---|---|
| Basic | $99 | 7 days |
| Pro | $195 | 2 days |
| **Premium ★** (Recommended) | $395 | 24 hours |

All tiers + `+$<state-fee>` (per-entity per-state, looked up from `BJW_State_Fees`).

---

## 3. First row — "Prepare & File Articles"

The first row is always-included for every tier and has rich content:

**Title cell (left column):**
- Bold: `Prepare & File Articles of Organization/Incorporation 🅘`
- Sub: `The official document filed with the state to legally create your business entity.`
- Heading: **What you receive:**
- Bullet list:
  - Digital Document Delivery of your approved state formation documents
  - Statement of Organizer/Incorporator
  - Business Name Availability Search and Verification
  - Email Support During Formation Process
  - Filing Status Updates
  - Secure Online Client Portal Access

**Per-tier cells (3 columns):**
- `+$<state-fee> state fees` (e.g. `+$205 state fees` for NY)
- speed chip (`7 days` / `2 days` / `24 hours`)
- `✔️` checkmark

🔧 **Delta vs current plugin:** plugin currently shows only state-fee + speed + ✓ — missing the title + bullet list. Need to add to the always-included filing row in `renderPackageRows()` (or `pkg-row-filing` markup in template).

---

## 4. Section A — Corporate Add-Ons + Compliance

| # | Addon | Basic | Pro | Premium | Entity gate |
|---|---|---|---|---|---|
| A1 | Bizjump Expedited Filing 🅘 | +$25 | ✔️ | ✔️ | all |
| A2 | EIN Business Tax Number 🅘 | +$75 | ✔️ | ✔️ | all |
| A3 | Registered Agent Service 🅘 | +$99/year | +$99/year | ✔️ | all (1st yr free on Premium) |
| A4 | Compliance Alerts 🅘 | +$75 | ✔️ | ✔️ | all |
| A5 | Executive Corporate Kit 🅘 | +$125 | +$125 | +$75 | all |
| A6 | Corporate Bylaws 🅘 | +$75 | +$75 | ✔️ | **C-Corp / S-Corp** |
| A7 | Operating Agreement 🅘 | +$75 | +$75 | ✔️ | **LLC** |
| A8 | Shareholder Agreement 🅘 | +$75 | +$75 | ✔️ | **C-Corp / S-Corp** |
| A9 | Business Bank Account Setup 🅘 | +$150 | +$150 | +$150 | all |

✅ Matches `data-addons.php`.

---

## 5. Section B — Business and Taxes

| # | Addon | Basic | Pro | Premium | Entity gate |
|---|---|---|---|---|---|
| B1 | IRS Form 2553 (S-Corp Election) 🅘 | +$75 | +$75 | +$75 | **S-Corp only** |
| B2 | IRS EZ-501(c)(3) Tax-Exempt Filing 🅘 | +$395 | +$395 | +$395 | **Nonprofit only** |
| B3 | First Year Tax Filing (CPA) 🅘 | +$200 | +$200 | +$200 | all |
| B4 | Business Plan Consultation 🅘 | +$175 | +$175 | +$175 | all |
| B5 | Accounting System Setup & Tax Planning 🅘 | +$125 | +$125 | ✔️ | all |

✅ Matches `data-addons.php`.

---

## 6. Section C — Website & Marketing

| # | Addon | Basic | Pro | Premium | Entity gate |
|---|---|---|---|---|---|
| C1 | Basic Corporate Website 🅘 | Free setup + $29/mo | Free setup + $29/mo | Free setup + $29/mo | all |
| C2 | Social Media Marketing Setup 🅘 | +$125 | +$125 | +$125 | all |
| C3 | Google Business Profile Setup 🅘 | +$125 | +$125 | +$125 | all |

✅ Matches `data-addons.php`.

---

## 7. Order Summary sidebar (right column)

Live render based on current selection. Example (Basic + NY):

```
Order Summary
─────────────
Basic package:           $99
New York state fee:     $205
─────────────
Total:                  $355

[ Continue ]
```

Rules:
- Sidebar updates instantly when user picks a tier or toggles an addon
- State fee always shown (pulled from `getStateFee(stateName, entity)`)
- Total = plan price + state fee + addons + expedited (if rush)

✅ Already implemented in `renderSidebar()`.

---

## 8. FAQ block — 14 items (verbatim from client)

| # | Question |
|---|---|
| 1 | What is included in the formation package? |
| 2 | Which package should I choose? |
| 3 | Why are state fees separate? |
| 4 | Do I need an EIN? |
| 5 | What is a Registered Agent? |
| 6 | Do I need a Registered Agent? |
| 7 | What are Compliance Alerts? |
| 8 | How fast is filing? |
| 9 | Can BizJump guarantee state approval? |
| 10 | Do I need a business bank account? |
| 11 | Can BizJump help with taxes? |
| 12 | Can you help set up my website and social media? |
| 13 | Are monthly fees refundable? |
| 14 | Is BizJump a law firm? |

Full answer copy in `changes.md` lines 82–112. Verbatim already loaded into `templates/wizard.php` Step 1 accordion.

✅ Already in plugin.

---

## 9. 🅘 icon — info popups

Every addon row has an 🅘 (info icon) next to the title. Hover/tap → reveals the long description currently stored in the addon's `desc` field.

**Status:** plugin currently renders desc text inline under the label via `feat-sub` truncation. Spec wants it **hidden behind the icon, popover on click** (per client note: "see bizee.com" — bizee uses tooltip-style popovers).

🔧 **Delta:** swap inline `feat-sub` for an icon + popover (or click-toggle accordion). Lightweight CSS `:hover` + `:focus` works.

---

## 10. Delta summary (what plugin still needs)

| # | Change | File to edit | Effort |
|---|---|---|---|
| 1 | Add "What you receive" bullet list to filing row | `assets/wizard.js` → `renderPackageRows()` (the `pkg-row-filing` block) | small |
| 2 | Change tagline `Since 2020` → `Since 1998` (after client confirms) | `templates/wizard.php` hero + Step 1 banner | trivial |
| 3 | 🅘 popover behaviour (replace inline truncated desc) | `assets/wizard.js` + `assets/wizard.css` | medium |
| 4 | Confirm DC fees with client (Q1) | `includes/data-state-fees.php` (overrides via admin UI) | n/a — waiting on client |
| 5 | Confirm NAICS list scope (Q4) | `templates/wizard.php` Step 2 markup | small once confirmed |

✅ Everything else from this doc matches plugin state.

---

## 11. Open questions still pending

From `01-spec/11-open-questions-for-client.md`:

- **Q1** DC fees — placeholder used, awaiting confirmation
- **Q2** "Business Purpose / / 11" typo — kept 100-char cap as default
- **Q3** Since 1998 vs Since 2020 — **needs answer now** (this doc says 1998)
- **Q4** NAICS list — short stylized list vs full ~150-item NAICS
- **Q5** Premium "Recommended" badge — kept (matches client doc + bizee)
- **Q6** Step 3/4 merger — kept separate (default)
