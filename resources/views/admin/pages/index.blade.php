@extends('admin.layout')
@section('title', 'صفحات')

<div class="header">
    <h1>صفحات</h1>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">صفحه جدید</a>
</div>
<table>
    <thead><tr><th>عنوان</th><th>نامک</th><th>وضعیت</th><th>عملیات</th></tr></thead>
    <tbody>
        @foreach($pages as $p)
            <tr>
                <td>{{ $p->title }}</td>
                <td>{{ $p->slug }}</td>
                <td>{{ $p->is_published ? 'منتشر شده' : 'پیش‌نویس' }}</td>
                <td>
                    <a href="{{ route('page.show', $p->slug) }}" class="btn btn-secondary" target="_blank">مشاهده</a>
                    <a href="{{ route('admin.pages.edit', $p) }}" class="btn btn-primary">ویرایش</a>
                    <form method="post" action="{{ route('admin.pages.destroy', $p) }}" style="display:inline;" onsubmit="return confirm('حذف شود؟');">@csrf @method('DELETE')<button type="submit" class="btn btn-danger">حذف</button></form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
