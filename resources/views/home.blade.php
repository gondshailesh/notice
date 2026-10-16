@extends('layouts.app')
@section('title', 'Notice Board')

@section('content')
<div class="container-fluid px-lg-5 py-4">

  {{-- ═════════════════ WELCOME STRIP ═════════════════ --}}
  @auth
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
      <h3 class="fw-bold mb-1">📋 Notice Board</h3>
      <p class="text-muted small mb-0">
        Welcome, <strong>{{ explode(' ', Auth::user()->name)[0] }}</strong>
        @if(Auth::user()->course)
          <span class="badge bg-light text-secondary border rounded-pill ms-1">{{ Auth::user()->course }}</span>
        @endif
      </p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary rounded-pill px-3">
      <i class="bi bi-speedometer2 me-1"></i>My Dashboard
    </a>
  </div>
  @endauth

  {{-- ═════════════════ HERO (Must Read / Urgent) ═════════════════ --}}
  @if($hero)
    <div class="card border-0 rounded-5 overflow-hidden mb-4 text-white shadow-lg"
         style="background:linear-gradient(135deg,#0f172a 0%,#1e293b 100%);border-radius:30px!important;">
      <div class="row g-0">
        <div class="col-md-8 p-4 p-lg-5">
          <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold">
            <i class="bi bi-megaphone-fill me-1"></i>
            {{ $hero->category === 'must_read' ? 'MUST READ' : strtoupper($hero->priority ?? 'LATEST') }}
          </span>
          <h2 class="fw-bold display-6 mb-3">{{ $hero->title }}</h2>
          <p class="opacity-75 lead mb-3">
            {{ \Illuminate\Support\Str::limit(strip_tags($hero->description), 180) }}
          </p>
          <small class="text-white-50 d-block mb-4">
            <i class="bi bi-calendar-event me-1"></i>
            {{ optional($hero->published_at)->format('d M Y, h:i A') }}
          </small>
          <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('notices.show', $hero->id) }}"
               class="btn btn-outline-light rounded-pill px-4">
              <i class="bi bi-eye me-1"></i>View
            </a>
            @if($hero->attachment_path)
              <a href="{{ route('notices.download', $hero->id) }}"
                 class="btn btn-warning text-dark fw-bold rounded-pill px-4">
                <i class="bi bi-download me-1"></i>Download
              </a>
            @endif
          </div>
        </div>
        <div class="col-md-4 d-none d-md-flex align-items-center justify-content-center bg-white bg-opacity-10">
          <i class="bi bi-journal-text display-1 opacity-25"></i>
        </div>
      </div>
    </div>
  @endif

  {{-- ═════════════════ STATS ═════════════════ --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="text-muted small text-uppercase fw-semibold">Total</div>
            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                 style="width:36px;height:36px;">
              <i class="bi bi-megaphone"></i>
            </div>
          </div>
          <h3 class="fw-bold mb-0 text-primary">{{ $stats['total'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="text-muted small text-uppercase fw-semibold">This Week</div>
            <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center"
                 style="width:36px;height:36px;">
              <i class="bi bi-calendar-week"></i>
            </div>
          </div>
          <h3 class="fw-bold mb-0 text-success">{{ $stats['this_week'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="text-muted small text-uppercase fw-semibold">Urgent</div>
            <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center"
                 style="width:36px;height:36px;">
              <i class="bi bi-exclamation-triangle"></i>
            </div>
          </div>
          <h3 class="fw-bold mb-0 text-danger">{{ $stats['urgent'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="text-muted small text-uppercase fw-semibold">Must Read</div>
            <div class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center"
                 style="width:36px;height:36px;">
              <i class="bi bi-star-fill"></i>
            </div>
          </div>
          <h3 class="fw-bold mb-0 text-warning-emphasis">{{ $stats['must_read'] }}</h3>
        </div>
      </div>
    </div>
  </div>

  {{-- ═════════════════ MAIN: SIDEBAR + NOTICES ═════════════════ --}}
  <div class="row g-4">

    {{-- ───────── SIDEBAR FILTERS ───────── --}}
    <div class="col-lg-3">
      <div class="sticky-top" style="top: 90px; z-index: 100;">

        {{-- Search --}}
        <div class="card border-0 shadow-sm rounded-4 mb-3">
          <div class="card-body p-4">
            <h6 class="fw-bold mb-3">
              <i class="bi bi-search me-2 text-primary"></i>Search
            </h6>
            <form method="GET" action="{{ route('home') }}">
              <input type="text" name="search" class="form-control rounded-pill"
                     placeholder="Keywords..."
                     value="{{ request('search') }}"
                     onchange="this.form.submit()">
            </form>
          </div>
        </div>

        {{-- Categories + Date --}}
        <div class="card border-0 shadow-sm rounded-4 mb-3">
          <div class="card-body p-4">
            <h6 class="fw-bold mb-3">
              <i class="bi bi-filter-left me-2 text-primary"></i>Filters
            </h6>

            <form method="GET" action="{{ route('home') }}" id="filterForm">
              {{-- preserve search + per_page --}}
              @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
              @endif
              <input type="hidden" name="per_page" value="{{ session('home_per_page', 10) }}">

              {{-- Category --}}
              <label class="small fw-semibold text-muted mb-1">Category</label>
              <select name="category" class="form-select form-select-sm rounded-pill mb-3"
                      onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categoryMap as $key => $label)
                  <option value="{{ $key }}" @selected(request('category') === $key)>{{ $label }}</option>
                @endforeach
              </select>

              {{-- Date range --}}
              <label class="small fw-semibold text-muted mb-1">
                <i class="bi bi-calendar3 me-1"></i>From date
              </label>
              <input type="date" name="date_from" class="form-control form-control-sm rounded-pill mb-2"
                     value="{{ request('date_from') }}"
                     max="{{ now()->toDateString() }}">

              <label class="small fw-semibold text-muted mb-1">To date</label>
              <input type="date" name="date_to" class="form-control form-control-sm rounded-pill mb-3"
                     value="{{ request('date_to') }}"
                     max="{{ now()->toDateString() }}">

              <button type="submit" class="btn btn-sm btn-primary w-100 rounded-pill mb-2">
                <i class="bi bi-funnel me-1"></i>Apply Filters
              </button>

              @if(request()->hasAny(['search','category','date_from','date_to']))
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary w-100 rounded-pill">
                  <i class="bi bi-x-circle me-1"></i>Clear All
                </a>
              @endif
            </form>
          </div>
        </div>

        {{-- Quick date presets --}}
        <div class="card border-0 shadow-sm rounded-4">
          <div class="card-body p-4">
            <h6 class="fw-bold mb-3">
              <i class="bi bi-lightning-charge me-2 text-warning"></i>Quick Dates
            </h6>
            <div class="d-grid gap-2">
              <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->toDateString(), 'date_to' => now()->toDateString(), 'page' => null]) }}"
                 class="btn btn-sm btn-outline-secondary rounded-pill text-start">
                <i class="bi bi-calendar-check me-1"></i>Today
              </a>
              <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->subDays(6)->toDateString(), 'date_to' => now()->toDateString(), 'page' => null]) }}"
                 class="btn btn-sm btn-outline-secondary rounded-pill text-start">
                <i class="bi bi-calendar-week me-1"></i>Last 7 days
              </a>
              <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->subDays(29)->toDateString(), 'date_to' => now()->toDateString(), 'page' => null]) }}"
                 class="btn btn-sm btn-outline-secondary rounded-pill text-start">
                <i class="bi bi-calendar-month me-1"></i>Last 30 days
              </a>
              <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->startOfYear()->toDateString(), 'date_to' => now()->toDateString(), 'page' => null]) }}"
                 class="btn btn-sm btn-outline-secondary rounded-pill text-start">
                <i class="bi bi-calendar-range me-1"></i>This Year
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- ───────── NOTICES LIST ───────── --}}
    <div class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h5 class="fw-bold mb-0">
          Recent Notices
          <span class="text-muted small fw-normal">({{ $notices->total() }})</span>
        </h5>
        <span class="text-muted small">
          <i class="bi bi-clock-history me-1"></i>
          Updated {{ now()->format('h:i A') }}
        </span>
      </div>

      {{-- Active filter chips --}}
      @if(request()->hasAny(['search','category','date_from','date_to']))
        <div class="d-flex flex-wrap gap-2 mb-3">
          @if(request('search'))
            <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
              <i class="bi bi-search me-1"></i>{{ request('search') }}
              <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                 class="text-danger ms-1 text-decoration-none">×</a>
            </span>
          @endif
          @if(request('category'))
            <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
              <i class="bi bi-tag me-1"></i>{{ $categoryMap[request('category')] ?? request('category') }}
              <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}"
                 class="text-danger ms-1 text-decoration-none">×</a>
            </span>
          @endif
          @if(request('date_from') || request('date_to'))
            <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
              <i class="bi bi-calendar me-1"></i>
              {{ request('date_from') ? \Carbon\Carbon::parse(request('date_from'))->format('d M') : '…' }}
              →
              {{ request('date_to') ? \Carbon\Carbon::parse(request('date_to'))->format('d M') : '…' }}
              <a href="{{ request()->fullUrlWithQuery(['date_from' => null, 'date_to' => null]) }}"
                 class="text-danger ms-1 text-decoration-none">×</a>
            </span>
          @endif
        </div>
      @endif

      {{-- Notice cards --}}
      <div class="row g-4">
        @forelse($notices as $notice)
          @php
            $isUrgent = strtolower($notice->priority ?? '') === 'urgent';
            $theme = match($notice->category) {
              'must_read'    => ['c' => 'warning', 'i' => 'bi-star-fill'],
              'examination'  => ['c' => 'danger',  'i' => 'bi-pencil-square'],
              'placement'    => ['c' => 'success', 'i' => 'bi-briefcase'],
              'event'        => ['c' => 'info',    'i' => 'bi-cpu'],
              'urgent'       => ['c' => 'danger',  'i' => 'bi-exclamation-triangle-fill'],
              default        => ['c' => 'primary', 'i' => 'bi-file-earmark-text'],
            };
          @endphp

          <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 notice-card position-relative overflow-hidden">
              <div class="priority-label rounded-pill bg-{{ $isUrgent ? 'danger' : $theme['c'] }} text-{{ $theme['c'] === 'warning' ? 'dark' : 'white' }}">
                {{ optional($notice->published_at)->format('d M') }}
              </div>

              <div class="card-body p-4 d-flex flex-column">
                <div class="icon-box rounded-circle bg-{{ $theme['c'] }}-subtle text-{{ $theme['c'] }} mb-3">
                  <i class="bi {{ $theme['i'] }} fs-4"></i>
                </div>

                <h6 class="fw-bold text-dark mb-2">{{ $notice->title }}</h6>
                <div class="text-muted small flex-grow-1 line-clamp-3 mb-3">
                  {{ \Illuminate\Support\Str::limit(strip_tags($notice->description), 120) }}
                </div>

                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                  <span class="badge rounded-pill bg-light text-secondary border px-3">
                    {{ $categoryMap[$notice->category] ?? ucfirst($notice->category) }}
                  </span>
                  <div class="d-flex gap-1">
                    <a href="{{ route('notices.show', $notice->id) }}"
                       class="btn btn-sm btn-outline-info rounded-circle"
                       style="width:34px;height:34px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                       title="View">
                      <i class="bi bi-eye"></i>
                    </a>
                    @if($notice->attachment_path)
                      <a href="{{ route('notices.download', $notice->id) }}"
                         class="btn btn-sm btn-primary rounded-circle"
                         style="width:34px;height:34px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                         title="Download">
                        <i class="bi bi-download"></i>
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12 text-center py-5">
            <i class="bi bi-inbox display-1 text-muted opacity-25"></i>
            <h5 class="mt-3 text-muted">No notices found</h5>
            <p class="text-muted">
              @if(request()->hasAny(['search','category','date_from','date_to']))
                Try adjusting your filters.
              @else
                No notices have been posted yet.
              @endif
            </p>
            @if(request()->hasAny(['search','category','date_from','date_to']))
              <a href="{{ route('home') }}" class="btn btn-link">Clear all filters</a>
            @endif
          </div>
        @endforelse
      </div>

      {{-- PAGINATION --}}
      @if($notices->total() > 0)
        <div class="mt-4">
          {{ $notices->links('vendor.pagination.custom') }}
        </div>
      @endif
    </div>

  </div>
</div>
@endsection

{{-- ═════════════════ STYLES ═════════════════ --}}
@push('styles')
<style>
  .stat-card { transition: transform .25s ease, box-shadow .25s ease; }
  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,.08) !important;
  }

  .notice-card {
    transition: transform .3s ease, box-shadow .3s ease;
    border-radius: 20px !important;
  }
  .notice-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,.08) !important;
  }

  .priority-label {
    position: absolute; top: 15px; right: 15px;
    padding: 4px 14px; font-size: .72rem; font-weight: 700; z-index: 5;
  }

  .icon-box {
    width: 50px; height: 50px;
    display: flex; align-items: center; justify-content: center;
  }

  .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* Bootstrap subtle backgrounds */
  .bg-warning-subtle{background:#fff3cd!important;color:#856404!important}
  .bg-danger-subtle {background:#f8d7da!important;color:#721c24!important}
  .bg-success-subtle{background:#d1e7dd!important;color:#0f5132!important}
  .bg-info-subtle   {background:#cff4fc!important;color:#055160!important}
  .bg-primary-subtle{background:#cfe2ff!important;color:#084298!important}

  /* Pagination fallback */
  .pg-wrapper {
    display: flex; flex-wrap: wrap; align-items: center;
    justify-content: space-between; gap: 1rem; padding: .5rem 0;
  }
  .pg-info { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
  .pg-info__text { font-size: .875rem; color: #6b7280; }
  .pg-info__text strong { color: #111827; font-weight: 600; }

  .pg-perpage { display: flex; align-items: center; gap: .5rem; margin: 0; }
  .pg-perpage__label { font-size: .8125rem; color: #6b7280; margin: 0; }
  .pg-perpage__select {
    appearance: none; -webkit-appearance: none;
    background: #fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>") no-repeat right 10px center;
    border: 1px solid #e5e7eb; border-radius: 999px;
    padding: .35rem 2rem .35rem .875rem; font-size: .8125rem;
    font-weight: 500; color: #111827; cursor: pointer; min-width: 72px;
  }

  .pg-list {
    display: flex; align-items: center; gap: .375rem;
    list-style: none; margin: 0; padding: 0; flex-wrap: wrap;
  }
  .pg-link {
    display: inline-flex; align-items: center; justify-content: center;
    gap: .35rem; min-width: 40px; height: 40px; padding: 0 .75rem;
    font-size: .875rem; font-weight: 500; color: #374151;
    background: #fff; border: 1px solid #e5e7eb; border-radius: 999px;
    text-decoration: none; transition: all .15s; line-height: 1;
  }
  .pg-item.is-active .pg-link {
    color: #fff;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    border-color: transparent; font-weight: 600;
  }
</style>
@endpush

{{-- ═════════════════ SCRIPTS ═════════════════ --}}
@push('scripts')
<script>
  document.addEventListener('change', function (e) {
    if (e.target.matches('[data-perpage-select]')) {
      e.target.closest('[data-perpage-form]').submit();
    }
  });
</script>
@endpush