@extends('themes.default.layout')

@section('title', 'سبد خرید')

@section('content')
    <h1>سبد خرید</h1>
    @if(count($cart) > 0)
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #e2e8f0;"><th style="text-align:right; padding:.75rem;">محصول</th><th>قیمت</th><th>تعداد</th><th>جمع</th></tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php $sub = $item['price'] * $item['quantity']; $total += $sub; @endphp
                    <tr style="border-bottom:1px solid #e2e8f0;">
                        <td style="padding:.75rem;">{{ $item['title'] }}</td>
                        <td>{{ number_format($item['price']) }} تومان</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($sub) }} تومان</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p style="margin-top:1rem;"><strong>جمع کل: {{ number_format($total) }} تومان</strong></p>
        <h2 style="margin-top:1.5rem;">تکمیل سفارش</h2>
        <form method="post" action="{{ route('shop.checkout') }}" style="max-width:480px;">
            @csrf
            <p><label>نام</label><input type="text" name="customer_name" value="{{ old('customer_name') }}" required style="width:100%; padding:.5rem;"></p>
            <p><label>ایمیل</label><input type="email" name="customer_email" value="{{ old('customer_email') }}" required style="width:100%; padding:.5rem;"></p>
            <p><label>تلفن</label><input type="text" name="customer_phone" value="{{ old('customer_phone') }}" style="width:100%; padding:.5rem;"></p>
            <p><label>آدرس</label><textarea name="customer_address" required style="width:100%; padding:.5rem;">{{ old('customer_address') }}</textarea></p>
            <p><label>یادداشت</label><textarea name="note" style="width:100%; padding:.5rem;">{{ old('note') }}</textarea></p>
            <button type="submit" class="btn">ثبت سفارش</button>
        </form>
    @else
        <p>سبد خرید شما خالی است.</p>
        <a href="{{ route('shop.index') }}" class="btn">فروشگاه</a>
    @endif
@endsection
