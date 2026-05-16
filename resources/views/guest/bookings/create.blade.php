<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">

    <title>Đặt phòng</title>

    <style>

        body{
            font-family:Arial, sans-serif;
            background:#f5f6fa;
            padding:40px;
        }

        .card{
            max-width:700px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:12px;
        }

        input,
        textarea{
            width:100%;
            padding:12px;
            margin-top:8px;
            margin-bottom:20px;
        }

        button{
            padding:12px 20px;
            border:none;
            background:#16a34a;
            color:white;
            border-radius:8px;
            cursor:pointer;
        }

    </style>

</head>

<body>

<div class="card">

    <h1>
        Đặt phòng:
        {{ $room->room_name }}
    </h1>

    <br>

    @if($errors->any())

        <div style="color:red; margin-bottom:20px;">

            @foreach($errors->all() as $error)

                <p>{{ $error }}</p>

            @endforeach

        </div>

    @endif

    <form
        method="POST"
        action="{{ route('guest.bookings.store', $room) }}"
    >

        @csrf

        <label>
            Ngày nhận phòng
        </label>

        <input
            type="date"
            name="check_in_date"
            required
        >

        <label>
            Ngày trả phòng
        </label>

        <input
            type="date"
            name="check_out_date"
            required
        >

        <label>
            Số khách
        </label>

        <input
            type="number"
            name="guest_count"
            min="1"
            max="{{ $room->capacity }}"
            required
        >

        <label>
            Tên liên hệ
        </label>

        <input
            type="text"
            name="contact_name"
            value="{{ Auth::user()->full_name }}"
            required
        >

        <label>
            Số điện thoại
        </label>

        <input
            type="text"
            name="contact_phone"
            required
        >

        <label>
            Email
        </label>

        <input
            type="email"
            name="contact_email"
            value="{{ Auth::user()->email }}"
        >

        <label>
            Ghi chú
        </label>

        <textarea
            name="note"
            rows="4"
        ></textarea>

        <button type="submit">
            Xác nhận đặt phòng
        </button>

    </form>

</div>

</body>

</html>