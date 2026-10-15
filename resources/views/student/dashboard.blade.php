@extends('layouts.app')
@section('title','My Dashboard')

@section('content')
<div class="container py-4">

  {{-- Welcome banner --}}
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

  {{-- Stats --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="text-muted small text-uppercase">Total Notices</div>
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
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="text-muted small text-uppercase">This Week</div>
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
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="text-muted small text-uppercase">Urgent</div>
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
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="text-muted small text-uppercase">Must Read</div>
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

    {{-- Left column: profile + urgent --}}
    <div class="col-lg-4">

      {{-- Profile card --}}
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <div class="text-center mb-3">
            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-2"
                 style="width:72px;height:72px;font-size:28px;font-weight:600;">
              {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h6 class="fw-bold mb-0">{{ $user->name }}</h6>
            <small class="text-muted">@{{ $user->username }}</small>
          </div>

          <hr class="opacity-25">

          <div class="mb-3">
            <div class="text-muted small text-uppercase fw-semibold">Email</div>
            <div class="d-flex align-items-center">
              <span class="text-truncate">{{ $user->email }}</span>
              @if($user->hasVerifiedEmail())
                <i class="bi bi-patch-check-fill text-success ms-2" title="Verified"></i>
              @endif
            </div>
          </div>

          <div class="mb-3">
            <div class="text-muted small text-uppercase fw-semibold">Phone</div>
            <div>+91 {{ $user->phone }}</div>
          </div>

          <div class="mb-3">
            <div class="text-muted small text-uppercase fw-semibold">Course</div>
            <div>{{ $user->course }}</div>
          </div>

          <div class="mb-3">
            <div class="text-muted small text-uppercase fw-semibold">Date of Birth</div>
            <div>{{ \Carbon\Carbon::parse($user->dob)->format('d M Y') }}</div>
          </div>

          <div class="mb-0">
            <div class="text-muted small text-uppercase fw-semibold">College Internet ID</div>
            <div>{{ $user->college_internet_id ?? '—' }}</div>
          </div>
        </div>
      </div>

      {{-- Urgent notices --}}
      @if($urgentNotices->count())
        <div class="card border-0 shadow-sm border-start border-danger border-4">
          <div class="card-body p-4">
            <h6 class="fw-bold text-danger mb-3">
              <i class="bi bi-exclamation-triangle-fill me-2"></i>Urgent Notices
            </h6>
            @foreach($urgentNotices as $u)
              <div class="border-bottom pb-2 mb-2">
                <div class="fw-semibold small text-dark">{{ $u->title }}</div>
                <small class="text-muted">{{ $u->created_at->diffForHumans() }}</small>
              </div>
            @endforeach
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-danger w-100 mt-2">
              View All Urgent
            </a>
          </div>
        </div>
      @endif
    </div>

    {{-- Right column: notices --}}
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
          <h6 class="fw-bold mb-0">
            <i class="bi bi-clock-history me-2 text-primary"></i>Latest Notices
          </h6>
          <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary">
            Browse All <i class="bi bi-arrow-right ms-1"></i>
          </a>
        </div>
        <div class="card-body p-4">
          @forelse($latestNotices as $n)
            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
              <div class="flex-grow-1 me-3">
                <div class="mb-1">
                  <span class="badge bg-light text-secondary border rounded-pill px-2"
                        style="font-size:.65rem;">
                    {{ \App\Models\Notice::CATEGORIES[$n->category] ?? ucfirst($n->category) }}
                  </span>
                  @if($n->priority === 'Urgent')
                    <span class="badge bg-danger rounded-pill px-2" style="font-size:.65rem;">Urgent</span>
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
                     class="btn btn-sm btn-outline-primary" title="Download">
                    <i class="bi bi-download"></i>
                  </a>
                @endif
              </div>
            </div>
          @empty
            <div class="text-center text-muted py-5">
              <i class="bi bi-inbox display-4 d-block mb-2 opacity-25"></i>
              No notices yet.
            </div>
          @endforelse
        </div>
      </div>
    </div>

  </div>
</div>
@endsection