@extends('admin.layout')
@section('title', 'لایسنس')

<h1>لایسنس</h1>

@if($license)
    <table style="max-width: 560px; margin-bottom: 1.5rem;">
        <tr><th style="width: 140px;">وضعیت</th><td><strong>{{ $license->statusLabel() }}</strong></td></tr>
        <tr><th>کلید (نمایش)</th><td><code>{{ $license->maskedKey() }}</code></td></tr>
        <tr><th>دامنه</th><td>{{ $license->domain ?: '—' }}</td></tr>
        <tr><th>تاریخ انقضا</th><td>{{ $license->expires_at ? $license->expires_at->format('Y/m/d') : '—' }}</td></tr>
        <tr><th>دامنه فعلی درخواست</th><td><code>{{ request()->getHost() }}</code></td></tr>
    </table>
@else
    <p style="margin-bottom: 1rem;">هنوز لایسنس ثبت نشده است. در فرم زیر وارد کنید.</p>
@endif

<h2 style="font-size: 1.1rem; margin-bottom: 0.75rem;">ثبت / بروزرسانی لایسنس</h2>
<form action="{{ route('admin.licenses.update') }}" method="post" style="max-width: 480px;">
    @csrf
    <div class="form-group">
        <label>کلید لایسنس</label>
        <input type="text" name="license_key" value="{{ old('license_key') }}" placeholder="XXXX-XXXX-XXXX-XXXX" autocomplete="off">
    </div>
    <div class="form-group">
        <label>دامنه (محدود به این دامنه)</label>
        <input type="text" name="domain" value="{{ old('domain', $license?->domain) }}" placeholder="example.com">
    </div>
    <div class="form-group">
        <label>تاریخ انقضا</label>
        <input type="date" name="expires_at" value="{{ old('expires_at', $license?->expires_at?->format('Y-m-d')) }}">
    </div>
    <button type="submit" class="btn btn-primary">ذخیره</button>
</form>

<p style="font-size: .9rem; color: #64748b; margin-top: 1rem;">اعتبارسنجی از راه دور فعلاً فعال نیست؛ تنها نمایش و ذخیرهٔ محلی است.</p>
