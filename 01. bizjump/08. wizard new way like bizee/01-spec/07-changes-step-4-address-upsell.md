# 07 — Step 4/5 (Company Address + Virtual Address) — required changes

Source: `05. incwiz p4 upsell (1).docx` + `client text.md`

After the renumber from spec 06, this is the **new Step 5**. We keep
referring to it as "Step 4" in headings below for continuity with the
docx filenames.

## 1. What stays the same

- Card title: "Company Address Information"
- Lede: "Formation documents are often publicly available and may include
  business or owner addresses. Many businesses choose to use a virtual address
  service for privacy."
- Virtual Address sub-card — pricing, badges, feature bullets, USPS Form 1583
  info box. All unchanged.
- Two radio cards: "Use Virtual Address" / "I'll use my own address"

## 2. What changes — the "Same as Contact person" pattern

The current page has 9 raw fields (First, Last, Email, Phone, Country, Street,
Address 2, City, State, Zip) directly editable. Client wants:

1. A **checkbox at the top of the Contact Address section**: "☐ Same as Contact person"
2. **Default: checked** (since 80% of users will reuse the contact address).
3. While checked: all fields are **pre-filled from `state.contact.*`** AND **disabled** (greyed out).
4. While unchecked: fields enable and the user can type a different address.

### Markup sketch

```html
<h3 class="bjw-card-h2">Contact Address</h3>

<label class="bjw-checkbox-row">
  <input type="checkbox" id="same-as-contact" checked
         onchange="toggleSameAsContact(this.checked)">
  <span>Same as Contact person</span>
</label>

<p class="bjw-card-intro-sm">
  Please provide the address of the person whom we may contact for State, IRS, or
  legal correspondence relating to your business.
</p>

<div id="company-addr-fields">
  <!-- First Name / Last Name / Email / Phone / Country / Street1 / Street2 / City / State / Zip -->
  <!-- All inputs have `disabled` attribute when checkbox is checked -->
</div>
```

### Behaviour

```js
function toggleSameAsContact(checked){
  state.address.sameAsContact = checked;
  const root = document.querySelector('#company-addr-fields');
  root.querySelectorAll('input, select').forEach(el => el.disabled = checked);

  if(checked){
    // copy from state.contact.* into the field values AND state.address.*
    Object.assign(state.address, {
      firstName: state.contact.firstName,
      lastName:  state.contact.lastName,
      email:     state.contact.email,
      phone:     state.contact.phone,
      street1:   state.contact.street1,
      street2:   state.contact.street2,
      city:      state.contact.city,
      state:     state.contact.state,
      zip:       state.contact.zip,
      country:   state.contact.country,
    });
    syncFieldsFromAddress();   // reflect into the inputs
  }
}
```

## 3. State shape

```js
state.address = {
  useVirtualAddress: true,   // existing
  sameAsContact:     true,   // NEW — default true
  firstName, lastName, email, phone,
  street1, street2, city, state, zip, country
};
```

(`state.address.contact.*` from the old code is dropped — use top-level
`state.contact.*` instead, written in Step 3b.)

## 4. The "State Expedited Filing" header row in the docx

The docx file starts with a row labelled "State Expedited Filing" (R0 in the
extracted table). That's actually just a **header label for the whole upsell
block**, not a separate field. The expedited filing decision was already made on
Step 3. **No new control needed here** — confirm with client if uncertain.

(See file 11 — open question on whether the docx intends Step 3 and Step 4 to be
merged. Default: keep separate, as the prototype already has them.)

## 5. Acceptance criteria

- [ ] Virtual Address sub-card unchanged (still default selected, $29/mo after 1st free month).
- [ ] "Same as Contact person" checkbox appears at top of Contact Address section.
- [ ] Default checked → fields disabled, pre-filled from `state.contact.*`.
- [ ] Unchecking enables fields and allows independent address entry.
- [ ] `state.address.sameAsContact` is read by Step 13 (Billing) and Step 12 (Review) so they can also reuse the same address.
