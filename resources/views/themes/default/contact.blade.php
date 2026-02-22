@extends('themes.default.layout')
@section('title', 'تماس با ما')
@section('content')
<h1>تماس با ما</h1>
<form method="post" action="{{ route('contact.submit') }}">
@csrf
<label>نام</label>
<input type="text" name="name" value="{{ old('name') }}" required>
<label>ایمیل</label>
<input type="email" name="email" value="{{ old('email') }}" required>
<label>پیام</label>
<textarea name="message" required>{{ old('message') }}</textarea>
<button type="submit" class="btn">ارسال</button>
</form>
@endsection
