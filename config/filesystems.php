<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        // Disk khusus untuk dokumen fakultas
        'dokumen_fakultas' => [
            'driver' => 'local',
            'root' => storage_path('app/public/dokumen/fakultas'),
            'url' => env('APP_URL') . '/storage/dokumen/fakultas',
            'visibility' => 'public',
            'throw' => false,
        ],

        // Disk khusus untuk dokumen prodi
        'dokumen_prodi' => [
            'driver' => 'local',
            'root' => storage_path('app/public/dokumen/prodi'),
            'url' => env('APP_URL') . '/storage/dokumen/prodi',
            'visibility' => 'public',
            'throw' => false,
        ],

        // Disk khusus untuk dokumen universitas
        'dokumen_universitas' => [
            'driver' => 'local',
            'root' => storage_path('app/public/dokumen/universitas'),
            'url' => env('APP_URL') . '/storage/dokumen/universitas',
            'visibility' => 'public',
            'throw' => false,
        ],

        // Disk untuk AMI
        'ami' => [
            'driver' => 'local',
            'root' => storage_path('app/public/ami'),
            'url' => env('APP_URL') . '/storage/ami',
            'visibility' => 'public',
            'throw' => false,
        ],

        // Disk untuk akreditasi
        'akreditasi' => [
            'driver' => 'local',
            'root' => storage_path('app/public/akreditasi'),
            'url' => env('APP_URL') . '/storage/akreditasi',
            'visibility' => 'public',
            'throw' => false,
        ],

        // Disk untuk laporan
        'laporan' => [
            'driver' => 'local',
            'root' => storage_path('app/public/laporan'),
            'url' => env('APP_URL') . '/storage/laporan',
            'visibility' => 'public',
            'throw' => false,
        ],

        // Disk untuk galeri
        'galeri' => [
            'driver' => 'local',
            'root' => storage_path('app/public/galeri'),
            'url' => env('APP_URL') . '/storage/galeri',
            'visibility' => 'public',
            'throw' => false,
        ],

        // Disk untuk berita
        'berita' => [
            'driver' => 'local',
            'root' => storage_path('app/public/berita'),
            'url' => env('APP_URL') . '/storage/berita',
            'visibility' => 'public',
            'throw' => false,
        ],

        // Disk untuk struktur organisasi
        'struktur' => [
            'driver' => 'local',
            'root' => storage_path('app/public/struktur'),
            'url' => env('APP_URL') . '/storage/struktur',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
];
