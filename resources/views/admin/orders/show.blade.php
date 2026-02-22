@extends('admin.layout')
@section('title', 'سفارش ' . $order->number)

<h1>سفارش {{ $order->number }}</h1>
<p><strong>مشتری:</strong> {{ $order->customer_name }} — {{ $order->customer_email }} — {{ $order->customer_phone }}</p>
<p><strong>آدرس:</strong> {{ $order->customer_address }}</p>
<p><strong>وضعیت:</strong> {{ $order->status }}</p>

<form action="{{ route('admin.orders.update-status', $order) }}" method="post" style="margin:1rem 0;">
    @csrf
    @method('PATCH')
    <label>تغییر وضعیت</label>
    <select name="status">
        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>در انتظار</option>
        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>پرداخت شده</option>
        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>در حال پردازش</option>
        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>ارسال شده</option>
        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>تکمیل شده</option>
        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>لغو شده</option>
    </select>
    <button type="submit" class="btn btn-primary">بروزرسانی</button>
</form>

<table>
    <thead><tr><th>محصول</th><th>قیمت</th><th>تعداد</th><th>جمع</th></tr></thead>
    <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_title }}</td>
                <td>{{ number_format($item->price) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->total) }} تومان</td>
            </tr>
        @endforeach
    </tbody>
</table>
<p><strong>جمع کل:</strong> {{ number_format($order->total) }} تومان</p>
<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">بازگشت</a>
