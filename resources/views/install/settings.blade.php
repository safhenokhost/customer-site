@extends('install.layout')
@section('title', 'تنظیمات سایت')

<h1>تنظیمات اولیه سایت</h1>

<form method="POST" action="{{ route('install.store-settings') }}">
    @csrf
    <label>نام سایت</label>
    <input type="text" name="site_name" value="{{ old('site_name', 'سایت شرکتی من') }}" required>
    <label>قالب</label>
    <select name="theme" style="width:100%;padding:.6rem .75rem;border:1px solid #ddd;border-radius:6px;margin-bottom:1rem;">
        <option value="default">پیش‌فرض</option>
    </select>
    <p style="font-size:.9rem; color:#64748b; margin-bottom:1rem;">ماژول‌ها (وبلاگ، فروشگاه) از طریق فایل <code>.env</code> فعال یا غیرفعال می‌شوند: <code>MODULE_BLOG_ENABLED</code>, <code>MODULE_SHOP_ENABLED</code></p>
    <div class="mt-2">
        <button type="submit">اتمام نصب</button>
    </div>
</form>
