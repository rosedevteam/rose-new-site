<?php

namespace Modules\Product\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;
use Modules\Product\Models\Product;

class ProductController extends Controller
{
    use SEOTools;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->seo()->setTitle('دوره ها');

        $category = request('category');
        $search = request('search');
        $products = Product::query()->where('status' , 'public')->orWhere('status' , 'outofstock');

        if ($category) {
            $products = Product::whereHas('categories', function ($q) use ($category) {
                return $q->where('archive_slug','like' , "$category%");
            });
        }

        if ($search) {
            $products = $products->where('title', 'like', '%' . $search . '%')
                ->orWhere('short_description', 'like', '%' . $search . '%');
        }

        $products = $products->paginate(9)->withQueryString();

        return view('product::front.all', [
            "products" => $products,
            'category' => $category,
            'search' => $search,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show(Product $product)
    {
        if (in_array($product->status, ['draft', 'hidden'])) abort(404);
        return view('product::front.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('product::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
