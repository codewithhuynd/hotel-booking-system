<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">

    <title>Danh sách phòng</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            padding: 40px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .room-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .room-card h3 {
            margin-bottom: 10px;
        }

        .room-card p {
            margin-bottom: 8px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .search-box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        input, select {
            padding: 10px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            background: #1e293b;
            color: white;
            cursor: pointer;
        }

        /* IMAGE SLIDER */
        .room-slider {
            position: relative;
            width: 100%;
            height: 200px;
            margin-bottom: 12px;
            border-radius: 10px;
            overflow: hidden;
        }

        .room-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: none;
            background: rgba(0,0,0,0.6);
            color: white;
            cursor: pointer;
        }

        .prev-btn { left: 10px; }
        .next-btn { right: 10px; }
    </style>
</head>

<body>

<div class="container">

    <div class="top-bar">
        <h1>Danh sách phòng</h1>

        <a href="{{ route('home') }}" class="btn">
            Trang chủ
        </a>
    </div>

    <!-- SEARCH -->
    <div class="search-box">

        <form method="GET">

            <input type="text" name="keyword" placeholder="Tên phòng..." value="{{ request('keyword') }}">

            <select name="price">
                <option value="">Tất cả giá</option>
                <option value="low" {{ request('price')=='low'?'selected':'' }}>Dưới 500k</option>
                <option value="medium" {{ request('price')=='medium'?'selected':'' }}>500k - 1 triệu</option>
                <option value="high" {{ request('price')=='high'?'selected':'' }}>Trên 1 triệu</option>
            </select>

            <select name="capacity">
                <option value="">Sức chứa</option>
                <option value="1" {{ request('capacity')==1?'selected':'' }}>1 người</option>
                <option value="2" {{ request('capacity')==2?'selected':'' }}>2 người</option>
                <option value="4" {{ request('capacity')==4?'selected':'' }}>4+ người</option>
            </select>

            <select name="status">
                <option value="">Trạng thái</option>
                <option value="available" {{ request('status')=='available'?'selected':'' }}>Còn trống</option>
                <option value="occupied" {{ request('status')=='occupied'?'selected':'' }}>Đang dùng</option>
                <option value="maintenance" {{ request('status')=='maintenance'?'selected':'' }}>Bảo trì</option>
            </select>

            <select name="sort_price">
                <option value="">Sắp xếp giá</option>
                <option value="asc" {{ request('sort_price')=='asc'?'selected':'' }}>Tăng dần</option>
                <option value="desc" {{ request('sort_price')=='desc'?'selected':'' }}>Giảm dần</option>
            </select>

            <select name="sort_time">
                <option value="latest" {{ request('sort_time')=='latest'?'selected':'' }}>Mới nhất</option>
                <option value="oldest" {{ request('sort_time')=='oldest'?'selected':'' }}>Cũ nhất</option>
            </select>

            <button type="submit">Lọc</button>

        </form>
    </div>

    <!-- DATA FOR JS -->
    @php
        $roomImages = $rooms->mapWithKeys(function ($room) {
            return [
                $room->id => $room->images->pluck('image_path')->values()
            ];
        });
    @endphp

    <!-- ROOM LIST -->
    <div class="room-grid">

        @forelse($rooms as $room)

            <div class="room-card">

                <div class="room-slider">

                    @php
                        $mainImage = $room->mainImage ?? $room->images->first();
                    @endphp

                    @if($mainImage)
                        <img
                            src="{{ asset('storage/'.$mainImage->image_path) }}"
                            class="room-image slide-{{ $room->id }}"
                        >
                    @else
                        <div class="room-image" style="background:#ddd;"></div>
                    @endif

                    @if($room->images->count() > 1)
                        <button class="slider-btn prev-btn" onclick="changeSlide({{ $room->id }}, -1)">‹</button>
                        <button class="slider-btn next-btn" onclick="changeSlide({{ $room->id }}, 1)">›</button>
                    @endif

                </div>

                <h3>{{ $room->room_name }}</h3>

                <p><b>Mã:</b> {{ $room->room_code }}</p>
                <p><b>Giá:</b> {{ number_format($room->price) }} VND</p>
                <p><b>Sức chứa:</b> {{ $room->capacity }}</p>
                <p><b>Trạng thái:</b> {{ ucfirst($room->status) }}</p>

                <br>

                <a href="{{ route('rooms.show', $room) }}" class="btn">
                    Xem chi tiết
                </a>

            </div>

        @empty
            <p>Không có phòng nào</p>
        @endforelse

    </div>

    <br>

    {{ $rooms->links() }}

</div>

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