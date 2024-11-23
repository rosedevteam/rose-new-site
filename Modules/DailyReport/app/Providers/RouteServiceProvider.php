<?php

namespace Modules\DailyReport\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'DailyReport';
    protected string $moduleNamespace = 'Modules\DailyReport\Http\Controllers';
    protected string $routeNamePersian = 'گزارش-روزانه-بازار';

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
            ->prefix('/' . $this->routeNamePersian)
            ->namespace("daily-report")
            ->group(module_path('DailyReport', 'Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web', 'admin'])
            ->namespace($this->moduleNamespace . '\admin')
            ->prefix(config('services.admin.prefix') . "/" . $this->routeNamePersian)
            ->name('admin.daily-report.')
            ->group(module_path('DailyReport', 'Routes/admin.php'));
    }
}
