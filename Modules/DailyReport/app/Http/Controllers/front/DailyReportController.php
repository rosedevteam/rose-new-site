<?php

namespace Modules\DailyReport\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Traits\AwardScore;
use Modules\DailyReport\Models\DailyReport;

class DailyReportController extends Controller
{
    use AwardScore;

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
            $message = null;
            if (!auth()->user()->scores()->where('log', 'daily-report-' . $dailyReport->id)->exists()) {
                $this->awardScore(10, 'daily-report-' . $dailyReport->id, 'دانلود گزارش روزانه');
                $message = 'شما 10 امتیاز گرفتید';
            }

            return response()->json([
                'message' => $message,
                'url' => route('dailyreports.download', $dailyReport)
            ]);
        }
        abort(404);

    }

    public function download(DailyReport $dailyReport)
    {
        $filePath = storage_path('app/private/daily-reports/' . $dailyReport->file);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        abort(404);
    }
}
