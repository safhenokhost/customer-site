@extends('themes.default.layout')
@section('title', isset($category) ? $category->name : 'وبلاگ')
@section('content')
<h1>{{ isset($category) ? $category->name : 'وبلاگ' }}</h1>
<ul style="list-style:none;">
@forelse($posts as $post)
<li style="padding:.75rem 0; border-bottom:1px solid #e2e8f0;">
<a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
<span style="color:#64748b;"> — {{ $post->published_at?->format('Y/m/d') }}</span>
</li>
@empty
<li>مطلبی یافت نشد.</li>
@endforelse
</ul>
{{ $posts->links() }}
@endsection
