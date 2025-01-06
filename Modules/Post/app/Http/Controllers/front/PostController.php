<?php

namespace Modules\Post\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Category\Models\Category;
use Modules\Post\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = request('category');
        $search = request('search');

        $posts = Post::query()->where('status', 'public');

        if ($category) {
            $posts = $posts->whereHas('categories', function ($query) use ($category) {
                $query->where('archive_slug', $category);
            });
        }

        if ($search) {
            $posts = $posts->where('title', 'like', '%' . $search . '%');
        }

        $posts = $posts->paginate(9)->withQueryString();

        $categories = Category::where('archive_slug', "!=", null)
            ->where('type', 'post')
            ->withCount('posts')
            ->where('posts_count', '!=', 0)
            ->get();

        return view('post::front.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post::create');
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
    public function show(Post $post)
    {
        return view('post::front.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('post::edit');
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
