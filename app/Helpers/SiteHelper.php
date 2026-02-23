<?php

namespace App\Helpers;

use App\Models\License;
use App\Models\Setting;

class SiteHelper
{
    public static function theme(): string
    {
        return Setting::get('theme', config('site.theme', 'default'));
    }

    /**
     * فعال بودن ماژول فروشگاه: اول از لایسنس/پلتفرم، در غیر صورت از config و .env.
     */
    public static function shopEnabled(): bool
    {
        return self::moduleEnabledFromLicenseOrConfig('shop');
    }

    /**
     * فعال بودن ماژول وبلاگ: اول از لایسنس/پلتفرم، در غیر صورت از config و .env.
     */
    public static function blogEnabled(): bool
    {
        return self::moduleEnabledFromLicenseOrConfig('blog');
    }

    /**
     * منبع حقیقت برای ماژول‌ها پلتفرم است؛ در صورت لایسنس معتبر از modules لایسنس استفاده می‌شود، وگرنه fallback به config + .env.
     * در حالت سایت مالک (OWNER_SITE=true) همیشه از config + .env استفاده می‌شود و لایسنس الزامی نیست.
     */
    protected static function moduleEnabledFromLicenseOrConfig(string $key): bool
    {
        if (self::isOwnerSite()) {
            return Module::enabled($key);
        }
        $license = License::current();
        if ($license && $license->isValid()) {
            $modules = $license->modules ?? [];
            return is_array($modules) && in_array($key, $modules, true);
        }
        return Module::enabled($key);
    }

    /**
     * آیا این نصب به‌عنوان سایت مالک (سایت فروش شما) تنظیم شده است؟
     * در این حالت لایسنس اختیاری است و ماژول‌ها از .env خوانده می‌شوند.
     */
    public static function isOwnerSite(): bool
    {
        return (bool) config('site.owner_site', false);
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
