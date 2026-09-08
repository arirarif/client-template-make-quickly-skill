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

---

## Noted, not actioned

- **12 plugin updates pending.** Not touched: there is no backup on this site yet. Install
  UpdraftPlus and take one before updating, exactly as was done on BNB.
- **WP Super Cache warning in the dashboard:** "Your server is configured to show files and
  directories, which may expose sensitive data such as login cookies to attackers in the cache
  directories." The notice says it has been mitigated with index.html files. Worth confirming.
- **`/book-now/` still serves the Vercel security challenge** to anonymous crawlers. Deferred by
  Paul in August and reconfirmed by the owner — excluded from the page-regression gate on purpose.
- Rank Math `Article` schema on service pages (see above).
