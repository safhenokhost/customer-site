<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $seoTitle = trim($__env->yieldContent('title')) ?: \App\Helpers\SiteHelper::siteName();
        $seoDesc = trim($__env->yieldContent('meta_description'));
        $seoImage = trim($__env->yieldContent('meta_image'));
        $seoCanonical = trim($__env->yieldContent('canonical')) ?: url()->current();
        $ogType = trim($__env->yieldContent('og_type')) ?: 'website';
    @endphp
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ e($seoDesc) }}">
    <link rel="canonical" href="{{ e($seoCanonical) }}">
    <meta property="og:type" content="{{ e($ogType) }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:url" content="{{ e($seoCanonical) }}">
    <meta property="og:locale" content="fa_IR">
    @if($seoDesc)
    <meta property="og:description" content="{{ e($seoDesc) }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ e($seoDesc) }}">
    @endif
    @if($seoImage)
    <meta property="og:image" content="{{ e($seoImage) }}">
    @endif
    <script type="application/ld+json">@json(\App\Helpers\JsonLd::organization())</script>
    @stack('json-ld')
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @include('partials.platform-styles')
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--platform-font-body, Vazirmatn, Tahoma, sans-serif); line-height: 1.7; color: #333; background: #fff; }
        .container { max-width: 960px; margin: 0 auto; padding: 0 1rem; }
        .site-header { background: var(--platform-menu-bg, #1e293b); color: var(--platform-menu-text, #e2e8f0); padding: 1rem 0; }
        .site-header .container { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; }
        .site-header a { color: var(--platform-menu-text, #e2e8f0); text-decoration: none; margin-left: 1.25rem; }
        .site-header a:hover { color: var(--platform-menu-link-active, #93c5fd); text-decoration: underline; }
        .site-header a:first-child { font-weight: 700; color: var(--platform-primary, #a5b4fc); }
        main { padding: 2rem 0; min-height: 50vh; }
        footer { background: #f1f5f9; padding: 1.5rem 0; margin-top: 2rem; text-align: center; font-size: .9rem; color: #64748b; }
        h1, h2, h3 { font-family: var(--platform-font-title, Vazirmatn, Tahoma, sans-serif); color: var(--platform-title-color, #111827); }
        h1 { font-size: 1.75rem; margin-bottom: 1rem; }
        .alert { padding: .75rem; border-radius: 0.5rem; margin-bottom: 1rem; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .btn { display: inline-block; padding: .5rem 1rem; background: var(--platform-button-primary-bg, #4f46e5); color: var(--platform-button-primary-text, #fff); border-radius: 0.5rem; text-decoration: none; border: none; cursor: pointer; font-size: 1rem; }
        .btn:hover { background: var(--platform-link-hover, #4338ca); }
        a { color: var(--platform-link-color, #4f46e5); }
        a:hover { color: var(--platform-link-hover, #4338ca); }
    </style>
    @stack('head')
</head>
<body>
    <header class="site-header">
        <div class="container">
            <a href="{{ route('home') }}">{{ \App\Helpers\SiteHelper::siteName() }}</a>
            <nav>
                <a href="{{ route('home') }}">خانه</a>
                @foreach($pages ?? [] as $p)
                    <a href="{{ route('page.show', $p->slug) }}">{{ $p->title }}</a>
                @endforeach
                @if(\App\Helpers\SiteHelper::blogEnabled())
                    <a href="{{ route('blog.index') }}">وبلاگ</a>
                @endif
                @if(\App\Helpers\SiteHelper::shopEnabled())
                    <a href="{{ route('shop.index') }}">فروشگاه</a>
                @endif
                <a href="{{ route('contact.show') }}">تماس</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}">پنل</a>
                @else
                    <a href="{{ route('login') }}">ورود</a>
                @endauth
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
    <footer>
        <div class="container">{{ \App\Helpers\SiteHelper::siteName() }} — قالب سایت شرکتی</div>
    </footer>
</body>
</html>
