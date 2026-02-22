@extends('themes.default.layout')
@section('title', $post->meta_title ?: $post->title)
@section('content')
<article>
<h1>{{ $post->title }}</h1>
<p style="color:#64748b;">{{ $post->published_at?->format('Y/m/d') }}</p>
<div style="margin-top:1rem;">{!! nl2br(e($post->body)) !!}</div>
</article>
<p style="margin-top:1.5rem;"><a href="{{ route('blog.index') }}" class="btn">بازگشت به وبلاگ</a></p>
@endsection
