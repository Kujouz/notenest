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

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, var(--blue), var(--red));
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            height: 45px;
            margin-right: 10px;
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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark py-3">
        <div class="container">
            <a class="navbar-brand" href="#">

            </a>
            <div class="ms-auto d-flex align-items-center gap-2">
                <a >

                </a>
                <a >

                </a>

            </div>
        </div>
    </nav>

    <!-- Header - Role Specific -->
    @if(auth()->user()->role === 'teacher')
        <section class="header">
            <h1><i class="fas fa-clipboard-question me-2"></i>Create & Publish Quiz</h1>
            <p>Design engaging quizzes for your students — instantly.</p>
        </section>
    @else
        <section class="header">
            <h1><i class="fas fa-graduation-cap me-2"></i>Available Quizzes</h1>
            <p>Test your knowledge and improve your skills!</p>
        </section>
    @endif

    <!-- Main Content -->
    <div class="container py-5">
        <!-- Teacher: Quiz Creation Form -->
        @if(auth()->user()->role === 'teacher')
            <div class="card shadow-sm p-4 mb-5">
                <h4 class="fw-bold text-primary mb-3"><i class="fas fa-plus-circle me-2"></i>New Quiz</h4>
                <form id="quizForm" method="POST" action="{{ route('quizzes.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Quiz Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter quiz title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="2"
                            placeholder="Short quiz description"></textarea>
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
        @endif

        <hr class="my-5 text-muted">

        <!-- Quiz Listing - Same for both roles -->
        <h4 class="fw-bold text-dark mb-3">
            <i class="fas fa-list me-2"></i>
            @if(auth()->user()->role === 'teacher')
                Published Quizzes
            @else
                Available Quizzes
            @endif
        </h4>

        @if($quizzes->count() > 0)
            <div class="row g-3">
                @foreach($quizzes as $quiz)
                    <div class="col-md-6">
                        <div class="quiz-card p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold">{{ $quiz->title }}</h5>
                                    <p class="text-muted">{{ $quiz->description ?? 'No description' }}</p>
                                    <p><small>{{ $quiz->questions->count() }} Questions |
                                            @if(auth()->user()->role === 'teacher')
                                                By {{ $quiz->user->name }} |
                                            @endif
                                            Published: {{ $quiz->created_at->format('M d, Y') }}</small></p>
                                </div>
                                <div>
                                    @if(auth()->user()->role === 'student')
                                        <a href="{{ route('quizzes.take', $quiz) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-play me-1"></i>Take Quiz
                                        </a>
                                    @else
                                        <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-sm btn-outline-primary me-2">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('quizzes.results.teacher', $quiz) }}"
                                            class="btn btn-sm btn-outline-info me-2">
                                            <i class="fas fa-chart-line"></i> Results
                                        </a>
                                        <form method="POST" action="{{ route('quizzes.destroy', $quiz) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this quiz?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">
                    @if(auth()->user()->role === 'teacher')
                        No quizzes published yet
                    @else
                        No quizzes available yet
                    @endif
                </h4>
                <p class="text-muted">
                    @if(auth()->user()->role === 'teacher')
                        Create your first quiz to get started!
                    @else
                        Wait for your teacher to publish quizzes.
                    @endif
                </p>
            </div>
        @endif
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
                ${[1, 2, 3, 4].map(i => `
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
