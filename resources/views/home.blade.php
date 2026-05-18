{{-- resources/views/home.blade.php --}}

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

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

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

            padding: 22px 70px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            background: rgba(2, 6, 23, 0.75);
            backdrop-filter: blur(10px);
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 2px;
            color: #fff;
            text-transform: uppercase;
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
            color: #e2e8f0;
            font-weight: 500;
            transition: 0.2s;
        }

        .nav-link:hover {
            color: #fff;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 10px 18px;

            border-radius: 999px;
            border: none;

            cursor: pointer;
            font-weight: 600;

            transition: 0.25s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-white {
            background: #fff;
            color: #111827;
        }

        .btn-dark {
            background: #111827;
            color: #fff;
        }

        .btn-green {
            background: #16a34a;
            color: #fff;
        }

        .btn-outline {
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: transparent;
            color: #fff;
        }

        .hero {
            min-height: 100vh;

            display: flex;
            align-items: center;

            background: linear-gradient(rgba(2, 6, 23, 0.75),
                rgba(2, 6, 23, 0.60)),
            url('{{ asset("images/hero.jpg") }}');

            background-size: cover;
            background-position: center;
        }

        .hero-inner {
            width: 100%;
            max-width: 1280px;
            margin: auto;

            padding: 140px 30px 90px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 40px;
            align-items: center;
        }

        .hero-kicker {
            display: inline-block;

            padding: 10px 18px;

            border-radius: 999px;

            background: rgba(255, 255, 255, 0.10);

            margin-bottom: 24px;

            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(46px, 6vw, 84px);
            line-height: 1.05;

            margin-bottom: 20px;

            color: #fff;
        }

        .hero p {
            max-width: 650px;
            margin-bottom: 30px;
            color: #cbd5e1;
        }

        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;

            margin-bottom: 30px;
        }

        .hero-stats {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .stat-chip {
            padding: 14px 18px;

            border-radius: 18px;

            background: rgba(255, 255, 255, 0.08);

            border: 1px solid rgba(255, 255, 255, 0.10);
        }

        .stat-chip strong {
            display: block;
            color: #fff;
            margin-bottom: 4px;
        }

        .stat-chip span {
            font-size: 13px;
            color: #cbd5e1;
        }

        .hero-card {
            background: rgba(255, 255, 255, 0.08);

            border: 1px solid rgba(255, 255, 255, 0.12);

            border-radius: 28px;

            padding: 26px;

            backdrop-filter: blur(10px);
        }

        .hero-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 30px;

            margin-bottom: 12px;
        }

        .hero-card p {
            font-size: 15px;
            margin-bottom: 18px;
        }

        .card-list {
            display: grid;
            gap: 12px;
        }

        .card-item {
            padding: 14px 16px;

            border-radius: 18px;

            background: rgba(15, 23, 42, 0.4);

            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .card-item strong {
            color: #fff;
        }

        .card-item span {
            font-size: 13px;
            color: #cbd5e1;
        }

        .container {
            max-width: 1280px;
            margin: auto;
            padding: 0 30px;
        }

        .search-box {
            margin-top: -70px;

            position: relative;
            z-index: 5;

            background: #fff;
            color: #111827;

            border-radius: 28px;

            padding: 30px;

            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.15);
        }

        .search-head h2 {
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            margin-bottom: 20px;
        }

        .search-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 16px;
            align-items: end;
        }

        .field label {
            display: block;

            margin-bottom: 8px;

            font-size: 13px;
            font-weight: 600;

            color: #334155;
        }

        input,
        select,
        textarea {
            width: 100%;

            padding: 14px 16px;

            border-radius: 14px;

            border: 1px solid #dbe3ee;

            background: #f8fafc;

            outline: none;

            font-family: inherit;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #94a3b8;
            background: #fff;

            box-shadow: 0 0 0 4px rgba(148, 163, 184, 0.18);
        }

        .rooms-section {
            padding: 90px 0;
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: end;

            gap: 20px;

            margin-bottom: 34px;

            flex-wrap: wrap;
        }

        .section-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 4vw, 50px);
            color: #fff;
        }

        .section-title p {
            max-width: 700px;
            color: #cbd5e1;
        }

        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));

            gap: 28px;
        }

        .room-card {
            background: #fff;
            color: #111827;

            border-radius: 26px;
            overflow: hidden;

            transition: 0.25s ease;
        }

        .room-slider {
            position: relative;
            overflow: hidden;
        }

        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);

            width: 40px;
            height: 40px;

            border: none;
            border-radius: 50%;

            background: rgba(0, 0, 0, 0.5);
            color: white;

            cursor: pointer;

            font-size: 18px;
            z-index: 5;
        }

        .prev-btn {
            left: 10px;
        }

        .next-btn {
            right: 10px;
        }

        .slider-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .room-card:hover {
            transform: translateY(-8px);
        }

        .room-image {
            width: 100%;

            aspect-ratio: 16 / 10;

            object-fit: cover;

            background: #e2e8f0;
        }

        .room-content {
            padding: 22px;
        }

        .room-content h3 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;

            margin-bottom: 12px;
        }

        .price {
            font-size: 30px;
            font-weight: 800;

            margin-bottom: 14px;
        }

        .meta {
            display: grid;
            gap: 8px;

            margin-bottom: 20px;
        }

        .meta p {
            color: #475569;
            font-size: 14px;
        }

        .welcome-box {
            margin-top: 40px;

            background: #fff;
            color: #111827;

            padding: 30px;

            border-radius: 28px;
        }

        .info-strip {
            margin-top: 36px;

            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));

            gap: 18px;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.06);

            border: 1px solid rgba(255, 255, 255, 0.08);

            border-radius: 22px;

            padding: 22px;

            backdrop-filter: blur(10px);
        }

        .info-card h4 {
            margin-bottom: 10px;
            color: #fff;
        }

        .info-card p {
            color: #cbd5e1;
            font-size: 14px;
        }

        .empty-box {
            background: #fff;
            color: #111827;

            padding: 20px;

            border-radius: 20px;
        }

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            background: rgba(255, 255, 255, 0.10);

            border: 1px solid rgba(255, 255, 255, 0.10);

            color: #fff;

            padding: 10px 16px;

            border-radius: 999px;

            cursor: pointer;
        }

        .dropdown-menu {
            position: absolute;

            top: 120%;
            right: 0;

            width: 220px;

            background: #fff;

            border-radius: 18px;

            overflow: hidden;

            opacity: 0;
            visibility: hidden;

            transform: translateY(10px);

            transition: 0.25s;

            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.15);
        }

        .user-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;

            transform: translateY(0);
        }

        .dropdown-item {
            display: block;
            width: 100%;

            padding: 14px 18px;

            background: #fff;
            color: #111827;

            border: none;

            text-align: left;

            cursor: pointer;
        }

        .dropdown-item:hover {
            background: #f8fafc;
        }

        .logout-btn {
            font-family: inherit;
        }

        @media (max-width: 1200px) {
            .search-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .hero-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {

            .navbar {
                padding: 18px;
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .nav-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
                width: 100%;
            }

            .nav-left,
            .nav-right {
                flex-wrap: wrap;
            }

            .hero-inner {
                padding: 170px 18px 80px;
            }

            .container {
                padding: 0 18px;
            }

            .search-box {
                margin-top: -30px;
                padding: 20px;
            }

            .search-grid {
                grid-template-columns: 1fr;
            }

            .rooms-section {
                padding: 70px 0;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">

        <div class="logo">
            DolPHPhins Hotel Booking
        </div>

        <div class="nav-wrapper">

            <div class="nav-left">

                <a href="#rooms" class="nav-link">
                    Rooms
                </a>

                <a href="#about" class="nav-link">
                    About
                </a>

                <a href="#services" class="nav-link">
                    Services
                </a>

                <a href="#contact" class="nav-link">
                    Contact
                </a>

            </div>

            <div class="nav-right">

                @guest

                <a
                    href="{{ route('login') }}"
                    class="btn btn-white">
                    Login
                </a>

                <a
                    href="{{ route('register') }}"
                    class="btn btn-green">
                    Register
                </a>

                @else

                @if(Auth::user()->role === 'host')

                <a
                    href="{{ route('host.dashboard') }}"
                    class="btn btn-dark">
                    Dashboard
                </a>

                @endif

                <div class="user-dropdown">

                    <button class="user-btn">
                        {{ Auth::user()->full_name }} ▼
                    </button>

                    <div class="dropdown-menu">

                        @if(Auth::user()->role === 'guest')

                        <a
                            href="{{ route('guest.bookings.index') }}"
                            class="dropdown-item">
                            My Bookings
                        </a>

                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            My Profile
                        </a>

                        @endif

                        <form
                            method="POST"
                            action="{{ route('logout') }}">

                            @csrf

                            <button
                                type="submit"
                                class="dropdown-item logout-btn">
                                Logout
                            </button>

                        </form>

                    </div>

                </div>

                @endguest

            </div>

        </div>

    </div>

    <!-- HERO -->
    <section class="hero">

        <div class="hero-inner">

            <div class="hero-grid">

                <div>

                    <div class="hero-kicker">
                        Luxury stay • Easy booking • Best experience
                    </div>

                    <h1>
                        {{ $hotelSetting->hero_title }}
                    </h1>

                    <p>
                        {{ $hotelSetting->hero_description }}
                    </p>

                    <div class="hero-actions">

                        <a href="#rooms" class="btn btn-white">
                            Explore Rooms
                        </a>

                        @guest
                        <a
                            href="{{ route('login') }}"
                            class="btn btn-outline">
                            Login to Book
                        </a>
                        @endguest

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

                    <h3>
                        Quick Highlights
                    </h3>

                    <p>
                        Những điểm nổi bật giúp khách hàng
                        tin tưởng ngay từ lần đầu truy cập.
                    </p>

                    <div class="card-list">

                        <div class="card-item">
                            <strong>Đặt phòng nhanh</strong><br>
                            <span>Tìm và xem phòng chỉ trong vài giây</span>
                        </div>

                        <div class="card-item">
                            <strong>Ảnh phòng rõ ràng</strong><br>
                            <span>Xem hình ảnh thực tế của từng phòng</span>
                        </div>

                        <div class="card-item">
                            <strong>Giá minh bạch</strong><br>
                            <span>Hiển thị rõ ràng trước khi đặt</span>
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

                <h2>
                    Tìm phòng phù hợp
                </h2>

            </div>

            <form
                method="GET"
                action="{{ route('home') }}">

                <div class="search-grid">

                    <div class="field">

                        <label>
                            Tên phòng
                        </label>

                        <input
                            type="text"
                            name="keyword"
                            placeholder="Tên phòng..."
                            value="{{ request('keyword') }}">

                    </div>

                    <div class="field">

                        <label>
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

                    <div class="field">

                        <label>
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

                    <div class="field">

                        <label>
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

                    <div class="field">

                        <label>
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

                    <div class="field">

                        <label>
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

                    <div class="field">

                        <label>
                            &nbsp;
                        </label>

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

        <!-- HOST -->
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
                            font-family:'Playfair Display', serif;
                            margin-bottom:10px;
                            font-size:32px;
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

        </div>

        @endif

        <!-- ROOMS -->
        <section class="rooms-section" id="rooms">

            <div class="section-title">

                <div>

                    <h2>
                        Rooms
                    </h2>

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

                    <div class="room-slider">

                        @if($room->images->count())

                        @foreach($room->images as $index => $image)

                        <img
                            src="{{ asset('storage/' . $image->image_path) }}"
                            class="room-image slide-image slide-{{ $room->id }}"
                            style="{{ $index !== 0 ? 'display:none;' : '' }}"
                            alt="{{ $room->room_name }}">

                        @endforeach

                        @if($room->images->count() > 1)

                        <button
                            class="slider-btn prev-btn"
                            onclick='changeSlide({{ $room->id }}, -1)'>
                            ❮
                        </button>

                        <button
                            class="slider-btn next-btn"
                            onclick='changeSlide({{ $room->id }}, 1)'>
                            ❯
                        </button>

                        @endif

                        @else

                        <div class="room-image"></div>

                        @endif

                    </div>

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

                    <h2>
                        About Our Hotel
                    </h2>

                    <p>
                        Trải nghiệm nghỉ dưỡng hiện đại, sang trọng và tiện nghi
                        dành cho khách du lịch, gia đình và doanh nhân.
                    </p>

                </div>

            </div>

            <div class="info-strip">

                @foreach($aboutSections as $about)

                <div class="info-card">

                    <h4>
                        {{ $about->title }}
                    </h4>

                    <p>
                        {{ $about->description }}
                    </p>

                </div>

                @endforeach

            </div>

        </section>

        <!-- SERVICES -->
        <section id="services" style="padding:0 0 100px;">

            <div class="section-title">

                <div>

                    <h2>
                        Our Services
                    </h2>

                    <p>
                        Những tiện ích nổi bật giúp nâng cao trải nghiệm khách hàng.
                    </p>

                </div>

            </div>

            <div class="info-strip">

                @foreach($services as $service)

                <div class="info-card">

                    <h4>
                        {{ $service->title }}
                    </h4>

                    <p>
                        {{ $service->description }}
                    </p>

                </div>

                @endforeach

            </div>

        </section>

        <!-- CONTACT -->
        <section id="contact" style="padding:0 0 100px;">

            <div class="section-title">

                <div>

                    <h2>
                        Contact Us
                    </h2>

                    <p>
                        Liên hệ với chúng tôi để được hỗ trợ nhanh chóng.
                    </p>

                </div>

            </div>

            <div class="info-strip">

                <div class="info-card">

                    <h4>
                        Hotline
                    </h4>

                    <p>
                        {{ $hotelSetting->hotline }}
                    </p>

                </div>

                <div class="info-card">

                    <h4>
                        Email
                    </h4>

                    <p>
                        {{ $hotelSetting->email }}
                    </p>

                </div>

                <div class="info-card">

                    <h4>
                        Address
                    </h4>

                    <p>
                        {{ $hotelSetting->address }}
                    </p>

                </div>

                <div class="info-card">

                    <h4>
                        Working Hours
                    </h4>

                    <p>
                        {{ $hotelSetting->working_hours }}
                    </p>

                </div>
                <div class="info-card">

                    <h4>
                        FaceBook
                    </h4>

                    <p>
                        {{ $hotelSetting->facebook_link }}
                    </p>

                </div>
                <div class="info-card">

                    <h4>
                        Map
                    </h4>

                    <p>
                        {{ $hotelSetting->google_map_link }}
                    </p>

                </div>

                <div class="info-card">

                    <form
                        method="POST"
                        action="{{ route('contact-messages.store') }}"
                        style="margin-top:12px;">
                        @csrf

                        @auth
                        @if(Auth::user()->role !== 'host')
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', Auth::user()->full_name) }}"
                            placeholder="Your name"
                            style="margin-bottom:12px;">

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', Auth::user()->email) }}"
                            placeholder="Your email"
                            style="margin-bottom:12px;">
                        @endif
                        @else
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Your name"
                            style="margin-bottom:12px;">

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Your email"
                            style="margin-bottom:12px;">
                        @endauth

                        <textarea
                            name="message"
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
        ">{{ old('message') }}</textarea>

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

    </div>

    <script>
        const sliders = {};

        function changeSlide(roomId, direction) {
            const slides = document.querySelectorAll('.slide-' + roomId);

            if (!slides.length) return;

            if (!(roomId in sliders)) {
                sliders[roomId] = 0;
            }

            slides[sliders[roomId]].style.display = 'none';

            sliders[roomId] += direction;

            if (sliders[roomId] >= slides.length) {
                sliders[roomId] = 0;
            }

            if (sliders[roomId] < 0) {
                sliders[roomId] = slides.length - 1;
            }

            slides[sliders[roomId]].style.display = 'block';
        }
    </script>
</body>

</html>