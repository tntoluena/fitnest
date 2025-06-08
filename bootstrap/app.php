<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Baris ini sudah benar, kita biarkan saja.
        $middleware->redirectGuestsTo(fn ($request) => $request->expectsJson() ? null : route('login'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        // --- TAMBAHKAN BLOK INI ---
        // Ini adalah "pengaman" terakhir.
        // Jika terjadi AuthenticationException (error karena token tidak valid)
        // dan request ditujukan ke URL yang diawali 'api/',
        // maka paksa kembalikan response JSON error 401 Unauthenticated.
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }
        });
        // --- AKHIR BLOK TAMBAHAN ---

    })->create();
