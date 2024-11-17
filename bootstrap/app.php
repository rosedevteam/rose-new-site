<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        then: function () {
            Route::middleware('web');
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('admin', [\App\Http\Middleware\Admin::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
