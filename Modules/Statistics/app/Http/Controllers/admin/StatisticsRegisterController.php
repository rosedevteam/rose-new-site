<?php

namespace Modules\Statistics\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Gate;
use Modules\User\Models\User;

class StatisticsRegisterController extends Controller
{
    public function index()
    {
        Gate::authorize('view-statistics');
        return view('statistics::admin.registers');
    }

    public function registers()
    {
        Gate::authorize('view-statistics');
        $users = User::orderBy('created_at', 'asc')->get();

        $usersSorted = $users->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('y-m-d');
        });
        foreach ($usersSorted as $index => $user) {
            $usersCount[Carbon::parse($index)->unix()] = [
                Carbon::parse($index)->getTimestampMs(),
                count($user)
            ];
        }
        usort($usersCount, function ($a, $b) {
            return $a[0] > $b[0];
        });

        return response()->json([
            'start_date' => [
                'year' => Carbon::parse(min(array_keys($usersCount)))->format('Y'),
                'month' => Carbon::parse(min(array_keys($usersCount)))->format('m'),
                'day' => Carbon::parse(min(array_keys($usersCount)))->format('d'),
            ],
            'date' => array_keys($usersCount),
            'total' => array_values($usersCount),
            'data' => array_values($usersCount)
        ]);
    }
}
