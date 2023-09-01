<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme'   => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'rtt' => [
        'user' => env('RTT_USER'),
        'pass' => env('RTT_PASS'),
    ],

    'board' => [
        'provider' => env('BOARD_PROVIDER', 'nre'),
        'numRows'  => env('BOARD_NUM_ROWS', 10),
    ],

    'nre' => [
        'ldb' => [
            'key' => env('LDB_KEY'),
        ],
        'kb' => [
            'user' => env('KB_USER'),
            'pass' => env('KB_PASS'),
        ],
        'kbrti' => [
            'user' => env('KBRTI_USER'),
            'pass' => env('KBRTI_PASS'),
        ],
        'darwin' => [
            'user' => env('DARWIN_TOPIC_USER'),
            'pass' => env('DARWIN_TOPIC_PASS'),
        ],
    ],

    'lande' => [
        'key' => env('LANDE_KEY'),
    ],

    'rss' => [
        'bbc' => [
            'url' => 'http://feeds.bbci.co.uk/news/rss.xml',
        ],
    ],

    'admin' => [
        'secret' => env('ADMIN_SECRET', 'secret'),
    ],
];
