<?php 
use Illuminate\Support\Facades\Auth;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Trang chủ — {{ config('app.name') }}
    </title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Arial, sans-serif;
            background:#f1f5f9;
            color:#1e293b;
        }

        .navbar{
            background:white;
            padding:20px 40px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        .navbar h2{
            color:#2563eb;
        }

        .nav-right{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .container{
            max-width:1200px;
            margin:30px auto;
            padding:20px;
        }

        .hero{
            background:linear-gradient(
                135deg,
                #2563eb,
                #1d4ed8
            );

            color:white;
            padding:60px;
            border-radius:20px;
            margin-bottom:30px;
        }

        .hero h1{
            font-size:42px;
            margin-bottom:15px;
        }

        .hero p{
            font-size:18px;
            opacity:0.95;
        }

        .search-box{
            background:white;
            padding:25px;
            border-radius:20px;
            margin-top:-60px;
            position:relative;
            z-index:10;
            box-shadow:0 5px 25px rgba(0,0,0,0.08);
        }

        .search-grid{
            display:grid;
            grid-template-columns:
                repeat(auto-fit, minmax(180px,1fr));
            gap:15px;
        }

        input,
        select{
            width:100%;
            padding:14px;
            border:1px solid #cbd5e1;
            border-radius:10px;
            font-size:15px;
        }

        input:focus,
        select:focus{
            outline:none;
            border-color:#2563eb;
        }

        .btn{
            display:inline-block;
            padding:12px 18px;
            border:none;
            border-radius:10px;
            text-decoration:none;
            cursor:pointer;
            font-weight:bold;
            color:white;
        }

        .btn-blue{
            background:#2563eb;
        }

        .btn-dark{
            background:#1e293b;
        }

        .btn-green{
            background:#16a34a;
        }

        .btn-red{
            background:#dc2626;
        }

        .rooms-section{
            margin-top:40px;
        }

        .section-title{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
        }

        .room-grid{
            display:grid;
            grid-template-columns:
                repeat(auto-fit, minmax(280px,1fr));
            gap:25px;
        }

        .room-card{
            background:white;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 2px 12px rgba(0,0,0,0.06);
            transition:0.2s;
        }

        .room-card:hover{
            transform:translateY(-4px);
        }

        .room-image{
            width:100%;
            height:220px;
            object-fit:cover;
            background:#e2e8f0;
        }

        .room-content{
            padding:20px;
        }

        .room-content h3{
            margin-bottom:12px;
        }

        .room-content p{
            margin-bottom:10px;
            color:#475569;
        }

        .price{
            font-size:22px;
            font-weight:bold;
            color:#2563eb;
            margin-bottom:15px;
        }

        .status{
            display:inline-block;
            padding:6px 10px;
            border-radius:999px;
            font-size:13px;
            font-weight:bold;
            background:#dcfce7;
            color:#166534;
            margin-bottom:15px;
        }

        .top-buttons{
            display:flex;
            gap:10px;
            flex-wrap:wrap;
        }

        .welcome-box{
            background:white;
            padding:20px;
            border-radius:15px;
            margin-bottom:25px;
            box-shadow:0 2px 8px rgba(0,0,0,0.05);
        }

    </style>
</head>

<body>

<!-- NAVBAR -->

<div class="navbar">

    <h2>
        HOTEL BOOKING
    </h2>

    <div class="nav-right">

        @guest

            <a
                href="{{ route('login') }}"
                class="btn btn-blue"
            >
                Đăng nhập
            </a>

            <a
                href="{{ route('register') }}"
                class="btn btn-green"
            >
                Đăng ký
            </a>

        @else

            <span>
                Xin chào,
                <strong>
                    {{ Auth::user()->full_name }}
                </strong>
            </span>

            @if(Auth::user()->role === 'host')

                <a
                    href="{{ route('host.dashboard') }}"
                    class="btn btn-dark"
                >
                    Host Dashboard
                </a>

            @endif

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="btn btn-red"
                >
                    Đăng xuất
                </button>

            </form>

        @endguest

    </div>

</div>

<div class="container">

    <!-- HERO -->

    <div class="hero">

        <h1>
            Tìm khách sạn phù hợp cho bạn
        </h1>

        <p>
            Đặt phòng nhanh chóng, dễ dàng và tiện lợi
        </p>

    </div>

    <!-- SEARCH -->

    <div class="search-box">

        <form
            method="GET"
            action="{{ route('home') }}"
        >

            <div class="search-grid">

                <!-- SEARCH NAME -->

                <div>

                    <input
                        type="text"
                        name="keyword"
                        placeholder="Tên phòng..."
                        value="{{ request('keyword') }}"
                    >

                </div>

                <!-- PRICE -->

                <div>

                    <select name="price">

                        <option value="">
                            Giá phòng
                        </option>

                        <option
                            value="low"
                            {{ request('price') == 'low' ? 'selected' : '' }}
                        >
                            Dưới 500k
                        </option>

                        <option
                            value="medium"
                            {{ request('price') == 'medium' ? 'selected' : '' }}
                        >
                            500k - 1 triệu
                        </option>

                        <option
                            value="high"
                            {{ request('price') == 'high' ? 'selected' : '' }}
                        >
                            Trên 1 triệu
                        </option>

                    </select>

                </div>

                <!-- CAPACITY -->

                <div>

                    <select name="capacity">

                        <option value="">
                            Sức chứa
                        </option>

                        <option
                            value="1"
                            {{ request('capacity') == '1' ? 'selected' : '' }}
                        >
                            1 người
                        </option>

                        <option
                            value="2"
                            {{ request('capacity') == '2' ? 'selected' : '' }}
                        >
                            2 người
                        </option>

                        <option
                            value="4"
                            {{ request('capacity') == '4' ? 'selected' : '' }}
                        >
                            4+ người
                        </option>

                    </select>

                </div>

                <!-- BUTTON -->

                <div>

                    <button
                        type="submit"
                        class="btn btn-blue"
                        style="width:100%; height:100%;"
                    >
                        Tìm kiếm
                    </button>

                </div>

            </div>

        </form>

    </div>

    <!-- USER INFO -->

    @auth

        <div class="welcome-box">

            <p>

                Email:
                <strong>
                    {{ Auth::user()->email }}
                </strong>

            </p>

            <br>

            <p>

                Vai trò:

                <strong>

                    {{ Auth::user()->role === 'host'
                        ? 'Host'
                        : 'Khách hàng'
                    }}

                </strong>

            </p>

            @if(Auth::user()->role === 'guest')

                <br>

                <div class="top-buttons">

                    <a
                        href="{{ route('guest.bookings.index') }}"
                        class="btn btn-dark"
                    >
                        My Bookings
                    </a>

                    <a
                        href="#"
                        class="btn btn-green"
                    >
                        My Profile
                    </a>

                </div>

            @endif

        </div>

    @endauth

    <!-- ROOM LIST -->

    <div class="rooms-section">

        <div class="section-title">

            <h2>
                Danh sách phòng
            </h2>

            <a
                href="{{ route('rooms.index') }}"
                class="btn btn-dark"
            >
                Xem tất cả
            </a>

        </div>

        <div class="room-grid">

            @forelse($rooms as $room)

                <div class="room-card">

                    @if($room->mainImage)

                        <img
                            src="{{ asset('storage/' . $room->mainImage->image_path) }}"
                            class="room-image"
                            alt="{{ $room->room_name }}"
                        >

                    @else

                        <div class="room-image"></div>

                    @endif

                    <div class="room-content">

                        <h3>
                            {{ $room->room_name }}
                        </h3>

                        <div class="price">

                            {{ number_format($room->price) }}
                            VND

                        </div>

                        <p>

                            <strong>
                                Sức chứa:
                            </strong>

                            {{ $room->capacity }}
                            người

                        </p>

                        <p>

                            <strong>
                                Mã phòng:
                            </strong>

                            {{ $room->room_code }}

                        </p>

                        <div class="status">

                            {{ ucfirst($room->status) }}

                        </div>

                        <br>

                        <a
                            href="{{ route('rooms.show', $room) }}"
                            class="btn btn-blue"
                        >
                            Xem chi tiết
                        </a>

                    </div>

                </div>

            @empty

                <p>
                    Không tìm thấy phòng phù hợp.
                </p>

            @endforelse

        </div>

    </div>

</div>

</body>

</html>