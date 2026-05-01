<?php
/**
 * BizJump Wizard — Plans Data
 *
 * 4 tiers: Basic, Pro, Premium (most popular), Enterprise.
 * Each plan also needs a hidden WC product (created on plugin activation).
 *
 * Prices are BizJump service fees — state filing fee is added separately
 * as a WooCommerce cart fee via wc-hooks.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function bjw_get_plans(): array {
    return [
        [
            'key'         => 'plan_basic',
            'label'       => 'Basic',
            'badge'       => '',
            'price'       => 99.00,
            'billing'     => 'one-time',
            'turnaround'  => '7–10 business days',
            'description' => 'Everything you need to get started.',
            'features'    => [
                'Articles of Incorporation filing',
                'Name availability check',
                'Lifetime customer support',
                'Digital document delivery',
                'Formation tracking dashboard',
                'Email support',
            ],
            'not_included' => [
                'EIN / Tax ID Filing',
                'Operating Agreement',
                'Registered Agent',
                'Annual Compliance Alerts',
                'Expedited Filing',
            ],
        ],
        [
            'key'         => 'plan_pro',
            'label'       => 'Pro',
            'badge'       => '',
            'price'       => 195.00,
            'billing'     => 'one-time',
            'turnaround'  => '5 business days',
            'description' => 'For founders who need compliance handled.',
            'features'    => [
                'Everything in Basic',
                'EIN / Tax ID number',
                'Operating Agreement',
                'Registered Agent (1 year)',
                'Priority processing (5 days)',
                'Priority email & chat support',
            ],
            'not_included' => [
                'CPA Tax Filing',
                'Bank Account Setup',
                'Digital Marketing Setup',
            ],
        ],
        [
            'key'         => 'plan_premium',
            'label'       => 'Premium',
            'badge'       => 'Most Popular',
            'price'       => 295.00,
            'billing'     => 'one-time',
            'turnaround'  => '1 business day (rush)',
            'description' => 'Our most complete one-time formation package.',
            'features'    => [
                'Everything in Pro',
                'Rush 1-day filing',
                'Business bank account setup',
                'Compliance calendar alerts',
                'Dedicated account manager',
                'Expedited state filing',
            ],
            'not_included' => [
                'CPA Tax Filing (add-on)',
                'Digital Marketing Setup (add-on)',
            ],
        ],
        [
            'key'                => 'plan_enterprise',
            'label'              => 'Enterprise',
            'badge'              => 'All-Inclusive',
            'price'              => 295.00,
            'subscription_price' => 29.00,
            'billing'            => 'one-time + $29/mo',
            'turnaround'         => '1 business day (rush)',
            'description'        => 'All-in-one with ongoing compliance and support.',
            'features'           => [
                'Everything in Premium',
                'Monthly compliance monitoring',
                'Annual report reminders',
                'Ongoing registered agent',
                'Priority phone support',
                'Multi-state filing support',
            ],
            'not_included' => [],
        ],
    ];
}

/**
 * Get a single plan array by key.
 */
function bjw_get_plan( string $key ): array {
    foreach ( bjw_get_plans() as $plan ) {
        if ( $plan['key'] === $key ) {
            return $plan;
        }
    }
    return [];
}
