# dvpfl.com — Delivery Notes

**Project:** Website audit fixes, performance & content overhaul
**Site:** https://dvpfl.com (Digital Video Productions, Venice FL)
**Work period:** August 24 – 31, 2026

---

## Headline results

| Measure | Before (Aug 24) | After (Aug 31) |
|---|---|---|
| Page weight (homepage, mobile) | 21.4 MB | **3.7 MB** (−83%) |
| Largest Contentful Paint | 9.0 s | **~6 s** |
| Total Blocking Time (main-thread jank) | 690–1,840 ms | **0 ms** |
| Layout shift (CLS) | 0 | 0 |
| **Accessibility score** | 77–84 | **100** |
| SEO score | 92 | 92 |
| AI-agent readiness (Agentic checks) | 1 of 3 | **3 of 3** |
| Performance score (mobile) | 32–41 | **~61** |

Every number above was measured on the live site, before and after.

---

## The audit's Top 10 issues — 9 of 10 closed

| # | Issue | Status |
|---|---|---|
| 1 | 8-second "LOADING" screen + heavy autoplay video | ✅ Fixed — preloader gone; videos now load poster-first, play on click |
| 2 | Elementor 2+ years out of date (security risk) | ✅ Updated to current (4.2.3 / Pro 4.2.2) |
| 3 | Wrong footer: "© 2022 Photo Aurel" | ✅ Now "© 2026 Digital Video Productions LLC" |
| 4 | Blog dead since June 2022 | ⏳ Open — needs your writing (see "Your input needed") |
| 5 | Broken internal link (404) | ✅ Redirected to the correct post |
| 6 | Dead vendor links + insecure http:// links | ✅ All vendor links verified working, zero insecure links |
| 7 | No tap-to-call / email on the site | ✅ New floating Call + Email buttons on every page |
| 8 | Missing headings; 13 pages too thin to rank | ✅ Every page now has a proper H1; 11 pages expanded to 180–280 words |
| 9 | 18 pages sharing one meta description | ✅ 17 unique descriptions across 17 pages |
| 10 | Dead analytics tag; pinch-zoom disabled | ✅ Dead tag removed; zoom restored (accessibility requirement) |

---

## What was done, in plain language

### Speed
- The homepage was downloading **15.7 MB of video before a visitor saw anything**. Videos now show an instant photo and load only when someone presses play.
- The portfolio slider (broken by the Elementor update) was **rebuilt from scratch** — lighter, faster, and immune to future plugin updates. All 8 wedding films restored.
- The contact form in the footer was silently loading **1.7 MB of Google/reCAPTCHA code on every visit** — it now loads only when a visitor scrolls to it. The form works exactly as before.
- Caching configured with **WP Rocket** (your licence, valid to 2076) plus **Perfmatters** for trimming unused code. Nine unused theme files removed from the homepage.
- Hero images now served at the right size per device (a phone gets a 57 KB image instead of 207 KB).

### Content
- **11 pages of new copy** written for the service pages (cinematic film, highlight recap, documentary, ceremony, engagement, memorial, photo montage, music video, commercial, awards, services). Every fact was taken from your own site — prices, service areas, "since 1995", team details. Nothing invented. Each page links to Packages and Contact.
- Blog page given a proper headline and clean heading structure.

### Accessibility (now 100/100)
- Pinch-zoom re-enabled — important for parents booking on phones.
- Every button, link and embedded frame now properly labelled for screen readers.
- Heading structure corrected on every page.
- Call-button colors adjusted to meet contrast standards.

### Trust & housekeeping
- All plugins updated; two years of missing security patches closed.
- XML-RPC endpoint disabled (a common attack target).
- Anti-spam active (the 197-comment spam flood is contained).
- `llms.txt` published so AI assistants (ChatGPT, Claude, etc.) can correctly describe your business.

---

## Your input needed (the honest list)

1. **Elementor Pro licence** shows "Missing" in the dashboard. The site works, but you get no Pro updates or support until a key is added. If you have one, it takes 2 minutes to connect.
2. **The blog** — last post June 2022. Google reads this as an inactive business. If you send bullet points about 2–3 recent weddings (couple's name, venue, one detail), I can draft the posts.
3. **Review the new page copy** — it's built from facts on your site, but you know your business best. Any line is a one-click edit in Elementor.
4. **Hosting** — your server takes 1.5–2.5 seconds to respond before the page even starts loading. That is now the single biggest speed limit. A better hosting plan would do more for speed than any further code work.

## One deliberate change to know about

Videos no longer autoplay with sound muted — they show a beautiful still frame and play (with sound) when clicked. This is what made the site fast, and for a portfolio it's the better experience: people choose what to watch. It can be reversed with a one-line switch if you prefer autoplay.

## For whoever maintains the site

- **Do not activate** FlyingPress, WP Super Cache or WP Fastest Cache — WP Rocket is the one cache plugin, and two cache plugins running together break each other.
- Custom work lives in **Elementor → Custom Code** (two entries). Removing an entry cleanly reverts that feature.
- After any content change, use WP Rocket's **"Clear and preload"**.
- A full technical changelog of every change, with rollback instructions, is in the project records.

---

*Delivered with a complete technical changelog covering every change made to the live site, each verified after deployment.*
