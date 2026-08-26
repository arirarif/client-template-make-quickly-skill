# Sample catalogue — `products.json`

Import file for the SVPI importer. 19 products, 262 variations, 5 categories.

Built 2026-08-26 from the reference store's public product feed. Regenerate any time:

```
node build/fetch-feed.mjs      # caches reference-feed.json (456 products)
node build/build-products.mjs  # writes ../products.json
node build/validate-products.mjs
```

`validate-products.mjs` exits non-zero on failure. Run it before every import.

---

## Two things the build deliberately changes

**Colourways are regrouped into variable products.** The reference store is Shopify and sells every colour as its own product — `SOLID MODAL - UMBER`, `SOLID MODAL - OLD NAVY`, and so on, each with a single-value Color option. Imported as-is that produces 25 separate simple products and no swatches at all, leaving the Single Product template with nothing to render. The build folds each family into one variable product whose Color attribute carries every colourway, and each variation keeps its own image so clicking a swatch swaps the photo.

**Prices are converted.** Shopify's `products.json` quotes minor units — `1700.00` is USD 17.00 — and the store's own `meta.json` reports USD, not QAR. Importing those numbers raw would price a scarf at 1,700 QAR. Converted at the riyal's dollar peg (3.64) and rounded to the nearest 5.

Resulting range: **QAR 60 – 975**.

---

## What's in it

| Category | Products | Notes |
|---|---|---|
| Hijabs | 6 | Colour swatches, 3–34 variations each |
| Abayas & Jilbabs | 6 | Size, or Size × Length |
| Dresses | 4 | Size × Length |
| Hijab Caps | 2 | Colour swatches |
| Accessories | 1 | Magnet Hijab Pins, colour swatches |

- **262 variations**, the largest being Georgette Chiffon Hijab at 34 colours.
- **Colour attributes carry hex swatch codes**, so `SVPI_Attribute_Handler` writes the swatch term meta rather than falling back to a plain dropdown.
- **3 products carry sale prices**, derived from the source's `compare_at_price`, so the SALE nav item and the sale badges have something real to show.
- **31% of variations are out of stock** (from real source availability). No product is fully out of stock, so everything is buyable — this exercises the out-of-stock state without breaking the demo.
- **164 unique images.** The importer references them 342 times but `SVPI_Image_Handler` caches by URL in memory and via the `_svpi_source_url` post meta, so each downloads once.

## Categories that are NOT covered

The header nav lists **Instant Hijabs** and the plan plus **Prayer Essentials** — the reference store stocks **neither**, and has no jilbabs either. Nothing was invented to fill those gaps. Two categories not in the original plan (**Dresses**, **Hijab Caps**) exist here because the source genuinely sells them in volume. The nav needs reconciling with this list before launch.

## Before going live

Product names, descriptions and photography come from the reference store and are placeholder content for template work while the site is in Coming Soon mode. Swap them for the client's own before the site is made public.
