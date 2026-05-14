# 06 — Step 3b (Contact) — NEW separate step

Source: `04. incwiz 3bcontact information (1).docx` + `client text.md`

## 1. Why this is its own step

In the current `index.html`, the contact-person fields are inside Step 4 below
the Virtual Address upsell. The client wants them **separated out**, captured
**before** the upsell, so that:

1. The contact-person info is gathered first ("This is who we'll contact if more info is needed during the filing process").
2. **Their address is reused 80% of the time** on Step 4 (business address), Step 13 (billing address), and any future "mailing address" page (per `client text.md`).

→ Insert a new screen between current Step 3 (Filing Time) and current Step 4
(Address). Call it **Step 3b** (internal id `#step-3b`) so we don't have to
renumber Steps 5–14 yet.

## 2. Layout (verbatim from docx)

```
┌────────────────────────────────────────────────────────────┐
│ Who is the main contact for this new business?             │
│ This is who we'll contact if more info is needed during    │
│ the filing process. This person could also be an owner     │
│ for the new business.                                       │
│                                                            │
│ [ First Name        ] [ Last Name           ]              │
│ [ Email             ] [ Mobile Phone (US+1) ]              │
│                                                            │
│ [ Street Address                                       ]   │
│ [ Address 2  (Optional)                                ]   │
│                                                            │
│ [ City        ] [ State      ] [ County  (Optional) ]      │
│                              [ Country (US default) ]      │
│ [ Zip Code                                              ]  │
│                                                            │
│ < Back                                       Next >        │
└────────────────────────────────────────────────────────────┘
```

(Sidebar continues to render on the right.)

## 3. State stored

```js
state.contact = {
  firstName: '',
  lastName:  '',
  email:     '',
  phone:     '',
  street1:   '',
  street2:   '',
  city:      '',
  state:     state.stateName,  // pre-default to formation state
  county:    '',
  country:   'US',
  zip:       ''
};
```

(Replaces / supersedes `state.address.contact.*`. Step 4 then reads from
`state.contact` when the "Same as Contact person" checkbox is ticked.)

## 4. Validation rules

| Field | Required | Notes |
|---|---|---|
| First Name | ✓ | |
| Last Name | ✓ | |
| Email | ✓ | basic email regex |
| Mobile Phone | ✓ | US +1, no strict format yet |
| Street Address | ✓ | |
| Address 2 | — | optional |
| City | ✓ | |
| State | ✓ | dropdown — defaults to formation state, but user can override |
| County | — | optional per docx |
| Country | ✓ | always US for v1 |
| Zip | ✓ | 5 or 9 digits |

`Next ›` button is disabled until First Name, Last Name, Email, Phone, Street,
City, State, Zip are filled.

## 5. Step navigation tweaks

| Was | Becomes |
|---|---|
| Step 3 `Next ›` → `setStep(4)` | Step 3 `Next ›` → `setStep('3b')` |
| Step 4 `Back ‹` → `setStep(3)` | Step 4 `Back ‹` → `setStep('3b')` |

Since steps are numeric in the existing code, easiest is to use `3.5` internally
or rename to `setStep('3b')` and add a tiny string-aware branch in `setStep()`.

Or: bump every downstream step number by 1 (3b becomes Step 4, old 4 becomes 5,
…, 14 becomes 15). Cleaner long-term but touches lots of `setStep(N)` calls.

→ **Recommendation**: bump downstream numbers (cleaner, less special-casing).

| Old step | New step | Title |
|---|---|---|
| 1 | 1 | Package |
| 2 | 2 | Business Name |
| 3 | 3 | Filing Time |
| — | **4 (new)** | **Contact** |
| 4 | 5 | Address / Virtual Address |
| 5 | 6 | Premium Bundle |
| 6 | 7 | Members |
| 7 | 8 | Registered Agent |
| 8 | 9 | EIN |
| 9 | 10 | Banking |
| 10 | 11 | Tax Consult |
| 11 | 12 | License |
| 12 | 13 | Review |
| 13 | 14 | Billing |
| 14 | 15 | Confirmation |

`state.totalSteps` changes from **13 → 14**.

## 6. Acceptance criteria

- [ ] `#step-4` (was contact-address sub-section) is a standalone step with the docx fields.
- [ ] All required fields enforced; Next disabled until valid.
- [ ] State dropdown defaults to formation state.
- [ ] `state.contact.*` is written on each blur/input.
- [ ] Back button → Step 3 (Filing Time); Next button → Step 5 (Address/Virtual Address).
- [ ] Progress bar denominator = 14.
