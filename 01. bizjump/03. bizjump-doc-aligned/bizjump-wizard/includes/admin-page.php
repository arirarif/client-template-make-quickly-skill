<?php
/**
 * BizJump Wizard — Admin Documentation & Settings Page
 *
 * Adds a "BizJump Wizard" top-level menu in WordPress Admin.
 * Provides full end-to-end setup instructions and plugin reference.
 *
 * Access: WP Admin → BizJump Wizard (left sidebar)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── Register admin menu ───────────────────────────────────────────────────────
add_action( 'admin_menu', 'bjw_register_admin_menu' );

function bjw_register_admin_menu(): void {
    add_menu_page(
        'BizJump Wizard',           // Page title
        'BizJump Wizard',           // Menu label
        'manage_options',           // Capability required
        'bizjump-wizard',           // Menu slug
        'bjw_render_admin_page',    // Callback
        'dashicons-businessman',    // Icon
        56                          // Position (below WooCommerce)
    );

    add_submenu_page(
        'bizjump-wizard',
        'Setup Guide',
        'Setup Guide',
        'manage_options',
        'bizjump-wizard',
        'bjw_render_admin_page'
    );

    add_submenu_page(
        'bizjump-wizard',
        'Product Keys',
        'Product Keys',
        'manage_options',
        'bizjump-wizard-products',
        'bjw_render_products_page'
    );

    add_submenu_page(
        'bizjump-wizard',
        'Recreate Products',
        'Recreate Products',
        'manage_options',
        'bizjump-wizard-recreate',
        'bjw_render_recreate_page'
    );
}

// ── Admin page styles (inline, no extra file needed) ─────────────────────────
add_action( 'admin_head', 'bjw_admin_styles' );

function bjw_admin_styles(): void {
    $screen = get_current_screen();
    if ( ! $screen || strpos( $screen->id, 'bizjump-wizard' ) === false ) return;
    ?>
    <style>
        .bjw-doc-wrap { max-width: 960px; }
        .bjw-doc-wrap h1 { color: #1e3a8a; font-size: 24px; margin-bottom: 4px; }
        .bjw-doc-wrap .bjw-version { color: #64748b; font-size: 13px; margin-bottom: 32px; display:block; }
        .bjw-section { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px 28px; margin-bottom: 24px; }
        .bjw-section h2 { color: #1e3a8a; font-size: 17px; margin: 0 0 16px; border-bottom: 2px solid #eff6ff; padding-bottom: 10px; }
        .bjw-section h3 { color: #1e293b; font-size: 14px; font-weight: 700; margin: 20px 0 8px; }
        .bjw-section p, .bjw-section li { font-size: 13px; line-height: 1.7; color: #334155; }
        .bjw-section ul, .bjw-section ol { padding-left: 20px; margin: 0 0 12px; }
        .bjw-section li { margin-bottom: 6px; }
        .bjw-code { background: #1e293b; color: #e2e8f0; font-family: monospace; font-size: 13px; padding: 12px 16px; border-radius: 6px; display: block; margin: 10px 0; word-break: break-all; }
        .bjw-badge { display: inline-block; padding: 2px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; margin-left: 8px; }
        .bjw-badge-blue  { background: #eff6ff; color: #1e3a8a; }
        .bjw-badge-green { background: #f0fdf4; color: #15803d; }
        .bjw-badge-orange{ background: #fff7ed; color: #c2410c; }
        .bjw-badge-red   { background: #fef2f2; color: #dc2626; }
        .bjw-table { width: 100%; border-collapse: collapse; font-size: 13px; margin-top: 12px; }
        .bjw-table th { background: #f1f5f9; color: #1e3a8a; padding: 8px 12px; text-align: left; border: 1px solid #e2e8f0; font-weight: 700; }
        .bjw-table td { padding: 8px 12px; border: 1px solid #e2e8f0; color: #334155; vertical-align: top; }
        .bjw-table tr:hover td { background: #f8fafc; }
        .bjw-alert { border-left: 4px solid #2563eb; background: #eff6ff; padding: 12px 16px; border-radius: 0 6px 6px 0; margin: 12px 0; font-size: 13px; color: #1e3a8a; }
        .bjw-alert-warn { border-color: #f97316; background: #fff7ed; color: #9a3412; }
        .bjw-alert-ok   { border-color: #16a34a; background: #f0fdf4; color: #14532d; }
        .bjw-steps-list { counter-reset: bjw-step; list-style: none; padding: 0; }
        .bjw-steps-list li { counter-increment: bjw-step; padding: 10px 10px 10px 44px; position: relative; border-bottom: 1px solid #f1f5f9; }
        .bjw-steps-list li::before { content: counter(bjw-step); position: absolute; left: 0; top: 10px; width: 28px; height: 28px; background: #1e3a8a; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; line-height: 28px; text-align: center; }
        .bjw-status-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 12px; }
        .bjw-status-card { border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 16px; }
        .bjw-status-card .label { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .5px; }
        .bjw-status-card .value { font-size: 15px; font-weight: 700; color: #1e3a8a; margin-top: 4px; }
        .bjw-status-card.ok .value { color: #16a34a; }
        .bjw-status-card.warn .value { color: #f97316; }
        .bjw-status-card.error .value { color: #dc2626; }
        .bjw-nav-tabs { display: flex; gap: 0; border-bottom: 2px solid #e2e8f0; margin-bottom: 24px; }
        .bjw-nav-tabs a { padding: 10px 20px; font-size: 13px; font-weight: 600; color: #64748b; text-decoration: none; border-bottom: 3px solid transparent; margin-bottom: -2px; }
        .bjw-nav-tabs a:hover { color: #1e3a8a; }
        .bjw-nav-tabs a.active { color: #1e3a8a; border-bottom-color: #2563eb; }
    </style>
    <?php
}

/* ══════════════════════════════════════════════════════════════════════════════
   MAIN SETUP GUIDE PAGE
══════════════════════════════════════════════════════════════════════════════ */
function bjw_render_admin_page(): void {
    $wc_active     = class_exists( 'WooCommerce' );
    $wc_subs       = class_exists( 'WC_Subscriptions' );
    $permalinks_ok = (bool) get_option( 'permalink_structure' );
    $products_ok   = bjw_count_wizard_products() > 0;

    ?>
    <div class="wrap bjw-doc-wrap">

        <h1>BizJump Wizard <span class="bjw-badge bjw-badge-blue">v<?php echo esc_html( BJW_VERSION ); ?></span></h1>
        <span class="bjw-version">6-step incorporation wizard → WooCommerce checkout</span>

        <div class="bjw-nav-tabs">
            <a href="?page=bizjump-wizard" class="active">Setup Guide</a>
            <a href="?page=bizjump-wizard-products">Product Keys</a>
            <a href="?page=bizjump-wizard-recreate">Recreate Products</a>
        </div>

        <!-- ── System Status ─────────────────────────────────────────── -->
        <div class="bjw-section">
            <h2>⚡ System Status</h2>
            <div class="bjw-status-grid">

                <div class="bjw-status-card <?php echo $wc_active ? 'ok' : 'error'; ?>">
                    <div class="label">WooCommerce</div>
                    <div class="value"><?php echo $wc_active ? '✓ Active' : '✗ Not Found'; ?></div>
                </div>

                <div class="bjw-status-card <?php echo $wc_subs ? 'ok' : 'warn'; ?>">
                    <div class="label">WC Subscriptions</div>
                    <div class="value"><?php echo $wc_subs ? '✓ Active' : '⚠ Not Active'; ?></div>
                </div>

                <div class="bjw-status-card <?php echo $permalinks_ok ? 'ok' : 'error'; ?>">
                    <div class="label">Pretty Permalinks</div>
                    <div class="value"><?php echo $permalinks_ok ? '✓ Enabled' : '✗ Disabled'; ?></div>
                </div>

                <div class="bjw-status-card <?php echo $products_ok ? 'ok' : 'warn'; ?>">
                    <div class="label">WC Products Created</div>
                    <div class="value"><?php echo $products_ok ? '✓ Found (' . esc_html( bjw_count_wizard_products() ) . ')' : '⚠ 0 Found'; ?></div>
                </div>

                <div class="bjw-status-card ok">
                    <div class="label">PHP Version</div>
                    <div class="value">✓ <?php echo esc_html( PHP_VERSION ); ?></div>
                </div>

                <div class="bjw-status-card ok">
                    <div class="label">Plugin Version</div>
                    <div class="value"><?php echo esc_html( BJW_VERSION ); ?></div>
                </div>

            </div>

            <?php if ( ! $wc_active ) : ?>
            <div class="bjw-alert bjw-alert-warn" style="margin-top:16px;">
                ⚠ <strong>WooCommerce is not active.</strong> This plugin requires WooCommerce. Please install and activate it first.
            </div>
            <?php endif; ?>

            <?php if ( ! $wc_subs ) : ?>
            <div class="bjw-alert" style="margin-top:12px;">
                ℹ <strong>WooCommerce Subscriptions not detected.</strong> Subscription-based add-ons (Registered Agent $99/yr, Corporate Website $29/mo, Enterprise $29/mo) require the WooCommerce Subscriptions plugin.
            </div>
            <?php endif; ?>

            <?php if ( ! $permalinks_ok ) : ?>
            <div class="bjw-alert bjw-alert-warn" style="margin-top:12px;">
                ⚠ <strong>Permalinks are not set.</strong> Go to <a href="<?php echo esc_url( admin_url( 'options-permalink.php' ) ); ?>">Settings → Permalinks</a> and save to enable the "My Formation" dashboard tab.
            </div>
            <?php endif; ?>
        </div>

        <!-- ── Quick Start ───────────────────────────────────────────── -->
        <div class="bjw-section">
            <h2>🚀 Quick Start — Complete Setup (5 Steps)</h2>

            <ol class="bjw-steps-list">
                <li>
                    <strong>Activate WooCommerce first</strong><br>
                    Go to <em>Plugins → Installed Plugins</em> and make sure WooCommerce is Active.
                    The wizard will not work without it.
                </li>
                <li>
                    <strong>Activate this plugin</strong><br>
                    Go to <em>Plugins → Installed Plugins → BizJump Wizard → Activate</em>.
                    On first activation it automatically creates all hidden WooCommerce products
                    (4 plans + 14 add-ons = 18 products total).
                    <br><br>
                    If products were <em>not</em> created (WooCommerce wasn't active yet), go to
                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=bizjump-wizard-recreate' ) ); ?>">BizJump Wizard → Recreate Products</a>
                    and click the button.
                </li>
                <li>
                    <strong>Create the Incorporation page</strong><br>
                    Go to <em>Pages → Add New</em>. Title it <strong>Incorporate</strong>.
                    Set the URL slug to <code>/incorporate/</code>.
                    In the page content, add the shortcode:<br>
                    <code class="bjw-code">[bizjump_wizard]</code>
                    Publish the page.
                </li>
                <li>
                    <strong>Flush permalinks</strong><br>
                    Go to <em>Settings → Permalinks</em> → click <strong>Save Changes</strong> (no changes needed, just save).
                    This registers the "My Formation" tab on the WooCommerce My Account page.
                </li>
                <li>
                    <strong>Configure payment gateways</strong><br>
                    Go to <em>WooCommerce → Settings → Payments</em> and enable Stripe, PayPal, and/or ACH.
                    The wizard sends users to the standard WooCommerce checkout — all payment methods work automatically.
                </li>
            </ol>

            <div class="bjw-alert bjw-alert-ok" style="margin-top:16px;">
                ✅ That's it! Visit <code>/incorporate/</code> to see the wizard live.
            </div>
        </div>

        <!-- ── How the Wizard Works ──────────────────────────────────── -->
        <div class="bjw-section">
            <h2>🧭 How the Wizard Works — End to End</h2>

            <p>The wizard is a single-page, 6-step form. All steps exist in the HTML at once — JavaScript controls which step is visible. No page reloads happen until the final checkout redirect.</p>

            <h3>Step 1 — Entity Type</h3>
            <p>User picks one of four entity types. This choice controls which add-ons appear in Step 4:</p>
            <ul>
                <li><strong>LLC</strong> — shows Operating Agreement, IRS Form 2553</li>
                <li><strong>C-Corp</strong> — shows Corporate Bylaws, Shareholder Agreement, Form 2553</li>
                <li><strong>S-Corp</strong> — shows Corporate Bylaws, Shareholder Agreement</li>
                <li><strong>Non-Profit</strong> — shows IRS EZ-501(c)(3); hides CPA Tax Filing</li>
            </ul>

            <h3>Step 2 — State Selection</h3>
            <p>User selects their formation state from a dropdown (all 50 states + DC). The state filing fee is shown live. This fee is <strong>not a product</strong> — it's added as a WooCommerce cart fee at checkout via a hook in <code>wc-hooks.php</code>.</p>

            <h3>Step 3 — Plan Selection</h3>
            <p>User sees a 4-column comparison table. Clicking a plan card immediately moves to Step 4. Each plan is a hidden WooCommerce product (created on activation).</p>

            <table class="bjw-table">
                <tr><th>Plan</th><th>Price</th><th>Billing</th></tr>
                <tr><td>Basic</td><td>$99</td><td>One-time</td></tr>
                <tr><td>Pro</td><td>$195</td><td>One-time</td></tr>
                <tr><td>Premium ⭐</td><td>$295</td><td>One-time</td></tr>
                <tr><td>Enterprise</td><td>$295 + $29/mo</td><td>One-time + subscription</td></tr>
            </table>

            <h3>Step 4 — Add-Ons</h3>
            <p>14 add-on services shown as toggleable checkboxes. Visibility is controlled by both entity type (Step 1) and plan (Step 3):</p>
            <ul>
                <li><strong>Hidden</strong> add-ons: not shown (already included in plan or not applicable)</li>
                <li><strong>Auto-selected & disabled</strong>: included in plan, user can't remove them</li>
                <li><strong>Optional</strong>: user can check/uncheck freely</li>
            </ul>
            <p>The sidebar order summary updates live as add-ons are checked.</p>

            <h3>Step 5 — Business Details</h3>
            <p>Collects: Business Name, Designator (LLC / Inc. / Corp.), Business Address, Contact Person, Email, Phone, SMS Consent. All fields are validated client-side before advancing. Required fields show a red border if empty.</p>

            <h3>Step 6 — Review & Checkout</h3>
            <p>Displays a full itemized summary. When user clicks <strong>Proceed to Checkout</strong>:</p>
            <ol>
                <li>An AJAX POST is sent to <code>wp-admin/admin-ajax.php</code> with action <code>bj_create_order</code></li>
                <li>Server validates the nonce + inputs</li>
                <li>WooCommerce cart is emptied</li>
                <li>Correct plan product + selected add-on products are added to cart</li>
                <li>Wizard data (entity, state, plan, add-ons, business details) is saved to WC session</li>
                <li>Server returns the WooCommerce checkout URL</li>
                <li>Browser redirects to standard WooCommerce checkout</li>
            </ol>

            <h3>At WooCommerce Checkout</h3>
            <ul>
                <li>The state filing fee is automatically added as a cart fee line item</li>
                <li>Customer fills in billing info + picks payment method (Stripe/PayPal/ACH)</li>
                <li>On order creation: all wizard data is saved to order meta</li>
            </ul>

            <h3>After Order Placed</h3>
            <ul>
                <li>WooCommerce sends the standard "New Order" email to admin and "Order Received" email to customer</li>
                <li>Admin can see formation details in the order screen (formation panel below billing address)</li>
                <li>Customer can see their formation in <em>My Account → My Formation</em></li>
            </ul>
        </div>

        <!-- ── Shortcode ─────────────────────────────────────────────── -->
        <div class="bjw-section">
            <h2>📌 Shortcode Reference</h2>

            <p>The wizard is placed on any page with a single shortcode:</p>
            <code class="bjw-code">[bizjump_wizard]</code>

            <p>The shortcode has no parameters — all configuration is in the PHP data files.</p>

            <h3>Where to place it</h3>
            <ul>
                <li>Go to <em>Pages → Add New</em></li>
                <li>Use the Block Editor (Gutenberg) → add a <strong>Shortcode</strong> block</li>
                <li>Or use Elementor → add a <strong>Shortcode</strong> widget</li>
                <li>Paste <code>[bizjump_wizard]</code> and publish</li>
            </ul>

            <div class="bjw-alert">
                ℹ The wizard CSS and JS only load on pages that contain this shortcode — no performance impact on other pages.
            </div>
        </div>

        <!-- ── WooCommerce Products ───────────────────────────────────── -->
        <div class="bjw-section">
            <h2>🛍️ WooCommerce Products</h2>

            <p>On plugin activation, <strong>18 hidden products</strong> are automatically created in WooCommerce:</p>

            <table class="bjw-table">
                <tr><th>Product Key</th><th>Label</th><th>Price</th><th>Type</th></tr>
                <tr><td><code>plan_basic</code></td><td>Basic Formation</td><td>$99</td><td>Simple</td></tr>
                <tr><td><code>plan_pro</code></td><td>Pro Formation</td><td>$195</td><td>Simple</td></tr>
                <tr><td><code>plan_premium</code></td><td>Premium Formation</td><td>$295</td><td>Simple</td></tr>
                <tr><td><code>plan_enterprise</code></td><td>Enterprise Formation</td><td>$295</td><td>Simple</td></tr>
                <tr><td><code>addon_operating_agreement</code></td><td>Operating Agreement</td><td>$35</td><td>Simple</td></tr>
                <tr><td><code>addon_ein</code></td><td>EIN / Tax ID Filing</td><td>$30</td><td>Simple</td></tr>
                <tr><td><code>addon_registered_agent</code></td><td>Registered Agent (1 Year)</td><td>$99</td><td>Simple*</td></tr>
                <tr><td><code>addon_compliance_alerts</code></td><td>Annual Compliance Alerts</td><td>$25</td><td>Simple</td></tr>
                <tr><td><code>addon_corporate_bylaws</code></td><td>Corporate Bylaws</td><td>$45</td><td>Simple</td></tr>
                <tr><td><code>addon_shareholder_agreement</code></td><td>Shareholder Agreement</td><td>$95</td><td>Simple</td></tr>
                <tr><td><code>addon_bank_account</code></td><td>Bank Account Setup</td><td>$200</td><td>Simple</td></tr>
                <tr><td><code>addon_form_2553</code></td><td>IRS Form 2553</td><td>$35</td><td>Simple</td></tr>
                <tr><td><code>addon_corporate_kit</code></td><td>Executive Corporate Kit</td><td>$99</td><td>Simple</td></tr>
                <tr><td><code>addon_accounting</code></td><td>Accounting System Setup</td><td>$25</td><td>Simple</td></tr>
                <tr><td><code>addon_tax_filing</code></td><td>First Year Tax Filing (CPA)</td><td>$195</td><td>Simple</td></tr>
                <tr><td><code>addon_website</code></td><td>Corporate Website</td><td>$0</td><td>Simple*</td></tr>
                <tr><td><code>addon_digital_marketing</code></td><td>Digital Marketing Setup</td><td>$95</td><td>Simple</td></tr>
                <tr><td><code>addon_501c3</code></td><td>IRS EZ-501(c)(3) Filing</td><td>$395</td><td>Simple</td></tr>
            </table>

            <p style="margin-top:12px;"><em>* Products marked with asterisk should be converted to WooCommerce Subscription products manually for recurring billing (Registered Agent $99/yr, Corporate Website $29/mo, Enterprise $29/mo).</em></p>

            <h3>How to find these products</h3>
            <p>Go to <em>WooCommerce → Products</em>. Filter by <strong>Hidden</strong> visibility. All 18 wizard products are there but not visible in the shop or catalog.</p>

            <h3>How to convert to Subscription products (for recurring billing)</h3>
            <ol>
                <li>Go to <em>WooCommerce → Products → find "Registered Agent Service (1 Year)"</em></li>
                <li>Edit the product → change Product Type from <strong>Simple product</strong> to <strong>Simple subscription</strong></li>
                <li>Set: Price = $99, Billing period = Every 1 Year</li>
                <li>Repeat for <strong>Corporate Website</strong>: $29/month</li>
                <li>For Enterprise monthly fee: create a separate subscription product ($29/month) and note its ID</li>
            </ol>

            <div class="bjw-alert bjw-alert-warn">
                ⚠ Do NOT delete any of these products. The wizard looks them up by their <code>_bjw_product_key</code> meta. If deleted, the add-to-cart will silently fail.
                Use <a href="<?php echo esc_url( admin_url( 'admin.php?page=bizjump-wizard-recreate' ) ); ?>">Recreate Products</a> to restore any deleted ones.
            </div>
        </div>

        <!-- ── Admin Order View ───────────────────────────────────────── -->
        <div class="bjw-section">
            <h2>📋 Viewing Formation Details in Orders</h2>

            <p>Every order placed through the wizard shows a <strong>BizJump Formation Details</strong> panel inside the WooCommerce order edit screen.</p>

            <h3>How to find it</h3>
            <ol>
                <li>Go to <em>WooCommerce → Orders</em></li>
                <li>Click on any order placed through the wizard</li>
                <li>Scroll down — below the Billing Address section you'll see the <strong>BizJump Formation Details</strong> panel (blue left border)</li>
            </ol>

            <h3>What data is shown</h3>
            <table class="bjw-table">
                <tr><th>Field</th><th>Description</th></tr>
                <tr><td>Entity Type</td><td>LLC / C-Corp / S-Corp / Non-Profit</td></tr>
                <tr><td>State</td><td>State slug (e.g. TX, FL, CA)</td></tr>
                <tr><td>Plan</td><td>Which package was ordered</td></tr>
                <tr><td>Add-Ons</td><td>Comma-separated list of selected add-on keys</td></tr>
                <tr><td>Business Name</td><td>Desired business name entered in Step 5</td></tr>
                <tr><td>Designator</td><td>LLC / Inc. / Corp. etc.</td></tr>
                <tr><td>Business Address</td><td>Formation/mailing address</td></tr>
                <tr><td>Contact Person</td><td>Organizer name</td></tr>
                <tr><td>Contact Email</td><td>Organizer email</td></tr>
                <tr><td>Contact Phone</td><td>Organizer phone</td></tr>
                <tr><td>SMS Consent</td><td>Yes / No</td></tr>
            </table>
        </div>

        <!-- ── My Account Tab ─────────────────────────────────────────── -->
        <div class="bjw-section">
            <h2>👤 Customer Dashboard — "My Formation" Tab</h2>

            <p>Customers who placed an order through the wizard see a <strong>My Formation</strong> tab in their WooCommerce My Account area.</p>

            <h3>Where to find it (as a customer)</h3>
            <p>Log in → click <em>My Account</em> → click <strong>My Formation</strong> tab in the left sidebar.</p>

            <h3>What it shows</h3>
            <ul>
                <li>A card for each formation order</li>
                <li>Business name + entity type</li>
                <li>State, plan, order status, and date</li>
                <li>Link to full order details</li>
            </ul>

            <h3>Flush permalinks if the tab is missing</h3>
            <p>Go to <em>Settings → Permalinks</em> → click <strong>Save Changes</strong>. This registers the <code>/my-account/my-formation/</code> endpoint.</p>
        </div>

        <!-- ── Customizing Data ───────────────────────────────────────── -->
        <div class="bjw-section">
            <h2>🔧 Customizing Plans, Add-Ons & State Fees</h2>

            <p>All wizard data lives in three PHP files inside the plugin folder. Edit them directly via FTP / SFTP, or in WordPress admin via a code editor plugin (e.g. WP File Manager).</p>

            <h3>Change a plan price</h3>
            <p>Edit: <code>wp-content/plugins/bizjump-wizard/includes/data-plans.php</code></p>
            <p>Find the plan by its <code>'key'</code> field and update the <code>'price'</code> value. Example:</p>
            <code class="bjw-code">[ 'key' => 'plan_basic', 'label' => 'Basic Formation', 'price' => 99.00, ... ]</code>
            <p>After changing the PHP file, also update the WooCommerce product price manually: <em>WooCommerce → Products → Basic Formation → Edit</em>.</p>

            <h3>Change a state filing fee</h3>
            <p>Edit: <code>wp-content/plugins/bizjump-wizard/includes/data-state-fees.php</code></p>
            <p>Find the state by its slug and change the <code>'fee'</code> value. The fee is displayed live in Step 2 and added as a cart fee at checkout automatically.</p>

            <h3>Change an add-on price or visibility</h3>
            <p>Edit: <code>wp-content/plugins/bizjump-wizard/includes/data-addons.php</code></p>
            <p>Each add-on has these control fields:</p>
            <table class="bjw-table">
                <tr><th>Field</th><th>What it does</th></tr>
                <tr><td><code>price</code></td><td>Price shown and added to cart</td></tr>
                <tr><td><code>entity_types</code></td><td>Array of entity types where this shows. <code>null</code> = all.</td></tr>
                <tr><td><code>hide_for_plans</code></td><td>Plans where this add-on is hidden (already included)</td></tr>
                <tr><td><code>auto_select</code></td><td>Plans where this is pre-checked and greyed out (included)</td></tr>
                <tr><td><code>subscription</code></td><td><code>true</code> if recurring billing</td></tr>
            </table>
        </div>

        <!-- ── Troubleshooting ────────────────────────────────────────── -->
        <div class="bjw-section">
            <h2>🛠️ Troubleshooting</h2>

            <h3>Wizard doesn't appear on the page</h3>
            <ul>
                <li>Make sure the shortcode <code>[bizjump_wizard]</code> is on the page</li>
                <li>If using Elementor, add a Shortcode widget and paste the shortcode inside it</li>
                <li>Check that WooCommerce is active — the wizard checks for it</li>
            </ul>

            <h3>"Proceed to Checkout" does nothing / spins forever</h3>
            <ul>
                <li>Open browser DevTools (F12) → Console tab — look for JS errors</li>
                <li>Check that the AJAX URL is correct: the JS global <code>BJW.ajaxUrl</code> should equal your site's <code>/wp-admin/admin-ajax.php</code></li>
                <li>Make sure WooCommerce cart is initialized (WooCommerce must be fully active)</li>
            </ul>

            <h3>State filing fee not showing at checkout</h3>
            <ul>
                <li>Make sure the user selected a state in Step 2 before proceeding</li>
                <li>If the cart was emptied (e.g. browser back button), the WC session data may have been lost — user needs to go through wizard again</li>
            </ul>

            <h3>Formation details not showing in order admin</h3>
            <ul>
                <li>Only orders placed through the wizard shortcode will have this panel</li>
                <li>If the user went directly to WooCommerce checkout (skipped wizard), no meta will be saved</li>
            </ul>

            <h3>"My Formation" tab not appearing in My Account</h3>
            <ul>
                <li>Go to <em>Settings → Permalinks → Save Changes</em> to flush the rewrite rules</li>
                <li>Make sure the customer actually placed an order through the wizard (panel only shows if there are BizJump orders)</li>
            </ul>

            <h3>Products were not created on activation</h3>
            <ul>
                <li>WooCommerce was probably not active when this plugin was first activated</li>
                <li>Go to <a href="<?php echo esc_url( admin_url( 'admin.php?page=bizjump-wizard-recreate' ) ); ?>">BizJump Wizard → Recreate Products</a> and click the button</li>
            </ul>
        </div>

        <!-- ── File Map ───────────────────────────────────────────────── -->
        <div class="bjw-section">
            <h2>📁 Plugin File Map</h2>

            <table class="bjw-table">
                <tr><th>File</th><th>Purpose</th></tr>
                <tr>
                    <td><code>bizjump-wizard.php</code></td>
                    <td>Main plugin file. Registers the shortcode, enqueues CSS/JS, passes data to JS via <code>wp_localize_script</code>, runs activation hook to create WC products.</td>
                </tr>
                <tr>
                    <td><code>includes/data-state-fees.php</code></td>
                    <td>PHP array of all 51 state filing fees. Edit here to update fees.</td>
                </tr>
                <tr>
                    <td><code>includes/data-plans.php</code></td>
                    <td>PHP array of 4 plans with prices, features, and billing type.</td>
                </tr>
                <tr>
                    <td><code>includes/data-addons.php</code></td>
                    <td>PHP array of 14 add-ons with entity/plan visibility rules.</td>
                </tr>
                <tr>
                    <td><code>includes/shortcode.php</code></td>
                    <td>Outputs the full 6-step wizard HTML. Called by <code>[bizjump_wizard]</code> shortcode.</td>
                </tr>
                <tr>
                    <td><code>includes/ajax-handlers.php</code></td>
                    <td>Handles the <code>bj_create_order</code> AJAX request: validates, empties cart, adds products, saves session, returns checkout URL.</td>
                </tr>
                <tr>
                    <td><code>includes/wc-hooks.php</code></td>
                    <td>4 WooCommerce hooks: (1) adds state fee to cart, (2) saves wizard data to order meta, (3) displays meta in admin order screen, (4) adds "My Formation" tab to My Account.</td>
                </tr>
                <tr>
                    <td><code>includes/admin-page.php</code></td>
                    <td>This documentation page. WP Admin → BizJump Wizard.</td>
                </tr>
                <tr>
                    <td><code>assets/wizard.css</code></td>
                    <td>All wizard styles. Responsive (mobile, tablet, desktop). Only loads on pages with the shortcode.</td>
                </tr>
                <tr>
                    <td><code>assets/wizard.js</code></td>
                    <td>6-step state machine. Controls step visibility, conditional add-on logic, sidebar live totals, Step 5 validation, review builder, AJAX submit.</td>
                </tr>
            </table>
        </div>

        <!-- ── Deployment Checklist ───────────────────────────────────── -->
        <div class="bjw-section">
            <h2>✅ Deployment Checklist</h2>
            <ul>
                <li>☐ WooCommerce active + configured (currency = USD)</li>
                <li>☐ WooCommerce Subscriptions active (for Registered Agent, Website, Enterprise)</li>
                <li>☐ BizJump Wizard plugin activated</li>
                <li>☐ 18 WC products created (check <a href="<?php echo esc_url( admin_url( 'admin.php?page=bizjump-wizard-products' ) ); ?>">Product Keys tab</a>)</li>
                <li>☐ Registered Agent + Corporate Website products converted to Subscription type</li>
                <li>☐ Incorporate page created with <code>[bizjump_wizard]</code> shortcode at <code>/incorporate/</code></li>
                <li>☐ Permalinks flushed (Settings → Permalinks → Save)</li>
                <li>☐ Stripe / PayPal / ACH enabled in WC payment settings</li>
                <li>☐ Test order placed end-to-end (wizard → checkout → order admin panel)</li>
                <li>☐ "My Formation" tab visible in My Account after test order</li>
                <li>☐ WC order emails tested (new order + order received)</li>
            </ul>
        </div>

    </div>
    <?php
}

/* ══════════════════════════════════════════════════════════════════════════════
   PRODUCT KEYS PAGE
══════════════════════════════════════════════════════════════════════════════ */
function bjw_render_products_page(): void {
    $all_items = array_merge( bjw_get_plans(), bjw_get_addons() );
    ?>
    <div class="wrap bjw-doc-wrap">
        <h1>BizJump Wizard — Product Keys</h1>
        <span class="bjw-version">All hidden WooCommerce products managed by this plugin</span>

        <div class="bjw-nav-tabs">
            <a href="?page=bizjump-wizard">Setup Guide</a>
            <a href="?page=bizjump-wizard-products" class="active">Product Keys</a>
            <a href="?page=bizjump-wizard-recreate">Recreate Products</a>
        </div>

        <div class="bjw-section">
            <h2>All 18 Wizard Products</h2>
            <p>Each product below is looked up by its <code>_bjw_product_key</code> meta. Click the WC Product ID to edit.</p>

            <table class="bjw-table">
                <tr>
                    <th>Key</th>
                    <th>Label</th>
                    <th>Price</th>
                    <th>WC Product ID</th>
                    <th>Status</th>
                </tr>
                <?php foreach ( $all_items as $item ) :
                    $existing = get_posts( [
                        'post_type'   => 'product',
                        'meta_key'    => '_bjw_product_key',
                        'meta_value'  => $item['key'],
                        'numberposts' => 1,
                        'fields'      => 'ids',
                    ] );
                    $product_id = ! empty( $existing ) ? $existing[0] : null;
                    $edit_url   = $product_id ? admin_url( 'post.php?post=' . $product_id . '&action=edit' ) : null;
                ?>
                <tr>
                    <td><code><?php echo esc_html( $item['key'] ); ?></code></td>
                    <td><?php echo esc_html( $item['label'] ); ?></td>
                    <td>$<?php echo esc_html( number_format( $item['price'], 2 ) ); ?></td>
                    <td>
                        <?php if ( $product_id && $edit_url ) : ?>
                            <a href="<?php echo esc_url( $edit_url ); ?>" target="_blank">#<?php echo esc_html( $product_id ); ?></a>
                        <?php else : ?>
                            <span style="color:#dc2626;">Not found</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ( $product_id ) : ?>
                            <span class="bjw-badge bjw-badge-green">✓ Exists</span>
                        <?php else : ?>
                            <span class="bjw-badge bjw-badge-red">✗ Missing</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>

            <?php
            $missing_count = 0;
            foreach ( $all_items as $item ) {
                $existing = get_posts( [
                    'post_type'   => 'product',
                    'meta_key'    => '_bjw_product_key',
                    'meta_value'  => $item['key'],
                    'numberposts' => 1,
                    'fields'      => 'ids',
                ] );
                if ( empty( $existing ) ) $missing_count++;
            }
            if ( $missing_count > 0 ) : ?>
            <div class="bjw-alert bjw-alert-warn" style="margin-top:16px;">
                ⚠ <strong><?php echo esc_html( $missing_count ); ?> product(s) missing.</strong>
                Go to <a href="<?php echo esc_url( admin_url( 'admin.php?page=bizjump-wizard-recreate' ) ); ?>">Recreate Products</a> to restore them.
            </div>
            <?php else : ?>
            <div class="bjw-alert bjw-alert-ok" style="margin-top:16px;">
                ✅ All 18 products found. Wizard is fully operational.
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/* ══════════════════════════════════════════════════════════════════════════════
   RECREATE PRODUCTS PAGE
══════════════════════════════════════════════════════════════════════════════ */
function bjw_render_recreate_page(): void {
    $message = '';
    $type    = 'info';

    if ( isset( $_POST['bjw_recreate_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bjw_recreate_nonce'] ) ), 'bjw_recreate_products' ) ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'Unauthorized', 'bizjump-wizard' ) );
        }

        if ( class_exists( 'WooCommerce' ) ) {
            bjw_create_wc_products();
            $message = '✅ Products created/verified successfully. Go to <a href="' . esc_url( admin_url( 'admin.php?page=bizjump-wizard-products' ) ) . '">Product Keys</a> to confirm.';
            $type    = 'ok';
        } else {
            $message = '⚠ WooCommerce is not active. Please activate WooCommerce first, then try again.';
            $type    = 'warn';
        }
    }
    ?>
    <div class="wrap bjw-doc-wrap">
        <h1>BizJump Wizard — Recreate Products</h1>
        <span class="bjw-version">Use this if products are missing after activation</span>

        <div class="bjw-nav-tabs">
            <a href="?page=bizjump-wizard">Setup Guide</a>
            <a href="?page=bizjump-wizard-products">Product Keys</a>
            <a href="?page=bizjump-wizard-recreate" class="active">Recreate Products</a>
        </div>

        <?php if ( $message ) : ?>
        <div class="bjw-alert bjw-alert-<?php echo esc_attr( $type ); ?>" style="margin-bottom:20px;">
            <?php echo wp_kses_post( $message ); ?>
        </div>
        <?php endif; ?>

        <div class="bjw-section">
            <h2>Recreate All Wizard Products</h2>

            <p>This button creates all 18 hidden WooCommerce products needed by the wizard. It is <strong>safe to run multiple times</strong> — it skips products that already exist.</p>
            <p>Use this if:</p>
            <ul>
                <li>WooCommerce was not active when the plugin was first activated</li>
                <li>A product was accidentally deleted</li>
                <li>You are setting up on a new server / after migration</li>
            </ul>

            <form method="post">
                <?php wp_nonce_field( 'bjw_recreate_products', 'bjw_recreate_nonce' ); ?>
                <input type="submit" class="button button-primary button-large"
                       value="▶ Create / Restore All 18 Wizard Products"
                       onclick="return confirm('This will create any missing wizard products. Continue?');">
            </form>
        </div>
    </div>
    <?php
}

/* ── Helper: count existing wizard products ─────────────────────────────── */
function bjw_count_wizard_products(): int {
    $all_items = array_merge( bjw_get_plans(), bjw_get_addons() );
    $found = 0;
    foreach ( $all_items as $item ) {
        $existing = get_posts( [
            'post_type'   => 'product',
            'meta_key'    => '_bjw_product_key',
            'meta_value'  => $item['key'],
            'numberposts' => 1,
            'fields'      => 'ids',
        ] );
        if ( ! empty( $existing ) ) $found++;
    }
    return $found;
}
