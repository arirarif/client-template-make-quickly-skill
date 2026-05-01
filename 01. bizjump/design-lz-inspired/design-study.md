# LegalZoom Design Study — BizJump Implementation Plan

## What the Client Loves About LegalZoom

The client specifically mentioned:
- Light white color blend
- Smooth shading and gradients
- Boxed elements with shadows
- Button colors and shadow depth
- Things feel "smooth"
- Orange accent (approved to keep)

---

## LegalZoom Design Breakdown

### 1. Color Architecture

LegalZoom uses a **3-layer color system**:

| Layer | Purpose | LZ Color | Our New Color |
|-------|---------|----------|---------------|
| Background | Page base | `#FFFFFF` white | `#FFFFFF` white |
| Surface | Section alternates | `#F5F5F5` / `#F9F9F9` | `#F8FAFC` slate-50 |
| Elevation | Cards, boxes | White + shadow | White + shadow |
| Brand Orange | CTAs, highlights | `#FF6B35` | `#F97316` (same feel) |
| Trust Color | Checkmarks, badges | Teal `#2D9D78` | Indigo `#6366F1` |
| Primary Text | Body copy | `#333333` | `#1E293B` slate-800 |
| Secondary Text | Subtitles, labels | `#666666` | `#475569` slate-600 |
| Muted | Placeholder, captions | `#999999` | `#94A3B8` slate-400 |
| Borders | Lines, dividers | `#DDDDDD` | `#E2E8F0` slate-200 |

### 2. Shadow System — The Secret to "Smooth" Feel

LegalZoom uses a **4-tier shadow scale** with low-opacity dark shadows:

```css
/* Tier 1 — Barely there, for flat elements */
box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);

/* Tier 2 — Cards at rest */
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);

/* Tier 3 — Hover state, highlighted cards */
box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);

/* Tier 4 — Featured/recommended card */
box-shadow: 0 16px 40px rgba(0, 0, 0, 0.14);
```

**Key insight:** The shadows use very low opacity (6-14%) which creates depth without harshness.

### 3. White-to-Light Blending Pattern

Sections alternate between `#FFFFFF` and `#F8FAFC` (barely visible gray). This creates rhythm without jarring contrast. The transition is invisible — you feel it more than see it.

```
Section 1: #FFFFFF — Hero
Section 2: #F8FAFC — Trust Strip
Section 3: #FFFFFF — Pricing Cards
Section 4: #F8FAFC — Features
Section 5: #FFFFFF — Testimonials
Section 6: Orange — CTA Banner
```

### 4. Button Design

```css
/* Primary CTA */
background: #F97316;
color: #FFFFFF;
border-radius: 8px;
padding: 14px 32px;
font-size: 16px;
font-weight: 600;
box-shadow: 0 4px 14px rgba(249, 115, 22, 0.35);
transition: all 0.2s ease;

/* Hover */
background: #EA580C;
box-shadow: 0 6px 20px rgba(249, 115, 22, 0.45);
transform: translateY(-1px);
```

The orange button has a **colored shadow** (orange-tinted, not black) — this is what makes it look "glowing" and premium.

### 5. Card Anatomy

```css
/* Standard card */
background: #FFFFFF;
border: 1px solid #E2E8F0;
border-radius: 12px;
padding: 32px;
box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);

/* Featured/highlighted card */
border: 2px solid #F97316;
box-shadow: 0 8px 32px rgba(249, 115, 22, 0.15); /* orange shadow tint */
```

### 6. Typography System

```css
/* Hero headline */
font-size: clamp(32px, 5vw, 52px);
font-weight: 800;
line-height: 1.15;
color: #0F172A;

/* Section title */
font-size: clamp(24px, 3vw, 36px);
font-weight: 700;
color: #1E293B;

/* Body */
font-size: 16px;
font-weight: 400;
line-height: 1.65;
color: #475569;

/* Caption/label */
font-size: 13px;
font-weight: 500;
letter-spacing: 0.05em;
text-transform: uppercase;
color: #94A3B8;
```

Font: Google Fonts **Inter** or **Plus Jakarta Sans** — both are clean, modern, match LegalZoom's feel perfectly.

### 7. Wizard / Multi-Step Form Design

```
Step indicator:
- Circle: 40px diameter
- Active: Orange background, white number
- Completed: Indigo background, white checkmark
- Inactive: White, slate-200 border, slate-400 number
- Connector line: 2px, slate-200 (inactive), indigo (completed)

Selection cards:
- Default: White, slate-200 border
- Hover: Slate-50 background, slate-300 border
- Selected: White, orange 2px border, orange-50 background tint, orange check icon

Input fields:
- Border: 1px slate-200
- Radius: 8px
- Padding: 12px 16px
- Focus: Orange ring (0 0 0 3px rgba(249,115,22,0.15))
```

---

## New BizJump Color Palette

### Primary Palette
```
Orange-50:   #FFF7ED   — Tints, backgrounds
Orange-100:  #FFEDD5   — Badges, pill backgrounds
Orange-400:  #FB923C   — Hover state light
Orange-500:  #F97316   — PRIMARY CTA
Orange-600:  #EA580C   — CTA hover/pressed
```

### Indigo Accent (replaces LZ's teal)
```
Indigo-50:   #EEF2FF   — Check badge bg
Indigo-100:  #E0E7FF   — Tints
Indigo-500:  #6366F1   — Checkmarks, trust icons, active step
Indigo-600:  #4F46E5   — Links, hover
```

### Neutrals (Slate family)
```
Slate-50:    #F8FAFC   — Section backgrounds
Slate-100:   #F1F5F9   — Inner card backgrounds
Slate-200:   #E2E8F0   — Borders, dividers
Slate-400:   #94A3B8   — Placeholder, muted text
Slate-600:   #475569   — Body text, subtitles
Slate-800:   #1E293B   — Primary headings
Slate-900:   #0F172A   — Maximum contrast text
```

### Why this works like LegalZoom:
- Slate feels just as trustworthy as LZ's navy/charcoal but is softer
- Orange stays identical in feel (same warm energy, call-to-action power)
- Indigo replaces teal as the "trust signal" color — still a cool tone against warm orange
- The whites/near-whites are identical in principle

---

## Files in This Folder

| File | Purpose |
|------|---------|
| `design-study.md` | This document — analysis and specs |
| `design-tokens.css` | All CSS custom properties / variables |
| `demo-landing.html` | Full landing page (LLC overview equivalent) |
| `demo-wizard.html` | Multi-step wizard (business formation flow) |
