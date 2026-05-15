<h1>Login</h1>

@if ($errors->any())

    <ul>

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

@endif

<form method="POST" action="/login">

    @csrf

    <input type="email"
           name="email"
           placeholder="Email">

    <br><br>

    <input type="password"
           name="password"
           placeholder="Password">

    <br><br>

    <button type="submit">
        Login
    </button>

</form>

<p><a href="{{ route('home') }}">Trang chủ</a> · <a href="{{ route('register') }}">Đăng ký khách</a></p>