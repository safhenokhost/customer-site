@extends('themes.default.layout')
@section('title', \App\Helpers\Seo::title($post))
@section('meta_description', \App\Helpers\Seo::description($post))
@section('meta_image', \App\Helpers\Seo::imageUrl($post))
@section('canonical', route('blog.show', $post->slug))
@section('og_type', 'article')
@push('json-ld')
<script type="application/ld+json">@json(\App\Helpers\JsonLd::article($post))</script>
@endpush
@section('content')
<article>
<h1>{{ $post->title }}</h1>
<p style="color:#64748b;">{{ $post->published_at ? \App\Helpers\Jalali::formatFa($post->published_at, 'Y/m/d') : '' }}</p>
<div style="margin-top:1rem;">{!! nl2br(e($post->body)) !!}</div>
</article>
<p style="margin-top:1.5rem;"><a href="{{ route('blog.index') }}" class="btn">بازگشت به وبلاگ</a></p>
@endsection
