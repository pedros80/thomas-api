<?php

return [
    'secret' => env('JWT_SECRET', 'secret'),
    'algo'   => env('JWT_ALGO', 'HS256'),
    'test'   => env('USER_TEST_JWT'),
];
