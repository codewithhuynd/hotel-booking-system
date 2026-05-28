@extends('host.layouts.app')

@section('title', 'Quản lý người dùng')

@section('content')

<div style="font-family: 'Segoe UI', sans-serif;">

    <!-- HEADER -->
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:28px;
        flex-wrap:wrap;
        gap:16px;
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
                Bảng điều khiển quản trị
            </p>

            <h1 style="
                font-size:34px;
                font-weight:800;
                color:#0f172a;
            ">
                Quản lý người dùng
            </h1>
        </div>

        <div style="
            background:white;
            border-radius:18px;
            padding:14px 18px;
            box-shadow:0 10px 30px rgba(15,23,42,0.06);
            border:1px solid #e2e8f0;
            min-width:220px;
        ">
            <p style="
                font-size:12px;
                color:#64748b;
                margin-bottom:4px;
            ">
                Tổng số người dùng
            </p>

            <h3 style="
                font-size:28px;
                font-weight:800;
                color:#0f172a;
            ">
                {{ $users->total() }}
            </h3>
        </div>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))

    <div style="
        margin-bottom:24px;
        padding:16px 20px;
        border-radius:18px;
        background:linear-gradient(135deg,#dcfce7,#f0fdf4);
        border:1px solid #bbf7d0;
        color:#166534;
        display:flex;
        align-items:center;
        gap:12px;
        font-weight:600;
        box-shadow:0 8px 20px rgba(34,197,94,0.08);
    ">
        <span style="font-size:18px;">✅</span>

        <span>{{ session('success') }}</span>
    </div>

    @endif

    <!-- TABLE CARD -->
    <div style="
        background:white;
        border-radius:28px;
        overflow:hidden;
        border:1px solid #e2e8f0;
        box-shadow:0 20px 45px rgba(15,23,42,0.06);
    ">

        <!-- TOP BAR -->
        <div style="
            padding:24px 28px;
            border-bottom:1px solid #f1f5f9;
            background:linear-gradient(to right,#ffffff,#f8fafc);
        ">
            <h2 style="
                font-size:20px;
                font-weight:700;
                color:#0f172a;
                margin-bottom:4px;
            ">
                Danh sách tài khoản
            </h2>

            <p style="
                font-size:14px;
                color:#64748b;
            ">
                Theo dõi và quản lý toàn bộ người dùng trong hệ thống khách sạn.
            </p>
        </div>

        <!-- TABLE -->
        <div style="overflow-x:auto;">

            <table style="
                width:100%;
                border-collapse:collapse;
                min-width:1000px;
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
                            Người dùng
                        </th>

                        <th style="padding:18px 22px; text-align:left; font-size:13px; color:#64748b; font-weight:700;">
                            Email
                        </th>

                        <th style="padding:18px 22px; text-align:left; font-size:13px; color:#64748b; font-weight:700;">
                            Số điện thoại
                        </th>

                        <th style="padding:18px 22px; text-align:left; font-size:13px; color:#64748b; font-weight:700;">
                            Vai trò
                        </th>

                        <th style="padding:18px 22px; text-align:right; font-size:13px; color:#64748b; font-weight:700;">
                            Thao tác
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($users as $user)

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
                            font-weight:600;
                        ">
                            #{{ $user->id }}
                        </td>

                        <!-- USER -->
                        <td style="padding:22px;">

                            <div style="
                                display:flex;
                                align-items:center;
                                gap:14px;
                            ">

                                <div style="
                                    width:48px;
                                    height:48px;
                                    border-radius:16px;
                                    background:linear-gradient(135deg,#16a34a,#22c55e);
                                    color:white;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    font-size:18px;
                                    font-weight:800;
                                    box-shadow:0 10px 20px rgba(34,197,94,0.18);
                                ">
                                    {{ strtoupper(substr($user->full_name, 0, 1)) }}
                                </div>

                                <div>

                                    <div style="
                                        font-weight:700;
                                        color:#0f172a;
                                        font-size:15px;
                                        margin-bottom:4px;
                                    ">
                                        {{ $user->full_name }}
                                    </div>

                                    <div style="
                                        font-size:13px;
                                        color:#94a3b8;
                                    ">
                                        Thành viên hệ thống
                                    </div>

                                </div>

                            </div>

                        </td>

                        <!-- EMAIL -->
                        <td style="
                            padding:22px;
                            color:#334155;
                            font-weight:500;
                        ">
                            {{ $user->email }}
                        </td>

                        <!-- PHONE -->
                        <td style="
                            padding:22px;
                            color:#334155;
                            font-weight:500;
                        ">
                            {{ $user->phone ?: 'Chưa cập nhật' }}
                        </td>

                        <!-- ROLE -->
                        <td style="padding:22px;">

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

                        </td>

                        <!-- ACTION -->
                        <td style="
                            padding:22px;
                            text-align:right;
                            white-space:nowrap;
                        ">

                            <div style="
                                display:flex;
                                justify-content:flex-end;
                                gap:10px;
                                flex-wrap:wrap;
                            ">

                                <!-- VIEW -->
                                <a href="{{ route('host.users.show', $user) }}"
                                    style="
                                        padding:10px 14px;
                                        border-radius:12px;
                                        background:#eff6ff;
                                        color:#2563eb;
                                        text-decoration:none;
                                        font-size:13px;
                                        font-weight:700;
                                        transition:0.25s ease;
                                    "
                                    onmouseover="this.style.transform='translateY(-2px)'"
                                    onmouseout="this.style.transform='translateY(0)'">

                                    👁 Chi tiết

                                </a>

                                <!-- EDIT -->
                                <a href="{{ route('host.users.edit', $user) }}"
                                    style="
                                        padding:10px 14px;
                                        border-radius:12px;
                                        background:#fff7ed;
                                        color:#ea580c;
                                        text-decoration:none;
                                        font-size:13px;
                                        font-weight:700;
                                        transition:0.25s ease;
                                    "
                                    onmouseover="this.style.transform='translateY(-2px)'"
                                    onmouseout="this.style.transform='translateY(0)'">

                                    ✏️ Chỉnh sửa

                                </a>

                                <!-- DELETE -->
                                <form action="{{ route('host.users.destroy', $user) }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        style="
                                            padding:10px 14px;
                                            border:none;
                                            border-radius:12px;
                                            background:#fef2f2;
                                            color:#dc2626;
                                            cursor:pointer;
                                            font-size:13px;
                                            font-weight:700;
                                            transition:0.25s ease;
                                        "
                                        onmouseover="this.style.transform='translateY(-2px)'"
                                        onmouseout="this.style.transform='translateY(0)'">

                                        🗑 Xóa

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <!-- PAGINATION -->
    <div style="
        margin-top:26px;
        display:flex;
        justify-content:center;
    ">
        {{ $users->links() }}
    </div>

</div>

@endsection