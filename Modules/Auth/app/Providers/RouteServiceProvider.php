<?php

namespace Modules\Auth\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'Auth';
    protected string $moduleNamespace = 'Modules\Auth\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapAdminRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware(['auth:guest', 'web'])
            ->namespace($this->moduleNamespace)
            ->controller(\Modules\Auth\Http\Controllers\AuthController::class)
            ->group(module_path('Auth', 'Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapAdminRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace . '\admin')
            ->prefix(config('services.admin.prefix'))
            ->name('admin.')
            ->controller(\Modules\Auth\Http\Controllers\admin\AuthController::class)
            ->group(module_path('Auth', 'Routes/admin.php'));
    }
}
