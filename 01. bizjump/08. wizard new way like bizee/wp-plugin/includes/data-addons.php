<?php
/**
 * BizJump Wizard — 17 add-on services, grouped into 3 sections.
 *
 * Section keys: 'corporate' | 'taxes' | 'web'
 *
 * Per-tier price values:
 *   integer     → +$N, displays a toggleable button (Basic / Pro often)
 *   'included'  → ✓ checkmark (auto-included)
 *   '99/year'   → display chip "+$99/year" (Registered Agent — billed separately)
 *   'free+29mo' → display chip "Free setup + $29/mo" (Website — recurring)
 *
 * entities:
 *   'all' (default) | array of allowed entity strings
 *
 * @package BizJump_Wizard
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BJW_Addons' ) ) :
class BJW_Addons {

    public static function sections(): array {
        return [
            'corporate' => 'Corporate Add-Ons + Compliance',
            'taxes'     => 'Business and Taxes',
            'web'       => 'Website & Marketing',
        ];
    }

    private static $addons = [

        // ─── CORPORATE ADD-ONS + COMPLIANCE ───────────────────────────────────
        [
            'id' => 'expedited_filing', 'section' => 'corporate', 'label' => 'Bizjump Expedited Filing',
            'desc' => 'Priority processing and fast-track submission to the state for approval. Standard state filing may take 2–3 weeks, while most states offer fee-based expedited service that can reduce formation time to as little as 1–3 business days.',
            'price' => [ 'basic' => 25, 'pro' => 'included', 'premium' => 'included' ],
            'entities' => 'all',
        ],
        [
            'id' => 'ein', 'section' => 'corporate', 'label' => 'EIN Business Tax Number',
            'desc' => 'We obtain your IRS Employer Identification Number for banking, payroll, and taxes. Required for most business entities.',
            'price' => [ 'basic' => 75, 'pro' => 'included', 'premium' => 'included' ],
            'entities' => 'all',
        ],
        [
            'id' => 'ra', 'section' => 'corporate', 'label' => 'Registered Agent Service',
            'desc' => 'We receive legal notices and state correspondence on your behalf and forward them to you.',
            'price' => [ 'basic' => '99/year', 'pro' => '99/year', 'premium' => 'included' ],
            'entities' => 'all',
        ],
        [
            'id' => 'compliance_alerts', 'section' => 'corporate', 'label' => 'Compliance Alerts',
            'desc' => 'Ongoing email reminders for Secretary of State compliance reports, deadlines, and required filings.',
            'price' => [ 'basic' => 75, 'pro' => 'included', 'premium' => 'included' ],
            'entities' => 'all',
        ],
        [
            'id' => 'corp_kit', 'section' => 'corporate', 'label' => 'Executive Corporate Kit',
            'desc' => 'Physical binder with printed documents, stock certificates, and company seal.',
            'price' => [ 'basic' => 125, 'pro' => 125, 'premium' => 75 ],
            'entities' => 'all',
        ],
        [
            'id' => 'bylaws', 'section' => 'corporate', 'label' => 'Corporate Bylaws',
            'desc' => 'Governing rules for corporations including officers, meetings, and voting.',
            'price' => [ 'basic' => 75, 'pro' => 75, 'premium' => 'included' ],
            'entities' => [ 'C-Corporation', 'S-Corporation' ],
        ],
        [
            'id' => 'oa', 'section' => 'corporate', 'label' => 'Operating Agreement',
            'desc' => 'Legal document defining ownership, roles, and management structure of your LLC. Often required by banks.',
            'price' => [ 'basic' => 75, 'pro' => 75, 'premium' => 'included' ],
            'entities' => [ 'LLC' ],
        ],
        [
            'id' => 'shareholder', 'section' => 'corporate', 'label' => 'Shareholder Agreement',
            'desc' => 'Defines shareholder rights, ownership transfers, and dispute resolution.',
            'price' => [ 'basic' => 75, 'pro' => 75, 'premium' => 'included' ],
            'entities' => [ 'C-Corporation', 'S-Corporation' ],
        ],
        [
            'id' => 'bank_setup', 'section' => 'corporate', 'label' => 'Business Bank Account Setup',
            'desc' => 'Assistance opening your business bank account with required documentation.',
            'price' => [ 'basic' => 150, 'pro' => 150, 'premium' => 150 ],
            'entities' => 'all',
        ],

        // ─── BUSINESS AND TAXES ───────────────────────────────────────────────
        [
            'id' => 'form_2553', 'section' => 'taxes', 'label' => 'IRS Form 2553 (S-Corp Election)',
            'desc' => 'File IRS election for S-Corporation taxation (pass-through taxation). Owners must be U.S. citizens or residents.',
            'price' => [ 'basic' => 75, 'pro' => 75, 'premium' => 75 ],
            'entities' => [ 'S-Corporation' ],
        ],
        [
            'id' => '501c3', 'section' => 'taxes', 'label' => 'IRS EZ-501(c)(3) Tax-Exempt Filing',
            'desc' => 'We prepare and file for federal tax-exempt status with the IRS.',
            'price' => [ 'basic' => 395, 'pro' => 395, 'premium' => 395 ],
            'entities' => [ 'Nonprofit' ],
        ],
        [
            'id' => 'first_year_cpa', 'section' => 'taxes', 'label' => 'First Year Tax Filing (CPA)',
            'desc' => 'CPA prepares and files first-year business tax return (70% discount). Personal taxes separate for C-Corp & S-Corp.',
            'price' => [ 'basic' => 200, 'pro' => 200, 'premium' => 200 ],
            'entities' => 'all',
        ],
        [
            'id' => 'biz_plan', 'section' => 'taxes', 'label' => 'Business Plan Consultation',
            'desc' => 'Professional guidance to help refine your business idea, research startup requirements including licensing, and overall business plan structure, including SWOT analysis. Deliverable includes a 3–5-page business plan summary document prepared after completion of a short questionnaire.',
            'price' => [ 'basic' => 175, 'pro' => 175, 'premium' => 175 ],
            'entities' => 'all',
        ],
        [
            'id' => 'accounting', 'section' => 'taxes', 'label' => 'Accounting System Setup & Tax Planning',
            'desc' => 'Setup accounting structure and provide basic tax planning guidance.',
            'price' => [ 'basic' => 125, 'pro' => 125, 'premium' => 'included' ],
            'entities' => 'all',
        ],

        // ─── WEBSITE & MARKETING ──────────────────────────────────────────────
        [
            'id' => 'website', 'section' => 'web', 'label' => 'Basic Corporate Website',
            'desc' => 'Professional 5-page website with hosting and ongoing maintenance.',
            'price' => [ 'basic' => 'free+29mo', 'pro' => 'free+29mo', 'premium' => 'free+29mo' ],
            'entities' => 'all',
        ],
        [
            'id' => 'social', 'section' => 'web', 'label' => 'Social Media Marketing Setup',
            'desc' => 'We create and configure your business social media accounts so your brand is professionally positioned online and ready to attract customers. Includes setup of Facebook, Instagram, LinkedIn, and YouTube business accounts.',
            'price' => [ 'basic' => 125, 'pro' => 125, 'premium' => 125 ],
            'entities' => 'all',
        ],
        [
            'id' => 'gbp', 'section' => 'web', 'label' => 'Google Business Profile Setup',
            'desc' => 'We set up and optimize your Google Business Profile to help customers find your business online through Google Search and Maps. Includes Google Business Profile configuration and basic Google Analytics setup.',
            'price' => [ 'basic' => 125, 'pro' => 125, 'premium' => 125 ],
            'entities' => 'all',
        ],
    ];

    public static function all(): array { return self::$addons; }

    public static function find( string $id ): ?array {
        foreach ( self::$addons as $a ) if ( $a['id'] === $id ) return $a;
        return null;
    }

    /** Filter the addon list to only those visible for the given entity. */
    public static function visible_for_entity( string $entity ): array {
        return array_values( array_filter( self::$addons, function ( $a ) use ( $entity ) {
            if ( $a['entities'] === 'all' ) return true;
            return is_array( $a['entities'] ) && in_array( $entity, $a['entities'], true );
        } ) );
    }

    /** Tier price for a given addon. Returns 0 if value is a non-numeric chip (included / chip strings). */
    public static function tier_price( array $addon, string $tier_key ): float {
        $v = $addon['price'][ $tier_key ] ?? null;
        return is_numeric( $v ) ? (float) $v : 0;
    }
}
endif;
