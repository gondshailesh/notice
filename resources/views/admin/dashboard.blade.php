@extends('layouts.app')
@section('title','Admin Dashboard')

@section('content')

{{-- ============ HERO ============ --}}
<div class="container-fluid px-lg-5 pt-4">
  <div class="card border-0 shadow-sm text-white position-relative overflow-hidden"
       style="border-radius:24px;background:linear-gradient(135deg,#dc3545 0%,#b02a37 50%,#8b1e2a 100%);">
    <div class="card-body p-4 p-lg-5 position-relative">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-2 mb-3">
            <i class="bi bi-shield-lock-fill me-1"></i>ADMIN CONTROL PANEL
          </span>
          <h2 class="fw-bold mb-2">Welcome back, {{ explode(' ', Auth::user()->name)[0] }} 🛡️</h2>
          <p class="opacity-75 mb-4">
            Manage notices, users, and content across the School of Computational Science portal.
          </p>
          <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.notices.create') }}" class="btn btn-warning fw-bold px-4">
              <i class="bi bi-plus-circle me-1"></i>Post Notice
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-light px-4">
              <i class="bi bi-eye me-1"></i>Preview Board
            </a>
          </div>
        </div>
        <div class="col-lg-4 d-none d-lg-flex justify-content-end">
          <i class="bi bi-speedometer2" style="font-size:9rem;opacity:.15;"></i>
        </div>
      </div>
    </div>
    <div class="position-absolute rounded-circle bg-white bg-opacity-10"
         style="width:220px;height:220px;bottom:-100px;right:-60px;"></div>
  </div>
</div>

{{-- ============ STATS ============ --}}
<div class="container-fluid px-lg-5 py-4">
  <div class="row g-3 mb-4">

    <div class="col-6 col-lg-3">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="icon-box bg-primary-subtle text-primary">
              <i class="bi bi-megaphone-fill"></i>
            </div>
            <span class="badge bg-success-subtle text-success rounded-pill small">
              <i class="bi bi-arrow-up-short"></i>live
            </span>
          </div>
          <div class="text-muted small text-uppercase fw-semibold mb-1">Total Notices</div>
          <h2 class="fw-bold mb-0">{{ $stats['total_notices'] }}</h2>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="icon-box bg-success-subtle text-success">
              <i class="bi bi-people-fill"></i>
            </div>
            <span class="badge bg-light text-secondary rounded-pill small">
              {{ $stats['students'] }} students
            </span>
          </div>
          <div class="text-muted small text-uppercase fw-semibold mb-1">Total Users</div>
          <h2 class="fw-bold mb-0">{{ $stats['total_users'] }}</h2>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="icon-box bg-danger-subtle text-danger">
              <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
          </div>
          <div class="text-muted small text-uppercase fw-semibold mb-1">Urgent</div>
          <h2 class="fw-bold mb-0 text-danger">{{ $stats['urgent'] }}</h2>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card border-0 shadow-sm h-100 stat-card">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="icon-box bg-warning-subtle text-warning-emphasis">
              <i class="bi bi-calendar-week-fill"></i>
            </div>
          </div>
          <div class="text-muted small text-uppercase fw-semibold mb-1">This Week</div>
          <h2 class="fw-bold mb-0 text-warning-emphasis">{{ $stats['this_week'] }}</h2>
        </div>
      </div>
    </div>

  </div>

  {{-- ============ QUICK ACTIONS ============ --}}
  <h6 class="fw-bold text-dark mb-3"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Quick Actions</h6>
  <div class="row g-3 mb-4">

    <div class="col-md-6 col-lg-3">
      <a href="{{ route('admin.notices.create') }}" class="text-decoration-none">
        <div class="card border-0 shadow-sm action-card h-100">
          <div class="card-body d-flex align-items-center">
            <div class="action-icon bg-primary text-white">
              <i class="bi bi-plus-lg"></i>
            </div>
            <div class="ms-3">
              <div class="fw-bold text-dark">Post Notice</div>
              <small class="text-muted">Create & publish</small>
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-lg-3">
      <a href="{{ route('home') }}" class="text-decoration-none">
        <div class="card border-0 shadow-sm action-card h-100">
          <div class="card-body d-flex align-items-center">
            <div class="action-icon bg-success text-white">
              <i class="bi bi-eye-fill"></i>
            </div>
            <div class="ms-3">
              <div class="fw-bold text-dark">Preview Board</div>
              <small class="text-muted">Student view</small>
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-lg-3">
      <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
        <div class="card border-0 shadow-sm action-card h-100">
          <div class="card-body d-flex align-items-center">
            <div class="action-icon bg-warning text-dark">
              <i class="bi bi-people-fill"></i>
            </div>
            <div class="ms-3">
              <div class="fw-bold text-dark">Manage Users</div>
              <small class="text-muted">{{ $stats['students'] }} students</small>
            </div>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="card border-0 shadow-sm action-card h-100">
        <div class="card-body d-flex align-items-center">
          <div class="action-icon bg-danger text-white">
            <i class="bi bi-exclamation-triangle-fill"></i>
          </div>
          <div class="ms-3">
            <div class="fw-bold text-dark">Urgent Notices</div>
            <small class="text-muted">{{ $stats['urgent'] }} active</small>
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- ============ RECENT NOTICES TABLE ============ --}}
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
      <h6 class="fw-bold mb-0">
        <i class="bi bi-list-ul me-2 text-primary"></i>All Notices
      </h6>
      <div class="d-flex align-items-center gap-2">
        <span class="badge bg-light text-secondary rounded-pill px-3 py-2">
          {{ $notices->total() }} total
        </span>
        <a href="{{ route('admin.notices.create') }}" class="btn btn-sm btn-primary">
          <i class="bi bi-plus-lg me-1"></i>New
        </a>
      </div>
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
            <tr>
              <td class="ps-4">
                <div class="d-flex align-items-start">
                  <div class="notice-avatar bg-{{ $n->priority === 'Urgent' ? 'danger' : 'primary' }}-subtle
                              text-{{ $n->priority === 'Urgent' ? 'danger' : 'primary' }} me-3">
                    <i class="bi bi-file-earmark-text"></i>
                  </div>
                  <div>
                    <div class="fw-semibold text-dark">{{ Str::limit($n->title, 50) }}</div>
                    <small class="text-muted">
                      {{ Str::limit(strip_tags($n->description), 60) }}
                    </small>
                    @if($n->attachment_path)
                      <div class="mt-1">
                        <span class="badge bg-light text-dark border small">
                          <i class="bi bi-paperclip me-1"></i>Attachment
                        </span>
                      </div>
                    @endif
                  </div>
                </div>
              </td>

              <td>
                <span class="badge bg-light text-dark border rounded-pill px-3">
                  {{ \App\Models\Notice::CATEGORIES[$n->category] ?? $n->category }}
                </span>
              </td>

              <td>
                @if($n->priority === 'Urgent')
                  <span class="badge bg-danger rounded-pill px-3">
                    <i class="bi bi-exclamation-circle me-1"></i>Urgent
                  </span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">Normal</span>
                @endif
              </td>

              <td>
                <div class="small text-dark fw-medium">{{ $n->created_at->format('d M Y') }}</div>
                <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small>
              </td>

              <td class="text-end pe-4">
                <div class="btn-group">
                  @if($n->attachment_path)
                    <a href="{{ route('notices.download', $n->id) }}"
                       class="btn btn-sm btn-outline-primary"
                       title="Download">
                      <i class="bi bi-download"></i>
                    </a>
                  @endif
                  <a href="{{ route('admin.notices.edit', $n) }}"
                     class="btn btn-sm btn-outline-secondary"
                     title="Edit">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.notices.destroy', $n) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Delete this notice? This cannot be undone.')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" title="Delete">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-5">
                <div class="text-muted">
                  <i class="bi bi-inbox display-4 d-block mb-3 opacity-25"></i>
                  <div class="fw-semibold">No notices yet</div>
                  <small>Click "Post Notice" to publish your first notice</small>
                  <div class="mt-3">
                    <a href="{{ route('admin.notices.create') }}" class="btn btn-primary">
                      <i class="bi bi-plus-circle me-1"></i>Post Notice
                    </a>
                  </div>
                </div>
              </td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>

    @if($notices->hasPages())
      <div class="card-footer bg-white border-0 py-3">
        {{ $notices->links() }}
      </div>
    @endif
  </div>

</div>

{{-- ============ STYLES ============ --}}
<style>
  .stat-card { transition: all .25s ease; }
  .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,.08) !important; }

  .icon-box {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
  }

  .action-card { transition: all .25s ease; cursor: pointer; }
  .action-card:hover { transform: translateY(-3px); box-shadow: 0 10px 24px rgba(0,0,0,.08) !important; }
  .action-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
  }

  .notice-avatar {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }

  .btn-group .btn { border-radius: 8px !important; margin-right: 4px; }
  .btn-group .btn:last-child { margin-right: 0; }
</style>

@endsection