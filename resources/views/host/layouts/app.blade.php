
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;

            background:
                radial-gradient(circle at top left,
                    rgba(16, 185, 129, 0.08),
                    transparent 25%),

                radial-gradient(circle at bottom right,
                    rgba(59, 130, 246, 0.08),
                    transparent 25%),

                #f1f5f9;

            color: #0f172a;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /*
        |------------------------------------------------------------------
        | SIDEBAR
        |------------------------------------------------------------------
        */

        .sidebar {
            width: 290px;

            background:
                linear-gradient(180deg,
                    #0f172a,
                    #111827);

            color: white;

            padding: 28px 22px;

            position: sticky;
            top: 0;

            height: 100vh;

            overflow-y: auto;

            border-right:
                1px solid rgba(255, 255, 255, 0.06);

            box-shadow:
                10px 0 40px rgba(15, 23, 42, 0.18);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 999px;
        }

        /*
        |------------------------------------------------------------------
        | BRAND
        |------------------------------------------------------------------
        */

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;

            margin-bottom: 38px;
        }

        .brand-icon {
            width: 56px;
            height: 56px;

            border-radius: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                linear-gradient(135deg,
                    #10b981,
                    #22c55e);

            box-shadow:
                0 10px 25px rgba(16, 185, 129, 0.35);

            font-size: 22px;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-text strong {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .brand-text span {
            font-size: 11px;
            color: #94a3b8;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /*
        |------------------------------------------------------------------
        | MENU
        |------------------------------------------------------------------
        */

        .menu-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 3px;

            color: #64748b;

            margin-bottom: 14px;
            padding-left: 10px;

            font-weight: 700;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar a {
            position: relative;

            display: flex;
            align-items: center;
            gap: 14px;

            color: #cbd5e1;
            text-decoration: none;

            padding: 14px 16px;

            border-radius: 18px;

            transition: all 0.28s ease;

            font-size: 14px;
            font-weight: 600;

            overflow: hidden;
        }

        .sidebar a::before {

            content: "";

            position: absolute;

            inset: 0;

            background:
                linear-gradient(135deg,
                    rgba(16, 185, 129, 0.12),
                    rgba(59, 130, 246, 0.12));

            opacity: 0;

            transition: .28s ease;
        }

        .sidebar a:hover::before {
            opacity: 1;
        }

        .sidebar a:hover {

            transform:
                translateX(5px);

            color: white;

            background:
                rgba(255, 255, 255, 0.04);
        }

        .sidebar a i {
            width: 18px;
            text-align: center;
            font-size: 15px;
        }

        /*
        |------------------------------------------------------------------
        | CONTENT
        |------------------------------------------------------------------
        */

        .content {
            flex: 1;
            padding: 34px;
        }

        /*
        |------------------------------------------------------------------
        | LOGOUT BUTTON
        |------------------------------------------------------------------
        */

        .logout-wrapper {
            margin-top: 28px;
            padding-top: 22px;

            border-top:
                1px solid rgba(255, 255, 255, 0.08);
        }

        .logout-btn {

            width: 100%;

            border: none;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            padding: 15px;

            border-radius: 18px;

            background:
                linear-gradient(135deg,
                    #ef4444,
                    #dc2626);

            color: white;

            font-size: 14px;
            font-weight: 700;

            cursor: pointer;

            transition: all 0.3s ease;

            box-shadow:
                0 12px 24px rgba(239, 68, 68, 0.22);
        }

        .logout-btn:hover {

            transform:
                translateY(-3px);

            box-shadow:
                0 16px 28px rgba(239, 68, 68, 0.3);
        }

        /*
        |------------------------------------------------------------------
        | RESPONSIVE
        |------------------------------------------------------------------
        */

        @media (max-width: 900px) {

            .container {
                flex-direction: column;
            }

            .sidebar {

                width: 100%;

                height: auto;

                position: relative;
            }

            .content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- SIDEBAR -->

        <div class="sidebar">

            <!-- BRAND -->

            <div class="brand">

                <div class="brand-icon">
                    <i class="fa-solid fa-hotel"></i>
                </div>

                <div class="brand-text">
                    <strong>Dolphins</strong>
                    <span>Quản trị khách sạn</span>
                </div>

            </div>

            <!-- MENU -->

            <div class="menu-title">
                Điều hướng hệ thống
            </div>

            <div class="sidebar-menu">

                <a href="{{ route('home') }}">
                    <i class="fa-solid fa-house"></i>
                    <span>Trang chủ</span>
                </a>

                <a href="{{ route('host.users.index') }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Quản lý người dùng</span>
                </a>

                <a href="{{ route('host.rooms.index') }}">
                    <i class="fa-solid fa-bed"></i>
                    <span>Quản lý phòng</span>
                </a>

                <a href="{{ route('host.bookings.index') }}">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span>Quản lý đặt phòng</span>
                </a>

                <a href="{{ route('host.payments.index') }}">
                    <i class="fa-solid fa-wallet"></i>
                    <span>Thanh toán</span>
                </a>

                <a href="{{ route('host.hotel-settings.index') }}">
                    <i class="fa-solid fa-gear"></i>
                    <span>Cài đặt khách sạn</span>
                </a>

                <a href="{{ route('host.about-sections.index') }}">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Giới thiệu khách sạn</span>
                </a>

                <a href="{{ route('host.services.index') }}">
                    <i class="fa-solid fa-bell-concierge"></i>
                    <span>Dịch vụ khách sạn</span>
                </a>

                <a href="{{ route('host.contact-messages.index') }}">
                    <i class="fa-solid fa-envelope"></i>
                    <span>Tin nhắn liên hệ</span>
                </a>

                <a href="{{ route('host.payment-methods.index') }}">
                    <i class="fa-solid fa-credit-card"></i>
                    <span>Phương thức thanh toán</span>
                </a>

                <a href="{{ route('host.register-host.create') }}">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Tạo tài khoản host</span>
                </a>

            </div>

            <!-- LOGOUT -->

            <div class="logout-wrapper">

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit" class="logout-btn">

                        <i class="fa-solid fa-right-from-bracket"></i>

                        Đăng xuất

                    </button>

                </form>

            </div>

        </div>

        <!-- CONTENT -->

        <div class="content">

            @yield('content')

        </div>

        @include('partials.notification-modal')

    </div>

</body>

</html>

