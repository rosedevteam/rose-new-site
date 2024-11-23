<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\AdminGuest;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('admin', [Admin::class]);
        $middleware->group('adminGuest', [AdminGuest::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
