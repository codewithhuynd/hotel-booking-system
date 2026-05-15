@extends('host.layouts.app')

@section('title', 'Edit Room')

@section('content')

<h1>Edit Room</h1>

<br>

@if(session('success'))

    <p style="color:green;">
        {{ session('success') }}
    </p>

    <br>

@endif

@if($errors->any())

    <div style="color:red;">

        <ul>

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    <br>

@endif

<!--
|--------------------------------------------------------------------------
| UPDATE ROOM FORM
|--------------------------------------------------------------------------
-->

<form
    method="POST"
    action="{{ route('host.rooms.update', $room) }}"
    style="
        background:white;
        padding:20px;
        border-radius:10px;
        margin-bottom:30px;
    "
>

    @csrf
    @method('PUT')

    <label>
        Room Code
    </label>

    <br>

    <input
        type="text"
        name="room_code"
        value="{{ old('room_code', $room->room_code) }}"
        placeholder="Room Code"
        style="width:100%; padding:10px;"
    >

    <br><br>

    <label>
        Room Name
    </label>

    <br>

    <input
        type="text"
        name="room_name"
        value="{{ old('room_name', $room->room_name) }}"
        placeholder="Room Name"
        style="width:100%; padding:10px;"
    >

    <br><br>

    <label>
        Description
    </label>

    <br>

    <textarea
        name="description"
        placeholder="Description"
        style="
            width:100%;
            padding:10px;
            min-height:120px;
        "
    >{{ old('description', $room->description) }}</textarea>

    <br><br>

    <label>
        Price
    </label>

    <br>

    <input
        type="number"
        name="price"
        value="{{ old('price', $room->price) }}"
        placeholder="Price"
        style="width:100%; padding:10px;"
    >

    <br><br>

    <label>
        Capacity
    </label>

    <br>

    <input
        type="number"
        name="capacity"
        value="{{ old('capacity', $room->capacity) }}"
        placeholder="Capacity"
        style="width:100%; padding:10px;"
    >

    <br><br>

    <label>
        Status
    </label>

    <br>

    <select
        name="status"
        style="width:100%; padding:10px;"
    >

        <option
            value="available"
            {{ $room->status == 'available' ? 'selected' : '' }}
        >
            Available
        </option>

        <option
            value="booked"
            {{ $room->status == 'booked' ? 'selected' : '' }}
        >
            Booked
        </option>

        <option
            value="occupied"
            {{ $room->status == 'occupied' ? 'selected' : '' }}
        >
            Occupied
        </option>

        <option
            value="cleaning"
            {{ $room->status == 'cleaning' ? 'selected' : '' }}
        >
            Cleaning
        </option>

    </select>

    <br><br>

    <button
        type="submit"
        style="
            padding:12px 20px;
            border:none;
            background:#2563eb;
            color:white;
            border-radius:8px;
            cursor:pointer;
        "
    >
        Update Room
    </button>

</form>

<!--
|--------------------------------------------------------------------------
| ROOM IMAGES
|--------------------------------------------------------------------------
-->

<div
    style="
        background:white;
        padding:20px;
        border-radius:10px;
    "
>

    <h2>Room Images</h2>

    <br>

    <!-- UPLOAD IMAGE -->

    <form
        method="POST"
        action="{{ route('host.rooms.images.store', $room) }}"
        enctype="multipart/form-data"
    >

        @csrf

        <input
            type="file"
            name="image"
        >

        <button
            type="submit"
            style="
                padding:10px 16px;
                border:none;
                background:#16a34a;
                color:white;
                border-radius:8px;
                cursor:pointer;
            "
        >
            Upload Image
        </button>

    </form>

    <br><br>

    <!-- IMAGE LIST -->

    <div
        style="
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));
            gap:20px;
        "
    >

        @forelse($room->images as $image)

            <div
                style="
                    border:1px solid #ddd;
                    border-radius:10px;
                    overflow:hidden;
                    background:#fafafa;
                "
            >

                <img
                    src="{{ asset('storage/' . $image->image_path) }}"
                    alt="Room Image"
                    style="
                        width:100%;
                        height:180px;
                        object-fit:cover;
                    "
                >

                <div style="padding:15px;">

                    @if($image->is_main)

                        <p
                            style="
                                color:green;
                                font-weight:bold;
                                margin-bottom:10px;
                            "
                        >
                            Main Image
                        </p>

                    @else

                        <form
                            method="POST"
                            action="{{ route('host.rooms.images.main', $image) }}"
                        >

                            @csrf
                            

                            <button
                                type="submit"
                                style="
                                    width:100%;
                                    padding:10px;
                                    border:none;
                                    background:#f59e0b;
                                    color:white;
                                    border-radius:8px;
                                    cursor:pointer;
                                    margin-bottom:10px;
                                "
                            >
                                Set Main Image
                            </button>

                        </form>

                    @endif

                    <!-- DELETE IMAGE -->

                    <form
                        method="POST"
                        action="{{ route('host.rooms.images.destroy', $image) }}"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            onclick="return confirm('Delete this image?')"
                            style="
                                width:100%;
                                padding:10px;
                                border:none;
                                background:#dc2626;
                                color:white;
                                border-radius:8px;
                                cursor:pointer;
                            "
                        >
                            Delete Image
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <p>
                No images uploaded yet.
            </p>

        @endforelse

    </div>

</div>

@endsection