<?php

namespace Modules\Category\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'Category';
    protected string $moduleNamespace = 'Modules\Category\Http\Controllers';

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
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Category', 'routes/web.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web', 'admin'])
            ->namespace($this->moduleNamespace . '\admin')
            ->prefix(config('services.admin.prefix'))
            ->name('admin.')
            ->group(module_path('Category', 'routes/admin.php'));
    }
}
