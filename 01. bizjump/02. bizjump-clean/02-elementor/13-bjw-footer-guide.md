# Widget 13 — BizJump Footer
# WoodMart Footer Builder Guide
# File: 13-bjw-footer-guide.md

================================================================
  WIDGET 13 — FOOTER (WoodMart Footer Builder + Custom CSS)
  This is a settings guide — not an HTML widget.
  The footer is built using WoodMart's Footer Builder.
================================================================

---

## Overview

- **Background**: `#0a0e1a` (very dark navy)
- **Text color**: `rgba(255,255,255,0.65)` (muted white)
- **Link color**: `rgba(255,255,255,0.65)` → hover: `#fff`
- **Accent**: `#f97316` (orange) for social icons + brand name
- **Structure**: 4 columns + legal disclaimer bar at very bottom
- **Font**: Inter (body), Space Grotesk (brand name)

---

## Step 1 — Open Footer Builder

1. WP Admin → **WoodMart** → **Footer Builder**
2. Click **Add New Footer**
3. Name it: `BizJump Main Footer`
4. Click **Edit with WoodMart Builder**

---

## Step 2 — Create Footer Structure

**Row 1 (Main Footer):**
Add 4 columns with equal widths (25% each):
- Column 1: Brand + Contact
- Column 2: Incorporation Links
- Column 3: Company Links
- Column 4: Newsletter + Legal

**Row 2 (Legal Bar):**
Add 1 full-width column for copyright + legal links

**Row settings (both rows):**
- Background color: `#0a0e1a`
- Padding Top/Bottom: 64px (Row 1), 24px (Row 2)
- Padding Left/Right: 32px

---

## Step 3 — Column 1: Brand + Contact

**Widgets to add:**

**1. Custom HTML Widget** — Brand block
```html
<div style="font-family:'Inter',sans-serif;">
  <div style="font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;letter-spacing:-0.5px;">
    Biz<span style="color:#f97316;">Jump</span>
  </div>
  <div style="font-size:11px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,0.4);margin-bottom:16px;">
    Business Formation Experts
  </div>
  <p style="font-size:14px;color:rgba(255,255,255,0.6);line-height:1.7;margin-bottom:20px;max-width:260px;">
    Helping entrepreneurs launch and grow their businesses since 1998.
    Trusted by 3,500+ companies across all 50 states.
  </p>
</div>
```

**2. Custom HTML Widget** — Social Icons
```html
<div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:24px;">
  <a href="https://facebook.com/bizjump" target="_blank" rel="noopener"
     style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,0.08);
            display:flex;align-items:center;justify-content:center;
            color:rgba(255,255,255,0.7);text-decoration:none;font-size:16px;
            transition:background .2s,color .2s;"
     onmouseenter="this.style.background='#f97316';this.style.color='#fff'"
     onmouseleave="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.7)'">f</a>
  <a href="https://twitter.com/bizjump" target="_blank" rel="noopener"
     style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,0.08);
            display:flex;align-items:center;justify-content:center;
            color:rgba(255,255,255,0.7);text-decoration:none;font-size:16px;
            transition:background .2s,color .2s;"
     onmouseenter="this.style.background='#f97316';this.style.color='#fff'"
     onmouseleave="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.7)'">𝕏</a>
  <a href="https://linkedin.com/company/bizjump" target="_blank" rel="noopener"
     style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,0.08);
            display:flex;align-items:center;justify-content:center;
            color:rgba(255,255,255,0.7);text-decoration:none;font-size:14px;
            transition:background .2s,color .2s;"
     onmouseenter="this.style.background='#f97316';this.style.color='#fff'"
     onmouseleave="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.7)'">in</a>
  <a href="https://instagram.com/bizjump" target="_blank" rel="noopener"
     style="width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,0.08);
            display:flex;align-items:center;justify-content:center;
            color:rgba(255,255,255,0.7);text-decoration:none;font-size:16px;
            transition:background .2s,color .2s;"
     onmouseenter="this.style.background='#f97316';this.style.color='#fff'"
     onmouseleave="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.7)'">◎</a>
</div>
```

**3. Custom HTML Widget** — Contact
```html
<div style="font-family:'Inter',sans-serif;display:flex;flex-direction:column;gap:10px;">
  <a href="tel:+12127815806" style="display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.65);text-decoration:none;font-size:14px;">
    <span style="color:#f97316;font-size:16px;">📞</span> +1 (212) 781-5806
  </a>
  <a href="mailto:info@bizjump.com" style="display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.65);text-decoration:none;font-size:14px;">
    <span style="color:#f97316;font-size:16px;">✉</span> info@bizjump.com
  </a>
  <div style="display:flex;align-items:flex-start;gap:10px;color:rgba(255,255,255,0.65);font-size:14px;">
    <span style="color:#f97316;font-size:16px;margin-top:2px;">📍</span> United States — All 50 States
  </div>
</div>
```

---

## Step 4 — Column 2: Incorporation Links

**Widget: Navigation Menu** (create a menu called "Footer - Incorporation")
- LLC Formation → `/incorporate/?entity=llc`
- Corporation → `/incorporate/?entity=corporation`
- S-Corporation → `/incorporate/?entity=scorp`
- Non-Profit → `/incorporate/?entity=nonprofit`
- Registered Agent → `/incorporate/?addon=registered-agent`
- EIN / Tax ID → `/incorporate/?addon=ein`

**WoodMart Menu Widget settings:**
- Heading: `Incorporation`
- Heading color: `#fff`, size: 13px, weight: 700, letter-spacing: 2px, uppercase
- Link color: `rgba(255,255,255,0.65)` → hover: `#fff`
- Item font size: 14px
- Gap between items: 10px

---

## Step 5 — Column 3: Company Links

**Widget: Navigation Menu** (create a menu called "Footer - Company")
- About Us → `/about/`
- Contact → `/contact/`
- Pricing → `/#pricing`
- Privacy Policy → `/privacy-policy/`
- Terms of Service → `/terms-of-service/`
- Refund Policy → `/refund-policy/`

**Same style settings as Column 2, heading: `Company`**

---

## Step 6 — Column 4: Newsletter + Trust

**1. Custom HTML Widget** — Newsletter
```html
<div style="font-family:'Inter',sans-serif;margin-bottom:24px;">
  <div style="font-size:13px;font-weight:700;letter-spacing:2px;text-transform:uppercase;
              color:#fff;margin-bottom:8px;">Stay Updated</div>
  <p style="font-size:14px;color:rgba(255,255,255,0.6);margin-bottom:16px;line-height:1.5;">
    Business tips, state law updates, and exclusive offers.
  </p>
  <!-- Replace ACTION with your Mailchimp/FluentCRM form action URL -->
  <form style="display:flex;gap:8px;flex-direction:column;">
    <input type="email" placeholder="Your email address"
           style="width:100%;padding:12px 16px;border-radius:8px;border:1.5px solid rgba(255,255,255,0.15);
                  background:rgba(255,255,255,0.07);color:#fff;font-size:14px;
                  font-family:'Inter',sans-serif;outline:none;box-sizing:border-box;"
           onfocus="this.style.borderColor='#2563eb'"
           onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
    <button type="submit"
            style="padding:12px;background:#f97316;color:#fff;border:none;border-radius:8px;
                   font-size:14px;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;
                   transition:background .2s;"
            onmouseenter="this.style.background='#ea6c00'"
            onmouseleave="this.style.background='#f97316'">
      Subscribe
    </button>
  </form>
</div>
```

**2. Custom HTML Widget** — Trust badges
```html
<div style="font-family:'Inter',sans-serif;display:flex;flex-direction:column;gap:8px;">
  <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,0.55);">
    <span style="color:#4ade80;font-weight:700;">✓</span> SSL Secured Checkout
  </div>
  <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,0.55);">
    <span style="color:#4ade80;font-weight:700;">✓</span> 100% Money-Back Guarantee
  </div>
  <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,0.55);">
    <span style="color:#4ade80;font-weight:700;">✓</span> No Hidden Fees, Ever
  </div>
</div>
```

---

## Step 7 — Row 2: Legal Bar

**Background**: `#060912` (slightly darker than footer)
**Padding**: 20px 32px
**Border top**: `1px solid rgba(255,255,255,0.07)`

**1 column, full width. Custom HTML Widget:**
```html
<div style="font-family:'Inter',sans-serif;display:flex;align-items:center;
            justify-content:space-between;flex-wrap:wrap;gap:12px;">
  <div style="font-size:13px;color:rgba(255,255,255,0.4);">
    © 2024 BizJump LLC. All rights reserved. BizJump is not a law firm and does not provide legal advice.
  </div>
  <div style="display:flex;gap:20px;flex-wrap:wrap;">
    <a href="/privacy-policy/" style="font-size:13px;color:rgba(255,255,255,0.45);text-decoration:none;"
       onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='rgba(255,255,255,0.45)'">Privacy Policy</a>
    <a href="/terms-of-service/" style="font-size:13px;color:rgba(255,255,255,0.45);text-decoration:none;"
       onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='rgba(255,255,255,0.45)'">Terms of Service</a>
    <a href="/refund-policy/" style="font-size:13px;color:rgba(255,255,255,0.45);text-decoration:none;"
       onmouseenter="this.style.color='#fff'" onmouseleave="this.style.color='rgba(255,255,255,0.45)'">Refund Policy</a>
  </div>
</div>
```

---

## Step 8 — Global Footer CSS

Go to **WP Admin → Appearance → Customize → Additional CSS** (or WoodMart → Custom CSS) and add:

```css
/* BizJump Footer Global Overrides */
.site-footer,
.woodmart-footer-container {
  background: #0a0e1a !important;
}

/* Footer link base */
.site-footer a {
  color: rgba(255,255,255,0.65);
  transition: color .2s;
}
.site-footer a:hover { color: #fff !important; }

/* Footer menu heading */
.woodmart-footer-widget .widget-title,
.woodmart-footer-widget h3 {
  font-family: 'Space Grotesk', sans-serif !important;
  font-size: 13px !important;
  font-weight: 700 !important;
  letter-spacing: 2px !important;
  text-transform: uppercase !important;
  color: #fff !important;
  margin-bottom: 18px !important;
}

/* Footer menu items */
.woodmart-footer-widget ul li {
  margin-bottom: 10px;
}
.woodmart-footer-widget ul li a {
  font-size: 14px;
  color: rgba(255,255,255,0.65);
}

/* Remove WoodMart default footer bg if conflicting */
.woodmart-footer-top { background: transparent !important; }

/* Mobile footer stacking */
@media (max-width: 768px) {
  .woodmart-footer-top .col-md-3 { margin-bottom: 40px; }
}
```

---

## Step 9 — Set as Active Footer

1. Save the footer builder layout
2. Go to **WoodMart → Footer Builder**
3. On your new footer row, click **Set as Default** (globe icon)
4. Save changes

---

## Column Summary

| Column | Content | Key Widget Types |
|--------|---------|-----------------|
| 1 | Brand + Social + Contact | 3× Custom HTML |
| 2 | Incorporation links | WoodMart Nav Menu |
| 3 | Company/legal links | WoodMart Nav Menu |
| 4 | Newsletter form + trust | 2× Custom HTML |
| Legal bar | Copyright + policy links | Custom HTML (full width) |

---

## Notes for Client

- Replace `info@bizjump.com` and `+1 (212) 781-5806` with confirmed contact details before going live
- Newsletter form: connect to Mailchimp, FluentCRM, or any other email list service
- Social links: update to actual BizJump social profile URLs
- The `© 2024` year should be updated to the actual current year at launch
