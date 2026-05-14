# 02 — HTML baseline: what `index.html` currently does

This is the **map of the current prototype** so we know what we're editing.
The file is 1,469 lines. There's one wizard with 14 step screens.

## File layout

| Lines | Section |
|---|---|
| 1–243 | `<style>` — design tokens, buttons, layout, tables, sidebar, responsive |
| 247–297 | `#screen-home` — homepage hero with Entity + State picker + Start CTA |
| 300–315 | `.topbar` — logo + progress bar + phone |
| 318–405 | **Step 1** — Package selection (4 tiers + 14-row feature table + FAQ) |
| 408–467 | **Step 2** — Company Information (Name, Designator, Business Purpose, NAICS) |
| 470–504 | **Step 3** — State Filing Time (rush / standard radio cards) |
| 506–524 | **Step 12** — Order Summary Review |
| 526–578 | **Step 13** — Billing & Payment |
| 581–601 | **Step 14** — Confirmation |
| 604–657 | **Step 8** — EIN / Tax ID |
| 660–698 | **Step 9** — Small Business Banking (Relay) |
| 701–736 | **Step 10** — Tax Strategy / Free Consultation |
| 739–784 | **Step 11** — Business License Research |
| 787–838 | **Step 5** — Premium Service Bundle |
| 841–869 | **Step 6** — Members Information |
| 872–912 | **Step 7** — Registered Agent |
| 915–989 | **Step 4** — Company Address (Virtual + Contact in one card) |
| 991 | `</section>` end of wizard |
| 994–1466 | `<script>` — all wizard logic |

*Note: the DOM steps are not in numerical order — Step 4 is near the end of the
file. That's fine, since `setStep(n)` toggles `#step-N` regardless of DOM order.*

## Key JS objects (lines 994–1026)

```js
const STATES = { "Alabama": 100, "Alaska": 250, ..., "District of Columbia": 220 };  // FLAT — needs replacement
const PLANS = {
  basic:    { label:'Basic',    price: 99,  speed:'7-10 days' },
  pro:      { label:'Pro',      price: 195, speed:'5 days' },
  premium:  { label:'Premium',  price: 295, speed:'1 day rush' },
  enterprise:{ label:'Enterprise', price: 295, speed:'1 day rush', monthlyAddon: 29 }
};
const STATE_PROCESSING = { "Florida":"3 weeks", "Texas":"4 weeks", ... };

const state = {
  entity, stateName, stateFee, plan,
  inlineAddons:{}, filingTime,
  business:{ name, designator, purpose, naics },
  address:{ useVirtualAddress, contact:{...} },
  premiumBundle, members:[...], registeredAgent,
  ein:{...}, banking, taxConsultation, licenseResearch,
  consent:{...}, currentStep, totalSteps:13
};
```

## Step-by-step current behaviour

| # | DOM id | Title | Inputs / State written |
|---|---|---|---|
| 1 | `#step-1` | Package | `state.plan`, `state.inlineAddons` |
| 2 | `#step-2` | Company Information | `state.business.{name,designator,purpose,naics}` |
| 3 | `#step-3` | State Filing Time | `state.filingTime = { type, price }` (rush=$50, std=$0) |
| 4 | `#step-4` | Company Address | `state.address.useVirtualAddress`, `state.address.contact.*` (all fields) |
| 5 | `#step-5` | Premium Bundle | `state.premiumBundle` (or null) — auto-skipped if Premium/Enterprise plan |
| 6 | `#step-6` | Members | `state.members[]` (1–5) |
| 7 | `#step-7` | Registered Agent | `state.registeredAgent = 'bizjump' | 'own'` |
| 8 | `#step-8` | EIN | `state.ein.{isForeign,idType,idNumber,irsAddress}` |
| 9 | `#step-9` | Banking | `state.banking = 'yes' | 'ask_later'` |
| 10 | `#step-10` | Tax Consult | `state.taxConsultation` |
| 11 | `#step-11` | License Research | `state.licenseResearch` |
| 12 | `#step-12` | Order Review | renders `renderReview()` |
| 13 | `#step-13` | Billing & Payment | credit card + billing address |
| 14 | `#step-14` | Confirmation | `populateConfirmation()` |

## Navigation logic (`setStep` — line 1077)

```js
function setStep(n){
  state.currentStep = n;
  $$('.step').forEach(el=>el.classList.remove('active'));
  $('#step-'+n).classList.add('active');
  const pct = Math.min(100,(n/state.totalSteps)*100);
  $('#progress-fill').style.width = pct+'%';
  window.scrollTo(0,0);
  renderSidebar();
  populateStateSelects();
  if(n===3) setupFilingDates();
  if(n===5 && (state.plan?.id==='premium'||state.plan?.id==='enterprise')) nextStep();
  if(n===6) renderMembers();
  if(n===11) ...
  if(n===12) renderReview();
}
```

`nextStep`/`prevStep` just increment/decrement `state.currentStep`. Plain integer
progression — no skips except the Step-5 auto-advance.

## Sidebar (`renderSidebar` — line 1318)

Sticky right column on every step except Step 14. Each line is built conditionally
from `state.*`. Total at bottom = plan + state fee + inline addons + filing time +
premium bundle + license research. Other lines (RA, Banking, etc.) are shown as
"icon only" or "Free" indicators.

The sidebar is the **single source of truth for the customer's price**. Everywhere
else (Step 12 review, Step 14 confirmation) recomputes from `state.*` directly.

## What this baseline is missing vs. client docs

1. No per-entity state fee — `state.stateFee` is set once at hero submission from a flat lookup.
2. No conditional addon visibility by entity type.
3. Designator dropdown is hard-coded to LLC options only.
4. Contact + address are jammed together with Virtual Address on one screen.
5. No "Same as Contact person" prefill semantics.
6. State expedited fee is hardcoded $50 — xlsx has per-state values from $35 to $385.
7. Enterprise tier exists — client wants only 3 tiers.
