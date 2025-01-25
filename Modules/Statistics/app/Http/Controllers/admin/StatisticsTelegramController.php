<?php

namespace Modules\Statistics\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Gate;
use Modules\Subscription\Models\Telegram;

class StatisticsTelegramController extends Controller
{

    public function index()
    {
        Gate::authorize('view-statistics');
        return view('statistics::admin.reserves');
    }

    public function reserves()
    {
        $telegrams = Telegram::orderBy('created_at', 'asc')->where('is_deleted', 0)->get();
        $telegramsDeleted = Telegram::orderBy('deleted_date', 'asc')->where('is_deleted', 1)->get();
        $telegramSorted = $telegrams->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('y-m-d');
        });

        $telegramDeletedSorted = $telegramsDeleted->groupBy(function ($item) {
            return Carbon::parse($item->deleted_date)->format('y-m-d');
        });

        foreach ($telegramSorted as $index => $telegram) {
            $addedUsers[Carbon::parse($index)->unix()] = [
                Carbon::parse($index)->getTimestampMs(),
                count($telegram)
            ];
        }


        foreach ($telegramDeletedSorted as $index => $telegram) {
            $deletedUsers[Carbon::parse($index)->unix()] = [
                Carbon::parse($index)->getTimestampMs(),
                count($telegram)
            ];
        }


        usort($addedUsers, function ($a, $b) {
            return $a[0] > $b[0];
        });

        usort($deletedUsers, function ($a, $b) {
            return $a[0] > $b[0];
        });

        return response()->json([
            'start_date' => [
                'year' => Carbon::parse(min(array_keys($addedUsers)))->format('Y'),
                'month' => Carbon::parse(min(array_keys($addedUsers)))->format('m'),
                'day' => Carbon::parse(min(array_keys($addedUsers)))->format('d'),
            ],
            'date' => array_keys($addedUsers),
            'total' => array_values($addedUsers),
            'data' => array_values($addedUsers),
            'deleted' => array_values($deletedUsers)
        ]);
    }
}
