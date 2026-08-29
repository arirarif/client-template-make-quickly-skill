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

## P0 — Fix the LCP element (regression I introduced)

- [ ] **P0.1 Preload the hero poster**

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

- [ ] **P0.2 Shrink the slider posters I added**

  **Why:** the eight slide posters are hardcoded at `-d_1280`. Two of them
  actually download: 264.2 KiB + 256.1 KiB = **520 KiB**, and PSI's image
  audit asks 219.3 KiB back from them. The slider is below the fold at
  `top 2117`, so full width is wasted.

  **Do:** in snippet 2596, change every `-d_1280?region=us` to
  `-d_640?region=us`. Consider keeping only slide 1's poster eager.

  **Verify:** payload drops ~300 KiB; "Improve image delivery" savings fall.

  **Rollback:** revert the URLs to `-d_1280`.

- [ ] **P0.3 Re-run PSI mobile + desktop, record here**

  Result: `mobile ___ / desktop ___ · LCP ___ · TBT ___`

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
