<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn đặt phòng của tôi - Dolphins Luxury</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

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
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .font-serif-luxury {
            font-family: 'Cormorant Garamond', serif;
        }

        /* =========================================
           NAVBAR
        ========================================= */

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
                linear-gradient(135deg, #22c55e, #16a34a);

            font-size: 20px;

            color: white;
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

            transition: all 0.3s ease;

            overflow: hidden;
        }

        .nav-link::before {

            content: "";

            position: absolute;

            inset: 0;

            background:
                rgba(255, 255, 255, 0.06);

            opacity: 0;

            transition: 0.3s ease;

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

            transition: 0.3s ease;
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

        .nav-profile:hover {
            color: #c084fc;
        }

        .nav-profile:hover::after {
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

        .auth-btn {

            height: 48px;

            padding: 0 22px;

            border-radius: 16px;

            display: flex;
            align-items: center;
            gap: 10px;

            font-size: 14px;
            font-weight: 700;

            transition: 0.3s ease;
        }

        .login-btn {

            background:
                rgba(255, 255, 255, 0.06);

            border:
                1px solid rgba(255, 255, 255, 0.08);

            color: white;
        }

        .login-btn:hover {

            background:
                rgba(255, 255, 255, 0.12);

            transform: translateY(-3px);
        }

        .register-btn {

            background:
                linear-gradient(135deg,
                    #16a34a,
                    #22c55e);

            color: white;
        }

        .register-btn:hover {

            transform:
                translateY(-3px);

            box-shadow:
                0 14px 28px rgba(34, 197, 94, 0.3);
        }

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

            height: 48px;

            padding: 0 18px;

            border-radius: 16px;

            border:
                1px solid rgba(255, 255, 255, 0.08);

            background:
                rgba(255, 255, 255, 0.06);

            color: white;

            display: flex;
            align-items: center;
            gap: 10px;

            cursor: pointer;

            transition: 0.3s ease;
        }

        .user-btn:hover {
            background: rgba(255, 255, 255, 0.12);
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

            border: 1px solid rgba(255, 255, 255, 0.08);

            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.35);

            opacity: 0;
            visibility: hidden;

            transform:
                translateY(10px);

            transition:
                opacity 0.25s ease,
                transform 0.25s ease,
                visibility 0.25s ease;

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

            transition: all 0.25s ease;

            text-decoration: none;

            background: transparent;

            border: none;

            cursor: pointer;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.06);
            color: white;
            transform: translateX(4px);
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.12);
            color: #f87171;
        }

        .luxury-card {

            background:
                linear-gradient(145deg,
                    rgba(255, 255, 255, 0.08),
                    rgba(255, 255, 255, 0.03));

            border:
                1px solid rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(18px);

            transition: all .35s ease;
        }

        .luxury-card:hover {

            transform:
                translateY(-4px);

            border-color:
                rgba(16, 185, 129, 0.35);

            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.28);
        }

        .glass-input {

            background:
                rgba(15, 23, 42, 0.6) !important;

            border:
                1px solid rgba(255, 255, 255, 0.08) !important;

            color: white !important;
        }

        .glass-input:focus {

            outline: none;

            border-color:
                rgba(16, 185, 129, 0.4) !important;

            box-shadow:
                0 0 18px rgba(16, 185, 129, 0.18);
        }

        .btn-shimmer {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-shimmer:hover {
            transform: translateY(-3px);
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 999px;
        }

        @media (max-width:768px) {

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
            .auth-btn,
            .user-btn {

                width: 100%;

                justify-content: center;
            }

            body {
                padding-top: 220px;
            }

            .dropdown-menu {
                right: unset;
                left: 0;
                min-width: 220px;
            }
        }

        .animate-modal {
            animation: modalShow .28s ease;
        }

        @keyframes modalShow {
            from {
                opacity: 0;
                transform: scale(.92) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .custom-scroll::-webkit-scrollbar {
            width: 10px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: rgba(203, 213, 225, 0.35);
            border-radius: 999px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom,
                    #f43f5e,
                    #ef4444);

            border-radius: 999px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom,
                    #fb7185,
                    #f87171);
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

                @guest

                <a href="{{ route('login') }}"
                    class="auth-btn login-btn">

                    <i class="fa-solid fa-right-to-bracket"></i>

                    <span>Đăng Nhập</span>

                </a>

                <a href="{{ route('register') }}"
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

                @endguest

            </div>

        </div>

    </nav>

    <div class="max-w-5xl mx-auto px-4 md:px-8 py-8">

        <!-- HEADER -->

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">

            <div>

                <div class="flex items-center gap-2 mb-2">

                    <span class="h-px w-6 bg-emerald-500"></span>

                    <span class="text-xs uppercase tracking-[0.25em] text-emerald-400 font-semibold">
                        Tài khoản thành viên
                    </span>

                </div>

                <h1 class="font-serif-luxury text-4xl md:text-5xl text-white font-semibold">
                    Đơn Đặt Phòng Của Tôi
                </h1>

            </div>

        </div>

        <!-- Alert Notifications -->

        @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-check"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-8 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm flex items-center gap-3">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
        @endif

        <!-- BOOKINGS -->

        <div class="space-y-8">

            @forelse($bookings as $booking)

            <div class="luxury-card rounded-3xl p-6 md:p-8">

                <!-- HEADER -->

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-white/10">

                    <div>

                        <span class="text-[10px] uppercase tracking-[0.2em] text-emerald-400 font-bold block mb-1">
                            TÊN PHÒNG NGHỈ DƯỠNG
                        </span>

                        <h2 class="font-serif-luxury text-2xl md:text-3xl text-white font-semibold tracking-wide">
                            {{ $booking->room->room_name }}
                        </h2>

                    </div>

                    <div class="flex flex-wrap items-center gap-3">

                        <span class="text-xs font-semibold tracking-wider bg-slate-900/60 text-slate-300 border border-slate-700 px-3.5 py-1.5 rounded-xl">
                            Mã: {{ $booking->booking_code }}
                        </span>

                        @php
                        $bStatus = $booking->status;
                        $bStatusColor = 'text-amber-400 bg-amber-500/10 border-amber-500/20';

                        if(in_array($bStatus, ['confirmed', 'completed'], true)) {
                        $bStatusColor = 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20';
                        } elseif(in_array($bStatus, ['cancelled'], true)) {
                        $bStatusColor = 'text-red-400 bg-red-500/10 border-red-500/20';
                        } elseif(in_array($bStatus, ['checked_in', 'checked_out'], true)) {
                        $bStatusColor = 'text-blue-400 bg-blue-500/10 border-blue-500/20';
                        }
                        @endphp

                        <span class="text-xs font-bold px-3.5 py-1.5 rounded-xl border {{ $bStatusColor }}">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>

                    </div>

                </div>

                <!-- INFO -->

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 py-6 border-b border-white/10 text-sm">

                    <div>
                        <span class="block text-xs uppercase tracking-wider text-slate-400 font-medium mb-1">
                            Ngày nhận phòng
                        </span>

                        <strong class="text-white font-semibold text-base">
                            {{ $booking->check_in_date?->format('d/m/Y') ?? $booking->check_in_date }}
                        </strong>
                    </div>

                    <div>
                        <span class="block text-xs uppercase tracking-wider text-slate-400 font-medium mb-1">
                            Ngày trả phòng
                        </span>

                        <strong class="text-white font-semibold text-base">
                            {{ $booking->check_out_date?->format('d/m/Y') ?? $booking->check_out_date }}
                        </strong>
                    </div>

                    <div>
                        <span class="block text-xs uppercase tracking-wider text-slate-400 font-medium mb-1">
                            Số lượng khách
                        </span>

                        <strong class="text-white font-semibold text-base">
                            {{ $booking->guest_count }} người
                        </strong>
                    </div>

                    <div>
                        <span class="block text-xs uppercase tracking-wider text-slate-400 font-medium mb-1 text-right">
                            Tổng chi phí
                        </span>

                        <p class="text-right text-xl md:text-2xl font-black text-emerald-400 tracking-tight">
                            {{ number_format($booking->total_price) }} VND
                        </p>
                    </div>

                </div>

                <!-- STATUS MESSAGE -->

                <div class="py-4 text-xs md:text-sm text-slate-300 flex items-center gap-2 font-medium">

                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>

                    @if($booking->status === 'pending')
                    <span>Chờ host xác nhận đơn đặt phòng của bạn.</span>

                    @elseif($booking->status === 'awaiting_deposit')
                    <span class="text-amber-400">Vui lòng tiến hành thanh toán tiền cọc để giữ chỗ.</span>

                    @elseif($booking->status === 'confirmed')
                    <span class="text-emerald-400">Đơn đặt phòng đã được xác nhận chính thức.</span>

                    @elseif($booking->status === 'checked_in')
                    <span class="text-blue-400">Chúc bạn có một kỳ nghỉ tuyệt vời tại Resort.</span>

                    @elseif($booking->status === 'checked_out')
                    <span class="text-purple-400">Đã hoàn tất thủ tục trả phòng nghỉ dưỡng.</span>

                    @elseif($booking->status === 'completed')
                    <span class="text-emerald-400">Đơn đặt phòng đã hoàn thành trọn vẹn.</span>

                    @elseif($booking->status === 'cancelled')
                    <span class="text-red-400">Đơn đặt phòng đã bị hủy bỏ.</span>
                    @endif

                </div>

                <!-- DEPOSIT PAYMENT BLOCK -->

                @if($booking->depositPayment)

                <div class="mt-4 p-5 rounded-2xl bg-slate-900/40 border border-white/10">

                    @php $deposit = $booking->depositPayment; @endphp

                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 mb-4">

                        <h3 class="text-sm uppercase tracking-wider text-white font-bold flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Khoản thanh toán đặt cọc
                        </h3>

                        @php
                        $dStatus = $deposit->status;
                        $dStatusClass = 'border-slate-700 text-slate-300 bg-slate-800';

                        if($dStatus === 'paid') $dStatusClass = 'border-emerald-500/20 text-emerald-400 bg-emerald-500/10';

                        if($dStatus === 'pending') $dStatusClass = 'border-amber-500/20 text-amber-400 bg-amber-500/10';

                        if($dStatus === 'expired') $dStatusClass = 'border-red-500/20 text-red-400 bg-red-500/10';
                        @endphp

                        <span class="text-[11px] uppercase font-bold tracking-wider px-3 py-1 rounded-lg border {{ $dStatusClass }}">
                            {{ $deposit->displayStatusLabel() }}
                        </span>

                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-400 mb-4">

                        <p>
                            Số tiền cọc:
                            <strong class="text-white text-sm font-bold ml-1">
                                {{ number_format($deposit->deposit_amount) }} VND
                            </strong>
                        </p>

                        <p class="sm:text-right">
                            Hạn chót thanh toán:
                            <strong class="text-slate-200 ml-1 font-medium">
                                {{ $deposit->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}
                            </strong>
                        </p>

                    </div>

                    @if($booking->status === 'awaiting_deposit' && $deposit->status === 'unpaid')

                    <div class="pt-2">

                        <a href="{{ route('guest.payments.show', $deposit) }}"
                            class="inline-block btn-shimmer bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-semibold text-xs px-5 py-2.5 rounded-xl shadow-md transition-all duration-300">

                            Thanh toán cọc ngay

                        </a>

                    </div>

                    @elseif($deposit->status === 'pending')

                    <p class="text-xs text-amber-400 font-semibold">
                        Đang chờ quản trị viên Resort xác nhận giao dịch thanh toán cọc.
                    </p>

                    @elseif($deposit->status === 'paid')

                    <p class="text-xs text-emerald-400 font-semibold">
                        Bạn đã hoàn thành việc đóng tiền cọc an toàn.
                    </p>

                    @elseif($deposit->status === 'expired')

                    <p class="text-xs text-red-400 font-semibold">
                        Liên kết thanh toán tiền đặt cọc đã hết thời hạn.
                    </p>

                    @endif

                </div>

                @endif

                <!-- FINAL PAYMENT BLOCK -->

                @if($booking->finalPayment)

                <div class="mt-4 p-5 rounded-2xl bg-slate-900/40 border border-white/10">

                    @php $final = $booking->finalPayment; @endphp

                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 mb-4">

                        <h3 class="text-sm uppercase tracking-wider text-white font-bold flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                            Khoản thanh toán còn lại
                        </h3>

                        @php
                        $fStatus = $final->status;
                        $fStatusClass = 'border-slate-700 text-slate-300 bg-slate-800';

                        if($fStatus === 'paid') $fStatusClass = 'border-emerald-500/20 text-emerald-400 bg-emerald-500/10';

                        if($fStatus === 'pending') $fStatusClass = 'border-amber-500/20 text-amber-400 bg-amber-500/10';

                        if($fStatus === 'expired') $fStatusClass = 'border-red-500/20 text-red-400 bg-red-500/10';
                        @endphp

                        <span class="text-[11px] uppercase font-bold tracking-wider px-3 py-1 rounded-lg border {{ $fStatusClass }}">
                            {{ $final->displayStatusLabel() }}
                        </span>

                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-400 mb-4">

                        <p>
                            Số tiền còn lại:
                            <strong class="text-white text-sm font-bold ml-1">
                                {{ number_format($final->deposit_amount) }} VND
                            </strong>
                        </p>

                        <p class="sm:text-right">
                            Hạn chót thanh toán:
                            <strong class="text-slate-200 ml-1 font-medium">
                                {{ $final->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}
                            </strong>
                        </p>

                    </div>

                    @if($booking->status === 'checked_out' && $final->status === 'unpaid')

                    <div class="pt-2">

                        <a href="{{ route('guest.payments.show', $final) }}"
                            class="inline-block btn-shimmer bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-semibold text-xs px-5 py-2.5 rounded-xl shadow-md transition-all duration-300">

                            Thanh toán phần còn lại

                        </a>

                    </div>

                    @endif

                </div>

                @endif

                <!-- CANCEL BUTTON -->

                @if(!in_array($booking->status, ['checked_in', 'checked_out', 'completed', 'cancelled'], true))

                <div class="mt-6 pt-5 border-t border-white/10 text-right">

                    <button type="button"
                        data-cancel-open="cancel-modal-{{ $booking->id }}"
                        class="inline-flex items-center gap-1.5 border border-red-500/20 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white font-bold text-xs px-5 py-2.5 rounded-xl transition-all duration-300 shadow-sm">

                        <i class="fa-solid fa-trash"></i>

                        Hủy đơn đặt phòng này

                    </button>

                    <div id="cancel-modal-{{ $booking->id }}" data-cancel-modal
                        class="fixed inset-0 z-[99999] hidden bg-black/60 backdrop-blur-md">

                        <div class="absolute inset-0 flex items-center justify-center p-4">

                            <div
                                class="w-full max-w-2xl
    max-h-[90vh]
    overflow-y-auto
    rounded-[32px]
    border border-white/30
    bg-gradient-to-br from-slate-100 to-white
    shadow-[0_25px_80px_rgba(0,0,0,0.45)]
    animate-modal custom-scroll">

                                <!-- HEADER -->
                                <div
                                    class="flex items-center justify-between
                px-7 py-5
                border-b border-slate-200
                bg-white">

                                    <div>

                                        <p class="text-[11px] uppercase tracking-[0.35em] text-rose-500 font-bold">
                                            Xác nhận hủy
                                        </p>

                                        <h3 class="text-2xl font-bold text-slate-800 mt-1">
                                            Hủy đơn đặt phòng
                                        </h3>

                                    </div>

                                    <button
                                        type="button"
                                        data-cancel-close="cancel-modal-{{ $booking->id }}"
                                        class="h-11 w-11 rounded-full
                    bg-slate-100 hover:bg-rose-500
                    text-slate-500 hover:text-white
                    transition-all duration-300
                    flex items-center justify-center">

                                        <i class="fa-solid fa-xmark text-lg"></i>

                                    </button>

                                </div>

                                <!-- BODY -->
                                <div class="px-7 py-6 text-sm text-slate-700 bg-white">

                                    <p class="mb-5 leading-7">
                                        Bạn có chắc chắn muốn hủy đơn đặt phòng
                                        <strong class="text-slate-900">
                                            {{ $booking->booking_code }}
                                        </strong>
                                        không?
                                    </p>

                                    <form action="{{ route('guest.bookings.cancel', $booking) }}"
                                        method="POST"
                                        class="space-y-5">

                                        @csrf

                                        <div>

                                            <label class="block mb-2 text-xs uppercase tracking-[0.2em] text-slate-500 font-bold">
                                                Lý do hủy
                                            </label>

                                            <textarea
                                                name="reason"
                                                rows="4"
                                                required
                                                class="w-full rounded-2xl
                            border border-slate-300
                            bg-slate-50
                            p-4
                            text-sm text-slate-800
                            placeholder:text-slate-400
                            focus:border-rose-400
                            focus:ring-4
                            focus:ring-rose-200
                            outline-none transition-all"
                                                placeholder="Vui lòng nhập lý do hủy phòng...">{{ old('reason') }}</textarea>

                                        </div>

                                        @php
                                        $needsRefund = $booking->depositPayment && in_array($booking->depositPayment->status, ['pending', 'paid'], true);
                                        @endphp

                                        @if($needsRefund)

                                        <div
                                            class="rounded-2xl
                        border border-amber-300
                        bg-amber-50
                        p-4 text-sm text-amber-800">

                                            Bạn đã chuyển cọc. Vui lòng nhập thông tin tài khoản để nhận hoàn tiền.

                                        </div>

                                        <div class="grid gap-5 md:grid-cols-2">

                                            <div class="md:col-span-2">

                                                <label class="block mb-2 text-xs uppercase tracking-[0.2em] text-slate-500 font-bold">
                                                    Ngân hàng nhận refund
                                                </label>

                                                <input
                                                    type="text"
                                                    name="bank_name"
                                                    value="{{ old('bank_name') }}"
                                                    placeholder="Ví dụ: Vietcombank"
                                                    required
                                                    class="w-full rounded-2xl border border-slate-300
                                bg-slate-50 p-4 text-slate-800
                                focus:border-rose-400
                                focus:ring-4 focus:ring-rose-200
                                outline-none transition-all">

                                            </div>

                                            <div>

                                                <label class="block mb-2 text-xs uppercase tracking-[0.2em] text-slate-500 font-bold">
                                                    Số tài khoản
                                                </label>

                                                <input
                                                    type="text"
                                                    name="bank_account_number"
                                                    value="{{ old('bank_account_number') }}"
                                                    placeholder="Nhập số tài khoản"
                                                    required
                                                    class="w-full rounded-2xl border border-slate-300
                                bg-slate-50 p-4 text-slate-800
                                focus:border-rose-400
                                focus:ring-4 focus:ring-rose-200
                                outline-none transition-all">

                                            </div>

                                            <div>

                                                <label class="block mb-2 text-xs uppercase tracking-[0.2em] text-slate-500 font-bold">
                                                    Chủ tài khoản
                                                </label>

                                                <input
                                                    type="text"
                                                    name="bank_account_name"
                                                    value="{{ old('bank_account_name') }}"
                                                    placeholder="Ví dụ: NGUYEN VAN A"
                                                    required
                                                    class="w-full rounded-2xl border border-slate-300
                                bg-slate-50 p-4 text-slate-800
                                focus:border-rose-400
                                focus:ring-4 focus:ring-rose-200
                                outline-none transition-all">

                                            </div>

                                        </div>

                                        @endif

                                        <!-- ACTION -->
                                        <div class="flex justify-end gap-3 pt-2">

                                            <button
                                                type="button"
                                                data-cancel-close="cancel-modal-{{ $booking->id }}"
                                                class="px-5 py-3 rounded-2xl
                            bg-slate-200 hover:bg-slate-300
                            text-slate-700 font-bold
                            transition-all">

                                                Đóng

                                            </button>

                                            <button
                                                type="submit"
                                                class="px-5 py-3 rounded-2xl
                            bg-gradient-to-r from-rose-500 to-red-500
                            hover:from-rose-400 hover:to-red-400
                            text-white font-bold
                            shadow-lg shadow-rose-500/30
                            transition-all duration-300
                            hover:-translate-y-1">

                                                Xác nhận hủy

                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                @endif

            </div>

            @empty

            <div class="luxury-card rounded-3xl p-12 text-center border border-white/10 max-w-xl mx-auto">

                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-900 border border-white/10 text-slate-400 mb-4">

                    <i class="fa-solid fa-calendar-xmark text-2xl"></i>

                </div>

                <h3 class="font-serif-luxury text-2xl text-white font-bold mb-2">
                    Chưa có đơn đặt phòng
                </h3>

                <p class="text-slate-400 text-sm max-w-xs mx-auto mb-6">
                    Bạn chưa có đặt phòng nghỉ dưỡng nào trên hệ thống của chúng tôi.
                </p>

                <a href="{{ route('rooms.index') }}"
                    class="inline-block btn-shimmer bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-semibold text-xs px-6 py-3 rounded-xl shadow-md transition-all duration-300">

                    Khám phá danh sách phòng nghỉ

                </a>

            </div>

            @endforelse

        </div>

    </div>

    @include('partials.notification-modal')

    <script>
        function openCancelModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeCancelModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        document.querySelectorAll('[data-cancel-open]').forEach((button) => {
            button.addEventListener('click', () => openCancelModal(button.getAttribute('data-cancel-open')));
        });

        document.querySelectorAll('[data-cancel-close]').forEach((button) => {
            button.addEventListener('click', () => closeCancelModal(button.getAttribute('data-cancel-close')));
        });

        document.querySelectorAll('[data-cancel-modal]').forEach((modal) => {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeCancelModal(modal.id);
                }
            });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                document.querySelectorAll('[data-cancel-modal]').forEach((modal) => {
                    if (!modal.classList.contains('hidden')) {
                        closeCancelModal(modal.id);
                    }
                });
            }
        });
    </script>

</body>

</html>