@extends('themes.default.layout')

@section('title', 'تماس با ما')

@section('content')
<h1 class="text-2xl font-bold mb-6">تماس با ما</h1>

<form method="post" action="{{ route('contact.submit') }}" class="max-w-xl space-y-4">
    @csrf
    <div>
        <label for="name" class="form-label">نام</label>
        <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
        @error('name')<p class="form-error">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="email" class="form-label">ایمیل</label>
        <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
        @error('email')<p class="form-error">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="subject" class="form-label">موضوع (اختیاری)</label>
        <input type="text" id="subject" name="subject" class="form-input" value="{{ old('subject') }}">
    </div>
    <div>
        <label for="message" class="form-label">پیام</label>
        <textarea id="message" name="message" class="form-textarea" rows="5" required>{{ old('message') }}</textarea>
        @error('message')<p class="form-error">{{ $message }}</p>@enderror
    </div>
    <button type="submit" class="px-6 py-3 font-semibold rounded-lg text-white transition" style="background: var(--platform-button-primary-bg, #4f46e5);">ارسال پیام</button>
</form>
@endsection
