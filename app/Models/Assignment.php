<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_id', 'student_id', 'title', 'description', 'file_path',
        'file_name', 'file_type', 'file_size', 'feedback', 'grade', 'status'
    ];

    public function note()
    {
        return $this->belongsTo(Note::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getFormattedFileSizeAttribute()
    {
        $size = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $size > 1024 && $i < 3; $i++) {
            $size /= 1024;
        }
        return round($size, 2) . ' ' . $units[$i];
    }

    public function getGradePercentageAttribute()
    {
        return $this->grade !== null ? round(($this->grade / 100) * 100) : null;
    }
}
