<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Helpers\SiteHelper;
use App\Models\Post;
use App\Models\Category;
use App\Models\Page;

class BlogController extends Controller
{
    public function index()
    {
        if (! SiteHelper::blogEnabled()) {
            abort(404);
        }
        $posts = Post::published()->latest('published_at')->paginate(9);
        $categories = Category::orderBy('order')->get();
        $pages = Page::published()->menu()->get();
        return view(SiteHelper::view('blog.index'), compact('posts', 'categories', 'pages'));
    }

    public function category(string $slug)
    {
        if (! SiteHelper::blogEnabled()) {
            abort(404);
        }
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = Post::published()->where('category_id', $category->id)->latest('published_at')->paginate(9);
        $categories = Category::orderBy('order')->get();
        $pages = Page::published()->menu()->get();
        return view(SiteHelper::view('blog.index'), compact('posts', 'categories', 'pages', 'category'));
    }

    public function show(string $slug)
    {
        if (! SiteHelper::blogEnabled()) {
            abort(404);
        }
        $post = Post::published()->where('slug', $slug)->firstOrFail();
        $post->increment('view_count');
        $pages = Page::published()->menu()->get();
        return view(SiteHelper::view('blog.show'), compact('post', 'pages'));
    }
}
