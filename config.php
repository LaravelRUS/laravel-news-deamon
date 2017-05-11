<?php
return [
    'gitter'       => [
        'token'   => env('GITTER_TOKEN', ''),
        'hook_id' => env('GITTER_WEBHOOK_ID', ''),
    ],
    'notify_title' => env('NOTIFY_TITLE', '**Новости сообщества**'),
    'vk'           => [
        'has_attachment' => env('VK_HAS_ATTACHMENT', false),
        'delay'          => 60,
        'community_name' => env('VK_COMMUNITY_NAME', 'laravel_rus'),
        'community_id'   => env('VK_COMMUNITY_ID', '-53758340'),
    ],
    'log'          => [
        'out'   => env('LOG_STDOUT', true) ? STDOUT : __DIR__ . '/logs.log',
        'level' => env('LOG_LEVEL', \Monolog\Logger::NOTICE),
    ],
];
