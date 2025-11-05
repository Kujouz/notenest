@extends('layouts.admin')

@section('content')
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-folder me-2"></i> Manage Folders</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFolderModal">
      <i class="fas fa-folder-plus me-2"></i> Create New Folder
    </button>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="row">
    @forelse($folders as $folder)
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title text-primary">
              <i class="fas fa-folder me-2"></i>{{ $folder->name }}
            </h5>
            <p class="text-muted mb-2">{{ $folder->notes->count() }} notes</p>
            <form action="{{ route('admin.folders.destroy', $folder->id) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="text-center py-5">
        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
        <p class="text-muted">No folders created yet.</p>
      </div>
    @endforelse
  </div>
</div>

<!-- Create Folder Modal -->
<div class="modal fade" id="addFolderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.folders.store') }}">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"><i class="fas fa-folder-plus me-2"></i>Create New Folder</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="folderName" class="form-label">Folder Name</label>
            <input type="text" class="form-control" id="folderName" name="name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
