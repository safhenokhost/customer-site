@extends('themes.default.layout')

@section('title', \App\Helpers\SiteHelper::siteName())

@section('content')
<h1>به {{ \App\Helpers\SiteHelper::siteName() }} خوش آمدید</h1>
<p>این یک قالب سایت شرکتی و فروشگاهی است.</p>
@if($recentPosts->isNotEmpty())
<h2 style="margin-top:2rem;">آخرین مطالب</h2>
<ul style="list-style:none;">
@foreach($recentPosts as $post)
<li style="padding:.5rem 0;"><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></li>
@endforeach
</ul>
@endif
@if($featuredProducts->isNotEmpty())
<h2 style="margin-top:2rem;">محصولات</h2>
<ul style="list-style:none;">
@foreach($featuredProducts as $product)
<li style="padding:.5rem 0;"><a href="{{ route('shop.show', $product->slug) }}">{{ $product->title }}</a> — {{ number_format($product->effective_price) }} تومان</li>
@endforeach
</ul>
@endif
@endsection
