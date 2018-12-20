@if ($paginator->hasPages())
    <ul class="pagination pages" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="page-item disabled" aria-disabled="true">
                <span class="page-link">@lang('pagination.previous')</span>
            </span>
        @else
            <span class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
            </span>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <span class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
            </span>
        @else
            <span class="page-item disabled" aria-disabled="true">
                <span class="page-link">@lang('pagination.next')</span>
            </span>
        @endif
    </ul>
@endif
