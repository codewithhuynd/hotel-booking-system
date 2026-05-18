<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\HotelSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelSettingController extends Controller
{
    public function index()
    {
        $setting = HotelSetting::firstOrCreate(
            [],
            [
                'hero_title' => 'Tìm khách sạn phù hợp cho bạn',
                'hero_description' => 'Đặt phòng nhanh chóng, dễ dàng và tiện lợi.',
                'hotline' => '+84 123 456 789',
                'email' => 'support@hotelbooking.com',
                'address' => 'TP. Hồ Chí Minh, Việt Nam',
                'working_hours' => 'Hỗ trợ khách hàng 24/7',
                'facebook_link' => '#',
                'google_map_link' => '#',
            ]
        );

        return view('host.hotel-settings.index', compact('setting'));
    }

    public function edit()
    {
        $setting = HotelSetting::firstOrCreate(
            [],
            [
                'hero_title' => 'Tìm khách sạn phù hợp cho bạn',
                'hero_description' => 'Đặt phòng nhanh chóng, dễ dàng và tiện lợi.',
                'hotline' => '+84 123 456 789',
                'email' => 'support@hotelbooking.com',
                'address' => 'TP. Hồ Chí Minh, Việt Nam',
                'working_hours' => 'Hỗ trợ khách hàng 24/7',
                'facebook_link' => '#',
                'google_map_link' => '#',
            ]
        );

        return view('host.hotel-settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = HotelSetting::firstOrCreate([]);

        $validated = $request->validate([
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_description' => ['required', 'string'],
            'hero_image' => ['nullable', 'image', 'max:4096'],

            'hotline' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'working_hours' => ['nullable', 'string', 'max:255'],
            'facebook_link' => ['nullable', 'url', 'max:255'],
            'google_map_link' => ['nullable', 'url', 'max:255'],
        ]);

        if ($request->hasFile('hero_image')) {
            if ($setting->hero_image) {
                Storage::disk('public')->delete($setting->hero_image);
            }

            $validated['hero_image'] = $request->file('hero_image')->store(
                'hotel-settings',
                'public'
            );
        }

        $setting->update($validated);

        return redirect()
            ->route('host.hotel-settings.index')
            ->with('success', 'Hotel settings đã được cập nhật.');
    }
}