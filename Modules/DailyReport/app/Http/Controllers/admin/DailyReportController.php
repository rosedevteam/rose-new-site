<?php

namespace Modules\DailyReport\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class DailyReportController extends Controller
{
    public function index(): View|Factory|Application
    {
        Gate::authorize('view-daily-reports', auth()->user());
        return view('dailyreport::admin.index');
    }
}
