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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'staff' => \App\Http\Middleware\EnsureStaff::class,
            'manager' => \App\Http\Middleware\EnsureManager::class,
            'store_ref' => \App\Http\Middleware\StoreReferral::class,
        ]);
        // Capture referrals/UTM on every web request
        $middleware->appendToGroup('web', \App\Http\Middleware\StoreReferral::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
