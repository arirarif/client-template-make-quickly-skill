# Fotello build — execution workflow

The order to do the work in. The "why" is in `ROADMAP-fotello-test-site.md`; this file is the "do".
Editor: https://app.fotello.co/dashboard/manage-website/WUufR8fRb8UXH9QIrSoR

## Ground rules (every step)

1. **Save after each section** (top-right Save → wait for "Unsaved changes" to clear). Reload once per session to confirm it stuck.
2. **Never press Publish.** Never submit a booking. Never use the image picker's **Stock** tab.
3. **Nothing invented goes live.** If a fact isn't confirmed, hide the item or leave it out.
4. Tick the box here when a step's **check** passes, and commit after each track.

## Tracks and blockers

| Track | Needs Paul? | Can start |
|---|---|---|
| T0 Send Paul the message | — | now |
| T1 Content sheet (text) | no | now |
| T2 Photos from Paul's listings | no | now |
| T3 Editor: text + photos + sections | no (except stats/reviews/logo) | after T1 + T2 |
| T4 Booking + contact check | no | after T3 |
| T5 Paul's answers go in (reviews, numbers, logo) | **yes** | when he replies |
| T6 QA + handover screenshots | no | after T3–T5 |
| T7 Domain + publish | **Paul + Adam** | after T6 |
| T8 Compare (2–4 weeks) | no | after T7 |

T1 and T2 run in parallel. T5 waits on Paul but doesn't block T3/T4 — put placeholders in hidden sections and keep moving.

---

## T0 — Message Paul (5 min)

- [ ] Fill in the price in `CLIENT-MESSAGE-2026-09-21-fotello-start.md` (suggested $150), send on Upwork.
- **Check:** message sent; note the date here.

## T1 — Content sheet (1.5 h)

Output: `fotello-site-build/CONTENT-SHEET.md`, one block per section, one line per editor field, ready to paste.

- [ ] **T1.1** Hero: eyebrow, headline, subtext, 3 highlights, button label, address placeholder.
  - Headline: keep "The photographer Venice agents call first." unless Paul objects.
  - Highlights: "Next-morning delivery" (pending Paul) · "Venice to Sarasota" · "Photo · Drone · 3D · Floor plans". **No rating.**
- [ ] **T1.2** Why Us: tighten Paul's existing bio, add the service area towns.
- [ ] **T1.3** Products: one distinct description per package. Basic and Classic currently share text. Inclusions from `content/home.md`.
- [ ] **T1.4** FAQ: 6–8 Q&As. Turnaround, service area, how to prepare, weather/reschedule, drone, payment, Zillow 3D vs Matterport, virtual staging.
- [ ] **T1.5** Portfolio heading + subtext, Contact intro, footer blurb.
- [ ] **T1.6** Local words spread across the text: Venice, Sarasota, North Port, Englewood, Port Charlotte, Nokomis, Osprey, Siesta Key, Lakewood Ranch.
- **Check:** every sentence is reworded, not copied from expressrealestatephotos.com (duplicate-text rule). No claim that Paul hasn't confirmed.

## T2 — Photo pick from Paul's Fotello listings (45 min)

Picker path: section → image → **Change** → **Listings** tab → choose the address → choose the photo.

- [ ] **T2.1** Open each listing in the picker and note the best frames in `CONTENT-SHEET.md` as `address → photo #`. Known listings: 4140 Woodmere Park Blvd (Venice), 1016 Rhodes Ave (Sarasota), 180 E Horton Ave (Englewood), 2827 Grand Cayman St (Sarasota), 5950 Midnight Pass Rd #212 (Siesta Key), 1993 Michigan Ave (Englewood), 5325 Murdock Ave (Sarasota), and more below in the list.
- [ ] **T2.2** Pick **3 hero** frames: wide front exteriors, bright sky, one twilight or pool if available. Prefer landscape, no people, no car in the driveway.
- [ ] **T2.3** Pick **8–12 portfolio** frames: 4 exteriors, 3 interiors (kitchen, living, primary bed), 2 drone, 1–2 twilight. Spread across different listings and towns.
- [ ] **T2.4** Pick **1 Why Us** frame (or a photo of Paul if he sends one).
- **Check:** no two picks from the same room, no stock, every town covered at least once.

## T3 — Editor build (3 h), top to bottom

- [ ] **T3.1 Style** — Classic, Inter. Brand colour from the Express logo instead of #1F5DE8. Save.
- [ ] **T3.2 Header** — menu labels, phone. Logo waits for T5. Save.
- [ ] **T3.3 Hero** — paste T1.1 text; swap all 3 slides with T2.2 picks; delete the "4.9 agent rating" highlight; "5,000+" stays only if Paul confirms (hide/replace until then). Save.
- [ ] **T3.4 Logo slider** — keep only brands Paul works with (KW, RE/MAX, Berkshire Hathaway, eXp, Zillow, Airbnb, Booking.com — confirm in T5); otherwise hide. Save.
- [ ] **T3.5 Why Us** — paste T1.2, swap the photo. Save.
- [ ] **T3.6 Products** — paste the T1.3 descriptions. Check the prices against the current site: $149 / $249 / $349 / $449. Save.
- [ ] **T3.7 Stats** — hide until T5. Save.
- [ ] **T3.8 Reviews** — ✅ already hidden (2026-09-21). Leave hidden until T5.
- [ ] **T3.9 FAQ** — replace all Q&As with T1.4. Save.
- [ ] **T3.10 Portfolio** — replace every image with T2.3 picks, paste the heading. Save.
- [ ] **T3.11 Contact** — paste the intro; replace the sample placeholder ("Two-bed condo in Larchmont…" — Larchmont is New York) with a Venice example. Save.
- [ ] **T3.12 Footer** — blurb, address, social links → Paul's real Instagram/Facebook/YouTube (take them from the current site's footer), Terms page content. Save.
- [ ] **T3.13 Hidden sections** — show each one in turn: Video Portfolio, Virtual Tour Portfolio, Packages, Services, Add-ons.
  - Keep a section only if it has Paul's real content and doesn't repeat Products.
  - Add-ons (drone, floor plan, staging…) is the likely keeper.
  - Save.
- [ ] **T3.14 Order** — Header → Hero → Logo slider → Products → Portfolio → Why Us → (Stats) → (Reviews) → FAQ → Contact → Footer. Save.
- **Check:** reload the editor, scroll the whole Preview: no stock house, no invented name/number, no New York example text, every menu link lands on a visible section.

## T4 — Booking + contact (1 h)

- [ ] **T4.1** In Preview, enter a real Venice address in the hero bar. Walk the flow: sq-ft tier → package → add-ons → calendar. **Stop before the final submit.**
- [ ] **T4.2** Flow prices = Products prices. Note any mismatch for Paul (prices live in his Fotello product settings; don't change them without him).
- [ ] **T4.3** Calendar shows real availability. If it doesn't, Paul needs to connect Google Calendar (his login).
- [ ] **T4.4** Contact form: confirm the destination email is orders@expressrealestatephotos.com. The real send test waits until the site is live (T7) — preview forms may not send.
- **Check:** notes written under this step; nothing submitted.

## T5 — When Paul replies (30 min)

- [ ] **T5.1 Logo** → Header + Footer. Save.
- [ ] **T5.2 Reviews** → enter 3–5, first name + last initial, no stock faces → **show** the Reviews section. Save.
- [ ] **T5.3 Numbers** → Stats section and hero highlights; show Stats only if there are 3+ real figures. Save.
- [ ] **T5.4** Delivery promise wording in Hero + FAQ matches his answer. Save.
- **Check:** every number on the page traces to something Paul wrote.

## T6 — QA + handover (1 h)

- [ ] **T6.1** Desktop pass: read every word, click every button (not Publish, not final booking submit).
- [ ] **T6.2** Mobile pass (phone toggle): menu, hero text readable over the photo, cards, FAQ opens, form fits.
- [ ] **T6.3** Placeholder hunt: stock · Larchmont · "4.9" · Rodriguez/Okafor/Bennett · "top-producing" · #1F5DE8 blue leftovers.
- [ ] **T6.4** Screenshots (desktop + mobile, full page) → `fotello-site-build/screenshots/`.
- [ ] **T6.5** Send Paul the "ready — please book the publish call with Adam" message with the screenshots.
- **Check:** Paul has the screenshots.

## T7 — Domain + publish (Paul + Adam; Arif on standby)

- [ ] **T7.1** Find the custom-domain setting (Fotello Settings), note the DNS records it asks for.
- [ ] **T7.2** Paul adds them in GoDaddy for **expressrephotos.com** (on the Adam call, or via GoDaddy Delegate Access for Arif). Web records only; no MX changes.
- [ ] **T7.3** Paul/Adam press Publish.
- [ ] **T7.4** Live check: https://expressrephotos.com loads over HTTPS; run T6.1–T6.2 again live; contact-form test marked "TEST — ignore", Paul confirms receipt.
- [ ] **T7.5** Add expressrephotos.com to Google Search Console.

## T8 — Compare (2–4 weeks after T7)

- [ ] **T8.1** PageSpeed mobile: expressrephotos.com vs expressrealestatephotos.com (93 baseline).
- [ ] **T8.2** Titles/meta/schema from view-source on both.
- [ ] **T8.3** Booking steps count on both; leads from each (Paul).
- [ ] **T8.4** Search Console: is the new domain indexed, any impressions.
- [ ] **T8.5** One short comparison message to Paul with a recommendation. If he switches the main domain, the roadmap's Phase G applies first.

---

## Progress log

| Date | Step | Note |
|---|---|---|
| 2026-09-21 | Audit | Editor audited; placeholders found (reviews, 4.9, 5,000+, stock photos, Larchmont example) |
| 2026-09-21 | T3.8 | Reviews section hidden + saved, confirmed after reload |
| 2026-09-21 | T2 | Found Paul's real photos in picker → Listings tab |
| 2026-09-21 | T1 | CONTENT-SHEET.md written from the live Express site |
| 2026-09-21 | T3.3 | Hero text done (no rating/count claims). Slides → Paul's photos: 4427 Deer Ridge Pl twilight pool · 1016 Rhodes Ave twilight garden · 426 Pineview Dr Venice twilight front. Saved |
| 2026-09-21 | T3.5/6/9/10/11/12 | Why Us text, Products subtext, all 8 FAQs, Portfolio subtext, Contact text + success msg, Footer blurb. Saved, verified after reload |
| 2026-09-21 | T3.7 | Stats hidden (5,000+ / 1 in 4 / 4.9 were invented) |
| 2026-09-21 | T3.5 | Why Us image → 4427 Deer Ridge twilight front (replaced Fotello graphic with a "Sold 11% higher" badge). Saved |
| 2026-09-21 | T3.10 | All 12 portfolio images → Paul's listings (Rhodes, Deer Ridge, Doubloon ×3, Pineview, Peppertree, Horton, Midnight Pass, 51st St W, Freeport). Saved |
| 2026-09-21 | T5.1 | Logo: uploaded logo-5.png (same file the live site uses) to Header brand image via Gallery → Upload. Saved |
| 2026-09-21 | T3.13 | Add-ons ON (Paul's real Fotello add-ons: marketing designs, STR close-ups, amenity, property website, same-day $50, virtual staging). Virtual Tour Portfolio ON with 4 real tours from the live site (2 Matterport, 2 Zillow 3D) + listing-photo covers. Both auto-added to the menu. Saved |
| 2026-09-21 | T3.13 | Video Portfolio stays hidden: it only takes listing videos or uploaded files, and none of Paul's Fotello listings has a video. Live site has 4 Vimeo videos (583609210, 646709340, 563764246, 651706746) — need the files from Paul |
| 2026-09-21 | T4 | Booking already live on Fotello: homes.expressrealestatephotos.com/book/default (same link the WordPress site uses). Flow: address → sq ft → packages priced by size (1,800 sq ft = $199/$299/$399/$499) → add-ons → schedule → contact → confirm. Walked to products step only, nothing submitted. Booking email is orders@ → keep orders@ in footer |
| 2026-09-21 | Q | Client Login = Paul's Fotello portal (main site links homes.expressrealestatephotos.com/login) → keep |
| 2026-09-22 | T4 | Package cards all link to /book/default (no product preselect); order form always starts at the address step. No option in Products, product settings, order forms or section designs. Arif decided: keep as is, no Fotello request |
| 2026-09-22 | T3.4 | Partner logos: 6 fake placeholders → 7 real logos from the live site (KW, RE/MAX, Berkshire Hathaway, eXp, Zillow, Airbnb, Booking.com), headline "Trusted by agents and hosts working with". Files in assets/partner-logos/. Saved |
| 2026-09-22 | T3.14 | Order (per Arif): Hero → Partners → Why Us → Packages → Add-ons → Virtual Tours → FAQ → Portfolio → Contact → Footer; header menu reordered to match. Saved, verified after reload |
| 2026-09-22 | T6.2 | Mobile view checked: header, hero, text, package cards fit |
| 2026-09-21 | notes | Header "Add link" accepts any https:// URL (external links possible). Contact "Larchmont" placeholder is not an editable field — ask Fotello via Requests. Footer socials verified real. Package cards live in /dashboard/products (Paul's booking) — not touched |
| 2026-09-25 | Feedback | Paul's round-1 feedback logged in CLIENT-FEEDBACK-2026-09-25.md. Hero rewritten to Sarasota & Charlotte County, "Every shoot by Paul" removed. Saved. Logo + headshot still open |
