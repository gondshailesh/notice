@extends('layouts.app')
@section('title','Welcome')

@section('content')
<div class="container py-5">
  <div class="row align-items-center g-5">
    <div class="col-lg-6">
      <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">Notice Board Portal</span>
      <h1 class="display-4 fw-bold text-dark mb-3">Welcome to SCS E-Learning Notice Board</h1>
      <p class="lead text-secondary mb-4">
        Stay updated with academic circulars, examination notices, placement updates,
        and everything happening at School of Computational Science — in one place.
      </p>
      <div class="d-flex gap-3 flex-wrap">
        <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2 shadow-sm">
          <i class="bi bi-box-arrow-in-right me-1"></i> Login
        </a>
        <a href="{{ route('register') }}" class="btn btn-outline-primary px-4 py-2">
          <i class="bi bi-person-plus me-1"></i> Register
        </a>
        <a href="{{ route('admin.login') }}" class="btn btn-outline-danger px-4 py-2">
  <i class="bi bi-shield-lock me-1"></i> Admin Login
</a>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2">
          <i class="bi bi-megaphone me-1"></i> View Notices
        </a>
      </div>

      <div class="row mt-5 g-4">
        <div class="col-4">
          <h3 class="fw-bold text-primary mb-0">12+</h3>
          <small class="text-muted">Categories</small>
        </div>
        <div class="col-4">
          <h3 class="fw-bold text-primary mb-0">24/7</h3>
          <small class="text-muted">Updates</small>
        </div>
        <div class="col-4">
          <h3 class="fw-bold text-primary mb-0">100%</h3>
          <small class="text-muted">Free Access</small>
        </div>
      </div>
    </div>

    <div class="col-lg-6 text-center">
      <i class="bi bi-megaphone-fill text-primary" style="font-size:14rem;opacity:.15;"></i>
    </div>
  </div>
</div>
@endsection