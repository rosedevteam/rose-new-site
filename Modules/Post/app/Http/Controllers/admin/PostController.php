<?php

namespace Modules\Post\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\traits\Slug;
use Artesaos\SEOTools\Traits\SEOTools;
use Gate;
use Illuminate\Http\Request;
use Modules\Post\Models\Post;

class PostController extends Controller
{
    use SEOTools, Slug;
    public function index()
    {
        $this->seo()->setTitle('پست ها');
        Gate::authorize('view-posts');
        try {

            $sort_by = request('sort_by', 'created_at');
            $sort_direction = request('sort_direction', 'desc');
            $search = request('search');
            $count = request('count', 50);
            $status = request('status', 'all');
            $comment_status = request('comment_status', 'all');
            $category = request('category', 'all');
            $categories = Post::allCategories();
            $posts = Post::query();

            if ($status !== 'all') {
                $posts = $posts->where('status', $status);
            }
            if ($comment_status !== 'all') {
                $posts = $posts->where('comment_status', $comment_status);
            }
            if ($search) {
                $posts = $posts->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            }
            if($category !== 'all'){
                $posts = $posts->whereRelation('categories', 'category_id', $category);
            }

            $posts = $posts->orderBy($sort_by, $sort_direction);
            $posts = $posts->paginate($count)->withQueryString();

            return view('post::admin.index', compact(
                'posts',
                'categories',
                'sort_by',
                'sort_direction',
                'search',
                'count',
                'category'
            ));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function show(Post $post)
    {
        Gate::authorize('view-posts');
        try {

            return view('post::admin.show', compact('post'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function create()
    {
        Gate::authorize('create-posts');
        try {
            $categories = Post::allCategories();
            return view('post::admin.create', compact('categories'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        Gate::authorize('create-posts');
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable',
            'comment_status' => 'required|string',
            'status' => 'required|string',
            'categories.*' => 'required|nullable|exists:categories,id',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
        ]);

        try {
            $data['slug'] = self::getSlug($data['slug']);
            $post = Post::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'content' => $data['content'],
                'comment_status' => $data['comment_status'] == 1,
                'user_id' => auth()->user()->id,
                'status' => $data['status'],
            ]);
            $data['categories'] = array_filter($data['categories'], function ($category) {
                return !is_null($category);
            });
            $post->categories()->sync($data['categories']);
            $post->metadata()->create([
                'title' => $data['meta_title'],
                'description' => $data['meta_description'],
                'keywords' => $data['meta_keywords'],
                'user_id' => auth()->user()->id,
            ]);
            $after = json_encode($data, JSON_UNESCAPED_UNICODE);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($post)
                ->withProperties(compact('after'))
                ->log('ساخت پست');
            alert()->success("موفق", "با موفقیت انجام شد");

            return redirect(route('admin.posts.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function edit(Post $post)
    {
        Gate::authorize('edit-posts');
        try {
            $categories = Post::allCategories();
            return view('post::admin.edit', compact('post', 'categories'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }

    public function update(Post $post)
    {
        Gate::authorize('edit-posts');
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'required|string',
            'comment_status' => 'required',
            'status' => 'required',
            'image' => 'nullable',
            'categories.*' => 'required|nullable|exists:categories,id',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
        ]);

        try {
            $data['slug'] = self::getSlug($data['slug']);
            $data['comment_status'] = $data['comment_status'] == 1;

            $before = json_encode($data, JSON_UNESCAPED_UNICODE);
            $post->update([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'content' => $data['content'],
                'comment_status' => $data['comment_status'] == '1',
                'status' => $data['status'],
                'image' => $data['image'],
            ]);
            $after = json_encode($data, JSON_UNESCAPED_UNICODE);

            $data['categories'] = array_filter($data['categories'], function ($category) {
                return !is_null($category);
            });
            $post->categories()->sync($data['categories']);

            if ($post->metadata()->exists()) {
                $post->metadata()->update([
                    'title' => $data['meta_title'],
                    'description' => $data['meta_description'],
                    'keywords' => $data['meta_keywords'],
                    'user_id' => auth()->user()->id,
                ]);
            } else {
                $post->metadata()->create([
                    'title' => $data['meta_title'],
                    'description' => $data['meta_description'],
                    'keywords' => $data['meta_keywords'],
                    'user_id' => auth()->user()->id,
                ]);
            }

            activity()
                ->causedBy(auth()->user())
                ->performedOn($post)
                ->withProperties(compact('before', 'after'))
                ->log('ویرایش پست');
            alert()->success("موفق", "ویرایش با موفقیت انجام شد");

            return redirect(route('admin.posts.edit', compact('post')));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }


    public function destroy(Post $post)
    {
        Gate::authorize('delete-posts');
        try {

            $before = json_encode($post, JSON_UNESCAPED_UNICODE);
            $post->delete();

            activity()
                ->causedBy(auth()->user())
                ->withProperties(compact('before'))
                ->log('حذف پست');
            alert()->success('موفق', 'پست با موفقیت حذف شد');

            return redirect(route('admin.posts.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
