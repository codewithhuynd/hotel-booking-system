
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Hồ Sơ Cá Nhân | Dolphins Hotel</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="preconnect"
        href="https://fonts.googleapis.com">

    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {

                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },

                    colors: {

                        brand: {

                            dark: '#020617',
                            darkSoft: '#0f172a',

                            blue: '#2563eb',
                            blueLight: '#60a5fa',

                            green: '#16a34a',

                            text: '#e2e8f0',
                            muted: '#94a3b8',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {

            font-family: 'Plus Jakarta Sans', sans-serif;

            background:
                radial-gradient(circle at top,
                    rgba(59, 130, 246, 0.12),
                    transparent 30%),
                #020617;

            color: white;

            min-height: 100vh;

            padding-top: 120px;
            padding-bottom: 60px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {

            position: fixed;

            top: 0;
            left: 0;

            width: 100%;

            z-index: 9999;

            padding: 16px 60px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            background:
                rgba(2, 6, 23, 0.78);

            backdrop-filter: blur(14px);

            border-bottom:
                1px solid rgba(255, 255, 255, 0.08);

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.22);
        }

        .logo {

            display: flex;
            align-items: center;
            gap: 14px;

            color: white;

            font-size: 28px;
            font-weight: 800;

            letter-spacing: 2px;

            text-transform: uppercase;

            font-family: serif;
        }

        .logo-icon {

            width: 50px;
            height: 50px;

            border-radius: 16px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                linear-gradient(135deg,
                    #22c55e,
                    #16a34a);

            font-size: 20px;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .logo-text span {

            font-size: 11px;

            letter-spacing: 2px;

            text-transform: uppercase;

            color: #cbd5e1;
        }

        .nav-wrapper {

            display: flex;
            align-items: center;
            gap: 40px;
        }

        .nav-left,
        .nav-right {

            display: flex;
            align-items: center;
            gap: 14px;
        }

        .nav-link {

            position: relative;

            display: flex;
            align-items: center;
            gap: 10px;

            padding: 10px 18px;

            border-radius: 999px;

            color: #e2e8f0;

            font-weight: 600;

            transition: all .3s ease;

            overflow: hidden;
        }

        .nav-link::before {

            content: "";

            position: absolute;

            inset: 0;

            background:
                rgba(255, 255, 255, 0.06);

            opacity: 0;

            transition: .3s ease;

            border-radius: 999px;
        }

        .nav-link:hover::before {
            opacity: 1;
        }

        .nav-link:hover {
            transform: translateY(-3px);
            color: white;
        }

        .nav-link::after {

            content: "";

            position: absolute;

            left: 18px;
            bottom: 6px;

            width: 0%;

            height: 2px;

            border-radius: 999px;

            transition: .3s ease;
        }

        .nav-home:hover {
            color: #60a5fa;
        }

        .nav-home:hover::after {
            width: calc(100% - 36px);
            background: #60a5fa;
        }

        .nav-room:hover {
            color: #4ade80;
        }

        .nav-room:hover::after {
            width: calc(100% - 36px);
            background: #4ade80;
        }

        .nav-booking:hover {
            color: #facc15;
        }

        .nav-booking:hover::after {
            width: calc(100% - 36px);
            background: #facc15;
        }

        .nav-profile {

            color: #c084fc;

            background:
                linear-gradient(135deg,
                    rgba(168, 85, 247, 0.16),
                    rgba(192, 132, 252, 0.08));

            border:
                1px solid rgba(192, 132, 252, 0.2);
        }

        .nav-profile::after {
            width: calc(100% - 36px);
            background: #c084fc;
        }

        .nav-dashboard:hover {
            color: #fb923c;
        }

        .nav-dashboard:hover::after {
            width: calc(100% - 36px);
            background: #fb923c;
        }

        .nav-notification:hover {
            color: #f87171;
        }

        .nav-notification:hover::after {
            width: calc(100% - 36px);
            background: #ef4444;
        }

        /* =========================
           USER DROPDOWN
        ========================= */

        .user-dropdown {
            position: relative;
            display: flex;
            align-items: center;
        }

        .user-dropdown::after {

            content: "";

            position: absolute;

            top: 100%;
            right: 0;

            width: 100%;
            height: 18px;
        }

        .user-btn {

            display: flex;
            align-items: center;
            gap: 10px;

            padding: 12px 18px;

            border-radius: 999px;

            background:
                rgba(255, 255, 255, 0.06);

            border:
                1px solid rgba(255, 255, 255, 0.08);

            color: white;

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;

            transition: .3s ease;
        }

        .user-btn:hover {

            background:
                rgba(255, 255, 255, 0.12);

            transform: translateY(-2px);
        }

        .dropdown-menu {

            position: absolute;

            top: calc(100% + 14px);
            right: 0;

            min-width: 260px;

            padding: 10px;

            border-radius: 22px;

            background:
                linear-gradient(145deg,
                    rgba(15, 23, 42, 0.96),
                    rgba(30, 41, 59, 0.96));

            backdrop-filter: blur(20px);

            border:
                1px solid rgba(255, 255, 255, 0.08);

            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.35);

            opacity: 0;
            visibility: hidden;

            transform: translateY(10px);

            transition:
                opacity .25s ease,
                transform .25s ease,
                visibility .25s ease;

            z-index: 9999;
        }

        .user-dropdown:hover .dropdown-menu {

            opacity: 1;
            visibility: visible;

            transform: translateY(0);
        }

        .dropdown-item {

            width: 100%;

            display: flex;
            align-items: center;
            gap: 12px;

            padding: 14px 16px;

            border-radius: 16px;

            color: #e2e8f0;

            font-size: 14px;
            font-weight: 600;

            transition: .25s ease;

            background: transparent;

            border: none;

            cursor: pointer;
        }

        .dropdown-item:hover {

            background:
                rgba(255, 255, 255, 0.06);

            color: white;

            transform: translateX(4px);
        }

        .logout-btn:hover {

            background:
                rgba(239, 68, 68, 0.12);

            color: #f87171;
        }

        /* =========================
           GLASS CARD
        ========================= */

        .glass-card {

            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, 0.08),
                    rgba(255, 255, 255, 0.03));

            border:
                1px solid rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(18px);

            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.22);
        }

        .glass-input {

            width: 100%;

            background:
                rgba(15, 23, 42, 0.7);

            border:
                1px solid rgba(255, 255, 255, 0.08);

            color: white;

            border-radius: 16px;

            padding: 14px 16px;

            font-size: 14px;

            transition: .3s ease;
        }

        .glass-input:focus {

            outline: none;

            border-color:
                rgba(59, 130, 246, 0.4);

            box-shadow:
                0 0 20px rgba(59, 130, 246, 0.18);
        }

        .glass-input::placeholder {
            color: #94a3b8;
        }

        .btn-primary {

            width: 100%;

            height: 52px;

            border: none;

            border-radius: 18px;

            color: white;

            font-size: 13px;
            font-weight: 700;

            letter-spacing: .08em;

            text-transform: uppercase;

            cursor: pointer;

            transition: .3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
        }

        .btn-blue {

            background:
                linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);
        }

        .btn-dark {

            background:
                linear-gradient(135deg,
                    #0f172a,
                    #111827);
        }

        /* =========================
           MOBILE
        ========================= */

        @media(max-width:768px) {

            .navbar {

                padding: 18px;

                flex-direction: column;

                align-items: flex-start;

                gap: 18px;
            }

            .nav-wrapper {

                width: 100%;

                flex-direction: column;
                align-items: flex-start;

                gap: 14px;
            }

            .nav-left,
            .nav-right {

                width: 100%;

                flex-wrap: wrap;
            }

            .nav-link,
            .user-btn {

                width: 100%;

                justify-content: center;
            }

            body {
                padding-top: 220px;
            }

            .dropdown-menu {

                left: 0;
                right: unset;

                min-width: 220px;
            }
        }
    </style>

</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar">

        <a href="{{ route('home') }}"
            class="logo">

            <div class="logo-icon">
                <i class="fa-solid fa-hotel"></i>
            </div>

            <div class="logo-text">
                Dolphins
                <span>Khách Sạn Sang Trọng</span>
            </div>

        </a>

        <div class="nav-wrapper">

            <div class="nav-left">

                <a href="{{ route('home') }}"
                    class="nav-link nav-home">

                    <i class="fa-solid fa-house"></i>

                    <span>Trang Chủ</span>

                </a>

                <a href="{{ route('rooms.index') }}"
                    class="nav-link nav-room">

                    <i class="fa-solid fa-bed"></i>

                    <span>Phòng</span>

                </a>

                @auth

                    @if(auth()->user()->role === 'guest')

                        <a href="{{ route('guest.bookings.index') }}"
                            class="nav-link nav-booking">

                            <i class="fa-solid fa-calendar-check"></i>

                            <span>Đặt phòng của tôi</span>

                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="nav-link nav-profile">

                            <i class="fa-solid fa-user"></i>

                            <span>Hồ sơ cá nhân</span>

                        </a>

                    @endif

                    @if(auth()->user()->role === 'host')

                        <a href="{{ route('host.dashboard') }}"
                            class="nav-link nav-dashboard">

                            <i class="fa-solid fa-chart-line"></i>

                            <span>Bảng Điều Khiển</span>

                        </a>

                    @endif

                    <a href="{{ route('notifications.index') }}"
                        class="nav-link nav-notification">

                        <i class="fa-solid fa-bell"></i>

                        <span>Thông Báo</span>

                    </a>

                @endauth

            </div>

            <div class="nav-right">

                @auth

                    <div class="user-dropdown">

                        <button class="user-btn">

                            <i class="fa-solid fa-user"></i>

                            <span>{{ auth()->user()->full_name }}</span>

                            <i class="fa-solid fa-chevron-down"></i>

                        </button>

                        <div class="dropdown-menu">

                            <a href="{{ route('rooms.index') }}"
                                class="dropdown-item">

                                <i class="fa-solid fa-bed"></i>

                                Danh Sách Phòng

                            </a>

                            @if(auth()->user()->role === 'guest')

                                <a href="{{ route('guest.bookings.index') }}"
                                    class="dropdown-item">

                                    <i class="fa-solid fa-calendar-check"></i>

                                    Đặt Phòng Của Tôi

                                </a>

                                <a href="{{ route('profile.edit') }}"
                                    class="dropdown-item">

                                    <i class="fa-solid fa-user"></i>

                                    Hồ Sơ Cá Nhân

                                </a>

                            @endif

                            @if(auth()->user()->role === 'host')

                                <a href="{{ route('host.dashboard') }}"
                                    class="dropdown-item">

                                    <i class="fa-solid fa-chart-line"></i>

                                    Bảng Điều Khiển

                                </a>

                            @endif

                            <a href="{{ route('notifications.index') }}"
                                class="dropdown-item">

                                <i class="fa-solid fa-bell"></i>

                                Thông Báo

                            </a>

                            <form method="POST"
                                action="{{ route('logout') }}">

                                @csrf

                                <button type="submit"
                                    class="dropdown-item logout-btn">

                                    <i class="fa-solid fa-right-from-bracket"></i>

                                    Đăng Xuất

                                </button>

                            </form>

                        </div>

                    </div>

                @endauth

            </div>

        </div>

    </nav>

    <!-- CONTENT -->

    <div class="max-w-6xl mx-auto px-4 md:px-8">

        <!-- HERO -->

        <div class="glass-card rounded-[34px] p-8 md:p-10 mb-10 relative overflow-hidden">

            <div class="absolute top-0 right-0 w-72 h-72 bg-blue-500/10 blur-3xl rounded-full"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-8">

                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-200 to-white flex items-center justify-center border border-white/20 shadow-xl">

                    <span class="font-serif text-4xl text-slate-900 font-semibold uppercase">
                        {{ substr($user->full_name ?? 'G', 0, 1) }}
                    </span>

                </div>

                <div>

                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 mb-4 text-sm text-blue-300 font-semibold">

                        <i class="fa-solid fa-crown"></i>

                        Hội Viên Đặc Quyền

                    </div>

                    <h1 class="font-serif text-4xl md:text-5xl font-semibold mb-3">

                        Xin chào,
                        {{ $user->full_name }}

                    </h1>

                    <p class="text-slate-300 leading-8 max-w-2xl">

                        Quản lý thông tin tài khoản,
                        bảo mật và trải nghiệm cá nhân của bạn
                        tại Dolphins Hotel.

                    </p>

                </div>

            </div>

        </div>

        <!-- SUCCESS -->

        @if(session('success'))

            <div class="mb-8 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-4 text-emerald-300 flex items-center gap-3">

                <i class="fa-solid fa-circle-check"></i>

                <span>{{ session('success') }}</span>

            </div>

        @endif

        @if(session('error'))

            <div class="mb-8 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-rose-200 flex items-center gap-3">

                <i class="fa-solid fa-circle-xmark"></i>

                <span>{{ session('error') }}</span>

            </div>

        @endif

        <!-- ERRORS -->

        @if($errors->any())

            <div class="mb-8 rounded-2xl border border-red-500/20 bg-red-500/10 px-5 py-5">

                <div class="flex items-center gap-2 text-red-300 font-semibold mb-3">

                    <i class="fa-solid fa-triangle-exclamation"></i>

                    <span>Thông tin chưa hợp lệ</span>

                </div>

                <ul class="list-disc pl-5 text-sm text-red-200 space-y-1">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <!-- FORM GRID -->

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- PROFILE -->

            <div class="glass-card rounded-[30px] p-8">

                <div class="flex items-center gap-3 mb-8">

                    <div class="w-12 h-12 rounded-2xl bg-blue-500/20 flex items-center justify-center text-blue-400">

                        <i class="fa-solid fa-user text-lg"></i>

                    </div>

                    <div>

                        <h2 class="font-serif text-2xl">
                            Thông Tin Cá Nhân
                        </h2>

                        <p class="text-slate-400 text-sm mt-1">
                            Cập nhật hồ sơ của bạn
                        </p>

                    </div>

                </div>

                <form method="POST"
                    action="{{ route('profile.update') }}"
                    class="space-y-5">

                    @csrf

                    <div>

                        <label class="block text-sm text-slate-300 mb-2">
                            Họ và tên
                        </label>

                        <input
                            type="text"
                            name="full_name"
                            value="{{ old('full_name', $user->full_name) }}"
                            class="glass-input"
                            placeholder="Nhập họ tên"
                            required
                            minlength="2"
                            maxlength="100">
                    </div>

                    <div>

                        <label class="block text-sm text-slate-300 mb-2">
                            Số điện thoại
                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            class="glass-input"
                            placeholder="Nhập số điện thoại"
                            pattern="^(0|\+84)[0-9]{9,10}$"
                            maxlength="20">
                    </div>

                    <div>

                        <label class="block text-sm text-slate-300 mb-2">
                            Ngày sinh
                        </label>

                        <input
                            type="date"
                            name="birthday"
                            value="{{ old('birthday', optional($user->birthday)->format('Y-m-d')) }}"
                            class="glass-input"
                            max="{{ now()->format('Y-m-d') }}">
                    </div>

                    <button type="submit"
                        class="btn-primary btn-blue">

                        Cập Nhật Thông Tin

                    </button>

                </form>

            </div>

            <!-- PASSWORD -->

            <div class="glass-card rounded-[30px] p-8">

                <div class="flex items-center gap-3 mb-8">

                    <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-white">

                        <i class="fa-solid fa-lock text-lg"></i>

                    </div>

                    <div>

                        <h2 class="font-serif text-2xl">
                            Đổi Mật Khẩu
                        </h2>

                        <p class="text-slate-400 text-sm mt-1">
                            Bảo vệ tài khoản của bạn bằng xác nhận email
                        </p>

                    </div>

                </div>

                <form method="POST"
                    action="{{ route('profile.change-password') }}"
                    class="space-y-5">

                    @csrf

                    <div>

                        <label class="block text-sm text-slate-300 mb-2">
                            Mật khẩu hiện tại
                        </label>

                        <input
                            type="password"
                            name="current_password"
                            class="glass-input"
                            placeholder="••••••••"
                            required>
                    </div>

                    <div>

                        <label class="block text-sm text-slate-300 mb-2">
                            Mật khẩu mới
                        </label>

                        <input
                            type="password"
                            name="new_password"
                            class="glass-input"
                            placeholder="••••••••"
                            required
                            minlength="8">
                    </div>

                    <div>

                        <label class="block text-sm text-slate-300 mb-2">
                            Xác nhận mật khẩu
                        </label>

                        <input
                            type="password"
                            name="new_password_confirmation"
                            class="glass-input"
                            placeholder="••••••••"
                            required>
                    </div>

                    <p class="text-xs text-slate-400 leading-6">
                        Sau khi gửi yêu cầu, hệ thống sẽ tạo link xác nhận có hiệu lực 15 phút và gửi về email của bạn.
                    </p>

                    <button type="submit"
                        class="btn-primary btn-dark">

                        Đổi Mật Khẩu

                    </button>

                </form>

            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if($errors->any())
                const messages = @json($errors->all());
                const text = 'Thông tin chưa hợp lệ:\n' + messages
                    .map((message, index) => (index + 1) + '. ' + message)
                    .join('\n');

                window.alert(text);
            @endif
        });
    </script>

    @include('partials.notification-modal')

</body>

</html>

