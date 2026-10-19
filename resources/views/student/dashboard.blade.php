@extends('layouts.app')
@section('title','My Dashboard')

@section('content')

{{-- ⚡ Flag JS as ready (fixes .notice-row opacity fallback) --}}
<script>document.documentElement.classList.add('js-ready');</script>

<div class="container py-4">

  {{-- Welcome banner --}}
  <div class="card border-0 shadow-sm mb-4 text-white banner-animated reveal"
       data-delay="0"
       style="border-radius:22px;background:linear-gradient(135deg,#0d6efd 0%,#0a58ca 60%,#084298 100%);background-size:200% 200%;">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
          <h4 class="fw-bold mb-1">Hi {{ explode(' ', $user->name ?? 'there')[0] }} 👋</h4>
          <p class="mb-0 opacity-75">Welcome to your student dashboard.</p>
        </div>
        <div class="text-end">
          <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold badge-pop">
            {{ $user->course }}
          </span>
        </div>
      </div>
    </div>
  </div>

  {{-- Success flash --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm animate-fade-in">
      <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
      <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Stats --}}
<div class="row g-3 mb-4">

  {{-- Total Notices → all notices --}}
  <div class="col-6 col-md-3 reveal" data-delay="0">
    <a href="{{ route('home') }}" class="text-decoration-none stat-link">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="text-muted small text-uppercase">Total Notices</div>
            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center icon-box-hover"
                 style="width:36px;height:36px;">
              <i class="bi bi-megaphone"></i>
            </div>
          </div>
          {{-- ✅ FIX: render actual value as fallback --}}
          <h3 class="fw-bold mb-0 text-primary counter" data-target="{{ $stats['total'] ?? 0 }}">{{ $stats['total'] ?? 0 }}</h3>
          <small class="text-muted small-link">
            View all <i class="bi bi-arrow-right ms-1"></i>
          </small>
        </div>
      </div>
    </a>
  </div>

  {{-- This Week → filtered by date --}}
  <div class="col-6 col-md-3 reveal" data-delay="100">
    <a href="{{ route('home', ['date_from' => now()->startOfWeek()->toDateString(), 'date_to' => now()->toDateString()]) }}"
       class="text-decoration-none stat-link">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="text-muted small text-uppercase">This Week</div>
            <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center icon-box-hover"
                 style="width:36px;height:36px;">
              <i class="bi bi-calendar-week"></i>
            </div>
          </div>
          {{-- ✅ FIX: render actual value as fallback --}}
          <h3 class="fw-bold mb-0 text-success counter" data-target="{{ $stats['this_week'] ?? 0 }}">{{ $stats['this_week'] ?? 0 }}</h3>
          <small class="text-muted small-link">
            View week <i class="bi bi-arrow-right ms-1"></i>
          </small>
        </div>
      </div>
    </a>
  </div>

  {{-- Urgent → filtered by priority --}}
  <div class="col-6 col-md-3 reveal" data-delay="200">
    <a href="{{ route('home', ['priority' => 'Urgent']) }}" class="text-decoration-none stat-link">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="text-muted small text-uppercase">Urgent</div>
            <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center icon-box-hover icon-pulse-soft"
                 style="width:36px;height:36px;">
              <i class="bi bi-exclamation-triangle"></i>
            </div>
          </div>
          {{-- ✅ FIX: render actual value as fallback --}}
          <h3 class="fw-bold mb-0 text-danger counter" data-target="{{ $stats['urgent'] ?? 0 }}">{{ $stats['urgent'] ?? 0 }}</h3>
          <small class="text-muted small-link">
            View urgent <i class="bi bi-arrow-right ms-1"></i>
          </small>
        </div>
      </div>
    </a>
  </div>

  {{-- Must Read → filtered by category --}}
  <div class="col-6 col-md-3 reveal" data-delay="300">
    <a href="{{ route('home', ['category' => 'must_read']) }}" class="text-decoration-none stat-link">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="text-muted small text-uppercase">Must Read</div>
            <div class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center icon-box-hover"
                 style="width:36px;height:36px;">
              <i class="bi bi-star-fill icon-twinkle"></i>
            </div>
          </div>
          {{-- ✅ FIX: render actual value as fallback --}}
          <h3 class="fw-bold mb-0 text-warning-emphasis counter" data-target="{{ $stats['must_read'] ?? 0 }}">{{ $stats['must_read'] ?? 0 }}</h3>
          <small class="text-muted small-link">
            View must-read <i class="bi bi-arrow-right ms-1"></i>
          </small>
        </div>
      </div>
    </a>
  </div>

</div>


  <div class="row g-4">

    {{-- Left column: profile + urgent --}}
    <div class="col-lg-4">

      {{-- Profile card --}}
      <div class="card border-0 shadow-sm mb-4 reveal" data-delay="0">
        <div class="card-body p-4">
          <div class="text-center mb-3">
            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-2 avatar-breathe"
                 style="width:72px;height:72px;font-size:28px;font-weight:600;">
              {{ mb_strtoupper(mb_substr($user->name ?? '?', 0, 1)) }}
            </div>
            <h6 class="fw-bold mb-0">{{ $user->name }}</h6>
            <small class="text-muted">&#64;{{ $user->username }}</small>
          </div>

          {{-- EDIT PROFILE BUTTON --}}
          <div class="d-grid mb-3">
            <button type="button"
                    class="btn btn-sm btn-outline-primary btn-lift"
                    data-bs-toggle="modal"
                    data-bs-target="#editProfileModal">
              <i class="bi bi-pencil-square me-1"></i>Edit Profile
            </button>
          </div>

          <hr class="opacity-25">

          <div class="mb-3 info-row">
            <div class="text-muted small text-uppercase fw-semibold">Email</div>
            <div class="d-flex align-items-center">
              <span class="text-truncate">{{ $user->email }}</span>
              @if($user->hasVerifiedEmail())
                <i class="bi bi-patch-check-fill text-success ms-2" title="Verified"></i>
              @endif
            </div>
          </div>

          <div class="mb-3 info-row">
            <div class="text-muted small text-uppercase fw-semibold">Phone</div>
            <div>+91 {{ $user->phone }}</div>
          </div>

          <div class="mb-3 info-row">
            <div class="text-muted small text-uppercase fw-semibold">Course</div>
            <div>{{ $user->course }}</div>
          </div>

          <div class="mb-3 info-row">
            <div class="text-muted small text-uppercase fw-semibold">Date of Birth</div>
            <div>{{ \Carbon\Carbon::parse($user->dob)->format('d M Y') }}</div>
          </div>

          <div class="mb-0 info-row">
            <div class="text-muted small text-uppercase fw-semibold">College Internet ID</div>
            <div>{{ $user->college_internet_id ?? '—' }}</div>
          </div>
        </div>
      </div>

      {{-- Urgent notices --}}
      @if($urgentNotices->count())
        <div class="card border-0 shadow-sm border-start border-danger border-4 reveal" data-delay="100">
          <div class="card-body p-4">
            <h6 class="fw-bold text-danger mb-3">
              <i class="bi bi-exclamation-triangle-fill me-2 icon-pulse-soft"></i>Urgent Notices
            </h6>
            @foreach($urgentNotices as $u)
              <div class="border-bottom pb-2 mb-2 urgent-item">
                <div class="fw-semibold small text-dark">{{ $u->title }}</div>
                <small class="text-muted">{{ $u->created_at->diffForHumans() }}</small>
              </div>
            @endforeach
            <a href="{{ route('home', ['priority' => 'Urgent']) }}" class="btn btn-sm btn-outline-danger w-100 mt-2 btn-lift">
              View All Urgent
            </a>
          </div>
        </div>
      @endif
    </div>

    {{-- Right column: notices --}}
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm reveal" data-delay="150">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
          <h6 class="fw-bold mb-0">
            <i class="bi bi-clock-history me-2 text-primary"></i>Latest Notices
          </h6>
          <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary btn-lift">
            Browse All <i class="bi bi-arrow-right ms-1 arrow-slide"></i>
          </a>
        </div>
        <div class="card-body p-4">
          @forelse($latestNotices as $n)
            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3 notice-row" style="--row-delay:{{ $loop->index * 0.05 }}s;">
              <div class="flex-grow-1 me-3">
                <div class="mb-1">
                  <span class="badge bg-light text-secondary border rounded-pill px-2 badge-pop"
                        style="font-size:.65rem;">
                    {{ \App\Models\Notice::categories()[$n->category] ?? ucfirst($n->category ?? '') }}
                  </span>
                  @if($n->priority === 'Urgent')
                    <span class="badge bg-danger rounded-pill px-2 badge-urgent" style="font-size:.65rem;">Urgent</span>
                  @endif
                </div>
                <div class="fw-semibold text-dark">{{ $n->title }}</div>
                <small class="text-muted">
                  {{ $n->created_at->diffForHumans() }}
                </small>
              </div>
              <div class="d-flex flex-column gap-1">
                @if($n->attachment_path)
                  <a href="{{ route('notices.download', $n->id) }}"
                     class="btn btn-sm btn-outline-primary btn-icon-hover" title="Download">
                    <i class="bi bi-download"></i>
                  </a>
                @endif
              </div>
            </div>
          @empty
            <div class="text-center text-muted py-5 animate-fade-in">
              <i class="bi bi-inbox display-4 d-block mb-2 opacity-25 icon-float-gentle"></i>
              No notices yet.
            </div>
          @endforelse
        </div>
      </div>
    </div>

  </div>
</div>

{{-- EDIT PROFILE MODAL --}}
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg" style="border-radius:18px;overflow:hidden;">

      <form method="POST" action="{{ route('student.profile.update') }}" id="editProfileForm">
        @csrf
        @method('PUT')

        <div class="modal-header text-white border-0"
             style="background:linear-gradient(135deg,#0d6efd 0%,#0a58ca 100%);">
          <div>
            <h5 class="modal-title fw-bold mb-0" id="editProfileModalLabel">
              <i class="bi bi-person-gear me-2"></i>Edit Profile
            </h5>
            <small class="opacity-75">Update your personal information</small>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4">
          @if($errors->any())
            <div class="alert alert-danger border-0 rounded-3 py-2 mb-3">
              <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Full Name <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-person text-muted"></i></span>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}" required>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold">Username <span class="text-muted">(cannot change)</span></label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-at text-muted"></i></span>
                <input type="text" class="form-control bg-light" value="{{ $user->username }}" readonly>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold">Email <span class="text-muted">(cannot change)</span></label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-envelope text-muted"></i></span>
                <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold">Phone <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-white">+91</span>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $user->phone) }}" pattern="[0-9]{10}" maxlength="10" required>
              </div>
              <small class="text-muted">10 digits only</small>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold">Course <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-book text-muted"></i></span>
                <input type="text" name="course" class="form-control @error('course') is-invalid @enderror"
                       value="{{ old('course', $user->course) }}" required>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold">Date of Birth <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-calendar-event text-muted"></i></span>
                <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
                       value="{{ old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '') }}"
                       max="{{ now()->subYears(15)->toDateString() }}" required>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold">College Internet ID</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-key text-muted"></i></span>
                <input type="text" name="college_internet_id" class="form-control @error('college_internet_id') is-invalid @enderror"
                       value="{{ old('college_internet_id', $user->college_internet_id) }}" placeholder="Optional">
              </div>
            </div>

            <div class="col-12">
              <hr class="my-3">
              <h6 class="fw-bold text-muted small text-uppercase mb-3">
                <i class="bi bi-shield-lock me-1"></i>Change Password (optional)
              </h6>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold">New Password</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="Leave empty to keep current" minlength="8">
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-semibold">Confirm New Password</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-lock-fill text-muted"></i></span>
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Repeat new password" minlength="8">
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer border-0 bg-light">
          <button type="button" class="btn btn-outline-secondary btn-lift" data-bs-dismiss="modal">
            <i class="bi bi-x-lg me-1"></i>Cancel
          </button>
          <button type="submit" class="btn btn-primary btn-lift">
            <i class="bi bi-check-lg me-1"></i>Save Changes
          </button>
        </div>

      </form>
    </div>
  </div>
</div>
@endsection

{{-- ============ STYLES ============ --}}
@push('styles')
<style>
  @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
  @keyframes bannerShift { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
  @keyframes pulseRingSoft { 0%, 100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.35); } 50% { box-shadow: 0 0 0 8px rgba(220, 53, 69, 0); } }
  @keyframes twinkle { 0%, 100% { transform: scale(1) rotate(0deg); opacity: 1; } 50% { transform: scale(1.15) rotate(-8deg); opacity: .85; } }
  @keyframes breathe { 0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4); } 50% { transform: scale(1.04); box-shadow: 0 0 0 12px rgba(13, 110, 253, 0); } }
  @keyframes iconFloatGentle { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
  @keyframes modalIn { from { opacity: 0; transform: translateY(-20px) scale(0.96); } to { opacity: 1; transform: translateY(0) scale(1); } }

  .animate-fade-in { animation: fadeIn 0.5s ease-out both; }

  .modal.fade .modal-dialog { transform: scale(0.94) translateY(-20px); transition: transform .3s cubic-bezier(0.16, 1, 0.3, 1), opacity .3s ease; }
  .modal.show .modal-dialog { transform: scale(1) translateY(0); }
  .modal-content { animation: modalIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) both; }

  .banner-animated { animation: bannerShift 12s ease infinite; }
  .banner-animated .badge-pop { transition: transform .25s ease, box-shadow .25s ease; }
  .banner-animated .badge-pop:hover { transform: translateY(-2px) scale(1.05); box-shadow: 0 6px 16px rgba(255, 193, 7, 0.4); }

  .stat-card { transition: transform .3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow .3s ease; }
  .stat-card:hover { transform: translateY(-6px) scale(1.01); box-shadow: 0 16px 32px rgba(13, 110, 253, 0.12) !important; }
  .stat-card:hover .icon-box-hover { transform: scale(1.12) rotate(-8deg); }
  .icon-box-hover { transition: transform .3s cubic-bezier(0.16, 1, 0.3, 1); }
  .stat-card:hover .counter { transform: scale(1.06); }
  .counter { font-variant-numeric: tabular-nums; transition: transform .25s ease; display: inline-block; }
  .icon-pulse-soft { animation: pulseRingSoft 2.5s ease-out infinite; border-radius: 50%; }
  .icon-twinkle { display: inline-block; animation: twinkle 2.8s ease-in-out infinite; transform-origin: center; }

  .avatar-breathe { animation: breathe 3.5s ease-in-out infinite; transition: transform .3s ease; }
  .avatar-breathe:hover { transform: scale(1.08) rotate(-3deg); }

  .info-row { transition: transform .2s ease, padding-left .2s ease, border-color .2s ease; border-left: 3px solid transparent; padding-left: 0; }
  .info-row:hover { transform: translateX(3px); padding-left: .5rem; border-left-color: #0d6efd; }

  .urgent-item { transition: transform .2s ease, padding-left .2s ease, background-color .2s ease; padding-left: 0; border-radius: 6px; }
  .urgent-item:hover { transform: translateX(3px); padding-left: .4rem; background-color: #fef2f2; }

  .notice-row { opacity: 1; transform: none; border-radius: 8px; padding-left: 0; transition: background-color .2s ease, padding-left .2s ease; }
  .js-ready .notice-row { opacity: 0; transform: translateX(-12px); transition: opacity .5s ease-out, transform .5s ease-out, background-color .2s ease, padding-left .2s ease; transition-delay: var(--row-delay, 0s); }
  .js-ready .notice-row.is-visible { opacity: 1; transform: translateX(0); }
  .notice-row:hover { background-color: #f8fafc; padding-left: .5rem; }

  .badge-pop { transition: transform .2s ease, background-color .2s ease; }
  .badge-pop:hover { transform: scale(1.08); background-color: #eef2ff !important; }
  .badge-urgent { position: relative; }
  .badge-urgent::after { content: ''; position: absolute; inset: 0; border-radius: 999px; animation: pulseRingSoft 2s ease-out infinite; pointer-events: none; }

  .btn-lift { transition: transform .2s ease, box-shadow .2s ease; }
  .btn-lift:hover { transform: translateY(-2px); box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1); }
  .btn-icon-hover { transition: all .2s ease; }
  .btn-icon-hover:hover { transform: scale(1.15) rotate(-4deg); }

  .arrow-slide { transition: transform .25s ease; display: inline-block; }
  .btn-lift:hover .arrow-slide { transform: translateX(4px); }

  .icon-float-gentle { animation: iconFloatGentle 3s ease-in-out infinite; }

  .modal .form-control:focus, .modal .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15); transition: box-shadow .2s ease, border-color .2s ease; }
  .modal .input-group-text { border-right: 0; transition: border-color .2s ease; }
  .modal .form-control { border-left: 0; transition: border-color .2s ease; }
  .modal .input-group:focus-within .input-group-text { border-color: #0d6efd; }

  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after { animation-duration: 0.001ms !important; animation-iteration-count: 1 !important; transition-duration: 0.001ms !important; }
    .stat-card:hover, .btn-lift:hover, .btn-icon-hover:hover, .info-row:hover, .urgent-item:hover, .notice-row:hover, .avatar-breathe:hover { transform: none !important; }
    .js-ready .notice-row { opacity: 1 !important; transform: none !important; }
  }

.stat-link { display: block; color: inherit; transition: transform .25s ease; }
.stat-link:hover { color: inherit; }
.stat-link .stat-card { position: relative; overflow: hidden; }
.stat-link .small-link { display: inline-block; opacity: 0; transform: translateX(-6px); transition: opacity .25s ease, transform .25s ease; font-size: .7rem; margin-top: .4rem; }
.stat-link:hover .small-link { opacity: 1; transform: translateX(0); }
.stat-link .stat-card::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: currentColor; transform: scaleY(0); transform-origin: top; transition: transform .3s cubic-bezier(0.16, 1, 0.3, 1); }
.stat-link:hover .stat-card::before { transform: scaleY(1); }
</style>
@endpush

{{-- ============ SCRIPTS ============ --}}
@push('scripts')
<script>
  (function () {
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const reveals  = document.querySelectorAll('.reveal');
    const rows     = document.querySelectorAll('.notice-row');
    const counters = document.querySelectorAll('.counter');

    /* Show final counter values (used in every non-animation path) */
    function setCounterFinal(el) {
      if (el.dataset.animated === 'true') return;
      el.dataset.animated = 'true';
      const target = parseInt(el.dataset.target, 10) || 0;
      el.textContent = target.toLocaleString();
    }

    /* ─────── Early exit: no animation, show final values ─────── */
    if (prefersReduced || !('IntersectionObserver' in window)) {
      reveals.forEach(function (el) { el.classList.add('is-visible'); });
      rows.forEach(function (el)    { el.classList.add('is-visible'); });
      counters.forEach(setCounterFinal);   // ✅ NEW: ensures counters show real values
      return;
    }

    /* ─────── Reveal observer ─────── */
    const revealObserver = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          const delay = entry.target.dataset.delay || 0;
          entry.target.style.setProperty('--reveal-delay', delay + 'ms');
          entry.target.classList.add('is-visible');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

    reveals.forEach(function (el) { revealObserver.observe(el); });

    /* ─────── Row observer ─────── */
    const rowObserver = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    rows.forEach(function (el) { rowObserver.observe(el); });

    /* ─────── Counter animation ─────── */
    function animateCounter(el) {
      if (el.dataset.animated === 'true') return;
      el.dataset.animated = 'true';

      const target = parseInt(el.dataset.target, 10) || 0;
      if (target === 0) { el.textContent = '0'; return; }

      el.textContent = '0';           // ✅ explicit reset so it counts up from zero
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

    const counterObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          counterObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.4 });

    counters.forEach(function (el) { counterObserver.observe(el); });
  })();

  /* ═══════ Reopen modal if validation errors exist ═══════ */
  @if($errors->any())
    document.addEventListener('DOMContentLoaded', function () {
      const modalEl = document.getElementById('editProfileModal');
      if (modalEl) new bootstrap.Modal(modalEl).show();
    });
  @endif

  /* ═══════ Phone: strip non-digits as user types ═══════ */
  document.addEventListener('input', function (e) {
    if (e.target && e.target.name === 'phone') {
      e.target.value = e.target.value.replace(/\D/g, '').slice(0, 10);
    }
  });
</script>
@endpush