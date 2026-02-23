<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Helpers\SiteHelper;
use App\Models\Post;
use App\Models\Product;
use App\Models\Page;
use App\Models\Setting;

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
        $aboutUsEnabled = (bool) Setting::get('about_us_enabled', false);
        $aboutUsTitle = Setting::get('about_us_title', 'درباره ما');
        $aboutUsText = Setting::get('about_us_text', '');

        return view(SiteHelper::view('home'), compact('recentPosts', 'featuredProducts', 'pages', 'aboutUsEnabled', 'aboutUsTitle', 'aboutUsText'));
    }
}
