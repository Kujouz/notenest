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

/* Buttons */
.btn-primary {
  background: var(--red);
  border: none;
}
.btn-primary:hover {
  background: var(--blue);
  color: #fff;
}
.btn-outline-primary:hover {
  background: var(--blue);
  color: white;
}

/* Cards */
.card,
.quiz-card,
.question-block {
  background: var(--card-bg);
  color: var(--dark);
  border-radius: 15px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  transition: 0.3s;
}

.question-block {
  border: 1px solid rgba(0,0,0,0.1);
  padding: 15px;
  margin-top: 10px;
}

/* Inputs */
.form-control {
  border: 1px solid rgba(0,0,0,0.15);
  background: #ffffff;
}
.form-control:focus {
  border-color: var(--blue);
  box-shadow: 0 0 0 0.25rem rgba(47,48,127,0.25);
}

.option-input {
  display: flex;
  align-items: center;
  margin-bottom: 6px;
}
.option-input input {
  margin-right: 10px;
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
  <h1><i class="fas fa-edit me-2"></i>Edit Question</h1>
  <p>Update question for: {{ $quiz->title }}</p>
</section>

<!-- Main Content -->
<div class="container py-5">
  <div class="card shadow-sm p-4">
    <h4 class="fw-bold text-primary mb-3"><i class="fas fa-question-circle me-2"></i>Question Details</h4>
    <form id="questionForm" method="POST" action="{{ route('questions.update', [$quiz, $question]) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-bold">Question Text</label>
            <textarea name="question_text" class="form-control" rows="3" required>{{ $question->question_text }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Options</label>
            @foreach($question->options as $index => $option)
                <div class="option-input">
                    <input type="radio" name="correct_option" value="{{ $index + 1 }}"
                           {{ $question->correct_option == ($index + 1) ? 'checked' : '' }} required>
                    <input type="text" name="options[]" class="form-control"
                           value="{{ $option }}" placeholder="Option {{ chr(65 + $index) }}" required>
                </div>
            @endforeach
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

    <!-- Delete Question Button -->
    <div class="mt-4 pt-3 border-top">
        <h6 class="text-danger">Danger Zone</h6>
        <form method="POST" action="{{ route('questions.destroy', [$quiz, $question]) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger"
                    onclick="return confirm('Are you sure you want to delete this question? This cannot be undone.')">
                <i class="fas fa-trash me-1"></i>Delete Question
            </button>
        </form>
    </div>
  </div>
</div>

@endsection
