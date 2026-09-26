# Paul's feedback — 2026-09-25

1. **Logo** — can't really see it; needs to be more prominent.
2. **Venice wording** — Venice is just where he lives. Replace "The photographer Venice agents call first." with **Sarasota & Charlotte County**, the area he serves.
3. **"Every shoot by Paul"** (hero highlight) — doesn't make sense to him; unclear purpose. Remove/replace.
4. **Why Us** — put his headshot back, like the original site, to feel personal.

## Status

| # | Fix | Done |
|---|---|---|
| 1 | Logo bigger / more visible | ⏳ light version (light blue + red, 800×476) in the header; still in the 40×40 box. Fotello request sent 2026-09-26; square crop next |
| 2 | Headline + Venice mentions → Sarasota & Charlotte County | ✅ 2026-09-26: headline re-set (the 09-25 save hadn't stuck) + footer blurb changed; both confirmed after reload |
| 3 | Drop "Every shoot by Paul" highlight | ✅ saved 2026-09-25 |
| 4 | Headshot in Why Us | ⏳ next — needs the headshot file (check the live site's About/Why Us image first) |

## What's live in the editor now (Hero, saved)

- Eyebrow: `Real estate photography · Southwest Florida`
- Headline: `The photographer Sarasota & Charlotte County agents call first.`
- Subtext: `Photos, video, drone, floor plans and 3D tours from one visit, delivered next day.` ("Shot by Paul" removed too)
- Highlights: `Next-day delivery` · `Photo · Drone · 3D tours` · `Sarasota & Charlotte County`
- Still to check: other "Venice" mentions (Why Us, FAQ, Portfolio subtext, Contact placeholder, Footer blurb) — decide per line; Venice as one town in a list is fine, Venice as *the* market is not.

## Logo findings

- Header renders the logo as `img.ftl-site-logo` in a fixed **40×40** box; the file (logo-5.png) is 200×119, so the wide wordmark shrinks to a smudge. The company-name text sits next to it, stacked on 4 lines.
- The Header panel has no logo-size setting (only Brand image / Company name / Phone).
- Options to try next: (a) upload a tight-cropped, square version of the logo (house mark + "Express") so 40×40 is legible; (b) try the other Style themes (Proof / Marquee) to see if one renders a bigger logo; (c) Requests tab → ask Fotello for a logo-size option.

## Editor gotcha (2026-09-25)

Typing fast into Hero fields crashes the editor ("Application error", React #185 = infinite update loop) and loses unsaved edits. Safe method: set the value via JS native setter + `input` event, one field at a time, and **Save after each field**.


## 2026-09-26 — Paul: "still seeing Venice"

- Cause: the 09-25 headline edit showed in the preview but never saved; after a reload it read "Venice agents call first." again. Re-set it with the same JS setter, saved, and confirmed after a reload.
- Footer blurb → "Real estate photography, video, drone, floor plans and 3D tours for listing agents across Sarasota & Charlotte County." Saved and confirmed after a reload.
- Left as they are: Why Us town list, Portfolio "Recent listings across Venice, Sarasota…" (a list of towns) and the footer address "Venice, FL 34293" (his real address).
- **Publish = book a call.** The Publish button opens "Book a call to publish your website" with a Fotello expert. Nothing is live; Paul reviews via the editor. Not booked.
- Logo-size request sent via Requests → Feature.
- Paul asked for a call to go through the site → reply draft in CLIENT-REPLY-2026-09-26-venice-call.md.
