@extends('admin.layout')
@section('title', 'مطالب وبلاگ')
@section('content')
<div class="header">
    <h1>مطالب وبلاگ</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">مطلب جدید</a>
</div>
<table>
    <thead><tr><th>عنوان</th><th>دسته</th><th>وضعیت</th><th>تاریخ</th><th>عملیات</th></tr></thead>
    <tbody>
        @foreach($posts as $p)
            <tr>
                <td>{{ $p->title }}</td>
                <td>{{ $p->category?->name ?? '—' }}</td>
                <td>{{ $p->is_published ? 'منتشر شده' : 'پیش‌نویس' }}</td>
                <td>{{ \App\Helpers\Jalali::formatFa($p->created_at, 'Y/m/d') }}</td>
                <td>
                    <a href="{{ route('admin.posts.edit', $p) }}" class="btn btn-primary">ویرایش</a>
                    <form method="post" action="{{ route('admin.posts.destroy', $p) }}" style="display:inline;" onsubmit="return confirm('حذف شود؟');">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">حذف</button></form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $posts->links() }}
@endsection
