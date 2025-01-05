<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Order\Models\Order;
use Modules\User\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('داشبورد');
        try {

            $userCount = User::all()->count();
            $orderCount = Order::all()->count();

            $totalSales = Order::pluck('price')->map(function ($item) {
                return (int)$item;
            })->sum();

            $latestOrders = Order::query()->latest()->take(10)->get();

            return view('admin::index', compact('userCount', 'orderCount', 'totalSales', 'latestOrders'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

}
