<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Helpers\SiteHelper;
use App\Models\Post;
use App\Models\Product;
use App\Models\Page;

class HomeController extends Controller
{
    public function index()
    {
        $recentPosts = SiteHelper::blogEnabled()
            ? Post::published()->latest('published_at')->take(3)->get()
            : collect();
        $featuredProducts = SiteHelper::shopEnabled()
            ? Product::active()->orderBy('order')->take(4)->get()
            : collect();
        $pages = Page::published()->menu()->get();

        return view(SiteHelper::view('home'), compact('recentPosts', 'featuredProducts', 'pages'));
    }
}
