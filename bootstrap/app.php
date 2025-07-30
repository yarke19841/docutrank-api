<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\Authenticate as JWTMiddleware; // ✅ Importar el middleware

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ✅ Alias para JWT
        $middleware->alias([
            'auth.jwt' => JWTMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(
            fn (Illuminate\Auth\AuthenticationException $e, $request) =>
                $request->expectsJson()
                    ? response()->json(['message' => 'No autenticado.'], 401)
                    : redirect()->guest('login')
        );
    })
    ->create();
