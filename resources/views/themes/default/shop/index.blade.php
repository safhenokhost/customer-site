@extends('themes.default.layout')
@section('title', 'فروشگاه')
@section('content')
<h1>فروشگاه</h1>
<ul style="list-style:none;">
@forelse($products as $product)
<li style="padding:1rem 0; border-bottom:1px solid #e2e8f0;">
<a href="{{ route('shop.show', $product->slug) }}"><strong>{{ $product->title }}</strong></a> — {{ number_format($product->effective_price) }} تومان
<form method="post" action="{{ route('shop.cart.add') }}" style="display:inline; margin-right:1rem;">
@csrf
<input type="hidden" name="product_id" value="{{ $product->id }}">
<button type="submit" class="btn">افزودن به سبد</button>
</form>
</li>
@empty
<li>محصولی یافت نشد.</li>
@endforelse
</ul>
{{ $products->links() }}
<p style="margin-top:1rem;"><a href="{{ route('shop.cart') }}" class="btn">سبد خرید</a></p>
@endsection
