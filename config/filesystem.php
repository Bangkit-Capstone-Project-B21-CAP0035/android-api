<?php

return [
    'default' => env('FILESYSTEM_DRIVER', 'local'),
    'cloud' => env('FILESYSTEM_CLOUD', 'gcloud'),
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => public_path('storage'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'gcloud' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],
    ],
];
