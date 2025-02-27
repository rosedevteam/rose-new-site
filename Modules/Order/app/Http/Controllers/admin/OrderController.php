<?php

namespace Modules\Order\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Modules\Order\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        Gate::authorize('view-orders');
        try {
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
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function create()
    {
        Gate::authorize('create-orders');
        try {
            return view('order::admin.create');
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function store()
    {
        Gate::authorize('create-orders');
        try {
            $data = request()->validate([
                'price' => 'required|numeric',
                'note' => 'required|nullable|string',
                'status' => 'required',
                'payment_method' => 'required',
            ]);
            $order = Order::create($data);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($order)
                ->withProperties($data)
                ->log('ساخت سفارش');
            alert()->success('موفق', 'سفارش با موفقیت ساخته شد');
            return redirect(route('admin.orders.show', compact('order')));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function show(Order $order)
    {
        Gate::authorize('view-orders');
        try {
            return view('order::admin.show', compact('order'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function update(Order $order)
    {
        Gate::authorize('edit-orders');
        try {
            $data = request()->validate([
                'price' => 'nullable|numeric',
                'note' => 'nullable|string',
                'status' => 'nullable',
                'payment_method' => 'nullable',
            ]);
            $data = array_filter($data, function ($value) {
                return !is_null($value);
            });
            $order->update($data);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($order)
                ->withProperties($data)
                ->log('ویرایش سفارش');
            alert()->success('موفق', 'سفارش با موفقیت ساخته شد');
            return redirect(route('admin.orders.show', compact('order')));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function destroy(Order $order)
    {
        Gate::authorize('delete-orders');
        try {
            $order->delete();
            activity()
                ->causedBy(auth()->user())
                ->performedOn($order)
                ->log('حذف سفارش');
            alert()->success('موفق', 'سفارش با موفقیت حذف شد');
            return redirect(route('admin.orders.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
