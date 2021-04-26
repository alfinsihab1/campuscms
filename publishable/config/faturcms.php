<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Package Name
    |--------------------------------------------------------------------------
    |
    */

    'name' => 'ajifatur/faturcms',

    /*
    |--------------------------------------------------------------------------
    | Controllers
    |--------------------------------------------------------------------------
    |
    */

    'controllers' => [
        'namespace' => 'Ajifatur\\FaturCMS\\Http\\Controllers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    |
    */

    'images' => [
        'acara' => 'acara.png',
        'blog' => 'blog.png',
        'file' => 'file.jpg',
        'fitur' => 'fitur.png',
        'folder' => 'folder.png',
        'karir' => 'karir.png',
        'mentor' => 'mentor.jpg',
        'mitra' => 'mitra.png',
        'pelatihan' => 'pelatihan.png',
        'pdf' => 'pdf.svg',
        'program' => 'program.png',
        'slider' => 'slider.png',
        'testimoni' => 'testimoni.jpg',
        'user' => 'user.jpg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Access
    |--------------------------------------------------------------------------
    |
    */

    'allowed_access' => [
        'DashboardController::member',
    ]
];