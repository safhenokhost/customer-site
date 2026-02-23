# راهنمای کامل پروژه — پلتفرم SaaS و سایت مشتری

> **جستجو:** با Ctrl+F (یا Cmd+F) می‌توانید عبارت‌هایی مثل `PLATFORM_URL`, `site-config`, `لایسنس`, `ماژول`, `API` و غیره را در این فایل جستجو کنید.
>
> **آپدیت:** این فایل در هر دو پروژه (saas-platform و customer-site) قرار دارد. با هر تغییری در قابلیت‌ها، مسیرها، API، یا تنظیمات، این راهنما باید به‌روز شود.

---

## فهرست (برای جستجوی سریع)

- [۱. نقش پروژه‌ها](#۱-نقش-پروژه‌ها)
- [۲. متغیرهای محیطی (.env)](#۲-متغیرهای-محیطی-env)
- [۳. APIهای پلتفرم](#۳-apiهای-پلتفرم)
- [۴. مسیرهای مهم (Routes)](#۴-مسیرهای-مهم-routes)
- [۵. ساختار پوشه‌ها و فایل‌های کلیدی](#۵-ساختار-پوشه‌ها)
- [۶. دیتابیس و جداول اصلی](#۶-دیتابیس-و-جداول-اصلی)
- [۷. ماژول‌ها و امکانات](#۷-ماژول‌ها-و-امکانات)
- [۸. جریان UX/UI از پلتفرم به سایت مشتری](#۸-جریان-uxui)
- [۹. لایسنس و سایت‌کانفیگ](#۹-لایسنس-و-سایت‌کانفیگ)
- [۱۰. دستورات آرتیزان و کمندها](#۱۰-دستورات-آرتیزان)
- [۱۱. قانون آپدیت این راهنما](#۱۱-قانون-آپدیت-راهنما)

---

## ۱. نقش پروژه‌ها

| پروژه | مسیر | نقش |
|--------|------|-----|
| **saas-platform** | پنل مدیر اصلی | مدیریت مشتریان، سایت‌ها، لایسنس، ماژول‌های هر سایت، تنظیمات UX (رنگ، فونت، لوگو)، فرم‌ها، دسترسی، کپچا، صفحات ثابت. منبع حقیقت برای «سایت چیست و چه امکاناتی دارد». |
| **customer-site** | سایت زیرمجموعه | یکی از سایت‌های مشتری. محتوا (صفحات، وبلاگ، فروشگاه) را خود مشتری مدیریت می‌کند؛ لایسنس، ظاهر (UX) و لیست ماژول‌های مجاز را از پلتفرم می‌گیرد. |

**قانون:** همهٔ مدیریت‌ها (سایت، ماژول، فرم، مشتری، تنظیمات ظاهری) فقط از **saas-platform** انجام می‌شود. **customer-site** مصرف‌کنندهٔ API و تنظیمات پلتفرم است.

---

## ۲. متغیرهای محیطی (.env)

### saas-platform

| متغیر | توضیح | مثال |
|--------|--------|------|
| `APP_NAME` | نام اپلیکیشن | پلتفرم SaaS |
| `APP_URL` | آدرس پایه پلتفرم (برای لینک لوگو در API) | http://saas-platform.test |
| `DB_*` | اتصال دیتابیس | — |
| (سایر متغیرهای استاندارد Laravel) | — | — |

ماژول‌ها و سایت‌ها در پلتفرم از **دیتابیس** و پنل ادمین مدیریت می‌شوند؛ برای فعال/غیرفعال کردن ماژول هر سایت از منوی **سایت‌ها → انتخاب سایت → ماژول‌ها** استفاده کنید.

### customer-site

| متغیر | توضیح | در کدام پروژه |
|--------|--------|----------------|
| `PLATFORM_URL` | آدرس پایهٔ پلتفرم (بدون اسلش آخر). برای اعتبارسنجی لایسنس و دریافت UX از API. | **فقط customer-site** |
| `MODULE_BLOG_ENABLED` | فعال بودن ماژول وبلاگ | **فقط customer-site** |
| `MODULE_SHOP_ENABLED` | فعال بودن ماژول فروشگاه | **فقط customer-site** |
| `SITE_NAME` | نام سایت (پیش‌فرض در config) | customer-site |
| `SITE_THEME` | تم فرانت | customer-site |
| `SITE_LOCALE` | زبان | customer-site |

**جستجو:** `.env` ، `PLATFORM_URL` ، `MODULE_SHOP_ENABLED` ، `MODULE_BLOG_ENABLED`

---

## ۳. APIهای پلتفرم

همهٔ APIها زیر پیشوند `https://پلتفرم/api/` هستند.

### ۳.۱ اعتبارسنجی لایسنس

- **مسیر:** `POST /api/license/validate`
- **پارامترها (بدن):** `license_key` ، `domain`
- **پاسخ موفق:** `valid: true` ، `expires_at` ، `support_expires_at` ، `modules` (آرایهٔ slug ماژول‌ها) ، `site_title`
- **پاسخ خطا:** `valid: false` ، `error`: یکی از `invalid_key` ، `revoked` ، `expired` ، `domain_mismatch` ، `site_inactive`

**جستجو:** `license` ، `validate` ، `api/license`

### ۳.۲ تنظیمات سایت (سایت‌کانفیگ + UX)

- **مسیر:** `GET /api/site-config?license_key=...&domain=...`
- **پارامترها (query):** `license_key` ، `domain`
- **پاسخ موفق (۲۰۰):**  
  `allowed: true` ، `site_title` ، `modules` ، `support_expires_at` ، `ux`: `{ general: { platform_name, logo_url, registration_open }, theme: {...}, font: {...} }`
- **پاسخ خطا (۴۰۳):** `allowed: false` ، `error`

**جستجو:** `site-config` ، `API` ، `ux` ، `theme` ، `font`

### ۳.۳ بررسی بروزرسانی

- **مسیر:** `GET /api/updates/check`
- **پارامترها (query):** `product` ، `license_key` ، `domain` ، اختیاری `current_version`
- **پاسخ:** `allowed` ، `update_available` ، `latest_version` ، `changelog` ، `distributed_at`

**جستجو:** `updates` ، `check`

---

## ۴. مسیرهای مهم (Routes)

### saas-platform (وب)

| نام مسیر | مسیر | توضیح |
|----------|------|--------|
| `home` | `/` | صفحهٔ اصلی |
| `login.show` / `login` | `/login` ، POST `/login` | ورود با موبایل |
| `logout` | POST `/logout` | خروج |
| `register` | `/register` ، POST | ثبت‌نام |
| `page.show` | `/page/{slug}` | صفحهٔ ثابت |
| `admin.dashboard` | `/admin/dashboard` | داشبورد ادمین |
| `admin.sites.index` | `/admin/sites` | لیست سایت‌ها |
| `admin.sites.show` | `/admin/sites/{site}` | نمایش سایت |
| `admin.sites.modules.edit` | `/admin/sites/{site}/modules` | مدیریت ماژول‌های یک سایت |
| `admin.platform-settings.index` | `/admin/platform-settings` | تنظیمات عمومی پلتفرم (نام، لوگو، رنگ، فونت) |
| `admin.customers.index` | `/admin/customers` | مشتری‌ها |
| `admin.forms.index` | `/admin/forms` | فرم‌ها |
| `admin.pages.index` | `/admin/pages` | صفحات ثابت |

**جستجو:** `routes` ، `web.php` ، `admin`

### customer-site (وب)

| نام مسیر | مسیر | توضیح |
|----------|------|--------|
| `login` | `/login` ، POST `/login` | ورود با موبایل |
| `logout` | POST `/logout` | خروج |
| `home` | `/` | صفحهٔ اصلی |
| `page.show` | `/page/{slug}` | صفحه |
| `contact.show` / `contact.submit` | `/contact` | تماس |
| `blog.index` ، `blog.show` | `/blog` ، `/blog/{slug}` | وبلاگ |
| `shop.index` ، `shop.show` ، `shop.cart` ، `shop.checkout` | `/shop` ، ... | فروشگاه (در صورت فعال بودن ماژول) |
| `admin.dashboard` | `/admin/dashboard` | داشبورد ادمین |
| `admin.license.index` | `/admin/license` | لایسنس (وارد کردن کلید و دامنه) |
| `admin.settings.index` | `/admin/settings` | تنظیمات سایت |
| `admin.pages.*` ، `admin.posts.*` ، `admin.products.*` ، `admin.orders.*` | ... | صفحات، مطالب، محصولات، سفارشات |
| `sitemap` | `/sitemap.xml` | نقشهٔ سایت (کش ۱ ساعته؛ برای موتورهای جستجو) |
| `guide.search` | GET `/guide-search?q=` | جستجو در راهنما (JSON) |

**جستجو:** `routes` ، `customer-site` ، `admin` ، `sitemap`

**SEO:** متا (title، description)، canonical، OpenGraph و Twitter Card در layout فرانت؛ JSON-LD (Organization، WebPage، Article، Product) در صفحات مربوط؛ helperهای `Seo::title/description/imageUrl` و `JsonLd::*` در `app/Helpers`.

---

## ۵. ساختار پوشه‌ها

### saas-platform — فایل‌های کلیدی

| مسیر | توضیح |
|------|--------|
| `app/Helpers/PlatformSettings.php` | کلیدهای تنظیمات عمومی، تم، فونت، آپلود؛ متدهای `get` ، `allTheme` ، `allFont` ، `logoUrl` ، `platformName` |
| `app/Http/Controllers/Api/SiteConfigController.php` | API سایت‌کانفیگ؛ برگرداندن `ux` (theme, font, general) در پاسخ |
| `app/Http/Controllers/Api/LicenseController.php` | API اعتبارسنجی لایسنس |
| `app/Http/Controllers/Admin/PlatformSettingsController.php` | ذخیرهٔ تنظیمات عمومی پلتفرم |
| `app/Http/Controllers/Admin/SiteModuleController.php` | ویرایش ماژول‌های هر سایت (با توجه به pivot `site_module_id` در site_module_features) |
| `app/Models/Site.php` | رابطهٔ `modules()` ؛ متد `getEnabledModuleFeatureIds()` برای فیچرهای فعال سایت |
| `app/Models/Setting.php` | ذخیرهٔ key/value تنظیمات |
| `app/Services/LicenseServerService.php` | اعتبارسنجی لایسنس و برگرداندن ماژول‌های سایت |
| `resources/views/partials/platform-styles.blade.php` | خروجی CSS متغیرهای تم و فونت |
| `resources/views/admin/platform-settings/index.blade.php` | فرم تنظیمات عمومی پلتفرم |
| `routes/api.php` | مسیرهای API |
| `routes/web.php` | مسیرهای وب |

**جستجو:** `PlatformSettings` ، `SiteConfigController` ، `LicenseServerService` ، `platform-styles`

### customer-site — فایل‌های کلیدی

| مسیر | توضیح |
|------|--------|
| `app/Helpers/PlatformUx.php` | دسترسی به نام پلتفرم، لوگو، تم، فونت از کش/API |
| `app/Helpers/Module.php` | `enabled($key)` بر اساس config و .env (MODULE_BLOG_ENABLED ، MODULE_SHOP_ENABLED) |
| `app/Helpers/SiteHelper.php` | `siteName()` ، `shopEnabled()` ، `blogEnabled()` ، `theme()` |
| `app/Services/PlatformUxService.php` | دریافت و کش UX از API پلتفرم؛ متدهای `getUx` ، `allTheme` ، `allFont` ، `platformName` ، `logoUrl` ، `clearCache()` |
| `app/Services/LicenseActivationService.php` | فراخوانی API لایسنس پلتفرم و ذخیرهٔ نتیجه در مدل License |
| `app/Models/License.php` | `license_key` ، `domain` ، `expires_at` ، `modules` (آرایه) ، `support_expires_at` ؛ متد `current()` |
| `config/site.php` | `platform_url` ، `name` ، `theme` ، `locale` |
| `config/modules.php` | تعریف ماژول‌های blog و shop و env مربوطه |
| `resources/views/partials/platform-styles.blade.php` | استفاده از `PlatformUx::allTheme()` و `allFont()` برای استایل |
| `resources/views/layouts/auth.blade.php` | لایهٔ ورود با لوگو و نام پلتفرم |
| `resources/views/admin/dashboard.blade.php` | داشبورد + بلوک «ماژول‌ها و امکانات از پلتفرم» |
| `routes/web.php` | مسیرهای نصب، فرانت، ادمین، لایسنس |

**جستجو:** `PlatformUx` ، `PlatformUxService` ، `License` ، `Module::enabled`

---

## ۶. دیتابیس و جداول اصلی

### saas-platform

| جدول | توضیح |
|------|--------|
| `sites` | سایت‌های مشتری (عنوان، دامنه، فعال/غیرفعال، support_expires_at و ...) |
| `site_modules` | pivot سایت–ماژول: `site_id` ، `module_id` ، `is_active` |
| `modules` | ماژول‌ها (slug، title، description) |
| `module_features` | فیچرهای هر ماژول (module_id، key، title) |
| `site_module_features` | pivot: `site_module_id` (رفرنس به site_modules) ، `module_feature_id` ، `is_active` — **بدون site_id** |
| `platform_licenses` | لایسنسهای صادرشده (site_id، hash کلید، domain_allowed، expires_at) |
| `settings` | key/value تنظیمات پلتفرم (نام، لوگو، رنگ‌ها، فونت‌ها و ...) |
| `customers` | مشتریان |
| `users` | کاربران پلتفرم (ورود با موبایل) |

**جستجو:** `migration` ، `site_modules` ، `site_module_features` ، `platform_licenses`

### customer-site

| جدول | توضیح |
|------|--------|
| `licenses` | لایسنس فعال (license_key، domain، expires_at، modules، support_expires_at) |
| `users` | کاربران سایت (شامل mobile برای ورود) |
| `pages` ، `posts` ، `categories` | محتوای وبلاگ و صفحات |
| `products` ، `orders` و جداول وابسته | فروشگاه (در صورت فعال بودن ماژول) |
| `settings` | تنظیمات محلی سایت |

**جستجو:** `licenses` ، `migration` ، `customer-site`

---

## ۷. ماژول‌ها و امکانات

### در پلتفرم (saas-platform)

- ماژول‌ها در جدول **modules** تعریف می‌شوند.
- برای هر **سایت** در **site_modules** مشخص می‌شود کدام ماژول با `is_active=1` فعال است.
- API لایسنس و سایت‌کانفیگ لیست **slug** ماژول‌های فعال آن سایت را برمی‌گردانند.
- داشبورد ادمین پلتفرم: بخش **«وضعیت ماژول‌های سایت‌های مشتری»** — جدول سایت × ماژول و لینک «ماژول‌ها» برای هر سایت.
- مدیریت ماژول هر سایت: **سایت‌ها → انتخاب سایت → ماژول‌ها** (یا مسیر `admin.sites.modules.edit`). فیچرهای هر ماژول از طریق جدول **site_module_features** (با **site_module_id**) ذخیره می‌شوند.

**جستجو:** `ماژول` ، `site_modules` ، `SiteModuleController` ، `getEnabledModuleFeatureIds`

### در سایت مشتری (customer-site)

- ماژول‌های قابل استفاده در **config/modules.php** تعریف شده‌اند (مثلاً blog، shop).
- **منبع حقیقت برای فعال/غیرفعال:** در صورت وجود لایسنس معتبر، `SiteHelper::blogEnabled()` و `shopEnabled()` از فیلد **modules** مدل **License** (دریافتی از پلتفرم) استفاده می‌کنند؛ در صورت نبود یا نامعتبر بودن لایسنس، fallback به **.env** (`MODULE_BLOG_ENABLED` ، `MODULE_SHOP_ENABLED`) است.
- لیست ماژول‌های **دریافتی از پلتفرم** در مدل **License** (فیلد `modules`) ذخیره و در داشبورد در بلوک **«ماژول‌ها و امکانات از پلتفرم»** نمایش داده می‌شود.

**جستجو:** `MODULE_BLOG_ENABLED` ، `MODULE_SHOP_ENABLED` ، `Module::enabled` ، `SiteHelper::shopEnabled`

---

## ۸. جریان UX/UI از پلتفرم به سایت مشتری

1. در **پلتفرم** در **تنظیمات عمومی پلتفرم** نام، لوگو، رنگ‌ها (THEME_KEYS) و فونت‌ها (FONT_KEYS) تنظیم می‌شوند و در جدول **settings** ذخیره می‌شوند.
2. **سایت مشتری** با داشتن لایسنس معتبر به **GET /api/site-config?license_key=...&domain=...** درخواست می‌زند.
3. پاسخ شامل **ux** (general، theme، font) است. **PlatformUxService** در customer-site این را کش می‌کند (مثلاً ۱ ساعت).
4. ویوهای ورود و پنل ادمین سایت مشتری از **PlatformUx** (و partial **platform-styles**) استفاده می‌کنند و همان رنگ، فونت و لوگو اعمال می‌شود.
5. پس از **فعال/غیرفعال کردن لایسنس** در سایت مشتری، **PlatformUx::clearCache()** فراخوانی می‌شود تا در درخواست بعدی UX از API دوباره گرفته شود.

**جستجو:** `UX` ، `platform-styles` ، `PlatformUx` ، `theme` ، `font` ، `logo`

---

## ۹. لایسنس و سایت‌کانفیگ

- **صدور لایسنس:** در پلتفرم از بخش سایت یا لایسنس برای یک سایت و دامنه لایسنس صادر می‌شود. کلید فقط یک‌بار نمایش داده می‌شود.
- **فعال‌سازی در سایت مشتری:** در **ادمین → لایسنس** کلید و دامنه وارد می‌شود. **LicenseActivationService** با **POST /api/license/validate** اعتبارسنجی می‌کند و در صورت موفقیت رکورد **licenses** به‌روز می‌شود (شامل modules و support_expires_at).
- **سایت‌کانفیگ:** برای دریافت نام سایت، ماژول‌ها، انقضای پشتیبانی و **ux** از **GET /api/site-config** با همان license_key و domain استفاده می‌شود. پاسخ برای کش UX و نمایش در داشبورد استفاده می‌شود.

**جستجو:** `لایسنس` ، `license_key` ، `site-config` ، `LicenseActivationService`

---

## ۱۰. دستورات آرتیزان و کمندها

### customer-site

| دستور | توضیح |
|--------|--------|
| `php artisan user:set-mobile --email=... --mobile=0912...` | تنظیم موبایل کاربر برای ورود |
| `php artisan user:make-admin --email=...` یا `--id=...` یا `--mobile=...` | ادمین کردن کاربر برای دسترسی به پنل |
| `php artisan migrate` | اجرای مایگریشن‌ها (مثلاً اضافه شدن ستون mobile به users) |

**جستجو:** `artisan` ، `user:set-mobile` ، `user:make-admin`

### saas-platform

- دستورات استاندارد Laravel (migrate، cache:clear و ...). ماژول‌ها و سایت‌ها از پنل ادمین مدیریت می‌شوند.

---

## ۱۱. قانون آپدیت راهنما

- این فایل (**docs/PROJECT-GUIDE.md**) در **هر دو** پروژه (saas-platform و customer-site) قرار دارد و باید **هم‌محتوای** یکدیگر باشند.
- **با هر تغییری** که به موارد زیر مربوط شود، این راهنما باید به‌روز شود:
  - اضافه/حذف مسیر (route) یا کنترلر مهم
  - تغییر یا اضافه شدن API (مسیر، پارامتر، پاسخ)
  - متغیرهای جدید .env یا config
  - جدول یا مایگریشن جدید با نقش مهم
  - قابلیت یا ماژول جدید
  - تغییر در جریان لایسنس، سایت‌کانفیگ یا UX

**جستجو:** `آپدیت` ، `PROJECT-GUIDE` ، `راهنما`

---

*آخرین به‌روزرسانی راهنما: بر اساس ساختار و قابلیت‌های فعلی پروژه.*
