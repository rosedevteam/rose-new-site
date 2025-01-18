<?php

namespace Modules\Post\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Modules\Category\Models\Category;
use Modules\Post\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('وبلاگ');
        $category = request('category');
        $search = request('search');

        $posts = Post::where('status', 'public');

        if ($category) {
            $posts = $posts->whereHas('categories', function ($query) use ($category) {
                $query->where('archive_slug', $category);
            });
        }

        if ($search) {
            $posts = $posts->where('title', 'like', '%' . $search . '%');
        }

        $posts->withCount(['comments' => function ($query) {
            $query->where('status', 'approved');
        }]);
        $posts = $posts->orderBy('created_at', 'desc')->paginate(9)->withQueryString();

        $categories = Category::where('archive_slug', "!=", null)
            ->where('type', 'post')
            ->withCount('posts')
            ->where('posts_count', '!=', 0)
            ->get();

        return view('post::front.index', compact('posts', 'categories', 'search'));
    }

    public function show(Post $post)
    {
        if ($post->status != 'public') abort(404);
        $this->seo()->setTitle($post->metadata?->title ?: $post->title);
        $categories = Category::where('archive_slug', "!=", null)
            ->where('type', 'post')
            ->withCount('posts')
            ->where('posts_count', '!=', 0)
            ->get();

        return view('post::front.show', compact('post', 'categories'));
    }
}
