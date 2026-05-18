@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="page-title">
        Tất cả phòng
    </h1>

    <div class="room-grid">

        @foreach($rooms as $room)

        <div class="room-card">

            @if($room->mainImage)

            <img
                src="{{ asset('storage/' . $room->mainImage->image_path) }}"
                class="room-image">

            @endif

            <div class="room-content">

                <h3>
                    {{ $room->room_name }}
                </h3>

                <div class="price">
                    {{ number_format($room->price) }} VND
                </div>

                <p>
                    Sức chứa:
                    {{ $room->capacity }} người
                </p>

                <a
                    href="{{ route('rooms.show', $room) }}"
                    class="btn btn-dark">
                    Xem chi tiết
                </a>

            </div>

        </div>

        @endforeach

    </div>

    <div style="margin-top:40px;">
        {{ $rooms->links() }}
    </div>

</div>

@endsection