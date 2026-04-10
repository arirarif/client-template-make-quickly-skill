# justinClark — Client Redesign: Wellness Junkiez

## Client Site
- **URL:** https://wellnessjunkiez.com
- **Type:** Supplement e-commerce brand (WooCommerce / WordPress)
- **Goal:** Full homepage redesign — modern, 3D, animated

---

## Project Structure

```
justinClark/
├── readme.md                    ← you are here
│
├── research/                    ← all scraped content, organized by topic
│   ├── brand.md                 ← brand identity, tone, stats, target audience
│   ├── hero.md                  ← hero section copy + CTA buttons
│   ├── products.md              ← full product catalog with prices
│   ├── about.md                 ← about page content + leadership + story
│   ├── sections.md              ← all homepage sections (problem, solution, bundles...)
│   └── images.md                ← image URLs, patterns, redesign image strategy
│
├── scripts/                     ← automation tools
│   ├── package.json
│   └── scrape.js                ← scraper: fetches content + downloads all images
│
└── assets/                      ← auto-created when you run the scraper
    ├── images/                  ← downloaded images from the site
    └── data/
        ├── scraped-content.json ← full text content per page (JSON)
        └── image-urls.txt       ← list of all image URLs found
```

---

## Quick Start — Run the Scraper

```bash
cd scripts
npm install
node scrape.js
```

To scrape a different site:
```bash
node scrape.js https://otherclientsite.com
```

---

## Redesign Direction
- Dark premium background (black / deep navy)
- 3D product renders (floating/rotating gummies/bottles)
- Particle effects + glowing accents on hero
- Bold split-screen typography animations
- Scroll-triggered section reveals (GSAP or Framer Motion)
- Color palette: dark bg + electric green or gold accents
- Modern sans-serif (e.g. Inter, Space Grotesk, or Neue Haas)
# client-template-make-quickly-skill
