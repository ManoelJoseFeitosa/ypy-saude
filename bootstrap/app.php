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
        // A linha abaixo registra o "apelido" para o nosso middleware.
        $middleware->alias([
            'is.medico' => \App\Http\Middleware\CheckIsMedico::class,
            'is.paciente' => \App\Http\Middleware\CheckIsPaciente::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();