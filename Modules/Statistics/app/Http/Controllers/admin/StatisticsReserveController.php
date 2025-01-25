<?php

namespace Modules\Statistics\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Gate;
use Modules\Reserve\Models\Reserve;

class StatisticsReserveController extends Controller
{
    public function index()
    {
        Gate::authorize('view-statistics');
        return view('statistics::admin.reserves');
    }

    public function reserves()
    {
        Gate::authorize('view-statistics');
        $reserves = Reserve::orderBy('created_at', 'asc')->get();

        $reserveSorted = $reserves->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('y-m-d');
        });
        foreach ($reserveSorted as $index => $reserve) {
            $reservesCount[Carbon::parse($index)->unix()] = [
                Carbon::parse($index)->getTimestampMs(),
                count($reserve)
            ];
        }
        usort($reservesCount, function ($a, $b) {
            return $a[0] > $b[0];
        });

        return response()->json([
            'start_date' => [
                'year' => Carbon::parse(min(array_keys($reservesCount)))->format('Y'),
                'month' => Carbon::parse(min(array_keys($reservesCount)))->format('m'),
                'day' => Carbon::parse(min(array_keys($reservesCount)))->format('d'),
            ],
            'date' => array_keys($reservesCount),
            'total' => array_values($reservesCount),
            'data' => array_values($reservesCount)
        ]);

    }

}
