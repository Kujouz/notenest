@extends('layouts.app')

@section('content')
<style>
:root {
  --yellow: #feec57;
  --red: #dd3226;
  --blue: #2f307f;
  --soft-bg: #fffef9;
  --card-bg: #fffaf0;
  --primary: var(--blue);
  --secondary: #25256e;
  --accent: var(--red);
  --light: #f8f9fa;
  --dark: #212529;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, var(--soft-bg), #f1f3f8);
  color: var(--dark);
  min-height: 100vh;
}

/* Header */
.header {
  background: linear-gradient(135deg, var(--blue), var(--red));
  color: white;
  text-align: center;
  padding: 70px 20px 60px;
  border-bottom-left-radius: 40px;
  border-bottom-right-radius: 40px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}
.header h1 {
  font-weight: 800;
  font-size: 2.5rem;
}

/* Cards */
.card {
  background: var(--card-bg);
  color: var(--dark);
  border-radius: 15px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* Footer */
footer {
  background: linear-gradient(135deg, var(--blue), var(--red));
  color: white;
  text-align: center;
  padding: 20px;
  font-weight: 600;
  letter-spacing: 0.5px;
  margin-top: 60px;
  border-top: 2px solid rgba(255,255,255,0.2);
}
</style>

<!-- Header -->
<section class="header">
  <h1><i class="fas fa-file-upload me-2"></i>Submit Assignment</h1>
  <p>For: {{ $note->title }}</p>
</section>

<!-- Main Content -->
<div class="container py-5">
  <div class="card shadow-sm p-4">
    <h4 class="fw-bold text-primary mb-3"><i class="fas fa-file-alt me-2"></i>Assignment Details</h4>

    <div class="row mb-4">
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label fw-bold">Note Title</label>
          <p class="form-control">{{ $note->title }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Course Code</label>
          <p class="form-control">{{ $note->course_code }}</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label fw-bold">Category</label>
          <p class="form-control">{{ $note->category }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Uploaded By</label>
          <p class="form-control">{{ $note->teacher->name }}</p>
        </div>
      </div>
    </div>

    <form method="POST" action="{{ route('assignments.store', $note) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Assignment Title (Optional)</label>
            <input type="text" name="title" class="form-control" placeholder="Enter assignment title">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Description (Optional)</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Add any notes about your assignment"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Upload File</label>
            <input type="file" name="file" class="form-control" required>
            <div class="form-text">Supported formats: PDF, DOC/DOCX, PPT/PPTX, ZIP, RAR, TXT (Max 10MB)</div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i>Cancel
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-paper-plane me-2"></i>Submit Assignment
            </button>
        </div>
    </form>
  </div>
</div>

@endsection
