<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Di sini Anda bisa mengatur setelan untuk Cross-Origin Resource Sharing (CORS).
    | Ini menentukan operasi lintas-domain apa yang dapat dieksekusi di browser web.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        // Kita langsung izinkan request yang datang dari alamat server Laravel kita,
        // karena halaman prototipe kita diakses dari sini.
        'http://127.0.0.1:8000', 
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];