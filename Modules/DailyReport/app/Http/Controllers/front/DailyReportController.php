<?php

namespace Modules\DailyReport\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Modules\DailyReport\Models\DailyReport;

class DailyReportController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('گزارشات روزانه بازار');
        $dailyReports = DailyReport::all()->sortByDesc('created_at');

        return view('dailyreport::front.index', compact('dailyReports'));
    }

    public function show(DailyReport $dailyReport)
    {
        $filePath = storage_path('app/private/daily-reports/' . $dailyReport->file);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        abort(404);
    }
}
