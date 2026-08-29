# dvpfl.com — speed work todo

**Baseline for this list:** PSI run 2026-08-29 15:48 GMT+6 (`speed.md`).
Mobile **28** · FCP 5.8s · LCP 28.2s · TBT 1,840ms · SI 15.9s · payload 10,523 KiB
Desktop **—** · FCP 1.1s · LCP 5.5s · TBT 810ms · SI 6.2s

**Rule for this list: one task, one PSI re-run.** Never batch two changes.
The Aug 29 morning session batched a video change with a poster change and
could not attribute the regression afterwards. Don't repeat that.

**Measurement caveat:** WP Super Cache's purge is broken on this host
(see `dvpfl_deploy_gotchas`). PSI fetches the bare URL, which can serve a
stale copy. Before every PSI run, confirm the live HTML is current:

    curl -sSL "https://dvpfl.com/?cb=$RANDOM" | grep -o "DVPFL deferred video autoplay v[0-9.]*"

---

## ⛔ STOP — speed work is paused, and why

**2026-08-29 18:45.** Two PSI runs, 33 minutes apart, on a byte-identical
page (77,705 bytes both times, same plugin versions, same snippet v1.3):

| | 18:04 | 18:37 |
|---|---|---|
| Score | 35 | 34 |
| FCP | 4.7 s | **3.5 s** |
| LCP | 6.8 s | **5.6 s** |
| TBT | 1,200 ms | **3,460 ms** |
| Payload | 6,372 KiB | 3,993 KiB |

Nothing changed between them. That spread — TBT tripling, payload moving
2.4 MB — is **run-to-run variance**, and it is that wide because the page
sits on 26 JS files and 24 stylesheets with 9.6 s of main-thread work. The
deferred hero video also lands inside the trace window on some runs and not
others, which moves the payload figure on its own.

**Consequence: single-run comparisons are not trustworthy on this site.**
Any future measurement needs 3 runs and a median, or it should only quote
FCP and LCP, which held steady across both.

### Where the speed work actually got to

| | Aug 24 | now |
|---|---|---|
| Score | 41 → 28 (regression) | **34–35** |
| FCP | 3.9 s | **3.5 s** |
| LCP | 9.0 s | **5.6 s** |
| Payload | 21,352 KiB | ~4,000–6,400 KiB |

LCP and FCP are genuinely better than the original baseline, and those are
the two a visitor feels. The score does not reflect it because TBT now
dominates, and part of the payload drop is the missing portfolio section
rather than optimisation.

### Why further speed work is paused

1. **The portfolio slider is gone** (below). Optimising a homepage whose
   main content section is broken is wasted effort, and whatever fixes it
   will change every number again.
2. **Elementor Pro licence reads `Status: Missing`.** Pro 4.2.2 is running
   unlicensed. Custom Code is a Pro feature, and snippet 2596 — which holds
   all the speed work — lives in it. It still outputs today; that is not a
   guarantee.
3. **The remaining levers need a child theme.** Render-blocking is 2,940 ms
   across 24 stylesheets, and unused JS is 1,040 KiB. Fixing either means
   dequeuing in PHP. There is no child theme.

### Honest ceiling

Even with P1–P4 all done, this stack — Aurel plus Elementor plus 14 plugins
— realistically lands somewhere around **50–60 on mobile**, not 90. The
theme and page builder set the floor. Anyone promising 90+ without
replacing them is guessing.

---

## 🔴 CRITICAL — the portfolio slider has disappeared from the live site

**Found 2026-08-29 18:10, while verifying the P0 measurement.**

Between the 15:48 and 18:04 PSI runs, someone updated the plugins:

| Plugin | Was | Now |
|---|---|---|
| Elementor core | 3.20.3 | **4.2.3** |
| Elementor Pro | 3.7.2 | **4.2.2** |
| Contact Form 7 | 5.7.7 | 6.1.7 |
| Chaty | 3.1.1 | 3.6.0 |
| Image Hover addon | 1.3.8 | 1.4.5 |

This is the update the August audit flagged as Critical Issue #2 and warned
against: *"Updating Elementor core on its own will very likely break the
site."*

**It did.** The `pm-media-slider` widget — the portfolio slider holding all
nine wedding films — no longer renders. Measured on the live homepage with
my own snippet's text excluded from the count:

    pm-media-slider           0
    aurel_front_end_display   0
    aurel_slider_wrapper      0
    aurel_slider_slide        0
    pm_image_slider.js        not enqueued
    player.vimeo.com/api/player.js   not enqueued
    elementor-widget-video    1   (the hero, still fine)

Visually confirmed: the homepage now runs hero → "Sarasota Wedding
Videographers" banner → Paul's bio. The portfolio section is simply absent.

`pm-instagram` still renders on every page, so this is specific to the
media-slider widget, not every theme widget. Most likely the theme registers
that widget against Elementor's pre-4.x widget API.

**Scope — corrected 2026-08-29 19:00.** An earlier note here implied the
portfolio was gone from the site. It is not. Scanning all 17 pages for real
Vimeo embeds (the film IDs that appear on `/` are only my own snippet's CSS
selectors, not content):

    /highlight-recap/        7 films  (incl. 4 of the 9 homepage ones)
    /commercial/             4
    /memorial-video/         3
    /photo-montage/          3
    /music-video/            3
    /engagement-video/       1
    /cinematic-wedding-film/ 1
    /ceremony-video/         1

Roughly 23 films still live on the service pages. What is lost is the
**homepage showcase**, not the portfolio.

**Consequences:**
1. The homepage — where couples land — no longer shows any wedding films
   below the hero. Still a business problem, but narrower than first stated.
2. Roughly 4 MB of the 4,151 KiB payload drop is this section's absence,
   not optimisation. The 28 → 35 score is therefore partly hollow.
3. My video gate is now moot on this page — `Vimeo.Player.__dvpWrapped` is
   `false` because `player.js` is no longer loaded at all. The snippet is
   harmless and still does its hero job, but the slider half has nothing
   left to gate.
4. The v1.2 YouTube-API block is also moot — that script was loaded *by*
   `pm_image_slider.js`.

**Not fixed. Needs a decision:**
- (a) Roll the two Elementor plugins back (WP Rollback is installed) and
      accept the old versions plus their known vulnerabilities.
- (b) Keep the update, and rebuild the portfolio section with a widget that
      still works — Elementor Pro 4.x has its own carousel/gallery widgets.
- (c) ~~Ask the Aurel theme author for a 4.x-compatible version.~~
      **Ruled out 2026-08-29:** Appearance → Themes shows Aurel with no
      update available. Only Twenty Twenty-Four and Twenty Twenty-Five have
      updates pending. No 4.x-compatible build is coming through the channel.

**Recommended: (b), built as a self-contained HTML widget** rather than a
Pro widget — no theme dependency, no Pro-licence dependency, immune to the
next Elementor update, and it removes `pm_image_slider.js` and Vimeo's
`player.js` from the page permanently. That slider was the origin of the
15,704 KiB problem in the first place, so rebuilding it lean fixes the
content loss and the speed problem in one move. All 8 film IDs and their
poster URLs are already recorded in `home-deferred-autoplay-snippet.html`.

**Also open: Elementor Pro licence reads `Status: Missing`.** Pro 4.2.2 is
running unactivated — no updates, no support. Needs a key, or a decision.

**Do not touch this without Paul.** Losing the portfolio is a visible,
client-facing change.

---

## P0 — Fix the LCP element (regression I introduced)

- [x] **P0.1 Preload the hero poster** — DONE, snippet 2596 v1.3

  **Why:** PSI names the LCP element as
  `div.elementor-custom-embed-image-overlay` with a CSS
  `background-image`. Subparts: **resource load delay 3,800 ms**,
  element render delay 7,110 ms. PSI flags `fetchpriority=high should be
  applied` as failing. A CSS background image is invisible to the preload
  scanner — it is only discovered after CSS parse and layout.

  **Do:** add to the top of snippet 2596 (`<head>`, already loads early):

      <link rel="preload" as="image" fetchpriority="high"
            href="https://dvpfl.com/wp-content/uploads/2026/08/hero-poster-1920.jpg">

  **Verify:** PSI mobile → "Resource load delay" should collapse from
  3,800 ms toward ~0. LCP should drop well below 28.2 s.

  **Rollback:** remove the one line from snippet 2596.

- [x] **P0.2 Shrink the slider posters I added** — DONE, snippet 2596 v1.3

  **Why:** the eight slide posters are hardcoded at `-d_1280`. Two of them
  actually download: 264.2 KiB + 256.1 KiB = **520 KiB**, and PSI's image
  audit asks 219.3 KiB back from them. The slider is below the fold at
  `top 2117`, so full width is wasted.

  **Do:** in snippet 2596, change every `-d_1280?region=us` to
  `-d_640?region=us`. Consider keeping only slide 1's poster eager.

  **Verify:** payload drops ~300 KiB; "Improve image delivery" savings fall.

  **Rollback:** revert the URLs to `-d_640` back to `-d_1280`.

### What P0 actually shipped (v1.3, 2026-08-29)

It turned out to be more than a preload. The hero poster was being served
at **1920px wide to every device**, including a 412px-wide Moto G. The
smaller crops already existed on the server, so this cost nothing to fix:

| Viewport | Poster served | Bytes | vs. before |
|---|---|---|---|
| ≤ 767px | `-768x432.jpg` | 57,015 | **−150,066 (−72%)** |
| 768–1365px | `-1024x576.jpg` | 88,094 | −118,987 (−57%) |
| ≥ 1366px | `-1536x864.jpg` | 159,232 | −47,849 (−23%) |
| *(was)* | `hero-poster-1920.jpg` | 207,081 | — |

Slider posters, per slide: `-d_1280` 139,510 b → `-d_640` **45,210 b**
(−68%). Two of them download in a PSI run, so roughly −190 KB there.

Elementor hardcodes the 1920 into an inline `style` attribute, so the
override needs `!important` — an author `!important` does outrank a normal
inline style. Three `@media` blocks, each matching one preload link.

**Verified in the browser, not assumed:**

    overlayUsesImage = hero-poster-1920-1536x864.jpg   CSS override works
    posterRequests   = 1                                no double download
    initiatorType    = link                             the PRELOAD fetched it

That `init=link` is the whole point: the fetch now starts at parse time
instead of waiting for CSS parse + layout.

Breakpoint coverage was checked across 13 widths (320 → 2560). Exactly one
tier matches at every width — no gaps, no overlaps, so the browser never
preloads a poster it will not paint, and never misses one.

- [x] **P0.3 Re-run PSI — DONE 2026-08-29 18:04**

  **Blocked on you** — the PSI API is out of daily quota without a key
  (`HTTP 429`, "Queries per day"). Run it in the browser and paste the
  result; I cannot self-measure this one.

  Bare URL confirmed serving v1.3, so PSI will measure the right version.

### P0 result — measured 2026-08-29 18:04

| Mobile | 15:48 (before P0) | 18:04 (after P0) |
|---|---|---|
| **Score** | 28 | **35** |
| FCP | 5.8 s | 4.7 s |
| **LCP** | **28.2 s** | **6.8 s** |
| TBT | 1,840 ms | 1,200 ms |
| Speed Index | 15.9 s | 9.8 s |
| Payload | 10,523 KiB | 6,372 KiB |

**The LCP element changed, which is the proof P0.1 worked.** The poster is
no longer the LCP candidate at all. The breakdown now reads:

    Time to first byte     0 ms
    Element render delay   3,070 ms
    CALL US NOW!!!  <span class="on-hover-text">

There is no "Resource load delay" row any more, because the LCP element is
now *text* — Chaty's floating call widget — not an image. The 3,800 ms of
load delay did not shrink, it ceased to exist.

**Caveat, and it is a big one:** part of this gain is not optimisation.
See the CRITICAL entry below — a whole content section vanished from the
page between the two runs, taking its bytes with it.

---

## P1 — reCAPTCHA is loading four times

- [ ] **P1.1 Load reCAPTCHA only on /contact-us/**

  **Why:** the payload audit lists

      Google CDN                    1,378.7 KiB
        recaptcha__en.js  344.7 KiB   x4

  Four identical copies, on a page with no visible form. After the hero
  video this is now the single biggest thing on the homepage, and a prime
  suspect for TBT 1,840 ms / main-thread 7.8 s / 20 long tasks.

  **Do (in order of preference):**
  1. Contact Form 7 settings — remove the reCAPTCHA site key if the form
     does not actually use it, or restrict loading to the contact page.
  2. If CF7 offers no scoping, block it the same way the YouTube API was
     blocked: an `insertBefore` refusal in a **new** Custom Code snippet
     scoped to *everything except* `/contact-us/`. Same pattern as
     `blockYouTubeApi` in `home-deferred-autoplay-snippet.html`.

  **Already checked — the answer is no.** On the live homepage:

      <form> tags in HTML        0
      "recaptcha" in HTML        0
      "wpcf7" in HTML            1   (a script/style handle, not a form)

  So there is no form on this page, and reCAPTCHA appears nowhere in the
  markup - CF7 enqueues Google's API script sitewide whenever a site key is
  configured, and Google's script then pulls `recaptcha__en.js` itself.
  That makes all 1,378.7 KiB pure waste here, not merely excessive.

  This also means the fix does not risk breaking a form on this page,
  because there is no form on this page.

  **Verify:** payload −1.3 MB; TBT should fall sharply.

  **Rollback:** restore the key / trash the new snippet.

- [ ] **P1.2 Re-run PSI, record here**

  Result: `mobile ___ / desktop ___ · TBT ___`

---

## P2 — 27 render-blocking requests, 1,650 ms

- [ ] **P2.1 Turn on Elementor "Improved CSS Loading"**

  **Where:** Elementor → Settings → Experiments.
  **Risk:** low, but it is an Elementor experiment on a site pinned to
  3.20.3 — check the homepage and one service page visually after.

- [ ] **P2.2 Dequeue theme CSS the homepage never uses**

  From the render-blocking list, the homepage loads:
  `owl.carousel.css`, `photoswipe.css`, `default-skin.css`,
  `pm-instagram.css` — none of which the page appears to need.

  **Blocker:** dequeuing is PHP, and there is no child theme. Options:
  (a) create a child theme (Aurel has no update channel, so it is safe and
  overdue), or (b) leave this one until a child theme exists.
  **This is the first task that genuinely needs a child theme.**

- [ ] **P2.3 `eicons.woff2` — 94.96 KiB on the critical path at 4,212 ms**

  Elementor's icon font. Check whether the homepage uses any eicon at all;
  if not, it is pure critical-path cost.

- [ ] **P2.4 Re-run PSI, record here**

  Result: `mobile ___ / desktop ___ · FCP ___`

---

## P3 — Hero video still streams 4.3 MB (needs Paul's decision)

Two segments, 2,187.7 + 2,100.5 KiB. This is the hero autoplaying, which is
**working as requested** — not a bug. Three options, pick one:

- [ ] **P3.a** Leave as is. Costs every mobile visitor 4.3 MB.
- [ ] **P3.b** Set `MOBILE_VIDEO = false` in snippet 2596 → phones get the
      poster only. Saves 4.3 MB on mobile, worth roughly 10 points. One-word
      edit, instantly reversible.
- [ ] **P3.c** Self-host a 12–15 s muted MP4 loop (~1.5 MB) for the hero.
      Also removes the entire Vimeo player stack from the critical path:
      `player.module.js`, `vendor.module.js`, `player.css`, `vuid.min.js`,
      `oembed.json`, `flarepoint`, `identity/settings` — ~8 third-party
      requests and 628 KiB of JS. Best result, most work. Keep the Vimeo
      embed for the portfolio slider, where people watch with sound.

---

## P4 — Images, 560 KiB

- [ ] **P4.1** `videographer-owner.png` — 213.3 KiB, **187 KiB savings**.
      A PNG of a photograph. Convert to WebP.
- [ ] **P4.2** `hotel2.jpg` — 145.1 KiB, 75.9 KiB savings.
- [ ] **P4.3** Three `1644015*-768x400.jpeg` — served at 768x400, displayed
      at 581x303. Fix the responsive sizes; ~57 KiB total.
- [ ] **P4.4** `dvpfl-logo.png` — 22.6 KiB, 15.4 KiB savings.
- [ ] **P4.5** Re-run PSI, record here

  Result: `mobile ___ / desktop ___`

---

## P5 — Blocked / not speed work

- [ ] **WP Super Cache purge is broken.** Delete Cache does nothing from the
      Contents tab, the Easy tab, or the front-end admin-bar link — page
      count and byte sizes unchanged. Every measurement is suspect until
      this is fixed. Raise with Paul; may need host-level file deletion.
- [ ] **Elementor 3.20.3 / Pro 3.7.2** — licence blocker, unchanged.
      Do NOT click "Begin updating plugins".

---

## Expected trajectory

| Step | Mobile |
|---|---|
| now | 28 |
| after P0 | ~40 |
| after P1 | ~52 |
| after P2 | ~62 |
| after P4 | ~68 |
| after P3.c | 75–80 |

These are estimates from the audit's own savings figures, not promises.
Record the real number after each step in the slots above.
