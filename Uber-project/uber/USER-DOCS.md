# PrestigeVTC — User Documentation

**Version 1.0 · April 2026**

---

## Contents

- [Part 1 — Customers](#part-1--customers)
  - [Getting Started](#getting-started)
  - [Booking a Ride](#booking-a-ride)
  - [Your Account Dashboard](#your-account-dashboard)
  - [Loyalty Program](#loyalty-program)
- [Part 2 — Drivers (Chauffeurs)](#part-2--drivers-chauffeurs)
  - [Driver Dashboard Overview](#driver-dashboard-overview)
  - [Managing Ride Requests](#managing-ride-requests)
  - [Going Online & Offline](#going-online--offline)
- [Part 3 — Administrators](#part-3--administrators)
  - [Operations Overview](#operations-overview)
  - [Managing Bookings](#managing-bookings)
  - [Configuring Pricing Rules](#configuring-pricing-rules)
  - [Using the Pricing Simulator](#using-the-pricing-simulator)
- [Navigation Reference](#navigation-reference)

---

# Part 1 — Customers

## Getting Started

Open `homepage.html` in your browser. This is the PrestigeVTC public homepage. No account is required to make a booking — simply start the checkout process and provide your details during the flow.

To access your existing account, click **Sign In** in the top-right of the navigation bar. This takes you directly to your Client Dashboard.

---

## Booking a Ride

Booking a ride takes three steps. You can navigate forward and backward between steps without losing your data.

### Step 1 — Your Details (`checkout-details.html`)

You arrive here by clicking **Book Now** on the homepage.

Fill in:

| Field | Required | Notes |
|-------|----------|-------|
| First Name | Yes | |
| Last Name | Yes | |
| Email Address | Yes | Confirmation will be sent here |
| Phone Number | Yes | Chauffeur will use this to contact you |
| Pickup Address | Yes | Be as specific as possible (terminal, gate, floor) |
| Destination | Yes | |
| Special Requests | No | Child seat, extra luggage, silent ride, etc. |

Click **Next** to proceed to payment. Use **Back** to return to the homepage.

---

### Step 2 — Payment (`checkout-payment.html`)

The right-hand sidebar shows your full order summary — route, date, service class, and total fare. Review this before entering card details.

Fill in:

| Field | Required |
|-------|----------|
| Card Number (16 digits) | Yes |
| Expiry Date (MM/YY) | Yes |
| CVV (3–4 digits) | Yes |
| Cardholder Name | Yes |

Accepted cards: Visa, Mastercard, American Express.

Click **Pay Now** to confirm. Your card will be charged the exact amount shown in the summary panel.

> Note: In the prototype, no real payment is processed. Clicking Pay Now always advances to the confirmation screen.

---

### Step 3 — Confirmation (`confirmation.html`)

Your booking is confirmed. This screen shows:

- **Booking Reference** — save or screenshot this number
- **Assigned Chauffeur** — name and vehicle details
- **Pickup Time** — confirmed date and time
- **Loyalty Points Earned** — added to your account automatically

From here you can:
- Click **Book Again** to start a new booking from the homepage
- Click **View Dashboard** to manage your account

---

## Your Account Dashboard (`client-dashboard.html`)

Your dashboard is divided into three areas:

### Loyalty Card (left, large panel)

Shows your current loyalty tier (Standard → Silver → Gold → **Platinum**), your exact points balance, and a progress bar showing how many points you need to reach the next tier.

**Julian Vance** example: 12,450 points, Platinum tier, 78% progress toward the next milestone.

### Promo Code (right, small panel)

Your active promotional code is shown here. Click the copy icon to copy it to clipboard and apply it at checkout.

Current example: `SUMMER24`

### Booking History (table below)

All your past and upcoming bookings in one place.

| Column | Description |
|--------|-------------|
| Date | Date and time of the ride |
| Route | Origin → Destination |
| Status | Upcoming / Completed / Cancelled |
| Fare | Amount charged or estimated |

**Status colours:**
- Blue pill → Upcoming (scheduled)
- Green pill → Completed (trip took place)
- Grey/Muted pill → Cancelled

Click **Book New Ride** in the sidebar to start a new booking.

---

## Loyalty Program

| Tier | Points Required | Benefits |
|------|----------------|---------|
| Standard | 0+ | 1 point per €1 spent |
| Silver | 2,500 | 1.2x multiplier, priority support |
| Gold | 7,500 | 1.5x multiplier, complimentary water |
| Platinum | 12,000 | 2x multiplier, dedicated account manager, lounge access |

Points are automatically credited after each completed ride. Points from cancelled rides are not credited.

---

# Part 2 — Drivers (Chauffeurs)

## Driver Dashboard Overview (`driver-dashboard.html`)

The driver dashboard is your daily command centre. It opens with four KPI cards at the top:

| Card | What it shows |
|------|--------------|
| Rides Today | Total completed rides for the current day |
| Revenue Today | Earnings for the current day (EUR) |
| Monthly Revenue | Cumulative earnings this calendar month |
| Your Rating | Average passenger rating (out of 5.00) |

Below the KPIs, you will see your **live request queue** — bookings that have been assigned to you for acceptance.

The sidebar on the left shows:
- **Dashboard** (current page)
- **Incoming Requests** → takes you to the dedicated request queue view

---

## Managing Ride Requests

### From the Driver Dashboard

Each booking card in the queue shows:

- Passenger name and rating
- Pickup → destination route
- Fare amount (EUR)
- Service type badge (Night Fare / Corporate / Standard)

Click **Accept** to accept the ride and confirm it in the system.  
Click **Decline** to remove the request from your queue. It will be offered to another driver.

### Incoming Requests View (`driver-incoming.html`)

If multiple new requests arrive simultaneously, switch to **Incoming Requests** via the sidebar. This view is purpose-built for a high-volume queue. In the example data:

- **Julianne Deville** — CDG Airport → Hôtel de Crillon, €145, awaiting response
- **Marcus Blackwood** — Avenue Montaigne → Orly Airport, €85.50

Each card has a prominent **Accept** (blue) and **Decline** (outlined) button.

The right panel shows a **Fleet Insight** card with your weekly completion goal and progress bar.

> Tip: The "3 LIVE REQUESTS" badge in the dashboard header is a quick link to this page.

---

## Going Online & Offline

The **ONLINE toggle** is displayed prominently on your Driver Dashboard. Click it to:

- **ONLINE** (toggle active, green) — you are visible to passengers and will receive new booking requests
- **OFFLINE** (toggle off) — you are hidden from the dispatch system; no new requests will arrive

You will not be penalised for going offline. Set your status before ending your shift to avoid declined requests.

---

# Part 3 — Administrators

## Operations Overview (`admin-operations.html`)

This is the admin entry point. Open it from the sidebar (Overview link) or directly.

### KPI Cards

| Card | Current Value | Meaning |
|------|--------------|---------|
| Total Fleet | 142 | Registered vehicles |
| Active Drivers | 89 | Drivers currently Online |
| Pending Bookings | 34 | Upcoming bookings not yet assigned a driver |
| Today's Revenue | €14,820 | All completed fares for today |

### Fleet Map

A satellite view of Paris showing active vehicle positions. Vehicle type indicators in the map legend identify standard vs. premium vehicles.

### Revenue Bar Chart

A 7-day bar chart (Monday through Sunday) showing daily fare totals. Bars are rendered proportionally. Hover over a bar for the exact value.

### System Activity Log

A scrollable feed of system events. Each entry shows a timestamp, event description, and severity:

| Border Colour | Severity |
|--------------|---------|
| Blue | Informational |
| Yellow | Warning |
| Red | Error / Alert |
| Green | Successful action |

---

## Managing Bookings (`admin-bookings.html`)

### Filtering the Table

Use the filter bar at the top of the bookings table:

1. **Date Range** — click the start/end date inputs to narrow the time window
2. **Status Pills** — click any pill to filter by status:
   - All (default)
   - Upcoming
   - Completed
   - Cancelled

The table updates immediately to show matching bookings only.

### Reading the Table

| Column | Description |
|--------|-------------|
| Booking ID | Unique reference (e.g. PV-88294) |
| Passenger | Full name |
| Route | Origin → Destination |
| Date / Time | Scheduled pickup |
| Status | Current booking status (colour-coded pill) |
| Fare | Quoted amount in EUR |
| Actions | View button (opens booking detail) |

### Viewing a Booking

Click **View** on any Upcoming booking to open the full booking confirmation screen in the customer view (`confirmation.html`). This is the same confirmation screen the passenger sees, allowing you to verify exact details.

### Pagination

Results are paginated. The footer shows the current page and total pages. Use **Previous** / **Next** to navigate.

---

## Configuring Pricing Rules (`admin-pricing.html`)

> Warning: Changes saved here affect all future fare calculations immediately. Always use the Pricing Simulator (below) to validate your changes before saving.

### Base Pricing

| Field | Default | Description |
|-------|---------|-------------|
| Base Fare | €12.00 | Fixed charge applied to every booking |
| Price per Kilometer | €1.80 | Distance rate, multiplied by total trip km |
| Minimum Trip Fare | €25.00 | Lowest possible fare regardless of distance |

Edit any value, then click **Update Base Rates** to stage the change. Click **Save Changes** in the page header to commit all staged changes.

### Surcharge Adjustments

| Field | Default | Applied when |
|-------|---------|-------------|
| Night Premium | 15% | Bookings between 22:00 and 06:00 |
| Weekend Premium | 10% | Friday 22:00 through Sunday 23:59 |
| Wait Time Rate | €4.00/unit | Per 5-minute increment beyond agreed pickup time |

### Active Rule Sets

Three global toggles control whether each surcharge category is active:

| Toggle | Default | Effect |
|--------|---------|--------|
| Night Rule | ON | Enables/disables all night surcharges |
| Weekend Uplift | ON | Enables/disables all weekend surcharges |
| Holiday Surge (+20%) | OFF | Regional holiday multiplier (off by default) |

Click the toggle to switch. The visual state (blue = ON, grey = OFF) updates immediately but must still be saved via **Save Changes**.

---

## Using the Pricing Simulator

The **Pricing Simulator** is the sticky panel on the right side of the Pricing Rules page. Use it to preview how any rule change will affect a sample fare before saving.

### Current Sample Scenario

| Input | Value |
|-------|-------|
| Distance | 15.0 km |
| Time of Day | 23:30 (Night Rate applies) |
| Waiting Time | 10 mins (2 units) |

### Fare Breakdown

```
Base Fare                         €12.00
Distance   (15 km × €1.80)       €27.00
Wait Time  (2 units × €4.00)      €8.00
Night Surcharge  (15% of €47)    + €7.05
─────────────────────────────────────────
Estimated Total                  €54.05
```

Click **Recalculate Preview** after editing any base pricing or surcharge inputs to see the updated total without saving.

### Recent Changes Log

Below the simulator (in the dark card) is a timestamped audit log of the last three rule changes, showing:

- Administrator initials
- Change description
- Time elapsed (e.g. "2h ago", "1d ago")

This provides a quick accountability trail without opening a full audit system.

---

# Navigation Reference

## Floating Page Navigator

Every page in the prototype has a fixed pill button in the **bottom-right corner** labelled **All Pages**. Click it to open a dropdown listing all 11 pages, organised by role.

| Badge | Meaning |
|-------|---------|
| Blue (Customer) | Customer-facing page |
| Green (Driver) | Driver portal page |
| Yellow (Admin) | Admin panel page |
| Dark (Active) | The page you are currently on |

## Page Flow Quick Reference

```
CUSTOMER FLOW
Homepage → Checkout: Details → Checkout: Payment → Confirmation → Client Dashboard
                                                        ↓
                                              (Book Again → Homepage)

DRIVER FLOW
Driver Dashboard ⟷ Driver: Incoming Requests

ADMIN FLOW
Admin: Operations ⟷ Admin: Bookings ⟷ Admin: Pricing
```

## All Pages (Direct Links)

| Page | File | Role |
|------|------|------|
| Design Hub | index.html | — |
| Homepage | homepage.html | Customer |
| Checkout: Details | checkout-details.html | Customer |
| Checkout: Payment | checkout-payment.html | Customer |
| Booking Confirmation | confirmation.html | Customer |
| Client Dashboard | client-dashboard.html | Customer |
| Driver: Incoming Requests | driver-incoming.html | Driver |
| Driver Dashboard | driver-dashboard.html | Driver |
| Admin: Operations | admin-operations.html | Admin |
| Admin: Bookings | admin-bookings.html | Admin |
| Admin: Pricing | admin-pricing.html | Admin |

---

*PrestigeVTC · Exceptionalism as Standard · © 2026*
