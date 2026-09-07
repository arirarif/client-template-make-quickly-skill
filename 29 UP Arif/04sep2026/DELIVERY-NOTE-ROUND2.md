# Round 2 delivery — Niswah Boutique

**Site:** niswahboutique.com · **Theme:** Niswah Boutique (Divi child) **v0.16.1** · **Delivered:** 2026-09-04, catalogue 2026-09-07
Responds to your feedback document and chat of 2026-09-04.

---

## Done, item by item

| # | Your ask | What is live |
|---|----------|--------------|
| 1 | Bigger logo | Header logo 84px tall (was 56), 52px on phones. |
| 2 | Ribbon + footer #891109 | Ticker bar and footer are #891109. |
| 3 | Background #FAF2E6 | Page background and all home sections are #FAF2E6; the trust-badge band is white for contrast. |
| 4 | Buttons #891109 / #FAF2E6 | Every button: home CTAs, product cards, Add to cart, cart Check out now, Place order. |
| 5 | Fonts unchanged | Marcellus + Jost kept. Cairo is used when the site is in Arabic. |
| 6 | Image ratio | All cards are 1:1 since 2026-09-07: every photo you supplied is square, and a 1:2 frame would crop half of each garment. See note A. |
| 7 | EN / AR switcher | "EN \| AR" in the top ribbon on every page and device. Arabic pages are right-to-left with mirrored layout, Arabic fonts and Arabic prices. Menus, header, footer, buttons, checkout and policy page titles are translated. See note B. |
| 8 | About Us | /about-us/ page (draft copy for you to edit), linked in the main menu and footer. |
| 9 | Payment methods shown | "We accept" badges in the footer, under Add to cart and above the payment options at checkout. They list whatever is enabled in WooCommerce, so they update themselves when you add a card gateway. |
| 10 | Social | Footer: "Follow Us" with @boutiqueniswah, Facebook, Instagram, YouTube (https links) and a WhatsApp link. |
| 11 | VAT / tax | Qatar has no VAT in force, so prices carry the line "Prices in QAR, inclusive of applicable taxes" on product pages, cart, checkout and footer. If VAT is introduced, it is a WooCommerce setting, no rebuild needed. |
| 12 | Qatar address at checkout | Zone, Street No. / Name, Building No., Unit / Flat No., Area / City. State and Postcode removed. Phone is now required. Orders, emails and the admin print the address as "Zone 25, Street 850 / Building 12, Unit 4 / Doha". Tested with a real order. |
| 13 | Footer contents | About Us, Contact, Size Chart, Collections, Shipping & Delivery, Returns & Refunds, FAQs, Privacy Policy, Terms & Conditions, social, payment badges. Every link works (no more 404s). |
| 14 | Legal pages | Returns & Exchanges Policy: your text, word for word. Shipping & Delivery, Terms & Conditions, Privacy Policy (Qatar Law 13/2016), About Us, Contact, Size Chart: drafts for you to review. FAQs: placeholder until you send the content. |
| — | Payments for testing | Cash on Delivery and Direct Bank Transfer are enabled so orders can be placed. |

## Notes

**A. Image ratio.** Your photos are square, so cards and the product gallery are square. If you later shoot portrait photos, switching garments to 2:3 or 1:2 is a one-line change.

**B. Arabic.** The site chrome is translated by hand. Product names and descriptions are still English because automatic translation needs a Google Translate or DeepL API key on your account (TranslatePress → Automatic Translation). Send the key and they translate themselves; or you can translate any string by hand from the "Translate Site" button in the admin bar.

**C. Drafts to review.** Shipping times and fees, size-chart measurements, About Us story, Terms and Privacy wording are placeholders written to be plausible for Qatar. Please read them once with your adviser and edit in Pages → Edit.

## Catalogue — added 2026-09-07

Your products are live: **27 products, 241 colour/size options**, with your own photos (391, watermark trimmed), colour swatches, and your category structure (Premium, Hijab, Instant Hijab, Essential, Prayer Essential, Jewelry & Accessories, Sports Wear, Modest Wear) as a dropdown menu. The sample catalogue is gone. All product cards are square because every photo you supplied is square.

Six products wait for your answers (see the questions I sent): Cotton Crinkle Hijab, Kids Hijab, Prayer Dress, the Salwar Suit Set rows, the Co-ord Set, and the Quran Bookmarks. They are prepared and go live the day you reply.

## Still needs you

1. **Products.** Answers to the six open product questions (prices, colour names, bookmark designs, prayer-dress photos).
2. **Card payment provider** (QPay, Sadad, Skipcash, Dibsy, Tap, MyFatoorah…) and its merchant account, when you are ready.
3. **Google / DeepL key** if you want product text in Arabic automatically.
4. **FAQ text** whenever it is ready.
5. **Server cleanup** is done: unused themes, WP Reset and 16 inactive plugins removed.

## How to update the site

Appearance → Add Theme → Upload → Replace installed with uploaded, then Appearance → Niswah Starter → Import Everything. The second step writes the layouts and pages into the database; without it nothing changes on screen.
