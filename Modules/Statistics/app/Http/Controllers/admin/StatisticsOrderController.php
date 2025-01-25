<?php

namespace Modules\Statistics\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Gate;
use Modules\Order\Models\Order;

class StatisticsOrderController extends Controller
{
    public function index()
    {
        Gate::authorize('view-statistics');
        $total = Order::where('status', 'completed')->sum('price');
        return view('statistics::admin.orders', compact('total'));
    }

    public function orders()
    {
        Gate::authorize('view-statistics');
        $orders = Order::orderBy('created_at', 'asc')->where('status', 'completed')->where('price', '>', 0)->get();
        $ordersSorted = $orders->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('y-m-d');
        });
        foreach ($ordersSorted as $order) {
            foreach ($order as $index => $value) {
                $priceByDay[Carbon::parse($value->created_at)->format('y-m-d')][] = $value->price;
            }
        }

        foreach ($priceByDay as $index => $price) {
            $sumPrices[Carbon::parse($index)->unix()] = [
                Carbon::parse($index)->getTimestampMs(),
                array_sum($price)
            ];

            $orderCounts[Carbon::parse($index)->unix()] = [
                Carbon::parse($index)->getTimestampMs(),
                count($price)
            ];
        }
        usort($sumPrices, function ($a, $b) {
            return $a[0] > $b[0];
        });
        usort($orderCounts, function ($a, $b) {
            return $a[0] > $b[0];
        });
        return response()->json([
            'start_date' => [
                'year' => Carbon::parse(min(array_keys($sumPrices)))->format('Y'),
                'month' => Carbon::parse(min(array_keys($sumPrices)))->format('m'),
                'day' => Carbon::parse(min(array_keys($sumPrices)))->format('d'),
            ],
            'date' => array_keys($sumPrices),
            'total' => array_values($sumPrices),
            'data' => array_values($sumPrices),
            'orders_count' => array_values($orderCounts)
        ]);
    }
}
