@extends('host.layouts.app')

@section('title', 'Manage Users')

@section('content')

<div style="font-family: sans-serif; padding: 20px; color: #333;">
    <h1 style="font-size: 24px; font-weight: 600; margin-bottom: 20px;">Manage Users</h1>

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
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Name</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Email</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Phone</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555;">Role</th>
                    <th style="padding: 12px 16px; font-weight: 600; color: #555; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px 16px; color: #777;">{{ $user->id }}</td>
                    <td style="padding: 12px 16px; font-weight: 500;">{{ $user->full_name }}</td>
                    <td style="padding: 12px 16px; color: #555;">{{ $user->email }}</td>
                    <td style="padding: 12px 16px; color: #555;">{{ $user->phone }}</td>
                    <td style="padding: 12px 16px;">
                        <span style="background: #f1f3f4; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td style="padding: 12px 16px; text-align: right; white-space: nowrap;">
                        <a href="{{ route('host.users.show', $user) }}" style="color: #1a73e8; text-decoration: none; margin-right: 12px; font-weight: 500;">View</a>
                        <a href="{{ route('host.users.edit', $user) }}" style="color: #e37400; text-decoration: none; margin-right: 12px; font-weight: 500;">Edit</a>

                        <form action="{{ route('host.users.destroy', $user) }}"
                              method="POST"
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #d93025; cursor: pointer; padding: 0; font-size: 14px; font-family: sans-serif; font-weight: 500;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
</div>

@endsection