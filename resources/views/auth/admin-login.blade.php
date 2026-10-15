@extends('layouts.app')
@section('title','Admin Login')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center align-items-center g-5" style="min-height:70vh;">
    <div class="col-lg-10">
      <div class="card shadow-lg border-0 overflow-hidden" style="border-radius:24px;">
        <div class="row g-0">

          {{-- LEFT: red branding --}}
          <div class="col-md-5 d-none d-md-flex flex-column justify-content-between p-5 text-white position-relative"
               style="background:linear-gradient(135deg,#dc3545 0%,#b02a37 60%,#8b1e2a 100%);">
            <div>
              <div class="d-flex align-items-center mb-4">
                <i class="bi bi-shield-lock-fill fs-1 me-2 text-warning"></i>
                <div>
                  <div class="fw-bold text-uppercase lh-1" style="font-size:.9rem;">Admin Access</div>
                  <small style="letter-spacing:3px;opacity:.85;">SCS E-LEARNING</small>
                </div>
              </div>

              <h2 class="fw-bold mb-3">Administrator<br>Portal.</h2>
              <p class="opacity-75 mb-4">
                Restricted area. Only authorized staff can post notices,
                manage users and moderate content.
              </p>

              <ul class="list-unstyled small">
                <li class="d-flex align-items-start mb-3">
                  <i class="bi bi-shield-check text-warning me-2 mt-1"></i>
                  <span class="opacity-90">Role-verified access</span>
                </li>
                <li class="d-flex align-items-start mb-3">
                  <i class="bi bi-shield-check text-warning me-2 mt-1"></i>
                  <span class="opacity-90">Full notice management</span>
                </li>
                <li class="d-flex align-items-start">
                  <i class="bi bi-shield-check text-warning me-2 mt-1"></i>
                  <span class="opacity-90">User administration</span>
                </li>
              </ul>
            </div>

            <div class="position-absolute rounded-circle bg-white bg-opacity-10"
                 style="width:220px;height:220px;bottom:-80px;left:-80px;"></div>
          </div>

          {{-- RIGHT: form --}}
          <div class="col-md-7 p-4 p-lg-5 bg-white">
            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 mb-3">
              <i class="bi bi-shield-lock me-1"></i>Admin Login
            </span>
            <h3 class="fw-bold mb-1">Administrator Sign In</h3>
            <p class="text-muted mb-4">This login is restricted to admins only.</p>

            @if(session('error'))
              <div class="alert alert-danger rounded-4 border-0">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
              </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
              @csrf

              <div class="mb-3">
                <label class="form-label fw-semibold small text-uppercase text-muted">Admin Email / Username</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0">
                    <i class="bi bi-person-shield text-danger"></i>
                  </span>
                  <input type="text" name="login" value="{{ old('login') }}"
                         class="form-control border-0 bg-light @error('login') is-invalid @enderror"
                         placeholder="admin@scs.edu" required autofocus>
                </div>
                @error('login')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold small text-uppercase text-muted">Password</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0">
                    <i class="bi bi-lock text-danger"></i>
                  </span>
                  <input type="password" name="password" id="pwAdmin"
                         class="form-control border-0 bg-light @error('password') is-invalid @enderror"
                         placeholder="Password" required>
                  <span class="input-group-text bg-light border-0" role="button"
                        onclick="togglePw('pwAdmin','eyeA')">
                    <i class="bi bi-eye text-muted" id="eyeA"></i>
                  </span>
                </div>
                @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
              </div>

              <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold mb-3">
                <i class="bi bi-box-arrow-in-right me-1"></i>Admin Login
              </button>

              <div class="text-center">
                <a href="{{ route('login') }}" class="small text-muted text-decoration-none">
                  <i class="bi bi-person me-1"></i>Student Login
                </a>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function togglePw(id, eye) {
  const inp = document.getElementById(id);
  const i = document.getElementById(eye);
  if (inp.type === 'password') {
    inp.type = 'text';
    i.classList.replace('bi-eye','bi-eye-slash');
  } else {
    inp.type = 'password';
    i.classList.replace('bi-eye-slash','bi-eye');
  }
}
</script>
@endpush