@extends('themes.default.layout')
@section('title', \App\Helpers\Seo::title($product))
@section('meta_description', \App\Helpers\Seo::description($product))
@section('meta_image', \App\Helpers\Seo::imageUrl($product))
@section('canonical', route('shop.show', $product->slug))
@section('og_type', 'product')
@push('json-ld')
<script type="application/ld+json">@json(\App\Helpers\JsonLd::product($product))</script>
@endpush
@section('content')
    <h1>{{ $product->title }}</h1>
    <p>{{ number_format($product->effective_price) }} تومان @if($product->sale_price && $product->sale_price < $product->price)<span style="text-decoration:line-through; color:#64748b;">{{ number_format($product->price) }}</span>@endif</p>
    @if($product->description)
        <div style="margin:1rem 0;">{!! nl2br(e($product->description)) !!}</div>
    @endif
    <form method="post" action="{{ route('shop.cart.add') }}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="number" name="quantity" value="1" min="1" style="width:70px; padding:.5rem;">
        <button type="submit" class="btn">افزودن به سبد</button>
    </form>
    <p style="margin-top:1rem;"><a href="{{ route('shop.index') }}">بازگشت به فروشگاه</a></p>
@endsection
