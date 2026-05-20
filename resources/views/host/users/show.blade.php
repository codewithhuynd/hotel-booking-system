@extends('host.layouts.app')

@section('title', 'User Detail')

@section('content')

<div style="font-family: sans-serif; padding: 20px; color: #333;">
    
    <!-- Tiêu đề & Nút quay lại -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 24px; font-weight: 600; margin: 0;">User Detail</h1>
        <a href="{{ route('host.users.index') }}" style="color: #1a73e8; text-decoration: none; font-weight: 500; font-size: 14px;">
            ← Back to List
        </a>
    </div>

    <!-- Thông tin chi tiết User -->
    <div style="background: white; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div>
                <span style="display: block; font-size: 12px; color: #777; text-transform: uppercase; margin-bottom: 4px; font-weight: 600;">Name</span>
                <span style="font-size: 16px; font-weight: 500; color: #111;">{{ $user->full_name }}</span>
            </div>
            <div>
                <span style="display: block; font-size: 12px; color: #777; text-transform: uppercase; margin-bottom: 4px; font-weight: 600;">Email Address</span>
                <span style="font-size: 16px; color: #333;">{{ $user->email }}</span>
            </div>
            <div>
                <span style="display: block; font-size: 12px; color: #777; text-transform: uppercase; margin-bottom: 4px; font-weight: 600;">Phone Number</span>
                <span style="font-size: 16px; color: #333;">{{ $user->phone }}</span>
            </div>
        </div>
    </div>

    <!-- Lịch sử đặt phòng -->
    <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 16px; color: #444;">Booking History</h2>

    @if($bookings->isEmpty())
        <div style="background: #f8f9fa; border: 1px dashed #ccc; padding: 30px; text-align: center; color: #777; border-radius: 8px; font-size: 14px;">
            User này chưa đặt phòng nào.
        </div>
    @else
        <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead>
                    <tr style="background-color: #f8f9fa; border-bottom: 2px solid #eee;">
                        <th style="padding: 12px 16px; font-weight: 600; color: #555;">ID</th>
                        <th style="padding: 12px 16px; font-weight: 600; color: #555;">Room</th>
                        <th style="padding: 12px 16px; font-weight: 600; color: #555;">Check In</th>
                        <th style="padding: 12px 16px; font-weight: 600; color: #555;">Check Out</th>
                        <th style="padding: 12px 16px; font-weight: 600; color: #555;">Status</th>
                        <th style="padding: 12px 16px; font-weight: 600; color: #555;">Total Price</th>
                        <th style="padding: 12px 16px; font-weight: 600; color: #555;">Booked At</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($bookings as $booking)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px 16px; color: #777;">{{ $booking->id }}</td>
                            <td style="padding: 12px 16px; font-weight: 500; color: #1a73e8;">{{ $booking->room->room_name ?? '' }}</td>
                            <td style="padding: 12px 16px; color: #555;">{{ $booking->check_in_date }}</td>
                            <td style="padding: 12px 16px; color: #555;">{{ $booking->check_out_date }}</td>
                            <td style="padding: 12px 16px;">
                                <span style="background: #f1f3f4; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500; color: #3c4043;">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td style="padding: 12px 16px; font-weight: 600; color: #137333;">{{ $booking->total_price }}</td>
                            <td style="padding: 12px 16px; color: #777; font-size: 13px;">{{ $booking->booked_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>

@endsection