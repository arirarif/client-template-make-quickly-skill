# 15 — FAQ content and schema

Neither Express nor BNB has a single FAQ on the site. These are the questions the two audiences
actually ask before booking, drawn from the buyer research and from what the sites already say.

Two payoffs: the answers remove the objections that stop someone booking, and marked up correctly
they can win an expanded search result that takes up more of the page than a competitor's listing.

**Every answer below is built from facts already published on Paul's sites.** Anything unverified
is marked `[CONFIRM]` — publish those only once he has answered.

---

## How to add them

**Preferred route — Yoast's FAQ block.** Both sites run Yoast. Edit the page, add a **Yoast FAQ**
block, paste the pairs in. Yoast emits valid `FAQPage` schema automatically, so there is no hand-
written JSON-LD to maintain and nothing to break on an update.

**Do not hand-write JSON-LD on BNB.** That site's Wordfence firewall rejects any save containing
`<script>` tags — the same block that is holding up the placeholder-schema fix. Yoast's block
sidesteps it entirely.

**Placement:** near the bottom of the relevant page, above the contact form.

---

## Express Real Estate Photos — put on `/services/`

**How quickly do I get the photos back?**
`[CONFIRM turnaround]` — the one genuine blank. Do not guess; agents choose on this answer.

**How long does a shoot take?**
Most homes take under two hours on site. Larger properties, or a shoot combining photography with
video, drone and a floor plan, take longer — but they are still a single visit, so the seller is
disturbed once.

**Do I have to be there?**
No. Plenty of agents arrange access and leave me to it. If the property is occupied it helps to
have someone there to move cars and switch on lights, but it is not required.

**How should the property be prepared?**
Blinds open, every lamp on, counters and worktops clear, cars off the driveway, bins out of shot.
Sellers who do that end up with noticeably better light in every room. There is a full checklist on
the blog.

**Can I book photography, video and a floor plan together?**
Yes, and that is the point of booking here rather than with three separate vendors. Photography,
video, drone, floor plans, virtual staging, Matterport 3D and Zillow Boost walkthroughs are all shot
in one visit and delivered together — one appointment, one invoice.

**What is virtual staging, and when is it worth it?**
Furniture added digitally to photographs of an empty room, so a buyer can see how the space works.
It is worth it on vacant properties, where empty rooms read as smaller and colder than they are.

**Which areas do you cover?**
Venice, Sarasota, North Port, Bradenton, Port Charlotte and the communities between them.

**Do you work with agents who list regularly?**
Yes — most of the work is repeat. The advantage is consistency: the same photographer means your
listings share a look rather than changing style shoot to shoot.

---

## BNB Photos — put on `/services/`

**Will better photographs actually get me more bookings?**
They change how often your listing gets clicked, and platforms show listings that get clicked more
often. That is the chain: better cover image, more clicks, more visibility, more nights booked.
Photography is the cheapest lever a host has on occupancy.

**How many photos will I get?**
`[CONFIRM typical count]` — hosts ask this before anything else.

**What does it cost?**
Pricing is based on property size, from a 1,500 sq ft base, **+$50 per additional 1,000 sq ft**.
Aerial photography is **+$100**, and off-site amenities such as a pool, clubhouse or beach access
are **+$50 for up to five photos**.

**How should I prepare the property?**
Treat it as a turnover, then go further: clear every surface, open all blinds, switch on every lamp,
hide remotes, chargers and bins, and make the beds properly. There is a full prep checklist on the
blog.

**Do I need to be there?**
No, as long as I can get in. Most hosts leave access instructions and never attend.

**Can I use these photos on Airbnb, Vrbo and Booking.com?**
Yes. The same set works across every platform and on your own site, which is what keeps a listing
looking like one property rather than three.

**Is twilight photography worth the money?**
For a property with a pool, a water view or good outdoor lighting, yes — twilight shots are the
ones guests remember, and they make strong cover images. For an interior-led listing the money is
better spent elsewhere. I will tell you honestly which yours is.

**Do you shoot floor plans?**
Yes. Guests booking for a group care about how a property is laid out — how bedrooms are separated,
where the bathrooms are — and a floor plan answers that before anyone has to ask.

**Which areas do you cover?**
Venice, Sarasota, Siesta Key, Anna Maria Island, Englewood and Nokomis.

**How soon can you shoot?**
`[CONFIRM lead time]`

---

## Two things to get right

**Only publish answers that are true.** Three questions above are blanks on purpose — turnaround
time, photo count, and lead time. They are exactly the questions buyers care most about, which is
why guessing them is worse than leaving them out. Ask Paul once and fill all three.

**Never mark up an answer that is not visible on the page.** Google requires FAQ schema to match
what a visitor can read. Using the Yoast block makes this automatic; hand-written JSON-LD is where
people get this wrong and earn a manual action.
