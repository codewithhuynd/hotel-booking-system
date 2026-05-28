@extends('host.layouts.app')

@section('title', 'Quản lý đặt phòng')

@section('content')

<style>
    .bookings-container{
        font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
        max-width: 1100px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
    }

    .page-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
    }

    .page-header h1{
        font-size:1.75rem;
        font-weight:700;
        margin:0;
        color:#0f172a;
    }

    .alert-success{
        padding:12px 16px;
        background:#f0fdf4;
        border-left:4px solid #16a34a;
        color:#166534;
        border-radius:8px;
        margin-bottom:16px;
        font-size:14px;
        font-weight:500;
    }

    .table-wrapper{
        background:white;
        border-radius:12px;
        border:1px solid #e2e8f0;
        overflow-x:auto;
        box-shadow:0 1px 3px rgba(0,0,0,0.05);
    }

    table{
        width:100%;
        border-collapse:collapse;
        min-width:1100px;
    }

    thead th{
        background:#1e293b;
        color:white;
        padding:14px 16px;
        font-size:13px;
        text-transform:uppercase;
        letter-spacing:0.05em;
        text-align:left;
    }

    tbody td{
        padding:16px;
        border-bottom:1px solid #f1f5f9;
        color:#334155;
        vertical-align:middle;
    }

    tbody tr:hover td{
        background:#f8fafc;
    }

    .status{
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:6px 10px;
        border-radius:999px;
        font-size:12px;
        font-weight:700;
        white-space:nowrap;
    }

    .actions{
        display:flex;
        justify-content:flex-end;
        white-space:nowrap;
    }

    .btn-view{
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:8px 12px;
        border-radius:8px;
        background:#eff6ff;
        color:#2563eb;
        text-decoration:none;
        font-size:13px;
        font-weight:700;
        white-space:nowrap;
    }

</style>

<div class="bookings-container">

    <!-- HEADER -->
    <div class="page-header">
        <h1>Quản lý đặt phòng</h1>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    <div class="table-wrapper">
        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã đặt phòng</th>
                    <th>Khách hàng</th>
                    <th>Phòng</th>
                    <th>Ngày nhận phòng</th>
                    <th>Ngày trả phòng</th>
                    <th>Trạng thái</th>
                    <th style="text-align:right;">Thao tác</th>
                </tr>
            </thead>

            <tbody>

                @forelse($bookings as $booking)

                @php
                    $statusText = 'Đang chờ';
                    $bg = '#fef3c7';
                    $color = '#92400e';

                    if($booking->status === 'confirmed'){
                        $statusText = 'Đã xác nhận';
                        $bg = '#dcfce7';
                        $color = '#166534';
                    }

                    if($booking->status === 'cancelled'){
                        $statusText = 'Đã huỷ';
                        $bg = '#fee2e2';
                        $color = '#b91c1c';
                    }

                    if($booking->status === 'completed'){
                        $statusText = 'Hoàn thành';
                        $bg = '#dbeafe';
                        $color = '#1d4ed8';
                    }
                @endphp

                <tr>

                    <td>#{{ $booking->id }}</td>

                    <td style="font-weight:700;">
                        {{ $booking->booking_code }}
                    </td>

                    <td>
                        {{ $booking->user->full_name }}
                    </td>

                    <td>
                        {{ $booking->room->room_name }}
                    </td>

                    <td style="white-space:nowrap;">
                        {{ $booking->check_in_date }}
                    </td>

                    <td style="white-space:nowrap;">
                        {{ $booking->check_out_date }}
                    </td>

                    <td>
                        <span class="status"
                              style="background:{{ $bg }};color:{{ $color }};">
                            {{ $statusText }}
                        </span>
                    </td>

                    <td>
                        <div class="actions">

                            <a href="{{ route('host.bookings.show', $booking) }}"
                               class="btn-view">
                                👁 Xem chi tiết
                            </a>

                        </div>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:#94a3b8;">
                        Không có đặt phòng nào.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

@endsection