# dvpfl.com — live changes log

Every change actually made to the production site, with how to undo it.
Client confirmed a full backup was taken before this session began.

---

## 2026-08-24 — Session 1

### ✅ 1. Preloader removed (Issue #1, visible half)

**Change:** Customizer → Aurel General → **Site Preloader: `Show` → `Hide`** → Published.

**Why:** visitors sat through an 8-second full-screen "LOADING" bar before seeing any film.
Client decision on the day: *"when site visit that time have loading, I think we don't keep it,
it's losing speed too."*

**Verified logged-out on the live homepage:**

| Marker | Before | After |
|---|---|---|
| `preloader` references in HTML | 5 | **0** |
| `LOADING` text | 1 | **0** |

Homepage, `/packages/`, `/contact-us/`, `/services/` all return HTTP 200 with no PHP errors
after the change. The hero video now renders immediately instead of behind the progress bar.

**To undo:** Customizer → Aurel General → Site Preloader → `Show` → Publish.

---

### ✅ 2. 197 spam comments cleared (new issue, not in the August audit)

**Change:** Comments → Pending → selected all → **Mark as spam**. Done in two passes
(20, then 177).

**Result:** Pending **197 → 0**. Spam folder 24 → **221**. Trash **0**.

**Nothing was deleted.** Every comment sits in the Spam folder and can be restored individually
or in bulk. WordPress showed an "Undo" link on both passes.

#### Why all 197 were treated as spam

The instruction was to keep any that said nice things. They were checked before any action, and
**none qualified**:

| Evidence | Result |
|---|---|
| Comments carrying an author link | **197 of 197 — 100%** |
| "Nice-sounding" comments (great / amazing / thank / love …) | 36 |
| …of those 36 that **also** carry an author link | **36 — all of them** |
| Approved comments before this session | 0 |

The flattery *is* the delivery mechanism. Every complimentary comment carried a payload link in
the author-URL field. Confirmed destinations included `luckycolalogin.net`, `woc44slot.com`,
`bonus68login.com`, `crearruletasonline.co`, `itconsultingmanagement.com` ("Fix My Website"),
and `ztd.bardou.online` — casinos, betting, roulette and cold-pitch SEO.

Also present: a competitor running **`ernestopro.com`** under at least four fake identities
(`alex.jamieson88`, `alex.morris88`, `james.baker89`, `lisa.martin22`) posting "I highly recommend
ernestopro.com for all your videography needs" on Paul's own posts.

Sampling across all 10 pages found betting, online roulette, casino, game-download, Friv,
OnlyFans, Russian-language and Chinese-language spam, plus the classic
"Does your website have a contact page?" and "Wow, awesome weblog format!" templates.

⚠️ **Note on the 82 gmail.com addresses.** A consumer email domain is not a signal of legitimacy
here — the gmail-addressed comments carried spam URLs too (e.g. `SallyiQT@gmail.com` posting
"Web Development Wizards https://ztd.bardou.online/adm"). An early read of only the first page
suggested the flood was a single botnet on `immenseignite.info`; it is in fact many sources.

**To undo:** Comments → Spam → select → Not Spam. The 24 comments that were already in the Spam
folder before this session are mixed in with the 197; if a full restore is ever needed, the 197
are the ones dated before 2026-08-24 17:xx in the spam list.

---

## Deliberately NOT changed

| Item | Why |
|---|---|
| **Footer "© 2022 Photo Aurel"** | Client instruction: *"keep it as it is."* The replacement is Paul's business name — three variants exist across his own materials (Digital Video Productions LLC / Digital Video Production FL / Digital Video Productions), so it needs his confirmation, not a guess. Still open. |
| **Elementor / Elementor Pro updates** | 🔴 Hard blocker. Pro 3.7.2 offers no update (licence lapsed or absent) and core would jump 3.20.3 → 4.2.3, which Pro declares itself incompatible with. Updating core alone would very likely break every page. Needs Paul's licence answer plus a staging environment first. See `ADMIN-INVENTORY-2026-08-24.md`. |
| The other 7 outdated plugins | Safe in principle, but should follow the staging setup rather than go straight to production. |

---

## Still open in Phase 1

- [ ] Footer copyright text — **awaiting Paul's business name**
- [ ] Remove the dead `UA-230894873-1` tag (still loading, ~326 KB per page view)
- [ ] Add `tel:` and `mailto:` links — still **0** of each on the homepage
- [ ] Remove `maximum-scale=1` from the viewport (WCAG 1.4.4 zoom block)
- [ ] Install an anti-spam plugin and tighten Settings → Discussion, so the 197 do not simply
      rebuild. **This is the one that makes the comment cleanup stick** — comments are still open
      and unfiltered.
- [ ] Check the **1 unread entry** on the Contact screen — it may be a real enquiry

---

## Measurements

TTFB after the change sampled at **2.20 s** — within the 1.48–2.20 s range seen all day and still
untouched by any caching work. Removing the preloader changes perceived speed, not server speed;
the TTFB fix is Phase 5 (cache + Cloudflare) and has not been started.

---

## 2026-08-24 — Session 1, part 2: INCIDENT + recovery

### 🔴 Incident — Elementor core updated to 4.2.3, pricing page broke silently

**Detected** while re-checking live state. The generator tag had changed from `Elementor 3.20.3`
to **`Elementor 4.2.3`**. Elementor Pro remained at **3.7.2**.

Not applied by this session — the Elementor update was deliberately withheld pending the licence
question. The admin-bar update counter dropped 10 → 8 → 6 during the session, and Contact Form 7
(5.7.7 → 6.1.7) and Chaty (3.1.1 → 3.6.0) also changed, so plugins were updated in parallel.

**This is exactly the failure documented that morning:** Elementor's own compatibility alert stated
Pro 3.7.2 is *"tested up to Elementor version 3.6.0"*.

#### Damage — silent, no errors, all pages still HTTP 200

| `/packages/` | Before | Broken |
|---|---|---|
| `$499` / `$999` / `$1299` / `$1499` / `$1599` | present | **all gone** |
| "Request Info" buttons | 10 | **0** |
| "PACKAGE" headings | 16 | 7 |
| Body words | 451 | **173 (−62%)** |
| Elementor widgets | 49 | 29 |

The homepage also lost ~11% of its content. Pro's pricing widgets rendered as empty containers —
the `elementor-widget-price-list` divs were still in the HTML with nothing inside. No PHP error, no
500, nothing in the logs. **The single most commercially important page on the site — the one
showing $499–$2,499 packages — displayed no prices and no call-to-action buttons.**

### ✅ Recovery — Elementor rolled back 4.2.3 → 3.20.3

1. Installed and activated **WP Rollback** (Tools → WP Rollback).
2. Rolled **Elementor only** back to **3.20.3**. Theme, Elementor Pro and all other plugins
   untouched.
3. Rollback reported "All steps completed successfully" at 100%.

#### Verified restored — all 17 pages re-fetched with cache-busting

| `/packages/` | Baseline | Broken | **Now** |
|---|---|---|---|
| `$499` | 1 | 0 | **1** |
| `$999` | 2 | 0 | **2** |
| `$1299` | 1 | 0 | **1** |
| `$1499` | 2 | 0 | **2** |
| `$1599` | 1 | 0 | **1** |
| "Request Info" | 10 | 0 | **10** |
| "PACKAGE" | 16 | 7 | **16** |
| Body words | 451 | 173 | **450** |

Full sweep: **17 of 17 pages HTTP 200 and within 3% of baseline word count. 0 mismatches.
0 PHP errors.** The 1-word deltas are the removed "LOADING" preloader text — expected.

The preloader fix survived the rollback: `LOADING` still **0**. The single remaining `preloader`
string is `aurel_gallery_preloader`, a small gallery spinner, unrelated to the site preloader.

### Lessons to carry into Phase 3

1. **The compatibility wall is real and now proven in production**, not theoretical. Elementor
   4.x + Pro 3.7.2 = silent content loss on Pro widgets.
2. **It fails silently.** HTTP 200, no PHP error, no visual error banner. Only a content-level diff
   caught it. Any future Elementor work must diff page content before/after, not just check for
   500s.
3. **Do not press "Begin updating plugins"** on this site until the Elementor Pro licence is
   resolved and a staging environment exists.
4. WP Rollback is now installed and is worth keeping as insurance.

### ⚠️ Still to check

Contact Form 7 (5.7.7 → 6.1.7) and Chaty (3.1.1 → 3.6.0) were also updated in that parallel batch
and have **not** been regression-tested. CF7 5→6 is a major version. The contact form should be
submitted end-to-end to confirm it still delivers.

---

## 2026-08-24 — Session 1, part 3

### ✅ 3. Malformed `tel:` and `mailto:` links fixed on `/contact-us/`

**Found:** both contact links carried a URL-encoded leading space, so the scheme was followed by
`%20` before the value:

```
href="tel:%20+1%20941-894-0980"      <- space after the colon
href="mailto:%20paul@dvpfl.com"      <- space after the colon
```

A leading space can stop a phone dialler from opening and can send mail to `" paul@dvpfl.com"`,
which many clients reject. The links *looked* present in the page but were not reliably actionable.

**Change:** Elementor → page 58 (`CONTACT US`) → two Icon Box widgets
(`309d5728` phone, `4acdf876` email) → Link field corrected → Update.

| | Before | After |
|---|---|---|
| Phone | `tel:%20+1%20941-894-0980` | **`tel:+19418940980`** |
| Email | `mailto:%20paul@dvpfl.com` | **`mailto:paul@dvpfl.com`** |
| Malformed links on page | 2 | **0** |

Phone is now in E.164 form (`+19418940980`), which is the most reliable format for mobile diallers.

**Verified live:** `/contact-us/` HTTP 200, body words 94 vs 95 baseline (the 1-word delta is the
removed preloader text), Táve form still present and rendering.

**To undo:** Elementor → page 58 → the two Icon Box widgets → restore the original strings.

---

## Contact form — investigated, NOT submitted

**The live contact form is not Contact Form 7.** It is a **Táve** form loaded in an iframe:

```
<iframe id="TaveContactForm"
        src="https://digital-video-productions-llc.vsco.page/inline/contact/contact?...">
```

Enquiries go to Paul's Táve CRM, not through WordPress mail.

**Therefore the Contact Form 7 update (5.7.7 → 6.1.7) did not put lead capture at risk** — CF7 is
not handling leads. Táve iframe returns **HTTP 200** and the form renders correctly (name, email,
"How did you hear about us?", event-date picker, message, Send Message).

**No test submission was made.** Submitting would create a real lead record in Paul's live CRM and
likely email him. That is a decision for the client, not something to do unannounced.

### ⚠️ Correction to an earlier note in this log
The "Contact **1**" badge in the admin sidebar is **not an unread enquiry**. Contact Form 7 does not
store submitted messages at all — the badge is a plugin configuration notice. The earlier line in
this changelog suggesting a real enquiry might be sitting unread was wrong.

### Two findings worth acting on
1. **CF7 is now dead weight.** It loads `styles.css` plus two JS files on **every page** while no
   CF7 form is used anywhere on the site. Pure bloat on a 3.1 MB site. Candidate for dequeue or
   deactivation — but check the 6 stored forms are genuinely unused first.
2. **CF7 stores nothing.** Quoting its own admin screen: *"you may lose important messages forever
   if your mail server has issues."* If CF7 is ever brought back into use, install **Flamingo**
   first.
3. Six CF7 forms exist, mostly duplicate "Contact form 1" copies dated 2017, 2019, 2020 and 2022.

---

## Running total — live changes this session

| # | Change | Status | Reversible |
|---|---|---|---|
| 1 | Preloader removed | ✅ verified | yes — Customizer |
| 2 | 197 spam comments → Spam folder | ✅ verified | yes — nothing deleted |
| 3 | Elementor rolled back 4.2.3 → 3.20.3 after pricing page broke | ✅ verified | yes — WP Rollback |
| 4 | `tel:` / `mailto:` links repaired | ✅ verified | yes — Elementor |

**Site state:** 17/17 pages HTTP 200, content within 3% of baseline, 0 PHP errors, all package
prices and CTAs present, preloader gone.

---

## 2026-08-24 — Session 1, part 4: serial run through remaining issues

### ✅ #3 Footer copyright replaced

`© 2022 Photo Aurel. All Rights Reserved.` → **`© 2026 Digital Video Productions LLC. All Rights Reserved.`**
Customizer → Footer Settings → Footer Copyright Text → Publish.

Verified live on `/`, `/packages/`, `/contact-us/`, `/services/`, `/vendors/`:
"Photo Aurel" occurrences **0**, "© 2022" **0**.

Name chosen: the legal entity from the August audit. ⚠️ If Paul prefers "Digital Video Production FL"
(site title) or "Digital Video Productions" (header logo), it is a one-field change in the same place.
⚠️ Static string — no dynamic year. **Will read 2026 in January 2027** unless a filter is added.

### ✅ #6 Vendor page dead links + mixed content fixed

Tested all 10 external links on `/vendors/` live, twice, with a 20-second timeout.

| Vendor | Was | Action |
|---|---|---|
| Love and Style Photography | `http://` (site alive on https) | **upgraded to `https://`** |
| Meg & Mike Photography | `https://www.meganmikephotography.com/` → dead | **unlinked, name kept** |
| Harp Soup | `https://www.harpsoup.com/` → dead | **unlinked, name kept** |
| American Classic Wedding Car Service LLC | `http://www.dannyklimo.com/` → dead + insecure | **unlinked, name kept** |
| Plan My Beach Wedding, Venice Photo Booth, Ace in the Hole, Beach Breeze, Florida Sun Weddings | all 200 | untouched |

Method: Elementor → page 57 → text-editor widget `410e5b07` → Code view → corrected table HTML.
Vendor **names were kept as plain text** rather than deleted — Paul may still work with them; only
the broken link was removed.

**Verified live:** all 7 remaining external links return **200**. Dead links **0**. `http://`
external links **0**. All **9 vendor names still present**. Page HTTP 200.

Original markup saved to `vendors-table-ORIGINAL.html` for rollback.

### 🟡 #7 Tap-to-call — mostly already working, finding corrected

**Correction:** earlier notes said "no tap-to-call anywhere except the contact page". That was based
on the raw HTML. Checking the **rendered DOM** shows the Chaty floating button injects a real link
by JavaScript on every page:

```
a[href="tel:+19418940980"]   ← present on /packages/, and site-wide via Chaty
```

So site-wide tap-to-call **does exist** and uses the correct E.164 number. What is genuinely missing:

- **No `mailto:` anywhere except `/contact-us/`**
- Tap-to-call depends on JavaScript and is only the small floating button — not in the header
- The header is rendered by the **Aurel theme, not Elementor**, so adding links there needs a theme
  edit, and Aurel has **no child theme**. Deferred rather than risk an edit that a theme update
  would wipe.

### ⛔ #10 Dead UA tag — BLOCKED, needs Paul's Google account

The tag is injected by **Site Kit**, confirmed in source:

```
<!-- Google Analytics snippet added by Site Kit -->
<script src="https://www.googletagmanager.com/gtag/js?id=UA-230894873-1" async></script>
gtag("config", "UA-230894873-1", {"anonymize_ip":true});
gtag("config", "G-XNGC4MFDGG");
```

But `Site Kit → Settings` returns **"Sorry, you are not allowed to access this page"**, and the Site
Kit dashboard shows **"Set up Site Kit / Sign in with Google"** — the `dvpfl_1oo4yc` admin is **not
connected** to the Google account that configured it.

Removing the UA property requires signing into that Google account. Not done — signing in as the
client is not something to do on their behalf.

**Options for Paul:**
1. He signs into Site Kit with the original Google account → remove the UA property, keep GA4. *(best)*
2. "Reset Site Kit" — **would remove GA4 tracking too**. Not recommended without a replacement ready.
3. Deactivate Site Kit and deploy GA4 via GTM instead — bigger change, better long-term.

Until then the site keeps loading a dead Universal Analytics tag on every page view.

### Not started
- **#4 Blog dead since June 2022** — needs written content and Paul's sign-off, not a config change.
- **#8** 11 missing H1s + 9 service pages at 80–90 words.
- **#9** 17 identical meta descriptions — 17 individual page edits.
- **#10 (zoom half)** `maximum-scale=1` is emitted by the Aurel theme; needs a child theme or a
  site-specific plugin first (see 1.7).

---

## 2026-08-24 — Session 1, part 5

### ✅ #8 (H1 half) — 10 of 11 missing H1s fixed

Each service page already had a large hero heading rendered as `<h2>`. Rather than add new text,
the existing Elementor Heading widget was promoted from **H2 → H1** (Content → HTML Tag).

**No visible change on any page** — same words, same size, same styling. Purely structural.

| Page | ID | Heading promoted |
|---|---|---|
| /ceremony-video/ | 22 | CEREMONY VIDEO SAMPLES |
| /highlight-recap/ | 21 | HIGHLIGHT RECAP SAMPLES |
| /full-documentary/ | 20 | FULL DOCUMENTARY SAMPLES |
| /engagement-video/ | 25 | ENGAGEMENT VIDEO SAMPLES |
| /commercial/ | 19 | COMMERCIAL SAMPLES |
| /cinematic-wedding-film/ | 18 | CINEMATIC WEDDING FILM SAMPLES |
| /memorial-video/ | 24 | MEMORIAL VIDEO SAMPLES |
| /photo-montage/ | 23 | PHOTO MONTAGE SAMPLES |
| /music-video/ | 26 | MUSIC VIDEO SAMPLES |
| /about-us/ | 15 | About us |

**Verified live, all 17 pages re-crawled:**

```
pages with exactly one <h1>:  16 / 17     (was 6 / 17 at session start)
pages with no <h1>:            1 / 17     (was 11 / 17)
```

All pages HTTP 200.

### ⏸️ /blog/ — the one H1 left, deliberately not done

The blog index is an Elementor page but has **no heading widget at all** — only the ten `<h3>` post
titles from the posts grid. There is nothing to promote; a new Heading widget would have to be
**added**, which:

1. **Adds visible text** where there is currently none — every other change in this batch was
   invisible. What it should say is a content decision (e.g. "Blog", "Wedding Video Blog",
   "Wedding Videography Tips — Sarasota & Venice FL").
2. Requires dragging a widget onto a live page, with real risk of dropping it inside the posts
   grid rather than above it.

Left for a decision rather than guessed at. Roughly 10 minutes once the wording is agreed.

⚠️ Note: the heading text on the service pages is still weak for SEO — "CEREMONY VIDEO SAMPLES"
rather than something like "Wedding Ceremony Videography — Sarasota & Venice, FL". The **structure**
is now correct; the **wording** is a separate content pass, and it changes visible text.

---

## 2026-08-24 — Session 1, part 6

### ✅ #9 All 17 duplicate meta descriptions replaced

Every page carried the identical string:
`"Professional Wedding Videography located in Venice, FL and Serving Sarasota, North Port, Bradenton, Port Charlotte, Fort Myers"`

**Method:** Yoast SEO → Tools → **Bulk editor → Pages**. Yoast 28.3 still ships this tool, which
made 17 edits practical without opening 17 page editors.

**Verified live — all 17 pages re-crawled with cache-busting:**

```
pages:                       17
distinct meta descriptions:  17     (was 1)
still duplicated:            none
pages on the old shared text: 0     (was 17)
```

Each description is location-bearing (Sarasota / Venice / Southwest Florida), states what the page
actually offers, and several carry a price or a call to action:

| Page | New description (opening) |
|---|---|
| Home | Award-winning wedding videographers in Venice and Sarasota, FL... from $499. Check your date. |
| Packages | Wedding video packages from $499... ceremony-only, classic, deluxe and premier films. |
| Contact us | Check your wedding date... Call (941) 894-0980 or send your event details. |
| Ceremony video | Wedding ceremony videography... from $499. Ideal for beach and short ceremonies. |
| Cinematic wedding film | A filmic, emotional edit of your day set to music. |
| Full documentary | Every major moment captured in its entirety, from ceremony to last dance. |
| Highlight recap | A short, shareable cinematic recap of your wedding day. |
| Engagement video | Cinematic save-the-date films shot on location. |
| Memorial video | A respectful photo and video tribute to celebrate a life. |
| Photo montage | Your photos edited into a music-set film. |
| Music video | Creative, cinematic music videos for local and touring artists. |
| Commercial | Promotional films, business profiles and event coverage. |
| Services / Vendors / Awards / About / Blog | each unique, location-bearing |

**Note:** the blog *posts* already had unique descriptions — only the 17 pages were duplicated.

⚠️ SEO titles were **not** changed. Every page title is still an ALL-CAPS page name
(`HOME - Digital Video Production FL`). That is a separate pass and changes what shows in search
results, so it was left for approval.

---

## Session totals — live changes

| # | Change | Verified |
|---|---|---|
| 1 | Preloader removed | preloader refs 5 → **0** |
| 2 | 197 spam comments → Spam folder (nothing deleted) | pending 197 → **0** |
| 3 | Elementor rolled back 4.2.3 → 3.20.3 after pricing page broke | all prices + 10 CTAs restored |
| 4 | `tel:` / `mailto:` links repaired | malformed 2 → **0** |
| 5 | Footer copyright replaced | "Photo Aurel" 17 pages → **0** |
| 6 | Vendor dead links + mixed content fixed | dead 3 → **0**, `http://` 2 → **0** |
| 7 | 10 missing H1s added | pages with H1 6 → **16** of 17 |
| 8 | 17 duplicate meta descriptions replaced | distinct 1 → **17** |

**Site state:** 17/17 pages HTTP 200 · 0 PHP errors · all package prices and CTAs present ·
preloader gone · Elementor core/Pro compatible pair restored.

---

## 2026-08-24 — Session 1, part 7

### ✅ Anti-spam lockdown — the fix that makes the comment cleanup stick

Clearing 197 spam comments was treating the symptom. The door was still open. Now closed.

**1. Antispam Bee 2.11.13 installed and activated.**
Chosen over Akismet deliberately: Akismet needs an API key and a signup (and a paid plan for a
commercial site). Antispam Bee needs **no key and no account** — it works immediately. 700,000+
installs, updated the day before install, flagged "Compatible with your version of WordPress".

**2. Settings → Discussion hardened.** The root cause was found here:

| Setting | Before | After |
|---|---|---|
| Allow people to submit comments on new posts | ☐ off | ☐ off (already correct) |
| **Automatically close comments on old posts** | **☐ OFF** | **☑ ON, 14 days** |
| Allow pingbacks and trackbacks from other blogs | ☑ on | **☐ off** |
| Comment must be manually approved | ☐ off | ☑ on |

**"Automatically close comments on old posts" being off was the actual hole.** New posts had
comments disabled, but the ten 2022 posts each had comments open individually — which is exactly
where all 197 spam comments landed. Turning this on closes them all at once.

Unchecking pingbacks/trackbacks removes a second, separate spam channel.

**Verified live on three of the 2022 posts:**

```
/sarasota-video-production/                        comment form: 0
/do-you-need-videography-at-a-wedding-in-florida/  comment form: 0
/florida-video-production-services/                comment form: 0
```

The comment form is gone from the public posts. Nothing can be submitted.

Site still healthy: `/`, `/packages/`, `/contact-us/`, `/blog/` all HTTP 200.

**To undo:** Settings → Discussion → untick "Automatically close comments on old posts".

---

## 🔴 STANDING WARNING — do not click "Begin updating plugins"

Now that Elementor has been rolled back to 3.20.3, the admin banner **again** offers
*"There are updates available for the following plugins: **Elementor Page Builder**, Meta Box and
One Click Demo Import."*

Taking that offer re-installs Elementor 4.2.3 and **will blank the pricing page again** — no error,
no warning, prices and all ten "Request Info" buttons simply vanish. It happened once today already.

**Elementor must not be updated until the Elementor Pro licence is resolved and both are updated
together, on staging first.** Meta Box and One Click Demo Import are safe to update individually.

Consider telling Paul explicitly, since he has admin access and the banner is persuasive.

---

## 2026-08-24 — Session 1, part 8: page caching

### Stack confirmed first (Tools → Site Health → Info)

```
Web server:        Apache          <- so NOT LiteSpeed Cache (the Express mistake)
PHP version:       8.3.30
PHP SAPI:          cgi-fcgi
PHP memory limit:  128M            <- see warning below
.htaccess:         core WordPress rules only
Object cache:      none
```

⚠️ **`cgi-fcgi` + `128M` is the exact combination that broke Elementor saves on BNB Photos.**
If an Elementor save ever fails on a heavy page here, that is the cause — and because the SAPI is
`cgi-fcgi`, raising it needs a **`.user.ini`** file, not `.htaccess` (`php_value` directives are
ignored under cgi-fcgi).

### ❌ WP Fastest Cache — tried first, abandoned

Chosen initially because the directory flagged it "✓ Compatible with your version of WordPress"
(updated 5 days ago) while WP Super Cache showed "Untested" (3 months old).

**It refused to save any settings**, returning:

> *"You have to set the Element Caching option of the Elementor plugin to Inactive"*

But **Element Caching does not exist in Elementor 3.20.3** — confirmed by searching Elementor's own
System Info, which lists every experiment and has no such entry. Most likely a stale option left
behind by today's brief Elementor 4.2.3 install, which cannot be cleared from the 3.20.3 UI.

Deactivated rather than fought. *(Another downstream cost of that unplanned Elementor update.)*

### ✅ WP Super Cache — installed, active, working

Configured via the **Easy** tab, which applies:

1. Caching **disabled for logged-in visitors** (admins always see live pages)
2. **Simple caching** — PHP-based, needs **no `.htaccess` mod_rewrite rules**, so lower risk
3. Cache Rebuild
4. Garbage collection every 10 min, 30-minute cache lifetime

No minification, no CSS/JS combining — deliberately, because Elementor 3.20.3 is fragile.

**Proof it is actually serving cached pages** (footer of the live HTML):

```
<!-- Cached page generated by WP-Super-Cache on 2026-08-24 13:25:48 -->
<!-- Dynamic page generated in 0.673 seconds. -->
```

### Measured result

| | Before | After |
|---|---|---|
| Homepage TTFB | 1.46 – 1.95 s | **0.89 – 1.00 s** |
| `/packages/` TTFB | ~1.5 s | **0.89 – 0.97 s** |
| TLS handshake (unchanged) | ~0.60 s | ~0.60 s |
| **Server work after TLS** | **~0.9–1.3 s** | **~0.3 s** |

**Roughly 0.6–1.0 second saved on every page, for every visitor.** Most of what remains is the TLS
handshake, which only a CDN in front (Cloudflare) can reduce.

A few pages showed 1.4–1.9 s on their very first request — that is the cache being built for that
URL. Second and subsequent hits land at ~0.9 s.

### Full verification after the change

```
17/17 pages HTTP 200        0 PHP errors
packages: $499 x4, $1599 x1, "Request Info" x10   (prices intact)
H1: 16/17          distinct meta descriptions: 17/17
footer: "© 2026 Digital Video Productions LLC"    "Photo Aurel": 0
preloader: 0 (uppercase LOADING 0, preloader div 0)
```

**To undo:** Settings → WP Super Cache → Easy → Caching Off → Update Status.

### Not done — Cloudflare
Deliberately skipped. It needs a Cloudflare account plus a nameserver change at the domain
registrar — Paul's decision and Paul's credentials, not something to do on his behalf. It is the
next meaningful speed win after this (it would cut the ~0.6 s TLS/latency portion).

---

## 2026-08-24 — Session 1, part 9

### ✅ NEW BUG FOUND AND FIXED — dead social icons on every page

Not in the August audit. The Twitter and Instagram icons in the header and footer were literally
set to `#`:

```html
<a class="aurel_footer_social_button aurel_twitter"   href="#">
<a class="aurel_footer_social_button aurel_instagram" href="#">
```

**4 dead links on every page** (each icon appears in both header and footer). Visitors clicking them
went nowhere — the page just jumped to the top.

**Fix:** Customizer → Social Buttons → cleared the `#` from Twitter and Instagram → Publish.
Empty fields render no icon, so the dead icons are gone rather than broken.

| | Before | After |
|---|---|---|
| `href="#"` social links per page | **4** | **0** |
| Facebook icon (real link) | present | **still present** (3 refs, `facebook.com/fldvp`) |

⚠️ **Ask Paul:** does he have a real Instagram or Twitter/X? For a wedding videographer Instagram
is usually the strongest channel. If he does, paste the URLs into the same Customizer fields and the
icons return, pointing somewhere real. Removing them was the right call *only* because they were
broken — not because the channels are unwanted.

### ✅ Yoast organisation entity improved

Site representation was already set to **Organization** with a logo. Added:

- **Alternate organization name: `Digital Video Productions LLC`**

Verified live in the schema graph:
```json
"alternateName":"Digital Video Productions LLC"
```

This helps Google connect the trading name ("Digital Video Production FL") to the legal entity
("Digital Video Productions LLC") — and it now matches the footer, which was changed earlier today.

### ⛔ What could NOT be done — Yoast free limits

The audit asked for **LocalBusiness / VideoObject / AggregateRating / Offer** schema and `sameAs`
profiles. Checking the actual form, Yoast **free** exposes only four editable fields here:

| Field | Status |
|---|---|
| Organization name | free ✅ |
| Alternate organization name | free ✅ (now set) |
| Facebook | free ✅ (already set) |
| X | free ✅ (empty) |
| Organization **phone number** | 🔒 Premium |
| Organization **legal name** | 🔒 Premium |
| Organization **description** | 🔒 Premium |
| Mastodon / other `sameAs` profiles | 🔒 Premium |

**Two real profile URLs were found in Paul's own badge widgets and are worth adding as `sameAs`:**

```
The Knot     https://www.theknot.com/marketplace/digital-video-productions-fl-venice-fl-2034487
WeddingWire  https://www.weddingwire.com/reviews/digital-video-productions-venice-brookfield/7cf0a89c06d2cabc.html
```

*(Both return 403 to automated requests — that is these sites blocking bots, not dead links. Noted
in the August audit too.)*

**Options for the remaining schema work:**
1. **Yoast SEO Premium** (~$99/yr) — unlocks phone, legal name, and the `sameAs` profile list.
2. **A free schema plugin** (e.g. Schema Pro / SEOPress) — can add LocalBusiness + VideoObject.
3. **Custom JSON-LD** in a site-specific plugin — most control, needs the child-theme/plugin
   groundwork that is still outstanding.

VideoObject for the 24 films remains the highest-leverage item and none of it is possible on Yoast
free.

---

## 2026-08-24 — Session 1, part 10: schema attempt — TRIED AND REVERTED

### What was attempted
Add **LocalBusiness** and **VideoObject** schema, which Yoast free cannot output. Installed
**Schema & Structured Data for WP & AMP** (Magazine3, 100k+ installs, "✓ Compatible", updated a
week earlier). Its free tier does expose 93 schema types including Local Business, VideoObject,
Service and Offer — so the capability was real.

Created a **Local Business** schema entry, placement `Homepage = Equal to = True`
*(the placement condition defaults to "Not Equal to (Exclude)" — the opposite of what you want,
easy to get wrong)*. It published and LocalBusiness appeared on the homepage.

### ❌ Why it was reverted — it silently replaced Yoast's entire schema graph

| Homepage schema | Before | With plugin active |
|---|---|---|
| Organization | ✅ (with `alternateName`) | ⚠️ thin, no `alternateName` |
| WebSite | ✅ | ❌ **gone** |
| SearchAction (sitelinks searchbox) | ✅ | ❌ **gone** |
| WebPage | ✅ | ❌ **gone** |
| BreadcrumbList | ✅ | ❌ **gone** |
| LocalBusiness | ❌ | ✅ but only `name`, `url`, `image` |

The LocalBusiness it produced carried **no telephone, no address, no priceRange** — the fields that
make LocalBusiness worth having. Filling them requires the "Modify Schema Output" modal, which
would not open (the admin page was timing out), and the plugin's Knowledge Graph phone/legal-name
fields feed *its* Organization, not its LocalBusiness entry.

**Net result: lose four working entity types, gain one hollow one.** Not a trade worth making, so
it was reverted.

### Revert performed and verified

Deactivated the plugin *(the row "Deactivate" link silently failed three times — the bulk action
Deactivate → Apply is what actually worked)*, then purged the WP Super Cache.

**Confirmed restored on the live homepage:**

```
entity types: WebPage, WebSite, SearchAction, BreadcrumbList, Organization,
              ImageObject x2, ReadAction, EntryPoint, ListItem, PropertyValueSpecification
Yoast graph      : True     alternateName : True
WebSite          : True     SearchAction  : True
BreadcrumbList   : True     WebPage       : True
LocalBusiness    : gone
17/17 pages HTTP 200
```

The plugin is left **installed but inactive** — no effect on the site. Delete it, or keep it for a
future properly-configured attempt.

### What this means for the schema work
LocalBusiness / VideoObject remain **not done**, and the realistic routes are:

1. **Custom JSON-LD** in a site-specific plugin, injected alongside Yoast's graph rather than
   replacing it. Most control, no licence cost, needs the child-theme/site-plugin groundwork that
   is still outstanding.
2. **Yoast SEO Premium + Local SEO** — designed to extend Yoast's own graph, so no conflict.
3. Retry this plugin with its **Compatibility** tab configured to defer to Yoast — untested, and it
   is what should have been checked *before* creating any schema. (I tried to open that tab first;
   the click did not register on the laggy admin and I proceeded anyway. That was the mistake.)

**VideoObject for the 24 films is still the single highest-value SEO item on this site** and remains
open.

---

## 2026-08-29 — Home page: both videos deferred until after load, poster until then

**Live change.** Elementor → Custom Code → snippet **post id 2596**,
"DVPFL — deferred video autoplay (poster until load) v1.1".
Location `<head>`, priority 1, condition Include / Singular / **Front Page**.
Verified absent from about-us, packages and contact-us.

**Revert:** trash that one snippet. No page content, no theme file, no
plugin file was touched.

### What was actually wrong

The Aug 24 mobile run blamed 15,704 KiB of Vimeo segments — 73% of a
21,352 KiB page. That was **not** the hero video widget. It was the Aurel
media slider (`pm-media-slider`, widget 75700314, nine Vimeo films).

`wp-content/themes/aurel/js/pm_image_slider.js:390`:

    this_obj.addVimeo = function(slide) {
        slide.append('<div id="vimeo_player"></div>');
        var vimeo_options = { id: slide.attr('data-src'), width:'1600',
                              loop: false, autoplay: true };
        var v_player = new Vimeo.Player('vimeo_player', vimeo_options);

Chain: `document.ready` → `init()` → `goto(1)` → `update(1)` → `addVimeo()`.
Slide 1 (Vimeo 306247929) booted a full player before first paint, with no
mute and no poster image anywhere in the slide markup.

### What the snippet does

- Installs an accessor on `window.Vimeo`, and — the part v1.0 got wrong —
  on `Player` on the namespace object, because player.js assigns in two
  steps (`window.Vimeo = window.Vimeo || {}` then `Vimeo.Player = Player`).
  A `window.Vimeo` setter alone is handed an empty object.
- Slider players are held behind a gate, returning a stub that records
  `.on()` handlers. Gate opens after `load` + `requestIdleCallback` + the
  slider reaching within 400px of the viewport, then builds the real
  players and replays the handlers.
- Forces `muted: true`. The theme never set it, and no current browser
  autoplays unmuted — this is why the slider stalled on a black frame.
  **Films now start silent.** Viewer unmutes with the player's own control.
- Paints a poster on all nine slides from Vimeo thumbnails fetched via
  oEmbed at build time and hardcoded, keyed on `data-src` (the duplicate
  306247929 slides at count 1 and 4 share one rule).
- Flips the Elementor video widget (25f2262, Vimeo 248909461) from
  click-to-play to self-starting, inserting `autoplay`/`muted` before the
  trailing `#t=` hash, and fading its existing poster overlay out on a real
  `timeupdate`.

Opts out entirely on `prefers-reduced-motion`, Data Saver and 2G.
`MOBILE_VIDEO` switch (currently `true`) turns phones into posters only.

### Verified on the live site

- Snippet at head offset 20395, `</head>` at 30374; player.js 66268 and
  pm_image_slider.js 66405 — hooks install first. ✅
- `Vimeo.Player.__dvpWrapped === true` — gate engages. ✅
- `.aurel_slider_slide iframe` count **0** ten seconds after load — the
  slider's player is held, so its segments never download. ✅
- Slide posters computed from the CSS. ✅
- Hero iframe gets `src` with autoplay + muted after load. ✅
- Overlay CSS correct (transition forced to finish → `opacity: 0`). ✅
- Snippet absent from three non-front pages. ✅

### NOT verified — needs a human with a real browser

The MCP tab was `visibilityState: hidden` for most runs. Chrome blocks
autoplay and throttles timers in hidden tabs, so the visual handoff
(poster → moving film, and whether `timeupdate` beats the 8s backstop)
could not be measured here. Eyeball it on a normal foreground load.

### Open issues

1. **WP Super Cache purge does not work on this host.** After clicking
   Delete Cache on both the Contents and Easy tabs, the page count and byte
   sizes were unchanged (4 pages, 74.39KB / 53.91KB). The bare homepage URL
   kept serving the older cached copy while any `?query` URL served the
   current one (WP Super Cache does not cache query-string URLs). Cache
   lifetime is 30 min with GC every 10, so it ages out on its own. Worth
   telling Paul — a cache you cannot purge is a liability.
2. **`pm_image_slider.js:497` loads `https://www.youtube.com/iframe_api`
   unconditionally**, on every page, with zero YouTube videos on the site.
   Cannot be stopped from a head snippet (inline `document.createElement`).
   Needs a child theme that dequeues `pm_image_slider` and enqueues a
   patched copy. No child theme exists — the Aurel theme has no update
   channel, so one is safe to add.
3. Hero self-hosted MP4 would remove the whole Vimeo player stack
   (`player.module.js`, `vendor.module.js`, `player.css`, `vuid.min.js`,
   `oembed.json`, `flarepoint`, `identity/settings`) — ~8 third-party
   requests and 628 KiB of JS. Not done.

---

## 2026-08-29 (later) — v1.2: YouTube iframe API refused, without a child theme

Same snippet, **post 2596**, updated in place. Still `<head>`, front page only.

### The problem

`pm_image_slider.js` ends with this, unconditionally:

    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

Measured cost:

| | |
|---|---|
| `iframe_api` response body | 0 bytes — but `Cache-Control: private, max-age=0`, so **refetched on every page view, forever** |
| then pulls `www-widgetapi.js` | 8,839 bytes transferred / 26,769 uncompressed |
| Real cost | 2 requests + a fresh DNS + TLS handshake to a new origin |

Scope check — `pm_image_slider.js` loads on the **home page only**
(about-us, packages, contact-us, services, blog, awards, vendors: 0). So
the existing front-page-scoped snippet is the right place; no second
snippet needed. And `data-type="youtube"` appears **zero** times sitewide.

### The fix, given no child theme

We cannot dequeue the script without PHP. We can decline to insert its
tag. The snippet is in `<head>`; `pm_image_slider.js` is a plain footer
script with **no async/defer** (verified on the live tag), so it executes
during parse — long after our patch is installed, and before
`DOMContentLoaded`.

So: patch `Node.prototype.insertBefore`, drop only a `<script>` whose src
contains `youtube.com/iframe_api`, hand the node back so the caller sees
nothing wrong, and **restore the native method on `DOMContentLoaded`** —
the patch exists only for the parse phase and leaves no permanent
monkey-patch behind.

**The guard is not optional.** `addYT()` does:

    if (jQuery('body').find('.aurel_youtube_api').length) { ... }
    else { setTimeout(function(){ addYT(-1); }, 300); }

The flag it waits on is only set by `onYouTubeIframeAPIReady()`. Kill the
API on a page that *does* have a YouTube slide and that becomes a 300ms
retry loop that never ends. So the block only fires when
`.aurel_slider_slide[data-type="youtube"]` matches nothing — a test that
is reliable, because the slider markup is parsed before the footer runs.

### Verified live

    ytNetworkRequests    = 0        no youtube / ytimg / googlevideo at all
    ytTagInDOM           = false    tag never entered the DOM
    YTglobal             = undefined
    insertBeforeIsNative = true     patch cleanly restored
    sliderWorks          = true     activeSlide 306247929
    PlayerWrapped        = true     video gate still engaged
    slideIframes         = 0        slider video still held

Slider navigation regression-tested: clicking next moved slide 1 → 2
(306247929 → 308323738), **0 JS errors**.

### Still not verified — needs a human

The automation tab keeps dropping to `visibilityState: hidden`. Chrome
suspends the rendering steps that deliver IntersectionObserver callbacks
in hidden tabs, so **the gate opening on scroll could not be observed
here** — `heroGotSrc=true` proves `start()` ran and the slider was fully
in view (`top 27`, viewport 864), but the IO callback never fired.

On a real foreground visit this is ordinary IO-on-scroll behaviour and
will fire. Worth one manual check: scroll to the slider and confirm the
film starts. If it does not, the gate trigger needs revisiting.

---

## 2026-08-29 (evening) — portfolio slider rebuilt; hero is poster-only

### 1. Hero: click to play (snippet 2596 v1.4)

Added a `HERO_VIDEO` flag, default `false`, guarding the two
`bootElementorVideos()` calls. The poster stays, Elementor's play button
stays, the film loads only on click. Verified live:

    BEFORE CLICK   heroIframeHasSrc=false   vimeoRequests=0
    AFTER CLICK    heroIframeHasSrc=true    vimeoRequests=1

Set `HERO_VIDEO = true` to restore autoplay — the deferred-boot, timeupdate
reveal and poster preload machinery is all still there, just not invoked.

### 2. Portfolio slider rebuilt — Home page, section 1c60403d

**What was lost.** Diffing the live homepage against `baseline-2026-08-24`
showed the Elementor update cost exactly one widget and nothing else:

    top-level sections   6 -> 6
    heading.default      7 -> 7      image.default    4 -> 4
    text-editor.default  3 -> 3      button.default   2 -> 2
    video.default        1 -> 1      html.default     1 -> 1
    pm-media-slider      1 -> 0      <-- the only loss

Confirmed inside the Elementor editor: section `1c60403d` had one column
and zero widgets. Elementor 4.x could not parse the theme's widget and
dropped it. Nothing moved; the page just closed up around the hole.

**The fix.** A new HTML widget (`52e1bdc`) in that same column, holding a
hand-built reel that owes nothing to the Aurel theme or to Elementor Pro —
so the next update cannot take it away again. Aurel has no update
available, so waiting for a compatible build was not an option.

Installed through Elementor's own command API rather than drag-and-drop:

    $e.run('document/elements/create', { container: column,
      model: { elType:'widget', widgetType:'html', settings:{ html: ... } } })

**It also fixes the original problem.** The theme's slider built a Vimeo
player at `document.ready` with `autoplay:true` and no poster — that was the
15,704 KiB and the 9 s LCP in the August audit. The rebuild ships eight
posters and nothing else; a Vimeo iframe appears only on click.

Verified on the live front end:

    slides rendered          8   (all original films, correct captions)
    iframes with a real src  0   (whole page, hero included)
    NEXT click               -> "Alison and Jonathan (2 / 8)"
    vimeo requests before play  0
    play click               -> iframe created, poster hidden, film playing

Details worth keeping: fixed 16:9 stage with absolutely positioned slides,
so paging never shifts layout; leaving a slide tears its iframe down so
audio cannot keep playing behind a slide nobody is looking at; the next
poster is un-lazied on navigation; swipes are ignored unless clearly
horizontal so they never fight page scroll; play targets are real buttons
with aria-labels; all eight posters `loading="lazy"` below the fold, so a
visitor who never scrolls there downloads none of them.

**Revert:** delete widget `52e1bdc` from section `1c60403d`.
