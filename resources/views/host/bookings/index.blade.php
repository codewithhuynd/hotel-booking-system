@extends('host.layouts.app')

@section('title', 'Manage Bookings')

@section('content')

<div style="font-family: sans-serif; padding: 20px; color: #333;">
    <h1 style="font-size: 24px; font-weight: 600; margin-bottom: 20px;">
        Manage Bookings
    </h1>

    @if(session('success'))
        <div style="padding: 12px 16px; background-color: #e6f4ea; color: #137333; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="background-color: #f8f9fa; border-bottom: 2px solid #eee;">
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">ID</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Booking Code</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Guest</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Room</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Check In</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Check Out</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Status</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px 16px; color: #777;">
                        {{ $booking->id }}
                    </td>
                    <td style="padding: 12px 16px; font-weight: 500;">
                        {{ $booking->booking_code }}
                    </td>
                    <td style="padding: 12px 16px; color: #555;">
                        {{ $booking->user->full_name }}
                    </td>
                    <td style="padding: 12px 16px; color: #555;">
                        {{ $booking->room->room_name }}
                    </td>
                    <td style="padding: 12px 16px; color: #555;">
                        {{ $booking->check_in_date }}
                    </td>
                    <td style="padding: 12px 16px; color: #555;">
                        {{ $booking->check_out_date }}
                    </td>
                    <td style="padding: 12px 16px;">
                        <span style="background: #f1f3f4; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                            {{ strtoupper($booking->status) }}
                        </span>
                    </td>
                    <td style="padding: 12px 16px; text-align: right; white-space: nowrap;">
                        <a href="{{ route('host.bookings.show', $booking) }}" style="color: #1a73e8; text-decoration: none; font-weight: 500;">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 12px 16px; color: #777; text-align: center;">
                        No bookings found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection