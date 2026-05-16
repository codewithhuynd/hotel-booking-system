use Illuminate\Support\Facades\Auth;
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">

    <title>
        {{ $room->room_name }}
    </title>

    <style>

        body{
            font-family:Arial, sans-serif;
            background:#f5f6fa;
            padding:40px;
        }

        .card{
            background:white;
            max-width:700px;
            margin:auto;
            padding:30px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
        }

        .btn{
            display:inline-block;
            padding:10px 18px;
            background:#2563eb;
            color:white;
            text-decoration:none;
            border-radius:8px;
        }

        img{
            width:100%;
            border-radius:10px;
            margin-bottom:20px;
        }

    </style>

</head>

<body>

<div class="card">

    <h1>
        {{ $room->room_name }}
    </h1>

    <br>

    @if($room->mainImage)

        <img
            src="{{ asset('storage/' . $room->mainImage->image_path) }}"
            alt="{{ $room->room_name }}"
        >

    @endif

    <p>

        <strong>
            Mã phòng:
        </strong>

        {{ $room->room_code }}

    </p>

    <br>

    <p>

        <strong>
            Giá:
        </strong>

        {{ number_format($room->price) }}
        VND

    </p>

    <br>

    <p>

        <strong>
            Sức chứa:
        </strong>

        {{ $room->capacity }}
        người

    </p>

    <br>

    <p>

        <strong>
            Trạng thái:
        </strong>

        {{ ucfirst($room->status) }}

    </p>

    <br>

    <p>

        <strong>
            Mô tả:
        </strong>

    </p>

    <br>

    <p>
        {{ $room->description }}
    </p>

    <br><br>

@if(
    Auth::check()
    && Auth::user()->role === 'guest'
)

    <a
        href="{{ route('guest.bookings.create', $room) }}"
        style="
            display:inline-block;
            padding:12px 20px;
            background:#16a34a;
            color:white;
            text-decoration:none;
            border-radius:8px;
            margin-right:10px;
        "
    >
        Đặt phòng
    </a>

@endif

<a
    href="{{ route('rooms.index') }}"
    class="btn"
>
    ← Quay lại danh sách phòng
</a>

</div>

</body>

</html>