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

            $posts = $posts->orderBy($sort_by, $sort_direction);
            $posts = $posts->paginate($count)->withQueryString();

            return view('post::admin.index', [
                'posts' => $posts,
                'sort_by' => $sort_by,
                'sort_direction' => $sort_direction,
                'status' => $status,
                'comment_status' => $comment_status,
                'search' => $search,
                'count' => $count,
            ]);
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

            return view('post::admin.create');
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
        ]);
        try {

            $data['slug'] = implode('-', explode(' ', $data['slug']));
            $post = Post::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'content' => $data['content'],
                'comment_status' => $data['comment_status'] == 1,
                'user_id' => auth()->user()->id,
                'status' => $data['status'],
            ]);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($post)
                ->withProperties([auth()->user(), $post, $data])
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

            return view('post::admin.edit', compact('post'));
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
            ]);

            $data['slug'] = implode('-', $data['slug']);
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

            activity()
                ->causedBy(auth()->id())
                ->performedOn($post)
                ->withProperties([auth()->user(), $post, $old, $data])
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
                ->causedBy(auth()->user())
                ->performedOn($post)
                ->withProperties([auth()->user(), $post])
                ->log('حذف پست');
            alert()->success('موفق', 'پست با موفقیت حذف شد');

            return redirect(route('admin.posts.index'));
        } catch (\Throwable $th) {
            alert()->error("خطا", $th->getMessage());
            return back();
        }
    }
}
