<?php

/*
|--------------------------------------------------------------------------
| Site / business details
|--------------------------------------------------------------------------
| One place for the business facts used by the header, footer, contact
| page, meta tags and the JSON-LD schema (resources/views/partials/schema).
*/

return [
    'name'        => 'Quality Core Cutting UAE',
    'short_name'  => 'Quality Core Cutting',
    'tagline'     => 'Concrete Cutting & Core Cutting Specialists',
    'description' => 'Concrete cutting, core cutting, wall saw, wire saw and floor saw cutting, concrete scanning and civil work across Dubai, Sharjah, Abu Dhabi and the UAE.',

    'logo'     => 'assets/images/logo.webp',
    'logo_png' => 'assets/images/logo.png',
    'og_image' => 'assets/images/og-default.jpg',

    'phone'     => '+971 50 758 9374',
    'phone_raw' => '+971507589374',
    'whatsapp'  => '971507589374',
    'email'     => 'info@qualitycorecuttinguae.com',
    'hours'     => 'Open 24 hours, 7 days a week',

    'address' => [
        'locality' => 'Abu Dhabi',
        'region'   => 'Abu Dhabi',
        'country'  => 'AE',
        'label'    => 'Abu Dhabi, United Arab Emirates',
    ],
    'map_url' => 'https://www.google.com/maps/search/?api=1&query=Abu+Dhabi%2C+United+Arab+Emirates',

    'area_served' => ['Dubai', 'Abu Dhabi', 'Sharjah', 'Al Ain', 'Ajman', 'Ras Al Khaimah', 'Fujairah', 'Umm Al Quwain'],

    // Social profile URLs (used in the footer and as "sameAs" in the schema).
    // e.g. 'facebook' => 'https://www.facebook.com/...'
    'social' => [],

    // Where website form enquiries are emailed.
    'enquiry_email' => env('ENQUIRY_EMAIL', 'info@qualitycorecuttinguae.com'),

    // Google Search Console / Bing Webmaster verification codes (content value only).
    'google_verification' => env('GOOGLE_SITE_VERIFICATION'),
    'bing_verification'   => env('BING_SITE_VERIFICATION'),

    // Google tag IDs that were on the old site. Remove an ID to disable it.
    'gtag_ids' => array_values(array_filter([
        env('GTAG_ID', 'GT-PZM4KCD2'),
        env('GADS_ID', 'AW-16802235479'),
    ])),
];
