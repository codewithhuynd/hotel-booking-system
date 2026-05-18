@extends('host.layouts.app')

@section('title', 'Hotel Settings')

@section('content')

<h1>Hotel Settings</h1>

<br>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
    <br>
@endif

<div style="background:white; padding:24px; border-radius:12px;">

    <p><strong>Hero Title:</strong> {{ $setting->hero_title }}</p>
    <p><strong>Hero Description:</strong> {{ $setting->hero_description }}</p>
    <p><strong>Hotline:</strong> {{ $setting->hotline }}</p>
    <p><strong>Email:</strong> {{ $setting->email }}</p>
    <p><strong>Address:</strong> {{ $setting->address }}</p>
    <p><strong>Working Hours:</strong> {{ $setting->working_hours }}</p>
    <p><strong>Facebook:</strong> {{ $setting->facebook_link }}</p>
    <p><strong>Map:</strong> {{ $setting->google_map_link }}</p>

    <br>

    <a
        href="{{ route('host.hotel-settings.edit') }}"
        style="padding:10px 14px; background:#2563eb; color:white; text-decoration:none; border-radius:8px;">
        Edit Settings
    </a>

</div>

@endsection