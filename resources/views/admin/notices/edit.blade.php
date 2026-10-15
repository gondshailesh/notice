@extends('layouts.app')
@section('title','Edit Notice')

@section('content')
<div class="container py-4">

  <div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary me-3">
      <i class="bi bi-arrow-left"></i>
    </a>
    <div>
      <h4 class="fw-bold mb-0">Edit Notice</h4>
      <small class="text-muted">Update the details below</small>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-lg-5">

          <form method="POST" action="{{ route('admin.notices.update', $notice) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
              <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
              <input type="text" name="title" value="{{ old('title', $notice->title) }}"
                     class="form-control form-control-lg @error('title') is-invalid @enderror" required>
              @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
              <textarea name="description" rows="7"
                        class="form-control @error('description') is-invalid @enderror"
                        required>{{ old('description', $notice->description) }}</textarea>
              @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category" class="form-select" required>
                  @foreach(\App\Models\Notice::CATEGORIES as $k => $v)
                    <option value="{{ $k }}" @selected(old('category', $notice->category) === $k)>{{ $v }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Target Semester</label>
                <input type="text" name="target_semester"
                       value="{{ old('target_semester', $notice->target_semester) }}"
                       class="form-control">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Priority</label>
                <select name="priority" class="form-select">
                  <option value="Normal" @selected(old('priority', $notice->priority) === 'Normal')>Normal</option>
                  <option value="Urgent" @selected(old('priority', $notice->priority) === 'Urgent')>Urgent</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Replace Attachment</label>
                <input type="file" name="attachment" class="form-control"
                       accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                @if($notice->attachment_path)
                  <small class="text-muted d-block mt-1">
                    Current:
                    <a href="{{ route('notices.download', $notice->id) }}">download existing</a>
                  </small>
                @endif
              </div>
            </div>

            <div class="d-flex gap-2 mt-4">
              <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                <i class="bi bi-save me-1"></i>Update Notice
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