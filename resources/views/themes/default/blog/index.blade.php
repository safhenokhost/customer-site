@extends('themes.default.layout')

@section('title', isset($category) ? $category->name : 'وبلاگ')

@section('breadcrumb')
    <a href="{{ route('home') }}">خانه</a>
    <span>/</span>
    <span>{{ isset($category) ? $category->name : 'وبلاگ' }}</span>
@endsection

@section('content')
<h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">{{ isset($category) ? $category->name : 'وبلاگ' }}</h1>

<form method="get" action="{{ isset($category) ? route('blog.category', $category->slug) : route('blog.index') }}" style="margin-bottom: 1.5rem;">
    <div style="display: flex; gap: 0.5rem;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="جستجو در مطالب..." style="flex: 1; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem;">
        <button type="submit" style="padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; background: var(--platform-primary, #4f46e5); color: white; border: none; cursor: pointer;">جستجو</button>
    </div>
</form>

@if(isset($categories) && $categories->isNotEmpty())
<div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem;">
    <a href="{{ route('blog.index') }}" style="padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; {{ !isset($category) ? 'background: #1f2937; color: white;' : 'background: #f3f4f6; color: #374151;' }}">همه</a>
    @foreach($categories as $c)
        <a href="{{ route('blog.category', $c->slug) }}" style="padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; {{ isset($category) && $category->id === $c->id ? 'background: #1f2937; color: white;' : 'background: #f3f4f6; color: #374151;' }}">{{ $c->name }}</a>
    @endforeach
</div>
@endif

<div class="card-grid card-grid-3">
    @forelse($posts as $post)
        <article class="card" style="display: flex; flex-direction: column; overflow: hidden;">
            <a href="{{ route('blog.show', $post->slug) }}" style="flex: 1; text-decoration: none; color: inherit;">
                <div style="aspect-ratio: 16/9; background: #f3f4f6; overflow: hidden; margin: -1.5rem -1.5rem 1rem -1.5rem;">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 2.5rem;">📄</div>
                    @endif
                </div>
                <h2 style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.5rem;">{{ $post->title }}</h2>
                <p style="color: #6b7280; font-size: 0.875rem;">{{ $post->published_at ? \App\Helpers\Jalali::formatFa($post->published_at, 'Y/m/d') : '' }}</p>
            </a>
        </article>
    @empty
        <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
            <p style="font-size: 1.125rem; color: #6b7280; margin-bottom: 1.5rem;">مطلبی یافت نشد.</p>
            <a href="{{ route('blog.index') }}" style="font-weight: 600; color: var(--platform-link-color, #4f46e5);">بازگشت به وبلاگ</a>
        </div>
    @endforelse
</div>

{{ $posts->links() }}
@endsection
