<?php
/**
 * BizJump Wizard — Per-entity state filing fees + expedited surcharges.
 *
 * Source: BizJump_50_State_Filing_Fees.xlsx (verbatim).
 * DC fees default to $220 / $220 / $80 / $50 — placeholder, confirm with client.
 *
 * @package BizJump_Wizard
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BJW_State_Fees' ) ) :
class BJW_State_Fees {

    /**
     * Per-state fee map. Each row: LLC / Corporation / Nonprofit / Expedited.
     * C-Corp and S-Corp both use the Corporation fee at the state level.
     */
    private static $fees = [
        'Alabama'        => [ 'llc' => 183, 'corp' => 183, 'nonprofit' => 183,  'expedited' => 60  ],
        'Alaska'         => [ 'llc' => 250, 'corp' => 250, 'nonprofit' => 50,   'expedited' => 85  ],
        'Arizona'        => [ 'llc' => 50,  'corp' => 60,  'nonprofit' => 40,   'expedited' => 70  ],
        'Arkansas'       => [ 'llc' => 45,  'corp' => 45,  'nonprofit' => 50,   'expedited' => 60  ],
        'California'     => [ 'llc' => 70,  'corp' => 115, 'nonprofit' => 45,   'expedited' => 385 ],
        'Colorado'       => [ 'llc' => 50,  'corp' => 50,  'nonprofit' => 50,   'expedited' => 60  ],
        'Connecticut'    => [ 'llc' => 185, 'corp' => 315, 'nonprofit' => 165,  'expedited' => 85  ],
        'Delaware'       => [ 'llc' => 90,  'corp' => 89,  'nonprofit' => 89,   'expedited' => 85  ],
        'Florida'        => [ 'llc' => 125, 'corp' => 70,  'nonprofit' => 70,   'expedited' => 135 ],
        'Georgia'        => [ 'llc' => 100, 'corp' => 100, 'nonprofit' => 100,  'expedited' => 135 ],
        'Hawaii'         => [ 'llc' => 51,  'corp' => 51,  'nonprofit' => 26,   'expedited' => 60  ],
        'Idaho'          => [ 'llc' => 100, 'corp' => 100, 'nonprofit' => 30,   'expedited' => 75  ],
        'Illinois'       => [ 'llc' => 150, 'corp' => 180, 'nonprofit' => 55,   'expedited' => 135 ],
        'Indiana'        => [ 'llc' => 91,  'corp' => 91,  'nonprofit' => 30,   'expedited' => 35  ],
        'Iowa'           => [ 'llc' => 50,  'corp' => 50,  'nonprofit' => 20,   'expedited' => 85  ],
        'Kansas'         => [ 'llc' => 165, 'corp' => 90,  'nonprofit' => 20,   'expedited' => 35  ],
        'Kentucky'       => [ 'llc' => 90,  'corp' => 100, 'nonprofit' => 58,   'expedited' => 75  ],
        'Louisiana'      => [ 'llc' => 105, 'corp' => 170, 'nonprofit' => 165,  'expedited' => 65  ],
        'Maine'          => [ 'llc' => 175, 'corp' => 145, 'nonprofit' => 40,   'expedited' => 85  ],
        'Maryland'       => [ 'llc' => 125, 'corp' => 145, 'nonprofit' => 195,  'expedited' => 85  ],
        'Massachusetts'  => [ 'llc' => 520, 'corp' => 290, 'nonprofit' => 40,   'expedited' => 55  ],
        'Michigan'       => [ 'llc' => 60,  'corp' => 50,  'nonprofit' => 20,   'expedited' => 85  ],
        'Minnesota'      => [ 'llc' => 155, 'corp' => 155, 'nonprofit' => 90,   'expedited' => 85  ],
        'Mississippi'    => [ 'llc' => 52,  'corp' => 52,  'nonprofit' => 52,   'expedited' => 35  ],
        'Missouri'       => [ 'llc' => 52,  'corp' => 60,  'nonprofit' => 27,   'expedited' => 85  ],
        'Montana'        => [ 'llc' => 70,  'corp' => 70,  'nonprofit' => 20,   'expedited' => 55  ],
        'Nebraska'       => [ 'llc' => 109, 'corp' => 67,  'nonprofit' => 22,   'expedited' => 35  ],
        'Nevada'         => [ 'llc' => 75,  'corp' => 75,  'nonprofit' => 50,   'expedited' => 160 ],
        'New Hampshire'  => [ 'llc' => 100, 'corp' => 100, 'nonprofit' => 25,   'expedited' => 60  ],
        'New Jersey'     => [ 'llc' => 130, 'corp' => 130, 'nonprofit' => 75,   'expedited' => 60  ],
        'New Mexico'     => [ 'llc' => 50,  'corp' => 100, 'nonprofit' => 25,   'expedited' => 35  ],
        'New York'       => [ 'llc' => 200, 'corp' => 125, 'nonprofit' => 75,   'expedited' => 60  ],
        'North Carolina' => [ 'llc' => 127, 'corp' => 127, 'nonprofit' => 62,   'expedited' => 135 ],
        'North Dakota'   => [ 'llc' => 135, 'corp' => 100, 'nonprofit' => 40,   'expedited' => 85  ],
        'Ohio'           => [ 'llc' => 99,  'corp' => 99,  'nonprofit' => 99,   'expedited' => 135 ],
        'Oklahoma'       => [ 'llc' => 104, 'corp' => 50,  'nonprofit' => 25,   'expedited' => 60  ],
        'Oregon'         => [ 'llc' => 100, 'corp' => 100, 'nonprofit' => 50,   'expedited' => 135 ],
        'Pennsylvania'   => [ 'llc' => 125, 'corp' => 125, 'nonprofit' => 125,  'expedited' => 135 ],
        'Rhode Island'   => [ 'llc' => 156, 'corp' => 238, 'nonprofit' => 37.5, 'expedited' => 85  ],
        'South Carolina' => [ 'llc' => 110, 'corp' => 235, 'nonprofit' => 25,   'expedited' => 35  ],
        'South Dakota'   => [ 'llc' => 150, 'corp' => 150, 'nonprofit' => 30,   'expedited' => 35  ],
        'Tennessee'      => [ 'llc' => 309, 'corp' => 105, 'nonprofit' => 100,  'expedited' => 35  ],
        'Texas'          => [ 'llc' => 300, 'corp' => 300, 'nonprofit' => 25,   'expedited' => 60  ],
        'Utah'           => [ 'llc' => 76,  'corp' => 76,  'nonprofit' => 36,   'expedited' => 110 ],
        'Vermont'        => [ 'llc' => 125, 'corp' => 125, 'nonprofit' => 125,  'expedited' => 85  ],
        'Virginia'       => [ 'llc' => 103, 'corp' => 77,  'nonprofit' => 75,   'expedited' => 135 ],
        'Washington'     => [ 'llc' => 180, 'corp' => 180, 'nonprofit' => 30,   'expedited' => 85  ],
        'West Virginia'  => [ 'llc' => 100, 'corp' => 100, 'nonprofit' => 25,   'expedited' => 60  ],
        'Wisconsin'      => [ 'llc' => 130, 'corp' => 100, 'nonprofit' => 35,   'expedited' => 135 ],
        'Wyoming'        => [ 'llc' => 102, 'corp' => 102, 'nonprofit' => 25,   'expedited' => 35  ],
        // PLACEHOLDER — confirm with client (xlsx has no DC row)
        'District of Columbia' => [ 'llc' => 220, 'corp' => 220, 'nonprofit' => 80, 'expedited' => 50 ],
    ];

    /** Map an entity choice (LLC / C-Corporation / S-Corporation / Nonprofit) to fee column key. */
    private static function entity_to_col( string $entity ): string {
        if ( $entity === 'LLC' )       return 'llc';
        if ( $entity === 'Nonprofit' ) return 'nonprofit';
        return 'corp'; // C-Corp + S-Corp share the Corporation filing fee at the state level
    }

    /** Get filing fee for a state + entity. Returns 0 if unknown. */
    public static function get_fee( string $state_name, string $entity ): float {
        $row = self::$fees[ $state_name ] ?? null;
        if ( ! $row ) return 0;
        $col = self::entity_to_col( $entity );
        return (float) ( $row[ $col ] ?? 0 );
    }

    /** Get the per-state expedited surcharge. Falls back to $50 if state is unknown. */
    public static function get_expedited( string $state_name ): float {
        return (float) ( self::$fees[ $state_name ]['expedited'] ?? 50 );
    }

    /** All state names (for dropdown rendering). */
    public static function all_states(): array {
        return array_keys( self::$fees );
    }

    /** Whole fee table (for wp_localize_script). */
    public static function all_fees(): array {
        return self::$fees;
    }
}
endif;
