@extends('host.layouts.app')

@section('title', 'Manage Bookings')

@section('content')

<h1>
    Manage Bookings
</h1>

<br>

@if(session('success'))

    <p style="color:green;">
        {{ session('success') }}
    </p>

    <br>

@endif

<table
    border="1"
    cellpadding="12"
    cellspacing="0"
    width="100%"
    style="
        background:white;
        border-collapse:collapse;
    "
>

    <tr
        style="
            background:#1e293b;
            color:white;
        "
    >
        <th>ID</th>
        <th>Booking Code</th>
        <th>Guest</th>
        <th>Room</th>
        <th>Check In</th>
        <th>Check Out</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @forelse($bookings as $booking)

        <tr>

            <td>
                {{ $booking->id }}
            </td>

            <td>
                {{ $booking->booking_code }}
            </td>

            <td>
                {{ $booking->user->full_name }}
            </td>

            <td>
                {{ $booking->room->room_name }}
            </td>

            <td>
                {{ $booking->check_in_date }}
            </td>

            <td>
                {{ $booking->check_out_date }}
            </td>

            <td>
                {{ strtoupper($booking->status) }}
            </td>

            <td>

                <a
                    href="{{ route('host.bookings.show', $booking) }}"
                    style="
                        padding:8px 12px;
                        background:#2563eb;
                        color:white;
                        text-decoration:none;
                        border-radius:6px;
                    "
                >
                    View
                </a>

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="8">
                No bookings found.
            </td>

        </tr>

    @endforelse

</table>

@endsection