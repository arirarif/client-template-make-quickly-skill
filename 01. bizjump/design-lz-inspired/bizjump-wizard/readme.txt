=== BizJump Wizard ===
Contributors: bizjumpdev
Tags: incorporation, woocommerce, wizard, business formation, llc
Requires at least: 6.0
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later

A guided 6-step incorporation wizard that integrates with WooCommerce for cart creation, checkout, and order tracking.

== Description ==

BizJump Wizard adds the [bizjump_wizard] shortcode that renders a full 6-step business formation wizard on any page.

**Steps:**
1. Entity Type (LLC, C-Corp, S-Corp, Non-Profit)
2. State Selection with live filing fee display
3. Plan Comparison (Basic $99 / Pro $195 / Premium $295 / Enterprise $295+$29/mo)
4. Add-On Services (14 conditional add-ons)
5. Business Details (name, address, contact, SMS consent)
6. Review & Checkout (AJAX cart bridge to WooCommerce)

**WooCommerce Integration:**
- State filing fee added as a cart fee (not a product)
- Wizard data stored in order meta
- Admin order screen shows full formation details
- My Account includes "My Formation" tab

== Installation ==

1. Upload the `bizjump-wizard` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu
3. Add `[bizjump_wizard]` to your Incorporation page
4. Flush rewrite rules: Settings → Permalinks → Save

== Changelog ==

= 1.0.0 =
* Initial release
