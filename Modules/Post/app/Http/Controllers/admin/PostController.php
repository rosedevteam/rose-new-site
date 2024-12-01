<?php

namespace Modules\Post\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Modules\Post\Models\Post;

class PostController extends Controller
{
    public function index(): Application|Factory|View
    {
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
            abort(500);
        }
    }

    public function show(Post $post): Application|Factory|View
    {
        Gate::authorize('view-posts');
        try {
            return view('post::admin.show', compact('post'));
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function create(): Application|Factory|View
    {
        Gate::authorize('create-posts');
        try {
            return view('post::admin.create');
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function store()
    {
        Gate::authorize('create-posts');
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        try {
            $post = Post::create([
                'title' => $data['title'],
                'url' => $data['url'],
                'content' => $data['content'],
                'author_id' => auth()->id()
            ]);
            activity()
                ->causedBy(auth()->id())
                ->performedOn($post)
                ->withProperties($data)
                ->log('Post created');
            return redirect(route('admin.post.index'));
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function edit(Post $post): Application|Factory|View
    {
        Gate::authorize('edit-posts');
        try {
            return view('post::admin.edit', compact('post'));
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function update(Post $post)
    {
        Gate::authorize('edit-posts');
        try {
            $data = request()->validate([
                'title' => 'required|string|max:255',
                'url' => 'required|string|max:255',
                'content' => 'required|string',
                'comment_status' => 'required',
                'status' => 'required',
            ]);
            $post->update([
                'title' => $data['title'],
                'url' => $data['url'],
                'content' => $data['content'],
                'comment_status' => $data['comment_status'] == '1',
                'status' => $data['status'],
            ]);
            activity()
                ->causedBy(auth()->id())
                ->performedOn($post)
                ->withProperties($data)
                ->log('Post updated');
            return redirect(route('admin.post.show', compact('post')));
        } catch (\Throwable $th) {
            abort(500);
        }
    }
}
