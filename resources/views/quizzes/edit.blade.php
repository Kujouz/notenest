@extends('layouts.app')

@section('content')
<style>
/* Your existing CSS styles */
</style>

<!-- Header -->
<section class="header">
  <h1><i class="fas fa-edit me-2"></i>Edit Quiz</h1>
  <p>Update your quiz details</p>
</section>

<!-- Main Content -->
<div class="container py-5">
  <div class="card shadow-sm p-4">
    <h4 class="fw-bold text-primary mb-3"><i class="fas fa-edit me-2"></i>{{ $quiz->title }}</h4>
    <form id="quizForm" method="POST" action="{{ route('quizzes.update', $quiz) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-bold">Quiz Title</label>
            <input type="text" name="title" class="form-control" value="{{ $quiz->title }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Description</label>
            <textarea name="description" class="form-control" rows="2" placeholder="Short quiz description">{{ $quiz->description }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Time Limit (minutes)</label>
            <input type="number" name="time_limit" class="form-control" min="1" max="120" value="{{ $quiz->time_limit }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Status</label>
            <select name="is_active" class="form-select">
                <option value="1" {{ $quiz->is_active ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$quiz->is_active ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Save Changes
            </button>
        </div>
    </form>
  </div>
</div>

@endsection
