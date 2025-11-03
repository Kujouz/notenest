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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .quiz-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .question-block {
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-top: 10px;
        }

        /* Inputs */
        .form-control {
            border: 1px solid rgba(0, 0, 0, 0.15);
            background: #ffffff;
        }

        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 0.25rem rgba(47, 48, 127, 0.25);
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
            border-top: 2px solid rgba(255, 255, 255, 0.2);
        }
    </style>

    <!-- Header -->
    <section class="header">
        <h1><i class="fas fa-clipboard-question me-2"></i>{{ $quiz->title }}</h1>
        <p>{{ $quiz->description ?? 'No description' }}</p>
    </section>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="card shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-primary">Quiz Details</h4>
                @if(auth()->user()->role === 'teacher')
                    <a href="{{ route('quizzes.edit', $quiz) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                @endif
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <p class="form-control">{{ $quiz->description ?? 'No description' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Time Limit</label>
                        <p class="form-control">{{ $quiz->time_limit }} minutes</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Created By</label>
                        <p class="form-control">{{ $quiz->user->name }} ({{ $quiz->user->email }})</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Questions</label>
                        <p class="form-control">{{ $quiz->questions->count() }} questions</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Published</label>
                        <p class="form-control">{{ $quiz->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <p class="form-control {{ $quiz->is_active ? 'text-success' : 'text-danger' }}">
                            {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="mt-4">
            <h4 class="fw-bold text-dark mb-3"><i class="fas fa-question-circle me-2"></i>Questions</h4>
            <div class="row g-3">
                @foreach($quiz->questions as $index => $question)
                    <div class="col-md-6">
                        <div class="question-block">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold">Question {{ $index + 1 }}</h6>
                                @if(auth()->user()->role === 'teacher')
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('questions.edit', [$quiz, $question]) }}" class="btn btn-sm btn-light"
                                            title="Edit Question">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('questions.destroy', [$quiz, $question]) }}"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger" title="Delete Question"
                                                onclick="return confirm('Are you sure you want to delete this question?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <p class="mt-2">{{ $question->question_text }}</p>

                            <div class="mt-3">
                                @foreach($question->options as $optionIndex => $option)
                                    <div class="option-input">
                                        <input type="radio" disabled>
                                        <span>{{ chr(65 + $optionIndex) }}. {{ $option }}</span>
                                        @if($optionIndex + 1 == $question->correct_option)
                                            <span class="badge bg-success ms-2">Correct</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Add Question Button for Teachers -->
            @if(auth()->user()->role === 'teacher')
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-outline-primary" onclick="showAddQuestionForm()">
                        <i class="fas fa-plus me-1"></i>Add Question
                    </button>
                </div>

                <!-- Add Question Form (Hidden by default) -->
                <div id="addQuestionForm" class="mt-4" style="display: none;">
                    <div class="card p-3">
                        <h5 class="fw-bold">Add New Question</h5>
                        <form method="POST" action="{{ route('questions.store', $quiz) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Question Text</label>
                                <textarea name="question_text" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Options</label>
                                <div class="option-input">
                                    <input type="radio" name="correct_option" value="1" required>
                                    <input type="text" name="options[]" class="form-control" placeholder="Option A" required>
                                </div>
                                <div class="option-input">
                                    <input type="radio" name="correct_option" value="2" required>
                                    <input type="text" name="options[]" class="form-control" placeholder="Option B" required>
                                </div>
                                <div class="option-input">
                                    <input type="radio" name="correct_option" value="3" required>
                                    <input type="text" name="options[]" class="form-control" placeholder="Option C" required>
                                </div>
                                <div class="option-input">
                                    <input type="radio" name="correct_option" value="4" required>
                                    <input type="text" name="options[]" class="form-control" placeholder="Option D" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2"
                                    onclick="hideAddQuestionForm()">Cancel</button>
                                <button type="submit" class="btn btn-primary">Add Question</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- Add JavaScript for Add Question Form -->
        @push('scripts')
            <script>
                function showAddQuestionForm() {
                    document.getElementById('addQuestionForm').style.display = 'block';
                }

                function hideAddQuestionForm() {
                    document.getElementById('addQuestionForm').style.display = 'none';
                }
            </script>
        @endpush

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end mt-4">
            @if(auth()->user()->role === 'teacher')
                <a href="{{ route('quizzes.results.teacher', $quiz) }}" class="btn btn-outline-info me-2">
                    <i class="fas fa-chart-line me-1"></i>View Results
                </a>
                <form method="POST" action="{{ route('quizzes.destroy', $quiz) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger"
                        onclick="return confirm('Are you sure you want to delete this quiz?')">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </form>
            @else
                <a href="{{ route('quizzes.take', $quiz) }}" class="btn btn-primary">
                    <i class="fas fa-play me-1"></i>Take Quiz
                </a>
            @endif
        </div>
    </div>

@endsection
