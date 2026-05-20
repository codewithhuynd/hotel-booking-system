@extends('host.layouts.app')

@section('title', 'Manage Rooms')

@section('content')

<div style="font-family: sans-serif; padding: 20px; color: #333;">

    <!-- Khối tiêu đề và nút Tạo phòng -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 24px; font-weight: 600; margin: 0;">Manage Rooms</h1>
        <a href="{{ route('host.rooms.create') }}" 
           style="background: #1a73e8; color: white; text-decoration: none; padding: 10px 16px; border-radius: 6px; font-size: 14px; font-weight: 500; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            + Create Room
        </a>
    </div>

    <!-- Thông báo thành công -->
    @if(session('success'))
        <div style="padding: 12px 16px; background-color: #e6f4ea; color: #137333; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Bảng danh sách phòng -->
    <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="background-color: #f8f9fa; border-bottom: 2px solid #eee;">
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">ID</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Room Code</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Room Name</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Price</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Capacity</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Status</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px 16px; color: #777;">{{ $room->id }}</td>
                        <td style="padding: 12px 16px; font-weight: 600; color: #1a73e8;">{{ $room->room_code }}</td>
                        <td style="padding: 12px 16px; font-weight: 500;">{{ $room->room_name }}</td>
                        <td style="padding: 12px 16px; color: #137333; font-weight: 600;">{{ number_format($room->price) }} VND</td>
                        <td style="padding: 12px 16px; color: #555;">{{ $room->capacity }} guests</td>
                        <td style="padding: 12px 16px;">
                            <span style="background: #e8f0fe; color: #1a73e8; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                                {{ $room->status }}
                            </span>
                        </td>
                        <td style="padding: 12px 16px; text-align: right; white-space: nowrap;">
                            <a href="{{ route('host.rooms.edit', $room) }}" 
                               style="color: #e37400; text-decoration: none; margin-right: 12px; font-weight: 500;">
                                Edit
                            </a>

                            <form action="{{ route('host.rooms.destroy', $room) }}"
                                  method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirm('Delete this room?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="background: none; border: none; color: #d93025; cursor: pointer; padding: 0; font-size: 14px; font-family: sans-serif; font-weight: 500;">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 32px; text-align: center; color: #777; font-style: italic; background-color: #fafafa;">
                            No rooms found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection