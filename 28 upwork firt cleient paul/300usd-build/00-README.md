# 300usd-build — everything built for the $300 job

Contract: `../SCOPE-2026-09-03-300usd.md` · Plan: `../WORKFLOW-300USD-parallel.md`
Ledger: `../GATES-300usd.md` (25 gates) · Oracles: `../scripts/check-300usd.mjs`
Live changes so far: `../bnbphotos.com/sep2026/CHANGELOG-live-changes.md`

Files are numbered in the order they get used. BNB first, per the owner's instruction.

| # | File | What it is | Blocked on |
|---|---|---|---|
| 01 | `01-message-to-paul-3-asks.md` | ~~Send this first~~ — superseded by file 10 | — |
| 02 | `02-signup-form-bnb.html` | Footer signup form, BNB | Brevo form URL |
| 03 | `03-brevo-setup-runbook.md` | Account, 3 lists, endpoints, capture, thank-you pages | Paul's email |
| 04 | `04-signup-form-express.html` | Footer signup form, Express | Brevo form URL |
| 05 | `05-signup-form-dvpfl.html` | Footer signup form, DVPFL | Brevo form URL |
| 06 | `06-welcome-emails.md` | Three welcome emails, one per audience | Paul's OK + 1 fact |
| 07 | `07-campaign-drafts.md` | Three seasonal campaigns, saved as drafts | — |
| 08 | `08-gbp-content-pack.md` | Paste-ready profile content, all three businesses | GBP access + 5 facts |
| 09 | `09-review-kit.md` | Ask templates, on-site review markup, automation | Paul's 3–5 emails |
| 10 | `10-message-to-paul-access-request.md` | ~~Send this~~ — superseded by 11 once Paul gave the go-ahead | — |
| 11 | `11-reply-to-paul-go-ahead.md` | **SEND THIS ONE.** Takes his yes, explains the one step only he can do, and tells him about the 350 reviews he isn't using | you, now |

## Status

**Content is complete.** Nothing here is a placeholder or a sketch — every file is ready to
execute the moment its blocker clears.

**Verified:** all three signup forms pass the gate detectors once deployed (Brevo action,
honeypot, consent wording), carry **zero JavaScript**, and correctly *fail* the check while the
`FORM_ACTION_URL` placeholder is unfilled — so a half-deployed form cannot pass as done.

**Nothing in this folder has touched a live site.** The live work so far is BNB only, logged in
the changelog above.

## The blockers, in one place

| Needed from Paul | Blocks |
|---|---|
| Email address to own the Brevo account | 02, 03, 04, 05, 06, 07 — the whole mailing list |
| GBP access + the verification code Google sends him | 08 |
| ~~3–5 happy-client emails~~ | **No longer needed** — 350 public reviews found on The Knot / WeddingWire / Thumbtack (see file 11) |
| Opening hours ×3, Express turnaround, Matterport still offered?, opening years | 06, 08 |

| Needed from the owner | Blocks |
|---|---|
| Google login for Search Console + GA4 | bundled items D1, D3 |
| Hosting panel (a real cron) | the wp-cron hardening item, deliberately left undone |

All of Paul's items are in file 01 as **three asks in one message**. He asked not to be
overwhelmed; the facts in the last row get collected in the same reply, not drip-fed.
