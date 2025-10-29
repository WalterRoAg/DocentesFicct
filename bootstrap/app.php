<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\PermisoMiddleware;


// ...
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 👇 registra tu alias de middleware
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
             'permiso' => PermisoMiddleware::class, // 👈 este alias faltaba
        ]);

        // (opcional) puedes añadir globales/grupos aquí si lo necesitas:
        // $middleware->append(\App\Http\Middleware\TrustProxies::class);
        // $middleware->appendToGroup('web', \Illuminate\Session\Middleware\StartSession::class);
    })
    ->withExceptions(function ($exceptions) {
        //
    })->create();

