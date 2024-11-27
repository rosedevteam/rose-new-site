<?php

namespace Modules\DailyReport\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Modules\DailyReport\Models\DailyReport;

class DailyReportController extends Controller
{
    public function index(): View|Factory|Application
    {
        Gate::authorize('view-daily-reports');
        $sort_by = request('sort_by');
        $sort_direction = request('sort_direction', 'asc');
        $count = request('count', 10);
        $dailyReports = DailyReport::query();
        if ($sort_by || $sort_direction) {
            $dailyReports = $dailyReports->orderBy($sort_by, $sort_direction);
        }
        $dailyReports = $dailyReports->paginate($count)->withQueryString();
        return view('dailyreport::admin.index', [
            'dailyReports' => $dailyReports,
            'sort_by' => $sort_by,
            'sort_direction' => $sort_direction,
            'count' => $count,
        ]);
    }
}
