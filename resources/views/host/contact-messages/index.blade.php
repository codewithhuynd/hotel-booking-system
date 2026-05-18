@extends('host.layouts.app')

@section('title', 'Contact Messages')

@section('content')

<h1>Contact Messages</h1>

<br>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
    <br>
@endif

<table
    border="1"
    cellpadding="12"
    cellspacing="0"
    width="100%"
    style="background:white; border-collapse:collapse;"
>
    <tr style="background:#1e293b; color:white;">
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>User</th>
        <th>Status</th>
        <th>Created</th>
        <th>Action</th>
    </tr>

    @forelse($messages as $message)
        <tr>
            <td>{{ $message->id }}</td>
            <td>{{ $message->name }}</td>
            <td>{{ $message->email }}</td>
            <td>
                {{ $message->user ? $message->user->full_name : 'Public user' }}
            </td>
            <td>{{ strtoupper($message->status) }}</td>
            <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <a
                    href="{{ route('host.contact-messages.show', $message) }}"
                    style="padding:8px 12px; background:#2563eb; color:white; text-decoration:none; border-radius:6px;"
                >
                    View
                </a>

                <form
                    method="POST"
                    action="{{ route('host.contact-messages.destroy', $message) }}"
                    style="display:inline;"
                    onsubmit="return confirm('Delete this message?')"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        style="padding:8px 12px; background:#dc2626; color:white; border:none; border-radius:6px;"
                    >
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7">No messages.</td>
        </tr>
    @endforelse
</table>

<br>

{{ $messages->links() }}

@endsection