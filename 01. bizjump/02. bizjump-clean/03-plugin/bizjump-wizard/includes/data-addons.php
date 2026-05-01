<?php
/**
 * BizJump Wizard — Add-Ons Data
 *
 * 14 add-ons with conditional visibility rules.
 *
 * Visibility keys:
 *   entity_types  : which entity types show this add-on (null = all)
 *   hide_for_plans: plans where this add-on is HIDDEN (already included)
 *   auto_select   : plans where this add-on is pre-selected (greyed out, user can't remove)
 *   subscription  : true = recurring billing, false = one-time
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function bjw_get_addons(): array {
    return [
        // 1. Operating Agreement
        [
            'key'             => 'addon_operating_agreement',
            'label'           => 'Operating Agreement',
            'description'     => 'Custom operating agreement tailored to your LLC and state.',
            'price'           => 35.00,
            'subscription'    => false,
            'entity_types'    => [ 'llc' ],                          // LLC only
            'hide_for_plans'  => [ 'plan_pro', 'plan_premium', 'plan_enterprise' ], // included in Pro+
            'auto_select'     => [],
        ],
        // 2. EIN Filing
        [
            'key'             => 'addon_ein',
            'label'           => 'EIN / Tax ID Filing',
            'description'     => 'We file for your federal Employer Identification Number with the IRS.',
            'price'           => 30.00,
            'subscription'    => false,
            'entity_types'    => null,                               // all entities
            'hide_for_plans'  => [ 'plan_pro', 'plan_premium', 'plan_enterprise' ], // included in Pro+
            'auto_select'     => [ 'plan_pro', 'plan_premium', 'plan_enterprise' ],
        ],
        // 3. Registered Agent (1 year)
        [
            'key'             => 'addon_registered_agent',
            'label'           => 'Registered Agent Service (1 Year)',
            'description'     => 'We act as your registered agent for official state and legal notices.',
            'price'           => 99.00,
            'subscription'    => true,  // annual via WC Subscriptions
            'entity_types'    => null,
            'hide_for_plans'  => [ 'plan_basic', 'plan_premium', 'plan_enterprise' ], // included in Basic, Premium, Enterprise
            'auto_select'     => [ 'plan_basic', 'plan_premium', 'plan_enterprise' ],
        ],
        // 4. Annual Compliance Alerts
        [
            'key'             => 'addon_compliance_alerts',
            'label'           => 'Annual Compliance Alerts',
            'description'     => 'We remind you of upcoming annual reports, renewals, and state deadlines.',
            'price'           => 25.00,
            'subscription'    => false,
            'entity_types'    => null,
            'hide_for_plans'  => [ 'plan_premium', 'plan_enterprise' ], // included in Premium+
            'auto_select'     => [ 'plan_pro', 'plan_premium', 'plan_enterprise' ],
        ],
        // 5. Corporate Bylaws
        [
            'key'             => 'addon_corporate_bylaws',
            'label'           => 'Corporate Bylaws',
            'description'     => 'Custom bylaws establishing governance rules for your corporation.',
            'price'           => 45.00,
            'subscription'    => false,
            'entity_types'    => [ 'c_corp', 's_corp' ],            // C-Corp / S-Corp only
            'hide_for_plans'  => [ 'plan_pro', 'plan_premium', 'plan_enterprise' ],
            'auto_select'     => [ 'plan_pro', 'plan_premium', 'plan_enterprise' ],
        ],
        // 6. Corporate Shareholder Agreement
        [
            'key'             => 'addon_shareholder_agreement',
            'label'           => 'Corporate Shareholder Agreement',
            'description'     => 'Protect your corporation with a professionally drafted shareholder agreement.',
            'price'           => 95.00,
            'subscription'    => false,
            'entity_types'    => [ 'c_corp', 's_corp' ],
            'hide_for_plans'  => [],
            'auto_select'     => [],
        ],
        // 7. Bank Account Setup
        [
            'key'             => 'addon_bank_account',
            'label'           => 'Business Bank Account Setup',
            'description'     => 'We help set up your business bank account with a vetted banking partner.',
            'price'           => 200.00,
            'subscription'    => false,
            'entity_types'    => null,
            'hide_for_plans'  => [ 'plan_premium', 'plan_enterprise' ],
            'auto_select'     => [ 'plan_premium', 'plan_enterprise' ],
        ],
        // 8. IRS Form 2553 (S-Corp Election)
        [
            'key'             => 'addon_form_2553',
            'label'           => 'IRS Form 2553 (S-Corp Election)',
            'description'     => 'File to elect S-Corp tax treatment with the IRS.',
            'price'           => 35.00,
            'subscription'    => false,
            'entity_types'    => [ 'llc', 'c_corp' ],              // LLC or C-Corp wanting S-Corp election
            'hide_for_plans'  => [ 'plan_premium', 'plan_enterprise' ],
            'auto_select'     => [ 'plan_premium', 'plan_enterprise' ],
        ],
        // 9. Executive Corporate Kit
        [
            'key'             => 'addon_corporate_kit',
            'label'           => 'Executive Corporate Kit',
            'description'     => 'Physical binder with printed documents, stock certificates, and company seal.',
            'price'           => 99.00,
            'subscription'    => false,
            'entity_types'    => [ 'llc', 'c_corp', 's_corp' ],
            'hide_for_plans'  => [ 'plan_premium', 'plan_enterprise' ],
            'auto_select'     => [ 'plan_premium', 'plan_enterprise' ],
        ],
        // 10. Accounting System Setup
        [
            'key'             => 'addon_accounting',
            'label'           => 'Accounting System Setup',
            'description'     => 'We configure QuickBooks or Wave for your new business.',
            'price'           => 25.00,
            'subscription'    => false,
            'entity_types'    => null,
            'hide_for_plans'  => [ 'plan_premium', 'plan_enterprise' ],
            'auto_select'     => [ 'plan_premium', 'plan_enterprise' ],
        ],
        // 11. First Year Tax Filing (CPA)
        [
            'key'             => 'addon_tax_filing',
            'label'           => 'First Year Tax Filing (CPA)',
            'description'     => 'A licensed CPA prepares and files your first-year business tax return.',
            'price'           => 195.00,
            'subscription'    => false,
            'entity_types'    => [ 'llc', 'c_corp', 's_corp' ],    // hidden for non-profit
            'hide_for_plans'  => [],
            'auto_select'     => [],
        ],
        // 12. Corporate Website
        [
            'key'             => 'addon_website',
            'label'           => 'Corporate Website',
            'description'     => 'Professional 5-page website for your new business. Free setup + $29/mo hosting.',
            'price'           => 0.00,       // free setup
            'subscription'    => true,       // $29/mo via WC Subscriptions
            'subscription_price' => 29.00,
            'entity_types'    => null,
            'hide_for_plans'  => [ 'plan_enterprise' ],            // included in Enterprise
            'auto_select'     => [ 'plan_enterprise' ],
        ],
        // 13. Digital Marketing Setup
        [
            'key'             => 'addon_digital_marketing',
            'label'           => 'Digital Marketing Setup',
            'description'     => 'Google Business Profile, social media pages, and basic SEO setup.',
            'price'           => 95.00,
            'subscription'    => false,
            'entity_types'    => null,
            'hide_for_plans'  => [],
            'auto_select'     => [],
        ],
        // 14. IRS EZ-501(c)(3) — Non-Profit ONLY
        [
            'key'             => 'addon_501c3',
            'label'           => 'IRS EZ-501(c)(3) Tax-Exempt Filing',
            'description'     => 'We prepare and file for federal tax-exempt status with the IRS.',
            'price'           => 395.00,
            'subscription'    => false,
            'entity_types'    => [ 'non_profit' ],                 // Non-Profit ONLY
            'hide_for_plans'  => [],
            'auto_select'     => [],
        ],
    ];
}

/**
 * Get a single add-on by key.
 */
function bjw_get_addon( string $key ): array {
    foreach ( bjw_get_addons() as $addon ) {
        if ( $addon['key'] === $key ) {
            return $addon;
        }
    }
    return [];
}
