@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4">{{ $form->title }}</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('site.forms.submit', $form->slug) }}" class="card p-4 shadow-sm">
        @csrf

        @foreach($form->fields as $field)
            <div class="mb-3">
                <label class="form-label">
                    {{ $field->label }}
                    @if($field->is_required) <span class="text-danger">*</span> @endif
                </label>

                @if(in_array($field->type, ['text','email','number']))
                    <input type="{{ $field->type }}" name="field_{{ $field->id }}"
                           class="form-control"
                           placeholder="{{ $field->placeholder }}">
                @elseif($field->type === 'textarea')
                    <textarea name="field_{{ $field->id }}" class="form-control"
                              placeholder="{{ $field->placeholder }}"></textarea>
                @elseif(in_array($field->type, ['select','radio','checkbox']))
                    @foreach($field->options ?? [] as $opt)
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="{{ $field->type === 'select' ? 'radio' : $field->type }}"
                                   name="field_{{ $field->id }}"
                                   value="{{ $opt }}">
                            <label class="form-check-label">{{ $opt }}</label>
                        </div>
                    @endforeach
                @endif

                @if($field->help_text)
                    <div class="form-text">{{ $field->help_text }}</div>
                @endif
            </div>
        @endforeach

        <button class="btn btn-primary w-100">ارسال فرم</button>
    </form>
</div>
@endsection
