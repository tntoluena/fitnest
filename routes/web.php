<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute untuk halaman utama
Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to Fitnest API Backend!',
        'version' => '1.0',
        'documentation_url' => '/api/docs' // Jika nanti ada dokumentasi
    ], 200);
});

// Rute untuk halaman prototipe (didefinisikan secara terpisah)
Route::get('/prototype', function () {
    return view('prototype');
});