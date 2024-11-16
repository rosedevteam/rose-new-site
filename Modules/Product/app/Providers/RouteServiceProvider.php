<?php

namespace Modules\Product\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'Product';
    protected string $moduleNamespace = 'Modules\Product\Http\Controllers';

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
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->controller(\Modules\Product\Http\Controllers\ProductController::class)
            ->group(module_path('Product', 'Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapAdminRoutes(): void
    {
        Route::middleware('admin')
            ->namespace($this->moduleNamespace . '\admin')
            ->prefix(config('services.admin.prefix'))
            ->name('admin.')
            ->controller(\Modules\Product\Http\Controllers\admin\ProductController::class)
            ->group(module_path('Product', 'Routes/admin.php'));
    }
}
