<h1>Register</h1>

@if ($errors->any())

    <ul>

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

@endif

<form method="POST" action="/register">

    @csrf

    <input type="text"
           name="full_name"
           placeholder="Full Name">

    <br><br>

    <input type="email"
           name="email"
           placeholder="Email">

    <br><br>

    <input type="password"
           name="password"
           placeholder="Password">

    <br><br>

    <button type="submit">
        Register
    </button>

</form>

<p><a href="{{ route('home') }}">Trang chủ</a> · <a href="{{ route('login') }}">Đăng nhập</a></p>