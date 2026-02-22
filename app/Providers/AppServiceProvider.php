<?php

namespace App\Providers;

use App\Models\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('themes.default.layout', function ($view) {
            if (isset($view->getData()['pages'])) {
                return;
            }
            $view->with('pages', \Illuminate\Support\Facades\Schema::hasTable('pages') ? Page::published()->menu()->get() : collect());
        });
    }
}
