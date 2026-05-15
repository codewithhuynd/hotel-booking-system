<h1>Tạo tài khoản host</h1>

@if ($errors->any())

    <ul>

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

@endif

<form method="POST" action="{{ route('host.register-host.store') }}">

    @csrf

    <input type="text" name="full_name" placeholder="Họ và tên" value="{{ old('full_name') }}">

    <br><br>

    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">

    <br><br>

    <input type="password" name="password" placeholder="Mật khẩu">

    <br><br>

    <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu">

    <br><br>

    <button type="submit">Tạo host</button>

</form>

<p><a href="{{ route('host.dashboard') }}">← Về Host Dashboard</a> · <a href="{{ route('home') }}">Trang chủ</a></p>
