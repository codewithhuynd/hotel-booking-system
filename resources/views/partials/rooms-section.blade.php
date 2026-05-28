<!-- ROOMS -->
<section class="rooms-section" id="rooms">

    <div class="section-title">
        <div>
            <h2>Phòng</h2>
        </div>
        {{-- Chỉ hiện nút "Xem tất cả" nếu không có bộ lọc nào được áp dụng --}}
        @if (!request()->anyFilled(['keyword', 'price', 'capacity', 'status', 'sort_price', 'sort_time']))
        <a href="{{ route('rooms.index') }}" class="btn btn-white">
            Xem tất cả
        </a>
        @endif
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
