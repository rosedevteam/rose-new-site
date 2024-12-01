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
        $sort_by = request('sort_by', 'created_at');
        $sort_direction = request('sort_direction', 'desc');
        $search = request('search');
        $count = request('count', 50);
        $status = request('status', 'all');
        $comment_status = request('comment_status', true);
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
    }

    public function show(Post $post): Application|Factory|View
    {
        Gate::authorize('view-posts');
        return view('post::admin.show', $post);
    }
}
