@extends('admin.layout')
@section('title', 'سفارشات')
@section('content')
<h1>سفارشات</h1>
<table>
    <thead><tr><th>شماره</th><th>مشتری</th><th>مبلغ</th><th>وضعیت</th><th>تاریخ</th><th></th></tr></thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->number }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ number_format($order->total) }} تومان</td>
                <td>{{ $order->status }}</td>
                <td>{{ \App\Helpers\Jalali::formatFa($order->created_at, 'Y/m/d H:i') }}</td>
                <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-primary">مشاهده</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $orders->links() }}
@endsection
