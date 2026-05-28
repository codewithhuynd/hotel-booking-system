@extends('host.layouts.app')

@section('title', 'Quản lý người dùng')

@section('content')

<div style="max-width:1100px;margin:0 auto;padding:20px;font-family:system-ui;color:#1e293b;">

    <!-- HEADER -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px;">

        <div>
            <p style="font-size:12px;color:#16a34a;font-weight:700;letter-spacing:1px;margin-bottom:6px;">
                Bảng quản trị
            </p>
            <h1 style="font-size:28px;font-weight:800;color:#0f172a;margin:0;">
                Quản lý người dùng
            </h1>
        </div>

        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:12px 16px;min-width:180px;">
            <p style="font-size:12px;color:#64748b;margin:0;">Tổng người dùng</p>
            <h3 style="margin:4px 0 0;font-size:22px;font-weight:800;">
                {{ $users->total() }}
            </h3>
        </div>

    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div style="padding:14px 16px;background:#f0fdf4;border-left:4px solid #16a34a;border-radius:8px;margin-bottom:18px;color:#166534;font-weight:600;">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">

        <table style="width:100%;border-collapse:collapse;min-width:900px;">

            <thead>
                <tr style="background:#1e293b;color:#fff;">
                    <th style="padding:14px;text-align:left;font-size:12px;">ID</th>
                    <th style="padding:14px;text-align:left;font-size:12px;">Người dùng</th>
                    <th style="padding:14px;text-align:left;font-size:12px;">Email</th>
                    <th style="padding:14px;text-align:left;font-size:12px;">SĐT</th>
                    <th style="padding:14px;text-align:left;font-size:12px;">Vai trò</th>
                    <th style="padding:14px;text-align:right;font-size:12px;">Thao tác</th>
                </tr>
            </thead>

            <tbody>

                @foreach($users as $user)

                @php
                    $roleText = 'Khách hàng';
                    $roleBg = '#dcfce7';
                    $roleColor = '#166534';

                    if($user->role === 'host'){
                        $roleText = 'Quản trị';
                        $roleBg = '#dbeafe';
                        $roleColor = '#1d4ed8';
                    }
                @endphp

                <tr style="border-bottom:1px solid #f1f5f9;">

                    <td style="padding:14px;color:#64748b;font-weight:600;">
                        #{{ $user->id }}
                    </td>

                    <td style="padding:14px;font-weight:700;color:#0f172a;">
                        {{ $user->full_name }}
                    </td>

                    <td style="padding:14px;color:#334155;">
                        {{ $user->email }}
                    </td>

                    <td style="padding:14px;color:#334155;">
                        {{ $user->phone ?? '---' }}
                    </td>

                    <td style="padding:14px;">
                        <span style="background:{{ $roleBg }};color:{{ $roleColor }};padding:6px 10px;border-radius:999px;font-size:12px;font-weight:700;">
                            {{ $roleText }}
                        </span>
                    </td>

                    <td style="padding:14px;text-align:right;white-space:nowrap;">

                        <a href="{{ route('host.users.show', $user) }}"
                           style="text-decoration:none;background:#eff6ff;color:#2563eb;padding:8px 10px;border-radius:8px;font-size:12px;font-weight:700;">
                            Xem
                        </a>

                        <a href="{{ route('host.users.edit', $user) }}"
                           style="text-decoration:none;background:#fff7ed;color:#ea580c;padding:8px 10px;border-radius:8px;font-size:12px;font-weight:700;margin-left:6px;">
                            Sửa
                        </a>

                        <form method="POST" action="{{ route('host.users.destroy', $user) }}" style="display:inline;">
                            @csrf @method('DELETE')

                            <button onclick="return confirm('Xóa user này?')"
                                style="border:none;background:#fef2f2;color:#dc2626;padding:8px 10px;border-radius:8px;font-size:12px;font-weight:700;margin-left:6px;cursor:pointer;">
                                Xóa
                            </button>
                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div style="margin-top:20px;display:flex;justify-content:center;">
        {{ $users->links() }}
    </div>

</div>

@endsection