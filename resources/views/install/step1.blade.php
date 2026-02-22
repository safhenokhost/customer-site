<h2>نصب اولیه سایت</h2>

<form method="POST" action="{{ route('install.db') }}">
    @csrf

    <input name="db_host" placeholder="DB Host (مثلاً 127.0.0.1)">
    <input name="db_name" placeholder="DB Name">
    <input name="db_user" placeholder="DB User">
    <input name="db_password" placeholder="DB Password">

    <button type="submit">مرحله بعد</button>

    @error('db')
        <div style="color:red">{{ $message }}</div>
    @enderror
</form>
