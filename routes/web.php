<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController as FrontPageController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\ShopController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\LicenseController as AdminLicenseController;
use App\Http\Controllers\GuideSearchController;
use App\Http\Controllers\Front\SitemapController;

/*
|--------------------------------------------------------------------------
| Install wizard (only when NOT installed; when installed, redirect to /)
|--------------------------------------------------------------------------
*/
Route::middleware('install.check')->group(function () {
    Route::get('/install', [InstallController::class, 'welcome'])->name('install.welcome');
    Route::get('/install/database', [InstallController::class, 'database'])->name('install.database');
    Route::post('/install/database', [InstallController::class, 'storeDatabase'])->name('install.store-database');
    Route::get('/install/admin', [InstallController::class, 'admin'])->name('install.admin');
    Route::post('/install/admin', [InstallController::class, 'storeAdmin'])->name('install.store-admin');
    Route::get('/install/settings', [InstallController::class, 'settings'])->name('install.settings');
    Route::post('/install/settings', [InstallController::class, 'storeSettings'])->name('install.store-settings');
    Route::get('/install/done', [InstallController::class, 'done'])->name('install.done');
});

/*
|--------------------------------------------------------------------------
| Main app (redirect to /install when not installed)
|--------------------------------------------------------------------------
*/
Route::middleware('redirect.if.not.installed')->group(function () {

    // Auth
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

    // Front: corporate + blog + optional shop
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/page/{slug}', [FrontPageController::class, 'show'])->name('page.show');
    Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
    Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
    Route::get('/guide-search', [GuideSearchController::class, 'index'])->name('guide.search');
    Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

    // Shop (optional: check in controller via setting)
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');
    Route::post('/shop/cart/add', [ShopController::class, 'addToCart'])->name('shop.cart.add');
    Route::get('/shop/cart', [ShopController::class, 'cart'])->name('shop.cart');
    Route::post('/shop/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');

    // Admin panel (Persian)
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('pages', AdminPageController::class);
        Route::resource('categories', AdminCategoryController::class)->except('show');
        Route::resource('posts', AdminPostController::class);
        Route::resource('products', AdminProductController::class);
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');
        Route::get('license', [AdminLicenseController::class, 'index'])->name('license.index');
        Route::post('license', [AdminLicenseController::class, 'update'])->name('license.update');
        Route::post('license/check-update', [AdminLicenseController::class, 'checkUpdate'])->name('license.check-update');
        Route::get('/', fn () => redirect()->route('admin.dashboard'));
    });
});
