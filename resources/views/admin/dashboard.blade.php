@extends('admin.layout')
@section('title', 'داشبورد')

<h1>داشبورد</h1>

<div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap:1rem; margin:1.5rem 0;">
    <div style="background:#fff; padding:1.25rem; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,.08);">
        <div style="font-size:.9rem; color:#64748b;">صفحات</div>
        <div style="font-size:1.75rem; font-weight:700;">{{ $stats['pages'] }}</div>
    </div>
    <div style="background:#fff; padding:1.25rem; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,.08);">
        <div style="font-size:.9rem; color:#64748b;">مطالب وبلاگ</div>
        <div style="font-size:1.75rem; font-weight:700;">{{ $stats['posts'] }}</div>
    </div>
    @if(\App\Helpers\SiteHelper::shopEnabled())
        <div style="background:#fff; padding:1.25rem; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,.08);">
            <div style="font-size:.9rem; color:#64748b;">محصولات</div>
            <div style="font-size:1.75rem; font-weight:700;">{{ $stats['products'] }}</div>
        </div>
        <div style="background:#fff; padding:1.25rem; border-radius:8px; box-shadow:0 1px 3px rgba(0,0,0,.08);">
            <div style="font-size:.9rem; color:#64748b;">سفارشات</div>
            <div style="font-size:1.75rem; font-weight:700;">{{ $stats['orders'] }}</div>
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
