<?php

namespace Modules\Admin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'admin';
    protected string $moduleNamespace = "Modules\Admin\Http\Controllers";

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
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web', 'admin'])
            ->namespace($this->moduleNamespace)
            ->prefix(config('services.admin.prefix'))
            ->name('admin.')
            ->group(module_path('admin', 'routes/admin.php'));
    }
}
