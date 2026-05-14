# 08 — State fees table

Source: `01. BizJump_50_State_Filing_Fees (1).xlsx` (also `00-extracted-source/01-state-fees.txt`)

## 1. Full data (50 states, 4 columns)

| State | LLC | Corporation | Non-Profit | Expedited |
|---|---:|---:|---:|---:|
| Alabama | 183 | 183 | 183 | 60 |
| Alaska | 250 | 250 | 50 | 85 |
| Arizona | 50 | 60 | 40 | 70 |
| Arkansas | 45 | 45 | 50 | 60 |
| California | 70 | 115 | 45 | 385 |
| Colorado | 50 | 50 | 50 | 60 |
| Connecticut | 185 | 315 | 165 | 85 |
| Delaware | 90 | 89 | 89 | 85 |
| Florida | 125 | 70 | 70 | 135 |
| Georgia | 100 | 100 | 100 | 135 |
| Hawaii | 51 | 51 | 26 | 60 |
| Idaho | 100 | 100 | 30 | 75 |
| Illinois | 150 | 180 | 55 | 135 |
| Indiana | 91 | 91 | 30 | 35 |
| Iowa | 50 | 50 | 20 | 85 |
| Kansas | 165 | 90 | 20 | 35 |
| Kentucky | 90 | 100 | 58 | 75 |
| Louisiana | 105 | 170 | 165 | 65 |
| Maine | 175 | 145 | 40 | 85 |
| Maryland | 125 | 145 | 195 | 85 |
| Massachusetts | 520 | 290 | 40 | 55 |
| Michigan | 60 | 50 | 20 | 85 |
| Minnesota | 155 | 155 | 90 | 85 |
| Mississippi | 52 | 52 | 52 | 35 |
| Missouri | 52 | 60 | 27 | 85 |
| Montana | 70 | 70 | 20 | 55 |
| Nebraska | 109 | 67 | 22 | 35 |
| Nevada | 75 | 75 | 50 | 160 |
| New Hampshire | 100 | 100 | 25 | 60 |
| New Jersey | 130 | 130 | 75 | 60 |
| New Mexico | 50 | 100 | 25 | 35 |
| New York | 200 | 125 | 75 | 60 |
| North Carolina | 127 | 127 | 62 | 135 |
| North Dakota | 135 | 100 | 40 | 85 |
| Ohio | 99 | 99 | 99 | 135 |
| Oklahoma | 104 | 50 | 25 | 60 |
| Oregon | 100 | 100 | 50 | 135 |
| Pennsylvania | 125 | 125 | 125 | 135 |
| Rhode Island | 156 | 238 | 37.5 | 85 |
| South Carolina | 110 | 235 | 25 | 35 |
| South Dakota | 150 | 150 | 30 | 35 |
| Tennessee | 309 | 105 | 100 | 35 |
| Texas | 300 | 300 | 25 | 60 |
| Utah | 76 | 76 | 36 | 110 |
| Vermont | 125 | 125 | 125 | 85 |
| Virginia | 103 | 77 | 75 | 135 |
| Washington | 180 | 180 | 30 | 85 |
| West Virginia | 100 | 100 | 25 | 60 |
| Wisconsin | 130 | 100 | 35 | 135 |
| Wyoming | 102 | 102 | 25 | 35 |

## 2. What's missing

**District of Columbia is NOT in the xlsx**. Current HTML has DC hardcoded to $220 (LLC).

Action: ask client. Until then, keep DC at $220 LLC / $220 Corp / $80 NonProfit / $50 Expedited as a working placeholder, flagged in code with a comment.

## 3. Mapping to entity values in the wizard

The wizard's entity dropdown is:
- `LLC` → xlsx column "LLC Filing Fee"
- `C-Corporation` → xlsx column "Corporation Filing Fee"
- `S-Corporation` → xlsx column "Corporation Filing Fee" (same as C-Corp filing-wise; the S-Corp election is a federal IRS thing, not a state filing)
- `Nonprofit` → xlsx column "Non-Profit Filing Fee"

Lookup function:
```js
function getStateFee(stateName, entity){
  const row = STATES[stateName];
  if(!row) return 0;
  if(entity === 'LLC')         return row.llc;
  if(entity === 'Nonprofit')   return row.nonprofit;
  // both C-Corp and S-Corp use the Corporation filing fee
  return row.corp;
}
function getExpeditedFee(stateName){
  return STATES[stateName]?.expedited ?? 50;
}
```

## 4. JS data shape

```js
const STATES = {
  'Alabama':       { llc:183, corp:183, nonprofit:183,  expedited: 60 },
  'Alaska':        { llc:250, corp:250, nonprofit: 50,  expedited: 85 },
  'Arizona':       { llc: 50, corp: 60, nonprofit: 40,  expedited: 70 },
  // ... 47 more from the table above ...
  'Wyoming':       { llc:102, corp:102, nonprofit: 25,  expedited: 35 },

  // PLACEHOLDER — confirm with client
  'District of Columbia': { llc:220, corp:220, nonprofit: 80, expedited: 50 }
};
```

## 5. Where this is used

| File / function | Use |
|---|---|
| `updateHeroFee()` | Display `getStateFee(state, entity)` under the hero |
| `startWizard()` | Capture per-entity fee into `state.stateFee` |
| Step 1 header | `+ ${getStateFee(state, entity)} state fee` chip |
| Step 1 row 1 | `+${getStateFee(state, entity)} state fees` cell per tier |
| Step 3 | `getExpeditedFee(state)` on the rush card |
| Sidebar | `${state.stateName} State Filing Fee` line |
| Step 12 review | Same as sidebar |
| Step 14 confirm | Same as sidebar |
