@extends('host.layouts.app')

@section('title', 'Edit Hotel Settings')

@section('content')

<h1>Edit Hotel Settings</h1>

<br>

<form method="POST" action="{{ route('host.hotel-settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="margin-bottom:15px;">
        <label>Hero Title</label><br>
        <input type="text" name="hero_title" value="{{ old('hero_title', $setting->hero_title) }}" style="width:100%; padding:10px;">
        @error('hero_title') <p style="color:red;">{{ $message }}</p> @enderror
    </div>

    <div style="margin-bottom:15px;">
        <label>Hero Description</label><br>
        <textarea name="hero_description" rows="4" style="width:100%; padding:10px;">{{ old('hero_description', $setting->hero_description) }}</textarea>
        @error('hero_description') <p style="color:red;">{{ $message }}</p> @enderror
    </div>

    <div style="margin-bottom:15px;">
        <label>Hero Image</label><br>
        <input type="file" name="hero_image">
        @if($setting->hero_image)
            <p style="margin-top:8px;">Current: {{ $setting->hero_image }}</p>
        @endif
        @error('hero_image') <p style="color:red;">{{ $message }}</p> @enderror
    </div>

    <div style="margin-bottom:15px;">
        <label>Hotline</label><br>
        <input type="text" name="hotline" value="{{ old('hotline', $setting->hotline) }}" style="width:100%; padding:10px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email', $setting->email) }}" style="width:100%; padding:10px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Address</label><br>
        <input type="text" name="address" value="{{ old('address', $setting->address) }}" style="width:100%; padding:10px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Working Hours</label><br>
        <input type="text" name="working_hours" value="{{ old('working_hours', $setting->working_hours) }}" style="width:100%; padding:10px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Facebook Link</label><br>
        <input type="url" name="facebook_link" value="{{ old('facebook_link', $setting->facebook_link) }}" style="width:100%; padding:10px;">
    </div>

    <div style="margin-bottom:15px;">
        <label>Google Map Link</label><br>
        <input type="url" name="google_map_link" value="{{ old('google_map_link', $setting->google_map_link) }}" style="width:100%; padding:10px;">
    </div>

    <button type="submit" style="padding:10px 14px; background:#16a34a; color:white; border:none; border-radius:8px;">
        Save
    </button>
</form>

@endsection