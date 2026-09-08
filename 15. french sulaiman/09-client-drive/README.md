# 09-client-drive — intake for Sulayman's Google Drive folder

**Status on 2026-09-08: EMPTY. The folder has not arrived yet.**
Checked Google Drive (`sharedWithMe = true`, plus title searches for
noor / festivities / arche / sulayman) — nothing from him is shared with us.
That matches his own words on 05/09: *"I put everything in a drive folder
**I will transfer you** the folder in cha Allah"* — future tense.

Do not start the import work until something lands here.

---

## Where things go

| Folder | What belongs in it |
|---|---|
| `_original-untouched/` | **Exact copies as received.** Never edit, never delete. If an import goes wrong, this is what you re-derive from. |
| `01-photos-produits/` | Main catalogue photos, processed (see pipeline below) |
| `02-photos-accessoires-location/` | Rental accessory photos — the ones he said on 05/09 he was still missing |
| `03-descriptions-prix/` | Descriptions, price lists, any CSV export he sends |
| `04-hero-accueil/` | The bright wide homepage photo. **Its own folder because it is the single most important image on the site** — see the workflow §9.7 |

---

## Intake procedure, in order

1. **Copy everything into `_original-untouched/` first, before touching anything.**
   Then work only on copies. His source files can be 76–86 MB
   (`noor_brand_assets`), and there is no second chance if one is overwritten.

2. **Inventory before processing.** Write `03-descriptions-prix/INVENTORY.md`:
   one row per file — filename, what product it belongs to, whether it is a
   main photo or an accessory, and anything missing. Half the work is finding
   out what he did *not* send.

3. **Never upload a raw file to WordPress.** Process every image:
   - strip EXIF (his phone photos will carry GPS)
   - one consistent aspect ratio per role (catalogue square, hero wide)
   - resize to a sane max width — 2000px hero, 1200px catalogue
   - convert to WebP
   - name it `noor-<category>-<slug>.webp`, lowercase, no spaces, no accents

4. **Check the light skin still holds.** The whole site is now white
   (v3.21.0), so photos carry all the colour. A dark photo will undo the
   POINT 0 fix visually even though the CSS is correct. Re-run the surface
   measurement in the workflow §9.1 after swapping the hero.

5. **Products:** prefer WooCommerce's **native CSV importer** over
   `08 products/svpi-importer` — SVPI was built for demo seeding, the native
   importer resolves image URLs and handles re-imports. Dry-run 3 rows first.

6. **Set `noor_region` on every imported product**, or Réunion-only stock will
   appear in the France catalogue. Meta key is in `inc/region.php`.

7. **Rental options:** each accessory he names becomes a normal simple product,
   then gets ticked into the arch's **Linked Products → Upsells**. That is all
   — `inc/rental-options.php` picks it up automatically. Set its
   *Tarif en option de location* dropdown (`flat` by default) only if he has
   answered "par jour".

---

## What we are still waiting on from him

From `CLIENT-MESSAGES-2026-09.md` §6:

- **A6** option names + prices + photos (drapés, fleurs, …)
- **A10** main product photos + descriptions — he said these are ready
- **A11** accessory photos for the rentals — **he flagged this as missing himself**
- **A12** the Drive folder transfer
- **A8** the copyright line, and e-mail access (or Brevo go-ahead)
- Plus the one thing we asked for on top: **a bright, wide hero photo**

He is under no time pressure — he said *"no problem take your time"* — so
chase at most once every 24–36h, per `client_sulayman`.
