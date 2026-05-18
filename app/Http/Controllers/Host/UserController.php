<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

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
            ->with('success', 'Cập nhật user thành công');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->withErrors('Bạn không thể xoá chính mình');
        }

        $user->delete();

        return back()->with('success', 'Xoá user thành công');
    }
}
