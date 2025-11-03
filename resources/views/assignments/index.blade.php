@extends('layouts.app')

@section('content')
<style>
/* Your existing CSS styles */
</style>

<!-- Header -->
<section class="header">
  <h1><i class="fas fa-tasks me-2"></i>Student Assignments</h1>
  <p>Grade assignments submitted by your students</p>
</section>

<!-- Main Content -->
<div class="container py-5">
  @if($assignments->count() > 0)
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="table-light">
          <tr>
            <th>Student</th>
            <th>Note Title</th>
            <th>Folder</th>
            <th>Status</th>
            <th>Grade</th>
            <th>Submitted</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($assignments as $assignment)
          <tr>
            <td>
              <strong>{{ $assignment->student->name }}</strong><br>
              <small>{{ $assignment->student->id_number }}</small>
            </td>
            <td>{{ $assignment->note->title }}</td>
            <td>{{ $assignment->note->folder->name ?? 'No Folder' }}</td>
            <td>
              <span class="badge bg-{{ $assignment->status === 'graded' ? 'success' : 'warning' }}">
                {{ ucfirst($assignment->status) }}
              </span>
            </td>
            <td>
              @if($assignment->grade !== null)
                <span class="badge bg-info">{{ $assignment->grade }}/100</span>
              @else
                <span class="text-muted">Not graded</span>
              @endif
            </td>
            <td>{{ $assignment->created_at->format('M d, Y') }}</td>
            <td>
              <a href="{{ route('assignments.show', $assignment) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-eye"></i> View
              </a>
              <a href="{{ route('assignments.download', $assignment) }}" class="btn btn-sm btn-outline-success">
                <i class="fas fa-download"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
      {{ $assignments->links() }}
    </div>
  @else
    <div class="text-center py-5">
      <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
      <h4 class="text-muted">No assignments submitted yet</h4>
      <p class="text-muted">Students will appear here once they submit assignments.</p>
    </div>
  @endif
</div>

@endsection
