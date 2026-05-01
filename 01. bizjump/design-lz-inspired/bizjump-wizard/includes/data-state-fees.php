<?php
/**
 * BizJump Wizard — State Filing Fees Data
 *
 * Returns array of [ 'slug' => 'state-name', 'name' => 'Display Name', 'fee' => 00.00]
 * for all 50 states + DC.
 *
 * Source: State_Filing_Fees.xlsx provided by client (Apr 9, 2026).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function bjw_get_state_fees(): array {
    return [
        [ 'slug' => 'AL', 'name' => 'Alabama',              'fee' => 200.00 ],
        [ 'slug' => 'AK', 'name' => 'Alaska',               'fee' => 250.00 ],
        [ 'slug' => 'AZ', 'name' => 'Arizona',              'fee' => 50.00  ],
        [ 'slug' => 'AR', 'name' => 'Arkansas',             'fee' => 50.00  ],
        [ 'slug' => 'CA', 'name' => 'California',           'fee' => 70.00  ],
        [ 'slug' => 'CO', 'name' => 'Colorado',             'fee' => 50.00  ],
        [ 'slug' => 'CT', 'name' => 'Connecticut',          'fee' => 120.00 ],
        [ 'slug' => 'DE', 'name' => 'Delaware',             'fee' => 90.00  ],
        [ 'slug' => 'DC', 'name' => 'District of Columbia', 'fee' => 99.00  ],
        [ 'slug' => 'FL', 'name' => 'Florida',              'fee' => 125.00 ],
        [ 'slug' => 'GA', 'name' => 'Georgia',              'fee' => 100.00 ],
        [ 'slug' => 'HI', 'name' => 'Hawaii',               'fee' => 50.00  ],
        [ 'slug' => 'ID', 'name' => 'Idaho',                'fee' => 100.00 ],
        [ 'slug' => 'IL', 'name' => 'Illinois',             'fee' => 150.00 ],
        [ 'slug' => 'IN', 'name' => 'Indiana',              'fee' => 95.00  ],
        [ 'slug' => 'IA', 'name' => 'Iowa',                 'fee' => 50.00  ],
        [ 'slug' => 'KS', 'name' => 'Kansas',               'fee' => 160.00 ],
        [ 'slug' => 'KY', 'name' => 'Kentucky',             'fee' => 40.00  ],
        [ 'slug' => 'LA', 'name' => 'Louisiana',            'fee' => 100.00 ],
        [ 'slug' => 'ME', 'name' => 'Maine',                'fee' => 175.00 ],
        [ 'slug' => 'MD', 'name' => 'Maryland',             'fee' => 100.00 ],
        [ 'slug' => 'MA', 'name' => 'Massachusetts',        'fee' => 500.00 ],
        [ 'slug' => 'MI', 'name' => 'Michigan',             'fee' => 50.00  ],
        [ 'slug' => 'MN', 'name' => 'Minnesota',            'fee' => 155.00 ],
        [ 'slug' => 'MS', 'name' => 'Mississippi',          'fee' => 50.00  ],
        [ 'slug' => 'MO', 'name' => 'Missouri',             'fee' => 50.00  ],
        [ 'slug' => 'MT', 'name' => 'Montana',              'fee' => 35.00  ],
        [ 'slug' => 'NE', 'name' => 'Nebraska',             'fee' => 100.00 ],
        [ 'slug' => 'NV', 'name' => 'Nevada',               'fee' => 75.00  ],
        [ 'slug' => 'NH', 'name' => 'New Hampshire',        'fee' => 100.00 ],
        [ 'slug' => 'NJ', 'name' => 'New Jersey',           'fee' => 125.00 ],
        [ 'slug' => 'NM', 'name' => 'New Mexico',           'fee' => 50.00  ],
        [ 'slug' => 'NY', 'name' => 'New York',             'fee' => 200.00 ],
        [ 'slug' => 'NC', 'name' => 'North Carolina',       'fee' => 125.00 ],
        [ 'slug' => 'ND', 'name' => 'North Dakota',         'fee' => 135.00 ],
        [ 'slug' => 'OH', 'name' => 'Ohio',                 'fee' => 99.00  ],
        [ 'slug' => 'OK', 'name' => 'Oklahoma',             'fee' => 100.00 ],
        [ 'slug' => 'OR', 'name' => 'Oregon',               'fee' => 100.00 ],
        [ 'slug' => 'PA', 'name' => 'Pennsylvania',         'fee' => 125.00 ],
        [ 'slug' => 'RI', 'name' => 'Rhode Island',         'fee' => 150.00 ],
        [ 'slug' => 'SC', 'name' => 'South Carolina',       'fee' => 110.00 ],
        [ 'slug' => 'SD', 'name' => 'South Dakota',         'fee' => 150.00 ],
        [ 'slug' => 'TN', 'name' => 'Tennessee',            'fee' => 300.00 ],
        [ 'slug' => 'TX', 'name' => 'Texas',                'fee' => 300.00 ],
        [ 'slug' => 'UT', 'name' => 'Utah',                 'fee' => 70.00  ],
        [ 'slug' => 'VT', 'name' => 'Vermont',              'fee' => 125.00 ],
        [ 'slug' => 'VA', 'name' => 'Virginia',             'fee' => 100.00 ],
        [ 'slug' => 'WA', 'name' => 'Washington',           'fee' => 200.00 ],
        [ 'slug' => 'WV', 'name' => 'West Virginia',        'fee' => 100.00 ],
        [ 'slug' => 'WI', 'name' => 'Wisconsin',            'fee' => 130.00 ],
        [ 'slug' => 'WY', 'name' => 'Wyoming',              'fee' => 100.00 ],
    ];
}

/**
 * Get a single state fee by slug (e.g. 'TX').
 * Returns 0.00 if state not found.
 */
function bjw_get_state_fee( string $slug ): float {
    foreach ( bjw_get_state_fees() as $state ) {
        if ( $state['slug'] === strtoupper( $slug ) ) {
            return (float) $state['fee'];
        }
    }
    return 0.00;
}
