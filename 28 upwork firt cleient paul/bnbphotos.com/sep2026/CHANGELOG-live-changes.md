# bnbphotos.com — live change log, September 2026 ($300 job)

Every change made to the live site, with how to undo it.
Scope: `../../SCOPE-2026-09-03-300usd.md` · Gates: `../../GATES-300usd.md`

---

## 2026-09-07

### Read-only findings first (nothing changed)

| Finding | Detail |
|---|---|
| **Unknown plugin: Rectifi 1.2.0** | "Scan. Score. Rectify." by Rakibul Islam. ACTIVE. Not present in the 2026-08-24 inventory. Performs "auto-fixes" and "automated hardening". Provenance unconfirmed — flagged to the site owner, deliberately NOT touched. |
| **10 failed emails in 30 days** | WP Mail SMTP 4.9.0 Lite, Gmail API, connected as dvppaul@gmail.com. 82 emails total. Lite hides which ones failed. Potential lost leads — needs a real delivery test. |
| **25 failed logins as `admin`** | Wordfence 9.0.0 active, but login rate-limiting still unconfigured. No user named `admin` exists, so these are blind brute-force attempts. |
| **Fluent Forms is the FREE tier** | Integrations → Modules is empty. No Brevo integration and no webhooks. This settles the open question in the Brevo runbook: contact-form → list sync needs either Fluent Forms Pro or the manual-export fallback. |
| 7 plugin updates pending | Elementor 4.2.4, Elementor Pro 4.2.3, Fluent Forms 6.2.13, WPCode 2.3.9, Yoast 28.4, Seraphinite 2.29.23, All-in-One WP Migration 7.110 |
| No backup existed | All-in-One WP Migration was installed but DEACTIVATED. Nothing was backing this site up. |
| Slider Revolution ×4 | Still installed, inactive since August. Safe to delete later; leaving them costs nothing at runtime. |

### Changes made

**1. Installed and activated UpdraftPlus 1.26.7** (free, from the official WordPress.org
directory — not a third-party plugin site).
*Why:* the site had no backup at all, and seven plugin updates were pending. Updating a live
client site with no rollback path is not acceptable.
*Undo:* Plugins → UpdraftPlus → Deactivate → Delete.

**2. Ran a full backup** (database + files), flagged **"only allow this backup to be deleted
manually"** so retention rules cannot purge the pre-update safety copy.
*Undo:* n/a — additive. The backup lives in `wp-content/updraft/`.

**3. Plugin updates — 5 of 7 applied, 2 deliberately held.**

| Plugin | Before | After |
|---|---|---|
| Elementor | 4.2.3 | **4.2.4** |
| Elementor Pro | 4.2.2 | **4.2.3** |
| Fluent Forms | 6.2.12 | **6.2.13** |
| WPCode Lite | 2.3.8 | **2.3.9** |
| Seraphinite Accelerator | 2.29.20 | **2.29.23** |

**Held on purpose:**
- **Yoast SEO 28.3 → 28.4** — Yoast SEO *Premium* on this site is 28.1 and reads "Activate your
  subscription". Premium and free are version-paired; pushing free further ahead widens a gap
  that is already two releases. Fix the licence first, then update both together.
- **All-in-One WP Migration 6.77 → 7.110** — a jump of 30+ releases, and the plugin is
  **deactivated**, so it carries no live risk. Not worth the blast radius during this job.

*Verified after updating:* homepage HTTP 200, no PHP fatals or warnings, exactly one H1
(the August fix still holds), Seraphinite still serving, page weight unchanged at 285,860 bytes.
Regression gate `node scripts/check-300usd.mjs pages` passed: **express 16/16, bnb 16/16,
dvpfl 27/27** URLs returning 200.

*Undo:* UpdraftPlus → Existing backups → the Sep 07 18:34 set → Restore (Plugins), or roll back
an individual plugin from its own zip.

**Note on the "Automatic update scheduled in 5 hours" notices:** these appear against several
plugins but the list header still reads "Auto-updates Disabled (19)". Not changed by me; worth
a second look, because silent auto-updates on a client site are how a working page quietly breaks.

### Rectifi — recommended for removal, then NOT removed. Recommendation withdrawn.

Owner confirmed the plugin is his and approved deactivating it. I opened its dashboard first
and the module list contradicts the assumption my advice rested on, so it stays.

Rectifi is not a redundant second scanner sitting idle. It is **actively supplying hardening
that nothing else on this site replaces**, including:

- `xmlrpc.php` blocked · REST/`?author=` user-enumeration blocked
- HTTP security headers (X-Frame-Options, X-Content-Type-Options, Referrer-Policy)
- **PHP execution blocked inside `wp-content/uploads/`** — the single most valuable item here;
  it is how an uploaded backdoor gets run
- PHP execution blocked under `wp-includes/`; dangerous upload types (.exe/.sh/.bat) blocked
- Direct web access to `wp-config.php` and to `.env`/`.git`/`.sql`/logs blocked
- Directory listing off · WordPress version fingerprint stripped
- Brute-force login lockout, math CAPTCHA on the login form, per-IP rate limiting, and a WAF

Verified live from outside the site, 2026-09-07:

```
xmlrpc.php               -> 404
/wp-json/wp/v2/users     -> 404
x-frame-options          -> SAMEORIGIN
x-content-type-options   -> nosniff
referrer-policy          -> strict-origin-when-cross-origin
strict-transport-security-> (absent)
```

**This matters for the record:** the August audit notes list "xmlrpc returns 404", "REST users
404" and "has X-Frame-Options / X-Content-Type-Options / Referrer-Policy" as *already resolved*,
with no cause recorded. Rectifi is the most likely source. Deactivating it would therefore have
silently reopened several findings we have been treating as closed — including the uploads-folder
PHP block, which Wordfence free does not provide.

**Decision: keep it active.** Wordfence overlaps on WAF and login lockout only; it does not
replace the filesystem and attack-surface rules. If it is ever removed, those rules must be
re-implemented in `.htaccess` first, not after.

**Its own three open items (all "manual step required", all genuine):**

1. **Theme/Plugin File Editor is enabled** — any admin-level compromise can write a backdoor
   straight into a theme file. Fix: `define('DISALLOW_FILE_EDIT', true);` in `wp-config.php`.
2. **Login page is at the default `/wp-login.php`** — matches the 25 blind `admin` brute-force
   attempts Wordfence logged this week.
3. **`wp-cron.php` is publicly reachable** — a cheap DoS vector, and it also fires on every real
   page view. Fix: disable WP-Cron over HTTP and run it from a real server cron.

Not applied yet: items 1 and 3 need `wp-config.php` edits, which is a different risk class from a
plugin update and should be done deliberately, with the backup already in place.

### OPEN ISSUE — pages regenerating much heavier after the Seraphinite update (diagnosis corrected below)

**Found while verifying the plugin updates. Not resolved. Needs host-level access.**

The homepage renders fine. What is cached against the bare `/` URL does not.

| Request | Bytes | Stylesheet links |
|---|---|---|
| `https://www.bnbphotos.com/` | **874,254** | **165** |
| `https://www.bnbphotos.com/?cachebust=<random>` | **259,079** | **35** |
| `/services/` | 131,253 | 23 |
| `/contact/` | 390,039 | 116 |

A cache-busted request proves WordPress is generating a **healthy 259 KB / 35-stylesheet page
right now**. Real visitors landing on `/` get a stale 874 KB / 165-stylesheet copy instead —
byte-identical on every request, unchanged over ~20 minutes of testing.

**When it changed:** `/` returned 285,860 bytes consistently earlier the same day, including
immediately after the Elementor, Elementor Pro, Fluent Forms and Seraphinite updates. It jumped
to 874,254 after the WPCode PHP snippet was activated — most likely that activation invalidated
Seraphinite's optimisation objects (Cache statistics showed `Objects: 0 (0.0 B)`) and the stale
copy at `/` was never replaced.

**What was tried, in order, and did not fix it:**
1. Seraphinite → Manager → **Revalidate cache** (All) — ran, no change
2. `wp-cron.php` pinged three times to drain the optimisation queue — HTTP 200 each, no change
   (Manager also reported `Pending: 0, processing: 0`)
3. Settings → Scripts and styles — optimisation toggles confirmed still **ON**; the update did
   not reset them
4. Seraphinite → **Delete cache** (All), then warmed `/`, `/services/`, `/contact/` — no change
5. Seraphinite → **Delete server's cache (if available)** — no change

**Ruled out:** the free-tier quota. Manager reports **1,184 of 5,000** page visits used until
18 Sep 2026, so optimisation is not throttled.

**Diagnosis:** a cache layer above the plugin — host-level (LiteSpeed/Varnish/NGINX FastCGI or
similar) — is holding the old homepage response for the canonical URL. Seraphinite's own purge
buttons do not reach it. This is the same class of trap already recorded for dvpfl.com, where
the cache purge silently did nothing and only a `?cachebust` request revealed the truth.

**Next step (needs hosting panel access, which I do not have):** purge the host cache for
`https://www.bnbphotos.com/`. A forced re-save of the Home page would also invalidate that one
URL — but **do not open the BNB homepage in Elementor to do it**; use Quick Edit → Update from
Pages, or the host's purge control.

**Rollback available if it turns out to be Seraphinite 2.29.23:** UpdraftPlus → Existing backups
→ Sep 07 18:34 → Restore (Plugins) returns Seraphinite to 2.29.20.

#### CORRECTION — the "stale cache / needs a host purge" diagnosis above was WRONG

Response headers settle it. Recorded here rather than quietly edited out, because the wrong
diagnosis would have sent the next person to the hosting panel for nothing.

```
/            874,254 b  165 css  x-seraph-accel-cache: state=cache; date="2026-09-07 19:14:38"
/services/   453,571 b  111 css  x-seraph-accel-cache: state=cache; date="2026-09-07 19:06:17"
/contact/    390,039 b  116 css  x-seraph-accel-cache: state=cache; date="2026-09-07 19:06:06"
/?cb=<rand>  259,079 b   35 css  x-seraph-accel-cache: state=skipped; reason="exclArgsAll"
```

Two things I had backwards:

1. **The cache is not stale.** Every page carries `state=cache` with a timestamp from *minutes
   ago*. Seraphinite regenerated them and the fresh output is simply heavier. No host-level
   cache is involved, and no host purge is needed.
2. **The 259 KB `?cachebust` response was never "the healthy render".** Query-string requests are
   **excluded from Seraphinite entirely** (`state=skipped; reason="exclArgsAll"`). That number is
   the page *without* the optimizer, so it was never the target to get back to.

**What actually happened.** Seraphinite's self-learned optimisation data was lost — the Manager
showed `Objects: 0 (0.0 B)` — and regeneration without that learning produces a much less
optimised page. The homepage went first, when the WPCode snippet activation invalidated it.
**Deleting the cache (step 4 above) then spread it to every page:** `/services/` measured a lean
131,253 bytes / 23 stylesheets *before* that click and 453,571 / 111 after. That one is on me.

**Why warming did not fix it.** Two full passes over all 10 sitemap URLs changed nothing: the
homepage entry is pinned at `date="2026-09-07 19:14:38"` under `cache-control: max-age=3600`.
Nothing regenerates until that hour is up, so any self-learning gain can only appear on the
*next* generation.

**Correct next step — re-measure, do not click anything else.** After the TTL expires, re-check:

```
node scripts/check-300usd.mjs pages     # regression guard, still passing
node -e "fetch('https://www.bnbphotos.com/').then(r=>r.text()).then(t=>console.log(t.length))"
```

If it is still ~874 KB once entries regenerate, the update itself is the cause and the fix is to
roll Seraphinite back: **UpdraftPlus → Existing backups → Sep 07 18:34 → Restore (Plugins)**
returns 2.29.20. That backup predates every change made today.

**Impact:** the site is fully functional — all 16 URLs return 200 throughout — but the mobile 94
baseline is at risk until page weight comes back down. Gate G5 stays unmet, deliberately.

#### Follow-up 2026-09-08 — it does not self-heal, and PSI could not be measured

Re-measured ~10 hours later (05:07 UTC 8 Sep vs cache written 19:14 on 7 Sep):

```
/            874,254b css=165  state=cache; date="2026-09-07 19:14:38"
/services/   453,571b css=111  state=cache; date="2026-09-07 19:06:17"
/contact/    390,039b css=116  state=cache; date="2026-09-07 19:06:06"
```

**Identical bytes, identical timestamps.** The `max-age=3600` header governs downstream caches;
Seraphinite's own stored entries do not expire and regenerate on their own. So waiting does not
fix this, and the earlier "re-measure after the TTL" plan was wrong — there is no TTL to wait out.
This is the steady state until something invalidates the cache, and the only invalidation so far
regenerated it *heavier*, because the self-learning data is gone.

**PSI could not be run, by either route:**
- API: `HTTP 429, Quota exceeded ... queries per day` — the same limitation already recorded in
  the August Express gates.
- Web UI (pagespeed.web.dev): the report was generated (11:08:58, 8 Sep) but the page never
  finished rendering the score across five waits totalling ~50s.

So gate G5 stays **unmet and unmeasured** — not assumed either way. What is known is structural:
165 stylesheet links on a homepage that previously scored mobile 94.

**Two candidate fixes, neither applied — the owner should pick:**

1. **Seraphinite setup wizard** (Settings → Basic → "Begin setup wizard"). Rebuilds its
   optimisation configuration and learning. Cheap, reversible, but it can change settings that
   were tuned in August — worth an export first (Settings → Export).
2. **Roll the plugin back to 2.29.20.** The pre-update backup (Sep 07 18:34) predates everything.
   Caveat worth knowing before choosing: UpdraftPlus restores the whole plugins directory, so it
   would also revert the Elementor, Elementor Pro, Fluent Forms and WPCode updates. Installing
   2.29.20 on its own from the WordPress.org version archive is the narrower move.

**Not doing either unprompted.** Both are live changes to a working site whose availability is
currently fine, and choosing wrong costs more than waiting for a decision.

### ROOT CAUSE FOUND for Paul's Google emails — fix blocked by Wordfence

Paul forwarded two Search Console warnings (6 Sep 2026), both:
**"Duplicate, Google chose different canonical than user"**, one for sitemap pages and one general.

**Diagnosis — it is not the canonicals.** A full crawl found all 16 sitemap URLs carrying correct
self-referencing canonicals, no duplicate titles, no trailing-slash duplicates, and only one host
variant serving 200 (`http`, non-www and `/index.php` all 301 correctly).

**The actual cause is conflicting structured data.** Every page emits **three** JSON-LD blocks:

| Block | Source | Content |
|---|---|---|
| 0 | Yoast — correct | `WebPage` for the real URL, BreadcrumbList, WebSite, Organization |
| 1 | **WPCode → Header & Footer → Header** | `WebPage` + `Service` + `BreadcrumbList` for **`https://www.bnbphotos.com/REPLACE-WITH-EXACT-PHOTOGRAPHY-URL/`** |
| 2 | WPCode snippet 3207 | LocalBusiness + a BreadcrumbList whose `@id` collides with Yoast's |

Block 1 is hardcoded, **not conditional**, and identical on every page — homepage, service pages,
contact, archives. So every page tells Google "the WebPage entity here is a URL that does not
exist". `/REPLACE-WITH-EXACT-PHOTOGRAPHY-URL/` and `/REPLACE-WITH-EXACT-SERVICES-PAGE-URL/` both
return **404**. Ten occurrences per page. That is a direct contradiction of each page's own
canonical tag, and it is a textbook trigger for exactly the warning Google sent.

Someone pasted a schema template into the global header and never replaced the placeholders.
The blog posts themselves are clean — the placeholders exist only in this header block.

**Exact location:** WordPress → Code Snippets → **Header & Footer** → *Header* box, **lines 10–91**
(`<script type="application/ld+json">` through its closing `</script>`). Lines 1–8 are the Google
site-verification meta and the GTM container and must stay.

**The removed block is saved** at `REMOVED-header-jsonld-2026-09-08.json` (3,068 bytes) so nothing
is lost.

**Why it is not fixed yet — Wordfence blocks the save.** Two attempts, both refused:

```
403 Forbidden — "A potentially unsafe operation has been detected in your request to this site"
Block Reason: A potentially unsafe operation has been detected in your request to this site
Time: Tue, 8 Sep 2026 13:56:43 GMT
```

Wordfence's firewall rejects any POST to that field because the content contains `<script>` tags —
the standard stored-XSS rule. It will refuse the save even after the JSON-LD is deleted, because
the GTM container that must stay is also a `<script>`. The same rule is the likely reason an
earlier snippet Update silently failed.

**This needs a decision, because every route is a security-setting change:**

1. **Allowlist that one action in Wordfence.** The 403 page offers "I am certain this is a false
   positive" → *Allowlist This Action*. Narrow, and it is the intended mechanism — but it is a
   change to the site's firewall, so it is the owner's call, not mine.
2. **Briefly disable the Wordfence firewall**, save, re-enable. Wider exposure, even if short.
3. **Edit `wp_options` directly** (the field is stored there). Avoids the WAF, but a database edit
   is a heavier instrument than the problem deserves.

**Not attempted without approval.** Nothing about this is urgent to the minute — the site works,
all URLs return 200 — but it is the direct cause of the indexing warnings Paul is receiving, so it
should be the next thing done.

**Also verified while investigating** (all fine, no action needed): 16/16 sitemap URLs have
self-canonicals · one 200-serving host variant · no duplicate titles · no trailing-slash twins ·
`/blog/`, `/?p=1`, `/tag/*` all 404 · date archive `/2026/05/` and `/author/paul/` are indexable
and thin, which is worth a `noindex` later but is not what Google is complaining about.

**Snippet 3207 was toggled off briefly during the hunt and put back.** It was ruled out as the
source of block 1, and its LocalBusiness schema is worth keeping until the GBP work replaces it
with a correct one carrying `sameAs`.

### 2026-09-08 — traffic fixes that did not need the firewall

With the schema fix parked behind the Wordfence decision, these were done instead.

**4. Author archive disabled (Yoast → Author archives → "Enable author archives" off).**
Yoast's own warning applies exactly here: on a one-author blog the author archive is a duplicate
of the homepage. `/author/paul/` listed the same three posts as every other archive.
*Verified:* `/author/paul/` now returns **301 → homepage**, `author-sitemap.xml` returns 404, and
the sitemap index is down to post / page / category. One duplicate-content source removed, and it
is one of the signals behind the warning Google sent.
*Undo:* same toggle back on.
*Note:* the first check showed 200 because Seraphinite was serving a cached copy — a cache-busted
request showed the 301. Worth remembering on this site: **verify with `?v=` or the answer lies.**

**5. Florida Rentals badge alt text (Media → logo_floridarentals.svg → Alternative Text).**
Set to "FloridaRentals.com member badge". The badge sits in Header #1, so it was the one missing
alt on **every page of the site**.
*Verified:* homepage now reports **0 of 7 images missing alt**.
*Gotcha worth keeping:* saving the attachment alt was not enough — the page still rendered
`alt=""` because Elementor had the old markup cached. **Elementor → Tools → Clear Files & Data**
was required before it appeared. The REST endpoint (`/wp-json/wp/v2/media/2963`) was the thing
that proved the save had worked while the page still showed the old value.

**6. `llms.txt` published** (Yoast → Site features → llms.txt, was off).
*Verified:* `https://www.bnbphotos.com/llms.txt` returns **200**, 1,152 bytes, correctly naming
the business and listing the real pages. This is how ChatGPT, Claude and similar assistants
describe the business when someone asks them for a vacation-rental photographer. DVPFL already
had one; BNB's was a 404. Free, one toggle.

**7. Category meta descriptions fixed at the template level**
(Yoast → Categories → Meta description → `%%term_description%%`).
Both category archives were emitting **no meta description at all**, so Google was inventing the
snippet. The descriptions already existed as WordPress term descriptions — Yoast simply had no
template telling it to use them. Setting the variable fixes every category at once, including any
added later, rather than editing terms one by one.
*Verified:*
```
/category/airbnb-tips/          desc 116 chars  "Practical tips for Airbnb and vacation rental hosts..."
/category/photography-guides/   desc 105 chars  "How professional property photography works..."
```
*Undo:* clear the field.

**8. `/thank-you/` page created** (page 3337, "You're on the list").
The redirect target for the newsletter signup, and what makes a subscription measurable in GA4
rather than invisible. Written now so the Brevo setup has nothing left to wait on.

*Verified:* returns **200**. Gate G4 passes across all three sites.

**Not achieved — noindex.** The page should be `noindex` (a thank-you page in search results is
noise, and it can leak as a landing page). Yoast's "Allow search engines to show this content"
dropdown **would not persist** through two attempts — it reverted to "Yes" on reload, and the page
is still in `page-sitemap.xml`. This is the same class of failure as the WPCode saves: a
React-controlled input that does not accept a programmatic change. **Someone should set it by hand:
Pages → You're on the list → Yoast → Advanced → "Allow search engines…" → No.** Consequence of
leaving it: cosmetic, not harmful.

**Checked and already fine — no action needed:**
- Date archive `/2026/05/` is already `noindex, follow`
- All 15 indexed pages: exactly one H1 each, titles 41–56 characters, meta descriptions 123–140
- One host variant serves 200; http, non-www and `/index.php` all 301 correctly
- `/blog/`, `/?p=1`, `/tag/*` all 404 — no stray archive types

**Still open, small:** each category archive carries 2–3 post images with no alt text (the post
featured images). The missing meta descriptions are now fixed — see item 7.

**Page weight, incidentally:** the Elementor regeneration forced the homepage cache to rebuild
(timestamp now 13:50:18) and it came back at **873,115 bytes / 165 stylesheets** — essentially
unchanged. That isolates the weight problem further: it is not Elementor's cache, and it survives
a genuine regeneration. The wizard-or-rollback decision still stands.

### 2026-09-09 — a correction, and fixes that were not actually reaching visitors

**I reported a duplicate-meta-description problem on BNB. That was wrong.** A crawl of all 16
sitemap URLs shows **14 distinct descriptions across 13 real pages — every one unique.** What I
saw in Google's results was Google writing its own snippets, not the site repeating one
description. Recorded rather than quietly dropped.

**What the crawl did find is worse, and it is systemic.** Three pages returned an *empty*
description. They are not empty: **Seraphinite was still serving copies cached on 2026-09-07,
from before the fixes.**

```
/category/airbnb-tips/          plain URL  desc=0     state=cache; date="2026-09-07"
/category/airbnb-tips/          ?v=...     desc=116   state=skipped (bypasses Seraphinite)
/author/paul/                   plain URL  200        (the redirect was not being served)
/author/paul/                   ?v=...     301 -> homepage
```

**So two of the fixes logged above were never reaching real visitors or Google.** They were
verified with `?v=` cache-busted requests — which, on this site, *bypass Seraphinite entirely* and
therefore prove only that WordPress renders correctly, not that anyone receives it. The logo alt
text was live on both, because the homepage had regenerated after the Elementor cache clear.

**This is the trap on this site, stated plainly:** a cache-busted request answers "did the change
save?" It does **not** answer "is the change live?" Both questions need asking, and the second one
needs the plain URL.

**Fixed:** Seraphinite → Manager → Delete cache. Verified afterwards on **plain URLs**:

```
/author/paul/                  -> 301 https://www.bnbphotos.com
/category/airbnb-tips/         -> desc 116 chars
/category/photography-guides/  -> desc 105 chars
```

**The connection to the open page-weight decision.** This is the same root cause: Seraphinite's
cached entries do not expire, so a change stays invisible until something forces regeneration —
and when it does regenerate, it currently comes back heavy. That is two symptoms of one problem,
and it is why the wizard-or-rollback decision is worth making rather than deferring.

### 2026-09-09 — safe-position pass

### 2026-09-09 — safe-position pass

**Scheduled backups turned on.** Both backups taken earlier were **one-off and manual** —
UpdraftPlus reported "Nothing currently scheduled", which means a single snapshot and then
nothing. Now:

```
Files backup:     Weekly,  retain 2
Database backup:  Daily,   retain 7
Next run:         Wed 9 Sep 2026, 08:5x   (confirmed on both sites)
```

Database daily is where the value is — content and settings change far more often than files, and
a database backup is small. Files weekly at retain 2 keeps disk use sane on shared hosting.

**Still local-only.** UpdraftPlus offers Google Drive, Dropbox, S3 and others, but every one needs
the owner to authorise an account. Local backups die with the server they sit on, so this is
better than nothing and not yet good enough. **Connecting remote storage is a five-minute job for
whoever holds the Google Drive or Dropbox login.**

**Security already covered here**, unlike the other two: Wordfence 9.0.0 plus Rectifi are both
active, and between them they provide the firewall, login lockout and CAPTCHA that Express and
DVPFL were missing entirely. No security plugin added.

### Alt-text audit and fix — BNB was already the strongest of the three

The audit that had been blocked for two days by local DNS finally ran. BNB turned out to be in
better shape than expected: **229 images across 16 pages, 6 without alt text**, and three of those
six were parsing artefacts in my own checker (inline SVG matched as `<img … svg>`), not real
images.

So three genuine gaps, all blog featured images with camera-roll filenames:

| File | What it actually is | Alt written |
|---|---|---|
| `Image-16-768x512-2.jpg` | bedroom, king bed, coffered ceiling | "Vacation rental bedroom with a king bed and coffered ceiling" |
| `DSC02342-768x512-2.jpg` | kitchen, blue island, pendant lights | "Vacation rental kitchen with a blue island, pendant lights and bar seating" |
| `Image-11-768x512-2.jpg` | open-plan living room, coastal palette | "Open-plan vacation rental living room with coastal furnishings" |

**Each one was opened and looked at before being described.** The filenames say nothing, and the
surrounding markup said nothing either — the only honest way to write these was to view them.
Same standard applied on DVPFL.

**A trap on this site specifically:** the media library holds **six** attachments matching
`DSC02342` — `-768x512-1`, `-768x512-2`, `-Copy-…`, `-scaled-…` — so picking the right one
mattered. Each edit screen was checked against the exact rendered filename before writing.

*Verified on plain URLs* after clearing Elementor and Seraphinite:

```
/category/airbnb-tips/           18 images   0 missing
/category/photography-guides/    16 images   0 missing
```

**BNB is now effectively complete on alt text** — the only remaining hits are the three inline-SVG
false positives in the checker, which are not images at all.

### Dormant plugins deleted — all 4

Every inactive plugin on this site was a dead Slider Revolution component: the main plugin plus
the Mousetrap, Transitionpack and Typewriter add-ons. All four were deactivated in August when the
hero was rebuilt, and none has been used since. Deactivated code is still code on disk that a
scanner can fingerprint, so they are now gone.

*Result:* **All (15), Active (15), zero inactive.** Nothing dormant left on this site.

---

## Still to do on this site

- [ ] **NEXT / needs a decision:** remove the placeholder JSON-LD from Header & Footer (lines 10-91) — blocked by a Wordfence 403, see the root-cause section above

- [x] ~~Set a backup schedule~~ — files weekly / database daily, first run 9 Sep
- [ ] Connect remote backup storage (needs the owner's Drive/Dropbox login)
- [x] ~~Run the plugin updates~~ — 5 applied, Yoast + AIO Migration held (see above)
- [ ] Yoast: activate the Premium subscription, then update free + Premium together
- [ ] Login hardening — note Rectifi already runs lockout + CAPTCHA; the remaining gap is the default `/wp-login.php` URL
- [ ] `DISALLOW_FILE_EDIT` in wp-config.php (Rectifi at-risk item 1)
- [ ] Disable public wp-cron, move to a real cron (Rectifi at-risk item 3)
- [ ] Add HSTS — the one security header still absent
- [ ] Diagnose the 10 failed emails — switching the mailer to Brevo gives free delivery logs
- [ ] `/thank-you/` page (noindex)
- [ ] Footer signup form (`../../300usd-build/02-signup-form-bnb.html`) via WPCode
- [ ] **DECISION NEEDED:** Seraphinite setup wizard, or roll back to 2.29.20? See the 2026-09-08 follow-up. Waiting does nothing — the cache does not self-regenerate.
- [ ] Re-run PSI mobile — baseline 94, must not drop
- [x] ~~Check the Seraphinite optimised-visit counter~~ — **1,184 / 5,000** until 18 Sep 2026, not throttled

## Rules for this site

- **Never open the BNB homepage in Elementor** — PHP memory is 128M and the save fails.
  Footer edits go through a template or WPCode.
- Purge Seraphinite after any front-end change, then verify logged out.
