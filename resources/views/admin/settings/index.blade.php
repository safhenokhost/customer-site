@extends('admin.layout')
@section('title', 'تنظیمات')
@section('content')
<h1>تنظیمات سایت</h1>
<form action="{{ route('admin.settings.update') }}" method="post">
    @csrf
    <div class="form-group"><label>نام سایت</label><input type="text" name="site_name" value="{{ old('site_name', $siteName) }}" required></div>
    <div class="form-group"><label>قالب</label><select name="theme"><option value="default" {{ $theme === 'default' ? 'selected' : '' }}>پیش‌فرض</option></select></div>
    <button type="submit" class="btn btn-primary">ذخیره</button>
</form>

<h2 style="margin-top:1.5rem; font-size:1.1rem;">ماژول‌ها (فعال‌سازی از طریق تنظیمات)</h2>
<p style="color:#64748b; font-size:.9rem; margin:.5rem 0;">فعال یا غیرفعال کردن هر ماژول از طریق فایل <code>.env</code> انجام می‌شود. پس از تغییر، کش را پاک کنید یا سرور را یک‌بار ریستارت کنید.</p>
<ul style="list-style:none;">
    @foreach($modules as $m)
        <li style="padding:.5rem 0;">
            <strong>{{ $m['name'] }}</strong> ({{ $m['key'] }})
            — {{ $m['enabled'] ? 'فعال' : 'غیرفعال' }}
            <span style="color:#64748b; font-size:.85rem;"> — env: {{ config('modules.modules.'.$m['key'].'.env', 'MODULE_'.strtoupper($m['key']).'_ENABLED') }}</span>
        </li>
    @endforeach
</ul>
@endsection
