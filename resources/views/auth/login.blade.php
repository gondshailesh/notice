@extends('layouts.app')
@section('title','Login')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center align-items-center g-5" style="min-height:70vh;">
    <div class="col-lg-10">
      <div class="card shadow-lg border-0 overflow-hidden" style="border-radius:24px;">
        <div class="row g-0">

          {{-- ============ LEFT: BRANDING PANEL ============ --}}
          <div class="col-md-5 d-none d-md-flex flex-column justify-content-between p-5 text-white position-relative"
               style="background:linear-gradient(135deg,#0d6efd 0%,#0a58ca 60%,#084298 100%);">
            <div>
              <div class="d-flex align-items-center mb-4">
                <i class="bi bi-mortarboard-fill fs-1 me-2 text-warning"></i>
                <div>
                  <div class="fw-bold text-uppercase lh-1" style="font-size:.9rem;letter-spacing:1px;">
                    School of Computational Science
                  </div>
                  <small style="font-size:.75rem;letter-spacing:3px;opacity:.85;">E-LEARNING</small>
                </div>
              </div>

              <h2 class="fw-bold mb-3">Welcome Back,<br>Scholar.</h2>
              <p class="opacity-75 mb-0" style="line-height:1.6;">
                Access circulars, exam schedules, placement updates, and everything
                you need — in one place.
              </p>
            </div>

            <div>
              <div class="d-flex align-items-center mb-3">
                <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center me-3"
                     style="width:44px;height:44px;">
                  <i class="bi bi-shield-check text-warning fs-5"></i>
                </div>
                <div>
                  <div class="fw-semibold small">Secure Login</div>
                  <small class="opacity-75">Your data is protected</small>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center me-3"
                     style="width:44px;height:44px;">
                  <i class="bi bi-lightning-charge-fill text-warning fs-5"></i>
                </div>
                <div>
                  <div class="fw-semibold small">Real-Time Notices</div>
                  <small class="opacity-75">Updates the moment they're posted</small>
                </div>
              </div>
            </div>

            {{-- Decorative circles --}}
            <div class="position-absolute rounded-circle bg-white bg-opacity-10"
                 style="width:220px;height:220px;bottom:-80px;right:-80px;"></div>
            <div class="position-absolute rounded-circle bg-warning bg-opacity-25"
                 style="width:120px;height:120px;top:40%;right:-40px;"></div>
          </div>

          {{-- ============ RIGHT: LOGIN FORM ============ --}}
          <div class="col-md-7 p-4 p-lg-5 bg-white">
            <div class="mb-4">
              <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3">
                <i class="bi bi-person-badge me-1"></i>Student / Admin Login
              </span>
              <h3 class="fw-bold text-dark mb-1">Sign in to your account</h3>
              <p class="text-muted mb-0">Enter your credentials to continue</p>
            </div>

            @if(session('status'))
              <div class="alert alert-success rounded-4 border-0">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
              </div>
            @endif

            <form method="POST" action="{{ route('login') }}" autocomplete="off">
              @csrf

              <div class="mb-3">
                <label class="form-label fw-semibold small text-uppercase text-muted">Username or Email</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0">
                    <i class="bi bi-person text-primary"></i>
                  </span>
                  <input type="text" name="login" value="{{ old('login') }}"
                         class="form-control form-control-lg border-0 bg-light @error('login') is-invalid @enderror"
                         placeholder="you@example.com or username"
                         required autofocus>
                  @error('login')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold small text-uppercase text-muted">Password</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0">
                    <i class="bi bi-lock text-primary"></i>
                  </span>
                  <input type="password" name="password" id="passwordInput"
                         class="form-control form-control-lg border-0 bg-light @error('password') is-invalid @enderror"
                         placeholder="Enter your password" required>
                  <span class="input-group-text bg-light border-0" role="button"
                        onclick="togglePassword()">
                    <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                  </span>
                  @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember">
                  <label class="form-check-label small text-muted" for="remember">Remember me</label>
                </div>
                <a href="{{ route('password.request') }}" class="small text-primary fw-semibold text-decoration-none">
                  Forgot password?
                </a>
              </div>

              <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login
              </button>

              <div class="text-center text-muted small mb-3">— or —</div>

              <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg w-100 fw-semibold mb-4">
                <i class="bi bi-person-plus me-2"></i>Create New Account
              </a>

              <div class="text-center">
                <a href="{{ route('welcome') }}" class="small text-muted text-decoration-none">
                  <i class="bi bi-arrow-left me-1"></i>Back to Home
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
  function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('bi-eye','bi-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.replace('bi-eye-slash','bi-eye');
    }
  }
</script>
@endpush