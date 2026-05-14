<?php
/**
 * BizJump Wizard — Entity → allowed legal-designator suffixes.
 *
 * Per the client spec (page 3 docx):
 *   LLC           → LLC, LIMITED LIABILITY COMPANY
 *   C-Corporation → INC, CORPORATION, INCORPORATED, CORP
 *   S-Corporation → INC, CORPORATION, INCORPORATED, CORP
 *   Nonprofit     → INC, CORPORATION, INCORPORATED, CORP
 *
 * @package BizJump_Wizard
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BJW_Designators' ) ) :
class BJW_Designators {

    private static $map = [
        'LLC'           => [ 'LLC', 'LIMITED LIABILITY COMPANY' ],
        'C-Corporation' => [ 'INC', 'CORPORATION', 'INCORPORATED', 'CORP' ],
        'S-Corporation' => [ 'INC', 'CORPORATION', 'INCORPORATED', 'CORP' ],
        'Nonprofit'     => [ 'INC', 'CORPORATION', 'INCORPORATED', 'CORP' ],
    ];

    public static function all(): array { return self::$map; }

    public static function for_entity( string $entity ): array {
        return self::$map[ $entity ] ?? [ 'LLC' ];
    }

    /** Flat, deduplicated list of every designator across every entity type. */
    public static function all_unique(): array {
        $out = [];
        foreach ( self::$map as $list ) {
            foreach ( $list as $d ) {
                if ( ! in_array( $d, $out, true ) ) $out[] = $d;
            }
        }
        return $out;
    }
}
endif;
