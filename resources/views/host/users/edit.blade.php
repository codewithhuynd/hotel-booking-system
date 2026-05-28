@extends('host.layouts.app')

@section('title', 'Chỉnh sửa người dùng')

@section('content')

<div style="
    font-family:'Segoe UI', sans-serif;
    max-width:760px;
;">

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
                Chỉnh sửa người dùng
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

    <!-- CARD -->
    <div style="
        background:white;
        border-radius:30px;
        overflow:hidden;
        border:1px solid #e2e8f0;
        box-shadow:0 20px 45px rgba(15,23,42,0.06);
    ">

        <!-- TOP -->
        <div style="
            padding:28px 32px;
            border-bottom:1px solid #f1f5f9;
            background:linear-gradient(to right,#ffffff,#f8fafc);
        ">

            <div style="
                display:flex;
                align-items:center;
                gap:18px;
            ">

                <div style="
                    width:68px;
                    height:68px;
                    border-radius:22px;
                    background:linear-gradient(135deg,#16a34a,#22c55e);
                    color:white;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:26px;
                    font-weight:800;
                    box-shadow:0 15px 30px rgba(34,197,94,0.2);
                ">
                    {{ strtoupper(substr($user->full_name, 0, 1)) }}
                </div>

                <div>

                    <h2 style="
                        font-size:24px;
                        font-weight:800;
                        color:#0f172a;
                        margin-bottom:4px;
                    ">
                        {{ $user->full_name }}
                    </h2>

                    <p style="
                        color:#64748b;
                        font-size:14px;
                    ">
                        {{ $user->email }}
                    </p>

                </div>

            </div>

        </div>

        <!-- FORM -->
        <form method="POST"
            action="{{ route('host.users.update', $user) }}"
            style="
                padding:32px;
            ">

            @csrf
            @method('PUT')

            <!-- NAME -->
            <div style="margin-bottom:26px;">

                <label style="
                    display:block;
                    margin-bottom:10px;
                    font-size:13px;
                    font-weight:700;
                    color:#334155;
                    text-transform:uppercase;
                    letter-spacing:1px;
                ">
                    👤 Họ và tên
                </label>

                <input
                    type="text"
                    name="full_name"
                    value="{{ $user->full_name }}"
                    placeholder="Nhập họ và tên..."
                    style="
                        width:100%;
                        padding:16px 18px;
                        border-radius:18px;
                        border:1px solid #dbe2ea;
                        background:#f8fafc;
                        font-size:15px;
                        color:#0f172a;
                        outline:none;
                        transition:0.25s ease;
                        box-sizing:border-box;
                    "
                    onfocus="this.style.borderColor='#22c55e';this.style.background='white';this.style.boxShadow='0 0 0 4px rgba(34,197,94,0.12)'"
                    onblur="this.style.borderColor='#dbe2ea';this.style.background='#f8fafc';this.style.boxShadow='none'">

            </div>

            <!-- PHONE -->
            <div style="margin-bottom:26px;">

                <label style="
                    display:block;
                    margin-bottom:10px;
                    font-size:13px;
                    font-weight:700;
                    color:#334155;
                    text-transform:uppercase;
                    letter-spacing:1px;
                ">
                    📞 Số điện thoại
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ $user->phone }}"
                    placeholder="Nhập số điện thoại..."
                    style="
                        width:100%;
                        padding:16px 18px;
                        border-radius:18px;
                        border:1px solid #dbe2ea;
                        background:#f8fafc;
                        font-size:15px;
                        color:#0f172a;
                        outline:none;
                        transition:0.25s ease;
                        box-sizing:border-box;
                    "
                    onfocus="this.style.borderColor='#22c55e';this.style.background='white';this.style.boxShadow='0 0 0 4px rgba(34,197,94,0.12)'"
                    onblur="this.style.borderColor='#dbe2ea';this.style.background='#f8fafc';this.style.boxShadow='none'">

            </div>

            <!-- BIRTHDAY -->
            <div style="margin-bottom:32px;">

                <label style="
                    display:block;
                    margin-bottom:10px;
                    font-size:13px;
                    font-weight:700;
                    color:#334155;
                    text-transform:uppercase;
                    letter-spacing:1px;
                ">
                    🎂 Ngày sinh
                </label>

                <input
                    type="date"
                    name="birthday"
                    value="{{ $user->birthday }}"
                    style="
                        width:100%;
                        padding:16px 18px;
                        border-radius:18px;
                        border:1px solid #dbe2ea;
                        background:#f8fafc;
                        font-size:15px;
                        color:#0f172a;
                        outline:none;
                        transition:0.25s ease;
                        box-sizing:border-box;
                        font-family:'Segoe UI', sans-serif;
                    "
                    onfocus="this.style.borderColor='#22c55e';this.style.background='white';this.style.boxShadow='0 0 0 4px rgba(34,197,94,0.12)'"
                    onblur="this.style.borderColor='#dbe2ea';this.style.background='#f8fafc';this.style.boxShadow='none'">

            </div>

            <!-- ACTION -->
            <div style="
                display:flex;
                align-items:center;
                gap:14px;
                flex-wrap:wrap;
                padding-top:10px;
                border-top:1px solid #f1f5f9;
            ">

                <!-- SAVE -->
                <button
                    type="submit"
                    style="
                        border:none;
                        cursor:pointer;
                        padding:16px 28px;
                        border-radius:18px;
                        background:linear-gradient(135deg,#16a34a,#22c55e);
                        color:white;
                        font-size:15px;
                        font-weight:800;
                        box-shadow:0 15px 30px rgba(34,197,94,0.2);
                        transition:0.25s ease;
                    "
                    onmouseover="this.style.transform='translateY(-2px)'"
                    onmouseout="this.style.transform='translateY(0)'">

                    💾 Lưu thay đổi

                </button>

                <!-- CANCEL -->
                <a href="{{ route('host.users.index') }}"
                    style="
                        display:inline-flex;
                        align-items:center;
                        justify-content:center;
                        padding:16px 24px;
                        border-radius:18px;
                        border:1px solid #dbe2ea;
                        background:white;
                        color:#475569;
                        text-decoration:none;
                        font-size:15px;
                        font-weight:700;
                        transition:0.25s ease;
                    "
                    onmouseover="this.style.background='#f8fafc'"
                    onmouseout="this.style.background='white'">

                    Hủy bỏ

                </a>

            </div>

        </form>

    </div>

</div>

@endsection