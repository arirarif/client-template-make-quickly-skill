# expressrealestatephotos.com — live change log, September 2026

Part of the $300 job (`../../SCOPE-2026-09-03-300usd.md`). These are traffic fixes found while
auditing all three sites after Paul forwarded Google's indexing warnings for BNB.

**Stack reminder:** Rank Math (not Yoast) · Fluent Forms + WPForms Lite · WP Super Cache ·
Elementor + Pro · canonical host is **non-www** (`www` 301s to bare domain).

---

## 2026-09-08 / 09

### Read-only audit first — Express is structurally clean

Unlike BNB, Express has **no placeholder schema and no `@id` collisions**. One Rank Math JSON-LD
block per page, correct self-referencing canonicals, one H1 per page, descriptions 116–148 chars.

Worth noting for later, not acted on: Rank Math marks service pages as `Article` authored by a
`Person`, which is a mismatch for commercial service pages (they are not articles) and can
suppress the rich results a `Service`/`LocalBusiness` shape would earn. Low priority, but real.

### 1. Homepage title — two defects in one line

**Before:** `Real Estate Photography Venice &amp; Sarasota FL | Express`
**After:** `Real Estate Photography Venice FL | Express Real Estate Photos`

Two separate problems, both live in Google results:

1. **The brand was truncated to "Express."** The August growth research flagged this exactly:
   the title ended at `| Express`, so the business appeared in every search result as an unknown
   brand rather than as Express Real Estate Photos. The site title in WordPress was always
   correct — the truncation was in Rank Math's snippet for the static front page, which is why
   it did not show up in Settings.
2. **The ampersand was double-escaped.** The stored title contained `&amp;`, so searchers were
   literally shown "Venice &amp; Sarasota". The replacement drops the ampersand entirely rather
   than re-escaping it, which removes the whole class of bug.

Trade-off taken deliberately: "Sarasota" left the title to make room for the full brand at
62 characters. Sarasota still appears in the meta description, in the page content, and will be a
named service area on the Google Business Profile, so the market is not abandoned — it is just
not competing with the brand name for pixels.

*Verified live on both the cached and cache-busted URL.*
*Undo:* Pages → Home → Rank Math → Edit Snippet.

### 2. Author archive disabled (Rank Math → Titles & Meta → Authors → Disabled)

`/author/paul/` returned **200** and duplicated the blog listing. Rank Math's own note says it:
"To avoid duplicate content issues, noindex author archives if you keep them enabled."
Single-author site, so disabling is cleaner than noindexing — the URL now redirects.

*Verified:* `/author/paul/` → **301 → homepage**.
*Undo:* same setting back to Enabled.

### 3. Sitewide missing alt text (Media → logo (5) → Alternative Text)

`logo-5.png` is the site logo and appeared **three times on every page** (header, mobile header,
footer) with no alt text. Set to "Express Real Estate Photos logo".

*Verified:* homepage now **0 of 12 images missing alt** (was 3).
*Gotcha, same as BNB:* saving the attachment was not enough — **Elementor → Tools → Clear Files
& Data** was required before the new alt appeared in the markup.

### 4. UpdraftPlus installed and a full backup taken

Same reasoning as BNB: eleven plugin updates were pending and nothing was backing the site up.
Installed from the **official WordPress.org directory**, took a full database + files backup and
flagged it **"only allow this backup to be deleted manually"** so retention cannot purge the
pre-update copy.

*Verified:* "The backup succeeded and is now complete (Sep 08 18:35:21)", **693.2 MB**.

**Caveat worth recording:** this site already had **WPvivid Backup Plugin** installed, which I did
not know before installing UpdraftPlus. Two backup plugins is redundancy the site does not need.
No UpdraftPlus backups existed and nothing was scheduled, so the safety copy was still necessary —
but somebody should decide which of the two stays, and the other should go. I did not remove
either.

### 5. Nine plugin updates applied, two held

| Plugin | Before | After |
|---|---|---|
| **WPvivid Backup** | 0.9.132 | **0.9.134** — *"Fixed two vulnerabilities in the plugin code"* |
| Rank Math SEO | 1.0.276 | 1.0.278 |
| Elementor | 4.2.3 | 4.2.4 |
| Fluent Forms | 6.2.12 | 6.2.13 |
| WP Super Cache | 3.1.1 | 3.1.3 |
| WPForms Lite | 2.0.0.5 | 2.0.1.1 |
| Click to Chat | 4.43 | 4.44 |
| Tidio Chat | 8.0.0 | 8.0.1 |
| WordPress Importer | 0.9.5 | 0.9.6 |

The WPvivid one was the reason not to wait: its changelog names two fixed vulnerabilities.

**Held deliberately:**
- **All-in-One WP Migration 6.77 → 7.110** — a 30+ release jump, same call as BNB.
- **LiteSpeed Cache 7.8.1 → 7.9.1** — **this plugin should be removed, not updated.** The August
  audit established that Express is not on a LiteSpeed server, so it does nothing, and running it
  alongside WP Super Cache is exactly the two-cache-plugin conflict that breaks sites. Updating it
  would entrench something that should leave. Flagged for removal rather than acted on, because
  deactivating a cache plugin on a live site deserves its own moment.

*Verified after:* the site went into maintenance mode for roughly a minute, then returned **HTTP
200**, no PHP fatals, new homepage title intact. Regression gate across all three sites passed:
**express 16/16, bnb 15/15, dvpfl 27/27** URLs returning 200.
*Undo:* UpdraftPlus → Existing backups → the Sep 08 18:34 set → Restore (Plugins).

### 6. `/thank-you/` page created (page 2671)

The newsletter signup's redirect target, so a subscription registers as a conversion in GA4
instead of vanishing. Copy points at the booking app and the phone number, since agents arriving
here are already warm.

*Verified:* returns **200**.
*Same caveat as BNB:* the page is not `noindex` — Yoast's dropdown would not persist through
automation. Worth setting by hand, but harmless as is.

### 7. Virtual-staging before/after images given alt text

A full crawl of all 18 indexed pages found **163 images, 13 without alt text** — a good ratio, and
six of the thirteen were the **virtual-staging before/after pairs**, which are the most
commercially important images on the site. Virtual staging is the service that most needs the
proof shown side by side, and a screen reader or Google Images had nothing to go on.

Written as matched pairs so the transformation is legible on its own:

```
Before3.jpg    -> "Empty living space before virtual staging"
after3.jpg     -> "The same living space after virtual staging, furnished digitally"
before2-1.jpg  -> "Empty room before virtual staging"
after2-1.jpg   -> "The same room after virtual staging, furnished digitally"
before-1.jpg   -> "Vacant room before virtual staging"
after-1.jpg    -> "The same vacant room after virtual staging, furnished digitally"
```

**Worth knowing:** each of those six filenames exists **twice** in the media library — the same
images uploaded on two occasions (IDs 434–439 and 699–704). Alt text was written to **both
copies**, twelve writes in total, so whichever attachment the page actually renders is covered.
Left unnoticed, fixing only one would have looked done and changed nothing.

*Verified on the plain URL after clearing Elementor and WP Super Cache:*
`/virtual-staging/` — **18 images, 0 missing alt**, and the rendered markup carries the new text.

**Seven images still without alt**, none of them commercially important: four screenshots of an
old `express.hd.pics` page from 2022, and three photographs with camera-roll filenames
(`Image-29`, `DSC05838`, `DSC05903`) that I could not identify confidently enough to describe.
Not guessed at — wrong alt text is worse for a screen-reader user than none.

### 8. Listing-website screenshots given alt text — Express now sits at 3 of 163

The four `screenshot-express.hd_.pics-*` images live on `/website-marketing-kit/`, whose H1 reads
"Listing Websites That Showcase Your Property Professionally". Filename and page agree, so the
class of image is certain even though the extension refused a screenshot of the file itself:
these are screenshots of single-property listing websites Express builds for clients.

Described as exactly that, at the level that could be verified — **"Screenshot of a single-property
listing website built for a client"** — rather than inventing detail about what each one shows.
Nine writes again, because the same four files exist twice over in the library plus one extra
from 2022.

**Sitewide re-audit after clearing Elementor and WP Super Cache:**

```
18 pages · 163 images · 3 missing alt   (was 13)
```

**The three left are the same three photographs** — `Image-29-768x512-1.jpg`,
`DSC05838-1024x682.webp`, `DSC05903-1024x683.webp` — that appear in a shared block across the
homepage, three blog posts and the Uncategorized archive. Camera-roll filenames, no describing
text near them, and the browser extension is not permitted to open image URLs on this domain, so
I could not look at them. Anything I wrote would be a guess dressed as a description, repeated
three times. Left deliberately.

**To finish them:** open the three in the Media Library, look, and write one line each. Two
minutes for someone who can see them.

### 9. Verified: the August `-v1` cleanup is still intact

The Google research turned up `/contact-v1/` still listed in search results, which raised the
question of whether the August redirects had lapsed. They have not — **all 12 redirect correctly**
and no `-v1` URL appears in the sitemap:

```
home-v1 -> /            about-us-v1 -> /about-us/        aerial-photography-v1 -> /aerial-photography/
book-now-v1 -> /book-now/    contact-v1 -> /contact/      floor-plans-v1 -> /floor-plans/
photography-v1 -> /photography/   videography-v1 -> /videography/
virtual-staging-v1 -> /virtual-staging/    virtual-tour-v1 -> /matterport-3d-virtual-tour/
website-marketing-kit-v1 -> /website-marketing-kit/    virtual-tour -> /matterport-3d-virtual-tour/

not redirecting: 0        v1 URLs in page sitemap: 0
```

So the search result is Google's index lagging behind a correct 301, not a live problem. No action
needed — recorded so the next person does not re-investigate it.

### 10. Two earlier flags were wrong — corrected

Reading the actual plugin list rather than the update screen:

- **"Two backup plugins running."** Not true. **WPvivid is inactive.** UpdraftPlus is the only
  active backup plugin. Nothing to choose between.
- **"LiteSpeed Cache is a conflict risk beside WP Super Cache."** Not true either. **LiteSpeed is
  inactive**, as are WP Fastest Cache and Slider Revolution. Only WP Super Cache is running.
  Nothing to remove; the update was still correctly skipped, since updating a dormant plugin is
  pointless.

Also worth recording: **Elementor Pro is inactive here** and **PRO Elements** is active in its
place, so this site does not depend on an Elementor Pro licence at all — unlike dvpfl.com, where
the missing licence is a live problem.

Genuine gap that remained, now closed:

**Login protection installed** — Limit Login Attempts Reloaded (official WordPress.org directory),
installed and activated. This site had **no security plugin at all**: no firewall, no login
lockout, nothing between a brute-force script and the login form. BNB logged 25 blind attempts
against a non-existent `admin` user in a single week, so the threat is not theoretical.

Chose a focused login limiter rather than a full suite like Wordfence deliberately — it does the
one thing that matters against the observed attack, and adds a fraction of the page weight.
*Undo:* deactivate the plugin.

*Verified after:* site returns 200, no PHP fatals, and the page gate passes across all three sites
(express 17/17, bnb 16/16, dvpfl 28/28).

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

### 11. Express reaches zero images without alt text

The last three — `DSC05838`, `DSC05903`, `Image-29` — were the ones I had refused to guess at,
because the browser extension would not open image URLs on this domain. On a later attempt the
permission allowed it, so I opened all three and described what they show:

```
DSC05838  -> "Living area of a listed home with a lanai view, opening through to a bedroom"
DSC05903  -> "Guest bedroom with twin beds and an en-suite bathroom"
Image-29  -> "Open-plan living room with a vaulted beamed ceiling and wet bar"
```

Twelve writes across every size and format variant in the library (`.webp`, `.jpg`,
`-768x512-1`, `-768x512-2`, `-scaled-1`), so whichever variant a page renders is covered.

*Verified sitewide on plain URLs after clearing Elementor and WP Super Cache:*

```
EXPRESS   18 pages   163 images   0 missing alt
```

**Worth noting where they were:** all three appeared only on `/category/uncategorized/`. Three
real blog posts are filed under **Uncategorized** — "Matterport vs Zillow 3D Tours", "How to
Prepare Your Property for a Real Estate Photoshoot" and "Why Professional Real Estate Photography
Sells Homes Faster". Giving them a proper category would be a small content-hygiene win; BNB had
the same problem and it was cleaned up in August.

### 12. Dormant plugins deleted — 6 of 12

Inactive plugins are not inert. Their code still sits on disk, still gets fingerprinted by
vulnerability scanners, and is still exploitable if a flaw is found — deactivation is not removal.
Express carried twelve.

**Deleted (6):** Slider Revolution + its Mousetrap, Transitionpack and Typewriter add-ons —
replaced by the custom hero slider in August and dead since · LiteSpeed Cache — wrong server type,
never did anything · WP Fastest Cache — a third cache engine sitting behind WP Super Cache.

**Kept deliberately (6):** Elementor Pro (a paid licence, not mine to throw away), WPvivid (may
hold backups), Click to Chat and Tidio (Paul may want a chat widget back), the Reviews widget
(reviews are dropped, not forbidden), and the upload-size utility. Anything ambiguous stayed.

*Verified:* homepage, virtual staging and contact all 200 with no PHP fatals; the page gate passes
17/17.

---

## Still to do on this site

- [ ] Three blog posts sit in **Uncategorized** — give them a real category

- [x] ~~Decide between UpdraftPlus and WPvivid~~ — WPvivid is inactive; UpdraftPlus scheduled
- [ ] Connect remote backup storage (needs the owner's Drive/Dropbox login)
- [x] ~~Remove LiteSpeed Cache~~ — already inactive, no conflict exists
- [ ] Remove WPForms Lite once confirmed no form uses it (Fluent Forms is the real one)
- [ ] Two chat plugins are installed (Click to Chat + Tidio) — confirm both are wanted
- [ ] Signup form + `/thank-you/` page, once the Brevo account exists
- [ ] Google Business Profile link + `sameAs` in schema, once the profile exists

---

## Noted, not actioned

- **WP Super Cache warning in the dashboard:** "Your server is configured to show files and
  directories, which may expose sensitive data such as login cookies to attackers in the cache
  directories." The notice says it has been mitigated with index.html files. Worth confirming.
- **`/book-now/` still serves the Vercel security challenge** to anonymous crawlers. Deferred by
  Paul in August and reconfirmed by the owner — excluded from the page-regression gate on purpose.
- Rank Math `Article` schema on service pages (see above).
