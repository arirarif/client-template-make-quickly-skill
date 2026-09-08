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

---

## Still to do on this site

- [ ] **Elementor Pro licence** — blocks Pro updates and is widening a core/Pro version gap. Paul's call.
- [ ] All-in-One WP Migration major update, once someone wants to babysit it
- [ ] Signup form via Elementor Custom Code, once the Brevo account exists
- [ ] GBP link + `sameAs` in schema, once the profile exists
- [ ] Blog still dead since June 2022 — needs Paul's input, unchanged since August
