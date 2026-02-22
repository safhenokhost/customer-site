<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'پنل مدیریت') — {{ \App\Helpers\SiteHelper::siteName() }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Tahoma, Arial, sans-serif; background: #f1f5f9; color: #1e293b; line-height: 1.6; }
        .admin-wrap { display: flex; min-height: 100vh; }
        .sidebar { width: 240px; background: #1e293b; color: #e2e8f0; padding: 1rem 0; }
        .sidebar a { display: block; padding: .6rem 1.25rem; color: #e2e8f0; text-decoration: none; }
        .sidebar a:hover { background: #334155; }
        .sidebar .active { background: #2563eb; }
        .main { flex: 1; padding: 1.5rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        h1 { font-size: 1.35rem; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        th, td { padding: .75rem 1rem; text-align: right; border-bottom: 1px solid #e2e8f0; }
        th { background: #f8fafc; font-weight: 600; }
        .btn { display: inline-block; padding: .5rem 1rem; border-radius: 6px; text-decoration: none; font-size: .9rem; border: none; cursor: pointer; }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-danger { background: #dc2626; color: #fff; }
        .btn-secondary { background: #64748b; color: #fff; }
        .alert { padding: .75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        label { display: block; margin-bottom: .35rem; font-weight: 600; }
        input[type="text"], input[type="email"], input[type="number"], input[type="url"], textarea, select { width: 100%; padding: .5rem .75rem; border: 1px solid #cbd5e1; border-radius: 6px; margin-bottom: 1rem; }
        textarea { min-height: 120px; }
        .form-group { margin-bottom: 1rem; }
        .mb-2 { margin-bottom: 1rem; }
        [type="checkbox"] { width: auto; margin-left: .5rem; }
    </style>
</head>
<body>
    <div class="admin-wrap">
        <aside class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">داشبورد</a>
            <a href="{{ route('admin.pages.index') }}" class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">صفحات</a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">دسته‌بندی‌های وبلاگ</a>
            <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">مطالب وبلاگ</a>
            @if(\App\Helpers\SiteHelper::shopEnabled())
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">محصولات</a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">سفارشات</a>
            @endif
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">تنظیمات</a>
            <a href="{{ route('admin.license.index') }}" class="{{ request()->routeIs('admin.license.*') ? 'active' : '' }}">لایسنس</a>
            <a href="{{ url('/') }}" target="_blank">مشاهده سایت</a>
            <form method="post" action="{{ route('logout') }}" style="padding: .6rem 1.25rem;">
                @csrf
                <button type="submit" class="btn btn-secondary" style="width:100%;text-align:right;">خروج</button>
            </form>
        </aside>
        <main class="main">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
