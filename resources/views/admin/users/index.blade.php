@extends('layouts.app')
@section('title','Manage Users')

@section('content')
<div class="container-fluid px-lg-5 py-4">

  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
      <h4 class="fw-bold mb-0">
        <i class="bi bi-people-fill me-2 text-primary"></i>Manage Users
      </h4>
      <small class="text-muted">View, promote, or remove portal users</small>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
    </a>
  </div>

  {{-- Stats --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="text-muted small text-uppercase fw-semibold">Total Users</div>
          <h3 class="fw-bold mb-0 text-primary">{{ $stats['total'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="text-muted small text-uppercase fw-semibold">Admins</div>
          <h3 class="fw-bold mb-0 text-danger">{{ $stats['admins'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="text-muted small text-uppercase fw-semibold">Students</div>
          <h3 class="fw-bold mb-0 text-success">{{ $stats['students'] }}</h3>
        </div>
      </div>
    </div>
  </div>

  {{-- Filters --}}
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
      <form method="GET" class="row g-2 align-items-center">
        <div class="col-md-6">
          <input type="text" name="q" value="{{ request('q') }}"
                 class="form-control" placeholder="Search by name, email, username, phone...">
        </div>
        <div class="col-md-3">
          <select name="role" class="form-select">
            <option value="">All Roles</option>
            <option value="1" @selected(request('role') === '1')>Admin only</option>
            <option value="0" @selected(request('role') === '0')>Students only</option>
          </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
          <button class="btn btn-primary flex-fill">Filter</button>
          <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>
  </div>

  {{-- Users table --}}
  <div class="card border-0 shadow-sm">
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
            <tr>
              <td class="ps-4">
                <div class="d-flex align-items-center">
                  <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                       style="width:40px;height:40px;font-weight:600;">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                  </div>
                  <div>
                    <div class="fw-semibold text-dark">{{ $u->name }}</div>
                    <small class="text-muted">@{{ $u->username }}</small>
                  </div>
                </div>
              </td>

              <td>
                <div class="small text-dark">{{ $u->email }}</div>
                <small class="text-muted">+91 {{ $u->phone }}</small>
              </td>

              <td>
                <span class="badge bg-light text-dark border">{{ $u->course }}</span>
              </td>

              <td>
                @if($u->role === 1)
                  <span class="badge bg-danger rounded-pill px-3">
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
                <div class="btn-group">
                  <form action="{{ route('admin.users.toggleRole', $u) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Change this user role?')">
                    @csrf @method('PATCH')
                    <button class="btn btn-sm btn-outline-{{ $u->role === 1 ? 'secondary' : 'primary' }}"
                            title="{{ $u->role === 1 ? 'Demote to Student' : 'Promote to Admin' }}"
                            {{ $u->id === auth()->id() ? 'disabled' : '' }}>
                      <i class="bi bi-arrow-repeat"></i>
                    </button>
                  </form>

                  <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Delete this user permanently?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger"
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
                <i class="bi bi-inbox display-4 d-block mb-2 opacity-25"></i>
                No users found.
              </td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="mt-3">{{ $users->links() }}</div>

</div>
@endsection
