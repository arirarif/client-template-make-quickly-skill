# Workflow — the $300 job, three sites in parallel

**Scope contract:** `SCOPE-2026-09-03-300usd.md` · **Agreed:** 2026-09-03 · **Written:** 2026-09-07
**Deliverables:** Google Business Profile · Reviews · Mailing list — on all three sites
**Bundled free inside the price:** Search Console ×3 · BNB updates + hardening + backups · live form-delivery test

---

## 0. Rules of engagement

1. **Never break what is already won.** Express is at mobile 93, BNB at 94. Every asset added
   in this job is measured against that number before and after. A signup form that costs
   10 points is a failure, not a feature.
2. **No new plugin unless there is no other way.** Prefer native HTML plus the existing WPCode /
   Elementor Custom Code routes. Rationale in Track A.
3. **Paul's time is the scarcest input.** He gets exactly three asks, batched into ONE message
   (§7), never drip-fed. Anything I can do without him, I do without asking.
4. **Budget guardrail:** $300 target, soft ceiling. Track it in §9. At 80% consumed with work
   outstanding, tell Paul before continuing — he pre-agreed it "could be a little more", but
   only if he hears it early, not at invoice time.
5. **Every live change gets:** a before-state note, the change, a verification command, and a
   one-line rollback. Same discipline as the August work.

---

## 1. Dependency map

```
                        +---------------------------------------------+
  ONE MESSAGE TO PAUL ->| P1  GBP access + verification code          |--> TRACK B
  (§7, send day 1)      | P2  3-5 happy-client emails                 |--> TRACK C
                        | P3  "yes" to the mailing list (already got) |--> TRACK A
                        +---------------------------------------------+

  TRACK A  mailing list      -- NO blocker -- start immediately --+
  TRACK D  bundled freebies  -- NO blocker -- start immediately --+
  TRACK B  GBP               -- waits on P1 ------------------+   |
  TRACK C  reviews           -- waits on P2 ------------+     |   |
                                                        v     v   v
                                        TRACK E  wire-up + close-out
                        (review schema, GBP links in footers, review-ask
                         automation in the email tool, handover, final report)
```

**The critical path is Paul, not me.** So: send §7 first, then work A + D while waiting.
Never idle waiting on B/C.

**Per-site parallelism:** inside each track the three sites are independent — same task, three
times, back to back. Batch **by task** (do "create list" on all three, then "footer form" on all
three), not by site. Batching by task is what makes this fit the budget: the decision gets made
once and applied three times.

---

## 2. Site stack — what each one actually runs

Established during the August work. This drives every "how" below.

| | Express | BNB Photos | DVPFL |
|---|---|---|---|
| Theme | Hello Elementor | Hello Elementor | **Aurel — no child theme** |
| Builder | Elementor | Elementor | Elementor 4.2.3 / **Pro licence "Missing"** |
| Forms | **Fluent Forms** + WPForms Lite (two — clean up) | **Fluent Forms** | **Contact Form 7** + Tave iframe (lazy-loaded) |
| Code injection | Elementor Custom Code (**proven** — the GA4 tag went in this way) | **WPCode Lite** (no per-page header — Pro only) | Elementor Custom Code (**the only safe route**) |
| Cache | WP Super Cache | **Seraphinite — free tier caps at 5,000 optimised visits** | WP Rocket + Perfmatters |
| Analytics | GA4 via Elementor Custom Code | GTM-5S55Q56K + GA4 G-0479PXZCRD | GA4 + Site Kit (old version) |
| Search Console | none | verify | verify |
| SEO plugin | Rank Math | Yoast | Yoast |
| Security | — | Wordfence 9.0.0 | — |
| Speed now | mobile 93 / desktop 97 | mobile 94 | ~61 (host-limited) |

**Landmines — read before touching anything:**

- **BNB:** PHP memory is 128M and saving the Elementor **homepage** fails at that limit. Edit the
  footer through a template / global widget or WPCode — never by opening the homepage in Elementor.
- **BNB:** Seraphinite free tier is capped at 5,000 optimised visits. Check where the counter
  stands before the end of the job, or caching silently stops optimising later.
- **DVPFL:** no child theme exists. Everything ships through Elementor → Custom Code.
  Always "Clear and preload" in WP Rocket after a change. Never activate a second cache plugin.
- **DVPFL:** the mobile LCP element is the call-button label — do not hide or restyle it.
- **Express:** two form plugins are active. Removing WPForms Lite is free speed, but confirm no
  form uses it first.

---

## 3. TRACK A — Mailing list (no blocker, start now)

### A0. Platform decision — decided, not open

**Brevo, free tier, one account, three lists.**

| Option | Verdict |
|---|---|
| **Brevo free** | **Chosen.** Unlimited contacts, 300 emails/day. A few hundred subscribers send in one day. |
| MailerLite free | Fine too, but 1,000 contacts and the cap bites first. |
| Mailchimp | Weakest free tier of the three now, priciest at growth. Skip. |

One account with **three lists**, not three accounts — Paul logs into one place, and a future
campaign to all past clients across brands stays possible.

- `express-agents` — listing agents, brokerages
- `bnb-hosts` — Airbnb hosts, property managers
- `dvpfl-couples` — engaged couples

Account owner = **Paul's email**, me added as a user. His asset, not mine. Non-negotiable — and
it also makes the retainer conversation later an easy yes rather than a lock-in argument.

### A1. Signup form — native HTML, no JS embed

The platform's JS embed loads an external script on every page. That is exactly the kind of third
party that cost Express points in August. Instead: **a plain HTML form POSTing to Brevo's hosted
subscription endpoint** — zero JS, zero render cost, styled with ~20 lines of CSS per site.

Per site:

1. Brevo → the list → create a subscription form → copy its POST action URL and field names.
2. Build the markup once, re-skin per site (Express blue / BNB / DVPFL dark).
3. Include: email field, hidden list ID, honeypot field for bots, a consent line
   ("Occasional tips and offers. Unsubscribe any time."), submit button.
4. Ship it:
   - **Express** → Elementor footer template → HTML widget
   - **BNB** → footer template or WPCode Lite — **not** by editing the homepage
   - **DVPFL** → Elementor Custom Code, footer position
5. Redirect after submit to the site's own `/thank-you/` (create if missing) so GA4 records a
   conversion. That is what makes the list measurable instead of a black box.

**Verify:** submit a real address → it appears in the correct list within 60s → confirmation email
arrives → re-run PSI mobile and confirm no score drop.

### A2. Capture from the forms people already fill

The footer form catches browsers. The **contact and booking forms catch buyers** — those are the
addresses actually worth having.

| Site | Route |
|---|---|
| Express | Fluent Forms → add a "Keep me updated" checkbox → push to Brevo. Free Fluent Forms has no native Brevo integration: try its webhook on the installed tier, else Brevo's WP plugin hook, else a documented manual export. **Decide by testing, not by assuming.** |
| BNB | Same Fluent Forms route, same test. |
| DVPFL | Contact Form 7 → Brevo's official WP plugin has historically offered a CF7 hook; verify it exists on the current version before relying on it. The Tave iframe is out of reach — those leads stay in Tave. |

**Rule:** checked-consent only. No silent adding. A photographer's list poisoned with
non-consenting addresses is worth less than no list at all.

If no automatic route works on a site within ~30 minutes, **stop** and use the fallback: a
documented 5-minute monthly export/import written into the handover. Do not burn budget
engineering an integration for a list that has zero subscribers today.

### A3. Welcome email — one per audience

Plain text, from Paul, sent instantly on signup. Not a newsletter — a warm handshake.

- **Agents:** what he shoots, turnaround time, booking link, "reply if you have a listing coming up".
- **Hosts:** the photo-prep tip, portfolio link, booking link.
- **Couples:** one film to watch, packages link, "tell me your date".

Written by me, approved by Paul in a single pass as part of the §7 message — not a separate ask.

### A4. Campaign drafts — the part that makes the list pay later

Three seasonal emails sit in Brevo as **drafts**, so a future campaign costs Paul one word:

| Draft | Audience | Send when |
|---|---|---|
| "Spring listing season — book your slots" | express-agents | Dec–Jan |
| "Snowbird season is coming — refresh your listing photos" | bnb-hosts | Sep–Oct |
| "Engagement season" | dvpfl-couples | Nov–Jan |

**Track A delivers:** three lists · three live signup forms · capture from real forms where
possible · three welcome emails live · three campaigns drafted · one page on how to send one.

---

## 4. TRACK B — Google Business Profile (blocked on P1)

The highest-value item in the job. All three brands have **zero** GBP presence — verified across
all 39 crawled pages: no `google.com/maps`, `g.page` or `business.google` link anywhere.

### B0. Access — the real blocker

A GBP belongs to a Google account. Two ways in, best first:

1. **Paul stays owner and adds me as Manager** — I set the profiles up, he keeps the asset.
2. Five minutes on a screen share at the start.

Either way, **only he can receive the verification** (postcard to his address, or a phone call).
That is stated plainly in §7 so it does not surprise him two weeks in.

### B1. Per-profile setup (same steps ×3)

| | Express | BNB Photos | DVPFL |
|---|---|---|---|
| Primary category | Real estate photographer | Photographer | **Videographer** |
| Secondary | Photographer, Drone photography service | Real estate photographer | Wedding photographer, Video production service |
| Business type | Service-area, **address hidden** | Service-area, hidden | Service-area, hidden |
| Service areas | Venice, Sarasota, North Port, Bradenton, Port Charlotte | Venice, Sarasota, Siesta Key, Anna Maria Island, Englewood, Nokomis | Venice, Sarasota, North Port, Bradenton, Port Charlotte, Fort Myers |
| Website | homepage, with UTM | homepage, with UTM | homepage, with UTM |
| Booking link | the existing booking app | contact page | contact page |
| Phone | (941) 894-0980 — must match the site exactly | same | same |

Fill **every** field: services with prices where they are already public, description, hours,
opening date, attributes. A half-filled profile ranks like a half-filled profile.

**Photos matter more than the text.** 10–15 per profile, pulled from each site's existing
portfolio — real work, correct brand. Free ranking signal Paul already owns.

### B2. Wire the profile back into the site

- GBP link in each site's footer — same deploy as the signup form, one edit instead of two.
- "Find us on Google" plus the review link on the contact page.
- `sameAs` in the existing LocalBusiness schema → the GBP URL, tying brand and profile together.

### B3. First post per profile

One GBP post per site at setup (an offer, or a recent job). Signals an active profile on day one.

**Verify:** profile public and findable by brand name → phone matches the site → website link
returns 200 → review link works → `sameAs` present in schema.

---

## 5. TRACK C — Reviews (blocked on P2)

### C1. Turn Paul's forwarded emails into on-site proof

- Pull the name, role or town, and the usable sentence. **Nothing invented** — same rule as the
  DVPFL copy work.
- If the source was private, Paul sends one line asking permission: "Happy for me to use your
  words on the site?"
- Build a review section per site, styled to match: Express agents / BNB hosts / DVPFL couples.
- **Schema:** `Review` markup per testimonial. `AggregateRating` **only once real Google reviews
  with real star values exist** — faking it is a manual-action risk. Real or nothing.

### C2. The review engine (the part that keeps working after I leave)

- Short review link per GBP (`g.page/r/...`).
- A copy-paste ask for Paul, one message he sends after each job: agents after the 2nd–3rd shoot,
  hosts when the listing goes live, couples when the film is delivered.
- Automate it in Brevo wherever a delivery email already exists — then the ask sends itself.
- Target: **10+ reviews per profile.** Ten real reviews beats a competitor with two.

---

## 6. TRACK D — Bundled freebies (no blocker, start now)

Small, high-certainty, and they are what make the three deliverables measurable.

| # | Task | Site | Note |
|---|---|---|---|
| D1 | Search Console: verify + submit sitemap | all three | Express has none — the biggest gap. Verify through the existing GA4 tag. |
| D2 | Contact-form live delivery test | all three | Send a real submission through **every** form; confirm it reaches Paul's inbox and is not in spam. Silent form failure is the classic invisible killer. |
| D3 | GA4 conversion events | all three | form submit · phone tap · newsletter signup. Without these the monthly report is guesswork. |
| D4 | Elementor + Pro update | BNB | Hold Yoast (Premium 28.1 vs free 28.2 — check the MyYoast licence). Hold All-in-One WP Migration (major jump). |
| D5 | Login hardening | BNB | Wordfence rate-limit on `wp-login.php` — already installed, just unconfigured. |
| D6 | Backup + update routine | BNB | None exists today. |
| D7 | Seraphinite quota check | BNB | Free tier caps at 5,000 optimised visits — see where it stands. |
| D8 | Remove WPForms Lite | Express | Only after confirming no form uses it. Free speed. |
| D9 | Re-run PSI | all three | After every deploy. The 93 / 94 scores are the regression guard. |

---

## 7. The one message to Paul (send before any work starts)

Batched — three asks, no follow-ups.

> Hi Paul — starting on the three items now. Everything I can do without you, I'm doing.
> Three things only you can do, whenever you get a minute:
>
> 1. **Google Business Profile** — I'll build all three profiles, but Google verifies the owner:
>    they send a postcard or call you. Two options — either add me as a Manager (I'll send the
>    invite, you stay the owner), or five minutes on a screen share and we do it together.
>    Which is easier for you?
> 2. **Reviews** — forward me 3–5 emails or texts from happy clients, any of the three
>    businesses. I'll draft the on-site version and send it to you before anything goes live.
> 3. **Welcome emails** — I'll write one short email per audience (agents / hosts / couples)
>    that sends automatically when someone signs up. I'll send all three for a quick yes.
>
> No rush on any of it — I'll keep working and updating you.

**Update cadence:** a short update at first deploy, at the halfway point, and at handover. Three
messages, no more. He asked not to be overwhelmed, and "keep updating you" was the promise —
three is the number that honours both.

---

## 8. Gates — the job is done when every line is checked

Checkable, not vibes. Same pattern as the August `GATES.md` files.

**Mailing list**
- [ ] G1 Brevo account exists, owner = Paul's email, three lists present
- [ ] G2 Live signup form on all three sites — a real test address lands in the correct list
- [ ] G3 PSI mobile after ≥ before on Express and BNB (93 / 94 floor)
- [ ] G4 Welcome email fires within 60s on all three lists
- [ ] G5 Three seasonal campaigns saved as drafts
- [ ] G6 Consent-capture route documented per site (automated, or the manual fallback)

**Google Business Profile**
- [ ] G7 Three profiles created, every field filled, 10+ photos each
- [ ] G8 Verification submitted (Paul-dependent — "submitted" is my gate, "verified" is Google's)
- [ ] G9 Name / phone / service areas match the site exactly on all three
- [ ] G10 GBP linked from footer + contact page, `sameAs` in schema, all three
- [ ] G11 One GBP post published per profile

**Reviews**
- [ ] G12 Review section live on all three sites, every quote traceable to a real forwarded message
- [ ] G13 `Review` schema valid in Rich Results Test, no fabricated `AggregateRating`
- [ ] G14 Review-ask template + short link delivered to Paul

**Bundled**
- [ ] G15 Search Console verified + sitemap submitted, all three
- [ ] G16 Every contact form delivers to Paul's inbox — tested live, not assumed
- [ ] G17 GA4 conversion events firing (form, phone, signup), all three
- [ ] G18 BNB: Elementor updated, login rate-limited, backups running
- [ ] G19 Every known page per site still returns HTTP 200 after each deploy (regression guard)

---

## 9. Budget tracker

$300 across three sites. Rough shape; adjust as reality lands.

| Track | Share | Notes |
|---|---|---|
| A — mailing list | ~35% | Highest build effort; the form is built once, deployed three times |
| B — GBP | ~30% | Mostly data entry and photos — slow but certain |
| C — reviews | ~15% | Cheap once Paul sends the emails |
| D — bundled | ~15% | Small, high certainty |
| E — close-out + handover | ~5% | Handover doc and final message |

**Trip-wire:** at 80% consumed with gates still open, message Paul before continuing.

---

## 10. Risk register

| Risk | Likelihood | Response |
|---|---|---|
| Paul never sends the review emails | **high** — he is busy by his own account | Ship everything else; leave the review section built but empty and hand him a one-click way to fill it later. Never let it block close-out. |
| GBP verification postcard delayed two weeks or more | medium | G8 is "submitted", not "verified". Close the job on submitted, follow up once. |
| No automatic form→Brevo route on the free tiers | medium | Documented manual export fallback, 5 min/month, written into the handover. Do not over-engineer. |
| Signup form costs speed points | low | Native HTML, no JS. G3 catches it. |
| BNB Elementor save fails (128M PHP memory) | **known** | Never edit the homepage in Elementor. Footer via template or WPCode. |
| Scope creep into the shelved roadmap | medium | Anything outside `SCOPE-2026-09-03-300usd.md` is a separate conversation. |
| Budget overrun | medium | §9 trip-wire and an early message. He pre-agreed to "a little more" — but only if told early. |

---

## 11. Handover (the last deliverable)

One short page for Paul, in his language, at close: what was set up · his three logins · how to
send one campaign (five steps with screenshots) · how to ask for a review · what to ignore ·
what a monthly check would cover if he wants one.

**The retainer ask goes here** — after he has seen the work, not before. That is the natural
moment, and it is the difference between a $300 job and an ongoing client.

---

## 12. Progress log

| Date | Track | Done | Told Paul? |
|---|---|---|---|
| 2026-09-03 | — | Scope agreed at $300, all three sites | yes — chat |
| 2026-09-07 | — | Workflow written | — |
