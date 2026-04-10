# Images Reference — Wellness Junkiez

## WordPress Image URL Pattern
All images hosted on WordPress CDN (i0.wp.com):
```
https://i0.wp.com/wellnessjunkiez.com/wp-content/uploads/YYYY/MM/[filename].png?fit=WxH&ssl=1
```
To get full resolution, drop the query params:
```
https://i0.wp.com/wellnessjunkiez.com/wp-content/uploads/YYYY/MM/[filename].png
```

## Known Product Images
```
https://i0.wp.com/wellnessjunkiez.com/wp-content/uploads/2026/02/Super-Detox-Gummies-25.png
```

## How to Find All Images
Run the scraper:
```bash
cd scripts
npm install
node scrape.js
```
This will:
1. Scrape all pages listed in `PAGES_TO_SCRAPE`
2. Extract every `<img>` src
3. Download all images to `../assets/images/`
4. Save full list to `../assets/data/image-urls.txt`

## Recommended Free Replacement Images (for redesign)
Use these sources for premium wellness/supplement visuals:
- **Unsplash:** https://unsplash.com/s/photos/supplement
- **Unsplash health:** https://unsplash.com/s/photos/wellness
- **Pexels:** https://www.pexels.com/search/supplement/
- **Freepik 3D:** https://www.freepik.com/search?query=supplement+3d

## Redesign Image Strategy
- Replace product shots with 3D rendered versions (Spline or Blender exports)
- Use dark studio backgrounds for product hero shots
- Ingredient close-ups (sea moss, charcoal, gummies) as section backgrounds
- Use subtle particle/glow overlays on hero background
- Color palette: deep black/navy + electric green or gold accents
