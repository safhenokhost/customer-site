<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'نصب') — قالب سایت شرکتی</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Tahoma, Arial, sans-serif; background: #f5f5f5; padding: 2rem; line-height: 1.6; color: #333; }
        .container { max-width: 520px; margin: 0 auto; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        h1 { font-size: 1.35rem; margin-bottom: 1rem; color: #1a1a1a; }
        .steps { display: flex; gap: .5rem; margin-bottom: 1.5rem; font-size: .85rem; color: #666; }
        .step { padding: .25rem .5rem; border-radius: 4px; }
        .step.active { background: #2563eb; color: #fff; }
        .step.done { color: #16a34a; }
        label { display: block; margin-bottom: .35rem; font-weight: 600; }
        input[type="text"], input[type="email"], input[type="password"], input[type="number"] { width: 100%; padding: .6rem .75rem; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 1rem; font-size: 1rem; }
        input:focus { outline: none; border-color: #2563eb; }
        button { background: #2563eb; color: #fff; border: none; padding: .65rem 1.25rem; border-radius: 6px; font-size: 1rem; cursor: pointer; }
        button:hover { background: #1d4ed8; }
        .error { color: #dc2626; font-size: .9rem; margin-top: .5rem; }
        .help { font-size: .85rem; color: #666; margin-top: .25rem; }
        .req-ok { color: #16a34a; }
        .req-fail { color: #dc2626; }
        ul { list-style: none; margin: 1rem 0; }
        li { padding: .35rem 0; padding-right: 1.25rem; position: relative; }
        li::before { content: ''; position: absolute; right: 0; top: .6rem; width: 6px; height: 6px; border-radius: 50%; }
        li.ok::before { background: #16a34a; }
        li.fail::before { background: #dc2626; }
        .mb-2 { margin-bottom: 1rem; }
        .mt-2 { margin-top: 1rem; }
        [type="checkbox"] { width: auto; margin-left: .5rem; vertical-align: middle; }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
