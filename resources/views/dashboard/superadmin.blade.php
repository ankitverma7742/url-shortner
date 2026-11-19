@extends('layout')

@section('content')

<h3>Clients</h3>

<p>
    <a href="{{ route('clients.create') }}">Invite</a>
</p>

<table border="1" cellpadding="6">
    <tr>
        <th>Client Name</th>
        <th>Users</th>
        <th>Total Generated URLs</th>
        <th>Total URL Hits</th>
    </tr>

    @forelse($companies as $c)
        <tr>
            <td>
                {{ $c->name }}
                <br>
                <small>{{ $c->email }}</small>
            </td>

            <td>{{ $c->users_count }}</td>

            <td>{{ $c->short_urls_count }}</td>

            <td>{{ $c->short_urls_sum_hits ?? 0 }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4">No clients found</td>
        </tr>
    @endforelse
</table>

@include('partials.pager', ['paginator' => $companies])

<h3>Generated Short URLs</h3>

@include('partials.urls', [
    'urls' => $urls,
    'column' => 'company'
])
@include('partials.invitations', ['invitations' => $invitations])
@endsection