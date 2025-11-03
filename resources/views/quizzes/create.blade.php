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

/* Elegant Preview Modal */
.modal-content {
  background: #ffffff;
  border-radius: 18px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.2);
  overflow: hidden;
}
.modal-header {
  background: linear-gradient(135deg, var(--blue), var(--red));
  color: #fff;
  font-weight: bold;
}
.modal-body {
  background: #fdfdfd;
  padding: 25px;
}
.preview-question {
  background: #faf9ff;
  border: 1px solid rgba(0,0,0,0.05);
  border-radius: 12px;
  padding: 15px;
  margin-bottom: 15px;
  display: none;
}
.preview-question.active {
  display: block;
}
.preview-question strong {
  color: var(--blue);
}
.preview-option {
  padding: 6px 10px;
  margin: 3px 0;
  border-radius: 6px;
  transition: 0.3s;
}
.preview-option.correct {
  background: rgba(40, 167, 69, 0.15);
  border-left: 4px solid #28a745;
}
.preview-option:hover {
  background: rgba(0,0,0,0.03);
}
.preview-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
}
</style>

<!-- Header -->
<section class="header">
  <h1><i class="fas fa-clipboard-question me-2"></i>Create & Publish Quiz</h1>
  <p>Design engaging quizzes for your students — instantly.</p>
</section>

<!-- Main Content -->
<div class="container py-5">
  <div class="card shadow-sm p-4">
    <h4 class="fw-bold text-primary mb-3"><i class="fas fa-plus-circle me-2"></i>New Quiz</h4>
    <form id="quizForm" method="POST" action="{{ route('quizzes.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">Quiz Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter quiz title" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Description</label>
            <textarea name="description" class="form-control" rows="2" placeholder="Short quiz description"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Time Limit (minutes)</label>
            <input type="number" name="time_limit" class="form-control" min="1" max="120" value="30" required>
        </div>
        <div id="questionsContainer"></div>

        <button type="button" class="btn btn-outline-primary mt-3" onclick="addQuestion()">
            <i class="fas fa-question-circle me-2"></i>Add Question
        </button>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane me-2"></i>Publish Quiz
            </button>
        </div>
    </form>
  </div>

  <hr class="my-5 text-muted">

  <h4 class="fw-bold text-dark mb-3"><i class="fas fa-list me-2"></i>Published Quizzes</h4>
  <div id="quizList"></div>
</div>

@endsection

@push('scripts')
<script>
let questionCount = 0;

function addQuestion() {
    questionCount++;
    const container = document.getElementById('questionsContainer');
    const questionBlock = document.createElement('div');
    questionBlock.className = 'question-block';
    questionBlock.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="fw-bold">Question ${questionCount}</h6>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.question-block').remove()">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <input type="text" name="questions[${questionCount}][question_text]" class="form-control mt-2 mb-3" placeholder="Enter question text..." required>

        <div class="mb-2">
            <label class="form-label fw-bold">Options</label>
            ${[1,2,3,4].map(i=>`
                <div class="option-input">
                    <input type="radio" name="questions[${questionCount}][correct_option]" value="${i}" required>
                    <input type="text" name="questions[${questionCount}][options][]" class="form-control" placeholder="Option ${i}" required>
                </div>`).join('')}
        </div>
    `;
    container.appendChild(questionBlock);
}
</script>
@endpush
