<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt phòng - {{ $room->room_name }}</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
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

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;

            background:
                radial-gradient(circle at top left,
                    rgba(16, 185, 129, 0.12),
                    transparent 30%),

                radial-gradient(circle at bottom right,
                    rgba(59, 130, 246, 0.10),
                    transparent 30%),

                #f8fafc;

            color: #0f172a;

            min-height: 100vh;

            padding-top: 110px;
        }

        .font-serif-luxury {
            font-family: 'Cormorant Garamond', serif;
        }

        /* ===============================
           NAVBAR
        =============================== */

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
                rgba(255, 255, 255, 0.72);

            backdrop-filter: blur(18px);

            border-bottom:
                1px solid rgba(15, 23, 42, 0.06);

            box-shadow:
                0 10px 40px rgba(15, 23, 42, 0.05);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 14px;

            text-decoration: none;
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

            color: white;

            font-size: 22px;

            box-shadow:
                0 14px 30px rgba(16, 185, 129, 0.28);
        }

        .logo-text {

            display: flex;
            flex-direction: column;

            line-height: 1.05;
        }

        .logo-text strong {

            font-size: 28px;

            color: #0f172a;

            letter-spacing: 1px;

            font-family: serif;
        }

        .logo-text span {

            font-size: 11px;

            letter-spacing: 3px;

            text-transform: uppercase;

            color: #64748b;

            font-weight: 700;
        }

        .nav-wrapper {

            display: flex;
            align-items: center;
            gap: 14px;
        }

        .nav-link {

            position: relative;

            padding: 12px 18px;

            border-radius: 16px;

            display: flex;
            align-items: center;
            gap: 10px;

            color: #475569;

            font-size: 14px;
            font-weight: 700;

            transition: 0.3s ease;
        }

        .nav-link:hover {

            background:
                rgba(16, 185, 129, 0.08);

            color: #059669;

            transform: translateY(-2px);
        }

        .nav-book-btn {

            background:
                linear-gradient(135deg,
                    #10b981,
                    #059669);

            color: white !important;

            padding: 13px 22px;

            border-radius: 18px;

            font-size: 14px;
            font-weight: 700;

            box-shadow:
                0 14px 28px rgba(16, 185, 129, 0.22);

            transition: 0.3s ease;
        }

        .nav-book-btn:hover {

            transform:
                translateY(-3px);

            box-shadow:
                0 18px 34px rgba(16, 185, 129, 0.3);
        }

        /* ===============================
           MAIN LAYOUT
        =============================== */

        .main-wrapper {

            width: 100%;
            max-width: 1400px;

            margin: auto;

            padding: 0 24px 50px;
        }

        .booking-grid {

            display: grid;

            grid-template-columns: 420px 1fr;

            gap: 34px;

            align-items: start;
        }

        /* ===============================
           LUXURY CARD
        =============================== */

        .luxury-card {

            background:
                rgba(255, 255, 255, 0.72);

            backdrop-filter: blur(18px);

            border:
                1px solid rgba(255, 255, 255, 0.8);

            box-shadow:
                0 24px 60px rgba(15, 23, 42, 0.08);

            border-radius: 34px;
        }

        /* ===============================
           SIDEBAR
        =============================== */

        .sidebar-card {

            position: sticky;

            top: 130px;

            overflow: hidden;
        }

        .room-preview {

            position: relative;

            aspect-ratio: 16/10;

            overflow: hidden;
        }

        .room-preview img {

            width: 100%;
            height: 100%;

            object-fit: cover;

            transition: 0.5s ease;
        }

        .room-preview:hover img {
            transform: scale(1.05);
        }

        .room-overlay {

            position: absolute;
            inset: 0;

            background:
                linear-gradient(to top,
                    rgba(15, 23, 42, 0.7),
                    transparent 50%);
        }

        .floating-price {

            position: absolute;

            left: 24px;
            bottom: 24px;

            z-index: 20;
        }

        .floating-price p:first-child {

            font-size: 11px;

            text-transform: uppercase;

            letter-spacing: 2px;

            color: rgba(255, 255, 255, 0.8);

            margin-bottom: 4px;
        }

        .floating-price p:last-child {

            font-size: 30px;

            font-weight: 800;

            color: white;
        }

        .meta-box {

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 14px 16px;

            border-radius: 18px;

            background:
                rgba(248, 250, 252, 0.9);

            border:
                1px solid rgba(15, 23, 42, 0.05);
        }

        /* ===============================
           FORM
        =============================== */

        .form-card {

            padding: 42px;
        }

        .section-tag {

            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 14px;

            color: #059669;

            font-size: 12px;
            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 2px;
        }

        .section-tag span {

            width: 28px;
            height: 1px;

            background: #10b981;
        }

        .form-title {

            font-size: 52px;

            line-height: 1;

            color: #0f172a;

            margin-bottom: 34px;

            font-weight: 700;
        }

        .input-group {
            margin-bottom: 24px;
        }

        .input-label {

            display: block;

            margin-bottom: 10px;

            font-size: 12px;

            font-weight: 700;

            letter-spacing: 1.5px;

            text-transform: uppercase;

            color: #64748b;
        }

        .glass-input {

            width: 100%;

            height: 58px;

            padding: 0 18px;

            border-radius: 20px;

            border:
                1px solid rgba(148, 163, 184, 0.25);

            background:
                rgba(255, 255, 255, 0.85);

            color: #0f172a;

            font-size: 15px;

            transition: 0.3s ease;
        }

        .glass-input:focus {

            outline: none;

            border-color:
                rgba(16, 185, 129, 0.5);

            box-shadow:
                0 0 0 5px rgba(16, 185, 129, 0.08);

            transform:
                translateY(-2px);
        }

        textarea.glass-input {

            min-height: 140px;

            padding-top: 18px;

            resize: vertical;
        }

        /* ===============================
           PRICE ESTIMATOR
        =============================== */

        .estimate-box {

            margin-top: 28px;

            padding: 24px;

            border-radius: 28px;

            background:
                linear-gradient(135deg,
                    rgba(16, 185, 129, 0.08),
                    rgba(255, 255, 255, 0.85));

            border:
                1px solid rgba(16, 185, 129, 0.14);
        }

        .estimate-total {

            font-size: 38px;

            font-weight: 800;

            color: #059669;

            line-height: 1;
        }

        /* ===============================
           BUTTON
        =============================== */

        .btn-shimmer {

            position: relative;

            overflow: hidden;

            transition: 0.35s ease;
        }

        .btn-shimmer::after {

            content: "";

            position: absolute;

            top: -50%;
            left: -60%;

            width: 40%;
            height: 200%;

            background:
                rgba(255, 255, 255, 0.28);

            transform: rotate(30deg);
        }

        .btn-shimmer:hover::after {

            left: 160%;

            transition: 0.8s ease;
        }

        .btn-shimmer:hover {
            transform: translateY(-3px);
        }

        .submit-btn {

            height: 60px;

            border: none;

            border-radius: 22px;

            padding: 0 34px;

            cursor: pointer;

            background:
                linear-gradient(135deg,
                    #10b981,
                    #059669);

            color: white;

            font-size: 15px;
            font-weight: 700;

            box-shadow:
                0 18px 34px rgba(16, 185, 129, 0.25);
        }

        .submit-btn:hover {

            box-shadow:
                0 22px 44px rgba(16, 185, 129, 0.34);
        }

        /* ===============================
           MOBILE
        =============================== */

        @media (max-width: 1100px) {

            .booking-grid {
                grid-template-columns: 1fr;
            }

            .sidebar-card {
                position: relative;
                top: 0;
            }
        }

        @media (max-width: 768px) {

            body {
                padding-top: 170px;
            }

            .navbar {

                padding: 18px;

                flex-direction: column;

                align-items: flex-start;

                gap: 18px;
            }

            .nav-wrapper {

                width: 100%;

                flex-wrap: wrap;
            }

            .nav-link,
            .nav-book-btn {

                width: 100%;

                justify-content: center;
            }

            .form-card {
                padding: 28px;
            }

            .form-title {
                font-size: 38px;
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

            <a href="{{ route('home') }}"
                class="nav-link">

                <i class="fa-solid fa-house"></i>

                Trang chủ

            </a>

            <a href="{{ route('rooms.index') }}"
                class="nav-link">

                <i class="fa-solid fa-bed"></i>

                Danh sách phòng

            </a>

            @auth

            @if(auth()->user()->role === 'guest')

            <a href="{{ route('guest.bookings.index') }}"
                class="nav-link">

                <i class="fa-solid fa-calendar-check"></i>

                Booking của tôi

            </a>

            <a href="{{ route('profile.edit') }}"
                class="nav-link">

                <i class="fa-solid fa-user"></i>

                Hồ sơ

            </a>

            @endif

            @endauth

            <a href="{{ route('rooms.show', $room) }}"
                class="nav-book-btn">

                <i class="fa-solid fa-arrow-left"></i>

                Quay lại chi tiết

            </a>

        </div>

    </nav>

    <!-- MAIN -->

    <div class="main-wrapper">

        <div class="booking-grid">

            <!-- LEFT -->

            <div>

                <div class="luxury-card sidebar-card">

                    <div class="room-preview">

                        @php
                            $previewImg = $room->mainImage ?? $room->images->first();
                        @endphp

                        @if($previewImg)

                        <img src="{{ asset('storage/' . $previewImg->image_path) }}"
                            alt="{{ $room->room_name }}">

                        @endif

                        <div class="room-overlay"></div>

                        <div class="floating-price">

                            <p>Giá mỗi đêm</p>

                            <p>{{ number_format($room->price) }} VND</p>

                        </div>

                    </div>

                    <div class="p-7">

                        <div class="section-tag">
                            <span></span>
                            Resort bạn đã chọn
                        </div>

                        <h2 class="font-serif-luxury text-4xl text-slate-900 font-bold mb-3">
                            {{ $room->room_name }}
                        </h2>

                        <div class="flex flex-wrap gap-2 mb-6">

                            <div class="px-3 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold">
                                Mã: {{ $room->room_code }}
                            </div>

                            <div class="px-3 py-2 rounded-xl bg-emerald-100 text-emerald-700 text-xs font-bold">
                                {{ $room->capacity }} khách
                            </div>

                        </div>

                        <div class="space-y-3">

                            <div class="meta-box">

                                <span class="text-slate-500 text-sm">
                                    Trạng thái
                                </span>

                                <strong class="text-emerald-600">
                                    {{ ucfirst($room->status) }}
                                </strong>

                            </div>

                            <div class="meta-box">

                                <span class="text-slate-500 text-sm">
                                    Loại phòng
                                </span>

                                <strong class="text-slate-800">
                                    Luxury Resort
                                </strong>

                            </div>

                        </div>

                        <div class="estimate-box">

                            <p class="text-xs uppercase tracking-[0.2em] text-slate-400 font-bold mb-3">
                                Ước tính chi phí
                            </p>

                            <div class="flex items-end justify-between gap-4">

                                <div>

                                    <p id="estimator-nights"
                                        class="text-sm text-slate-500 font-medium">
                                        Chưa chọn ngày
                                    </p>

                                </div>

                                <div class="estimate-total"
                                    id="estimator-total">

                                    0 VND

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div>

                <div class="luxury-card form-card">

                    <div class="section-tag">
                        <span></span>
                        Đăng ký kỳ nghỉ dưỡng
                    </div>

                    <h1 class="font-serif-luxury form-title">
                        Booking Form
                    </h1>

                    @if($errors->any())

                    <div class="mb-8 rounded-3xl border border-red-200 bg-red-50 p-5">

                        <div class="flex items-center gap-2 text-red-600 font-bold mb-2">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            Có lỗi xảy ra
                        </div>

                        <ul class="space-y-1 text-sm text-red-500">

                            @foreach($errors->all() as $error)

                            <li>• {{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                    @endif

                    <form method="POST"
                        action="{{ route('guest.bookings.store', $room) }}">

                        @csrf

                        <div class="grid md:grid-cols-2 gap-6">

                            <div class="input-group">

                                <label class="input-label">
                                    Ngày nhận phòng
                                </label>

                                <input type="date"
                                    id="check_in_date"
                                    name="check_in_date"
                                    class="glass-input"
                                    required>

                            </div>

                            <div class="input-group">

                                <label class="input-label">
                                    Ngày trả phòng
                                </label>

                                <input type="date"
                                    id="check_out_date"
                                    name="check_out_date"
                                    class="glass-input"
                                    required>

                            </div>

                        </div>

                        <div class="grid md:grid-cols-2 gap-6">

                            <div class="input-group">

                                <label class="input-label">
                                    Số lượng khách
                                </label>

                                <input type="number"
                                    name="guest_count"
                                    min="1"
                                    max="{{ $room->capacity }}"
                                    placeholder="Tối đa {{ $room->capacity }} khách"
                                    class="glass-input"
                                    required>

                            </div>

                            <div class="input-group">

                                <label class="input-label">
                                    Người liên hệ
                                </label>

                                <input type="text"
                                    name="contact_name"
                                    value="{{ Auth::user()->full_name }}"
                                    class="glass-input"
                                    required>

                            </div>

                        </div>

                        <div class="grid md:grid-cols-2 gap-6">

                            <div class="input-group">

                                <label class="input-label">
                                    Số điện thoại
                                </label>

                                <input type="text"
                                    name="contact_phone"
                                    placeholder="Nhập số điện thoại"
                                    class="glass-input"
                                    required>

                            </div>

                            <div class="input-group">

                                <label class="input-label">
                                    Email liên hệ
                                </label>

                                <input type="email"
                                    name="contact_email"
                                    value="{{ Auth::user()->email }}"
                                    class="glass-input">

                            </div>

                        </div>

                        <div class="input-group">

                            <label class="input-label">
                                Ghi chú đặc biệt
                            </label>

                            <textarea name="note"
                                class="glass-input"
                                placeholder="Yêu cầu đặc biệt, giờ check-in, giường phụ..."></textarea>

                        </div>

                        <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row gap-4 justify-between">

                            <a href="{{ route('rooms.show', $room) }}"
                                class="h-[58px] px-8 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 flex items-center justify-center gap-2 font-semibold text-slate-700 transition">

                                <i class="fa-solid fa-arrow-left"></i>

                                Quay lại

                            </a>

                            <button type="submit"
                                class="submit-btn btn-shimmer">

                                <i class="fa-solid fa-check mr-2"></i>

                                Xác nhận đặt phòng

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const checkInInput = document.getElementById('check_in_date');
            const checkOutInput = document.getElementById('check_out_date');

            const estimatorNights = document.getElementById('estimator-nights');
            const estimatorTotal = document.getElementById('estimator-total');

            const roomPrice = {{ $room->price }};

            function formatCurrency(number) {
                return new Intl.NumberFormat('vi-VN').format(number) + ' VND';
            }

            function calculateEstimate() {

                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);

                if (
                    checkInInput.value &&
                    checkOutInput.value &&
                    checkOut > checkIn
                ) {

                    const diffTime = Math.abs(checkOut - checkIn);

                    const nights = Math.ceil(
                        diffTime / (1000 * 60 * 60 * 24)
                    );

                    const total = nights * roomPrice;

                    estimatorNights.innerHTML =
                        `<span class="text-emerald-600 font-bold">${nights} đêm</span> nghỉ dưỡng`;

                    estimatorTotal.innerText =
                        formatCurrency(total);

                } else {

                    estimatorNights.innerText =
                        'Chưa chọn ngày';

                    estimatorTotal.innerText =
                        '0 VND';
                }
            }

            checkInInput.addEventListener('change', calculateEstimate);
            checkOutInput.addEventListener('change', calculateEstimate);

        });

    </script>

    @include('partials.notification-modal')

</body>

</html>