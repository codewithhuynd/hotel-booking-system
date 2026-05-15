@extends('host.layouts.app')

@section('title', 'Manage Rooms')

@section('content')

<h1>Manage Rooms</h1>

<br>

<a href="{{ route('host.rooms.create') }}">
    + Create Room
</a>

<br><br>

@if(session('success'))

    <p style="color: green;">
        {{ session('success') }}
    </p>

@endif

<table
    border="1"
    cellpadding="10"
    cellspacing="0"
    width="100%"
    style="background: white;"
>

    <tr>

        <th>ID</th>

        <th>Room Code</th>

        <th>Room Name</th>

        <th>Price</th>

        <th>Capacity</th>

        <th>Status</th>

        <th>Actions</th>

    </tr>

    @forelse($rooms as $room)

        <tr>

            <td>{{ $room->id }}</td>

            <td>{{ $room->room_code }}</td>

            <td>{{ $room->room_name }}</td>

            <td>{{ number_format($room->price) }} VND</td>

            <td>{{ $room->capacity }}</td>

            <td>{{ $room->status }}</td>

            <td>

                <a href="{{ route('host.rooms.edit', $room) }}">
                    Edit
                </a>

                |

                <form
                    action="{{ route('host.rooms.destroy', $room) }}"
                    method="POST"
                    style="display:inline;"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        onclick="return confirm('Delete this room?')"
                    >
                        Delete
                    </button>

                </form>

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="7">
                No rooms found.
            </td>

        </tr>

    @endforelse

</table>

@endsection