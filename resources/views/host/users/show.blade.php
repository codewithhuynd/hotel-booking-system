@extends('host.layouts.app')

@section('title', 'Chi tiết người dùng')

@section('content')

<div style="
    font-family:'Segoe UI', sans-serif;
">

    <!-- HEADER -->
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:16px;
        margin-bottom:28px;
        flex-wrap:wrap;
    ">

        <div>

            <p style="
                font-size:12px;
                text-transform:uppercase;
                letter-spacing:2px;
                color:#16a34a;
                font-weight:700;
                margin-bottom:6px;
            ">
                Quản lý người dùng
            </p>

            <h1 style="
                font-size:36px;
                font-weight:800;
                color:#0f172a;
                line-height:1.2;
            ">
                Chi tiết người dùng
            </h1>

        </div>

        <a href="{{ route('host.users.index') }}"
            style="
                display:inline-flex;
                align-items:center;
                gap:10px;
                padding:14px 18px;
                border-radius:16px;
                background:white;
                border:1px solid #e2e8f0;
                color:#334155;
                text-decoration:none;
                font-size:14px;
                font-weight:700;
                transition:0.25s ease;
                box-shadow:0 8px 20px rgba(15,23,42,0.05);
            "
            onmouseover="this.style.transform='translateY(-2px)'"
            onmouseout="this.style.transform='translateY(0)'">

            ← Quay lại danh sách

        </a>

    </div>

    <!-- USER INFO CARD -->
    <div style="
        background:white;
        border-radius:30px;
        overflow:hidden;
        border:1px solid #e2e8f0;
        box-shadow:0 20px 45px rgba(15,23,42,0.06);
        margin-bottom:30px;
    ">

        <!-- TOP -->
        <div style="
            padding:32px;
            border-bottom:1px solid #f1f5f9;
            background:linear-gradient(to right,#ffffff,#f8fafc);
        ">

            <div style="
                display:flex;
                align-items:center;
                gap:20px;
                flex-wrap:wrap;
            ">

                <div style="
                    width:80px;
                    height:80px;
                    border-radius:24px;
                    background:linear-gradient(135deg,#16a34a,#22c55e);
                    color:white;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:32px;
                    font-weight:800;
                    box-shadow:0 18px 35px rgba(34,197,94,0.2);
                ">
                    {{ strtoupper(substr($user->full_name, 0, 1)) }}
                </div>

                <div>

                    <h2 style="
                        font-size:30px;
                        font-weight:800;
                        color:#0f172a;
                        margin-bottom:6px;
                    ">
                        {{ $user->full_name }}
                    </h2>

                    <p style="
                        color:#64748b;
                        font-size:15px;
                        margin-bottom:10px;
                    ">
                        {{ $user->email }}
                    </p>

                    @php
                        $roleText = 'Khách hàng';
                        $roleBg = '#dcfce7';
                        $roleColor = '#166534';

                        if($user->role === 'host') {
                            $roleText = 'Quản trị viên';
                            $roleBg = '#dbeafe';
                            $roleColor = '#1d4ed8';
                        }
                    @endphp

                    <span style="
                        display:inline-flex;
                        align-items:center;
                        gap:8px;
                        padding:10px 14px;
                        border-radius:999px;
                        background:{{ $roleBg }};
                        color:{{ $roleColor }};
                        font-size:13px;
                        font-weight:700;
                    ">

                        <span style="
                            width:8px;
                            height:8px;
                            border-radius:999px;
                            background:{{ $roleColor }};
                        "></span>

                        {{ $roleText }}

                    </span>

                </div>

            </div>

        </div>

        <!-- DETAILS -->
        <div style="
            padding:32px;
        ">

            <div style="
                display:grid;
                grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
                gap:24px;
            ">

                <!-- NAME -->
                <div style="
                    padding:24px;
                    border-radius:22px;
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                ">

                    <p style="
                        font-size:12px;
                        text-transform:uppercase;
                        letter-spacing:1px;
                        color:#64748b;
                        font-weight:700;
                        margin-bottom:10px;
                    ">
                        👤 Họ và tên
                    </p>

                    <h3 style="
                        font-size:18px;
                        color:#0f172a;
                        font-weight:700;
                    ">
                        {{ $user->full_name }}
                    </h3>

                </div>

                <!-- EMAIL -->
                <div style="
                    padding:24px;
                    border-radius:22px;
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                ">

                    <p style="
                        font-size:12px;
                        text-transform:uppercase;
                        letter-spacing:1px;
                        color:#64748b;
                        font-weight:700;
                        margin-bottom:10px;
                    ">
                        📧 Địa chỉ email
                    </p>

                    <h3 style="
                        font-size:18px;
                        color:#0f172a;
                        font-weight:700;
                        word-break:break-word;
                    ">
                        {{ $user->email }}
                    </h3>

                </div>

                <!-- PHONE -->
                <div style="
                    padding:24px;
                    border-radius:22px;
                    background:#f8fafc;
                    border:1px solid #e2e8f0;
                ">

                    <p style="
                        font-size:12px;
                        text-transform:uppercase;
                        letter-spacing:1px;
                        color:#64748b;
                        font-weight:700;
                        margin-bottom:10px;
                    ">
                        📞 Số điện thoại
                    </p>

                    <h3 style="
                        font-size:18px;
                        color:#0f172a;
                        font-weight:700;
                    ">
                        {{ $user->phone ?: 'Chưa cập nhật' }}
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- BOOKING HEADER -->
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:18px;
        flex-wrap:wrap;
        gap:12px;
    ">

        <div>

            <h2 style="
                font-size:28px;
                font-weight:800;
                color:#0f172a;
                margin-bottom:4px;
            ">
                Lịch sử đặt phòng
            </h2>

            <p style="
                color:#64748b;
                font-size:14px;
            ">
                Theo dõi toàn bộ đơn đặt phòng của người dùng này.
            </p>

        </div>

        <div style="
            background:white;
            border:1px solid #e2e8f0;
            padding:14px 18px;
            border-radius:18px;
            box-shadow:0 8px 20px rgba(15,23,42,0.05);
        ">

            <p style="
                font-size:12px;
                color:#64748b;
                margin-bottom:4px;
            ">
                Tổng đơn đặt phòng
            </p>

            <h3 style="
                font-size:24px;
                font-weight:800;
                color:#0f172a;
            ">
                {{ $bookings->count() }}
            </h3>

        </div>

    </div>

    @if($bookings->isEmpty())

    <!-- EMPTY -->
    <div style="
        background:white;
        border:2px dashed #cbd5e1;
        border-radius:30px;
        padding:60px 30px;
        text-align:center;
        color:#64748b;
    ">

        <div style="
            font-size:56px;
            margin-bottom:18px;
        ">
            🏨
        </div>

        <h3 style="
            font-size:24px;
            font-weight:800;
            color:#0f172a;
            margin-bottom:10px;
        ">
            Chưa có đơn đặt phòng
        </h3>

        <p style="
            font-size:15px;
            max-width:420px;
            margin:auto;
            line-height:1.7;
        ">
            Người dùng này hiện chưa thực hiện bất kỳ đơn đặt phòng nào trên hệ thống.
        </p>

    </div>

    @else

    <!-- TABLE -->
    <div style="
        background:white;
        border-radius:30px;
        overflow:hidden;
        border:1px solid #e2e8f0;
        box-shadow:0 20px 45px rgba(15,23,42,0.06);
    ">

        <div style="overflow-x:auto;">

            <table style="
                width:100%;
                border-collapse:collapse;
                min-width:1100px;
            ">

                <thead>

                    <tr style="
                        background:#f8fafc;
                        border-bottom:1px solid #e2e8f0;
                    ">

                        <th style="padding:18px 22px; text-align:left; font-size:13px; color:#64748b; font-weight:700;">
                            ID
                        </th>

                        <th style="padding:18px 22px; text-align:left; font-size:13px; color:#64748b; font-weight:700;">
                            Phòng
                        </th>

                        <th style="padding:18px 22px; text-align:left; font-size:13px; color:#64748b; font-weight:700;">
                            Ngày nhận phòng
                        </th>

                        <th style="padding:18px 22px; text-align:left; font-size:13px; color:#64748b; font-weight:700;">
                            Ngày trả phòng
                        </th>

                        <th style="padding:18px 22px; text-align:left; font-size:13px; color:#64748b; font-weight:700;">
                            Trạng thái
                        </th>

                        <th style="padding:18px 22px; text-align:left; font-size:13px; color:#64748b; font-weight:700;">
                            Tổng tiền
                        </th>

                        <th style="padding:18px 22px; text-align:left; font-size:13px; color:#64748b; font-weight:700;">
                            Thời gian đặt
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($bookings as $booking)

                    @php

                    $statusText = 'Chờ xác nhận';
                    $statusBg = '#fef3c7';
                    $statusColor = '#92400e';

                    if($booking->status === 'confirmed') {
                        $statusText = 'Đã xác nhận';
                        $statusBg = '#dcfce7';
                        $statusColor = '#166534';
                    }

                    if($booking->status === 'checked_in') {
                        $statusText = 'Đã nhận phòng';
                        $statusBg = '#dbeafe';
                        $statusColor = '#1d4ed8';
                    }

                    if($booking->status === 'checked_out') {
                        $statusText = 'Đã trả phòng';
                        $statusBg = '#ede9fe';
                        $statusColor = '#6d28d9';
                    }

                    if($booking->status === 'completed') {
                        $statusText = 'Hoàn thành';
                        $statusBg = '#dcfce7';
                        $statusColor = '#166534';
                    }

                    if($booking->status === 'cancelled') {
                        $statusText = 'Đã hủy';
                        $statusBg = '#fee2e2';
                        $statusColor = '#b91c1c';
                    }

                    @endphp

                    <tr style="
                        border-bottom:1px solid #f1f5f9;
                        transition:0.25s ease;
                    "
                    onmouseover="this.style.background='#f8fafc'"
                    onmouseout="this.style.background='white'">

                        <!-- ID -->
                        <td style="
                            padding:22px;
                            color:#64748b;
                            font-weight:700;
                        ">
                            #{{ $booking->id }}
                        </td>

                        <!-- ROOM -->
                        <td style="
                            padding:22px;
                            font-weight:700;
                            color:#0f172a;
                        ">
                            🛏 {{ $booking->room->room_name ?? 'Không có dữ liệu' }}
                        </td>

                        <!-- CHECKIN -->
                        <td style="
                            padding:22px;
                            color:#334155;
                            font-weight:500;
                        ">
                            {{ $booking->check_in_date }}
                        </td>

                        <!-- CHECKOUT -->
                        <td style="
                            padding:22px;
                            color:#334155;
                            font-weight:500;
                        ">
                            {{ $booking->check_out_date }}
                        </td>

                        <!-- STATUS -->
                        <td style="padding:22px;">

                            <span style="
                                display:inline-flex;
                                align-items:center;
                                gap:8px;
                                padding:10px 14px;
                                border-radius:999px;
                                background:{{ $statusBg }};
                                color:{{ $statusColor }};
                                font-size:13px;
                                font-weight:700;
                            ">

                                <span style="
                                    width:8px;
                                    height:8px;
                                    border-radius:999px;
                                    background:{{ $statusColor }};
                                "></span>

                                {{ $statusText }}

                            </span>

                        </td>

                        <!-- TOTAL -->
                        <td style="
                            padding:22px;
                            color:#16a34a;
                            font-weight:800;
                            font-size:15px;
                        ">
                            {{ number_format($booking->total_price) }} VNĐ
                        </td>

                        <!-- BOOKED -->
                        <td style="
                            padding:22px;
                            color:#64748b;
                            font-size:13px;
                            font-weight:500;
                        ">
                            {{ $booking->booked_at }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    @endif

</div>

@endsection