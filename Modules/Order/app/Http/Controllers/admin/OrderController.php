<?php

namespace Modules\Order\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Gate;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Modules\Order\Models\Order;
use Modules\Product\Models\Product;

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

    public function store(Request $request)
    {
        Gate::authorize('create-orders');
        try {
            $validData = request()->validate([
                'user_id' => 'required',
                'created_at' => 'required',
                'products' => 'required',
                'notes' => 'nullable|string',
                'status' => 'required',
                'payment_method' => 'required',
                'watermark' => 'nullable|string',
            ]);

            $validData['created_at'] = self::formatDate($validData['created_at']);

            $total = 0;

            foreach ($validData['products'] as $product) {
                $product = Product::whereId($product)->first();
                $total = ($product->isOnSale() ? $product->sale_price : $product->price) + $total;

            }


            $order = Order::create([
                'user_id' => $validData['user_id'],
                'created_at' => $validData['created_at'],
                'status' => $validData['status'],
                'payment_method' => $validData['payment_method'],
                'notes' => $validData['notes'],
                'price' => $total,
            ]);

            $order->products()->attach($validData['products']);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($order)
                ->withProperties([auth()->user(), $order])
                ->log('ساخت سفارش');
            alert()->success('موفق', 'سفارش با موفقیت ساخته شد');

            return redirect(route('admin.orders.index'));
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

    public function edit(Order $order)
    {
        return view('order::admin.edit', compact('order'));
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

            $old = $order->toArray();
            $order->update($data);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($order)
                ->withProperties([auth()->user(), $order, $old])
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
                ->withProperties([auth()->user(), $order])
                ->log('حذف سفارش');
            alert()->success('موفق', 'سفارش با موفقیت حذف شد');

            return redirect(route('admin.orders.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    protected static function formatDate(string $d)
    {
        $expires_at = self::convertNums($d);
        $t = explode(' ', $expires_at);
        $date = explode('/', $t[0]);
        $verta = Verta::jalaliToGregorian($date[0], $date[1], $date[2]);
        return $verta[0] . '/' . $verta[1] . '/' . $verta[2] . ' ' . $t[1];
    }

    protected static function convertNums($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        return str_replace($arabic, $num, $convertedPersianNums);
    }
}
