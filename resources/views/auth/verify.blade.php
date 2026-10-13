@extends('layouts.app')
@section('title','Verify Your Email')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg border-0" style="border-radius:24px;">
        <div class="card-body p-5 text-center">

          <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-4"
               style="width:80px;height:80px;">
            <i class="bi bi-envelope-check-fill fs-1"></i>
          </div>

          <h3 class="fw-bold mb-2">Verify Your Email</h3>
          <p class="text-muted mb-4">
            We've sent a verification link to
            <strong class="text-dark">{{ Auth::user()->email ?? 'your email' }}</strong>.
            Click that link to activate your account.
          </p>

          @if(session('resent'))
            <div class="alert alert-success rounded-4 border-0">
              <i class="bi bi-check-circle-fill me-2"></i>
              A fresh verification link has been sent to your email.
            </div>
          @endif

          @if(session('verified'))
            <div class="alert alert-success rounded-4 border-0">
              <i class="bi bi-patch-check-fill me-2"></i>
              Your email is verified. Redirecting...
            </div>
          @endif

          <div class="d-flex gap-2 justify-content-center flex-wrap">
            <form method="POST" action="{{ route('verification.resend') }}" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                <i class="bi bi-arrow-clockwise me-1"></i>Resend Verification Email
              </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-outline-secondary px-4 py-2">
                <i class="bi bi-power me-1"></i>Logout
              </button>
            </form>
          </div>

          <hr class="my-4 opacity-25">

          <p class="text-muted small mb-0">
            <i class="bi bi-info-circle me-1"></i>
            Didn't receive the email? Check your spam folder, or click resend above.
          </p>

          <div class="mt-4">
            <a href="{{ route('welcome') }}" class="small text-muted text-decoration-none">
              <i class="bi bi-arrow-left me-1"></i>Back to Home
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection