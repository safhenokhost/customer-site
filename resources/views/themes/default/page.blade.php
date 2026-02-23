@extends('themes.default.layout')

@section('title', \App\Helpers\Seo::title($page))
@section('meta_description', \App\Helpers\Seo::description($page))
@section('canonical', route('page.show', $page->slug))
@push('json-ld')
<script type="application/ld+json">@json(\App\Helpers\JsonLd::webPage($page->title, route('page.show', $page->slug), \App\Helpers\Seo::description($page)))</script>
@endpush

@section('breadcrumb')
    <a href="{{ route('home') }}">خانه</a>
    <span class="mx-2">/</span>
    <span>{{ $page->title }}</span>
@endsection

@section('content')
<article class="max-w-3xl">
    <h1 class="text-2xl md:text-3xl font-bold mb-6">{{ $page->title }}</h1>
    <div class="prose prose-lg max-w-none">{!! nl2br(e($page->body)) !!}</div>
</article>
@endsection
