@if ($paginator->hasPages() || $paginator->total() > 0)

@php
    /* Pick whichever per-page session key the current page uses */
    $currentPerPage = (int) (
        session('home_per_page')
        ?? session('admin_per_page')
        ?? session('student_per_page')
        ?? 10
    );
    if (! in_array($currentPerPage, [10, 25, 50, 100], true)) {
        $currentPerPage = 10;
    }
@endphp

<div class="pg-wrapper">

    {{-- ══════════ LEFT: INFO + PER-PAGE ══════════ --}}
    <div class="pg-info">

        <span class="pg-info__text">
            Showing
            <strong>{{ $paginator->firstItem() ?? 0 }}</strong>–<strong>{{ $paginator->lastItem() ?? 0 }}</strong>
            of <strong>{{ $paginator->total() }}</strong>
        </span>

        <form method="GET" class="pg-perpage" data-perpage-form>
            {{-- Preserve all other query params (search, category, dates, etc.) --}}
            @foreach(request()->except(['per_page', 'page']) as $key => $value)
                @if(is_scalar($value) && $value !== '')
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach

            <label class="pg-perpage__label">Rows</label>
            <select name="per_page" class="pg-perpage__select" data-perpage-select
                    aria-label="Rows per page">
                @foreach ([10, 25, 50, 100] as $n)
                    <option value="{{ $n }}" @selected($currentPerPage === $n)>
                        {{ $n }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- ══════════ RIGHT: PAGE LINKS ══════════ --}}
    @if ($paginator->hasPages())
    <nav class="pg-nav" aria-label="Pagination Navigation">
        <ul class="pg-list">

            {{-- Prev --}}
            @if ($paginator->onFirstPage())
                <li class="pg-item is-disabled">
                    <span class="pg-link" aria-disabled="true">
                        <svg class="pg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                        <span class="pg-label">Prev</span>
                    </span>
                </li>
            @else
                <li class="pg-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="pg-link" rel="prev">
                        <svg class="pg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                        <span class="pg-label">Prev</span>
                    </a>
                </li>
            @endif

            {{-- Page numbers with ellipsis --}}
            @foreach ($elements as $element)

                @if (is_string($element))
                    <li class="pg-item is-dots">
                        <span class="pg-link">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pg-item is-active">
                                <span class="pg-link" aria-current="page">{{ $page }}</span>
                            </li>
                        @else
                            <li class="pg-item">
                                <a href="{{ $url }}" class="pg-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif

            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li class="pg-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="pg-link" rel="next">
                        <span class="pg-label">Next</span>
                        <svg class="pg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                </li>
            @else
                <li class="pg-item is-disabled">
                    <span class="pg-link" aria-disabled="true">
                        <span class="pg-label">Next</span>
                        <svg class="pg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </span>
                </li>
            @endif

        </ul>
    </nav>
    @endif

</div>
@endif