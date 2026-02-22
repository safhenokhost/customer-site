@extends('admin.layout')
@section('title', 'محصول جدید')

<h1>محصول جدید</h1>
<form action="{{ route('admin.products.store') }}" method="post">
    @csrf
    <div class="form-group"><label>عنوان</label><input type="text" name="title" value="{{ old('title') }}" required></div>
    <div class="form-group"><label>نامک (اختیاری)</label><input type="text" name="slug" value="{{ old('slug') }}"></div>
    <div class="form-group"><label>قیمت (تومان)</label><input type="number" name="price" value="{{ old('price', 0) }}" min="0" required></div>
    <div class="form-group"><label>قیمت با تخفیف (اختیاری)</label><input type="number" name="sale_price" value="{{ old('sale_price') }}" min="0"></div>
    <div class="form-group"><label>موجودی</label><input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"></div>
    <div class="form-group"><label>توضیح</label><textarea name="description">{{ old('description') }}</textarea></div>
    <div class="form-group"><label><input type="checkbox" name="is_active" value="1" checked> فعال</label></div>
    <button type="submit" class="btn btn-primary">ذخیره</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">انصراف</a>
</form>
