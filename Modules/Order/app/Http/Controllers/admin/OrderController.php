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
                $spot_keys[] = $product->spot_player_key;
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

            //if status was completed then send a request to spot player api for create license
            if ($order->status == 'completed') {
                $spot_response = self::createSpotPlayerLicence(
                    $order->user->first_name . ' ' . $order->user->last_name,
                    array_filter($spot_keys, null),
                    $validData['watermark'] ? $validData['watermark'] : $order->user->phone);
                $spot = json_decode($spot_response->getContent(), true);

                if ($spot_response->getStatusCode() == 200) {
                    $order->update([
                        'spot_player_id' => $spot['id'],
                        'spot_player_licence' => $spot['key'],
                        'spot_player_log' => $spot['message'],
                        'spot_player_watermark' => $validData['watermark'] ? $validData['watermark'] : $order->user->phone

                    ]);
                } else {
                    $order->update(
                        [
                            'status' => 'pending',
                            'spot_player_log' => $spot['message'],
                            'spot_player_watermark' => $validData['watermark'] ? $validData['watermark'] : $order->user->phone,
                        ]);

                }
            }

            activity()
                ->withProperties([auth()->user()->name(), $order, $validData])
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

    public function update(Request $request , Order $order)
    {
        Gate::authorize('edit-orders');
        try {

            $validData = $request->validate([
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
                $spot_keys[] = $product->spot_player_key;
                $total = ($product->isOnSale() ? $product->sale_price : $product->price) + $total;
            }


            $old = $order->toArray();

            $order->update([
                'user_id' => $validData['user_id'],
                'created_at' => $validData['created_at'],
                'status' => $validData['status'],
                'payment_method' => $validData['payment_method'],
                'notes' => $validData['notes'],
                'price' => $total,
            ]);
            $order->products()->sync($validData['products']);

            activity()
                ->withProperties([auth()->user()->name(), $order, $old])
                ->log('ویرایش سفارش');

            alert()->success('موفق', 'سفارش با موفقیت ,یرایش شد');

            return back();
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
                ->withProperties([auth()->user()->name(), $order])
                ->log('حذف سفارش');
            alert()->success('موفق', 'سفارش با موفقیت حذف شد');

            return redirect(route('admin.orders.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function createSpotPlayerLicence($name, $courses, $watermarks)
    {

        $api_key = config('services.spotplayer.api');

        function filter($a): array
        {
            return array_filter($a, function ($v) {
                return !is_null($v);
            });
        }

        function request($u, $o = null)
        {
            $api_key = config('services.spotplayer.api');
            curl_setopt_array($c = curl_init(), [
                CURLOPT_URL => $u,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => $o ? 'POST' : 'GET',
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_HTTPHEADER => ['$API: ' . $api_key, '$LEVEL: -1', 'content-type: application/json'],
            ]);
            if ($o) curl_setopt($c, CURLOPT_POSTFIELDS, json_encode(filter($o)));
            $json = json_decode(curl_exec($c), true);
            curl_close($c);
            if (is_array($json) && ($ex = @$json['ex'])) throw new \Exception($ex['msg']);
            return $json;
        }

        function license($name, $courses, $watermarks, $test = true)
        {
            return request('https://panel.spotplayer.ir/license/edit/', [
                'test' => false,
                'name' => $name,
                'course' => $courses,
                'watermark' => ['texts' => array_map(function ($w) {
                    return ['text' => $w];
                }, $watermarks)]
            ]);
        }

        try {
            $L = license($name, $courses, [$watermarks], false);
            return response()->json([
                'status' => 'success',
                'id' => ($LID = $L['_id']),
                'key' => $L['key'],
                'url' => 'https://dl.spotplayer.ir/' . $L['url'],
                'message' => 'لایسنس با موفقیت ایجاد شد'
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
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

    public function createSpotLicence(Request $request , Order $order)
    {
        try {
            $validData = $request->validate([
               'watermark' => 'required|string'
            ]);

            foreach ($order->products as $product) {
                $product_spot_keys[] = $product->spot_player_key;
            }

            //todo create licence from admin front
            function filter($a): array
            {
                return array_filter($a, function ($v) {
                    return !is_null($v);
                });
            }

            function request($u, $o = null)
            {
                $api_key = config('services.spotplayer.api');
                curl_setopt_array($c = curl_init(), [
                    CURLOPT_URL => $u,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => $o ? 'POST' : 'GET',
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_HTTPHEADER => ['$API: ' . $api_key, '$LEVEL: -1', 'content-type: application/json'],
                ]);
                if ($o) curl_setopt($c, CURLOPT_POSTFIELDS, json_encode(filter($o)));
                $json = json_decode(curl_exec($c), true);
                curl_close($c);
                if (is_array($json) && ($ex = @$json['ex'])) throw new \Exception($ex['msg']);
                return $json;
            }

            function license($name, $courses, $watermarks, $test = true)
            {
                return request('https://panel.spotplayer.ir/license/edit/', [
                    'test' => false,
                    'name' => $name,
                    'course' => $courses,
                    'watermark' => ['texts' => array_map(function ($w) {
                        return ['text' => $w];
                    }, $watermarks)]
                ]);
            }
            activity()
                ->causedBy(auth()->user())
                ->performedOn($order)
                ->withProperties([auth()->user(), $order])
                ->log('ساخت لایسنس');

            try {

                $L = license($order->user->first_name . ' ' . $order->user->last_name, array_filter($product_spot_keys , null), [$validData['watermark']], false);

                alert()->success('موفق', 'لایسنس با موفقیت ایجاد شد');
                $order->update([
                    'spot_player_id' => ($LID = $L['_id']),
                    'spot_player_licence' => $L['key'],
                    'spot_player_log' => 'لایسنس با موفقیت ایجاد شد',
                    'spot_player_watermark' => $validData['watermark']
                ]);
                return back();
            } catch (\Throwable $e) {
                $order->update(
                    [
                        'status' => 'pending',
                        'spot_player_log' => $e->getMessage(),
                        'spot_player_watermark' => $validData['watermark'] ? $validData['watermark'] : $order->user->phone,
                    ]);

                return back();
            }
        }catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }

    }
}
