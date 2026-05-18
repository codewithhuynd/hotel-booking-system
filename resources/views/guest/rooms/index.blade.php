<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phòng nghỉ dưỡng</title>

    <!-- Tailwind CSS for high-end utility design -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Luxury & Premium Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #5b6376;
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(37, 99, 235, 0.05) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(16, 185, 129, 0.03) 0px, transparent 50%);
            background-attachment: fixed;
        }

        .font-serif-luxury {
            font-family: 'Cormorant Garamond', serif;
        }

        /* Custom Shimmer and Glow for Elite feel */
        .luxury-card {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .luxury-card:hover {
            transform: translateY(-6px);
            border-color: rgba(16, 185, 129, 0.3);
            box-shadow: 0 20px 40px -15px rgba(16, 185, 129, 0.15);
        }

        /* Glassmorphism Inputs */
        .glass-input {
            background: rgba(15, 23, 42, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #f1f5f9 !important;
            transition: all 0.3s ease;
        }

        .glass-input:focus {
            outline: none;
            border-color: rgba(16, 185, 129, 0.5) !important;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.15);
        }

        /* Smooth Slider Transitions & Zooms */
        .room-slider {
            position: relative;
            width: 100%;
            height: 240px;
            margin-bottom: 1.25rem;
            border-radius: 1.25rem;
            overflow: hidden;
            background: #1e293b;
        }

        .room-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), filter 0.3s ease;
        }

        .room-slider:hover .room-image {
            transform: scale(1.08);
        }

        /* Premium Slick Buttons */
        .btn-premium {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-premium::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 30%;
            height: 200%;
            background: rgba(255, 255, 255, 0.15);
            transform: rotate(30deg);
            transition: none;
        }

        .btn-premium:hover::after {
            left: 150%;
            transition: all 0.8s ease-in-out;
        }

        /* Custom Scrollbar for Luxury Grid */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0b0f19;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #10b981;
        }
        
        /* Adjust Tailwind default native select icon color for dark mode */
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") !important;
            background-position: right 0.75rem center !important;
            background-repeat: no-repeat !important;
            background-size: 1.5em 1.5em !important;
            padding-right: 2.5rem !important;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
</head>

<body class="text-slate-200 min-h-screen p-4 md:p-8">

<div class="max-w-7xl mx-auto my-6">

    <!-- Top Luxury Bar -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10 pb-6 border-b border-slate-800/60">
        <div>
            <div class="flex items-center space-x-2 mb-1">
                <span class="h-px w-6 bg-emerald-500/80"></span>
                <span class="text-xs uppercase tracking-[0.25em] text-emerald-400 font-semibold">Tuyệt tác không gian</span>
            </div>
            <h1 class="font-serif-luxury text-4xl md:text-5xl text-white font-semibold tracking-wide">
                Danh sách phòng nghỉ
            </h1>
        </div>

        <a href="{{ route('home') }}" class="group border border-slate-800 hover:border-slate-600 bg-slate-950/40 hover:bg-slate-900/60 text-slate-300 hover:text-white px-6 py-3.5 rounded-2xl transition-all duration-300 text-sm font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Quay về Trang chủ
        </a>
    </div>

    <!-- SEARCH & FILTER STUDIO (BỌC KÍNH MỜ SANG TRỌNG) -->
    <div class="luxury-card rounded-3xl p-6 md:p-8 mb-12">
        <div class="flex items-center space-x-2 mb-6">
            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
            </svg>
            <h2 class="text-sm uppercase tracking-wider text-slate-300 font-semibold">Tìm kiếm & Bộ lọc nâng cao</h2>
        </div>

        <form method="GET">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                
                <!-- Keyword Field -->
                <div class="xl:col-span-2">
                    <input 
                        type="text" 
                        name="keyword" 
                        placeholder="Tên phòng nghỉ..." 
                        value="{{ request('keyword') }}"
                        class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm"
                    >
                </div>

                <!-- Price Field -->
                <div>
                    <select name="price" class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm cursor-pointer">
                        <option value="">Tất cả mức giá</option>
                        <option value="low" {{ request('price')=='low'?'selected':'' }}>Dưới 500k</option>
                        <option value="medium" {{ request('price')=='medium'?'selected':'' }}>500k - 1 triệu</option>
                        <option value="high" {{ request('price')=='high'?'selected':'' }}>Trên 1 triệu</option>
                    </select>
                </div>

                <!-- Capacity Field -->
                <div>
                    <select name="capacity" class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm cursor-pointer">
                        <option value="">Sức chứa</option>
                        <option value="1" {{ request('capacity')==1?'selected':'' }}>1 khách</option>
                        <option value="2" {{ request('capacity')==2?'selected':'' }}>2 khách</option>
                        <option value="4" {{ request('capacity')==4?'selected':'' }}>4+ khách</option>
                    </select>
                </div>

                <!-- Status Field -->
                <div>
                    <select name="status" class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm cursor-pointer">
                        <option value="">Trạng thái phòng</option>
                        <option value="available" {{ request('status')=='available'?'selected':'' }}>Còn trống</option>
                        <option value="occupied" {{ request('status')=='occupied'?'selected':'' }}>Đang dùng</option>
                        <option value="maintenance" {{ request('status')=='maintenance'?'selected':'' }}>Bảo trì</option>
                    </select>
                </div>

                <!-- Sort Price Field -->
                <div>
                    <select name="sort_price" class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm cursor-pointer">
                        <option value="">Sắp xếp giá</option>
                        <option value="asc" {{ request('sort_price')=='asc'?'selected':'' }}>Giá tăng dần</option>
                        <option value="desc" {{ request('sort_price')=='desc'?'selected':'' }}>Giá giảm dần</option>
                    </select>
                </div>

                <!-- Sort Time Field & Button Submit Row -->
                <div class="sm:col-span-2 lg:col-span-3 xl:col-span-6 grid grid-cols-1 md:grid-cols-4 gap-4 mt-2">
                    <div class="md:col-span-3">
                        <select name="sort_time" class="glass-input w-full px-4 py-3.5 rounded-2xl text-sm cursor-pointer">
                            <option value="latest" {{ request('sort_time')=='latest'?'selected':'' }}>Mới cập nhật</option>
                            <option value="oldest" {{ request('sort_time')=='oldest'?'selected':'' }}>Cũ nhất</option>
                        </select>
                    </div>
                    
                    <div>
                        <button 
                            type="submit" 
                            class="w-full btn-premium bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-semibold py-3.5 px-6 rounded-2xl text-sm shadow-lg text-center"
                        >
                            Áp dụng lọc
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <!-- DATA FOR JS (KEEP AS-IS) -->
    @php
        $roomImages = $rooms->mapWithKeys(function ($room) {
            return [
                $room->id => $room->images->pluck('image_path')->values()
            ];
        });
    @endphp

    <!-- ROOM LIST GRID -->
    <div class="room-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        @forelse($rooms as $room)

            <div class="luxury-card rounded-3xl overflow-hidden p-5 flex flex-col justify-between group">

                <div>
                    <!-- PREMIUM IMAGE SLIDER -->
                    <div class="room-slider group/slider">

                        @php
                            $mainImage = $room->mainImage ?? $room->images->first();
                        @endphp

                        @if($mainImage)
                            <img
                                src="{{ asset('storage/'.$mainImage->image_path) }}"
                                class="room-image slide-{{ $room->id }}"
                                alt="{{ $room->room_name }}"
                            >
                        @else
                            <!-- Placeholder Premium State -->
                            <div class="w-full h-full bg-slate-900 flex flex-col items-center justify-center text-slate-500">
                                <svg class="w-10 h-10 mb-2 stroke-slate-600" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs tracking-wider">Hình ảnh đang được cập nhật</span>
                            </div>
                        @endif

                        <!-- Ambient Linear Dark Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 to-transparent pointer-events-none"></div>

                        <!-- Elegant Slider Control Overlays -->
                        @if($room->images->count() > 1)
                            <button 
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-slate-950/40 hover:bg-slate-950/80 text-white flex items-center justify-center border border-white/5 backdrop-blur-sm transition-all duration-300 transform scale-90 group-hover/slider:scale-100 opacity-0 group-hover/slider:opacity-100" 
                                onclick="changeSlide({{ $room->id }}, -1)"
                                aria-label="Previous image"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button 
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-slate-950/40 hover:bg-slate-950/80 text-white flex items-center justify-center border border-white/5 backdrop-blur-sm transition-all duration-300 transform scale-90 group-hover/slider:scale-100 opacity-0 group-hover/slider:opacity-100" 
                                onclick="changeSlide({{ $room->id }}, 1)"
                                aria-label="Next image"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        @endif
                    </div>

                    <!-- Room Meta Content -->
                    <div class="px-2">
                        <div class="flex items-center justify-between mb-3">
                            <!-- Code Tag -->
                            <span class="text-xs uppercase font-semibold tracking-wider text-slate-400 bg-slate-900/60 px-3 py-1.5 rounded-lg border border-slate-800/40">
                                MD: {{ $room->room_code }}
                            </span>

                            <!-- Dynamic Luxury Status Badges -->
                            @php
                                $status = strtolower($room->status);
                                $statusClasses = 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20';
                                if($status === 'occupied') {
                                    $statusClasses = 'text-amber-400 bg-amber-500/10 border-amber-500/20';
                                } elseif($status === 'maintenance') {
                                    $statusClasses = 'text-rose-400 bg-rose-500/10 border-rose-500/20';
                                }
                            @endphp
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full border {{ $statusClasses }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current {{ $status === 'available' ? 'animate-pulse' : '' }}"></span>
                                {{ ucfirst($room->status) }}
                            </span>
                        </div>

                        <!-- Room Title -->
                        <h3 class="font-serif-luxury text-2xl text-white font-medium mb-3 group-hover:text-emerald-400 transition-colors duration-300">
                            {{ $room->room_name }}
                        </h3>

                        <!-- Attributes List -->
                        <div class="space-y-2 border-t border-slate-800/60 pt-4 mb-5">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-400">Giá phòng</span>
                                <span class="text-emerald-400 font-bold text-sm tracking-wide">{{ number_format($room->price) }} VND <span class="text-slate-500 font-normal">/ đêm</span></span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-400">Sức chứa tối đa</span>
                                <span class="text-slate-200 font-medium">{{ $room->capacity }} khách</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA Action Button -->
                <div class="px-2 pt-2">
                    <a 
                        href="{{ route('rooms.show', $room) }}" 
                        class="block w-full border border-slate-700 group-hover:border-emerald-500/40 bg-slate-950/40 hover:bg-emerald-600 text-slate-300 hover:text-white text-center font-semibold py-3.5 px-6 rounded-2xl transition-all duration-300 text-sm"
                    >
                        Trải nghiệm chi tiết
                    </a>
                </div>

            </div>

        @empty
            <!-- Beautiful Empty State -->
            <div class="col-span-full py-16 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-900 border border-slate-800 text-slate-500 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-serif-luxury text-2xl text-white font-semibold mb-2">Không tìm thấy phòng phù hợp</h3>
                <p class="text-slate-400 text-sm max-w-md mx-auto">Vui lòng thay đổi từ khóa tìm kiếm hoặc các tiêu chí bộ lọc của bạn.</p>
            </div>
        @endforelse

    </div>

    <!-- ELITE PAGINATION CONTAINER (Wrapped creatively for Dark Mode alignment) -->
    @if($rooms->hasPages())
        <div class="mt-16 p-6 rounded-3xl bg-slate-950/20 border border-slate-800/40 flex justify-center">
            <div class="text-slate-300 luxury-pagination">
                {{ $rooms->links() }}
            </div>
        </div>
    @endif

</div>

<!-- PRESERVED JAVASCRIPT LOGIC WITHOUT MODIFICATION -->
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

</body>
</html>