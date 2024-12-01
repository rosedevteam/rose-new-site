<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public function index(): Application|Factory|View
    {
        try {
            return view('admin::index');
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function logIndex(): Application|Factory|View
    {
        Gate::authorize('view-logs');
        try {
            $sort_direction = request('sort_direction', 'desc');
            $count = request('count', 10);
            $logs = Activity::query();
            $logs = $logs->orderBy('created_at', $sort_direction);
            $logs = $logs->paginate($count)->withQueryString();
            return view('admin::log.index', compact('logs', 'sort_direction', 'count'));
        } catch (\Throwable $th) {
            abort(500);
        }
    }
}
