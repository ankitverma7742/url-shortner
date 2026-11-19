@extends('layout')

@section('content')

<h3>Login</h3>

<form method="POST" action="{{ route('login.attempt') }}">
    @csrf

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
        Password<br>
        <input
            type="password"
            name="password"
            required
        >
    </p>

    <button type="submit">Login</button>
</form>

@endsection