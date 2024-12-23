<?php

namespace Modules\Order\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Gate;
use Modules\Order\Models\Order;

class OrderController extends Controller
{
    use SEOTools;
    public function index()
    {
        $this->seo()->setTitle('سفارش ها');
        Gate::authorize('view-orders');
        try {

            $sort_by = request('sort_by', 'created_at');
            $sort_direction = request('sort_direction', 'desc');
            $status = request('status', 'all');
            $payment_method = request('payment_method', 'all');
            $count = request('count', 50);
            $orders = Order::query();

            if ($status !== 'all') {
                $orders = $orders->where('status', $status);
            }
            if ($payment_method !== 'all') {
                $orders = $orders->where('payment_method', $payment_method);
            }

            $orders = $orders->orderBy($sort_by, $sort_direction);
            $orders = $orders->paginate($count)->withQueryString();

            return view('order::admin.index', compact(
                'orders',
                'sort_by',
                'sort_direction',
                'status',
                'payment_method',
                'count',
            ));
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
                ->withProperties([auth()->user()->name(), $order->id])
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
                ->withProperties([auth()->user()->name(), $order->id, $data])
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
                ->withProperties([auth()->user()->name(), $order->id])
                ->log('حذف سفارش');
            alert()->success('موفق', 'سفارش با موفقیت حذف شد');

            return redirect(route('admin.orders.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
