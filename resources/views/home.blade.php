<?php

use Illuminate\Support\Facades\Auth;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Trang chủ — {{ config('app.name') }}
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;

            padding: 26px 70px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            background: linear-gradient(to bottom,
                    rgba(2, 6, 23, 0.65),
                    rgba(2, 6, 23, 0.10));
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: 2px;
            color: #fff;
            text-transform: uppercase;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .nav-link {
            color: #e2e8f0;
            font-weight: 500;
            padding: 8px 10px;
            opacity: 0.95;
        }

        .nav-link:hover {
            color: #fff;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 12px 22px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: 0.25s ease;
            white-space: nowrap;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-white {
            background: #ffffff;
            color: #111827;
            box-shadow: 0 12px 30px rgba(255, 255, 255, 0.10);
        }

        .btn-dark {
            background: #111827;
            color: #fff;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .btn-green {
            background: #16a34a;
            color: #fff;
            box-shadow: 0 12px 30px rgba(22, 163, 74, 0.18);
        }

        .btn-red {
            background: #dc2626;
            color: #fff;
            box-shadow: 0 12px 30px rgba(220, 38, 38, 0.18);
        }

        .btn-outline {
            border: 1px solid rgba(255, 255, 255, 0.35);
            color: #fff;
            background: transparent;
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;

            background: linear-gradient(135deg,
                rgba(2, 6, 23, 0.75),
                rgba(15, 23, 42, 0.45)),
            url('{{ asset("images/hero.jpg") }}');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.08), transparent 25%),
                radial-gradient(circle at 80% 30%, rgba(255, 255, 255, 0.06), transparent 20%);
            pointer-events: none;
        }

        .hero-inner {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 140px 30px 90px;
            position: relative;
            z-index: 1;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.25fr 0.75fr;
            gap: 40px;
            align-items: end;
        }

        .hero-content {
            max-width: 760px;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(10px);
            color: #fff;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 22px;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(44px, 6vw, 86px);
            line-height: 1.04;
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }

        .hero p {
            max-width: 650px;
            font-size: 17px;
            color: #e2e8f0;
            opacity: 0.95;
            margin-bottom: 30px;
        }

        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .hero-stats {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
            margin-top: 22px;
        }

        .stat-chip {
            padding: 14px 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.10);
            min-width: 150px;
        }

        .stat-chip strong {
            display: block;
            font-size: 18px;
            color: #fff;
            margin-bottom: 4px;
        }

        .stat-chip span {
            color: #cbd5e1;
            font-size: 13px;
        }

        .hero-card {
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 28px;
            padding: 26px;
            color: #fff;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.22);
        }

        .hero-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .hero-card p {
            color: #e2e8f0;
            opacity: 0.95;
            margin-bottom: 18px;
            font-size: 15px;
        }

        .card-list {
            display: grid;
            gap: 12px;
        }

        .card-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(15, 23, 42, 0.38);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .card-item strong {
            font-size: 14px;
        }

        .card-item span {
            font-size: 13px;
            color: #cbd5e1;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 30px;
        }

        .search-box {
            margin-top: -72px;
            position: relative;
            z-index: 20;
            background: #ffffff;
            color: #0f172a;
            border-radius: 28px;
            padding: 30px;
            box-shadow: 0 24px 70px rgba(2, 6, 23, 0.18);
        }

        .search-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-head h2 {
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            color: #111827;
            white-space: nowrap;
        }

        .search-head p {
            color: #475569;
            max-width: 560px;
        }

        .search-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 16px;
            align-items: end;
        }

        .field {
            min-width: 0;
        }

        @media (max-width: 1200px) {
            .search-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .search-grid {
                grid-template-columns: 1fr;
            }
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        input,
        select {
            width: 100%;
            padding: 15px 16px;
            border: 1px solid #dbe3ee;
            border-radius: 14px;
            font-size: 15px;
            background: #f8fafc;
            color: #0f172a;
            outline: none;
            transition: 0.2s;
        }

        input:focus,
        select:focus {
            border-color: #94a3b8;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(148, 163, 184, 0.18);
        }

        .rooms-section {
            padding: 96px 0 90px;
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 20px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .section-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(30px, 4vw, 48px);
            color: #fff;
        }

        .section-title p {
            color: #cbd5e1;
            max-width: 700px;
        }

        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 28px;
        }

        .room-card {
            background: #fff;
            color: #0f172a;
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 16px 40px rgba(2, 6, 23, 0.10);
            transition: 0.28s ease;
            border: 1px solid rgba(148, 163, 184, 0.14);
        }

        .room-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 22px 55px rgba(2, 6, 23, 0.18);
        }

        .room-image {
            width: 100%;
            height: 260px;
            object-fit: cover;
            background: linear-gradient(135deg, #cbd5e1, #e2e8f0);
        }

        .room-content {
            padding: 22px 22px 24px;
        }

        .room-topline {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .room-content h3 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            line-height: 1.2;
            margin-bottom: 10px;
            color: #111827;
        }

        .price {
            font-size: 30px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 14px;
        }

        .meta {
            display: grid;
            gap: 8px;
            margin-bottom: 16px;
        }

        .meta p {
            color: #475569;
            font-size: 14px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .badge.available {
            background: #dcfce7;
            color: #166534;
        }

        .badge.occupied {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge.cleaning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge.maintenance {
            background: #e2e8f0;
            color: #334155;
        }

        .top-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .welcome-box {
            margin-top: 26px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.98));
            color: #0f172a;
            padding: 24px;
            border-radius: 24px;
            box-shadow: 0 16px 40px rgba(2, 6, 23, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.12);
        }

        .welcome-box p {
            color: #334155;
        }

        .info-strip {
            margin-top: 36px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 22px;
            padding: 18px;
            backdrop-filter: blur(8px);
        }

        .info-card h4 {
            color: #fff;
            font-size: 18px;
            margin-bottom: 8px;
        }

        .info-card p {
            color: #cbd5e1;
            font-size: 14px;
        }

        .empty-box {
            margin-top: 20px;
            padding: 18px 20px;
            border-radius: 18px;
            background: #fff;
            color: #0f172a;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.08);
        }

        @media (max-width: 1024px) {
            .hero-grid {
                grid-template-columns: 1fr;
            }

            .info-strip {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 18px 18px;
                flex-direction: column;
                gap: 14px;
                align-items: flex-start;
            }

            .logo {
                font-size: 24px;
            }

            .hero-inner {
                padding: 150px 18px 80px;
            }

            .hero {
                min-height: auto;
                padding-bottom: 30px;
            }

            .search-box {
                margin-top: -36px;
                padding: 20px;
            }

            .container {
                padding: 0 18px;
            }

            .rooms-section {
                padding: 72px 0 80px;
            }

            .section-title {
                align-items: flex-start;
            }

            .info-strip {
                grid-template-columns: 1fr;
            }
        }

        textarea:focus {
            border-color: #94a3b8;
            background: #fff;
            outline: none;
            box-shadow: 0 0 0 4px rgba(148, 163, 184, 0.18);
        }

        .info-strip {
            align-items: stretch;
        }

        .info-card {
            height: 100%;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">

        <div class="logo">
            dolPHPhins HOTEL BOOKING

        </div>

        <div class="nav-right">

            <a href="#rooms" class="nav-link">Rooms</a>
            <a href="#about" class="nav-link">About</a>
            <a href="#services" class="nav-link">Services</a>
            <a href="#contact" class="nav-link">Contact</a>

            @guest

            <a
                href="{{ route('login') }}"
                class="btn btn-white">
                Đăng nhập
            </a>

            <a
                href="{{ route('register') }}"
                class="btn btn-green">
                Đăng ký
            </a>

            @else


            @if(Auth::user()->role === 'guest')

            <a
                href="{{ route('guest.bookings.index') }}"
                class="nav-link">
                My Bookings
            </a>

            <a
                href="#"
                class="nav-link">
                My Profile
            </a>

            @endif

            @if(Auth::user()->role === 'host')

            <a
                href="{{ route('host.dashboard') }}"
                class="btn btn-dark">
                Host Dashboard
            </a>

            @endif
            <span>
                Xin chào,
                <strong>
                    {{ Auth::user()->full_name }}
                </strong>
            </span>

            <form
                method="POST"
                action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="btn btn-red">
                    Đăng xuất
                </button>
            </form>

            @endguest

        </div>

    </div>

    <!-- HERO -->
    <section class="hero">

        <div class="hero-inner">

            <div class="hero-grid">

                <div class="hero-content">

                    <div class="hero-kicker">
                        Luxury stay • Easy booking • Best experience
                    </div>

                    <h1>
                        Tìm khách sạn phù hợp cho bạn
                    </h1>

                    <p>
                        Đặt phòng nhanh chóng, dễ dàng và tiện lợi. Khám phá những căn phòng đẹp,
                        không gian sang trọng và dịch vụ chuyên nghiệp dành cho bạn.
                    </p>

                    <div class="hero-actions">
                        <a href="#rooms" class="btn btn-white">Explore Rooms</a>
                        <a href="{{ route('login') }}" class="btn btn-outline">Login to Book</a>
                    </div>

                    <div class="hero-stats">
                        <div class="stat-chip">
                            <strong>100+</strong>
                            <span>Phòng đẹp</span>
                        </div>
                        <div class="stat-chip">
                            <strong>24/7</strong>
                            <span>Hỗ trợ khách hàng</span>
                        </div>
                        <div class="stat-chip">
                            <strong>Luxury</strong>
                            <span>Không gian đẳng cấp</span>
                        </div>
                    </div>
                </div>

                <div class="hero-card">
                    <h3>Quick Highlights</h3>
                    <p>Những điểm nổi bật giúp khách mới có cảm giác tin tưởng ngay từ trang đầu.</p>

                    <div class="card-list">
                        <div class="card-item">
                            <div>
                                <strong>Đặt phòng nhanh</strong><br>
                                <span>Tìm và xem phòng chỉ trong vài giây</span>
                            </div>
                        </div>

                        <div class="card-item">
                            <div>
                                <strong>Ảnh phòng rõ ràng</strong><br>
                                <span>Xem hình ảnh thực tế của từng phòng</span>
                            </div>
                        </div>

                        <div class="card-item">
                            <div>
                                <strong>Giá hiển thị minh bạch</strong><br>
                                <span>Biết ngay mức giá trước khi đặt</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <div class="container">

        <!-- SEARCH -->
        <div class="search-box">

            <div class="search-head">
                <div>
                    <h2>Tìm phòng phù hợp</h2>

                </div>
            </div>

            <form
                method="GET"
                action="{{ route('home') }}">
                <div class="search-grid">

                    <div class="field">
                        <label>Tên phòng</label>
                        <input
                            type="text"
                            name="keyword"
                            placeholder="Tên phòng..."
                            value="{{ request('keyword') }}">
                    </div>

                    <div class="field">
                        <label>Giá phòng</label>
                        <select name="price">
                            <option value="">Tất cả mức giá</option>
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

                    <div class="field">
                        <label>Sức chứa</label>
                        <select name="capacity">
                            <option value="">Tất cả sức chứa</option>
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
                    <div class="field">
                        <label>Trạng thái</label>

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
                    <div class="field">
                        <label>Sắp xếp giá</label>

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
                    <div class="field">
                        <label>Sắp xếp</label>

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

                    <div class="field">
                        <label>&nbsp;</label>
                        <button
                            type="submit"
                            class="btn btn-dark"
                            style="width:100%;">
                            Tìm kiếm
                        </button>
                    </div>

                </div>
            </form>

        </div>

        <!-- USER / ROLE SECTION -->





        @if(Auth::check() && Auth::user()->role === 'host')

        <div class="welcome-box">

            <div
                style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    gap:20px;
                    flex-wrap:wrap;
                ">

                <div>

                    <h2
                        style="
                            font-family:'Playfair Display',serif;
                            margin-bottom:10px;
                            font-size:32px;
                            color:#111827;
                        ">
                        Host Dashboard
                    </h2>

                    <p style="color:#475569;">
                        Quản lý phòng, booking và hoạt động kinh doanh.
                    </p>

                </div>

                <a
                    href="{{ route('host.dashboard') }}"
                    class="btn btn-dark">
                    Đi tới Dashboard
                </a>

            </div>

            <div
                style="
                    display:grid;
                    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
                    gap:18px;
                    margin-top:28px;
                ">

                <div
                    style="
                        background:#f8fafc;
                        padding:24px;
                        border-radius:20px;
                        border:1px solid #e2e8f0;
                    ">

                    <h3
                        style="
                            color:#111827;
                            margin-bottom:8px;
                        ">
                        Manage Rooms
                    </h3>

                    <p style="color:#475569;">
                        Thêm, sửa, xóa và cập nhật trạng thái phòng.
                    </p>

                </div>

                <div
                    style="
                        background:#f8fafc;
                        padding:24px;
                        border-radius:20px;
                        border:1px solid #e2e8f0;
                    ">

                    <h3
                        style="
                            color:#111827;
                            margin-bottom:8px;
                        ">
                        Manage Bookings
                    </h3>

                    <p style="color:#475569;">
                        Theo dõi booking mới,
                        xác nhận cọc và check-in.
                    </p>

                </div>

                <div
                    style="
                        background:#f8fafc;
                        padding:24px;
                        border-radius:20px;
                        border:1px solid #e2e8f0;
                    ">

                    <h3
                        style="
                            color:#111827;
                            margin-bottom:8px;
                        ">
                        Revenue
                    </h3>

                    <p style="color:#475569;">
                        Theo dõi doanh thu và hoạt động khách sạn.
                    </p>

                </div>

            </div>

        </div>

        @endif

        <!-- ROOM LIST -->
        <section class="rooms-section" id="rooms">

            <div class="section-title">
                <div>
                    <h2>Luxury Rooms</h2>

                </div>

                <a
                    href="{{ route('rooms.index') }}"
                    class="btn btn-white">
                    Xem tất cả
                </a>
            </div>

            <div class="room-grid">

                @forelse($rooms as $room)

                <div class="room-card">

                    @if($room->mainImage)

                    <img
                        src="{{ asset('storage/' . $room->mainImage->image_path) }}"
                        class="room-image"
                        alt="{{ $room->room_name }}">

                    @else

                    <div class="room-image"></div>

                    @endif

                    <div class="room-content">



                        <h3>
                            {{ $room->room_name }}
                        </h3>

                        <div class="price">
                            {{ number_format($room->price) }} VND
                        </div>

                        <div class="meta">
                            <p>
                                <strong>Sức chứa:</strong>
                                {{ $room->capacity }} người
                            </p>

                            <p>
                                <strong>Mã phòng:</strong>
                                {{ $room->room_code }}
                            </p>
                        </div>

                        <a
                            href="{{ route('rooms.show', $room) }}"
                            class="btn btn-dark">
                            Xem chi tiết
                        </a>

                    </div>
                </div>

                @empty

                <div class="empty-box">
                    Không tìm thấy phòng phù hợp.
                </div>

                @endforelse

            </div>

        </section>

        <!-- ABOUT -->
        <section id="about" style="padding:0 0 100px;">

            <div class="section-title">
                <div>
                    <h2>About Our Hotel</h2>

                    <p>
                        Trải nghiệm nghỉ dưỡng hiện đại, sang trọng và tiện nghi
                        dành cho khách du lịch, gia đình và doanh nhân.
                    </p>
                </div>
            </div>

            <!-- INTRODUCTION -->
            <div class="info-strip">

                <div class="info-card">
                    <h4>Introduction</h4>

                    <p>
                        DolPHPhins Hotel Booking mang đến trải nghiệm đặt phòng
                        đơn giản, nhanh chóng và chuyên nghiệp với không gian nghỉ dưỡng cao cấp.
                    </p>
                </div>

                <div class="info-card">
                    <h4>Why Choose Us</h4>

                    <p>
                        Hệ thống đặt phòng dễ sử dụng, hình ảnh thực tế,
                        giá minh bạch và hỗ trợ khách hàng 24/7.
                    </p>
                </div>

                <div class="info-card">
                    <h4>Hotel Statistics</h4>

                    <p>
                        100+ phòng • 5000+ khách hàng •
                        4.9/5 đánh giá • hỗ trợ toàn thời gian.
                    </p>
                </div>

                <div class="info-card">
                    <h4>Hotel Vision</h4>

                    <p>
                        Xây dựng trải nghiệm nghỉ dưỡng hiện đại,
                        tiện nghi và đáng tin cậy cho mọi khách hàng.
                    </p>
                </div>

            </div>

        </section>

        <!-- SERVICES -->
        <section id="services" style="padding:0 0 100px;">

            <div class="section-title">
                <div>
                    <h2>Our Services</h2>

                    <p>
                        Những tiện ích nổi bật giúp nâng cao trải nghiệm khách hàng
                        trong suốt thời gian lưu trú.
                    </p>
                </div>
            </div>

            <div class="info-strip">

                <div class="info-card">
                    <h4>Internet</h4>

                    <p>
                        Wi-Fi tốc độ cao miễn phí trong toàn bộ khách sạn,
                        phù hợp cho cả làm việc và giải trí.
                    </p>
                </div>

                <div class="info-card">
                    <h4>Dining</h4>

                    <p>
                        Nhà hàng sang trọng với nhiều món ăn đa dạng,
                        phục vụ bữa sáng và đồ uống.
                    </p>
                </div>

                <div class="info-card">
                    <h4>Relaxation</h4>

                    <p>
                        Không gian thư giãn hiện đại với khu nghỉ dưỡng,
                        phòng lounge và dịch vụ chăm sóc khách hàng.
                    </p>
                </div>

                <div class="info-card">
                    <h4>Transportation</h4>

                    <p>
                        Hỗ trợ đưa đón sân bay, gọi taxi và hướng dẫn di chuyển thuận tiện.
                    </p>
                </div>

                <div class="info-card">
                    <h4>Customer Support</h4>

                    <p>
                        Đội ngũ hỗ trợ 24/7 luôn sẵn sàng giải đáp
                        và hỗ trợ khách hàng nhanh chóng.
                    </p>
                </div>

            </div>

        </section>

        <!-- CONTACT -->
        <section id="contact" style="padding:0 0 100px;">

            <div class="section-title">
                <div>
                    <h2>Contact Us</h2>

                    <p>
                        Liên hệ với chúng tôi để được hỗ trợ đặt phòng
                        và giải đáp thông tin nhanh chóng.
                    </p>
                </div>
            </div>

            <div class="info-strip">

                <div class="info-card">
                    <h4>Hotline</h4>

                    <p>
                        +84 123 456 789
                    </p>
                </div>

                <div class="info-card">
                    <h4>Email</h4>

                    <p>
                        support@hotelbooking.com
                    </p>
                </div>

                <div class="info-card">
                    <h4>Address</h4>

                    <p>
                        123 Nguyễn Văn Linh, TP. Hồ Chí Minh, Việt Nam
                    </p>
                </div>

                <div class="info-card">
                    <h4>Working Hours</h4>

                    <p>
                        Hỗ trợ khách hàng 24/7 tất cả các ngày trong tuần.
                    </p>
                </div>

                <div class="info-card">
                    <h4>Social Links</h4>

                    <p>
                        Facebook • Instagram • YouTube • TikTok
                    </p>
                </div>

                <div class="info-card">
                    <h4>Contact Form</h4>

                    <form style="margin-top:12px;">

                        <input
                            type="text"
                            placeholder="Your name"
                            style="margin-bottom:12px;">

                        <input
                            type="email"
                            placeholder="Your email"
                            style="margin-bottom:12px;">

                        <textarea
                            placeholder="Your message"
                            style="
                        width:100%;
                        min-height:120px;
                        padding:15px;
                        border-radius:14px;
                        border:1px solid #dbe3ee;
                        background:#f8fafc;
                        resize:none;
                        margin-bottom:12px;
                        font-family:Poppins,sans-serif;
                    "></textarea>

                        <button
                            type="submit"
                            class="btn btn-white"
                            style="width:100%;">
                            Send Message
                        </button>

                    </form>
                </div>

            </div>

        </section>

</body>

</html>