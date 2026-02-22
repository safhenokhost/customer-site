@extends('install.layout')
@section('title', 'نصب انجام شد')

<h1>نصب با موفقیت انجام شد</h1>
<p class="mb-2">سایت شما آماده استفاده است. از پنل مدیریت می‌توانید صفحات، وبلاگ و در صورت فعال بودن، فروشگاه را مدیریت کنید.</p>
<p class="mb-2"><strong>توصیه امنیتی:</strong> در سرور واقعی پس از نصب، پوشه یا فایل‌های مربوط به مراحل نصب را غیرفعال یا حذف کنید تا کسی نتواند دوباره به نصب دسترسی پیدا کند.</p>
<a href="{{ url('/') }}" style="display:inline-block;background:#2563eb;color:#fff;padding:.65rem 1.25rem;border-radius:6px;text-decoration:none;margin-top:.5rem;">رفتن به صفحه اصلی</a>
<a href="{{ route('login') }}" style="display:inline-block;background:#16a34a;color:#fff;padding:.65rem 1.25rem;border-radius:6px;text-decoration:none;margin-top:.5rem;margin-right:.5rem;">ورود به پنل مدیریت</a>
