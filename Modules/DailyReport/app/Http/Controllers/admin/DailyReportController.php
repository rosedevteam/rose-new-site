<?php

namespace Modules\DailyReport\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Gate;
use Illuminate\Validation\Rules\File;
use Modules\DailyReport\Models\DailyReport;

class DailyReportController extends Controller
{
    use SEOTools;
    public function index()
    {
        $this->seo()->setTitle('گزارش های روزانه بازار');
        Gate::authorize('view-daily-reports');
        try {

            $sort_by = request('sort_by', 'created_at');
            $sort_direction = request('sort_direction', 'desc');
            $count = request('count', 50);
            $dailyReports = DailyReport::query();
            $dailyReports = $dailyReports->orderBy($sort_by, $sort_direction);
            $dailyReports = $dailyReports->paginate($count)->withQueryString();

            return view('dailyreport::admin.index', compact(
                'dailyReports',
                'sort_by',
                'sort_direction',
                'count'
            ));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function store()
    {
        Gate::authorize('create-daily-reports');
        $data = request()->validate([
            'date' => 'bail|required|string',
            'file' => [
                'bail',
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
                'user_id' => auth()->user()->id,
            ]);

            activity()
                ->withProperties([auth()->user()->name(), $dailyReport->title, $data])
                ->log('ساخت گزارش روزانه');
            alert()->success("موفق", "با موفقیت انجام شد");

            return redirect(route('admin.dailyreports.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function destroy(DailyReport $dailyreport)
    {
        Gate::authorize('delete-daily-reports');
        try {

            $dailyreport->delete();

            activity()
                ->withProperties([auth()->user()->name(), $dailyreport->title])
                ->log('حذف گزارش روزانه');
            alert()->success('موفق', 'گزارش روزانه با موفقیت حذف شد');

            return redirect(route('admin.dailyreports.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
