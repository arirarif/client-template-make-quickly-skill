# Content sheet — field by field

Workflow step T1. Each row is one editor field: **current value** (what Fotello put there) → **new value**.
Sources: the live Express site (`content/*.md`), `300usd-build/15-faq-content.md`, `08-gbp-content-pack.md`.
Only facts already published on Paul's site are used. Anything unconfirmed is marked `[PAUL]` and stays out until he answers.

Facts in use (all already public on expressrealestatephotos.com):
- Paul personally handles every shoot, no subcontractors (About page)
- Next-day delivery (homepage meta description)
- Services: photography, video, drone, floor plans, 3D tours (Zillow Boost, Matterport), virtual staging, virtual twilight, property website, sizzle reel
- Prices: Basic from $149 · Classic $249 · Deluxe $349 · Premier $449
- Area: Venice, Sarasota, North Port, Bradenton, Port Charlotte, Englewood, Siesta Key
- Phone (941) 894-0980

---

## Header

| Field | Current | New |
|---|---|---|
| Brand image | broken placeholder | logo `[PAUL]` (use `assets/logo-5.png` if he doesn't send a better one) |
| Company name | Express Real Estate Photos | keep |
| Phone | +19418940980 | keep (the field probably drives the tap-to-call link) |
| Nav links | Hero, Partners, Why Us, Packages, Stats, FAQ, Portfolio, Contact | remove **Stats** while it's hidden; the rest stay |

## Hero

| Field | Current | New |
|---|---|---|
| Eyebrow | Magazine-quality real estate media | Real estate photography · Venice, FL |
| Headline | The photographer Venice agents call first. | keep |
| Subtext | Everything your listing needs to compete online. | Photos, video, drone, floor plans and 3D tours from one visit. Shot by Paul, delivered next day. |
| Highlight 1 | Next-morning delivery | Next-day delivery |
| Highlight 2 | **4.9 agent rating** ❌ | Every shoot by Paul |
| Highlight 3 | **5,000+ properties shot** ❌ | Venice to Sarasota |
| Slides ×3 | stock houses ❌ | Paul's listings (T2) |
| Button label | Book a Shoot | keep |
| Address placeholder | Enter your property address… | Enter the listing address… |

## Logo slider ("Partners")

| Field | Current | New |
|---|---|---|
| Headline | (empty) | Trusted by agents from |
| Logos ×6 | check which | only brokerages Paul has shot for `[PAUL]`. The current site shows KW, RE/MAX, Berkshire Hathaway, eXp, Zillow, Airbnb, Booking.com. If he can't confirm, hide the section |

## Why Us

| Field | Current | New |
|---|---|---|
| Eyebrow | It's not complicated | Why agents book Express |
| Headline | The listings that markets best get best offers *(grammar error)* | The best-marketed listings get the best offers. |
| Body | Paul's About text, copied | see below |
| Image | stock porch ❌ | a Paul listing exterior (T2) |

Body:
> I'm Paul, and I shoot every Express listing myself. No subcontractors, so the quality you saw on your last listing is the quality you get on the next one.
>
> I've photographed homes across Southwest Florida for years, and I'm a real estate investor and Airbnb host myself. I know what makes a buyer stop scrolling and click, and I shoot for that: bright interiors, clean exteriors, and video that shows how a home actually feels.

## Products (packages)

| Field | Current | New |
|---|---|---|
| Headline | Choose the right package for your listing. | keep |
| Subtext | Transparent pricing, flat rates, no surprises. *("flat rates" is wrong — prices go by square footage)* | Clear starting prices. Enter the address and the final price is set by square footage. |

Package cards come from Paul's **Fotello Products** (`/dashboard/products`), which also run his live booking. **Don't edit them without Paul's OK.** Proposed descriptions to send him (Basic and Classic currently share the same text):

- **Basic — from $149:** Professional interior and exterior photos, edited and delivered next day. Everything a listing needs to go live.
- **Classic — from $249:** Everything in Basic, plus a virtual twilight cover shot, a property website and a short sizzle reel for social media.
- **Deluxe — from $349:** Everything in Classic, plus a floor plan, aerial drone photos and a Zillow Boost 3D tour.
- **Premier — from $449:** Everything in Deluxe, plus a walkthrough video. Built for high-end listings where every detail counts.

## Stats

| Field | Current | New |
|---|---|---|
| 5,000+ / Properties shot | invented ❌ | `[PAUL]` |
| 24h / Average turnaround | conflicts with "next day" | Next day / Delivery |
| 1 in 4 / City listings we shoot | invented ❌ | remove |
| 4.9/5 / Average agent rating | invented ❌ | remove |

→ **Hide the whole section** until Paul gives at least 3 real figures.

## Reviews

Hidden ✅. Stays hidden until Paul's real reviews arrive.

## FAQ

| Field | Current | New |
|---|---|---|
| Headline | Questions agents ask before booking | keep |
| Subtext | Straight answers about shoots, turnaround, and delivery. | keep |

Replace all Q&As (the current ones promise "same-day rush" and "our photographers" — not true for a one-man business):

1. **How fast do I get the photos?**
   Next day. Photos, video and tours are edited and delivered the day after the shoot, so the listing can go live without waiting.
2. **How long does the shoot take?**
   Most homes take under two hours. Bigger homes, or shoots that add video, drone and a floor plan, take longer, but it's still one visit, so the seller is only disturbed once.
3. **Do I need to be there?**
   No. Many agents set up access and leave me to it. If the home is occupied, it helps to have someone there to move cars and turn on lights, but it isn't required.
4. **How should the home be prepared?**
   Blinds open, every light on, counters cleared, cars off the driveway, bins out of sight. Those five things make the biggest difference in every room.
5. **Can I book photos, video and a floor plan together?**
   Yes, that's the point. Photography, video, drone, floor plans, virtual staging and 3D tours are all done in one visit and delivered together, with one booking and one invoice.
6. **What is virtual staging, and when is it worth it?**
   Furniture is added digitally to photos of an empty room, so buyers can see how the space works. It's worth it for vacant homes, where empty rooms look smaller and colder than they are.
7. **Which areas do you cover?**
   Venice, Sarasota, North Port, Englewood, Port Charlotte, Bradenton, Siesta Key and the towns in between.
8. **Do you work with agents who list often?**
   Yes, most of my work is repeat. Using the same photographer means all your listings share one consistent look.

## Portfolio

| Field | Current | New |
|---|---|---|
| Headline | The work that gets agents their next listing. | keep |
| Subtext | A selection of properties we have recently photographed. | Recent listings across Venice, Sarasota, Englewood and Siesta Key. |
| Images | stock ❌ | Paul's listings (T2) |

## Contact

| Field | Current | New |
|---|---|---|
| Headline | Tell us about your listing | keep |
| Subtext | Send a few details and we will come back with availability the same day. *("same day" is a promise Paul hasn't made)* | Send the address and a preferred date, and Paul will reply with availability. |
| Button | Send message | keep |
| Success message | Thanks — we will be in touch shortly. | Thanks, Paul will be in touch shortly. |
| Message placeholder | Two-bed condo in Larchmont, listing goes live Monday *(Larchmont is in New York)* | Three-bed pool home in Venice, listing goes live Monday |

## Footer

| Field | Current | New |
|---|---|---|
| Name | Express Real Estate Photos | keep |
| Blurb | Professional real estate photography and media services — helping agents showcase every listing at its best. | Real estate photography, video, drone, floor plans and 3D tours for listing agents in Venice, Sarasota and Southwest Florida. |
| Email | orders@expressrealestatephotos.com | keep for now `[PAUL]` — the live site uses **support@** on every page (29 mentions); orders@ is likely his Fotello login and the address that receives bookings. Ask which one he reads |
| Phone | +19418940980 | keep |
| Instagram / Facebook / YouTube | expressrealestatephotos | keep — checked 2026-09-21: all three profiles exist and match the current site |

---

## Questions for Paul collected from this sheet

1. Real reviews (3–5)
2. Properties shot (roughly), for Stats
3. Logo file
4. Which brokerages to show in "Trusted by agents from"
5. OK to update the four package descriptions in his Fotello Products?
6. orders@ or support@ for the contact email?
