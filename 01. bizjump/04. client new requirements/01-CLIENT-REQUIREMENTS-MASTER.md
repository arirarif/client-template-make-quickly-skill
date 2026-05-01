# 🚀 BIZJUMP — CLIENT DASHBOARD REQUIREMENTS

> **System Name:** BizJump **Business Command Center**
> **Source Files Merged:**
> - `docs.md` (full text spec — 14 sections)
> - `Wire Frame of Customer Portal.docx` (visual layout + 21 design reference images)
> **Headline Design Reference:** Fiverr — *"Do figma wireframe UI/UX design for SaaS, AI dashboard, CRM"* by **Varun Dade**

---

## 📑 TABLE OF CONTENTS

| # | Section | Purpose |
|---|---|---|
| 1 | [Dashboard Home](#1-dashboard-home-main-screen) | Welcome, status, quick actions |
| 2 | [Document Hub](#2-document-hub) | Storage for all business docs |
| 3 | [Compliance Center](#3-compliance-center) | Deadlines, filings, reminders |
| 4 | [Service Management](#4-service-management-panel) | Active services + add-ons |
| 5 | [Action Center](#5-action-center--key-differentiator) | Step-by-step business plan |
| 6 | [Communication Hub](#6-communication-hub) | Messages with BizJump team |
| 7 | [Business Profile](#7-business-profile) | Edit business details |
| 8 | [Sidebar Menu](#8-sidebar-menu) | Global navigation |
| 9 | [Notifications System](#9-notifications-system) | Alerts and updates |
| 10 | [Empty States](#10-empty-states-ux-copy) | First-time UX copy |
| 11 | [Top Bar](#11-top-bar-global) | Global header |
| 12 | [Support Access](#12-support-access) | Help button (visible everywhere) |
| 13 | [Core Positioning](#13-core-positioning--differentiation) | Brand voice in dashboard |
| 14 | [Implementation Mapping](#14-implementation-mapping) | Tech stack mapping |
| — | [Image Reference Index](#-image-reference-index) | All 21 reference mockups by section |

---

## 🌐 GLOBAL LAYOUT STRUCTURE

```
┌──────────────────────────────────────────────────────────────┐
│  [Logo]                          [🔔] [Support] [Account ▾]  │  ← Top Bar
├──────────┬───────────────────────────────────────────────────┤
│          │                                                   │
│ Sidebar  │                                                   │
│          │                Main Content Area                  │
│ • Dash   │              (Section 1 – 7)                      │
│ • Docs   │                                                   │
│ • Compli │                                                   │
│ • Servs  │                                                   │
│ • Action │                                                   │
│ • Msgs   │                                                   │
│ • Settgs │                                                   │
│ • Logout │                                                   │
│          │                                                   │
└──────────┴───────────────────────────────────────────────────┘
```

---

## 1. DASHBOARD HOME (MAIN SCREEN)

### 🎯 Header
> **Welcome back, [First Name]**
> *Subtext:* "Here's the current status of your business and what needs your attention."

### 🖼 Design References
- **`image1.jpeg`** — Fiverr "Varun Dade" SaaS dashboard collage (overall vibe & structure)
- **`image2.png`** — Dashboard with stat cards, donut chart, notifications panel, calendar (closest layout match)

### 📐 Layout Grid

```
┌─────────────────────────────────────────┬─────────────────────┐
│  LEFT COLUMN (70%)                      │  RIGHT COLUMN (30%) │
├─────────────────────────────────────────┼─────────────────────┤
│  📊 Business Status Card                │  ⚡ Quick Summary    │
│  • Business Name                        │  • Formation Prog%  │
│  • Entity Type (LLC / Corp)             │  • Next Deadline    │
│  • State                                │  • Active Services  │
│  • Filing Status (progress bar)         │                     │
│  • EIN Status                           │  🔔 Notifications   │
│                                         │  • Filing updates   │
│  ✅ Action Plan – Next Steps            │  • Reminder alerts  │
│  ☐ Apply for EIN                        │                     │
│  ☐ Download Documents                   │                     │
│  ☐ Open Bank Account                    │                     │
│  ☐ Set Up Compliance                    │                     │
│  [ View Full Action Plan ]              │                     │
└─────────────────────────────────────────┴─────────────────────┘
```

### 📋 Status Panel Fields

| Field | Value Source |
|---|---|
| Business Name | Auto |
| Entity Type | LLC / Corp / etc. |
| State | Auto |
| Filing Status | `Preparing Documents` → `Filed with State` → `Approved` |
| EIN Status | `Not Started` / `In Progress` / `Completed` |

**Progress Bar Label:** *"Your Business Formation Progress"*

### ✅ Quick Actions Checklist (Dynamic)
- Apply for EIN
- Download your formation documents
- Open a business bank account
- Set up your compliance reminders
- Add optional services

**Button:** `View Full Action Plan`

---

## 2. DOCUMENT HUB

### 📌 Title & Description
> **Your Business Documents**
> *"Access, download, and manage all your official business documents in one place."*

### 🖼 Design References
- **`image3.png`** — "My Documents" with file-type tiles + document list
- **`image4.png`** — Documents table with status badges + mobile responsive view
- **`image5.png`** — "Client Portal" sidebar layout with filter modal
- **`image6.png`** — Clean table with multi-filter chips (type, department, date)

### 📐 Layout

```
┌────────────────────────────────────────────────────────────────┐
│  YOUR BUSINESS DOCUMENTS                                       │
├────────────────┬──────┬────────────┬──────────┬────────────────┤
│ Document Name  │ Type │ Date       │ Status   │ Action         │
├────────────────┼──────┼────────────┼──────────┼────────────────┤
│ Articles of    │ PDF  │ 2026-04-12 │ ✅ Ready │ [ Download ]   │
│ Organization   │      │            │          │                │
│ EIN Confirm    │ PDF  │ 2026-04-15 │ ⏳ Pend. │ [ Download ]   │
│ Operating Agmt │ PDF  │ 2026-04-20 │ 🔄 Proc. │ [ Download ]   │
└────────────────┴──────┴────────────┴──────────┴────────────────┘

[ Upload New Document ]    [ Download All Files ]
```

### 🎨 Status Tags
- ✅ **Ready** — green
- ⏳ **Pending** — yellow
- 🔄 **Processing** — blue

### 🖱 UX Behavior
- **Click row** → preview document inline
- **Buttons:** `Upload New Document` · `Download All Files`

---

## 3. COMPLIANCE CENTER

### 📌 Title & Description
> **Stay Compliant**
> *"Keep up with state requirements and tax obligations—deadlines, filings, and reminders all in one place so you never miss a step."*

### 🖼 Design References
- **`image7.png`** — "Tax Compliance Dashboard" with calendar + upcoming deadlines (★ best match)
- **`image8.png`** — Yearly compliance heatmap (green/yellow/red columns by month)
- **`image9.png`** — Mobile "Tax Returns" with Pending / Processing / Completed sections

### 📐 Layout

```
┌────────────────────────────────────────────────────────────────┐
│  ⚠️  TOP SECTION: ALERTS                                       │
│  • Annual Report Due: [Date]            🟢 On Track            │
│  • State Filing Requirement: [Date]     🟡 Action Required     │
│  • Tax Reminder: [Date]                 🔴 Overdue             │
├────────────────────────────────────────────────────────────────┤
│  📅 CALENDAR VIEW (Monthly compliance timeline)                │
│  ┌─────────────────────────────────────────────────────────┐  │
│  │  Mon  Tue  Wed  Thu  Fri  Sat  Sun                      │  │
│  │   1    2    3    4    5    6    7                        │  │
│  │   8    9   10   11   12🔴 13   14                        │  │
│  │  15   16   17🟡 18   19   20   21                        │  │
│  └─────────────────────────────────────────────────────────┘  │
└────────────────────────────────────────────────────────────────┘

[ View Compliance Calendar ]    [ Add Compliance Service ]
```

### 🚦 Status Indicators

| Color | Meaning |
|---|---|
| 🟢 Green | On Track |
| 🟡 Yellow | Action Required |
| 🔴 Red | Overdue |

---

## 4. SERVICE MANAGEMENT PANEL

### 📌 Title & Description
> **Your Services**
> *"View and manage the services you've selected. Add new services anytime as your business grows."*

### 🖼 Design References
- **`image10.jpeg`** — "Nectar" dashboard with stat cards + suppliers/services table
- **`image11.jpeg`** — Subscription dashboard with renewals + history + frequently used
- **`image12.png`** — "Pricing Plans" cards (Individual / PRO / Team / Business) — for **Upgrade Package** flow

### 📐 Layout

```
┌────────────────────────────────────────────────────────────────┐
│  ⭐ ACTIVE SERVICES (Top)                                      │
│  ┌───────────────────┬──────────────────┬──────────────────┐  │
│  │ Formation Package │ Registered Agent │ EIN Filing       │  │
│  └───────────────────┴──────────────────┴──────────────────┘  │
├────────────────────────────────────────────────────────────────┤
│  ➕ AVAILABLE ADD-ONS (Cards)                                  │
│  ┌──────────────┬──────────────┬──────────────┬─────────────┐ │
│  │ Operating    │ Corporate    │ Bank Account │ Social      │ │
│  │ Agreement    │ Bylaws       │ Setup        │ Media Setup │ │
│  └──────────────┴──────────────┴──────────────┴─────────────┘ │
│  ┌──────────────┐                                              │
│  │ Google Biz   │                                              │
│  │ & Analytics  │                                              │
│  └──────────────┘                                              │
└────────────────────────────────────────────────────────────────┘

[ Add Services ]    [ Upgrade Package ]
```

---

## 5. ACTION CENTER ⭐ (KEY DIFFERENTIATOR)

### 📌 Title & Description
> **Your Business Action Plan**
> *"A step-by-step guide to help you fully set up and run your business."*

### 🖼 Design References
- **`image13.png`** — "Getting Started" with **38% complete progress bar** + step checklist (★ closest match)
- **`image14.png`** — "Checklist" with per-row progress bars for each task
- **`image15.png`** — Project dashboard with productivity bars + project summary

### 📐 Layout — Tabs / Sections

```
┌────────────────────────────────────────────────────────────────┐
│  [ Setup ]    [ Growth ]    [ Compliance ]                     │
├────────────────────────────────────────────────────────────────┤
│                                                                │
│  🔧 SETUP TASKS                                                │
│  ☐ Register for EIN                          [ View Details ]  │
│  ☐ Open Business Bank Account                [ View Details ]  │
│  ☐ Set up Accounting System                  [ View Details ]  │
│                                                                │
│  📈 GROWTH TASKS                                               │
│  ☐ Create Social Media Accounts              [ View Details ]  │
│  ☐ Set up Google Business Profile            [ View Details ]  │
│  ☐ Launch Website                            [ View Details ]  │
│                                                                │
│  ⚖️  COMPLIANCE TASKS                                          │
│  ☐ File Annual Report                        [ View Details ]  │
│  ☐ Maintain Registered Agent                 [ View Details ]  │
│  ☐ Track Tax Deadlines                       [ View Details ]  │
│                                                                │
└────────────────────────────────────────────────────────────────┘
```

### 🖱 Interactions
- **Checkbox** → Mark Complete
- **Expand** → View instructions inline
- **Buttons:** `Mark as Complete` · `View Details`

---

## 6. COMMUNICATION HUB

### 📌 Title & Description
> **Messages & Updates**
> *"Stay connected with our team and receive important updates about your business."*

### 🖼 Design References
- **`image16.png`** — "Tenx Messages & Inbox" — conversation list + chat thread (★ closest match)
- **`image17.png`** — "BOARDASH Messages" — list with overall/sent/received stats
- **`image18.png`** — "Workhubs Messages" — chat thread with voice messages support

### 📐 Layout

```
┌──────────────────┬─────────────────────────────────────────────┐
│  LEFT PANEL      │  MAIN PANEL                                 │
│                  │                                             │
│  💬 Conversations│  Message thread with BizJump                │
│  ────────────────│  ─────────────────────────────────────────  │
│  • BizJump Team  │  [BizJump] Your filing is approved! 🎉      │
│    ● 2 new       │  [You]     Thanks, when is the EIN ready?   │
│  • Filing Updates│  [BizJump] Within 5 business days.          │
│  • Notifications │                                             │
│                  │  ┌─────────────────────────────────────┐    │
│                  │  │ Type your message...                │    │
│                  │  └─────────────────────────────────────┘    │
│                  │  [ Send Message ]   [ 📎 Upload File ]      │
└──────────────────┴─────────────────────────────────────────────┘
```

### Features
- Message thread with BizJump team
- Filing updates feed
- Notifications log
- **Buttons:** `Send Message` · `Upload File` · `View All Notifications`

---

## 7. BUSINESS PROFILE

### 📌 Title
> **Your Business Details**

### 🖼 Design References
- **`image19.png`** — "Account Settings" with sidebar navigation (Account / Notifications / Security / Appearance / Billing / Integrations)
- **`image20.png`** — Business account settings (Account name, Business address, Phone verification, Time zone)
- **`image21.png`** — "Business Information" with Store details + Business details + Tax registration sections

### 📐 Layout

```
┌────────────────────────────────────────────────────────────────┐
│  YOUR BUSINESS DETAILS                                         │
├────────────────────────────────────────────────────────────────┤
│                                                                │
│  Business Name      :  ________________________________        │
│  Entity Type        :  [ LLC ▾ ]                               │
│  State              :  [ Florida ▾ ]                           │
│  Formation Date     :  __ / __ / ____                          │
│  EIN (if available) :  ________________________________        │
│  Registered Agent   :  ________________________________        │
│                                                                │
│                                       [ Edit Information ]     │
└────────────────────────────────────────────────────────────────┘
```

### 💡 From Reference Images (additional fields to consider)
From `image19.png` & `image21.png` the client likely also wants:
- Business contact phone (with verification)
- Business address (street + city + ZIP)
- Time zone
- Tax/VAT registration number
- Branding (logo upload)
- Bank accounts & currencies tab

---

## 8. SIDEBAR MENU

```
┌──────────────────┐
│  📊 Dashboard    │  ← active state (highlighted)
│  📁 Documents    │
│  ⚖️  Compliance  │
│  🛠  Services    │
│  ✅ Action Plan  │
│  💬 Messages     │
│  ⚙️  Settings    │
│  🚪 Logout       │
└──────────────────┘
```

---

## 9. NOTIFICATIONS SYSTEM

### Example Messages
- ✅ *"Your business has been successfully filed with the state"*
- 🔄 *"Your EIN application is in progress"*
- ⏰ *"Annual report due in 30 days"*

### Triggers
- Filing status change
- EIN milestone reached
- Compliance deadline approaching (30d / 7d / overdue)
- New message from BizJump team
- Document uploaded / ready

---

## 10. EMPTY STATES (UX COPY)

| Section | Empty State Copy |
|---|---|
| **Documents** | *"You don't have any documents yet. Once your business is filed, they will appear here."* |
| **Compliance** | *"No upcoming deadlines at the moment. You're all set."* |
| **Services** | *"You haven't added any additional services yet. Explore options to strengthen your business."* |

---

## 11. TOP BAR (GLOBAL)

```
┌──────────────────────────────────────────────────────────────┐
│  [BizJump Logo]              [🔔]  [Support]  [Account ▾]    │
└──────────────────────────────────────────────────────────────┘
```

| Position | Element |
|---|---|
| **Left** | BizJump Logo |
| **Right** | Notifications Icon · Support Button · Account Menu |

---

## 12. SUPPORT ACCESS

> **Visible on every page**
>
> **Button Label:** `Contact Support`
> **Tooltip:** *"Get help from our team anytime."*

---

## 13. CORE POSITIONING & DIFFERENTIATION

### 🎯 Subtle Reinforcement (across pages)
> *"Everything you need to start, manage, and grow your business — clearly organized in one place."*

### ⭐ Key Differentiators (built into design)
1. ✅ **Provide real operational value** (not just documents)
2. ✅ **Guide users on what to do next** (Action Center)
3. ✅ **Avoid aggressive upsells**
4. ✅ **Reinforce trust and transparency**

---

## 14. IMPLEMENTATION MAPPING

### 🛠 Tech Stack Mapping (from client's note)

| Dashboard Feature | Maps To |
|---|---|
| Orders + Services | **WooCommerce** |
| Custom Dashboard | **Custom "My Account" pages** |
| CRM Integration | **FluentCRM** or **Jetpack CRM** |
| Document Storage | **Document storage plugin** |
| Notifications | **Notification system plugin** |

---

## 🖼 IMAGE REFERENCE INDEX

> All 21 images extracted from `Wire Frame of Customer Portal.docx`.
> Located at: `_extracted/word/media/`

| Section | Image | Description / What to copy |
|---|---|---|
| Hero ref | `image1.jpeg` | Fiverr Varun Dade SaaS/CRM collage — overall aesthetic anchor |
| §1 Dashboard | `image2.png` | Stat cards row + donut chart + notifications + calendar |
| §2 Documents | `image3.png` | File-type tiles (PDF/Sheets/Docs/Zip) + table |
| §2 Documents | `image4.png` | Doc table with status pills + mobile responsive view |
| §2 Documents | `image5.png` | Sidebar nav + filter modal pattern |
| §2 Documents | `image6.png` | Clean table with multi-filter chips |
| §3 Compliance | `image7.png` | ★ Tax compliance dashboard (calendar + deadlines + tasks) |
| §3 Compliance | `image8.png` | Yearly compliance heatmap |
| §3 Compliance | `image9.png` | Mobile tax returns (Pending/Processing/Completed) |
| §4 Services | `image10.jpeg` | Stat cards + services/suppliers table |
| §4 Services | `image11.jpeg` | Subscription dashboard (renewals + history) |
| §4 Services | `image12.png` | Pricing plan cards (4 tiers) |
| §5 Action | `image13.png` | ★ Getting Started checklist with 38% progress bar |
| §5 Action | `image14.png` | Checklist with per-row progress bars |
| §5 Action | `image15.png` | Productivity bars + project summary |
| §6 Messages | `image16.png` | ★ Messages & Inbox (list + chat thread) |
| §6 Messages | `image17.png` | Messages with sent/received stats |
| §6 Messages | `image18.png` | Chat thread with voice messages |
| §7 Profile | `image19.png` | Account Settings (sidebar nav of profile sections) |
| §7 Profile | `image20.png` | Business account settings (name/address/phone/zone) |
| §7 Profile | `image21.png` | Business Information (Store + Business + Tax tabs) |

★ = best match for the section.

---

## 📌 SUMMARY CHECKLIST

- [ ] **Section 1:** Dashboard Home — status panel + quick actions
- [ ] **Section 2:** Document Hub — table + upload/download
- [ ] **Section 3:** Compliance Center — alerts + calendar
- [ ] **Section 4:** Service Management — active + add-ons + upgrade pricing cards
- [ ] **Section 5:** Action Center — tabbed checklists *(differentiator)*
- [ ] **Section 6:** Communication Hub — chat + notifications
- [ ] **Section 7:** Business Profile — editable fields (extended w/ tax/branding tabs)
- [ ] **Section 8:** Sidebar — 8 menu items
- [ ] **Section 9:** Notifications system
- [ ] **Section 10:** Empty state copy for 3 areas
- [ ] **Section 11:** Top bar (logo + 3 right items)
- [ ] **Section 12:** Persistent Support button
- [ ] **Integration:** WooCommerce + CRM + Document plugin

---

**📁 Source files:**
- `docs.md` — full text spec (14 sections, 261 lines)
- `Wire Frame of Customer Portal.docx` — visual layout + 21 reference images
- `Wire Frame of Customer Portal.docx.txt` — text-only conversion (no images)
- `Wire Frame of Customer Portal.docx.pdf` — PDF version
- `_extracted/word/media/image1..21` — extracted reference images
