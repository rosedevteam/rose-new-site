<?php

use App\Http\Middleware\Admin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        then: function () {
            Route::middleware('web')->group(base_path('routes/web.php'));
            Route::middleware(['admin', 'web'])
                ->prefix(config('services.admin.prefix'))
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('admin', [Admin::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (AuthorizationException $e) {
            return response()->view(view: 'error.403', status: 403);
        })->stop();
    })->create();
