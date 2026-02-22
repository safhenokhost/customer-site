@extends('admin.layout')
@section('title', 'صفحه جدید')

<h1>صفحه جدید</h1>
<form action="{{ route('admin.pages.store') }}" method="post">
    @csrf
    <div class="form-group"><label>عنوان</label><input type="text" name="title" value="{{ old('title') }}" required></div>
    <div class="form-group"><label>نامک (اختیاری)</label><input type="text" name="slug" value="{{ old('slug') }}" placeholder="about-us"></div>
    <div class="form-group"><label>محتوا</label><textarea name="body">{{ old('body') }}</textarea></div>
    <div class="form-group"><label><input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}> منتشر شود</label></div>
    <div class="form-group"><label><input type="checkbox" name="show_in_menu" value="1" {{ old('show_in_menu', true) ? 'checked' : '' }}> در منو نمایش داده شود</label></div>
    <button type="submit" class="btn btn-primary">ذخیره</button>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">انصراف</a>
</form>
