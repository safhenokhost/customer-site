<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', \App\Helpers\SiteHelper::siteName())</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Tahoma, Arial, sans-serif; line-height: 1.7; color: #333; background: #fff; }
        .container { max-width: 960px; margin: 0 auto; padding: 0 1rem; }
        header { background: #1e293b; color: #e2e8f0; padding: 1rem 0; }
        header .container { display: flex; justify-content: space-between; align-items: center; }
        header a { color: #e2e8f0; text-decoration: none; margin-left: 1.25rem; }
        header a:hover { text-decoration: underline; }
        main { padding: 2rem 0; min-height: 50vh; }
        footer { background: #f1f5f9; padding: 1.5rem 0; margin-top: 2rem; text-align: center; font-size: .9rem; color: #64748b; }
        h1 { font-size: 1.75rem; margin-bottom: 1rem; }
        .alert { padding: .75rem; border-radius: 6px; margin-bottom: 1rem; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .btn { display: inline-block; padding: .5rem 1rem; background: #2563eb; color: #fff; border-radius: 6px; text-decoration: none; border: none; cursor: pointer; font-size: 1rem; }
        .btn:hover { background: #1d4ed8; }
    </style>
    @stack('head')
</head>
<body>
    <header>
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
