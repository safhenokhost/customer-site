@extends('admin.layout')
@section('title', 'دسته‌بندی محصولات')
@section('content')
<div class="header">
    <h1>دسته‌بندی محصولات</h1>
    <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary">دسته جدید</a>
</div>
<table>
    <thead><tr><th>نام</th><th>نامک</th><th>ترتیب</th><th>عملیات</th></tr></thead>
    <tbody>
        @foreach($categories as $c)
            <tr>
                <td>{{ $c->name }}</td>
                <td>{{ $c->slug }}</td>
                <td>{{ $c->order }}</td>
                <td>
                    <a href="{{ route('admin.product-categories.edit', $c) }}" class="btn btn-primary">ویرایش</a>
                    <form method="post" action="{{ route('admin.product-categories.destroy', $c) }}" style="display:inline;" onsubmit="return confirm('حذف شود؟');">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">حذف</button></form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
