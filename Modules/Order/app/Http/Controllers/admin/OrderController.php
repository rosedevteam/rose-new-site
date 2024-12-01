<?php

namespace Modules\Order\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Modules\Order\Models\Order;

class OrderController extends Controller
{
    public function index(): Application|Factory|View
    {
        Gate::authorize('view-orders');
        $sort_by = request('sort_by', 'created_at');
        $sort_direction = request('sort_direction', 'desc');
        $status = request('status', 'all');
        $paymentMethod = request('payment_method', 'all');
        $count = request('count', 50);
        $orders = Order::query();
        if ($status !== 'all') {
            $orders = $orders->where('status', $status);
        }
        if ($paymentMethod !== 'all') {
            $orders = $orders->where('payment_method', $paymentMethod);
        }
        $orders = $orders->orderBy($sort_by, $sort_direction);
        $orders = $orders->paginate($count)->withQueryString();
        return view('order::admin.index', [
            'orders' => $orders,
            'sort_by' => $sort_by,
            'payment_method' => $paymentMethod,
            'status' => $status,
            'sort_direction' => $sort_direction,
            'count' => $count,
        ]);
    }
}
