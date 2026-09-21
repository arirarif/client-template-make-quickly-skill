# Fotello test site — end-to-end roadmap

Client: Paul Ayoub · Brand: Express Real Estate Photos · Test domain: **expressrephotos.com** (Paul's GoDaddy)
Editor: https://app.fotello.co/dashboard/manage-website/WUufR8fRb8UXH9QIrSoR
Written 2026-09-21 after going through the editor in the browser. Read with `FOTELLO-MEETING-NOTES-2026-09-18.md` and `FOTELLO-BUSINESS-REPORT-29-of-100.md`.

---

## 0. Can we do it? Yes.

The editor is a simple form-based page builder, and Arif's invite access opens it with full edit rights. Every section we need can be edited. Nothing technical blocks us.

What the job really is: **replace Fotello's placeholder content with Paul's real content, check every claim, and hide what can't be backed up.** Fotello pre-built a draft that looks finished but is part fake. Publishing it as-is would put invented reviews and numbers under Paul's name.

Things only Paul or Fotello can do (listed in step 1):
- Real reviews.
- Confirming the numbers ("4.9 rating", "5,000+ properties").
- Connecting the domain and pressing **Publish** — Paul does this on a call with Adam S at Fotello.

---

## 1. What the editor has right now (audited 2026-09-21)

### Editor layout
- **Style tab:** theme (Classic ✓ / Proof / Marquee), font (Inter ✓ / Archivo / Fraunces / Hanken), brand colour (#1F5DE8), corner radius (25).
- **Sections tab** (drag to reorder, eye icon to show/hide, per-section "Change design"):
  - Shown: Header · Hero · Logo slider · Why Us · Products · Stats · Reviews · FAQ · Portfolio · Contact · Footer
  - Hidden: Video Portfolio · Virtual Tour Portfolio · Packages · Services · Add-ons
- **Requests tab:** a form to ask Fotello for a new section, feature, design or other change. This is the only way past the builder's limits.
- **Preview** and **Publish** buttons, top right. **Never press Publish** — only one site can be published per account, and Paul publishes with Adam.
- Desktop/mobile toggle at the top.

### Content audit — what's real, what's fake

| Section | Current content | Status |
|---|---|---|
| Header | "Express Real Estate Photos" as text; **logo image is a broken placeholder**; +19418940980; Client Login; Book a shoot | Fix: upload logo, format phone as (941) 894-0980 if the field allows |
| Hero | Eyebrow "Magazine-quality real estate media"; H1 "The photographer Venice agents call first."; subtext; address bar + Book a Shoot; 3 slides of **stock modern houses** | Replace slides with Paul's photos. Headline is fine; check wording with Paul |
| Hero highlights | "Next-morning delivery" · **"4.9 agent rating"** · **"5,000+ properties shot"** | Rating is unverifiable (Google shows 0 reviews): **remove**. Property count: **ask Paul** |
| Logo slider | Brokerage logos? (not checked in detail) | Use the logos from the current site: KW, RE/MAX, Berkshire Hathaway, eXp, Zillow, Airbnb, Booking.com — only brands Paul actually works with |
| Why Us / About | Paul's own first-person bio ("real estate investor and Airbnb host…") with a porch photo | Real. Swap in a photo of Paul or his work instead of stock |
| Products / Packages | **Real, pulled from Paul's Fotello products:** Basic $149, Classic $249, Deluxe $349, Premier, Airbnb/VRBO STR Package, Zillow Boost 3D Virtual Tour, with his photos | Good. Check descriptions: Basic and Classic share the same text; Premier price is cut off in the view |
| Stats | Numbers not checked | **Ask Paul** for every figure |
| Reviews | "Trusted by top-producing agents…" + **invented reviews: James Rodriguez, Daniel Okafor, Olivia Bennett, Marcus…, …Brooks**, with stock headshots | **Fake. Hide the section** until real reviews exist |
| FAQ | Not checked in detail | Rewrite from the Express FAQ copy (`300usd-build/`) |
| Portfolio | "The work that gets agents their next listing" + **stock farmhouse photos** | Replace with Paul's photos (`assets/` + more from him) |
| Contact | Contact form + "Send message" | Test that it delivers (step 6) |
| Footer | Blurb, "Venice, FL 34293, USA", orders@expressrealestatephotos.com, Instagram/Facebook/YouTube, Terms and Conditions, © 2026 | Check the social links go to Paul's real profiles; check the Terms page |

**Note on the current WordPress site too:** its homepage reviews ("Michael R., Sarah L., David K., Jessica M., Brian T.") look like theme placeholders as well. Don't copy them into Fotello. Ask Paul whether they're real.

---

## 2. Before starting — settle with Paul (one message)

Send these in **one** message (Paul prefers few, short asks):

1. **Price for this build.** Nothing agreed yet, and it's outside the $300. Suggest a fixed price (estimate in section 9).
2. **Reviews.** "Fotello filled the Reviews section with made-up names. I've hidden it. Can you forward 3–5 real client messages or emails?" This is the same ask as the reviews item in the $300 job, so one answer covers both.
3. **Numbers.** "How many properties have you shot, roughly? Do you want a delivery promise (next-morning / 24h)?"
4. **Photos.** "Can you share a folder of 20–30 of your best recent shoots (exteriors, twilight, interiors, drone)?" Put them in `fotello-site-build/assets/`.
5. **Logo.** Is `assets/logo-5.png` the current one? Is there a larger or transparent version?

Don't raise the Fotello fee again — it's settled (free on Ultimate with one listing plan).

---

## 3. Phase A — prepare offline (about 1–2 h)

Done in the project folder before touching the editor, so the editing session is copy-paste.

- [ ] **A1. Content sheet** `fotello-site-build/CONTENT-SHEET.md`: one block per section with the final text for each field (eyebrow, headline, subtext, highlights, Why Us, FAQ Q&As, stats, footer blurb). Sources: `content/*.md` and the copy already written in `300usd-build/`.
- [ ] **A2. Write new copy, don't paste the current site.** The test site and expressrealestatephotos.com will both be live, so identical text on both domains makes Google treat one as a copy. Reuse facts, reword sentences.
- [ ] **A3. Local keywords in the copy** (the report's "needs Fotello to fix" rows are really this): Venice FL, Sarasota, North Port, Englewood, Port Charlotte, Nokomis, Osprey, Lakewood Ranch. Use them in the hero subtext, Why Us, FAQ and footer.
- [ ] **A4. Photo pick:**
  - hero ×3: wide exteriors, one twilight
  - portfolio ×8–12: a mix of interior, exterior, drone and twilight
  - About: a photo of Paul, if he sends one
  - Rename files descriptively (`venice-fl-twilight-exterior.jpg`) and resize to ~2000px wide, <500 KB each. There are duplicates in `assets/` (DJI_0037 ×2, DJI_0537 ×2) — keep one of each.
- [ ] **A5. FAQ** — 6–8 real questions: service area, turnaround, what to prepare, weather/rescheduling, drone rules, payment, Zillow 3D vs Matterport, vacant-home virtual staging.

---

## 4. Phase B — build in the editor (about 3–4 h)

Work top to bottom. The builder saves as you go; use **Preview**, never Publish.

- [ ] **B1. Style.** Keep the Classic theme and Inter (clean, fast). Set the brand colour to match Express's logo instead of Fotello's default blue #1F5DE8 — take it from the logo. Corners: leave as is.
- [ ] **B2. Header.** Upload the logo (fixes the broken image). Check the menu links scroll to the right sections. Phone number format. The "Client Login" button — confirm with Paul that his clients use the Fotello portal. If they don't, ask whether it can be hidden.
- [ ] **B3. Hero.** Final eyebrow/headline/subtext. Replace all 3 stock slides. Highlights: "Next-morning delivery" (if Paul confirms), "Serving Venice to Sarasota", "Drone · 3D tours · Floor plans". **No rating claim.** Check the address autocomplete works for a Venice FL address.
- [ ] **B4. Logo slider.** Brokerage and platform logos Paul really works with. If unsure, hide it.
- [ ] **B5. Why Us.** Paul's bio is fine; tighten it and add the service area. Replace the stock porch photo.
- [ ] **B6. Products.** Fix the duplicate Basic/Classic descriptions. List what each package includes (from `content/home.md`: Classic = virtual twilight + property website + sizzle reel; Deluxe = + floor plan, aerial, Zillow 3D; Premier = + walkthrough video). Check the prices match Fotello's product settings and the current site.
- [ ] **B7. Stats.** Only numbers Paul confirmed. If none, hide the section.
- [ ] **B8. Reviews.** ✅ Hidden 2026-09-21 and saved (confirmed after reload; the "Testimonials" menu link went with it). Keep hidden until real reviews arrive. Then enter them with first name + last initial and no stock headshots. If the section can later pull Google reviews automatically, use that once the Google listing has reviews.
- [ ] **B9. FAQ.** Enter from the content sheet.
- [ ] **B10. Portfolio.** Replace every stock image.
- [ ] **B11. Hidden sections — decide each one:**
  - Video Portfolio → show if Paul has 2–3 property videos (YouTube links).
  - Virtual Tour Portfolio → show if he has Zillow 3D / Matterport links.
  - Packages / Services / Add-ons → turn on one at a time in Preview and see if they duplicate Products. Show Add-ons if it lists drone, floor plan, staging and so on, because agents buy those separately.
- [ ] **B12. Contact.** Check which email the form sends to (should be orders@expressrealestatephotos.com).
- [ ] **B13. Footer.** Real social links (the current site has them), address format, Terms page content.
- [ ] **B14. Section order** (suggested): Header → Hero → Logo slider → Products → Portfolio → Why Us → Stats → Reviews → FAQ → Contact → Footer. Put prices and work before the bio; agents shop on price and photos.

---

## 5. Phase C — booking setup (about 1 h, needs Paul's Fotello settings)

Booking lives in the Fotello account (the "Book a shoot" / address bar flow). The website only links to it.

- [ ] **C1.** Walk the booking flow in Preview. Enter an address, check the square-footage tiers, the package picker and the add-ons upsell. **Stop before the final submit** — no real orders.
- [ ] **C2.** Check the prices in the flow match the Products section.
- [ ] **C3.** Check the Google Calendar link is on Paul's calendar (Settings). If it isn't connected, Paul does it — it's his Google login.
- [ ] **C4.** Check the service area / travel limits. Venice-based: note which towns are in range.
- [ ] **C5.** Paul already takes bookings through Fotello, so this is mostly confirming, not building.

---

## 6. Phase D — QA before handing to Paul (about 1 h)

- [ ] **D1. Placeholder hunt.** Search Preview for anything invented: names, stock faces, "4.9", "5,000+", "top-producing agents", "Lorem", stock houses. None may remain.
- [ ] **D2. Mobile.** Switch to mobile view and scroll everything: menu, hero text over the image, product cards, form.
- [ ] **D3. Links.** Every menu item, every button, phone (tap to call), email, social, Terms, Client Login.
- [ ] **D4. Contact form.** Send one test message marked "TEST — ignore", and confirm with Paul that it arrived.
- [ ] **D5. Booking flow** walked through to the last step, not submitted.
- [ ] **D6. Spelling and consistency:** the phone number the same everywhere, "Express Real Estate Photos" spelled the same everywhere.
- [ ] **D7.** Screenshots of the finished preview (desktop + mobile) into `fotello-site-build/screenshots/` for the handover message.

---

## 7. Phase E — domain + publish (Paul and Fotello; Arif guides)

Per the meeting: the domain stays Paul's, DNS points to Fotello, email is unchanged, and Adam supports publishing and DNS.

- [ ] **E1.** Find where the custom domain goes (Settings in the Fotello sidebar). Enter **expressrephotos.com**, and note the DNS records Fotello asks for.
- [ ] **E2.** Those records go into **Paul's GoDaddy**. Either Paul adds them on the call with Adam, or Paul gives Arif GoDaddy delegate access (GoDaddy "Delegate Access", not his password).
- [ ] **E3.** Only change the records Fotello names (usually A / CNAME for the web address). **Don't touch MX records** — expressrephotos.com has no email yet, but the habit protects expressrealestatephotos.com later.
- [ ] **E4.** Paul books the publish call with Adam (his action item from the meeting). Arif sends Paul a short "ready for Adam" message with the preview screenshots.
- [ ] **E5.** After publishing: open https://expressrephotos.com, check HTTPS, run the D-checks again on the live site.

---

## 8. Phase F — the comparison (2–4 weeks after publishing)

A brand-new domain won't rank for weeks, so **don't compare Google rankings.** Compare what can be measured fairly:

| Measure | Tool | Current site baseline |
|---|---|---|
| Mobile speed | PageSpeed Insights, mobile | Express = 93 (Aug 2026) |
| Page title, meta description, schema | view-source / Rich Results Test | Express has local title + meta |
| Clicks to book | Walk both flows | count the steps |
| Content depth | Page count | Express ~17 pages + blog; Fotello = one page, no blog yet |
| Leads | Bookings/messages from each site | Paul reports |

- [ ] **F1.** Add expressrephotos.com to Google Search Console (Arif, same as the other 3 sites) to see if and when Google indexes it.
- [ ] **F2.** Re-run Fotello's Business Report once the Express Google listing is claimed and has reviews. Most of the 29/100 comes from the Google listing, not the website.
- [ ] **F3.** Write a 1-page comparison for Paul — short, a decision not a report (he doesn't want long documents).

---

## 9. Phase G — if Paul decides to switch expressrealestatephotos.com (later, separate decision)

Only if the test wins. Risks to state plainly then:
- The WordPress site stops existing at that address (Adam, 15:52). ~17 pages + blog become one page, and Fotello has no blog yet.
- Google re-indexes. Old page URLs (/aerial-photography/, /virtual-staging/, blog posts) will 404 unless Fotello can set redirects — **ask Adam before switching.**
- Keep a full WordPress backup (files + database) before the nameservers change, so it can be undone.
- Email on expressrealestatephotos.com (orders@…) must keep working: copy the MX records before any DNS change.

---

## 10. Effort + price guide

| Phase | Hours |
|---|---|
| A. Offline prep (content sheet, copy, photos) | 1.5–2 |
| B. Editor build | 3–4 |
| C. Booking check | 1 |
| D. QA | 1 |
| E. Domain guidance + publish support | 0.5–1 |
| F. Comparison + Search Console | 1 |
| **Total** | **8–10 h** |

Suggested fixed price for Paul: quote it once, in the step-2 message, as a fixed amount for A–F. Phase G is its own quote if it ever happens.

---

## 11. Where to start (in order)

1. Send the step-2 message to Paul (price + reviews + numbers + photos + logo).
2. While waiting: Phase A (content sheet, copy, photo prep) — needs nothing from Paul.
3. In the editor: B1–B6, B9, B12–B13 (everything that doesn't depend on Paul's answers). **Hide Reviews and Stats right away**, so the draft never shows fake content.
4. When Paul replies: B7, B8, B10, B11, then C and D.
5. Send "ready for Adam" with screenshots → E → F.

## 12. Rules

- Never press **Publish**. Never submit a real booking.
- Nothing invented goes live: no made-up reviews, ratings or counts.
- Don't bring up Fotello's cost with Paul again.
- Keep Paul's asks few and short — batch them.
- Log progress in this file (tick the boxes) and commit after each phase.
