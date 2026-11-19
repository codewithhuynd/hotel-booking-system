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
            'images' => 'required|array|max:10',
            'images.*' => 'image|max:5120',
        ], [
            'images.required' => 'Vui lòng chọn ít nhất một ảnh.',
            'images.max' => 'Mỗi lần chỉ tải tối đa 10 ảnh.',
            'images.*.image' => 'File tải lên phải là ảnh.',
            'images.*.max' => 'Mỗi ảnh không được vượt quá 5MB.',
        ]);

        // Phòng chưa có ảnh chính thì ảnh đầu tiên tải lên sẽ là ảnh chính.
        $needsMain = ! $room->images()->where('is_main', true)->exists();

        foreach ($request->file('images') as $file) {

            $path = $file->store(
                'rooms',
                'public'
            );

            RoomImage::create([
                'room_id' => $room->id,
                'image_path' => $path,
                'is_main' => $needsMain,
            ]);

            $needsMain = false;
        }

        return back()->with(
            'success',
            'Images uploaded successfully.'
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

        $wasMain = $roomImage->is_main;
        $roomId = $roomImage->room_id;

        $roomImage->delete();

        // Xoá ảnh chính thì chọn ảnh còn lại đầu tiên làm ảnh chính.
        if ($wasMain) {
            RoomImage::where('room_id', $roomId)->orderBy('id')->first()?->update(['is_main' => true]);
        }

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
