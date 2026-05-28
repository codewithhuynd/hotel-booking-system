@extends('host.layouts.app')

@section('title', 'Quản lý phòng')

@section('content')

<div style="font-family: 'Segoe UI', sans-serif; padding: 24px; color: #0f172a;">

    <!-- HEADER -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">

        <div>
            <p style="font-size: 13px; color: #64748b; margin-bottom: 6px;">
                Quản lý hệ thống phòng khách sạn
            </p>

            <h1 style="font-size: 30px; font-weight: 700; margin: 0; color: #0f172a;">
                Danh sách phòng
            </h1>
        </div>

        <a href="{{ route('host.rooms.create') }}"
           style="
                background: linear-gradient(135deg,#2563eb,#1d4ed8);
                color: white;
                text-decoration: none;
                padding: 12px 18px;
                border-radius: 14px;
                font-size: 14px;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 10px;
                box-shadow: 0 10px 25px rgba(37,99,235,0.25);
                transition: .3s;
           ">

            <i class="fa-solid fa-plus"></i>

            Thêm phòng mới
        </a>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))

        <div style="
            padding: 16px 18px;
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
            border-radius: 16px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        ">

            <i class="fa-solid fa-circle-check"></i>

            {{ session('success') }}

        </div>

    @endif

    <!-- TABLE -->
    <div style="
        background: white;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 35px rgba(15,23,42,0.06);
    ">

        <div style="overflow-x: auto;">

            <table style="
                width: 100%;
                border-collapse: collapse;
                min-width: 1100px;
            ">

                <thead>

                    <tr style="
                        background: linear-gradient(to right,#f8fafc,#f1f5f9);
                        border-bottom: 1px solid #e2e8f0;
                    ">

                        <th style="padding: 18px; text-align: left; font-size: 13px; color: #64748b;">
                            ID
                        </th>

                        <th style="padding: 18px; text-align: left; font-size: 13px; color: #64748b;">
                            Mã phòng
                        </th>

                        <th style="padding: 18px; text-align: left; font-size: 13px; color: #64748b;">
                            Tên phòng
                        </th>

                        <th style="padding: 18px; text-align: left; font-size: 13px; color: #64748b;">
                            Giá phòng
                        </th>

                        <th style="padding: 18px; text-align: left; font-size: 13px; color: #64748b;">
                            Sức chứa
                        </th>

                        <th style="padding: 18px; text-align: left; font-size: 13px; color: #64748b;">
                            Trạng thái
                        </th>

                        <th style="padding: 18px; text-align: right; font-size: 13px; color: #64748b;">
                            Thao tác
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($rooms as $room)

                        @php

                            $statusText = 'Không xác định';
                            $statusBg = '#e2e8f0';
                            $statusColor = '#475569';

                            if($room->status === 'available') {
                                $statusText = 'Sẵn sàng';
                                $statusBg = '#dcfce7';
                                $statusColor = '#166534';
                            }

                            if($room->status === 'maintenance') {
                                $statusText = 'Bảo trì';
                                $statusBg = '#fee2e2';
                                $statusColor = '#b91c1c';
                            }

                            if($room->status === 'cleaning') {
                                $statusText = 'Đang dọn';
                                $statusBg = '#fef3c7';
                                $statusColor = '#b45309';
                            }

                            if($room->status === 'booked') {
                                $statusText = 'Đã đặt';
                                $statusBg = '#dbeafe';
                                $statusColor = '#1d4ed8';
                            }

                        @endphp

                        <tr style="
                            border-bottom: 1px solid #f1f5f9;
                            transition: .2s;
                        "
                        onmouseover="this.style.background='#f8fafc'"
                        onmouseout="this.style.background='white'">

                            <!-- ID -->
                            <td style="
                                padding: 18px;
                                color: #64748b;
                                font-size: 14px;
                            ">
                                #{{ $room->id }}
                            </td>

                            <!-- ROOM CODE -->
                            <td style="padding: 18px;">

                                <div style="
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 8px;
                                    background: #eff6ff;
                                    color: #2563eb;
                                    padding: 8px 12px;
                                    border-radius: 999px;
                                    font-size: 13px;
                                    font-weight: 700;
                                ">

                                    <i class="fa-solid fa-hashtag"></i>

                                    {{ $room->room_code }}

                                </div>

                            </td>

                            <!-- ROOM NAME -->
                            <td style="padding: 18px;">

                                <div style="
                                    display: flex;
                                    align-items: center;
                                    gap: 12px;
                                ">

                                    <div style="
                                        width: 42px;
                                        height: 42px;
                                        border-radius: 12px;
                                        background: linear-gradient(135deg,#0f172a,#334155);
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        color: white;
                                        font-size: 16px;
                                    ">
                                        <i class="fa-solid fa-bed"></i>
                                    </div>

                                    <div>

                                        <div style="
                                            font-size: 15px;
                                            font-weight: 700;
                                            color: #0f172a;
                                            margin-bottom: 4px;
                                        ">
                                            {{ $room->room_name }}
                                        </div>

                                        <div style="
                                            font-size: 12px;
                                            color: #64748b;
                                        ">
                                            Phòng khách sạn cao cấp
                                        </div>

                                    </div>

                                </div>

                            </td>

                            <!-- PRICE -->
                            <td style="padding: 18px;">

                                <div style="
                                    font-size: 15px;
                                    font-weight: 700;
                                    color: #059669;
                                ">

                                    {{ number_format($room->price) }} VNĐ

                                </div>

                                <div style="
                                    font-size: 12px;
                                    color: #94a3b8;
                                    margin-top: 4px;
                                ">
                                    / đêm
                                </div>

                            </td>

                            <!-- CAPACITY -->
                            <td style="padding: 18px;">

                                <div style="
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 8px;
                                    color: #334155;
                                    font-weight: 600;
                                    background: #f8fafc;
                                    padding: 8px 12px;
                                    border-radius: 12px;
                                ">

                                    <i class="fa-solid fa-users"></i>

                                    {{ $room->capacity }} người

                                </div>

                            </td>

                            <!-- STATUS -->
                            <td style="padding: 18px;">

                                <span style="
                                    background: {{ $statusBg }};
                                    color: {{ $statusColor }};
                                    padding: 8px 14px;
                                    border-radius: 999px;
                                    font-size: 12px;
                                    font-weight: 700;
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 8px;
                                ">

                                    <span style="
                                        width: 8px;
                                        height: 8px;
                                        border-radius: 50%;
                                        background: {{ $statusColor }};
                                    "></span>

                                    {{ $statusText }}

                                </span>

                            </td>

                            <!-- ACTIONS -->
                            <td style="
                                padding: 18px;
                                text-align: right;
                                white-space: nowrap;
                            ">

                                <div style="
                                    display: flex;
                                    justify-content: flex-end;
                                    gap: 10px;
                                ">

                                    <!-- EDIT -->
                                    <a href="{{ route('host.rooms.edit', $room) }}"
                                       style="
                                            text-decoration: none;
                                            background: #fff7ed;
                                            color: #ea580c;
                                            padding: 10px 14px;
                                            border-radius: 12px;
                                            font-size: 13px;
                                            font-weight: 600;
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 8px;
                                            transition: .2s;
                                       ">

                                        <i class="fa-solid fa-pen"></i>

                                        Chỉnh sửa

                                    </a>

                                    <!-- DELETE -->
                                    <form action="{{ route('host.rooms.destroy', $room) }}"
                                          method="POST"
                                          style="display:inline;"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng này không?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                style="
                                                    border: none;
                                                    background: #fef2f2;
                                                    color: #dc2626;
                                                    padding: 10px 14px;
                                                    border-radius: 12px;
                                                    font-size: 13px;
                                                    font-weight: 600;
                                                    cursor: pointer;
                                                    display: inline-flex;
                                                    align-items: center;
                                                    gap: 8px;
                                                    transition: .2s;
                                                ">

                                            <i class="fa-solid fa-trash"></i>

                                            Xóa

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" style="padding: 60px 20px;">

                                <div style="
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    justify-content: center;
                                    text-align: center;
                                ">

                                    <div style="
                                        width: 90px;
                                        height: 90px;
                                        border-radius: 50%;
                                        background: #f1f5f9;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        margin-bottom: 18px;
                                        color: #94a3b8;
                                        font-size: 34px;
                                    ">

                                        <i class="fa-solid fa-bed"></i>

                                    </div>

                                    <h3 style="
                                        font-size: 20px;
                                        color: #334155;
                                        margin-bottom: 10px;
                                    ">
                                        Chưa có phòng nào
                                    </h3>

                                    <p style="
                                        color: #64748b;
                                        font-size: 14px;
                                        margin-bottom: 20px;
                                    ">
                                        Hiện tại hệ thống chưa có phòng khách sạn nào.
                                    </p>

                                    <a href="{{ route('host.rooms.create') }}"
                                       style="
                                            background: #2563eb;
                                            color: white;
                                            text-decoration: none;
                                            padding: 12px 18px;
                                            border-radius: 12px;
                                            font-size: 14px;
                                            font-weight: 600;
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 10px;
                                       ">

                                        <i class="fa-solid fa-plus"></i>

                                        Thêm phòng đầu tiên

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection