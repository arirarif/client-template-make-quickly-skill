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

---

## Still to do on this site

- [ ] **Decide between UpdraftPlus and WPvivid** — remove one, schedule the other with off-server storage
- [ ] **Remove LiteSpeed Cache** — dead weight on a non-LiteSpeed server, and a conflict risk beside WP Super Cache
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
