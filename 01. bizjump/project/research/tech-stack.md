# BizJump — Tech Stack & Plugins

## Platform
| Layer | Tool |
|-------|------|
| CMS | WordPress |
| E-commerce | WooCommerce |
| Hosting (recommended) | WP Engine / Kinsta / SiteGround |
| Client has: | Domain + hosting (already purchased) |

---

## Required Plugins

### Core Wizard & Funnel
| Plugin | Purpose |
|--------|---------|
| **CartFlows Pro** | Multi-step wizard/funnel builder |

### WooCommerce Extensions
| Plugin | Purpose |
|--------|---------|
| **WooCommerce Product Add-ons** | Dynamic add-on services with price updates |
| **WooCommerce Subscriptions** | Recurring billing (Registered Agent, hosting, compliance) |
| **WooCommerce Checkout Field Editor** | Custom business info fields at checkout |
| **WooCommerce Payments / Stripe for WooCommerce** | Stripe credit/debit + ACH payments |
| **WooCommerce PayPal Payments** | PayPal checkout |
| **WooCommerce ACH/eCheck** | ACH bank transfers (via Authorize.net or Stripe ACH) |

### CRM & Automation
| Plugin | Purpose |
|--------|---------|
| **FluentCRM Pro** | CRM, email automation, post-purchase flows |
| (Alternative) Jetpack CRM | Backup option if FluentCRM not suitable |

### Forms & Data Capture
| Plugin | Purpose |
|--------|---------|
| **Gravity Forms Pro** OR **WPForms Pro** | Business info forms, document upload |
| **Gravity Forms Signature Add-on** | E-signatures (if needed) |

### Search
| Plugin | Purpose |
|--------|---------|
| **FiboSearch Pro** OR **SearchWP** | Enhanced product/service search |

### Admin & Order Management
| Plugin | Purpose |
|--------|---------|
| **Admin Columns Pro** | Better order management columns in WP admin |
| **WooCommerce Order Status Manager** | Custom order statuses (e.g., "Formation In Progress", "Filed") |
| **WooCommerce Customer/Order/Coupon Export** | Export orders for processing |

### Security & Performance
| Plugin | Purpose |
|--------|---------|
| **WP Rocket** | Caching + performance |
| Google reCAPTCHA | Checkout spam protection |
| SSL Certificate | Must be active (hosting level) |

---

## Custom Development Required

### 1. State-Based Dynamic Pricing Plugin
- Load State_Filing_Fees.xlsx data into WordPress
- Create logic: entity type + state → correct fee
- Trigger: on state/entity selection in wizard → update cart total via AJAX
- Options: custom plugin, ACF + custom logic, or heavy Product Add-ons config

### 2. Client Dashboard (My Account Customization)
- Custom WooCommerce My Account tabs:
  - Order Status (with custom statuses)
  - Document Upload portal
  - Progress tracker
  - Download deliverables

### 3. Admin Formation Details View
- Per-order panel showing all business details collected at checkout
- Custom metabox or Admin Columns Pro setup

---

## Hero Slider Decision (Pending)
- Client wants: Revolution Slider (familiar, used it for years)
- Recommendation: Use a lighter slider to avoid performance issues
- Options to consider:
  - **Swiper.js** (free, lightweight, 35kb, very capable)
  - **Splide.js** (free, lightweight, accessible)
  - **Smart Slider 3** (WordPress plugin, lighter than Revolution Slider)
- ACTION: Confirm with client which direction to go

---

## Notes
- All premium plugins will be provided by developer at no extra cost to client
- Client only paid for domain + hosting
