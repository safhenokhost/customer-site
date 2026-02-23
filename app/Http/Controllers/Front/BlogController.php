<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Helpers\SiteHelper;
use App\Models\Post;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if (! SiteHelper::blogEnabled()) {
            abort(404);
        }
        $query = Post::published()->latest('published_at');
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($qb) use ($search) {
                $qb->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }
        $posts = $query->paginate(9)->withQueryString();
        $categories = Category::orderBy('order')->get();
        $pages = Page::published()->menu()->get();
        return view(SiteHelper::view('blog.index'), compact('posts', 'categories', 'pages'));
    }

    public function category(Request $request, string $slug)
    {
        if (! SiteHelper::blogEnabled()) {
            abort(404);
        }
        $category = Category::where('slug', $slug)->firstOrFail();
        $query = Post::published()->where('category_id', $category->id)->latest('published_at');
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($qb) use ($search) {
                $qb->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }
        $posts = $query->paginate(9)->withQueryString();
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
