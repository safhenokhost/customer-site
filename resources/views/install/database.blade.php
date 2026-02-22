@extends('install.layout')
@section('title', 'تنظیم دیتابیس')

<h1>تنظیم دیتابیس</h1>

<form method="POST" action="{{ route('install.store-database') }}">
    @csrf
    <label>میزبان (Host)</label>
    <input type="text" name="db_host" value="{{ old('db_host', '127.0.0.1') }}" required>
    <label>نام دیتابیس</label>
    <input type="text" name="db_name" value="{{ old('db_name') }}" required>
    <label>نام کاربری</label>
    <input type="text" name="db_user" value="{{ old('db_user') }}" required>
    <label>رمز عبور</label>
    <input type="password" name="db_password" value="{{ old('db_password') }}">
    @error('db')
        <p class="error">{{ $message }}</p>
    @enderror
    <div class="mt-2">
        <button type="submit">اتصال و اجرای مایگریشن</button>
    </div>
</form>
