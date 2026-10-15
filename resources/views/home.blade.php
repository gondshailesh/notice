@extends('layouts.app')
@section('title','Notice Board')

@section('content')
<div class="container-fluid py-4 px-lg-5" id="notices">
  <div class="row g-4">

    {{-- ============ SIDEBAR FILTER ============ --}}
    <div class="col-lg-3">
      <div class="sticky-top" style="top:90px;z-index:5;">

        <form method="GET" action="{{ route('home') }}" id="filterForm">

          <div class="card shadow-sm mb-3">
            <div class="card-body p-4">
              <h6 class="fw-bold mb-3"><i class="bi bi-search me-2 text-primary"></i>Search</h6>
              <input type="text" name="q" value="{{ request('q') }}"
                     class="form-control" placeholder="Keywords...">
            </div>
          </div>

          <div class="card shadow-sm mb-3">
            <div class="card-body p-4">
              <h6 class="fw-bold mb-3">
                <i class="bi bi-funnel me-2 text-primary"></i>Categories
              </h6>

              @php $selected = (array) request('categories', []); @endphp

              <div class="d-flex justify-content-between mb-2 small">
                <a href="#" onclick="selectAllCategories(event)" class="text-primary text-decoration-none">Select all</a>
                <a href="#" onclick="clearAllCategories(event)" class="text-muted text-decoration-none">Clear</a>
              </div>

              @foreach(\App\Models\Notice::CATEGORIES as $key => $label)
                <div class="form-check mb-2">
                  <input class="form-check-input category-check" type="checkbox"
                         name="categories[]" value="{{ $key }}"
                         id="chk_{{ $key }}"
                         {{ in_array($key, $selected) ? 'checked':'' }}>
                  <label class="form-check-label fw-medium text-secondary" for="chk_{{ $key }}">
                    {{ $label }}
                  </label>
                </div>
              @endforeach
            </div>
          </div>

          <div class="card shadow-sm mb-3">
            <div class="card-body p-4">
              <h6 class="fw-bold mb-3">
                <i class="bi bi-exclamation-circle me-2 text-primary"></i>Priority
              </h6>
              <select name="priority" class="form-select">
                <option value="">All Priorities</option>
                <option value="Normal" @selected(request('priority') === 'Normal')>Normal</option>
                <option value="Urgent" @selected(request('priority') === 'Urgent')>Urgent</option>
              </select>
            </div>
          </div>

          <div class="card shadow-sm mb-3">
            <div class="card-body p-4">
              <h6 class="fw-bold mb-3">
                <i class="bi bi-calendar-range me-2 text-primary"></i>Date Range
              </h6>

              <label class="small text-muted">From</label>
              <input type="date" name="from" value="{{ request('from') }}" class="form-control mb-2">

              <label class="small text-muted">To</label>
              <input type="date" name="to" value="{{ request('to') }}" class="form-control mb-3">

              <div class="d-grid gap-2">
                <button class="btn btn-primary py-2 fw-bold">
                  <i class="bi bi-check2-circle me-1"></i>Apply Filters
                </button>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                  <i class="bi bi-arrow-clockwise me-1"></i>Reset All
                </a>
              </div>
            </div>
          </div>

        </form>

        @if(request('q') || request('categories') || request('priority') || request('from') || request('to'))
          <div class="card border-0 bg-primary-subtle">
            <div class="card-body p-3 small">
              <div class="fw-bold mb-2 text-primary-emphasis">
                <i class="bi bi-funnel-fill me-1"></i>Active Filters
              </div>
              @if(request('q'))
                <div class="mb-1">🔍 "{{ request('q') }}"</div>
              @endif
              @if(request('categories'))
                <div class="mb-1">📂 {{ count((array)request('categories')) }} categories</div>
              @endif
              @if(request('priority'))
                <div class="mb-1">⚡ {{ request('priority') }}</div>
              @endif
              @if(request('from') || request('to'))
                <div class="mb-1">
                  📅 {{ request('from') ?: 'any' }} → {{ request('to') ?: 'today' }}
                </div>
              @endif
            </div>
          </div>
        @endif

      </div>
    </div>

    {{-- ============ MAIN CONTENT ============ --}}
    <div class="col-lg-9">

      {{-- Banner --}}
      @if($banner)
        <div class="card bg-dark text-white shadow-lg mb-4 overflow-hidden" style="border-radius:26px;">
          <div class="row g-0">
            <div class="col-md-8 p-5">
              <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold">
                <i class="bi bi-megaphone-fill me-1"></i>
                {{ strtoupper($banner->category === 'must_read' ? 'MUST READ' : $banner->priority) }}
              </span>
              <h2 class="fw-bold display-6 mb-3">{{ $banner->title }}</h2>
              <p class="opacity-75 lead mb-4">
                {{ \Illuminate\Support\Str::limit(strip_tags($banner->description), 180) }}
              </p>

              <div class="d-flex gap-2 flex-wrap">
                @if($banner->attachment_path)
                  <a href="{{ route('notices.download', $banner->id) }}" class="btn btn-warning fw-bold px-4">
                    <i class="bi bi-download me-1"></i>Download
                  </a>
                @endif
                <button class="btn btn-outline-light px-4" data-bs-toggle="modal" data-bs-target="#bannerModal">
                  <i class="bi bi-eye me-1"></i>View
                </button>
              </div>
            </div>
            <div class="col-md-4 d-none d-md-flex align-items-center justify-content-center bg-white bg-opacity-10">
              <i class="bi bi-journal-text display-1 opacity-25"></i>
            </div>
          </div>
        </div>

        <div class="modal fade" id="bannerModal" tabindex="-1">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
              <div class="modal-header">
                <h5 class="fw-bold">{{ $banner->title }}</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">{!! nl2br(e($banner->description)) !!}</div>
            </div>
          </div>
        </div>
      @endif

      {{-- All notices header --}}
      <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h5 class="fw-bold mb-0">
          {{ request('categories') || request('q') || request('from') || request('to') || request('priority')
             ? 'Filtered Notices' : 'All Notices' }}
        </h5>
        <small class="text-muted">
          <i class="bi bi-clock-history me-1"></i>{{ now()->format('d M Y, h:i A') }}
          &nbsp;•&nbsp;
          <strong>{{ $notices->total() }}</strong> result{{ $notices->total() !== 1 ? 's' : '' }}
        </small>
      </div>

      {{-- ============ 3-CARD GRID ============ --}}
      <div class="row g-4">
        @forelse($notices as $n)
          @php
            $theme = match($n->category) {
              'must_read'      => ['color' => 'warning',  'icon' => 'bi-star-fill'],
              'examination'    => ['color' => 'danger',   'icon' => 'bi-pencil-square'],
              'placement'      => ['color' => 'success',  'icon' => 'bi-briefcase'],
              'event'          => ['color' => 'info',     'icon' => 'bi-cpu'],
              'academic'       => ['color' => 'primary',  'icon' => 'bi-book'],
              'admission'      => ['color' => 'info',     'icon' => 'bi-person-plus'],
              'sports'         => ['color' => 'success',  'icon' => 'bi-trophy'],
              'administrative' => ['color' => 'secondary','icon' => 'bi-building'],
              'library'        => ['color' => 'secondary','icon' => 'bi-book-half'],
              'scholarship'    => ['color' => 'warning',  'icon' => 'bi-cash-coin'],
              'urgent'         => ['color' => 'danger',   'icon' => 'bi-exclamation-triangle'],
              default          => ['color' => 'primary',  'icon' => 'bi-file-earmark-text'],
            };
          @endphp

          <div class="col-md-6 col-xl-4">
            <div class="card h-100 border-0 shadow-sm notice-card hover-up position-relative">

              {{-- Date badge --}}
              <div class="date-badge rounded-pill
                          {{ $n->category === 'must_read'
                              ? 'bg-warning text-dark'
                              : ($n->priority === 'Urgent' ? 'bg-danger text-white' : 'bg-primary text-white') }}">
                {{ $n->created_at->format('d M') }}
              </div>

              <div class="card-body p-4 d-flex flex-column">

                {{-- Category badge --}}
                <div class="mb-3">
                  <span class="badge bg-{{ $theme['color'] }}-subtle text-{{ $theme['color'] }} rounded-pill px-3 py-2">
                    <i class="bi {{ $theme['icon'] }} me-1"></i>
                    {{ \App\Models\Notice::CATEGORIES[$n->category] ?? ucfirst($n->category) }}
                  </span>
                </div>

                {{-- Title --}}
                <h6 class="fw-bold text-dark mb-2 notice-title">
                  {{ Str::limit($n->title, 65) }}
                </h6>

                {{-- Description --}}
                <p class="text-muted small flex-grow-1 line-clamp-3 mb-3">
                  {{ Str::limit(strip_tags($n->description), 120) }}
                </p>

                {{-- Priority / semester chips --}}
                <div class="mb-3 d-flex flex-wrap gap-1">
                  @if($n->priority === 'Urgent')
                    <span class="badge bg-danger-subtle text-danger rounded-pill px-2">
                      <i class="bi bi-lightning-charge-fill me-1"></i>Urgent
                    </span>
                  @endif
                  @if($n->target_semester && $n->target_semester !== 'all')
                    <span class="badge bg-info-subtle text-info rounded-pill px-2">
                      {{ $n->target_semester }}
                    </span>
                  @endif
                  @if($n->attachment_path)
                    <span class="badge bg-light text-dark border rounded-pill px-2">
                      <i class="bi bi-paperclip me-1"></i>File
                    </span>
                  @endif
                </div>

                {{-- Footer: date + actions --}}
                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                  <small class="text-muted">
                    <i class="bi bi-clock me-1"></i>{{ $n->created_at->diffForHumans() }}
                  </small>
                  <div class="d-flex gap-1">
                    @if($n->attachment_path)
                      <a href="{{ route('notices.download', $n->id) }}"
                         class="btn btn-sm btn-outline-primary"
                         title="Download">
                        <i class="bi bi-download"></i>
                      </a>
                    @endif
                    <button class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#noticeModal{{ $n->id }}"
                            title="View">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- Modal --}}
          <div class="modal fade" id="noticeModal{{ $n->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content rounded-4 border-0">
                <div class="modal-header">
                  <h5 class="fw-bold">{{ $n->title }}</h5>
                  <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <span class="badge bg-{{ $theme['color'] }}-subtle text-{{ $theme['color'] }} rounded-pill px-3">
                      <i class="bi {{ $theme['icon'] }} me-1"></i>
                      {{ \App\Models\Notice::CATEGORIES[$n->category] ?? ucfirst($n->category) }}
                    </span>
                    @if($n->priority === 'Urgent')
                      <span class="badge bg-danger rounded-pill px-3">Urgent</span>
                    @endif
                  </div>
                  <div class="text-muted small mb-3">
                    <i class="bi bi-calendar3 me-1"></i>{{ $n->created_at->format('d M Y, h:i A') }}
                  </div>
                  <div>{!! nl2br(e($n->description)) !!}</div>
                </div>
                @if($n->attachment_path)
                  <div class="modal-footer">
                    <a href="{{ route('notices.download', $n->id) }}" class="btn btn-primary">
                      <i class="bi bi-download me-1"></i>Download Attachment
                    </a>
                  </div>
                @endif
              </div>
            </div>
          </div>

        @empty
          <div class="col-12">
            <div class="card shadow-sm">
              <div class="card-body text-center py-5">
                <i class="bi bi-inbox display-4 text-muted opacity-25"></i>
                <h5 class="mt-3 text-muted">No notices match your filters</h5>
                <p class="text-muted">Try adjusting categories, dates, or search terms.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                  <i class="bi bi-arrow-clockwise me-1"></i>Clear Filters
                </a>
              </div>
            </div>
          </div>
        @endforelse
      </div>

      {{-- Pagination --}}
      <div class="mt-4 d-flex justify-content-center">
        {{ $notices->links() }}
      </div>

    </div>
  </div>
</div>

<style>
  .hover-up { transition: all .25s ease; }
  .hover-up:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,.08) !important; }

  .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .notice-card {
    border-radius: 18px !important;
    border: 1px solid rgba(0,0,0,.05) !important;
    overflow: hidden;
  }

  .date-badge {
    position: absolute;
    top: 14px;
    right: 14px;
    padding: 4px 14px;
    font-size: .72rem;
    font-weight: 700;
    z-index: 10;
  }

  .notice-title {
    line-height: 1.35;
    min-height: 2.7em;
  }
</style>
@endsection

@push('scripts')
<script>
  function selectAllCategories(e) {
    e.preventDefault();
    document.querySelectorAll('.category-check').forEach(c => c.checked = true);
  }

  function clearAllCategories(e) {
    e.preventDefault();
    document.querySelectorAll('.category-check').forEach(c => c.checked = false);
  }

  document.querySelector('select[name="priority"]')?.addEventListener('change', function () {
    document.getElementById('filterForm').submit();
  });

  document.querySelectorAll('input[type="date"]').forEach(el => {
    el.addEventListener('change', function () {
      document.getElementById('filterForm').submit();
    });
  });
</script>
@endpush