<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt phòng - {{ $room->room_name }}</title>

    <!-- Tailwind CSS for modern utility classes -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Luxury & Premium Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght=0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #e9ffea;
            background-image: 
                radial-gradient(at 0% 0%, rgba(15, 137, 96, 0.07) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(59, 130, 246, 0.05) 0px, transparent 50%);
            background-attachment: fixed;
        }

        .font-serif-luxury {
            font-family: 'Cormorant Garamond', serif;
        }

        /* Thẻ kính mờ cao cấp - Phiên bản tươi sáng */
        .luxury-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.06), 0 0 0 1px rgba(15, 23, 42, 0.02);
            animation: cardEntrance 0.8s ease-out forwards;
        }

        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Ô nhập liệu bọc kính mờ sáng */
        .glass-input {
            background: rgba(255, 255, 255, 0.8) !important;
            border: 1px solid #e2e8f0 !important;
            color: #0f172a !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-input:focus {
            outline: none;
            border-color: rgba(16, 185, 129, 0.5) !important;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.12);
            background: #ffffff !important;
            transform: translateY(-1px);
        }

        .glass-input::placeholder {
            color: #94a3b8 !important;
        }

        /* Nút Shimmer ngọc lục bảo */
        .btn-shimmer {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-shimmer::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 30%;
            height: 200%;
            background: rgba(255, 255, 255, 0.25);
            transform: rotate(30deg);
            transition: none;
        }

        .btn-shimmer:hover::after {
            left: 150%;
            transition: all 0.8s ease-in-out;
        }

        .btn-shimmer:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        /* Định dạng các trường ngày tháng mặc định */
        ::-webkit-calendar-picker-indicator {
            filter: sepia(0.5) saturate(2) hue-rotate(90deg);
            cursor: pointer;
        }
    </style>
</head>

<body class="text-slate-600 min-h-screen flex items-center justify-center p-4 md:p-8">

<div class="w-full max-w-5xl mx-auto my-4">

    <!-- TOP NAVIGATION -->
    <div class="flex justify-between items-center mb-6 px-2">
        <a href="{{ route('rooms.show', $room) }}" class="group text-slate-500 hover:text-emerald-600 transition-colors duration-300 flex items-center gap-2 text-sm font-medium">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
            Quay lại chi tiết phòng
        </a>

        <a href="{{ route('home') }}" class="group border border-slate-200 hover:border-slate-300 bg-white hover:bg-slate-50 text-slate-600 hover:text-slate-900 px-5 py-2.5 rounded-2xl transition-all duration-300 text-xs font-semibold flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4 transform group-hover:-translate-y-0.5 transition-transform text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Trang chủ
        </a>
    </div>

    <!-- MAIN GRID CONTAINER -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT SIDEBAR: ROOM SUMMARY -->
        <div class="lg:col-span-4 space-y-6">
            <div class="luxury-card rounded-3xl p-6">
                <div class="flex items-center space-x-2 mb-4">
                    <span class="h-px w-6 bg-emerald-500"></span>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-emerald-600 font-bold">Lựa chọn của bạn</span>
                </div>

                <!-- Room Image Preview -->
                <div class="relative rounded-2xl overflow-hidden aspect-video mb-4 bg-slate-100 border border-slate-200/60 shadow-inner">
                    @php
                        $previewImg = $room->mainImage ?? $room->images->first();
                    @endphp
                    @if($previewImg)
                        <img src="{{ asset('storage/' . $previewImg->image_path) }}" class="w-full h-full object-cover" alt="{{ $room->room_name }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                            <span class="text-xs">Chưa có hình ảnh</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/20 to-transparent"></div>
                </div>

                <h3 class="font-serif-luxury text-2xl text-slate-900 font-semibold mb-1 tracking-wide">
                    {{ $room->room_name }}
                </h3>
                <span class="inline-block text-xs uppercase font-semibold tracking-wider text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200/60 mb-4">
                    Mã: {{ $room->room_code }}
                </span>

                <!-- Quick Meta Information -->
                <div class="space-y-2 border-t border-slate-100 pt-4 mb-4 text-xs">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Đơn giá:</span>
                        <span class="text-emerald-600 font-bold text-sm" id="price-per-night" data-price="{{ $room->price }}">
                            {{ number_format($room->price) }} VND
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500">Sức chứa tối đa:</span>
                        <span class="text-slate-800 font-medium">{{ $room->capacity }} khách</span>
                    </div>
                </div>

                <!-- Realtime Interactive Total Estimator -->
                <div class="bg-emerald-50/50 rounded-2xl p-4 border border-emerald-500/10" id="price-estimator-box">
                    <span class="block text-[10px] uppercase tracking-wider text-slate-400 font-bold mb-2">ƯỚC TÍNH CHI PHÍ</span>
                    <div class="flex justify-between items-baseline">
                        <span class="text-xs text-slate-500" id="estimator-nights">Chưa chọn ngày nghỉ</span>
                        <span class="text-lg font-bold text-emerald-600 tracking-tight" id="estimator-total">0 VND</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE: FORM -->
        <div class="lg:col-span-8">
            <div class="luxury-card rounded-3xl p-8 md:p-10">
                
                <div class="flex items-center space-x-2 mb-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <h2 class="text-xs uppercase tracking-wider text-slate-400 font-bold">Thông tin đặt kỳ nghỉ</h2>
                </div>
                <h1 class="font-serif-luxury text-3xl md:text-4xl text-slate-900 font-semibold mb-8">Biểu mẫu Đăng ký</h1>

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-800 text-sm shadow-sm">
                        <div class="flex items-center space-x-2 mb-2">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span class="font-bold">Đã xảy ra lỗi nhập liệu:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1 text-xs text-rose-700/90 pl-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- CORE BOOKING FORM -->
                <form method="POST" action="{{ route('guest.bookings.store', $room) }}" class="space-y-6">
                    @csrf

                    <!-- Grid for Dates -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-slate-500 font-semibold mb-2">Ngày nhận phòng</label>
                            <input 
                                type="date" 
                                name="check_in_date" 
                                id="check_in_date"
                                class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-wider text-slate-500 font-semibold mb-2">Ngày trả phòng</label>
                            <input 
                                type="date" 
                                name="check_out_date" 
                                id="check_out_date"
                                class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm"
                                required
                            >
                        </div>
                    </div>

                    <!-- Row for Guest Count & Contact Name -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-slate-500 font-semibold mb-2">Số khách đi cùng</label>
                            <input 
                                type="number" 
                                name="guest_count" 
                                class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm"
                                min="1" 
                                max="{{ $room->capacity }}" 
                                placeholder="Tối đa {{ $room->capacity }} người"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-wider text-slate-500 font-semibold mb-2">Tên người liên hệ</label>
                            <input 
                                type="text" 
                                name="contact_name" 
                                value="{{ Auth::user()->full_name }}" 
                                class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm"
                                required
                            >
                        </div>
                    </div>

                    <!-- Row for Contact Phone & Contact Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs uppercase tracking-wider text-slate-500 font-semibold mb-2">Số điện thoại liên hệ</label>
                            <input 
                                type="text" 
                                name="contact_phone" 
                                class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm"
                                placeholder="Nhập số điện thoại..."
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-wider text-slate-500 font-semibold mb-2">Địa chỉ Email</label>
                            <input 
                                type="email" 
                                name="contact_email" 
                                value="{{ Auth::user()->email }}" 
                                class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm"
                            >
                        </div>
                    </div>

                    <!-- Textarea for Note -->
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-slate-500 font-semibold mb-2">Ghi chú đặc biệt (Tùy chọn)</label>
                        <textarea 
                            name="note" 
                            rows="4" 
                            class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm"
                            placeholder="Vui lòng cho chúng tôi biết về yêu cầu giường phụ, chế độ ăn uống hoặc giờ nhận phòng của bạn..."
                        ></textarea>
                    </div>

                    <!-- Bottom Actions -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('rooms.show', $room) }}" class="group border border-slate-200 hover:border-slate-300 bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-900 font-semibold px-6 py-3.5 rounded-2xl transition-all duration-300 text-center text-sm flex items-center justify-center gap-2 shadow-sm">
                            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Quay lại chi tiết
                        </a>

                        <button 
                            type="submit" 
                            class="btn-shimmer bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-semibold px-8 py-3.5 rounded-2xl text-center shadow-md transition-all duration-300 text-sm"
                        >
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
        const pricePerNightStr = document.getElementById('price-per-night').getAttribute('data-price');
        const pricePerNight = parseFloat(pricePerNightStr);

        const estimatorNights = document.getElementById('estimator-nights');
        const estimatorTotal = document.getElementById('estimator-total');

        function formatCurrency(number) {
            return new Intl.NumberFormat('vi-VN').format(number) + ' VND';
        }

        function calculateEstimate() {
            const checkInDate = new Date(checkInInput.value);
            const checkOutDate = new Date(checkOutInput.value);

            if (checkInInput.value && checkOutInput.value && checkOutDate > checkInDate) {
                const diffTime = Math.abs(checkOutDate - checkInDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                const totalCost = diffDays * pricePerNight;

                estimatorNights.innerHTML = `<span class="text-emerald-600 font-semibold">${diffDays} đêm</span> nghỉ dưỡng`;
                estimatorTotal.innerText = formatCurrency(totalCost);
                
                // Hiệu ứng nháy nhẹ thanh lịch khi cập nhật giá tiền
                estimatorTotal.classList.add('animate-pulse');
                setTimeout(() => {
                    estimatorTotal.classList.remove('animate-pulse');
                }, 500);
            } else {
                estimatorNights.innerText = 'Chưa chọn ngày nghỉ';
                estimatorTotal.innerText = '0 VND';
            }
        }

        checkInInput.addEventListener('change', calculateEstimate);
        checkOutInput.addEventListener('change', calculateEstimate);
    });
</script>

</body>

</html>