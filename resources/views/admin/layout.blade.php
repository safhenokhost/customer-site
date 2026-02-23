<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'پنل مدیریت') — {{ \App\Helpers\SiteHelper::siteName() }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @include('partials.platform-styles')
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--platform-font-body, Vazirmatn, Tahoma, sans-serif); background: #f1f5f9; color: #1e293b; line-height: 1.6; }
        .admin-wrap { display: flex; min-height: 100vh; width: 100%; overflow-x: hidden; align-items: flex-start; }
        .sidebar { width: 240px; min-width: 240px; flex-shrink: 0; position: sticky; top: 0; max-height: 100vh; overflow-y: auto; background: var(--platform-sidebar-bg, #ffffff); color: var(--platform-sidebar-text, #374151); padding: 1rem 0; border-left: 1px solid #e5e7eb; }
        .sidebar .sidebar-brand { padding: .75rem 1.25rem; display: flex; align-items: center; gap: .5rem; border-bottom: 1px solid #e5e7eb; margin-bottom: .5rem; }
        .sidebar .sidebar-brand img { height: 1.75rem; width: auto; }
        .sidebar .sidebar-brand span { font-weight: 700; color: var(--platform-primary, #4f46e5); }
        .sidebar a { display: block; padding: .6rem 1.25rem; color: var(--platform-sidebar-text, #374151); text-decoration: none; }
        .sidebar a:hover { background: var(--platform-sidebar-active-bg, #eff6ff); color: var(--platform-sidebar-active-text, #2563eb); }
        .sidebar a.active { background: var(--platform-sidebar-active-bg, #eff6ff); color: var(--platform-sidebar-active-text, #2563eb); font-weight: 600; }
        .main { flex: 1; min-width: 0; padding: 1.5rem; overflow-x: auto; }
        .main .page-content { margin-top: 0; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        h1, h2, h3 { font-family: var(--platform-font-title, Vazirmatn, Tahoma, sans-serif); color: var(--platform-title-color, #111827); }
        h1 { font-size: 1.35rem; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        th, td { padding: .75rem 1rem; text-align: right; border-bottom: 1px solid #e2e8f0; }
        th { background: #f8fafc; font-weight: 600; }
        .btn { display: inline-block; padding: .5rem 1rem; border-radius: 6px; text-decoration: none; font-size: .9rem; border: none; cursor: pointer; }
        .btn-primary { background: var(--platform-button-primary-bg, #4f46e5); color: var(--platform-button-primary-text, #fff); }
        .btn-primary:hover { background: var(--platform-link-hover, #4338ca); }
        .btn-danger { background: #dc2626; color: #fff; }
        .btn-secondary { background: #64748b; color: #fff; }
        .alert { padding: .75rem 1rem; border-radius: 6px; margin-bottom: 1rem; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        label { display: block; margin-bottom: .35rem; font-weight: 600; }
        input[type="text"], input[type="email"], input[type="number"], input[type="url"], input[type="tel"], textarea, select { width: 100%; padding: .5rem .75rem; border: 1px solid #cbd5e1; border-radius: 6px; margin-bottom: 1rem; font-family: inherit; }
        textarea { min-height: 120px; }
        .form-group { margin-bottom: 1rem; }
        .mb-2 { margin-bottom: 1rem; }
        [type="checkbox"] { width: auto; margin-left: .5rem; }
        a { color: var(--platform-link-color, #4f46e5); }
        a:hover { color: var(--platform-link-hover, #4338ca); }
    </style>
</head>
<body>
    <div class="admin-wrap">
        <aside class="sidebar">
            <div class="sidebar-brand">
                @if(\App\Helpers\PlatformUx::logoUrl())
                    <img src="{{ \App\Helpers\PlatformUx::logoUrl() }}" alt="{{ \App\Helpers\PlatformUx::platformName() }}">
                @endif
                <span>{{ \App\Helpers\PlatformUx::platformName() }}</span>
            </div>
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
    {{-- ویجت راهنما: مستقیم در لایه (بدون وابستگی به PlatformUx) --}}
    <div id="guide-widget-wrap" style="position:fixed;bottom:1.5rem;left:1.5rem;z-index:9997;">
        <button type="button" id="guide-widget-toggle" aria-label="راهنما" style="width:3.5rem;height:3.5rem;border-radius:9999px;background:#2563eb;color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 15px -3px rgba(0,0,0,.1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </button>
    </div>
    <div id="guide-widget-backdrop" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,0.4);"></div>
    <div id="guide-widget-panel" style="display:none;position:fixed;top:0;right:0;width:100%;max-width:24rem;height:100%;z-index:9999;background:#fff;border-left:1px solid #e5e7eb;box-shadow:-10px 0 25px -5px rgba(0,0,0,.1);flex-direction:column;">
        <div style="display:flex;justify-content:space-between;align-items:center;padding:1rem;border-bottom:1px solid #e5e7eb;background:#f9fafb;">
            <h2 style="font-size:1.125rem;font-weight:700;margin:0;">راهنمای استفاده</h2>
            <button type="button" id="guide-widget-close" aria-label="بستن" style="padding:0.5rem;border:none;background:transparent;cursor:pointer;font-size:1.25rem;">✕</button>
        </div>
        <div style="padding:1rem;border-bottom:1px solid #f3f4f6;">
            <input type="text" id="guide-widget-search" placeholder="جستجو در راهنما..." style="width:100%;padding:0.5rem 0.75rem;border:1px solid #d1d5db;border-radius:6px;text-align:right;direction:rtl;">
        </div>
        <div id="guide-widget-results" style="flex:1;overflow-y:auto;padding:1rem;">
            <p style="color:#6b7280;font-size:0.875rem;">عبارتی تایپ کنید یا لیست زیر را ببینید.</p>
        </div>
    </div>
    <script>
    (function(){
        var searchUrl = @json(route('guide.search'));
        var toggle = document.getElementById('guide-widget-toggle');
        var panel = document.getElementById('guide-widget-panel');
        var closeBtn = document.getElementById('guide-widget-close');
        var backdrop = document.getElementById('guide-widget-backdrop');
        var searchInput = document.getElementById('guide-widget-search');
        var resultsEl = document.getElementById('guide-widget-results');
        var debounce = null;
        function openPanel(){ panel.style.display='flex'; backdrop.style.display='block'; document.body.style.overflow='hidden'; if(!searchInput.value.trim()) fetchResults(''); searchInput.focus(); }
        function closePanel(){ panel.style.display='none'; backdrop.style.display='none'; document.body.style.overflow=''; }
        function render(pages){ if(!pages||!pages.length){ resultsEl.innerHTML='<p style="color:#6b7280;font-size:0.875rem;">نتیجه‌ای یافت نشد.</p>'; return; } resultsEl.innerHTML='<ul style="list-style:none;padding:0;margin:0;">'+pages.map(function(p){ return '<li style="margin-bottom:0.5rem;"><a href="'+p.url+'" target="_blank" rel="noopener" style="display:block;padding:0.65rem;border-radius:6px;border:1px solid #e5e7eb;text-align:right;text-decoration:none;color:#1e293b;">'+(p.title||p.slug)+'</a></li>'; }).join('')+'</ul>'; }
        function fetchResults(q){ var sep = searchUrl.indexOf('?') !== -1 ? '&' : '?'; var url = searchUrl + sep + (q ? 'q='+encodeURIComponent(q)+'&' : '') + 'context=admin'; resultsEl.innerHTML='<p style="color:#6b7280;font-size:0.875rem;">در حال جستجو...</p>'; fetch(url,{headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'},credentials:'same-origin'}).then(function(r){if(!r.ok)throw new Error(); return r.json();}).then(function(d){ render(d.pages||[]); }).catch(function(){ resultsEl.innerHTML='<p style="color:#dc2626;font-size:0.875rem;">خطا در بارگذاری.</p>'; }); }
        if(toggle){ toggle.addEventListener('click',openPanel); }
        if(closeBtn){ closeBtn.addEventListener('click',closePanel); }
        if(backdrop){ backdrop.addEventListener('click',closePanel); }
        if(searchInput){ searchInput.addEventListener('input',function(){ clearTimeout(debounce); debounce=setTimeout(function(){ fetchResults(searchInput.value.trim()); },300); }); searchInput.addEventListener('keydown',function(e){ if(e.key==='Escape') closePanel(); }); }
    })();
    </script>
</body>
</html>
