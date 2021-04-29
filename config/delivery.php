<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Delivery information
    |--------------------------------------------------------------------------
    |
    | about the restaurant delivery
    */

    'price' => 10,
    "time"=> 20,
    'zone_bounds' => [
        // casablanca airport
        'south_west' => [
            'latitude' => 33.55416445,
            'longitude' => -7.656330708
        ],
        // Mohammédia
        'north_east' => [
            'latitude' =>  33.6833306,
            'longitude' => -7.3833318
        ],
    ]

];
