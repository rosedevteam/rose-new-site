<?php

namespace Modules\Product\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\traits\Slug;
use App\traits\Upload;
use Gate;
use Illuminate\Support\Arr;
use Modules\Product\Models\Product;

class ProductController extends Controller
{
    use Upload, Slug;

    public function index()
    {
        Gate::authorize('view-products');
        $this->seo()->setTitle('دوره ها');

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
        $validatedData = request()->validate([
            'title' => 'required',
            'short_description' => 'required',
            'content' => 'required',
            'price' => 'required|numeric',
            'slug' => 'required|unique:products,slug',
            'spot_player_key' => 'nullable',
            'sale_price' => 'nullable',
            'comment_status' => 'required',
            'status' => 'required',
            'image' => 'required',
            'attributes' => 'nullable',
            'lessons' => 'nullable',
            'is_free' => 'required',
            'duration' => 'nullable',
            'categories.*' => 'required|exists:categories,id',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
        ]);

        try {
            $validatedData['slug'] = self::getSlug($validatedData['slug']);

            $product = auth()->user()->products()->create(Arr::except($validatedData, ['attributes', 'lessons', 'categories', 'meta_title', 'meta_description', 'meta_keywords']));

            $validatedData['categories'] = array_filter($validatedData['categories'], function ($category) {
                return !is_null($category);
            });
            $product->categories()->sync(Arr::except($validatedData['categories'], ['0']));

            if ($validatedData['attributes']) {
                foreach ($validatedData['attributes'] as $attribute) {
                    if ($attribute['attr_title']) {
                        $path = $this->uploadFile($attribute['icon'], "/products/attrs");
                        $product->attributes()->create([
                            'title' => $attribute['attr_title'],
                            'subtitle' => $attribute['attr_subtitle'],
                            'icon' => '/uploads/' . $path,
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
                            'file' => $lesson['file'],
                        ]);
                    }
                }
            }

            $product->metadata()->create([
                'title' => $validatedData['meta_title'],
                'description' => $validatedData['meta_description'],
                'keywords' => $validatedData['meta_keywords'],
                'user_id' => auth()->user()->id,
            ]);

            $after = Product::with('lessons:id,title', 'attributes:id,title', 'metadata:id,title,keywords,description', 'categories:id,name')->find($product->id)->toArray();

            self::log($product, compact('after'), 'ساخت دوره');
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
        $validatedData = request()->validate([
            'title' => 'required',
            'short_description' => 'required',
            'content' => 'nullable',
            'price' => 'required',
            'slug' => 'required',
            'spot_player_key' => 'nullable',
            'sale_price' => 'nullable',
            'comment_status' => 'required',
            'status' => 'required',
            'image' => 'required',
            'is_free' => 'required',
            'duration' => 'nullable',
            'lessons' => 'sometimes|nullable',
            'attributes' => 'nullable',
            'categories.*' => 'required|exists:categories,id',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
        ]);

        try {
            $validatedData['slug'] = self::getSlug($validatedData['slug']);
            $before = Product::with('lessons:id,title', 'attributes:id,title', 'metadata:id,title,keywords,description', 'categories:id,name')->find($product->id)->toArray();

            if ($validatedData['attributes'] ?? false) {
                foreach ($validatedData['attributes'] as $attribute) {
                    if ($attribute['attr_title']) {
                        $path = $this->uploadFile($attribute['icon'], "/products/attrs");
                        $product->attributes()->create([
                            'title' => $attribute['attr_title'],
                            'subtitle' => $attribute['attr_subtitle'],
                            'icon' => '/uploads/' . $path,
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

            if ($product->metadata()->exists()) {
                $product->metadata()->update([
                    'title' => $validatedData['meta_title'],
                    'description' => $validatedData['meta_description'],
                    'keywords' => $validatedData['meta_keywords'],
                    'user_id' => auth()->user()->id,
                ]);
            } else {
                $product->metadata()->create([
                    'title' => $validatedData['meta_title'],
                    'description' => $validatedData['meta_description'],
                    'keywords' => $validatedData['meta_keywords'],
                    'user_id' => auth()->user()->id,
                ]);
            }

            $product->update(Arr::except($validatedData, ['attributes', 'lessons', 'categories', 'meta_title', 'meta_description', 'meta_keywords']));

            $validatedData['categories'] = array_filter($validatedData['categories'], function ($category) {
                return !is_null($category);
            });
            $product->categories()->sync($validatedData['categories']);

            $after = Product::with('lessons:id,title', 'attributes:id,title', 'metadata:id,title,keywords,description', 'categories:id,name')->find($product->id)->toArray();

            self::log($product, compact('before', 'after'), 'ویرایش دوره');
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
            $before = Product::with('lessons:id,title', 'attributes:id,title', 'metadata:id,title,keywords,description', 'categories:id,name')->find($product->id)->toArray();
            $product->delete();

            self::log(null, compact('before'), 'حذف دوره');
            alert()->success('موفق', 'محصول با موفقیت حذف شد');

            return redirect(route('admin.products.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
