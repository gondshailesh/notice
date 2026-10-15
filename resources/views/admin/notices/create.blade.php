@extends('layouts.app')
@section('title','Post Notice')

@section('content')
<div class="container py-4">

  <div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary me-3">
      <i class="bi bi-arrow-left"></i>
    </a>
    <div>
      <h4 class="fw-bold mb-0">Post a New Notice</h4>
      <small class="text-muted">Fill in the details and publish</small>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-lg-5">

          <form method="POST" action="{{ route('admin.notices.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
              <label class="form-label fw-semibold">Notice Title <span class="text-danger">*</span></label>
              <input type="text" name="title" value="{{ old('title') }}"
                     class="form-control form-control-lg @error('title') is-invalid @enderror"
                     placeholder="e.g. End Semester Exam Schedule Released" required>
              @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
              <textarea name="description" rows="7"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Full notice content..." required>{{ old('description') }}</textarea>
              @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                  <option value="">-- Select Category --</option>
                  @foreach(\App\Models\Notice::CATEGORIES as $k => $v)
                    <option value="{{ $k }}" @selected(old('category') === $k)>{{ $v }}</option>
                  @endforeach
                </select>
                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Target Semester</label>
                <select name="target_semester" class="form-select">
                  <option value="all" @selected(old('target_semester') === 'all')>All Semesters</option>
                  <option value="First Year"  @selected(old('target_semester') === 'First Year')>First Year</option>
                  <option value="Second Year" @selected(old('target_semester') === 'Second Year')>Second Year</option>
                  <option value="Third Year"  @selected(old('target_semester') === 'Third Year')>Third Year</option>
                  <option value="Final Year"  @selected(old('target_semester') === 'Final Year')>Final Year</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Priority</label>
                <div class="d-flex gap-3 mt-1">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="priority" id="prNormal" value="Normal"
                           @checked(old('priority', 'Normal') === 'Normal')>
                    <label class="form-check-label" for="prNormal">
                      <span class="badge bg-secondary">Normal</span>
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="priority" id="prUrgent" value="Urgent"
                           @checked(old('priority') === 'Urgent')>
                    <label class="form-check-label" for="prUrgent">
                      <span class="badge bg-danger">Urgent</span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Attachment (optional)</label>
                <input type="file" name="attachment"
                       class="form-control @error('attachment') is-invalid @enderror"
                       accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                <small class="text-muted">PDF, JPG, PNG, DOC · Max 5 MB</small>
                @error('attachment')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="d-flex gap-2 mt-4">
              <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                <i class="bi bi-send me-1"></i>Publish Notice
              </button>
              <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-4 py-2">
                Cancel
              </a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection