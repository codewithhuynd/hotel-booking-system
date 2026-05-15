<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomImageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | UPLOAD IMAGE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request, Room $room)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store(
            'rooms',
            'public'
        );

        RoomImage::create([
            'room_id' => $room->id,
            'image_path' => $path,
            'is_main' => false,
        ]);

        return back()->with(
            'success',
            'Image uploaded successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE IMAGE
    |--------------------------------------------------------------------------
    */

    public function destroy(RoomImage $roomImage)
    {
        Storage::disk('public')->delete(
            $roomImage->image_path
        );

        $roomImage->delete();

        return back()->with(
            'success',
            'Image deleted successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SET MAIN IMAGE
    |--------------------------------------------------------------------------
    */

    public function setMain(RoomImage $roomImage)
    {
        RoomImage::where(
            'room_id',
            $roomImage->room_id
        )->update([
            'is_main' => false
        ]);

        $roomImage->update([
            'is_main' => true
        ]);

        return back()->with(
            'success',
            'Main image updated.'
        );
    }
}