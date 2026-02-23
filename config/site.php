<?php

return [
    'name' => env('SITE_NAME', 'سایت شرکتی'),
    'theme' => env('SITE_THEME', 'default'),
    'locale' => env('SITE_LOCALE', 'fa'),

    /*
    | آدرس سایت پلتفرم اصلی (saas-platform) — بدون اسلش آخر.
    |
    | کاربرد:
    | - اعتبارسنجی لایسنس (صفحهٔ لایسنس در پنل)
    | - دریافت تنظیمات UX از پلتفرم: رنگ‌ها، فونت، لوگو، نام پلتفرم
    |
    | اگر خالی بگذارید: لایسنس از طریق API چک نمی‌شود و ظاهر سایت مشتری
    | با همان رنگ و فونت پیش‌فرض (مشابه پلتفرم) نمایش داده می‌شود.
    |
    | مثال (محلی):  http://saas-platform.test
    | مثال (سرور):  https://panel.example.com
    */
    'platform_url' => rtrim(env('PLATFORM_URL', ''), '/'),
];
