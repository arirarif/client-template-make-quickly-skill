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

---

## Still to do on this site

- [ ] Set a backup schedule + remote storage (local-only backups die with the server)
- [x] ~~Run the plugin updates~~ — 5 applied, Yoast + AIO Migration held (see above)
- [ ] Yoast: activate the Premium subscription, then update free + Premium together
- [ ] Wordfence: rate-limit `wp-login.php`
- [ ] Diagnose the 10 failed emails — switching the mailer to Brevo gives free delivery logs
- [ ] `/thank-you/` page (noindex)
- [ ] Footer signup form (`../../300usd-build/02-signup-form-bnb.html`) via WPCode
- [ ] Re-run PSI mobile — baseline 94, must not drop
- [ ] Check the Seraphinite optimised-visit counter (free tier caps at 5,000)

## Rules for this site

- **Never open the BNB homepage in Elementor** — PHP memory is 128M and the save fails.
  Footer edits go through a template or WPCode.
- Purge Seraphinite after any front-end change, then verify logged out.
