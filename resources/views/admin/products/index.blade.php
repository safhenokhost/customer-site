@extends('admin.layout')
@section('title', 'محصولات')

<div class="header">
    <h1>محصولات</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">محصول جدید</a>
</div>
<table>
    <thead>
        <tr><th>عنوان</th><th>قیمت</th><th>موجودی</th><th>وضعیت</th><th>عملیات</th></tr>
    </thead>
    <tbody>
        @foreach($products as $p)
            <tr>
                <td>{{ $p->title }}</td>
                <td>{{ number_format($p->price) }} تومان</td>
                <td>{{ $p->stock }}</td>
                <td>{{ $p->is_active ? 'فعال' : 'غیرفعال' }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-primary">ویرایش</a>
                    <form method="post" action="{{ route('admin.products.destroy', $p) }}" style="display:inline;" onsubmit="return confirm('حذف شود؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $products->links() }}
