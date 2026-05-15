<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang chủ — {{ config('app.name') }}</title>
</head>
<body style="font-family: system-ui, sans-serif; max-width: 40rem; margin: 2rem auto; padding: 0 1rem;">

    <h1>Đặt phòng khách sạn</h1>

    @guest

        <p>Bạn chưa đăng nhập.</p>

        <ul>
            <li><a href="{{ route('login') }}">Đăng nhập</a> — dùng cho <strong>khách</strong> và <strong>host</strong> (cùng một form, phân biệt bằng tài khoản).</li>
            <li><a href="{{ route('register') }}">Đăng ký tài khoản khách</a> (guest).</li>
        </ul>

        <p><small>Tài khoản host do host hiện có tạo trong khu vực host, hoặc dùng tài khoản từ seeder (ví dụ <code>host@gmail.com</code>).</small></p>

    @else

        <p>Xin chào, <strong>{{ Auth::user()->full_name }}</strong><br>
            Email: {{ Auth::user()->email }}<br>
            Vai trò: <strong>{{ Auth::user()->role === 'host' ? 'Host' : 'Khách' }}</strong>
        </p>

        @if (Auth::user()->role === 'host')

            <p style="margin-top: 1.25rem;">
                <a href="{{ route('host.dashboard') }}"
                   style="display: inline-block; padding: 0.6rem 1.25rem; background: #1b1b18; color: #fff; text-decoration: none; border-radius: 4px; font-weight: 500;">
                    Vào Host Dashboard
                </a>
            </p>

        @endif

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 1rem;">
            @csrf
            <button type="submit">Đăng xuất</button>
        </form>

    @endguest

</body>
</html>
