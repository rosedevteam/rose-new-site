<?php

namespace Modules\Product\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Modules\Product\Models\Product;

class ProductController extends Controller
{
    public function index(): Application|Factory|View
    {
        Gate::authorize('view-products');
        try {
            $sort_by = request('sort_by', 'created_at');
            $sort_direction = request('sort_direction', 'desc');
            $search = request('search');
            $count = request('count', 50);
            $products = Product::query();
            if ($search) {
                $products = $products->where('title', 'like', '%' . $search . '%')
                    ->orWhere('short_description', 'like', '%' . $search . '%');
            }
            $products = $products->orderBy($sort_by, $sort_direction);
            $products = $products->paginate($count)->withQueryString();
            return view('product::admin.index', [
                "products" => $products,
                'sort_by' => $sort_by,
                'sort_direction' => $sort_direction,
                'search' => $search,
                'count' => $count,
            ]);
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function show(Product $product): Application|Factory|View
    {
        Gate::authorize('view-products');
        try {
            return view('product::admin.show', $product);
        } catch (\Throwable $th) {
            abort(500);
        }
    }
}
