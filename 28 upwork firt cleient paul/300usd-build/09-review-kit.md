# 09 — Review kit

Reviews are the fuel for the map pack. Ten real reviews beats a competitor with two, regardless
of who has the better website. All three profiles start at zero.

Two halves: **turning Paul's forwarded emails into on-site proof** (needs his emails), and
**the engine that keeps reviews arriving after this job ends** (needs nothing from him but sending).

---

## Part A — the ask templates

Paul sends these. One message, after each job, at the moment goodwill is highest. Each is short
enough to send from a phone.

### Agents (Express) — after the 2nd or 3rd completed shoot

> Hi [name] — glad the photos worked for the [street] listing. If you have a minute, a quick
> Google review helps other agents find me more than anything else I could do:
> [GBP REVIEW LINK]
> Either way, thanks for the work this year.

**Why the 2nd or 3rd, not the first:** an agent who has used him twice is reviewing a working
relationship, not a single transaction. Those reviews read as more credible and mention repeat
use, which is exactly what the next agent is looking for.

### Hosts (BNB) — when the listing goes live with the new photos

> Hi [name] — saw the listing is live with the new photos, it looks great. If the shoot was
> worth it, would you mind leaving a quick Google review? It genuinely helps other hosts find me:
> [GBP REVIEW LINK]
> Thanks — and let me know how bookings go.

**Why then:** the host has just seen the photos in the place they matter. Asking at delivery is
asking before they've felt the benefit.

### Couples (DVPFL) — a few days after the film is delivered

> Hi [names] — hope you've had a chance to watch it properly, and congratulations again.
> If you're happy with the film, a short Google review would mean a lot — it's how most couples
> find me: [GBP REVIEW LINK]
> Thank you both for having me there.

**Why a few days:** they watch it the day it arrives, usually with family. Asking at the end of
that week catches them after they've watched it twice, not while they're still opening it.

### If someone says yes but never does it

One follow-up, once, a week later. Never a second.

> Hi [name] — no pressure at all, just floating this back up in case it got buried: [LINK]

---

## Part B — on-site review sections

Built from the 3–5 emails Paul forwards. **Nothing invented.** Same rule as the DVPFL copy work:
every published sentence traces to a real message.

**Process:**
1. Pull the usable sentence, the person's name, and their role or town.
2. If the source was private, Paul sends one line: *"Happy for me to use your words on the site?"*
   Public reviews need no permission; a private email does.
3. Build one section per site, styled to match, placed above the contact form.
4. Add `Review` schema per testimonial.

**Schema rules — the part that carries risk:**
- `Review` markup per real testimonial: fine.
- **`AggregateRating` only once real Google reviews with real star values exist.** Inventing a
  rating is a manual-action risk, and a manual action costs more than the reviews are worth.
  Gate G16 fails the build if an `aggregateRating` appears with no real review count behind it.
- Names as given. No stock photos of fake people.

**Markup pattern** (drop into the same footer/HTML widget route as the signup form):

```html
<section class="reviews" aria-label="Client reviews">
  <h2>What clients say</h2>

  <figure class="review" itemscope itemtype="https://schema.org/Review">
    <blockquote itemprop="reviewBody">
      <!-- exact words from the forwarded message, trimmed only for length -->
    </blockquote>
    <figcaption>
      <span itemprop="author" itemscope itemtype="https://schema.org/Person">
        <span itemprop="name"><!-- real name --></span>
      </span>
      <!-- role or town -->
    </figcaption>
    <meta itemprop="itemReviewed" content="<!-- business name -->">
  </figure>

  <!-- repeat per review -->
</section>
```

**Placement per site:**
- Express → above the contact form, agents' names and brokerages shown
- BNB → homepage, below the portfolio, hosts identified by property type and area
- DVPFL → below the films, couples' first names and venue

---

## Part C — automate the ask where a delivery email already exists

Once Brevo is live, the ask can send itself:

- Brevo → Automations → trigger on a "job delivered" tag added to a contact
- Wait the right number of days per audience (0 for hosts at listing-live, 3 for couples)
- Send the matching template above

That is what makes this outlast the job: Paul stops having to remember.

---

## Delivered to Paul (gate G18)

- [ ] The three ask templates, in a form he can copy from his phone
- [ ] The short review link per profile (`g.page/r/...`), once the GBP profiles exist
- [ ] One line on when to ask for each audience — the timing is most of the yield

## Blocked

- **Part B is blocked on Paul forwarding 3–5 client emails.** If they never arrive, the review
  section still gets built and left empty with a one-click way to fill it later. This does not
  block closing the job — see the risk register in `../WORKFLOW-300USD-parallel.md`.
