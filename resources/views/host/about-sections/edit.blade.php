@extends('host.layouts.app')

@section('title', 'Edit About Section')

@section('content')

<h1>Edit About Section</h1>

<br>

<form method="POST" action="{{ route('host.about-sections.update', $about_section) }}">
    @csrf
    @method('PUT')

    <div style="margin-bottom:15px;">
        <label>Title</label><br>
        <input type="text" name="title" value="{{ old('title', $about_section->title) }}" style="width:100%; padding:10px;">
        @error('title') <p style="color:red;">{{ $message }}</p> @enderror
    </div>

    <div style="margin-bottom:15px;">
        <label>Description</label><br>
        <textarea name="description" rows="5" style="width:100%; padding:10px;">{{ old('description', $about_section->description) }}</textarea>
        @error('description') <p style="color:red;">{{ $message }}</p> @enderror
    </div>

    <button type="submit" style="padding:10px 14px; background:#2563eb; color:white; border:none; border-radius:8px;">
        Update
    </button>
</form>

@endsection