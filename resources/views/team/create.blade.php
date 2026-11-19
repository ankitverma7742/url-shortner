@extends('layout')

@section('content')

<h3>Invite New Team Member</h3>

<form method="POST" action="{{ route('team.store') }}">
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

    <p>
        Role<br>

        <select name="role" required>
            <option value="member">Member</option>
            <option value="admin">Admin</option>
        </select>
    </p>

    <button type="submit">Send Invitation</button>
</form>

@endsection