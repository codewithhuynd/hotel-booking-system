@extends('host.layouts.app')

@section('title', 'Edit Service')

@section('content')

<h1>Edit Service</h1>

<br>

<form method="POST" action="{{ route('host.services.update', $service) }}">
    @csrf
    @method('PUT')

    <div style="margin-bottom:15px;">
        <label>Title</label><br>
        <input type="text" name="title" value="{{ old('title', $service->title) }}" style="width:100%; padding:10px;">
        @error('title') <p style="color:red;">{{ $message }}</p> @enderror
    </div>

    <div style="margin-bottom:15px;">
        <label>Description</label><br>
        <textarea name="description" rows="5" style="width:100%; padding:10px;">{{ old('description', $service->description) }}</textarea>
        @error('description') <p style="color:red;">{{ $message }}</p> @enderror
    </div>

    <button type="submit" style="padding:10px 14px; background:#2563eb; color:white; border:none; border-radius:8px;">
        Update
    </button>
</form>

@endsection