# Products import plan — Niswah Boutique (Phase 6)

Source: `29 UP Arif/Products/` (client's Google Drive download, 2026-09-07). Analysed 2026-09-07. Nothing imported yet.

---

## 1. What the client sent

| Item | Found |
|---|---|
| `website.xlsx` → sheet **PRODUCTS LISTING** | 263 variant rows = **30 products** (NB0001–NB0029, plus NB0010). Columns: Inventory ID, Category, Name, Description, Colour, Size, Unit price (QAR). |
| `website.xlsx` → sheet **Sheet2** | The client's **site map**: 12 categories with sub-groups, home sections, footer links, contact email, socials (adds TikTok), payment options "CASH ON DELIVERY / FAWRAN / CREDIT CARD", live chat number. |
| `website.xlsx` → sheet **wc-product-export…** | Header row only: the WooCommerce CSV format they expected us to fill. |
| 29 product folders | 393 images, 558 MB. 22 Word descriptions (2 are empty files). 1 video. 2 HEIC. |

### Products (by inventory ID)

| ID | Product | Sheet category | Variants | Price QAR | Images | Description |
|---|---|---|---|---|---|---|
| NB0001 | Arm Sleeves | ESSENTIAL | 5 colours | 25 | 5 | yes |
| NB0002 | Bamboo Jersey Hijab | HIJAB | 10 colours | 60 | 10 | yes |
| NB0003 | Sport Hijab | SPORTS WEAR | 3 colours | 70 | 6 | yes |
| NB0004 | Instant Moscrepe Hijab | INSTANT HIJAB | 10 colours (+1 image not in sheet) | 45 | 11 | yes |
| NB0005 | Instant Ruffle Chiffon Hijab | INSTANT HIJAB | 18 colours | 40 | 18 | yes |
| NB0006 | Cotton Crinkle Hijab | HIJAB | **1 row, colour "NA", price 0** | — | 38 unnamed photos | yes |
| NB0007 | Modal Hijab | HIJAB | 20 colours | 35 | 20 | yes |
| NB0008 | Pashmina Hijab | HIJAB | 8 colours | 25 | 8 | yes |
| NB0009 | Korean Chiffon Embroidered Hijab | HIJAB | 9 colours | 65 | 9 | yes |
| NB0010 | Instant Kids Hijab (Moscrepe) | INSTANT HIJAB | **1 row, price 0**, but 19 colour images | — | 23 | **no** |
| NB0011 | One Piece Jilbab | PRAYER ESSENTIAL | 5 colours | 150 | 5 | yes |
| NB0012 | Prayer Dress (silk cotton viscose) | PRAYER ESSENTIAL | **1 row, price 0** | — | **no folder, no images** | no |
| NB0013 | Hijab Cap | ESSENTIAL | 15 colours | 15 | 16 | yes |
| NB0014 | Hijab Mini Pins (box 50) | JEWELRY & ACCESSORIES | simple | 10 | 1 | yes |
| NB0015 | Hijab Pins (box 8) | JEWELRY & ACCESSORIES | 5 colourways | 10 | 5 | yes |
| NB0016 | Magnetic Hijab Pins (2-pack) | JEWELRY & ACCESSORIES | 14 (10 plain + 4 flower) | 20 | 14 | yes |
| NB0017 | Magnetic Chiffon Hijab (with cap) | INSTANT HIJAB | 15 colours | 70 | 16 | yes |
| NB0018 | Magnetic Ninja Chiffon Hijab | INSTANT HIJAB | 8 colours | 80 | 12 (dupes) | yes |
| NB0019 | Plain Chiffon Hijab | HIJAB | 31 colours | 20 | 31 | yes |
| NB0020 | Criss Cross Chiffon Hijab | INSTANT HIJAB | 15 colours | 50 | 30 (2 per colour) + 2 HEIC | yes, **EN + AR** |
| NB0021 | Prayer Mat 115×70 | PRAYER ESSENTIAL | simple | 48 | 4 unnamed | **empty file** |
| NB0022 | Tasbeeh 100 beads (9 colours) + Miswak | PRAYER ESSENTIAL | 9 + 1 | 15 / 5 | 10 | yes, EN + AR (+ miswak) |
| NB0023 | Kurti / Salwar suits / Co-ord (mixed) | MODEST WEAR | 6 rows, **3 with price 0**, sizes M/XXL | 50–75 | 15 | no |
| NB0024 | Black Niqab single / double layer | ESSENTIAL | 2 | 18 / 30 | 4 | no |
| NB0025 | Embroidered Co-ord Set | MODEST WEAR | 8 colours, free size | 120 | 22 | no |
| NB0026 | Printed Cotton Co-ord Set | MODEST WEAR | 4 colours, free size | 80 | 7 | no |
| NB0027 | Resin Quran Bookmark 4" | GIFT SET | 10 rows, **identical names** | 35 | 10 | **empty file** |
| NB0028 | Printed Signature Co-ord Set | MODEST WEAR | 5 colours × S/M/L/XL (19) | 170 | 19 | no |
| NB0029 | Linen Blend Embroidered Dress | MODEST WEAR | 8 rows, colours only in the name | 200 | 24 | no |

Image ↔ sheet match by filename (`NB0002.3 WOOD.png` → `NB0002.3`): **258 of 263 variants have a matching image**. Only NB0006, NB0010, NB0012, NB0014, NB0021 need manual mapping.

### Image facts that change the plan

1. **Every image is square (1:1)**: 1024×1024 mostly, some 1254, 2992, 3400. Not one portrait photo. The client's own request of **1:2 for garments** would crop half of every garment picture. Recommendation: switch all cards to 1:1 (or 4:5 if they want a little height), keep the CSS switch so it is a one-line change.
2. **Most photos are AI-generated** (Gemini sparkle in the bottom-right corner; one file even carries the text "AI-generated content"). Fine for a shop if the client is happy with it, but the sparkle should be cropped off (a 4% trim on the right/bottom edge removes it) and the client should know it is visible today.
3. A few are **real phone photos**: NB0028 co-ord sets (shot on a rack, **rotated 90°**), NB0006 crinkle hijabs (timestamp names), NB0021 prayer mat (WhatsApp). These need rotating and picking.
4. **Weight**: 558 MB of PNG; 70 files over 2 MB. The server disk is already full. Convert everything to JPG, 1200 px, quality 85 → roughly 40–60 MB total, then upload.
5. Duplicates: same shot as .jpg and .png (NB0018, NB0028, NB0010); two HEIC (convert); one MP4 (can be a product video on NB0028, not an image).

### Sheet facts that change the plan

- **Categories**: the sheet uses 8 categories, Sheet2 defines 12 (PREMIUM, HIJAB, INSTANT HIJAB, TURBANS, ESSENTIAL, PRAYER ESSENTIAL, KIDS, JEWELRY & ACCESSORIES, SPORTS WEAR, MODEST WEAR, GIFT SETS, SALE) with sub-groups (e.g. HIJAB → Plain Chiffon, Pashmina, Cotton Crinkle…). The live site has 11 categories copied from the reference site (Abayas & Jilbabs, Dresses, Kids…). **These must be replaced**; the nav, home category tiles and Collections page rebuild from categories automatically.
- TURBANS and SALE have no products yet; PREMIUM = Bamboo Jersey, Korean Chiffon, Modal (which are also "HIJAB"). PREMIUM reads like a tag or a second category.
- **Prices missing** (0): NB0006, NB0010, NB0012, NB0023.2, NB0023.5, NB0023.6.
- **Naming is inconsistent**: ALL CAPS, some names carry colour/size ("SPORT HIJAB - BLACK - ONE SIZE"), NB0016 mixes two products (plain vs flower magnetic pins), NB0022 mixes tasbeeh and miswak, NB0023 mixes kurti/salwar/co-ord. I will normalise to Title Case, strip colour/size from names, and split mixed IDs into separate products.
- **Sizes**: mostly ONE SIZE or a dimension ("180x70 cm"), which is an attribute for the description, not a purchasable size. Real size variants exist only on NB0028 (S–XL) and NB0023 (M/XXL).
- Contact email in Sheet2 is **shop@niswahboutique.com**; the site uses info@. Payment options list **Fawran** (Qatar instant payment) and credit card: neither is set up.
- Descriptions: 22 of 30 have one; they follow one template (intro, "Product Details" bullets, "Why You'll Love It" bullets). Missing for NB0010, 0012, 0021, 0023–0029. NB0020 and NB0022 come with Arabic.

---

## 2. Decisions needed from the client (send before building)

1. **Image ratio**: their photos are square. Go 1:1 everywhere (recommended) or 4:5? Their 1:2 request cannot work with these images.
2. **AI watermark**: crop the sparkle off (recommended), or leave the photos as they are?
3. **Missing prices**: NB0006 Cotton Crinkle, NB0010 Kids Hijab, NB0012 Prayer Dress, NB0023 rows 2/5/6.
4. **NB0006 Cotton Crinkle**: 38 photos, no colour names. Send the colour list in photo order, or we name them.
5. **NB0010 Kids Hijab**: 19 colour photos but one sheet row. Confirm it is 19 colours at one price.
6. **NB0012 Prayer Dress**: no photos. Skip until photos arrive?
7. **NB0027 bookmarks**: 10 rows with the same name. Are these 10 designs (need names) or one product with 10 photos?
8. **Categories**: confirm the 12-category structure from Sheet2 and how PREMIUM works (separate category vs. "also in"). TURBANS and SALE stay empty for now?
9. **Descriptions** for the 8 products without one: they write, or we draft in their template?
10. **Contact email**: info@ or shop@niswahboutique.com?
11. **Fawran / card**: which provider? Not part of the import, but the footer badges will only show what is enabled.
12. **Sample catalogue**: confirm the 44 niswafashion sample products get deleted at import.

---

## 3. Build plan (after decisions)

### Step A — Data build (local, ~3 h)
`build/build-client-products.mjs` reads `Products/website.xlsx` + the docx files + the image folders and writes `svpi-importer/products.json` in the shape the existing importer already understands:
- product type per ID: variable-by-colour (most), variable colour×size (NB0028, NB0023), simple (NB0014, NB0021, miswak)
- names normalised, colour/size stripped from names, mixed IDs split (NB0016 → 2 products, NB0022 → 2, NB0023 → up to 3)
- SKU = inventory ID (NB0002.3), parent SKU = NB0002
- attributes: Colour (swatch), Size only where real
- description from docx (HTML), short description = first paragraph, product details bullets kept; Arabic kept where supplied
- categories: Sheet2 taxonomy as parent/child terms; PREMIUM as an extra category on its 3 products
- validated by `build/validate-products.mjs` (duplicate SKUs, missing prices, missing images)

### Step B — Image build (local, ~2 h)
`build/build-client-images.mjs` (sharp): rotate NB0028, convert HEIC/PNG → JPG, resize to 1200 px, quality 85, crop 4% right/bottom if the watermark decision is yes, rename to `NB0002-3-wood.jpg`, drop duplicates. Output `client-products/images/` (gitignored). Target ≤ 60 MB.

### Step C — Server space (blocking)
Delete unused themes (Molti, Divi Ecommerce Pro), WP Reset and the 19 inactive plugins. Without this the image upload fails like the theme upload did on 2026-09-04.

### Step D — Upload + import (~2 h, mostly waiting)
1. Trash the 44 sample products (reversible).
2. Upload the JPGs to the Media Library in batches through the browser (REST, 20 at a time).
3. Rewrite the categories: delete the 11 reference categories, create the Sheet2 tree.
4. WooCommerce → Import Products (SVPI) with `products.json`; re-run until counts match (263 variants).
5. Niswah Starter → Import Everything: rebuilds nav from the new categories, backfills category images, refreshes home.

### Step E — Theme adjustments (~2 h)
- Image ratio per decision 1 (`class-nb-image-ratios.php` category list, or one CSS value).
- Category tiles on home: 12 categories instead of 3 tiles; pick 3 for the tiles, rest on Collections.
- Home "Shop New Arrivals" featured trio: star 3 products.
- Footer email/Fawran/TikTok per decisions 10–11.
- Arabic: product names and descriptions through TranslatePress (client's Google key, or hand-translated from the template since 22 descriptions share one structure).

### Step F — QA + handover (~1 h)
Every product page opened once in EN and AR, swatches work, prices right, add to cart on a colour×size product, category counts match the sheet. Update status log, delivery note, client message.

---

## 4. Estimate

About 10–12 hours of work once the decisions are in, spread over two sessions because the SVPI import and image uploads are wait-heavy. Blocking today: the server disk.
