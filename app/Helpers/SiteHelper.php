<?php

namespace App\Helpers;

use App\Models\Setting;

class SiteHelper
{
    public static function theme(): string
    {
        return Setting::get('theme', config('site.theme', 'default'));
    }

    public static function shopEnabled(): bool
    {
        return Module::enabled('shop');
    }

    public static function blogEnabled(): bool
    {
        return Module::enabled('blog');
    }

    public static function siteName(): string
    {
        return Setting::get('site_name', config('site.name', 'سایت شرکتی'));
    }

    /** View path for current theme: e.g. themes.default */
    public static function view(string $name): string
    {
        return 'themes.' . self::theme() . '.' . $name;
    }
}
