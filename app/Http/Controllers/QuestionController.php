<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function edit(Quiz $quiz, Question $question)
    {
        // Ensure teacher owns the quiz
        if ($quiz->user_id !== Auth::id()) {
            abort(403, 'You can only edit questions in your own quizzes.');
        }

        // Ensure question belongs to this quiz
        if ($question->quiz_id !== $quiz->id) {
            abort(403, 'This question does not belong to this quiz.');
        }

        return view('questions.edit', compact('quiz', 'question'));
    }

    public function update(Request $request, Quiz $quiz, Question $question)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        if ($question->quiz_id !== $quiz->id) {
            abort(403);
        }

        $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|size:4',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer|min:1|max:4',
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'options' => $request->options,
            'correct_option' => $request->correct_option,
        ]);

        return redirect()->route('quizzes.show', $quiz)->with('success', 'Question updated successfully!');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        if ($question->quiz_id !== $quiz->id) {
            abort(403);
        }

        $question->delete();

        return redirect()->route('quizzes.show', $quiz)->with('success', 'Question deleted successfully!');
    }

    public function store(Request $request, Quiz $quiz)
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|size:4',
            'options.*' => 'required|string',
            'correct_option' => 'required|integer|min=1|max=4',
        ]);

        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => $request->question_text,
            'options' => $request->options,
            'correct_option' => $request->correct_option,
        ]);

        return redirect()->route('quizzes.show', $quiz)->with('success', 'Question added successfully!');
    }
}
