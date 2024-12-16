<?php

namespace Modules\Discount\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Modules\Discount\Models\Discount;
use Modules\Product\Models\Product;

class DiscountController extends Controller
{
    public function index()
    {
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
                'expires_at' => 'bail|required|string|numeric',
                'amount' => 'bail|required|string',
                'products.*' => 'bail|required|integer|exists:products,id',
            ]);
            $discount = Discount::create([
                'code' => $data['code'],
                'type' => $data['type'],
                'is_active' => $data['is_active'],
                'expires_at' => $data['expires_at'],
                'amount' => $data['amount'],
                'author_id' => auth()->user()->id,
            ]);
            $discount->products()->attach($data['products']);
            activity()
                ->causedBy(auth()->user())
                ->performedOn($discount)
                ->withProperties($data);
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
        $products = Product::all();
        return view('discount::admin.create', compact('products'));
    }
}
