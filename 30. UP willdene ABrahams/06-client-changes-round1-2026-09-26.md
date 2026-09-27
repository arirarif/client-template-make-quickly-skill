# Client changes, round 1 — plan and workflow (written 2026-09-26, Day 6 of 10)

Source: 3 messages from Willdene (below), 10 photos + 1 privacy-policy PDF in `client-assets/2026-09-26/photos-and-policy/`, the
story PDF `client-assets/2026-09-26/Emma_Our_Story.pdf`, and a read-only check of the live site on 2026-09-26.
`05-full-project-workflow-2026-09-22.md` stays the master plan; **this file covers round 1 of the client's changes and the rest of the job.**

---

## 0. Where things stand (checked 2026-09-26)

| Item | State |
|---|---|
| Live site | Home, About, Services, Portfolio and Contact all return 200. `noindex, nofollow` is on. Emma child theme **0.3.0** + Emma Core **0.3.0** match the local `build/` |
| Elementor Pro | **Not installed** (no `elementor-pro` files load). The site runs on the fallbacks: Hello's dynamic header, `[emma_projects]` cards and the Emma footer |
| Header logo | `logo-color.png` at **60 px** tall on desktop and 50 px on mobile (`theme.css` lines 85, 100, 388) |
| Favicon | `sunflower.png` (the stock sunflower) — this is the "murky" one the client means |
| Home photos | All are stock placeholders: `hero-team.jpg`, `intro-sketch.jpg`, `band-sunflowers.jpg`, `sunflower-real.png`, and 3 `work-*.jpg` sample projects |
| About | Hero → Story ("Digital work should be clear…") → Values → Network → **Team ("Team member name" placeholder)** → CTA |
| `/privacy-policy/` | **404**: the page is still a draft |
| Milestone 1 | **Due Thu 09-24, now 2 days late.** Willdene asked for the M1 deliverables so she can request the payment. M2 starts once M1 is in |
| Days left | Day 6 today → **last day Wed 09-30** |

## 1. The client's requests, one by one

| # | Request | Decision | Milestone |
|---|---|---|---|
| R1 | Use their photos; pick 1–2 landscapes by design judgement | See section 2 | M1 (Home) + M2 (About) |
| R2 | "5 portfolio pieces, not 3?" | **The written scope is 3** (milestone message, 2026-09-16: "Add the first 3 portfolio projects"; the scope limits say "3 portfolio items"). Answer honestly, see section 4 | Answer now |
| R3 | Logo in the header slightly larger | 60 → **76 px** on desktop, 50 → **58 px** on mobile. Keep the header height calm (padding 16 → 14 px) | M1 |
| R4 | New favicon | Received as `IMG_9719.png`. **The transparency checkerboard is baked into the pixels** (RGB file, no alpha), so it cannot be used as it is. Clean it (section 3), and ask for the original file as well | M1 |
| R5 | The email address has been created | `hello@emmadigitalagency.com` exists → SMTP + SPF/DKIM/DMARC in M2 (Contact form) | M2 |
| R6 | "Their answer to your second question was also yes" | **⚠ We need to confirm which message this answers.** If it was option 1 in file 05, Q2 was about pricing (a yes does not fit). If it was the plugin-removal question, the 4 Hostinger plugins + the AI theme can go. **Ariful: check the Upwork thread** | — |
| R7 | Photo of the two of them (2 options) | **IMG_9707** (the lake one) | M2 (About) |
| R8 | The Emma story, **final part of About**, heading **"The Story About Emma"**, **in full** | Its own section after Team, before the CTA. Full text, word for word, including the closing note and John 14:6 | M2 (About) |
| R9 | Privacy policy PDF (it came with the photos) | Publish it as `/privacy-policy/`. It contains placeholders — section 5 | M2 |

## 2. Photo choices (design judgement)

Contact sheet reviewed. Sizes are in pixels.

| File | What it is | Use | Why |
|---|---|---|---|
| **IMG_9707** (1647×955) | The couple by a lake, bright sky, her yellow top | **About → "The people behind Emma"** (replaces the placeholder) | Bright, warm and open. The yellow matches Sunflower Gold, and the water gives the "light" feeling of the brief. IMG_9717 (forest, darker green, standing apart) is heavier and fights the cream palette |
| IMG_9717 (1537×1023) | The couple, forest background | Keep as the reserve | Tell Willdene we chose 9707 and why; swapping is one click |
| **IMG_9714** (1448×1086) | Sun over a golden field | **Home → wide photo band** (replaces `band-sunflowers.jpg`) | The most "sunshine" of the set; the gold matches the palette. **Tilted about 1.4° — straighten it** |
| **IMG_9708** (3264×2448) | Lake sunset with clouds | **About → background of the Emma story, or the About page hero** | Calm and reflective, which suits the story. Horizon is level |
| IMG_9716 (1295×1215) | Sunflower against a sunlit wall | **Home → intro photo** (replaces `intro-sketch.jpg`) | Their own sunflower photo, soft light, fits the cream background |
| IMG_9715 (1295×1215, **real transparency**) | Sunflower cut-out | **Home hero → the rising sunflower** (replaces the stock `sunflower-real.png`) | Their own flower in the signature spot. Check that the edges are clean on cream |
| IMG_9713 (1536×1024) | Woman writing at a desk | **Home → intro, second photo** (replaces `hero-team.jpg`) | Looks AI-generated; use it only small. If it looks artificial next to the real photos, leave it out |
| IMG_9709 | Sea sunset with wind turbines, dark rock | Not used | The turbines and the dark foreground pull the eye |
| IMG_9710 | Dark field silhouette | Not used | Too dark for the "bright" brief. Also tilted about 1.2° |
| IMG_9711 (portrait) | Sun through the ferns | Reserve (a Contact page side photo if needed) | Strong, but portrait and busy |
| IMG_9719 | New favicon | Favicon, see section 3 | — |

**Photo rules for all of them:** straighten 9714 (then crop to remove the corners) · export WebP at 2400 px on the long side (the band) or 1600 px (the others), quality 80 · give each file a clear name (`emma-field-sunset.webp`, `eivind-matleena.webp`…) · alt text in plain English · 14 px corners as in the design.

The client only said "two horizons are not straight". Our measurement found **9714 (−1.4°) and 9710 (−1.2°)**; 9708 is level. Check by eye after straightening.

## 3. Favicon workflow (IMG_9719)

1. Remove the fake checkerboard: keep only the orange pixels (colour distance from about `#F5AD2A`), and turn the grey and white squares transparent. Use soft alpha on the edges so there is no grey fringe.
2. Trim to the shape, centre it on a square canvas with about 6 % padding, and export `emma-favicon-512.png`.
3. Test it at 16, 32 and 48 px on a light **and** a dark browser tab. If the thin petal outline turns to mush at 16 px, make a 32 px version with a thicker outline.
4. WordPress → Settings → General → Site Icon → upload the 512 file (WP makes 32/180/192/270).
5. Change `setup.php` so a fresh setup uses the new icon, and bump the versions.
6. Ask Willdene for the **original file** (PNG with real transparency, or SVG) and swap it in if it arrives.

## 4. The portfolio: 3 or 5

**Facts:** the scope we sent and Willdene accepted says 3 projects. The system itself has no limit: any number of projects, with a filter by service and one page each.

**The real issue:** the client wants the "**strongest, most visually impressive** work". Right now the 3 projects are invented samples (café, yoga, florist, marked "Sample project"). A new agency has no work of its own yet, so someone must decide **what real work** goes there.

| Option | What it means | Our note |
|---|---|---|
| A. **3 as agreed, 5 slots in the design** | We build and style 5; the client (or Willdene) sends the content for 2 more at any time | Honest and cheap. Recommended as the baseline answer |
| B. We fill 5 with **real sites we built** (white-label under Emma) | Stronger proof | **Ariful's decision.** It needs each end client's permission, or else the name and logo removed. Never show another agency's client as Emma's without that |
| C. 5 styled concept pieces, clearly labelled "Concept" | Visually strong, and not fake proof | Extra work beyond $80; offer it as a quoted add-on |

➡ **Ariful: pick A, A+B or A+C before the reply goes out.** The draft reply below is for A.

## 5. Privacy policy — what is missing

The PDF is good and short. Before it goes live, it needs:
- `[Registered business name]`, `Business ID (Y-tunnus)`, `[Street address], [postcode] [city]` and the "Last updated" date
- It says analytics are used **"only if you accept cookies"** and there is a **"link in the footer"** to change the choice. **Neither exists on the site** (no analytics, no cookie banner). Either (a) leave out the analytics lines until analytics is added, or (b) add a consent banner (a new plugin = new scope). Ask; default to (a)
- Page count: a privacy page is a legal page, not one of the 5 design pages. Build it free on the plain page template, and add a footer link

## 6. "The Story About Emma" — section design (About)

- Position: **after "The people behind Emma", before the CTA band** (the client's wish: the last part of About)
- Background: Sunbeam Cream `#FDF5E6`, full width, a lot of space above and below. Optional: IMG_9708 as a quiet band **above** the heading (not behind the text; the text stays on cream so it is easy to read)
- Small label "OUR STORY", then H2 **"The Story About Emma"** (Gloock)
- Text column max 680 px, Hanken Grotesk 18–19 px, line height 1.75, paragraphs exactly as in the PDF
- The closing note ("Note to everyone that has lost a small child…") in italics after a thin Warm Stone line, as in their PDF
- Signature "Eivind and Matleena", right-aligned or centred, in Gloock italic
- **No** gold buttons or marketing in this section; the CTA band after it gives the page its breathing space
- Copy the text exactly (keep "sooo", the capitals, the "!!"). **Do not edit their words.** Only fix the formatting
- It is an Elementor Text Editor widget, so they can edit it themselves

Also: rename "The people behind Emma" → names **Eivind & Matleena** + IMG_9707. Ask Willdene for 1–2 lines on who does what (or use neutral text: "Founders of Emma").

## 7. Work plan, step by step

> **Scope rule (Ariful, 2026-09-27): do no more than the $40 Milestone 1.** M1 = design, WordPress setup and the
> homepage only. Nothing else gets built until Willdene activates (funds) M2. The About work (Steps 2–3) is
> already live; it stays up but is **not billed as M1** and **counts toward M2**. Step 4 onward is frozen until
> M2 is funded, and the privacy page (section 5) is M2 work too. The M1 message (section 9A) lists only M1 items.

**Rules for every step:** bump the child theme / Emma Core version after any file edit · rebuild the zips with `build/tools/build_zips.py` · purge the Elementor CSS + LiteSpeed · test logged out with `?cb=` (never `?m=`) · commit each step (scope `git add` to this folder).

### Step 0 — Before any work (today)
- [ ] Ariful: check which "second question" was answered yes (R6)
- [ ] Ariful: portfolio decision A / A+B / A+C (section 4)
- [x] Moved `SSSS/` to `client-assets/2026-09-26/` (2026-09-26). The originals are not committed (14 MB); the web copies are in `build/emma-core/assets/img/emma-*`
- [ ] hPanel backup before touching the live site

### Step 1 — M1 fixes on Home ✅ done and live 2026-09-26 (v0.4.0, commit 23c15d3)
1. [x] Logo 76 px desktop / 58 px phone (the Pro header and Hello's fallback header). Measured on live: 76 / 58
2. [x] Favicon: `emma-favicon.png` (checkerboard removed, colour #FDB01D), set as the Site Icon by setup
3. [x] Photos prepared by `build/tools/prepare_client_photos.py` (re-run it if the originals change)
4. [x] Home: band ← `emma-field-sunset.jpg` (straightened), intro ← `emma-desk.jpg` (caption "Every project starts on paper.") + `emma-sunflower-wall.jpg`, hero/CTA sunflower ← `emma-sunflower-cutout.png` (150 KB). The generator and `home.json` match the live site
5. [x] Deployed: theme + plugin zips uploaded, Tools → Emma setup run with "Replace", no failures. Checked logged out: 0.4.0 CSS, new favicon, all 4 new images; no sideways scroll at 1521 px or 374 px
6. [ ] Screenshots, desktop + phone, full page (Ariful, for the M1 message)
7. [ ] **Send M1** (message A below)

Note: the Chrome session is logged in as the **client's** account (eivindjohansen@…), not `Developer`.

### Step 2 — About page ✅ done and live 2026-09-26 (v0.5.0 + theme 0.5.1, commits 5857ebc, 803e590)
1. [x] "The people behind Emma" → **Eivind & Matleena** + the lake photo (`emma-eivind-matleena.jpg`, from IMG_9707), in place of the 4 placeholder cards. The one line of text is ours ("Emma is run by Eivind and Matleena…"); replace it with their text when it arrives
2. [x] New last section **"The Story About Emma"** (label "Why Emma", from their PDF): lake sunset strip (`emma-lake-sunset.jpg`, IMG_9708) · the story in full · the note in olive after a thin line · signed "Eivind and Matleena". **Checked word for word against the PDF: identical**
3. [x] The last stock photos on About are gone: "Our story" ← `emma-desk.jpg`, "How we are organised" ← `emma-ferns.jpg` (IMG_9711). The About hero stays text-only
4. [ ] Their About text when it arrives
5. [x] Phone check at 374 px: no sideways scroll; story heading balanced (0.5.1) so "Emma" is not left alone on a line

### Step 3 — Portfolio ✅ layout done (option A: 3 agreed, room for 5)
1. [x] Home "Selected work" shows up to 5 (`[emma_projects count="5"]`): 1 large + 2 stacked, then projects 4–5 side by side. With 3 projects it looks exactly as before. Phones: one column. The Pro Loop Grid version has the same rule
2. [x] The Portfolio page already shows up to 12, with the filter
3. [ ] The 3 are still clearly labelled "Sample project". Real work replaces them when the client sends it

### Step 4 — Contact + email (Day 8, Mon 09-28)
1. [ ] SMTP through `hello@emmadigitalagency.com` (FluentSMTP or Hostinger's mail settings)
2. [ ] DNS: SPF, DKIM, DMARC in hPanel (none exist, checked 09-22)
3. [ ] Form: send a real test → it must land in the inbox, not spam
4. [ ] Privacy policy page live + footer link (section 5)
5. [ ] **Submit M2**

### Step 5 — Their text + revisions + launch (Days 9–10, 09-29 / 09-30)
- Put in their text as it arrives (Home, About, Services)
- One revision round → SEO, speed, security → QA → go live (untick "Discourage", re-activate LiteSpeed) → handover (file 05, sections 7–8)
- **Elementor Pro** is still not installed. Either Ariful installs it before M2, or the site stays on the free-Elementor fallbacks, which already work. Decide by Day 8; the guide must match what is installed

## 8. Risks from this round

| Risk | What to do |
|---|---|
| M1 is 2 days late | Send it today, with the logo + favicon + real photos done, so the delay reads as "your changes are already in" |
| Scope creep (5 projects, story section, privacy page, their text arriving late) | The story + privacy page are small: do them. 5 projects = the layout only, unless paid or the client sends the content. Say it kindly and clearly |
| The story is very personal and religious | Show it exactly as written, with care: a calm design, no stock images, no edits to their words |
| Fake-checkerboard favicon | Clean it, and ask for the original |
| Their text is not here yet | Build with the current draft copy; swap it in when it arrives (already agreed) |

## 9. Messages to Willdene

### A. M1 delivery (short version, sent text)

```
Hi Willdene,

Milestone 1 is complete: WordPress setup, the design and the
homepage, with the client's homepage changes already in:
- Larger logo in the header
- New favicon (their file had the transparency pattern saved into the
  image, so I cleaned it. If they have the original, please send it)
- Their own photos on the homepage, with the horizon straightened

Home: https://emmadigitalagency.com
Screenshots attached.

I have also made a head start on Milestone 2: the About page already
has the photo of the two of them and "The Story About Emma" in full
(https://emmadigitalagency.com/about/).

Portfolio: the agreed scope is 3 pieces, and the homepage has room for
5, so two more fit in as soon as they send the content.

One quick question: which was the "second question" they answered
yes to?

You can now request the Milestone 1 payment. Once Milestone 2 is
activated, I will continue with the remaining pages, the contact form
and the privacy policy.

Best regards,
Ariful
```

### B. Short privacy-policy question (send only after M2 is activated — it is M2 work)

```
The privacy policy is ready to publish. It still needs the registered
business name, the Business ID (Y-tunnus), the address and the date.
It also mentions analytics cookies and a cookie link in the footer.
The site has no analytics yet, so I suggest leaving that part out until
analytics is added. Is that okay?
```

---

## Appendix — the client's messages (2026-09-24 to 26)

**Willdene, 10:52** — Client reviewed the homepage, very happy. Will send text + images; use design judgement for
the landscapes. Remembers "5 portfolio pieces rather than 3", please confirm; wants the strongest, most visually
impressive work. Logo in the header slightly larger. New favicon (current one is unclear/murky). The email
address works and has been created. "Their answer to your second question was also yes."

**Willdene, 10:59** — Extra photos: a photo of the two of them must be included (2 options). Several Finnish
summer-night landscapes, choose 1–2. Two horizons are not straight; they can be corrected. Use design judgement. (10 files)

**Willdene, 22:12** — The client will send the company story; add it if it fits, remove it if too busy. Asks when
to request the Milestone 1 payment.

**Willdene, 17:39** — The Emma story goes as the **final part of About**, after they present themselves; a longer
page is fine. Heading **"The Story About Emma"**, story **in full**. "Today is Day 4 and the deadline for Milestone 1"
— send all M1 deliverables for review; M2 from tomorrow. File: `Emma_Our_Story.pdf`.
