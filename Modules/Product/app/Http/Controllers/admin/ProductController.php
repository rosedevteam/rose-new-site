<?php

namespace Modules\Product\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Gate;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        Gate::authorize('create-products');
        try {
            $validatedData = $request->validate([
                'title' => 'required',
                'short_description' => 'required',
                'content' => 'required',
                'price' => 'required',
                'slug' => 'required',
                'spot_player_key' => 'required',
                'sale_price' => 'required',
                'comment_status' => 'required',
                'status' => 'required',
                'image' => 'required'
            ]);
            $validatedData['slug'] = implode('-', explode(' ', $validatedData['slug']));

            $product = auth()->user()->products()->create($validatedData);

            activity()
                ->withProperties([auth()->user()->name(), $product->title, $validatedData])
                ->log('ساخت محصول');
            alert()->success("موفق", "با موفقیت انجام شد");

            return redirect(route('admin.products.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function edit(Product $product)
    {
        Gate::authorize('edit-products');
        try {
            return view('product::admin.edit', compact('product'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function update(Request $request, Product $product)
    {
        Gate::authorize('edit-products');
        try {
            $validatedData = $request->validate([
                'title' => 'required',
                'short_description' => 'required',
                'content' => 'required',
                'price' => 'required',
                'slug' => 'required',
                'spot_player_key' => 'required',
                'sale_price' => 'required',
                'comment_status' => 'required',
                'status' => 'required',
                'image' => 'required'
            ]);
            $validatedData['slug'] = implode('-', explode(' ', $validatedData['slug']));

            $old = $product->toArray();
            $product->update($validatedData);


//            $product->categories()->sync($validatedData['categories']);

            activity()
                ->withProperties([auth()->user()->name(), $product->title, $validatedData])
                ->log('ویرایش پست');
            alert()->success("موفق", "ویرایش با موفقیت انجام شد");

            return redirect(route('admin.products.edit', compact('product')));
        }catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
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
        Gate::authorize('delete-products');
        try {

            $product->delete();

            activity()
                ->causedBy(auth()->user())
                ->performedOn($product)
                ->withProperties([auth()->user(), $product])
                ->log('حذف محصول');
            alert()->success('موفق', 'محصول با موفقیت حذف شد');

            return redirect(route('admin.products.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
