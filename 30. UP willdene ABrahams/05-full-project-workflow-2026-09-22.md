# End-to-end workflow — emmadigitalagency.com (written 2026-09-22, Day 2 of 10)

Built from (1) the whole Upwork thread, (2) a **read-only audit of the live WordPress admin** done in
Chrome on 2026-09-22 (nothing was changed), and (3) the real CSS of the two reference sites.
Files `02`, `03` and `04` are history. **This file is the plan.**

---

## 0. The job on one screen

| Item | Fact |
|---|---|
| Middle client (pays us) | Willdene Abrahams, agency on Upwork. All client contact goes through Willdene |
| End client | Owner of **emma Digital Agency** (domain `emmadigitalagency.com`), now living in Paraguay, slow to send content |
| Pages | **Home, About, Services, Portfolio, Contact**. Exactly 5 |
| Services shown | Web Development · SEO & SEM · Social Media Marketing · AI Solutions · Email Automation · Analytics |
| Price | **$80 fixed**, split $40 / $30 / $10 |
| Time | **10 days. Day 1 = Mon 2026-09-21. Last day = Wed 2026-09-30** |
| Contract | Offer sent 2026-09-21 11:39. **Only Milestone 1 ($40, due Thu 2026-09-24) is set up** |
| Real prize | Ongoing white-label work from Willdene + a first strong review on the Upwork profile |

### The end client's wishes (as passed on by Willdene)

1. WordPress
2. He edits **text, portfolio pieces and pricing** himself, because the site will change often
3. Clean build, **no unnecessary plugins**
4. **No generic or off-the-shelf theme**, and no generic look
5. Strong focus on **visual design and quality**: the site is proof of what his agency sells
6. **Another WordPress developer can take it over** easily
7. Feeling: **"bright, spacious, full of light and sunshine"** (from thatsaprile.com + nakashimawoodworkers.com)

---

## 1. What is on the server right now (audited 2026-09-22)

| Area | Found | What it means |
|---|---|---|
| Install date | Both users created **2026-09-20**. A fresh install | Nothing to keep or migrate |
| Old Hostinger-builder site | **Gone.** The domain already serves this WordPress | Case "B": we build on the live domain. There is no separate staging address |
| Public homepage | **Blank**. Only "Skip to content" shows, with the title "emmadigitalagency.com" | Visitors and Google see an empty page today |
| Search engines | **Allowed** (the "Discourage" box is off). robots.txt + `wp-sitemap.xml` are live | Google can index the blank page → switch on "Discourage" on Day 3 while building |
| Content | 0 posts, 0 media, 1 page: **Privacy Policy (draft)**. 1 empty Navigation menu | Clean slate |
| Settings | Site title = `emmadigitalagency.com`, tagline empty, front page = "latest posts", no logo, no site icon, **timezone UTC+0**, comments **open**, permalinks `/%postname%/` ✅ | All to set in the Day-3 setup |
| Theme | **Hostinger AI theme 2.1.9** (block theme, active). Inactive: Twenty Twenty-Five, -Four, -Three | Replace. The AI theme *is* the generic Hostinger look he disliked |
| Plugins (all active) | Hostinger AI 3.0.55 · Hostinger Easy Onboarding 3.0.0 · Hostinger Reach 1.8.2 · Hostinger Tools 3.0.77 · LiteSpeed Cache 7.9.1 | Keep **LiteSpeed Cache** only. The other 4 are "unnecessary plugins". Hostinger Reach even loads its files on the public page |
| Hidden extras | 2 must-use plugins (Hostinger's) + `object-cache.php` drop-in (object cache on) | Leave the MU plugins. Purge the object cache after big changes |
| Users | #1 client admin (his ProtonMail address) · **#2 `Developer` = aririslam2@gmail.com, administrator** ✅ | Do all work as **Developer** (the Chrome session on 09-22 was logged in as the client's account #1, so switch accounts) |
| Server | LiteSpeed · Hostinger CDN (`hcdn`) · **PHP 8.3** · **WordPress 7.1.1** · environment "production" · `WP_MEMORY_LIMIT` 40M (front end), 2048M (admin) · Imagick + GD | Very good for a block theme. Block bindings (6.5+) are available |
| Domain | Nameservers `dns-parking.com` (Hostinger) · A → 147.79.69.9 · **MX → mx1/mx2.hostinger.com** · `www` → 301 to the bare domain · HTTPS ✅ | Email on the domain is hosted at Hostinger → form mail sends from `hello@emmadigitalagency.com` (mailbox to create) |
| Not visible from WP | Hostinger plan level, daily backups, staging tool, mailbox count | Check in **hPanel** on Day 3 (invitation accepted 2026-09-20) |

**The two things that change the old plan:**
1. **No staging.** The site *is* the live domain, and it is blank today. We build in place behind "Discourage search engines" and a simple holding page, then open it on Day 10. (We promised a staging site. Tell Willdene in plain words, see section 12.)
2. **The admin email is ProtonMail.** ProtonMail cannot be used as a normal SMTP sender on free plans, so enquiries are **sent from a Hostinger mailbox on the domain** and **delivered to** whatever address the client chooses.

---

## 2. Every promise we made (the acceptance list)

From the proposal (09-15), the shortlist answers (09-15), the milestone message (09-16) and the Day-1 reply (09-17).

| # | Promise | Milestone |
|---|---|---|
| P1 | WordPress set up; current site stays safe during the build | M1 |
| P2 | **Custom theme**: no page builder, no off-the-shelf theme (in the milestone message) | M1 |
| P3 | Homepage **design shared for approval first**, then built. 2 revision rounds on the design | M1 |
| P4 | Homepage responsive: desktop, tablet and mobile | M1 |
| P5 | Brand colours, fonts and style set up for all pages | M1 |
| P6 | About, Services, Portfolio and Contact in the same design | M2 |
| P7 | **Portfolio system**: a project is added through a simple form (title, client, services, images, results) | M2 |
| P8 | **Filter by service**, **one page per case study**, Services show **matching case studies automatically** | M2 |
| P9 | **Pricing, text and images editable** in the WordPress editor | M2 |
| P10 | **Ready-made section blocks** so he can add matching sections | M2 |
| P11 | Enquiry form with **spam protection + SMTP** delivery | M2 |
| P12 | **First 3 portfolio projects** added | M2 |
| P13 | All **6 services** shown, with a clear call to action on each | M2 |
| P14 | **1 revision round** on the full site | M3 |
| P15 | QA on devices and browsers, tested on **real devices** | M3 |
| P16 | Basic SEO: titles, meta, heading structure, sitemap, Search Console | M3 |
| P17 | Speed: image compression, caching, lean theme | M3 |
| P18 | Security: updates, login protection, firewall, **daily backups** | M3 |
| P19 | Site live on his domain | M3 |
| P20 | **Written guide** (milestone message) **and a short video** (shortlist answer). Deliver both | M3 |
| P21 | Draft text + royalty-free images where content is missing. He replaces them, or sends content **before Day 9** | all |

**Out of scope** (answer politely with "happy to quote it as a next step"): a 6th page or more, more
than 3 case studies entered by us, final copywriting, working AI, chatbot or email-automation features
(these are only *services listed* on the site), logo or brand design, paid stock photos, paid licences.

---

## 3. Builder decision: custom block theme vs a premium theme vs Hello + Elementor

You asked whether a lightweight premium theme or Hello Elementor would be better. Measured against what
**the client asked for** and what **we already put in writing**:

| Option | "Not generic / not off-the-shelf" | "No unnecessary plugins" | He edits text, prices, portfolio | Another dev can take over | Cost to client | Speed | Build time for us |
|---|---|---|---|---|---|---|---|
| **A. Custom block theme `emma` + tiny `emma-core` plugin** (recommended) | ✅ fully ours; exactly what the milestone message promised | ✅ 0 builder plugins | ✅ Site Editor + locked patterns + form for case studies | ✅ pure core WordPress, no vendor lock | $0 | Best: core blocks only | Medium. The theme is mostly `theme.json` + patterns |
| B. Lightweight theme (Kadence, GeneratePress, Blocksy, Astra) + custom design | ⚠ still an off-the-shelf theme. The client said no to that, and we wrote "no off-the-shelf theme" | ⚠ the good parts (custom layouts, hooks, extra blocks) sit in a companion plugin, often Pro | ✅ | ✅ widely known | Free, or Pro yearly licence | Good | Medium: you fight the theme's defaults |
| C. **Hello Elementor + Elementor Pro** | ✅ can look custom | ❌ adds Elementor + Pro. **We wrote "no page builder" in the milestone message the client approved** | ✅ drag and drop | ✅ very well known | **Elementor Pro yearly licence** (portfolio loop templates, the theme builder and forms are Pro features) | Heavier. Front-end memory is 40M here, so it would need raising | Fastest for you |

**Recommendation: A.** It is the only option that meets all 7 wishes *and* matches the written milestones.
B and C both break a promise that Willdene already forwarded to the client.

**If you still want C (Hello + Elementor) because it is faster for you:** do not switch silently. Ask
Willdene first, in writing (message in section 12, option 2), and let the client accept the Elementor
Pro licence cost. Then the portfolio system becomes an Elementor Pro Loop Grid + the same `emma-core`
plugin, and the rest of this workflow stays the same.

---

## 4. Design direction (from the reference sites' real CSS)

| | thatsaprile.com | nakashimawoodworkers.com |
|---|---|---|
| Built with | Hand-coded (Foundation grid, Flickity, Splitting.js) | WordPress, custom theme |
| Headline font | **Magnat Head**: high-contrast display serif (paid) | **Freight Display**: elegant serif (paid) |
| Text font | **TT Commons**: soft geometric sans (paid) | **Gotham**: geometric sans (paid) |
| Background | Warm off-white **`#fbf9f6`** (never pure white) | `#fff` + soft grey `#f2f2f0` |
| Text | Warm near-black `#1a1918`, greys `#4e4746` / `#807b7a` | Charcoal **`#4a4a4a`**, grey `#9b9b9b` (never pure black) |
| Lines / quiet fills | Warm beige `#e5dedc` | Grey `#cdcdcd` |
| Accent | **Muted gold `#bb9704`** | Moss green `#6f8555` |
| Signature | Big serif statements, story-like sections, fold-open detail rows | **Small UPPERCASE labels with 2–3 px letter-spacing**, "more >" text links, full-width photos |

**The brief both sites share:** serif headlines + a clean geometric sans · a warm off-white page with soft
dark text · one quiet accent colour · very large empty spaces · text links rather than loud buttons ·
large, calm photos.

### emma design tokens

| Token | Value |
|---|---|
| Headline font | **Fraunces** (free, closest to Magnat/Freight). Backup: Instrument Serif |
| Text font | **Figtree** (free, closest to TT Commons/Gotham). Backup: DM Sans |
| Font loading | Self-hosted `.woff2` in the theme. No Google Fonts calls (speed + EU privacy) |
| Background | Warm off-white around `#fbf9f6` |
| Text | ~`#1a1918` headlines, ~`#4e4746` body |
| Accent | **Sunflower yellow taken from `Colors.png` / the logo** (read the exact hex from the client files) |
| Labels | 12–13 px uppercase, letter-spacing 2 px |
| Section spacing | ~120–160 px desktop, ~64–80 px mobile |

**Yellow rule:** yellow is only ever a **fill** (button, highlight band, sun shape) with **dark text on
it**. Never yellow text on a light page and never white text on yellow: both fail contrast.

**Don't:** copy aprile's 30→1 countdown preloader (slow, hurts the speed score), use their text or photos,
or download the paid fonts from their servers.

---

## 5. Architecture (option A)

### Theme `emma` (design only)

```
emma/
  style.css            theme header + Version (bump on EVERY change)
  theme.json           palette, fonts, fluid type sizes, spacing scale, widths, block styles
  functions.php        enqueue, pattern category "emma", block style variations
  assets/fonts/        Fraunces + Figtree .woff2
  assets/css/          only what theme.json cannot do
  assets/img/          sun shape SVG from the logo
  parts/     header.html · footer.html
  templates/ front-page.html · page.html · index.html · 404.html
             archive-case_study.html   → /portfolio/
             taxonomy-service.html     → /service/seo-sem/ etc. (the filter)
             single-case_study.html    → one case study
  patterns/  hero · intro-statement · services-list · featured-work · process-steps
             testimonial · pricing-table · cta-band · about-story · values · team-grid
             service-detail · contact-split · faq
  README.md  for the next developer
```

### Plugin `emma-core` (data, survives a theme change)

- Post type **`case_study`**, shown as "Portfolio", URL `/portfolio/`
- Taxonomy **`service`**, with the 6 services as terms
- **"Project details" box** (the "simple form"): client · industry · year · live link · 3 results
  (number + label) · testimonial quote / name / role. Registered with `register_post_meta`. **No ACF.**
- New case studies open with the headings **Challenge / Solution / Results** already in place, so he
  only types under them. Cover = featured image. Screenshots = core Gallery block.
- The single template shows the fields through **core block bindings**, so the layout is locked
- Small hardening: XML-RPC off, user listing through REST blocked for visitors, comments off site-wide

### How each promise is met

| Promise | How |
|---|---|
| P7 simple form | "Project details" box + pre-filled headings |
| P8 filter | Pill links to `/service/<term>/`. No JavaScript, and every filter is a real URL Google can index |
| P8 single page | `single-case_study.html` |
| P8 automatic matching | On the Services page, each of the 6 sections has a Query Loop filtered to that service |
| P9 pricing | `pricing-table` as a **synced pattern**: edit a price once and it changes everywhere |
| P10 sections | 14 patterns in the "emma" category of the block inserter |
| P13 6 services | Services = **one page with 6 sections** (keeps it to 5 pages), each with its own CTA |

### Plugin list (final state)

| Need | Plugin | Why this one |
|---|---|---|
| Cache + image optimisation | **LiteSpeed Cache** (already installed) | The server is LiteSpeed; it's the natural fit |
| Form + spam protection | **Fluent Forms** (free) | Honeypot + Cloudflare Turnstile, clean markup |
| SMTP | **FluentSMTP** (free) | Sends through the Hostinger domain mailbox |
| SEO | **The SEO Framework** (free) | Lightest option: titles, meta, sitemap, no ads |
| Login protection | **Limit Login Attempts Reloaded** | Small. The rest of the hardening is in `emma-core` |
| Backups | **Hostinger's backups** if the plan has daily ones (check hPanel); otherwise UpdraftPlus | "Daily backups" was promised |
| Removed | Hostinger AI · Hostinger Easy Onboarding · Hostinger Reach · Hostinger Tools · Hostinger AI theme | "No unnecessary plugins". **Ask the client before removing** (section 12). Hostinger Tools is optional; it has the maintenance-mode switch, so keep it until launch if we use that |

Final count: **5 plugins + 1 custom plugin.**

---

## 6. End-to-end steps

### Phase 0 — Before the build (Day 2, today, 09-22)

- [ ] Save the 9 brand files from the Upwork chat into `assets/brand/` in this folder. **Never** save the
      login screenshot `IMG_9625.png` or any password in this folder (it's a shared git repo)
- [ ] Read the exact hex codes from `Colors.png`, `Colors 2.png`, `Colors 3.png` → put them in the tokens (section 4)
- [ ] Send the reply to Willdene (section 12, option 1)
- [ ] **Homepage design**: a static HTML page, desktop + mobile, using the exact section 4 tokens (so the
      build later is a copy, not a redo). Publish it as a link + 2 screenshots → Willdene. **Today.**

Homepage sections:
1. **Header**: logo left, 5 links, small "Start a project" button
2. **Hero**: big serif headline, 2-line intro, yellow button + "See our work" text link, soft sun shape from the logo, lots of air
3. **Intro statement**: one large serif paragraph: who emma is and for whom
4. **Services**: 01–06 quiet numbered list with uppercase labels, each linking to its section on Services
5. **Featured work**: 2–3 case studies, big images, client + service label
6. **How we work**: 4 steps
7. **Testimonial**: one large serif quote. **Only if a real one exists**, otherwise the section is left out
8. **CTA band**: yellow fill, dark text, one button
9. **Footer**: logo, links, contact, legal line

### Phase 1 — Site setup (Day 3, Wed 09-23) · all as user `Developer`

- [ ] hPanel: note the plan, **daily backups yes/no**, staging tool yes/no. **Make a manual backup first**
- [ ] hPanel: create mailbox `hello@emmadigitalagency.com` (for sending form mail)
- [ ] Settings → Reading: **tick "Discourage search engines"**
- [ ] Settings → General: title "emma Digital Agency" (confirm the exact name), tagline, **timezone** (confirm: Paraguay = `America/Asuncion`, or the agency's market)
- [ ] Settings → Discussion: comments off
- [ ] Holding page for visitors during the build (Hostinger Tools' maintenance mode, or a simple "New site coming soon" front page)
- [ ] Remove the 4 Hostinger plugins + the AI theme + the 2 unused default themes (**after** the client's OK). Keep Twenty Twenty-Five as the fallback theme
- [ ] Install and activate the `emma` theme skeleton: `theme.json`, fonts, header, footer. This does not depend on the design approval, so **don't wait**
- [ ] Logo + site icon (`emma_favicon_sunflower_logo_exact_transparent`)
- [ ] Install `emma-core`

### Phase 2 — Homepage build → Milestone 1 (Day 4, **Thu 09-24**)

- [ ] Apply design feedback (round 1 on Day 3, round 2 on Day 4)
- [ ] Turn each section into a pattern; assemble `front-page.html`
- [ ] Create pages Home, About, Services, Portfolio, Contact (empty ones are fine); set Home as the front page; build the header menu
- [ ] Responsive check: 390 / 768 / 1024 / 1440 px
- [ ] **Submit M1** with the link + screenshots + a note on what comes next. **Ask Willdene to fund M2**
- If no design feedback arrives by Thursday morning: build the design as sent, and tell Willdene any change goes into the revision round. Silence must not move the due date

### Phase 3 — Portfolio system (Day 5, Fri 09-25) · **only after M2 is funded**

- [ ] `case_study` + `service` + "Project details" box + pre-filled headings
- [ ] `archive-case_study.html` with the service pills · `taxonomy-service.html` · `single-case_study.html`
- [ ] Test: add a case study as an editor would. Nothing may break

### Phase 4 — Services + pricing (Day 6, Sat 09-26)

- [ ] Services page: 6 `service-detail` sections, each with a CTA + a Query Loop for matching work
- [ ] `pricing-table` synced pattern, placed where the client wants it (question in section 12)
- [ ] Progress note + link to Willdene

### Phase 5 — About + Contact + form (Day 7, Sun 09-27)

- [ ] About: story, values, team patterns
- [ ] Contact: `contact-split` pattern + Fluent Forms (name, email, company, service of interest, budget, message)
- [ ] Turnstile spam protection · FluentSMTP via the Hostinger mailbox
- [ ] **Send a real test enquiry: it must reach the inbox, not spam.** Check SPF/DKIM for the domain in hPanel (checked 2026-09-22 via Google DNS: **no SPF record and no DMARC record** on the domain. Add SPF `v=spf1 include:_spf.mail.hostinger.com ~all` (confirm the exact value hPanel shows), turn on DKIM, and add a basic DMARC record, or form mail will land in spam)

### Phase 6 — Content + polish → Milestone 2 (Day 8, Mon 09-28)

- [ ] 3 case studies: real ones if they arrived, otherwise **clearly labelled "Sample project"**
- [ ] All 14 patterns registered and visible in the inserter
- [ ] Draft text on every page wherever real content is missing (honest, no invented numbers or clients)
- [ ] Full responsive pass on all 5 pages + the case study templates
- [ ] **Submit M2.** In the same message: ask for the **single revision list**, M3 funding, and any final content **by tomorrow (Day 9)**

### Phase 7 — Revision + launch prep (Day 9, Tue 09-29)

- [ ] The one revision round
- [ ] Add any real content that arrived
- [ ] The SEO Framework: title + meta on each page, one H1 per page, Open Graph image
- [ ] LiteSpeed: page cache, image optimisation (WebP), CSS/JS minify. Check nothing breaks
- [ ] Limit Login Attempts, `emma-core` hardening, all updates, backup schedule confirmed

### Phase 8 — QA, launch, handover → Milestone 3 (Day 10, **Wed 09-30**)

QA (see section 7) → then go live:
- [ ] Backup in hPanel
- [ ] Remove the holding page / maintenance mode
- [ ] **Untick "Discourage search engines"** (the classic forgotten step)
- [ ] Purge LiteSpeed + the object cache; test logged out in a private window
- [ ] Search Console: verify the domain (DNS TXT in hPanel) and submit the sitemap
- [ ] Handover pack (section 8) → **submit M3**

---

## 7. QA checklist (Day 10)

- [ ] All promises P1–P21 ticked
- [ ] Real phone + real tablet · Chrome, Safari, Firefox, Edge
- [ ] **No draft text, sample case study, made-up number or placeholder testimonial goes live** unless the client has agreed to it in writing
- [ ] Contrast: no yellow text; every text passes
- [ ] Form: arrives in the inbox, spam protection works, success message shows
- [ ] SEO: one H1 per page, titles, meta, sitemap, styled 404, site icon
- [ ] Speed: WebP images at the right sizes, lazy loading, preloaded fonts, cache on; mobile Lighthouse checked
- [ ] Security: login limit on, XML-RPC off, no unused plugins or themes, backup + restore point made
- [ ] The client, logged in, adds a test case study and changes a price **without help**
- [ ] `README.md` written; theme version bumped

---

## 8. Handover pack

1. **Written guide** (PDF, ~2 pages with screenshots): edit text · change a price · add a portfolio project · add a section from the patterns · where form emails go
2. **Video** (5–8 min screen recording) of the same 5 tasks
3. Theme `README.md`: file map, how the portfolio system works, the plugin list and why each is there
4. Handover message: which password to change, **remove the `Developer` account after approval**, what is still draft content
5. After M3 is approved: ask Willdene for the review and for the next project

---

## 9. Timeline at a glance

| Day | Date | Phase | Out to Willdene |
|---|---|---|---|
| 1 | Mon 09-21 | Contract, access | ✅ done |
| **2** | **Tue 09-22** | Phase 0: brand files, reply, **homepage design** | Design link + screenshots |
| 3 | Wed 09-23 | Phase 1: setup, theme skeleton, round 1 | Progress note |
| 4 | **Thu 09-24** | Phase 2: homepage built, round 2 | **Submit M1, ask for M2** |
| 5 | Fri 09-25 | Phase 3: portfolio system | — |
| 6 | Sat 09-26 | Phase 4: Services + pricing | Progress link |
| 7 | Sun 09-27 | Phase 5: About, Contact, form, SMTP | — |
| 8 | Mon 09-28 | Phase 6: case studies, polish | **Submit M2, ask for revisions + M3** |
| 9 | Tue 09-29 | Phase 7: revision, SEO, speed, security | — |
| 10 | **Wed 09-30** | Phase 8: QA, launch, handover | **Submit M3** |

---

## 10. Still missing from the client (none of it blocks the build)

Exact agency name + tagline · headline and intro · About story and team · service descriptions ·
**pricing (packages, currency, where prices show)** · 3 real portfolio projects + permission to show them ·
testimonials · contact details + form fields · **the address that should receive enquiries** · privacy
policy text (a draft exists) · timezone/market · Analytics / Search Console.

---

## 11. Risks

| Risk | What to do |
|---|---|
| **Only M1 is funded** | Ask for M2 when submitting M1. **No Phase 3 work before M2 is funded** |
| **No staging; we build on the live domain** | Discourage search engines + a holding page during the build; backup before each big step |
| Slow approvals (client abroad, messages go through Willdene) | Build as sent; changes go into the revision round |
| Content never arrives | Already agreed: draft stays, he edits later. Repeat it in the Day-8 message |
| $80 for 10 days | Time-box each phase. Extras get a quote, not free work |
| "Small changes any time before launch" (proposal) | Fine for text and images. Layout changes use the revision round |
| Invented proof on an agency site | Samples clearly labelled; nothing fake goes live |
| Form mail goes to spam (no SPF / DMARC in DNS, confirmed 09-22) | Fix SPF/DKIM in hPanel on Day 7, and test |
| Cache hides changes | Bump the theme version on every change; purge LiteSpeed + object cache |
| Passwords in the git repo | Never. Password manager only |

---

## 12. Messages to Willdene

### Option 1: recommended (custom theme, as promised)

```
Hi Willdene,

Thank you. I am in both WordPress and Hostinger, and everything works.

I checked the site. It is a fresh WordPress install on the live domain
with a Hostinger AI theme and four Hostinger plugins, and the homepage
is currently blank. So I will build directly on the domain, hidden from
Google and visitors behind a "coming soon" page until launch. Nothing
live will be affected.

The two reference sites are enough, no need for more examples. What they
share is a warm off-white background, elegant serif headlines with a
clean text font, one quiet accent colour and a lot of space. I will
bring that bright, spacious feeling to the agency site with his
sunflower yellow as the accent, and plan the page structure for an
agency, so visitors are led to the services, the work and the enquiry
form.

I will send the homepage design for his approval by the end of today.

A few short questions for the client. None of them stop my work:
1. Is the name "emma Digital Agency", and is there a tagline?
2. Pricing: should prices show on the Services page, the homepage, or
   both? Roughly how many packages?
3. Which email address should receive the enquiries from the form?
4. May I remove the four Hostinger plugins and the Hostinger theme?
   They are not needed, and removing them keeps the build clean, as he
   asked.

Best regards,
Ariful
```

### Option 2: only if you decide to switch to Hello + Elementor (must be agreed first)

```
Hi Willdene,

One question before I start the build. My plan was a fully custom theme
with no page builder. I can also build it on Elementor Pro with the
lightweight Hello theme. That gives the client drag-and-drop editing,
but it needs an Elementor Pro licence (paid yearly by the client) and
adds a page builder, which he wanted to avoid.

My recommendation is still the custom theme, since it matches what he
asked for. Please let me know which he prefers. The price and timeline
stay the same either way.

Best regards,
Ariful
```
