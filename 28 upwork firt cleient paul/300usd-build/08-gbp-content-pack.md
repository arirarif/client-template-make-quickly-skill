# 08 — Google Business Profile content pack

Paste-ready content for all three profiles. Written now so that the moment Paul grants access,
setup is typing, not deciding.

**Why this is the highest-value item in the job:** all three brands have **zero** GBP presence —
confirmed across all 39 crawled pages, no `google.com/maps`, `g.page` or `business.google` link
anywhere. For a local service business the map pack sits above every website result, and it is free.

**Facts below come from Paul's own sites.** Anything in `[brackets]` is a blank only Paul can
fill — do not invent it, and do not publish a profile with a bracket still in it.

**Shared across all three:**
- Phone: **(941) 894-0980** — must match each site exactly, character for character. Google reads
  a mismatched phone number as a different business.
- Business type: **service-area business, address hidden.** He works at client properties; a
  hidden address is correct and does not hurt ranking for this category.
- Hours: `[CONFIRM with Paul]` — do not guess. Wrong hours generate calls he cannot answer.
- Opening date: Express/BNB `[CONFIRM]`; DVPFL can use **1995** (stated on his own site).

---

## 1. Express Real Estate Photos

| Field | Value |
|---|---|
| Name | Express Real Estate Photos |
| Primary category | Real estate photographer |
| Additional | Photographer · Drone photography service · Video production service |
| Service areas | Venice · Sarasota · North Port · Bradenton · Port Charlotte |
| Website | https://www.expressrealestatephotos.com/ |
| Booking link | https://www.expressrealestatephotos.com/book-now/ |
| Phone | (941) 894-0980 |

**Description** (740 chars, under Google's 750 limit):

> Express Real Estate Photos gives listing agents everything a property needs from one visit:
> professional interior and exterior photography, video tours, aerial drone imagery, floor plans
> and virtual staging. Serving Venice, Sarasota, North Port, Bradenton and Port Charlotte.
> Booking is online and available any hour, so a listing can be scheduled the moment it is signed
> rather than the next business day. Photographs are made to sell a property, not to win awards —
> bright, accurate, and consistent across every room, so a buyer scrolling on a phone stops on
> yours. Agents who list regularly get the same photographer every time, which means the look of
> your listings stays consistent across the whole year.

**Services to list** (Google shows these as their own entries):
Real estate photography · Aerial and drone photography · Real estate video · Floor plans ·
Virtual staging · Matterport 3D virtual tour `[CONFIRM: the audit found a dead Matterport link
and it was removed — is this still offered?]`

---

## 2. BNB Photos

| Field | Value |
|---|---|
| Name | BNB Photos |
| Primary category | Photographer |
| Additional | Real estate photographer · Drone photography service |
| Service areas | Venice · Sarasota · Siesta Key · Anna Maria Island · Englewood · Nokomis |
| Website | https://www.bnbphotos.com/ |
| Booking link | https://www.bnbphotos.com/contact/ |
| Phone | (941) 894-0980 |

**Description** (735 chars):

> BNB Photos photographs vacation rentals and short-term rental properties across the Suncoast —
> Venice, Sarasota, Siesta Key, Anna Maria Island, Englewood and Nokomis. Photography, video,
> drone imagery and floor plans, all made for the way guests actually book: scrolling a grid of
> thumbnails on a phone, deciding in seconds. That means a cover image chosen to earn the click,
> rooms shot bright and true to size, and the details that make a property feel worth the nightly
> rate. Hosts and property managers who list on Airbnb, Vrbo and their own sites use the same
> images everywhere, so the listing looks like one property rather than three. A single visit
> covers a whole property.

**Services to list:**
Vacation rental photography · Airbnb listing photography · Drone photography · Property video ·
Floor plans

**Note:** BNB is described on its own site as a division of Express. Keep them as **two separate
profiles** — different categories, different searchers — but cross-link the two websites in the
footers, which is already on the list.

---

## 3. Digital Video Productions FL

| Field | Value |
|---|---|
| Name | Digital Video Productions FL |
| Primary category | **Videographer** |
| Additional | Video production service · Wedding photographer |
| Service areas | Venice · Sarasota · North Port · Bradenton · Port Charlotte · Fort Myers |
| Website | https://www.dvpfl.com/ |
| Booking link | https://www.dvpfl.com/contact/ |
| Phone | (941) 894-0980 |
| Opening date | 1995 (stated on the site) |

**Description** (748 chars):

> Digital Video Productions FL has been filming weddings in Venice, Florida since 1995, serving
> Sarasota, North Port, Bradenton, Port Charlotte and Fort Myers. Cinematic wedding films,
> highlight recaps, documentary-style ceremony coverage, engagement films and memorial tributes.
> Thirty years of weddings means knowing where to stand during a ceremony without being part of
> it, and how a long day is actually shaped — the quiet half hour before the doors open, the
> toast that runs long, the light going gold outside. Couples receive a film they will watch
> again in ten years, not a highlight reel that ages in one. Dates in season book early;
> availability is worth asking about as soon as a date is set.

**Services to list:**
Wedding videography · Cinematic wedding film · Highlight recap · Documentary ceremony coverage ·
Engagement film · Memorial tribute · Commercial video

---

## Photos — the part that outranks the text

**10–15 per profile**, pulled from each site's existing portfolio. Real work Paul already owns.

- Express: exteriors, twilight shots, drone, one floor plan, one virtual-staging before/after
- BNB: living spaces, pools, views, one detail shot, one exterior
- DVPFL: ceremony, reception, couple portraits, one behind-the-scenes frame

Add the logo and a cover image to each. **Do not upload the same photo to two profiles** — Google
notices duplicates across profiles, and it makes two businesses look like one.

## First post per profile (publish at setup, so the profile is not empty on day one)

- **Express:** "Booking spring listings now — online scheduling, next-day delivery `[CONFIRM]`"
- **BNB:** "Getting a rental ready for season? Photo refreshes booking now."
- **DVPFL:** "Now booking [YEAR] weddings across Venice and Sarasota."

## After each profile is live

- [ ] Link it from the site footer and contact page (same deploy as the signup form — one edit)
- [ ] Add the GBP URL to `sameAs` in the existing LocalBusiness schema (gate G14)
- [ ] Grab the short review link (`g.page/r/...`) for the review kit — file 09
- [ ] Verify name, phone and areas match the live site exactly (gate G12)

## Blanks Paul must fill before publishing

1. Opening hours for all three
2. Express turnaround time (also blocks the welcome email in file 06)
3. Express: is the Matterport 3D tour still offered?
4. Opening year for Express and BNB
5. The year to use in the DVPFL first post
