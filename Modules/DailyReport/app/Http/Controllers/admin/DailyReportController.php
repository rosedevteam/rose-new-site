<?php

namespace Modules\DailyReport\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Validation\Rules\File;
use Modules\DailyReport\Models\DailyReport;

class DailyReportController extends Controller
{
    public function index()
    {
        Gate::authorize('view-daily-reports');
        try {
            $sort_by = request('sort_by', 'created_at');
            $sort_direction = request('sort_direction', 'desc');
            $count = request('count', 50);
            $dailyReports = DailyReport::query();
            $dailyReports = $dailyReports->orderBy($sort_by, $sort_direction);
            $dailyReports = $dailyReports->paginate($count)->withQueryString();
            return view('dailyreport::admin.index', [
                'dailyReports' => $dailyReports,
                'sort_by' => $sort_by,
                'sort_direction' => $sort_direction,
                'count' => $count,
            ]);
        } catch (\Throwable $th) {
            alert()->error("خطا", "خطایی رخ داد");
            return back();
        }
    }

    public function store()
    {
        Gate::authorize('create-daily-reports');
        $data = request()->validate([
            'date' => 'required|string',
            'file' => [
                'required',
                File::types(['pdf'])
            ],
        ]);
        try {
            $name = 'daily-report-' . now()->timestamp . '.pdf';
            request()->file('file')->storeAs('daily-reports', $name, 'public');
            $dailyReport = DailyReport::create([
                'title' => $data['date'],
                'file' => $name,
                'author_id' => auth()->user()->id,
            ]);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($dailyReport)
                ->log('ساخت گزارش روزانه');
            alert()->success("موفق", "با موفقیت انجام شد");
            return redirect()->route('admin.dailyreport.index');
        } catch (\Throwable $th) {
            alert()->error("خطا", "خطایی رخ داد");
            return back();
        }
    }
}
