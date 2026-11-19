@extends('layout')

@section('content')

<h3>Generate Short URL</h3>

<form method="POST" action="{{ route('urls.store') }}">
    @csrf

    <p>
        Long URL<br>

        <input
            type="url"
            name="original_url"
            value="{{ old('original_url') }}"
            size="60"
            placeholder="https://sembark.com/..."
            required
        >
    </p>

    <button type="submit">Generate</button>
</form>

@endsection