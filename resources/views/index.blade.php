@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h4 class="fw-bold mb-4">📋 فرم‌های فعال</h4>

    <div class="row g-3">
        @foreach($forms as $form)
            <div class="col-md-4">
                <a href="{{ route('site.forms.show', $form->slug) }}"
                   class="card p-3 shadow-sm text-decoration-none text-dark h-100">
                    <strong>{{ $form->title }}</strong>
                    <small class="text-muted mt-2">مشاهده فرم</small>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
