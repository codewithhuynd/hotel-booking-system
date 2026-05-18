@extends('host.layouts.app')

@section('title', 'User Detail')

@section('content')

<h1>User Detail</h1>

<div style="background:white;padding:20px;border-radius:10px;margin-bottom:20px;">
    <p><strong>Name:</strong> {{ $user->full_name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Phone:</strong> {{ $user->phone }}</p>
</div>

<h2>Booking History</h2>

@if($bookings->isEmpty())
    <p>User này chưa đặt phòng nào.</p>
@else
    <table border="1" width="100%" cellpadding="10" style="background:white;border-radius:10px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Room</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
                <th>Total Price</th>
                <th>Booked At</th>
            </tr>
        </thead>

        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->room->room_name ?? '' }}</td>
                    <td>{{ $booking->check_in_date }}</td>
                    <td>{{ $booking->check_out_date }}</td>
                    <td>{{ $booking->status }}</td>
                    <td>{{ $booking->total_price }}</td>
                    <td>{{ $booking->booked_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<br>

<a href="{{ route('host.users.index') }}">← Back</a>

@endsection