<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
            'room_code' => 'required|unique:rooms|alpha_dash|uppercase',
            'room_name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0|max:100000000', // toi da 100 trieu
            'capacity' => 'required|integer|min:1|max:10',
            'status' => 'required|in:available,occupied,cleaning,maintenance',
        ]);

        // default status la available
        $validated['status'] = $validated['status'] ?? 'available';

        Room::create($validated);

        return redirect()->route('host.rooms.index')
            ->with('success', 'Đã tạo phòng thành công.');
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
            'room_code' => 'required|unique:rooms,room_code,' . $room->id . '|alpha_dash|uppercase',
            'room_name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0|max:100000000',
            'capacity' => 'required|integer|min:1|max:10',
            'status' => 'required|in:available,occupied,cleaning,maintenance',
        ]);

        // check nếu đang đổi trạng thái từ occupied sang trạng thái khác (trừ cleaning)
        if ($room->status === 'occupied' && $validated['status'] !== 'cleaning') {
            // check có booking nào đã xác nhận hoặc đang check-in không
            $hasActiveBookings = $room->bookings()
                ->whereIn('status', ['confirmed', 'checked_in'])
                ->exists();

            if ($hasActiveBookings) {
                return back()->withErrors('Không thể thay đổi trạng thái phòng khi đang có đặt phòng đã xác nhận hoặc khách đang lưu trú.');
            }
        }

        // if chuyển sang occupied, kiểm tra có booking nào sắp tới ko
        if ($validated['status'] === 'occupied') {
            $upcomingBooking = $room->bookings()
                ->where('status', 'confirmed')
                ->where('check_in_date', '>', now())
                ->exists();
            if ($upcomingBooking) {
                // cảnh báo
                Session::flash('warning', 'Phòng này có đặt phòng trong tương lai, hãy chắc chắn bạn muốn đặt trạng thái đang sử dụng.');
            }
        }

        $room->update($validated);

        return redirect()->route('host.rooms.index')
            ->with('success', 'Đã cập nhật phòng thành công.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE ROOM
    |--------------------------------------------------------------------------
    */

    public function destroy(Room $room)
    {
        // check nếu phòng có booking đang hoạt động
        $activeBookings = $room->bookings()->whereIn('status', [
            'pending',
            'awaiting_deposit',
            'confirmed',
            'checked_in'
        ])->exists();

        if ($activeBookings) {
            return back()->withErrors('Không thể xóa phòng vì đang có đặt phòng chưa hoàn tất.');
        }

        $room->delete();

        return redirect()->route('host.rooms.index')
            ->with('success', 'Đã xóa phòng thành công.');
    }
}
