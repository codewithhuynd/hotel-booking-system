@extends('host.layouts.app')

@section('title', 'Manage About Sections')

@section('content')

<h1>Manage About Sections</h1>

<br>

<a href="{{ route('host.about-sections.create') }}"
   style="padding:10px 14px; background:#16a34a; color:white; text-decoration:none; border-radius:8px;">
    Add New
</a>

<br><br>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
    <br>
@endif

<table border="1" cellpadding="12" cellspacing="0" width="100%" style="background:white; border-collapse:collapse;">
    <tr style="background:#1e293b; color:white;">
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Action</th>
    </tr>

    @forelse($sections as $section)
        <tr>
            <td>{{ $section->id }}</td>
            <td>{{ $section->title }}</td>
            <td>{{ $section->description }}</td>
            <td>
                <a href="{{ route('host.about-sections.edit', $section) }}"
                   style="padding:8px 12px; background:#2563eb; color:white; text-decoration:none; border-radius:6px;">
                    Edit
                </a>

                <form action="{{ route('host.about-sections.destroy', $section) }}"
                      method="POST"
                      style="display:inline-block;"
                      onsubmit="return confirm('Delete this item?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            style="padding:8px 12px; background:#dc2626; color:white; border:none; border-radius:6px;">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">No about sections found.</td>
        </tr>
    @endforelse
</table>

@endsection