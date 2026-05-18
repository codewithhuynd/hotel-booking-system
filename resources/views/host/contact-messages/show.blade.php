@extends('host.layouts.app')

@section('title', 'Contact Message Detail')

@section('content')

<h1>Contact Message Detail</h1>

<br>

@if(session('success'))
<p style="color:green;">{{ session('success') }}</p>
<br>
@endif

<div style="background:white; padding:24px; border-radius:10px;">

    <p><strong>Name:</strong> {{ $contactMessage->name }}</p>
    <p><strong>Email:</strong> {{ $contactMessage->email }}</p>
    <p>
        <strong>User:</strong>
        {{ $contactMessage->user ? $contactMessage->user->full_name : 'Public user' }}
    </p>
    <p><strong>Status:</strong> {{ strtoupper($contactMessage->status) }}</p>
    <p><strong>Created:</strong> {{ $contactMessage->created_at->format('d/m/Y H:i') }}</p>

    <br>

    <p><strong>Message:</strong></p>
    <div style="background:#f8fafc; padding:16px; border-radius:8px;">
        {{ $contactMessage->message }}
    </div>

    <br>

    @if($contactMessage->reply_message)
    <p><strong>Last reply:</strong></p>
    <div style="background:#ecfeff; padding:16px; border-radius:8px;">
        {{ $contactMessage->reply_message }}
    </div>
    <br>
    @endif

    <br>

    <form method="POST" action="{{ route('host.contact-messages.reply', $contactMessage) }}">
        @csrf

        @if($contactMessage->status !== 'replied')

        <button
            type="submit"
            style="
                padding:10px 16px;
                background:#2563eb;
                color:white;
                border:none;
                border-radius:8px;
                cursor:pointer;
            ">
            Mark as Replied
        </button>

        @else

        <button
            disabled
            style="
                padding:10px 16px;
                background:#94a3b8;
                color:white;
                border:none;
                border-radius:8px;
                border-radius:8px;
            ">
            Already Replied
        </button>

        @endif

    </form>

</div>

@endsection