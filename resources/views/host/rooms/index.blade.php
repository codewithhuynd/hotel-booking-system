@extends('host.layouts.app')

@section('title', 'Quản lý phòng')

@section('content')

<div style="max-width:1100px;margin:0 auto;padding:20px;font-family:system-ui;color:#1e293b;">

    <!-- HEADER -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">

        <div>
            <p style="font-size:12px;color:#16a34a;font-weight:700;margin-bottom:6px;">
                Quản lý khách sạn
            </p>
            <h1 style="font-size:28px;font-weight:800;color:#0f172a;margin:0;">
                Danh sách phòng
            </h1>
        </div>

        <a href="{{ route('host.rooms.create') }}"
           style="background:#16a34a;color:white;text-decoration:none;padding:10px 14px;border-radius:8px;font-weight:700;font-size:13px;">
            + Thêm phòng
        </a>

    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div style="padding:14px 16px;background:#f0fdf4;border-left:4px solid #16a34a;border-radius:8px;margin-bottom:18px;color:#166534;font-weight:600;">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">

        <table style="width:100%;border-collapse:collapse;min-width:1000px;">

            <thead>
                <tr style="background:#1e293b;color:#fff;">
                    <th style="padding:14px;text-align:left;">ID</th>
                    <th style="padding:14px;text-align:left;">Mã phòng</th>
                    <th style="padding:14px;text-align:left;">Tên phòng</th>
                    <th style="padding:14px;text-align:left;">Giá</th>
                    <th style="padding:14px;text-align:left;">Sức chứa</th>
                    <th style="padding:14px;text-align:left;">Trạng thái</th>
                    <th style="padding:14px;text-align:right;">Thao tác</th>
                </tr>
            </thead>

            <tbody>

                @foreach($rooms as $room)

                @php
                    $statusText = 'Không rõ';
                    $statusBg = '#e2e8f0';
                    $statusColor = '#475569';

                    if($room->status === 'available'){
                        $statusText = 'Sẵn sàng';
                        $statusBg = '#dcfce7';
                        $statusColor = '#166534';
                    }

                    if($room->status === 'maintenance'){
                        $statusText = 'Bảo trì';
                        $statusBg = '#fee2e2';
                        $statusColor = '#b91c1c';
                    }

                    if($room->status === 'cleaning'){
                        $statusText = 'Dọn phòng';
                        $statusBg = '#fef3c7';
                        $statusColor = '#b45309';
                    }

                    if($room->status === 'booked'){
                        $statusText = 'Đã đặt';
                        $statusBg = '#dbeafe';
                        $statusColor = '#1d4ed8';
                    }
                @endphp

                <tr style="border-bottom:1px solid #f1f5f9;">

                    <td style="padding:14px;color:#64748b;">#{{ $room->id }}</td>

                    <td style="padding:14px;font-weight:700;color:#2563eb;">
                        {{ $room->room_code }}
                    </td>

                    <td style="padding:14px;font-weight:700;">
                        {{ $room->room_name }}
                    </td>

                    <td style="padding:14px;color:#16a34a;font-weight:700;">
                        {{ number_format($room->price) }} VNĐ
                    </td>

                    <td style="padding:14px;">
                        {{ $room->capacity }} người
                    </td>

                    <td style="padding:14px;">
                        <span style="background:{{ $statusBg }};color:{{ $statusColor }};padding:6px 10px;border-radius:999px;font-size:12px;font-weight:700;">
                            {{ $statusText }}
                        </span>
                    </td>

                    <td style="padding:14px;text-align:right;white-space:nowrap;">

                        <a href="{{ route('host.rooms.edit', $room) }}"
                           style="background:#fff7ed;color:#ea580c;padding:6px 10px;border-radius:8px;text-decoration:none;font-weight:700;font-size:12px;">
                            Sửa
                        </a>

                        <form method="POST" action="{{ route('host.rooms.destroy', $room) }}" style="display:inline;">
                            @csrf @method('DELETE')

                            <button onclick="return confirm('Xóa phòng?')"
                                style="margin-left:6px;background:#fef2f2;color:#dc2626;border:none;padding:6px 10px;border-radius:8px;font-weight:700;font-size:12px;cursor:pointer;">
                                Xóa
                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection