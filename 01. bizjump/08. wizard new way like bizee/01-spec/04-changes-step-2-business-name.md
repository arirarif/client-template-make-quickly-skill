# 04 — Step 2 (Business Name) — required changes

Source: `03. inc wiz p3 (1).docx` (also `00-extracted-source/03-page-3-business-name.txt`)

## 1. Field list (unchanged)

The four fields stay the same:
1. **What's the name of your business?** — text input (current `#biz-name`)
2. **Designator** — dropdown (current `#biz-designator`) → **NEEDS rules below**
3. **Business Purpose** — textarea, 100-char counter (current `#biz-purpose`)
4. **Tell us what industry your business is in?** — dropdown (current `#biz-naics`)

The docx shows a "11" near Business Purpose — that's almost certainly the legacy
char counter ("100 characters left" minus typed) or a typo. **Keep 100 chars** unless client confirms otherwise.

## 2. Entity-aware Designator dropdown

This is the only material change on this step.

Currently the dropdown is hard-coded to LLC options. The client provided the
official rules:

| Entity | Designator options |
|---|---|
| **LLC** | `LLC`, `LIMITED LIABILITY COMPANY` |
| **C-Corporation** | `INC`, `CORPORATION`, `INCORPORATED`, `CORP` |
| **S-Corporation** | `INC`, `CORPORATION`, `INCORPORATED`, `CORP` |
| **Nonprofit** | `INC`, `CORPORATION`, `INCORPORATED`, `CORP` |

→ Implementation: when Step 2 mounts (or on `state.entity` change), repopulate
the `#biz-designator` `<select>` from a lookup table.

```js
const DESIGNATORS = {
  'LLC':            ['LLC', 'LIMITED LIABILITY COMPANY'],
  'C-Corporation':  ['INC', 'CORPORATION', 'INCORPORATED', 'CORP'],
  'S-Corporation':  ['INC', 'CORPORATION', 'INCORPORATED', 'CORP'],
  'Nonprofit':      ['INC', 'CORPORATION', 'INCORPORATED', 'CORP'],
};
```

Default selection = first option. If user had already picked one and it's still
in the new list, keep it.

## 3. NAICS / industry dropdown

The docx says "Tell us what industry your business is in?" but provides **no
list**. Keep the current 10-option list (Professional, Food, Manufacturing,
Repair, Retail, Education, Health, Construction, Tech, Other) + the
"e.g. hair salon, accountant…" helper text.

**Open question (see file 11)**: should this be NAICS codes from a real list, or
keep this short stylized list?

## 4. Replace the FAQ block with the 4 client-supplied FAQs

The docx provides four long FAQs. Replace the current 3-FAQ "Additional Explanation" block:

### FAQ 1 — Are there any restrictions on Company Name Choice?

> Your company name must be distinguishable from other businesses already registered in your state. Certain words such as "doctor" may also require additional state approval or professional licensing.
>
> To help avoid delays:
> - Avoid names that are too similar to existing registered businesses
> - Do not include restricted words such as "Bank," "Insurance," or "University" unless properly authorized
> - Special characters and punctuation may be restricted in some states
>
> We recommend you have 2–3 alternative names in case your first choice is unavailable. We will reach out to you via email if first name is not approved.
>
> **Important Note:** Approval of a company name is determined solely by the state filing office. A name being available online or as a domain name does not guarantee state approval.

### FAQ 2 — What if my company name is unavailable?

> If your requested company name is unavailable, we will contact you to request an alternative name. Our team will continue working with you until a name is approved by the state.

### FAQ 3 — Does my company name need to end with "LLC" or "INC"?

> Yes. Most states require incorporated businesses to include a legal designator showing the type of entity. These designators help identify the legal structure of the business to the public and the state.
>
> Allowable endings include:
> - For C-Corp, S-Corp & Nonprofit Corporations: **INC, CORPORATION, INCORPORATED, CORP**
> - For LLCs: **LLC, LIMITED LIABILITY COMPANY**
>
> The most common designators are "LLC" for Limited Liability Companies and "INC" for Corporations.

### FAQ 4 — Why is the Business Purpose and Industry Needed?

> Your business purpose and industry classification help determine the correct type of business entity and filing requirements for your company. Certain industries are regulated and may require specialized entity structures, additional licenses, or state approvals before formation can be completed.
>
> For example:
> - Medical practices, legal firms, accounting firms, architects, and certain licensed professionals may need to form a **PLLC** (Professional Limited Liability Company) or **Professional Corporation** instead of a standard LLC or Corporation.
> - Non-profit organizations may require additional IRS and state filings.
> - Financial, insurance, transportation, healthcare, and childcare businesses may require special state licenses or regulatory approvals.
>
> Providing accurate business purpose information also helps ensure:
> - Your company is formed correctly from the beginning
> - The proper state documents are filed
> - Banking and tax setup is completed properly
> - You avoid delays or rejections from the Secretary of State
>
> If your business requires a specialized entity type or additional compliance steps, the BizJump team will help guide you through the process.

## 5. Sidebar pricing rows (from docx)

The docx shows a sample Order Summary for this step:
- Entity Type: LLC
- Standard package: $199 (likely a stale typo; live should pull from selected plan)
- NY State Filing Fee: $205
- Banking Resolution
- Operating Agreement
- EIN
- Tax ID #
- Electronic Delivery
- Total: 404

→ This matches the live sidebar conceptually. Make sure `renderSidebar()` already
shows: entity type, plan + price, state fee, plus any inline addons. **No code change** needed beyond the per-entity state-fee fix.

## 6. Acceptance criteria

- [ ] `#biz-designator` repopulates from `DESIGNATORS[state.entity]` on Step 2 mount.
- [ ] All 4 client FAQs are present, in order, in the "Additional Explanation" accordion.
- [ ] Business Purpose textarea remains capped at 100 chars with live counter.
- [ ] Sidebar pulls per-entity state fee.
