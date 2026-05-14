# 01 — Overview (every client change in one place)

The current `index.html` is a 14-step wizard. The client sent edits for **steps 1, 2, 3 (filing time), 3b (new), and 4** plus a new state-fee table.

## TL;DR — what changes

| Step | What changes | Source |
|---|---|---|
| **Step 1 — Package** | 3 tiers only (drop Enterprise). New prices/speeds. Entire feature table replaced with the client's 16-row addon list grouped into 3 sections. Addon visibility depends on entity. New FAQ block (14 items). | `02. inc wizard p2a.docx` |
| **Step 2 — Business Name** | Same 4 fields kept. **Designator dropdown becomes entity-aware** (LLC choices vs. INC/CORP choices). FAQs replaced with the 4 long client-supplied FAQs. | `03. inc wiz p3.docx` |
| **Step 3 — Filing Time** | Expedited price is **per state**, pulled from xlsx column "State Expedited Fee" — not a hardcoded $50. | `01. BizJump_50_State_Filing_Fees.xlsx` |
| **Step 3b — Contact** | **NEW SEPARATE STEP** (currently embedded inside Step 4). Captures contact person + their address. This address is reused on Step 4 via "Same as Contact person" checkbox (80% case). | `04. incwiz 3bcontact information.docx` + client text.md |
| **Step 4 — Address + Virtual Address upsell** | Contact-address section at the bottom becomes a "Same as Contact person" checkbox that prefills (and disables) the fields from Step 3b. | `05. incwiz p4 upsell.docx` + client text.md |
| **State Fees data** | Replace flat `STATES = { state: fee }` with per-entity table: `STATES = { state: { llc, corp, nonprofit, expedited } }`. Use real numbers from xlsx. | xlsx |

## Why these changes (client's reasoning)

From `client text.md` (12 May, 6:25 am):
> "bizee collects only the contact information for the person forming the corp..
> i also collect the persons address..so down the road we can use it to populate
> other pages that ask for address as 80 percent of the time that will be the
> adress used..for example business address, billing address and mailing address"

From `client text.md` (12 May, 6:27 am):
> "The final items is the upselling pages where the bizee site offer these
> services along the way...i will edit those by tommorow..in the meantime
> you can just exactly what bizee has"

→ Translation:
1. Collect the **contact person + their address ONCE**, at Step 3b.
2. Auto-fill **business address, billing address, mailing address** from that 80% of the time, with a "Same as Contact person" toggle.
3. Steps 5–11 (upsells like Premium Bundle, Banking, Tax Consult, License Research) → **keep as-is**. Match bizee until further edits arrive.

## Steps that DO NOT change

- Step 5 — Premium Service Bundle ($99 upsell)
- Step 6 — Members Information
- Step 7 — Registered Agent
- Step 8 — EIN / Tax ID
- Step 9 — Small Business Banking (Relay)
- Step 10 — Tax Strategy Free Consultation
- Step 11 — Business License Research
- Step 12 — Order Summary Review
- Step 13 — Billing & Payment
- Step 14 — Confirmation

(Client said: "you can just exactly what bizee has" for upsells.)

## Cross-cutting changes

1. **Sidebar pricing math** must use `STATES[state][entity]` not `STATES[state]`.
2. **Designator** field is no longer fixed to "LLC" — it now depends on `state.entity`.
3. **Step renumbering** — current Step 4 ("Company Address") splits into:
   - Step 3b (new) — Contact
   - Step 4 (revised) — Company Address + Virtual Address (with prefill from 3b)
4. **Total step count** goes from 13 visible (14 incl. confirmation) → 14 visible (15 incl. confirmation). Progress bar denominator increments accordingly.
