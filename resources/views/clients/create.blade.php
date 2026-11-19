@extends('layout')

@section('content')

<h3>Invite New Client</h3>

<form method="POST" action="{{ route('clients.store') }}">
    @csrf

    <p>
        Name<br>
        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            required
        >
    </p>

    <p>
        Email<br>
        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
        >
    </p>

    <button type="submit">Send Invitation</button>
</form>

@endsection