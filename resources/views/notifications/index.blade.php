<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Thông Báo</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background:
                radial-gradient(circle at top,
                    rgba(59, 130, 246, 0.12),
                    transparent 30%),
                #020617;

            color: white;

            min-height: 100vh;

            padding-top: 120px;
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

            background: rgba(2, 6, 23, 0.78);

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
                linear-gradient(135deg, #22c55e, #16a34a);

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

        .nav-booking:hover {
            color: #4ade80;
        }

        .nav-booking:hover::after {
            width: calc(100% - 36px);
            background: #4ade80;
        }

        .nav-profile:hover {
            color: #c084fc;
        }

        .nav-profile:hover::after {
            width: calc(100% - 36px);
            background: #c084fc;
        }

        .nav-dashboard:hover {
            color: #fbbf24;
        }

        .nav-dashboard:hover::after {
            width: calc(100% - 36px);
            background: #fbbf24;
        }

        .nav-notification {

            color: #fecaca;

            background:
                linear-gradient(135deg,
                    rgba(127, 29, 29, 0.35),
                    rgba(239, 68, 68, 0.12));

            border:
                1px solid rgba(239, 68, 68, 0.22);
        }

        .nav-notification::after {
            width: calc(100% - 36px);
            background: #ef4444;
        }

        .nav-notification i {
            color: #f87171;
            animation: bellShake 2s infinite;
        }

        @keyframes bellShake {

            0% {
                transform: rotate(0deg);
            }

            10% {
                transform: rotate(14deg);
            }

            20% {
                transform: rotate(-12deg);
            }

            30% {
                transform: rotate(10deg);
            }

            40% {
                transform: rotate(-5deg);
            }

            50% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        /* =========================
           AUTH BUTTON
        ========================= */

        .auth-btn {

            height: 46px;

            padding: 0 20px;

            border-radius: 14px;

            display: flex;
            align-items: center;
            gap: 10px;

            font-weight: 700;

            transition: .3s ease;
        }

        .login-btn {

            background:
                rgba(255, 255, 255, 0.08);

            border:
                1px solid rgba(255, 255, 255, 0.08);
        }

        .login-btn:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .register-btn {

            background:
                linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .register-btn:hover {
            transform: translateY(-3px);
        }

        /* =========================
           USER DROPDOWN
        ========================= */

        .user-dropdown {
            position: relative;
        }

        .user-btn {

            height: 48px;

            padding: 0 18px;

            border: none;

            border-radius: 16px;

            display: flex;
            align-items: center;
            gap: 12px;

            cursor: pointer;

            color: white;

            font-weight: 700;

            background:
                rgba(255, 255, 255, 0.08);

            border:
                1px solid rgba(255, 255, 255, 0.08);
        }

        .dropdown-menu {

            position: absolute;

            top: 60px;
            right: 0;

            min-width: 240px;

            padding: 10px;

            border-radius: 22px;

            background:
                rgba(15, 23, 42, 0.96);

            border:
                1px solid rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(20px);

            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);

            transition: .3s ease;
        }

        .user-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {

            width: 100%;

            border: none;

            background: transparent;

            display: flex;
            align-items: center;
            gap: 12px;

            padding: 14px 16px;

            border-radius: 14px;

            color: #e2e8f0;

            font-weight: 600;

            cursor: pointer;

            transition: .3s ease;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.12);
            color: #fca5a5;
        }

        /* =========================
           MAIN
        ========================= */

        .glass-box {

            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, 0.08),
                    rgba(255, 255, 255, 0.03));

            border:
                1px solid rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(18px);

            border-radius: 32px;
        }

        .page-title {
            font-size: 42px;
            font-weight: 800;
            font-family: serif;
        }

        .unread-badge {

            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 8px 14px;

            border-radius: 999px;

            background:
                rgba(239, 68, 68, 0.15);

            color: #fca5a5;

            font-size: 12px;
            font-weight: 700;
        }

        .btn-primary {

            height: 50px;

            border: none;

            padding: 0 22px;

            border-radius: 16px;

            display: flex;
            align-items: center;
            gap: 10px;

            color: white;

            font-weight: 700;

            cursor: pointer;

            background:
                linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
        }

        /* =========================
           NOTIFICATION CARD
        ========================= */

        .notification-card {

            position: relative;

            overflow: hidden;

            border-radius: 28px;

            padding: 24px;

            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, 0.08),
                    rgba(255, 255, 255, 0.03));

            border:
                1px solid rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(18px);

            transition: all .35s ease;

            cursor: pointer;
        }

        .notification-card:hover {

            transform: translateY(-6px);

            border-color:
                rgba(59, 130, 246, 0.35);

            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.28);
        }

        .notification-unread {

            border-color:
                rgba(239, 68, 68, 0.35);

            background:
                linear-gradient(145deg,
                    rgba(127, 29, 29, 0.22),
                    rgba(255, 255, 255, 0.04));
        }

        .notification-icon {

            width: 64px;
            height: 64px;

            border-radius: 22px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 24px;

            color: white;

            flex-shrink: 0;
        }

        .notification-icon.unread {

            background:
                linear-gradient(135deg, #ef4444, #dc2626);
        }

        .notification-icon.read {

            background:
                linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .mark-read-btn {

            border: none;

            height: 46px;

            padding: 0 18px;

            border-radius: 14px;

            background:
                rgba(255, 255, 255, 0.08);

            border:
                1px solid rgba(255, 255, 255, 0.08);

            color: white;

            font-weight: 700;

            cursor: pointer;

            transition: .3s ease;
        }

        .mark-read-btn:hover {
            background: rgba(255, 255, 255, 0.14);
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 999px;
        }

        @media(max-width:768px) {

            .navbar {

                padding: 18px;

                flex-direction: column;

                align-items: flex-start;

                gap: 16px;
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

            .nav-link {
                flex: 1;
                justify-content: center;
            }

            body {
                padding-top: 200px;
            }

            .page-title {
                font-size: 32px;
            }
        }

        .nav-rooms:hover {
            color: #38bdf8;
        }

        .nav-rooms:hover::after {
            width: calc(100% - 36px);
            background: #38bdf8;
        }
    </style>

</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar">

        <a href="{{ route('home') }}" class="logo">

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

                <a
                    href="{{ route('home') }}"
                    class="nav-link nav-home">

                    <i class="fa-solid fa-house"></i>

                    <span>Trang Chủ</span>

                </a>

                <!-- PHÒNG -->

                <a
                    href="{{ route('rooms.index') }}"
                    class="nav-link nav-rooms">

                    <i class="fa-solid fa-bed"></i>

                    <span>Phòng</span>

                </a>



                @auth

                @if(auth()->user()->role === 'guest')

                <a
                    href="{{ route('guest.bookings.index') }}"
                    class="nav-link nav-booking">

                    <i class="fa-solid fa-calendar-check"></i>

                    <span>Đặt phòng của tôi</span>

                </a>

                <a
                    href="{{ route('profile.edit') }}"
                    class="nav-link nav-profile">

                    <i class="fa-solid fa-user"></i>

                    <span>Hồ sơ cá nhân</span>

                </a>

                @endif

                @if(auth()->user()->role === 'host')

                <a
                    href="{{ route('host.dashboard') }}"
                    class="nav-link nav-dashboard">

                    <i class="fa-solid fa-chart-line"></i>

                    <span>Bảng Điều Khiển</span>

                </a>

                @endif

                @endauth

                <a
                    href="{{ route('notifications.index') }}"
                    class="nav-link nav-notification">

                    <i class="fa-solid fa-bell"></i>

                    <span>Thông Báo</span>

                </a>

            </div>

            <div class="nav-right">

                @guest

                <a
                    href="{{ route('login') }}"
                    class="auth-btn login-btn">

                    <i class="fa-solid fa-right-to-bracket"></i>

                    <span>Đăng Nhập</span>

                </a>

                <a
                    href="{{ route('register') }}"
                    class="auth-btn register-btn">

                    <i class="fa-solid fa-user-plus"></i>

                    <span>Đăng Ký</span>

                </a>

                @else

                <div class="user-dropdown">

                    <button class="user-btn">

                        <i class="fa-solid fa-user"></i>

                        <span>{{ auth()->user()->full_name }}</span>

                        <i class="fa-solid fa-chevron-down"></i>

                    </button>

                    <div class="dropdown-menu">

                        @if(auth()->user()->role === 'guest')

                        <a
                            href="{{ route('guest.bookings.index') }}"
                            class="dropdown-item">

                            <i class="fa-solid fa-calendar-check"></i>

                            Đặt Phòng Của Tôi

                        </a>

                        <a
                            href="{{ route('profile.edit') }}"
                            class="dropdown-item">

                            <i class="fa-solid fa-user"></i>

                            Hồ Sơ Cá Nhân

                        </a>

                        @endif

                        @if(auth()->user()->role === 'host')

                        <a
                            href="{{ route('host.dashboard') }}"
                            class="dropdown-item">

                            <i class="fa-solid fa-chart-line"></i>

                            Bảng Điều Khiển

                        </a>

                        @endif

                        <form
                            method="POST"
                            action="{{ route('logout') }}">

                            @csrf

                            <button
                                type="submit"
                                class="dropdown-item logout-btn">

                                <i class="fa-solid fa-right-from-bracket"></i>

                                Đăng Xuất

                            </button>

                        </form>

                    </div>

                </div>

                @endguest

            </div>

        </div>

    </nav>

    <!-- CONTENT -->

    <div class="max-w-5xl mx-auto py-10 px-4">

        <!-- HEADER -->

        <div class="glass-box p-8 mb-8">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div>

                    <div class="unread-badge mb-4">

                        <i class="fa-solid fa-bell"></i>

                        Trung Tâm Thông Báo

                    </div>

                    <h1 class="page-title mb-3">
                        Thông Báo Của Bạn
                    </h1>

                    <p class="text-slate-300 leading-8 max-w-2xl">
                        Theo dõi trạng thái đặt phòng,
                        thanh toán và các cập nhật mới nhất.
                    </p>

                </div>

                @if($unreadCount > 0)

                <form
                    method="POST"
                    action="{{ route('notifications.mark-all-read') }}">

                    @csrf

                    <button class="btn-primary">

                        <i class="fa-solid fa-check-double"></i>

                        Đánh Dấu Đã Đọc Tất Cả

                    </button>

                </form>

                @endif

            </div>

        </div>

        <!-- EMPTY -->

        @if($notifications->isEmpty())

        <div class="glass-box p-12 text-center">

            <i class="fa-solid fa-bell-slash text-5xl text-slate-500 mb-5"></i>

            <h3 class="text-2xl font-bold mb-3">
                Chưa Có Thông Báo
            </h3>

            <p class="text-slate-400">
                Hiện tại bạn chưa có thông báo nào mới.
            </p>

        </div>

        @else

        <div class="space-y-5">

            @foreach($notifications as $notification)

            @php

            $notificationUrl = $notification->data['url'] ?? null;

            if (! $notificationUrl && auth()->check()) {

            if (! empty($notification->data['booking_id'])) {

            $notificationUrl =
            auth()->user()->role === 'host'
            ? route('admin.bookings.show', [
            'booking' => $notification->data['booking_id']
            ])
            : route('guest.bookings.show', [
            'booking' => $notification->data['booking_id']
            ]);

            } elseif (! empty($notification->data['payment_id'])) {

            $notificationUrl =
            auth()->user()->role === 'host'
            ? route('admin.payments.show', [
            'payment' => $notification->data['payment_id']
            ])
            : route('guest.payments.show', [
            'payment' => $notification->data['payment_id']
            ]);
            }
            }

            @endphp

            <article
                class="notification-card {{ $notification->read_at ? '' : 'notification-unread' }}"
                data-url="{{ $notificationUrl ?? route('notifications.index') }}"
                data-notification-id="{{ $notification->id }}">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                    <div class="flex items-start gap-5 flex-1">

                        <div class="notification-icon {{ $notification->read_at ? 'read' : 'unread' }}">

                            <i class="fa-solid fa-bell"></i>

                        </div>

                        <div class="flex-1">

                            <h3 class="text-2xl font-bold mb-2">

                                {{ $notification->data['title'] ?? 'Thông Báo' }}

                            </h3>

                            <p class="text-slate-300 leading-7 mb-3">

                                {{ $notification->data['message'] ?? '' }}

                            </p>

                            <small class="text-slate-500">

                                <i class="fa-regular fa-clock mr-1"></i>

                                {{ $notification->created_at->diffForHumans() }}

                            </small>

                        </div>

                    </div>

                    @if(is_null($notification->read_at))

                    <button
                        type="button"
                        class="js-mark-read-btn mark-read-btn"
                        data-notification-id="{{ $notification->id }}">

                        <i class="fa-solid fa-check"></i>

                        Đánh Dấu Đã Đọc

                    </button>

                    @endif

                </div>

            </article>

            @endforeach

        </div>

        <div class="mt-8">

            {{ $notifications->links() }}

        </div>

        @endif

    </div>

    <script>
        document.querySelectorAll('.js-mark-read-btn').forEach(function(button) {

            button.addEventListener('click', function(event) {

                event.stopPropagation();

                const id = button.getAttribute('data-notification-id');

                fetch(
                    "{{ route('notifications.mark-read', '__ID__') }}"
                    .replace('__ID__', id), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        credentials: 'same-origin'
                    }
                ).finally(function() {
                    window.location.reload();
                });

            });

        });

        document.querySelectorAll('.notification-card').forEach(function(card) {

            card.addEventListener('click', function() {

                const url = card.dataset.url;

                if (url) {
                    window.location.href = url;
                }

            });

        });
    </script>

    @include('partials.notification-modal')

</body>

</html>