<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $room->room_name }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #545865;
            background-image:
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(37, 99, 235, 0.05) 0px, transparent 50%);
        }

        .font-serif-luxury {
            font-family: 'Cormorant Garamond', serif;
        }

        .slider-container {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
            background: #1e293b;
            overflow: hidden;
        }

        .slide {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transform: scale(1.02);
            transition: opacity 0.8s ease, transform 1.2s ease;
        }

        .slide.active {
            opacity: 1;
            transform: scale(1);
            z-index: 10;
        }

        .luxury-card {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
        }
    </style>
</head>

<body class="text-slate-200 min-h-screen flex items-center justify-center p-4 md:p-8">

<!-- FIXED TOP BAR -->
<div class="fixed top-0 left-0 w-full z-50 bg-slate-950/70 backdrop-blur-md border-b border-slate-800">
    <div class="max-w-5xl mx-auto flex items-center justify-between px-4 py-3">

        <!-- LEFT -->
        <div class="flex items-center gap-4">
            <a href="{{ route('rooms.index') }}" class="text-slate-300 hover:text-white text-sm">
                ← Danh sách phòng
            </a>

            <a href="{{ route('home') }}" class="text-slate-300 hover:text-white text-sm">
                🏠 Trang chủ
            </a>
        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-3">

            @guest
                <a href="{{ route('login') }}"
                   class="px-4 py-2 rounded-xl border border-slate-700 text-sm hover:text-white">
                    Đăng nhập
                </a>

                <a href="{{ route('register') }}"
                   class="px-4 py-2 rounded-xl bg-emerald-500 text-white text-sm hover:bg-emerald-400">
                    Đăng ký
                </a>
            @endguest

            @if(Auth::check() && Auth::user()->role === 'guest')

                <a href="{{ route('guest.bookings.index') }}"
                   class="px-4 py-2 rounded-xl border border-slate-700 text-sm hover:text-white">
                    My Booking
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="px-4 py-2 rounded-xl border border-slate-700 text-sm hover:text-white">
                    My Profile
                </a>

                <a href="{{ route('guest.bookings.create', $room) }}"
                   class="px-4 py-2 rounded-xl bg-emerald-500 text-white text-sm hover:bg-emerald-400">
                    Đặt phòng
                </a>

            @endif

        </div>
    </div>
</div>

<!-- MAIN -->
<div class="w-full max-w-5xl mx-auto mt-20">

    <div class="luxury-card rounded-3xl overflow-hidden">

        <!-- SLIDER -->
        <div class="slider-container group">

            @foreach($room->images as $index => $img)
                <img src="{{ asset('storage/' . $img->image_path) }}"
                     class="slide {{ $index === 0 ? 'active' : '' }}"
                     alt="{{ $room->room_name }}">
            @endforeach

            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-black/30 pointer-events-none z-20"></div>

            @if($room->images->count() > 1)

                <button onclick="changeSlide(-1)"
                        class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-slate-950/40 text-white z-30 opacity-0 group-hover:opacity-100">
                    ‹
                </button>

                <button onclick="changeSlide(1)"
                        class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-slate-950/40 text-white z-30 opacity-0 group-hover:opacity-100">
                    ›
                </button>

            @endif

        </div>

        <!-- CONTENT -->
        <div class="p-8 md:p-12">

            <h1 class="font-serif-luxury text-4xl text-white mb-4">
                {{ $room->room_name }}
            </h1>

            <div class="text-emerald-400 text-2xl font-bold mb-6">
                {{ number_format($room->price) }} VND / đêm
            </div>

            <div class="grid md:grid-cols-3 gap-4 mb-8">
                <div>Mã phòng: {{ $room->room_code }}</div>
                <div>Sức chứa: {{ $room->capacity }} khách</div>
                <div>Trạng thái: {{ ucfirst($room->status) }}</div>
            </div>

            <p class="text-slate-300 leading-relaxed">
                {{ $room->description }}
            </p>

        </div>
    </div>
</div>

<script>
let current = 0;
const slides = document.querySelectorAll('.slide');

function show(i){
    slides.forEach((s, idx)=>{
        s.classList.toggle('active', idx === i);
    });
}

function changeSlide(step){
    current += step;
    if(current >= slides.length) current = 0;
    if(current < 0) current = slides.length - 1;
    show(current);
}

setInterval(()=>changeSlide(1), 6000);
</script>

</body>
</html>