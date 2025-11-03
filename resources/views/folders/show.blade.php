@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>{{ $folder->name }} ({{ $folder->code }})</h4>
    <p class="text-muted">by {{ $folder->teacher->name }}</p>

    @can('update', $folder)
        <a href="{{ route('notes.create', ['folder' => $folder->id]) }}" class="btn btn-primary btn-sm mb-3">
            <i class="fas fa-file-upload"></i> Upload Note here
        </a>
    @endcan

    <div class="row g-3">
        @forelse($folder->notes as $note)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">{{ $note->title }}</h6>
                        <small class="text-muted">{{ $note->course_code }} • {{ $note->category }}</small><br>
                        <small>Uploaded {{ $note->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('notes.download', $note) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-download"></i> Download
                        </a>
                        <a href="{{ route('notes.show', $note) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No notes inside this folder yet.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">← Back to folders</a>
    </div>
</div>
@endsection
