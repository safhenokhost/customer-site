<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ورود — پنل مدیریت</title>
    <style>
        body { font-family: Tahoma, Arial, sans-serif; background: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .box { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.08); max-width: 360px; width: 100%; }
        h1 { margin-bottom: 1.25rem; font-size: 1.25rem; }
        label { display: block; margin-bottom: .35rem; font-weight: 600; }
        input { width: 100%; padding: .6rem .75rem; border: 1px solid #cbd5e1; border-radius: 6px; margin-bottom: 1rem; }
        button { width: 100%; padding: .65rem; background: #2563eb; color: #fff; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; }
        button:hover { background: #1d4ed8; }
        .error { color: #dc2626; font-size: .9rem; margin-bottom: .5rem; }
    </style>
</head>
<body>
    <div class="box">
        <h1>ورود به پنل مدیریت</h1>
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror
        <form method="post" action="{{ route('login') }}">
            @csrf
            <label>ایمیل</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            <label>رمز عبور</label>
            <input type="password" name="password" required>
            <label style="display:flex;align-items:center;"><input type="checkbox" name="remember"> به خاطر بسپار</label>
            <button type="submit">ورود</button>
        </form>
    </div>
</body>
</html>
