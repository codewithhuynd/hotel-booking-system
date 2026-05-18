<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\HotelSetting;
use App\Models\AboutSection;
use App\Models\Service;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('images');
        $hotelSetting = HotelSetting::first();

        $aboutSections = AboutSection::latest()->get();

        $services = Service::latest()->get();

        /*
        |--------------------------------------------------------------------------
        | 1. Keyword
        |--------------------------------------------------------------------------
        */
        if ($request->filled('keyword')) {
            $query->where('room_name', 'like', '%' . $request->keyword . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Price Filter
        |--------------------------------------------------------------------------
        */
        if ($request->price === 'low') {
            $query->where('price', '<', 500000);
        }

        if ($request->price === 'medium') {
            $query->whereBetween('price', [500000, 1000000]);
        }

        if ($request->price === 'high') {
            $query->where('price', '>', 1000000);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Capacity Filter
        |--------------------------------------------------------------------------
        */
        if ($request->capacity === '1') {
            $query->where('capacity', 1);
        }

        if ($request->capacity === '2') {
            $query->where('capacity', 2);
        }

        if ($request->capacity === '4') {
            $query->where('capacity', '>=', 4);
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Status Filter
        |--------------------------------------------------------------------------
        */
        if ($request->status === 'available') {
            $query->where('status', 'available');
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Sort By Price
        |--------------------------------------------------------------------------
        */
        if ($request->sort_price === 'asc') {
            $query->orderBy('price', 'asc');
        }

        if ($request->sort_price === 'desc') {
            $query->orderBy('price', 'desc');
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Sort By Time
        |--------------------------------------------------------------------------
        */
        if ($request->sort_time === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $rooms = $query
            ->take(6)
            ->get();

        return view('home', compact(
            'rooms',
            'hotelSetting',
            'aboutSections',
            'services'
        ));
    }
}
