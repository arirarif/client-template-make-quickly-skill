# Software Requirements Specification
## PrestigeVTC — Private Chauffeur Platform

| Field | Value |
|-------|-------|
| Document ID | SRS-PVTC-001 |
| Version | 1.0 |
| Date | April 12, 2026 |
| Status | Final |
| Author | Engineering Team |

---

## Table of Contents

1. [Introduction](#1-introduction)
2. [Overall Description](#2-overall-description)
3. [Stakeholders & User Roles](#3-stakeholders--user-roles)
4. [System Features & Functional Requirements](#4-system-features--functional-requirements)
   - 4.1 Customer Journey
   - 4.2 Driver Portal
   - 4.3 Admin Panel
5. [Non-Functional Requirements](#5-non-functional-requirements)
6. [Design System](#6-design-system)
7. [Page Inventory](#7-page-inventory)
8. [Data Models](#8-data-models)
9. [Constraints & Assumptions](#9-constraints--assumptions)

---

## 1. Introduction

### 1.1 Purpose

This document specifies the functional and non-functional requirements for **PrestigeVTC**, a web-based private chauffeur booking platform. It is intended for designers, frontend developers, backend engineers, and QA teams building or maintaining the product.

### 1.2 Scope

PrestigeVTC provides three distinct role-based interfaces:

- **Customer Portal** — discover, book, track, and manage rides
- **Driver Portal** — receive and manage live booking requests
- **Admin Panel** — monitor operations, manage bookings, and control pricing

The prototype scope covers 11 UI screens extracted from a single `code.md` source and delivered as standalone HTML pages with full cross-navigation.

### 1.3 Definitions

| Term | Definition |
|------|------------|
| VTC | Voiture de Transport avec Chauffeur (French: private hire vehicle) |
| Chauffeur | A professional driver employed by PrestigeVTC |
| Booking | A confirmed or pending ride reservation |
| Surge | A dynamic price multiplier applied under specific conditions (night, weekend, holiday) |
| Loyalty Points | Reward points earned per ride, redeemable for discounts |
| Simulator | Admin-side pricing preview tool showing fare breakdowns for test scenarios |

### 1.4 References

- UI Prototype: `Uber-project/uber/` (11 HTML files)
- Design System: Tailwind CSS with custom token configuration
- Fonts: Manrope (headlines), Inter (body/label) via Google Fonts
- Icons: Google Material Symbols Outlined

---

## 2. Overall Description

### 2.1 Product Perspective

PrestigeVTC is a standalone SPA-style prototype built with Tailwind CSS and semantic HTML. It targets a premium clientele seeking airport transfers and corporate rides in Paris and surrounding regions. The system replaces manual phone/email booking with a fully digital self-service experience.

### 2.2 Product Functions (Summary)

```
Customer                Driver                  Admin
├── View homepage       ├── View dashboard       ├── View fleet ops map
├── Book ride (3-step)  ├── Accept/decline reqs  ├── Manage all bookings
├── Pay online          ├── View earnings        ├── Configure pricing
├── View confirmation   └── Toggle availability  ├── Monitor system logs
└── Manage account                               └── View revenue charts
```

### 2.3 User Classes

| Class | Access Level | Key Concern |
|-------|-------------|-------------|
| Passenger | Customer portal only | Easy booking, status visibility |
| Chauffeur | Driver portal only | Request queue, earnings |
| Admin | Full admin panel | Operations, data, pricing |
| Superadmin | All panels | System-wide configuration |

### 2.4 Operating Environment

- Modern browsers (Chrome 120+, Firefox 120+, Safari 17+, Edge 120+)
- Responsive design: desktop primary, tablet secondary, mobile tertiary
- Network: standard broadband; CDN-delivered CSS/JS assets
- No backend required for prototype phase (static HTML)

---

## 3. Stakeholders & User Roles

### 3.1 Customer (Passenger)

**Profile:** Business traveler or private individual requiring premium point-to-point transportation in the Paris area.

**Goals:**
- Book a ride in under 3 minutes
- Know the fare before confirming
- Receive real-time booking confirmation
- Track loyalty points and tier status

**Acceptance Criteria:** Booking flow completable without assistance. Confirmation delivered without page refresh.

### 3.2 Chauffeur (Driver)

**Profile:** Professional licensed driver registered with PrestigeVTC, operating a luxury or standard-class vehicle.

**Goals:**
- See incoming booking requests as they arrive
- Accept or decline requests within a time window
- Monitor daily earnings and trip count
- Toggle availability (ONLINE/OFFLINE) easily

**Acceptance Criteria:** Request queue updates in real-time. Accept/decline responsive within 200ms.

### 3.3 Administrator

**Profile:** PrestigeVTC operations manager or back-office staff with elevated system access.

**Goals:**
- Monitor all active bookings across the fleet
- Adjust fare pricing rules without developer involvement
- Identify operational issues via system activity logs
- Pull revenue metrics by day/week/month

**Acceptance Criteria:** All KPI cards render on dashboard load. Pricing changes apply without page reload.

---

## 4. System Features & Functional Requirements

### 4.1 Customer Journey

#### FR-C-01: Homepage (homepage.html)

| ID | Requirement |
|----|-------------|
| FR-C-01.1 | Display hero section with headline, subtitle, and a primary booking CTA button |
| FR-C-01.2 | Provide a booking preview widget visible above the fold |
| FR-C-01.3 | Display three service-tier cards (Economy, Business, First Class) with pricing indication |
| FR-C-01.4 | Show a coverage/zone section indicating Paris city + airport routes |
| FR-C-01.5 | Render a social proof section with ≥3 customer testimonials |
| FR-C-01.6 | Header must include logo (links to homepage) and Sign In (links to `client-dashboard.html`) |
| FR-C-01.7 | CTA "Book Now" must navigate to `checkout-details.html` |

#### FR-C-02: Checkout — Details (checkout-details.html)

| ID | Requirement |
|----|-------------|
| FR-C-02.1 | Display a 3-step progress indicator showing current step (Step 1) |
| FR-C-02.2 | Collect: First Name, Last Name, Email, Phone Number |
| FR-C-02.3 | Collect: Pickup address, Destination address |
| FR-C-02.4 | Provide optional Special Requests text area |
| FR-C-02.5 | "Back" button navigates to `homepage.html` |
| FR-C-02.6 | "Next" / Submit button navigates to `checkout-payment.html` |
| FR-C-02.7 | All required fields must show validation state |

#### FR-C-03: Checkout — Payment (checkout-payment.html)

| ID | Requirement |
|----|-------------|
| FR-C-03.1 | Display 3-step progress indicator at Step 2 |
| FR-C-03.2 | Render a dark sidebar showing order summary (route, date, service class, fare) |
| FR-C-03.3 | Accept: Card Number, Expiry (MM/YY), CVV, Cardholder Name |
| FR-C-03.4 | Show accepted card type icons (Visa, Mastercard, Amex) |
| FR-C-03.5 | "Back" button navigates to `checkout-details.html` |
| FR-C-03.6 | "Pay Now" button navigates to `confirmation.html` |
| FR-C-03.7 | Display total fare prominently before payment submit |

#### FR-C-04: Booking Confirmation (confirmation.html)

| ID | Requirement |
|----|-------------|
| FR-C-04.1 | Display a success confirmation with booking reference number |
| FR-C-04.2 | Show assigned chauffeur name and vehicle details |
| FR-C-04.3 | Display loyalty points earned for this booking |
| FR-C-04.4 | "Book Again" button navigates to `homepage.html` |
| FR-C-04.5 | "View Dashboard" button navigates to `client-dashboard.html` |

#### FR-C-05: Client Dashboard (client-dashboard.html)

| ID | Requirement |
|----|-------------|
| FR-C-05.1 | Fixed left sidebar (w-64) with passenger name, tier badge, and navigation links |
| FR-C-05.2 | Loyalty card (bento col-span-8): display point balance, tier (Platinum), progress bar to next tier |
| FR-C-05.3 | Promo card (bento col-span-4): display active promo code with copy-to-clipboard option |
| FR-C-05.4 | Booking history table with columns: Date, Route, Status, Fare |
| FR-C-05.5 | Status pills: Upcoming (blue), Completed (green), Cancelled (red/muted) |
| FR-C-05.6 | "Book New Ride" button navigates to `checkout-details.html` |
| FR-C-05.7 | Logout navigates to `homepage.html` |

---

### 4.2 Driver Portal

#### FR-D-01: Driver Dashboard — Incoming Requests (driver-incoming.html)

| ID | Requirement |
|----|-------------|
| FR-D-01.1 | Display dark-themed sidebar with PrestigeVTC / Fleet Portal branding |
| FR-D-01.2 | Render 4 KPI metric cards: Rides Today, Revenue Today, Monthly Revenue, Rating |
| FR-D-01.3 | Show ≥2 incoming booking request cards in a live queue |
| FR-D-01.4 | Each request card must show: Passenger Name, Route (origin → destination), Fare, Accept + Decline buttons |
| FR-D-01.5 | Display a Paris map section showing fleet vehicle positions |
| FR-D-01.6 | Render a Fleet Insight card with weekly goal progress bar |

#### FR-D-02: Driver Dashboard — Main (driver-dashboard.html)

| ID | Requirement |
|----|-------------|
| FR-D-02.1 | Same sidebar with Dashboard marked active; Incoming Requests links to `driver-incoming.html` |
| FR-D-02.2 | Display ONLINE / OFFLINE availability toggle prominently |
| FR-D-02.3 | Show a "LIVE REQUESTS" badge with count, linking to `driver-incoming.html` |
| FR-D-02.4 | Render ≥3 booking request cards (Alexander Sterling, Marie Lefebvre, David Henderson) |
| FR-D-02.5 | Each card shows: Night Fare / Corporate / Standard type badge, route, fare |
| FR-D-02.6 | KPI metric cards for today's performance visible above request queue |

---

### 4.3 Admin Panel

#### FR-A-01: Admin Operations Overview (admin-operations.html)

| ID | Requirement |
|----|-------------|
| FR-A-01.1 | Light sidebar with PrestigeVTC / Admin Panel branding |
| FR-A-01.2 | 4 headline KPI cards: Total Fleet (142), Active Drivers (89), Pending Bookings (34), Today Revenue (€14,820) |
| FR-A-01.3 | Fleet map section (Paris satellite view) with vehicle position indicators and a legend |
| FR-A-01.4 | System Activity log showing ≥4 timestamped event entries with color-coded severity border |
| FR-A-01.5 | Revenue Performance bar chart (Monday–Sunday) rendered in CSS |
| FR-A-01.6 | Sidebar links: All Bookings → `admin-bookings.html`, Pricing Rules → `admin-pricing.html` |

#### FR-A-02: Admin Bookings Management (admin-bookings.html)

| ID | Requirement |
|----|-------------|
| FR-A-02.1 | Dark sidebar (#0A1128) mirroring admin-operations sidebar nav |
| FR-A-02.2 | Filter bar: date range inputs, status filter pills (All / Upcoming / Completed / Cancelled) |
| FR-A-02.3 | Bookings data table with columns: Booking ID, Passenger, Route, Date/Time, Status, Fare, Actions |
| FR-A-02.4 | ≥4 booking rows with mixed statuses |
| FR-A-02.5 | "View" action on an Upcoming booking links to `confirmation.html` |
| FR-A-02.6 | Pagination footer (page indicator + prev/next controls) |

#### FR-A-03: Admin Pricing Rules (admin-pricing.html)

| ID | Requirement |
|----|-------------|
| FR-A-03.1 | 4 quick-stat cards: Avg Fare, Top Surcharge, Active Fleet, Last Sync |
| FR-A-03.2 | Base Pricing form: editable inputs for Base Fare (€12.00), Per Km (€1.80), Minimum Fare (€25.00) |
| FR-A-03.3 | Surcharge form: editable inputs for Night Premium (15%), Weekend Premium (10%), Wait Time Rate (€4.00/unit) |
| FR-A-03.4 | Active Rule Sets toggles: Night Rule (ON), Weekend Uplift (ON), Holiday Surge (OFF) |
| FR-A-03.5 | Pricing Simulator sticky panel: scenario inputs + live breakdown showing Total €54.05 for sample |
| FR-A-03.6 | Pricing analytics line-chart (SVG, 4-week trend) |
| FR-A-03.7 | Recent Changes audit log showing ≥3 entries with author initials and timestamp |
| FR-A-03.8 | Page header: "Save Changes" (blue gradient) and "Discard Changes" (outline) buttons |

---

## 5. Non-Functional Requirements

### 5.1 Performance

| ID | Requirement |
|----|-------------|
| NFR-P-01 | Every page must render visually complete within 2 seconds on a standard broadband connection |
| NFR-P-02 | No page shall load more than 3 external CDN dependencies |
| NFR-P-03 | All CSS transitions must complete within 300ms |

### 5.2 Usability

| ID | Requirement |
|----|-------------|
| NFR-U-01 | Booking checkout flow (3 steps) completable in under 3 minutes by a first-time user |
| NFR-U-02 | All interactive elements must have visible hover/focus states |
| NFR-U-03 | Floating page navigator must be present on every page for prototype navigation |
| NFR-U-04 | Role-colored badge system must visually distinguish Customer / Driver / Admin pages at a glance |

### 5.3 Accessibility

| ID | Requirement |
|----|-------------|
| NFR-A-01 | All images must carry descriptive `alt` attributes |
| NFR-A-02 | Color contrast ratio ≥ 4.5:1 for all body text against its background |
| NFR-A-03 | Form fields must have associated `<label>` elements |
| NFR-A-04 | Interactive cards must be keyboard-focusable |

### 5.4 Maintainability

| ID | Requirement |
|----|-------------|
| NFR-M-01 | Design tokens (colors, radii, fonts) must be defined in Tailwind config, not hardcoded inline |
| NFR-M-02 | Each page must be a self-contained HTML file with no shared external JS dependencies beyond CDN |
| NFR-M-03 | Navigator pill markup must be identical across all pages |

### 5.5 Security (Prototype Scope)

| ID | Requirement |
|----|-------------|
| NFR-S-01 | No real payment card data is processed; all inputs are non-functional in prototype |
| NFR-S-02 | No `localStorage` or `sessionStorage` is used for sensitive data |
| NFR-S-03 | All external links use `rel="noopener noreferrer"` |

---

## 6. Design System

### 6.1 Color Tokens

| Token | Hex | Usage |
|-------|-----|-------|
| `primary` | `#000000` | Headlines, primary text |
| `secondary` | `#1d4ed8` | CTAs, active states, links |
| `primary-container` | `#141a32` | Dark cards, sidebar backgrounds |
| `surface` | `#f8f9fa` | Page backgrounds |
| `surface-container-lowest` | `#ffffff` | Card backgrounds |
| `outline-variant` | `#c6c6ce` | Borders, dividers |
| `on-surface-variant` | `#46464d` | Secondary text, labels |
| `on-primary-container` | `#7c839f` | Dark card secondary text |

### 6.2 Signature Gradient

```css
background: linear-gradient(135deg, #1d4ed8 0%, #4069f2 100%);
```

Used on: primary CTA buttons, hero sections, card accent headers.

### 6.3 Typography

| Role | Family | Weights |
|------|--------|---------|
| Headlines (`font-headline`) | Manrope | 200, 400, 600, 700, 800 |
| Body/Label (`font-body`, `font-label`) | Inter | 300, 400, 500, 600 |

### 6.4 Badge System

| Badge Class | Background | Text | Role |
|-------------|-----------|------|------|
| `.badge-customer` | `#dce1ff` | `#0039b5` | Customer-facing pages |
| `.badge-driver` | `#d1fae5` | `#065f46` | Driver portal pages |
| `.badge-admin` | `#fef3c7` | `#92400e` | Admin panel pages |
| `.badge-active` | `#141a32` | `#ffffff` | Current page indicator |

### 6.5 Spacing

4px base grid. All spacing values are multiples of 4 (4, 8, 12, 16, 20, 24, 32, 48, 64px).

---

## 7. Page Inventory

| # | File | Title | Role | Primary Action |
|---|------|-------|------|---------------|
| 1 | `index.html` | Design Hub | — | Browse all pages |
| 2 | `homepage.html` | PrestigeVTC Homepage | Customer | Book a ride |
| 3 | `checkout-details.html` | Checkout: Passenger Details | Customer | Fill details → payment |
| 4 | `checkout-payment.html` | Checkout: Payment | Customer | Pay → confirmation |
| 5 | `confirmation.html` | Booking Confirmed | Customer | View dashboard |
| 6 | `client-dashboard.html` | Client Dashboard | Customer | Manage account |
| 7 | `driver-incoming.html` | Incoming Requests | Driver | Accept/decline rides |
| 8 | `driver-dashboard.html` | Driver Dashboard | Driver | Monitor performance |
| 9 | `admin-operations.html` | Operations Overview | Admin | Monitor fleet |
| 10 | `admin-bookings.html` | Bookings Management | Admin | Filter & view bookings |
| 11 | `admin-pricing.html` | Pricing Rules | Admin | Configure fares |

---

## 8. Data Models

### 8.1 Booking

```
Booking {
  id:           string        // e.g. "PV-88294"
  passengerId:  string
  driverId:     string | null
  origin:       string        // e.g. "Charles de Gaulle Airport"
  destination:  string        // e.g. "Hôtel de Crillon"
  dateTime:     ISO8601
  serviceClass: "Economy" | "Business" | "First"
  status:       "Upcoming" | "Completed" | "Cancelled"
  fare:         number        // EUR
  loyaltyEarned: number       // points
}
```

### 8.2 Passenger

```
Passenger {
  id:           string
  firstName:    string
  lastName:     string
  email:        string
  phone:        string
  loyaltyPoints: number
  tier:         "Standard" | "Silver" | "Gold" | "Platinum"
}
```

### 8.3 Driver (Chauffeur)

```
Driver {
  id:         string
  name:       string
  rating:     number   // 0.00 – 5.00
  status:     "Online" | "Offline" | "In-Ride"
  todayRides: number
  todayRevenue: number // EUR
}
```

### 8.4 Pricing Rule

```
PricingRule {
  baseFare:       number   // EUR, e.g. 12.00
  perKmRate:      number   // EUR/km, e.g. 1.80
  minimumFare:    number   // EUR, e.g. 25.00
  nightSurcharge: number   // %, e.g. 15
  weekendSurcharge: number // %, e.g. 10
  waitRatePerUnit: number  // EUR, e.g. 4.00
  rules: {
    nightRuleActive:     boolean
    weekendUpliftActive: boolean
    holidaySurgeActive:  boolean
  }
}
```

---

## 9. Constraints & Assumptions

| # | Type | Description |
|---|------|-------------|
| C-01 | Technical | Prototype is pure HTML/CSS; no backend or database |
| C-02 | Technical | All dynamic content (fare calculation, real-time requests) is simulated with static data |
| C-03 | Technical | Payment processing is non-functional; no real transactions occur |
| C-04 | Scope | Map sections use static image placeholders (Google Maps-style satellite images) |
| C-05 | Scope | Multi-language support (English/French) is out of scope for v1 |
| C-06 | Assumption | Booking flow is linear; edge cases (failed payment, duplicate booking) are deferred to v2 |
| C-07 | Assumption | Admin users access the panel via a separate authenticated URL not covered in this prototype |
| C-08 | Legal | VTC regulations (LOTI law, France) apply to the production system; compliance is out of prototype scope |
