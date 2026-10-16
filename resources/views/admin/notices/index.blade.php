@extends('layouts.app')
@section('title', 'Manage Notices')

@section('content')

<div class="container-fluid px-lg-5 py-4">

  {{-- HEADER --}}
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
      <h3 class="fw-bold mb-1">
        <i class="bi bi-list-ul me-2 text-primary"></i>
        @if(request('priority') === 'Urgent')
          Urgent Notices
        @elseif(request('category'))
          {{ $categoryMap[request('category')] ?? ucfirst(request('category')) }}
        @else
          All Notices
        @endif
      </h3>
      <p class="text-muted small mb-0">{{ $notices->total() }} total notices</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
      </a>
      <a href="{{ route('admin.notices.create') }}" class="btn btn-primary rounded-pill px-4 fw-semibold">
        <i class="bi bi-plus-circle me-1"></i>Post Notice
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm">
      <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
      <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- FILTERS --}}
  <div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
      <form method="GET" action="{{ route('admin.notices.index') }}" class="row g-3 align-items-end">

        <div class="col-md-4">
          <label class="form-label small fw-semibold text-muted">Search</label>
          <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Title or content...">
          </div>
        </div>

        <div class="col-md-3">
          <label class="form-label small fw-semibold text-muted">Category</label>
          <select name="category" class="form-select">
            <option value="all">All Categories</option>
            @foreach($categoryMap as $key => $label)
              <option value="{{ $key }}" @selected(request('category') === $key)>{{ $label }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted">Priority</label>
          <select name="priority" class="form-select">
            <option value="all">All</option>
            <option value="Normal" @selected(request('priority') === 'Normal')>Normal</option>
            <option value="High"   @selected(request('priority') === 'High')>High</option>
            <option value="Urgent" @selected(request('priority') === 'Urgent')>Urgent</option>
          </select>
        </div>

        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted">Per Page</label>
          <select name="per_page" class="form-select">
            @foreach([10,25,50,100] as $n)
              <option value="{{ $n }}" @selected((int) session('admin_per_page', 10) === $n)>{{ $n }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-1 d-flex gap-2">
          <button class="btn btn-primary flex-fill"><i class="bi bi-funnel"></i></button>
          <a href="{{ route('admin.notices.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-clockwise"></i>
          </a>
        </div>
      </form>
    </div>
  </div>

  {{-- TABLE --}}
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
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
                <div class="me-3 d-flex align-items-center justify-content-center rounded-3
                            bg-{{ $n->priority === 'Urgent' ? 'danger' : 'primary' }}-subtle
                            text-{{ $n->priority === 'Urgent' ? 'danger' : 'primary' }}"
                     style="width:42px;height:42px;flex-shrink:0;">
                  <i class="bi bi-file-earmark-text"></i>
                </div>
                <div>
                  <div class="fw-semibold text-dark">{{ Str::limit($n->title, 60) }}</div>
                  <small class="text-muted">{{ Str::limit(strip_tags($n->description), 70) }}</small>
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
                {{ $categoryMap[$n->category] ?? $n->category }}
              </span>
            </td>

            <td>
              @if($n->priority === 'Urgent')
                <span class="badge bg-danger rounded-pill px-3">
                  <i class="bi bi-exclamation-circle me-1"></i>Urgent
                </span>
              @elseif($n->priority === 'High')
                <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3">High</span>
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
                     class="btn btn-sm btn-outline-primary" title="Download">
                    <i class="bi bi-download"></i>
                  </a>
                @endif
                <a href="{{ route('admin.notices.edit', $n) }}"
                   class="btn btn-sm btn-outline-secondary" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('admin.notices.destroy', $n) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Delete this notice?')">
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
              <i class="bi bi-inbox display-4 text-muted opacity-25"></i>
              <p class="text-muted mt-3 mb-0">No notices match your filters.</p>
              <a href="{{ route('admin.notices.index') }}" class="btn btn-link">Clear filters</a>
            </td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    @if($notices->hasPages())
      <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <small class="text-muted">
          Showing <b>{{ $notices->firstItem() }}</b> to <b>{{ $notices->lastItem() }}</b>
          of <b>{{ $notices->total() }}</b> notices
        </small>
        {{ $notices->links() }}
      </div>
    @endif
  </div>

</div>

@endsection