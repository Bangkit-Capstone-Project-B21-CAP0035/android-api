<?php

return [
    'default' => env('FILESYSTEM_DRIVER', 'local'),
    'cloud' => env('FILESYSTEM_CLOUD', 'gcs'),
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => public_path('storage'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'gcs' => [
            'driver' => 'gcs',
            'project_id' => env('GOOGLE_CLOUD_PROJECT_ID', 'project-id'),
            'key_file' => env('GOOGLE_CLOUD_KEY_FILE', ''),
            'bucket' => env('GOOGLE_CLOUD_STORAGE_BUCKET', 'your-bucket'),
            'path_prefix' => env('GOOGLE_CLOUD_STORAGE_PATH_PREFIX', 'sehatmentalku'),
            'storage_api_uri' => env('GOOGLE_CLOUD_STORAGE_API_URI', null),
        ],
    ],
];
