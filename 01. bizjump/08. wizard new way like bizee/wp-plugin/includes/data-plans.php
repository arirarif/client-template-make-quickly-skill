<?php
/**
 * BizJump Wizard — Plan tiers.
 *
 * Three tiers per the May 2026 client spec. No Enterprise tier.
 *
 * @package BizJump_Wizard
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BJW_Plans' ) ) :
class BJW_Plans {

    private static $plans = [
        'basic' => [
            'key'         => 'basic',
            'label'       => 'Basic',
            'price'       => 99.00,
            'speed'       => '7 days',
            'recommended' => false,
            'description' => 'Ideal for experienced founders who only need business formation services and can handle the remaining setup steps themselves.',
        ],
        'pro' => [
            'key'         => 'pro',
            'label'       => 'Pro',
            'price'       => 195.00,
            'speed'       => '2 days',
            'recommended' => false,
            'description' => 'Best for busy entrepreneurs who want additional setup support while still managing a few tasks independently.',
        ],
        'premium' => [
            'key'         => 'premium',
            'label'       => 'Premium',
            'price'       => 395.00,
            'speed'       => '24 hours',
            'recommended' => true,
            'description' => 'Designed for founders who want a more complete setup experience with expedited processing and broader hands-on support from our team.',
        ],
    ];

    public static function all(): array { return self::$plans; }

    public static function get( string $key ): ?array {
        return self::$plans[ $key ] ?? null;
    }

    public static function price( string $key ): float {
        return (float) ( self::$plans[ $key ]['price'] ?? 0 );
    }
}
endif;
