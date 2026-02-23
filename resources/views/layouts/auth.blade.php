<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ورود') — {{ \App\Helpers\PlatformUx::platformName() }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @include('partials.platform-styles')
    <style>
        body { direction: rtl; margin: 0; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); padding: 1rem; }
        .auth-bar { width: 100%; max-width: 28rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-bottom: 1.5rem; }
        .auth-bar img { height: 2rem; width: auto; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.625rem 1.25rem; border-radius: 0.5rem; font-weight: 500; border: none; cursor: pointer; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .btn-primary { background: var(--platform-button-primary-bg, #4f46e5); color: var(--platform-button-primary-text, #fff); }
        .btn-primary:hover { opacity: 0.95; }
        .btn.w-full { width: 100%; }
        .form-control { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; text-align: right; font-size: 1rem; box-sizing: border-box; }
        .form-control:focus { outline: none; border-color: var(--platform-primary, #818cf8); box-shadow: 0 0 0 2px rgba(79,70,229,0.2); }
        .form-label { display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem; text-align: right; }
        .card { background: #fff; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); border: 1px solid #e5e7eb; box-sizing: border-box; }
        .card.p-6 { padding: 1.5rem; }
        .alert { padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1rem; border: 1px solid; }
        .alert-danger { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
        .flex { display: flex; }
        .justify-center { justify-content: center; }
        .w-full { width: 100%; }
        .max-w-md { max-width: 28rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mt-4 { margin-top: 1rem; }
        .text-center { text-align: center; }
        .text-xl { font-size: 1.25rem; }
        .px-4 { padding-right: 1rem; padding-left: 1rem; }
        a { color: var(--platform-link-color, #4f46e5); }
        a:hover { color: var(--platform-link-hover, #4338ca); text-decoration: underline; }
    </style>
    @yield('head')
    @stack('head')
</head>
<body>
    <div class="auth-bar">
        @if(\App\Helpers\PlatformUx::logoUrl())
            <img src="{{ \App\Helpers\PlatformUx::logoUrl() }}" alt="{{ \App\Helpers\PlatformUx::platformName() }}">
        @endif
        <span style="font-weight:700; color: var(--platform-primary, #4f46e5);">{{ \App\Helpers\PlatformUx::platformName() }}</span>
    </div>
    @yield('content')
    @stack('scripts')
</body>
</html>
