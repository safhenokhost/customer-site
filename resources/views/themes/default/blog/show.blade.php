@extends('themes.default.layout')

@section('title', \App\Helpers\Seo::title($post))
@section('meta_description', \App\Helpers\Seo::description($post))
@section('meta_image', \App\Helpers\Seo::imageUrl($post))
@section('canonical', route('blog.show', $post->slug))
@section('og_type', 'article')
@push('json-ld')
<script type="application/ld+json">@json(\App\Helpers\JsonLd::article($post))</script>
@endpush

@section('breadcrumb')
    <a href="{{ route('home') }}">خانه</a>
    <span style="margin: 0 0.5rem;">/</span>
    <a href="{{ route('blog.index') }}">وبلاگ</a>
    <span style="margin: 0 0.5rem;">/</span>
    <span>{{ Str::limit($post->title, 30) }}</span>
@endsection

@section('content')
<article style="max-width: 48rem;">
    @if($post->featured_image)
    <div style="aspect-ratio: 16/9; background: #f3f4f6; border-radius: 0.75rem; overflow: hidden; margin-bottom: 1.5rem;">
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
    @endif
    <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">{{ $post->title }}</h1>
    <p style="color: #6b7280; margin-bottom: 1.5rem;">{{ $post->published_at ? \App\Helpers\Jalali::formatFa($post->published_at, 'Y/m/d') : '' }}</p>
    <div style="line-height: 1.75;">{!! nl2br(e($post->body)) !!}</div>
</article>
<p class="mt-8">
    <a href="{{ route('blog.index') }}" class="font-semibold" style="color: var(--platform-link-color, #4f46e5);">← بازگشت به وبلاگ</a>
</p>
@endsection
