@extends('themes.default.layout')
@section('title', \App\Helpers\Seo::title($page))
@section('meta_description', \App\Helpers\Seo::description($page))
@section('canonical', route('page.show', $page->slug))
@push('json-ld')
<script type="application/ld+json">@json(\App\Helpers\JsonLd::webPage($page->title, route('page.show', $page->slug), \App\Helpers\Seo::description($page)))</script>
@endpush
@section('content')
<h1>{{ $page->title }}</h1>
<div>{!! nl2br(e($page->body)) !!}</div>
@endsection
