@extends('layouts.admin')

@section('content')
<style>
  :root {
    --blue: #2f307f;
    --red: #dd3226;
    --yellow: #feec57;
  }

  body {
    background: #f5f6ff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .navbar {
    background: linear-gradient(135deg, var(--red), var(--blue));
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  .navbar-brand {
    font-weight: 700;
    color: white !important;
    display: flex;
    align-items: center;
  }
  .navbar-brand img {
    height: 45px;
    margin-right: 10px;
  }
  .nav-link {
    color: rgba(255,255,255,0.9) !important;
    font-weight: 500;
    transition: 0.3s;
    border-radius: 6px;
    padding: 8px 14px !important;
  }
  .nav-link:hover, .nav-link.active {
    color: white !important;
    background: rgba(255,255,255,0.2);
  }

  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid var(--blue);
    padding-bottom: 10px;
    margin-bottom: 25px;
    flex-wrap: wrap;
    gap: 10px;
  }

  .page-header h2 {
    color: var(--blue);
    font-weight: 700;
  }

  .note-card {
    background: white;
    border-radius: 14px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.06);
    padding: 20px;
    margin-bottom: 18px;
    border-left: 5px solid var(--blue);
    transition: all 0.3s ease;
  }

  .note-card:hover {
    transform: translateY(-4px);
  }

  footer {
    background: linear-gradient(90deg, var(--red), var(--blue));
    color: white;
    text-align: center;
    padding: 12px;
    margin-top: 40px;
    font-weight: 500;
  }
</style>

<div class="container my-4">
  <div class="page-header">
    <h2><i class="fas fa-file-alt me-2"></i>Manage Notes</h2>
    <div class="d-flex gap-2">
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadNoteModal">
        <i class="fas fa-upload"></i> Upload Note
      </button>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($notes->isEmpty())
    <div class="text-center text-muted mt-5">
      <i class="fas fa-folder-open fa-3x mb-3"></i>
      <p>No notes found. Try uploading a new one.</p>
    </div>
  @else
    <div class="row">
      @foreach($notes as $note)
        <div class="col-md-4">
          <div class="note-card">
            <h5>{{ $note->title }}</h5>
            <small><b>Folder:</b> {{ $note->folder->name ?? 'No Folder' }}</small><br>
            <small><b>Uploaded by:</b> {{ $note->user->name ?? 'Unknown' }}</small>
            <p class="mt-2">{{ $note->description }}</p>
            <a href="{{ asset('storage/'.$note->file_path) }}" class="btn btn-sm btn-primary" download>
              <i class="fas fa-download"></i> Download
            </a>
            <form action="{{ route('admin.notes.delete', $note->id) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">
                <i class="fas fa-trash"></i> Delete
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>

<!-- Upload Note Modal -->
<div class="modal fade" id="uploadNoteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="fas fa-upload me-2"></i>Upload Note</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.notes.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label">Note Title</label>
            <input type="text" class="form-control" name="title" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Course Code</label>
            <input type="text" name="course_code" class="form-control" placeholder="e.g. CSC101" required>
        </div>

          <div class="mb-3">
            <label class="form-label">Folder</label>
            <select name="folder_id" class="form-select" required>
              <option value="">Select Folder</option>
              @foreach($folders as $folder)
                <option value="{{ $folder->id }}">{{ $folder->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Upload File</label>
            <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Upload Note</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
