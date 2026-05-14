# 10 — Implementation plan (ordered build steps)

The single editable file is `index.html`. To keep changes reviewable and avoid
the "one huge timed-out edit" pattern, work through the list below in **small
passes**, one task at a time, and commit / mark each pass complete before the
next.

## Pass 1 — Data layer (no UI changes yet)

**File**: `index.html` — `<script>` block.

1. Replace flat `STATES` const with the per-entity table from `09-data-models.md` §1.
2. Replace `PLANS` const with the 3-tier version from `09-data-models.md` §2.
3. Add `DESIGNATORS` const (§3) and `ADDONS` const (§4).
4. Update `state` shape (§5): add `state.contact`, `state.address.sameAsContact`, `state.expeditedFee`, bump `totalSteps:14`.
5. Add helpers `getStateFee`, `getExpeditedFee`, `refreshStateFee`, `applyDesignators`, `isAddonVisible` (§6).
6. Call `refreshStateFee()` from `updateHeroFee()` and `startWizard()`.

**Smoke test**: `getStateFee('New York', 'LLC') === 200`, `getStateFee('California', 'C-Corporation') === 115`, `getExpeditedFee('California') === 385`.

## Pass 2 — Step 1 (Package): drop Enterprise

**File**: `index.html` — Step 1 markup (lines 318–405) + `selectPlan` JS.

1. Remove the 4th `pkg-header-cell` (Enterprise).
2. Remove the 4th cell in every `pkg-row` (Enterprise column).
3. Remove the 4th `pkg-footer-cell`.
4. Change grid `1.2fr 1fr 1fr 1fr 1fr` → `1.2fr 1fr 1fr 1fr`.
5. Update Premium price `$295 → $395`, speed `1 day rush → 24 hours`.
6. Update Basic speed `7-10 days → 7 days`, Pro speed `5 days → 2 days`.
7. Remove the `if(state.plan?.id==='enterprise')` skip in `setStep(5)`.

**Smoke test**: page loads, 3-column table, Premium shows $395 / 24 hours.

## Pass 3 — Step 1 (Package): replace feature rows with ADDONS data

**File**: `index.html` — replace the static `pkg-row` blocks (lines 367–385) with a dynamic renderer.

1. Add `renderPackageRows()` JS function — iterates `ADDONS`, groups by `section`, filters with `isAddonVisible`, renders a section header + one `pkg-row` per item.
2. For each addon row, the per-tier cell renders:
   - `'included'`  → `<span class="pkg-check">✓</span>`
   - `'free+29mo'` → `<span class="pkg-add">Free setup + $29/mo</span>` (non-clickable info chip)
   - `'99/year'`   → `<span class="pkg-add">+$99/year</span>` (display only — RA bundled with Step 7)
   - integer       → `<button class="pkg-add" onclick="toggleInlineAddon(this,'<id>',<price>)">+$<price></button>`
3. Call `renderPackageRows()` from `setStep(1)` so it re-renders when entity changes.
4. Update the FAQ accordion under the table with the 14 client FAQs (`03-changes-step-1-package.md` §6).

**Smoke test**: switch entity LLC ↔ S-Corp on the hero and see Operating Agreement vs Shareholder Agreement / Form 2553 toggle visibility.

## Pass 4 — Step 2 (Business Name): designator rules + FAQ swap

**File**: `index.html` — Step 2 markup + new function.

1. Strip the hard-coded `<option>` list in `#biz-designator`.
2. Call `applyDesignators()` from `setStep(2)` (also on initial load).
3. Replace the 3 existing FAQs in the Step 2 accordion with the 4 client FAQs (`04-changes-step-2-business-name.md` §4).

**Smoke test**: pick S-Corp on hero → Step 2 designator dropdown shows INC/CORP/etc., not LLC.

## Pass 5 — Step 3 (Filing Time): per-state expedited fee

**File**: `index.html` — Step 3 markup + `setupFilingDates`.

1. Change the rush radio card to render `${state.expeditedFee}` instead of hardcoded `$50` (both the visible price and the `onclick="selectFilingTime(this,'rush',50)"` argument).
2. Have `setupFilingDates()` rewrite the price text from `state.expeditedFee` each time it runs.

**Smoke test**: pick California on hero → Step 3 rush card shows $385. Pick Wyoming → $35.

## Pass 6 — Step 3b (Contact): new screen

**File**: `index.html`.

1. Insert new `<div id="step-4" class="step">…</div>` block with markup from `06-changes-step-3b-contact-new.md` §2.
2. Inputs all write to `state.contact.*` on `oninput`.
3. Add `validateContact()` JS helper that toggles the Next button's `disabled` attribute based on required fields.
4. Renumber every downstream step's id and `setStep()` argument (`#step-4` → `#step-5`, etc., up to `#step-14` → `#step-15`).
5. Bump `state.totalSteps = 14` (already done in Pass 1).
6. Update progress-bar denominator accordingly.

**Smoke test**: full happy path — homepage → Step 1 → 2 → 3 → 3b (new) → 5 → ... → 14 confirmation. Required-field validation gates `Next ›`.

## Pass 7 — Step 5 (Address): "Same as Contact" prefill

**File**: `index.html` — Step 5 markup + new JS.

1. Replace the existing Contact Address fields markup with the checkbox + disabled-by-default fields layout from `07-changes-step-4-address-upsell.md` §2.
2. Add `toggleSameAsContact()` function (see §2 sample).
3. On mount, default `state.address.sameAsContact = true` and disable the inputs.
4. When the checkbox is unticked, enable inputs and clear `state.address.*` to whatever the user types.
5. Wire Step 13 (Billing) — billing address should also offer a "Same as Contact person" affordance (out of scope for this pass; capture as follow-up).

**Smoke test**: enter contact info on Step 3b, advance to Step 5, see all fields filled in and disabled. Untick checkbox → fields enable and clear/edit-ready.

## Pass 8 — Sidebar + Review + Confirmation: use per-entity state fee

**File**: `index.html` — `renderSidebar`, `renderReview`, `populateConfirmation`.

1. Replace every reference to the literal `state.stateFee` with the freshly computed value via `refreshStateFee()` (call once at the top of each renderer).
2. Audit each addon line — wire to the same `ADDONS` data so per-entity logic is consistent.

**Smoke test**: change entity mid-wizard via Back → Step 1, pick C-Corp instead. Sidebar updates to show the Corp state fee, not the LLC fee.

## Pass 9 — QA pass (manual checklist)

- [ ] Hero → entity LLC → state Florida → state fee shows $125 (was $87.50)
- [ ] Hero → entity Nonprofit → state California → state fee shows $45
- [ ] Step 1 has 3 columns, Premium = $395 / 24 hours
- [ ] Step 1 LLC entity: shows Operating Agreement row, NOT Shareholder Agreement
- [ ] Step 1 S-Corp entity: shows Shareholder Agreement + Form 2553 rows
- [ ] Step 1 Nonprofit entity: shows IRS 501(c)(3) row
- [ ] Step 1 FAQ has 14 questions
- [ ] Step 2 designator dropdown changes options when entity changes
- [ ] Step 2 FAQ has 4 long client questions
- [ ] Step 3 expedited fee = California $385 / Wyoming $35
- [ ] Step 3b (new) collects all 10 fields
- [ ] Step 5 contact-address checkbox prefills and disables
- [ ] Sidebar total matches Review total matches Confirmation total
- [ ] Progress bar reaches 100% on Step 14

## Pass 10 — Polish + commit

- [ ] Re-test on mobile width (responsive grid stacks)
- [ ] Bump a version string somewhere visible if the client tracks releases
- [ ] Commit with message: `feat(wizard): per-entity state fees, 3-tier packages, new Contact step, prefill addresses`
