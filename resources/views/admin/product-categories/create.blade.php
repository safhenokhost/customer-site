@extends('admin.layout')
@section('title', 'دسته‌بندی محصول جدید')
@section('content')
<h1>دسته‌بندی محصول جدید</h1>
<form action="{{ route('admin.product-categories.store') }}" method="post">
    @csrf
    <div class="form-group"><label>نام</label><input type="text" name="name" value="{{ old('name') }}" required></div>
    <div class="form-group"><label>نامک (اختیاری)</label><input type="text" name="slug" value="{{ old('slug') }}"></div>
    <div class="form-group"><label>ترتیب</label><input type="number" name="order" value="{{ old('order', 0) }}" min="0"></div>
    <button type="submit" class="btn btn-primary">ذخیره</button>
    <a href="{{ route('admin.product-categories.index') }}" class="btn btn-secondary">انصراف</a>
</form>
@endsection
