@extends('host.layouts.app')

@section('title', 'Manage Users')

@section('content')

<h1>Manage Users</h1>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table style="width:100%; background:white; padding:10px; border-radius:10px;">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Role</th>
        <th>Action</th>
    </tr>

    @foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->full_name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->phone }}</td>
        <td>{{ $user->role }}</td>
        <td>
            <a href="{{ route('host.users.show', $user) }}">View</a> |
            <a href="{{ route('host.users.edit', $user) }}">Edit</a>

            <form action="{{ route('host.users.destroy', $user) }}"
                  method="POST"
                  style="display:inline;">
                @csrf
                @method('DELETE')

                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<br>

{{ $users->links() }}

@endsection