<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('host.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $bookings = Booking::where('user_id', $user->id)
            ->with('room')
            ->latest()
            ->get();

        return view('host.users.show', compact('user', 'bookings'));
    }

    public function edit(User $user)
    {
        return view('host.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date',
            'role' => 'required|in:host,guest',
        ]);

        $user->update([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'birthday' => $request->birthday,
            'role' => $request->role,
        ]);

        return redirect()->route('host.users.index')
            ->with('success', 'Đã cập nhật người dùng thành công.');
    }

    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->withErrors('Bạn không thể xoá chính mình');
        }

        if ($user->role === 'host') {
            return back()->withErrors('Bạn không thể xoá tài khoản quản trị viên khác');
        }

        $user->delete();

        return back()->with('success', 'Đã xóa người dùng thành công.');
    }
}
