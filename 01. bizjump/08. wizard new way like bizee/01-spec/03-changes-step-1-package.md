# 03 — Step 1 (Package) — required changes

Source: `02. inc wizard p2a (1).docx` (also `00-extracted-source/02-page-2a-package.txt`)

## 1. Drop Enterprise tier

Current: 4 tiers (Basic, Pro, Premium, Enterprise).
Client: **3 tiers only**.

Remove Enterprise from `PLANS`, the `pkg-header`, all `pkg-row` 4th cells, and `pkg-footer`. The grid drops from `1.2fr 1fr 1fr 1fr 1fr` (5 cols) to `1.2fr 1fr 1fr 1fr` (4 cols).

## 2. New tier prices + speeds

| Tier | Price | Speed |
|---|---|---|
| Basic | $99 | **7 days** |
| Pro | $195 | **2 days** |
| Premium | **$395** | **24 hours** |

(Currently: $99 / $195 / $295. Speeds: 7–10d / 5d / 1d rush.)

`PLANS` becomes:
```js
const PLANS = {
  basic:   { label:'Basic',   price: 99,  speed:'7 days'    },
  pro:     { label:'Pro',     price: 195, speed:'2 days'    },
  premium: { label:'Premium', price: 395, speed:'24 hours'  }
};
```

## 3. Replace the whole feature table with the client's addon list

The current 14 hard-coded `pkg-row` blocks (LLC Filing, RA, Online Access Dashboard,
etc.) go away. They get replaced by the **16-row client addon list**, grouped into
3 visible sections.

### Row 1 — "Always included" header row (mandatory)

| Feature | Basic | Pro | Premium |
|---|---|---|---|
| Prepare & File Articles of Organization/Incorporation 🅘 | +$205 state fees / 7 days / ✔️ | +$205 state fees / 2 days / ✔️ | +$205 state fees / 24 hours / ✔️ |

(The "+$205" is just the New York example from the docx. In the live wizard the
state-fee chip pulls from `STATES[state][entity]`.)

### Section A — Corporate Add-Ons + Compliance

| # | Item | Basic | Pro | Premium | Entity gate |
|---|---|---|---|---|---|
| A1 | Bizjump Expedited Filing 🅘 | +$25 | ✔️ included | ✔️ included | all |
| A2 | EIN Business Tax Number 🅘 | +$75 | ✔️ included | ✔️ included | all |
| A3 | Registered Agent Service 🅘 | +$99/year | +$99/year | ✔️ included | all (1st year free if Premium) |
| A4 | Compliance Alerts 🅘 | +$75 | ✔️ included | ✔️ included | all |
| A5 | Executive Corporate Kit 🅘 | +$125 | +$125 | +$75 | all |
| A6 | Corporate Bylaws 🅘 | +$75 | +$75 | ✔️ included | **C-Corp / S-Corp only** |
| A7 | Operating Agreement 🅘 | +$75 | +$75 | ✔️ included | **LLC only** |
| A8 | Shareholder Agreement 🅘 | +$75 | +$75 | ✔️ included | **C-Corp / S-Corp only** |
| A9 | Business Bank Account Setup 🅘 | +$150 | +$150 | +$150 | all |

### Section B — BUSINESS AND TAXES

| # | Item | Basic | Pro | Premium | Entity gate |
|---|---|---|---|---|---|
| B1 | IRS Form 2553 (S-Corp Election) 🅘 | +$75 | +$75 | +$75 | **S-Corp only** |
| B2 | IRS EZ-501(c)(3) Tax-Exempt Filing 🅘 | +$395 | +$395 | +$395 | **Nonprofit only** |
| B3 | First Year Tax Filing (CPA) 🅘 | +$200 | +$200 | +$200 | all |
| B4 | Business Plan Consultation 🅘 | +$175 | +$175 | +$175 | all |
| B5 | Accounting System Setup & Tax Planning 🅘 | +$125 | +$125 | ✔️ included | all |

### Section C — WEBSITE & MARKETING

| # | Item | Basic | Pro | Premium | Entity gate |
|---|---|---|---|---|---|
| C1 | Basic Corporate Website 🅘 | Free setup + $29/month | Free setup + $29/month | Free setup + $29/month | all |
| C2 | Social Media Marketing Setup 🅘 | +$125 | +$125 | +$125 | all |
| C3 | Google Business Profile Setup 🅘 | +$125 | +$125 | +$125 | all |

## 4. Entity-conditional visibility

When `state.entity` is set on the homepage hero, **before rendering the table**, hide rows whose `entity_gate` does not include the entity.

```js
const ADDON_VISIBILITY = {
  A6: ['C-Corporation','S-Corporation'],
  A7: ['LLC'],
  A8: ['C-Corporation','S-Corporation'],
  B1: ['S-Corporation'],
  B2: ['Nonprofit'],
  // all others: visible for all
};
```

## 5. Single state-fee chip (not per-tier)

Current header shows "+ $87.50 state fee" three times (once under each price).
That's fine — the SAME state fee applies to every tier. Just make sure it pulls
from `STATES[state.stateName][state.entity]`.

For the per-row "+$205 state fees" cells in row 1 of the table: this is the same
value, just shown once per tier column.

## 6. New FAQ block (replaces existing 4-FAQ accordion)

The client supplied **14 FAQs** for the bottom of Step 1. Verbatim from docx:

1. **What is included in the formation package?** — All packages include the essentials needed to legally form your business: preparation and filing of your formation documents, business name verification, digital delivery of approved documents, filing status updates, and secure client portal access. Our higher-tier packages — Pro and Premium — also include additional services such as EIN filing and other startup support services, bundled at significantly lower pricing than purchased separately. Of course, clients may also select additional services within any package based on their specific business needs.
2. **Which package should I choose?**
   - Basic — Ideal for experienced founders who only need business formation services and can handle the remaining setup steps themselves.
   - Pro — Best for busy entrepreneurs who want additional setup support while still managing a few tasks independently.
   - Premium — Designed for founders who want a more complete setup experience with expedited processing and broader hands-on support from our team.
3. **Why are state fees separate?** — State filing fees are government charges paid directly to the Secretary of State. These fees vary by state and entity type and are not included in BizJump's service fees.
4. **Do I need an EIN?** — Almost all businesses require an EIN to open a business bank account, hire employees, process payroll, or file taxes.
5. **What is a Registered Agent?** — A Registered Agent receives legal notices and official government correspondence on behalf of your business.
6. **Do I need a Registered Agent?** — Most states legally require it. You may act as your own RA using your business address; using your home creates privacy concerns.
7. **What are Compliance Alerts?** — Reminders about annual reports, filing deadlines, and Secretary of State compliance requirements.
8. **How fast is filing?** — Varies by package and Secretary of State speed. Some states also charge $50–$100+ expedited fees.
9. **Can BizJump guarantee state approval?** — No. Final approval is determined by the Secretary of State; if your name is unavailable we work with you on an alternative.
10. **Do I need a business bank account?** — Yes — separating personal/business finances is strongly recommended.
11. **Can BizJump help with taxes?** — Yes — CPA-supported tax filing, accounting setup, bookkeeping, tax planning.
12. **Can you help set up my website and social media?** — Yes — website + hosting, Google Business Profile, social account setup.
13. **Are monthly fees refundable?** — Subscriptions cancellable per terms; government filing fees are non-refundable once submitted.
14. **Is BizJump a law firm?** — No — not a law firm, no legal advice.

## 7. Header tagline

The docx header reads:
> "bizjump — Led by Real Small Business Experts Since 1998"

Current hero says "Since 2020".
**Open question (see file 11)**: confirm 2020 vs. 1998.

## 8. Acceptance criteria

- [ ] `PLANS` has exactly 3 entries (basic / pro / premium) with prices 99/195/395 and speeds 7d / 2d / 24h.
- [ ] `pkg-header` grid is 4 columns (label + 3 tiers).
- [ ] Table rows are the 16 client-listed addons grouped into 3 visible sections.
- [ ] Entity-gated rows are hidden when entity is set on the hero.
- [ ] Each tier's footer "Get Started" button still calls `selectPlan(planId)`.
- [ ] FAQ block under the table contains the 14 client FAQs.
- [ ] State fee chip reads from `STATES[state.stateName][state.entity]`.
