@extends('themes.default.layout')

@section('title', \App\Helpers\SiteHelper::siteName())

@section('content')
<section class="hero-section" style="background: linear-gradient(135deg, var(--platform-primary, #4f46e5) 0%, var(--platform-link-hover, #4338ca) 100%); color: white;">
    <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 1rem;">به {{ \App\Helpers\SiteHelper::siteName() }} خوش آمدید</h1>
    <p style="font-size: 1.125rem; opacity: 0.9; max-width: 42rem; margin: 0 auto 1.5rem;">سایت شرکتی و فروشگاهی شما با امکانات وبلاگ، فروشگاه و صفحات ثابت</p>
    <div class="hero-buttons">
        @if(\App\Helpers\SiteHelper::blogEnabled())
            <a href="{{ route('blog.index') }}" style="background: white; color: #1f2937;">مطالب وبلاگ</a>
        @endif
        @if(\App\Helpers\SiteHelper::shopEnabled())
            <a href="{{ route('shop.index') }}" style="background: rgba(255,255,255,0.2); border: 2px solid white; color: white;">فروشگاه</a>
        @endif
        <a href="{{ route('contact.show') }}" style="background: rgba(255,255,255,0.2); border: 2px solid white; color: white;">تماس با ما</a>
    </div>
</section>

@if($aboutUsEnabled && $aboutUsText)
<section class="card" style="margin-bottom: 3rem;">
    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">{{ $aboutUsTitle }}</h2>
    <div style="line-height: 1.75; color: #4b5563;">{!! nl2br(e($aboutUsText)) !!}</div>
</section>
@endif

@if($recentPosts->isNotEmpty())
<section style="margin-bottom: 3rem;">
    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">آخرین مطالب</h2>
    <div class="card-grid card-grid-3">
        @foreach($recentPosts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="card" style="text-decoration: none; color: inherit;">
                <h3 style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.5rem;">{{ $post->title }}</h3>
                <p style="color: #6b7280; font-size: 0.875rem;">{{ $post->published_at ? \App\Helpers\Jalali::formatFa($post->published_at, 'Y/m/d') : '' }}</p>
            </a>
        @endforeach
    </div>
    <div style="margin-top: 1.5rem;">
        <a href="{{ route('blog.index') }}" style="font-weight: 600; color: var(--platform-link-color, #4f46e5);">همهٔ مطالب ←</a>
    </div>
</section>
@endif

@if($featuredProducts->isNotEmpty())
<section style="margin-bottom: 3rem;">
    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">محصولات</h2>
    <div class="card-grid card-grid-4">
        @foreach($featuredProducts as $product)
            <a href="{{ route('shop.show', $product->slug) }}" class="card" style="text-decoration: none; color: inherit; text-align: center;">
                <h3 style="font-weight: 700; margin-bottom: 0.5rem;">{{ $product->title }}</h3>
                <p style="font-weight: 600; color: var(--platform-primary, #4f46e5);">{{ number_format($product->effective_price) }} تومان</p>
            </a>
        @endforeach
    </div>
    <div style="margin-top: 1.5rem;">
        <a href="{{ route('shop.index') }}" style="font-weight: 600; color: var(--platform-link-color, #4f46e5);">همهٔ محصولات ←</a>
    </div>
</section>
@endif

@if($recentPosts->isEmpty() && $featuredProducts->isEmpty())
<section class="text-center py-12 text-gray-500">
    <p>محتوایی برای نمایش وجود ندارد. از پنل مدیریت محتوا اضافه کنید.</p>
</section>
@endif
@endsection
