@extends('admin.layout')
@section('title', 'داشبورد')
@section('content')
<style>
@media (max-width: 768px) {
    .dashboard-modules-block .dashboard-modules-header { max-width: none; width: 100%; border-left: none; border-bottom: 1px solid #e5e7eb; }
    .dashboard-modules-block .dashboard-modules-content { width: 100%; }
}
</style>
<h1>داشبورد</h1>
<p style="color:#64748b; font-size:.95rem; margin:.5rem 0 1.5rem;">خلاصهٔ محتوا و وضعیت سایت.</p>

<div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap:1rem; margin:1.5rem 0; direction:rtl;">
    <div style="background:#fff; padding:1.25rem; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,.08); text-align:right;">
        <div style="font-size:.9rem; color:#64748b;">صفحات</div>
        <div style="font-size:1.75rem; font-weight:700; color:var(--platform-title-color,#111827);">{{ $stats['pages'] }}</div>
    </div>
    <div style="background:#fff; padding:1.25rem; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,.08); text-align:right;">
        <div style="font-size:.9rem; color:#64748b;">مطالب وبلاگ</div>
        <div style="font-size:1.75rem; font-weight:700; color:var(--platform-title-color,#111827);">{{ $stats['posts'] }}</div>
    </div>
    @if(\App\Helpers\SiteHelper::shopEnabled())
        <div style="background:#fff; padding:1.25rem; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,.08); text-align:right;">
            <div style="font-size:.9rem; color:#64748b;">محصولات</div>
            <div style="font-size:1.75rem; font-weight:700; color:var(--platform-title-color,#111827);">{{ $stats['products'] }}</div>
        </div>
        <div style="background:#fff; padding:1.25rem; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,.08); text-align:right;">
            <div style="font-size:.9rem; color:#64748b;">سفارشات</div>
            <div style="font-size:1.75rem; font-weight:700; color:var(--platform-title-color,#111827);">{{ $stats['orders'] }}</div>
        </div>
    @endif
</div>

@if(\App\Helpers\SiteHelper::shopEnabled() && $recentOrders->isNotEmpty())
    <h2 style="margin:1.5rem 0 .75rem; font-size:1.1rem;">آخرین سفارشات</h2>
    <table>
        <thead>
            <tr><th>شماره</th><th>مشتری</th><th>مبلغ</th><th>وضعیت</th><th></th></tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
                <tr>
                    <td>{{ $order->number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ number_format($order->total) }} تومان</td>
                    <td>{{ $order->status }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">مشاهده</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- وضعیت ماژول‌ها و امکانات از پلتفرم: عنوان و توضیح در یک سمت، جدول محتوا روبرو (در RTL کنار هم) --}}
<div class="dashboard-modules-block" style="margin-top:2rem; background:#fff; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,.08); border:1px solid #e5e7eb; overflow:hidden;">
    <div style="display:flex; flex-wrap:wrap; width:100%; min-height:0;">
        <div class="dashboard-modules-header" style="flex:0 0 auto; width:100%; max-width:320px; padding:1.25rem; border-left:1px solid #e5e7eb;">
            <h2 style="font-size:1.1rem; font-weight:700; margin-bottom:0.5rem;">ماژول‌ها و امکانات از پلتفرم</h2>
            <p style="color:#64748b; font-size:.875rem; margin-bottom:1rem;">مقایسهٔ ماژول‌های دریافتی از پلتفرم با وضعیت فعال بودن در این سایت. برای اعمال ماژول‌های پلتفرم، در صفحهٔ <a href="{{ route('admin.license.index') }}" class="text-blue-600 hover:underline">لایسنس</a> کلید را ذخیره کنید و در صورت نیاز در فایل <code>.env</code> ماژول را فعال کنید (مثلاً <code>MODULE_SHOP_ENABLED=true</code>).</p>
            @php
                $license = $license ?? null;
                $modulesFromPlatform = $modulesFromPlatform ?? [];
                $localModules = $localModules ?? [];
            @endphp
            <div style="margin-bottom:0;">
                <strong>وضعیت لایسنس:</strong>
                @if(!$license || empty($license->license_key))
                    <span style="color:#b45309;">تنظیم نشده</span> — در <a href="{{ route('admin.license.index') }}" class="text-blue-600 hover:underline">صفحهٔ لایسنس</a> کلید را وارد کنید.
                @elseif(!$license->isValid())
                    <span style="color:#dc2626;">نامعتبر یا منقضی</span> — دامنه یا انقضا را بررسی کنید.
                @else
                    <span style="color:#15803d;">فعال</span>
                    @if(!empty($license->modules))
                        — ماژول‌های دریافتی: {{ implode('، ', $license->modules) }}
                    @endif
                @endif
            </div>
        </div>
        <div class="dashboard-modules-content" style="flex:1; min-width:0; padding:1.25rem; overflow-x:auto;">
            @if(count($localModules) > 0)
                <table style="width:100%; border-collapse:collapse; text-align:right;">
                    <thead>
                        <tr style="border-bottom:1px solid #e5e7eb;">
                            <th style="padding:0.5rem 0.75rem; font-weight:600;">ماژول</th>
                            <th style="padding:0.5rem 0.75rem; font-weight:600;">از پلتفرم</th>
                            <th style="padding:0.5rem 0.75rem; font-weight:600;">فعال در این سایت</th>
                            <th style="padding:0.5rem 0.75rem; font-weight:600;">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($localModules as $key => $info)
                            @php
                                $fromPlatform = in_array($key, $modulesFromPlatform, true);
                                $enabledLocally = !empty($info['enabled']);
                                $ok = $fromPlatform && $enabledLocally;
                                $needEnable = $fromPlatform && !$enabledLocally;
                            @endphp
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td style="padding:0.5rem 0.75rem;">{{ $info['name'] ?? $key }}</td>
                                <td style="padding:0.5rem 0.75rem;">
                                    @if($fromPlatform)
                                        <span style="display:inline-flex; padding:0.15rem 0.5rem; border-radius:4px; background:#dcfce7; color:#166534; font-size:.8rem;">✓ فعال</span>
                                    @else
                                        <span style="color:#94a3b8;">—</span>
                                    @endif
                                </td>
                                <td style="padding:0.5rem 0.75rem;">
                                    @if($enabledLocally)
                                        <span style="display:inline-flex; padding:0.15rem 0.5rem; border-radius:4px; background:#dcfce7; color:#166534; font-size:.8rem;">✓ فعال</span>
                                    @else
                                        <span style="color:#94a3b8;">غیرفعال</span>
                                    @endif
                                </td>
                                <td style="padding:0.5rem 0.75rem;">
                                    @if($ok)
                                        <span style="color:#15803d; font-size:.85rem;">هماهنگ</span>
                                    @elseif($needEnable)
                                        <span style="color:#b45309; font-size:.85rem;">پلتفرم داده، در سایت غیرفعال است</span>
                                    @else
                                        <span style="color:#64748b; font-size:.85rem;">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="color:#64748b; font-size:.875rem;">ماژولی در تنظیمات این نصب تعریف نشده است.</p>
            @endif
        </div>
    </div>
</div>
@endsection
