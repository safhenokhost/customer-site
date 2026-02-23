@extends('themes.default.layout')

@section('title', \App\Helpers\Seo::title($product))
@section('meta_description', \App\Helpers\Seo::description($product))
@section('meta_image', \App\Helpers\Seo::imageUrl($product))
@section('canonical', route('shop.show', $product->slug))
@section('og_type', 'product')
@push('json-ld')
<script type="application/ld+json">@json(\App\Helpers\JsonLd::product($product))</script>
@endpush

@section('breadcrumb')
    <a href="{{ route('home') }}">خانه</a>
    <span style="margin: 0 0.5rem;">/</span>
    <a href="{{ route('shop.index') }}">فروشگاه</a>
    <span style="margin: 0 0.5rem;">/</span>
    <span>{{ Str::limit($product->title, 30) }}</span>
@endsection

@section('content')
<div style="max-width: 56rem;">
    <div style="display: grid; gap: 2rem; grid-template-columns: 1fr;">
    @if($product->image)
    <div style="aspect-ratio: 1; max-width: 20rem; background: #f3f4f6; border-radius: 0.75rem; overflow: hidden;">
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    @else
    <div style="aspect-ratio: 1; max-width: 20rem; background: #f3f4f6; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 4rem;">📦</div>
    @endif
    <div>
    <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">{{ $product->title }}</h1>
    <p class="text-xl font-semibold mb-6" style="color: var(--platform-primary, #4f46e5);">
        {{ number_format($product->effective_price) }} تومان
        @if($product->sale_price && $product->sale_price < $product->price)
            <span class="text-gray-400 line-through text-base">{{ number_format($product->price) }}</span>
        @endif
    </p>
    @if($product->description)
        <div class="mb-8 p-6 bg-white rounded-xl border border-gray-100">{!! nl2br(e($product->description)) !!}</div>
    @endif
    <form method="post" action="{{ route('shop.cart.add') }}" class="flex flex-wrap items-center gap-4">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <label class="flex items-center gap-2">
            <span class="form-label mb-0">تعداد:</span>
            <input type="number" name="quantity" value="1" min="1" class="form-input w-24">
        </label>
        <button type="submit" class="px-6 py-3 font-semibold rounded-lg text-white transition" style="background: var(--platform-button-primary-bg, #4f46e5);">افزودن به سبد</button>
    </form>
    <p style="margin-top: 1.5rem;">
        <a href="{{ route('shop.index') }}" style="font-weight: 600; color: var(--platform-link-color, #4f46e5);">← بازگشت به فروشگاه</a>
    </p>
    </div>
    </div>
</div>
@endsection
