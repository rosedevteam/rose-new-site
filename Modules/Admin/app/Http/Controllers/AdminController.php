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
        return view('admin::index');
    }

    public function logIndex(): Application|Factory|View
    {
        Gate::authorize('view-logs');
        $search = request('search');
        $sort_direction = request('sort_direction', 'desc');
        $count = request('count', 10);
        $logs = Activity::query();
        if ($search) {
            $logs = $logs->where('subject', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orwhere('causer', 'like', '%' . $search . '%');
        }
        $logs = $logs->orderBy('created_at', $sort_direction);
        $logs = $logs->paginate($count)->withQueryString();
        return view('admin::log.index', compact('logs', 'search', 'sort_direction', 'count'));
    }
}
