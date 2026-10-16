@extends('layouts.app')
@section('title','My Dashboard')

@section('content')
<div class="container py-4">

  {{-- ══════════ WELCOME BANNER ══════════ --}}
  <div class="card border-0 shadow-sm mb-4 text-white"
       style="border-radius:22px;background:linear-gradient(135deg,#0d6efd 0%,#0a58ca 60%,#084298 100%);">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
          <h4 class="fw-bold mb-1">Hi {{ explode(' ', $user->name)[0] }} 👋</h4>
          <p class="mb-0 opacity-75">Welcome to your student dashboard.</p>
        </div>
        <div class="text-end">
          <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold">
            {{ $user->course }}
          </span>
        </div>
      </div>
    </div>
  </div>

  {{-- ══════════ STATS ══════════ --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="text-muted small text-uppercase fw-semibold">Total Notices</div>
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
          <div class="d-flex align-items-center justify-content-between mb-2">
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
          <div class="d-flex align-items-center justify-content-between mb-2">
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
          <div class="d-flex align-items-center justify-content-between mb-2">
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

  <div class="row g-4">

    {{-- ══════════ LEFT COLUMN: Profile + Urgent ══════════ --}}
    <div class="col-lg-4">

      {{-- Profile card --}}
      <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-4">
          <div class="text-center mb-3">
            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-2"
                 style="width:72px;height:72px;font-size:28px;font-weight:600;">
              {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h6 class="fw-bold mb-0">{{ $user->name }}</h6>
            <small class="text-muted">{{ '@' . ($user->username ?? 'user') }}</small>
          </div>

          <hr class="opacity-25">

          <div class="mb-3">
            <div class="text-muted small text-uppercase fw-semibold">Email</div>
            <div class="d-flex align-items-center">
              <span class="text-truncate">{{ $user->email }}</span>
              @if(method_exists($user, 'hasVerifiedEmail') && $user->hasVerifiedEmail())
                <i class="bi bi-patch-check-fill text-success ms-2" title="Verified"></i>
              @endif
            </div>
          </div>

          @if(!empty($user->phone))
            <div class="mb-3">
              <div class="text-muted small text-uppercase fw-semibold">Phone</div>
              <div>+91 {{ $user->phone }}</div>
            </div>
          @endif

          <div class="mb-3">
            <div class="text-muted small text-uppercase fw-semibold">Course</div>
            <div>{{ $user->course }}</div>
          </div>

          @if(!empty($user->dob))
            <div class="mb-3">
              <div class="text-muted small text-uppercase fw-semibold">Date of Birth</div>
              <div>{{ \Carbon\Carbon::parse($user->dob)->format('d M Y') }}</div>
            </div>
          @endif

          <div class="mb-0">
            <div class="text-muted small text-uppercase fw-semibold">College Internet ID</div>
            <div>{{ $user->college_internet_id ?? '—' }}</div>
          </div>
        </div>
      </div>

      {{-- Urgent notices sidebar --}}
      @if($urgentNotices->count())
        <div class="card border-0 shadow-sm border-start border-danger border-4 rounded-4">
          <div class="card-body p-4">
            <h6 class="fw-bold text-danger mb-3">
              <i class="bi bi-exclamation-triangle-fill me-2"></i>Urgent Notices
            </h6>
            @foreach($urgentNotices as $u)
              <div class="border-bottom pb-2 mb-2">
                <a href="{{ route('notices.show', $u->id) }}"
                   class="fw-semibold small text-dark text-decoration-none d-block">
                  {{ $u->title }}
                </a>
                <small class="text-muted">{{ $u->created_at->diffForHumans() }}</small>
              </div>
            @endforeach
            <a href="{{ route('dashboard', ['category' => 'urgent']) }}"
               class="btn btn-sm btn-outline-danger w-100 mt-2 rounded-pill">
              View All Urgent
            </a>
          </div>
        </div>
      @endif
    </div>

    {{-- ══════════ RIGHT COLUMN: All Notices with Filters + Pagination ══════════ --}}
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        {{-- HEADER with search + category + date filter --}}
        <div class="card-header bg-white border-0 pt-4 pb-3 px-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
            <h6 class="fw-bold mb-0">
              <i class="bi bi-list-ul me-2 text-primary"></i>All Notices
            </h6>
            <div class="d-flex align-items-center gap-2">
              <span class="badge bg-light text-secondary rounded-pill px-3 py-2">
                {{ $notices->total() }} total
              </span>
              <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                Browse Board <i class="bi bi-arrow-right ms-1"></i>
              </a>
            </div>
          </div>

          {{-- FILTER FORM --}}
          <form method="GET" action="{{ route('dashboard') }}">
            <input type="hidden" name="per_page" value="{{ session('student_per_page', 10) }}">

            {{-- Row 1: Search + Category + Actions --}}
            <div class="row g-2 mb-2">
              <div class="col-md-5">
                <div class="input-group input-group-sm">
                  <span class="input-group-text bg-white rounded-start-pill">
                    <i class="bi bi-search text-muted"></i>
                  </span>
                  <input type="text" name="search"
                         class="form-control rounded-end-pill"
                         placeholder="Search notices..."
                         value="{{ request('search') }}">
                </div>
              </div>
              <div class="col-md-4">
                <select name="category" class="form-select form-select-sm rounded-pill">
                  <option value="">All Categories</option>
                  @foreach($categoryMap as $key => $label)
                    <option value="{{ $key }}" @selected(request('category') === $key)>{{ $label }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-outline-primary flex-fill rounded-pill">
                  <i class="bi bi-funnel me-1"></i>Filter
                </button>
                @if(request()->hasAny(['search','category','date_from','date_to']))
                  <a href="{{ route('dashboard') }}"
                     class="btn btn-sm btn-outline-secondary rounded-pill"
                     title="Clear all filters">
                    <i class="bi bi-x-lg"></i>
                  </a>
                @endif
              </div>
            </div>

            {{-- Row 2: Date range --}}
            <div class="row g-2 align-items-center">
              <div class="col-auto">
                <span class="small text-muted fw-semibold">
                  <i class="bi bi-calendar3 me-1 text-primary"></i>Date:
                </span>
              </div>
              <div class="col-md-2 col-6">
                <input type="date" name="date_from"
                       class="form-control form-control-sm rounded-pill"
                       value="{{ request('date_from') }}"
                       max="{{ now()->toDateString() }}">
              </div>
              <div class="col-auto small text-muted">to</div>
              <div class="col-md-2 col-6">
                <input type="date" name="date_to"
                       class="form-control form-control-sm rounded-pill"
                       value="{{ request('date_to') }}"
                       max="{{ now()->toDateString() }}">
              </div>

              {{-- Quick presets --}}
              <div class="col-md-5">
                <div class="d-flex flex-wrap gap-1">
                  <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->toDateString(), 'date_to' => now()->toDateString(), 'page' => null]) }}"
                     class="btn btn-sm btn-outline-secondary rounded-pill py-0 px-2" style="font-size:.72rem;">
                    Today
                  </a>
                  <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->subDays(6)->toDateString(), 'date_to' => now()->toDateString(), 'page' => null]) }}"
                     class="btn btn-sm btn-outline-secondary rounded-pill py-0 px-2" style="font-size:.72rem;">
                    7d
                  </a>
                  <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->subDays(29)->toDateString(), 'date_to' => now()->toDateString(), 'page' => null]) }}"
                     class="btn btn-sm btn-outline-secondary rounded-pill py-0 px-2" style="font-size:.72rem;">
                    30d
                  </a>
                  <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->startOfYear()->toDateString(), 'date_to' => now()->toDateString(), 'page' => null]) }}"
                     class="btn btn-sm btn-outline-secondary rounded-pill py-0 px-2" style="font-size:.72rem;">
                    This Year
                  </a>
                  <a href="{{ request()->fullUrlWithQuery(['date_from' => null, 'date_to' => null, 'page' => null]) }}"
                     class="btn btn-sm btn-outline-danger rounded-pill py-0 px-2" style="font-size:.72rem;">
                    <i class="bi bi-x-circle me-1"></i>Clear
                  </a>
                </div>
              </div>
            </div>

            {{-- Active date filter summary --}}
            @if(request()->filled('date_from') || request()->filled('date_to'))
              <div class="mt-2 small text-muted">
                <i class="bi bi-info-circle me-1"></i>
                Showing notices
                @if(request()->filled('date_from'))
                  from <b class="text-dark">{{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }}</b>
                @endif
                @if(request()->filled('date_to'))
                  to <b class="text-dark">{{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }}</b>
                @endif
              </div>
            @endif
          </form>
        </div>

        {{-- ══════════ NOTICE LIST ══════════ --}}
        <div class="card-body p-0">
          @forelse($notices as $n)
            @php
              $isUrgent = strtolower($n->priority ?? '') === 'urgent';
              $theme = match($n->category) {
                'must_read'    => ['c' => 'warning', 'i' => 'bi-star-fill'],
                'examination'  => ['c' => 'danger',  'i' => 'bi-pencil-square'],
                'placement'    => ['c' => 'success', 'i' => 'bi-briefcase'],
                'event'        => ['c' => 'info',    'i' => 'bi-cpu'],
                'urgent'       => ['c' => 'danger',  'i' => 'bi-exclamation-triangle-fill'],
                default        => ['c' => 'primary', 'i' => 'bi-file-earmark-text'],
              };
            @endphp
            <div class="d-flex align-items-start border-bottom px-4 py-3 notice-row">
              {{-- Icon --}}
              <div class="notice-avatar bg-{{ $isUrgent ? 'danger' : $theme['c'] }}-subtle
                          text-{{ $isUrgent ? 'danger' : $theme['c'] }} me-3">
                <i class="bi {{ $isUrgent ? 'bi-exclamation-triangle-fill' : $theme['i'] }}"></i>
              </div>

              {{-- Content --}}
              <div class="flex-grow-1 me-3">
                <div class="mb-1">
                  <span class="badge bg-light text-secondary border rounded-pill px-2"
                        style="font-size:.65rem;">
                    {{ $categoryMap[$n->category] ?? ucfirst($n->category) }}
                  </span>
                  @if($isUrgent)
                    <span class="badge bg-danger rounded-pill px-2" style="font-size:.65rem;">Urgent</span>
                  @elseif($n->priority === 'High')
                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-2"
                          style="font-size:.65rem;">High</span>
                  @endif
                </div>

                <div class="fw-semibold">
                  <a href="{{ route('notices.show', $n->id) }}"
                     class="text-decoration-none text-dark notice-title">
                    {{ $n->title }}
                  </a>
                </div>

                <small class="text-muted">
                  <i class="bi bi-calendar3 me-1"></i>
                  {{ optional($n->published_at)->format('d M Y') }}
                  <span class="mx-1">•</span>
                  {{ $n->created_at->diffForHumans() }}
                  @if($n->author)
                    <span class="mx-1">•</span>
                    <i class="bi bi-person-circle me-1"></i>{{ $n->author->name }}
                  @endif
                </small>
              </div>

              {{-- Actions --}}
              <div class="d-flex flex-column gap-1 flex-shrink-0">
                <a href="{{ route('notices.show', $n->id) }}"
                   class="btn btn-sm btn-outline-info rounded-circle"
                   style="width:34px;height:34px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                   title="View">
                  <i class="bi bi-eye"></i>
                </a>
                @if($n->attachment_path)
                  <a href="{{ route('notices.download', $n->id) }}"
                     class="btn btn-sm btn-outline-primary rounded-circle"
                     style="width:34px;height:34px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                     title="Download">
                    <i class="bi bi-download"></i>
                  </a>
                @endif
              </div>
            </div>
          @empty
            <div class="text-center text-muted py-5">
              <i class="bi bi-inbox display-4 d-block mb-2 opacity-25"></i>
              <div class="fw-semibold">No notices found</div>
              <small>
                @if(request()->hasAny(['search','category','date_from','date_to']))
                  Try adjusting your filters or
                  <a href="{{ route('dashboard') }}">clear all</a>
                @else
                  No notices have been published yet.
                @endif
              </small>
            </div>
          @endforelse
        </div>

        {{-- ✅ PAGINATION --}}
        @if($notices->total() > 0)
          <div class="card-footer bg-white border-0 py-3 px-4">
            {{ $notices->links('vendor.pagination.custom') }}
          </div>
        @endif

      </div>
    </div>

  </div>
</div>
@endsection

{{-- ══════════ STYLES ══════════ --}}
@push('styles')
<style>
  /* Stat cards */
  .stat-card { transition: transform .25s ease, box-shadow .25s ease; }
  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,.08) !important;
  }

  /* Notice rows */
  .notice-row { transition: background .15s ease; }
  .notice-row:hover { background: #f8fafc; }

  .notice-title { transition: color .15s ease; }
  .notice-title:hover { color: #4f46e5 !important; }

  .notice-avatar {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 1.05rem;
  }

  /* Date inputs */
  input[type="date"].form-control-sm {
    font-size: .8125rem;
    padding: .35rem .75rem;
  }

  /* Pagination fallback (in case layout doesn't include it) */
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

{{-- ══════════ SCRIPTS ══════════ --}}
@push('scripts')
<script>
  /* Auto-submit per-page selector */
  document.addEventListener('change', function (e) {
    if (e.target.matches('[data-perpage-select]')) {
      e.target.closest('[data-perpage-form]').submit();
    }
  });
</script>
@endpush