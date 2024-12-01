<?php

namespace Modules\DailyReport\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Validation\Rules\File;
use Modules\DailyReport\Models\DailyReport;

class DailyReportController extends Controller
{
    public function index(): View|Factory|Application
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
            abort(500);
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
            DailyReport::create([
                'title' => $data['date'],
                'file' => $name,
                'author_id' => auth()->user()->id,
            ]);
            return redirect()->route('admin.dailyreport.index');
        } catch (\Throwable $th) {
            abort(500);
        }
    }
}
