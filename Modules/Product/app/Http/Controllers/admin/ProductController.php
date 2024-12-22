<?php

namespace Modules\Product\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Gate;
use http\Env\Request;
use Modules\Product\Models\Product;

class ProductController extends Controller
{
    use SEOTools;
    public function index()
    {
        $this->seo()->setTitle('دوره ها');
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
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function create()
    {
        $this->seo('افزودن محصول جدید');
        Gate::authorize('create-products');
        return view('product::admin.create');
    }

    public function store(\Request $request)
    {
        Gate::authorize('create-products');
        try {
//            dd($request->all());
        }catch (\Exception $exception){

        }
    }

    public function edit(Product $product)
    {

    }

    public function update(Request $request, Product $product)
    {

    }

    public function show(Product $product)
    {
        Gate::authorize('view-products');
        try {
            return view('product::admin.show', $product);
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function destroy(Product $product)
    {

    }
}
