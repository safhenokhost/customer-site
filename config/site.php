<?php

return [
    'name' => env('SITE_NAME', 'سایت شرکتی'),
    'theme' => env('SITE_THEME', 'default'),
    'locale' => env('SITE_LOCALE', 'fa'),

    /*
    | سایت مالک (فروش شما): وقتی true باشد، لایسنس برای کارکرد سایت الزامی نیست.
    | ماژول‌ها از .env (MODULE_BLOG_ENABLED و غیره) و ظاهر از پیش‌فرض پلتفرم استفاده می‌شود.
    | در صورت وارد کردن لایسنس، بروزرسانی و UX از پلتفرم دریافت می‌شود.
    */
    'owner_site' => filter_var(env('OWNER_SITE', false), FILTER_VALIDATE_BOOLEAN),

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
