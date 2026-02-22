<h2>ساخت مدیر سایت</h2>

<form method="POST" action="{{ route('install.admin') }}">
    @csrf

    <input name="name" placeholder="نام مدیر">
    <input name="email" placeholder="ایمیل">
    <input name="password" placeholder="رمز عبور">

    <button type="submit">پایان نصب</button>
</form>
