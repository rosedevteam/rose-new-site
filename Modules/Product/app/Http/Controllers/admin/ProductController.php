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
        $sort_by = request('sort_by');
        $sort_direction = request('sort_direction', 'asc');
        $search = request('search');
        $count = request('count', 10);
        $products = Product::query();
        if ($search) {
            $products = $products->where('title', 'like', '%' . $search . '%')
                ->orWhere('short_description', 'like', '%' . $search . '%');
        }
        if ($sort_by || $sort_direction) {
            $products = $products->orderBy($sort_by, $sort_direction);
        }
        $products = $products->paginate($count)->withQueryString();
        return view('product::admin.index', [
            "products" => $products,
            'sort_by' => $sort_by,
            'sort_direction' => $sort_direction,
            'search' => $search,
            'count' => $count,
        ]);
    }
}
