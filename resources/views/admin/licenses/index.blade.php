@extends('admin.layout')
@section('title', 'لایسنس')
@section('content')
<h1>لایسنس</h1>

@if(session('success'))
    <p style="color: green; margin-bottom: 1rem;">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p style="color: #b91c1c; margin-bottom: 1rem;">{{ session('error') }}</p>
@endif
@if(session('update_available'))
    @php $ua = session('update_available'); @endphp
    <p style="background: #fef3c7; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem;">
        <strong>بروزرسانی جدید موجود است:</strong> نسخهٔ {{ $ua['latest_version'] ?? '—' }}
        @if(!empty($ua['changelog']))<br><span style="font-size: .9rem;">{{ $ua['changelog'] }}</span>@endif
    </p>
@endif

@if($license)
    <table style="max-width: 560px; margin-bottom: 1.5rem;">
        <tr><th style="width: 140px;">وضعیت</th><td><strong>{{ $license->statusLabel() }}</strong></td></tr>
        <tr><th>کلید (نمایش)</th><td><code>{{ $license->maskedKey() }}</code></td></tr>
        <tr><th>دامنه</th><td>{{ $license->domain ?: '—' }}</td></tr>
        <tr><th>تاریخ انقضا</th><td>{{ $license->expires_at ? \App\Helpers\Jalali::formatFa($license->expires_at, 'Y/m/d') : '—' }}</td></tr>
        @if($license->support_expires_at)
        <tr><th>انقضای پشتیبانی</th><td>{{ \App\Helpers\Jalali::formatFa($license->support_expires_at, 'Y/m/d') }}</td></tr>
        @endif
        @if(!empty($license->modules))
        <tr><th>ماژول‌های فعال</th><td>{{ implode('، ', $license->modules) }}</td></tr>
        @endif
        <tr><th>دامنه فعلی درخواست</th><td><code>{{ request()->getHost() }}</code></td></tr>
    </table>
@else
    <p style="margin-bottom: 1rem;">هنوز لایسنس ثبت نشده است. کلید را در فرم زیر وارد کرده و «فعال‌سازی» را بزنید.</p>
@endif

<h2 style="font-size: 1.1rem; margin-bottom: 0.75rem;">فعال‌سازی / بروزرسانی لایسنس</h2>
<p style="font-size: .9rem; color: #64748b; margin-bottom: 1rem;">کلید لایسنس را از پلتفرم دریافت کرده و اینجا وارد کنید. اعتبار از طریق سرور پلتفرم بررسی می‌شود.</p>
@if($license)
<form action="{{ route('admin.license.check-update') }}" method="post" style="display: inline-block; margin-left: 8px;">
    @csrf
    <button type="submit" class="btn btn-outline-secondary">بررسی بروزرسانی</button>
</form>
@endif
<form action="{{ route('admin.license.update') }}" method="post" style="max-width: 480px;">
    @csrf
    <div class="form-group">
        <label>کلید لایسنس</label>
        <input type="text" name="license_key" value="{{ old('license_key') }}" placeholder="XXXX-XXXX-XXXX-XXXX" autocomplete="off" required>
    </div>
    <div class="form-group">
        <label>دامنه این سایت (خالی = دامنه فعلی)</label>
        <input type="text" name="domain" value="{{ old('domain', $license?->domain ?? request()->getHost()) }}" placeholder="{{ request()->getHost() }}">
    </div>
    <button type="submit" class="btn btn-primary">فعال‌سازی لایسنس</button>
</form>
@endsection
