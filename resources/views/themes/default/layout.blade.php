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
    @if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>tailwind.config = { theme: { extend: { fontFamily: { vazir: ['Vazirmatn', 'Tahoma', 'sans-serif'] } } } };</script>
    @endif
    <style>
        * { box-sizing: border-box; }
        body { font-family: Vazirmatn, Tahoma, sans-serif; margin: 0; background: #f9fafb; color: #1f2937; min-height: 100vh; }
        .form-input, .form-textarea, .form-select { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; }
        .form-input:focus, .form-textarea:focus { outline: none; border-color: var(--platform-primary, #4f46e5); box-shadow: 0 0 0 2px rgba(79,70,229,0.2); }
        .form-label { display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem; }
        .form-error { font-size: 0.875rem; color: #dc2626; margin-top: 0.25rem; }
        .nav-link { color: inherit; text-decoration: none; }
        .nav-link:hover { color: var(--platform-menu-link-active, #93c5fd); }
        .site-header .nav-link.font-semibold { color: var(--platform-menu-link-active, #93c5fd); }
        #mobile-menu a { color: inherit; text-decoration: none; display: block; padding: 0.5rem 0; }
        #mobile-menu a:hover { color: var(--platform-menu-link-active, #93c5fd); }
        /* Critical layout - works without Tailwind */
        .site-header .container-inner { max-width: 72rem; margin: 0 auto; padding: 0 1rem; }
        .site-header .header-row { display: flex; align-items: center; justify-content: space-between; min-height: 4rem; }
        .site-header #main-nav { display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; }
        .site-header #mobile-menu { display: none; border-top: 1px solid rgba(255,255,255,0.2); padding: 1rem; }
        .site-header #mobile-menu > div { display: flex; flex-direction: column; gap: 0.5rem; }
        .site-header #mobile-menu.is-open { display: block; }
        .site-header .menu-btn { display: none; padding: 0.5rem; border-radius: 0.5rem; background: transparent; border: none; cursor: pointer; color: inherit; }
        @media (max-width: 767px) {
            .site-header #main-nav { display: none; }
            .site-header .menu-btn { display: block; }
        }
        main .main-inner { max-width: 72rem; margin: 0 auto; padding: 0 1rem; padding-top: 2rem; padding-bottom: 3rem; }
        @media (min-width: 768px) { main .main-inner { padding-top: 3rem; padding-bottom: 3rem; } }
        footer .footer-inner { max-width: 72rem; margin: 0 auto; padding: 0 1rem; }
        footer .footer-row { display: flex; flex-direction: column; gap: 1rem; padding-top: 2rem; padding-bottom: 1.5rem; }
        @media (min-width: 768px) { footer .footer-row { flex-direction: row; justify-content: space-between; align-items: center; } }
        footer .footer-links { display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.875rem; }
        footer .footer-links a { color: #6b7280; text-decoration: none; }
        footer .footer-links a:hover { text-decoration: underline; }
        .card-grid { display: grid; gap: 1.5rem; }
        @media (min-width: 768px) { .card-grid-2 { grid-template-columns: repeat(2, 1fr); } .card-grid-3 { grid-template-columns: repeat(3, 1fr); } .card-grid-4 { grid-template-columns: repeat(4, 1fr); } }
        .card { padding: 1.5rem; background: #fff; border-radius: 0.75rem; border: 1px solid #f3f4f6; }
        .hero-section { text-align: center; padding: 3rem 1rem; margin-bottom: 3rem; border-radius: 1rem; }
        @media (min-width: 768px) { .hero-section { padding: 4rem 1rem; } }
        .hero-buttons { display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem; margin-top: 1.5rem; }
        .hero-buttons a { display: inline-block; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; }
        .skip-link { position: fixed; top: -5rem; right: 1rem; z-index: 50; padding: 0.5rem 1rem; background: #1f2937; color: #fff; border-radius: 0.5rem; text-decoration: none; }
        .skip-link:focus { top: 1rem; opacity: 1; }
        *:focus-visible { outline: 2px solid var(--platform-primary, #4f46e5); outline-offset: 2px; }
        button:focus-visible, a:focus-visible, input:focus-visible, textarea:focus-visible, select:focus-visible { outline: 2px solid var(--platform-primary, #4f46e5); outline-offset: 2px; }
        nav[aria-label="مسیر"] { display: flex; flex-wrap: wrap; align-items: center; gap: 0.25rem; }
        nav[aria-label="مسیر"] a { color: #6b7280; text-decoration: none; }
        nav[aria-label="مسیر"] a:hover { text-decoration: underline; }
        nav[role="navigation"] { margin-top: 2rem; }
        nav[role="navigation"] ul { display: flex; flex-wrap: wrap; gap: 0.5rem; list-style: none; padding: 0; margin: 0; }
        nav[role="navigation"] a, nav[role="navigation"] span { padding: 0.5rem 0.75rem; border-radius: 0.375rem; }
        nav[role="navigation"] a { text-decoration: none; background: #f3f4f6; color: #374151; }
        nav[role="navigation"] a:hover { background: #e5e7eb; }
        nav[role="navigation"] .relative span { background: var(--platform-primary, #4f46e5); color: white; }
    </style>
    @stack('head')
</head>
<body>
    <a href="#main" class="skip-link">پرش به محتوا</a>

    <header class="site-header" style="background: var(--platform-menu-bg, #1e293b); color: var(--platform-menu-text, #e2e8f0);">
        <div class="container-inner">
            <div class="header-row">
                <a href="{{ route('home') }}" style="font-size: 1.25rem; font-weight: 700; color: var(--platform-primary, #a5b4fc); text-decoration: none;">
                    {{ \App\Helpers\SiteHelper::siteName() }}
                </a>
                <button type="button" id="mobile-menu-btn" class="menu-btn" aria-label="منو">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <nav id="main-nav">
                    <a href="{{ route('home') }}" class="nav-link hover:opacity-90 {{ request()->routeIs('home') ? 'font-semibold' : '' }}">خانه</a>
                    @foreach($pages ?? [] as $p)
                        <a href="{{ route('page.show', $p->slug) }}" class="nav-link">{{ $p->title }}</a>
                    @endforeach
                    @if(\App\Helpers\SiteHelper::blogEnabled())
                        <a href="{{ route('blog.index') }}" class="nav-link {{ request()->routeIs('blog.*') ? 'font-semibold' : '' }}">وبلاگ</a>
                    @endif
                    @if(\App\Helpers\SiteHelper::shopEnabled())
                        <a href="{{ route('shop.index') }}" class="nav-link {{ request()->routeIs('shop.*') ? 'font-semibold' : '' }}">فروشگاه</a>
                        <a href="{{ route('shop.cart') }}" class="nav-link flex items-center gap-1">سبد خرید</a>
                    @endif
                    <a href="{{ route('contact.show') }}" class="nav-link {{ request()->routeIs('contact.*') ? 'font-semibold' : '' }}">تماس</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">پنل</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">ورود</a>
                    @endauth
                </nav>
            </div>
        </div>
        <div id="mobile-menu">
            <div class="flex flex-col gap-2">
                <a href="{{ route('home') }}" class="py-2 block">خانه</a>
                @foreach($pages ?? [] as $p)
                    <a href="{{ route('page.show', $p->slug) }}" class="py-2 block">{{ $p->title }}</a>
                @endforeach
                @if(\App\Helpers\SiteHelper::blogEnabled())
                    <a href="{{ route('blog.index') }}" class="py-2 block">وبلاگ</a>
                @endif
                @if(\App\Helpers\SiteHelper::shopEnabled())
                    <a href="{{ route('shop.index') }}" class="py-2 block">فروشگاه</a>
                    <a href="{{ route('shop.cart') }}" class="py-2 block">سبد خرید</a>
                @endif
                <a href="{{ route('contact.show') }}" class="py-2 block">تماس</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="py-2 block">پنل</a>
                @else
                    <a href="{{ route('login') }}" class="py-2 block">ورود</a>
                @endauth
            </div>
        </div>
    </header>

    <main id="main">
        <div class="main-inner">
            @if(session('success'))
                <div style="margin-bottom: 1.5rem; padding: 1rem; border-radius: 0.5rem; background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="margin-bottom: 1.5rem; padding: 1rem; border-radius: 0.5rem; background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; display: flex; align-items: center; gap: 0.5rem;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @hasSection('breadcrumb')
                <nav style="margin-bottom: 1.5rem; font-size: 0.875rem; color: #6b7280;" aria-label="مسیر">
                    @yield('breadcrumb')
                </nav>
            @endif
            @yield('content')
        </div>
    </main>

    <footer style="margin-top: 3rem; padding-top: 2rem; padding-bottom: 1.5rem; background: #f3f4f6; border-top: 1px solid #e5e7eb;">
        <div class="footer-inner">
            <div class="footer-row">
                <div style="font-weight: 600;">{{ \App\Helpers\SiteHelper::siteName() }}</div>
                <div class="footer-links">
                    <a href="{{ route('home') }}" class="hover:underline">خانه</a>
                    @if(\App\Helpers\SiteHelper::blogEnabled())
                        <a href="{{ route('blog.index') }}" class="hover:underline">وبلاگ</a>
                    @endif
                    @if(\App\Helpers\SiteHelper::shopEnabled())
                        <a href="{{ route('shop.index') }}" class="hover:underline">فروشگاه</a>
                    @endif
                    <a href="{{ route('contact.show') }}" class="hover:underline">تماس</a>
                </div>
            </div>
            <p style="margin-top: 1rem; font-size: 0.875rem; color: #6b7280; text-align: center;">© {{ date('Y') }} {{ \App\Helpers\SiteHelper::siteName() }}. تمامی حقوق محفوظ است.</p>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu')?.classList.toggle('is-open');
        });
        document.querySelectorAll('form').forEach(function(f) {
            f.addEventListener('submit', function() {
                var btn = f.querySelector('button[type="submit"]');
                if (btn && !btn.disabled) {
                    btn.disabled = true;
                    var orig = btn.textContent;
                    btn.textContent = btn.dataset.loadingText || 'در حال ارسال...';
                    setTimeout(function() { btn.disabled = false; btn.textContent = orig; }, 10000);
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
