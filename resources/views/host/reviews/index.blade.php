@extends('host.layouts.app')

@section('title', 'Đánh giá phòng')

@section('content')

@php
    $total = (int) ($summary->total ?? 0);
    $average = $total > 0 ? number_format((float) $summary->average, 1) : '—';
    $cardStyle = 'background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:12px 16px;min-width:150px;';
@endphp

<div style="max-width:1100px;margin:0 auto;padding:20px;font-family:system-ui;color:#1e293b;">

    <!-- HEADER -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
        <div>
            <p style="font-size:12px;color:#16a34a;font-weight:700;letter-spacing:1px;margin-bottom:6px;">Bảng quản trị</p>
            <h1 style="font-size:28px;font-weight:800;color:#0f172a;margin:0;">Đánh giá phòng</h1>
        </div>

        <div style="display:flex;gap:12px;flex-wrap:wrap;">
            <div style="{{ $cardStyle }}">
                <p style="font-size:12px;color:#64748b;margin:0;">Tổng đánh giá</p>
                <h3 style="margin:4px 0 0;font-size:22px;font-weight:800;">{{ $total }}</h3>
            </div>
            <div style="{{ $cardStyle }}">
                <p style="font-size:12px;color:#64748b;margin:0;">Điểm trung bình</p>
                <h3 style="margin:4px 0 0;font-size:22px;font-weight:800;color:#d97706;">{{ $average }} ★</h3>
            </div>
            <div style="{{ $cardStyle }}">
                <p style="font-size:12px;color:#64748b;margin:0;">Đang ẩn</p>
                <h3 style="margin:4px 0 0;font-size:22px;font-weight:800;">{{ (int) ($summary->hidden ?? 0) }}</h3>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div style="padding:14px 16px;background:#f0fdf4;border-left:4px solid #16a34a;border-radius:8px;margin-bottom:18px;color:#166534;font-weight:600;">
            {{ session('success') }}
        </div>
    @endif

    @include('host.partials.list-filter', [
        'action' => route('host.reviews.index'),
        'placeholder' => 'Nội dung nhận xét, tên khách, mã booking...',
        'selects' => [
            ['name' => 'room_id', 'label' => 'Phòng', 'options' => $roomOptions],
            ['name' => 'rating', 'label' => 'Số sao', 'options' => [5 => '5 sao', 4 => '4 sao', 3 => '3 sao', 2 => '2 sao', 1 => '1 sao']],
            ['name' => 'visibility', 'label' => 'Hiển thị', 'options' => ['visible' => 'Đang hiện', 'hidden' => 'Đang ẩn']],
        ],
    ])

    <!-- TABLE -->
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;min-width:900px;">
            <thead>
                <tr style="background:#1e293b;color:#fff;">
                    <th style="padding:14px;text-align:left;font-size:12px;">Khách</th>
                    <th style="padding:14px;text-align:left;font-size:12px;">Phòng</th>
                    <th style="padding:14px;text-align:left;font-size:12px;">Số sao</th>
                    <th style="padding:14px;text-align:left;font-size:12px;width:40%;">Nhận xét</th>
                    <th style="padding:14px;text-align:left;font-size:12px;">Ngày</th>
                    <th style="padding:14px;text-align:right;font-size:12px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr style="border-bottom:1px solid #f1f5f9;{{ $review->is_hidden ? 'background:#f8fafc;color:#94a3b8;' : '' }}">
                        <td style="padding:14px;font-size:14px;">
                            <div style="font-weight:700;">{{ $review->user->full_name ?? '—' }}</div>
                            <div style="font-size:12px;color:#64748b;">
                                @if($review->booking)
                                    <a href="{{ route('host.bookings.show', $review->booking_id) }}" style="color:#2563eb;text-decoration:none;">#{{ $review->booking->booking_code }}</a>
                                @endif
                            </div>
                        </td>
                        <td style="padding:14px;font-size:14px;">{{ $review->room->room_name ?? '—' }}</td>
                        <td style="padding:14px;font-size:15px;color:#d97706;white-space:nowrap;">
                            {{ str_repeat('★', $review->rating) }}<span style="color:#e2e8f0;">{{ str_repeat('★', 5 - $review->rating) }}</span>
                        </td>
                        <td style="padding:14px;font-size:14px;line-height:1.6;">
                            {{ $review->comment ?: '(Không có nhận xét)' }}
                            @if($review->is_hidden)
                                <span style="display:inline-block;margin-left:6px;padding:2px 8px;border-radius:999px;background:#fef3c7;color:#92400e;font-size:11px;font-weight:700;">Đang ẩn</span>
                            @endif
                        </td>
                        <td style="padding:14px;font-size:13px;white-space:nowrap;">{{ $review->created_at->format('d/m/Y') }}</td>
                        <td style="padding:14px;text-align:right;">
                            <form method="POST" action="{{ route('host.reviews.toggle', $review) }}" style="display:inline;">
                                @csrf
                                <button type="submit"
                                    style="border:none;padding:8px 10px;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;{{ $review->is_hidden ? 'background:#f0fdf4;color:#16a34a;' : 'background:#fef2f2;color:#dc2626;' }}">
                                    {{ $review->is_hidden ? 'Hiện lại' : 'Ẩn' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;">Chưa có đánh giá nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $reviews->links('host.partials.pagination') }}

</div>

@endsection
