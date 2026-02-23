@extends('admin.layout')
@section('title', 'ویرایش محصول')
@section('content')
<h1>ویرایش محصول</h1>
<form action="{{ route('admin.products.update', $product) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group"><label>عنوان</label><input type="text" name="title" value="{{ old('title', $product->title) }}" required></div>
    <div class="form-group"><label>نامک</label><input type="text" name="slug" value="{{ old('slug', $product->slug) }}"></div>
    <div class="form-group"><label>دسته‌بندی</label><select name="category_id"><option value="">بدون دسته</option>@foreach($categories ?? [] as $cat)<option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach</select></div>
    <div class="form-group"><label>قیمت (تومان)</label><input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" required></div>
    <div class="form-group"><label>قیمت با تخفیف</label><input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" min="0"></div>
    <div class="form-group"><label>موجودی</label><input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"></div>
    <div class="form-group"><label>توضیح</label><textarea name="description">{{ old('description', $product->description) }}</textarea></div>
    <div class="form-group"><label><input type="checkbox" name="is_active" value="1" @if(old('is_active', $product->is_active)) checked @endif> فعال</label></div>
    <button type="submit" class="btn btn-primary">ذخیره</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">انصراف</a>
</form>
@endsection
