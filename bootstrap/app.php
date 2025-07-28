<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // ✅ rutas API registradas correctamente
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Puedes agregar middlewares globales aquí si lo necesitas
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
