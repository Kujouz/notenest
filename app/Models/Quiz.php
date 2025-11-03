<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'time_limit', 'is_active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function results()
    {
        return $this->hasMany(QuizResult::class);
    }

    // Add this accessor for average score
    public function getAverageScoreAttribute()
    {
        if ($this->results->count() === 0) {
            return 0;
        }

        $totalPercentage = $this->results->sum(function ($result) {
            return ($result->score / $result->total_questions) * 100;
        });

        return round($totalPercentage / $this->results->count());
    }

    // Add this accessor to include question text with answers
    public function getResultsWithQuestionsAttribute()
    {
        return $this->results->map(function ($result) {
            $result->answers_with_questions = collect($this->questions)->map(function ($question) use ($result) {
                return [
                    'question_text' => $question->question_text,
                    'options' => $question->options,
                    'correct_option' => $question->correct_option,
                    'student_answer' => $result->answers[$question->id] ?? null,
                ];
            })->values()->toArray();

            return $result;
        });
    }
}
