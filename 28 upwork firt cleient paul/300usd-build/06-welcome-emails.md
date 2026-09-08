# 06 — Welcome emails, one per audience

Sent automatically the moment someone confirms their subscription. Plain text, from Paul,
signed by Paul. Not a newsletter — a handshake that makes the next email welcome.

**Setup:** Brevo → Automations → "Welcome message" → trigger: contact added to list → send
immediately. One automation per list. Gate G7 checks it fires within 60 seconds.

**Rules I followed, so edits keep working:**
- Plain text, no images, no template chrome. Deliverability on a free tier depends on looking
  like a person wrote it, and a first email that looks like a campaign gets filed as one.
- One link each. Two links in a welcome email halves the click on the one that matters.
- No discount, no urgency. These people just arrived; the goal is that they open the next one.
- Subject lines under 45 characters so they survive a phone inbox.
- Every factual claim comes from Paul's own sites. **Anything in [brackets] is a blank Paul must
  fill or confirm before this goes live** — do not guess on his behalf.

---

## 1. `bnb-hosts` — Airbnb hosts and property managers

**Subject:** Thanks — here's the one that matters most

> Hi,
>
> Thanks for signing up. I'm Paul — I photograph vacation rentals around Venice, Sarasota and
> the barrier islands.
>
> One thing before anything else, because it moves bookings more than any other single change:
> your first photo. Guests scroll a grid of thumbnails, and the cover shot decides whether they
> ever see the other twenty. It should be the room that makes the place worth booking — usually
> the living space or the view, shot wide, in daylight, with nothing on the counters.
>
> If you want a look at what that turns into, my recent work is here:
> https://www.bnbphotos.com/
>
> Every so often I'll send something practical — how to prep a property, what guests skip past,
> when a refresh is worth it. That's all.
>
> If you have a property coming up, just reply to this email and tell me a bit about it.
>
> Paul Ayoub
> BNB Photos · (941) 894-0980

---

## 2. `express-agents` — listing agents and brokerages

**Subject:** Thanks — turnaround and how to book

> Hi,
>
> Thanks for signing up. I'm Paul — I shoot real estate photography for agents across Venice,
> Sarasota, North Port, Bradenton and Port Charlotte.
>
> The practical part, so you have it when you need it:
>
> - Photos, video, drone, floor plans and virtual staging, so a listing needs one visit and one
>   invoice rather than three vendors.
> - Delivery is [CONFIRM: next business day?] — **Paul, tell me the real number and I'll fix
>   this line.**
> - Booking is online, any hour: https://www.expressrealestatephotos.com/book-now/
>
> A shoot goes fastest when the property is photo-ready before I arrive — blinds open, lights on,
> counters and driveways clear, cars moved. Sellers who do that end up with better light in
> every room.
>
> I'll send something occasionally — availability before the spring listing season, and anything
> genuinely useful. Not often.
>
> Got a listing coming up? Reply here and I'll get you on the calendar.
>
> Paul Ayoub
> Express Real Estate Photos · (941) 894-0980

---

## 3. `dvpfl-couples` — engaged couples

**Subject:** Congratulations — one film to watch

> Hi,
>
> Congratulations, and thanks for getting in touch. I'm Paul — I've been filming weddings around
> Venice and Sarasota since 1995.
>
> Rather than tell you what I do, here's a film. It's the honest way to judge a wedding
> videographer, because you'll know within a minute whether it feels like you:
> https://www.dvpfl.com/
>
> One thing worth knowing while you plan: good dates go early, especially in season. If you have
> a date, it's worth asking about it now even if you're still deciding — there's no cost to
> asking, and it saves the disappointment later.
>
> I'll send a few things while you plan — real weddings, and questions worth asking any
> videographer you talk to, including me. Then I stop.
>
> If you already have a date, reply and tell me. I'll let you know if it's open.
>
> Paul Ayoub
> Digital Video Productions FL · (941) 894-0980

---

## Before these go live

- [ ] Paul confirms the Express turnaround time — the only invented-shaped blank in these three
- [ ] Paul reads all three and changes any line that does not sound like him. His name is on them;
      his voice should be too.
- [ ] Sender address verified in Brevo, or none of them send at all
- [ ] Test signup on each list → confirm the email arrives within 60s and the link works (G7)
