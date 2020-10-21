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

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'upload' => [
            'driver' => 'local',
            'root' => public_path(),
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

        'console' => [
            'avatar' => [
                'path' => 'upload/console/avatar/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'logo' => [
                'path' => 'upload/console/logo/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp']
            ],
        ],

        'front' => [
            'grid' => [
                'path' => 'upload/front/grid/',
                'size' => 1024 * 1024 * 2,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'banner' => [
                'path' => 'upload/front/banner/',
                'size' => 1024 * 1024 * 2,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp']
            ],
        ],

        'poster' => [
            'artist' => [
                'path' => 'upload/poster/artist/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'notice' => [
                'path' => 'upload/poster/notice/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],
        ],

        'goods' => [
            'image' => [
                'path' => 'upload/goods/image/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'banner' => [
                'path' => 'upload/goods/banner/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'category' => [
                'path' => 'upload/goods/category/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'group' => [
                'path' => 'upload/goods/group/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],
        ],

        'order' => [
            'comment' => [
                'path' => 'upload/order/comment/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg'],
            ],
        ],

        'navigation' => [
            'path' => 'upload/navigation/',
            'size' => 1024 * 1024 * 2,
            'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
        ],

        'article' => [
            'image' => [
                'path' => 'upload/article/image/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'banner' => [
                'path' => 'upload/article/banner/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],
        ],

        'editor' => [
            'path' => 'upload/editor/',
            'size' => 1024 * 1024 * 5,
            'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
        ],

        'store' => [
            'path' => 'upload/store/',
            'size' => 1024 * 1024 * 5,
            'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
        ],

        'invite' => [
            'poster' => [
                'path' => 'upload/invite/poster/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],
        ],

        'setting' => [
            'qrcode' => [
                'path' => 'upload/setting/qrcode/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],
        ],

        'design' => [
            'swiper' => [
                'path' => 'upload/design/swiper/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'image' => [
                'path' => 'upload/design/image/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'cube' => [
                'path' => 'upload/design/cube/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'video' => [
                'video' => [
                    'path' => 'upload/design/video/',
                    'size' => 1024 * 1024 * 50,
                    'type' => ['mp4'],
                ],

                'poster' => [
                    'path' => 'upload/design/video/',
                    'size' => 1024 * 1024 * 5,
                    'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
                ],
            ],

            'grid' => [
                'path' => 'upload/design/grid/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'cell' => [
                'path' => 'upload/design/cell/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'notice' => [
                'path' => 'upload/design/notice/',
                'size' => 1024 * 1024 * 5,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'tabbar' => [
                'path' => 'upload/design/tabbar/',
                'size' => 1024 * 1024 * 1,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'text' => [
                'path' => 'upload/design/text/',
                'size' => 1024 * 1024 * 1,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],

            'mine' => [
                'path' => 'upload/design/mine/',
                'size' => 1024 * 1024 * 1,
                'type' => ['jpg', 'gif', 'png', 'jpeg', 'webp'],
            ],
        ],
    ],
];
