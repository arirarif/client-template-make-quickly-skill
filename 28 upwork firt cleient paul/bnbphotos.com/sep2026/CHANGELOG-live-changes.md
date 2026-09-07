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

---

## Still to do on this site

- [ ] Set a backup schedule + remote storage (local-only backups die with the server)
- [ ] Run the 7 plugin updates, one at a time, verifying the homepage after each
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
