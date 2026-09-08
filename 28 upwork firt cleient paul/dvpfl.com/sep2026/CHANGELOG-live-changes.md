# dvpfl.com — live change log, September 2026

Continues `../CHANGELOG-live-changes.md` (the Aug 24–31 overhaul).
Part of the $300 job (`../../SCOPE-2026-09-03-300usd.md`).

**Site rules that governed this session** (from the August work — do not relearn the hard way):
no child theme exists, so custom work ships through Elementor → Custom Code · WP Rocket +
Perfmatters are the stack and **no second cache plugin may be activated** · the mobile LCP element
is the floating call-button label, so it must not be hidden or restyled · always "Clear and
preload" in WP Rocket after a change.

**Backups:** the site owner confirmed they hold their own backups of all three sites, so no backup
plugin was installed here (unlike BNB and Express, which had none).

---

## 2026-09-08

### Read-only audit first — DVPFL is structurally clean

Checked for the defect found on BNB. **DVPFL has none of it:** exactly one JSON-LD block per page,
no placeholder URLs, no `@id` collisions, canonicals correct throughout.

```
/            ld=1  WebPage, ImageObject, BreadcrumbList, WebSite, Organization
/packages/   ld=1  WebPage, BreadcrumbList, WebSite, Organization
/contact/    ld=1  WebPage (canonical /contact-us/), BreadcrumbList, WebSite, Organization
```

### 1. Four plugin updates applied, two not

| Plugin | Before | After |
|---|---|---|
| Elementor | 4.2.3 | **4.2.4** |
| Meta Box | 5.14.1 | **5.15.0** |
| Schema & Structured Data for WP & AMP | 1.65 | **1.66** |
| Site Kit by Google | 1.186.0 | **1.187.0** |

**Held deliberately:** All-in-One WP Migration 6.77 → 7.110 — a 30+ release jump, same call as the
other two sites.

**Failed silently — and this one matters:** **Elementor Pro stayed on 4.2.2** despite being
selected. This is the licence problem recorded in August: the Pro licence on this site reads
**"Missing"**, and Elementor Pro will not pull an update without a valid one. The update simply
did not happen; nothing errored on screen.

**Consequence:** the site now runs **Elementor core 4.2.4 with Elementor Pro 4.2.2**. A core/Pro
version gap is exactly the configuration that broke the portfolio slider widget on 2026-08-29.
The homepage is fine today — the slider on it is the custom rebuild from August, which does not
depend on the Pro widget and is therefore immune — but the gap will widen with every core release
until the licence is activated.

**This is Paul's to fix:** it is his purchase, not a technical blocker. Until then, Elementor core
should arguably be held back too, so the two stay in step.

### 2. Elementor database update completed

After the core update, Elementor showed "Database update process is running in the background."
Ran it to completion rather than leaving it half-applied — an interrupted Elementor DB migration
is a good way to get inconsistent element data.

*Verified:* "The database update process is now complete."

### 3. WP Rocket cleared and preloaded

Required on this site after any change.

*Verified after everything above:*

```
/              200   92,993b   h1=1   tel: present   no fatals
/packages/     200   71,451b   h1=1   tel: present   no fatals
/contact-us/   200   62,935b   h1=1   tel: present   no fatals
```

Also confirmed the August fixes all survived: **no preloader** (the 17 `loading=` hits are
lazy-load attributes, not the old LOADING screen), exactly one H1, footer reads
**"© 2026 Digital Video Productions LLC"**, the floating call button is intact, and the rebuilt
portfolio slider still renders. Page-regression gate: **27/27 URLs returning 200**.

### 4. `/thank-you/` page created (page 2681)

The newsletter signup's redirect target. This site uses the block editor rather than the classic
one, so the flow differed from the other two — worth knowing next time.

*Verified:* returns **200**.
*Same caveat:* not `noindex`; Yoast's dropdown would not persist through automation.

### 5. Full on-page audit (read-only) — the August content work has held

Crawled all **28 indexed pages** (post + page sitemaps). The result is a good report card:

- **Exactly one H1 on every page** — the audit's issue #8 stays closed
- **No duplicate titles and no duplicate meta descriptions.** This is the one worth noting: the
  August audit found *18 pages sharing a single description*. All 28 are now unique, so that fix
  did not regress through two rounds of plugin updates.
- Title lengths 34–112 characters, descriptions 128–284 — service pages sit in a healthy band

**The one real gap: 38 images have no alt text.** Concentrated rather than scattered:

| Page | Missing / total |
|---|---|
| `/awards/` | **18 of 19** |
| `/blog/` | 5 of 10 |
| `/` | 4 of 12 |
| `/about-us/` | 3 of 3 |
| `/thank-you/` | 3 of 3 (template images on the new page) |
| 6 blog posts | 1 each |

`/awards/` is the page that matters most here — those are award badges, which are trust signals for
couples comparing videographers, and they are currently invisible to screen readers and to Google
Images. Fixing them is Media Library alt text, the same route used on BNB and Express, but it is
roughly 20 separate attachment edits rather than the single shared logo those sites needed.

**Not started.** It is a discrete chunk of work, and mid-audit the local DNS began failing
intermittently (`EAI_AGAIN` on repeated lookups, while other hosts resolved fine), so I stopped
rather than push edits through a flaky connection. Queued below.

**Also noted:** the new `/thank-you/` page has no meta description. Harmless while it is a
conversion target rather than a landing page, and it should be `noindex` anyway.

---

## Still to do on this site

- [ ] **Alt text for 38 images**, starting with the 18 award badges on `/awards/` — accessibility and image search
- [ ] Set `/thank-you/` to noindex by hand (Yoast dropdown will not take a programmatic change)

- [ ] **Elementor Pro licence** — blocks Pro updates and is widening a core/Pro version gap. Paul's call.
- [ ] All-in-One WP Migration major update, once someone wants to babysit it
- [ ] Signup form via Elementor Custom Code, once the Brevo account exists
- [ ] GBP link + `sameAs` in schema, once the profile exists
- [ ] Blog still dead since June 2022 — needs Paul's input, unchanged since August
