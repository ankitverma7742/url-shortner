@extends('layout')

@section('content')

<h3>Generated Short URLs</h3>

<p>
    <a href="{{ route('urls.create') }}">Generate</a>
</p>

@include('partials.urls', ['urls' => $urls])

@endsection