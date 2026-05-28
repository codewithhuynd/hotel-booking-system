<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Danh Sách Phòng Nghỉ</title>

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

            top: 58px;
            right: 0;

            width: 240px;

            background:
                #0f172a;

            border:
                1px solid rgba(255, 255, 255, 0.08);

            border-radius: 20px;

            padding: 10px;

            display: none;

            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .user-dropdown:hover .dropdown-menu {
            display: block;
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

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;

            transition: 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.12);
            color: #f87171;
        }

        /* =========================================
           ROOM CARD
        ========================================= */

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
                translateY(-6px);

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

        .room-slider {

            position: relative;

            width: 100%;
            height: 240px;

            overflow: hidden;

            border-radius: 24px;

            margin-bottom: 20px;
        }

        .room-image {

            width: 100%;
            height: 100%;

            object-fit: cover;

            transition: transform .5s ease;
        }

        .room-slider:hover .room-image {
            transform: scale(1.08);
        }

        .btn-premium {

            transition: 0.3s ease;
        }

        .btn-premium:hover {
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
        }

        /* =========================================
   USER DROPDOWN FIX
========================================= */

        .user-dropdown {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Tạo khoảng đệm invisible để rê chuột xuống menu không bị mất */
        .user-dropdown::after {
            content: "";
            position: absolute;
            top: 100%;
            right: 0;
            width: 100%;
            height: 18px;
        }

        /* BUTTON */

        .user-btn {
            display: flex;
            align-items: center;
            gap: 10px;

            padding: 12px 18px;

            border-radius: 999px;

            background: rgba(255, 255, 255, 0.06);

            border: 1px solid rgba(255, 255, 255, 0.08);

            color: white;

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;

            transition: all 0.3s ease;
        }

        .user-btn:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }

        /* MENU */

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

        /* Hover giữ menu */

        .user-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* ITEM */

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

        /* LOGOUT */

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.12);
            color: #f87171;
        }

        /* MOBILE */

        @media (max-width: 768px) {

            .dropdown-menu {
                right: unset;
                left: 0;
                min-width: 220px;
            }

        }

        /* =========================================
   SEARCH BOX
========================================= */

        .search-subtitle {

            display: inline-block;

            margin-bottom: 10px;

            font-size: 12px;
            font-weight: 700;

            letter-spacing: 0.25em;

            text-transform: uppercase;

            color: #34d399;
        }

        .search-title {

            font-size: 34px;
            font-weight: 700;

            color: white;

            font-family: 'Cormorant Garamond', serif;
        }

        .search-grid {

            display: grid;

            grid-template-columns:
                repeat(auto-fit, minmax(220px, 1fr));

            gap: 20px;
        }

        .field {
            display: flex;
            flex-direction: column;
        }

        .field label {

            display: flex;
            align-items: center;
            gap: 10px;

            margin-bottom: 12px;

            font-size: 13px;
            font-weight: 600;

            color: #cbd5e1;
        }

        .field label i {
            color: #34d399;
        }

        .field input,
        .field select {

            width: 100%;

            height: 58px;

            padding: 0 18px;

            border-radius: 18px;

            background:
                rgba(15, 23, 42, 0.75);

            border:
                1px solid rgba(255, 255, 255, 0.08);

            color: white;

            outline: none;

            transition: all .3s ease;
        }

        .field input:focus,
        .field select:focus {

            border-color:
                rgba(16, 185, 129, 0.5);

            box-shadow:
                0 0 20px rgba(16, 185, 129, 0.18);
        }

        .field input::placeholder {
            color: #64748b;
        }

        .search-btn {

            width: 100%;

            height: 58px;

            border: none;

            border-radius: 18px;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            background:
                linear-gradient(135deg, #10b981, #059669);

            color: white;

            font-weight: 700;

            cursor: pointer;

            transition: all .3s ease;
        }

        .search-btn:hover {

            transform: translateY(-3px);

            box-shadow:
                0 16px 30px rgba(16, 185, 129, 0.28);
        }

        @media(max-width:768px) {

            .search-title {
                font-size: 28px;
            }

            .search-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="/css/heading-font.css">
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

    <!-- CONTENT -->

    <div class="max-w-7xl mx-auto px-4 md:px-8">

        <!-- HEADER -->

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">

            <div>

                <div class="flex items-center gap-2 mb-2">

                    <span class="h-px w-6 bg-emerald-500"></span>

                    <span class="text-xs uppercase tracking-[0.25em] text-emerald-400 font-semibold">
                        Tuyệt tác không gian
                    </span>

                </div>

                <h1 class="font-serif-luxury text-4xl md:text-5xl text-white font-semibold">
                    Danh Sách Phòng Nghỉ
                </h1>

            </div>

        </div>

        <!-- SEARCH -->

        <div class="search-box luxury-card rounded-[32px] p-6 md:p-8 mb-12">

            <div class="search-head mb-8">

                <div>

                    <span class="search-subtitle">
                        Tìm kiếm nhanh
                    </span>

                    <h2 class="search-title">
                        Tìm phòng phù hợp
                    </h2>

                </div>

            </div>

            <form method="GET" action="{{ route('rooms.index') }}">

                <div class="search-grid">

                    <!-- Keyword -->

                    <div class="field">

                        <label>
                            <i class="fa-solid fa-bed"></i>
                            Tên phòng
                        </label>

                        <input
                            type="text"
                            name="keyword"
                            placeholder="Ví dụ: Deluxe Room..."
                            value="{{ request('keyword') }}">

                    </div>

                    <!-- Price -->

                    <div class="field">

                        <label>
                            <i class="fa-solid fa-money-bill-wave"></i>
                            Giá phòng
                        </label>

                        <select name="price">

                            <option value="">
                                Tất cả mức giá
                            </option>

                            <option
                                value="low"
                                {{ request('price') == 'low' ? 'selected' : '' }}>
                                Dưới 500k
                            </option>

                            <option
                                value="medium"
                                {{ request('price') == 'medium' ? 'selected' : '' }}>
                                500k - 1 triệu
                            </option>

                            <option
                                value="high"
                                {{ request('price') == 'high' ? 'selected' : '' }}>
                                Trên 1 triệu
                            </option>

                        </select>

                    </div>

                    <!-- Capacity -->

                    <div class="field">

                        <label>
                            <i class="fa-solid fa-user-group"></i>
                            Sức chứa
                        </label>

                        <select name="capacity">

                            <option value="">
                                Tất cả sức chứa
                            </option>

                            <option
                                value="1"
                                {{ request('capacity') == '1' ? 'selected' : '' }}>
                                1 người
                            </option>

                            <option
                                value="2"
                                {{ request('capacity') == '2' ? 'selected' : '' }}>
                                2 người
                            </option>

                            <option
                                value="4"
                                {{ request('capacity') == '4' ? 'selected' : '' }}>
                                4+ người
                            </option>

                        </select>

                    </div>

                    <!-- Status -->

                    <div class="field">

                        <label>
                            <i class="fa-solid fa-circle-check"></i>
                            Trạng thái
                        </label>

                        <select name="status">

                            <option value="">
                                Tất cả
                            </option>

                            <option
                                value="available"
                                {{ request('status') == 'available' ? 'selected' : '' }}>
                                Còn trống
                            </option>

                        </select>

                    </div>

                    <!-- Sort Price -->

                    <div class="field">

                        <label>
                            <i class="fa-solid fa-arrow-up-wide-short"></i>
                            Sắp xếp giá
                        </label>

                        <select name="sort_price">

                            <option value="">
                                Mặc định
                            </option>

                            <option
                                value="asc"
                                {{ request('sort_price') == 'asc' ? 'selected' : '' }}>
                                Giá thấp → cao
                            </option>

                            <option
                                value="desc"
                                {{ request('sort_price') == 'desc' ? 'selected' : '' }}>
                                Giá cao → thấp
                            </option>

                        </select>

                    </div>

                    <!-- Sort Time -->

                    <div class="field">

                        <label>
                            <i class="fa-solid fa-clock"></i>
                            Sắp xếp
                        </label>

                        <select name="sort_time">

                            <option
                                value="latest"
                                {{ request('sort_time') == 'latest' ? 'selected' : '' }}>
                                Mới nhất
                            </option>

                            <option
                                value="oldest"
                                {{ request('sort_time') == 'oldest' ? 'selected' : '' }}>
                                Cũ nhất
                            </option>

                        </select>

                    </div>

                    <!-- Button -->

                    <div class="field search-btn-wrap">

                        <label>&nbsp;</label>

                        <button
                            type="submit"
                            class="search-btn">

                            <i class="fa-solid fa-magnifying-glass"></i>
                            Tìm kiếm

                        </button>

                    </div>

                </div>

            </form>

        </div>

        <!-- ROOM LIST -->

        @php
        $roomImages = $rooms->mapWithKeys(function ($room) {
        return [
        $room->id => $room->images->pluck('image_path')->values()
        ];
        });
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse($rooms as $room)

            <div class="luxury-card rounded-3xl overflow-hidden p-5 flex flex-col justify-between group">

                <div>

                    <div class="room-slider">

                        @php
                        $mainImage = $room->mainImage ?? $room->images->first();
                        @endphp

                        @if($mainImage)

                        <img
                            src="{{ asset('storage/'.$mainImage->image_path) }}"
                            class="room-image slide-{{ $room->id }}"
                            alt="{{ $room->room_name }}">

                        @endif

                    </div>

                    <div class="px-2">

                        <div class="flex items-center justify-between mb-3">

                            <span class="text-xs uppercase font-semibold tracking-wider text-slate-400 bg-slate-900/60 px-3 py-1.5 rounded-lg border border-slate-800/40">
                                Mã: {{ $room->room_code }}
                            </span>

                            <span class="text-xs font-semibold px-3 py-1.5 rounded-full border border-emerald-500/20 text-emerald-400 bg-emerald-500/10">
                                {{ ucfirst($room->status) }}
                            </span>

                        </div>

                        <h3 class="font-serif-luxury text-2xl text-white font-medium mb-3 group-hover:text-emerald-400 transition-colors duration-300">

                            {{ $room->room_name }}

                        </h3>

                        <div class="space-y-2 border-t border-slate-800/60 pt-4 mb-5">

                            <div class="flex justify-between items-center text-xs">

                                <span class="text-slate-400">
                                    Giá phòng
                                </span>

                                <span class="text-emerald-400 font-bold text-sm">

                                    {{ number_format($room->price) }} VND

                                </span>

                            </div>

                            <div class="flex justify-between items-center text-xs">

                                <span class="text-slate-400">
                                    Sức chứa
                                </span>

                                <span class="text-slate-200 font-medium">

                                    {{ $room->capacity }} khách

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="px-2 pt-2">

                    <a href="{{ route('rooms.show', $room) }}"
                        class="block w-full border border-slate-700 group-hover:border-emerald-500/40 bg-slate-950/40 hover:bg-emerald-600 text-slate-300 hover:text-white text-center font-semibold py-3.5 px-6 rounded-2xl transition-all duration-300 text-sm">

                        Xem Chi Tiết

                    </a>

                </div>

            </div>

            @empty

            <div class="col-span-full py-16 text-center">

                <h3 class="font-serif-luxury text-2xl text-white font-semibold mb-2">

                    Không tìm thấy phòng phù hợp

                </h3>

            </div>

            @endforelse

        </div>

        <!-- PAGINATION -->

        @if($rooms->hasPages())

        <div class="mt-16 flex justify-center">

            {{ $rooms->links() }}

        </div>

        @endif

    </div>

    <!-- SCRIPT -->

    <script>
        const roomImages = @json($roomImages);

        const sliders = {};

        function changeSlide(roomId, direction) {

            const images = roomImages[roomId];

            if (!images || images.length === 0) return;

            if (!sliders[roomId]) sliders[roomId] = 0;

            sliders[roomId] += direction;

            if (sliders[roomId] >= images.length) sliders[roomId] = 0;

            if (sliders[roomId] < 0) sliders[roomId] = images.length - 1;

            const img = document.querySelector('.slide-' + roomId);

            if (img) {

                img.src = '/storage/' + images[sliders[roomId]];

            }
        }
    </script>

    @include('partials.notification-modal')

</body>

</html>