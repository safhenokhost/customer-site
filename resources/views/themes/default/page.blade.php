@extends('themes.default.layout')
@section('title', $page->meta_title ?: $page->title)
@section('content')
<h1>{{ $page->title }}</h1>
<div>{!! nl2br(e($page->body)) !!}</div>
@endsection
