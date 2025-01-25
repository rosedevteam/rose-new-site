<?php

namespace Modules\Statistics\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Gate;
use Modules\Cart\Models\Cart;

class StatisticsCartController extends Controller
{

    public function index()
    {
        Gate::authorize('view-statistics');
        return view('statistics::admin.carts');
    }

    public function reserves()
    {
        Gate::authorize('view-statistics');

        $cart = Cart::all();

        $cartsSorted = $cart->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('y-m-d');
        });

        foreach ($cartsSorted as $order) {
            foreach ($order as $index => $value) {
                $priceByDay[Carbon::parse($value->order_date)->format('y-m-d')][] = $value->order_total;
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
            'carts_count' => array_values($orderCounts),
        ]);
    }
}
