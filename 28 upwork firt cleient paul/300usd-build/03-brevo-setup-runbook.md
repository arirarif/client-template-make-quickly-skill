# 03 — Brevo setup runbook (BNB first, then Express and DVPFL)

One account. Three lists. Owner = **Paul's email**, me added as a user — his asset, not mine.
Free tier: unlimited contacts, 300 emails/day. A list of a few hundred sends in one day.

Blocked until Paul names the owner email (ask 3 in `01-message-to-paul-3-asks.md`).
Everything below is written so it can be executed in one sitting once that lands.

---

## Step 1 — Account and lists

1. Create the Brevo account under Paul's email. Verify it from his inbox.
2. Add me as a user (Settings → Users).
3. **Sender:** add and verify Paul's sending address. Until a sender is verified, nothing
   sends — this is the step people forget and then blame the platform.
4. Create three lists, exact names:

   | List | Audience | Site |
   |---|---|---|
   | `bnb-hosts` | Airbnb hosts, property managers | bnbphotos.com |
   | `express-agents` | Listing agents, brokerages | expressrealestatephotos.com |
   | `dvpfl-couples` | Engaged couples | dvpfl.com |

**Why one account, not three:** Paul logs into one place, and a future "all past clients"
campaign across brands stays possible. Three accounts would make that impossible without
export/import.

---

## Step 2 — BNB first: the form endpoint

1. Brevo → Contacts → Forms → **create a form** targeting `bnb-hosts`.
2. Set the confirmation behaviour to **redirect to a URL**: `https://www.bnbphotos.com/thank-you/`
3. Copy the form's **action URL** (looks like `https://sibforms.com/serve/MUIF...`).
4. Open `02-signup-form-bnb.html`, replace `FORM_ACTION_URL` with that action.
   Replace **both** occurrences? No — only the one inside the `<form>` tag. The other is in
   the comment header and is documentation.
5. Confirm the field names Brevo expects match the form: `EMAIL` and `email_address_check`.
   If Brevo's generated markup uses different names, **its names win** — change the HTML,
   not Brevo.

### Double opt-in — decide once, apply to all three

Turn **double opt-in ON**. Reasons, in order of weight:
- It is the honest default, and Paul's reputation is the asset being protected.
- A confirmed list has far better deliverability, which matters on a free tier sharing IP pools.
- It gives a clean, provable consent record.

Cost: perhaps 20–30% fewer confirmed subscribers than raw signups. Worth it. Note this to Paul
in the handover so a smaller number later is not read as a broken form.

---

## Step 3 — The /thank-you/ page (all three sites)

Each site needs one, because it is what makes the signup measurable in GA4.

- Create a plain page at `/thank-you/`, title "You're on the list".
- Content: one line of confirmation, one line on what to expect, a link back to the portfolio.
- **Set it to `noindex`** (Yoast on BNB and DVPFL, Rank Math on Express) — a thank-you page in
  search results is noise, and it can leak as a landing page.
- Gate G4 in `../GATES-300usd.md` checks all three return 200.

---

## Step 4 — Deploy the form (BNB)

**Route: WPCode Lite, or the Elementor footer template. Never the homepage in Elementor.**
BNB's PHP memory limit is 128M and saving the homepage in Elementor fails at that limit.

1. WordPress → WPCode → Add Snippet → HTML snippet.
2. Paste the contents of `02-signup-form-bnb.html` (the `<style>` and the markup; the comment
   header is optional but harmless).
3. Location: site-wide footer.
4. Save and activate.
5. **Purge Seraphinite cache**, then load the site logged out to confirm it renders.

### After deploying, immediately:

```
node scripts/check-300usd.mjs signup      # expects the form on all three; BNB alone will still fail until Express/DVPFL ship
node scripts/check-300usd.mjs nojsembed   # must stay passing — no newsletter JS anywhere
```

Then re-run PSI mobile on BNB. **Baseline is 94.** If it drops, the form is the suspect —
it should not, because there is no JavaScript in it, but the gate exists precisely so that
assumption gets tested rather than trusted.

Also check the **Seraphinite optimised-visit counter** while in the dashboard — the free tier
caps at 5,000 and silently stops optimising past it.

---

## Step 5 — Capture from the real contact form (BNB)

The footer form catches browsers. The **contact form catches buyers** — those addresses matter more.

BNB runs **Fluent Forms**. Order of attempts, stop at the first that works:

1. Fluent Forms → the contact form → Settings → **Integrations**. If a Brevo integration is
   available on the installed tier, use it. Map `EMAIL` → the `bnb-hosts` list.
2. If not: Fluent Forms **webhook** to Brevo's contacts API endpoint.
3. If neither: **fallback** — a documented monthly export/import, five minutes, written into
   the handover.

**In all three cases:** add an unchecked "Keep me updated with photo tips" checkbox and push
only when it is ticked. Checked-consent only. A list poisoned with non-consenting addresses is
worth less than no list.

**Time limit: 30 minutes.** If no automatic route works by then, take the fallback and move on.
Do not engineer an integration for a list that has zero subscribers today. Gate G9 accepts the
documented fallback as a pass — that is deliberate.

---

## Step 6 — Repeat for Express and DVPFL

Same steps, three differences:

| | Express | DVPFL |
|---|---|---|
| Form file | `07-signup-form-express.html` | `08-signup-form-dvpfl.html` |
| Deploy route | Elementor footer template → HTML widget (**proven** — the GA4 tag shipped this way) | Elementor → **Custom Code**, footer position (no child theme exists) |
| Contact form | Fluent Forms (+ WPForms Lite still installed — remove after confirming nothing uses it) | Contact Form 7. The Tave iframe is out of reach; those leads stay in Tave. |
| After deploy | Purge WP Super Cache · PSI baseline **93** | WP Rocket **"Clear and preload"** · PSI ~61, host-limited |

---

## Step 7 — Welcome emails and campaign drafts

- Welcome automation per list, from `04-welcome-emails.md`. Trigger: contact added to list.
  Verify it fires within 60s with a real test address (gate G7).
- Three seasonal campaigns saved as **drafts**, from `06-campaign-drafts.md` (gate G8).
  Drafts, never scheduled — sending is Paul's call.

---

## Verification checklist for this runbook

- [ ] Account exists under Paul's email, sender verified, three lists present (G1)
- [ ] Test address through the live BNB form lands in `bnb-hosts` within 60s (G6)
- [ ] Welcome email arrives (G7)
- [ ] `/thank-you/` returns 200 on all three (G4)
- [ ] `node scripts/check-300usd.mjs signup` passes once all three are deployed (G2)
- [ ] `node scripts/check-300usd.mjs nojsembed` still passes (G3)
- [ ] PSI mobile: BNB ≥ 94, Express ≥ 93 (G5)
- [ ] Consent route documented per site (G9)
