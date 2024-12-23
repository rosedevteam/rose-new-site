<?php

namespace Modules\Discount\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Gate;
use Modules\Discount\Models\Discount;
use Modules\Product\Models\Product;
use Verta;

class DiscountController extends Controller
{
    use SEOTools;
    public function index()
    {
        $this->seo()->setTitle('تخفیف ها');
        Gate::authorize('view-discounts');
        try {

            $sort_direction = request()->input('sort_direction', 'desc');
            $search = request('search');
            $is_active = request('is_active', 'all');
            $type = request('type', 'all');
            $count = request('count', 50);
            $discounts = Discount::query();

            if ($is_active != 'all') {
                $discounts = $discounts->where('is_active', $is_active == '1');
            }
            if ($type != 'all') {
                $discounts = $discounts->where('type', $type);
            }
            if (!is_null($search)) {
                $discounts = $discounts->where('code', 'like', '%' . $search . '%');
            }

            $discounts = $discounts->orderBy('create_at', $sort_direction)->paginate($count);

            return view('discount::admin.index', compact(
                'discounts',
                'sort_direction',
                'search',
                'type',
                'count',
                'is_active'
            ));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function store()
    {
        Gate::authorize('create-discounts');
        try {

            $data = request()->validate([
                'code' => 'bail|required|string|unique:discounts,code',
                'type' => 'bail|required|string|in:amount,percentage',
                'is_active' => 'bail|required|integer|in:0,1',
                'amount' => 'bail|required|string',
                'products.*' => 'bail|required|integer|exists:products,id',
                'expires_at' => 'bail|required|string',
                'limit' => 'bail|required|string|numeric',
            ]);

            $data['expires_at'] = self::formatDate($data['expires_at']);
            $discount = Discount::create([
                'code' => $data['code'],
                'type' => $data['type'],
                'is_active' => $data['is_active'],
                'amount' => $data['amount'],
                'expires_at' => $data['expires_at'],
                'limit' => $data['limit'],
                'user_id' => auth()->user()->id,
            ]);
            $discount->products()->attach($data['products']);

            activity()
                ->withProperties([auth()->user()->name(), $discount->code, $data])
                ->log('ساخت تخفیف');
            alert()->success('موفق', 'تخفیف با موفقیت ساخته شد');

            return redirect(route('admin.discounts.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function create()
    {
        Gate::authorize('create-discounts');
        try {
            $products = Product::all();
            return view('discount::admin.create', compact('products'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function edit(Discount $discount)
    {
        Gate::authorize('view-discounts');
        try {
            $products = Product::all();
            return view('discount::admin.edit', compact('discount', 'products'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function update(Discount $discount)
    {
        Gate::authorize('edit-discounts');
        try {
            $data = request();
            if ($data['code'] == $discount->code) {
                $data['code'] = null;
            }
            $data = $data->validate([
                'code' => 'bail|nullable|string|unique:discounts,code',
                'type' => 'bail|required|string|in:amount,percentage',
                'is_active' => 'bail|required|integer|in:0,1',
                'amount' => 'bail|required|string',
                'products.*' => 'bail|required|integer|exists:products,id',
                'expires_at' => 'bail|required|string',
                'limit' => 'bail|required|string|numeric',
            ]);
            $data['expires_at'] = self::formatDate($data['expires_at']);

            $old = $discount->toArray();
            $old += $discount->products->toArray();
            $discount->update([
                'code' => $data['code'] ?: $discount->code,
                'type' => $data['type'],
                'is_active' => $data['is_active'],
                'expires_at' => $data['expires_at'],
                'amount' => $data['amount'],
                'limit' => $data['limit'],
            ]);
            $discount->products()->sync($data['products']);

            activity()
                ->withProperties([auth()->user()->name(), $discount->code, $data])
                ->log('ویرایش تخفیف');
            alert()->success('موفق', 'تخفیف با موفقیت ویرایش شد');

            return redirect(route('admin.discounts.edit', $discount));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function destroy(Discount $discount)
    {
        Gate::authorize('delete-discounts');
        try {

            $discount->delete();

            activity()
                ->withProperties([auth()->user()->name(), $discount->code])
                ->log('حذف تخفیف');
            alert()->success('موفق', 'تخفیف با موفقیت حذف شد');
            return redirect(route('admin.discounts.index'));
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
