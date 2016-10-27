<?php
return [
    'gitter' => [
        'token' => env('GITTER_TOKEN'),
        'hook'  => env('GITTER_WEBHOOK_ID'),
    ],
    'vk'     => [
        'app_id'    => env('VK_APP_ID', ''),
        'secret'    => env('VK_APP_SECRET', ''),
        'delay'     => 1,
        'community' => '-53758340', // Laravel RUS
    ],
    'log'    => [
        'out'   => env('LOG_STDOUT', true) ? STDOUT : __DIR__ . '/logs.log',
        'level' => env('LOG_LEVEL', \Monolog\Logger::NOTICE),
    ],
];