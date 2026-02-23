@extends('layouts.auth')

@section('title', 'ورود')

@section('content')
<div class="flex justify-center px-4">
    <div class="card w-full max-w-md p-6">
        <h2 class="text-xl font-bold mb-6 text-center">
            ورود به پنل مدیریت
        </h2>

        @if ($errors->any())
            <div class="alert alert-danger text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="form-label">موبایل</label>
                <input type="text"
                       name="mobile"
                       value="{{ old('mobile') }}"
                       placeholder="مثال: ۰۹۱۲۳۴۵۶۷۸۹"
                       class="form-control"
                       required
                       dir="rtl"
                       autocomplete="tel">
            </div>

            <div>
                <label class="form-label">رمز عبور</label>
                <input type="password"
                       name="password"
                       placeholder="رمز عبور خود را وارد کنید"
                       class="form-control"
                       required
                       dir="rtl"
                       autocomplete="current-password">
            </div>

            <label style="display:flex;align-items:center;gap:0.5rem;">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                <span>به خاطر بسپار</span>
            </label>

            <button type="submit" class="btn btn-primary w-full">
                ورود
            </button>
        </form>
    </div>
</div>
@endsection
