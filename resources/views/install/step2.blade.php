<h2>ادامه نصب ...</h2>

<form method="POST" action="{{ route('install.finish') }}">
    @csrf

    <input name="name" placeholder="نام مدیر">
    <input name="email" placeholder="ایمیل">
    <input type="password" name="password" placeholder="رمز عبور">

    <button type="submit">اتمام نصب</button>
</form>
