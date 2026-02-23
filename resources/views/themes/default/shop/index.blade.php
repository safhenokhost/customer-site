@extends('themes.default.layout')

@section('title', 'فروشگاه')

@section('breadcrumb')
    <a href="{{ route('home') }}">خانه</a>
    <span class="mx-2">/</span>
    <span>فروشگاه</span>
@endsection

@section('content')
<h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">فروشگاه</h1>

@if(isset($categories) && $categories->isNotEmpty())
<div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem;">
    <a href="{{ route('shop.index') }}" style="padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; {{ !request('category') ? 'background: #1f2937; color: white;' : 'background: #f3f4f6; color: #374151;' }}">همه</a>
    @foreach($categories as $c)
        <a href="{{ route('shop.index', ['category' => $c->slug]) }}" style="padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; {{ request('category') === $c->slug ? 'background: #1f2937; color: white;' : 'background: #f3f4f6; color: #374151;' }}">{{ $c->name }}</a>
    @endforeach
</div>
@endif

<form method="get" action="{{ route('shop.index') }}" style="margin-bottom: 1.5rem;">
    <input type="hidden" name="category" value="{{ request('category') }}">
    <div style="display: flex; gap: 0.5rem;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="جستجو در محصولات..." style="flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem;">
        <button type="submit" style="padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; background: var(--platform-primary, #4f46e5); color: white; border: none; cursor: pointer;">جستجو</button>
    </div>
</form>

<div class="card-grid card-grid-3">
    @forelse($products as $product)
        <article class="card" style="display: flex; flex-direction: column; overflow: hidden;">
            <a href="{{ route('shop.show', $product->slug) }}" style="flex: 1; text-decoration: none; color: inherit;">
                <div style="aspect-ratio: 1; background: #f3f4f6; overflow: hidden; margin: -1.5rem -1.5rem 1rem -1.5rem;">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 3rem;">📦</div>
                    @endif
                </div>
                <h2 style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.5rem;">{{ $product->title }}</h2>
                <p style="font-weight: 600; margin-bottom: 1rem; color: var(--platform-primary, #4f46e5);">{{ number_format($product->effective_price) }} تومان</p>
            </a>
            <form method="post" action="{{ route('shop.cart.add') }}" style="margin-top: auto;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" style="width: 100%; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; color: white; border: none; cursor: pointer; background: var(--platform-button-primary-bg, #4f46e5);">افزودن به سبد</button>
            </form>
        </article>
    @empty
        <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
            <p style="color: #6b7280; margin-bottom: 1rem;">محصولی یافت نشد.</p>
            <a href="{{ route('home') }}" style="font-weight: 600; color: var(--platform-link-color, #4f46e5);">بازگشت به خانه</a>
        </div>
    @endforelse
</div>

{{ $products->links() }}

<div style="margin-top: 1.5rem;">
    <a href="{{ route('shop.cart') }}" style="display: inline-block; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; color: white; text-decoration: none; background: var(--platform-button-primary-bg, #4f46e5);">مشاهده سبد خرید</a>
</div>
@endsection
