# 11 — Reply to Paul's go-ahead

**Context.** Paul replied: *"if he already added all in his contact like phone number, mail and
all then we're good to add everything in google so people can find out in map and all. and rest
of it he will confirm later."*

He has said yes. But there is a misunderstanding inside it worth correcting gently: he seems to
think that because his phone number and email are already on the websites, the Google listing can
just be switched on. It cannot. Google verifies the **owner**, by mailing a postcard or calling
the number, and only he can receive that. Nothing on the websites substitutes for it.

So this reply does three things: take the yes, explain the one unavoidable step in plain words,
and hand him a genuinely good piece of news so the message is not purely another ask.

---

## The message

Hi Paul,

Perfect — that's the go-ahead I needed. I'll build all three listings.

One thing I should be straight about, because it's the only part I can't do for you: Google won't
publish a business listing just because the phone number is on the website. Before it goes live,
Google checks that the person setting it up really owns the business — it either posts a postcard
to you with a code on it, or rings the number and reads you a code. I can do everything either
side of that, but the code only ever goes to you.

So all I need is you nearby for about ten minutes. I'll share my screen, do all the typing, and
you click "next" a couple of times and read me the code. That's the whole job.

**And something worth knowing that I found while checking.** You have far more reviews than I
realised — 181 on The Knot, 110 on WeddingWire, 43 on Thumbtack, all sitting at five stars.
That's over three hundred happy clients on record.

Two things about that. First, none of them are on Google, which is where most people actually
look before they call. Second, none of them are on your own websites either — a couple in ten
years of that reputation is doing nothing for you right now. Once the Google listing is live, I'll
put the best of them on the sites and set up an easy way for new clients to leave one.

So you don't need to dig up old emails after all. You already have the proof; it's just in the
wrong places.

One last thing: a competitor is currently paying Google to advertise on your business name — when
someone searches "Express Real Estate Photos", their ad shows above your website. A Google
listing is the free fix for that, since your own listing sits above the ads.

Send me a couple of times that suit you — evenings are fine.

Thanks,
Arif

---

## Research behind this message (2026-09-09, read-only Google searches)

**Express Real Estate Photos** — searched the exact brand name plus "Venice FL":
- **No business listing, no map panel.** Confirms zero presence.
- **A competitor, `anyhomeshoots.com`, runs a paid ad on his brand-name query** — twice on the
  page, above his own website. Real and worth telling him.
- `/contact-v1/` still appears in results ("Contact V1 - Express Real Estate Photos") despite the
  August redirect. Probably Google not having recrawled, but **verify once DNS is working** —
  if it still serves 200, the v1 cleanup has a gap.
- The homepage snippet still shows the **old** title. Expected; the fix was hours ago.
- Google's AI Overview lists Matterport **and** a Zillow 3D walkthrough as current services, and
  both have live pages. That effectively answers one of my five questions for him — **Matterport
  is still offered**, so stop asking.
- Public address granularity: "Venice, FL 34293". Enough for a service-area listing.

**Digital Video Productions FL** — the big one:

| Platform | Rating | Reviews |
|---|---|---|
| The Knot | 5.0 | **181** |
| WeddingWire | 5.0 | **110** |
| Thumbtack | 4.9 | **43** |
| Facebook | 5.0 | 15 |

**No Google listing.** So roughly **350 five-star reviews exist and none are on Google**, which is
where couples look first. The August audit called the Knot/WeddingWire badges on his site
"unverified" — they are not decorative, the ratings behind them are real and excellent.

**This changes the review deliverable.** File 09 assumes Paul forwards 3–5 client emails, which
he was never going to get round to. He does not need to: there are hundreds of public reviews
already. Plan instead: quote a small number briefly **with attribution and a link to the source**
(short quote plus link, not wholesale copying — respect the platforms' content), and lead with the
factual aggregate, "5.0 from 181 reviews on The Knot", which is verifiable and strong.
`AggregateRating` schema still waits for real Google reviews, per the rule in file 09.

**BNB Photos** — no business listing, no third-party reviews. Its own pages rank for the brand.

**New defect spotted in the BNB results:** the **same meta description repeats across at least
five pages** — homepage, contact, aerial, blog post, category. My earlier BNB audit measured
description *lengths* (123–140) but only ran the duplicate check on DVPFL, so this slipped past.
Same class of problem August fixed on DVPFL. **Verify and fix once DNS is back.**
