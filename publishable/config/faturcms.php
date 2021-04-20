<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Controllers config
    |--------------------------------------------------------------------------
    |
    | Here you can specify FaturCMS controller settings
    |
    */

    'controllers' => [
        'namespace' => 'Ajifatur\\FaturCMS\\Http\\Controllers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Image config
    |--------------------------------------------------------------------------
    |
    */

    'images' => [
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
    | Role permission config
    |--------------------------------------------------------------------------
    |
    */

    'allowed_access' => [
        'DashboardController::member',
    ]
];