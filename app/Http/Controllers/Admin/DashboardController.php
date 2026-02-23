<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\Module;
use App\Helpers\SiteHelper;
use App\Models\License;
use App\Models\Post;
use App\Models\Product;
use App\Models\Order;
use App\Models\Page;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pages' => Page::count(),
            'posts' => Post::count(),
            'products' => SiteHelper::shopEnabled() ? Product::count() : 0,
            'orders' => SiteHelper::shopEnabled() ? Order::count() : 0,
        ];
        $recentOrders = SiteHelper::shopEnabled()
            ? Order::latest()->take(5)->get()
            : collect();

        $license = License::current();
        $modulesFromPlatform = $license && is_array($license->modules) ? $license->modules : [];
        $localModules = Module::all();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'license',
            'modulesFromPlatform',
            'localModules'
        ));
    }
}
