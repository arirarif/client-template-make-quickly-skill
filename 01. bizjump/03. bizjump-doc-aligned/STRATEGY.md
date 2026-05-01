# BizJump — Whole-Site Redesign Strategy

**Goal:** redesign every public page on `bizjump.com` using the doc-aligned design pattern established in `formation-landing.html`, while keeping all existing site content **verbatim**. No content fabrication.

## Design system (already established)

Reused across every page. Source of truth: `formation-landing.html`.

| Token group | Values |
|---|---|
| Brand orange | `#F97316` (500), `#EA580C` (600), `#FFF7ED` (50), `#FFEDD5` (100) |
| Slate scale | `#0F172A` (900) → `#F8FAFC` (50) |
| Indigo accent | `#4F46E5` (600), `#6366F1` (500), `#EEF2FF` (50) |
| Cream warm BG | `#F2EDE7` (hero zones, trust strips) |
| Heading font | Plus Jakarta Sans 700/800, `letter-spacing: -.02em` |
| Body font | Inter 400/500/600 |
| Container | `max-width: 1160px` (default), `860px` (sm), `760px` (xs) |
| Border radius | 10/12/14/18 (input → card → hero panel) |
| Shadow | `--shadow-xs` to `--shadow-lg` |

Components reused page-to-page:
- Sticky navbar (logo + nav links + Sign In / My Account)
- Cream hero zone with bold headline + small subhead
- `.section` (80px vertical padding) and `.section-alt` (slate-50 BG)
- Card patterns from wizard (`.entity-card`, `.package-card`, `.form-input`, `.form-select`)
- FAQ accordion
- Slate-900 footer with 4-column grid

## Live-site source of truth

| Page | URL | Content status | Action |
|---|---|---|---|
| Home | `/` | Already redesigned by user | **Skip** |
| Wizard | `/wizard/`, `/start/` | Already redesigned (`demo-wizard.html`) | **Skip** |
| About Us | `/about-us/` | Real verbatim copy (Clinton & Michelle, 1998, 2,200+ clients, Incubate+Accelerate process) | **Build** |
| Contact Us | `/contact-us/` | Real form + address (294 Bay Meadows Ave., Bay Shore, NY 11706) + 5 FAQ headlines | **Build** |
| Blog | `/blog/` | 8 Woodmart demo posts (lorem ipsum body, real images at `wd-blog-1.jpg`–`wd-blog-9.jpg`) | **Build** (preserve existing titles + excerpts as-is) |
| Shop | `/shop/` | Empty — "No products were found matching your selection" | **Build** (empty state) |
| Cart | `/cart/` | Empty — "Your shopping bag is empty" | **Build** (empty state) |
| Checkout | `/checkout/` | Empty (defers to cart when no items) | **Build** (empty state) |
| Wishlist | `/wishlist/` | Empty — "This wishlist is empty" | **Build** (empty state) |
| Compare | `/compare/` | Empty — "Compare list is empty" | **Build** (empty state) |
| My Account | `/my-account/` | Returns 404 on live site | **Build** (standard WooCommerce login + register, no fabricated marketing copy) |

## Pages NOT being built (reason)

- Service detail pages (Form an LLC, Registered Agent, EIN Filing, Business Name Search, State Requirements, Business Guide). The live site's footer links to `#` for all of these — they don't exist as published pages. Building them would mean fabricating content, which is the exact mistake the client cited. Hold until client provides copy.
- Privacy Policy / Terms of Service / Cookie Policy — same reason. Live site footer links to `#`.
- Newsletter, Affiliate Program, Customer Reviews — same.

## Image assets reused from bizjump.com

| Asset | URL | Used on |
|---|---|---|
| Logo (black) | `/wp-content/uploads/2026/04/BizjumpLogo-black-v7.png` | Optional — current design uses inline SVG mark |
| About hero photo | `/wp-content/uploads/2019/05/businessman-chairs-facial-expression-716411-e1559267142351-1024x434.jpg` | About page hero |
| About team photo | `/wp-content/uploads/2019/05/business-people-working-together-istock_000017346252medium-1024x682.jpg` | About page secondary section |
| Blog thumbnails | `/wp-content/uploads/2021/08/wd-blog-{1..9}.jpg` | Blog grid (one per post) |

## Cross-page conventions

- **Navbar**: identical on every page (sticky, white BG, same links)
- **Footer**: identical on every page (slate-900, 4 columns, same legal row)
- **Page hero**: cream BG, eyebrow label (orange uppercase), headline (Plus Jakarta 800), subhead (slate-500)
- **Empty states** (shop/cart/wishlist/compare/checkout): centered icon + message + primary CTA back to home/start wizard
- **Forms**: orange focus ring (`box-shadow: 0 0 0 3px rgba(249,115,22,.12)`)
- **Mobile breakpoints**: `980px` (sidebar collapse), `640px` (single column, card padding tightens)

## Build order

1. ✅ `formation-landing.html` (homepage replacement — done previously)
2. ✅ `demo-wizard.html` (6-step wizard — done previously)
3. ⏳ `about-us.html`
4. ⏳ `contact-us.html`
5. ⏳ `blog.html`
6. ⏳ `shop.html`
7. ⏳ `cart.html`
8. ⏳ `checkout.html`
9. ⏳ `wishlist.html`
10. ⏳ `compare.html`
11. ⏳ `my-account.html`

## What this delivers

A complete static HTML mock of every public BizJump page that currently has content, every page using the same visual system as `formation-landing.html` and `demo-wizard.html`. Ready for client review before WordPress/Elementor implementation.
