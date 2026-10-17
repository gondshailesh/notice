@if ($paginator->hasPages())
  <div class="pg-wrapper">

    {{-- Left side: "Showing X–Y of Z" + per-page selector --}}
    <div class="pg-info">
      <p class="pg-info__text mb-0">
        Showing
        <strong>{{ $paginator->firstItem() }}</strong>
        to
        <strong>{{ $paginator->lastItem() }}</strong>
        of
        <strong>{{ $paginator->total() }}</strong>
        results
      </p>

      <form method="GET" class="pg-perpage" data-perpage-form>
        {{-- Preserve ALL current filters so changing per-page keeps them --}}
        @foreach (request()->except(['per_page', 'page']) as $key => $value)
          @if (is_scalar($value))
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
          @endif
        @endforeach

        <label for="perPage" class="pg-perpage__label">Per page:</label>
        <select name="per_page"
                id="perPage"
                class="pg-perpage__select"
                data-perpage-select
                aria-label="Items per page">
          @foreach ([10, 25, 50, 100] as $size)
            <option value="{{ $size }}"
              @selected((int) session('admin_per_page', 10) === $size)>
              {{ $size }}
            </option>
          @endforeach
        </select>
      </form>
    </div>

    {{-- Right side: numbered pagination --}}
    <nav class="pg-nav" role="navigation" aria-label="Pagination Navigation">
      <ul class="pg-list">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
          <li class="pg-item is-disabled" aria-disabled="true">
            <span class="pg-link" aria-hidden="true">
              <svg class="pg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
              <span class="pg-label">Prev</span>
            </span>
          </li>
        @else
          <li class="pg-item">
            {{-- ✅ $paginator->previousPageUrl() already respects withQueryString() --}}
            <a href="{{ $paginator->previousPageUrl() }}"
               class="pg-link"
               rel="prev"
               aria-label="Previous page">
              <svg class="pg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
              <span class="pg-label">Prev</span>
            </a>
          </li>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
          {{-- "Three dots" separator --}}
          @if (is_string($element))
            <li class="pg-item is-dots" aria-disabled="true">
              <span class="pg-link">{{ $element }}</span>
            </li>
          @endif

          {{-- Array of links --}}
          @if (is_array($element))
            @foreach ($element as $page => $url)
              @if ($page == $paginator->currentPage())
                <li class="pg-item is-active" aria-current="page">
                  <span class="pg-link">{{ $page }}</span>
                </li>
              @else
                <li class="pg-item">
                  {{-- ✅ THIS is the line that matters.
                       $paginator->url($page) re-applies withQueryString(),
                       so ?priority=Urgent survives page changes.
                       Do NOT replace with '?page='.$page — that drops filters. --}}
                  <a href="{{ $paginator->url($page) }}"
                     class="pg-link"
                     aria-label="Go to page {{ $page }}">
                    {{ $page }}
                  </a>
                </li>
              @endif
            @endforeach
          @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
          <li class="pg-item">
            <a href="{{ $paginator->nextPageUrl() }}"
               class="pg-link"
               rel="next"
               aria-label="Next page">
              <span class="pg-label">Next</span>
              <svg class="pg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
          </li>
        @else
          <li class="pg-item is-disabled" aria-disabled="true">
            <span class="pg-link" aria-hidden="true">
              <span class="pg-label">Next</span>
              <svg class="pg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </span>
          </li>
        @endif

      </ul>
    </nav>
  </div>
@endif