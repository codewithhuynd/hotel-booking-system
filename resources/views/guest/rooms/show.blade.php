html
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $room->room_name }} - Dolphins Luxury</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
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
                radial-gradient(circle at top left,
                    rgba(16, 185, 129, 0.12),
                    transparent 30%),

                radial-gradient(circle at bottom right,
                    rgba(59, 130, 246, 0.12),
                    transparent 30%),

                #020617;

            color: white;

            min-height: 100vh;

            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        .font-serif-luxury {
            font-family: 'Cormorant Garamond', serif;
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

            padding: 16px 50px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            background:
                rgba(2, 6, 23, 0.8);

            backdrop-filter: blur(18px);

            border-bottom:
                1px solid rgba(255, 255, 255, 0.08);

            box-shadow:
                0 12px 40px rgba(0, 0, 0, 0.35);
        }

        .logo {

            display: flex;
            align-items: center;
            gap: 14px;

            color: white;
        }

        .logo-icon {

            width: 52px;
            height: 52px;

            border-radius: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                linear-gradient(135deg,
                    #10b981,
                    #059669);

            font-size: 22px;

            color: white;

            box-shadow:
                0 10px 30px rgba(16, 185, 129, 0.3);
        }

        .logo-text {

            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .logo-text strong {

            font-size: 24px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .logo-text span {

            font-size: 10px;

            letter-spacing: 3px;

            text-transform: uppercase;

            color: #94a3b8;

            margin-top: 4px;
        }

        .nav-wrapper {

            display: flex;
            align-items: center;
            gap: 18px;
        }

        .nav-link {

            position: relative;

            padding: 12px 18px;

            border-radius: 14px;

            display: flex;
            align-items: center;
            gap: 10px;

            color: #cbd5e1;

            font-size: 14px;
            font-weight: 600;

            transition: all .3s ease;
        }

        .nav-link:hover {

            background:
                rgba(255, 255, 255, 0.06);

            color: white;

            transform: translateY(-2px);
        }

        .btn-primary {

            padding: 12px 20px;

            border-radius: 16px;

            background:
                linear-gradient(135deg,
                    #10b981,
                    #22c55e);

            color: white;

            font-size: 14px;
            font-weight: 700;

            transition: all .3s ease;

            box-shadow:
                0 10px 30px rgba(16, 185, 129, 0.28);
        }

        .btn-primary:hover {

            transform:
                translateY(-3px);

            box-shadow:
                0 18px 40px rgba(16, 185, 129, 0.35);
        }

        .btn-outline {

            padding: 12px 20px;

            border-radius: 16px;

            border:
                1px solid rgba(255, 255, 255, 0.1);

            background:
                rgba(255, 255, 255, 0.04);

            color: white;

            font-size: 14px;
            font-weight: 600;

            transition: all .3s ease;
        }

        .btn-outline:hover {

            background:
                rgba(255, 255, 255, 0.1);

            transform:
                translateY(-2px);
        }

        /* =========================
           MAIN
        ========================= */

        .main-container {

            width: 100%;
            max-width: 1400px;

            margin: 0 auto;

            padding:
                140px 24px 60px;
        }

        .luxury-card {

            background:
                linear-gradient(145deg,
                    rgba(15, 23, 42, 0.96),
                    rgba(15, 23, 42, 0.9));

            border:
                1px solid rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(20px);

            overflow: hidden;

            border-radius: 36px;

            box-shadow:
                0 25px 70px rgba(0, 0, 0, 0.4);
        }

        /* =========================
           SLIDER
        ========================= */

        .slider-container {

            position: relative;

            width: 100%;
            height: 700px;

            overflow: hidden;

            background: #0f172a;
        }

        .slide {

            position: absolute;

            inset: 0;

            width: 100%;
            height: 100%;

            object-fit: cover;

            opacity: 0;

            transform: scale(1.05);

            transition:
                opacity 1s ease,
                transform 1.8s ease;
        }

        .slide.active {

            opacity: 1;

            transform: scale(1);

            z-index: 10;
        }

        .slider-overlay {

            position: absolute;

            inset: 0;

            background:
                linear-gradient(to top,
                    rgba(2, 6, 23, 0.95),
                    rgba(2, 6, 23, 0.2),
                    rgba(0, 0, 0, 0.3));

            z-index: 20;
        }

        .slider-content {

            position: absolute;

            left: 60px;
            bottom: 60px;

            z-index: 30;

            max-width: 700px;
        }

        .room-badge {

            display: inline-flex;
            align-items: center;
            gap: 10px;

            padding: 10px 18px;

            border-radius: 999px;

            background:
                rgba(16, 185, 129, 0.14);

            border:
                1px solid rgba(16, 185, 129, 0.2);

            color: #6ee7b7;

            font-size: 12px;
            font-weight: 700;

            letter-spacing: 2px;

            text-transform: uppercase;

            margin-bottom: 20px;
        }

        .slider-title {

            font-size: 72px;
            line-height: 0.95;
            font-weight: 700;

            color: white;

            margin-bottom: 18px;
        }

        .slider-price {

            display: inline-block;

            padding: 14px 22px;

            border-radius: 18px;

            background:
                rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(10px);

            border:
                1px solid rgba(255, 255, 255, 0.08);

            color: #4ade80;

            font-size: 28px;
            font-weight: 800;
        }

        /* =========================
           SLIDER BUTTON
        ========================= */

        .slider-btn {

            position: absolute;

            top: 50%;

            transform: translateY(-50%);

            width: 60px;
            height: 60px;

            border-radius: 50%;

            border:
                1px solid rgba(255, 255, 255, 0.1);

            background:
                rgba(15, 23, 42, 0.5);

            backdrop-filter: blur(10px);

            color: white;

            font-size: 22px;

            z-index: 40;

            cursor: pointer;

            transition: all .3s ease;
        }

        .slider-btn:hover {

            background:
                rgba(16, 185, 129, 0.9);

            transform:
                translateY(-50%) scale(1.08);
        }

        .slider-btn.prev {
            left: 30px;
        }

        .slider-btn.next {
            right: 30px;
        }

        /* =========================
           CONTENT
        ========================= */

        .content-section {

            padding: 50px;
        }

        .info-grid {

            display: grid;

            grid-template-columns:
                repeat(auto-fit, minmax(220px, 1fr));

            gap: 20px;

            margin-bottom: 40px;
        }

        .info-box {

            padding: 24px;

            border-radius: 24px;

            background:
                rgba(255, 255, 255, 0.04);

            border:
                1px solid rgba(255, 255, 255, 0.06);

            transition: all .3s ease;
        }

        .info-box:hover {

            transform:
                translateY(-5px);

            border-color:
                rgba(16, 185, 129, 0.25);

            background:
                rgba(255, 255, 255, 0.06);
        }

        .info-label {

            color: #94a3b8;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: 2px;

            margin-bottom: 12px;
        }

        .info-value {

            color: white;

            font-size: 22px;
            font-weight: 700;
        }

        .description {

            color: #cbd5e1;

            font-size: 17px;

            line-height: 1.9;
        }

        .action-bar {

            margin-top: 40px;

            display: flex;
            gap: 18px;
            flex-wrap: wrap;
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 768px) {

            .navbar {

                padding: 18px;

                flex-direction: column;

                align-items: flex-start;

                gap: 16px;
            }

            .nav-wrapper {

                width: 100%;

                flex-wrap: wrap;
            }

            .main-container {

                padding-top: 170px;
            }

            .slider-container {

                height: 420px;
            }

            .slider-content {

                left: 24px;
                right: 24px;
                bottom: 24px;
            }

            .slider-title {

                font-size: 42px;
            }

            .content-section {

                padding: 28px;
            }

            .slider-btn {

                width: 48px;
                height: 48px;
            }
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
                <strong>Dolphins</strong>
                <span>Luxury Resort</span>
            </div>

        </a>

        <div class="nav-wrapper">

            <a href="{{ route('home') }}" class="nav-link">
                <i class="fa-solid fa-house"></i>
                Trang Chủ
            </a>

            <a href="{{ route('rooms.index') }}" class="nav-link">
                <i class="fa-solid fa-bed"></i>
                Danh Sách Phòng
            </a>

            @guest

            <a href="{{ route('login') }}" class="btn-outline">
                <i class="fa-solid fa-right-to-bracket"></i>
                Đăng Nhập
            </a>

            <a href="{{ route('register') }}" class="btn-primary">
                <i class="fa-solid fa-user-plus"></i>
                Đăng Ký
            </a>

            @endguest

            @auth

            @if(auth()->user()->role === 'guest')

            <a href="{{ route('guest.bookings.index') }}" class="nav-link">
                <i class="fa-solid fa-calendar-check"></i>
                Đặt phòng của tôi
            </a>

            <a href="{{ route('profile.edit') }}" class="nav-link">
                <i class="fa-solid fa-user"></i>
                Hồ sơ cá nhân
            </a>

            <a href="{{ route('guest.bookings.create', $room) }}"
                class="btn-primary">

                <i class="fa-solid fa-calendar-plus"></i>
                Đặt Phòng

            </a>

            @endif

            @endauth

        </div>

    </nav>

    <!-- MAIN -->

    <main class="main-container">

        <div class="luxury-card">

            <!-- SLIDER -->

            <div class="slider-container">

                @foreach($room->images as $index => $img)

                <img
                    src="{{ asset('storage/' . $img->image_path) }}"
                    alt="{{ $room->room_name }}"
                    class="slide {{ $index === 0 ? 'active' : '' }}">

                @endforeach

                <div class="slider-overlay"></div>

                <!-- TEXT -->

                <div class="slider-content">

                    <div class="room-badge">
                        <i class="fa-solid fa-star"></i>
                        Luxury Premium Room
                    </div>

                    <h1 class="slider-title font-serif-luxury">
                        {{ $room->room_name }}
                    </h1>

                    <div class="slider-price">
                        {{ number_format($room->price) }} VND / đêm
                    </div>

                </div>

                <!-- BUTTON -->

                @if($room->images->count() > 1)

                <button onclick="changeSlide(-1)"
                    class="slider-btn prev">

                    <i class="fa-solid fa-chevron-left"></i>

                </button>

                <button onclick="changeSlide(1)"
                    class="slider-btn next">

                    <i class="fa-solid fa-chevron-right"></i>

                </button>

                @endif

            </div>

            <!-- CONTENT -->

            <div class="content-section">

                <div class="info-grid">

                    <div class="info-box">

                        <div class="info-label">
                            Mã phòng
                        </div>

                        <div class="info-value">
                            {{ $room->room_code }}
                        </div>

                    </div>

                    <div class="info-box">

                        <div class="info-label">
                            Sức chứa
                        </div>

                        <div class="info-value">
                            {{ $room->capacity }} khách
                        </div>

                    </div>

                    <div class="info-box">

                        <div class="info-label">
                            Trạng thái
                        </div>

                        <div class="info-value">
                            {{ ucfirst($room->status) }}
                        </div>

                    </div>

                </div>

                <div class="description">
                    {{ $room->description }}
                </div>

                <!-- ACTION -->

                <div class="action-bar">

                    @auth

                    @if(auth()->user()->role === 'guest')

                    <a href="{{ route('guest.bookings.create', $room) }}"
                        class="btn-primary">

                        <i class="fa-solid fa-calendar-check"></i>

                        Đặt phòng ngay

                    </a>

                    @endif

                    @endauth

                    <a href="{{ route('rooms.index') }}"
                        class="btn-outline">

                        <i class="fa-solid fa-arrow-left"></i>

                        Quay lại danh sách phòng

                    </a>

                </div>

            </div>

        </div>

    </main>

    <script>

        let current = 0;

        const slides =
            document.querySelectorAll('.slide');

        function show(index) {

            slides.forEach((slide, i) => {

                slide.classList.toggle(
                    'active',
                    i === index
                );

            });

        }

        function changeSlide(step) {

            current += step;

            if (current >= slides.length)
                current = 0;

            if (current < 0)
                current = slides.length - 1;

            show(current);
        }

        if (slides.length > 1) {

            setInterval(() => {

                changeSlide(1);

            }, 6000);

        }

    </script>

    @include('partials.notification-modal')

</body>

</html>

