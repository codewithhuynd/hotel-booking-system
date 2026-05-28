@extends('host.layouts.app')

@section('title', 'Thêm phòng mới')

@section('content')

<div style="font-family: 'Segoe UI', sans-serif; padding: 24px; color: #0f172a; max-width: 850px; margin: 0 auto;">

    <!-- HEADER -->
    <div style="
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    ">

        <div>

            <p style="
                font-size: 13px;
                color: #64748b;
                margin-bottom: 6px;
            ">
                Quản lý hệ thống phòng khách sạn
            </p>

            <h1 style="
                font-size: 32px;
                font-weight: 700;
                margin: 0;
                color: #0f172a;
            ">
                Thêm phòng mới
            </h1>

        </div>

        <a href="{{ route('host.rooms.index') }}"
           style="
                color: #2563eb;
                text-decoration: none;
                font-weight: 600;
                font-size: 14px;
                display: flex;
                align-items: center;
                gap: 8px;
                background: #eff6ff;
                padding: 12px 16px;
                border-radius: 14px;
                transition: .2s;
           ">

            <i class="fa-solid fa-arrow-left"></i>

            Quay lại danh sách

        </a>

    </div>

    <!-- ERROR MESSAGE -->
    @if($errors->any())

        <div style="
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 18px 20px;
            border-radius: 18px;
            margin-bottom: 24px;
            font-size: 14px;
        ">

            <div style="
                display: flex;
                align-items: center;
                gap: 10px;
                font-weight: 700;
                margin-bottom: 10px;
            ">

                <i class="fa-solid fa-circle-exclamation"></i>

                Vui lòng kiểm tra lại thông tin

            </div>

            <ul style="
                margin: 0;
                padding-left: 22px;
                line-height: 1.8;
            ">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- FORM -->
    <form method="POST"
          action="{{ route('host.rooms.store') }}"
          style="
                background: white;
                border-radius: 28px;
                padding: 34px;
                border: 1px solid #e2e8f0;
                box-shadow: 0 12px 40px rgba(15,23,42,0.06);
          ">

        @csrf

        <!-- ROOM CODE & NAME -->
        <div style="
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px,1fr));
            gap: 24px;
            margin-bottom: 24px;
        ">

            <!-- ROOM CODE -->
            <div>

                <label style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    font-size: 14px;
                    font-weight: 700;
                    color: #334155;
                    margin-bottom: 10px;
                ">

                    <i class="fa-solid fa-hashtag" style="color:#2563eb;"></i>

                    Mã phòng

                </label>

                <input type="text"
                       name="room_code"
                       value="{{ old('room_code') }}"
                       placeholder="Ví dụ: R-101"
                       style="
                            width: 100%;
                            padding: 14px 16px;
                            border: 1px solid #cbd5e1;
                            border-radius: 16px;
                            font-size: 14px;
                            box-sizing: border-box;
                            color: #0f172a;
                            outline: none;
                            transition: .2s;
                       ">

            </div>

            <!-- ROOM NAME -->
            <div>

                <label style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    font-size: 14px;
                    font-weight: 700;
                    color: #334155;
                    margin-bottom: 10px;
                ">

                    <i class="fa-solid fa-bed" style="color:#0f172a;"></i>

                    Tên phòng

                </label>

                <input type="text"
                       name="room_name"
                       value="{{ old('room_name') }}"
                       placeholder="Ví dụ: Suite cao cấp"
                       style="
                            width: 100%;
                            padding: 14px 16px;
                            border: 1px solid #cbd5e1;
                            border-radius: 16px;
                            font-size: 14px;
                            box-sizing: border-box;
                            color: #0f172a;
                            outline: none;
                            transition: .2s;
                       ">

            </div>

        </div>

        <!-- DESCRIPTION -->
        <div style="margin-bottom: 24px;">

            <label style="
                display: flex;
                align-items: center;
                gap: 8px;
                font-size: 14px;
                font-weight: 700;
                color: #334155;
                margin-bottom: 10px;
            ">

                <i class="fa-solid fa-align-left" style="color:#7c3aed;"></i>

                Mô tả phòng

            </label>

            <textarea
                name="description"
                placeholder="Nhập mô tả chi tiết về phòng, hướng nhìn, loại giường, tiện nghi..."
                style="
                    width: 100%;
                    min-height: 140px;
                    padding: 16px;
                    border: 1px solid #cbd5e1;
                    border-radius: 18px;
                    font-size: 14px;
                    color: #0f172a;
                    resize: vertical;
                    font-family: 'Segoe UI', sans-serif;
                    outline: none;
                    box-sizing: border-box;
                ">{{ old('description') }}</textarea>

        </div>

        <!-- PRICE / CAPACITY / STATUS -->
        <div style="
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
            gap: 24px;
            margin-bottom: 32px;
        ">

            <!-- PRICE -->
            <div>

                <label style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    font-size: 14px;
                    font-weight: 700;
                    color: #334155;
                    margin-bottom: 10px;
                ">

                    <i class="fa-solid fa-money-bill-wave" style="color:#059669;"></i>

                    Giá phòng (VNĐ)

                </label>

                <input type="number"
                       name="price"
                       value="{{ old('price') }}"
                       placeholder="Nhập giá phòng"
                       style="
                            width: 100%;
                            padding: 14px 16px;
                            border: 1px solid #cbd5e1;
                            border-radius: 16px;
                            font-size: 14px;
                            box-sizing: border-box;
                            color: #0f172a;
                            outline: none;
                       ">

            </div>

            <!-- CAPACITY -->
            <div>

                <label style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    font-size: 14px;
                    font-weight: 700;
                    color: #334155;
                    margin-bottom: 10px;
                ">

                    <i class="fa-solid fa-users" style="color:#ea580c;"></i>

                    Sức chứa

                </label>

                <input type="number"
                       name="capacity"
                       value="{{ old('capacity') }}"
                       placeholder="Số lượng khách"
                       style="
                            width: 100%;
                            padding: 14px 16px;
                            border: 1px solid #cbd5e1;
                            border-radius: 16px;
                            font-size: 14px;
                            box-sizing: border-box;
                            color: #0f172a;
                            outline: none;
                       ">

            </div>

            <!-- STATUS -->
            <div>

                <label style="
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    font-size: 14px;
                    font-weight: 700;
                    color: #334155;
                    margin-bottom: 10px;
                ">

                    <i class="fa-solid fa-circle-check" style="color:#2563eb;"></i>

                    Trạng thái

                </label>

                <select name="status"
                        style="
                            width: 100%;
                            padding: 14px 16px;
                            border: 1px solid #cbd5e1;
                            border-radius: 16px;
                            font-size: 14px;
                            color: #0f172a;
                            background: white;
                            outline: none;
                            height: 52px;
                        ">

                    <option value="available">Sẵn sàng</option>

                    <option value="booked">Đã đặt</option>

                    <option value="occupied">Đang sử dụng</option>

                    <option value="cleaning">Đang dọn dẹp</option>

                </select>

            </div>

        </div>

        <!-- ACTION BUTTON -->
        <div style="
            display: flex;
            gap: 14px;
            align-items: center;
            flex-wrap: wrap;
        ">

            <button type="submit"
                    style="
                        background: linear-gradient(135deg,#2563eb,#1d4ed8);
                        color: white;
                        border: none;
                        padding: 14px 24px;
                        border-radius: 16px;
                        font-size: 14px;
                        font-weight: 700;
                        cursor: pointer;
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        box-shadow: 0 10px 25px rgba(37,99,235,0.25);
                    ">

                <i class="fa-solid fa-plus"></i>

                Tạo phòng mới

            </button>

            <a href="{{ route('host.rooms.index') }}"
               style="
                    text-decoration: none;
                    color: #475569;
                    font-size: 14px;
                    font-weight: 600;
                    padding: 14px 18px;
                    border-radius: 16px;
                    border: 1px solid #cbd5e1;
                    background: white;
                    display: flex;
                    align-items: center;
                    gap: 8px;
               ">

                <i class="fa-solid fa-xmark"></i>

                Hủy bỏ

            </a>

        </div>

    </form>

</div>

@endsection