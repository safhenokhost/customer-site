@extends('admin.layout')
@section('title', 'تنظیمات')
@section('content')
<h1>تنظیمات سایت</h1>
<form action="{{ route('admin.settings.update') }}" method="post">
    @csrf
    <div class="form-group"><label>نام سایت</label><input type="text" name="site_name" value="{{ old('site_name', $siteName) }}" required></div>
    <div class="form-group"><label>قالب</label><select name="theme"><option value="default" {{ ($theme ?? 'default') === 'default' ? 'selected' : '' }}>پیش‌فرض</option><option value="minimal" {{ ($theme ?? '') === 'minimal' ? 'selected' : '' }}>مینیمال</option><option value="dark" {{ ($theme ?? '') === 'dark' ? 'selected' : '' }}>تیره</option></select></div>
    <hr style="margin: 1rem 0;">
    <h3 style="font-size: 1rem;">بلوک درباره ما (صفحهٔ خانه)</h3>
    <div class="form-group"><label><input type="checkbox" name="about_us_enabled" value="1" {{ ($aboutUsEnabled ?? false) ? 'checked' : '' }}> نمایش بلوک درباره ما</label></div>
    <div class="form-group"><label>عنوان</label><input type="text" name="about_us_title" value="{{ old('about_us_title', $aboutUsTitle ?? '') }}" placeholder="درباره ما"></div>
    <div class="form-group"><label>متن</label><textarea name="about_us_text" rows="4">{{ old('about_us_text', $aboutUsText ?? '') }}</textarea></div>
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
