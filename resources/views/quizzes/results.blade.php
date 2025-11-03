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

.quiz-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(0,0,0,0.15);
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
  <h1><i class="fas fa-clipboard-check me-2"></i>Quiz Results</h1>
  <p>{{ $quiz->title }}</p>
</section>

<!-- Main Content -->
<div class="container py-5">
  <div class="card shadow-sm p-4">
    <div class="text-center">
      <h2 class="fw-bold text-primary mb-3">
        <i class="fas fa-trophy me-2"></i>Your Score: {{ $score }} / {{ $total }}
      </h2>
      <div class="progress mb-4" style="height: 20px;">
        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
          {{ $percentage }}%
        </div>
      </div>

      @if($percentage >= 80)
        <div class="alert alert-success">
          <i class="fas fa-check-circle me-2"></i>Excellent! You passed with flying colors!
        </div>
      @elseif($percentage >= 60)
        <div class="alert alert-info">
          <i class="fas fa-exclamation-circle me-2"></i>Good job! You passed.
        </div>
      @else
        <div class="alert alert-danger">
          <i class="fas fa-times-circle me-2"></i>Keep practicing! You'll get there.
        </div>
      @endif

      <div class="mt-4">
        <a href="{{ route('quizzes.index') }}" class="btn btn-outline-primary">
          <i class="fas fa-arrow-left me-2"></i>Back to Quizzes
        </a>
      </div>
    </div>
  </div>
</div>

@endsection
