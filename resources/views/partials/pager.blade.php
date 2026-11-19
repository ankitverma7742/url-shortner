@if ($paginator->total() > 0)

    <p>
        Showing {{ $paginator->count() }}
        of total {{ $paginator->total() }}

        @if ($paginator->onFirstPage())
            <span>&larr; Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">
                &larr; Prev
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">
                Next &rarr;
            </a>
        @else
            <span>Next &rarr;</span>
        @endif
    </p>

@endif