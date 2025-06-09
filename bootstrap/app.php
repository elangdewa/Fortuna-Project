<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'midtrans' => \App\Http\Middleware\MidtransMiddleware::class,
             'prevent-back' => \App\Http\Middleware\PreventBackHistory::class,
             'member' => \App\Http\Middleware\MemberMiddleware::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'payments/callback'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();
