@extends('layout')

@section('content')

<h3>Accept Invitation</h3>

<p>Email: {{ $invitation->email }}</p>

<form method="POST" action="{{ route('invitation.accept', $invitation->token) }}">
    @csrf

    <p>
        Name<br>
        <input
            type="text"
            name="name"
            value="{{ old('name', $invitation->name) }}"
            required
        >
    </p>

    <p>
        Password<br>
        <input
            type="password"
            name="password"
            required
        >
    </p>

    <p>
        Confirm Password<br>
        <input
            type="password"
            name="password_confirmation"
            required
        >
    </p>

    <button type="submit">Create Account</button>
</form>

@endsection