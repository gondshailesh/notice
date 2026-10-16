@extends('layouts.app')
@section('title','Manage Users')

@section('content')
<div class="container-fluid px-lg-5 py-4">

  {{-- ============ PAGE HEADER ============ --}}
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 animate-fade-in">
    <div>
      <h4 class="fw-bold mb-0">
        <i class="bi bi-people-fill me-2 text-primary animate-icon-pop"></i>Manage Users
      </h4>
      <small class="text-muted">View, promote, or remove portal users</small>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-hover-lift rounded-pill px-3">
      <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
    </a>
  </div>

  {{-- ============ STATS ============ --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
      <div class="card border-0 shadow-sm h-100 stat-card animate-stat" style="animation-delay:0.1s;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="icon-box bg-primary-subtle text-primary">
              <i class="bi bi-people-fill"></i>
            </div>
          </div>
          <div class="text-muted small text-uppercase fw-semibold">Total Users</div>
          <h3 class="fw-bold mb-0 text-primary counter" data-target="{{ $stats['total'] ?? 0 }}">0</h3>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-4">
      <div class="card border-0 shadow-sm h-100 stat-card animate-stat" style="animation-delay:0.2s;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="icon-box bg-danger-subtle text-danger icon-pulse">
              <i class="bi bi-shield-lock-fill"></i>
            </div>
          </div>
          <div class="text-muted small text-uppercase fw-semibold">Admins</div>
          <h3 class="fw-bold mb-0 text-danger counter" data-target="{{ $stats['admins'] ?? 0 }}">0</h3>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-4">
      <div class="card border-0 shadow-sm h-100 stat-card animate-stat" style="animation-delay:0.3s;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="icon-box bg-success-subtle text-success">
              <i class="bi bi-person-badge-fill"></i>
            </div>
          </div>
          <div class="text-muted small text-uppercase fw-semibold">Students</div>
          <h3 class="fw-bold mb-0 text-success counter" data-target="{{ $stats['students'] ?? 0 }}">0</h3>
        </div>
      </div>
    </div>
  </div>

  {{-- ============ FILTERS ============ --}}
  <div class="card border-0 shadow-sm mb-4 animate-stat" style="animation-delay:0.4s;">
    <div class="card-body p-3">
      <form method="GET" class="row g-2 align-items-center">
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text bg-white rounded-start-pill">
              <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" name="q" value="{{ request('q') }}"
                   class="form-control rounded-end-pill"
                   placeholder="Search by name, email, username, phone...">
          </div>
        </div>
        <div class="col-md-3">
          <select name="role" class="form-select rounded-pill">
            <option value="">All Roles</option>
            <option value="1" @selected(request('role') === '1')>Admin only</option>
            <option value="0" @selected(request('role') === '0')>Students only</option>
          </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
          <button class="btn btn-primary flex-fill rounded-pill btn-hover-lift">
            <i class="bi bi-funnel me-1"></i>Filter
          </button>
          <a href="{{ route('admin.users.index') }}"
             class="btn btn-outline-secondary rounded-pill btn-hover-lift">
            <i class="bi bi-x-lg"></i>
          </a>
        </div>
      </form>
    </div>
  </div>

  {{-- ============ USERS TABLE ============ --}}
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate-stat" style="animation-delay:0.5s;">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="ps-4">User</th>
              <th>Contact</th>
              <th>Course</th>
              <th>Role</th>
              <th>Verified</th>
              <th class="text-end pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
          @forelse($users as $u)
            @php
              $isAdmin = $u->role === 1;
              $initials = strtoupper(substr($u->name, 0, 1));
              // Rotate avatar colors for visual variety
              $avatarColors = ['bg-primary', 'bg-success', 'bg-warning', 'bg-danger', 'bg-info', 'bg-secondary'];
              $avatarColor = $avatarColors[$u->id % count($avatarColors)];
            @endphp
            <tr class="row-animate" style="animation-delay:{{ 0.55 + ($loop->index * 0.03) }}s;">
              <td class="ps-4">
                <div class="d-flex align-items-center">
                  <div class="user-avatar {{ $avatarColor }} text-white d-flex align-items-center justify-content-center me-3">
                    {{ $initials }}
                  </div>
                  <div>
                    <div class="fw-semibold text-dark">{{ $u->name }}</div>
                    <small class="text-muted">&#64;{{ $u->username }}</small>
                  </div>
                </div>
              </td>

              <td>
                <div class="small text-dark">
                  <i class="bi bi-envelope text-muted me-1"></i>{{ $u->email }}
                </div>
                @if($u->phone)
                  <small class="text-muted">
                    <i class="bi bi-telephone me-1"></i>+91 {{ $u->phone }}
                  </small>
                @endif
              </td>

              <td>
                @if($u->course)
                  <span class="badge bg-light text-dark border border-secondary-subtle rounded-pill px-3">
                    {{ $u->course }}
                  </span>
                @else
                  <span class="text-muted small">—</span>
                @endif
              </td>

              <td>
                @if($isAdmin)
                  <span class="badge bg-danger rounded-pill px-3 badge-admin">
                    <i class="bi bi-shield-lock-fill me-1"></i>ADMIN
                  </span>
                @else
                  <span class="badge bg-success-subtle text-success rounded-pill px-3">
                    <i class="bi bi-person-fill me-1"></i>STUDENT
                  </span>
                @endif
              </td>

              <td>
                @if($u->hasVerifiedEmail())
                  <span class="text-success small">
                    <i class="bi bi-patch-check-fill me-1"></i>Verified
                  </span>
                @else
                  <span class="text-warning small">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>Pending
                  </span>
                @endif
              </td>

              <td class="text-end pe-4">
                <div class="d-flex justify-content-end gap-1">
                  <form action="{{ route('admin.users.toggleRole', $u) }}" method="POST" class="d-inline toggle-role-form">
                    @csrf @method('PATCH')
                    <button class="btn btn-sm btn-outline-{{ $isAdmin ? 'secondary' : 'primary' }} rounded-circle btn-icon-hover"
                            style="width:34px;height:34px;padding:0;"
                            title="{{ $isAdmin ? 'Demote to Student' : 'Promote to Admin' }}"
                            aria-label="{{ $isAdmin ? 'Demote to Student' : 'Promote to Admin' }}"
                            {{ $u->id === auth()->id() ? 'disabled' : '' }}>
                      <i class="bi bi-arrow-repeat"></i>
                    </button>
                  </form>

                  <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline delete-user-form">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger rounded-circle btn-icon-hover"
                            style="width:34px;height:34px;padding:0;"
                            title="Delete user"
                            aria-label="Delete user"
                            {{ $u->id === auth()->id() ? 'disabled' : '' }}>
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-5">
                <div class="animate-fade-in">
                  <i class="bi bi-inbox display-4 d-block mb-2 opacity-25 animate-icon-float"></i>
                  <div class="fw-semibold">No users found</div>
                  <small>
                    @if(request()->hasAny(['q','role']))
                      Try adjusting your filters
                    @else
                      Users will appear here once they register
                    @endif
                  </small>
                </div>
              </td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- ============ PAGINATION ============ --}}
  <div class="mt-3 animate-fade-in" style="animation-delay:0.8s;">
    {{ $users->links('vendor.pagination.custom') }}
  </div>

</div>
@endsection

{{-- ============ STYLES ============ --}}
@push('styles')
<style>
  /* ═══════════ ENTRANCE ANIMATIONS ═══════════ */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes statIn {
    0%   { opacity: 0; transform: translateY(20px) scale(0.96); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
  }
  @keyframes rowIn {
    from { opacity: 0; transform: translateX(-12px); }
    to   { opacity: 1; transform: translateX(0); }
  }
  @keyframes pulseRing {
    0%   { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.6); }
    70%  { box-shadow: 0 0 0 12px rgba(220, 53, 69, 0); }
    100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
  }
  @keyframes iconPop {
    0%, 100% { transform: scale(1); }
    50%      { transform: scale(1.15); }
  }
  @keyframes iconFloat {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-6px); }
  }
  @keyframes avatarPop {
    0%   { transform: scale(0); }
    70%  { transform: scale(1.15); }
    100% { transform: scale(1); }
  }

  .animate-fade-in { animation: fadeIn 0.5s ease-out both; }
  .animate-stat    { animation: statIn 0.55s cubic-bezier(0.16, 1, 0.3, 1) both; }

  .row-animate {
    animation: rowIn 0.5s ease-out both;
  }

  .animate-icon-pop {
    display: inline-block;
    animation: iconPop 2s ease-in-out infinite;
    transform-origin: center;
  }
  .animate-icon-float {
    animation: iconFloat 3s ease-in-out infinite;
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
  .icon-pulse {
    animation: pulseRing 2.5s ease-out infinite;
    border-radius: 50%;
  }

  /* ═══════════ COUNTERS ═══════════ */
  .counter {
    font-variant-numeric: tabular-nums;
  }

  /* ═══════════ USER AVATARS ═══════════ */
  .user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-weight: 600;
    font-size: 1rem;
    flex-shrink: 0;
    transition: transform .25s ease, box-shadow .25s ease;
    animation: avatarPop 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
  }
  tbody tr:hover .user-avatar {
    transform: scale(1.1) rotate(-5deg);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
  }

  /* ═══════════ TABLE ROWS ═══════════ */
  tbody tr {
    transition: background-color .2s ease, transform .2s ease;
  }
  tbody tr:hover {
    background-color: #f8fafc;
    transform: translateX(2px);
  }

  /* ═══════════ BADGES ═══════════ */
  .badge-admin {
    position: relative;
  }
  .badge-admin::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 999px;
    animation: pulseRing 3s ease-out infinite;
    pointer-events: none;
  }

  /* ═══════════ BUTTONS ═══════════ */
  .btn-hover-lift {
    transition: transform .2s ease, box-shadow .2s ease;
  }
  .btn-hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
  }
  .btn-icon-hover {
    transition: all .2s ease;
  }
  .btn-icon-hover:hover:not(:disabled) {
    transform: scale(1.15);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }
  .btn-icon-hover:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  /* ═══════════ SEARCH INPUT ═══════════ */
  .input-group-text.rounded-start-pill {
    border-top-left-radius: 50rem !important;
    border-bottom-left-radius: 50rem !important;
  }
  input.form-control.rounded-end-pill {
    border-top-right-radius: 50rem !important;
    border-bottom-right-radius: 50rem !important;
  }
  .form-control:focus,
  .form-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, .15);
  }

  /* ═══════════ RESPONSIVE ═══════════ */
  @media (max-width: 767.98px) {
    .user-avatar {
      width: 36px;
      height: 36px;
      font-size: .9rem;
    }
    .table td, .table th {
      font-size: .875rem;
    }
  }

  /* ═══════════ REDUCED MOTION ═══════════ */
  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
      animation-duration: 0.001ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.001ms !important;
    }
    .stat-card:hover,
    .btn-hover-lift:hover,
    .btn-icon-hover:hover {
      transform: none !important;
    }
    tbody tr:hover {
      transform: none !important;
    }
  }
</style>
@endpush

{{-- ============ SCRIPTS ============ --}}
@push('scripts')
<script>
  /* ═══════ Delete user confirmation ═══════ */
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-user-form').forEach(function (form) {
      form.addEventListener('submit', function (e) {
        if (!confirm('Delete this user permanently? This cannot be undone.')) {
          e.preventDefault();
        }
      });
    });

    document.querySelectorAll('.toggle-role-form').forEach(function (form) {
      form.addEventListener('submit', function (e) {
        if (!confirm('Change this user\'s role?')) {
          e.preventDefault();
        }
      });
    });
  });

  /* ═══════ Counter animation ═══════ */
  (function () {
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    document.querySelectorAll('.counter').forEach(function (el) {
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
        const current = Math.round(target * eased);
        el.textContent = current.toLocaleString();
        if (progress < 1) {
          requestAnimationFrame(step);
        }
      }

      requestAnimationFrame(step);
    });
  })();
</script>
@endpush