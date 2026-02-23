@extends('admin.layout')
@section('title', 'ویرایش دسته‌بندی')
@section('content')
<h1>ویرایش دسته‌بندی: {{ $productCategory->name }}</h1>
<form action="{{ route('admin.product-categories.update', $productCategory) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group"><label>نام</label><input type="text" name="name" value="{{ old('name', $productCategory->name) }}" required></div>
    <div class="form-group"><label>نامک (اختیاری)</label><input type="text" name="slug" value="{{ old('slug', $productCategory->slug) }}"></div>
    <div class="form-group"><label>ترتیب</label><input type="number" name="order" value="{{ old('order', $productCategory->order) }}" min="0"></div>
    <button type="submit" class="btn btn-primary">ذخیره</button>
    <a href="{{ route('admin.product-categories.index') }}" class="btn btn-secondary">انصراف</a>
</form>
@endsection
