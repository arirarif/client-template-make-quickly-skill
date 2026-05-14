# BizJump Wizard — Plugin Usage Guide

A self-serve incorporation wizard for WordPress + WooCommerce. Mirrors the Bizee-style flow: hero → 14-step wizard → WC checkout.

---

## 1. Install + Activate

### Option A — Upload via wp-admin

1. Zip the entire `wp-plugin/` folder (so the zip's root contains `bizjump-wizard.php`).
2. Rename the zip to `bizjump-wizard.zip` (optional — folder name on disk will become the plugin slug).
3. wp-admin → **Plugins → Add New → Upload Plugin** → choose the zip → **Install Now** → **Activate**.

### Option B — Upload via FTP / cPanel File Manager

1. Upload the `wp-plugin/` folder contents into `wp-content/plugins/bizjump-wizard/` (folder name is your choice but must be unique).
2. wp-admin → **Plugins** → find **BizJump Wizard** → **Activate**.

### What happens on activation

- A page titled **Incorporation** (slug `/incorporation/`) is auto-created with the `[bizjump_wizard]` shortcode if one doesn't already exist.
- If WooCommerce is active, the plugin auto-creates hidden WC products:
  - **Plan tier products** — SKUs `bjw-plan-basic`, `bjw-plan-pro`, `bjw-plan-premium`
  - **Add-on products** — SKUs `bjw-addon-<addon-id>` (e.g. `bjw-addon-ein`, `bjw-addon-oa`)
  These products are virtual + hidden from the shop. They exist so WC can charge the customer; you should never edit their names/prices manually (use the data files in `includes/` instead).
- Rewrite rules are flushed.

Re-activating is **idempotent** — existing pages and products are skipped.

---

## 2. Embedding the Wizard

### Default: visit `/incorporation/`

After activation, the wizard is live at:
```
https://your-site.com/incorporation/
```

### Embed elsewhere

Drop the shortcode into any page, post, or block:
```
[bizjump_wizard]
```

Assets (CSS + JS) only load on pages where the shortcode is present — no global bloat.

### Embed with a specific starting step (future)

```
[bizjump_wizard step="2"]
```
Currently the `step` attribute is accepted but the JS always starts at Step 1 (Package). Hook for future deep-linking.

---

## 3. End-User Flow

1. **Hero** — pick entity (LLC / C-Corp / S-Corp / Nonprofit) + state → see live filing fee → click **Start My Business**.
2. **Step 1 — Package** — Basic $99 / Pro $195 / Premium $395 (Recommended). Entity-aware add-ons appear.
3. **Step 2 — Business Name** — name, designator (suffix dropdown depends on entity), business purpose, NAICS industry.
4. **Step 3 — Filing Time** — Standard ($0) or Expedited (per-state, e.g. CA $385, WY $35).
5. **Step 4 — Contact** — name, email, phone, full address. Validated; **Next** stays disabled until valid.
6. **Step 5 — Company Address** — Virtual Address ($29/mo after 1st free month) or own address. "Same as Contact person" checkbox is **checked by default** and prefills + disables the fields.
7. **Step 6 — Premium Bundle** — auto-skipped if user already chose the Premium plan.
8. **Step 7 — Members** — add LLC/Corp members.
9. **Step 8 — Registered Agent** — BizJump (1st year free) or self.
10. **Step 9 — EIN** — SSN/ITIN entry for IRS filing.
11. **Step 10 — Banking** — Relay banking partner offer.
12. **Step 11 — Tax Consultation** — free 30-min CPA call offer.
13. **Step 12 — Business License Research** — $99 add-on offer.
14. **Step 13 — Order Summary** — review all selections; each section has an **Edit** link that jumps back to that step.
15. **Step 14 — Billing & Payment** — agree to terms → click **Complete Purchase**:
    - **If WooCommerce is active:** the plugin builds the cart server-side (plan + addons as products, state fee + expedited as cart-level fees), redirects to the WC checkout with all billing fields prefilled from Step 4.
    - **If WooCommerce is not active:** redirects to a thank-you page with a lead ID. Submission is logged in wp-admin.
16. **Step 15 — Confirmation** — order number + summary (standalone fallback only; WC users see the WC order-received page instead).

---

## 4. wp-admin Pages

Top-level menu: **BizJump Wizard** (clipboard icon, position 58 in the sidebar).

### Submissions
- Lists the **last 200** wizard submissions
- Columns: ID, Created, Name, Email, Business, Entity, State, Plan, State Fee
- Use to follow up on leads even when no WC order was placed

### State Fee Overrides
- One row per state, four columns: LLC / Corp / Nonprofit / Expedited
- Leave a cell blank to use the default from `data-state-fees.php`
- Saved values are stored under `wp_options.bjw_fee_overrides`
- Note: as of v4.0 the JS still reads the **default** table; overrides currently only affect server-side recompute on submission. Frontend-override sync is a future enhancement.

---

## 5. Customizing Data

All data lives in `includes/data-*.php` files. Edit and re-upload — no migration needed, just refresh the page.

### Plans (`includes/data-plans.php`)
```php
'pro' => [
    'key'         => 'pro',
    'label'       => 'Pro',
    'price'       => 195.00,
    'speed'       => '2 days',
    'recommended' => false,
    'description' => '...',
],
```
Change `price` or `speed` here → reflected on Step 1 instantly.

### Add-ons (`includes/data-addons.php`)
Each addon has:
- `id` — unique key (also forms the SKU: `bjw-addon-<id>`)
- `section` — `'corporate'` | `'taxes'` | `'web'`
- `label`, `desc` — UI text
- `price` — `[ 'basic' => 25, 'pro' => 'included', 'premium' => 'included' ]`
  - integer → +$N button
  - `'included'` → ✓ checkmark
  - `'99/year'` → display chip "+$99/year"
  - `'free+29mo'` → display chip "Free setup + $29/mo"
- `entities` — `'all'` or array like `[ 'LLC' ]` / `[ 'S-Corporation' ]` to hide for other entity types

After editing, re-activate the plugin (or manually create a WC product with SKU `bjw-addon-<your-id>`) to enable purchasing.

### State Fees (`includes/data-state-fees.php`)
Per-state rows:
```php
'New York' => [ 'llc' => 200, 'corp' => 125, 'nonprofit' => 75, 'expedited' => 60 ],
```
Or override at runtime via the admin **State Fee Overrides** page.

### Designators (`includes/data-designators.php`)
```php
'LLC' => [ 'LLC', 'LIMITED LIABILITY COMPANY' ],
'C-Corporation' => [ 'INC', 'CORPORATION', 'INCORPORATED', 'CORP' ],
```

---

## 6. Customizing Design

All styles live in `assets/wizard.css`. The top of the file defines CSS custom properties — change these to re-skin without touching individual rules:

```css
:root {
  --bz-orange: #FF6B35;          /* primary accent */
  --bz-orange-hover: #E5552A;
  --bz-orange-light: #FFF1EB;    /* hover backgrounds */
  --bz-black: #1A1A1A;
  --bz-g900: #2D2D2D; --bz-g600: #666; --bz-g400: #999;
  --bz-g200: #E5E5E5; --bz-g100: #F5F5F5;
  --font: 'Inter', ...;
  --radius-md: 8px; --radius-lg: 12px;
}
```

After editing, bump `BJW_VERSION` in `bizjump-wizard.php` so browsers fetch the new file (asset URLs are cache-busted by version).

---

## 7. WooCommerce Integration Details

### Cart structure on checkout
When the user clicks **Complete Purchase**:

| Line | Source | Type |
|---|---|---|
| BizJump Pro Plan | `bjw-plan-pro` product | WC line item |
| EIN Business Tax Number | `bjw-addon-ein` product | WC line item |
| Operating Agreement | `bjw-addon-oa` product | WC line item |
| New York State Filing Fee | `BJW_WC_Hooks::add_state_fees` | Cart fee |
| Expedited Filing | `BJW_WC_Hooks::add_state_fees` | Cart fee (if rush selected) |

State fee + expedited are added as **cart fees** (not products) so they vary correctly by state and entity without spawning hundreds of product variants.

### Order meta
After checkout, every WC order has a custom meta field `_bjw_wizard_state` containing the full JSON snapshot of the user's wizard answers. Useful for:
- Customer-service lookup (what did they actually select?)
- Reconciling with the audit log under `wp_options.bjw_submissions`
- Future analytics / reporting

Read it like:
```php
$state = json_decode( $order->get_meta( '_bjw_wizard_state' ), true );
```

### Checkout billing prefill
On the WC checkout page, billing fields auto-populate from Step 4 (Contact):
- `billing_first_name`, `billing_last_name`, `billing_email`, `billing_phone`
- `billing_address_1`, `billing_address_2`, `billing_city`, `billing_state`, `billing_postcode`, `billing_country`

Users can still edit them — the prefill only kicks in if the field is empty.

---

## 8. Without WooCommerce

The plugin gracefully falls back if WC isn't installed:
- The wizard still renders fully (CSS/JS unaffected)
- Submissions are still validated and logged to wp-admin
- The final step redirects to `/incorporation/?thanks=BJ-XXXXXXXX` instead of a WC checkout
- You can still capture leads, just no payment

To enable payment later, install + activate WooCommerce, then **deactivate + reactivate** BizJump Wizard so the installer creates the missing products.

---

## 9. File Structure Reference

```
wp-plugin/
├── bizjump-wizard.php              ← main entry, header, constants, requires
├── README.md                        ← this file
├── assets/
│   ├── wizard.css                  ← all styles
│   └── wizard.js                   ← all behaviour
├── includes/
│   ├── data-state-fees.php         ← BJW_State_Fees (50 states + DC)
│   ├── data-plans.php              ← BJW_Plans (3 tiers)
│   ├── data-addons.php             ← BJW_Addons (17 items)
│   ├── data-designators.php        ← BJW_Designators
│   ├── shortcode.php               ← BJW_Shortcode (render + enqueue + localize)
│   ├── ajax-handlers.php           ← BJW_Ajax_Handlers (POST /wp-admin/admin-ajax.php?action=bjw_submit)
│   ├── wc-hooks.php                ← BJW_WC_Hooks (cart build, fees, order meta)
│   ├── checkout-prefill.php        ← BJW_Checkout_Prefill
│   ├── class-installer.php         ← BJW_Installer (page + WC products on activate)
│   └── class-admin.php             ← BJW_Admin (Submissions + Fee Overrides UI)
└── templates/
    └── wizard.php                  ← full 15-step markup
```

---

## 10. Troubleshooting

### "Cannot declare class BJW_State_Fees, because the name is already in use"
You have a duplicate copy of the plugin folder under `wp-content/plugins/`. Look for any other `*wizard*` or `*bizjump*` folder besides `bizjump-wizard/` and delete it. Every class is guarded with `if (!class_exists())`, but two folders trying to declare the same class are still a conflict at the file-load level for older PHP — clean up the duplicate.

### "Plugin could not be activated because it triggered a fatal error"
Visit `wp-admin/plugins.php?action=error_scrape&plugin=bizjump-wizard/bizjump-wizard.php` directly to see the real error text inside the iframe.

### Wizard renders but state fees show $0
Likely the JS can't read `window.BJW_DATA`. Check:
- The page actually contains the `[bizjump_wizard]` shortcode (asset enqueue is gated on `has_shortcode`).
- Browser devtools → Sources → look for `wizard.js` loaded; type `BJW_DATA` in console; you should see the object with `states`, `plans`, `addons` etc.

### WC checkout missing some line items
- Did the installer create the products? wp-admin → Products → search for SKU `bjw-plan-` → should see Basic / Pro / Premium.
- Each addon needs a matching product with SKU `bjw-addon-<id>`. If you added a new addon to `data-addons.php`, re-activate the plugin so the installer creates the WC product.

### Submissions log is empty
- Submissions are only written when the **Pay** button on Step 14 is clicked AND the WordPress AJAX endpoint accepts the POST.
- The endpoint requires a valid nonce (auto-generated). If you're testing across domains or with aggressive caching, the nonce may be stale — hard-refresh the page.

### Want to clear all submissions
```php
delete_option( 'bjw_submissions' );
```
Drop into your child theme's `functions.php` once, hit the site, then remove the line.

---

## 11. Updating the Plugin

1. Replace the plugin folder on disk with the new version.
2. Bump `BJW_VERSION` in `bizjump-wizard.php` (forces browsers to fetch the new CSS/JS).
3. wp-admin → **Plugins** → **Deactivate** → **Activate** to re-run the installer (idempotent — no data loss).

No database migration needed; all state lives in `wp_options` (`bjw_submissions`, `bjw_fee_overrides`) and WC.

---

## 12. Uninstalling

The plugin currently does **not** delete its data on uninstall (this is safer for accidental deactivations). To fully remove:

```php
// Run once via WP-CLI or a one-off action:
delete_option( 'bjw_submissions' );
delete_option( 'bjw_fee_overrides' );

// Then delete the WC products with SKU prefix bjw-plan-* and bjw-addon-*:
$products = wc_get_products( [ 'limit' => -1 ] );
foreach ( $products as $p ) {
    $sku = $p->get_sku();
    if ( str_starts_with( $sku, 'bjw-plan-' ) || str_starts_with( $sku, 'bjw-addon-' ) ) {
        $p->delete( true );
    }
}

// Delete the /incorporation/ page if you want:
$page = get_page_by_path( 'incorporation' );
if ( $page ) wp_delete_post( $page->ID, true );
```

---

## Quick Reference Card

| Want to... | Edit this file |
|---|---|
| Change plan prices/names/speeds | `includes/data-plans.php` |
| Add/remove an add-on | `includes/data-addons.php` |
| Adjust state filing fees | `includes/data-state-fees.php` OR wp-admin → BizJump Wizard → State Fee Overrides |
| Change entity-allowed suffixes (LLC/INC) | `includes/data-designators.php` |
| Restyle the wizard | `assets/wizard.css` (top has CSS variables) |
| Modify the markup | `templates/wizard.php` |
| Change validation rules | `includes/ajax-handlers.php` → `validate()` |
| Change what gets added to the WC cart | `includes/wc-hooks.php` → `build_cart_from_wizard()` |
| Add admin reporting | `includes/class-admin.php` |

— BizJump Wizard v4.0






  Covers:

  1. Install + Activate — both upload methods + what happens on activation (page
  + WC products auto-created, idempotent)
  2. Embedding the Wizard — default /incorporation/ URL + [bizjump_wizard]
  shortcode anywhere
  3. End-User Flow — what the customer sees at each of the 15 steps
  4. wp-admin Pages — Submissions log (last 200) + State Fee Overrides UI
  5. Customizing Data — exact file + struct for plans, addons, state fees,
  designators (with field-by-field reference)
  6. Customizing Design — CSS custom properties at the top of wizard.css to
  re-skin
  7. WC Integration Details — what gets added as line items vs cart fees, where
  the wizard snapshot lives on the order, billing prefill behavior
  8. Without WooCommerce — graceful fallback (still captures leads)
  9. File Structure Reference — annotated tree
  10. Troubleshooting — duplicate-class fatal, error_scrape URL trick, $0 fees,
  missing line items, empty submission log
  11. Updating — version-bump cache busting + idempotent re-activate
  12. Uninstalling — snippet to fully wipe data

  The last section is a Quick Reference Card — a "want to X → edit Y" table for
  finding the right file fast.

  Want me to also generate:
  - A one-page cheat sheet PDF/MD for the client?
  - A CHANGELOG.md documenting the v3 → v4 migration?
  - An inline admin help tab (the contextual "?" panel in wp-admin) so this
  README is reachable from inside WordPress?