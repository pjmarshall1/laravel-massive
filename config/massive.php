<?php

return [

    'api_key' => env('MASSIVE_API_KEY'),

    'base_url' => env('MASSIVE_BASE_URL', 'https://api.massive.com'),

    'timeout' => (int) env('MASSIVE_TIMEOUT', 10),

    'connect_timeout' => (int) env('MASSIVE_CONNECT_TIMEOUT', 3),

    'retry_delays' => [100, 200, 500],

];
