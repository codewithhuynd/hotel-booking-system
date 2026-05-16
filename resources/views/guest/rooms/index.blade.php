<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">

    <title>
        Danh sách phòng
    </title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Arial, sans-serif;
            background:#f5f6fa;
            padding:40px;
        }

        .container{
            max-width:1200px;
            margin:auto;
        }

        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        .room-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));
            gap:20px;
        }

        .room-card{
            background:white;
            padding:20px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
        }

        .room-card h3{
            margin-bottom:10px;
        }

        .room-card p{
            margin-bottom:8px;
        }

        .btn{
            display:inline-block;
            padding:10px 16px;
            background:#2563eb;
            color:white;
            text-decoration:none;
            border-radius:8px;
        }

        .search-box{
            background:white;
            padding:20px;
            border-radius:12px;
            margin-bottom:30px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
        }

        input{
            padding:10px;
            width:100%;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:8px;
        }

        button{
            padding:10px 16px;
            border:none;
            border-radius:8px;
            background:#1e293b;
            color:white;
            cursor:pointer;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="top-bar">

        <h1>
            Danh sách phòng
        </h1>

        <a
            href="{{ route('home') }}"
            class="btn"
        >
            Trang chủ
        </a>

    </div>

    <!-- SEARCH -->

    <div class="search-box">

        <form method="GET">

            <input
                type="text"
                name="keyword"
                placeholder="Tìm theo tên phòng..."
                value="{{ request('keyword') }}"
            >

            <input
                type="number"
                name="min_price"
                placeholder="Giá tối thiểu"
                value="{{ request('min_price') }}"
            >

            <input
                type="number"
                name="max_price"
                placeholder="Giá tối đa"
                value="{{ request('max_price') }}"
            >

            <button type="submit">
                Tìm kiếm
            </button>

        </form>

    </div>

    <!-- ROOM LIST -->

    <div class="room-grid">

        @forelse($rooms as $room)

            <div class="room-card">

                <h3>
                    {{ $room->room_name }}
                </h3>

                <p>

                    <strong>
                        Mã phòng:
                    </strong>

                    {{ $room->room_code }}

                </p>

                <p>

                    <strong>
                        Giá:
                    </strong>

                    {{ number_format($room->price) }}
                    VND

                </p>

                <p>

                    <strong>
                        Sức chứa:
                    </strong>

                    {{ $room->capacity }}
                    người

                </p>

                <p>

                    <strong>
                        Trạng thái:
                    </strong>

                    {{ ucfirst($room->status) }}

                </p>

                <br>

                <a
                    href="{{ route('rooms.show', $room) }}"
                    class="btn"
                >
                    Xem chi tiết
                </a>

            </div>

        @empty

            <p>
                Không có phòng nào.
            </p>

        @endforelse

    </div>

    <br><br>

    {{ $rooms->links() }}

</div>

</body>

</html>