<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Notice Board Portal')</title>
<link rel="icon" href="{{ asset('favicon.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body{background:#f4f6fb;min-height:100vh;display:flex;flex-direction:column;}
    main{flex:1;}
    .navbar-brand{font-weight:700;letter-spacing:1px;}
    .nav-link.active{border-bottom:2px solid #ffc107;}
    .dropdown-menu{border:none;border-radius:14px;overflow:hidden;}
    .card{border-radius:18px;border:none;}
    .btn{border-radius:50rem;}
    .form-control,.form-select{border-radius:12px;}
    .hover-up{transition:.2s;}
    .hover-up:hover{transform:translateY(-3px);}
    .line-clamp-3{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;}

    /* ═══════════ LAYOUT ANIMATIONS ═══════════ */
    @keyframes navDrop {
        from { opacity: 0; transform: translateY(-12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes alertSlide {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes footerFade {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes dropdownIn {
        from { opacity: 0; transform: translateY(-8px) scale(0.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes brandGlow {
        0%, 100% { text-shadow: 0 0 0 rgba(255, 193, 7, 0); }
        50%      { text-shadow: 0 0 12px rgba(255, 193, 7, 0.35); }
    }

    /* Navbar entrance */
    .navbar { animation: navDrop 0.55s cubic-bezier(0.16, 1, 0.3, 1) both; transition: box-shadow .25s ease; }
    .navbar.scrolled { box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12) !important; }

    /* Brand hover */
    .navbar-brand { transition: transform .25s ease; }
    .navbar-brand:hover { transform: translateY(-1px); }
    .navbar-brand .bi-mortarboard-fill { transition: transform .35s cubic-bezier(0.16, 1, 0.3, 1); display: inline-block; }
    .navbar-brand:hover .bi-mortarboard-fill { transform: rotate(-8deg) scale(1.1); }
    .navbar-brand:hover span { animation: brandGlow 2s ease-in-out infinite; }

    /* Nav links hover */
    .navbar-nav .nav-link {
        position: relative;
        transition: color .2s ease, transform .2s ease;
    }
    .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        width: 0;
        height: 2px;
        background: #ffc107;
        transition: width .25s ease, left .25s ease;
    }
    .navbar-nav .nav-link:hover {
        transform: translateY(-1px);
        color: #ffc107 !important;
    }
    .navbar-nav .nav-link:hover::after { width: 70%; left: 15%; }
    .navbar-nav .nav-link.active::after { display: none; }

    /* Dropdown animation */
    .dropdown-menu {
        animation: dropdownIn 0.22s cubic-bezier(0.16, 1, 0.3, 1) both;
        transform-origin: top right;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12) !important;
    }
    .dropdown-item {
        transition: background-color .18s ease, transform .18s ease, padding-left .18s ease;
    }
    .dropdown-item:hover {
        background-color: #f1f5ff;
        transform: translateX(2px);
        padding-left: 1.4rem;
    }
    .dropdown-item.text-danger:hover {
        background-color: #fef2f2;
    }

    /* Profile pill hover */
    .navbar .dropdown-toggle.rounded-pill {
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .navbar .dropdown-toggle.rounded-pill:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12) !important;
    }

    /* Alerts slide-in */
    .alert { animation: alertSlide 0.4s cubic-bezier(0.16, 1, 0.3, 1) both; }

    /* Buttons */
    .btn { transition: transform .2s ease, box-shadow .2s ease; }
    .btn-warning:hover,
    .btn-primary:hover,
    .btn-success:hover,
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
    }

    /* Admin login button subtle pulse */
    .btn-warning.btn-sm { position: relative; }
    .btn-warning.btn-sm:hover { animation: none; }

    /* Footer */
    footer { animation: footerFade 0.6s ease-out both; animation-play-state: paused; }
    footer.is-visible { animation-play-state: running; }

    /* Scroll reveal utilities for child pages */
    .reveal {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1),
                    transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        transition-delay: calc(var(--reveal-delay, 0ms));
    }
    .reveal.is-visible { opacity: 1; transform: translateY(0); }

    .reveal-row {
        opacity: 0;
        transform: translateX(-12px);
        transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        transition-delay: var(--row-delay, 0s);
    }
    tbody.is-visible .reveal-row { opacity: 1; transform: translateX(0); }

    .no-js .reveal,
    .no-js .reveal-row { opacity: 1; transform: none; }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.001ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.001ms !important;
        }
        .navbar-nav .nav-link:hover,
        .dropdown-item:hover,
        .btn:hover,
        .navbar-brand:hover {
            transform: none !important;
        }
        .reveal, .reveal-row { opacity: 1 !important; transform: none !important; }
    }
</style>
@stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
      <i class="bi bi-mortarboard-fill fs-2 me-2 text-warning"></i>
      <div>
        <span class="d-block lh-1 fw-bold text-uppercase" style="font-size:.95rem;">School Of Computational Science</span>
        <small style="font-size:.8rem;letter-spacing:2px;">E-LEARNING</small>
      </div>
    </a>
    <button class="navbar-toggler border-0" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">

      {{-- ============ CENTER NAV LINKS ============ --}}
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link {{ Request::routeIs('welcome') ? 'active fw-bold text-warning':'' }}" href="{{ route('welcome') }}">
            <i class="bi bi-house-door me-1"></i>Home
          </a>
        </li>

        {{-- Notices link: visible to guests + students, hidden for admins --}}
        @guest
          <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('home') ? 'active fw-bold text-warning':'' }}" href="{{ route('home') }}">
              <i class="bi bi-megaphone me-1"></i>Notices
            </a>
          </li>
        @else
          @if(!Auth::user()->isAdmin())
            <li class="nav-item">
              <a class="nav-link {{ Request::routeIs('home') ? 'active fw-bold text-warning':'' }}" href="{{ route('home') }}">
                <i class="bi bi-megaphone me-1"></i>Notices
              </a>
            </li>
          @endif
        @endguest

        {{-- Admin-only quick links in the center --}}
        @auth
          @if(Auth::user()->isAdmin())
            <li class="nav-item">
              <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active fw-bold text-warning':'' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-1"></i>Admin Panel
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Request::routeIs('admin.notices.create') ? 'active fw-bold text-warning':'' }}" href="{{ route('admin.notices.create') }}">
                <i class="bi bi-plus-circle me-1"></i>Post Notice
              </a>
            </li>
          @endif
        @endauth
      </ul>

      {{-- ============ RIGHT SIDE: AUTH / PROFILE ============ --}}
      <ul class="navbar-nav ms-auto align-items-center">

      @guest
        
        <li class="nav-item">
          <a href="{{ route('admin.login') }}" class="btn btn-warning btn-sm ms-2">
        <i class="bi bi-shield-lock me-1"></i> Admin Login
          </a>
        </li>
      @else
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle bg-white text-primary rounded-pill px-3 shadow-sm" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle me-1"></i>{{ explode(' ', Auth::user()->name)[0] }}
            <span class="badge bg-{{ Auth::user()->isAdmin() ? 'danger':'success' }} ms-1" style="font-size:.6rem;">
              {{ Auth::user()->isAdmin() ? 'ADMIN':'STUDENT' }}
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow mt-2">
            <li><h6 class="dropdown-header">Account Settings</h6></li>

            <li>
              <div class="px-3 py-2 small">
                @if(Auth::user()->hasVerifiedEmail())
                  <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1">
                    <i class="bi bi-patch-check-fill me-1"></i>Email Verified
                  </span>
                @else
                  <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-2 py-1">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>Email Not Verified
                  </span>
                @endif
              </div>
            </li>

            <li><hr class="dropdown-divider"></li>

            @if(Auth::user()->isAdmin())
              {{-- ADMIN menu --}}
              <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</a></li>
              <li><a class="dropdown-item" href="{{ route('admin.notices.create') }}"><i class="bi bi-plus-circle me-2"></i>Post Notice</a></li>
              <li><a class="dropdown-item" href="{{ route('home') }}"><i class="bi bi-megaphone me-2"></i>Preview Notices</a></li>
            @else
              {{-- STUDENT menu --}}
              <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2-fill me-2"></i>My Dashboard</a></li>
              <li><a class="dropdown-item" href="{{ route('home') }}"><i class="bi bi-megaphone me-2"></i>All Notices</a></li>
            @endif

            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="dropdown-item text-danger"><i class="bi bi-power me-2"></i>Logout</button>
              </form>
            </li>
          </ul>
        </li>
      @endguest
      </ul>
    </div>
  </div>
</nav>
<main>
  @auth
    @if(!Auth::user()->hasVerifiedEmail())
      <div class="container mt-3">
        <div class="alert alert-warning alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center justify-content-between flex-wrap gap-2">
          <div>
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Verify your email</strong> — we sent a link to <em>{{ Auth::user()->email }}</em>.
          </div>
          <div>
            <a href="{{ route('verification.notice') }}" class="btn btn-sm btn-warning fw-bold">Verify Now</a>
          </div>
        </div>
      </div>
    @endif
  @endauth

  @if(session('success'))
    <div class="container mt-3">
      <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="container mt-3">
      <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
  @endif

  @yield('content')
</main>

<footer class="border-top py-4 mt-5 bg-white">
  <div class="container text-center text-muted">
    <small>&copy; {{ date('Y') }} School of Computational Science. All Rights Reserved.</small>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  /* ═══════════ Remove no-js (enables reveal) ═══════════ */
  document.documentElement.classList.remove('no-js');

  /* ═══════════ Navbar: shadow on scroll ═══════════ */
  (function () {
    const nav = document.querySelector('.navbar.sticky-top');
    if (!nav) return;

    function updateShadow() {
      if (window.scrollY > 10) nav.classList.add('scrolled');
      else nav.classList.remove('scrolled');
    }

    window.addEventListener('scroll', updateShadow, { passive: true });
    updateShadow();
  })();

  /* ═══════════ Footer: reveal on scroll ═══════════ */
  (function () {
    const footer = document.querySelector('footer');
    if (!footer) return;

    if (!('IntersectionObserver' in window)) {
      footer.classList.add('is-visible');
      return;
    }

    const footerObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          footerObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    footerObserver.observe(footer);
  })();

  /* ═══════════ Global scroll reveal (for any child page) ═══════════ */
  (function () {
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const elements = document.querySelectorAll('.reveal');

    if (prefersReduced || !('IntersectionObserver' in window)) {
      elements.forEach(function (el) { el.classList.add('is-visible'); });
      document.querySelectorAll('tbody').forEach(function (tb) { tb.classList.add('is-visible'); });
      return;
    }

    const revealObserver = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          const delay = entry.target.dataset.delay || 0;
          entry.target.style.setProperty('--reveal-delay', delay + 'ms');
          entry.target.classList.add('is-visible');
          obs.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.12,
      rootMargin: '0px 0px -60px 0px'
    });

    elements.forEach(function (el) { revealObserver.observe(el); });

    /* Table rows: reveal when their tbody enters viewport */
    document.querySelectorAll('.card tbody').forEach(function (tbody) {
      if (!tbody.querySelector('tr')) return;

      const rowObserver = new IntersectionObserver(function (entries, obs) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            obs.unobserve(entry.target);
          }
        });
      }, { threshold: 0.05 });

      rowObserver.observe(tbody);
    });
  })();
</script>

@stack('scripts')
</body>
</html>