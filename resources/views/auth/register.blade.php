@extends('layouts.app')
@section('title','Register')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center g-5">
    <div class="col-lg-11">
      <div class="card shadow-lg border-0 overflow-hidden" style="border-radius:24px;">
        <div class="row g-0">

          {{-- ============ LEFT: BRANDING ============ --}}
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

              <h2 class="fw-bold mb-3">Join the SCS<br>E-Learning Portal.</h2>
              <p class="opacity-75 mb-4" style="line-height:1.6;">
                Register once and unlock instant access to academic notices,
                exam schedules, placement drives and everything happening on campus.
              </p>

              <ul class="list-unstyled small mb-0">
                <li class="d-flex align-items-start mb-3">
                  <i class="bi bi-shield-check text-warning me-2 mt-1"></i>
                  <span class="opacity-90">Aadhaar-linked verified registration</span>
                </li>
                <li class="d-flex align-items-start mb-3">
                  <i class="bi bi-shield-check text-warning me-2 mt-1"></i>
                  <span class="opacity-90">Strong password protection</span>
                </li>
                <li class="d-flex align-items-start mb-3">
                  <i class="bi bi-shield-check text-warning me-2 mt-1"></i>
                  <span class="opacity-90">Mobile OTP & email verification</span>
                </li>
                <li class="d-flex align-items-start">
                  <i class="bi bi-shield-check text-warning me-2 mt-1"></i>
                  <span class="opacity-90">18+ students only</span>
                </li>
              </ul>
            </div>

            <div class="mt-4">
              <div class="d-flex align-items-center">
                <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center me-3"
                     style="width:44px;height:44px;">
                  <i class="bi bi-patch-check-fill text-warning fs-5"></i>
                </div>
                <div>
                  <div class="fw-semibold small">100% Secure</div>
                  <small class="opacity-75">Encrypted credentials</small>
                </div>
              </div>
            </div>

            <div class="position-absolute rounded-circle bg-white bg-opacity-10"
                 style="width:220px;height:220px;bottom:-80px;left:-80px;"></div>
            <div class="position-absolute rounded-circle bg-warning bg-opacity-25"
                 style="width:120px;height:120px;top:35%;right:-40px;"></div>
          </div>

          {{-- ============ RIGHT: FORM ============ --}}
          <div class="col-md-7 p-4 p-lg-5 bg-white">
            <div class="mb-4">
              <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3">
                <i class="bi bi-person-plus-fill me-1"></i>Student Registration
              </span>
              <h3 class="fw-bold text-dark mb-1">Create your account</h3>
              <p class="text-muted mb-0">Fields marked <span class="text-danger">*</span> are mandatory</p>
            </div>

            <form method="POST" action="{{ route('register') }}" autocomplete="off" id="registerForm">
              @csrf

              {{-- 1. FULL NAME --}}
              <div class="mb-3">
                <label class="form-label fw-semibold small text-uppercase text-muted">
                  Full Name (as per 12th marksheet) <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0">
                    <i class="bi bi-person-vcard text-primary"></i>
                  </span>
                  <input type="text" name="name" value="{{ old('name') }}"
                         class="form-control border-0 bg-light @error('name') is-invalid @enderror"
                         placeholder="e.g. Rahul Kumar Sharma" required>
                </div>
                @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
              </div>

              {{-- 2. EMAIL + 3. PHONE --}}
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold small text-uppercase text-muted">
                    Email (linked with Aadhaar) <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                      <i class="bi bi-envelope-at text-primary"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control border-0 bg-light @error('email') is-invalid @enderror"
                           placeholder="you@example.com" required>
                  </div>
                  <small class="text-muted">A verification link will be sent to this address.</small>
                  @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold small text-uppercase text-muted">
                    Phone Number <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0">+91</span>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           maxlength="10" pattern="[6-9][0-9]{9}" inputmode="numeric"
                           class="form-control border-0 bg-light @error('phone') is-invalid @enderror"
                           placeholder="10 digits, starts 6-9" required>
                  </div>
                  @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
              </div>

              {{-- 4. AADHAAR + 5. DOB --}}
              <div class="row g-3 mt-1">
                <div class="col-md-6">
                  <label class="form-label fw-semibold small text-uppercase text-muted">
                    Aadhaar Number <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                      <i class="bi bi-fingerprint text-primary"></i>
                    </span>
                    <input type="text" name="aadhaar_no" value="{{ old('aadhaar_no') }}"
                           maxlength="12" pattern="[2-9][0-9]{11}" inputmode="numeric"
                           class="form-control border-0 bg-light @error('aadhaar_no') is-invalid @enderror"
                           placeholder="12 digits (cannot start 0/1)" required>
                  </div>
                  @error('aadhaar_no')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold small text-uppercase text-muted">
                    Date of Birth <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                      <i class="bi bi-calendar-event text-primary"></i>
                    </span>
                    <input type="date" name="dob" value="{{ old('dob') }}"
                           max="{{ now()->subYears(18)->format('Y-m-d') }}"
                           class="form-control border-0 bg-light @error('dob') is-invalid @enderror"
                           required>
                  </div>
                  <small class="text-muted">Must be 18 years or older</small>
                  @error('dob')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
              </div>

              {{-- 6. COURSE DROPDOWN --}}
              <div class="mt-3">
                <label class="form-label fw-semibold small text-uppercase text-muted">
                  Select Course <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0">
                    <i class="bi bi-book text-primary"></i>
                  </span>
                  <select name="course" class="form-select border-0 bg-light @error('course') is-invalid @enderror" required>
  <option value="">-- Choose your course --</option>

  <optgroup label="BCA — Bachelor of Computer Applications (3 Years)">
    <option value="BCA - First Year"   @selected(old('course')==='BCA - First Year')>BCA — First Year</option>
    <option value="BCA - Second Year"  @selected(old('course')==='BCA - Second Year')>BCA — Second Year</option>
    <option value="BCA - Third Year"   @selected(old('course')==='BCA - Third Year')>BCA — Third Year</option>
  </optgroup>

  <optgroup label="BSc — Bachelor of Science (3 Years)">
    <option value="BSc CS - First Year"   @selected(old('course')==='BSc CS - First Year')>BSc CS — First Year</option>
    <option value="BSc CS - Second Year"  @selected(old('course')==='BSc CS - Second Year')>BSc CS — Second Year</option>
    <option value="BSc CS - Third Year"   @selected(old('course')==='BSc CS - Third Year')>BSc CS — Third Year</option>

    <option value="BSc IT - First Year"   @selected(old('course')==='BSc IT - First Year')>BSc IT — First Year</option>
    <option value="BSc IT - Second Year"  @selected(old('course')==='BSc IT - Second Year')>BSc IT — Second Year</option>
    <option value="BSc IT - Third Year"   @selected(old('course')==='BSc IT - Third Year')>BSc IT — Third Year</option>

    <option value="BSc Computer Application - First Year"   @selected(old('course')==='BSc Computer Application - First Year')>BSc Computer Application — First Year</option>
    <option value="BSc Computer Application - Second Year"  @selected(old('course')==='BSc Computer Application - Second Year')>BSc Computer Application — Second Year</option>
    <option value="BSc Computer Application - Third Year"   @selected(old('course')==='BSc Computer Application - Third Year')>BSc Computer Application — Third Year</option>
  </optgroup>

  <optgroup label="MCA — Master of Computer Applications (2 Years)">
    <option value="MCA - First Year"   @selected(old('course')==='MCA - First Year')>MCA — First Year</option>
    <option value="MCA - Second Year"  @selected(old('course')==='MCA - Second Year')>MCA — Second Year</option>
  </optgroup>

  <optgroup label="MSc — Master of Science (2 Years)">
    <option value="MSc CS - First Year"   @selected(old('course')==='MSc CS - First Year')>MSc CS — First Year</option>
    <option value="MSc CS - Second Year"  @selected(old('course')==='MSc CS - Second Year')>MSc CS — Second Year</option>

    <option value="MSc IT - First Year"   @selected(old('course')==='MSc IT - First Year')>MSc IT — First Year</option>
    <option value="MSc IT - Second Year"  @selected(old('course')==='MSc IT - Second Year')>MSc IT — Second Year</option>

    <option value="MSc Data Science - First Year"   @selected(old('course')==='MSc Data Science - First Year')>MSc Data Science — First Year</option>
    <option value="MSc Data Science - Second Year"  @selected(old('course')==='MSc Data Science - Second Year')>MSc Data Science — Second Year</option>
  </optgroup>

  <optgroup label="Post Graduate Diploma (1 Year)">
    <option value="PG Diploma" @selected(old('course')==='PG Diploma')>PG Diploma</option>
  </optgroup>

  <optgroup label="Other">
    <option value="Other" @selected(old('course')==='Other')>Other</option>
  </optgroup>
</select>
                </div>
                @error('course')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
              </div>

              {{-- 7. COLLEGE INTERNET ID --}}
              <div class="mt-3">
                <label class="form-label fw-semibold small text-uppercase text-muted">
                  College Internet ID
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0">
                    <i class="bi bi-wifi text-primary"></i>
                  </span>
                  <input type="text" name="college_internet_id" value="{{ old('college_internet_id') }}"
                         class="form-control border-0 bg-light"
                         placeholder="e.g. student.scs.edu (optional)">
                </div>
              </div>

              {{-- 8. USERNAME --}}
              <div class="mt-3">
                <label class="form-label fw-semibold small text-uppercase text-muted">
                  Username <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0">
                    <i class="bi bi-at text-primary"></i>
                  </span>
                  <input type="text" name="username" id="usernameInput" value="{{ old('username') }}"
                         minlength="4" maxlength="20"
                         class="form-control border-0 bg-light @error('username') is-invalid @enderror"
                         placeholder="4–20 chars, starts with a letter" required>
                </div>
                <small class="text-muted" id="usernameHint">
                  Letters, numbers, dots (.) and underscores (_) allowed. Must start with a letter.
                </small>
                @error('username')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
              </div>

              {{-- 9. PASSWORD + CONFIRM --}}
              <div class="row g-3 mt-1">
                <div class="col-md-6">
                  <label class="form-label fw-semibold small text-uppercase text-muted">
                    Password <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                      <i class="bi bi-lock text-primary"></i>
                    </span>
                    <input type="password" name="password" id="passwordInput"
                           minlength="8" maxlength="16"
                           class="form-control border-0 bg-light @error('password') is-invalid @enderror"
                           placeholder="8–16 chars" required>
                    <span class="input-group-text bg-light border-0" role="button"
                          onclick="togglePassword('passwordInput','eyeIcon1')">
                      <i class="bi bi-eye text-muted" id="eyeIcon1"></i>
                    </span>
                  </div>
                  @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold small text-uppercase text-muted">
                    Confirm Password <span class="text-danger">*</span>
                  </label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                      <i class="bi bi-lock-fill text-primary"></i>
                    </span>
                    <input type="password" name="password_confirmation" id="confirmInput"
                           class="form-control border-0 bg-light"
                           placeholder="Re-enter password" required>
                    <span class="input-group-text bg-light border-0" role="button"
                          onclick="togglePassword('confirmInput','eyeIcon2')">
                      <i class="bi bi-eye text-muted" id="eyeIcon2"></i>
                    </span>
                  </div>
                </div>
              </div>

              {{-- Password strength meter --}}
              <div class="mt-2">
                <div class="progress" style="height:6px;border-radius:6px;">
                  <div id="pwBar" class="progress-bar" role="progressbar" style="width:0%"></div>
                </div>
                <small id="pwText" class="text-muted d-block mt-1">
                  Must contain: uppercase · lowercase · number · special character
                </small>
              </div>

              {{-- Terms --}}
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" id="agree" required>
                <label class="form-check-label small text-muted" for="agree">
                  I confirm the information is accurate, my email is linked with my Aadhaar,
                  and I agree to the <a href="#" class="text-primary text-decoration-none">Terms & Conditions</a>.
                </label>
              </div>

              <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm mt-4 mb-3">
                <i class="bi bi-person-check-fill me-2"></i>Create Account
              </button>

              <div class="text-center">
                <span class="text-muted small">Already have an account?</span>
                <a href="{{ route('login') }}" class="small text-primary fw-semibold text-decoration-none ms-1">
                  Login here
                </a>
              </div>

              <div class="text-center mt-3">
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
/* ---------- Show / hide password ---------- */
function togglePassword(inputId, iconId) {
  const input = document.getElementById(inputId);
  const icon  = document.getElementById(iconId);
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.replace('bi-eye','bi-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.replace('bi-eye-slash','bi-eye');
  }
}

/* ---------- Numeric only: phone + aadhaar ---------- */
document.querySelector('input[name="phone"]').addEventListener('input', function () {
  this.value = this.value.replace(/\D/g,'').slice(0,10);
});
document.querySelector('input[name="aadhaar_no"]').addEventListener('input', function () {
  this.value = this.value.replace(/\D/g,'').slice(0,12);
});

/* ---------- Username live validation ---------- */
const usernameInput = document.getElementById('usernameInput');
const usernameHint  = document.getElementById('usernameHint');
usernameInput.addEventListener('input', function () {
  const v = this.value;
  const ok = /^[a-zA-Z][a-zA-Z0-9._]{3,19}$/.test(v);
  if (!v) {
    usernameHint.className = 'text-muted';
    usernameHint.textContent = 'Letters, numbers, dots (.) and underscores (_) allowed. Must start with a letter.';
  } else if (ok) {
    usernameHint.className = 'text-success small';
    usernameHint.textContent = '✓ Valid username';
  } else {
    usernameHint.className = 'text-danger small';
    usernameHint.textContent = '✗ Start with a letter; 4–20 characters; letters, digits, . and _ only.';
  }
});

/* ---------- Password strength meter ---------- */
const pwInput = document.getElementById('passwordInput');
const pwBar   = document.getElementById('pwBar');
const pwText  = document.getElementById('pwText');

pwInput.addEventListener('input', function () {
  const v = this.value;
  let score = 0;
  if (v.length >= 8 && v.length <= 16)     score++;
  if (/[a-z]/.test(v))                     score++;
  if (/[A-Z]/.test(v))                     score++;
  if (/\d/.test(v))                        score++;
  if (/[\W_]/.test(v))                     score++;

  const pct = (score/5)*100;
  pwBar.style.width = pct + '%';

  if (v.length === 0) {
    pwBar.className = 'progress-bar';
    pwText.className = 'text-muted d-block mt-1';
    pwText.textContent = 'Must contain: uppercase · lowercase · number · special character';
  } else if (v.length < 8) {
    pwBar.className = 'progress-bar bg-danger';
    pwText.className = 'text-danger small d-block mt-1';
    pwText.textContent = 'Too short — minimum 8 characters';
  } else if (v.length > 16) {
    pwBar.className = 'progress-bar bg-danger';
    pwText.className = 'text-danger small d-block mt-1';
    pwText.textContent = 'Too long — maximum 16 characters';
  } else if (score <= 2) {
    pwBar.className = 'progress-bar bg-danger';
    pwText.className = 'text-danger small d-block mt-1';
    pwText.textContent = 'Weak password';
  } else if (score === 3 || score === 4) {
    pwBar.className = 'progress-bar bg-warning';
    pwText.className = 'text-warning small d-block mt-1';
    pwText.textContent = 'Medium — add more variety';
  } else {
    pwBar.className = 'progress-bar bg-success';
    pwText.className = 'text-success small d-block mt-1';
    pwText.textContent = '✓ Strong password';
  }
});

/* ---------- DOB age check ---------- */
document.querySelector('input[name="dob"]').addEventListener('change', function () {
  const dob = new Date(this.value);
  const today = new Date();
  let age = today.getFullYear() - dob.getFullYear();
  const m = today.getMonth() - dob.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
  if (age < 18) {
    alert('You must be at least 18 years old to register.');
    this.value = '';
  }
});
</script>
@endpush