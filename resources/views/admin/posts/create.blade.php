@extends('admin.layout')
@section('title', 'مطلب جدید')
@section('content')
<h1>مطلب جدید</h1>
<form action="{{ route('admin.posts.store') }}" method="post">
    @csrf
    <div class="form-group"><label>عنوان</label><input type="text" name="title" value="{{ old('title') }}" required></div>
    <div class="form-group"><label>نامک (اختیاری)</label><input type="text" name="slug" value="{{ old('slug') }}"></div>
    <div class="form-group"><label>دسته‌بندی</label><select name="category_id"><option value="">—</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
    <div class="form-group"><label>خلاصه</label><textarea name="excerpt">{{ old('excerpt') }}</textarea></div>
    <div class="form-group"><label>محتوا</label><textarea name="body">{{ old('body') }}</textarea></div>
    <div class="form-group"><label><input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}> منتشر شود</label></div>
    <button type="submit" class="btn btn-primary">ذخیره</button>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">انصراف</a>
</form>
@endsection
