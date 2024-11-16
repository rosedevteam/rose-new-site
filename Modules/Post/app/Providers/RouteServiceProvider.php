<?php

namespace Modules\Post\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'Post';
    protected string $moduleNamespace = 'Modules\Post\Http\Controllers';

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
            ->controller(\Modules\Post\Http\Controllers\PostController::class)
            ->group(module_path('Post', 'Routes/web.php'));
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
            ->controller(\Modules\Post\Http\Controllers\admin\PostController::class)
            ->group(module_path('Post', 'Routes/admin.php'));
    }
}
