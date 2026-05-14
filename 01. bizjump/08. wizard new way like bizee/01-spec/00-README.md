# 01-spec — Wizard Changes (in-depth description)

This folder is the **complete written spec** for the next round of changes
to the wizard prototype in `08. wizard new way like bizee/index.html`.

The HTML prototype is good. The client sent **4 .docx files + 1 .xlsx + 1 .md text note**
asking for specific changes. This folder turns those source documents into a
precise, step-by-step build spec.

## Read this folder in order

| # | File | What it covers |
|---|---|---|
| 00 | 00-README.md | This index |
| 01 | 01-overview.md | High-level summary of every client change |
| 02 | 02-html-baseline-14-steps.md | What the current `index.html` does — all 14 steps mapped |
| 03 | 03-changes-step-1-package.md | Step 1 changes — 3 tiers, new addons, conditional visibility |
| 04 | 04-changes-step-2-business-name.md | Step 2 changes — designator rules, FAQs |
| 05 | 05-changes-step-3-filing-time.md | Step 3 changes — per-state expedited fee |
| 06 | 06-changes-step-3b-contact-new.md | NEW Step 3b — Contact + address |
| 07 | 07-changes-step-4-address-upsell.md | Step 4 changes — prefill from Step 3b |
| 08 | 08-state-fees-table.md | The 50-state fee xlsx, parsed |
| 09 | 09-data-models.md | New JS data structures (PLANS / ADDONS / STATES / DESIGNATORS) |
| 10 | 10-implementation-plan.md | Ordered build steps, one file per pass |
| 11 | 11-open-questions-for-client.md | 3 questions client must confirm before code lands |

## Source documents

- `../client text.md` — client's WhatsApp message (May 12, 6:25am + 6:27am)
- `../01. BizJump_50_State_Filing_Fees (1).xlsx` — state fee table
- `../02. inc wizard p2a (1).docx` — page 2 (package) layout + FAQ
- `../03. inc wiz p3 (1).docx` — page 3 (business name) fields + FAQs
- `../04. incwiz 3bcontact information (1).docx` — page 3b (contact + address)
- `../05. incwiz p4 upsell (1).docx` — page 4 (virtual address + same-as-contact)
- `../00-extracted-source/*.txt` — UTF-8 plain-text dumps of the above

## Build rules (carry forward from earlier sessions)

1. The HTML prototype is the design source of truth — keep its look-and-feel.
2. Tier count is **3** (Basic / Pro / Premium). Drop Enterprise everywhere.
3. State fees are **per (state, entity)** — not a single flat fee per state.
4. Expedited fees are **per state** (from the xlsx column 4).
5. Designator choices depend on entity type.
6. "Same as Contact person" must prefill the Step-4 contact address from Step-3b.
7. Don't build new pages outside this folder. Everything goes in `08. wizard new way like bizee/`.
