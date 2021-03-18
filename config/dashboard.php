<?php

return [
    /*
     * The dashboard supports these themes:
     *
     * - light: always use light mode
     * - dark: always use dark mode
     * - device: follow the OS preference for determining light or dark mode
     * - auto: use light mode when the sun is up, dark mode when the sun is down
     */
    'theme' => 'auto',

    /*
     * When the dashboard uses the `auto` theme, these coordinates will be used
     * to determine whether the sun is up or down
     */
    'auto_theme_location' => [
        'lat' => 45.612150,
        'lng' => -73.531860,
    ],

    'tiles' => [
        'calendar' => [
            'ids' => [
                env('GOOGLE_CALENDAR_ID'),
            ],
            'refresh_interval_in_seconds' => 60,
        ],

        'twitter' => [
            'configurations' => [
                'default' => [
                    'consumer_key' => env('TWITTER_CONSUMER_KEY'),
                    'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
                    'access_token' => env('TWITTER_ACCESS_TOKEN'),
                    'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
                    'listen_for' => [
                        'kangaroorewards.com',
                        '@KangarooRewards',
                        'github.com/kangaroorewards',
//                        'laravel',
//                        '#laravel',
//                        '#DaylightSavingTime'
                    ],
                ],
            ],
            'refresh_interval_in_seconds' => 5,
        ],

        'velo' => [
            'stations' => explode(',', env('VELO_STATIONS')),
        ],

        'belgian_trains' => [
            [
                'departure' => 'Antwerpen-Centraal',
                'destination' => 'Gent-Dampoort',
                'label' => 'Gent',
            ],
            [
                'departure' => 'Antwerpen-Centraal',
                'destination' => 'Mechelen',
                'label' => 'Mechelen',
            ],
            [
                'departure' => 'Antwerpen-Centraal',
                'destination' => 'Overpelt',
                'label' => 'Overpelt',
            ],
            [
                'departure' => 'Antwerpen-Centraal',
                'destination' => 'Kapellen',
                'label' => 'Kapellen',
            ],
        ],

        'time_weather' => [
            'open_weather_map_key' => env('OPEN_WEATHER_MAP_KEY'),
            'open_weather_map_city' => 'Montreal',
            'buienradar_latitude' => env('BUIENRADAR_LATITUDE'),
            'buienradar_longitude' => env('BUIENRADAR_LONGITUDE'),
        ],

        /* Monitors should be an array with ids of your monitors you want to display */
        'uptimerobot' => [
            'key' => env('UPTIMEROBOT_KEY'),
            'monitors' => []
        ]
    ],
];
