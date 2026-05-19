@extends('host.layouts.app')

@section('title', 'Payment Methods')

@section('content')

<h1>Payment Methods</h1>

<br>

<a href="{{ route('host.payment-methods.create') }}">
    Create Payment Method
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>QR</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    @foreach($paymentMethods as $method)

        <tr>

            <td>{{ $method->id }}</td>

            <td>{{ $method->name }}</td>

            <td>{{ $method->type }}</td>

            <td>

                @if($method->qr_image)

                    <img
                        src="{{ asset('storage/' . $method->qr_image) }}"
                        width="100"
                    >

                @endif

            </td>

            <td>

                {{ $method->is_active ? 'Active' : 'Inactive' }}

            </td>

            <td>

                <a
                    href="{{ route('host.payment-methods.edit', $method) }}"
                >
                    Edit
                </a>

                <br><br>

                <form
                    method="POST"
                    action="{{ route('host.payment-methods.destroy', $method) }}"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        onclick="return confirm('Delete?')"
                    >
                        Delete
                    </button>

                </form>

            </td>

        </tr>

    @endforeach

</table>

@endsection