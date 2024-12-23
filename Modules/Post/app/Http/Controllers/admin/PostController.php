<?php

namespace Modules\Post\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Traits\SEOTools;
use Gate;
use Illuminate\Http\Request;
use Modules\Post\Models\Post;

class PostController extends Controller
{
    use SEOTools;
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
        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable',
                'comment_status' => 'required|string',
                'status' => 'required|string',
                'categories.*' => 'nullable|exists:categories,id',
            ]);

            $data['slug'] = implode('-', explode(' ', $data['slug']));
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

            activity()
                ->withProperties([auth()->user()->name(), $post->name(), $data])
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
        try {
            $data = request()->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'content' => 'required|string',
                'comment_status' => 'required',
                'status' => 'required',
                'image' => 'nullable',
                'categories.*' => '|nullable|exists:categories,id',
            ]);

            $data['slug'] = implode('-', explode(' ', $data['slug']));
            $data['comment_status'] = $data['comment_status'] == 1;

            $old = $post->toArray();
            $post->update([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'content' => $data['content'],
                'comment_status' => $data['comment_status'] == '1',
                'status' => $data['status'],
                'image' => $data['image'],
            ]);

            $data['categories'] = array_filter($data['categories'], function ($category) {
                return !is_null($category);
            });
            $post->categories()->sync($data['categories']);

            activity()
                ->withProperties([auth()->user()->name(), $post->title, $data])
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

            $post->delete();

            activity()
                ->withProperties([auth()->user()->name(), $post->title])
                ->log('حذف پست');
            alert()->success('موفق', 'پست با موفقیت حذف شد');

            return redirect(route('admin.posts.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
