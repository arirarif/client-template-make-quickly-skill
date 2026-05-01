# 02 — State Filing Fees (All 51 States)

**Source:** `State_Filing_Fees.xlsx` (sent by client Apr 9, 2026)

> These are **C-Corp filing fees**. They get added on top of BizJump's service fee in the wizard's price calculation.
>
> **Formula:** `Final Price = Plan Price + State Fee + Selected Add-Ons`

---

## Full State Fee Table

| # | State | Filing Fee ($) |
|---|---|---|
| 1 | Alabama | 100 |
| 2 | Alaska | 250 |
| 3 | Arizona | 60 |
| 4 | Arkansas | 45 |
| 5 | California | 100 |
| 6 | Colorado | 50 |
| 7 | Connecticut | 250 |
| 8 | Delaware | 89 |
| 9 | Florida | 87.50 |
| 10 | Georgia | 100 |
| 11 | Hawaii | 50 |
| 12 | Idaho | 100 |
| 13 | Illinois | 150 |
| 14 | Indiana | 100 |
| 15 | Iowa | 50 |
| 16 | Kansas | 90 |
| 17 | Kentucky | 40 |
| 18 | Louisiana | 75 |
| 19 | Maine | 145 |
| 20 | Maryland | 120 |
| 21 | Massachusetts | 275 |
| 22 | Michigan | 60 |
| 23 | Minnesota | 155 |
| 24 | Mississippi | 50 |
| 25 | Missouri | 58 |
| 26 | Montana | 35 |
| 27 | Nebraska | 60 |
| 28 | Nevada | 75 |
| 29 | New Hampshire | 100 |
| 30 | New Jersey | 125 |
| 31 | New Mexico | 100 |
| 32 | New York | 135 |
| 33 | North Carolina | 125 |
| 34 | North Dakota | 100 |
| 35 | Ohio | 99 |
| 36 | Oklahoma | 50 |
| 37 | Oregon | 100 |
| 38 | Pennsylvania | 125 |
| 39 | Rhode Island | 230 |
| 40 | South Carolina | 135 |
| 41 | South Dakota | 150 |
| 42 | Tennessee | 100 |
| 43 | Texas | 300 |
| 44 | Utah | 54 |
| 45 | Vermont | 125 |
| 46 | Virginia | 75 |
| 47 | Washington | 180 |
| 48 | West Virginia | 100 |
| 49 | Wisconsin | 100 |
| 50 | Wyoming | 100 |
| 51 | District of Columbia | 220 |

---

## PHP Array (for the wizard plugin)

```php
$state_fees = [
    'Alabama' => 100, 'Alaska' => 250, 'Arizona' => 60, 'Arkansas' => 45,
    'California' => 100, 'Colorado' => 50, 'Connecticut' => 250, 'Delaware' => 89,
    'Florida' => 87.50, 'Georgia' => 100, 'Hawaii' => 50, 'Idaho' => 100,
    'Illinois' => 150, 'Indiana' => 100, 'Iowa' => 50, 'Kansas' => 90,
    'Kentucky' => 40, 'Louisiana' => 75, 'Maine' => 145, 'Maryland' => 120,
    'Massachusetts' => 275, 'Michigan' => 60, 'Minnesota' => 155, 'Mississippi' => 50,
    'Missouri' => 58, 'Montana' => 35, 'Nebraska' => 60, 'Nevada' => 75,
    'New Hampshire' => 100, 'New Jersey' => 125, 'New Mexico' => 100, 'New York' => 135,
    'North Carolina' => 125, 'North Dakota' => 100, 'Ohio' => 99, 'Oklahoma' => 50,
    'Oregon' => 100, 'Pennsylvania' => 125, 'Rhode Island' => 230, 'South Carolina' => 135,
    'South Dakota' => 150, 'Tennessee' => 100, 'Texas' => 300, 'Utah' => 54,
    'Vermont' => 125, 'Virginia' => 75, 'Washington' => 180, 'West Virginia' => 100,
    'Wisconsin' => 100, 'Wyoming' => 100, 'District of Columbia' => 220,
];
```

---

## Quick Stats

- **Cheapest:** Montana ($35)
- **Most expensive:** Texas ($300)
- **Average:** ~$117
- **Most common:** $100 (16 states)
