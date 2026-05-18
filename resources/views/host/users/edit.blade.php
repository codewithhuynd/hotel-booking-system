@extends('host.layouts.app')

@section('title', 'Edit User')

@section('content')

<h1>Edit User</h1>

<form method="POST" action="{{ route('host.users.update', $user) }}"
      style="background:white; padding:20px; border-radius:10px;">
    @csrf
    @method('PUT')

    <label>Name</label>
    <input name="full_name" value="{{ $user->full_name }}">
    <br><br>

    <label>Phone</label>
    <input name="phone" value="{{ $user->phone }}">
    <br><br>

    <label>Birthday</label>
    <input type="date" name="birthday" value="{{ $user->birthday }}">
    <br><br>

    <label>Role</label>
    <select name="role">
        <option value="guest" @selected($user->role=='guest')>Guest</option>
        <option value="host" @selected($user->role=='host')>Host</option>
    </select>

    <br><br>

    <button type="submit">Save</button>
</form>

<br>

<a href="{{ route('host.users.index') }}">← Back</a>

@endsection