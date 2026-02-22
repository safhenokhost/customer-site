@extends('install.layout')
@section('title', 'بررسی محیط')

<h1>بررسی محیط نصب</h1>

@if($checks['passed'])
    <p class="mb-2">همهٔ پیش‌نیازها برقرار است. برای ادامه روی دکمه زیر کلیک کنید.</p>
    <form method="get" action="{{ route('install.database') }}">
        <button type="submit">مرحله بعد: دیتابیس</button>
    </form>
@else
    <p class="mb-2">لطفاً موارد زیر را برطرف کنید و سپس صفحه را رفرش کنید.</p>
    <ul>
        <li class="{{ $checks['php'] ? 'ok' : 'fail' }}">PHP &gt;= 8.2 {{ $checks['php'] ? '✓' : '✗' }}</li>
        @foreach($checks['extensions'] as $ext => $ok)
            <li class="{{ $ok ? 'ok' : 'fail' }}">افزونه {{ $ext }} {{ $ok ? '✓' : '✗' }}</li>
        @endforeach
        @foreach($checks['writable'] as $name => $ok)
            <li class="{{ $ok ? 'ok' : 'fail' }}">قابل نوشتن: {{ $name }} {{ $ok ? '✓' : '✗' }}</li>
        @endforeach
    </ul>
    <form method="get" action="{{ url()->current() }}" class="mt-2">
        <button type="submit">بررسی مجدد</button>
    </form>
@endif
