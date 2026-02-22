@extends('admin.layout')
@section('title', 'دسته‌بندی جدید')

<h1>دسته‌بندی جدید</h1>
<form action="{{ route('admin.categories.store') }}" method="post">
    @csrf
    <div class="form-group"><label>نام</label><input type="text" name="name" value="{{ old('name') }}" required></div>
    <div class="form-group"><label>نامک (اختیاری)</label><input type="text" name="slug" value="{{ old('slug') }}"></div>
    <div class="form-group"><label>توضیح</label><textarea name="description">{{ old('description') }}</textarea></div>
    <button type="submit" class="btn btn-primary">ذخیره</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">انصراف</a>
</form>
