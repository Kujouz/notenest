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

        .student-result-card {
            border-left: 4px solid
                @if($quiz->average_score >= 80)
                    #28a745
                @elseif($quiz->average_score >= 60)
                #17a2b8 @else #dc3545 @endif;
        }

        /* Progress bars */
        .progress {
            height: 8px;
            border-radius: 4px;
            background-color: #e9ecef;
        }

        .progress-bar {
            height: 8px;
            border-radius: 4px;
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
        <h1><i class="fas fa-chart-line me-2"></i>Quiz Results</h1>
        <p>{{ $quiz->title }} - {{ $quiz->results->count() }} students have completed this quiz</p>
    </section>

    <!-- Main Content -->
    <div class="container py-5">
        <!-- Quiz Stats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <h3 class="fw-bold text-primary">{{ $quiz->results->count() }}</h3>
                    <p class="text-muted mb-0">Students Completed</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <h3 class="fw-bold text-success">{{ $quiz->average_score }}%</h3>
                    <p class="text-muted mb-0">Average Score</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <h3 class="fw-bold text-info">{{ $quiz->questions->count() }}</h3>
                    <p class="text-muted mb-0">Total Questions</p>
                </div>
            </div>
        </div>

        <!-- Individual Student Results -->
        @if($quiz->results->count() > 0)
            <div class="card shadow-sm p-4">
                <h4 class="fw-bold text-dark mb-4"><i class="fas fa-users me-2"></i>Student Results</h4>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Score</th>
                                <th>Percentage</th>
                                <th>Completed</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quiz->results as $result)
                                <tr class="student-result-card">
                                    <td>
                                        <strong>{{ $result->student->name }}</strong><br>
                                        <small>{{ $result->student->id_number }}</small>
                                    </td>
                                    <td>{{ $result->score }} / {{ $result->total_questions }}</td>
                                    <td>
                                        @php
                                            $percentage = $result->total_questions > 0 ? round(($result->score / $result->total_questions) * 100) : 0;
                                        @endphp
                                        <div class="progress mb-1">
                                            <div class="progress-bar bg-{{ $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'info' : 'danger') }}"
                                                role="progressbar" style="width: {{ $percentage }}%;"
                                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small>{{ $percentage }}%</small>
                                    </td>
                                    <td>{{ $result->completed_at->format('M d, Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary view-answers" data-bs-toggle="modal"
                                            data-bs-target="#answersModal" data-quiz-id="{{ $quiz->id }}"
                                            data-student-id="{{ $result->student_id }}"
                                            data-answers="{{ json_encode($result->answers) }}"
                                            data-questions="{{ json_encode($quiz->questions->pluck('question_text', 'id')->toArray()) }}"
                                            data-options="{{ json_encode($quiz->questions->pluck('options', 'id')->toArray()) }}"
                                            data-correct-options="{{ json_encode($quiz->questions->pluck('correct_option', 'id')->toArray()) }}">
                                            <i class="fas fa-eye"></i> View Answers
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No students have completed this quiz yet</h4>
                <p class="text-muted">Students will appear here once they take the quiz.</p>
            </div>
        @endif

        <!-- Back to Quizzes Button -->
        <div class="text-center mt-4">
            <a href="{{ route('quizzes.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Quizzes
            </a>
        </div>
    </div>

    <!-- Answers Modal -->
    <div class="modal fade" id="answersModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-file-alt me-2"></i>Student Answers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalAnswersContent">
                    <!-- Answers will be loaded here via JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-answers');
    const modalContent = document.getElementById('modalAnswersContent');

    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const quizId = this.getAttribute('data-quiz-id');
            const studentId = this.getAttribute('data-student-id');
            const answers = JSON.parse(this.getAttribute('data-answers'));
            const questions = JSON.parse(this.getAttribute('data-questions'));
            const options = JSON.parse(this.getAttribute('data-options'));
            const correctOptions = JSON.parse(this.getAttribute('data-correct-options'));

            let html = '<div class="row">';

            // Sort questions by ID to display in order
            const questionIds = Object.keys(questions).sort((a, b) => parseInt(a) - parseInt(b));

            questionIds.forEach(questionId => {
                const questionText = questions[questionId];
                const questionOptions = options[questionId];
                const correctOption = correctOptions[questionId];
                const studentAnswer = answers[questionId] || 0;
                const isCorrect = studentAnswer == correctOption;

                html += `
                    <div class="col-md-6 mb-3">
                        <div class="card ${isCorrect ? 'border-success' : 'border-danger'}">
                            <div class="card-body">
                                <h6 class="card-title">Question ${Object.keys(questions).indexOf(questionId) + 1}</h6>
                                <p class="mb-2">${questionText}</p>
                                <p><strong>Your Answer:</strong> ${String.fromCharCode(65 + studentAnswer - 1)}. ${questionOptions[studentAnswer - 1]}</p>
                                <p class="${isCorrect ? 'text-success' : 'text-danger'}">
                                    <strong>${isCorrect ? '✓ Correct' : '✗ Incorrect'}</strong><br>
                                    ${!isCorrect ? `Correct Answer: ${String.fromCharCode(65 + correctOption - 1)}. ${questionOptions[correctOption - 1]}` : ''}
                                </p>
                            </div>
                        </div>
                    </div>
                `;
            });

            html += '</div>';
            modalContent.innerHTML = html;
        });
    });
});
</script>
@endpush
