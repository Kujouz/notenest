@extends('layouts.app')

@section('content')
<style>
/* Your existing CSS styles */
</style>

<!-- Header -->
<section class="header">
  <h1><i class="fas fa-file-alt me-2"></i>Assignment Details</h1>
  <p>{{ $assignment->note->title }} - {{ $assignment->student->name }}</p>
</section>

<!-- Main Content -->
<div class="container py-5">
  <div class="row">
    <div class="col-md-8">
      <div class="card shadow-sm p-4 mb-4">
        <h4 class="fw-bold text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Assignment Info</h4>

        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label fw-bold">Student</label>
              <p class="form-control">{{ $assignment->student->name }}</p>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Student ID</label>
              <p class="form-control">{{ $assignment->student->id_number }}</p>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Status</label>
              <p class="form-control">
                <span class="badge bg-{{ $assignment->status === 'graded' ? 'success' : 'warning' }}">
                  {{ ucfirst($assignment->status) }}
                </span>
              </p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label fw-bold">Note Title</label>
              <p class="form-control">{{ $assignment->note->title }}</p>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Course Code</label>
              <p class="form-control">{{ $assignment->note->course_code }}</p>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Submitted</label>
              <p class="form-control">{{ $assignment->created_at->format('M d, Y H:i') }}</p>
            </div>
          </div>
        </div>

        @if($assignment->title || $assignment->description)
          <div class="mb-3">
            <label class="form-label fw-bold">Assignment Details</label>
            @if($assignment->title)
              <p><strong>Title:</strong> {{ $assignment->title }}</p>
            @endif
            @if($assignment->description)
              <p><strong>Description:</strong> {{ $assignment->description }}</p>
            @endif
          </div>
        @endif

        <div class="mb-3">
          <label class="form-label fw-bold">File</label>
          <p class="form-control">
            {{ $assignment->file_name }} ({{ $assignment->formatted_file_size }})
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm p-4">
        <h4 class="fw-bold text-primary mb-3"><i class="fas fa-graduation-cap me-2"></i>Grade Assignment</h4>

        <form method="POST" action="{{ route('assignments.grade', $assignment) }}">
          @csrf

          <div class="mb-3">
            <label class="form-label fw-bold">Grade (0-100)</label>
            <input type="number" name="grade" class="form-control"
                   value="{{ old('grade', $assignment->grade) }}" min="0" max="100" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Feedback (Optional)</label>
            <textarea name="feedback" class="form-control" rows="4"
                      placeholder="Provide feedback to the student...">{{ old('feedback', $assignment->feedback) }}</textarea>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save me-2"></i>Save Grade
            </button>
          </div>
        </form>

        <div class="mt-3 pt-3 border-top">
          <a href="{{ route('assignments.download', $assignment) }}" class="btn btn-success w-100">
            <i class="fas fa-download me-2"></i>Download File
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="text-center mt-4">
    <a href="{{ route('assignments.index') }}" class="btn btn-outline-primary">
      <i class="fas fa-arrow-left me-2"></i>Back to Assignments
    </a>
  </div>
</div>

@endsection
