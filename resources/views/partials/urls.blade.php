@php($column = $column ?? null)

<table border="1" cellpadding="6">
    <tr>
        <th>Short URL</th>
        <th>Long URL</th>
        <th>Hits</th>

        @if($column === 'company')
            <th>Company</th>
        @elseif($column === 'user')
            <th>User</th>
        @endif

        <th>Created On</th>
    </tr>

    @forelse($urls as $url)
        <tr>
            <td>
                <a href="{{ $url->short_link }}" target="_blank">
                    {{ $url->short_link }}
                </a>
            </td>

            <td>
                {{ \Illuminate\Support\Str::limit($url->original_url, 40) }}
            </td>

            <td>{{ $url->hits }}</td>

            @if($column === 'company')
                <td>{{ $url->company->name }}</td>
            @elseif($column === 'user')
                <td>{{ $url->user->name }}</td>
            @endif

            <td>{{ $url->created_at->format("d M 'y") }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="{{ $column ? 5 : 4 }}">
                No URLs yet
            </td>
        </tr>
    @endforelse
</table>

@include('partials.pager', ['paginator' => $urls])