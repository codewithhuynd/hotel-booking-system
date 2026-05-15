<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST ROOMS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $rooms = Room::latest()->get();

        return view('host.rooms.index', compact('rooms'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW CREATE FORM
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('host.rooms.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE ROOM
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'room_code' => 'required|unique:rooms',

            'room_name' => 'required',

            'description' => 'nullable',

            'price' => 'required|numeric|min:0',

            'capacity' => 'required|integer|min:1',

            'status' => 'required',
        ]);

        Room::create($validated);

        return redirect()
            ->route('host.rooms.index')
            ->with('success', 'Room created successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW EDIT FORM
    |--------------------------------------------------------------------------
    */

    public function edit(Room $room)
    {
        return view('host.rooms.edit', compact('room'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE ROOM
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([

            'room_code' => 'required|unique:rooms,room_code,' . $room->id,

            'room_name' => 'required',

            'description' => 'nullable',

            'price' => 'required|numeric|min:0',

            'capacity' => 'required|integer|min:1',

            'status' => 'required',
        ]);

        $room->update($validated);

        return redirect()
            ->route('host.rooms.index')
            ->with('success', 'Room updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE ROOM
    |--------------------------------------------------------------------------
    */

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()
            ->route('host.rooms.index')
            ->with('success', 'Room deleted successfully');
    }
}