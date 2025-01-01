<?php

namespace Modules\Product\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\traits\Slug;
use App\traits\Upload;
use Artesaos\SEOTools\Traits\SEOTools;
use Gate;
use Illuminate\Support\Arr;
use Modules\Product\Models\Product;

class ProductController extends Controller
{
    use SEOTools, Upload, Slug;

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
        $this->seo()->setTitle('افزودن محصول جدید');
        Gate::authorize('create-products');
        try {
            $categories = Product::allCategories();
            return view('product::admin.create', compact('categories'));
        } catch (\Throwable $th) {
            alert()->error($th->getMessage());
            return back();
        }
    }

    public function store()
    {
        Gate::authorize('create-products');
        try {
            $validatedData = request()->validate([
                'title' => 'required',
                'short_description' => 'required',
                'content' => 'required',
                'price' => 'required|numeric',
                'slug' => 'required|unique:products,slug',
                'spot_player_key' => 'required',
                'sale_price' => 'nullable',
                'comment_status' => 'required',
                'status' => 'required',
                'image' => 'required',
                'attributes' => 'nullable',
                'lessons' => 'nullable',
                'is_free' => 'required',
                'categories.*' => 'nullable|exists:categories,id',
            ]);

            $validatedData['slug'] = self::getSlug($validatedData['slug']);

            $product = auth()->user()->products()->create(Arr::except($validatedData, ['attributes' , 'lessons', 'categories']));

            $validatedData['categories'] = array_filter($validatedData['categories'], function ($category) {
                return !is_null($category);
            });
            $product->categories()->sync($validatedData['categories']);
            $after = json_encode($validatedData, JSON_UNESCAPED_UNICODE);

            if ($validatedData['attributes']) {
                foreach ($validatedData['attributes'] as $attribute) {
                    $path = $this->uploadFile($attribute['icon'] , "/products/attrs");
                    $product->attributes()->create([
                        'title' => $attribute['attr_title'],
                        'subtitle' => $attribute['attr_subtitle'],
                        'icon' =>   '/uploads/' . $path,
                    ]);
                }
            }

            if ($validatedData['lessons']) {
                foreach ($validatedData['lessons'] as $lesson) {
                    $product->lessons()->create([
                        'title' => $lesson['lesson_title'],
                        'duration' => $lesson['lesson_duration'],
                        'file' =>   $lesson['file'],
                    ]);
                }
            }

            activity()
                ->causedBy(auth()->user())
                ->performedOn($product)
                ->withProperties(compact('after'))
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
            $categories = Product::allCategories();
            return view('product::admin.edit', compact('product', 'categories'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function update(Product $product)
    {
        Gate::authorize('edit-products');
        try {
            $validatedData = request()->validate([
                'title' => 'required',
                'short_description' => 'required',
                'content' => 'required',
                'price' => 'required',
                'slug' => 'required',
                'spot_player_key' => 'required',
                'sale_price' => 'nullable',
                'comment_status' => 'required',
                'status' => 'required',
                'image' => 'required',
                'is_free' => 'required',
                'lessons' => 'sometimes|nullable',
                'lessons.*' => 'required',
                'attributes' => 'sometimes|nullable',
                'attributes.*' => 'required',
                'categories.*' => 'nullable|exists:categories,id',
            ]);
            $validatedData['slug'] = self::getSlug($validatedData['slug']);

            if ($validatedData['attributes'] ?? false) {
                foreach ($validatedData['attributes'] as $attribute) {
                    if ($attribute['attr_title']) {
                        $path = $this->uploadFile($attribute['icon'] , "/products/attrs");
                        $product->attributes()->create([
                            'title' => $attribute['attr_title'],
                            'subtitle' => $attribute['attr_subtitle'],
                            'icon' =>   '/uploads/' . $path,
                        ]);
                    }

                }
            }

            if ($validatedData['lessons']) {
                foreach ($validatedData['lessons'] as $lesson) {
                    if ($lesson['lesson_title']) {
                        $product->lessons()->create([
                            'title' => $lesson['lesson_title'],
                            'duration' => $lesson['lesson_duration'],
                            'file' => $lesson['lesson_file'],
                        ]);
                    }
                }
            }

            $before = json_encode($product, JSON_UNESCAPED_UNICODE);
            $product->update(Arr::except($validatedData, ['attributes', 'lessons', 'categories']));
            $after = json_encode($product, JSON_UNESCAPED_UNICODE);

            $validatedData['categories'] = array_filter($validatedData['categories'], function ($category) {
                return !is_null($category);
            });
            $product->categories()->sync($validatedData['categories']);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($product)
                ->withProperties(compact('before', 'after'))
                ->log('ویرایش محصول');
            alert()->success("موفق", "ویرایش با موفقیت انجام شد");

            return redirect(route('admin.products.edit', compact('product')));
        } catch (\Throwable $th) {
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
            $before = json_encode($product, JSON_UNESCAPED_UNICODE);
            $product->delete();

            activity()
                ->causedBy(auth()->user())
                ->withProperties(compact('before'))
                ->log('حذف محصول');
            alert()->success('موفق', 'محصول با موفقیت حذف شد');

            return redirect(route('admin.products.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
