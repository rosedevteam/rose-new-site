<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Gate;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public function index()
    {
        try {
            return view('admin::index');
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function logIndex()
    {
        Gate::authorize('view-logs');
        try {
            $sort_direction = request('sort_direction', 'desc');
            $count = request('count', 10);
            $search = request('search');
            $logs = Activity::query();
            if (!is_null($search)) {
                $logs = $logs->where('description', 'like', '%' . $search . '%');
            }
            $logs = $logs->orderBy('created_at', $sort_direction);
            $logs = $logs->paginate($count)->withQueryString();
            return view('admin::log.index', compact('logs', 'sort_direction', 'count', 'search'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
