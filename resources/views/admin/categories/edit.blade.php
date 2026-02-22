@extends('admin.layout')
@section('title', 'ویرایش دسته‌بندی')

<h1>ویرایش دسته‌بندی</h1>
<form action="{{ route('admin.categories.update', $category) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group"><label>نام</label><input type="text" name="name" value="{{ old('name', $category->name) }}" required></div>
    <div class="form-group"><label>نامک</label><input type="text" name="slug" value="{{ old('slug', $category->slug) }}" required></div>
    <div class="form-group"><label>توضیح</label><textarea name="description">{{ old('description', $category->description) }}</textarea></div>
    <div class="form-group"><label>ترتیب</label><input type="number" name="order" value="{{ old('order', $category->order) }}" min="0"></div>
    <button type="submit" class="btn btn-primary">ذخیره</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">انصراف</a>
</form>
