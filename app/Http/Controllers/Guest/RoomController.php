<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ROOM LIST
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Room::query();

        /*
    |----------------------------------------------------------------------
    | SEARCH ROOM NAME
    |----------------------------------------------------------------------
    */

        if ($request->filled('keyword')) {

            $query->where(
                'room_name',
                'like',
                '%' . $request->keyword . '%'
            );
        }

        /*
    |----------------------------------------------------------------------
    | FILTER CAPACITY
    |----------------------------------------------------------------------
    */

        if ($request->filled('capacity')) {

            $query->where(
                'capacity',
                '>=',
                $request->capacity
            );
        }

        /*
    |----------------------------------------------------------------------
    | FILTER PRICE
    |----------------------------------------------------------------------
    */

        if ($request->filled('max_price')) {

            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        $rooms = $query
            ->latest()
            ->paginate(9);

        return view(
            'guest.rooms.index',
            compact('rooms')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ROOM DETAIL
    |--------------------------------------------------------------------------
    */

    public function show(Room $room)
    {
        $room->load([
            'images',
        ]);

        return view(
            'guest.rooms.show',
            compact('room')
        );
    }
}
