@extends('layouts.app')
@section('title','Admin Dashboard')

@section('content')

{{-- ⚡ Flag JS as ready ASAP (fixes reveal fallback bug) --}}
<script>document.documentElement.classList.add('js-ready');</script>

{{-- ============ HERO ============ --}}
<div class="container-fluid px-lg-5 pt-4">
  <div class="card border-0 shadow-sm text-white position-relative overflow-hidden hero-animated"
       style="border-radius:24px;background:linear-gradient(135deg,#4f46e5 0%,#4338ca 50%,#3730a3 100%);background-size:200% 200%;">
    <div class="card-body p-4 p-lg-5 position-relative">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-2 mb-3 animate-fade-in"
                style="animation-delay:0.1s;">
            <i class="bi bi-shield-lock-fill me-1" aria-hidden="true"></i>ADMIN CONTROL PANEL
          </span>
          <h2 class="fw-bold mb-2 animate-slide-up" style="animation-delay:0.2s;">
            Welcome back, {{ explode(' ', Auth::user()->name)[0] }} 🛡️
          </h2>
          <p class="opacity-75 mb-4 animate-slide-up" style="animation-delay:0.3s;">
            Manage notices, users, and content across the School of Computational Science portal.
          </p>
          <div class="d-flex gap-2 flex-wrap animate-slide-up" style="animation-delay:0.4s;">
            <a href="{{ route('admin.notices.create') }}" class="btn btn-warning fw-bold px-4 rounded-pill btn-pulse">
              <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>Post Notice
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-light px-4 rounded-pill btn-glow">
              <i class="bi bi-eye me-1" aria-hidden="true"></i>Preview Board
            </a>
          </div>
        </div>
        <div class="col-lg-4 d-none d-lg-flex justify-content-end">
          <i class="bi bi-speedometer2 animate-rotate-slow"
             style="font-size:9rem;opacity:.15;" aria-hidden="true"></i>
        </div>
      </div>
    </div>
    <div class="position-absolute rounded-circle bg-white bg-opacity-10 hero-orb"
         style="width:220px;height:220px;bottom:-100px;right:-60px;"></div>
    <div class="position-absolute rounded-circle bg-white bg-opacity-10 hero-orb"
         style="width:120px;height:120px;top:-40px;left:40%;animation-delay:1s;"></div>
  </div>
</div>

{{-- ============ STATS ============ --}}
<div class="container-fluid px-lg-5 py-4">
  <div class="row g-3 mb-4">

    <div class="col-6 col-lg-3 reveal" data-delay="0">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="icon-box bg-primary-subtle text-primary">
              <i class="bi bi-megaphone-fill" aria-hidden="true"></i>
            </div>
            <span class="badge bg-success-subtle text-success rounded-pill small">
              <i class="bi bi-check-circle me-1" aria-hidden="true"></i>Published
            </span>
          </div>
          <div class="text-muted small text-uppercase fw-semibold mb-1">Total Notices</div>
          <h2 class="fw-bold mb-0 counter"
              data-target="{{ $stats['total_notices'] ?? 0 }}">0</h2>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3 reveal" data-delay="100">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="icon-box bg-success-subtle text-success">
              <i class="bi bi-people-fill" aria-hidden="true"></i>
            </div>
            <span class="badge bg-light text-secondary rounded-pill small">
              {{ $stats['students'] ?? 0 }} students
            </span>
          </div>
          <div class="text-muted small text-uppercase fw-semibold mb-1">Total Users</div>
          <h2 class="fw-bold mb-0 counter"
              data-target="{{ $stats['total_users'] ?? 0 }}">0</h2>
        </div>
      </div>
    </div>

    {{-- ✅ Urgent card — red removed, now amber (warning) --}}
    <div class="col-6 col-lg-3 reveal" data-delay="200">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="icon-box bg-warning-subtle text-warning-emphasis icon-pulse">
              <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
            </div>
            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill small">
              <i class="bi bi-exclamation-circle me-1" aria-hidden="true"></i>Active
            </span>
          </div>
          <div class="text-muted small text-uppercase fw-semibold mb-1">Urgent</div>
          <h2 class="fw-bold mb-0 text-warning-emphasis counter"
              data-target="{{ $stats['urgent'] ?? 0 }}">0</h2>
        </div>
      </div>
    </div>

    {{-- This Week — switched to info so it doesn't clash with Urgent --}}
    <div class="col-6 col-lg-3 reveal" data-delay="300">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="icon-box bg-info-subtle text-info-emphasis">
              <i class="bi bi-calendar-week-fill" aria-hidden="true"></i>
            </div>
            <span class="badge bg-info-subtle text-info-emphasis rounded-pill small">
              <i class="bi bi-clock-history me-1" aria-hidden="true"></i>7 days
            </span>
          </div>
          <div class="text-muted small text-uppercase fw-semibold mb-1">This Week</div>
          <h2 class="fw-bold mb-0 text-info-emphasis counter"
              data-target="{{ $stats['this_week'] ?? 0 }}">0</h2>
        </div>
      </div>
    </div>

  </div>

  {{-- ============ QUICK ACTIONS ============ --}}
  <h6 class="fw-bold text-dark mb-3 reveal" data-delay="0">
    <i class="bi bi-lightning-charge-fill text-warning me-2 icon-zap" aria-hidden="true"></i>Quick Actions
  </h6>
  <div class="row g-3 mb-4">

    <div class="col-md-6 col-lg-3 reveal" data-delay="0">
      <a href="{{ route('admin.notices.create') }}" class="text-decoration-none">
        <div class="card border-0 shadow-sm action-card h-100">
          <div class="card-body d-flex align-items-center">
            <div class="action-icon bg-primary text-white action-icon-hover">
              <i class="bi bi-plus-lg" aria-hidden="true"></i>
            </div>
            <div class="ms-3">
              <div class="fw-bold text-dark">Post Notice</div>
              <small class="text-muted">Create &amp; publish</small>
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-lg-3 reveal" data-delay="100">
      <a href="{{ route('home') }}" class="text-decoration-none">
        <div class="card border-0 shadow-sm action-card h-100">
          <div class="card-body d-flex align-items-center">
            <div class="action-icon bg-success text-white action-icon-hover">
              <i class="bi bi-eye-fill" aria-hidden="true"></i>
            </div>
            <div class="ms-3">
              <div class="fw-bold text-dark">Preview Board</div>
              <small class="text-muted">Student view</small>
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-lg-3 reveal" data-delay="200">
      <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
        <div class="card border-0 shadow-sm action-card h-100">
          <div class="card-body d-flex align-items-center">
            <div class="action-icon bg-warning text-dark action-icon-hover">
              <i class="bi bi-people-fill" aria-hidden="true"></i>
            </div>
            <div class="ms-3">
              <div class="fw-bold text-dark">Manage Users</div>
              <small class="text-muted">{{ $stats['students'] ?? 0 }} students</small>
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-lg-3 reveal" data-delay="300">
      <a href="{{ route('admin.notices.index', ['priority' => 'Urgent']) }}" class="text-decoration-none">
        <div class="card border-0 shadow-sm action-card h-100">
          <div class="card-body d-flex align-items-center">
            <div class="action-icon bg-danger text-white action-icon-hover">
              <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
            </div>
            <div class="ms-3">
              <div class="fw-bold text-dark">Urgent Notices</div>
              <small class="text-muted">{{ $stats['urgent'] ?? 0 }} active</small>
            </div>
          </div>
        </div>
      </a>
    </div>

  </div>

  {{-- ============ RECENT NOTICES TABLE ============ --}}
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden reveal" data-delay="0">

    {{-- ═══════════ CARD HEADER with DATE FILTER ═══════════ --}}
    <div class="card-header bg-white border-0 pt-4 pb-3 px-4 reveal" data-delay="100">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
        <h6 class="fw-bold mb-0">
          <i class="bi bi-list-ul me-2 text-primary" aria-hidden="true"></i>All Notices
        </h6>
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-light text-secondary rounded-pill px-3 py-2">
            {{ $notices->total() }} total
          </span>
          <a href="{{ route('admin.notices.create') }}" class="btn btn-sm btn-primary rounded-pill px-3 btn-hover-lift">
            <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>New
          </a>
        </div>
      </div>

      {{-- SEARCH + CATEGORY + DATE FILTER --}}
      <form method="GET" action="{{ route('admin.dashboard') }}" id="filterForm">

        <input type="hidden" name="per_page" value="{{ session('admin_per_page', 10) }}">

        {{-- ROW 1: Search / Category / Actions --}}
        <div class="row g-2 mb-2">
          <div class="col-md-6">
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-white rounded-start-pill">
                <i class="bi bi-search text-muted" aria-hidden="true"></i>
              </span>
              <input type="text"
                     name="search"
                     class="form-control rounded-end-pill input-focus-lift"
                     placeholder="Search notices by title or content..."
                     value="{{ request('search') }}"
                     aria-label="Search notices">
            </div>
          </div>

          <div class="col-md-3">
            <select name="category" class="form-select form-select-sm rounded-pill input-focus-lift" aria-label="Filter by category">
              <option value="">All Categories</option>
              @foreach(\App\Models\Notice::categories() as $key => $label)
                <option value="{{ $key }}" @selected(request('category') === $key)>{{ $label }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-outline-primary flex-fill rounded-pill btn-hover-lift">
              <i class="bi bi-funnel me-1" aria-hidden="true"></i>Filter
            </button>
            @if(request()->hasAny(['search','category','date_from','date_to']))
              <a href="{{ route('admin.dashboard') }}"
                 class="btn btn-sm btn-outline-secondary rounded-pill btn-hover-lift"
                 title="Clear all filters">
                <i class="bi bi-x-lg" aria-hidden="true"></i>
              </a>
            @endif
          </div>
        </div>

        {{-- ✅ ROW 2: DATE RANGE — now centered in the card --}}
        <div class="row g-2 align-items-center justify-content-center text-center">
          <div class="col-auto">
            <span class="small text-muted fw-semibold">
              <i class="bi bi-calendar3 me-1 text-primary" aria-hidden="true"></i>Date:
            </span>
          </div>

          <div class="col-md-2 col-6">
            <input type="date"
                   name="date_from"
                   class="form-control form-control-sm rounded-pill input-focus-lift"
                   value="{{ request('date_from') }}"
                   max="{{ now()->toDateString() }}"
                   aria-label="From date">
          </div>

          <div class="col-auto small text-muted">to</div>

          <div class="col-md-2 col-6">
            <input type="date"
                   name="date_to"
                   class="form-control form-control-sm rounded-pill input-focus-lift"
                   value="{{ request('date_to') }}"
                   max="{{ now()->toDateString() }}"
                   aria-label="To date">
          </div>

          <div class="col-md-5">
            <div class="d-flex flex-wrap gap-1 justify-content-center">
              <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->toDateString(), 'date_to' => now()->toDateString(), 'page' => null]) }}"
                 class="btn btn-sm btn-outline-secondary rounded-pill py-0 px-2 btn-hover-lift" style="font-size:.72rem;">
                Today
              </a>
              <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->subDays(6)->toDateString(), 'date_to' => now()->toDateString(), 'page' => null]) }}"
                 class="btn btn-sm btn-outline-secondary rounded-pill py-0 px-2 btn-hover-lift" style="font-size:.72rem;">
                7d
              </a>
              <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->subDays(29)->toDateString(), 'date_to' => now()->toDateString(), 'page' => null]) }}"
                 class="btn btn-sm btn-outline-secondary rounded-pill py-0 px-2 btn-hover-lift" style="font-size:.72rem;">
                30d
              </a>
              <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->startOfYear()->toDateString(), 'date_to' => now()->toDateString(), 'page' => null]) }}"
                 class="btn btn-sm btn-outline-secondary rounded-pill py-0 px-2 btn-hover-lift" style="font-size:.72rem;">
                This Year
              </a>
              <a href="{{ request()->fullUrlWithQuery(['date_from' => now()->subYear()->startOfYear()->toDateString(), 'date_to' => now()->subYear()->endOfYear()->toDateString(), 'page' => null]) }}"
                 class="btn btn-sm btn-outline-secondary rounded-pill py-0 px-2 btn-hover-lift" style="font-size:.72rem;">
                Last Year
              </a>
              <a href="{{ request()->fullUrlWithQuery(['date_from' => null, 'date_to' => null, 'page' => null]) }}"
                 class="btn btn-sm btn-outline-danger rounded-pill py-0 px-2 btn-hover-lift" style="font-size:.72rem;">
                <i class="bi bi-x-circle me-1" aria-hidden="true"></i>Clear dates
              </a>
            </div>
          </div>
        </div>

        @if(request()->filled('date_from') || request()->filled('date_to'))
          <div class="mt-2 small text-muted animate-fade-in text-center">
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

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="ps-4" style="width:42%;">Notice</th>
              <th>Category</th>
              <th>Priority</th>
              <th>Posted</th>
              <th class="text-end pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
          @forelse($notices as $n)
            @php
              $isUrgent = strtolower($n->priority ?? '') === 'urgent';
              $categoryLabel = \App\Models\Notice::categories()[$n->category] ?? $n->category;
            @endphp
            <tr class="reveal-row" style="--row-delay:{{ $loop->index * 0.04 }}s;">
              <td class="ps-4">
                <div class="d-flex align-items-start">
                  <div class="notice-avatar bg-{{ $isUrgent ? 'danger' : 'primary' }}-subtle
                              text-{{ $isUrgent ? 'danger' : 'primary' }} me-3">
                    <i class="bi bi-file-earmark-text" aria-hidden="true"></i>
                  </div>
                  <div>
                    <div class="fw-semibold text-dark">{{ Str::limit($n->title, 50) }}</div>
                    <small class="text-muted">
                      {{ Str::limit(strip_tags($n->description), 60) }}
                    </small>
                    @if($n->attachment_path)
                      <div class="mt-1">
                        <span class="badge bg-light text-dark border border-secondary-subtle small">
                          <i class="bi bi-paperclip me-1" aria-hidden="true"></i>Attachment
                        </span>
                      </div>
                    @endif
                  </div>
                </div>
              </td>

              <td>
                <span class="badge bg-light text-dark border border-secondary-subtle rounded-pill px-3 badge-hover-pop">
                  {{ $categoryLabel }}
                </span>
              </td>

              <td>
                @if($isUrgent)
                  <span class="badge bg-danger rounded-pill px-3 badge-urgent">
                    <i class="bi bi-exclamation-circle me-1" aria-hidden="true"></i>Urgent
                  </span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 badge-hover-pop">Normal</span>
                @endif
              </td>

              <td>
                <div class="small text-dark fw-medium">{{ $n->created_at->format('d M Y') }}</div>
                <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small>
              </td>

              <td class="text-end pe-4">
                <div class="d-flex justify-content-end gap-1">
                  <a href="{{ route('notices.show', $n->id) }}"
                     class="btn btn-sm btn-outline-info rounded-circle btn-icon-hover"
                     style="width:34px;height:34px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                     title="View notice" aria-label="View notice">
                    <i class="bi bi-eye" aria-hidden="true"></i>
                  </a>
                  @if($n->attachment_path)
                    <a href="{{ route('notices.download', $n->id) }}"
                       class="btn btn-sm btn-outline-primary rounded-circle btn-icon-hover"
                       style="width:34px;height:34px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                       title="Download attachment" aria-label="Download attachment">
                      <i class="bi bi-download" aria-hidden="true"></i>
                    </a>
                  @endif
                  <a href="{{ route('admin.notices.edit', $n) }}"
                     class="btn btn-sm btn-outline-secondary rounded-circle btn-icon-hover"
                     style="width:34px;height:34px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                     title="Edit notice" aria-label="Edit notice">
                    <i class="bi bi-pencil" aria-hidden="true"></i>
                  </a>
                  <form action="{{ route('admin.notices.destroy', $n) }}"
                        method="POST" class="d-inline delete-form">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="btn btn-sm btn-outline-danger rounded-circle btn-icon-hover"
                            style="width:34px;height:34px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                            title="Delete notice" aria-label="Delete notice">
                      <i class="bi bi-trash" aria-hidden="true"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr class="reveal-row" style="--row-delay:0s;">
              <td colspan="5" class="text-center py-5">
                <div class="text-muted animate-fade-in">
                  <i class="bi bi-inbox display-4 d-block mb-3 opacity-25 icon-float-gentle" aria-hidden="true"></i>
                  <div class="fw-semibold">No notices found</div>
                  <small>
                    @if(request()->hasAny(['search','category','date_from','date_to']))
                      Try adjusting your filters or
                      <a href="{{ route('admin.dashboard') }}">clear all</a>
                    @else
                      Click "Post Notice" to publish your first notice
                    @endif
                  </small>
                  @unless(request()->hasAny(['search','category','date_from','date_to']))
                    <div class="mt-3">
                      <a href="{{ route('admin.notices.create') }}" class="btn btn-primary rounded-pill px-4 btn-pulse">
                        <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>Post Notice
                      </a>
                    </div>
                  @endunless
                </div>
              </td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>

    @if($notices->total() > 0)
      <div class="card-footer bg-white border-0 py-3 px-4 reveal" data-delay="200">
        {{ $notices->links('vendor.pagination.custom') }}
      </div>
    @endif
  </div>

</div>

@endsection

{{-- ============ STYLES ============ --}}
@push('styles')
<style>
  /* ═══════════ ENTRANCE ANIMATIONS (hero) ═══════════ */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes slideUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes rotateSlow {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
  }
  @keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50%      { background-position: 100% 50%; }
  }
  @keyframes orbFloat {
    0%, 100% { transform: translateY(0) scale(1); }
    50%      { transform: translateY(-20px) scale(1.05); }
  }
  /* red pulse kept for the urgent TABLE badge only */
  @keyframes pulseRing {
    0%   { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.6); }
    70%  { box-shadow: 0 0 0 12px rgba(220, 53, 69, 0); }
    100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
  }
  /* ✅ new amber pulse for the Urgent STAT card */
  @keyframes pulseRingAmber {
    0%   { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.6); }
    70%  { box-shadow: 0 0 0 12px rgba(255, 193, 7, 0); }
    100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
  }
  @keyframes zapWiggle {
    0%, 100% { transform: rotate(0deg); }
    25%      { transform: rotate(-12deg); }
    75%      { transform: rotate(12deg); }
  }
  @keyframes iconFloatGentle {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-6px); }
  }

  .animate-fade-in  { animation: fadeIn 0.5s ease-out both; }
  .animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }

  /* ═══════════ HERO ═══════════ */
  .hero-animated { animation: gradientShift 12s ease infinite; }
  .hero-orb      { animation: orbFloat 6s ease-in-out infinite; }
  .animate-rotate-slow { animation: rotateSlow 60s linear infinite; }

  /* ═══════════ ⚡ SCROLL REVEAL (FIXED) ═══════════
     .reveal is VISIBLE by default so it works without JS.
     Only when JS has flagged itself as ready (.js-ready on <html>)
     do we hide them for the entrance animation.
  ─────────────────────────────────────────────── */
  .reveal {
    opacity: 1;
    transform: none;
  }
  .js-ready .reveal {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1),
                transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
    transition-delay: calc(var(--reveal-delay, 0ms));
  }
  .js-ready .reveal.is-visible {
    opacity: 1;
    transform: translateY(0);
  }

  /* Rows reveal (staggered from within the table) */
  .reveal-row {
    opacity: 1;
    transform: none;
  }
  .js-ready .reveal-row {
    opacity: 0;
    transform: translateX(-12px);
    transition: opacity 0.5s ease-out,
                transform 0.5s ease-out;
    transition-delay: var(--row-delay, 0s);
  }
  .js-ready tbody.is-visible .reveal-row {
    opacity: 1;
    transform: translateX(0);
  }

  /* ═══════════ STAT CARDS ═══════════ */
  .stat-card {
    transition: transform .3s cubic-bezier(0.16, 1, 0.3, 1),
                box-shadow .3s ease;
  }
  .stat-card:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow: 0 16px 32px rgba(79, 70, 229, 0.12) !important;
  }

  .icon-box {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    transition: transform .3s ease;
  }
  .stat-card:hover .icon-box {
    transform: scale(1.1) rotate(-6deg);
  }
  /* ✅ amber pulse (was red) */
  .icon-pulse {
    animation: pulseRingAmber 2.5s ease-out infinite;
    border-radius: 50%;
  }

  /* ═══════════ COUNTERS ═══════════ */
  .counter {
    font-variant-numeric: tabular-nums;
    transition: transform .25s ease, color .25s ease;
  }
  .stat-card:hover .counter {
    transform: scale(1.06);
  }

  /* ═══════════ ACTION CARDS ═══════════ */
  .action-card {
    transition: transform .3s cubic-bezier(0.16, 1, 0.3, 1),
                box-shadow .3s ease;
    cursor: pointer;
  }
  .action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 28px rgba(79, 70, 229, 0.14) !important;
  }
  .action-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; flex-shrink: 0;
    transition: transform .35s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .action-card:hover .action-icon-hover {
    transform: scale(1.12) rotate(8deg);
  }

  /* ═══════════ ROWS ═══════════ */
  tbody tr {
    transition: background-color .2s ease, transform .2s ease,
                box-shadow .2s ease;
  }
  tbody tr:hover {
    background-color: #f8fafc;
    transform: translateX(2px);
    box-shadow: inset 3px 0 0 0 #6366f1;
  }

  /* ═══════════ BADGES ═══════════ */
  .badge-urgent { position: relative; }
  .badge-urgent::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 999px;
    animation: pulseRing 2s ease-out infinite;
    pointer-events: none;
  }
  .badge-hover-pop {
    transition: transform .2s ease, background-color .2s ease;
  }
  .badge-hover-pop:hover {
    transform: scale(1.08);
    background-color: #eef2ff !important;
  }

  /* ═══════════ BUTTONS ═══════════ */
  .btn-pulse {
    transition: transform .25s ease, box-shadow .25s ease;
  }
  .btn-pulse:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.4);
  }
  .btn-glow { transition: all .25s ease; }
  .btn-glow:hover {
    background-color: #fff;
    color: #3730a3;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.4);
  }
  .btn-hover-lift {
    transition: transform .2s ease, box-shadow .2s ease;
  }
  .btn-hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
  }
  .btn-icon-hover { transition: all .2s ease; }
  .btn-icon-hover:hover {
    transform: scale(1.15) rotate(-4deg);
  }

  /* ═══════════ ZAP ICON ═══════════ */
  .icon-zap {
    display: inline-block;
    animation: zapWiggle 2.5s ease-in-out infinite;
    transform-origin: center;
  }

  .icon-float-gentle {
    animation: iconFloatGentle 3s ease-in-out infinite;
  }

  /* ═══════════ NOTICE AVATAR ═══════════ */
  .notice-avatar {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: transform .25s ease, box-shadow .25s ease;
  }
  tbody tr:hover .notice-avatar {
    transform: scale(1.1) rotate(-4deg);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
  }

  /* ═══════════ DATE INPUTS ═══════════ */
  input[type="date"].form-control-sm {
    font-size: .8125rem;
    padding: .35rem .75rem;
  }

  .input-focus-lift {
    transition: transform .2s ease, box-shadow .2s ease,
                border-color .2s ease;
  }
  .input-focus-lift:focus {
    transform: translateY(-1px);
    box-shadow: 0 6px 14px rgba(99, 102, 241, 0.15);
    border-color: #6366f1;
  }

  /* ═══════════ PAGINATION ═══════════ */
  .pg-wrapper {
    display: flex; flex-wrap: wrap; align-items: center;
    justify-content: space-between; gap: 1rem; padding: .5rem 0;
  }
  .pg-info { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
  .pg-info__text { font-size: .875rem; color: #6b7280; }
  .pg-info__text strong { color: #111827; font-weight: 600; }

  .pg-perpage { display: flex; align-items: center; gap: .5rem; margin: 0; }
  .pg-perpage__label { font-size: .8125rem; color: #6b7280; margin: 0; white-space: nowrap; }
  .pg-perpage__select {
    appearance: none; -webkit-appearance: none;
    background: #fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>") no-repeat right 10px center;
    border: 1px solid #e5e7eb; border-radius: 999px;
    padding: .35rem 2rem .35rem .875rem; font-size: .8125rem;
    font-weight: 500; color: #111827; cursor: pointer;
    transition: border-color .15s, box-shadow .15s; min-width: 72px;
  }
  .pg-perpage__select:hover { border-color: #cbd5e1; }
  .pg-perpage__select:focus {
    outline: none; border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.15);
  }

  .pg-nav { margin: 0; }
  .pg-list {
    display: flex; align-items: center; gap: .375rem;
    list-style: none; margin: 0; padding: 0; flex-wrap: wrap;
  }
  .pg-item { display: inline-flex; }
  .pg-link {
    display: inline-flex; align-items: center; justify-content: center;
    gap: .35rem; min-width: 40px; height: 40px; padding: 0 .75rem;
    font-size: .875rem; font-weight: 500; color: #374151;
    background: #fff; border: 1px solid #e5e7eb; border-radius: 999px;
    text-decoration: none; transition: all .15s;
    user-select: none; line-height: 1;
  }
  .pg-item:not(.is-active):not(.is-disabled):not(.is-dots) .pg-link:hover {
    color: #4338ca; border-color: #c7d2fe; background: #eef2ff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(99,102,241,.12);
  }
  .pg-item.is-active .pg-link {
    color: #fff;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    border-color: transparent; font-weight: 600;
    box-shadow: 0 4px 12px rgba(79,70,229,.35);
  }
  .pg-item.is-disabled .pg-link {
    color: #9ca3af; background: #f9fafb; border-color: #f3f4f6;
    cursor: not-allowed; opacity: .7;
  }
  .pg-item.is-dots .pg-link {
    color: #9ca3af; background: transparent; border-color: transparent;
    cursor: default; padding: 0 .25rem; min-width: 32px;
  }
  .pg-icon { width: 16px; height: 16px; flex-shrink: 0; }
  .pg-label { font-size: .8125rem; }

  /* ═══════════ RESPONSIVE ═══════════ */
  @media (max-width: 575.98px) {
    .pg-wrapper { flex-direction: column; align-items: stretch; }
    .pg-info    { justify-content: space-between; width: 100%; }
    .pg-nav     { width: 100%; }
    .pg-list    { justify-content: center; }
    .pg-label   { display: none; }
    .pg-link    { min-width: 36px; height: 36px; padding: 0 .5rem; font-size: .8125rem; }
    .pg-item:not(.is-active):not(.is-disabled):not(.is-dots):not(:first-child):not(:last-child) {
      display: none;
    }
  }

  /* ═══════════ REDUCED MOTION ═══════════ */
  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
      animation-duration: 0.001ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.001ms !important;
    }
    .reveal,
    .reveal-row {
      opacity: 1 !important;
      transform: none !important;
    }
    .stat-card:hover,
    .action-card:hover,
    .btn-hover-lift:hover,
    .btn-icon-hover:hover,
    .badge-hover-pop:hover,
    .input-focus-lift:focus {
      transform: none !important;
    }
  }
</style>
@endpush

{{-- ============ SCRIPTS ============ --}}
@push('scripts')
<script>
  /* ═══════ Delete confirmation ═══════ */
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-form').forEach(function (form) {
      form.addEventListener('submit', function (e) {
        if (!confirm('Delete this notice? This cannot be undone.')) {
          e.preventDefault();
        }
      });
    });
  });

  /* ═══════ Auto-submit per-page selector ═══════ */
  document.addEventListener('change', function (e) {
    if (e.target.matches('[data-perpage-select]')) {
      e.target.closest('[data-perpage-form]').submit();
    }
  });

  /* ═══════ Counter animation (only when visible) ═══════ */
  (function () {
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function animateCounter(el) {
      if (el.dataset.animated === 'true') return;
      el.dataset.animated = 'true';

      const target = parseInt(el.dataset.target, 10) || 0;

      if (prefersReduced || target === 0) {
        el.textContent = target.toLocaleString();
        return;
      }

      const duration = 1200;
      const start = performance.now();

      function step(now) {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.round(target * eased).toLocaleString();
        if (progress < 1) requestAnimationFrame(step);
      }

      requestAnimationFrame(step);
    }

    if (!('IntersectionObserver' in window)) {
      document.querySelectorAll('.counter').forEach(animateCounter);
      return;
    }

    const counterObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          counterObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.4 });

    document.querySelectorAll('.counter').forEach(function (el) {
      counterObserver.observe(el);
    });
  })();

  /* ═══════ Scroll Reveal (with stagger via data-delay) ═══════ */
  (function () {
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const elements = document.querySelectorAll('.reveal');

    if (prefersReduced || !('IntersectionObserver' in window)) {
      elements.forEach(function (el) { el.classList.add('is-visible'); });
      document.querySelectorAll('tbody').forEach(function (tb) { tb.classList.add('is-visible'); });
      return;
    }

    const revealObserver = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          const delay = entry.target.dataset.delay || 0;
          entry.target.style.setProperty('--reveal-delay', delay + 'ms');
          entry.target.classList.add('is-visible');
          obs.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.12,
      rootMargin: '0px 0px -60px 0px'
    });

    elements.forEach(function (el) { revealObserver.observe(el); });

    /* ═══════ Table rows: reveal when their tbody enters viewport ═══════ */
    document.querySelectorAll('.card tbody').forEach(function (tbody) {
      if (!tbody.querySelector('tr')) return;

      const rowObserver = new IntersectionObserver(function (entries, obs) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            obs.unobserve(entry.target);
          }
        });
      }, { threshold: 0.05 });

      rowObserver.observe(tbody);
    });
  })();
</script>
@endpush