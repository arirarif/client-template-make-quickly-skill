# Studio management app — concept teardown (research for a portfolio project)

Source studied: Fotello (app.fotello.co), a SaaS for real-estate photography studios. It was viewed while logged in to a studio account on 2026-09-17.
All notes are written in my own words. **No customer names, addresses or prices from the account are recorded.**
Goal: understand how the product works, then build an ORIGINAL design with its own branding and wording for the portfolio.

---

## 1. What the product is

An all-in-one back office for a real-estate media business (photographers, videographers, drone, floor plans, virtual staging):
agents book shoots → the studio schedules and shoots them → it uploads and delivers the media in a branded gallery → invoices are paid → reports show how the business is doing.
It also markets the studio (a public booking website, SEO "site score", an agent-facing marketplace) and connects to other tools (accounting, payroll, floor plans, pay-at-closing financing).

## 2. App shell (layout pattern)

- **Left sidebar**, collapsible (toggle button next to the breadcrumb). The logo sits at the top, and an account/company switcher at the bottom shows the studio name and the logged-in user.
- Sidebar groups:
  - Main: New Listing · Listings · Schedule · Orders · Invoices · Customers · Reports · Marketing ("New" badge)
  - *Studio Manager*: Website (with an "Improve business" sub-hint) · Products · Order Form · Customer Gallery · Availability · Automation · Apps
  - **Promo carousel** card in the sidebar (dismissible): partner apps with a "Connect Now" button, rotating with dots
- **Top bar**: breadcrumb (Dashboard › Page), referral button ("Earn $100"), dark-mode toggle, settings gear.
- **Global announcement banner** (brand colour, dismissible): nudges the owner to raise their website score and links to that task.
- Keyboard shortcuts on the main create buttons (e.g. Ctrl+Shift+A = new listing, Ctrl+Shift+E = new order).
- The `/dashboard` root redirects to Listings (no separate home dashboard).
- Visual style: white canvas, thin grey dividers, one coral/pink accent, rounded pills for statuses, coloured initial-avatars for customers, skeleton loaders while tables load.

## 3. Pages

### 3.1 Listings (`/dashboard/listings`) — the core object
- A listing = one property address (the unit of work). A header counter shows the total number of listings.
- Toolbar: one combined **search + filter** input (a filter icon inside the input), a primary **New Listing** button, and **Import**.
- Table columns: Listing (thumbnail + address) · Status · Customer (avatar + name) · Members (assigned team avatars) · Appointments (next date/time) · Created At · Actions (row menu). Every column is sortable.
- Statuses seen: **Pending delivery**, **Delivered**. A secondary tag under the address shows e.g. "Video Completed".
- Empty thumbnails show a house icon placeholder.

### 3.2 Schedule (`/dashboard/schedule`)
- A full calendar page with its own left panel: "Back to Dashboard" and a mini month calendar.
- Header: Today · prev/next arrows · date-range title · **timezone selector** · view switch **Day / Week / Month / Map** (Map = shoots plotted geographically for route planning).
- A red "now" line on today's column.
- Right panel: **Unscheduled** queue (orders without an appointment, collapsible) and a **+ New order** button → drag an order onto the calendar to book it.

### 3.3 Orders (`/dashboard/orders`)
- An order = what the customer bought for a property (a product bundle), which creates appointments.
- Toolbar: search/filter, **New Order** (Ctrl+Shift+E), Import.
- Columns: Address · Status · Customer · Appointments · Created At · Actions.

### 3.4 Invoices (`/dashboard/invoices`)
- Header count of invoices. Toolbar: search/filter, **Import**, **Export**, and an icon button with a badge counter (likely a queue of invoices waiting for action).
- Columns: Invoice # (generated code, customer prefix + sequence) · Address · Status · Customer · Amount · Due At · Created At · Actions (⋯ menu).
- Statuses: **Paid** (dark green pill), **Draft** (grey pill; drafts have no invoice number yet).

### 3.5 Customers (`/dashboard/customers/customers`)
- Tabs: **Customers** | **Teams** (a team = a brokerage or agent team, grouping several agents).
- Toolbar: search/filter, **Add**, **Import**.
- Columns: Name · Email · Phone · Status · Terms & Privacy (whether the customer accepted the studio's terms) · Last Updated · Actions.

### 3.6 Reports (`/dashboard/reports/<tab>`)
- Tabs: **Media · Customers · Money · Demand · Products · Team · Mileage**.
- Shared filter row: date range (e.g. last 12 months) · **Compare** toggle with a period (last year) · team-member filter.
- Media tab ("how much you shot and what you delivered"):
  - KPI cards with a big number and a monthly bar chart, compared with the same period last year: *Listings produced*, *Twilight & staging created*
  - 90-day rolling KPIs: *Average time at a property*, *Shoots running over 2 hours*, *Minutes per shot*
  - Table *Shoots by property size*: Property size · Shoots · Typical time · Per shot
  - Each card has an icon button to switch between chart and table.
- **Customers tab**
  - KPI cards: *Active customers*, *New customers*, *New-customer revenue*, *Repeat-customer revenue*
  - *Relationships* section: how concentrated revenue is (the biggest customer's share as a %)
  - *Customer health*: lists of **At risk** customers (ordering less) and **Lapsed** customers (stopped ordering)
  - *Top customers* table: Customer · Orders · Revenue (12 mo). *Revenue by brokerage* table
- **Money tab**
  - KPIs: *Invoiced*, *Collected*, *Average order value*, plus a *Detail* breakdown
  - *Coverage & pipeline*, *Outstanding by age* (aging buckets)
  - *Payments & collections*; *Tips, fees & settlement*; *How money arrived* (payment methods); *Discounts given, by source*
  - *Who owes you money* table: Customer · Invoices · Oldest overdue · Outstanding
- **Demand tab**
  - KPIs: *Orders placed*, *Cancellations & reschedules*, *Already on the books*, *Booked forward*
  - *Where demand comes from* (booking channel: order form, manual, import…)
  - *Lead time & calendar churn*; *Orders by status*; *How far ahead customers book* (distribution)
- **Products tab**
  - *Services & add-ons* table: Product · Orders · Attach rate · Revenue
  - *Packages* table: Package · Includes · Times sold
  - *Order value by service type*; *Packages vs individual services*
  - *Pricing & bundling* / *What you actually charge*: At list price · Actually charged · Realized %
  - *Frequently bought together*: Bought together · Lift (a market-basket analysis)
- **Team tab** ("how the work is spread across people")
  - Filters: date · member · customer team · service area
  - *Workload by member* table: Member · Shoots · Booked hours · Rescheduled · Cancelled (with a note that per-member revenue needs an attribution rule to be configured)
  - *Share of booked hours* shown as horizontal progress bars
- **Mileage tab** (drive tracking for tax deductions)
  - Segmented control Daily / Monthly / Detailed · date range · member filter · **Total distance** summary top-right
  - Trips table: Date · Team member · Start address · End address (each with an open-in-maps icon) · Distance (mi) · **Export** button
  - Trips are generated automatically from consecutive appointment addresses

### 3.7 Listing detail (`/dashboard/listings/<id>?tab=…`) — the heart of delivery
- **Header:** the address as the page title. Below it: Customer (avatar + edit pencil) and Members (assigned staff + edit pencil).
  Right side: a **Share Gallery** button, a **status button** (Delivered / Pending delivery, used to deliver the job), and a ⋯ menu.
- **Tabs** (each one sets `?tab=` in the URL):
  1. **Info.** A two-column form:
     - Left: *Location* (address lines, city, state, postal code, country, and an embedded map with a pin); *Basic information* (custom property name, description, built area, lot size, year built); *Property details* (stories, bedrooms, full/half/¾ baths, parking); *Neighborhood* (name + description)
     - Right sidebar cards: *Listing status* (Draft…), *Go-live date*, *Listing price*, *Property type*, *Amenities*, *MLS number*
     - This data feeds the property website and the marketing designs
  2. **Photos.**
     - A count, then an upload tile ("upload edited photos") and a grid of thumbnails with file names (drone JPGs, camera RAW files)
     - Hovering a photo shows a mini toolbar (AI enhance options such as twilight/sky/staging, favourite, crop, more)
     - Toolbar: **AI enhance** button ("make my photos better"), **Create video**, **Download photos** (a dropdown for size/format), and a ⋯ menu
  3. **Videos.** The empty state offers two big choices: **generate a video from the listing's photos** (AI slideshow/reel), or **upload an existing video**.
  4. **Virtual tours.** A count, plus an "Add tour" tile with a URL field (embed Matterport-style links). Each tour shows as a thumbnail card.
  5. **Floor plans.** A count and a **Download floor plans** button. An integration banner for the floor-plan partner app (create plans from a phone scan → *Connect*), plus an "Add floor plans" tile with upload or URL.
  6. **Marketing kit** (URL `?tab=designs`).
     - An info banner: the studio decides which designs are included free with delivery and which are sold as paid add-ons
     - An *Included designs* drop zone (drag a design here to include it for free) and a **Make all free** button
     - *Earn with these designs*: design templates auto-filled with the listing's photos and data, grouped as **Reels** (social video: just listed / just sold / open house / dream home…), **Flyers** (about 20 variants), **Brochures** (about 14 variants), each with a "View more (n)" link. Every card carries an **Add-on** tag.
  7. **Website.** A single-property website:
     - *Active website* (the basic template is free)
     - *Premium templates* sold as add-ons
  8. **Orders.** The full order detail for this property:
     - Order number, status pill (**Accepted**), date and a ⋯ menu
     - *Products* card: line items (package name / size tier, e.g. by square footage, with an expandable "included" list), amount, delete icon, subtotal, and an edit pencil
     - *Appointments* card: Date & time · Duration · Assigned to · **Reschedule** · ⋯, with + to add another appointment
     - *Invoices* card (+ to create)
     - *Intake questions* (answers the customer gave on the order form, e.g. "who will be present at the shoot")
     - Right column: *Details* (order ID, status, created/updated time, currency) and *Internal note* (+ Add note, staff only)

**Pricing idea worth copying as a concept:** packages are priced by **property size tier** (square-footage bands).

### 3.8 Marketing (`/dashboard/marketing/templates`) — email campaigns to customers (agents)
- A *Templates* tab and a **Start from scratch** button.
- Template gallery in 3 goal-based cards, each with 2 starter templates:
  - *Promote an offer* → seasonal discount, one-off special
  - *Stay in touch* → holiday greeting, re-engage past clients
  - *Show your work* → announce a new service, share recent shoots
- **Campaign editor** (`/dashboard/marketing/new?template=…`):
  - Top: *New campaign* title, **Send test**, **Send**
  - Left: an "Email" card with From / Reply-to (the studio's sending domain), a **recipient picker**, **Subject** with merge-tag chips (first name, company name) and an *Insert* menu, and a **Message** rich-text editor (bold, italic, strike, bullet/numbered lists, undo/redo, image, attachment, Insert merge tag)
  - Right: a live **Preview** pane showing the email with merge tags filled in
  - **Save as template**

### 3.9 Website (`/dashboard/manage-website/site`) — the studio's public booking site
- Tabs: **Website** | **Leads** (an inbox of enquiries from the site).
- *Publish bar:* status ("ready to go live", **Not published** pill, "only you can see it", last edited time), plus **View** and **Publish website** buttons.
- *Online score card (gamified SEO):*
  - A ring gauge with the current score out of 100, compared with nearby competitors
  - A progress bar from today's score to the projected score "the moment you publish", with a second ring showing the target
- A benefits checklist: local SEO, brand customisation, packages/photos/reviews pulled in automatically, one-tap mobile booking.
- **Theme picker:** 3 full-page preview cards (a light/airy one with the brand accent, an editorial off-white one with sharp corners, and a bold one with full-width colour bands). The current theme shows an **Active** badge; the others show a **Preview** button. Content carries over between themes, and nothing goes live until you save.
- The site's hero pattern: a big headline, an **address input + "Book a shoot"** button, and trust stats (turnaround, rating, shoots delivered). The nav has Client login + a Book button.
- The same score nudge appears as the **global top banner** across the whole app.

### 3.10 Products (`/dashboard/products/<tab>`) — the service catalogue
- Tabs: **Packages · Services · Add-ons · Travel Fee · Custom Fee · Coupons**.
- An **AI assistant side panel** (slides in from the right, can expand or close). It offers suggestion chips for catalogue tasks, e.g. import products from an existing website URL, research local competitor pricing, create a service with size-based tiers, or raise all prices by a %. It has a chat input with a "uses context from" selector.
- **Packages** table: drag-to-reorder handle · Name · Included services · Recommended add-ons · Price · Duration · Actions, plus an **Add Package** button.
- **Services** table: reorder · thumbnail + Name · Type (Photo / Video / Virtual tour / Drone…) · Recommended add-ons · Price · Duration · Actions, plus **Add Service** and search. Types seen: aerial photos, walkthrough video, reel video, 3D tour.
- **Add-ons** table (same pattern): some add-ons are the platform's own digital products (marketing designs, premium property website), others are extra shoot types.
- **Travel fee:**
  - A link to set the studio's *home base*
  - Radio cards to measure travel by **Distance** or **Time** (drive time from the assigned member to the appointment)
  - A **tiered fee table** (for the first X–Y minutes charge $; for the next band add $…, up to an open-ended last band)
- **Custom fee:** extra surcharges (listed as a tab; the page redirected during the visit).
- **Coupons** table: Code · Discount (%) · Status (Active pill) · Redemptions · Restrictions (e.g. first order only) · Actions, plus search and create.

### 3.11 Order Form (`/dashboard/order-form/<tab>`) — the customer-facing booking flow
- Tabs: **Order Forms · Intake Questions · Settings**.
- **Order Forms:**
  - A count and a form switcher dropdown (several forms are possible, e.g. per brokerage) with a ⋯ menu
  - Left column: *URL link* (a public booking URL on the studio's own sub-domain, with edit/open icons and a **Share Link** button); *Name*; *Embed code* (a script snippet with a copy button, to embed the form on any website); a *Set as default* checkbox; *Limit to specific products*; **Discard / Save**
  - Right column: a **live preview in a fake browser window** (URL bar + the studio's logo header)
- **Intake questions** (a form builder):
  - Each question card has the question text, answer options (for choice types) with + Add option / ✕, a *Type* dropdown (Radio button, Long text, …) and a *Required* toggle
  - Example uses: a property-readiness confirmation (with a fee warning), "anything to highlight", "who will be present"
- **Settings** (grouped cards with toggles and segmented controls):
  - *Booking:* collect property size (to show only size-appropriate packages and prices) · guest bookings (no account needed) · tips
  - *Scheduling:*
    - Appointment time: Required / Optional / Off
    - How customers pick: Exact slot / Time window; slot interval (dropdown, minutes); recommended times (highlight the best-fit slots); team-member selection by the customer
    - **AI scheduling** (auto-assign the best member using service area, availability, product match and drive time)
  - *Payment:* payment at booking: Full / Deposit / Optional / None
  - *Approval:* order approval: Automatic / Manual (the studio accepts or declines each request)
  - *AI phone orders:* an AI answers calls and texts and turns them into orders (toggle)

### 3.12 Customer Gallery (`/dashboard/customer-gallery/<tab>`) — the client portal where agents get their media
- Tabs: **Preferences · Settings**.
- **Preferences:**
  - *URL links:* public **login** and **sign-up** links on the studio's sub-domain, each with open and **Share Link** buttons
  - *Company logo* upload; *Brand colour* (hex picker); *Business details*; Discard/Save
  - Right side: a **live preview** of the portal's welcome/login screen (the studio's logo in the header, an email field and a Continue button, i.e. passwordless email login)
- **Settings:**
  - *Adjust panel* (what clients can do to photos), as radio cards: **Full access** (all editing tools) / **Focused access** (revision requests, object removal, profiles) / **Hidden** (view and download only)
  - *Gallery:* an optional **guided-tour video** for first-time clients
  - *Downloads:* **payment required before download** (locked until the first invoice is paid); optional **watermark** until paid
  - *Rescheduling:* customers can reschedule themselves (toggle), with a **cutoff in hours**
  - *AI chat:* let agents message the studio from inside the gallery

### 3.13 Availability (`/dashboard/availability/<tab>`)
- Tabs: **My Availability · Home Base · Service Area · Settings**. There is a **member picker** (each team member has their own settings).
- *My availability:* a weekly-hours card, one row per day (on/off switch · start – end time · + add another range · copy to other days), a timezone display and a "copy from business hours" button.
- *Home base:* the member's start address, used for travel-fee and mileage calculations.
- *Service area:* a list of areas (city + **radius in miles** + members assigned) with edit/delete and "+ add area", next to a **map** with the radius shaded.
- *Scheduling settings:*
  - Minimum buffer between jobs (minutes); optionally extend the buffer after external calendar events
  - **Smart buffer**: widens the gap using live drive time when the drive is longer than the buffer
  - Minimum notice (hours) and maximum notice (days) for bookings

### 3.14 Automation (`/dashboard/automation/<tab>`) — AI photo-editing pipeline settings
- Tabs: **Edit agent · QC agent · Categorization agent**.
- *Edit agent* (separate **Exterior / Interior** profiles via a segmented toggle):
  - Style model choice (two image cards)
  - Colour/tone preset (five image cards, one of them "original")
  - Perspective correction toggle
  - Replacement-sky picker (five image cards)
  - A "digitally altered" disclaimer stamp (dropdown)
- *QC agent* (automatic quality checks on every edit, each a toggle with an explanation):
  - Standard checks: wall-colour consistency, furniture/floor colour accuracy, photographer reflections, sky-replacement quality, horizon/perspective
  - Optional *declutter* removals (bathroom items, bins, cables, toilet seats)
- *Categorization agent:* one row per room type (exterior, kitchen, living, dining…) with a free-text "note for the AI" on how to group those photos.

### 3.15 Apps (`/dashboard/app-store`) — integrations marketplace
- Grouped card grid (icon, name, one-line benefit, an "Active" pill when connected). Each card opens a detail page.
- Groups:
  - *Own add-ons:* referral programme, staff payroll per job, SMS notifications, a mobile app, a white-label app
  - *Scheduling:* Google, Apple and Outlook calendar sync
  - *Payments:* Stripe, Square, a pay-at-closing financing partner
  - *Accounting:* QuickBooks, Xero
  - *Listing media:* a floor-plan scanning app
  - *Marketing:* a tag manager
- The same partners rotate in the sidebar promo carousel.

### 3.16 Settings (`/dashboard/settings`, opened from the gear icon)
- A **card grid** (icon + title + one-line description) linking to: Personal details · Business · Notifications · Teams & security · Referrals · Storage · Import data.
- **Business**, tabs **Details · Brand kit · Hours · Domain · Tax · Legal**:
  - *Details:* company name*, contact email*, website, phone with a country picker, address with autocomplete. *Default units:* currency, area, distance, timezone. Side column: social profile fields (Instagram, Facebook, X, LinkedIn, YouTube, Pinterest, Vimeo, TikTok)
  - *Brand kit:* logo + colours
  - *Hours:* weekly hours plus **date overrides** (holidays) and timezone
  - *Domain:* custom-domain table (domain · status · next steps for DNS · actions) plus aliases
  - *Tax:* tax rates
  - *Legal:* **rich-text editors** where the studio writes its own terms and privacy policy (with a character counter). Customers accept these, which is why the Customers table has a terms column
- **Notifications** (tabs **Customer · Member**): a table of event · when it fires · email/SMS toggle · edit-template menu. Customer events: order created / accepted / cancelled; appointment scheduled / rescheduled / cancelled; reminders 24 h and 1 h before; invoice due / overdue / sent; listing delivered; revision complete; portal invitation; portal access link.
- **Teams & security:** a members table (member · email · role (owner / admin / …) · status · joined · updated) with search and invite.
- **Referrals:** send invites, copy invite link, earnings, referral status and a top-10 leaderboard.
- **Storage:** an overview of space used by photos, videos and uploads.
- **Import data:** bring customers and listings over from another platform.

### 3.17 New Listing
- Opened from the sidebar, the listings toolbar or a keyboard shortcut. The page did not render during this session, so this part is not documented. From the rest of the app, a listing needs an address (with autocomplete), a customer and members, and optionally an order with products.

---

## 4. Core data model (inferred)

```
Studio (business, brand, domain, legal, tax, hours)
 ├─ Member (role, availability, home base, service areas)
 ├─ Customer (agent) ── Team (brokerage)
 ├─ Product: Service | Package(=services) | Add-on | Travel-fee rule | Custom fee | Coupon
 ├─ Order ── line items (product + size tier) ── Appointment(s) (time, duration, member)
 │            └─ intake answers, internal notes, status (requested → accepted → completed / cancelled)
 ├─ Listing (property address + details) ── Photos / Videos / Tours / Floor plans / Designs / Property site
 │            └─ status: pending delivery → delivered
 ├─ Invoice (number, amount, due date, status: draft → sent → paid / overdue) ── payments, tips, discounts
 ├─ Campaign (email to customers, templates, merge tags)
 ├─ Lead (from the public website)
 └─ Automation settings (AI edit / QC / categorisation), Notifications, Integrations
```

## 5. End-to-end flow
1. The agent opens the studio's **booking form** (standalone link or embed) → enters the address and property size → sees size-matched packages → adds add-ons, a coupon and a tip → answers intake questions → picks a slot (or skips) → pays in full, a deposit, or nothing (per settings).
2. The order arrives → auto- or manual-approved → the appointment is assigned (manually or automatically by area, availability and drive time) → email/SMS notifications go out.
3. On shoot day: calendar/map view, drive-time buffers, mileage logged automatically.
4. The photographer uploads RAW files → AI editing → AI quality check → AI room grouping.
5. The studio marks the listing **Delivered** → the customer gets a branded gallery link (downloads locked or watermarked until paid) → can request revisions, buy upsells (marketing designs, property site, video) and reschedule.
6. The invoice is paid by card → accounting sync → **Reports** cover output, customer health, money, demand, product mix, team load and mileage.
7. Growth: public website with an SEO score, email campaigns, referrals, integrations.

---

## 6. Portfolio build brief — make it ORIGINAL

Reuse the *concept and features* only. Do **not** reuse their name, logo, colours, imagery, wording, template names or screen layouts.

- **Own brand:** a new product name and logo; a clearly different palette and fonts.
- **Own layout decisions:**
  - Add a real **home dashboard** (theirs has none): today's shoots, money due, deliveries pending, a revenue trend
  - Try a different navigation pattern (e.g. icon rail + contextual sub-nav) and a card/grid view for listings alongside the table
- **Own copy:** write every label, helper text and empty state fresh.
- **Demo data:** fictional addresses, customers and prices only.
- **Suggested scope for a static prototype:**
  1. App shell + home dashboard
  2. Listings table + listing detail (Info, Media, Tours, Plans, Marketing, Order)
  3. Calendar (week view + unscheduled queue)
  4. Orders + order detail
  5. Invoices + invoice detail
  6. Customers + teams
  7. Reports (2–3 tabs with charts)
  8. Products (packages/services/add-ons, tiered travel fee, coupons)
  9. Public booking wizard with live price
  10. Client gallery (login → gallery → download gated by payment)
  11. Settings (business, notifications, team)
- **Stack idea:** Vite + React + Tailwind, or plain HTML + Alpine.js; Chart.js for reports, FullCalendar for the schedule, Leaflet for maps.
