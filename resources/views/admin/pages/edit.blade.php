@extends('admin.layout')
@section('title', 'ویرایش صفحه')
@section('content')
<h1>ویرایش صفحه</h1>
<form action="{{ route('admin.pages.update', $page) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group"><label>عنوان</label><input type="text" name="title" value="{{ old('title', $page->title) }}" required></div>
    <div class="form-group"><label>نامک</label><input type="text" name="slug" value="{{ old('slug', $page->slug) }}" required></div>
    <div class="form-group"><label>محتوا</label><textarea name="body">{{ old('body', $page->body) }}</textarea></div>
    <div class="form-group"><label>ترتیب</label><input type="number" name="order" value="{{ old('order', $page->order) }}" min="0"></div>
    <div class="form-group"><label><input type="checkbox" name="is_published" value="1" @if(old('is_published', $page->is_published)) checked @endif> منتشر شود</label></div>
    <div class="form-group"><label><input type="checkbox" name="show_in_menu" value="1" @if(old('show_in_menu', $page->show_in_menu)) checked @endif> در منو</label></div>
    <button type="submit" class="btn btn-primary">ذخیره</button>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">انصراف</a>
</form>
@endsection
