<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>خطای سرور | {{ config('app.name', 'سایت') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: Vazirmatn, Tahoma, sans-serif; margin: 0; background: #f9fafb; color: #1f2937; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .box { text-align: center; max-width: 28rem; }
        .code { font-size: 6rem; font-weight: 700; color: #dc2626; line-height: 1; margin-bottom: 1rem; }
        h1 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; }
        p { color: #6b7280; margin-bottom: 1.5rem; }
        a { display: inline-block; padding: 0.75rem 1.5rem; font-weight: 600; border-radius: 0.5rem; color: white; text-decoration: none; background: var(--platform-primary, #4f46e5); }
        a:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="box">
        <div class="code">۵۰۰</div>
        <h1>خطای سرور</h1>
        <p>متأسفانه خطایی رخ داده است. لطفاً بعداً تلاش کنید.</p>
        <a href="{{ url('/') }}">بازگشت به صفحهٔ اصلی</a>
    </div>
</body>
</html>
