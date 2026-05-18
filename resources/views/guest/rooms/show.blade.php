<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $room->room_name }}</title>
    
    <!-- Tailwind CSS for modern utility classes -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Luxury & Premium Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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

        /* ===== PREMIUM IMAGE CROSS-FADE SLIDER ===== */
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
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 1.2s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1;
        }

        .slide.active {
            opacity: 1;
            transform: scale(1);
            z-index: 10;
        }

        /* ===== GLOW & SHIMMER EFFECTS ===== */
        .luxury-card {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
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

        /* Premium hover shimmer on primary buttons */
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
            background: rgba(255, 255, 255, 0.18);
            transform: rotate(30deg);
            transition: none;
        }

        .btn-shimmer:hover::after {
            left: 150%;
            transition: all 0.8s ease-in-out;
        }
        
        .btn-shimmer:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
    </style>
</head>

<body class="text-slate-200 min-h-screen flex items-center justify-center p-4 md:p-8">

<div class="w-full max-w-5xl mx-auto my-4">

    <!-- Top Luxury Navigation Bar -->
    <div class="flex justify-between items-center mb-6 px-2">
        <a href="{{ route('rooms.index') }}" class="group text-slate-400 hover:text-white transition-colors duration-300 flex items-center gap-2 text-sm font-medium">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
            Quay lại danh sách
        </a>

        <a href="{{ route('home') }}" class="group border border-slate-800 hover:border-slate-600 bg-slate-950/40 hover:bg-slate-900/60 text-slate-300 hover:text-white px-5 py-2.5 rounded-2xl transition-all duration-300 text-xs font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 transform group-hover:-translate-y-0.5 transition-transform text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Trang chủ
        </a>
    </div>

    <!-- Luxury Room Card -->
    <div class="luxury-card rounded-3xl overflow-hidden shadow-2xl">

        <!-- ===== PREMIUM IMAGE SLIDER ===== -->
        <div class="slider-container group">
            @foreach($room->images as $index => $img)
                <img
                    src="{{ asset('storage/' . $img->image_path) }}"
                    class="{{ $index === 0 ? 'active' : '' }} slide"
                    alt="{{ $room->room_name }}"
                >
            @endforeach

            <!-- Ambient Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-black/30 pointer-events-none z-20"></div>

            <!-- Slider Control Buttons -->
            @if($room->images->count() > 1)
                <button 
                    class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-slate-950/40 hover:bg-slate-950/75 text-white flex items-center justify-center border border-white/10 backdrop-blur-md transition-all duration-300 transform hover:scale-110 active:scale-95 z-30 opacity-0 group-hover:opacity-100 focus:opacity-100" 
                    onclick="changeSlide(-1)"
                    aria-label="Previous slide"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button 
                    class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-slate-950/40 hover:bg-slate-950/75 text-white flex items-center justify-center border border-white/10 backdrop-blur-md transition-all duration-300 transform hover:scale-110 active:scale-95 z-30 opacity-0 group-hover:opacity-100 focus:opacity-100" 
                    onclick="changeSlide(1)"
                    aria-label="Next slide"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>

                <!-- Premium Indicator dots dynamically managed (visual cue) -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-2 z-30">
                    @foreach($room->images as $index => $img)
                        <span class="slide-dot w-2 h-2 rounded-full bg-white/40 transition-all duration-300 {{ $index === 0 ? 'bg-white !w-6' : '' }}"></span>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- ===== CONTENT & INFO DETAILS ===== -->
        <div class="p-8 md:p-12">

            <!-- Label/Header Decorator -->
            <div class="flex items-center space-x-2 mb-3">
                <span class="h-px w-8 bg-emerald-500/80"></span>
                <span class="text-xs uppercase tracking-[0.25em] text-emerald-400 font-semibold">Trải nghiệm Thượng Lưu</span>
            </div>

            <!-- Room Main Title -->
            <h1 class="font-serif-luxury text-4xl md:text-5xl text-white font-semibold leading-tight mb-4 tracking-wide">
                {{ $room->room_name }}
            </h1>

            <!-- Luxury Pricing Badge -->
            <div class="inline-flex items-baseline bg-slate-900/60 border border-emerald-500/10 rounded-2xl px-5 py-3 mb-8">
                <span class="text-3xl font-extrabold text-emerald-400 tracking-tight">
                    {{ number_format($room->price) }}
                </span>
                <span class="text-emerald-500/80 font-medium text-sm ml-2">VND / đêm</span>
            </div>

            <!-- Room Amenities & Meta Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 border-y border-slate-800/80 py-8">
                
                <!-- Room Code Item -->
                <div class="flex items-center space-x-4 bg-slate-900/40 p-4 rounded-2xl border border-slate-800/50 hover:border-slate-700/60 transition-colors duration-300">
                    <div class="w-12 h-12 rounded-xl bg-slate-800/80 flex items-center justify-center text-emerald-400 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-xs uppercase tracking-wider text-slate-400 font-medium">Mã phòng</span>
                        <strong class="text-white text-base font-semibold">{{ $room->room_code }}</strong>
                    </div>
                </div>

                <!-- Capacity Item -->
                <div class="flex items-center space-x-4 bg-slate-900/40 p-4 rounded-2xl border border-slate-800/50 hover:border-slate-700/60 transition-colors duration-300">
                    <div class="w-12 h-12 rounded-xl bg-slate-800/80 flex items-center justify-center text-emerald-400 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-xs uppercase tracking-wider text-slate-400 font-medium">Sức chứa</span>
                        <strong class="text-white text-base font-semibold">{{ $room->capacity }} khách</strong>
                    </div>
                </div>

                <!-- Status Item -->
                <div class="flex items-center space-x-4 bg-slate-900/40 p-4 rounded-2xl border border-slate-800/50 hover:border-slate-700/60 transition-colors duration-300">
                    <div class="w-12 h-12 rounded-xl bg-slate-800/80 flex items-center justify-center text-emerald-400 shadow-inner">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs uppercase tracking-wider text-slate-400 font-medium">Trạng thái</span>
                        <strong class="text-white text-base font-semibold">{{ ucfirst($room->status) }}</strong>
                    </div>
                </div>

            </div>

            <!-- Description -->
            <div class="mb-10">
                <h3 class="font-serif-luxury text-xl text-white font-medium mb-3 tracking-wide">Mô tả chi tiết</h3>
                <p class="text-slate-300/90 leading-relaxed text-base font-light">
                    {{ $room->description }}
                </p>
            </div>

            <!-- ===== BUTTON ACTIONS ===== -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-4 border-t border-slate-800/30">
                
                @if(Auth::check() && Auth::user()->role === 'guest')
                    <a href="{{ route('guest.bookings.create', $room) }}" class="btn-shimmer bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-semibold px-8 py-4 rounded-2xl text-center shadow-lg transition-all duration-300 text-base">
                        Đặt phòng ngay
                    </a>
                @endif

                <a href="{{ route('rooms.index') }}" class="group border border-slate-700 hover:border-slate-500 bg-slate-900/40 hover:bg-slate-800/50 text-slate-300 hover:text-white font-semibold px-6 py-4 rounded-2xl transition-all duration-300 text-center text-base flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Quay lại danh sách
                </a>

                <a href="{{ route('home') }}" class="group border border-slate-800 hover:border-slate-700 bg-slate-950/30 hover:bg-slate-900/40 text-slate-400 hover:text-white font-semibold px-6 py-4 rounded-2xl transition-all duration-300 text-center text-base flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 transform group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Về Trang chủ
                </a>

            </div>

        </div>

    </div>

</div>

<script>
    let current = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slide-dot');

    function show(index) {
        slides.forEach((img, i) => {
            img.classList.remove('active');
            if (i === index) {
                img.classList.add('active');
            }
        });

        // Update indicators visually if present
        if (dots.length > 0) {
            dots.forEach((dot, i) => {
                dot.classList.remove('bg-white', 'w-6');
                dot.classList.add('bg-white/40');
                if (i === index) {
                    dot.classList.add('bg-white', 'w-6');
                    dot.classList.remove('bg-white/40');
                }
            });
        }
    }

    function changeSlide(step) {
        current += step;

        if (current >= slides.length) current = 0;
        if (current < 0) current = slides.length - 1;

        show(current);
    }

    // Auto-advance slideshow slowly for premium feel
    let slideInterval = setInterval(() => {
        changeSlide(1);
    }, 6000);

    // Reset auto-slide timer on user interaction
    const sliderContainer = document.querySelector('.slider-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', () => clearInterval(slideInterval));
        sliderContainer.addEventListener('mouseleave', () => {
            slideInterval = setInterval(() => {
                changeSlide(1);
            }, 6000);
        });
    }
</script>

</body>
</html>