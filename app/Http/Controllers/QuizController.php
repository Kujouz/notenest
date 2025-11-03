<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QuizResult;

class QuizController extends Controller
{
    /**
     * Display the quiz builder page.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created quiz.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1|max:120',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.options' => 'required|array|size:4',
            'questions.*.options.*' => 'required|string',
            'questions.*.correct_option' => 'required|integer|min:1|max:4',
        ]);

        $quiz = Quiz::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'time_limit' => $request->time_limit,
            'is_active' => true,
        ]);

        foreach ($request->questions as $questionData) {
            Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $questionData['question_text'],
                'options' => $questionData['options'],
                'correct_option' => $questionData['correct_option'],
            ]);
        }

        return redirect()->route('quizzes.index')->with('success', 'Quiz published successfully!');
    }

    /**
     * Display all quizzes.
     */
    public function index()
    {
        // Show all active quizzes to everyone
        $quizzes = Quiz::with(['user', 'questions'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show a specific quiz.
     */
    public function show(Quiz $quiz)
    {
        return view('quizzes.show', compact('quiz'));
    }

    /**
     * Delete a quiz.
     */
    public function destroy(Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        $quiz->questions()->delete();
        $quiz->delete();

        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully!');
    }

    public function take(Quiz $quiz)
    {
        return view('quizzes.take', compact('quiz'));
    }

    public function submit(Quiz $quiz, Request $request)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|integer|min:1|max:4',
        ]);

        // Calculate score
        $score = 0;
        $totalQuestions = $quiz->questions->count();
        $studentAnswers = $request->input('answers');

        foreach ($quiz->questions as $question) {
            if ($studentAnswers[$question->id] == $question->correct_option) {
                $score++;
            }
        }

        // Save quiz result
        QuizResult::create([
            'quiz_id' => $quiz->id,
            'student_id' => auth()->id(),
            'score' => $score,
            'total_questions' => $totalQuestions,
            'answers' => $studentAnswers,
            'completed_at' => now(),
        ]);

        return redirect()->route('quizzes.results', $quiz)
            ->with([
                'score' => $score,
                'total' => $totalQuestions,
                'percentage' => round(($score / $totalQuestions) * 100)
            ]);
    }
    public function results(Quiz $quiz)
    {
        $score = session('score', 0);
        $total = session('total', 0);
        $percentage = $total > 0 ? round(($score / $total) * 100) : 0;

        return view('quizzes.results', compact('quiz', 'score', 'total', 'percentage'));
    }

    public function resultsTeacher(Quiz $quiz)
    {
    // Ensure only the teacher who created the quiz can view results
    if ($quiz->user_id !== auth()->id()) {
        abort(403, 'You can only view results for your own quizzes.');
    }

    // Load quiz with results and questions
    $quiz->load(['results.student', 'questions']);

    return view('quizzes.results-teacher', compact('quiz'));
    }

    // app/Http/Controllers/QuizController.php
public function edit(Quiz $quiz)
{
    return view('quizzes.edit', compact('quiz'));
}

public function update(Request $request, Quiz $quiz)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'time_limit' => 'required|integer|min:1|max:120',
        'is_active' => 'required|boolean',
    ]);

    $quiz->update([
        'title' => $request->title,
        'description' => $request->description,
        'time_limit' => $request->time_limit,
        'is_active' => $request->is_active,
    ]);

    return redirect()->route('quizzes.show', $quiz)->with('success', 'Quiz updated successfully!');
}
}
