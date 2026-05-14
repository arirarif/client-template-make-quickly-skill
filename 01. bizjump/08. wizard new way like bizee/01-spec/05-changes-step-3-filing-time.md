# 05 — Step 3 (State Filing Time) — required changes

Source: `01. BizJump_50_State_Filing_Fees (1).xlsx` (also `00-extracted-source/01-state-fees.txt`)

## 1. The current behaviour

```html
<div class="radio-card" onclick="selectFilingTime(this,'rush',50)">
  ...
  <div class="radio-card-price">$50</div>
```

Hardcoded $50 expedited fee. Standard = $0. Estimated dates computed in JS.

## 2. The change

**Use per-state expedited fee** from the xlsx column "State Expedited Fee".

```js
const expedited = STATES[state.stateName].expedited;  // e.g. 60 for New York, 385 for California
```

Render:
```html
<div class="radio-card" data-type="expedited" data-price="${expedited}">
  ...
  <div class="radio-card-price">$${expedited}</div>
```

And on click:
```js
selectFilingTime(card, 'rush', expedited);
```

## 3. Range of values (sanity check)

From the xlsx, expedited fees per state span **$35 – $385**:
- Lowest: $35 (AR/IN/KS/MS/SD/TN/Wyoming…)
- Median: ~$70
- Highest: $385 (California)

## 4. Estimated date logic

No change needed. The existing `setupFilingDates()` adds 3 biz days for rush and
N weeks (parsed from `STATE_PROCESSING`) for standard. Keep as-is.

## 5. Acceptance criteria

- [ ] Expedited card price renders `$${STATES[state.stateName].expedited}`.
- [ ] `selectFilingTime` is called with that same dynamic value.
- [ ] Sidebar "Expedited Filing" line uses the per-state amount.
- [ ] Standard remains $0.
