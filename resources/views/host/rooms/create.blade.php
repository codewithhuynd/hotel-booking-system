@extends('host.layouts.app')

@section('title', 'Create Room')

@section('content')

<h1>Create Room</h1>

<br>

@if($errors->any())

    <div style="color:red;">

        <ul>

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<form
    method="POST"
    action="{{ route('host.rooms.store') }}"
>

    @csrf

    <input
        type="text"
        name="room_code"
        value="{{ old('room_code') }}"
        placeholder="Room Code"
    >

    <br><br>

    <input
        type="text"
        name="room_name"
        value="{{ old('room_name') }}"
        placeholder="Room Name"
    >

    <br><br>

    <textarea
        name="description"
        placeholder="Description"
    >{{ old('description') }}</textarea>

    <br><br>

    <input
        type="number"
        name="price"
        value="{{ old('price') }}"
        placeholder="Price"
    >

    <br><br>

    <input
        type="number"
        name="capacity"
        value="{{ old('capacity') }}"
        placeholder="Capacity"
    >

    <br><br>

    <select name="status">

        <option value="available">
            Available
        </option>

        <option value="booked">
            Booked
        </option>

        <option value="occupied">
            Occupied
        </option>

        <option value="cleaning">
            Cleaning
        </option>

    </select>

    <br><br>

    <button type="submit">
        Create Room
    </button>

</form>

@endsection