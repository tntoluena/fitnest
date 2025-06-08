<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to Fitnest API Backend!',
        'version' => '1.0',
        'documentation_url' => '/api/docs' // Jika nanti ada dokumentasi
    ], 200);
});

// Pastikan TIDAK ADA Auth::routes(); atau require __DIR__.'/auth.php';
// Hanya rute-rute yang benar-benar Anda butuhkan untuk web (jika ada,
// tapi untuk API-only, ini biasanya tidak ada)