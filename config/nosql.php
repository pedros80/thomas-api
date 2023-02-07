<?php

$details = [
    'tables' => [
        'event_store_table' => env('EVENT_STORE_TABLE', 'EventStore'),
        'thomas_table'      => env('THOMAS_TABLE', 'Thomas'),
    ],
    'dynamo'  => [
        'host'    => env('DYNAMO_HOST'),
        'region'  => env('DYNAMO_REGION'),
        'version' => env('DYNAMO_VERSION'),
    ],
];

/*
 *  Add in auth credentials if we're using them locally
 */
if (env('DYNAMO_KEY')) {
    $details['dynamo']['credentials'] = [
        'key'    => env('DYNAMO_KEY'),
        'secret' => env('DYNAMO_SECRET'),
    ];
}

return $details;
