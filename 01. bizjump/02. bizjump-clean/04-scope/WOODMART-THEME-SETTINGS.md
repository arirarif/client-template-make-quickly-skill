# BizJump — WoodMart Theme Settings
## Complete field-by-field setup guide

---

## 1. TYPOGRAPHY → Basic

Go to: **Appearance → Theme Settings → Typography → Basic**

### Text font (body/paragraphs)
| Field | Value |
|-------|-------|
| Font family | **Inter** |
| Style | Normal 400 |
| Font size | **15** px |
| Color | **#374151** |

### Title font (h1, h2, h3, h4, h5, h6)
| Field | Value |
|-------|-------|
| Font family | **Space Grotesk** |
| Style | **Bold 700** |
| Text transform | None |
| Color | **#111827** |

### Entities names font (posts, products, categories)
| Field | Value |
|-------|-------|
| Font family | **Space Grotesk** |
| Style | **SemiBold 600** |
| Color | **#111827** |
| Color on hover | **#2563eb** |

### Secondary font
| Field | Value |
|-------|-------|
| Font family | **Inter** |
| Style | Normal 400 |

### Widget titles font
| Field | Value |
|-------|-------|
| Font family | **Space Grotesk** |
| Style | **SemiBold 600** |
| Text transform | **Uppercase** |
| Font size | **13** px |
| Color | **#111827** |

### Header font (nav menu, header elements)
| Field | Value |
|-------|-------|
| Font family | **Inter** |
| Style | **SemiBold 600** |
| Text transform | None |
| Font size | **15** px |

**→ Save options**

---

## 2. TYPOGRAPHY → Advanced

Go to: **Typography → Advanced → + Add rule**

Add these rules one by one:

### Rule 1 — H1 headings
| Field | Value |
|-------|-------|
| Assigned to | **H1** |
| Font family | **Space Grotesk** |
| Style | **ExtraBold 800** |
| Font size | leave blank (controlled by CSS) |
| Color | **#111827** |

### Rule 2 — H2 headings
| Field | Value |
|-------|-------|
| Assigned to | **H2** |
| Font family | **Space Grotesk** |
| Style | **Bold 700** |
| Color | **#111827** |

### Rule 3 — Navigation links
| Field | Value |
|-------|-------|
| Assigned to | **Navigation** |
| Font family | **Inter** |
| Style | **Medium 500** |
| Font size | **15** px |
| Color | **#374151** |
| Color on hover | **#1e3a8a** |

### Rule 4 — Price (WooCommerce)
| Field | Value |
|-------|-------|
| Assigned to | **Price** |
| Font family | **Space Grotesk** |
| Style | **Bold 700** |
| Color | **#0f2156** |

### Rule 5 — Buttons text
| Field | Value |
|-------|-------|
| Assigned to | **Buttons** |
| Font family | **Inter** |
| Style | **Bold 700** |

**→ Save options**

---

## 3. STYLES AND COLORS → Colors

Go to: **Styles and colors → Colors**

| Field | Value | Notes |
|-------|-------|-------|
| **Primary color** | **#f97316** | Orange — used for accent/CTA buttons |
| **Secondary color** | **#2563eb** | Blue-mid — used for page builder "secondary" elements |
| **Links color — Regular** | **#2563eb** | Blue links |
| **Links color — Hover** | **#1e3a8a** | Dark blue on hover |
| **Mobile browser top bar color** | **#0f2156** | Navy — matches announcement bar |

**→ Save options**

---

## 4. STYLES AND COLORS → Styles

Go to: **Styles and colors → Styles**

| Field | Value |
|-------|-------|
| Infoboxes style | **Shadow** |
| Buttons style | **Flat** (see Buttons section) |
| Products style | **Shadow** |

---

## 5. STYLES AND COLORS → Buttons

Go to: **Styles and colors → Buttons**

### Default buttons (standard WooCommerce / theme buttons)
| Field | Value |
|-------|-------|
| Default buttons styles | **FLAT** |
| Font family | **Inter** |
| Style | **Bold 700** |
| Text transform | None |
| Default buttons background | **#1e3a8a** |
| Default buttons hover background | **#2563eb** |
| Default buttons text color scheme | **Light** |
| Default buttons hover text color scheme | **Light** |

### Accent buttons ("Call to action" buttons)
| Field | Value |
|-------|-------|
| Accent buttons styles | **FLAT** |
| Font family | **Inter** |
| Style | **Bold 700** |
| Text transform | None |
| Accent buttons background | **#f97316** |
| Accent buttons hover background | **#ea6c00** |
| Accent buttons text color scheme | **Light** |
| Accent hover buttons text color scheme | **Light** |

**→ Save options**

---

## 6. STYLES AND COLORS → Forms

Go to: **Styles and colors → Forms**

| Field | Value |
|-------|-------|
| Input background | **#ffffff** |
| Input border color | **#e5e7eb** |
| Input focus border color | **#2563eb** |
| Input text color | **#111827** |
| Input placeholder color | **#9ca3af** |
| Label color | **#111827** |

---

## 7. STYLES AND COLORS → Pages background

Go to: **Styles and colors → Pages background**

| Field | Value |
|-------|-------|
| All pages background | **#ffffff** (white — leave color picker empty, just ensure it's white) |
| Product archive background | leave blank |
| Single product background | leave blank |
| Blog archive background | leave blank |
| Single post background | leave blank |

---

## 8. STYLES AND COLORS → Notices

Go to: **Styles and colors → Notices**

| Field | Value |
|-------|-------|
| Info notice | **#eff6ff** bg / **#2563eb** text |
| Success notice | **#f0fdf4** bg / **#16a34a** text |
| Error notice | **#fef2f2** bg / **#ef4444** text |

---

## 9. GENERAL → Header

Go to: **General → Header** (or via Header Builder)

| Field | Value |
|-------|-------|
| Header background | **#ffffff** |
| Header border bottom | **1px solid #f3f4f6** |
| Sticky header | **Enabled** |
| Sticky header background | **rgba(255,255,255,0.95)** with blur effect |
| Logo max-height | **40px** |

---

## 10. GENERAL → Footer

Go to: **Footer**

| Field | Value |
|-------|-------|
| Footer background | **#0f2156** (navy) |
| Footer text color | **rgba(255,255,255,0.7)** |
| Footer headings color | **#ffffff** |
| Footer links color | **rgba(255,255,255,0.7)** |
| Footer links hover | **#f97316** |
| Bottom bar background | **#0a1840** (darker navy) |
| Bottom bar text color | **rgba(255,255,255,0.5)** |

---

## 11. CUSTOM CSS (optional global overrides)

Go to: **Styles and colors → Custom CSS**

Paste this to ensure Space Grotesk loads and headings are consistent:

```css
/* ── BizJump Global Overrides ── */
@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap');

h1, h2, h3, h4, h5, h6 {
  font-family: 'Space Grotesk', sans-serif;
  letter-spacing: -0.5px;
}

body, p, a, li, input, select, textarea, button {
  font-family: 'Inter', sans-serif;
}

/* Announcement bar */
.woodmart-top-bar {
  background: #0f2156 !important;
  color: rgba(255,255,255,0.9) !important;
  font-size: 13.5px !important;
  font-weight: 500 !important;
}

/* Primary CTA button */
.wd-btn-accent,
.woocommerce a.button.alt,
.woocommerce button.button.alt,
.woocommerce input.button.alt,
.woocommerce #respond input#submit.alt {
  background-color: #f97316 !important;
  color: #fff !important;
  font-family: 'Inter', sans-serif !important;
  font-weight: 700 !important;
  border-radius: 8px !important;
}

.wd-btn-accent:hover,
.woocommerce a.button.alt:hover,
.woocommerce button.button.alt:hover {
  background-color: #ea6c00 !important;
  color: #fff !important;
}

/* Default button */
.wd-btn-default,
.woocommerce a.button,
.woocommerce button.button {
  background-color: #1e3a8a !important;
  color: #fff !important;
  font-family: 'Inter', sans-serif !important;
  font-weight: 700 !important;
  border-radius: 8px !important;
}

.wd-btn-default:hover,
.woocommerce a.button:hover {
  background-color: #2563eb !important;
  color: #fff !important;
}

/* Price color */
.price, .woocommerce-Price-amount {
  font-family: 'Space Grotesk', sans-serif !important;
  color: #0f2156 !important;
  font-weight: 700 !important;
}

/* Navigation links */
.site-header .main-nav > li > a {
  font-family: 'Inter', sans-serif !important;
  font-size: 15px !important;
  font-weight: 500 !important;
  color: #374151 !important;
}
.site-header .main-nav > li > a:hover {
  color: #1e3a8a !important;
}

/* Input focus ring */
input:focus, select:focus, textarea:focus {
  border-color: #2563eb !important;
  outline: none !important;
  box-shadow: 0 0 0 3px rgba(37,99,235,.15) !important;
}
```

**→ Save options**

---

## Quick Reference — BizJump Color Cheatsheet

| WoodMart Field | Color | Hex |
|---------------|-------|-----|
| Primary color | Orange | `#f97316` |
| Secondary color | Blue-mid | `#2563eb` |
| Navy / Dark blue | Headers, footer | `#0f2156` |
| Blue | Body blue | `#1e3a8a` |
| Body text | Dark gray | `#111827` |
| Muted text | Gray | `#6b7280` |
| Borders | Light gray | `#e5e7eb` |
| Background | White | `#ffffff` |
| Section bg | Off-white | `#f9fafb` |
| Success | Green | `#16a34a` |
| Error | Red | `#ef4444` |
| Orange hover | Dark orange | `#ea6c00` |

## Quick Reference — Fonts

| WoodMart Field | Font | Weight |
|---------------|------|--------|
| Text font (body) | **Inter** | 400 Normal |
| Title font (h1–h6) | **Space Grotesk** | 700 Bold |
| Entities names | **Space Grotesk** | 600 SemiBold |
| Secondary font | **Inter** | 400 Normal |
| Widget titles | **Space Grotesk** | 600 SemiBold |
| Header font (nav) | **Inter** | 600 SemiBold |
| Buttons | **Inter** | 700 Bold |
| Prices | **Space Grotesk** | 700 Bold |
