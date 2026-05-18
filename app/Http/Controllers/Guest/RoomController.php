<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query()->with(['mainImage', 'images']);

        if ($request->filled('keyword')) {
            $query->where('room_name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('price')) {
            if ($request->price === 'low') {
                $query->where('price', '<', 500000);
            }

            if ($request->price === 'medium') {
                $query->whereBetween('price', [500000, 1000000]);
            }

            if ($request->price === 'high') {
                $query->where('price', '>', 1000000);
            }
        }

        if ($request->filled('capacity')) {
            if ((int) $request->capacity === 4) {
                $query->where('capacity', '>=', 4);
            } else {
                $query->where('capacity', $request->capacity);
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sort_price')) {
            $query->orderBy('price', $request->sort_price);
        } else {
            if ($request->filled('sort_time')) {
                if ($request->sort_time === 'latest') {
                    $query->latest();
                } elseif ($request->sort_time === 'oldest') {
                    $query->oldest();
                }
            } else {
                $query->latest();
            }
        }

        $rooms = $query->paginate(9)->withQueryString();

        return view('guest.rooms.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        $room->load([
            'images' => fn ($query) => $query->orderByDesc('is_main')->orderBy('id'),
            'mainImage',
        ]);

        return view('guest.rooms.show', compact('room'));
    }
}