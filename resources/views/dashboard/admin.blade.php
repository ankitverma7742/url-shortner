@extends('layout')

@section('content')

<h3>Generated Short URLs</h3>

<p>
    <a href="{{ route('urls.create') }}">Generate</a>
</p>

@include('partials.urls', [
    'urls' => $urls,
    'column' => 'user'
])

<h3>Team Members</h3>

<p>
    <a href="{{ route('team.create') }}">Invite</a>
</p>

<table border="1" cellpadding="6">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Total Generated URLs</th>
        <th>Total URL Hits</th>
    </tr>

    @forelse($members as $m)
        <tr>
            <td>{{ $m->name }}</td>
            <td>{{ $m->email }}</td>
            <td>{{ $m->role }}</td>
            <td>{{ $m->short_urls_count }}</td>
            <td>{{ $m->short_urls_sum_hits ?? 0 }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No team members found</td>
        </tr>
    @endforelse
</table>

@include('partials.pager', ['paginator' => $members])
@include('partials.invitations', ['invitations' => $invitations])

@endsection